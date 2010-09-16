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
//  Path: /modules/inventory/pages/popup_price_mgr/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = (int)$_SESSION['admin_id']; // for popups, just make sure they are logged in
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');

/**************   page specific initialization  *************************/
$id     = (int)$_GET['iID'];
$action = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/inventory/popup_price_mgr/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
    case 'save':
	if ($_SESSION['admin_security'][SECURITY_ID_PRICE_SHEET_MANAGER] < 2) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$tab_id = 1;
	while (true) {
		if (!isset($_POST['id_' . $tab_id])) break;
		$sheet_id = (int)$_POST['id_' . $tab_id];
		$default_checked = isset($_POST['def_' . $tab_id]) ? true : false;
		if ($default_checked) {
			$db->Execute("delete from " . TABLE_INVENTORY_SPECIAL_PRICES . " 
				where inventory_id = " . $id . " and price_sheet_id = " . $sheet_id);
		} else {
			$encoded_prices = array();
			for ($i=0, $j=1; $i < MAX_NUM_PRICE_LEVELS; $i++, $j++) {
				$level_data  =       $currencies->clean_value($_POST['price_'   . $tab_id . '_' . $j]);
				$level_data .= ':' . db_prepare_input($_POST['qty_'     . $tab_id . '_' . $j]);
				$level_data .= ':' . db_prepare_input($_POST['src_'     . $tab_id . '_' . $j]);
				$level_data .= ':' . db_prepare_input($_POST['adj_'     . $tab_id . '_' . $j]);
				$level_data .= ':' . $currencies->clean_value($_POST['adj_val_' . $tab_id . '_' . $j]);
				$level_data .= ':' . db_prepare_input($_POST['rnd_'     . $tab_id . '_' . $j]);
				$level_data .= ':' . $currencies->clean_value($_POST['rnd_val_' . $tab_id . '_' . $j]);
				$encoded_prices[] = $level_data;
			}
			$price_levels = implode(';', $encoded_prices);
			$result = $db->Execute("select id from " . TABLE_INVENTORY_SPECIAL_PRICES . " 
				where inventory_id = " . $id . " and price_sheet_id = " . $sheet_id);
			if ($result->RecordCount() == 0) {
				$db->Execute("insert into " . TABLE_INVENTORY_SPECIAL_PRICES . " 
					set inventory_id = " . $id . ", price_sheet_id = " . $sheet_id . ", price_levels = '" . $price_levels . "'");
			} else {
				$db->Execute("update " . TABLE_INVENTORY_SPECIAL_PRICES . " 
					set price_levels = '" . $price_levels . "' 
					where inventory_id = " . $id . " and price_sheet_id = " . $sheet_id);
			}
		}
		$tab_id++;
	}
	gen_add_audit_log(INV_LOG_PRICE_MGR . TEXT_UPDATE, $inventory_details->fields['sku'] . ' - ' . $inventory_details->fields['description_short']);
	break;
  default:
}

/*****************   prepare to display templates  *************************/
// some preliminary information
$full_price = $currencies->clean_value($_GET['price']);
$item_cost  = $currencies->clean_value($_GET['cost']);

$sql = "select id, sheet_name, revision, default_sheet, default_levels from " . TABLE_PRICE_SHEETS . " 
	where inactive = '0' and 
	(expiration_date is null or expiration_date = '0000-00-00' or expiration_date >= '" . date('Y-m-d', time()) . "') 
	order by sheet_name";
$price_sheets = $db->Execute($sql);

// retrieve some item details
$inventory_details = $db->Execute("select sku, description_short, quantity_on_hand, quantity_on_order,
	quantity_on_sales_order from " . TABLE_INVENTORY . " where id = " . $id);

// retrieve special pricing for this inventory item
$result = $db->Execute("select price_sheet_id, price_levels 
	from " . TABLE_INVENTORY_SPECIAL_PRICES . " where inventory_id = " . $id);
$special_prices = array();
while (!$result->EOF) {
	$special_prices[$result->fields['price_sheet_id']] = $result->fields['price_levels'];
	$result->MoveNext();
}

$include_header   = false;
$include_footer   = false;
$include_tabs     = true;
$include_calendar = false;
$include_template = 'template_main.php';
define('PAGE_TITLE', INV_POPUP_PRICE_MGR_WINDOW_TITLE);
?>