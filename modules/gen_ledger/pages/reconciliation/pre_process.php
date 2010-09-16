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
//  Path: /modules/gen_ledger/pages/reconciliation/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_ACCT_RECONCILIATION];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING . 'functions/banking.php');
require(DIR_FS_WORKING . 'classes/banking.php');

/**************   page specific initialization  *************************/
// retrieve the current status of this periods reconciliation
$period = $_GET['search_period'] ? $_GET['search_period'] : CURRENT_ACCOUNTING_PERIOD;
if ($period == 'all') {
	$messageStack->add(BNK_ERROR_PERIOD_NOT_ALL, 'error');
	$period = CURRENT_ACCOUNTING_PERIOD;
}
$gl_account = isset($_POST['gl_account']) ? $_POST['gl_account'] : AR_SALES_RECEIPTS_ACCOUNT;
$cleared_items = array();
$uncleared_items = array();

$action = isset($_GET['action']) ? $_GET['action'] : $_POST['todo'];

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/banking/reconciliation/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
	if ($security_level < 3) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$statement_balance = db_prepare_input($currencies->clean_value($_POST['start_balance']));
	if (is_array($_POST['ref'])) for ($i = 0; $i < count($_POST['ref']); $i++) {
		$value_list = explode(':', $_POST['ref'][$i]);
		if (isset($_POST['id'][$i])) {
			foreach ($value_list as $id) $cleared_items[] = $id;
		} else {
			foreach ($value_list as $id) $uncleared_items[] = $id;
		}
	}

	// see if this is an update or new entry
	$sql = "select id from " . TABLE_RECONCILIATION . " where period = " . $period . " and gl_account = '" . $gl_account . "'";
	$result = $db->Execute($sql);
	if ($result->RecordCount() == 0) {
		$sql = "insert into " . TABLE_RECONCILIATION . " set
			period = " . $period . ", 
			gl_account = '" . $gl_account . "', 
			statement_balance = " . $statement_balance . ", 
			cleared_items = '" . serialize($cleared_items) . "'";
	} else {
		$sql = "update " . TABLE_RECONCILIATION . " set
			statement_balance = " . $statement_balance . ", 
			cleared_items = '" . serialize($cleared_items) . "' 
			where period = " . $period . " and gl_account = '" . $gl_account . "'";
	}
//	$result = $db->Execute($sql);
	// set closed flag to '1' for all records that were checked
	if (count($cleared_items)) {
		$sql = "update " . TABLE_JOURNAL_MAIN . " set closed = '1' where id in (" . implode(',', $cleared_items) . ")";
//		$result = $db->Execute($sql);
	}

	// set closed flag to '0' for all records that were unchecked
	if (count($uncleared_items)) {
		$sql = "update " . TABLE_JOURNAL_MAIN . " set closed = '0' where id in (" . implode(',', $uncleared_items) . ")";
//		$result = $db->Execute($sql);
	}
	$messageStack->add(GL_RECON_POST_SUCCESS,'success');
	gen_add_audit_log(GL_LOG_ACCT_RECON . $period, $gl_account);
	break;
  default:
}

/*****************   prepare to display templates  *************************/
//
$bank_list = array();
$statement_balance = $currencies->format(0);

// load the payments and deposits that are open
$fiscal_dates = gen_calculate_fiscal_dates($period);
$end_date = $fiscal_dates['end_date'];
$sql = "select i.id, m.post_date, i.debit_amount, i.credit_amount, m.purchase_invoice_id, m.bill_primary_name 
	from " . TABLE_JOURNAL_MAIN . " m inner join " . TABLE_JOURNAL_ITEM . " i on m.id = i.ref_id
	where i.gl_account = '" . $gl_account . "' and i.reconciled = '0' and m.post_date <= '" . $fiscal_dates['end_date'] . "'";
$result = $db->Execute($sql);
while (!$result->EOF) {
  $bank_list[$result->fields['id']] = array(
	'post_date' => $result->fields['post_date'],
	'reference' => $result->fields['purchase_invoice_id'],
	'dep_amount' => $result->fields['debit_amount'],
	'pmt_amount' => $result->fields['credit_amount'],
	'payment' => ($result->fields['debit_amount'] ? 0 : 1), // payment else deposit
	'name' => $result->fields['bill_primary_name'],
	'cleared' => 0);
  $result->MoveNext();
}

// check to see if in partial reconciliation, if so add closed items
$sql = "select statement_balance, cleared_items from " . TABLE_RECONCILIATION . " where period = " . $period . " and gl_account = '" . $gl_account . "'";
$result = $db->Execute($sql);
if ($result->RecordCount() <> 0) { // there are current cleared items in the present accounting period (edit)
	$statement_balance = $currencies->format($result->fields['statement_balance']);
	$cleared_items = unserialize($result->fields['cleared_items']);
	// load information from general journal
	if (count($cleared_items) > 0) {
		$sql = "select i.id, m.post_date, i.debit_amount, i.credit_amount, m.purchase_invoice_id, m.bill_primary_name 
			from " . TABLE_JOURNAL_MAIN . " m inner join " . TABLE_JOURNAL_ITEM . " i on m.id = i.ref_id
			where i.gl_account = '" . $gl_account . "' and i.id in (" . implode(',', $cleared_items) . ")";
		$result = $db->Execute($sql);
		while (!$result->EOF) {
			if (isset($bank_list[$result->fields['id']])) { // record exists, mark as cleared (shouldn't happen)
				$bank_list[$result->fields['id']]['cleared'] = 1;
			} else {
				$bank_list[$result->fields['id']] = array (
					'post_date' => $result->fields['post_date'],
					'reference' => $result->fields['purchase_invoice_id'],
					'dep_amount' => $result->fields['debit_amount'],
					'pmt_amount' => $result->fields['credit_amount'],
					'payment' => ($result->fields['debit_amount'] ? 0 : 1), // payment or deposit
					'name' => $result->fields['bill_primary_name'],
					'cleared' => 1);
			}
			$result->MoveNext();
		} 
	}
}

// combine by reference number
$combined_list = array();
if (is_array($bank_list)) foreach ($bank_list as $id => $value) {
	$index = ($value['payment'] ? 'p_' : 'd_') . $value['reference'];
	if (isset($combined_list[$index])) { // the reference already exists
		$combined_list[$index]['dep_amount'] += $value['dep_amount'];
		$combined_list[$index]['pmt_amount'] += $value['pmt_amount'];
		$combined_list[$index]['ref_id'] .= ':' . $id;	// add id to the list
		$combined_list[$index]['name'] = $value['payment'] ? TEXT_MULTIPLE_PAYMENTS : TEXT_MULTIPLE_DEPOSITS;
		if ($combined_list[$index]['cleared'] && $value['cleared']) {
			$combined_list[$index]['cleared'] = 1;	// check cleared box if all cleared flags set to this point
		} else {
			$combined_list[$index]['cleared'] = 0;	// uncheck cleared box if any one not set to this point
		}
	} else {
		$combined_list[$index]['dep_amount'] = $value['dep_amount'];
		$combined_list[$index]['pmt_amount'] = $value['pmt_amount'];
		$combined_list[$index]['ref_id'] = $id;	// add id to the list
		$combined_list[$index]['name'] = $value['name'];
		$combined_list[$index]['cleared'] = $value['cleared'];
	}
	$combined_list[$index]['post_date'] = $value['post_date'];
	$combined_list[$index]['reference'] = $value['reference'];
	$combined_list[$index]['payment'] = $value['payment'];
}

// sort by user choice for display
$sort_value = explode('-',$_GET['list_order']);
switch ($sort_value[0]) {
	case 'dep_amount': define('RECON_SORT_KEY','dep_amount'); break;
	case 'pmt_amount': define('RECON_SORT_KEY','pmt_amount'); break;
	case 'post_date': define('RECON_SORT_KEY','post_date'); break;
	default:
	case 'reference': define('RECON_SORT_KEY','reference'); break;
}
define('RECON_SORT_DESC', isset($sort_value[1]) ? true : false);
function my_sort($a, $b) {
    if ($a[RECON_SORT_KEY] == $b[RECON_SORT_KEY]) return 0;
	if (RECON_SORT_DESC) {
    	return ($a[RECON_SORT_KEY] > $b[RECON_SORT_KEY]) ? -1 : 1;
	} else {
    	return ($a[RECON_SORT_KEY] < $b[RECON_SORT_KEY]) ? -1 : 1;
	}
}
usort($combined_list, "my_sort");

// load the gl account end of period balance
$sql = "select beginning_balance + debit_amount - credit_amount as gl_balance 
	from " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " where account_id = '" . $gl_account . "' and period = " . $period;
$result = $db->Execute($sql);
$gl_balance = $currencies->format($result->fields['gl_balance']);

// build the array of cash accounts
$result = $db->Execute("select id, description from " . TABLE_CHART_OF_ACCOUNTS. " where account_type = 20 order by id");
$account_array = array();
while (!$result->EOF) {
  $text_value = $result->fields['id'] . ' : ' . $result->fields['description'];
  $account_array[] = array('id' => $result->fields['id'], 'text' => $text_value);
  $result->MoveNext();
}

$include_header = true; // include header flag
$include_footer = true; // include footer flag
$include_tabs = false;
$include_calendar = false;

$include_template = 'template_main.php'; // include display template (required)
define('PAGE_TITLE', BOX_BANKING_ACCOUNT_RECONCILIATION);

?>