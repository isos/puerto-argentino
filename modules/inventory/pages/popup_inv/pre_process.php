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
//  Path: /modules/inventory/pages/popup_inv/pre_process.php
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
$account_type = isset($_GET['type'])    ? $_GET['type']    : 'c';	// current types are c (customer) and v (vendor)
$rowID        = isset($_GET['rowID'])   ? $_GET['rowID']   : 0;
$store_id     = isset($_GET['storeID']) ? $_GET['storeID'] : 0;
$contactID    = isset($_GET['cID'])     ? $_GET['cID']     : 0;
$assembly     = isset($_GET['asy'])     ? true             : false;
// load the filters
$f0           = isset($_POST['f0']) ? $_POST['f0'] : $_GET['f0']; // show inactive checkbox
$f1           = isset($_POST['f1']) ? $_POST['f1'] : $_GET['f1']; // inventory_type dropdown
$f2           = isset($_POST['f2']) ? $_POST['f2'] : $_GET['f2']; // limit to preferred_vendor checkbox
// save the filters for page jumps
$_GET['f0'] = $f0;
$_GET['f1'] = $f1;
$_GET['f2'] = $f2;

$search_text  = ($_POST['search_text']) ? db_input(db_prepare_input($_POST['search_text'])) : db_input(db_prepare_input($_GET['search_text']));
if ($search_text == TEXT_SEARCH) $search_text = '';
$action       = isset($_GET['action']) ? $_GET['action'] : $_POST['todo'];
if (!$action && $search_text <> '') $action = 'search'; // if enter key pressed and search not blank

switch ($account_type) {
  default:
  case 'c': $terms_type = 'AR'; break;
  case 'v': $terms_type = 'AP';
}

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/inventory/popup_inv/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
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
// build the type filter list
$type_select_list = array(
  array('id' => '0',   'text' => TEXT_ALL),
  array('id' => 'cog', 'text' => TEXT_INV_MANAGED),
  array('id' => 'si',  'text' => INV_TYPES_SI),
  array('id' => 'sr',  'text' => INV_TYPES_SR),
  array('id' => 'ms',  'text' => INV_TYPES_MS),
  array('id' => 'as',  'text' => INV_TYPES_AS),
  array('id' => 'sa',  'text' => INV_TYPES_SA),
  array('id' => 'ns',  'text' => INV_TYPES_NS),
  array('id' => 'lb',  'text' => INV_TYPES_LB),
  array('id' => 'sv',  'text' => INV_TYPES_SV),
  array('id' => 'sf',  'text' => INV_TYPES_SF),
  array('id' => 'ci',  'text' => INV_TYPES_CI),
  array('id' => 'ai',  'text' => INV_TYPES_AI),
  array('id' => 'ds',  'text' => INV_TYPES_DS),
);

// build the list header
$heading_array = array(
  'sku'               => TEXT_SKU,
  'description_short' => TEXT_DESCRIPTION,
  'full_price'        => ($account_type == 'v') ? INV_ENTRY_INV_ITEM_COST : INV_ENTRY_FULL_PRICE,
  'quantity_on_hand'  => INV_HEADING_QTY_ON_HAND,
  'quantity_on_order' => INV_HEADING_QTY_ON_ORDER,
);
$extras      = (ENABLE_MULTI_BRANCH) ? array(TEXT_QTY_THIS_STORE) : array();
$result      = html_heading_bar($heading_array, $_GET['list_order'], $extras);
$list_header = $result['html_code'];
$disp_order  = $result['disp_order'];

// build the list for the page selected
$criteria = array();
if (isset($search_text) && gen_not_null($search_text)) {
  $search_fields = array('sku', 'description_short', 'description_purchase');
  // hook for inserting new search fields to the query criteria.
  if (is_array($extra_search_fields)) $search_fields = array_merge($search_fields, $extra_search_fields);
  $criteria[] = '(' . implode(' like \'%' . $search_text . '%\' or ', $search_fields) . ' like \'%' . $search_text . '%\')';
}
if (!$f0) $criteria[] = "inactive = '0'"; // inactive flag
if ($f1) { // sort by inventory type
  switch ($f1) {
    case 'cog': 
	  $cog_types = explode(',',COG_ITEM_TYPES);
	  $criteria[] = "inventory_type in ('" . implode("','", $cog_types) . "')"; break;
	default:    $criteria[] = "inventory_type = '$f1'";                     break;
  }
}
if ($f2 && $contactID) $criteria[] = "vendor_id = " . $contactID; // limit to preferred vendor flag
// build search filter string
$search = (sizeof($criteria) > 0) ? (' where ' . implode(' and ', $criteria)) : '';

$field_list = array('id', 'sku', 'inactive', 'inventory_type', 'quantity_on_hand', 'quantity_on_order', 
  'description_short', 'full_price', 'item_cost');

// hook to add new fields to the query return results
if (is_array($extra_query_list_fields) > 0) $field_list = array_merge($field_list, $extra_query_list_fields);

$query_raw = "select " . implode(', ', $field_list)  . " from " . TABLE_INVENTORY . $search . " order by $disp_order";

$query_split  = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
$query_result = $db->Execute($query_raw);

// check for auto close (if auto fill is turned on and only one result is found, the data will already be there)
$auto_close = (INVENTORY_AUTO_FILL && $query_result->RecordCount() == 1 && $_GET['page'] == 1) ? true : false;
$auto_close = false; // disable until all modules that use this function are ajax compliant

$include_header   = false;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = false;
$include_template = 'template_main.php';
define('PAGE_TITLE', INV_POPUP_WINDOW_TITLE);

?>