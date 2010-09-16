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
//  Path: /modules/banking/functions/banking.php
//

function fill_paid_invoice_array($id, $account_id, $type = 'c') {
	// to build this data array, all current open invoices need to be gathered and then the paid part needs
	// to be applied along with discounts taken by row.
	global $db, $currencies;
	$negate = ((JOURNAL_ID == 20 && $type == 'c') || (JOURNAL_ID == 18 && $type == 'v')) ? true : false;

	// first read all currently open invoices and the payments of interest and put into an array
	$sql = "select distinct so_po_item_ref_id from " . TABLE_JOURNAL_ITEM . " where ref_id = " . $id;
	$result = $db->Execute($sql);
	$paid_indeces = array();
	while (!$result->EOF) {
		if ($result->fields['so_po_item_ref_id']) $paid_indeces[] = $result->fields['so_po_item_ref_id'];
		$result->MoveNext();
	}
	switch ($type) {
		case 'c': $search_journal = '(12, 13)'; break;
		case 'v': $search_journal = '(6, 7)';   break;
		default: return false;
	}
	$sql = "select id, journal_id, post_date, terms, purch_order_id, purchase_invoice_id, total_amount, gl_acct_id 
		from " . TABLE_JOURNAL_MAIN . " 
		where (journal_id in " . $search_journal . " and closed = '0' and bill_acct_id = " . $account_id . ")";
	if (sizeof($paid_indeces) > 0) $sql .= " or (id in (" . implode(',',$paid_indeces) . ") and closed = '0')";
	$sql .= " order by post_date";
	$result = $db->Execute($sql);
	$open_invoices = array();
	while (!$result->EOF) {
		if ($result->fields['journal_id'] == 7 || $result->fields['journal_id'] == 13) {
		  $result->fields['total_amount'] = -$result->fields['total_amount'];
		}
		$result->fields['total_amount'] -= fetch_partially_paid($result->fields['id']);
		$result->fields['description']   = $result->fields['purch_order_id'];
		$result->fields['discount']      = '';
		$result->fields['amount_paid']   = '';
		$open_invoices[$result->fields['id']] = $result->fields;
		$result->MoveNext();
	}
	// next read the record of interest and add/adjust open invoice array with amounts
	$sql = "select id, ref_id, so_po_item_ref_id, gl_type, description, debit_amount, credit_amount, gl_account 
		from " . TABLE_JOURNAL_ITEM . " where ref_id = " . $id;
	$result = $db->Execute($sql);
	while (!$result->EOF) {
		$amount = ($result->fields['debit_amount']) ? $result->fields['debit_amount'] : $result->fields['credit_amount'];
		if ($negate) $amount = -$amount;
		$index = $result->fields['so_po_item_ref_id'];
		switch ($result->fields['gl_type']) {
		  case 'dsc': // it's the discount field
			$open_invoices[$index]['discount']      = $amount;
			$open_invoices[$index]['amount_paid']  -= $amount;
			break;
		  case 'chk':
		  case 'pmt': // it's the payment field
			$open_invoices[$index]['total_amount'] += $amount;
			$open_invoices[$index]['description']   = $result->fields['description'];
			$open_invoices[$index]['amount_paid']   = $amount;
			break;
		  case 'ttl':
			$payment_fields = $result->fields['description']; // payment details
		  default:
		}
		$result->MoveNext();
	}
	ksort($open_invoices);

	$balance   = 0;
	$index     = 0;
	$item_list = array();
	foreach ($open_invoices as $key => $line_item) {
		// fetch some information about the invoice
		$sql = "select id, post_date, terms, purchase_invoice_id, purch_order_id, gl_acct_id, waiting  
			from " . TABLE_JOURNAL_MAIN . " where id = " . $key;
		$result = $db->Execute($sql);
		$due_dates = calculate_terms_due_dates($result->fields['post_date'], $result->fields['terms'], ($type == 'v' ? 'AP' : 'AR'));
		if ( $negate) {
		  $line_item['total_amount'] = -$line_item['total_amount'];
		  $line_item['discount']     = -$line_item['discount'];
		  $line_item['amount_paid']  = -$line_item['amount_paid'];
		}
		$balance += $line_item['total_amount'];

		$item_list[] = array(
			'id'                  => $result->fields['id'],
			'waiting'             => $result->fields['waiting'],
			'purchase_invoice_id' => $result->fields['purchase_invoice_id'],
			'purch_order_id'      => $result->fields['purch_order_id'],
			'percent'             => $due_dates['discount'],
			'early_date'          => gen_spiffycal_db_date_short($due_dates['early_date']),
			'net_date'            => gen_spiffycal_db_date_short($due_dates['net_date']),
			'total_amount'        => $currencies->format($line_item['total_amount']),
			'gl_acct_id'          => $result->fields['gl_acct_id'],
			'description'         => $line_item['description'],
			'discount'            => $line_item['discount']    ? $currencies->format($line_item['discount']) : '',
			'amount_paid'         => $line_item['amount_paid'] ? $currencies->format($line_item['amount_paid']) : '',
		);
		$index++;
	}
    return array('balance' => $balance, 'payment_fields' => $payment_fields, 'invoices' => $item_list);
}

function fetch_partially_paid($id, $journal = JOURNAL_ID) {
	global $db;
	$sql = "select sum(i.debit_amount) as debit, sum(i.credit_amount) as credit 
		from " . TABLE_JOURNAL_MAIN . " m inner join " . TABLE_JOURNAL_ITEM . " i on m.id = i.ref_id 
		where m.journal_id in (18, 20) and i.so_po_item_ref_id = " . $id . " group by m.journal_id";
	$result = $db->Execute($sql);
	if ($result->fields['debit']) {
		return $result->fields['debit'];
	} elseif ($result->fields['credit']) {
		return $result->fields['credit'];
	} else {
		return 0;
	}
}

function calculate_terms_due_dates($post_date, $terms_encoded, $type = 'AR') {
  $terms = explode(':', $terms_encoded);
  $date_details = gen_get_dates($post_date);
  $result = array();
  switch ($terms[0]) {
	default:
	case '0': // Default terms
		$result['discount'] = constant($type . '_PREPAYMENT_DISCOUNT_PERCENT') / 100;
		$result['net_date'] = gen_specific_date($post_date, constant($type . '_NUM_DAYS_DUE'));
		if ($result['discount'] <> 0) {
		  $result['early_date'] = gen_specific_date($post_date, constant($type . '_PREPAYMENT_DISCOUNT_DAYS'));
		} else {
		  $result['early_date'] = gen_specific_date($post_date, 1000); // move way out
		}
		break;
	case '1': // Cash on Delivery (COD)
	case '2': // Prepaid
		$result['discount']   = 0;
		$result['early_date'] = $post_date;
		$result['net_date']   = $post_date;
		break;
	case '3': // Special terms
		$result['discount']   = $terms[1] / 100;
		$result['early_date'] = gen_specific_date($post_date, $terms[2]);
		$result['net_date']   = gen_specific_date($post_date, $terms[3]);
		break;
	case '4': // Due on day of next month
		$result['discount']   = $terms[1] / 100;
		$result['early_date'] = gen_specific_date($post_date, $terms[2]);
		$result['net_date']   = gen_db_date_short( $terms[3] );
		break;
	case '5': // Due at end of month
		$result['discount']   = $terms[1] / 100;
		$result['early_date'] = gen_specific_date($post_date, $terms[2]);
		$result['net_date']   = date('Y-m-d', mktime(0, 0, 0, $date_details['ThisMonth'], $date_details['TotalDays'], $date_details['ThisYear']));
		break;
  }
  return $result;
}

function load_cash_acct_balance($post_date, $gl_acct_id, $period) {
  global $db, $messageStack;
  $acct_balance = 0;
  $sql = "select beginning_balance from " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " 
	where account_id = '" . $gl_acct_id . "' and period = " . $period;
  $result = $db->Execute($sql);
  $acct_balance = $result->fields['beginning_balance'];

  // load the payments and deposits for the current period
  $bank_list = array();
  $sql = "select i.debit_amount, i.credit_amount
	from " . TABLE_JOURNAL_MAIN . " m inner join " . TABLE_JOURNAL_ITEM . " i on m.id = i.ref_id
	where m.period = " . $period . " and i.gl_account = '" . $gl_acct_id . "' and m.post_date <= '" . $post_date . "' 
	order by m.post_date, m.journal_id";
  $result = $db->Execute($sql);
  while (!$result->EOF) {
    $acct_balance += $result->fields['debit_amount'] - $result->fields['credit_amount'];
    $result->MoveNext();
  }
  return $acct_balance;
}
?>