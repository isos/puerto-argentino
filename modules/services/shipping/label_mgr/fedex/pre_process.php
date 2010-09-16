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
//  Path: /modules/services/shipping/label_mgr/fedex/pre_process.php
//

$shipping_module = 'fedex';

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'shipping/language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING . 'shipping/language/' . $_SESSION['language'] . '/modules/' . $shipping_module . '.php');
require(DIR_FS_WORKING . 'shipping/functions/shipping.php');
require(DIR_FS_WORKING . 'shipping/classes/shipping.php');
require(DIR_FS_WORKING . 'shipping/modules/' . $shipping_module . '.php');

/**************   page specific initialization  *************************/
$error = false;
$sInfo = new shipment();	// load defaults

$action = isset($_GET['action']) ? $_GET['action'] : $_POST['todo'];

/***************   Act on the action request   *************************/
switch ($action) {
  case 'label':
	// overwrite the defaults with data from the form
	reset($_POST);
	while (list($key, $value) = each($_POST)) $sInfo->$key = db_prepare_input($value);
	// generate ISO2 codes for countries (needed by FedEx and others)
	$sInfo->ship_country_code = gen_get_country_iso_2_from_3($sInfo->ship_country_code);
	$sInfo->terminal_date     = date('Y-m-d', strtotime($sInfo->terminal_date));
	// read checkboxes
	$sInfo->residential_address   = isset($_POST['residential_address'])   ? '1' : '0';
	$sInfo->additional_handling   = isset($_POST['additional_handling'])   ? '1' : '0';
	$sInfo->delivery_confirmation = isset($_POST['delivery_confirmation']) ? '1' : '0';
	$sInfo->saturday_delivery     = isset($_POST['saturday_delivery'])     ? '1' : '0';
	$sInfo->cod                   = isset($_POST['cod'])                   ? '1' : '0';
	$sInfo->return_service  = isset($_POST['return_service'])  ? '1' : '0';
	$sInfo->email_rcp_ship  = isset($_POST['email_rcp_ship'])  ? '1' : '0';
	$sInfo->email_rcp_excp  = isset($_POST['email_rcp_excp'])  ? '1' : '0';
	$sInfo->email_rcp_dlvr  = isset($_POST['email_rcp_dlvr'])  ? '1' : '0';
	$sInfo->email_sndr_ship = isset($_POST['email_sndr_ship']) ? '1' : '0';
	$sInfo->email_sndr_excp = isset($_POST['email_sndr_excp']) ? '1' : '0';
	$sInfo->email_sndr_dlvr = isset($_POST['email_sndr_dlvr']) ? '1' : '0';
	// load package information
	$i = 0;
	$sInfo->package = array();
	while(true) {
		$i++;		
		if (!isset($_POST['qty_' . $i])) break;
		// error check
		if (!$_POST['qty_' . $i]) continue; // skip if quantity is 0 or blank
		if (!$_POST['wt_' . $i])  continue;	// skip if weight is 0 or blank
		if (!$_POST['len_' . $i]) $_POST['len_' . $i] = SHIPPING_DEFAULT_LENGTH;
		if (!$_POST['wid_' . $i]) $_POST['wid_' . $i] = SHIPPING_DEFAULT_WIDTH;
		if (!$_POST['hgt_' . $i]) $_POST['hgt_' . $i] = SHIPPING_DEFAULT_HEIGHT;
		for ($j = 0; $j < $_POST['qty_' . $i]; $j++) {
			$sInfo->package[] = array(
				'weight' => $_POST['wt_' . $i],
				'length' => $_POST['len_' . $i],
				'width'  => $_POST['wid_' . $i],
				'height' => $_POST['hgt_' . $i],
				'value'  => $_POST['ins_' . $i]);
		}
	}
	if (count($sInfo->package) > 0) {
		$shipment = new fedex();
		$result = $shipment->retrieveLabel($sInfo);
		if (!$result) $error = true;
	}

	if (!$error) {
		$temp = $db->Execute("select next_shipment_num from " . TABLE_CURRENT_STATUS);
		$shipment_num = $temp->fields['next_shipment_num'];
		$labels_array = array();
		foreach ($result as $shipment) {
			$sql_array = array(
				'ref_id'       => $sInfo->purchase_invoice_id,
				'shipment_id'  => $shipment_num,
				'carrier'      => $shipping_module,
				'method'       => $sInfo->ship_method,
				'ship_date'    => $sInfo->terminal_date,
				'deliver_date' => $shipment['delivery_date'],
				'tracking_id'  => $shipment['tracking'],
				'cost'         => $shipment['net_cost']);
			db_perform(TABLE_SHIPPING_LOG, $sql_array, 'insert');
			$labels_array[] = $shipment['tracking'];
		}
		$db->Execute("update " . TABLE_CURRENT_STATUS . " set next_shipment_num = next_shipment_num + 1");
		gen_add_audit_log(SHIPPING_LOG_FEDEX_LABEL_PRINTED, $shipment_num . '-' . $sInfo->purchase_invoice_id);
		// load the window to print the label
		$tracking_list = implode(':',$labels_array);
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('module', 'carrier', 'labels', 'date')) . 'module=popup_label_viewer&carrier=' . $shipping_module . '&date=' . $sInfo->terminal_date . '&labels=' . $tracking_list, 'SSL'));
	} else {
		$messageStack->add(SHIPPING_FEDEX_NO_PACKAGES,'error');
		$sInfo->ship_country_code = gen_get_country_iso_3_from_2($sInfo->ship_country_code);
	}
	break;

  case 'delete':
	$shipment_id = db_prepare_input($_GET['sID']);
	$result = $db->Execute("select method, ship_date from " . TABLE_SHIPPING_LOG . " where shipment_id = " . (int)$shipment_id);
	$ship_method = $result->fields['method'];
	if ($result->RecordCount() == 0 || !$ship_method) {
		$messageStack->add(SHIPPING_FEDEX_DELETE_ERROR,'error');
		$error = true;
		break;
	}
	if ($result->fields['ship_date'] < date('Y-m-d', time())) { // only allow delete if shipped today or in future
		$messageStack->add(SHIPPING_FEDEX_CANNOT_DELETE,'error');
		$error = true;
		break;
	}
	$shipment = new fedex();
	if ($shipment->deleteLabel($ship_method, $shipment_id)) {
		$db->Execute("delete from " . TABLE_SHIPPING_LOG . " where shipment_id = " . $shipment_id);
		gen_add_audit_log(SHIPPING_FEDEX_LABEL_DELETED, $shipment_id);
		$messageStack->convert_add_to_session(); // save any messages for reload
	} else {
		$error = true;
	}
	break;

  case 'close':
    $date = ($_GET['date']) ? $_GET['date'] : date('Y-m-d', time());
	$shipment = new fedex();
	$shipment->close_date = ($_POST['search_date']) ? gen_db_date_short($_POST['search_date']) : date('Y-m-d', time());
	$shipment->closeFedEx($date);
	gen_add_audit_log(SHIPPING_FEDEX_END_OF_DAY, $tracking_id);
	break;

  case 'report':
    $date = ($_GET['date']) ? $_GET['date'] : date('Y-m-d');
	break;

  default:
	$oID = db_prepare_input($_GET['oID']);
	$sql = "select shipper_code, ship_primary_name, ship_contact, ship_address1, ship_address2, 
		ship_city_town, ship_state_province, ship_postal_code, ship_country_code, ship_telephone1, 
		ship_email, purchase_invoice_id, purch_order_id, total_amount  
		from " . TABLE_JOURNAL_MAIN . " where id = " . (int)$oID;
	$result = $db->Execute($sql);
	if (is_array($result->fields)) {
	  while (list($key, $value) = each($result->fields)) $sInfo->$key = $value;
	  $temp = explode(':', $result->fields['shipper_code']);
	  $sInfo->ship_method = $temp[1];
	}
}

/*****************   prepare to display templates  *************************/
$currency_array = gen_get_currency_array();
// translate shipping terms in the carriers language, style
$shipping_methods = array();
foreach ($shipping_defaults['service_levels'] as $key => $value) {
	if (defined($shipping_module . '_' . $key)) {
		$shipping_methods[$key] = constant($shipping_module . '_' . $key);
	}
}

$include_header   = false;
$include_footer   = false;
$include_tabs     = false;
$include_calendar = true;
$include_template = 'template_main.php';
define('PAGE_TITLE', SHIPPING_POPUP_WINDOW_TITLE);

?>