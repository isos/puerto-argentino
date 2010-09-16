<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2008, 2009, 2010 PhreeSoft, LLC                   |
// | http://www.PhreeSoft.com                                        |
// +-----------------------------------------------------------------+
// | This program is free software: you can redistribute it and/or   |
// | modify it under the terms of the GNU General Public License as  |
// | published by the Free Software Foundation, either version 3 of  |
// | the License, or any later version.                              |
// |                                                                 |
// | This program is distributed in the hope that it will be useful, |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of  |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the   |
// | GNU General Public License for more details.                    |
// |                                                                 |
// | The license that is bundled with this package is located in the |
// | file: /doc/manual/ch01-Introduction/license.html.               |
// | If not, see http://www.gnu.org/licenses/                        |
// +-----------------------------------------------------------------+
//  Path: /modules/inventory/pages/bulk_prices/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_PRICE_SHEET_MANAGER];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
//require(DIR_FS_WORKING . 'pricesheets/language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'inventory/language/' . $_SESSION['language'] . '/language.php');

/**************   page specific initialization  *************************/
$search_text = ($_POST['search_text']) ? db_input(db_prepare_input($_POST['search_text'])) : db_input(db_prepare_input($_GET['search_text']));
if ($search_text == TEXT_SEARCH) $search_text = '';
$action = isset($_GET['action']) ? $_GET['action'] : $_POST['todo'];
if (!$action && $search_text <> '') $action = 'search'; // if enter key pressed and search not blank

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/inventory/bulk_prices/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
	$j = 1;
	while (true) {
		if (isset($_POST['id_' . $j])) {
			$id = db_prepare_input($_POST['id_' . $j]);
			$lead_time = db_prepare_input($_POST['lead_' . $j]);
			$item_cost = $currencies->clean_value($_POST['cost_' . $j]);
			$full_price = $currencies->clean_value($_POST['sell_' . $j]);
			$db->Execute("update " . TABLE_INVENTORY . " 
				set lead_time = '" . $currencies->clean_value($lead_time) . "', 
				item_cost = '" . $currencies->clean_value($item_cost) . "', 
				full_price = '" . $currencies->clean_value($full_price) . "' 
				where id = " . $id);
		} else {
			break;
		}
		$j++;
	}
	gen_add_audit_log(PRICE_SHEETS_LOG_BULK . TEXT_UPDATE);
	break;
  case 'go_first':    $_GET['page'] = 1;     break;
  case 'go_previous': $_GET['page']--;       break;
  case 'go_next':     $_GET['page']++;       break;
  case 'go_last':     $_GET['page'] = 99999; break;
  case 'search':
  case 'search_reset':
  case 'go_page':
  default:
}

/*****************   prepare to display templates  *************************/


$include_header   = true;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = false;

$heading_array = array(
  'sku'               => TEXT_SKU,
  'inactive'          => TEXT_INACTIVE,
  'description_short' => TEXT_DESCRIPTION,
  'lead_time'         => INV_HEADING_LEAD_TIME,
  'item_cost'         => INV_ENTRY_INV_ITEM_COST . (ENABLE_MULTI_CURRENCY ? ' (' . DEFAULT_CURRENCY . ')' : ''),
  'full_price'        => INV_ENTRY_FULL_PRICE . (ENABLE_MULTI_CURRENCY ? ' (' . DEFAULT_CURRENCY . ')' : ''));
$result      = html_heading_bar($heading_array, $_GET['list_order']);
$list_header = $result['html_code'];
$disp_order  = $result['disp_order'];

// build the list for the page selected
if (isset($search_text) && gen_not_null($search_text)) {
  $search_fields = array('sku', 'description_short', 'description_sales', 'description_purchase');
  // hook for inserting new search fields to the query criteria.
  if (is_array($extra_search_fields)) $search_fields = array_merge($search_fields, $extra_search_fields);
  $search = ' where ' . implode(' like \'%' . $search_text . '%\' or ', $search_fields) . ' like \'%' . $search_text . '%\'';
} else {
  $search = '';
}

$field_list = array('id', 'sku', 'inactive', 'description_short', 'lead_time', 'item_cost', 'full_price');

// hook to add new fields to the query return results
if (is_array($extra_query_list_fields) > 0) $field_list = array_merge($field_list, $extra_query_list_fields);

$query_raw    = "select " . implode(', ', $field_list)  . " from " . TABLE_INVENTORY . $search . " order by $disp_order";
$query_split  = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
$query_result = $db->Execute($query_raw);

$include_template = 'template_main.php';
define('PAGE_TITLE', INV_BULK_SKU_ENTRY_TITLE);

?>