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
//  Path: /modules/general/functions/general.php
//

function load_company_dropdown($include_select = false) {
	$output = array();
	$i = 1;
	if ($dir = @dir(DIR_FS_MY_FILES)) {
		while ($file = $dir->read()) {
			if ($file <> '.' && $file <> '..' && is_dir(DIR_FS_MY_FILES . $file)) {
				if (file_exists(DIR_FS_MY_FILES . $file . '/config.txt')) convert_cfg($file);
				if (file_exists(DIR_FS_MY_FILES . $file . '/config.php')) {
					require_once(DIR_FS_MY_FILES . $file . '/config.php');
					$output[$i] = array(
						'text' => constant($file . '_TITLE'), 
						'file' => $file,
					);
					$i++;
				}
			}
		}
		sort($output);
		$dir->close();
	}
	if ($include_select) $output[0] = array('text' => TEXT_NONE, 'file' => 'none');
	$the_list = array();
	foreach ($output as $key => $value) {
	  $_SESSION['companies'][$key] = $value['file'];
	  $the_list[] = array('id' => $key, 'text' => $value['text']);
	}
	return $the_list;
}

function load_language_dropdown($language_directory = 'modules/general/language/') {
	$output = array();
	if ($dir = @dir($language_directory)) {
		while ($file = $dir->read()) {
			if ($file <> '.' && $file <> '..' && file_exists($language_directory . $file . '/language.php')) {
				if ($config_file = file($language_directory . $file . '/language.php')) {
					foreach ($config_file as $line) {
						if (strstr($line,'\'LANGUAGE\'') !== false) {
							$start_pos = strpos($line, ',') + 2;
							$end_pos = strpos($line, ')') + 1;
							$language_name = substr($line, $start_pos, $end_pos - $start_pos);
							break;
						}
					}
					$output[$file] = array('id' => $file, 'text' => $language_name);
				}
			}
		}
		ksort($output);
		$dir->close();
	}
	return $output;
}

function load_theme_dropdown() {
	$theme_directory = DIR_FS_THEMES;
	$output = array();
	if ($dir = @dir($theme_directory)) {
		while ($file = $dir->read()) {
			if ($file <> '.' && $file <> '..' && $file <> '.svn' && is_dir($theme_directory . $file)) {
				if ($config_file = file($theme_directory . $file . '/config.php')) {
					foreach ($config_file as $line) {
						if (strstr($line,'\'THEME_NAME\'') !== false) {
							$start_pos = strpos($line, ',') + 2;
							$end_pos = strrpos($line, '\'');
							$theme_name = trim(substr($line, $start_pos, $end_pos - $start_pos));
							break;
						}
					}
					$output[$file] = array('id' => $file, 'text' => $theme_name);
				}
			}
		}
		ksort($output);
		$dir->close();
	}
	return $output;
}

function build_search_sql($fields, $id, $id_from = '', $id_to = '') {
  $crit = array();
  foreach ($fields as $field) {	
	$output = '';
	switch ($id) {
		case 'all': // no filter required
			break;
		case 'rng':
			if ($id_from) $output .= $field . " >= '" . $id_from . "'";
			if ($output && $id_to) $output .= " and ";
			if ($id_to) $output .= $field . " <= '" . $id_to . "'";
			break;
		case 'eq':
			if ($id_from) $output .= $field . " = '" . $id_from . "'";
			break;
		case 'neq':
			if ($id_from) $output .= $field . " <> '" . $id_from . "'";
			break;
		case 'like':
			if ($id_from) $output .= $field . " like '%" . $id_from . "%'";
			break;
	}
	if ($output) $crit[] = $output;
  }
  return ($crit) ? ('(' . implode(' or ', $crit) . ')') : '';
}

function gen_auto_update_period($show_message = true) {
	global $db, $messageStack;
	$period = gen_calculate_period(date('Y-m-d'), true);
	if ($period == CURRENT_ACCOUNTING_PERIOD) return; // we're in the current period
	if (!$period) { // we're outside of the defined fiscal years
	  if ($show_message) $messageStack->add(ERROR_MSG_POST_DATE_NOT_IN_FISCAL_YEAR,'error');
	} else { // update CURRENT_ACCOUNTING_PERIOD constant with this new period
	  $result = $db->Execute("select start_date, end_date from " . TABLE_ACCOUNTING_PERIODS . " where period = " . $period);
	  $db->Execute("update " . TABLE_CONFIGURATION . " set configuration_value = " . $period . " 
		where configuration_key = 'CURRENT_ACCOUNTING_PERIOD'");
	  $db->Execute("update " . TABLE_CONFIGURATION . " set configuration_value = '" . $result->fields['start_date'] . "' 
		where configuration_key = 'CURRENT_ACCOUNTING_PERIOD_START'");
	  $db->Execute("update " . TABLE_CONFIGURATION . " set configuration_value = '" . $result->fields['end_date'] . "' 
		where configuration_key = 'CURRENT_ACCOUNTING_PERIOD_END'");
	  if ($show_message) {
	    gen_add_audit_log(GEN_LOG_PERIOD_CHANGE);
	    $messageStack->add(sprintf(ERROR_MSG_ACCT_PERIOD_CHANGE, $period),'success');
	  }
	}
}

function repost_journals($journals, $start_date, $end_date) {
	global $db, $messageStack;
	if (sizeof($journals) > 0) {
	  $sql = "select id from " . TABLE_JOURNAL_MAIN . " 
		where journal_id in (" . implode(',', $journals) . ") 
		and post_date >= '" . $start_date . "' and post_date < '" . gen_specific_date($end_date, 1) . "' 
		order by id";
	  $result = $db->Execute($sql);
	  $cnt = 0;
	  $db->transStart();
	  while (!$result->EOF) {
	    $gl_entry = new journal($result->fields['id']);
	    $gl_entry->remove_cogs_rows(); // they will be regenerated during the re-post
	    if (!$gl_entry->Post('edit', true)) {
		  $db->transRollback();
		  $messageStack->add('<br /><br />Failed Re-posting the journals, try a smaller range. The record that failed was # ' . $gl_entry->id,'error');
		  return false;
	    }
		$cnt++;
	    $result->MoveNext();
	  }
      $db->transCommit();
	  return $cnt;
	}
}

function gen_get_account_type($id) {
  global $db;
  $vendor_type = $db->Execute("select type from " . TABLE_CONTACTS . " where id = '" . $id . "'");
  return ($vendor_type->RecordCount() == 1) ? $vendor_type->fields['type'] : false;
}


function validate_gl_balances($action) {
	global $db, $currencies, $messageStack;
	$fiscal_years = array();
	$sql = "select distinct fiscal_year, min(period) as first_period, max(period) as last_period
	  from " . TABLE_ACCOUNTING_PERIODS . " group by fiscal_year order by fiscal_year ASC";
	$result = $db->Execute($sql);
	while (!$result->EOF) {
	  $fiscal_years[] = array(
	    'fiscal_year'  => $result->fields['fiscal_year'],
		'first_period' => $result->fields['first_period'],
		'last_period'  => $result->fields['last_period']);
	  $result->MoveNext();
	}

	$beg_bal = array();
	$bad_accounts = array();
	foreach ($fiscal_years as $fiscal_year) {
	  $sql = "select account_id, period, beginning_balance, (beginning_balance + debit_amount - credit_amount) as next_beg_bal
		from " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " 
		where period >= " . $fiscal_year['first_period'] . " and period <= " . $fiscal_year['last_period'] . " 
		order by period, account_id";
	  $result = $db->Execute($sql);
	  while (!$result->EOF) {
		$period       = $result->fields['period'];
		$next_period  = $period + 1;
		$gl_account   = $result->fields['account_id'];
		$beg_balance  = $currencies->format($result->fields['beginning_balance']);
		$next_beg_bal = $currencies->format($result->fields['next_beg_bal']);
		$beg_bal[$next_period][$gl_account] = $next_beg_bal;
		if ($period <> 1 && $beg_bal[$period][$gl_account] <> $beg_balance) {
		  if ($action <> 'coa_hist_fix') $messageStack->add(sprintf(GEN_ADM_TOOLS_REPAIR_ERROR_MSG, $period, $gl_account, $beg_bal[$period][$gl_account], $beg_balance),'caution');
		  $bad_accounts[$period][$gl_account] = array('sync' => '1');
		}
		// check posted transactions to account to see if they match
		$posted = $db->Execute("select sum(debit_amount) as debit, sum(credit_amount) as credit 
		  from " . TABLE_JOURNAL_MAIN . " m join " . TABLE_JOURNAL_ITEM . " i on m.id = i.ref_id
		  where period = " . $period . " and gl_account = '" . $gl_account . "' 
		  and journal_id in (2, 6, 7, 12, 13, 14, 16, 18, 19, 20, 21)");
		$posted_bal   = $currencies->format($result->fields['beginning_balance'] + $posted->fields['debit'] - $posted->fields['credit']);
		if ($posted_bal <> $next_beg_bal) {
		  if ($action <> 'coa_hist_fix') $messageStack->add(sprintf(GEN_ADM_TOOLS_REPAIR_ERROR_MSG, $period, $gl_account, $posted_bal, $next_beg_bal),'caution');
		  $bad_accounts[$period][$gl_account] = array(
		    'sync'   => '1',
		    'debit'  => $posted->fields['debit'],
		    'credit' => $posted->fields['credit'],
		  );
		}
		$result->MoveNext();
	  }
	  // roll the fiscal year balances
	  $result = $db->Execute("select id from " . TABLE_CHART_OF_ACCOUNTS . " where account_type = 44");
	  $retained_earnings_acct = $result->fields['id'];
	  // select list of accounts that need to be closed, adjusted
	  $sql = "select id from " . TABLE_CHART_OF_ACCOUNTS . " where account_type in (30, 32, 34, 42, 44)";
	  $result = $db->Execute($sql);
	  $acct_list = array();
	  while(!$result->EOF) {
		$beg_bal[$next_period][$result->fields['id']] = 0;
		$acct_list[] = $result->fields['id'];
		$result->MoveNext();
	  }
	  // fetch the totals for the closed accounts
	  $sql = "select sum(beginning_balance + debit_amount - credit_amount) as retained_earnings 
		from " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " 
		where account_id in ('" . implode("','",$acct_list) . "') and period = " . $period;
	  $result = $db->Execute($sql);
	  $beg_bal[$next_period][$retained_earnings_acct] = $currencies->format($result->fields['retained_earnings']);
	}
	if ($action == 'coa_hist_fix') {
	  // find the affected accounts
	  if (sizeof($bad_accounts) > 0) {
		// *************** START TRANSACTION *************************
		$db->transStart();
	    $glEntry = new journal();
		$min_period = 999999;
		foreach ($bad_accounts as $period => $acct_array) {
		  foreach ($acct_array as $gl_acct => $value) {
			$min_period = min($period, $min_period); // find first period that has an error
			$glEntry->affected_accounts[$gl_acct] = 1;
			if (isset($value['debit'])) { // the history doesn't match posted data, repair
			  $db->Execute("update " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " 
			    set debit_amount = " . $value['debit'] . ", credit_amount = " . $value['credit'] . " 
			    where period = " . $period . " and account_id = '" . $gl_acct . "'");
			}
		  }
		}
		$debug = true;
		if ($glEntry->update_chart_history_periods($min_period - 1)) { // from prior period than the error account
			$db->transCommit();
			$messageStack->add_session(GEN_ADM_TOOLS_REPAIR_COMPLETE,'success');
			gen_add_audit_log(GEN_ADM_TOOLS_REPAIR_LOG_ENTRY);
			gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=coa_hist_test', 'SSL'));
		}
	  }
	}
	if (sizeof($bad_accounts) == 0) {
	  $messageStack->add(GEN_ADM_TOOLS_REPAIR_SUCCESS,'success');
	} else {
	  $messageStack->add(GEN_ADM_TOOLS_REPAIR_ERROR,'error');
	}
}

function gen_pull_db_config_info($database, $key) {
  $filename = DIR_FS_ADMIN . 'my_files/' . $database . '/config.txt';
  $lines = file($filename);
  for ($x = 0; $x < count($lines); $x++) {
	if (trim(substr($lines[$x], 0, strpos($lines[$x], '='))) == $key) {
	  return trim(substr($lines[$x], strpos($lines[$x],'=') + 1, strpos($lines[$x],';') - strpos($lines[$x],'=') - 1));
	}
  }
  return false;
}

function convert_cfg($company) {
  // build the new file
  $lines  = '<?php' . "\n";
  $lines .= "/* config.php */" . "\n";
  $lines .= "define('" . $company . "_TITLE','" . gen_pull_db_config_info($company, 'company_name') . "');" . "\n";
  $lines .= "define('DB_SERVER','"              . gen_pull_db_config_info($company, 'db_server') . "');" . "\n";
  $lines .= "define('DB_SERVER_USERNAME','"     . gen_pull_db_config_info($company, 'db_user') . "');" . "\n";
  $lines .= "define('DB_SERVER_PASSWORD','"     . gen_pull_db_config_info($company, 'db_pw') . "');" . "\n";

  $filename = DIR_FS_ADMIN . 'my_files/' . $company . '/config';
  if (!$handle = @fopen($filename . '.php', 'w')) die('Cannot open file (' . $filename . '.php) for writing, check your permissions. This directory and file needs access from the web server for upgrading PhreeBooks to the latest version.');
  if (!fwrite($handle, $lines)) die('Cannot write to file (' . $filename . '.php), check your permissions.');
  fclose($handle);
  if (!unlink($filename . '.txt')) die('Cannot delete file (' . $filename . '.txt). This file needs to be deleted for security reasons.');
}

?>