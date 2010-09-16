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
//  Path: /modules/reportwriter/classes/day_book.php
//

// this file contains special function calls to generate the data array needed to build reports not possible
// with the current reportbuilder structure. Targeted towards aged receivables.
if (file_exists(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/classes/day_book.php')) {
  require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/classes/day_book.php');
} else {
  require(DIR_FS_WORKING . 'language/en_us/classes/day_book.php');
}

class day_book {

  // class constructor
  function day_book() {
	// List the special fields as an array to substitute out for the sql, must match from the selection menu generation
	$this->special_field_array = array('beg_balance');
  }

  function load_report_data($Prefs, $Seq, $sql = '', $GrpField = '') {
	global $db;
	// prepare the sql by temporarily replacing calculated fields with real fields
	$sql_fields = substr($sql, strpos($sql,'select ') + 7, strpos($sql, ' from ') - 7);
	$this->sql_field_array = explode(', ', $sql_fields);
	for ($i = 0; $i < count($this->sql_field_array); $i++) {
	  $this->sql_field_karray['c' . $i] = substr($this->sql_field_array[$i], 0, strpos($this->sql_field_array[$i], ' '));
	}
	$sql = $this->replace_special_fields($sql);
//echo 'sql = ' . $sql . '<br />'; exit;
//echo 'Prefs = '; print_r($Prefs); echo '<br />';
	$result = $db->Execute($sql);
	if ($result->RecordCount() == 0) return false; // No data so bail now
	// Generate the output data array
/*@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
	$this->gl_account = $Prefs['fromvalue1']; // assumes that the gl account is the first criteria, equal to
	if (!$this->gl_account) return false; // No gl account so bail now
	$dates      = gen_build_sql_date($Prefs['datedefault'], $Prefs['datefield']);
	$post_date  = $dates['start_date'];
	$period     = gen_calculate_period($post_date, $hide_error = true);
	if (!$period) $period = 1;
	$temp = $db->Execute("select beginning_balance from " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " 
		where account_id = '" . $this->gl_account . "' and period = " . $period);
	$beginning_balance = $temp->fields['beginning_balance'];
	// load the payments and deposits for the current period
	$sql = "select sum(i.debit_amount) as deposit, sum(i.credit_amount) as withdrawal
		from " . TABLE_JOURNAL_MAIN . " m inner join " . TABLE_JOURNAL_ITEM . " i on m.id = i.ref_id
		where m.period = " . $period . " and m.post_date < '" . $post_date . "' and i.gl_account = '" . $this->gl_account . "'";
	$temp = $db->Execute($sql);
	$this->beginning_balance = $beginning_balance + $temp->fields['deposit'] - $temp->fields['withdrawal'];
	$this->current_balance = $this->beginning_balance;
/*@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/

	$RowCnt = 0; // Row counter for output data
	$ColCnt = 1;
	$GrpWorking = false;
	while (!$result->EOF) {
		$myrow = $result->fields;
		// Check to see if a total row needs to be displayed
		if (isset($GrpField)) { // we're checking for group totals, see if this group is complete
			if (($myrow[$GrpField] <> $GrpWorking) && $GrpWorking !== false) { // it's a new group so print totals
				$OutputArray[$RowCnt][0] = 'g:' . $GrpWorking;
				foreach($Seq as $offset => $TotalCtl) {
					$OutputArray[$RowCnt][$offset+1] = ProcessData($TotalCtl['grptotal'], $TotalCtl['processing']);
					$Seq[$offset]['grptotal'] = ''; // reset the total
				}
				$RowCnt++; // go to next row
			}
			$GrpWorking = $myrow[$GrpField]; // set to new grouping value
		}
		$OutputArray[$RowCnt][0] = 'd'; // let the display class know its a data element
//echo 'orig myrow = '; print_r($myrow); echo '<br /><br />';
		$myrow = $this->replace_data_fields($myrow, $Seq);
//echo 'new myrow = '; print_r($myrow); echo '<br /><br />';
		// build the new balance
		foreach($Seq as $key => $TableCtl) { // calculate the new balance
//echo 'key = ' . $key . ' and fieldname = '; print_r($Prefs['FieldListings'][$key+1]['fieldname']); echo '<br />';
			if ($Prefs['FieldListings'][$key+1]['fieldname'] == '[table2].debit_amount')  $this->beginning_balance += $myrow[$TableCtl['fieldname']];
			if ($Prefs['FieldListings'][$key+1]['fieldname'] == '[table2].credit_amount') $this->beginning_balance -= $myrow[$TableCtl['fieldname']];
		}
		foreach($Seq as $key => $TableCtl) { // 
			// insert data into output array and set to next column
			$OutputArray[$RowCnt][$ColCnt] = ProcessData($myrow[$TableCtl['fieldname']], $TableCtl['processing']);
			$ColCnt++;
			if ($TableCtl['total']) { // add to the running total if need be
				$Seq[$key]['grptotal'] += $myrow[$TableCtl['fieldname']];
				$Seq[$key]['rpttotal'] += $myrow[$TableCtl['fieldname']];
			}
		}
		$RowCnt++;
		$ColCnt = 1;
		$result->MoveNext();
	}
	// add an extra line at the bottom with the newest balance
	$OutputArray[$RowCnt][0] = 'd'; // let the display class know its a data element
	foreach($Seq as $key => $TableCtl) { // calculate the new balance
		if ($Prefs['FieldListings'][$key+1]['fieldname'] == 'beg_balance') {
			$OutputArray[$RowCnt][$ColCnt] = ProcessData($this->beginning_balance, $TableCtl['processing']);
		} else {
			$OutputArray[$RowCnt][$ColCnt] = '';		
		}
		$ColCnt++;
	}
	$RowCnt++;
	$ColCnt = 1;

	if ($GrpWorking !== false) { // if we collected group data show the final group total
		$OutputArray[$RowCnt][0] = 'g:' . $GrpWorking;
		foreach ($Seq as $TotalCtl) {
			$OutputArray[$RowCnt][$ColCnt] = ($TotalCtl['total'] == '1') ? ProcessData($TotalCtl['grptotal'], $TotalCtl['processing']) : ' ';
			$ColCnt++;
		}
		$RowCnt++;
		$ColCnt = 1;
	}
	// see if we have a total to send
	$ShowTotals = false;
	foreach ($Seq as $TotalCtl) if ($TotalCtl['total'] == '1') $ShowTotals = true; 
	if ($ShowTotals) {
		$OutputArray[$RowCnt][0] = 'r:' . $Prefs['description'];
		foreach ($Seq as $TotalCtl) {
			if ($TotalCtl['total']) $OutputArray[$RowCnt][$ColCnt] = ProcessData($TotalCtl['rpttotal'], $TotalCtl['processing']);
				else $OutputArray[$RowCnt][$ColCnt] = ' ';
			$ColCnt++;
		}
	}
// echo 'output array = '; print_r($OutputArray); echo '<br />'; exit();
	return $OutputArray;
  }

  function build_selection_dropdown() {
	// build user choices for this class with the current and newly established fields
	$output = array();
	$output[] = array('id' => '[table1].id',                  'text' => RW_AR_RECORD_ID);
	$output[] = array('id' => '[table1].period',              'text' => TEXT_PERIOD);
	$output[] = array('id' => '[table1].journal_id',          'text' => RW_AR_JOURNAL_ID);
	$output[] = array('id' => '[table1].post_date',           'text' => TEXT_POST_DATE);
	$output[] = array('id' => '[table1].store_id',            'text' => RW_AR_STORE_ID);
	$output[] = array('id' => '[table1].description',         'text' => RW_AR_JOURNAL_DESC);
	$output[] = array('id' => '[table1].closed',              'text' => RW_AR_CLOSED);
	$output[] = array('id' => '[table1].freight',             'text' => RW_AR_FRT_TOTAL);
	$output[] = array('id' => '[table1].ship_carrier',        'text' => RW_AR_FRT_CARRIER);
	$output[] = array('id' => '[table1].ship_service',        'text' => RW_AR_FRT_SERVICE);
	$output[] = array('id' => '[table1].terms',               'text' => RW_AR_TERMS);
	$output[] = array('id' => '[table1].sales_tax',           'text' => RW_AR_SALES_TAX);
	$output[] = array('id' => '[table1].tax_auths',           'text' => RW_AR_TAX_AUTH);
	$output[] = array('id' => '[table1].total_amount',        'text' => RW_AR_INV_TOTAL);
	$output[] = array('id' => '[table1].balance_due',         'text' => RW_AR_BALANCE_DUE);
	$output[] = array('id' => '[table1].currencies_code',     'text' => RW_AR_CUR_CODE);
	$output[] = array('id' => '[table1].currencies_value',    'text' => RW_AR_CUR_EXC_RATE);
	$output[] = array('id' => '[table1].so_po_ref_id',        'text' => RW_AR_SO_NUM);
	$output[] = array('id' => '[table1].purchase_invoice_id', 'text' => RW_AR_INV_NUM);
	$output[] = array('id' => '[table1].purch_order_id',      'text' => RW_AR_PO_NUM);
	$output[] = array('id' => '[table1].rep_id',              'text' => RW_AR_SALES_REP);
	$output[] = array('id' => '[table1].gl_acct_id',          'text' => RW_AR_AR_ACCT);
	$output[] = array('id' => '[table1].bill_acct_id',        'text' => RW_AR_BILL_ACCT_ID);
	$output[] = array('id' => '[table1].bill_address_id',     'text' => RW_AR_BILL_ADD_ID);
	$output[] = array('id' => '[table1].bill_primary_name',   'text' => RW_AR_BILL_PRIMARY_NAME);
	$output[] = array('id' => '[table1].bill_contact',        'text' => RW_AR_BILL_CONTACT);
	$output[] = array('id' => '[table1].bill_address1',       'text' => RW_AR_BILL_ADDRESS1);
	$output[] = array('id' => '[table1].bill_address2',       'text' => RW_AR_BILL_ADDRESS2);
	$output[] = array('id' => '[table1].bill_city_town',      'text' => RW_AR_BILL_CITY);
	$output[] = array('id' => '[table1].bill_state_province', 'text' => RW_AR_BILL_STATE);
	$output[] = array('id' => '[table1].bill_postal_code',    'text' => RW_AR_BILL_ZIP);
	$output[] = array('id' => '[table1].bill_country_code',   'text' => RW_AR_BILL_COUNTRY);
	$output[] = array('id' => '[table1].bill_telephone1',     'text' => RW_AR_BILL_TELE1);
	$output[] = array('id' => '[table1].bill_email',          'text' => RW_AR_BILL_EMAIL);
	$output[] = array('id' => '[table1].ship_acct_id',        'text' => RW_AR_SHIP_ACCT_ID);
	$output[] = array('id' => '[table1].ship_address_id',     'text' => RW_AR_SHIP_ADD_ID);
	$output[] = array('id' => '[table1].ship_primary_name',   'text' => RW_AR_SHIP_PRIMARY_NAME);
	$output[] = array('id' => '[table1].ship_contact',        'text' => RW_AR_SHIP_CONTACT);
	$output[] = array('id' => '[table1].ship_address1',       'text' => RW_AR_SHIP_ADDRESS1);
	$output[] = array('id' => '[table1].ship_address2',       'text' => RW_AR_SHIP_ADDRESS2);
	$output[] = array('id' => '[table1].ship_city_town',      'text' => RW_AR_SHIP_CITY);
	$output[] = array('id' => '[table1].ship_state_province', 'text' => RW_AR_SHIP_STATE);
	$output[] = array('id' => '[table1].ship_postal_code',    'text' => RW_AR_SHIP_ZIP);
	$output[] = array('id' => '[table1].ship_country_code',   'text' => RW_AR_SHIP_COUNTRY);
	$output[] = array('id' => '[table1].ship_telephone1',     'text' => RW_AR_SHIP_TELE1);
	$output[] = array('id' => '[table1].ship_email',          'text' => RW_AR_SHIP_EMAIL);
	$output[] = array('id' => '[table1].terminal_date',       'text' => RW_AR_SHIP_DATE);
	$output[] = array('id' => '[table2].debit_amount',        'text' => RW_AR_DEPOSITS);
	$output[] = array('id' => '[table2].credit_amount',       'text' => RW_AR_WITHDRAWAL);
	// calculated fields
	$output[] = array('id' => 'beg_balance',                  'text' => RW_AR_BEG_BAL);
	return $output;
  }

  function replace_special_fields($sql) {
  	$preg_array = array();
  	for ($i = 0; $i < count ($this->special_field_array); $i++ ) {
	  $preg_array[] = '/' . $this->special_field_array[$i] . '/';
	}
	return preg_replace($preg_array, TABLE_JOURNAL_MAIN . '.id', $sql);
  }

  function replace_data_fields($myrow, $Seq) {
	foreach ($Seq as $key => $TableCtl) { // We need to find the id number to calculate the special fields
	  if (in_array($this->sql_field_karray[$TableCtl['fieldname']], $this->special_field_array)) {
	    $id = $myrow[$TableCtl['fieldname']];
		break;
	  }
	}
    $new_data = $this->calulate_special_fields($id);
	foreach ($myrow as $key => $value) { 
	  for ($i = 0; $i < count($this->special_field_array); $i++) {
	    if ($this->sql_field_karray[$key] == $this->special_field_array[$i]) $myrow[$key] = $new_data[$this->special_field_array[$i]];
	  }
	}
	return $myrow;
  }

  function calulate_special_fields($id) {
	$new_data['beg_balance'] = $this->beginning_balance;
	return $new_data;
  }
}
?>