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
//  Path: /modules/banking/pages/bills/pre_process.php
//

/**************   Check user security   *****************************/
$jID = (int)$_GET['jID'];
$type = isset($_GET['type']) ? $_GET['type'] : $_POST['type'];

switch ($jID) {
  case 18:	// Cash Receipts Journal
	define('JOURNAL_ID',18);
	$security_token = ($type == 'v') ? SECURITY_ID_VENDOR_RECEIPTS : SECURITY_ID_CUSTOMER_RECEIPTS;
	$security_level = $_SESSION['admin_security'][$security_token]; break;
  case 20:	// Cash Disbursements Journal
	define('JOURNAL_ID',20);
	$security_token = ($type == 'c') ? SECURITY_ID_CUSTOMER_PAYMENTS : SECURITY_ID_PAY_BILLS;
	$security_level = $_SESSION['admin_security'][$security_token]; break;
}

if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'gen_ledger/language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING . 'functions/banking.php');
require(DIR_FS_WORKING . 'classes/banking.php');

/**************   page specific initialization  *************************/
// check to see if we need to make a payment for a specific order
$oID               = isset($_GET['oID']) ? (int)$_GET['oID'] : false;
$post_date         = ($_POST['post_date']) ? gen_db_date_short($_POST['post_date']) : date('Y-m-d', time());
$period            = gen_calculate_period($post_date);
if (!$period) { // bad post_date was submitted
  $action    = '';
  $post_date = date('Y-m-d', time());
  $period    = 0;
}
$gl_acct_id        = ($_POST['gl_acct_id']) ? db_prepare_input($_POST['gl_acct_id']) : AP_PURCHASE_INVOICE_ACCOUNT;
$installed_modules = array();
$post_success      = false;
$error             = false;

switch (JOURNAL_ID) {
	case 18:	// Cash Receipts Journal
		define('GL_TYPE','pmt');
		define('POPUP_FORM_TYPE','ar:rcpt');
		define('AUDIT_LOG_DESC',BNK_18_ENTER_BILLS);
		define('AUDIT_LOG_DEL_DESC',BNK_18_DELETE_BILLS);
		$account_type = ($type == 'v') ? 'v' : 'c';
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
		break;
	case 20:	// Cash Disbursements Journal
		define('GL_TYPE','chk');
		define('POPUP_FORM_TYPE','ap:chk');
		define('AUDIT_LOG_DESC',BNK_20_ENTER_BILLS);
		define('AUDIT_LOG_DEL_DESC',BNK_20_DELETE_BILLS);
		$account_type = ($type == 'c') ? 'c' : 'v';
		break;
	default: // this should never happen
		$messageStack->add_session('No valid journal id found (module bills), Journal ID needs to be passed to this script to identify the action', 'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

$order  = new banking();
$action = isset($_GET['action']) ? $_GET['action'] : $_POST['todo'];

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/banking/bills/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
  case 'print':
	if ($security_level < 2) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}

	// create and retrieve customer account (defaults also)
	$order->bill_short_name     = db_prepare_input($_POST['search']);
	$order->bill_acct_id        = db_prepare_input($_POST['bill_acct_id']);
	$order->bill_address_id     = db_prepare_input($_POST['bill_address_id']);
	$order->bill_primary_name   = $_POST['bill_primary_name'] <> GEN_PRIMARY_NAME ? db_prepare_input($_POST['bill_primary_name']) : '';
	$order->bill_contact        = $_POST['bill_contact'] <> GEN_CONTACT ? db_prepare_input($_POST['bill_contact']) : '';
	$order->bill_address1       = $_POST['bill_address1'] <> GEN_ADDRESS1 ? db_prepare_input($_POST['bill_address1']) : '';
	$order->bill_address2       = $_POST['bill_address2'] <> GEN_ADDRESS2 ? db_prepare_input($_POST['bill_address2']) : '';
	$order->bill_city_town      = $_POST['bill_city_town'] <> GEN_CITY_TOWN ? db_prepare_input($_POST['bill_city_town']) : '';
	$order->bill_state_province = $_POST['bill_state_province'] <> GEN_STATE_PROVINCE ? db_prepare_input($_POST['bill_state_province']) : '';
	$order->bill_postal_code    = $_POST['bill_postal_code'] <> GEN_POSTAL_CODE ? db_prepare_input($_POST['bill_postal_code']) : '';
	$order->bill_country_code   = db_prepare_input($_POST['bill_country_code']);

	// load journal main data
	$order->id                  = ($_POST['id'] <> '') ? $_POST['id'] : ''; // will be null unless opening an existing purchase/receive
	$order->journal_id          = JOURNAL_ID;
	$order->post_date           = $post_date;
	$order->period              = $period;
	$order->admin_id            = $_SESSION['admin_id'];
	if (!$order->period) break;	// bad post_date was submitted
	$order->purchase_invoice_id = db_prepare_input($_POST['purchase_invoice_id']);	// PhreeBooks order/invoice ID
	$order->shipper_code        = db_prepare_input($_POST['shipper_code']);  // store payment method in shipper_code field
	$order->purch_order_id      = db_prepare_input($_POST['purch_order_id']);  // customer PO/Ref number
	$order->description         = constant('GENERAL_JOURNAL_' . JOURNAL_ID . '_' . strtoupper($type) . '_DESC');

	$order->total_amount        = $currencies->clean_value(db_prepare_input($_POST['total']), DEFAULT_CURRENCY);
	$order->gl_acct_id          = $gl_acct_id;
	$order->gl_disc_acct_id     = db_prepare_input($_POST['gl_disc_acct_id']);
	$order->payment_id          = db_prepare_input($_POST['payment_id']);
	$order->save_payment        = isset($_POST['save_payment']) ? true : false;

	// load item row data
	$x = 1;
	while (isset($_POST['id_' . $x])) { // while there are invoice rows to read in
	  if (isset($_POST['pay_' . $x])) {
		$order->item_rows[] = array(
		  'id'      => db_prepare_input($_POST['id_' . $x]),
		  'gl_type' => GL_TYPE,
		  'amt'     => $currencies->clean_value(db_prepare_input($_POST['amt_' . $x])),
		  'desc'    => db_prepare_input($_POST['desc_' . $x]),
		  'dscnt'   => $currencies->clean_value(db_prepare_input($_POST['dscnt_' . $x])),
		  'total'   => $currencies->clean_value(db_prepare_input($_POST['total_' . $x])),
		  'inv'     => db_prepare_input($_POST['inv_' . $x]),
		  'prcnt'   => db_prepare_input($_POST['prcnt_' . $x]),
		  'early'   => db_prepare_input($_POST['early_' . $x]),
		  'due'     => db_prepare_input($_POST['due_' . $x]),
		  'pay'     => isset($_POST['pay_' . $x]) ? true : false,
		  'acct'    => db_prepare_input($_POST['acct_' . $x]),
		);
	  }
	  $x++;
	}

	// error check input
	if (!$order->bill_acct_id) { // no account was selected, error
		$messageStack->add(constant('BNK_' . JOURNAL_ID . '_ERROR_NO_VENDOR'), 'error');
		$error = true;
	}
	if (!$order->item_rows) {
		$messageStack->add(GL_ERROR_NO_ITEMS, 'error');
		$error = true;
	}

	// check to make sure the payment method is valid
	if (JOURNAL_ID == 18) {	
		$payment_module = $order->shipper_code; 
		$payment_module = load_service_module('payment', $payment_module);
		if (class_exists($payment_module)) {
			$processor = new $payment_module;
			if (!$processor->check()) $error = true;
			if ($processor->pre_confirmation_check()) $error = true;	
			
		}
	}

/* This has been commented out to allow customer refunds (negative invoices)
	if ($order->total_amount < 0) {
		$messageStack->add(constant('BNK_' . JOURNAL_ID . '_NEGATIVE_TOTAL'),'error');
		$error = true;
	}
*/
	// post the receipt/payment
	if (!$error && $post_success = $order->post_ordr($action)) {	// Post the order class to the db
		if ($action == 'save') {
			gen_add_audit_log(AUDIT_LOG_DESC, $order->purchase_invoice_id, $order->total_amount);
			if (DEBUG) $messageStack->write_debug();
			gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		} // else print or print_update, fall through and load javascript to call form_popup and clear form
	} else { // else there was a post error, display and re-display form
		$error = true;
		if (DEBUG) $messageStack->write_debug();
		$order = new objectInfo($_POST);
		$order->post_date = gen_db_date_short($_POST['post_date']); // fix the date to original format
		$order->id = ($_POST['id'] <> '') ? $_POST['id'] : ''; // will be null unless opening an existing purchase/receive
		$messageStack->add(GL_ERROR_NO_POST, 'error');
	}
	break;

  case 'delete':
	if ($security_level < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$id = ($_POST['id'] <> '') ? $_POST['id'] : ''; // will be null unless opening an existing purchase/receive
	if ($id) {
		$delOrd = new banking();
		$delOrd->journal($id); // load the posted record based on the id submitted
		if ($delOrd->delete_payment()) {
			gen_add_audit_log(AUDIT_LOG_DEL_DESC, $order->purchase_invoice_id, $order->total_amount);
			if (DEBUG) $messageStack->write_debug();
			gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		}
	} else {
		$messageStack->add(GL_ERROR_NEVER_POSTED, 'error');
	}
	$messageStack->add(GL_ERROR_NO_DELETE, 'error');
	// if we are here, there was an error, reload page
	$order = new objectInfo($_POST);
	$order->post_date = gen_db_date_short($_POST['post_date']); // fix the date to original format
	break;

  case 'pmt': // for opening a sales/invoice directly from payment (POS like)
    // fetch the journal_main information
    $sql = "select id, shipper_code, bill_acct_id, bill_address_id, bill_primary_name, bill_contact, bill_address1, 
		bill_address2, bill_city_town, bill_state_province, bill_postal_code, bill_country_code, 
		post_date, terms, gl_acct_id, purchase_invoice_id, total_amount from " . TABLE_JOURNAL_MAIN . " 
		where id = " . $oID;
	$result = $db->Execute($sql);
	$account_id = $db->Execute("select short_name from " . TABLE_CONTACTS . " where id = " . $result->fields['bill_acct_id']);
	$due_dates = calculate_terms_due_dates($result->fields['post_date'], $result->fields['terms'], 'AR');

	$order->bill_acct_id        = $result->fields['bill_acct_id'];
	$order->bill_primary_name   = $result->fields['bill_primary_name'];
	$order->bill_contact        = $result->fields['bill_contact'];
	$order->bill_address1       = $result->fields['bill_address1'];
	$order->bill_address2       = $result->fields['bill_address2'];
	$order->bill_city_town      = $result->fields['bill_city_town'];
	$order->bill_state_province = $result->fields['bill_state_province'];
	$order->bill_postal_code    = $result->fields['bill_postal_code'];
	$order->bill_country_code   = $result->fields['bill_country_code'];
    $order->id_1                = $result->fields['id'];
    $order->inv_1               = $result->fields['purchase_invoice_id'];
    $order->acct_1              = $result->fields['gl_acct_id'];
    $order->early_1             = $due_dates['early_date'];
    $order->due_1               = $due_dates['net_date'];
    $order->prcnt_1             = $due_dates['discount'];
    $order->pay_1               = true;
    $order->amt_1               = $result->fields['total_amount'];
    $order->total_1             = $result->fields['total_amount'];
    $order->desc_1              = '';
	// reset some particular values
	$order->search = $account_id->fields['short_name']; // set the customer id in the search box
	// show the form
	$payment = $db->Execute("select description from " . TABLE_JOURNAL_ITEM . " 
		where ref_id = " . $oID . " and gl_type = 'ttl'");
	$temp = $payment->fields['description'];
	$temp = strpos($temp, ':') ? substr($temp, strpos($temp, ':') + 1) : '';
	$payment_fields = explode(':', $temp);
	for ($i = 0; $i < sizeof($payment_fields); $i++) {
	  $temp = $result->fields['shipper_code'] . '_field_' . $i;
	  $order->$temp = $payment_fields[$i];
	}
	break;
  case 'edit': // handled in ajax
	break;
  default:
}

/*****************   prepare to display templates  *************************/
// load the gl account beginning balance
$acct_balance = load_cash_acct_balance($post_date, $gl_acct_id, $period);
// load gl accounts
$gl_array_list = gen_coa_pull_down();
// generate address arrays for javascript
$js_arrays = gen_build_acct_arrays();

$include_header   = true;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = true;
$include_template = 'template_main.php';
define('PAGE_TITLE', constant('BNK_' . JOURNAL_ID . '_' . strtoupper($type) . '_WINDOW_TITLE'));
?>