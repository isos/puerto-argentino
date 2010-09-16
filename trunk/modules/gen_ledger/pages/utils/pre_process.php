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
//  Path: /modules/gen_ledger/pages/utils/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_GL_UTILITIES];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING . 'functions/gen_ledger.php');
require(DIR_FS_MODULES . 'gen_ledger/classes/gen_ledger.php');

/**************   page specific initialization  *************************/
define('JOURNAL_ID',2);	// General Journal

// determine what button was pressed, if any
if (isset($_POST['cancel'])) $action = 'cancel';
if (isset($_POST['update'])) $action = 'update';
if (isset($_POST['new'])) $action = 'new';
if (isset($_POST['change'])) $action = 'change';
if (isset($_POST['purge_db'])) $action = 'purge_db';
if (isset($_POST['beg_balances'])) $action = 'beg_balances';

// see what fiscal year we are looking at (assume this FY is entered for the first time)
if ($_POST['fy']) {
	$fy = $_POST['fy'];
} else {
	$result = $db->Execute("select fiscal_year from " . TABLE_ACCOUNTING_PERIODS . " where period = " . CURRENT_ACCOUNTING_PERIOD);
	$fy = $result->fields['fiscal_year'];
}

// find the highest posted period to disallow accounting period changes
$result = $db->Execute("select max(period) as period from " . TABLE_JOURNAL_MAIN);
$max_period = ($result->fields['period'] > 0) ? $result->fields['period'] : 0;
// find the highest fiscal year and period in the system
$result = $db->Execute("select max(fiscal_year) as fiscal_year, max(period) as period from " . TABLE_ACCOUNTING_PERIODS);
$highest_fy = ($result->fields['fiscal_year'] > 0) ? ($result->fields['fiscal_year']) : '';
$highest_period = ($result->fields['period'] > 0) ? ($result->fields['period']) : '';
$period = CURRENT_ACCOUNTING_PERIOD;

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/gen_ledger/utils/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'update':
	if ($security_level < 3) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	// propagate into remaining fiscal years if the last date was changed.
	$fy_array = array();
	$x = 0;
	while(isset($_POST['start_' . $x])) {
		$update_period = db_prepare_input($_POST['per_' . $x]);
		$fy_array = array(
			'start_date' =>gen_db_date_short(db_prepare_input($_POST['start_' . $x])),
			'end_date' =>gen_db_date_short(db_prepare_input($_POST['end_' . $x])));
		db_perform(TABLE_ACCOUNTING_PERIODS, $fy_array, 'update', 'period = ' . (int)$update_period);
		$x++;
	}
	// see if there is a disconnect between fiscal years
	$next_period = $update_period + 1;
	$next_start_date = date('Y-m-d', strtotime($fy_array['end_date']) + (60 * 60 * 24));
	$result = $db->Execute("select start_date from " . TABLE_ACCOUNTING_PERIODS . " where period = " . $next_period);
	if ($result->RecordCount() > 0) { // next FY exists, check it
		if ($next_start_date <> $result->fields['start_date']) {
			$fy_array = array('start_date' =>$next_start_date);
			db_perform(TABLE_ACCOUNTING_PERIODS, $fy_array, 'update', 'period = ' . (int)$next_period);
			$messageStack->add(GL_ERROR_FISCAL_YEAR_SEQ, 'caution');
			$fy++;
		}
	}
	gen_add_audit_log(GL_LOG_FY_UPDATE . TEXT_UPDATE);
	break;

  case 'new':
	if ($security_level < 2) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$result = $db->Execute("select * from " . TABLE_ACCOUNTING_PERIODS . " where period = " . $highest_period);
	$next_fy         = $result->fields['fiscal_year'] + 1;
	$next_period     = $result->fields['period'] + 1;
	$next_start_date = date('Y-m-d', strtotime($result->fields['end_date']) + (60 * 60 * 24));
	$highest_period  = validate_fiscal_year($next_fy, $next_period, $next_start_date);
	build_and_check_account_history_records();
	// *************** roll account balances into next fiscal year *************************
    $glEntry = new journal();
	$result = $db->Execute("select id from " . TABLE_CHART_OF_ACCOUNTS);
	while (!$result->EOF) {
		$glEntry->affected_accounts[$result->fields['id']] = 1;
		$result->MoveNext();
	}
	$glEntry->update_chart_history_periods(CURRENT_ACCOUNTING_PERIOD); // from current period through new fiscal year
	$fy = $next_fy;	// set the pointer to open the fiscal year added
	gen_add_audit_log(GL_LOG_FY_UPDATE . TEXT_ADD);
	break;

  case "change":
	// retrieve the desired period and update the system default values.
	if ($security_level < 3) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$period = (int)db_prepare_input($_POST['period']);
	if ($period <= 0 || $period > $highest_period) {
		$messageStack->add(GL_ERROR_BAD_ACCT_PERIOD, 'error');
		break;
	}
	$result = $db->Execute("select start_date, end_date from " . TABLE_ACCOUNTING_PERIODS . " where period = " . $period);
	$db->Execute("update " . TABLE_CONFIGURATION . " set configuration_value = " . $period . " 
		where configuration_key = 'CURRENT_ACCOUNTING_PERIOD'");
	$db->Execute("update " . TABLE_CONFIGURATION . " set configuration_value = '" . $result->fields['start_date'] . "' 
		where configuration_key = 'CURRENT_ACCOUNTING_PERIOD_START'");
	$db->Execute("update " . TABLE_CONFIGURATION . " set configuration_value = '" . $result->fields['end_date'] . "' 
		where configuration_key = 'CURRENT_ACCOUNTING_PERIOD_END'");
	gen_add_audit_log(GEN_LOG_PERIOD_CHANGE);
	gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
	break;

case 'beg_balances': // Enter beginning balances
	gen_redirect(html_href_link(FILENAME_DEFAULT, 'cat=gen_ledger&amp;module=beg_bal', 'SSL'));
	break;

case 'purge_db':
	if ($security_level < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	if ($_POST['purge_confirm'] == 'purge') {
		$db->Execute("TRUNCATE TABLE " . TABLE_JOURNAL_MAIN);
		$db->Execute("TRUNCATE TABLE " . TABLE_JOURNAL_ITEM);
		$db->Execute("TRUNCATE TABLE " . TABLE_ACCOUNTS_HISTORY);
		$db->Execute("TRUNCATE TABLE " . TABLE_INVENTORY_HISTORY);
		$db->Execute("TRUNCATE TABLE " . TABLE_INVENTORY_COGS_OWED);
		$db->Execute("TRUNCATE TABLE " . TABLE_INVENTORY_COGS_USAGE);
		$db->Execute("TRUNCATE TABLE " . TABLE_RECONCILIATION);
		$db->Execute("TRUNCATE TABLE " . TABLE_SHIPPING_LOG);
		$db->Execute("update " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " set beginning_balance = 0, debit_amount = 0, credit_amount = 0");
		$db->Execute("update " . TABLE_INVENTORY . " set quantity_on_hand = 0, quantity_on_order = 0, quantity_on_sales_order = 0");
		$messageStack->add_session(GL_UTIL_PURGE_CONFIRM, 'success');
	} else {

/********************************** DELETE ME **********************************
require_once (DIR_FS_MODULES . 'gen_ledger/classes/gen_ledger.php');
$result = $db->Execute("select id from " . TABLE_JOURNAL_MAIN . " order by id");
$db->transStart();
echo 're-posting id = ';
while (!$result->EOF) {
echo ', ' . $result->fields['id'];
$gl_entry = new journal($result->fields['id']);
$gl_entry->remove_cogs_rows(); // they will be regenerated during the re-post
if (!$gl_entry->Post('edit', true)) {
	$db->transRollback();
	die('<br /><br />Failed Dave\'s little experiment');
}
$result->MoveNext();
}
$db->transCommit();
echo '<br /><br />Done!';
exit();
/********************************** END DELETE ME **********************************/

		$messageStack->add_session(GL_UTIL_PURGE_FAIL, 'caution');
	}
	gen_add_audit_log(GL_LOG_PURGE_DB);
	gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
	break;

  default:
}

/*****************   prepare to display templates  *************************/
$result = $db->Execute("select period, start_date, end_date from " . TABLE_ACCOUNTING_PERIODS . " where fiscal_year = " . $fy);
$fy_array = array();
while(!$result->EOF) {
	$fy_array[$result->fields['period']] = array('start' => $result->fields['start_date'], 'end' => $result->fields['end_date']);
	$result->MoveNext();
}

$include_header = true; // include header flag
$include_footer = true; // include footer flag
$include_tabs = false;
$include_calendar = true;

$include_template = 'template_main.php'; // include display template (required)
define('PAGE_TITLE', GL_UTIL_HEADING_TITLE);

?>