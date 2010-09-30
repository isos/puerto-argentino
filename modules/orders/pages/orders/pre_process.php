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
//  Path: /modules/orders/pages/orders/pre_process.php
//

/**************   Check user security   *****************************/
define('JOURNAL_ID',$_GET['jID']);
switch (JOURNAL_ID) {
  case  3: $security_level = $_SESSION['admin_security'][SECURITY_ID_PURCHASE_QUOTE];     break;
  case  4: $security_level = $_SESSION['admin_security'][SECURITY_ID_PURCHASE_ORDER];     break;
  case  6: $security_level = $_SESSION['admin_security'][SECURITY_ID_PURCHASE_INVENTORY]; break;
  case  7: $security_level = $_SESSION['admin_security'][SECURITY_ID_PURCHASE_CREDIT];    break;
  case  9: $security_level = $_SESSION['admin_security'][SECURITY_ID_SALES_QUOTE];        break;
  case 10: $security_level = $_SESSION['admin_security'][SECURITY_ID_SALES_ORDER];        break;
  case 12: $security_level = $_SESSION['admin_security'][SECURITY_ID_SALES_INVOICE];      break;
  case 13: $security_level = $_SESSION['admin_security'][SECURITY_ID_SALES_CREDIT];       break;
  case 19: $security_level = $_SESSION['admin_security'][SECURITY_ID_POINT_OF_SALE];      break;
  case 21: $security_level = $_SESSION['admin_security'][SECURITY_ID_PURCHASE_INVENTORY]; break;
  default:
	die('No valid journal id found (filename: modules/orders.php), Journal ID needs to be passed to this script to identify the action required.');
}

if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' .                   $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'accounts/language/' .          $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'banking/language/' .           $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'gen_ledger/language/' .        $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'services/shipping/language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING . 'classes/orders.php');
//require(DIR_FS_WORKING . 'classes/payment.php');
require(DIR_FS_WORKING . 'functions/orders.php');

/**************   page specific initialization  *************************/
switch (JOURNAL_ID) {
  case 3:		// Vendor Quote Journal
	define('ORD_ACCT_ID',GEN_VENDOR_ID);
	define('GL_TYPE','poo');				// code to use for journal rows
	define('DEF_INV_GL_ACCT',AP_DEFAULT_INVENTORY_ACCOUNT);	// default account to use for item rows
	define('DEF_GL_ACCT',$_SESSION['admin_prefs']['def_ap_acct'] ? $_SESSION['admin_prefs']['def_ap_acct'] : AP_DEFAULT_PURCHASE_ACCOUNT);
	define('DEF_GL_ACCT_TITLE',ORD_AP_ACCOUNT);
	$item_col_1_enable = true;				// allow/disallow entry of item columns
	$item_col_2_enable = false;
	define('POPUP_FORM_TYPE','ap:quot');	// form type to use for printing
	$account_type = 'v';					// choices are v - vendor or c - customer
	break;
  case 4:		// Purchase Order Journal
	define('ORD_ACCT_ID',GEN_VENDOR_ID);
	define('GL_TYPE','poo');				// code to use for journal rows
	define('DEF_INV_GL_ACCT',AP_DEFAULT_INVENTORY_ACCOUNT);	// default account to use for item rows
	define('DEF_GL_ACCT',$_SESSION['admin_prefs']['def_ap_acct'] ? $_SESSION['admin_prefs']['def_ap_acct'] : AP_DEFAULT_PURCHASE_ACCOUNT);
	define('DEF_GL_ACCT_TITLE',ORD_AP_ACCOUNT);
	$item_col_1_enable = true;				// allow/disallow entry of item columns
	$item_col_2_enable = false;
	define('POPUP_FORM_TYPE','ap:po');		// form type to use for printing
	$account_type = 'v';					// choices are v - vendor or c - customer
	break;
  case 6:		// Purchase Journal (accounts payable - pay later)
	define('ORD_ACCT_ID',GEN_VENDOR_ID);
	define('GL_TYPE','por');
	define('DEF_INV_GL_ACCT',AP_DEFAULT_INVENTORY_ACCOUNT);
	define('DEF_GL_ACCT',$_SESSION['admin_prefs']['def_ap_acct'] ? $_SESSION['admin_prefs']['def_ap_acct'] : AP_DEFAULT_PURCHASE_ACCOUNT);
	define('DEF_GL_ACCT_TITLE',ORD_AP_ACCOUNT);
	$item_col_1_enable = false;
	$item_col_2_enable = true;
	define('POPUP_FORM_TYPE','');
	$account_type = 'v';
	break;
  case 7:		// Vendor Credit Memo Journal (unpaid invoice returned product to vendor)
	define('ORD_ACCT_ID',GEN_VENDOR_ID);
	define('GL_TYPE','por');
	define('DEF_INV_GL_ACCT',AP_DEFAULT_INVENTORY_ACCOUNT);
	define('DEF_GL_ACCT',$_SESSION['admin_prefs']['def_ap_acct'] ? $_SESSION['admin_prefs']['def_ap_acct'] : AP_DEFAULT_PURCHASE_ACCOUNT);
	define('DEF_GL_ACCT_TITLE',ORD_AP_ACCOUNT);
	$item_col_1_enable = false;
	$item_col_2_enable = true;
	define('POPUP_FORM_TYPE','ap:cm');
	$account_type = 'v';
	break;
  case 9:		// Customer Quote Journal
	define('ORD_ACCT_ID',GEN_CUSTOMER_ID);
	define('GL_TYPE','soo');				// code to use for journal rows
	define('DEF_INV_GL_ACCT',AR_DEF_GL_SALES_ACCT);	// default account to use for item rows
	define('DEF_GL_ACCT',$_SESSION['admin_prefs']['def_ar_acct'] ? $_SESSION['admin_prefs']['def_ar_acct'] : AR_DEFAULT_GL_ACCT);
	define('DEF_GL_ACCT_TITLE',ORD_AR_ACCOUNT);
	$item_col_1_enable = true;				// allow/disallow entry of item columns
	$item_col_2_enable = false;
	define('POPUP_FORM_TYPE','ar:quot');	// form type to use for printing
	$account_type = 'c';					// choices are v - vendor or c - customer
	break;
  case 10:	// Sales Order Journal
	define('ORD_ACCT_ID',GEN_CUSTOMER_ID);
	define('GL_TYPE','soo');
	define('DEF_INV_GL_ACCT',AR_DEF_GL_SALES_ACCT);
	define('DEF_GL_ACCT',$_SESSION['admin_prefs']['def_ar_acct'] ? $_SESSION['admin_prefs']['def_ar_acct'] : AR_DEFAULT_GL_ACCT);
	define('DEF_GL_ACCT_TITLE',ORD_AR_ACCOUNT);
	$item_col_1_enable = true;
	$item_col_2_enable = false;
	define('POPUP_FORM_TYPE','ar:so');
	$account_type = 'c';
	break;
  case 12:	// Sales/Invoice Journal (invoice for payment later)
	define('ORD_ACCT_ID',GEN_CUSTOMER_ID);
	define('GL_TYPE','sos');
	define('DEF_INV_GL_ACCT',AR_DEF_GL_SALES_ACCT);
	define('DEF_GL_ACCT',$_SESSION['admin_prefs']['def_ar_acct'] ? $_SESSION['admin_prefs']['def_ar_acct'] : AR_DEFAULT_GL_ACCT);
	define('DEF_GL_ACCT_TITLE',ORD_AR_ACCOUNT);
	$item_col_1_enable = false;
	$item_col_2_enable = true;
	define('POPUP_FORM_TYPE','ar:inv');
	$account_type = 'c';
	break;
  case 13:	// Customer Credit Memo Journal (unpaid invoice returned product from customer)
	define('ORD_ACCT_ID',GEN_CUSTOMER_ID);
	define('GL_TYPE','sos');
	define('DEF_INV_GL_ACCT',AR_DEF_GL_SALES_ACCT);
	define('DEF_GL_ACCT',$_SESSION['admin_prefs']['def_ar_acct'] ? $_SESSION['admin_prefs']['def_ar_acct'] : AR_DEFAULT_GL_ACCT);
	define('DEF_GL_ACCT_TITLE',ORD_AR_ACCOUNT);
	$item_col_1_enable = false;
	$item_col_2_enable = true;
	define('POPUP_FORM_TYPE','ar:cm');
	$account_type = 'c';
	break;
  case 19:	// Point of Sale Journal
	define('ORD_ACCT_ID',GEN_CUSTOMER_ID);
	define('GL_TYPE','sos');
	define('DEF_INV_GL_ACCT',AR_DEF_GL_SALES_ACCT);
	define('DEF_GL_ACCT',AR_DEFAULT_GL_ACCT);
	define('DEF_GL_ACCT_TITLE',ORD_AR_ACCOUNT);
	$item_col_1_enable = false;
	$item_col_2_enable = true;
	define('POPUP_FORM_TYPE','ar:rcpt');
	$account_type = 'c';
	break;
  case 21:	// Point of Purchase Journal
	define('ORD_ACCT_ID',GEN_VENDOR_ID);
	define('GL_TYPE','por');
	define('DEF_INV_GL_ACCT',AP_DEFAULT_INVENTORY_ACCOUNT);
	define('DEF_GL_ACCT',AP_PURCHASE_INVOICE_ACCOUNT);
	define('DEF_GL_ACCT_TITLE',ORD_CASH_ACCOUNT);
	$item_col_1_enable = false;
	$item_col_2_enable = true;
	define('POPUP_FORM_TYPE','ap:chk');
	$account_type = 'v';
	break;
  default:
}

if (JOURNAL_ID == 19) {// Rene decide if shipping functions are required and wanted.
  define('SHOW_SHIPPING_FUNCTIONS',false);	
} else {
  define('SHOW_SHIPPING_FUNCTIONS',ENABLE_SHIPPING_FUNCTIONS);
}
$error        = false;
$post_success = false;
$order        = new orders();
//$payment	  = new payment();

$action       = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);
/*** AGREGO ESTAS LINEAS PARA EVITAR EL FORM RESUBMISION  */
if ($_SERVER['REQUEST_METHOD']!='GET' && $action) { //ya se hizo el submit
	$session = new SessionManager();
	$action = ($session->validate_session($_POST['random'])) ? $action : null; //si no valida la sesion, invalido el action
  	/*if ($action == null)
		die("encontre un resubmit");*/
}
/*** FIN DE LAS LINEAS PARA EVITAR EL FORM RESUBMISION  */


/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/orders/orders/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
  case 'email':
  case 'print':
  case 'payment':
  case 'post_previous':
  case 'post_next':
	if ($security_level < 2) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}

	// load bill to and ship to information
	$order->short_name          = db_prepare_input(($_POST['search'] <> TEXT_SEARCH) ? $_POST['search'] : '');
	$order->ship_short_name     = db_prepare_input($_POST['ship_search']);
	$order->bill_add_update     = isset($_POST['bill_add_update']) ? $_POST['bill_add_update'] : 0;
	$order->ship_add_update     = isset($_POST['ship_add_update']) ? $_POST['ship_add_update'] : 0;
	$order->account_type        = $account_type;

	$order->bill_acct_id        = db_prepare_input($_POST['bill_acct_id']);
	$order->bill_address_id     = db_prepare_input($_POST['bill_address_id']);
	$order->bill_primary_name   = db_prepare_input(($_POST['bill_primary_name'] <> GEN_PRIMARY_NAME) ? $_POST['bill_primary_name'] : '', true);
	$order->bill_contact        = db_prepare_input(($_POST['bill_contact'] <> GEN_CONTACT) ? $_POST['bill_contact'] : '', ADDRESS_BOOK_CONTACT_REQUIRED);
	$order->bill_address1       = db_prepare_input(($_POST['bill_address1'] <> GEN_ADDRESS1) ? $_POST['bill_address1'] : '', ADDRESS_BOOK_ADDRESS1_REQUIRED);
	$order->bill_address2       = db_prepare_input(($_POST['bill_address2'] <> GEN_ADDRESS2) ? $_POST['bill_address2'] : '', ADDRESS_BOOK_ADDRESS2_REQUIRED);
	$order->bill_city_town      = db_prepare_input(($_POST['bill_city_town'] <> GEN_CITY_TOWN) ? $_POST['bill_city_town'] : '', ADDRESS_BOOK_CITY_TOWN_REQUIRED);
	$order->bill_state_province = db_prepare_input(($_POST['bill_state_province'] <> GEN_STATE_PROVINCE) ? $_POST['bill_state_province'] : '', ADDRESS_BOOK_STATE_PROVINCE_REQUIRED);
	$order->bill_postal_code    = db_prepare_input(($_POST['bill_postal_code'] <> GEN_POSTAL_CODE) ? $_POST['bill_postal_code'] : '', ADDRESS_BOOK_POSTAL_CODE_REQUIRED);
	$order->bill_country_code   = db_prepare_input($_POST['bill_country_code']);
	$order->bill_telephone1     = db_prepare_input(($_POST['bill_telephone1'] <> GEN_TELEPHONE1) ? $_POST['bill_telephone1'] : '', ADDRESS_BOOK_TELEPHONE1_REQUIRED);
	$order->bill_email          = db_prepare_input(($_POST['bill_email'] <> GEN_EMAIL) ? $_POST['bill_email'] : '', ADDRESS_BOOK_EMAIL_REQUIRED);

	$order->ship_acct_id        = db_prepare_input($_POST['ship_acct_id']);
	$order->ship_address_id     = db_prepare_input($_POST['ship_address_id']);
	$order->ship_primary_name   = db_prepare_input(($_POST['ship_primary_name'] <> GEN_PRIMARY_NAME) ? $_POST['ship_primary_name'] : '', true);
	$order->ship_contact        = db_prepare_input(($_POST['ship_contact'] <> GEN_CONTACT) ? $_POST['ship_contact'] : '', ADDRESS_BOOK_SHIP_CONTACT_REQ);
	$order->ship_address1       = db_prepare_input(($_POST['ship_address1'] <> GEN_ADDRESS1) ? $_POST['ship_address1'] : '', ADDRESS_BOOK_SHIP_ADD1_REQ);
	$order->ship_address2       = db_prepare_input(($_POST['ship_address2'] <> GEN_ADDRESS2) ? $_POST['ship_address2'] : '', ADDRESS_BOOK_SHIP_ADD2_REQ);
	$order->ship_city_town      = db_prepare_input(($_POST['ship_city_town'] <> GEN_CITY_TOWN) ? $_POST['ship_city_town'] : '', ADDRESS_BOOK_SHIP_CITY_REQ);
	$order->ship_state_province = db_prepare_input(($_POST['ship_state_province'] <> GEN_STATE_PROVINCE) ? $_POST['ship_state_province'] : '', ADDRESS_BOOK_SHIP_STATE_REQ);
	$order->ship_postal_code    = db_prepare_input(($_POST['ship_postal_code'] <> GEN_POSTAL_CODE) ? $_POST['ship_postal_code'] : '', ADDRESS_BOOK_SHIP_POSTAL_CODE_REQ);
	$order->ship_country_code   = db_prepare_input($_POST['ship_country_code']);
	$order->ship_telephone1     = db_prepare_input(($_POST['ship_telephone1'] <> GEN_TELEPHONE1) ? $_POST['ship_telephone1'] : '', ADDRESS_BOOK_TELEPHONE1_REQUIRED);
	$order->ship_email          = db_prepare_input(($_POST['ship_email'] <> GEN_EMAIL) ? $_POST['ship_email'] : '', ADDRESS_BOOK_EMAIL_REQUIRED);
	$order->shipper_code        = implode(':', array(db_prepare_input($_POST['ship_carrier']), db_prepare_input($_POST['ship_service'])));

	// load journal main data
	$order->id = ($_POST['id'] <> '') ? $_POST['id'] : ''; // will be null unless opening an existing purchase/receive
	$order->journal_id          = JOURNAL_ID;
	$order->post_date           = gen_db_date_short($_POST['post_date']);
	$order->period              = gen_calculate_period($order->post_date);
	if (!$order->period) break;	// bad post_date was submitted
	if ($_SESSION['admin_prefs']['restrict_period'] && $order->period <> CURRENT_ACCOUNTING_PERIOD) {
	  $error = $messageStack->add(ORD_ERROR_NOT_CUR_PERIOD, 'error');
	  break;
	}
	$order->so_po_ref_id        = db_prepare_input($_POST['so_po_ref_id']);	// Internal link to reference po/so record
	$order->purchase_invoice_id = db_prepare_input($_POST['purchase_invoice_id']);	// PhreeBooks order/invoice ID
	$order->purch_order_id      = db_prepare_input($_POST['purch_order_id']);  // customer PO/Ref number
	$order->store_id            = db_prepare_input($_POST['store_id']);
	if ($order->store_id == '') $order->store_id = 0;
	$order->description         = constant('GENERAL_JOURNAL_' . JOURNAL_ID . '_DESC');
	$order->recur_id            = db_prepare_input($_POST['recur_id']);
	$order->recur_frequency     = db_prepare_input($_POST['recur_frequency']);
//	$order->sales_tax_auths     = db_prepare_input($_POST['sales_tax_auths']);
	
	$order->admin_id            = $_SESSION['admin_id'];
	$order->rep_id              = db_prepare_input($_POST['rep_id']);
	$order->gl_acct_id          = db_prepare_input($_POST['gl_acct_id']);
	$order->terms               = db_prepare_input($_POST['terms']);
	$order->drop_ship           = isset($_POST['drop_ship']) ? $_POST['drop_ship'] : 0;
	$order->waiting             = (JOURNAL_ID == 6 || JOURNAL_ID == 7) ? (isset($_POST['waiting']) ? 1 : 0) : 0;
	$order->closed              = ($_POST['closed'] == '1') ? 1 : 0;
	$order->terminal_date       = gen_db_date_short($_POST['terminal_date']);
	$order->item_count          = db_prepare_input($_POST['item_count']);
	$order->weight              = db_prepare_input($_POST['weight']);
	$order->printed             = db_prepare_input($_POST['printed']);

	// currency values (convert to DEFAULT_CURRENCY to store in db)
	$order->currencies_code     = db_prepare_input($_POST['currencies_code']);
	$order->currencies_value    = db_prepare_input($_POST['currencies_value']);
	$order->subtotal            = $currencies->clean_value(db_prepare_input($_POST['subtotal']), $order->currencies_code) / $order->currencies_value; // don't need unless for verification
	$order->disc_gl_acct_id     = db_prepare_input($_POST['disc_gl_acct_id']);
	$order->discount            = $currencies->clean_value(db_prepare_input($_POST['discount']), $order->currencies_code) / $order->currencies_value;
	$order->disc_percent        = ($order->subtotal) ? (1 - (($order->subtotal - $order->discount) / $order->subtotal)) : 0;
	$order->ship_gl_acct_id     = db_prepare_input($_POST['ship_gl_acct_id']);
	$order->freight             = $currencies->clean_value(db_prepare_input($_POST['freight']), $order->currencies_code) / $order->currencies_value;
	$order->sales_tax           = $currencies->clean_value(db_prepare_input($_POST['sales_tax']), $order->currencies_code) / $order->currencies_value;
	$order->total_amount        = $currencies->clean_value(db_prepare_input($_POST['total']), $order->currencies_code) / $order->currencies_value;

	// load item row data
	$x = 1;
	while (isset($_POST['qty_' . $x])) { // while there are item rows to read in
	  $full_price = in_array(JOURNAL_ID, array(9, 10, 12, 13, 19, 21)) ? ($currencies->clean_value(db_prepare_input($_POST['full_' . $x]), $order->currencies_code) / $order->currencies_value) : 0;

	  // Error check some input fields
	  //if ($_POST['pstd_' . $x] == "") $error = $messageStack->add(GEN_ERRMSG_NO_DATA . "Qty", 'error');	  
	  if ($_POST['acct_' . $x] == "") $error = $messageStack->add(GEN_ERRMSG_NO_DATA . TEXT_GL_ACCOUNT, 'error');
	  //if ($_POST['price_' . $x] == "") $error = $messageStack->add(GEN_ERRMSG_NO_DATA . "Price", 'error'); //need to fix bugs.

	  if (!$error) {
	    $order->item_rows[] = array(
		  'id'                => db_prepare_input($_POST['id_' . $x]),
		  'so_po_item_ref_id' => db_prepare_input($_POST['so_po_item_ref_id_' . $x]),
		  'gl_type'           => GL_TYPE,
		  'qty'               => $currencies->clean_value(db_prepare_input($_POST['qty_' . $x]), $order->currencies_code),
		  'pstd'              => $currencies->clean_value(db_prepare_input($_POST['pstd_' . $x]), $order->currencies_code),
		  'sku'               => ($_POST['sku_' . $x] == TEXT_SEARCH) ? '' : db_prepare_input($_POST['sku_' . $x]),
		  'desc'              => db_prepare_input($_POST['desc_' . $x]),
		  'proj'              => db_prepare_input($_POST['proj_' . $x]),
		  'price'             => $currencies->clean_value(db_prepare_input($_POST['price_' . $x]), $order->currencies_code) / $order->currencies_value,
		  'full'              => $full_price,
		  'acct'              => db_prepare_input($_POST['acct_' . $x]),
		  'tax'               => db_prepare_input($_POST['tax_' . $x]),
		  'total'             => $currencies->clean_value(db_prepare_input($_POST['total_' . $x]), $order->currencies_code) / $order->currencies_value,
		  'weight'            => db_prepare_input($_POST['weight_' . $x]),
		  'serial'            => db_prepare_input($_POST['serial_' . $x]),
		  'stock'             => db_prepare_input($_POST['stock_' . $x]),
		  'inactive'          => db_prepare_input($_POST['inactive_' . $x]),
		  'lead_time'         => db_prepare_input($_POST['lead_' . $x]),
	    );
	  }
	  $x++;
	}
	// check for errors (address fields)
	if (JOURNAL_ID <> 19) { // Allow POS to post without address
	  if (!$order->bill_acct_id && !$order->bill_add_update) {
		$error = $messageStack->add(constant('ORD_TEXT_' . JOURNAL_ID . '_ERROR_NO_VENDOR'), 'error');
		break; // go no further
	  }
	  if ($order->bill_primary_name === false) $error     = $messageStack->add(GEN_ERRMSG_NO_DATA . constant('ORD_TEXT_' . JOURNAL_ID . '_BILL_TO') . ' / ' . GEN_PRIMARY_NAME, 'error');
	  if ($order->bill_contact === false) $error          = $messageStack->add(GEN_ERRMSG_NO_DATA . constant('ORD_TEXT_' . JOURNAL_ID . '_BILL_TO') . ' / ' . GEN_CONTACT, 'error');
	  if ($order->bill_address1 === false) $error         = $messageStack->add(GEN_ERRMSG_NO_DATA . constant('ORD_TEXT_' . JOURNAL_ID . '_BILL_TO') . ' / ' . GEN_ADDRESS1, 'error');
	  if ($order->bill_address2 === false) $error         = $messageStack->add(GEN_ERRMSG_NO_DATA . constant('ORD_TEXT_' . JOURNAL_ID . '_BILL_TO') . ' / ' . GEN_ADDRESS2, 'error');
	  if ($order->bill_city_town === false) $error        = $messageStack->add(GEN_ERRMSG_NO_DATA . constant('ORD_TEXT_' . JOURNAL_ID . '_BILL_TO') . ' / ' . GEN_CITY_TOWN, 'error');
	  if ($order->bill_state_province === false) $error   = $messageStack->add(GEN_ERRMSG_NO_DATA . constant('ORD_TEXT_' . JOURNAL_ID . '_BILL_TO') . ' / ' . GEN_STATE_PROVINCE, 'error');
	  if ($order->bill_postal_code === false) $error      = $messageStack->add(GEN_ERRMSG_NO_DATA . constant('ORD_TEXT_' . JOURNAL_ID . '_BILL_TO') . ' / ' . GEN_POSTAL_CODE, 'error');
	  if (ENABLE_SHIPPING_FUNCTIONS) {
		if ($order->ship_primary_name === false) $error   = $messageStack->add(GEN_ERRMSG_NO_DATA . ORD_SHIP_TO . ' / ' . GEN_PRIMARY_NAME, 'error');
		if ($order->ship_contact === false) $error        = $messageStack->add(GEN_ERRMSG_NO_DATA . ORD_SHIP_TO . ' / ' . GEN_CONTACT, 'error');
		if ($order->ship_address1 === false) $error       = $messageStack->add(GEN_ERRMSG_NO_DATA . ORD_SHIP_TO . ' / ' . GEN_ADDRESS1, 'error');
		if ($order->ship_address2 === false) $error       = $messageStack->add(GEN_ERRMSG_NO_DATA . ORD_SHIP_TO . ' / ' . GEN_ADDRESS2, 'error');
		if ($order->ship_city_town === false) $error      = $messageStack->add(GEN_ERRMSG_NO_DATA . ORD_SHIP_TO . ' / ' . GEN_CITY_TOWN, 'error');
		if ($order->ship_state_province === false) $error = $messageStack->add(GEN_ERRMSG_NO_DATA . ORD_SHIP_TO . ' / ' . GEN_STATE_PROVINCE, 'error');
		if ($order->ship_postal_code === false) $error    = $messageStack->add(GEN_ERRMSG_NO_DATA . ORD_SHIP_TO . ' / ' . GEN_POSTAL_CODE, 'error');
		if ($order->ship_telephone1 === false) $error     = $messageStack->add(GEN_ERRMSG_NO_DATA . ORD_SHIP_TO . ' / ' . GEN_TELEPHONE1, 'error');
		if ($order->ship_email === false) $error          = $messageStack->add(GEN_ERRMSG_NO_DATA . ORD_SHIP_TO . ' / ' . GEN_EMAIL, 'error');
	  }
	}
	// Item row errors
	if (!$order->item_rows) $error = $messageStack->add(GL_ERROR_NO_ITEMS, 'error');

	// End of error checking, process the order
	if (!$error) { // Post the order
	  if ($post_success = $order->post_ordr($action)) {	// Post the order class to the db
		gen_add_audit_log(constant('ORD_TEXT_' . JOURNAL_ID . '_WINDOW_TITLE') . ' - ' . ($_POST['id'] ? TEXT_EDIT : TEXT_ADD), $order->purchase_invoice_id, $order->total_amount);
		if (DEBUG) $messageStack->write_debug();
		if ($action == 'save') {
		  gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		} elseif ($action == 'payment') {
		  switch (JOURNAL_ID) {
			case  6: $jID = 20; break; // payments
			case 12: $jID = 18; break; // cash receipts
			default: $jID = 0; // error
		  } 
		  gen_redirect(html_href_link(FILENAME_DEFAULT, 'cat=banking&amp;module=bills&amp;jID=' . $jID . '&amp;type=' . $account_type . '&amp;oID=' . $order->id . '&amp;action=pmt', 'SSL'));
		} // else print or print_update, fall through and load javascript to call form_popup and clear form
	  } else { // reset the id because the post failed (ID could have been set inside of Post)
		$error = true;
		$order->purchase_invoice_id = db_prepare_input($_POST['purchase_invoice_id']);	// reset order num to submitted value (may have been set if payment failed)
		$order->id = ($_POST['id'] <> '') ? $_POST['id'] : ''; // will be null unless opening an existing purchase/receive
	  }
	} else { // there was a post error, reset id and re-display form
	  $messageStack->add(GL_ERROR_NO_POST, 'error');
	}
	if ($action == 'post_previous') {
	  $result = $db->Execute("select id from " . TABLE_JOURNAL_MAIN . " 
	    where journal_id = '12' and purchase_invoice_id < '" . $order->purchase_invoice_id . "' 
	    order by purchase_invoice_id DESC limit 1");
	  if ($result->RecordCount() > 0) {
	    $oID    = $result->fields['id'];
	    $action = 'edit'; // force page to reload with the new order to edit
		$order  = new orders();
      } else { // at the beginning
	  	gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
	  }
	}
	if ($action == 'post_next') {
	  $result = $db->Execute("select id from " . TABLE_JOURNAL_MAIN . " 
	    where journal_id = '12' and purchase_invoice_id > '" . $order->purchase_invoice_id . "' 
	    order by purchase_invoice_id limit 1");
	  if ($result->RecordCount() > 0) {
	    $oID    = $result->fields['id'];
	    $action = 'edit'; // force page to reload with the new order to edit
		$order  = new orders();
      } else { // at the end
	  	gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
	  }
	}
	if (DEBUG) $messageStack->write_debug();
	break;

  case 'delete':
	if ($security_level < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}

	$id = ($_POST['id'] <> '') ? $_POST['id'] : ''; // will be null unless opening an existing purchase/receive
	if ($id) {
		$delOrd = new orders();
		$delOrd->journal($id); // load the posted record based on the id submitted
		if ($_SESSION['admin_prefs']['restrict_period'] && $delOrd->period <> CURRENT_ACCOUNTING_PERIOD) {
		  $error = $messageStack->add(ORD_ERROR_DEL_NOT_CUR_PERIOD, 'error');
		  break;
		}
		$delOrd->recur_frequency = db_prepare_input($_POST['recur_frequency']);
		if ($delOrd->delete_ordr()) {
			if (DEBUG) $messageStack->write_debug();
			gen_add_audit_log(constant('ORD_TEXT_' . JOURNAL_ID . '_WINDOW_TITLE') . ' - Delete', $delOrd->purchase_invoice_id, $delOrd->total_amount);
			gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
			break;
		}
	} else {
		$messageStack->add(GL_ERROR_NEVER_POSTED, 'error');
	}
	$messageStack->add(GL_ERROR_NO_DELETE, 'error');
	if (DEBUG) $messageStack->write_debug();
	break;

  case 'edit':
  case 'prc_so':
	$oID = db_prepare_input($_GET['oID']);
	if (!$oID) {
		$messageStack->add('Bad order ID passed to edit order.','error'); // this should never happen
		$action = '';
	}
	break;

  default:
}

/*****************   prepare to display templates  *************************/
// generate address arrays for javascript
$js_arrays = gen_build_acct_arrays();

// load gl accounts
$gl_array_list = gen_coa_pull_down();
// generate the list of gl accounts and fill js arrays for dynamic pull downs
$js_gl_array = 'var js_gl_array = new Array(' . count($gl_array_list) . ');' . chr(10);
for ($i = 0; $i < count($gl_array_list); $i++) {
  $js_gl_array .= 'js_gl_array[' . $i . '] = new dropDownData("' . $gl_array_list[$i]['id'] . '", "' . $gl_array_list[$i]['text'] . '");' . chr(10);
}
// load the tax rates
$tax_rates = ord_calculate_tax_drop_down($account_type);
// generate a rate array parallel to the drop down for the javascript total calculator
$js_tax_rates = 'var tax_rates = new Array(' . count($tax_rates) . ');' . chr(10);
for ($i = 0; $i < count($tax_rates); $i++) {
  $js_tax_rates .= 'tax_rates[' . $i . '] = new salesTaxes("' . $tax_rates[$i]['id'] . '", "' . $tax_rates[$i]['text'] . '", "' . $tax_rates[$i]['rate'] . '");' . chr(10);
}
// load projects
$proj_list = ord_get_projects();
// generate a project list array parallel to the drop down for the javascript add line item function
$js_proj_list = 'var proj_list = new Array(' . count($proj_list) . ');' . chr(10);
for ($i = 0; $i < count($proj_list); $i++) {
  $js_proj_list .= 'proj_list[' . $i . '] = new dropDownData("' . $proj_list[$i]['id'] . '", "' . $proj_list[$i]['text'] . '");' . chr(10);
}
// Load shipping methods
$shipping_methods = ord_get_shipping_methods();

// see if current user points to a employee for sales rep default
$result = $db->Execute("select account_id from " . TABLE_USERS . " where admin_id = " . $_SESSION['admin_id']);
$default_sales_rep = $result->fields['account_id'] ? $result->fields['account_id'] : '0';
if (JOURNAL_ID == 19) { // load available payment modules
  $payment_choices = array();
  $payment_modules = load_service_modules('payment');		
  foreach ($payment_modules as $class) {
	$$class = new $class;
	if ($$class->check() > 0) {
	  if ($$class->sort_order > 0) {
		$payment_choices[$$class->sort_order] = array('id' => $class, 'text' => constant('MODULE_PAYMENT_' . strtoupper($class) . '_TEXT_TITLE'));
		$installed_modules[$$class->sort_order] = $class;
	  } else {
		$installed_modules[] = $class;
	  }
    }
  }
  ksort($installed_modules);
  ksort($payment_choices);
}
// build the display options based on JOURNAL_ID
$template_options = array();
switch(JOURNAL_ID) {
  case  3:
	$req_date = gen_spiffycal_db_date_short(gen_specific_date('', 0, 1, 0));
	$template_options['terminal_date'] = array('title' => constant('ORD_TEXT_' . JOURNAL_ID . '_EXPIRES'), 
		'field' => '<script type="text/javascript">dateRequired.writeControl(); dateRequired.displayLeft=true; dateRequired.dateFormat="' . DATE_FORMAT_SPIFFYCAL . '";</script>');
	$template_options['terms'] = array('title' => ACT_TERMS_DUE, 
		'field' => html_input_field('terms_text', gen_terms_to_language('0', true, 'ap'), 'readonly="readonly" size="25"') . '&nbsp;' . html_icon('apps/accessories-text-editor.png', ACT_TERMS_DUE, 'small', 'align="top" style="cursor:pointer" onclick="TermsList()"'));
	$template_options['closed'] = array('title' => TEXT_CLOSE, 
		'field' => html_checkbox_field('closed', '1', ($order->closed) ? true : false, '', ''));
	break;
  case  4:
	$req_date = gen_spiffycal_db_date_short(gen_specific_date('', 0, 1, 0));
	$template_options['terminal_date'] = array('title' => constant('ORD_TEXT_' . JOURNAL_ID . '_EXPIRES'), 
		'field' => '<script type="text/javascript">dateRequired.writeControl(); dateRequired.displayLeft=true; dateRequired.dateFormat="' . DATE_FORMAT_SPIFFYCAL . '";</script>');
	$template_options['terms'] = array('title' => ACT_TERMS_DUE, 
		'field' => html_input_field('terms_text', gen_terms_to_language('0', true, 'ap'), 'readonly="readonly" size="25"') . '&nbsp;' . html_icon('apps/accessories-text-editor.png', ACT_TERMS_DUE, 'small', 'align="top" style="cursor:pointer" onclick="TermsList()"'));
	$template_options['closed'] = array('title' => TEXT_CLOSE, 
		'field' => html_checkbox_field('closed', '1', ($order->closed) ? true : false, '', ''));
	break;
  case  6:
	$req_date = gen_spiffycal_db_date_short(gen_specific_date('', 0, 1, 0));
	$template_options['terms'] = array('title' => ACT_TERMS_DUE, 
		'field' => html_input_field('terms_text', gen_terms_to_language('0', true, 'ap'), 'readonly="readonly" size="25"') . '&nbsp;' . html_icon('apps/accessories-text-editor.png', ACT_TERMS_DUE, 'small', 'align="top" style="cursor:pointer" onclick="TermsList()"'));
	$template_options['waiting'] = array('title' => ORD_WAITING_FOR_INVOICE,
		'field' => html_checkbox_field('waiting', '1', ($order->waiting) ? true : false, '', ''));
	break;
  case  7:
	$req_date = date(DATE_FORMAT, time());
	$template_options['terms'] = array('title' => ACT_TERMS_DUE, 
		'field' => html_input_field('terms_text', gen_terms_to_language('0', true, 'ap'), 'readonly="readonly" size="25"') . '&nbsp;' . html_icon('apps/accessories-text-editor.png', ACT_TERMS_DUE, 'small', 'align="top" style="cursor:pointer" onclick="TermsList()"'));
	$template_options['waiting'] = array('title' => ORD_WAITING_FOR_INVOICE,
		'field' => html_checkbox_field('waiting', '1', ($order->waiting) ? true : false, '', ''));
	break;
  case  9:
	$req_date = date(DATE_FORMAT, time());
	$template_options['terminal_date'] = array('title' => constant('ORD_TEXT_' . JOURNAL_ID . '_EXPIRES'), 
		'field' => '<script type="text/javascript">dateRequired.writeControl(); dateRequired.displayLeft=true; dateRequired.dateFormat="' . DATE_FORMAT_SPIFFYCAL . '";</script>');
	$template_options['terms'] = array('title' => ACT_TERMS_DUE, 
		'field' => html_input_field('terms_text', gen_terms_to_language('0', true, 'ap'), 'readonly="readonly" size="25"') . '&nbsp;' . html_icon('apps/accessories-text-editor.png', ACT_TERMS_DUE, 'small', 'align="top" style="cursor:pointer" onclick="TermsList()"'));
	$template_options['closed'] = array('title' => TEXT_CLOSE, 
		'field' => html_checkbox_field('closed', '1', ($order->closed) ? true : false, '', ''));
	break;
  case 10:
	$req_date = date(DATE_FORMAT, time());
	$template_options['terminal_date'] = array('title' => constant('ORD_TEXT_' . JOURNAL_ID . '_EXPIRES'), 
		'field' => '<script type="text/javascript">dateRequired.writeControl(); dateRequired.displayLeft=true; dateRequired.dateFormat="' . DATE_FORMAT_SPIFFYCAL . '";</script>');
	$template_options['terms'] = array('title' => ACT_TERMS_DUE, 
		'field' => html_input_field('terms_text', gen_terms_to_language('0', true, 'ap'), 'readonly="readonly" size="25"') . '&nbsp;' . html_icon('apps/accessories-text-editor.png', ACT_TERMS_DUE, 'small', 'align="top" style="cursor:pointer" onclick="TermsList()"'));
	$template_options['closed'] = array('title' => TEXT_CLOSE, 
		'field' => html_checkbox_field('closed', '1', ($order->closed) ? true : false, '', ''));
	break;
  case 12:
	$req_date = date(DATE_FORMAT, time());
	$template_options['terminal_date'] = array('title' => constant('ORD_TEXT_' . JOURNAL_ID . '_EXPIRES'), 
		'field' => '<script type="text/javascript">dateRequired.writeControl(); dateRequired.displayLeft=true; dateRequired.dateFormat="' . DATE_FORMAT_SPIFFYCAL . '";</script>');
	$template_options['terms'] = array('title' => ACT_TERMS_DUE, 
		'field' => html_input_field('terms_text', gen_terms_to_language('0', true, 'ap'), 'readonly="readonly" size="25"') . '&nbsp;' . html_icon('apps/accessories-text-editor.png', ACT_TERMS_DUE, 'small', 'align="top" style="cursor:pointer" onclick="TermsList()"'));
	break;
  case 13: 
  case 19: 
  case 21: 
	$req_date = date(DATE_FORMAT, time());
	break;
default:
}

$include_header   = true;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = true;
$include_template = 'template_main.php'; // include display template (required)
define('PAGE_TITLE', constant('ORD_TEXT_' . JOURNAL_ID . '_WINDOW_TITLE'));

?>
