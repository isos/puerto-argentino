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
//  Path: /modules/inventory/pages/revaluation/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_PRICE_SHEET_MANAGER];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');

/**************   page specific initialization  *************************/
$action = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/inventory/revaluation/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
	$j = 1;
	while (true) {
	  if (!isset($_POST['id_' . $j])) break;
/*
			$id = db_prepare_input($_POST['id_' . $j]);
			$lead_time = db_prepare_input($_POST['lead_' . $j]);
			$item_cost = $currencies->clean_value($_POST['cost_' . $j]);
			$full_price = $currencies->clean_value($_POST['sell_' . $j]);
			$db->Execute("update " . TABLE_INVENTORY . " 
				set lead_time = '" . $currencies->clean_value($lead_time) . "', 
				item_cost = '" . $currencies->clean_value($item_cost) . "', 
				full_price = '" . $currencies->clean_value($full_price) . "' 
				where id = " . $id);
*/
	  $j++;
	}
	gen_add_audit_log(INVENTORY_REVALUATION);
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
$heading_array = array(
  'h.sku'               => TEXT_SKU,
  'i.inactive'          => TEXT_INACTIVE,
  'i.description_short' => TEXT_DESCRIPTION,
  'h.remaining'         => INV_TEXT_REMAINING,
  'h.unit_cost'         => INV_TEXT_UNIT_COST,
);
$result = html_heading_bar($heading_array, $_GET['list_order'], array(INV_TEXT_CURRENT_VALUE, INV_TEXT_NEW_VALUE));
$list_header = $result['html_code'];
$disp_order = $result['disp_order'];

// build the list for the page selected
$search_text = ($_GET['search_text'] == TEXT_SEARCH) ? '' : db_input(db_prepare_input($_GET['search_text']));
if (isset($search_text) && gen_not_null($search_text)) {
  $search_fields = array('i.description_short', 'h.sku');
  // hook for inserting new search fields to the query criteria.
  if (is_array($extra_search_fields)) $search_fields = array_merge($search_fields, $extra_search_fields);
  $search = ' and (' . implode(' like \'%' . $search_text . '%\' or ', $search_fields) . ' like \'%' . $search_text . '%\')';
} else {
  $search = '';
}

$field_list = array('h.id', 'h.sku', 'h.remaining', 'h.unit_cost', 'i.inactive', 'i.description_short');

// hook to add new fields to the query return results
if (is_array($extra_query_list_fields) > 0) $field_list = array_merge($field_list, $extra_query_list_fields);

$query_raw = "select " . implode(', ', $field_list) . " 
	from " . TABLE_INVENTORY_HISTORY . " h inner join " . TABLE_INVENTORY . " i on h.sku = i.sku 
	where h.remaining <> 0 " . $search . "  order by $disp_order";

$query_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
$query_result = $db->Execute($query_raw);

$include_header   = true;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = false;
$include_template = 'template_main.php';
define('PAGE_TITLE', TEXT_INVENTORY_REVALUATION);

?>