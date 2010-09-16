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
//  Path: /modules/inventory/pages/popup_prices/pre_process.php
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
$sku   = $_GET['sku'];
$rowId = $_GET['rowId'];

// retrieve some inventory item details
$inventory_details = $db->Execute("select id, sku, description_short, item_cost, full_price, item_weight 
	 from " . TABLE_INVENTORY . " where sku = '" . $sku . "'");
$id = $inventory_details->fields['id'];

if ($id) { // then the sku was valid
	// get item information, cost and full price
	$sql = "select id, sheet_name, revision, default_sheet, default_levels from " . TABLE_PRICE_SHEETS . " 
		where inactive = '0' and 
		(expiration_date is null or expiration_date = '0000-00-00' or expiration_date >= '" . date('Y-m-d', time()) . "') 
		order by sheet_name";
	$price_sheets = $db->Execute($sql);
	// retrieve special pricing for this inventory item
	$result = $db->Execute("select price_sheet_id, price_levels 
		from " . TABLE_INVENTORY_SPECIAL_PRICES . " where inventory_id = " . $id);
	$special_prices = array();
	while (!$result->EOF) {
		$special_prices[$result->fields['price_sheet_id']] = $result->fields['price_levels'];
		$result->MoveNext();
	}
}

/***************   Act on the action request  *************************/
$action = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/inventory/popup_prics/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

switch ($action) {
  default:
}

/*****************   prepare to display templates  *************************/
// some preliminary information
$include_header   = false;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = false;
$include_template = 'template_main.php';
define('PAGE_TITLE', INV_POPUP_PRICES_WINDOW_TITLE);
?>