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
//  Path: /modules/services/import_export/functions/import_export.php
//

// Tables that use the address book (to get their codes for alignment)
$address_tables = array(TABLE_CONTACTS => 'c');

// Note: corresponding entries in function ie_process_the_data must exist
$imp_exp_funcs[] = array('id' => 'none',      'text' => TEXT_NONE);
$imp_exp_funcs[] = array('id' => 'real_r2',   'text' => RW_FRM_CNVTDLR);
$imp_exp_funcs[] = array('id' => 'date',      'text' => TEXT_DATE);
$imp_exp_funcs[] = array('id' => 'date-time', 'text' => RW_FRM_DATE_TIME);
$imp_exp_funcs[] = array('id' => 'trim',      'text' => TEXT_TRIM);

function ie_process_the_data($value, $process_key, $export = true) {
	global $currencies;
	switch ($process_key) {
		case 'real_r2': return $currencies->clean_value($value);
		case 'date':	// assumes m/d/yyyy format
			if ($export) {
				return date(DATE_FORMAT, strtotime($value));
			} else {
				return gen_db_date_short($value, $separator = '/');
			}
		case 'date-time':
			return date(DATE_TIME_FORMAT, strtotime($value));
		case 'trim':
			return trim($value);
		case 'none': return $value;
		default: return $value;
	}
}

// Criteria functions
$criteria_funcs[] = array('id' => 'all_range',             'text' => TEXT_ALL . ':' . TEXT_RANGE);
$criteria_funcs[] = array('id' => 'date',                  'text' => TEXT_DATE);
$criteria_funcs[] = array('id' => 'all_yes_no',            'text' => TEXT_ALL . ':' . TEXT_YES . ':' . TEXT_NO);
$criteria_funcs[] = array('id' => 'all_active_inactive',   'text' => TEXT_ALL . ':' . TEXT_ACTIVE . ':' . TEXT_INACTIVE);
$criteria_funcs[] = array('id' => 'all_printed_unprinted', 'text' => TEXT_ALL . ':' . TEXT_PRINTED . ':' . TEXT_UNPRINTED);

// Text qualifiers
$qualifiers[] = array('id' => 'none',         'text' => TEXT_NONE);
$qualifiers[] = array('id' => 'single_quote', 'text' => RW_FRM_QUOTE_SINGLE);
$qualifiers[] = array('id' => 'double_quote', 'text' => RW_FRM_QUOTE_DOUBLE);

function ie_fetch_qualifier($choice) {
	switch ($choice) {
		case 'none':         $qualifier = '';  break;
		case 'single_quote': $qualifier = "'"; break;
		case 'double_quote': 
		default:             $qualifier = '"';
	}
	return $qualifier;
}

// Field delimiters
$delimiters[] = array('id' => 'tab',   'text' => RW_FRM_TAB);
$delimiters[] = array('id' => 'comma', 'text' => RW_FRM_COMMA);

function ie_fetch_delimiter($choice) {
	switch ($choice) {
		case 'tab':   $delimiter = "\t"; break;
		case 'comma': 
		default:      $delimiter = ',';
	}
	return $delimiter;
}

////
// Synchronizes the fields in the db with the field parameters 
// (usually only needed for first entry to inventory field builder)
function ie_sync_field_list($params, $table_name) {
	global $max_num_addresses;
	global $db;
	$use_address_book = ($table_name == TABLE_CONTACTS) ? true : false;
	// First check to see if field table is synced with actual inventory table
	$temp = $db->Execute("describe " . $table_name);
	while (!$temp->EOF) {
		$table_fields[] = $temp->fields['Field'];
		$temp->MoveNext();
	}

	if ($use_address_book) {
		$address_type = array('mail', 'ship', 'bill');
		foreach ($address_type as $value) {
			$num_addresses = ($value == 'mail') ? 1 : MAX_NUM_ADDRESSES;
			for ($i=0; $i<$num_addresses; $i++ ) {
				$table_fields[] = $value . ' primary_name '   . ($i+1);
				$table_fields[] = $value . ' contact '        . ($i+1);
				$table_fields[] = $value . ' address1 '       . ($i+1);
				$table_fields[] = $value . ' address2 '       . ($i+1);
				$table_fields[] = $value . ' city_town '      . ($i+1);
				$table_fields[] = $value . ' state_province ' . ($i+1);
				$table_fields[] = $value . ' postal_code '    . ($i+1);
				$table_fields[] = $value . ' country_code '   . ($i+1);
				$table_fields[] = $value . ' telephone1 '     . ($i+1);
				$table_fields[] = $value . ' telephone2 '     . ($i+1);
				$table_fields[] = $value . ' telephone3 '     . ($i+1);
				$table_fields[] = $value . ' telephone4 '     . ($i+1);
				$table_fields[] = $value . ' email '          . ($i+1);
				$table_fields[] = $value . ' website '        . ($i+1);
				$table_fields[] = $value . ' notes '          . ($i+1);
			}
		}
	}

	if (is_array($params)) {
		foreach ($params as $value) {
			$field_list[] = $value['field'];
		}
		sort($field_list);
	} else {
		$field_list = '';
	}
	$needs_sync = false;
	foreach ($table_fields as $key=>$value) {
		if ($value <> $field_list[$key]) {
			$needs_sync = true;
			break;
		}
	}
	if ($needs_sync) {
		if (is_array($field_list)) { // table may have been changed, update the parameters array
			$add_list = array_diff($table_fields, $field_list);
			$delete_list = array_diff($field_list, $table_fields);
		} else { // the table is new, build parameters array
			$add_list = $table_fields;
			$delete_list = '';
		}
		if (!is_array($params)) $params = array();
		if (isset($add_list)) {
			foreach ($add_list as $value) {
				$index = count($params); // index becomes the new sequence position
				$params[$index]['field'] = $value;
				$params[$index]['name'] = $value;
				$params[$index]['proc'] = 'none';
				$params[$index]['mode'] = 'b';
				$params[$index]['show'] = '0';
			}
		}
		if ($delete_list) {
			foreach ($delete_list as $value) {
				foreach ($params as $index=>$field) {
					if ($field['field'] == $value) {
						array_splice($params, $index, 1);
						break;
					}
				}
			}
		}
	}
	return $params;
}

function ie_read_io_form_data() {
	$choices = array();
	$choices['id'] = db_prepare_input($_GET['id']);

	// criteria parameters
	$cnt = 0;
	while (isset($_POST[$value . 'cfield_' . $cnt])) {
		$choices['criteria'][$cnt]['cfield'] = db_prepare_input($_POST['cfield_' . $cnt]);
		$choices['criteria'][$cnt]['ctype'] = db_prepare_input($_POST['ctype_' . $cnt]);
		$choices['criteria'][$cnt]['crit'] = db_prepare_input($_POST['crit_' . $cnt]);
		$choices['criteria'][$cnt]['from'] = db_prepare_input($_POST['from_' . $cnt]);
		$choices['criteria'][$cnt]['to'] = db_prepare_input($_POST['to_' . $cnt]);
		$cnt++;
	}
	$choices['new_crit']['new_cname'] = db_prepare_input($_POST['new_cname']);
	$choices['new_crit']['new_crit'] = db_prepare_input($_POST['new_crit']);
	// option parameters
	$choices['options']['delimiter'] = db_prepare_input($_POST['delimiter']);
	$choices['options']['qualifier'] = db_prepare_input($_POST['qualifier']);
	$choices['options']['import_file_name'] = db_prepare_input($_POST['import_file_name']);
	$choices['options']['imp_headings'] = db_prepare_input($_POST['imp_headings']);
	$choices['options']['export_file_name'] = db_prepare_input($_POST['export_file_name']);
	$choices['options']['exp_headings'] = db_prepare_input($_POST['exp_headings']);

// TBD - validate input

	return $choices;
}

function ie_convert_criteria_types($type = 'all_range') {
	$dropdown_array = array();
	switch ($type) {
		case 'all_range':
			$dropdown_array[] = array('id' => 'all', 'text' => TEXT_ALL);
			$dropdown_array[] = array('id' => 'range', 'text' => TEXT_RANGE);
			break;
		case 'date':
			$dropdown_array[] = array('id' => 'all', 'text' => TEXT_ALL);
			$dropdown_array[] = array('id' => 'date_range', 'text' => TEXT_RANGE);
			$dropdown_array[] = array('id' => 'date_today', 'text' => TEXT_TODAY);
			$dropdown_array[] = array('id' => 'date_week', 'text' => TEXT_WEEK);
			$dropdown_array[] = array('id' => 'date_wtd', 'text' => TEXT_WTD);
			$dropdown_array[] = array('id' => 'date_month', 'text' => TEXT_MONTH);
			$dropdown_array[] = array('id' => 'period', 'text' => TEXT_PERIOD);
			$dropdown_array[] = array('id' => 'date_mtd', 'text' => TEXT_MTD);
			$dropdown_array[] = array('id' => 'date_qtr', 'text' => TEXT_QUARTER);
			$dropdown_array[] = array('id' => 'date_qtd', 'text' => TEXT_QTD);
			$dropdown_array[] = array('id' => 'date_year', 'text' => TEXT_YEAR);
			$dropdown_array[] = array('id' => 'date_ytd', 'text' => TEXT_YTD);
			break;
		case 'all_yes_no':
			$dropdown_array[] = array('id' => 'all', 'text' => TEXT_ALL);
			$dropdown_array[] = array('id' => 'yes', 'text' => TEXT_YES);
			$dropdown_array[] = array('id' => 'no', 'text' => TEXT_NO);
			break;
		case 'all_active_inactive':
			$dropdown_array[] = array('id' => 'all', 'text' => TEXT_ALL);
			$dropdown_array[] = array('id' => 'active', 'text' => TEXT_ACTIVE);
			$dropdown_array[] = array('id' => 'inactive', 'text' => TEXT_INACTIVE);
			break;
		case 'all_printed_unprinted':
			$dropdown_array[] = array('id' => 'all', 'text' => TEXT_ALL);
			$dropdown_array[] = array('id' => 'printed', 'text' => TEXT_PRINTED);
			$dropdown_array[] = array('id' => 'unprinted', 'text' => TEXT_UNPRINTED);
			break;
		default:
	}
	return $dropdown_array;
}

function ie_longest_line_length($handle) { // find the length of the longest row of an uploaded text file
	$length = 1;
	$array = file($handle);
	for ($i=0; $i<count($array); $i++) {
		$linelength = strlen($array[$i]);
    	if ($length < $linelength) $length = $linelength;
	}
	return $length;
}

function ie_find_field_name($needle, $haystack) {
	foreach ($haystack as $value) {
		if ($value['field'] == $needle) return $value['name'];
	}
	return TEXT_NONE;
}

function ie_implode($parts_array, $delimiter = ',', $qualifier = '"') {
	$output = '';
	if (is_array($parts_array)) {
		foreach ($parts_array as $part) {
			if (strpos($part, $delimiter) !== false) {
				$part = $qualifier . $part . $qualifier;
			}
			$output .= $part . $delimiter;
		}
		$output = substr($output, 0, -1);
	}
	return $output;
}

function ie_explode($parts_string, $delimiter = ',', $qualifier = '"') {
	global $messageStack;
	$correctParts = array();
	$correctIndex = 0;
	$insideEncaps = false;
	foreach ($parts_string as $part) {
		$numEncaps = substr_count( $part, $qualifier );
		if (!$insideEncaps) {
			switch ( $numEncaps ) {
				case 1:
					$correctParts[$correctIndex] = str_replace($qualifier, '', $part);
					$insideEncaps = true;
					break;
				case 0:
				case 2:
					$correctParts[$correctIndex++] = str_replace($qualifier, '', $part);
					break;
				default:
					$messageStack->add(TEXT_IMP_ERMSG14 . htmlspecialchars($part), 'error');
			}
		} else {
			switch ($numEncaps) {
				case 0:
					$correctParts[$correctIndex] .= ';' . str_replace($qualifier, '', $part);
					break;
				case 1:
					$correctParts[$correctIndex++] .= ';' . str_replace($qualifier, '', $part);
					$insideEncaps = false;
					break;
				default:
					$messageStack->add(TEXT_IMP_ERMSG14 . htmlspecialchars($part), 'error');
			}
		}
	}
	return $correctParts;
}

function ie_import_data($prefs, $params, $criteria, $options) {
	global $db;
	global $messageStack;
	global $qualifiers, $delimiters, $address_tables;
	if ($prefs['table_name'] == TABLE_CONTACTS) {
		$use_address_book = true; 
		switch ($prefs['group_id']) {
			case 'ar':
				$account_type = 'c'; break;// customers
			case 'ap':
				$account_type = 'v'; break; // vendors
			case 'hr':
				$account_type = 'e'; // employees
		}
	} else {
		$use_address_book = false; 
	}
	// first verify the file was uploaded ok
	if (!validate_upload('import_file_name', 'text', 'csv')) return false;

	// build the mapping arrays to point field names to proper position in import order
	$data[0] = array();
	if ($use_address_book) {
		$mail[0] = array();
		for ($i=0; $i < MAX_NUM_ADDRESSES; $i++) {
			$ship[$i] = array();
			$bill[$i] = array();
		}
	}
	$index = 0;
	$found_primary_key = false;
	$element_processing = array();
	foreach ($params as $field) {
		if ($field['show'] && ($field['mode'] == 'i' || $field['mode'] == 'b')) {
			if ($use_address_book && substr($field['field'], 0, 5) == 'mail ') {
				$temp = explode(' ', $field['field']);
				$mail[0][$temp[1]] = $index;
			} elseif ($use_address_book && substr($field['field'], 0, 5) == 'ship ') {
				$temp = explode(' ', $field['field']);
				$ship[($temp[2]-1)][$temp[1]] = $index;
			} elseif ($use_address_book && substr($field['field'], 0, 5) == 'bill ') {
				$temp = explode(' ', $field['field']);
				$bill[($temp[2]-1)][$temp[1]] = $index;
			} else {
				if ($field['field'] == $prefs['primary_key_field']) {
					$found_primary_key = true;
				}
				$data[0][$field['field']] = $index;
			}
			$element_processing[$index] = $field['proc']; // needed for processing of each input value
			$index++;
		}
	}

	// A primary key is necessary for every import to check for updates versus new entries.
	if (!$found_primary_key) {
		$messageStack->add(TEXT_IMP_ERMSG15 . $prefs['primary_key_field'], 'error');
		return false;
	}

	// fetch the delimiters and text qualifiers
	$delimiter = ie_fetch_delimiter($options['delimiter']);
	$qualifier = ie_fetch_qualifier($options['qualifier']);

	// find the length of the longest row for the parser
	$length = ie_longest_line_length($_FILES['import_file_name']['tmp_name']);
	// ready to process the import file
	$skip_first_row = ($options['imp_headings'] == '1') ? true : false;
	$handle = fopen($_FILES['import_file_name']['tmp_name'], "r");
	while (($row_data = fgetcsv($handle, $length, $delimiter)) !== FALSE) {
		if ($skip_first_row) {
			$skip_first_row = false;
			continue;
		}
		if ($qualifier <> '') $row_data = ie_explode($row_data, $delimiter, $qualifier);
		// process the main table data
		$sql_data_array = array();
		if ($prefs['table_name'] == TABLE_CONTACTS) $sql_data_array['type'] = $account_type;
		foreach ($data[0] as $key => $value) {
			if ($key == $prefs['primary_key_field']) $key_value = db_input($row_data[$value]);
			$sql_data_array[$key] = ie_process_the_data($row_data[$value], $element_processing[$value], false);
		}
		$sql = "select id from " . $prefs['table_name'] . " 
			where " . $prefs['primary_key_field'] . " = '" . $key_value . "'";
		$found_row = $db->Execute($sql);
		if ($found_row->RecordCount()) {
			db_perform($prefs['table_name'], $sql_data_array, 'update', $prefs['primary_key_field'] . " = '" . $key_value . "'");
			$id = $found_row->fields['id'];
		} else {
			db_perform($prefs['table_name'], $sql_data_array, 'insert');
			$id = db_insert_id();
		}
		// update the address book, if necessary
		if ($use_address_book) {
			// fetch the id to use to link addresses to the correct main record
			$address_type = array($account_type.'m' =>$mail, $account_type.'s' => $ship, $account_type.'b' => $bill);
			foreach ($address_type as $type => $array_name) {
				for ($i=0; $i<count($array_name); $i++ ) {
					$sql_data_array = array();
					foreach ($array_name[$i] as $key => $value) {
						if ($key == 'primary_name') $key_value = db_input($row_data[$value]);
						$sql_data_array[$key] = ie_process_the_data($row_data[$value], $element_processing[$value], false);
					}
					if (count($sql_data_array) > 0) { // we have data to add to the address book
						$sql_data_array['type'] = $type;
						$sql_data_array['ref_id'] = $id;
						$sql = "select address_id from " . TABLE_ADDRESS_BOOK . " 
							where type = '" . $sql_data_array['type'] . "' 
							and ref_id = '" . $sql_data_array['ref_id'] . "'";
						// uniqueness test for all but mailing addresses (only one mail address allowed per entry)
						if ($type <> 'm') $sql .= " and primary_name = '" . $key_value . "'";
						$found_row = $db->Execute($sql);
						if ($found_row->RecordCount()) {
							db_perform(TABLE_ADDRESS_BOOK, $sql_data_array, 'update', "address_id = '" . $found_row->fields['address_id'] . "'");
						} else {
							db_perform(TABLE_ADDRESS_BOOK, $sql_data_array, 'insert');
						}
					}
				}
			}
		}
	}
	fclose($handle);
	$messageStack->add(TEXT_IMP_ERMSG11, 'success');
	return true;
}

function ie_export_data($prefs, $params, $criteria, $options) {
	global $db, $messageStack;
	global $qualifiers, $delimiters, $address_tables;
	if ($prefs['table_name'] == TABLE_CONTACTS) {
		$use_address_book = true; 
		switch ($prefs['group_id']) {
			case 'ar':
				$account_type = 'c'; break;// customers
			case 'ap':
				$account_type = 'v'; break; // vendors
			case 'hr':
				$account_type = 'e'; // employees
		}
	} else {
		$use_address_book = false; 
	}
	// build the mapping arrays to point field names to proper position in export order
	$data = array();
	$element_processing = array();
	if ($use_address_book) {
		$mail[0] = array();
		for ($i=0; $i < MAX_NUM_ADDRESSES; $i++) {
			$ship[$i] = array();
			$bill[$i] = array();
		}
	}
	$index = 0;
	foreach ($params as $field) {
		if ($field['show'] && ($field['mode'] == 'e' || $field['mode'] == 'b')) {
			if ($use_address_book && substr($field['field'], 0, 5) == 'mail ') {
				$temp = explode(' ', $field['field']);
				$mail[0][$temp[1]] = $index;
			} elseif ($use_address_book && substr($field['field'], 0, 5) == 'ship ') {
				$temp = explode(' ', $field['field']);
				$ship[($temp[2]-1)][$temp[1]] = $index;
			} elseif ($use_address_book && substr($field['field'], 0, 5) == 'bill ') {
				$temp = explode(' ', $field['field']);
				$bill[($temp[2]-1)][$temp[1]] = $index;
			} else {
				$data[$field['field']] = $index;
			}
			$element_processing[$index] = $field['proc']; // needed for processing of each ouput value
			$index++;
		}
	}

	// fetch the delimiters and text qualifiers
	$delimiter = ie_fetch_delimiter($options['delimiter']);
	$qualifier = ie_fetch_qualifier($options['qualifier']);

	// ready to process the export file
	$output = '';
	if ($options['exp_headings']) {
		$output_line = array();
		foreach ($params as $field) {
			if ($field['show']) $output_line[] = $field['name'];
		}
		$output .= ie_implode($output_line, $delimiter, $qualifier) . chr(10);
	}
	// build export criteria
	$criteria_list = array();
	$description_list = array();
	if (is_array($criteria)) foreach ($criteria as $filter) {
		$filter['name'] = ie_find_field_name($filter['cfield'], $params);
		$address_test = substr($filter['cfield'], 0, 5);
		if ($address_test == 'mail ' || $address_test == 'ship ' || $address_test == 'bill ') {
			$temp = explode(' ', $filter['cfield']);
			$filter['cfield'] = 'a.' . $temp[1];
		} else {
			$filter['cfield'] = 'd.' . $filter['cfield'];
		}
		$crit_data = '';
		$crit_desc = '';
		switch ($filter['crit']) { // based on the date choice selected
			default:
			case "all":
			case "stock": // TBD field to compare so default to nothing
			case "assembly": // TBD field to compare so default to nothing
				break;
			case "date_range":
				$arrData = array('fieldname' => $filter['cfield']);
				$arrData['params'] = implode(':', array('b', $filter['from'], $filter['to']));
				$temp = gen_build_sql_date($arrData['params'], $arrData['fieldname']);
				$crit_data = $temp['sql'];
				$crit_desc = $temp['description'];
				break;
			case "date_today":
				$arrData = array('fieldname' => $filter['cfield']);
				$arrData['params'] = implode(':', array('c', '', ''));
				$temp = gen_build_sql_date($arrData['params'], $arrData['fieldname']);
				$crit_data = $temp['sql'];
				$crit_desc = $temp['description'];
				break;
			case "date_week":
				$arrData = array('fieldname' => $filter['cfield']);
				$arrData['params'] = implode(':', array('d', '', ''));
				$temp = gen_build_sql_date($arrData['params'], $arrData['fieldname']);
				$crit_data = $temp['sql'];
				$crit_desc = $temp['description'];
				break;
			case "date_wtd":
				$arrData = array('fieldname' => $filter['cfield']);
				$arrData['params'] = implode(':', array('e', '', ''));
				$temp = gen_build_sql_date($arrData['params'], $arrData['fieldname']);
				$crit_data = $temp['sql'];
				$crit_desc = $temp['description'];
				break;
			case "date_month":
				$arrData = array('fieldname' => $filter['cfield']);
				$arrData['params'] = implode(':', array('f', '', ''));
				$temp = gen_build_sql_date($arrData['params'], $arrData['fieldname']);
				$crit_data = $temp['sql'];
				$crit_desc = $temp['description'];
				break;
			case "date_mtd":
				$arrData = array('fieldname' => $filter['cfield']);
				$arrData['params'] = implode(':', array('g', '', ''));
				$temp = gen_build_sql_date($arrData['params'], $arrData['fieldname']);
				$crit_data = $temp['sql'];
				$crit_desc = $temp['description'];
				break;
			case "date_qtr":
				$arrData = array('fieldname' => $filter['cfield']);
				$arrData['params'] = implode(':', array('h', '', ''));
				$temp = gen_build_sql_date($arrData['params'], $arrData['fieldname']);
				$crit_data = $temp['sql'];
				$crit_desc = $temp['description'];
				break;
			case "date_qtd":
				$arrData = array('fieldname' => $filter['cfield']);
				$arrData['params'] = implode(':', array('i', '', ''));
				$temp = gen_build_sql_date($arrData['params'], $arrData['fieldname']);
				$crit_data = $temp['sql'];
				$crit_desc = $temp['description'];
				break;
			case "date_year":
				$arrData = array('fieldname' => $filter['cfield']);
				$arrData['params'] = implode(':', array('j', '', ''));
				$temp = gen_build_sql_date($arrData['params'], $arrData['fieldname']);
				$crit_data = $temp['sql'];
				$crit_desc = $temp['description'];
				break;
			case "date_ytd":
				$arrData = array('fieldname' => $filter['cfield']);
				$arrData['params'] = implode(':', array('k', '', ''));
				$temp = gen_build_sql_date($arrData['params'], $arrData['fieldname']);
				$crit_data = $temp['sql'];
				$crit_desc = $temp['description'];
				break;
			case "period":
				$arrData = array('fieldname' => $filter['cfield']);
				$arrData['params'] = implode(':', array('l', '', ''));
				$temp = gen_build_sql_date($arrData['params'], $arrData['fieldname']);
				$crit_data = $temp['sql'];
				$crit_desc = $temp['description'];
				break;
			case "range":
				if ($filter['from']<>'') {
					$crit_data .= $filter['cfield'] . ">='" . $filter['from'] . "'";
					$crit_desc .= ' ' . TEXT_FROM . ' ' . $filter['from'];
				}
				if ($filter['to']<>'') {
					if (strlen($crit_data)>0) $crit_data .= ' and ';
					$crit_data .= $filter['cfield'] . "<='" . $filter['to'] . "'";
					$crit_desc .= ' ' . TEXT_TO . ' ' . $filter['to'];
				}
				if ($crit_desc <> '') $crit_desc = $filter['name'] . ': ' . $crit_desc;
				break;
			case "yes":
			case "true":
			case "active":
			case "printed":
				$crit_data .= $value['cfield'] . '=1';
				$crit_desc .= $filter['name'] . '=' . $value['crit'];
				break;
			case "no":
			case "false":
			case "inactive":
			case "unprinted":
				$crit_data .= $value['cfield'] . '=0';
				$crit_desc .= $filter['name'] . '=' . $value['crit'];
		}
		if ($crit_data <> '') $criteria_list[] = $crit_data;
		if ($crit_desc <> '') $description_list[] = $crit_desc;
	}
	$crit_string = '';
	if (count($criteria_list)>0) {
		$crit_string = ' where ' . implode(' and ', $criteria_list);
	}

	// build query
	$fields = array_keys($data);
	if (!in_array('id', $fields)) $fields[] = 'id';
	$field_list = 'd.' . implode(', d.', $fields);
	$sql = "select distinct " . $field_list . " from " . $prefs['table_name'] . " d ";
	if ($use_address_book) $sql .= "left join " . TABLE_ADDRESS_BOOK . " a on d.id = a.ref_id ";
	$sql .= $crit_string;
	$export_rows = $db->Execute($sql);
	if ($export_rows->RecordCount() ==0) {
		$messageStack->add(TEXT_IMP_ERMSG12, 'success');
		return;
	}
	// export data
    while (!$export_rows->EOF) {
		$output_line = array();
		foreach ($data as $field_name=>$index) {
			$output_line[$index] = ie_process_the_data($export_rows->fields[$field_name], $element_processing[$index]);
		}
		if ($use_address_book) {
			$address_type = array($account_type.'m' =>$mail, $account_type.'s' => $ship, $account_type.'b' => $bill);
			foreach ($address_type as $type => $array_name) {
				// fetch the id to use to link addresses to the correct main record
				$sql = "select * from " . TABLE_ADDRESS_BOOK . " 
					where type = '" . $type . "' 
					and ref_id = '" . $export_rows->fields['id'] . "' limit " . MAX_NUM_ADDRESSES;
				$addresses = $db->Execute($sql);
				for ($i=0; $i<count($array_name); $i++ ) { // each address of type
					foreach ($array_name[$i] as $field_name=>$index) { // each field in address
						$output_line[$index] = ie_process_the_data($addresses->fields[$field_name], $element_processing[$index]);
					}
					$addresses->MoveNext();
				}
			}
		}
		ksort($output_line);
		$output .= ie_implode($output_line, $delimiter, $qualifier) . chr(10);
		$export_rows->MoveNext();
    }
	$FileSize = strlen($output);
	if (substr($options['export_file_name'], strrpos($options['export_file_name'], '.')) == '.csv') {
		header("Content-type: application/csv");
	} else {
		header("Content-type: plain/txt");
	}
	header("Content-disposition: attachment; filename=" . $options['export_file_name'] . "; size=" . $FileSize);
	header('Pragma: cache');
	header('Cache-Control: public, must-revalidate, max-age=0');
	header('Connection: close');
	header('Expires: ' . date('r', time()+60*60));
	header('Last-Modified: ' . date('r', time()));
	print $output;
	exit();  
}

?>