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
//  Path: /modules/banking/pages/register/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_ACCT_REGISTER];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');

/**************   page specific initialization  *************************/
// retrieve the current status of this periods register
$period = $_GET['search_period'] ? $_GET['search_period'] : CURRENT_ACCOUNTING_PERIOD;
if ($period == 'all') $period = CURRENT_ACCOUNTING_PERIOD; // don't allow the all option
$gl_account = isset($_POST['gl_account']) ? $_POST['gl_account'] : AR_SALES_RECEIPTS_ACCOUNT;
$action = isset($_GET['action']) ? $_GET['action'] : $_POST['todo'];

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/banking/register/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  default:
}

/*****************   prepare to display templates  *************************/
// load the gl account beginning balance
$sql = "select beginning_balance from " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " 
	where account_id = '" . $gl_account . "' and period = " . $period;
$result = $db->Execute($sql);
$beginning_balance = $result->fields['beginning_balance'];

// load the payments and deposits for the current period
$bank_list = array();
$sql = "select m.id, m.journal_id, m.post_date, m.total_amount, m.purchase_invoice_id, m.bill_primary_name, 
	i.debit_amount, i.credit_amount
	from " . TABLE_JOURNAL_MAIN . " m inner join " . TABLE_JOURNAL_ITEM . " i on m.id = i.ref_id
	where m.period = " . $period . " and i.gl_account = '" . $gl_account . "' 
	order by m.post_date, m.journal_id";
$result = $db->Execute($sql);
while (!$result->EOF) {
  switch ($result->fields['journal_id']) {
	case  2:
	case 18:
	case 20:
	  $deposit_amount    = $result->fields['debit_amount'];
	  $withdrawal_amount = $result->fields['credit_amount'];
	  break;
	default:
	  $messageStack->add('You have an entry in a cash account that shouldn\'t be there.','error');
  }
  $bank_list[] = array(
	'post_date'  => $result->fields['post_date'],
	'reference'  => $result->fields['purchase_invoice_id'],
	'dep_amount' => $deposit_amount,
	'pmt_amount' => $withdrawal_amount,
	'name'       => $result->fields['bill_primary_name']);
  $result->MoveNext();
}

// build the array of cash accounts
$result = $db->Execute("select id, description from " . TABLE_CHART_OF_ACCOUNTS. " where account_type = 0 order by id");
$account_array = array();
while (!$result->EOF) {
  $text_value = $result->fields['id'] . ' : ' . $result->fields['description'];
  $account_array[] = array('id' => $result->fields['id'], 'text' => $text_value);
  $result->MoveNext();
}

$include_header   = true;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = false;
$include_template = 'template_main.php'; // include display template (required)
define('PAGE_TITLE', BOX_BANKING_BANK_ACCOUNT_REGISTER);

?>