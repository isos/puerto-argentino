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
//  Path: /modules/orders/pages/popup_status/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = (int)$_SESSION['admin_id']; // for popups, just make sure they are logged in
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'accounts/language/' . $_SESSION['language'] . '/language.php');

/**************   page specific initialization  *************************/
$id = (int)$_GET['id'];

/***************   Act on the action request   *************************/
// Load the customer status
$customer = $db->Execute("select c.type, c.inactive, c.special_terms, a.notes 
  from " . TABLE_CONTACTS . " c inner join " . TABLE_ADDRESS_BOOK . " a on c.id = a.ref_id 
  where c.id = " . $id . " and a.type like '%m'");
$notes         = str_replace(chr(10), "<br />", $customer->fields['notes']);
$type          = $customer->fields['type'] == 'v' ? 'AP' : 'AR';
$special_terms = gen_terms_to_language($customer->fields['special_terms'], $short = false, $type);
$terms         = explode(':', $customer->fields['special_terms']);
$credit_limit  = $terms[4] ? $terms[4] : constant($type . '_CREDIT_LIMIT_AMOUNT');
$due_days      = $terms[3] ? $terms[3] : constant($type . '_NUM_DAYS_DUE');
$due_date      = gen_specific_date($today, -$due_days);

// load the aged status
$today = date('Y-m-d');
$late_30 = gen_specific_date($today, ($type == 'AP') ? -AP_AGING_DATE_1 : -AR_AGING_PERIOD_1);
$late_60 = gen_specific_date($today, ($type == 'AP') ? -AP_AGING_DATE_2 : -AR_AGING_PERIOD_2);
$late_90 = gen_specific_date($today, ($type == 'AP') ? -AP_AGING_DATE_3 : -AR_AGING_PERIOD_3);
$new_data = array(
  'balance_0'  => '0',
  'balance_30' => '0',
  'balance_60' => '0',
  'balance_90' => '0',
);
  
$inv_jid = ($type == 'AP') ? '6, 7' : '12, 13';
$pmt_jid = ($type == 'AP') ? '20' : '18';
$total_outstanding = 0;
$past_due = 0;
$sql = "select id from " . TABLE_JOURNAL_MAIN . " 
	where bill_acct_id = " . $id . " and journal_id in (" . $inv_jid . ") and closed = '0'";
$open_inv = $db->Execute($sql);
//echo 'records = ' . $open_inv->RecordCount() . '<br />';
while(!$open_inv->EOF) {
  $sql = "select m.post_date, sum(i.debit_amount) as debits, sum(i.credit_amount) as credits 
    from " . TABLE_JOURNAL_MAIN . " m inner join " . TABLE_JOURNAL_ITEM . " i on m.id = i.ref_id
    where m.id = " . $open_inv->fields['id'] . " and journal_id in (" . $inv_jid . ") and i.gl_type <> 'ttl' group by m.id";
  $result = $db->Execute($sql);
  $total_billed = $result->fields['credits'] - $result->fields['debits'];
  $post_date = $result->fields['post_date'];
  $sql = "select sum(i.debit_amount) as debits, sum(i.credit_amount) as credits 
    from " . TABLE_JOURNAL_MAIN . " m inner join " . TABLE_JOURNAL_ITEM . " i on m.id = i.ref_id
    where i.so_po_item_ref_id = " . $open_inv->fields['id'] . " and m.journal_id = " . $pmt_jid . " and i.gl_type = 'pmt'";
  $result = $db->Execute($sql);
  $total_paid = $result->fields['credits'] - $result->fields['debits'];
  $balance = $total_billed - $total_paid;
  if ($type == 'AP') $balance = -$balance;

  // start the placement in aging array
  if ($post_date < $due_date) $past_due += $balance;
  if ($post_date < $late_90) {
	$new_data['balance_90'] += $balance;
    $total_outstanding += $balance;
  } elseif ($post_date < $late_60) {
	$new_data['balance_60'] += $balance;
    $total_outstanding += $balance;
  } elseif ($post_date < $late_30) {
	$new_data['balance_30'] += $balance;
    $total_outstanding += $balance;
  } elseif ($post_date < $today) {
	$new_data['balance_0']  += $balance;
    $total_outstanding += $balance;
  } // else it's in the future
  $open_inv->MoveNext();
}

// set the customer/vendor status in order of importance
if ($customer->fields['inactive']) {
  $inactive_flag = ' style="background-color:red"';
  $status_text = TEXT_INACTIVE;
} elseif ($past_due > 0) {
  $inactive_flag = ' style="background-color:yellow"';
  $status_text = ACT_HAS_PAST_DUE_AMOUNT;
} elseif ($total_outstanding > $credit_limit) {
  $inactive_flag = ' style="background-color:yellow"';
  $status_text = ACT_OVER_CREDIT_LIMIT;
} else {
  $inactive_flag = ' style="background-color:lightgreen"';
  $status_text = ACT_GOOD_STANDING;
}

/*****************   prepare to display templates  *************************/

$include_header   = false;
$include_footer   = false;
$include_tabs     = false;
$include_calendar = true;
$include_template = 'template_main.php'; // include display template (required)
define('PAGE_TITLE', constant($type . '_CONTACT_STATUS'));
?>