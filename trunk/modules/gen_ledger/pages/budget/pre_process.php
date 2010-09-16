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
//  Path: /modules/gen_ledger/pages/budget/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_GL_BUDGET];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING . 'functions/gen_ledger.php');
require(DIR_FS_MODULES . 'gen_ledger/classes/gen_ledger.php');

/**************   page specific initialization  *************************/
// determine what button was pressed, if any
$action = isset($_GET['action']) ? $_GET['action'] : $_POST['todo'];
if (!$action && $search_text <> '') $action = 'search'; // if enter key pressed and search not blank

// see what fiscal year we are looking at (assume this FY is entered for the first time)
if ($_POST['fy']) {
  $fy = $_POST['fy'];
} else {
  $result = $db->Execute("select fiscal_year from " . TABLE_ACCOUNTING_PERIODS . " where period = " . CURRENT_ACCOUNTING_PERIOD);
  $fy = $result->fields['fiscal_year'];
}
$gl_acct = isset($_POST['gl_acct']) ? $_POST['gl_acct'] : '';

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/gen_ledger/budget/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
	if ($security_level < 3) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$i = 0;
	while (true) {
	  if (!isset($_POST['budget_' . $i])) break;
	  $budget = $currencies->clean_value($_POST['budget_' . $i]);
	  $id     = $_POST['id_' . $i];
	  $sql = "update " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " set budget = " . $budget . " where id = '" . $id . "'";
	  $db->Execute($sql);
	  $i++;
	}
	gen_add_audit_log(GL_LOG_BUDGET_UPDATE);
	break;

  case 'clear_fy':
	$result  = $db->Execute("select period from " . TABLE_ACCOUNTING_PERIODS . " where fiscal_year = '" . $fy . "'");
	$periods = array();
	while (!$result->EOF) {
	  $periods[] = $result->fields['period'];
	  $result->MoveNext();
	}
    $sql = "update " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " set budget = 0 where period in (" . implode(',', $periods) . ")";
    $db->Execute($sql);
	break;

  case 'copy_fy':
	$result  = $db->Execute("select period from " . TABLE_ACCOUNTING_PERIODS . " 
	  where fiscal_year = '" . $fy . "' order by period");
	$last_fy = $db->Execute("select period from " . TABLE_ACCOUNTING_PERIODS . " 
	  where fiscal_year = '" . ($fy - 1) . "' order by period");
	while (!$result->EOF) {
	  $accounts = $db->Execute("select account_id, debit_amount - credit_amount as balance 
	    from " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " 
		where period = '" . $last_fy->fields['period'] . "'");
	  while(!$accounts->EOF) {
	    $budget = $accounts->fields['balance'] ? round($accounts->fields['balance'], $currencies->currencies[DEFAULT_CURRENCY]['decimal_places']) : 0;
	    $sql = "update " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " 
	      set budget = " . $budget . "  
		  where period = '" . $result->fields['period'] . "' and account_id = '" . $accounts->fields['account_id'] . "'";
		$db->Execute($sql);
	    $accounts->MoveNext();
	  }
	  $result->MoveNext();
	  $last_fy->MoveNext();
	}
	break;

  default:
}

/*****************   prepare to display templates  *************************/

$result  = $db->Execute("select period, start_date, end_date from " . TABLE_ACCOUNTING_PERIODS . " 
	where fiscal_year = '" . $fy . "' order by period");
$last_fy = $db->Execute("select period from " . TABLE_ACCOUNTING_PERIODS . " 
	where fiscal_year = '" . ($fy - 1) . "' order by period");
$next_fy = $db->Execute("select period from " . TABLE_ACCOUNTING_PERIODS . " 
	where fiscal_year = '" . ($fy + 1) . "' order by period");
$periods = array();
$lf_per = array();
$nf_per = array();
while (!$result->EOF) {
  $periods[$result->fields['period']] = $result->fields['period'] . ' - ' . gen_spiffycal_db_date_short($result->fields['start_date']) . ' - ' . gen_spiffycal_db_date_short($result->fields['end_date']);
  if (!$last_fy->EOF) $lf_per[$last_fy->fields['period']] = 1;
  if (!$next_fy->EOF) $nf_per[$next_fy->fields['period']] = 1;
  $result->MoveNext();
  $last_fy->MoveNext();
  $next_fy->MoveNext();
}
$result = $db->Execute("select id, period, budget from " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " 
	where account_id = '" . $gl_acct . "' and period in (" . implode(',', array_keys($periods)) . ")");
if ($gl_acct && sizeof($lf_per) > 0) {
  $last_fy = $db->Execute("select budget from " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " 
	where account_id = '" . $gl_acct . "' and period in (" . implode(',', array_keys($lf_per)) . ")");
} else {
  $next_fy = new objectInfo();
}
if ($gl_acct && sizeof($nf_per) > 0) {
  $next_fy = $db->Execute("select budget from " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " 
	where account_id = '" . $gl_acct . "' and period in (" . implode(',', array_keys($nf_per)) . ")");
} else {
  $next_fy = new objectInfo();
}
$fy_array = array();
while(!$result->EOF) {
  $fy_array[] = array(
    'id'     => $result->fields['id'], 
    'period' => $periods[$result->fields['period']],
	'prior'  => $last_fy->fields['budget'],
	'budget' => $result->fields['budget'],
	'next'   => $next_fy->fields['budget'],
  );
  $result->MoveNext();
  if (sizeof($lf_per) > 0) $last_fy->MoveNext();
  if (sizeof($nf_per) > 0) $next_fy->MoveNext();
}

$include_header   = true;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = true;
$include_template = 'template_main.php';
define('PAGE_TITLE', GL_BUDGET_HEADING_TITLE);

?>