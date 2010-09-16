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
//  Path: /modules/general/boxes/mini_financial.php
//

class mini_financial extends ctl_panel {

  function mini_financial() {
	$this->module_id   = 'mini_financial';
	$this->category    = 'gen_ledger';
	$this->title       = CP_MINI_FINANCIAL_TITLE;
	$this->security    = SECURITY_ID_JOURNAL_ENTRY; // allow if access to journal entry is available
	$this->description = CP_MINI_FINANCIAL_DESCRIPTION;
  }

  function Install($column_id = 1, $row_id = 0) {
	global $db;
	if (!$row_id) $row_id = $this->get_next_row();
	$result = $db->Execute("insert into " . TABLE_USERS_PROFILES . " set 
	  user_id = "    . $_SESSION['admin_id'] . ", 
	  page_id = '"   . $this->page_id . "', 
	  module_id = '" . $this->module_id . "', 
	  column_id = "  . $column_id . ", 
	  row_id = "     . $row_id . ", 
	  params = ''");
  }

  function Remove() {
	global $db;
	$result = $db->Execute("delete from " . TABLE_USERS_PROFILES . " 
	  where user_id = " . $_SESSION['admin_id'] . " and page_id = '" . $this->page_id . "' and module_id = '" . $this->module_id . "'");
  }

  function Output($params) {
	global $db;
	// Build control box form data
	$control  = '<div class="row">';
	$control .= '  <div style="white-space:nowrap">';
	$control .= CP_MINI_FINANCIAL_NO_OPTIONS . '<br />';
	$control .= html_hidden_field($this->module_id . '_rId', '');
	$control .= '  </div>';
	$control .= '</div>';

	// Build content box
	$contents = '<table width="100%" border = "0">';
	$period = CURRENT_ACCOUNTING_PERIOD;
	// build assets
	$this->bal_tot_2 = 0;
	$this->bal_tot_3 = 0;
	$this->bal_sheet_data = array();
	$the_list = array(0, 2, 4 ,6);
	$negate_array = array(false, false, false, false);
	$contents .= $this->add_bal_sheet_data($the_list, $negate_array, $period);
	$contents .= '<tr><td>&nbsp;&nbsp;' . htmlspecialchars(RW_FIN_CURRENT_ASSETS) . '</td>' . chr(10);
	$contents .= '<td align="right">' . $this->ProcessData($this->bal_tot_2) . '</td></tr>' . chr(10);

	$this->bal_tot_2 = 0;
	$the_list = array(8, 10, 12);
	$negate_array = array(false, false, false);
	$this->add_bal_sheet_data($the_list, $negate_array, $period);
	$contents .= '<tr><td>&nbsp;&nbsp;' . htmlspecialchars(RW_FIN_PROP_EQUIP) . '</td>' . chr(10);
	$contents .= '<td align="right">' . $this->ProcessData($this->bal_tot_2) . '</td></tr>' . chr(10);
	$contents .= '<tr><td>' . htmlspecialchars(RW_FIN_ASSETS) . '</td>' . chr(10);
	$contents .= '<td align="right">' . $this->ProcessData($this->bal_tot_3) . '</td></tr>' . chr(10);
	$contents .= '<tr><td colspan="2">&nbsp;</td></tr>' . chr(10);

	// build liabilities
	$this->bal_tot_2 = 0;
	$this->bal_tot_3 = 0;
	$the_list = array(20, 22);
	$negate_array = array(true, true);
	$this->add_bal_sheet_data($the_list, $negate_array, $period);
	$contents .= '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;' . htmlspecialchars(RW_FIN_CUR_LIABILITIES) . '</td>' . chr(10);
	$contents .= '<td align="right">' . $this->ProcessData($this->bal_tot_2) . '</td></tr>' . chr(10);

	$this->bal_tot_2 = 0;
	$the_list = array(24);
	$negate_array = array(true);
	$this->add_bal_sheet_data($the_list, $negate_array, $period);
	$contents .= '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;' . htmlspecialchars(RW_FIN_LT_LIABILITIES) . '</td>' . chr(10);
	$contents .= '<td align="right">&nbsp;&nbsp;' . $this->ProcessData($this->bal_tot_2) . '</td></tr>' . chr(10);
	$contents .= '<tr><td>&nbsp;&nbsp;' . htmlspecialchars(RW_FIN_TOTAL_LIABILITIES) . '</td>' . chr(10);
	$contents .= '<td align="right">' . $this->ProcessData($this->bal_tot_3) . '</td></tr>' . chr(10);

	// build capital
	$this->bal_tot_2 = 0;
	$the_list = array(40, 42, 44);
	$negate_array = array(true, true, true);
	$this->add_bal_sheet_data($the_list, $negate_array, $period);

	$contents .= $this->load_report_data($period); // retrieve and add net income value
	$this->bal_tot_2 += $this->ytd_net_income;
	$this->bal_tot_3 += $this->ytd_net_income;
	$contents .= '<tr><td>&nbsp;&nbsp;' . htmlspecialchars(RW_FIN_NET_INCOME) . '</td>' . chr(10);
	$contents .= '<td align="right">' . $this->ProcessData($this->ytd_net_income) . '</td></tr>' . chr(10);

	$contents .= '<tr><td>&nbsp;&nbsp;' . htmlspecialchars(RW_FIN_CAPITAL) . '</td>' . chr(10);
	$contents .= '<td align="right">' . $this->ProcessData($this->bal_tot_2) . '</td></tr>' . chr(10);

	$contents .= '<tr><td>' . htmlspecialchars(RW_FIN_TOTAL_LIABILITIES_CAPITAL) . '</td>' . chr(10);
	$contents .= '<td align="right">' . $this->ProcessData($this->bal_tot_3) . '</td></tr>' . chr(10);
	$contents .= '</table>' . chr(10);
	return $this->build_div($this->title, $contents, $control);
  }

  function Update() {
  }

  function add_bal_sheet_data($the_list, $negate_array, $period) {
	global $db;
	$contents = '';
	foreach($the_list as $key => $account_type) {
	  $sql = "select h.beginning_balance + h.debit_amount - h.credit_amount as balance, c.description  
			from " . TABLE_CHART_OF_ACCOUNTS . " c inner join " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " h on c.id = h.account_id
			where h.period = " . $period . " and c.account_type = " . $account_type;
	  $result = $db->Execute($sql);
	  $total_1 = 0;
	  while (!$result->EOF) {
		if ($negate_array[$key]) {
		  $total_1 -= $result->fields['balance'];
		} else {
		  $total_1 += $result->fields['balance'];
		}
		$result->MoveNext();
	  }
	  $this->bal_tot_2 += $total_1;
	  $contents .= '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;' . constant('RW_FIN_HEAD_' . $account_type) . '</td>' . chr(10);
	  $contents .= '<td align="right">' . $this->ProcessData($total_1) . '</td></tr>' . chr(10);
	}
	$this->bal_tot_3 += $this->bal_tot_2;
	return $contents;
  }

  function ProcessData($strData) {
    global $currencies;
  	return $currencies->format_full($strData, true, DEFAULT_CURRENCY, 1, 'fpdf');
  }

  function load_report_data($period) {
	global $db;
	$contents = '';
	// find the period range within the fiscal year from the first period to current requested period
	$result = $db->Execute("select fiscal_year from " . TABLE_ACCOUNTING_PERIODS . " where period = " . $period);
	$fiscal_year = $result->fields['fiscal_year'];
	$result = $db->Execute("select period from " . TABLE_ACCOUNTING_PERIODS . " where fiscal_year = " . $fiscal_year . " order by period limit 1");
	$first_period = $result->fields['period'];
	// build revenues
	$cur_year  = $this->add_income_stmt_data(30, $first_period, $period, $negate = true); // Income account_type
	$ytd_temp  = $this->ProcessData($this->total_3);
	$this->ytd_net_income = $this->total_3;
	$contents .= '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;' . RW_FIN_TOTAL_INCOME . '</td>' . chr(10);
	$contents .= '<td align="right">' . $this->ProcessData($this->total_3) . '</td></tr>' . chr(10);
	// less COGS
	$cur_year  = $this->add_income_stmt_data(32, $first_period, $period, $negate = false); // Cost of Sales account_type
	$ytd_temp  = $this->ProcessData($this->total_3);
	$this->ytd_net_income -= $this->total_3;
	$contents .= '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;' . RW_FIN_COST_OF_SALES . '</td>' . chr(10);
	$contents .= '<td align="right">(' . $this->ProcessData($this->total_3) . ')</td></tr>' . chr(10);
	$contents .= '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;' . RW_FIN_GROSS_PROFIT . '</td>' . chr(10);
	$contents .= '<td align="right">' . $this->ProcessData($this->ytd_net_income) . '</td></tr>' . chr(10);
	// less expenses
	$cur_year  = $this->add_income_stmt_data(34, $first_period, $period, $negate = false); // Expenses account_type
	$this->ytd_net_income -= $this->total_3;
	$contents .= '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;' . RW_FIN_EXPENSES . '</td>' . chr(10);
	$contents .= '<td align="right">(' . $this->ProcessData($this->total_3) . ')</td></tr>' . chr(10);
	$ytd_temp  = $this->ProcessData($this->ytd_net_income);
	return $contents;
  }

  function add_income_stmt_data($type, $first_period, $period, $negate = false) {
	global $db;
	$account_array = array();
	$sql = "select c.id, c.description, h.debit_amount - h.credit_amount as balance   
		from " . TABLE_CHART_OF_ACCOUNTS . " c inner join " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " h on c.id = h.account_id
		where h.period = " . $period . " and c.account_type = " . $type . " 
		order by c.id";
	$cur_period = $db->Execute($sql);
	$sql = "select (sum(h.debit_amount) - sum(h.credit_amount)) as balance  
		from " . TABLE_CHART_OF_ACCOUNTS . " c inner join " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " h on c.id = h.account_id
		where h.period >= " . $first_period . " and h.period <= " . $period . " and c.account_type = " . $type . " 
		group by h.account_id order by c.id";
	$ytd_period = $db->Execute($sql);
	$sql = "select beginning_balance 
		from " . TABLE_CHART_OF_ACCOUNTS . " c inner join " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " h on c.id = h.account_id
		where h.period = " . $first_period . " and c.account_type = " . $type . " 
		group by h.account_id order by c.id";
	$beg_balance = $db->Execute($sql);
	$ytd_total_1 = 0;
	while (!$ytd_period->EOF) {
		if ($negate) {
			$ytd_total_1 += -$beg_balance->fields['beginning_balance'] - $ytd_period->fields['balance'];
			$ytd_temp     = $this->ProcessData(-$beg_balance->fields['beginning_balance'] - $ytd_period->fields['balance']);
		} else {
			$ytd_total_1 += $beg_balance->fields['beginning_balance'] + $ytd_period->fields['balance'];
			$ytd_temp     = $this->ProcessData($beg_balance->fields['beginning_balance'] + $ytd_period->fields['balance']);
		}
		$account_array[$cur_period->fields['id']] = array($cur_period->fields['description'], $cur_temp, $ytd_temp);
		$ytd_period->MoveNext();
		$beg_balance->MoveNext();
	}
	$this->total_3 = $ytd_total_1;
	return $account_array;
  }

}
?>