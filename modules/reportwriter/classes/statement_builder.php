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
//  Path: /modules/reportwriter/classes/statement_builder.php
//
if (file_exists(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/classes/statement_builder.php')) {
  require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/classes/statement_builder.php');
} else {
  require(DIR_FS_MODULES . 'reportwriter/language/en_us/classes/statement_builder.php');
}

require_once(DIR_FS_MODULES . 'banking/functions/banking.php'); // needed to calculate terms

class statement_builder {

	// class constructor
	function statement_builder() {

	}

	function load_query_results($tableKey = 'id', $tableValue = 0) {
		global $db, $FieldListings, $Prefs, $rw_xtra_jrnl_defs;
		if (!$tableValue) return false;
		$this->bill_acct_id = $tableValue;
		// fetch the main contact information, only one record
		$sql = "select c.id, c.type, c.short_name, c.special_terms, 
		    a.primary_name, a.contact, a.address1, a.address2, a.city_town, a.state_province, a.postal_code, 
			a.country_code, a.telephone1, a.telephone2, a.telephone3, a.telephone4, a.email, a.website 
		  from " . TABLE_CONTACTS . " c inner join " . TABLE_ADDRESS_BOOK . " a on c.id = a.ref_id 
		  where c.id = " . $this->bill_acct_id . " and a.type like '%m'";
		$result = $db->Execute($sql);
        while (list($key, $value) = each($result->fields)) $this->$key = db_prepare_input($value);

		// calculate the starting balance
		$dates = gen_build_sql_date($Prefs['datedefault'], $Prefs['datefield']);
		$sql = "select sum(i.credit_amount) as credit, sum(i.debit_amount) as debit 
			from " . TABLE_JOURNAL_MAIN . " m inner join " . TABLE_JOURNAL_ITEM . " i on m.id = i.ref_id
			where m.bill_acct_id = " . $this->bill_acct_id . " and m.post_date < '" . $dates['start_date'] . "' 
			  and m.journal_id in (6, 7, 12, 13) and i.gl_type = 'ttl'";
		$result = $db->Execute($sql);
		$this->prior_balance = ($result->RecordCount()) ? ($result->fields['debit'] - $result->fields['credit']) : 0;
		$sql = "select sum(i.credit_amount) as credit, sum(i.debit_amount) as debit 
			from " . TABLE_JOURNAL_MAIN . " m inner join " . TABLE_JOURNAL_ITEM . " i on m.id = i.ref_id
			where m.bill_acct_id = " . $this->bill_acct_id . " and m.post_date < '" . $dates['start_date'] . "' 
			  and m.journal_id in (18, 20) and i.gl_type in ('pmt', 'chk')";
		$result = $db->Execute($sql);
		$this->prior_balance -= ($result->RecordCount()) ? ($result->fields['credit'] - $result->fields['debit']) : 0;

		// fetch journal history based on date criteria
		$strDates = str_replace('[table1]', 'm', $dates['sql']);
		$this->line_items = array();
		$sql = "select m.post_date, m.journal_id, i.debit_amount, i.credit_amount, m.purchase_invoice_id, 
		  m.purch_order_id, i.gl_type 
		  from " . TABLE_JOURNAL_MAIN . " m inner join " . TABLE_JOURNAL_ITEM . " i on m.id = i.ref_id 
		  where m.bill_acct_id = " . $this->bill_acct_id;
		if ($strDates) $sql .= " and " . $strDates;
//		$sql .= " and m.journal_id in (6, 7, 12, 13, 18, 20) and i.gl_type in ('dsc', 'ttl') order by m.post_date";
		$sql .= " and m.journal_id in (6, 7, 12, 13, 18, 20) and i.gl_type = 'ttl' order by m.post_date";
		$result = $db->Execute($sql);
		$this->statememt_total = 0;
        while (!$result->EOF) {
		  $reverse    = in_array($result->fields['journal_id'], array(6, 7, 12, 13)) ? true : false;
		  $line_desc  = $rw_xtra_jrnl_defs[$result->fields['journal_id']];
		  $terms_date = calculate_terms_due_dates($result->fields['post_date'], $this->special_terms);
		  $credit     = ($reverse) ? $result->fields['debit_amount']  : $result->fields['credit_amount'];
		  $debit      = ($reverse) ? $result->fields['credit_amount'] : $result->fields['debit_amount'];
		  if (in_array($result->fields['journal_id'], array(7, 13)) || $result->fields['gl_type'] == 'dsc') { // special case for credit memos and discounts
			$temp   = $debit;
			$debit  = -$credit;
			$credit = -$temp;
			if ($result->fields['gl_type'] == 'dsc') $line_desc = TEXT_DISCOUNT;
		  }
		  $this->line_items[] = array(
		    'journal_desc'        => $line_desc,
		    'post_date'           => $result->fields['post_date'],
		    'debit_amount'        => $debit,
		    'credit_amount'       => $credit,
		    'purchase_invoice_id' => $result->fields['purchase_invoice_id'],
		    'purch_order_id'      => $result->fields['purch_order_id'],
		    'due_date'            => $terms_date['net_date'],
		  );
		  $this->statememt_total += $credit - $debit;
		  $result->MoveNext();
		}

		// convert particular values indexed by id to common name
		if ($this->rep_id) {
			$sql = "select short_name from " . TABLE_CONTACTS . " where id = " . $this->rep_id;
			$result = $db->Execute($sql);
			$this->rep_id = $result->fields['display_name'];
		} else {
			$this->rep_id = '';
		}
		$this->balance_due = $this->prior_balance + $this->statememt_total;
		if ($this->type == 'v') { // invert amount for vendors for display purposes
			$this->prior_balance = -$this->prior_balance; 
			$this->balance_due   = -$this->balance_due;
		}
//echo 'prior balance = ' . $this->prior_balance . ' and bal due = ' . $this->balance_due . '<br />';
		$this->post_date = date(DATE_FORMAT);

		// sequence the results per Prefs[Seq]
		$output = array();
		foreach ($FieldListings as $OneField) { // check for a data field and build sql field list
			if ($OneField['params']['index'] == 'Data') { // then it's data field, include it
				$output[] = $this->$OneField['params']['DataField'];
			}
		}
		// return results
		return $output;
	}

  function load_table_data($Seq = '') {
	// fill the return data array
	$output = array();
	if (is_array($this->line_items) && is_array($Seq)) {
	  foreach ($this->line_items as $key => $row) {
		$row_data = array();
		foreach ($Seq as $column) {
		  if ($column['TblShow']) $row_data[] = $this->line_items[$key][$column[TblField]];
		}
		$output[] = $row_data;
	  }
	}
	return $output;
  }

  function load_total_results($Params) {
	return $this->balance_due;
  }

  function load_text_block_data($Params) {
	$TextField = '';
	foreach($Params as $Temp) {
	  $fieldname = $Temp['TblField'];
	  $TextField .= AddSep($this->$fieldname, $Temp['Processing']);
	}
	return $TextField;
  }

  function build_selection_dropdown() {
	// build user choices for this class with the current and newly established fields
	$output = array();
	$output[] = array('id' => 'id',             'text' => RW_SB_RECORD_ID);
	$output[] = array('id' => 'short_name',     'text' => RW_SB_CUSTOMER_ID);
	$output[] = array('id' => 'account_number', 'text' => RW_SB_ACCOUNT_NUMBER);
	$output[] = array('id' => 'rep_id',         'text' => RW_SB_SALES_REP);
	$output[] = array('id' => 'terms',          'text' => RW_SB_TERMS);
	$output[] = array('id' => 'primary_name',   'text' => RW_SB_BILL_PRIMARY_NAME);
	$output[] = array('id' => 'contact',        'text' => RW_SB_BILL_CONTACT);
	$output[] = array('id' => 'address1',       'text' => RW_SB_BILL_ADDRESS1);
	$output[] = array('id' => 'address2',       'text' => RW_SB_BILL_ADDRESS2);
	$output[] = array('id' => 'city_town',      'text' => RW_SB_BILL_CITY);
	$output[] = array('id' => 'state_province', 'text' => RW_SB_BILL_STATE);
	$output[] = array('id' => 'postal_code',    'text' => RW_SB_BILL_ZIP);
	$output[] = array('id' => 'country_code',   'text' => RW_SB_BILL_COUNTRY);
	$output[] = array('id' => 'telephone1',     'text' => RW_SB_BILL_TELE1);
	$output[] = array('id' => 'telephone2',     'text' => RW_SB_BILL_TELE2);
	$output[] = array('id' => 'telephone4',     'text' => RW_SB_BILL_FAX);
	$output[] = array('id' => 'email',          'text' => RW_SB_BILL_EMAIL);
	$output[] = array('id' => 'website',        'text' => RW_SB_BILL_WEBSITE);
	// special calculated fields
	$output[] = array('id' => 'prior_balance',  'text' => RW_SB_PRIOR_BALANCE);
	$output[] = array('id' => 'balance_due',    'text' => RW_SB_BALANCE_DUE);
	return $output;
  }

  function build_table_drop_down() { // build the drop down choices
	$output = array();
	$output[] = array('id' => 'journal_desc',        'text' => RW_SB_JOURNAL_DESC);
	$output[] = array('id' => 'purchase_invoice_id', 'text' => RW_SB_INV_NUM);
	$output[] = array('id' => 'purch_order_id',      'text' => RW_SB_PO_NUM);
	$output[] = array('id' => 'post_date',           'text' => TEXT_POST_DATE);
	$output[] = array('id' => 'due_date',            'text' => RW_SB_DUE_DATE);
	$output[] = array('id' => 'credit_amount',       'text' => RW_SB_PMT_RCVD);
	$output[] = array('id' => 'debit_amount',        'text' => RW_SB_INV_TOTAL);
	$output[] = array('id' => 'total_amount',        'text' => RW_SB_BALANCE_DUE);
	return $output;
  }

}
?>