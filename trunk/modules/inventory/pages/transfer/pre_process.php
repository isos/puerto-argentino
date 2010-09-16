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
//  Path: /modules/inventory/pages/transfer/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_TRANSFER_INVENTORY];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'gen_ledger/language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'gen_ledger/classes/gen_ledger.php');
require(DIR_FS_WORKING . 'functions/inventory.php');

/**************   page specific initialization  *************************/
define('JOURNAL_ID',16);	// Adjustment Journal
define('GL_TYPE', '');

$error     = false;
$post_date = ($_POST['post_date']) ? gen_db_date_short($_POST['post_date']) : date('Y-m-d');
$period    = gen_calculate_period($post_date);
if (!$period) $error = true;
$action    = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/inventory/transfer/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
    // security check
	if ($security_level < 2) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	// retrieve and clean input values
	$sku             = db_prepare_input($_POST['sku_1']);
	$qty             = db_prepare_input($_POST['adj_qty']);
	$serial_number   = db_prepare_input($_POST['serial_1']);
	$desc            = db_prepare_input($_POST['desc_1']);
	$acct            = db_prepare_input($_POST['acct_1']);
	$inv_acct        = $_POST['inv_acct']; // account inventory item is placed
	$inv_type        = $_POST['inv_type'];
	$source_store_id = $_POST['source_store_id'];
	$dest_store_id   = $_POST['dest_store_id'];
	// test for errors
	if (strpos(COG_ITEM_TYPES, $inv_type) === false) {
		$messageStack->add(INV_XFER_ERROR_NO_COGS_REQD, 'error');
		$error = true;
	}
	// quantity needs to be greater than zero
	if ($qty < 0) {
		$messageStack->add(INV_XFER_ERROR_QTY_ZERO, 'error');
		$error = true;
	}
	// source and dest need to be different
	if ($source_store_id == $dest_store_id) {
		$messageStack->add(INV_XFER_ERROR_SAME_STORE_ID, 'error');
		$error = true;
	}
	// source store needs to have enough
	$source_stock = load_store_stock($sku, $source_store_id);
	if ($source_stock < $qty) {
		$messageStack->add(INV_XFER_ERROR_NOT_ENOUGH_SKU, 'error');
		$error = true;
	}
	// process the request, first subtract from the source store
	if (!$error) {
	  $glEntry                      = new journal();
	  $glEntry->id                  = ''; // all transactions are considered new
	  $glEntry->journal_id          = JOURNAL_ID;
	  $glEntry->post_date           = $post_date;
	  $glEntry->period              = $period;
	  $glEntry->store_id            = $source_store_id;
	  $glEntry->admin_id            = $_SESSION['admin_id'];
	  $glEntry->purchase_invoice_id = db_prepare_input($_POST['purchase_invoice_id']);
	  $glEntry->closed              = '1'; // closes by default
	  $glEntry->override_cogs_acct  = $acct; // force cogs account to be users specified account versus default inventory account

	  $glEntry->journal_main_array  = $glEntry->build_journal_main_array();
	  $glEntry->journal_rows[]      = array(
		'sku'              => $sku,
		'qty'              => -$qty,
		'gl_type'          => 'adj',
		'serialize_number' => $serial_number,
		'gl_account'       => $inv_acct,
		'description'      => $desc,
		'credit_amount'    => '',
	  );
	  $glEntry->journal_rows[]      = array(
		'sku'              => '',
		'qty'              => '',
		'gl_type'          => 'ttl',
		'gl_account'       => $acct,
		'description'      => sprintf(INV_LOG_TRANSFER, $source_store_id, $dest_store_id),
		'debit_amount'     => '',
	  );
	  // *************** START TRANSACTION *************************
	  $db->transStart();
	  if (!$glEntry->Post('insert')) $error = true;
	  // Extract the cost to use as the total amount for the next adjustment
	  foreach ($glEntry->journal_rows as $value) {
	    if ($value['gl_type'] == 'cog') $tot_amount = $value['credit_amount'] + $value['debit_amount'];
	  }
	  // now make another adjustment to the new store (treat like purchase/receive)
	  $glEntry                      = new journal();
	  $glEntry->id                  = ''; // all transactions are considered new
	  $glEntry->journal_id          = JOURNAL_ID;
	  $glEntry->post_date           = $post_date;
	  $glEntry->period              = $period;
	  $glEntry->store_id            = $dest_store_id;
	  $glEntry->admin_id            = $_SESSION['admin_id'];
	  $glEntry->purchase_invoice_id = db_prepare_input($_POST['purchase_invoice_id']);
	  $glEntry->closed              = '1'; // closes by default
	  $glEntry->override_cogs_acct  = $acct;

	  $glEntry->journal_main_array  = $glEntry->build_journal_main_array();
	  $glEntry->journal_main_array['total_amount'] = $tot_amount;
	  $glEntry->journal_rows[] = array(
		'sku'              => $sku,
		'qty'              => $qty,
		'gl_type'          => 'adj',
		'serialize_number' => $serial_number,
		'gl_account'       => $inv_acct,
		'description'      => $desc,
		'debit_amount'     => $tot_amount,
	  );
	  $glEntry->journal_rows[] = array(
		'sku'              => '',
		'qty'              => '',
		'gl_type'          => 'ttl',
		'gl_account'       => $acct,
		'description'      => sprintf(INV_LOG_TRANSFER, $source_store_id, $dest_store_id),
		'credit_amount'    => $tot_amount,
	  );
	  if (!$error) {
	    if ($glEntry->Post('insert')) {
		  $db->transCommit();
	      gen_add_audit_log(sprintf(INV_LOG_TRANSFER, $source_store_id, $dest_store_id), $sku, $qty);
		  $messageStack->add_session(sprintf(INV_XFER_SUCCESS, $qty, $sku),'success');
		  if (DEBUG) $messageStack->write_debug();
		  gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		  // *************** END TRANSACTION *************************
	    }
	  }
	  $db->transRollback();
	}
	$messageStack->add(GL_ERROR_NO_POST, 'error');
	$cInfo = new objectInfo($_POST);
	break;

  case 'delete':
  case 'edit':
  default:
	$cInfo = new objectInfo(array());
}

/*****************   prepare to display templates  *************************/
// load gl accounts
$gl_array_list = gen_coa_pull_down();

$include_header   = true;
$include_footer   = true;
$include_calendar = true;
$include_template = 'template_main.php';
define('PAGE_TITLE', BOX_INV_TRANSFER);

?>