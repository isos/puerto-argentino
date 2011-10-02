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
//  Path: /modules/general/functions/gen_functions.php
//

////
// Redirect to another page or site
  function gen_redirect($url) {
    global $messageStack;
	// put any messages form the messageStack into a session variable to recover after redirect
	$messageStack->convert_add_to_session();
	// clean up URL before executing it
    while (strstr($url, '&&')) $url = str_replace('&&', '&', $url);
    while (strstr($url, '&amp;&amp;')) $url = str_replace('&amp;&amp;', '&amp;', $url);
    // header locates should not have the &amp; in the address it breaks things
    while (strstr($url, '&amp;')) $url = str_replace('&amp;', '&', $url);
    header('Location: ' . $url);
    exit;
  }

  function gen_not_null($value) {
    return (!is_null($value) || strlen(trim($value)) > 0) ? true : false;
  }

////
// Sanitizes a javascript string in an array enclosed in double quotes
  function gen_js_encode($str) {
  	$str = str_replace('"', '\"', $str);
	$str = str_replace(chr(10), '\n', $str);
	$str = str_replace(chr(13), '', $str);
	return $str;
  }

////
  function gen_array_key_merge($arr1, $arr2) {
  	if (!is_array($arr1)) $arr1 = array();
    if (is_array($arr2) && sizeof($arr2) > 0) {
	  foreach($arr2 as $key => $value) { 
        if (!array_key_exists($key, $arr1)) $arr1[$key] = $value;
      }
	}
    return $arr1;
  }
 
////
  function gen_null_pull_down() {
    $null_array = array('id' => '0', 'text' => TEXT_ENTER_NEW);
    return $null_array;
  }

////
// converts a keyed_array to format needed for html_pull_down_menu
  function gen_build_pull_down($keyed_array) {
	$values = array();
	if (is_array($keyed_array)) {
		foreach($keyed_array as $key => $value) {
			$values[] = array('id' => $key, 'text' => $value);
		}
	}
	return $values;
  }

  function gen_get_pull_down($db_name, $first_none = false, $show_id = '0', $id = 'id', $description = 'description') {
    global $db;
    $type_format_values = $db->Execute("select " . $id . " as id, " . $description . " as description
                                           from " . $db_name . "
                                           order by '" . $id . "'");
    $type_format_array = array();
    if ($first_none) $type_format_array[] = array('id' => '', 'text' => TEXT_NONE);
    while (!$type_format_values->EOF) {
	  switch ($show_id) {
	    case '1': // description only
		  $text_value = $type_format_values->fields['description'];
		  break;
		case '2': // Both id and description
		  $text_value = $type_format_values->fields['id'] . ' : ' . $type_format_values->fields['description'];
		  break;
		case '0': // id only
		default:
	  	  $text_value = $type_format_values->fields['id'];
	  }
      $type_format_array[] = array(
	    'id'   => $type_format_values->fields['id'],
        'text' => $text_value,
	  );
      $type_format_values->MoveNext();
    }
    return $type_format_array;
  }

  function gen_coa_pull_down($show_id = SHOW_FULL_GL_NAMES, $first_none = true, $hide_inactive = true, $show_all = false, $restrict_types = false) {
    global $db;
	$params = array();
    $output = array();
	$sql  = "select id, description from " . TABLE_CHART_OF_ACCOUNTS;
	if ($hide_inactive)  $params[] = "account_inactive = '0'";
	if (!$show_all)      $params[] = "heading_only = '0'";
	if ($restrict_types) $params[] = "and account_type in (" . implode(',', $restrict_types) . ")";
	$sql .= (sizeof($params) == 0) ? '' : ' where ' . implode(' and ', $params); 
	$sql .= " order by id";
    $result = $db->Execute($sql);
    if ($first_none) $output[] = array('id' => '', 'text' => GEN_HEADING_PLEASE_SELECT);
    while (!$result->EOF) {
	  switch ($show_id) {
		default:
		case '0': // id only
	  	  $text_value = $result->fields['id']; break;
	    case '1': // description only
		  $text_value = $result->fields['description']; break;
		case '2': // Both id and description
		  $text_value = $result->fields['id'] . ' : ' . $result->fields['description']; break;
	  }
      $output[] = array('id' => $result->fields['id'], 'text' => $text_value);
      $result->MoveNext();
    }
    return $output;
  }

  function gen_get_period_pull_down($include_all = true) {
    global $db;
    $period_values = $db->Execute("select period, start_date, end_date from " . TABLE_ACCOUNTING_PERIODS . " order by period");
    $period_array = array();
    if ($include_all) $period_array[] = array('id' => 'all', 'text' => TEXT_ALL);
    while (!$period_values->EOF) {
	  $text_value = TEXT_PERIOD . ' ' . $period_values->fields['period'] . ' : ' . gen_date_short($period_values->fields['start_date']) . ' - ' . gen_date_short($period_values->fields['end_date']);
      $period_array[] = array('id' => $period_values->fields['period'], 'text' => $text_value);
      $period_values->MoveNext();
    }
    return $period_array;
  }

  function gen_calculate_period($post_date, $hide_error = false) {
	global $db, $messageStack;
	$post_time_stamp = strtotime($post_date);
	$period_start_time_stamp = strtotime(CURRENT_ACCOUNTING_PERIOD_START);
	$period_end_time_stamp = strtotime(CURRENT_ACCOUNTING_PERIOD_END);

	if (($post_time_stamp >= $period_start_time_stamp) && ($post_time_stamp <= $period_end_time_stamp)) {
		return CURRENT_ACCOUNTING_PERIOD;
	} else {
		$result = $db->Execute("select period from " . TABLE_ACCOUNTING_PERIODS . " 
			where start_date <= '" . $post_date . "' and end_date >= '" . $post_date . "'");
		if ($result->RecordCount() <> 1) { // post_date is out of range of defined accounting periods
			if (!$hide_error) $messageStack->add(ERROR_MSG_POST_DATE_NOT_IN_FISCAL_YEAR,'error');
			return false;
		}
		if (!$hide_error) $messageStack->add(ERROR_MSG_BAD_POST_DATE,'caution');
		return $result->fields['period'];
	}
  }

////
// fetch the description field of a db for a given id
  function gen_get_type_description($db_name, $id, $full = true) {
    global $db;
    $type_name = $db->Execute("select description from " . $db_name . " where id = '" . $id . "'");
    if ($type_name->RecordCount() < 1) {
      return $id;
    } else {
	  if ($full) {
		return $id . ':' . $type_name->fields['description'];
	  } else {
		return $type_name->fields['description'];
	  }
    }
  }

////
//
  function gen_get_account_array_by_type($type = 'v') {
    global $db;
    $accounts = $db->Execute("select id, short_name from " . TABLE_CONTACTS . " where type='" . $type . "' order by short_name");
    $accounts_array = array();
    $accounts_array[] = array('id' => '', 'text' => TEXT_NONE);
    while (!$accounts->EOF) {
      $accounts_array[] = array('id' => $accounts->fields['id'], 'text' => $accounts->fields['short_name']);
      $accounts->MoveNext();
    }
    return $accounts_array;
  }

  function gen_get_rep_ids($type = 'c') {
	global $db;
	// map the type to the employee types
	switch ($type) {
	  default:
	  case 'c': $emp_type = 's'; break;
	  case 'v': $emp_type = 'b'; break;
	}
    $result_array = array();
    $result_array[] = array('id' => '0', 'text' => TEXT_NONE);
	$result = $db->Execute("select id, contact_first, contact_last, gl_type_account from " . TABLE_CONTACTS . " where type = 'e' and inactive <> '1'");
	while(!$result->EOF) {
	  if (strpos($result->fields['gl_type_account'], $emp_type) !== false) {
 	    $result_array[] = array('id' => $result->fields['id'], 'text' => $result->fields['contact_first'] . ' ' . $result->fields['contact_last']);
	  }
	  $result->MoveNext();
	}
    return $result_array;
  }


////
// fetch the description of the account for a given id
  function gen_get_account_name($id) {
    global $db;
    $vendor_name = $db->Execute("select short_name from " . TABLE_CONTACTS . " where id = '" . $id . "'");
    if ($vendor_name->RecordCount() < 1) {
      return false;
    } else {
      return $vendor_name->fields['short_name'];
    }
  }

  function gen_get_store_ids() {
	global $db;
    $result_array = array();
	$result = $db->Execute("select id, short_name from " . TABLE_CONTACTS . " where type = 'b'");
	if (($_SESSION['admin_prefs']['restrict_store'] && $_SESSION['admin_prefs']['def_store_id'] == 0)
	  || !$_SESSION['admin_prefs']['restrict_store']) {
          $result_array[] = array('id' => '0', 'text' => COMPANY_ID); // main branch id
	}
	while(!$result->EOF) {
	  if (($_SESSION['admin_prefs']['restrict_store'] && $_SESSION['admin_prefs']['def_store_id'] == $result->fields['id'])
	    || !$_SESSION['admin_prefs']['restrict_store']) {
 	   $result_array[] = array('id' => $result->fields['id'], 'text' => $result->fields['short_name']);
	  }
	  $result->MoveNext();
	}
    return $result_array;
  }


////
// build tax authority array to determine tax rates 
  function gen_build_tax_auth_array() {
    global $db;
    $tax_auth_values = $db->Execute("select tax_auth_id, description_short, account_id , tax_rate
                             from " . TABLE_TAX_AUTH . "
                             order by description_short");
    if ($tax_auth_values->RecordCount() < 1) {
      return false;
    } else {
		while (!$tax_auth_values->EOF) {
		  $tax_auth_array[$tax_auth_values->fields['tax_auth_id']] = 
		  	array('description_short' => $tax_auth_values->fields['description_short'],
				  'account_id' => $tax_auth_values->fields['account_id'],
				  'tax_rate' => $tax_auth_values->fields['tax_rate']);
		  $tax_auth_values->MoveNext();
		}
    	return $tax_auth_array;
    }
  }

////
// caculate the total tax rate for a given tax code 
  function gen_calculate_tax_rate($tax_authorities_chosen, $tax_auth_array) {
	$chosen_auth_array = explode(':', $tax_authorities_chosen);
	$total_tax_rate = 0;
	while ($chosen_auth = array_shift($chosen_auth_array)) {
	  $total_tax_rate += $tax_auth_array[$chosen_auth]['tax_rate'];
	}
	return $total_tax_rate;
  }

  function gen_terms_to_language($terms_encoded, $short = true, $type = 'AR') {
	$type = strtoupper($type);
	$terms = explode(':', $terms_encoded);
	$result = array();
	switch ($terms[0]) {
		default:
		case '0': // Default terms
			if ((int)constant($type . '_PREPAYMENT_DISCOUNT_PERCENT') <> 0) {
				$result['long'] = ACT_DISCOUNT . constant($type . '_PREPAYMENT_DISCOUNT_PERCENT') . ACT_EARLY_DISCOUNT . ACT_DUE_IN . constant($type . '_PREPAYMENT_DISCOUNT_DAYS') . ACT_TERMS_EARLY_DAYS;
				$result['short'] = constant($type . '_PREPAYMENT_DISCOUNT_PERCENT') . ACT_EARLY_DISCOUNT_SHORT . constant($type . '_PREPAYMENT_DISCOUNT_DAYS') . ', ';
			}
			$result['long'] .= ACT_TERMS_NET . constant($type . '_NUM_DAYS_DUE') . ACT_TERMS_STANDARD_DAYS;
			$result['short'] .= ACT_TERMS_NET . constant($type . '_NUM_DAYS_DUE');
			break;
		case '1': // Cash on Delivery (COD)
			$result['long'] = ACT_COD_LONG;
			$result['short'] = ACT_COD_SHORT;
			break;
		case '2': // Prepaid
			$result['long'] = ACT_PREPAID;
			$result['short'] = ACT_PREPAID;
			break;
		case '3': // Special terms
			if ($terms[1] <> 0) {
				$result['long'] = ACT_DISCOUNT . $terms[1] . ACT_EARLY_DISCOUNT . ACT_DUE_IN . $terms[2] . ACT_TERMS_EARLY_DAYS;
				$result['short'] = $terms[1] . ACT_EARLY_DISCOUNT_SHORT . $terms[2] . ', ';
			}
			$result['long'] .= ACT_TERMS_NET . $terms[3] . ACT_TERMS_STANDARD_DAYS;
			$result['short'] .=  ACT_TERMS_NET . $terms[3];
			break;
		case '4': // Due on day of next month
			if ($terms[1] <> 0) {
				$result['long'] = ACT_DISCOUNT . $terms[1] . ACT_EARLY_DISCOUNT . ACT_DUE_IN . $terms[2] . ACT_TERMS_EARLY_DAYS;
				$result['short'] = $terms[1] . ACT_EARLY_DISCOUNT_SHORT . $terms[2] . ', ';
			}
			$result['long'] .= ACT_DUE_ON . $terms[3];
			$result['short'] .=  ACT_DUE_ON . $terms[3];
			break;
		case '5': // Due at end of month
			if ($terms[1] <> 0) {
			} else {
				$result['long'] = ACT_DISCOUNT . $terms[1] . ACT_EARLY_DISCOUNT . ACT_DUE_IN . $terms[2] . ACT_TERMS_EARLY_DAYS;
				$result['short'] = $terms[1] . ACT_EARLY_DISCOUNT_SHORT . $terms[2] . ', ';
			}
			$result['long'] .= ACT_END_OF_MONTH;
			$result['short'] .=  ACT_END_OF_MONTH;
	}
	if ($short) return $result['short']; 
	return $result['long'];
  }

  function gen_get_currency_array() {
  	global $db;
	$result = $db->Execute('select code, title from ' . TABLE_CURRENCIES);
    $result_array = array();
	while(!$result->EOF) {
 	   $result_array[] = array('id' => $result->fields['code'], 'text' => $result->fields['title']);
	   $result->MoveNext();
	}
    return $result_array;
  }

  function get_price_sheet_data() {
    global $db;
    $sql = "select distinct sheet_name, default_sheet from " . TABLE_PRICE_SHEETS . " 
		where inactive = '0' order by sheet_name";
    $result = $db->Execute($sql);
    $sheets = array();
	$default = '';
    $sheets[] = array('id' => '', 'text' => TEXT_NONE);
    while (!$result->EOF) {
	  if ($result->fields['default_sheet']) $default = $result->fields['sheet_name'];
      $sheets[] = array('id' => $result->fields['sheet_name'], 'text' => $result->fields['sheet_name']);
      $result->MoveNext();
    }
    return $sheets;
  }

  function gen_build_acct_arrays() {
  	$acct_array = array();
	$acct_array['fields'] = array('primary_name', 'contact', 'address1', 'address2', 'city_town', 'state_province', 'postal_code', 'country_code', 'telephone1', 'email');
	$acct_array['company'] = array(
		gen_js_encode(COMPANY_NAME),
		gen_js_encode(AP_CONTACT_NAME),
		gen_js_encode(COMPANY_ADDRESS1),
		gen_js_encode(COMPANY_ADDRESS2),
		gen_js_encode(COMPANY_CITY_TOWN),
		gen_js_encode(COMPANY_ZONE),
		COMPANY_POSTAL_CODE, 
		COMPANY_COUNTRY, 
		COMPANY_TELEPHONE1, 
		COMPANY_EMAIL);
	$acct_array['text'] = array();
	foreach ($acct_array['fields'] as $value) $acct_array['text'][] = constant('GEN_' . strtoupper($value));
	return $acct_array;
  }

  function gen_validate_sku($sku) {
  	global $db;
	$result = $db->Execute("select id from " . TABLE_INVENTORY . " where sku = '" . $sku . "'");
	if ($result->RecordCount() <> 0) {
		return true;
	} else {
		return false;
	}
  }

  function gen_parse_permissions($imploded_permissions) {
	$result = array();
	$temp = explode(',', $imploded_permissions);
	if (is_array($temp)) {
		foreach ($temp as $imploded_entry) {
			$entry = explode(':', $imploded_entry);
			$result[$entry[0]] = $entry[1];
		}
	}
	return $result;
  }

  function gen_add_audit_log($action, $ref_id = '', $amount = '') {
	if ($action == '' || !isset($action)) die ('Error, call to audit log with no description');
	$ref_id = db_prepare_input($ref_id);
	$fields = array(
	  'user_id' => $_SESSION['admin_id'] ? $_SESSION['admin_id'] : '1',
	  'action'  => db_prepare_input($action),
	);
	if ($ref_id <> '') $fields['reference_id'] = db_prepare_input($ref_id);
	if ($amount <> '') $fields['amount']       = db_prepare_input($amount);
	db_perform(TABLE_AUDIT_LOG, $fields, 'insert');
  }

// Parse the data used in the html tags to ensure the tags will not break
  function gen_parse_input_field_data($data, $parse) {
    return strtr(trim($data), $parse);
  }

  function gen_output_string($string, $translate = false, $protected = false) {
    if ($protected == true) {
      return htmlspecialchars($string);
    } else {
      if ($translate == false) {
        return gen_parse_input_field_data($string, array('"' => '&quot;'));
      } else {
        return gen_parse_input_field_data($string, $translate);
      }
    }
  }

  function gen_get_all_get_params($exclude_array = '') {
    global $_GET;
    if ($exclude_array == '') $exclude_array = array();
    $get_url = '';
    
    reset($_GET);
    while (list($key, $value) = each($_GET)) {
      if (($key != session_name()) && ($key != 'error') && (!in_array($key, $exclude_array))) $get_url .= $key . '=' . $value . '&amp;';
    }
    
    //agrego estas 2 lineas para que los nuevos filtros cerrado/abierto sean incluidos en $_GET
    if (isset($_REQUEST['filter_closed']))
    	$get_url .= 'filter_closed='. $_REQUEST['filter_closed']. '&amp;';
    	
    return $get_url;
  }

  function js_get_all_get_params($exclude_array = '') { // for use within javascript language validator
    global $_GET;
    if ($exclude_array == '') $exclude_array = array();
    $get_url = '';
    reset($_GET);
    while (list($key, $value) = each($_GET)) {
      if (($key != session_name()) && ($key != 'error') && (!in_array($key, $exclude_array))) $get_url .= $key . '=' . $value . '&';
    }
    return $get_url;
  }

  function gen_get_dates($this_date = '') { // this_date format YYYY-MM-DD
  	$result = array();
	$result['Today']     = ($this_date) ? substr(trim($this_date), 0, 10) : date('Y-m-d', time());
	$result['ThisDay']   = (int)substr($result['Today'], 8, 2);
	$result['ThisMonth'] = (int)substr($result['Today'], 5, 2);
	$result['ThisYear']  = (int)substr($result['Today'], 0, 4);
	$result['TotalDays'] = date('t', mktime( 0, 0, 0, $result['ThisMonth'], $result['ThisDay'], $result['ThisYear']));
	return $result;
  }

  function gen_specific_date($start_date, $day_offset = 0, $month_offset = 0, $year_offset = 0) {
	$date_details = gen_get_dates($start_date);
    if (@date('Y', mktime(0, 0, 0, $date_details['ThisMonth'], $date_details['ThisDay'], $date_details['ThisYear'])) == $date_details['ThisYear']) {
      return date('Y-m-d', mktime(0, 0, 0, $date_details['ThisMonth'] + $month_offset, $date_details['ThisDay'] + $day_offset, $date_details['ThisYear'] + $year_offset));
    } else {
      return preg_replace('2037' . '$', $date_details['ThisYear'], date('Y-m-d', mktime(0, 0, 0, $date_details['ThisMonth'] + $month_offset, $date_details['ThisDay'] + $day_offset, 2037)));
    }
  }

  function gen_calculate_fiscal_dates($period) {
	global $db, $messageStack;

	$result = $db->Execute("select fiscal_year, start_date, end_date from " . TABLE_ACCOUNTING_PERIODS . " 
		where period = " . $period);
	if ($result->RecordCount() <> 1) { // post_date is out of range of defined accounting periods
		$messageStack->add(ERROR_MSG_POST_DATE_NOT_IN_FISCAL_YEAR,'error');
		return false;
	}
	return $result->fields;
  }

  // builds sql date string and description string based on passed criteria
  // function requires as input an associative array with two entries:
  // df = database fieldname for the sql date search
  // date_prefs = imploded (:) string with three entries
  //    entry 1 => date range specfication for switch statement
  //    entry 2 => start date value db format
  //    entry 3 => end date value db format
  function gen_build_sql_date($date_prefs, $df) {
  	global $db;
	$dates = gen_get_dates();
	$DateArray = explode(':', $date_prefs);
	$t = time();
	$ds = '0000-00-00'; // pick a start date a long time ago
	$de = '2199-00-00'; // pick an end date a long time from now
	switch ($DateArray[0]) { // based on the date choice selected
		default:
		case "a": // All, skip the date addition to the where statement, all dates in db
			$d = '';
			$fildesc = '';
			break;
		case "b": // Date Range
			$d = '';
			$fildesc = RW_RPT_DATERANGE;
			if ($DateArray[1] <> '') {
				$ds = gen_db_date_short($DateArray[1]);
				$d .= $df . " >= '" . $ds . "'";
				$fildesc .= ' ' . TEXT_FROM . ' ' . $DateArray[1];
			}
			if ($DateArray[2] <> '') { // a value entered, check
				if (strlen($d) > 0) $d .= ' and ';
				$de = gen_specific_date(gen_db_date_short($DateArray[2]), 1);
				$d .= $df . " < '" . $de . "'";
				$fildesc .= ' ' . TEXT_TO . ' ' . $DateArray[2];
			}
			$fildesc .= '; ';			
			break;
		case "c": // Today (specify range for datetime type fields to match for time parts)
			$ds = $dates['Today'];
			$de = gen_specific_date($dates['Today'], 1);
			$d = $df . " >= '" . $ds . "' and " . $df . " < '" . $de . "'";
			$fildesc = RW_RPT_DATERANGE . ' = ' . gen_date_short($dates['Today']) . '; ';
			break;
		case "d": // This Week
			$ds = date('Y-m-d', mktime(0, 0, 0, $dates['ThisMonth'], date('j', $t) - date('w', $t), $dates['ThisYear']));
			$de = gen_specific_date(date('Y-m-d', mktime(0, 0, 0, $dates['ThisMonth'], date('j', $t) - date('w', $t)+6, $dates['ThisYear'])), 1);
			$d = $df . " >= '" . $ds . "' and " . $df . " < '" . $de . "'";
			$fildesc = RW_RPT_DATERANGE . ' ' . TEXT_FROM . ' ' . gen_date_short($ds) . ' ' . TEXT_TO . ' ' . gen_date_short(gen_specific_date($de, -1)) . '; ';
			break;
		case "e": // This Week to Date
			$ds = date('Y-m-d', mktime(0, 0, 0, $dates['ThisMonth'], date('j', $t)-date('w', $t), $dates['ThisYear']));
			$de = gen_specific_date($dates['Today'], 1);
			$d = $df . " >= '" . $ds . "' and " . $df . " < '" . $de . "'";
			$fildesc = RW_RPT_DATERANGE . ' ' . TEXT_FROM . ' ' . gen_date_short($ds) . ' ' . TEXT_TO . ' ' . gen_date_short($dates['Today']) . '; ';
			break;
		case "f": // This Month
			$ds = date('Y-m-d', mktime(0, 0, 0, $dates['ThisMonth'], 1, $dates['ThisYear']));
			$de = gen_specific_date(date('Y-m-d', mktime(0, 0, 0, $dates['ThisMonth'], $dates['TotalDays'], $dates['ThisYear'])), 1);
			$d = $df . " >= '" . $ds . "' and " . $df . " < '" . $de . "'";
			$fildesc = RW_RPT_DATERANGE . ' ' . TEXT_FROM . ' ' . gen_date_short($ds) . ' ' . TEXT_TO . ' ' . gen_date_short(gen_specific_date($de, -1)) . '; ';
			break;
		case "g": // This Month to Date
			$ds = date('Y-m-d', mktime(0, 0, 0, $dates['ThisMonth'], 1, $dates['ThisYear']));
			$de = gen_specific_date($dates['Today'], 1);
			$d = $df . " >= '" . $ds . "' and " . $df . " < '" . $de . "'";
			$fildesc = RW_RPT_DATERANGE . ' ' . TEXT_FROM . ' ' . gen_date_short($ds) . ' ' . TEXT_TO . ' ' . gen_date_short($dates['Today']) . '; ';
			break;
		case "h": // This Quarter
			$QtrStrt = CURRENT_ACCOUNTING_PERIOD - ((CURRENT_ACCOUNTING_PERIOD - 1) % 3);
			$temp = gen_calculate_fiscal_dates($QtrStrt);
			$ds = $temp['start_date'];
			$temp = gen_calculate_fiscal_dates($QtrStrt + 2);
			$de = gen_specific_date($temp['end_date'], 1);
			$d = $df . " >= '" . $ds . "' and " . $df . " < '" . $de . "'";
			$fildesc = RW_RPT_DATERANGE . ' ' . TEXT_FROM . ' ' . gen_date_short($ds) . ' ' . TEXT_TO . ' ' . gen_date_short($temp['end_date']) . '; ';
			break;
		case "i": // Quarter to Date
			$QtrStrt = CURRENT_ACCOUNTING_PERIOD - ((CURRENT_ACCOUNTING_PERIOD - 1) % 3);
			$temp = gen_calculate_fiscal_dates($QtrStrt);
			$ds = $temp['start_date'];
			$de = gen_specific_date($dates['Today'], 1);
			$d = $df . " >= '" . $ds . "' and " . $df . " < '" . $de . "'";
			$fildesc = RW_RPT_DATERANGE . ' ' . TEXT_FROM . ' ' . gen_date_short($ds) . ' ' . TEXT_TO . ' ' . gen_date_short($dates['Today']) . '; ';
			break;
		case "j": // This Year
			$YrStrt = CURRENT_ACCOUNTING_PERIOD - ((CURRENT_ACCOUNTING_PERIOD - 1) % 12);
			$temp = gen_calculate_fiscal_dates($YrStrt);
			$ds = $temp['start_date'];
			$temp = gen_calculate_fiscal_dates($YrStrt + 11);
			$de = gen_specific_date($temp['end_date'], 1);
			$d = $df . " >= '" . $ds . "' and " . $df . " < '" . $de . "'";
			$fildesc = RW_RPT_DATERANGE . ' ' . TEXT_FROM . ' ' . gen_date_short($ds) . ' ' . TEXT_TO . ' ' . gen_date_short($temp['end_date']) . '; ';
			break;
		case "k": // Year to Date
			$YrStrt = CURRENT_ACCOUNTING_PERIOD - ((CURRENT_ACCOUNTING_PERIOD - 1) % 12);
			$temp = gen_calculate_fiscal_dates($YrStrt);
			$ds = $temp['start_date'];
			$de = gen_specific_date($dates['Today'], 1);
			$d = $df . " >= '" . $ds . "' and " . $df . " < '" . $de . "'";
			$fildesc = RW_RPT_DATERANGE . ' ' . TEXT_FROM . ' ' . gen_date_short($ds) . ' ' . TEXT_TO . ' ' . gen_date_short($dates['Today']) . '; ';
			break;
		case "l": // This Period
			$ds = CURRENT_ACCOUNTING_PERIOD_START;
			$de = gen_specific_date(CURRENT_ACCOUNTING_PERIOD_END, 1);
			$d = $df . " >= '" . $ds . "' and " . $df . " < '" . $de . "'";
			$fildesc = TEXT_PERIOD . ' ' . CURRENT_ACCOUNTING_PERIOD . ' (' . gen_date_short(CURRENT_ACCOUNTING_PERIOD_START) . ' ' . TEXT_TO . ' ' . gen_date_short(CURRENT_ACCOUNTING_PERIOD_END) . '); ';
			break;
		case "z": // date by period
			$temp = gen_calculate_fiscal_dates($DateArray[1]);
			$ds = $temp['start_date'];
			$de = $temp['end_date'];
			$d = 'period = ' . $DateArray[1];
			$fildesc = TEXT_PERIOD . ' ' . $DateArray[1] . ' (' . gen_date_short($ds) . ' ' . TEXT_TO . ' ' . gen_date_short($de) . '); ';
			break;
	}
	$dates = array(
		'sql'         => $d, 
		'description' => $fildesc,
		'start_date'  => $ds,
		'end_date'    => $de,
	);
	return $dates;
  }

// $raw_date needs to be in this format: YYYY-MM-DD HH:MM:SS
  function gen_date_short($raw_date) {
    if ( ($raw_date == '0001-01-01 00:00:00') || ($raw_date == '') ) return false;
    $year   =      substr($raw_date, 0, 4);
    $month  = (int)substr($raw_date, 5, 2);
    $day    = (int)substr($raw_date, 8, 2);
    $hour   = (int)substr($raw_date, 11, 2);
    $minute = (int)substr($raw_date, 14, 2);
    $second = (int)substr($raw_date, 17, 2);
    return date(DATE_FORMAT, mktime($hour, $minute, $second, $month, $day, $year));
  }

  function gen_db_date_short($raw_date = '', $separator = '/') { 
  	global $messageStack;
    // handles periods (.), dashes (-), and slashes (/) as date separators
    if ($raw_date == '') return false;
	if (strpos($raw_date, '.') !== false) $separator = '.';
	if (strpos($raw_date, '-') !== false) $separator = '-';
	$date_vals = explode($separator, DATE_FORMAT);
	$parts = explode($separator, $raw_date);
	foreach ($date_vals as $key => $position) {
	  switch ($position) {
	    case 'Y': 
		  $year = substr('20' . $parts[$key], -4, 4); break; // if its a two digit year, assume 20xx and take the last four digits
	    case 'm': 
		  $month = substr('0' . $parts[$key], -2, 2); break;
	    case 'd': 
		  $day = substr('0' . $parts[$key], -2, 2); break;
	  }
	}
	$error = false;
	if ($month < 1 || $month > 12) $error = true;
	if ($day < 1 || $day > 31) $error = true;
	if ($year < 1900 || $year > 2099) $error = true;
	if ($error) {
		$messageStack->add(sprintf(GEN_CALENDAR_FORMAT_ERROR, $raw_date),'error');
        return date($cal_format, time());
	}
	return $year . '-' . $month . '-' . $day;
  }

  function gen_spiffycal_db_date_short($raw_date) {	// from db to spiffycal format
  	global $messageStack;
    if (($raw_date == '0000-00-00 00:00:00') || ($raw_date == '0000-00-00') || ($raw_date == '')) return false;
    $year  = substr($raw_date, 0, 4);
    $month = substr($raw_date, 5, 2);
    $day   = substr($raw_date, 8, 2);
	// clean up the Spiffycal format to work with the date function
	$cal_format =  preg_replace(array('/MM/', '/dd/', '/yyyy/'), array('m', 'd', 'Y'), DATE_FORMAT_SPIFFYCAL);
	$error = false;
	if ($month < 1 || $month > 12) $error = true;
	if ($day < 1 || $day > 31) $error = true;
	if ($year < 1900 || $year > 2099) $error = true;
	if ($error) {
		$messageStack->add(sprintf(GEN_CALENDAR_FORMAT_ERROR, $raw_date),'error');
		return date($cal_format, time());
	}
    return date($cal_format, mktime(0, 0, 0, $month, $day, $year));
  }

  function gen_datetime_short($raw_datetime) {
    if ($raw_datetime == '0000-00-00 00:00:00' || $raw_datetime == '') return false;
    $year   = (int)substr($raw_datetime, 0, 4);
    $month  = (int)substr($raw_datetime, 5, 2);
    $day    = (int)substr($raw_datetime, 8, 2);
    $hour   = (int)substr($raw_datetime, 11, 2);
    $minute = (int)substr($raw_datetime, 14, 2);
    $second = (int)substr($raw_datetime, 17, 2);
    return date(DATE_TIME_FORMAT, mktime($hour, $minute, $second, $month, $day, $year));
  }

  function gen_get_country_iso_2($country_id) {
    global $db;
    $country = $db->Execute("select countries_iso_code_2
                             from " . TABLE_COUNTRIES . "
                             where countries_id = '" . (int)$country_id . "'");
    if ($country->RecordCount() < 1) {
      return $country_id;
    } else {
      return $country->fields['countries_iso_code_2'];
    }
  }

  function gen_get_country_iso_2_from_3($country_iso_code_3) {
    global $db;
    $country = $db->Execute("select countries_iso_code_2
                             from " . TABLE_COUNTRIES . "
                             where countries_iso_code_3 = '" . $country_iso_code_3 . "'");
    if ($country->RecordCount() < 1) {
      return $country_id;
    } else {
      return $country->fields['countries_iso_code_2'];
    }
  }

  function gen_get_country_iso_3_from_2($country_iso_code_2) {
    global $db;
    $country = $db->Execute("select countries_iso_code_3
                             from " . TABLE_COUNTRIES . "
                             where countries_iso_code_2 = '" . $country_iso_code_2 . "'");

    if ($country->RecordCount() < 1) {
      return $country_id;
    } else {
      return $country->fields['countries_iso_code_3'];
    }
  }

////
// Returns an array with countries
  function gen_get_countries($choose = false, $iso_chars = 'ISO_3') {
    global $db;
    $countries = $db->Execute("select countries_id, countries_iso_code_2, countries_iso_code_3, countries_name
                               from " . TABLE_COUNTRIES . " order by countries_name");
    $countries_array = array();
    if ($choose) $countries_array[] = array('id' => 0, 'text' => GEN_HEADING_PLEASE_SELECT);
    while (!$countries->EOF) {
	  if ($iso_chars == 'ISO_3') {
		  $countries_array[] = array('id' => $countries->fields['countries_iso_code_3'],
									 'text' => $countries->fields['countries_name']);
	  } elseif ($iso_chars == 'ISO_2') {
		  $countries_array[] = array('id' => $countries->fields['countries_iso_code_2'],
									 'text' => $countries->fields['countries_name']);
	  } else {
		  $countries_array[] = array('id' => $countries->fields['countries_id'],
									 'text' => $countries->fields['countries_name']);
	  }
	  $countries->MoveNext();
    }
    return $countries_array;
  }

////
// Sets timeout for the current script. Cant be used in safe mode.
  function gen_set_time_limit($limit) {
    if (!get_cfg_var('safe_mode')) {
      @set_time_limit($limit);
    }
  }

  function gen_get_top_level_domain($url) {
    if (strpos($url, '://')) {
      $url = parse_url($url);
      $url = $url['host'];
    }
    $domain_array = explode('.', $url);
    $domain_size = sizeof($domain_array);
    if ($domain_size > 1) {
      if (SESSION_USE_FQDN == 'True') return $url;
      if (is_numeric($domain_array[$domain_size-2]) && is_numeric($domain_array[$domain_size-1])) {
        return false;
      } else {
        if ($domain_size > 3) {
          return $domain_array[$domain_size-3] . '.' . $domain_array[$domain_size-2] . '.' . $domain_array[$domain_size-1];
        } else {
          return $domain_array[$domain_size-2] . '.' . $domain_array[$domain_size-1];
        }
      }
    } else {
      return false;
    }
  }

////
// configuration key value lookup
  function gen_get_configuration_key_value($lookup) {
    global $db;
    $configuration_query= $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key='" . $lookup . "'");
    $lookup_value= $configuration_query->fields['configuration_value'];
    if ( $configuration_query->RecordCount() == 0 ) {
      $lookup_value='<font color="FF0000">' . $lookup . '</font>';
    }
    return $lookup_value;
  }

  function get_ip_address() {
    if (isset($_SERVER)) {
      if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
      } else {
        $ip = $_SERVER['REMOTE_ADDR'];
      }
    } else {
      if (getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
      } elseif (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
      } else {
        $ip = getenv('REMOTE_ADDR');
      }
    }
    return $ip;
  }

////
// Return a random value
  function general_rand($min = null, $max = null) {
    static $seeded;
    if (!$seeded) {
      mt_srand((double)microtime()*1000000);
      $seeded = true;
    }
    if (isset($min) && isset($max)) {
      if ($min >= $max) {
        return $min;
      } else {
        return mt_rand($min, $max);
      }
    } else {
      return mt_rand();
    }
  }

  function arr2string($arr) {
    if (!is_array($arr)) return $arr;
    $output = "Array (";
	if (sizeof($arr) > 0) {
	  foreach ($arr as $key => $val) {
	    if (is_array($val)) {
	  	  $output .= ' [' . $key . '] => ' . arr2string($val);
		} else {
	  	  $output .= ' [' . $key . '] => ' . $val;
		}
	  }
	}
	$output .= ' )';
	return $output;
  }

  function string_increment($string, $increment = 1) {
	$string++; // just use the built in PHP operation
	return $string;
  }

  function install_blank_webpage($filename) {
    global $messageStack;
  	$blank_web = '<html>
  <head>
    <title></title>
    <meta content="">
    <style></style>
  </head>
  <body>&nbsp;</body>
</html>';
	if (!$handle = @fopen($filename, 'w')) {
	  $messageStack->add('Cannot open file (' . $filename . ') for writing check your permissions.', 'error');
	  return false;
	}
	fwrite($handle, $blank_web);
	fclose($handle);
	return true;
  }

  function load_service_modules($module_type) {
	global $PHP_SELF;
	$file_extension = substr($PHP_SELF, strrpos($PHP_SELF, '.'));
  	$directory_array = array();
  	$standard_module_dir = DIR_WS_MODULES . 'services/' . $module_type . '/modules/';

	// standard modules
	if ($dir = @dir($standard_module_dir)) {
	    while ($file = $dir->read()) {
	        if (!is_dir($standard_module_dir . $file)) {
	            if (substr($file, strrpos($file, '.')) == $file_extension) {
	                $modules_names[] = substr($file, 0, strrpos($file, '.'));
	            }
	        }
	    }
	    $dir->close();
	}
	
    // custom modules
    $custom_module_dir = DIR_FS_MY_FILES .  'custom/services/' . $module_type . '/modules/';
    if ($dir = @dir($custom_module_dir)) {
        while ($file = $dir->read()) {
            if (!is_dir($custom_module_dir . $file)) {
                if (substr($file, strrpos($file, '.')) == $file_extension) {
                    $modules_names[] = substr($file, 0, strrpos($file, '.'));
                }
            }
        }
    	$dir->close();
	}	
    sort($modules_names);

    $class = array();
    foreach ($modules_names as $module_name) {
        $class[] = load_service_module($module_type, $module_name); 
    }
    
    return  $class;
  }

  function load_service_module($module_type, $module_name) {
    global $PHP_SELF;
	$file_extension = substr($PHP_SELF, strrpos($PHP_SELF, '.'));
    $standard_module_dir = DIR_WS_MODULES . 'services/' . $module_type . '/modules/';
    $custom_module_dir = DIR_FS_MY_FILES .  'custom/services/' . $module_type . '/modules/';
    $file = $module_name . $file_extension;
    
    if (file_exists($standard_module_dir . $file)) {
        include_once($standard_module_dir . '../language/' . $_SESSION['language'] . '/modules/' . $file);
        include_once($standard_module_dir . $file);
    } else {
        include_once($custom_module_dir . '../language/' . $_SESSION['language'] . '/modules/' . $file);
        include_once($custom_module_dir . $file);
    }
    return $module_name;
  }

?>