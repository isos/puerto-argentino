<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2009 PhreeSoft, LLC                               |
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
//  Path: /modules/rma/pages/popup_assets/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = (int)$_SESSION['admin_id']; // for popups, just make sure they are logged in
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING . 'functions/inventory.php');

/**************   page specific initialization  *************************/
// Set the types of inventory that we track cost of goods sold
$inv_cogs_calculated_types = array('si', 'sr', 'ms', 'mi', 'as');

$account_type = (isset($_GET['type']) ? $_GET['type'] : 'c');	// current types are c (customer) and v (vendor)
$rowID = (isset($_GET['rowID']) ? $_GET['rowID'] : 0);
$form_name = $_GET['form'];
if (!$form_name) die ('The $_GET parameter \'form\' is required'); 

switch ($account_type) {
	default:
	case 'c': $terms_type = 'AR'; break;
	case 'v': $terms_type = 'AP';
}

$search_text = ($_POST['search_text']) ? db_input(db_prepare_input($_POST['search_text'])) : db_input(db_prepare_input($_GET['search_text']));
if ($search_text == TEXT_SEARCH) $search_text = '';
$action = isset($_GET['action']) ? $_GET['action'] : $_POST['todo'];
if (!$action && $search_text <> '') $action = 'search'; // if enter key pressed and search not blank

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/inventory/popup_inv/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'go_first':     $_GET['page'] = 1;         break;
  case 'go_previous':  $_GET['page']--;           break;
  case 'go_next':      $_GET['page']++;           break;
  case 'go_last':      $_GET['page'] = 99999;     break;
  case 'search':
  case 'search_reset':
  case 'go_page':
  default:
}

/*****************   prepare to display templates  *************************/
// build the list header
$heading_array = array(
	'sku' => TEXT_SKU,
	'description_short' => TEXT_ACCT_DESCRIPTION,
	'quantity_on_hand' => INV_HEADING_QTY_ON_HAND,
	'quantity_on_order' => INV_HEADING_QTY_ON_ORDER);
$result = html_heading_bar($heading_array, $_GET['list_order'], array());
$list_header = $result['html_code'];
$disp_order = $result['disp_order'];

// build the list for the page selected
if (isset($search_text) && gen_not_null($search_text)) {
  $search_fields = array('sku', 'description_short', 'description_purchase');
  // hook for inserting new search fields to the query criteria.
  if (is_array($extra_search_fields)) $search_fields = array_merge($search_fields, $extra_search_fields);
  $search = ' where ' . implode(' like \'%' . $search_text . '%\' or ', $search_fields) . ' like \'%' . $search_text . '%\'';
} else {
  $search = '';
}

// for assemblies, restrict list to just inventory items that are categorized as assemblies
if ($form_name == 'inv_assy') $search .= ($search) ? " and inventory_type = 'as'" :" where inventory_type = 'as'";

$field_list = array('id', 'sku', 'inactive', 'inventory_type', 'description_short', 'description_purchase',
		'quantity_on_hand', 'quantity_on_order', 'full_price', 'item_taxable', 'item_cost', 'item_weight',
		'account_sales_income', 'account_inventory_wage', 'lead_time', 'account_cost_of_sales');

// hook to add new fields to the query return results
if (is_array($extra_query_list_fields) > 0) $field_list = array_merge($field_list, $extra_query_list_fields);

$query_raw = "select " . implode(', ', $field_list)  . " from " . TABLE_INVENTORY . $search . " order by $disp_order";

$query_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
$query_result = $db->Execute($query_raw);

$include_header = false; // include header flag
$include_footer = true; // include footer flag
$include_tabs = false;
$include_calendar = false;

$include_template = 'template_main.php'; // include display template (required)
define('PAGE_TITLE', INV_POPUP_WINDOW_TITLE);



?>