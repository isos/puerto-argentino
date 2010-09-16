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
//  Path: /modules/inventory/pages/adjustments/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_ADJUST_INVENTORY];
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

$glEntry             = new journal();
$glEntry->id         = ($_POST['id'] <> '') ? $_POST['id'] : '';
$glEntry->journal_id = JOURNAL_ID;
$glEntry->store_id   = isset($_POST['store_id']) ? $_POST['store_id'] : 0;
$action              = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/inventory/adjustments/extra_actions.php';
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
	$glEntry->post_date           = gen_db_date_short($_POST['post_date']);
	$glEntry->purchase_invoice_id = db_prepare_input($_POST['purchase_invoice_id']);
	$glEntry->admin_id            = $_SESSION['admin_id'];
	$sku                          = db_prepare_input($_POST['sku_1']);
	$qty                          = db_prepare_input($_POST['adj_qty']);
	$serialize_number             = db_prepare_input($_POST['serial_1']);
	$desc                         = db_prepare_input($_POST['desc_1']);
	$acct                         = db_prepare_input($_POST['acct_1']);
	$adj_reason                   = db_prepare_input($_POST['adj_reason']);
	$price                        = $currencies->clean_value($_POST['price_1']);

	// check for errors and prepare extra values
	$glEntry->period              = gen_calculate_period($glEntry->post_date);
	if (!$glEntry->period) break;

	$temp = inv_sku_inv_accounts($sku);
	$sku_inv_acct = $temp['inventory_wage'];
	if (!$sku_inv_acct) {
		$messageStack->add(INV_ERROR_SKU_INVALID, 'error');
		break;
	}

	// process the request
	$glEntry->closed             = '1'; // closes by default
	$glEntry->journal_main_array = $glEntry->build_journal_main_array();

	// build journal entry based on adding or subtracting from inventory
	if ($qty < 0) { // removing from inventory (loss, damage, etc.)
		$glEntry->journal_rows[] = array(
			'sku'              => $sku,
			'qty'              => $qty,
			'gl_type'          => 'adj',
			'serialize_number' => $serialize_number,
			'gl_account'       => $sku_inv_acct,
			'description'      => $desc,
			'credit_amount'    => '',
		);
		$glEntry->journal_rows[] = array(
			'sku'              => '',
			'qty'              => '',
			'gl_type'          => 'ttl',
			'gl_account'       => $acct,
			'description'      => $adj_reason,
			'debit_amount'     => '',
		);
	} elseif ($qty > 0) { // adding to inventory (treat like purchase/receive)
		$tot_amount = $qty * $price;
		$glEntry->journal_main_array['total_amount'] = $tot_amount;
		$glEntry->journal_rows[] = array(
			'sku'              => $sku,
			'qty'              => $qty,
			'gl_type'          => 'adj',
			'serialize_number' => $serialize_number,
			'gl_account'       => $sku_inv_acct,
			'description'      => $desc,
			'debit_amount'     => $tot_amount,
		);
		$glEntry->journal_rows[] = array(
			'sku'              => '',
			'qty'              => '',
			'gl_type'          => 'ttl',
			'gl_account'       => $acct,
			'description'      => $adj_reason,
			'credit_amount'    => $tot_amount,
		);
	} else {
		die('Cannot adjust inventory with a zero quantity'); // This is tested in javascript, should not happen
	}
	// *************** START TRANSACTION *************************
	$db->transStart();
	$glEntry->override_cogs_acct = $acct; // force cogs account to be users specified account versus default inventory account
	if ($glEntry->Post($glEntry->id ? 'edit' : 'insert')) {
		$db->transCommit();	// post the chart of account values
		gen_add_audit_log(INV_LOG_ADJ . ($action=='save' ? TEXT_SAVE : TEXT_EDIT), $sku, $qty);
		$messageStack->add_session(INV_POST_SUCCESS . $glEntry->purchase_invoice_id, 'success');
		if (DEBUG) $messageStack->write_debug();
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		// *************** END TRANSACTION *************************
	}
	$messageStack->add(GL_ERROR_NO_POST, 'error');
	$cInfo = new objectInfo($_POST);
	break;

  case 'delete':
    // security check
	if ($security_level < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	// process the request
	if ($glEntry->id) {
		$delOrd = new journal();
		$delOrd->journal($glEntry->id); // load the posted record based on the id submitted
		// *************** START TRANSACTION *************************
		$db->transStart();
		if ($delOrd->unPost('delete')) {
			$db->transCommit(); // if not successful rollback will already have been performed
			gen_add_audit_log(INV_LOG_ADJ . TEXT_DELETE, $delOrd->journal_rows[0]['sku'], $delOrd->journal_rows[0]['qty']);
			if (DEBUG) $messageStack->write_debug();
			gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
			break;
		}
	}
	$messageStack->add(GL_ERROR_NO_DELETE, 'error');
	$cInfo = new objectInfo($_POST);
	break;

  case 'edit':
    $oID = (int)$_GET['oID'];
    // security check
	if ($security_level < 2) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$cInfo = new objectInfo(array());
	$cInfo->acct_1 = INV_STOCK_DEFAULT_COS;
	break;

  default:
	$cInfo = new objectInfo(array());
	$cInfo->acct_1 = INV_STOCK_DEFAULT_COS;
}

/*****************   prepare to display templates  *************************/
// load gl accounts
$gl_array_list = gen_coa_pull_down();

$include_header   = true;
$include_footer   = true;
$include_calendar = true;
$include_template = 'template_main.php';
define('PAGE_TITLE', INV_POPUP_ADJ_WINDOW_TITLE);

?>