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
//  Path: /modules/gen_ledger/pages/beg_bal/pre_process.php
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
require(DIR_FS_WORKING . 'classes/gen_ledger.php');

/**************   page specific initialization  *************************/
define('JOURNAL_ID',2);	// General Journal
$coa_types = load_coa_types();
$glEntry = new journal();
$glEntry->journal_id = JOURNAL_ID;

// retrieve the original beginning_balances
$sql = "select c.id, beginning_balance, c.description, c.account_type
	from " . TABLE_CHART_OF_ACCOUNTS . " c inner join " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " h on c.id = h.account_id
	where h.period = 1 order by c.id";
$result = $db->Execute($sql);
$glEntry->beg_bal = array();
while (!$result->EOF) {
	$glEntry->beg_bal[$result->fields['id']] = array(
		'desc' => $result->fields['description'], 
		'type' => $result->fields['account_type'],
		'type_desc' => $coa_types[$result->fields['account_type']]['text'],
		'beg_bal' => $currencies->clean_value($result->fields['beginning_balance']));
	$glEntry->affected_accounts[$result->fields['id']] = true; // build list of affected accounts to update chart history
	$result->MoveNext();
}

$action = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/gen_ledger/beg_bal/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
	if ($security_level < 3) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$total_amount = 0;
	$coa_values = $_POST['coa_value'];
	$index = 0;
	foreach ($glEntry->beg_bal as $coa_id => $values) {
		if ($coa_types[$values['type']]['asset']) { // it is a debit
			$entry = $currencies->clean_value($coa_values[$index]);
		} else { // it is a credit
			$entry = -$currencies->clean_value($coa_values[$index]);
		}
		$glEntry->beg_bal[$coa_id]['beg_bal'] = $entry;
		$total_amount += $entry;
		$index++;
	}
	// check to see if journal is still in balance
	$total_amount = $currencies->format($total_amount);
	if ($total_amount <> 0) {
		$messageStack->add(GL_ERROR_NO_BALANCE, 'error');
		break;
	}
	// *************** START TRANSACTION *************************
	$db->transStart();
	foreach ($glEntry->beg_bal as $account => $values) {
		$sql = "update " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " 
			set beginning_balance = " . $values['beg_bal'] . " 
			where period = 1 and account_id = '" . $account . "'";
		$result = $db->Execute($sql);
	}
	if (!$glEntry->update_chart_history_periods($period = 1)) { // roll the beginning balances into chart history table
		$glEntry->fail_message(GL_ERROR_UPDATE_COA_HISTORY);
	} else {
		$db->transCommit();	// post the chart of account values
		gen_add_audit_log('Enter Beginning Balances');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		// *************** END TRANSACTION *************************
	}
	$messageStack->add(GL_ERROR_NO_POST, 'error');
	break;

  default:
}

/*****************   prepare to display templates  *************************/

$include_header = true; // include header flag
$include_footer = true; // include footer flag
$include_tabs = false;
$include_calendar = false;

$include_template = 'template_main.php'; // include display template (required)
define('PAGE_TITLE', GL_HEADING_BEGINNING_BALANCES);

?>