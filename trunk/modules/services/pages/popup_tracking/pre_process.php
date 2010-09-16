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
//  Path: /modules/services/pages/popup_tracking/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = (int)$_SESSION['admin_id']; // for popups, just make sure they are logged in
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files  *********************/
require(DIR_FS_WORKING . 'shipping/language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'orders/functions/orders.php');

/**************   page specific initialization  *************************/
$close_popup = false;
$module_name = $_GET['subject'];
if (file_exists(DIR_FS_MODULES . 'services/shipping/modules/' . $module_name . '.php')) {
  require(DIR_FS_MODULES . 'services/shipping/language/' . $_SESSION['language'] . '/modules/' . $module_name . '.php');
  require(DIR_FS_MODULES . 'services/shipping/modules/'  . $module_name . '.php');
} else {
  require(DIR_FS_MY_FILES . 'custom/services/shipping/language/' . $_SESSION['language'] . '/modules/' . $module_name . '.php');
  require(DIR_FS_MY_FILES . 'custom/services/shipping/modules/'  . $module_name . '.php');
}
$subject_module = new $module_name();

$sID       = $_GET['sID'] ? (int)$_GET['sID'] : 0;
$carrier   = ($module_name) ? $module_name : '';
$ship_date = date('Y-m-d');
$action    = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/services/popup_tracking/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
	$sql_data_array = array(
		'carrier'      => db_prepare_input($_POST['carrier']),
		'ref_id'       => db_prepare_input($_POST['ref_id']),
		'method'       => db_prepare_input($_POST['method']),
		'ship_date'    => gen_db_date_short($_POST['ship_date']),
		'deliver_date' => gen_db_date_short($_POST['deliver_date']),
		'tracking_id'  => db_prepare_input($_POST['tracking_id']),
		'cost'         => $currencies->clean_value($_POST['cost']),
	);
	if (!$sID) { // it's a new entry
	  $result = $db->Execute("select next_shipment_num from " . TABLE_CURRENT_STATUS);
	  $sql_data_array['shipment_id'] = $result->fields['next_shipment_num'];
	  db_perform(TABLE_SHIPPING_LOG, $sql_data_array, 'insert');
	  $db->Execute("update " . TABLE_CURRENT_STATUS . " set next_shipment_num = next_shipment_num + 1");
      gen_add_audit_log(SHIPPING_SHIPMENT_DETAILS . ' - ' . TEXT_INSERT, $sID);
	} else { // update
	  db_perform(TABLE_SHIPPING_LOG, $sql_data_array, 'update', "id = " . $sID);
      gen_add_audit_log(SHIPPING_SHIPMENT_DETAILS . ' - ' . TEXT_UPDATE, $sID);
	}
	$close_popup = true;
    break;
  default:
}

/*****************   prepare to display templates  *************************/
$shipping_methods = ord_get_shipping_methods();

$sql = "select id, shipment_id, carrier, ref_id, method, ship_date, deliver_date, tracking_id, cost 
	from " . TABLE_SHIPPING_LOG . " where id = " . (int)$sID;
$result = $db->Execute($sql);
if ($result->RecordCount() > 0) {
	$cInfo = new objectInfo($result->fields);
} else {
	$cInfo = new objectInfo(array('shipment_id' => $sID, 'carrier' => $carrier, 'ship_date' => $ship_date));
}

$include_header   = false;
$include_footer   = false;
$include_tabs     = false;
$include_calendar = true;
$include_template = 'template_main.php';
define('PAGE_TITLE', $subject_module->title);

?>