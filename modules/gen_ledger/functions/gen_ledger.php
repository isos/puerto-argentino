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
//  Path: /modules/gen_ledger/functions/gen_ledger.php
//

//
function fetch_item_description($id) {
  global $db;
  $result = $db->Execute("select description from " . TABLE_JOURNAL_ITEM . " where ref_id = " . $id . " limit 1");
  return $result->fields['description'];
}

function validate_fiscal_year($next_fy, $next_period, $next_start_date, $num_periods = 12) {
  global $db;
  for ($i = 0; $i < $num_periods; $i++) {
	$fy_array = array(
	  'period'      => $next_period,
	  'fiscal_year' => $next_fy,
	  'start_date'  => $next_start_date,
	  'end_date'    => gen_specific_date($next_start_date, $day_offset = -1, $month_offset = 1),
	  'date_added'  => date('Y-m-d'),
	);
	db_perform(TABLE_ACCOUNTING_PERIODS, $fy_array, 'insert');
	$next_period++;
	$next_start_date = gen_specific_date($next_start_date, $day_offset = 0, $month_offset = 1);
  }
  return $next_period--;
}

function modify_account_history_records($id, $add_acct = true) {
  global $db;
  $result = $db->Execute("select max(period) as period from " . TABLE_ACCOUNTING_PERIODS);
  $max_period = $result->fields['period'];
  if (!$max_period) die ('table: accounting_periods is not set, run setup.');
  if ($add_acct) {
    $result = $db->Execute("select heading_only from " . TABLE_CHART_OF_ACCOUNTS . " where id = '" . $id . "'");
	if ($result->fields['heading_only'] <> '1') {
	  for ($i = 0, $j = 1; $i < $max_period; $i++, $j++) {
	    $db->Execute("insert into " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " (account_id, period) values('" . $id . "', '" . $j . "')");
	  }
	}
  } else {
	$result = $db->Execute("delete from " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " where account_id = '" . $id . "'");
  }
}

function build_and_check_account_history_records() {
  global $db;
  $result = $db->Execute("select max(period) as period from " . TABLE_ACCOUNTING_PERIODS);
  $max_period = $result->fields['period'];
  if (!$max_period) die ('table: accounting_periods is not set, run setup.');
  $result = $db->Execute("select id, heading_only from " . TABLE_CHART_OF_ACCOUNTS . " order by id");
  while (!$result->EOF) {
    if ($result->fields['heading_only'] <> '1') {
	  $account_id = $result->fields['id'];
	  for ($i = 0, $j = 1; $i < $max_period; $i++, $j++) {
	    $record_found = $db->Execute("select id from " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " where account_id = '" . $account_id . "' and period = " . $j);
	    if (!$record_found->RecordCount()) {
		  $db->Execute("insert into " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " (account_id, period) values('" . $account_id . "', '" . $j . "')");
		 }
	  }
	}
	$result->MoveNext();
  }
}

function get_fiscal_year_pulldown() {
    global $db;
    $fy_values = $db->Execute("select distinct fiscal_year from " . TABLE_ACCOUNTING_PERIODS . " order by fiscal_year");
    $fy_array = array();
    while (!$fy_values->EOF) {
      $fy_array[] = array('id' => $fy_values->fields['fiscal_year'], 'text' => $fy_values->fields['fiscal_year']);
      $fy_values->MoveNext();
    }
    return $fy_array;
}

function load_coa_types() {
  global $db;
  $coa_types = array();
  $result = $db->Execute("select * from " . TABLE_CHART_OF_ACCOUNTS_TYPES);
  while (!$result->EOF) {
    $coa_types[$result->fields['id']] = array(
	  'id'    => $result->fields['id'],
	  'text'  => $result->fields['description'],
	  'asset' => $result->fields['asset'] ? true : false,
	);
	$result->MoveNext();
  }
  return $coa_types;
}

function load_coa_info($types = array()) { // includes inactive accounts
  global $db;
  $coa_data = array();
  $sql = "select * from " . TABLE_CHART_OF_ACCOUNTS;
  if (sizeof($types > 0)) $sql .= " where account_type in (" . implode(", ", $types) . ")";
  $result = $db->Execute($sql);
  while (!$result->EOF) {
    $coa_data[$result->fields['id']] = array(
	  'id'              => $result->fields['id'],
	  'description'     => $result->fields['description'],
	  'heading_only'    => $result->fields['heading_only'],
	  'primary_acct_id' => $result->fields['primary_acct_id'],
	  'account_type'    => $result->fields['account_type'],
	);
	$result->MoveNext();
  }
  return $coa_data;
}

?>