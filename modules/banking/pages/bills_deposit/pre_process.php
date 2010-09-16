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
//  Path: /modules/banking/pages/bills_deposit/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_CUSTOMER_DEPOSITS];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/*****************  Set additional defines   ************************/
$type = $_GET['type'];
switch ($type) {
  case 'c': // customers
	define('JOURNAL_ID', 18);
	define('GL_TYPE','pmt');
	define('POPUP_FORM_TYPE','ar:rcpt');
	define('AUDIT_LOG_DESC',BNK_18_ENTER_DEPOSIT);
	define('DEF_DEP_GL_ACCT',AR_DEF_DEP_LIAB_ACCT);
    break;
  case 'v': // vendors
	define('JOURNAL_ID', 20);
	define('GL_TYPE','chk');
	define('POPUP_FORM_TYPE','ap:chk');
	define('AUDIT_LOG_DESC',BNK_20_ENTER_DEPOSIT);
	define('DEF_DEP_GL_ACCT',AP_DEF_DEP_LIAB_ACCT);
    break;
  default:
    die('Illegal Access');
}

/**************  include page specific files    *********************/
require(DIR_FS_MODULES . 'banking/language/'    . $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'gen_ledger/language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'orders/language/'     . $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'banking/functions/banking.php');
require(DIR_FS_MODULES . 'banking/classes/banking.php');
require(DIR_FS_MODULES . 'orders/functions/orders.php');
require(DIR_FS_MODULES . 'orders/classes/orders.php');

/**************   page specific initialization  *************************/
$error             = false;
$post_success      = false;
$installed_modules = array();
$order             = new banking();
$action            = isset($_GET['action']) ? $_GET['action'] : $_POST['todo'];
$gl_acct_id        = $_POST['gl_acct_id']   ? db_prepare_input($_POST['gl_acct_id']) : $order->gl_acct_id;
$order->gl_acct_id = $gl_acct_id;
$order->acct_1     = DEF_DEP_GL_ACCT;
$default_dep_acct  = JOURNAL_ID == 18 ? AR_DEF_DEPOSIT_ACCT : AP_DEF_DEPOSIT_ACCT;
$post_date         = $_POST['post_date']    ? gen_db_date_short($_POST['post_date']) : date('Y-m-d', time());
$period            = gen_calculate_period($post_date);
if (!$period) { // bad post_date was submitted
  $action = '';
  $post_date = date('Y-m-d', time());
  $period = 0;
}

// load available payment modules, receipts only
if (JOURNAL_ID == 18) {
  $module_directory = DIR_FS_MODULES . 'services/payment/modules/';
  $file_extension = substr($PHP_SELF, strrpos($PHP_SELF, '.'));
  $directory_array = array();
  if ($dir = @dir($module_directory)) {
	while ($file = $dir->read()) {
		if (!is_dir($module_directory . $file)) {
			if (substr($file, strrpos($file, '.')) == $file_extension) {
				$directory_array[] = $file;
			}
		}
	}
	sort($directory_array);
	$dir->close();
  }

  $payment_choices = array();
  for ($i=0, $n=sizeof($directory_array); $i<$n; $i++) {
	$file = $directory_array[$i];
	include_once($module_directory . $file);
	$class = substr($file, 0, strrpos($file, '.'));
	if (class_exists($class)) {
		include_once(DIR_FS_MODULES . 'services/payment/language/' . $_SESSION['language'] . '/modules/' . $file);
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
  }
  ksort($installed_modules);
  ksort($payment_choices);
}

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/banking/bills_deposit/extra_actions.php';
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
	$order->bill_primary_name   = $_POST['bill_primary_name']   <> GEN_PRIMARY_NAME   ? db_prepare_input($_POST['bill_primary_name'])   : '';
	$order->bill_contact        = $_POST['bill_contact']        <> GEN_CONTACT        ? db_prepare_input($_POST['bill_contact'])        : '';
	$order->bill_address1       = $_POST['bill_address1']       <> GEN_ADDRESS1       ? db_prepare_input($_POST['bill_address1'])       : '';
	$order->bill_address2       = $_POST['bill_address2']       <> GEN_ADDRESS2       ? db_prepare_input($_POST['bill_address2'])       : '';
	$order->bill_city_town      = $_POST['bill_city_town']      <> GEN_CITY_TOWN      ? db_prepare_input($_POST['bill_city_town'])      : '';
	$order->bill_state_province = $_POST['bill_state_province'] <> GEN_STATE_PROVINCE ? db_prepare_input($_POST['bill_state_province']) : '';
	$order->bill_postal_code    = $_POST['bill_postal_code']    <> GEN_POSTAL_CODE    ? db_prepare_input($_POST['bill_postal_code'])    : '';
	$order->bill_country_code   = db_prepare_input($_POST['bill_country_code']);

	// load journal main data
	$order->id                  = ($_POST['id'] <> '') ? $_POST['id'] : ''; // will be null unless opening an existing purchase/receive
	$order->post_date           = $post_date;
	$order->period              = $period;
	$order->admin_id            = $_SESSION['admin_id'];
	$order->purchase_invoice_id = db_prepare_input($_POST['purchase_invoice_id']);	// PhreeBooks order/invoice ID
	$order->shipper_code        = db_prepare_input($_POST['shipper_code']);  // store payment method in shipper_code field
	$order->purch_order_id      = db_prepare_input($_POST['purch_order_id']);  // customer PO/Ref number
	$order->description         = constant('GENERAL_JOURNAL_' . $order->journal_id . '_DESC');
	$order->total_amount        = $currencies->clean_value(db_prepare_input($_POST['total']), DEFAULT_CURRENCY);
	$order->gl_acct_id          = $gl_acct_id;
	$order->payment_id          = db_prepare_input($_POST['payment_id']);
	$order->save_payment        = isset($_POST['save_payment']) ? true : false;

	// load item row data
	$order->item_rows[0] = array(
	  'id'      => db_prepare_input($_POST['id_1']),
	  'gl_type' => GL_TYPE,
	  'desc'    => db_prepare_input($_POST['desc_1']),
	  'total'   => $currencies->clean_value(db_prepare_input($_POST['total_1'])),
	  'acct'    => db_prepare_input($_POST['acct_1']),
	);

	// error check input
	if (!$order->period) break;	// bad post_date was submitted
	if (!$order->bill_acct_id) { // no account was selected, error
		$messageStack->add(constant('BNK_' . JOURNAL_ID . '_ERROR_NO_VENDOR'), 'error');
		$error = true;
	}
	if (!$order->item_rows) {
		$messageStack->add(GL_ERROR_NO_ITEMS, 'error');
		$error = true;
	}

	// post the receipt/payment
	if (!$error && $post_success = $order->post_ordr($action)) {
		// now create a credit memo to show a credit on customers account
		$order = new orders();
		$order->bill_short_name     = db_prepare_input($_POST['search']);
		$order->bill_acct_id        = db_prepare_input($_POST['bill_acct_id']);
		$order->bill_address_id     = db_prepare_input($_POST['bill_address_id']);
		$order->bill_primary_name   = $_POST['bill_primary_name']   <> GEN_PRIMARY_NAME   ? db_prepare_input($_POST['bill_primary_name'])   : '';
		$order->bill_contact        = $_POST['bill_contact']        <> GEN_CONTACT        ? db_prepare_input($_POST['bill_contact'])        : '';
		$order->bill_address1       = $_POST['bill_address1']       <> GEN_ADDRESS1       ? db_prepare_input($_POST['bill_address1'])       : '';
		$order->bill_address2       = $_POST['bill_address2']       <> GEN_ADDRESS2       ? db_prepare_input($_POST['bill_address2'])       : '';
		$order->bill_city_town      = $_POST['bill_city_town']      <> GEN_CITY_TOWN      ? db_prepare_input($_POST['bill_city_town'])      : '';
		$order->bill_state_province = $_POST['bill_state_province'] <> GEN_STATE_PROVINCE ? db_prepare_input($_POST['bill_state_province']) : '';
		$order->bill_postal_code    = $_POST['bill_postal_code']    <> GEN_POSTAL_CODE    ? db_prepare_input($_POST['bill_postal_code'])    : '';
		$order->bill_country_code   = db_prepare_input($_POST['bill_country_code']);

		// load journal main data
		$order->id                  = ($_POST['id'] <> '') ? $_POST['id'] : ''; // will be null unless opening an existing purchase/receive
		$order->journal_id          = (JOURNAL_ID == 20) ? 7 : 13;  // credit memo
		$order->gl_type             = (JOURNAL_ID == 20) ? 'por' : 'sos';
		$order->post_date           = $post_date;
		$order->period              = $period;
		$order->admin_id            = $_SESSION['admin_id'];
		$order->purch_order_id      = db_prepare_input($_POST['purch_order_id']);  // customer PO/Ref number
		$order->description         = constant('GENERAL_JOURNAL_' . $order->journal_id . '_DESC');
		$order->total_amount        = $currencies->clean_value(db_prepare_input($_POST['total']), DEFAULT_CURRENCY);
		$order->gl_acct_id          = (JOURNAL_ID == 20) ? AP_DEFAULT_PURCHASE_ACCOUNT : AR_DEFAULT_GL_ACCT;
		$order->item_rows[0] = array(
		  'pstd'  => '1',
		  'id'    => '',
		  'desc'  => db_prepare_input($_POST['desc_1']),
		  'total' => $currencies->clean_value(db_prepare_input($_POST['total_1'])),
		  'acct'  => db_prepare_input($_POST['acct_1']),
		);
		$post_credit = $order->post_ordr($action);
		if (!$post_credit) {
			$order = new objectInfo($_POST);
			$order->post_date = gen_db_date_short($_POST['post_date']); // fix the date to original format
			$order->id = ($_POST['id'] <> '') ? $_POST['id'] : ''; // will be null unless opening an existing purchase/receive
			$messageStack->add(GL_ERROR_NO_POST, 'error');
		}

		gen_add_audit_log(AUDIT_LOG_DESC, $order->purchase_invoice_id, $order->total_amount);
		if (DEBUG) $messageStack->write_debug();
		if ($action == 'save') {
			gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		} // else print or print_update, fall through and load javascript to call form_popup and clear form
	} else { // else there was a post error, display and re-display form
		$order = new objectInfo($_POST);
		$order->post_date = gen_db_date_short($_POST['post_date']); // fix the date to original format
		$order->id = ($_POST['id'] <> '') ? $_POST['id'] : ''; // will be null unless opening an existing purchase/receive
		$messageStack->add(GL_ERROR_NO_POST, 'error');
	}
	break;
  default:
}

/*****************   prepare to display templates  *************************/
// load the gl account beginning balance
$acct_balance  = load_cash_acct_balance($post_date, $gl_acct_id, $period);
// load gl accounts
$gl_array_list = gen_coa_pull_down();
// generate the list of gl accounts and fill js arrays for dynamic pull downs
$js_gl_array = 'var js_gl_array = new Array(' . count($gl_array_list) . ');' . chr(10);
for ($i = 0; $i < count($gl_array_list); $i++) {
  $js_gl_array .= 'js_gl_array[' . $i . '] = new dropDownData("' . $gl_array_list[$i]['id'] . '", "' . $gl_array_list[$i]['text'] . '");' . chr(10);
}
// generate address arrays for javascript
$js_arrays     = gen_build_acct_arrays();

$include_header   = true;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = true;
$include_template = 'template_main.php';
define('PAGE_TITLE', constant('BNK_DEP_' . JOURNAL_ID . '_' . strtoupper($type) . '_WINDOW_TITLE'));

?>