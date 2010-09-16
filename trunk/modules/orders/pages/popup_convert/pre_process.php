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
//  Path: /modules/orders/pages/popup_convert/pre_process.php
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
$id = (isset($_GET['oID']) ? $_GET['oID'] : $_POST['id']);
$action = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

$error = false;

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/orders/popup_convert/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
    $selection = $_POST['conv_type'];
	$so_num    = $_POST['so_num'];
	$inv_num   = $_POST['inv_num'];

	require_once(DIR_FS_MODULES . 'gen_ledger/language/' . $_SESSION['language'] . '/language.php');
	require_once(DIR_FS_MODULES . 'gen_ledger/classes/gen_ledger.php');

	if ($selection == 'inv') { // invoice
	  define('JOURNAL_ID',12);
	  define('GL_TYPE','sos');
	  $purchase_invoice_id = $inv_num;
	} else { // sales order
	  define('JOURNAL_ID',10);
	  define('GL_TYPE','soo');
	  $purchase_invoice_id = $so_num;
	}
	$order = new journal($id);
	// change some values to make it look like a new sales order/invoice
	$order->journal_id = JOURNAL_ID;
	$order->journal_main_array['journal_id'] = JOURNAL_ID;
	$order->id = '';
	$order->journal_main_array['id'] = '';
	$order->post_date = date('Y-m-d',time()); // make post date today
	$order->period = gen_calculate_period($order->post_date);
	$order->terminal_date = $order->post_date; // make ship date the same as post date
	$order->journal_main_array['description'] = constant('GENERAL_JOURNAL_' . JOURNAL_ID . '_DESC');
	$order->journal_main_array['post_date'] = date('Y-m-d',time());
	for ($i = 0; $i < sizeof($order->journal_rows); $i++) {
	  $order->journal_rows[$i]['id'] = '';
	  $order->journal_rows[$i]['so_po_item_ref_id'] = '';
	  if ($order->journal_rows[$i]['gl_type'] == 'soo') $order->journal_rows[$i]['gl_type'] = GL_TYPE;
	}
	// ***************************** START TRANSACTION *******************************
	$db->transStart();
	if ($purchase_invoice_id) {
	  $order->journal_main_array['purchase_invoice_id'] = $purchase_invoice_id;
	  $order->purchase_invoice_id = $purchase_invoice_id;
	} else {
	  $order->purchase_invoice_id = '';
	  if (!$order->validate_purchase_invoice_id()) {
	  	$error = true;
		break;
	  }
	}
	if (!$order->Post('insert')) $error = true;
    if ($order->purchase_invoice_id == '') {
	  if (!$order->increment_purchase_invoice_id()) $error = true;
	}
	if (!$error) {
	  gen_add_audit_log(constant('ORD_TEXT_' . JOURNAL_ID . '_WINDOW_TITLE') . ' - ' . TEXT_ADD, $order->purchase_invoice_id, $order->total_amount);
	  // set the closed flag on the quote
	  $result = $db->Execute("update " . TABLE_JOURNAL_MAIN . " set closed = '1' where id = " . $id);
	  $db->transCommit();	// finished successfully
	  // ***************************** END TRANSACTION *******************************
	}
	break;
  default:
}

/*****************   prepare to display templates  *************************/
$include_header   = false;
$include_footer   = false;
$include_tabs     = false;
$include_calendar = false;
$include_template = 'template_main.php';
define('PAGE_TITLE', ORD_CONVERT_TO_SO_INV);
?>