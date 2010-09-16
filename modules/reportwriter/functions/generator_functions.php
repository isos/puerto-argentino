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
//  Path: /modules/reportwriter/functions/generator_functions.php
//

function ProcessData($strData, $Process) {
	global $currencies, $posted_currencies, $rw_xtra_jrnl_defs;
//echo 'process = ' . $Process . ' and posted cur = '; print_r($posted_currencies); echo '<br />';
	switch ($Process) {
		case "uc":        return strtoupper_utf8($strData);
		case "lc":        return strtolower_utf8($strData);
		case "neg":       return -$strData;
		case "rnd2d":
			if (!is_numeric($strData)) return $strData;
		    else return number_format(round($strData, 2), 2, '.', '');
		case "rnd_dec":
			if (!is_numeric($strData)) return $strData;
			else return $currencies->format($strData);
		case "rnd_pre":
			if (!is_numeric($strData)) return $strData;
			else return $currencies->precise($strData);
		case "def_cur": 
			if (!is_numeric($strData)) return $strData;
			else return $currencies->format_full($strData, true, DEFAULT_CURRENCY, 1, 'fpdf');
		case "null_dcur": 
			if (!is_numeric($strData)) return $strData;
			else return (!$strData) ? '' :$currencies->format_full($strData, true, DEFAULT_CURRENCY, 1, 'fpdf');
		case "posted_cur": 
			if (!is_numeric($strData)) return $strData;
			else return $currencies->format_full($strData, true, $posted_currencies['currencies_code'], $posted_currencies['currencies_value'], 'fpdf');
		case "null_pcur": 
			if (!is_numeric($strData)) return $strData;
			else return (!$strData) ? '' : $currencies->format_full($strData, true, $posted_currencies['currencies_code'], $posted_currencies['currencies_value'], 'fpdf');
		case "dlr": 
			if (!is_numeric($strData)) return $strData;
		    else return '$ ' . number_format(round($strData, 2), 2);
		case "euro":
			if (!is_numeric($strData)) return $strData;
		    else return chr(128) . ' ' . number_format(round($strData, 2), 2); // assumes standard FPDF fonts
		case "n2wrd":     return value_to_words_en_us($strData); // for checks primarily
		case "terms":     return gen_terms_to_language($strData, $short = true, $type = 'ar');
		case "date":      return gen_spiffycal_db_date_short($strData);
		case "null-dlr":  return (!$strData) ? '' : '$ ' . number_format($strData, 2);
		case "ordr_qty":  return pull_order_qty($strData);
		case "branch":    return rw_get_branch_name($strData);
		case "rep_id":    return rw_get_user_name($strData);
		case "ship_name": return rw_get_ship_name($strData);
		case 'j_desc':    return isset($rw_xtra_jrnl_defs[$strData]) ? $rw_xtra_jrnl_defs[$strData] : $strData;
		case 'yesBno':    return ($strData) ? TEXT_YES : '';
		case 'printed':   return ($strData) ? '' : TEXT_DUPLICATE;
	}

	$processed_value = false;
	if (function_exists('rw_extra_processing')) $processed_value = rw_extra_processing($strData, $Process);

	return ($processed_value === false) ? $strData : $processed_value; // do nothing if Process not recognized
}

function AddSep($value, $Process) {
	switch ($Process) {
		case "sp":      return $value . ' ';
		case "2sp":     return $value . '  ';
		case "comma":   return $value . ',';
		case "com-sp":  return $value . ', ';
		case "nl":      return $value . chr(10);
		case "semi-sp": return $value . '; ';
		case "del-nl":  return ($value == '') ? '' : $value . chr(10);
	}

	$separator_value = false;
	if (function_exists('rw_extra_separators')) $separator_value = rw_extra_separators($value, $Process);

	return ($separator_value === false) ? $value : $separator_value; // do nothing if Process not recognized
}

function TextReplace($text_string) {
	global $Prefs, $report_title;
	// substitutes a command string with dynamic information
	$text_string = str_replace('%date%',       gen_date_short(date('Y-m-d')), $text_string);
	$text_string = str_replace('%reportname%', $report_title,                 $text_string);
	$text_string = str_replace('%company%',    COMPANY_NAME,                  $text_string);
	return $text_string;
}

function FetchReportDetails($ReportID) {
	global $db;
	$result = $db->Execute("select * from " . TABLE_REPORTS . " where id = " . $ReportID);
	$result->fields['description'] = stripslashes($result->fields['description']);
	foreach ($result->fields as $key => $value) $Prefs[$key] = $value;
	// load the page fields
	$result = $db->Execute("select params from " . TABLE_REPORT_FIELDS . " 
		where reportid = " . $ReportID . " and entrytype = 'pagelist'");
	if ($result->RecordCount() > 0 ) {
		$params = unserialize($result->fields['params']);
		$params['title1desc'] = stripslashes($params['title1desc']);
		$params['title2desc'] = stripslashes($params['title2desc']);
		$Prefs = array_merge($Prefs, $params);
	}

	// Report/Form properties
	$Prefs['GroupListings'] = RetrieveFields($ReportID, 'grouplist');
	$Prefs['CritListings']  = RetrieveFields($ReportID, 'critlist');
	$Prefs['SortListings']  = RetrieveFields($ReportID, 'sortlist');
	$Prefs['FieldListings'] = RetrieveFields($ReportID, 'fieldlist');
	return $Prefs;
}

function RetrieveFields($ReportID, $EntryType) {
	global $db;
	$FieldListings = '';
	$sql= "select *	from " . TABLE_REPORT_FIELDS . " 
		where reportid = " . $ReportID . " and entrytype = '" . $EntryType . "'
		order by seqnum";
	$result = $db->Execute($sql);
	while (!$result->EOF) {
		$result->fields['params'] = unserialize($result->fields['params']);
		$FieldListings[] = $result->fields;
		$result->MoveNext();
	}
	return $FieldListings;
}

function ChangeSequence($ReportID, $SeqNum, $EntryType, $UpDown) {
	global $db;
	// find the id of the row to move
	$sql = "select id from " . TABLE_REPORT_FIELDS . " 
		where reportid = " . $ReportID . " and entrytype = '" . $EntryType . "' and seqnum = " . $SeqNum;
	$result = $db->Execute($sql);
	$OrigID = $result->fields['id'];
	$NewSeqNum = ($UpDown == 'up') ? ($SeqNum - 1) : ($SeqNum + 1);
	// first move affected sequence to seqnum, then seqnum to new position
	$sql = "update " . TABLE_REPORT_FIELDS . " set seqnum = '" . $SeqNum . "' 
		where reportid = " . $ReportID . " and entrytype = '" . $EntryType . "' and seqnum = " . $NewSeqNum;
	$result = $db->Execute($sql);
	$sql = "update " . TABLE_REPORT_FIELDS . " set seqnum = '" . $NewSeqNum . "' where id = " . $OrigID;
	$result = $db->Execute($sql);
	return true;
}

function BuildCriteria($FieldListings) {
	global $db, $CritChoices;
	$CriteriaString = '';
	$Visible = $FieldListings['visible'];
	$SeqNum  = $FieldListings['seqnum'];
//	$Params  = explode(':', $FieldListings['params']['value']);  // the first value is the criteria type
//	if (!isset($Params[0])) $Params[0] = '-'; // default to no default if this parameter doesn't exist
//	if (!isset($Params[1])) $Params[1] = ''; // default to no entry for default from box
//	if (!isset($Params[2])) $Params[2] = ''; // default to no entry for default to box
	$TableEntries = array();
	// retrieve the dropdown based on the params field (dropdown type)
	$CritBlocks = explode(':', $CritChoices[$FieldListings['params']['value']]);
	switch (array_shift($CritBlocks)) { // determine how many text boxes to build
		default:
		case 0: 
			$TableEntries[1] = '&nbsp;'; 
			$TableEntries[2] = '&nbsp;'; 
			break;
		case 1: 
			$TableEntries[1] = '<input name="fromvalue' . $SeqNum . '" type="' . ($Visible ? 'text' :'hidden') . '" value="' . $FieldListings['params']['min_val'] . '" size="21" maxlength="20">';
			$TableEntries[2] = '&nbsp;'; 
			break;
		case 2: 
			$TableEntries[1] = '<input name="fromvalue' . $SeqNum . '" type="' . ($Visible ? 'text' :'hidden') . '" value="' . $FieldListings['params']['min_val'] . '" size="21" maxlength="20">';
			$TableEntries[2] = '<input name="tovalue' . $SeqNum . '" type="' . ($Visible ? 'text' :'hidden') . '" value="' . $FieldListings['params']['max_val'] . '" size="21" maxlength="20">';
	} // end switch array_shift($CritBlocks)

	if ($Visible) {
		$TableEntries[0] = '<select name="defcritsel' . $SeqNum . '">';
		foreach ($CritBlocks as $value) {
			$TableEntries[0] .= '<option value="' . $value . '"' . (($FieldListings['params']['default'] == $value) ? ' selected' : '') . '>' . constant('TEXT_' . $value) . '</option>';
		}
		$TableEntries[0] .= '</select>';
		$CriteriaString .= '<tr><td>' . $FieldListings['displaydesc'] . '</td>' . chr(10); // add the description
		$CriteriaString .= '<td>' . $TableEntries[0] . '</td>' . chr(10);
		$CriteriaString .= '<td>' . $TableEntries[1] . '</td>' . chr(10);
		$CriteriaString .= '<td>' . $TableEntries[2] . '</td></tr>' . chr(10);
	} else {
		$TableEntries[0] = '<input name="defcritsel' . $SeqNum . '" type="hidden" value="' . $CritBlocks[0] . '">';
		$CriteriaString .= $TableEntries[0] . chr(10);
		$CriteriaString .= $TableEntries[1] . chr(10);
		$CriteriaString .= $TableEntries[2] . chr(10);
	}
	return $CriteriaString;
}

function BuildFieldList($FieldListings) {
	$CriteriaString = '';
	$i = 0;
	foreach ($FieldListings as $FieldValues) {
		$CriteriaString .= '<tr><td>';
		$CriteriaString .= html_hidden_field('id_' . $i, $FieldValues['id']);
		$CriteriaString .= html_hidden_field('seq_' . $i, $FieldValues['seqnum']);
		$CriteriaString .= $FieldValues['displaydesc'] . '</td>' . chr(10); // add the description
		$CriteriaString .= '<td align="center">' . html_checkbox_field('show_' . $i, '1', ($FieldValues['visible']) ? true : false, '', 'onchange="calculateWidth()"') . '</td>' . chr(10);
		$CriteriaString .= '<td align="center">' . html_checkbox_field('break_' . $i, '1', ($FieldValues['columnbreak']) ? true : false, '', 'onchange="calculateWidth()"') . '</td>' . chr(10);
		$CriteriaString .= '<td align="center">' . html_input_field('width_' . $i, ($FieldValues['params']['columnwidth'] ? $FieldValues['params']['columnwidth'] : RW_DEFAULT_COLUMN_WIDTH), 'size="4" maxlength="3" onchange="calculateWidth()"') . '</td>' . chr(10);
		$CriteriaString .= '<td id="col_' . $i . '" align="center">&nbsp;</td>' . chr(10); 
		$CriteriaString .= '<td id="tot_' . $i . '" align="center">&nbsp;</td>' . chr(10); 
		$CriteriaString .= '<td align="center">';
		$CriteriaString .= html_icon('actions/go-up.png', TEXT_UP, 'small', 'onclick="exchange(' . $i . ', \'up\')"'); 
		$CriteriaString .= html_icon('actions/go-down.png', TEXT_DOWN, 'small', 'onclick="exchange(' . $i . ', \'down\')"'); 
		$CriteriaString .= '</td></tr>' . chr(10);
		$i++;
	}
	return $CriteriaString;
}

function BuildjsArrays($FieldListings) {
	$index = 0;
	$jsArray  = 'var fieldIdx = new Array(' . sizeof($FieldListings) . ');' . chr(10);
	foreach ($FieldListings as $FieldValues) {
		$jsArray .= 'fieldIdx['   . $index . '] = '   . ($index) . '; ';
		$index++;
	}
	return $jsArray;
}

function ReadPostData($ReportID, $Prefs, $Overrides, $action = '') {
	global $db, $messageStack;
//echo 'Prefs = '; print_r($Prefs); echo '<br />';
	// look at check boxes and convert to boolean
	$Overrides['coynameshow'] = isset($Overrides['coynameshow']) ? '1' : '0';
	$Overrides['title1show']  = isset($Overrides['title1show'])  ? '1' : '0';
	$Overrides['title2show']  = isset($Overrides['title2show'])  ? '1' : '0';
	$Overrides['grpbreak']    = isset($Overrides['grpbreak'])    ? '1' : '0';
	// Some special cases
	$Prefs['trunclong']       = $Overrides['deftrunc'];
	// map the Override field listings to the pre-defined format
	$temp = array();
	$tempEntry = array();
	for ($i = 0; $i < sizeof($Prefs['FieldListings']); $i++) {
		for ($j = 0; $j < sizeof($Prefs['FieldListings']); $j++) {
			if ($Prefs['FieldListings'][$i]['id'] == $Overrides['id_' . $j]) {
				$tempEntry = $Prefs['FieldListings'][$i];
				$tempEntry['seqnum'] = $Overrides['seq_' . $j];
				$tempEntry['visible'] = ($Overrides['show_' . $j] == '1') ? '1' : '0';
				$tempEntry['columnbreak'] = ($Overrides['break_' . $j] == '1') ? '1' : '0';
				$tempEntry['params']['columnwidth'] = $Overrides['width_' . $j];
				unset($Overrides['seq_' . $j], $Overrides['show_' . $j], $Overrides['break_' . $j], $Overrides['width_' . $j]);
				if ($action == 'save' && !$Prefs['standard_report']) { // If it's a default report, don't write the changes just acknowledge them for display
					$db->Execute("update "   . TABLE_REPORT_FIELDS . " set 
							seqnum = '"      . $tempEntry['seqnum'] . "',
							visible = '"     . $tempEntry['visible'] . "',
							columnbreak = '" . $tempEntry['columnbreak'] . "',
							params = '"      . serialize($tempEntry['params']) . "'
						where id = " . $tempEntry['id']);
				}
				$temp[$tempEntry['seqnum']] = $tempEntry;
			}
		}
	}
	// re-sort the fields listings
	ksort($temp);
	$Prefs['FieldListings'] = array();
	$Prefs['FieldListings'] = $temp;

	// Overrride the default preferences with the remaining fields
	$Prefs = array_merge($Prefs, $Overrides);
//echo 'Prefs = '; print_r($Prefs); echo '<br />'; exit();

	// read from the filter form, fetch user selections
	if (isset($Overrides['period'])) { // choose by period field instead of date
		$Prefs['datedefault'] = 'z:' . $Overrides['period'];
	} else {
		$Prefs['datedefault'] = $Overrides['defdate'];
		if ($Overrides['defdate'] == 'b') { // then it's a range selection, save dates, else discard
			$Prefs['datedefault'] .= ':' . $Overrides['DefDateFrom'] . ':' . $Overrides['DefDateTo'];
		}
	}

	// update Prefs with current user selections
	if (isset($Prefs['defgroup'])) { // First clear all defaults and reset the user's choice
		for ($i = 0; $i < count($Prefs['GroupListings']); $i++) $Prefs['GroupListings'][$i]['params']['default'] = 0;
		if ($Prefs['defgroup'] <> 0) $Prefs['GroupListings'][$Prefs['defgroup'] - 1]['params']['default'] = '1';
	}
	if (isset($Prefs['defsort'])) { // First clear all defaults and reset the user's choice
		for ($i = 0; $i < count($Prefs['SortListings']); $i++) $Prefs['SortListings'][$i]['params']['default'] = 0;
		if ($Prefs['defsort'] <> 0) $Prefs['SortListings'][$Prefs['defsort'] - 1]['params']['default'] = '1';
	}

	// Criteria Field Selection
	$i = 1;
	while (isset($Overrides['defcritsel' . $i])) { // then there is at least one criteria
		// Build the criteria default string
		$Prefs['CritListings'][$i-1]['params']['default'] = $Overrides['defcritsel' . $i];
		$Prefs['CritListings'][$i-1]['params']['min_val'] = $Overrides['fromvalue'  . $i];
		$Prefs['CritListings'][$i-1]['params']['max_val'] = $Overrides['tovalue'    . $i];
		if ($action == 'save' && !$Prefs['standard_report']) { // save it since it's a custom report
			$sql = "update " . TABLE_REPORT_FIELDS . " 
				set params = '" . serialize($Prefs['CritListings'][$i-1]['params']) . "' 
				where reportid = " . $ReportID . " and entrytype = 'critlist' and seqnum = " . $i;
			$result = $db->Execute($sql);
		}
		$i++;
	}

	if ($action == 'save' && !$Prefs['standard_report']) { // Update the main report record
		$data_array['papersize']        = $Prefs['papersize'];
		$data_array['paperorientation'] = $Prefs['paperorientation'];
		$data_array['margintop']        = $Prefs['margintop'];
		$data_array['marginbottom']     = $Prefs['marginbottom'];
		$data_array['marginleft']       = $Prefs['marginleft'];
		$data_array['marginright']      = $Prefs['marginright'];
		$data_array['coynamefont']      = $Prefs['coynamefont'];
		$data_array['coynamefontsize']  = $Prefs['coynamefontsize'];
		$data_array['coynamefontcolor'] = $Prefs['coynamefontcolor'];
		$data_array['coynamealign']     = $Prefs['coynamealign'];
		$data_array['coynameshow']      = $Prefs['coynameshow'];
		$data_array['title1desc']       = addslashes($Prefs['title1desc']);
		$data_array['title1font']       = $Prefs['title1font'];
		$data_array['title1fontsize']   = $Prefs['title1fontsize'];
		$data_array['title1fontcolor']  = $Prefs['title1fontcolor'];
		$data_array['title1fontalign']  = $Prefs['title1fontalign'];
		$data_array['title1show']       = $Prefs['title1show'];
		$data_array['title2desc']       = addslashes($Prefs['title2desc']);
		$data_array['title2font']       = $Prefs['title2font'];
		$data_array['title2fontsize']   = $Prefs['title2fontsize'];
		$data_array['title2fontcolor']  = $Prefs['title2fontcolor'];
		$data_array['title2fontalign']  = $Prefs['title2fontalign'];
		$data_array['title2show']       = $Prefs['title2show'];
		$data_array['filterfont']       = $Prefs['filterfont'];
		$data_array['filterfontsize']   = $Prefs['filterfontsize'];
		$data_array['filterfontcolor']  = $Prefs['filterfontcolor'];
		$data_array['filterfontalign']  = $Prefs['filterfontalign'];
		$data_array['datafont']         = $Prefs['datafont'];
		$data_array['datafontsize']     = $Prefs['datafontsize'];
		$data_array['datafontcolor']    = $Prefs['datafontcolor'];
		$data_array['datafontalign']    = $Prefs['datafontalign'];
		$data_array['totalsfont']       = $Prefs['totalsfont'];
		$data_array['totalsfontsize']   = $Prefs['totalsfontsize'];
		$data_array['totalsfontcolor']  = $Prefs['totalsfontcolor'];
		$data_array['totalsfontalign']  = $Prefs['totalsfontalign'];
		$data_array['trunclong']        = $Prefs['trunclong'];
		$data_array['datedefault']      = $Prefs['datedefault'];

		$sql = "update " . TABLE_REPORT_FIELDS . " set params = '" . serialize($data_array) . "'
			where reportid = " . $ReportID . " and entrytype = 'pagelist'";
		$result = $db->Execute($sql);
		// update the criteria and fields
		if (isset($Prefs['defgroup'])) SaveDefSettings($ReportID, 'grouplist', $Prefs['defgroup']);
		if (isset($Prefs['defsort']))  SaveDefSettings($ReportID, 'sortlist',  $Prefs['defsort']);
	} elseif ($action == 'save') {
		$messageStack->add(RW_RPT_CANNOT_EDIT,'caution');
	}
	return $Prefs;
}

function SaveDefSettings($ReportID, $EntryType, $SeqNum) {
	global $db;
	$result = $db->Execute("select seqnum, params from " . TABLE_REPORT_FIELDS . " 
	  where reportid = " . $ReportID . " and entrytype = '" . $EntryType . "'");
	while (!$result->EOF) {
	  $params = unserialize($result->fields['params']);
	  if ($params['default'] == '1' && $result->fields['seqnum'] <> $SeqNum) { // clear the default
	    $params['default'] = '0';
		$result = $db->Execute("update " . TABLE_REPORT_FIELDS . " set params = '" . serialize($params) . "' 
		  where reportid = " . $ReportID . " and entrytype = '" . $EntryType . "' and seqnum = " . $result->fields['seqnum']);
	  } else if ($result->fields['seqnum'] == $SeqNum) { // set the default
	    $params['default'] = '1';
		$result = $db->Execute("update " . TABLE_REPORT_FIELDS . " set params = '" . serialize($params) . "' 
		  where reportid = " . $ReportID . " and entrytype = '" . $EntryType . "' and seqnum = " . $SeqNum);
	  } // else leave it alone
	  $result->MoveNext();
	}
}

function SaveNewReport($ReportID, $AllowOverwrite) {
	global $db, $Prefs;
	// input error check description, blank duplicate, bad characters, etc.
	// Delete any special characters from ReportName
	if ($_POST['ReportName'] == '') { // no report name was entered, error and reload form
		$Rtn['result'] = 'error';
		$Rtn['default'] = false;
		$Rtn['message'] = RW_RPT_NORPT;
		return $Rtn;
	}
	// check for duplicate report name and error or overwrite if allowed
	$sql = "select id, standard_report from " . TABLE_REPORTS . " 
		where description = '" . addslashes($_POST['ReportName']) . "'";
	$result = $db->Execute($sql);
	if ($result->RecordCount() > 0) $myrow = $result->fields;
	if (isset($myrow)) { // then we have a duplicate report name do some checking
		if ($myrow['standard_report']) { // it's a default don't allow overwrite no matter what, return
			$Rtn['result']  = 'warn';
			$Rtn['default'] = true;
			$Rtn['message'] = RW_RPT_SAVEDEF;
			return $Rtn;
		} elseif (!$AllowOverwrite) { // verify user wants to replace, return
			$Rtn['result']  = 'warn';
			$Rtn['default'] = false;
			$Rtn['message'] = RW_RPT_SAVEDUP;
			return $Rtn;
		} 
		// check for the same report to update or replace a different report than ReportID
		if ($myrow['id'] <> $ReportID) { // erase the report to overwrite and duplicate ReportID
			$sql= "delete from " . TABLE_REPORTS . " where id = " . $myrow['id'];
			$result = $db->Execute($sql);
			$sql= "delete from " . TABLE_REPORT_FIELDS . " where reportid = " . $myrow['id'];
			$result = $db->Execute($sql);
		} else { // just return because the save as name is the same as the current report name
			$Rtn['message']  = TEXT_REPORT . $Prefs['description'] . RW_RPT_WASSAVED . $_POST['ReportName'];
			$Rtn['ReportID'] = $ReportID;
			$Rtn['result']   = 'success';
			return $Rtn;
		}		
	}
	// Input validated perform requested operation
	$OrigID = $ReportID;
	// Set the report id to 0 to prepare to duplicate
	$sql = "update " . TABLE_REPORTS . " set id = 0 where id = " . $ReportID;
	$result = $db->Execute($sql);
	$sql = "insert into " . TABLE_REPORTS . " select * from " . TABLE_REPORTS . " where id = 0";
	$result = $db->Execute($sql);
	// Fetch the id entered
	$ReportID = $db->insert_ID();
	// Restore original report ID from 0
	$sql = "update " . TABLE_REPORTS . " set id = " . $OrigID . " where id=0";
	$result = $db->Execute($sql);
	// Set the report name per the form and make a non-default report
	$sql = "update " . TABLE_REPORTS . " 
		set description = '" . addslashes($_POST['ReportName']) . "', standard_report = '0' 
		where id = " . $ReportID;
	$result = $db->Execute($sql);
	// fetch the fields and duplicate
	$sql = "select * from " . TABLE_REPORT_FIELDS . " where reportid = " . $OrigID;
	$result = $db->Execute($sql);
	while (!$result->EOF) {
		$sql = "insert into " . TABLE_REPORT_FIELDS . " (reportid, entrytype, seqnum, fieldname, 
				displaydesc, visible, columnbreak, params)
			VALUES (" . $ReportID . ", '" . $result->fields['entrytype'] . "', " . $result->fields['seqnum'] . ",
				'" . $result->fields['fieldname'] . "', '" . $result->fields['displaydesc'] . "', '" . $result->fields['visible'] . "',
				'" . $result->fields['columnbreak'] . "', '" . $result->fields['params'] . "');";
		$temp = $db->Execute($sql);
		$result->MoveNext();
	}
	$Rtn['message']  = TEXT_REPORT . $Prefs['description'] . RW_RPT_WASSAVED . $_POST['ReportName'];
	$Rtn['ReportID'] = $ReportID;
	$Rtn['result']   = 'success';
	return $Rtn;
}

function BuildSQL($Prefs) { // for reports only
	//fetch the listing fields (must have at least one) to build select field
	$strField = '';
	$i=0;
	if (is_array($Prefs['FieldListings'])) {
		while ($FieldValues = array_shift($Prefs['FieldListings'])) { 
			if ($FieldValues['visible']) {
				$strField .= $FieldValues['fieldname'] . " AS c" . $i . ", "; 
				$i++;
			}
		}
	}
	// check for at least one field selected to show
	if (!$strField) { // No fields are checked to show, that's bad
		$usrMsg['message'] = RW_RPT_NOROWS;
		$usrMsg['level']   = 'error';
		return $usrMsg;
	}
	$strField = substr($strField, 0, -2); // strip the last comma

	$Prefs['filterdesc'] = RW_RPT_RPTFILTER; // Initialize the filter display string
	//fetch the groupings and build first level of SORT BY string (for sub totals)
	$strGroup = '';
	if (is_array($Prefs['GroupListings'])) while ($FieldValues = array_shift($Prefs['GroupListings'])) { 
//echo 'FieldValues array = '; print_r($FieldValues); echo '<br />';
		if ($FieldValues['params']['default']) {  // then it's the group by field match
			$strGroup .= $FieldValues['fieldname']; 
			$Prefs['filterdesc'] .= RW_RPT_GROUPBY . ' ' . $FieldValues['displaydesc'] . '; ';
			break;
		}
	}

	// fetch the sort order and add to group by string to finish ORDER BY string
	$strSort = $strGroup;
	if (is_array($Prefs['SortListings'])) while ($FieldValues = array_shift($Prefs['SortListings'])) { 
		if ($FieldValues['params']['default']) {  // then it's the sort by field match
			if ($strSort == '') $strSort .= $FieldValues['fieldname']; else $strSort .= ', ' . $FieldValues['fieldname'];
			$Prefs['filterdesc'] .= RW_RPT_SORTBY . ' ' . $FieldValues['displaydesc'] . '; ';
			break;
		}
	}

	// fetch date filter info
	$dates = gen_build_sql_date($Prefs['datedefault'], $Prefs['datefield']);
	$strDate = $dates['sql'];
	if ($dates['description']) $Prefs['filterdesc'] .= $dates['description']; // update the filter description string

	// Fetch the Criteria
	$criteria = build_criteria($Prefs['CritListings']);
	$strCrit = $criteria['sql'];
	if ($criteria['description']) $Prefs['filterdesc'] .= RW_RPT_CRITBY . ' ' . $criteria['description'] . '; ';

	// fetch the tables to query
	$strTable = DB_PREFIX . $Prefs['table1'];
	if ($Prefs['table2']) $strTable .= ' inner join ' . DB_PREFIX . $Prefs['table2'] . ' on ' . $Prefs['table2criteria'];
	if ($Prefs['table3']) $strTable .= ' inner join ' . DB_PREFIX . $Prefs['table3'] . ' on ' . $Prefs['table3criteria'];
	if ($Prefs['table4']) $strTable .= ' inner join ' . DB_PREFIX . $Prefs['table4'] . ' on ' . $Prefs['table4criteria'];
	if ($Prefs['table5']) $strTable .= ' inner join ' . DB_PREFIX . $Prefs['table5'] . ' on ' . $Prefs['table5criteria'];
	if ($Prefs['table6']) $strTable .= ' inner join ' . DB_PREFIX . $Prefs['table6'] . ' on ' . $Prefs['table6criteria'];

	// Build query string
	$sql = 'select ' . $strField . ' from ' . $strTable;
	if ($strCrit && $strDate)  $sql .= ' where ' . $strDate . ' and ' . $strCrit;
	if (!$strCrit && $strDate) $sql .= ' where ' . $strDate;
	if ($strCrit && !$strDate) $sql .= ' where ' . $strCrit;
	if ($strSort)              $sql .= ' order by ' . $strSort;

	$tables = array($Prefs['table1'], $Prefs['table2'], $Prefs['table3'], $Prefs['table4'], $Prefs['table5'], $Prefs['table6']);
//echo 'sql = ' . GenReplaceTables($sql, $tables) . '<br>';
	$usrMsg['level']      = 'success';
	$usrMsg['data']       = GenReplaceTables($sql, $tables);
	$usrMsg['filterdesc'] = $Prefs['filterdesc'];
	return $usrMsg;
}

function BuildDataArray($ReportID, $sql, $Prefs) { // for reports only
	global $db, $Heading, $Seq, $posted_currencies, $messageStack;
	$posted_currencies = array('currencies_code' => DEFAULT_CURRENCY, 'currencies_value' => 1); // use default currency
	// See if we need to group, fetch the group fieldname
	$GrpFieldName = '';
	if (is_array($Prefs['GroupListings'])) while ($Temp = array_shift($Prefs['GroupListings'])) {
		if ($Temp['params']['default'] == '1') {
			$GrpFieldName = $Temp['fieldname'];
			$GrpFieldProcessing = $Temp['params']['processing'];
		}
	}

	// Build the sequence map of retrieved fields, order is as user wants it
	$i = 0;
	$GrpField = '';
	foreach ($Prefs['FieldListings'] as $DataFields) {
		if ($DataFields['visible']) { // match the group fieldname with fetched data fieldname for group totals
			if ($DataFields['fieldname'] == $GrpFieldName) $GrpField = 'c' . $i;
			$Seq[$i]['break'] = $DataFields['columnbreak'];
			$Heading[] = $DataFields['displaydesc']; // fill the heading array
			$Seq[$i]['fieldname']  = 'c' . $i;
			$Seq[$i]['total']      = $DataFields['params']['index'];
			$Seq[$i]['processing'] = $DataFields['params']['processing'];
			$Seq[$i]['align']      = $DataFields['params']['align'];
			$Seq[$i]['grptotal']   = '';
			$Seq[$i]['rpttotal']   = '';
			$i++;
		}
	}

	// patch for special_reports where the data file is generated externally from the standard function
	if ($Prefs['special_report']) {
		$temp = explode(':', $Prefs['special_report']);
		$report_class = $temp[1];
		if (file_exists(DIR_FS_MY_FILES .       'custom/reportwriter/classes/' . $report_class . '.php')){
		  $success = include (DIR_FS_MY_FILES . 'custom/reportwriter/classes/' . $report_class . '.php');
		} elseif (file_exists(DIR_FS_MODULES .  'reportwriter/classes/'        . $report_class . '.php')) {
		  $success = include (DIR_FS_MODULES .  'reportwriter/classes/'        . $report_class . '.php');
		} else { $success = false; }
		if (!$success) {
			$messageStack->add('Special report class: ' . $report_class . ' was called but could not be found!', 'error');
			return;
		}
		$sp_report = new $report_class;
		return $sp_report->load_report_data($Prefs, $Seq, $sql, $GrpField); // the special report formats all of the data, we're done
	}

	$result = $db->Execute($sql);
	if ($result->RecordCount() == 0) return false; // No data so bail now
	// Generate the output data array
	$RowCnt = 0; // Row counter for output data
	$ColCnt = 1;
	$GrpWorking = false;
	while (!$result->EOF) {
		$myrow = $result->fields;
		// Check to see if a total row needs to be displayed
		if (isset($GrpField)) { // we're checking for group totals, see if this group is complete
			if (($myrow[$GrpField] <> $GrpWorking) && $GrpWorking !== false) { // it's a new group so print totals
				$OutputArray[$RowCnt][0] = 'g:' . ProcessData($GrpWorking, $GrpFieldProcessing);
				foreach($Seq as $offset => $TotalCtl) {
					$OutputArray[$RowCnt][$offset+1] = ($TotalCtl['total'] == '1') ? ProcessData($TotalCtl['grptotal'], $TotalCtl['processing']) : ' ';
					$Seq[$offset]['grptotal'] = ''; // reset the total
				}
				$RowCnt++; // go to next row
			}
			$GrpWorking = $myrow[$GrpField]; // set to new grouping value
		}
		$OutputArray[$RowCnt][0] = 'd'; // let the display class know its a data element
		foreach($Seq as $key => $TableCtl) { // 
		  if ($Prefs['totalonly'] <> '1') { // insert data into output array and set to next column
			$OutputArray[$RowCnt][$ColCnt] = ProcessData($myrow[$TableCtl['fieldname']], $TableCtl['processing']);
		  }
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
	if ($GrpWorking !== false) { // if we collected group data show the final group total
		$OutputArray[$RowCnt][0] = 'g:' . ProcessData($GrpWorking, $GrpFieldProcessing);
		foreach ($Seq as $TotalCtl) {
			$OutputArray[$RowCnt][$ColCnt] = ($TotalCtl['total'] == '1') ? ProcessData($TotalCtl['grptotal'], $TotalCtl['processing']) : ' ';
			$ColCnt++;
		}
		$RowCnt++;
		$ColCnt = 1;
	}
	// see if we have a total to send
	$ShowTotals = false;
	foreach ($Seq as $TotalCtl) if ($TotalCtl['total']=='1') $ShowTotals = true; 
	if ($ShowTotals) {
		$OutputArray[$RowCnt][0] = 'r:' . $Prefs['description'];
		foreach ($Seq as $TotalCtl) {
			if ($TotalCtl['total']) $OutputArray[$RowCnt][$ColCnt] = ProcessData($TotalCtl['rpttotal'], $TotalCtl['processing']);
				else $OutputArray[$RowCnt][$ColCnt] = ' ';
			$ColCnt++;
		}
	}
//echo 'output array = '; print_r($OutputArray); echo '<br />'; exit();
	return $OutputArray;
}

function GenerateCSVFile($Data, $Prefs) { // for reports only
	global $Heading, $posted_currencies;
	$posted_currencies = array('currencies_code' => DEFAULT_CURRENCY, 'currencies_value' => 1); // use default currency
	$CSVOutput = '';
	// Write the column headings
	foreach ($Heading as $mycolumn) { // check for embedded commas and enclose in quotes
		$CSVOutput .= (strpos($mycolumn, ',') === false) ? ($mycolumn . ',') : ('"' . $mycolumn . '",');
	}
	$CSVOutput = substr($CSVOutput, 0, -1) . chr(10); // Strip the last comma off and add line feed
	// Now write each data line and totals
	foreach ($Data as $myrow) {
		$Action = array_shift($myrow);
		$todo = explode(':', $Action); // contains a letter of the date type and title/groupname
		switch ($todo[0]) {
			case "r": // Report Total
			case "g": // Group Total
				$Desc = ($todo[0] == 'g') ? RW_TEXT_GROUP_TOTAL_FOR : RW_TEXT_REPORT_TOTAL_FOR;
				$CSVOutput .= $Desc . $todo[1] . chr(10);
				// Now write the total data like any other data row
			case "d": // Data
			default:
				$CSVLine = '';
				foreach ($myrow as $mycolumn) { // check for embedded commas and enclose in quotes
					$CSVLine .= (strpos($mycolumn, ',') === false) ? ($mycolumn . ',') : ('"' . $mycolumn . '",');
				}
				$CSVLine = substr($CSVLine, 0, -1); // Strip the last comma off
		}
		$CSVOutput .= $CSVLine . chr(10);
	}

	$FileSize = strlen($CSVOutput);
	header("Content-type: application/csv");
	header("Content-disposition: attachment; filename=" . $Prefs['description'] . ".csv; size=" . $FileSize);
	header('Pragma: cache');
	header('Cache-Control: public, must-revalidate, max-age=0');
	header('Connection: close');
	header('Expires: ' . date('r', time()+60*60));
	header('Last-Modified: ' . date('r', time()));
	print $CSVOutput;
	exit();  
}

function GenerateHTMLFile($Data, $Prefs, $delivery_method = 'D') { // for html reports only
	require(DIR_FS_WORKING . 'classes/html_generator.php');
	$html = new HTML();
	$html->title = ReplaceNonAllowedCharacters($Prefs['description']);
	$html->ReportTable($Data);
	if ($delivery_method == 'S') return $html->output;
	echo $html->output;
	exit();
}

function GeneratePDFFile($Data, $Prefs, $delivery_method = 'D') { // for reports only
	$pdf = new PDF();
	$pdf->ReportTable($Data);
	$ReportName = ReplaceNonAllowedCharacters($Prefs['description']) . '.pdf';
	$pdfcode = $pdf->Output($ReportName, 'S');
	if ($delivery_method == 'S') return $pdfcode;

	$len = strlen($pdfcode);
	header('Content-type: application/pdf');
	header('Content-Length: ' . $len);
	header('Content-Disposition: inline; filename=' . $ReportName);
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	$pdf->Output($ReportName, $delivery_method);
	exit(); // needs to be here to properly render the pdf file.
}

function BuildPDF($ReportID, $Prefs, $delivery_method = 'D') { // for forms only
	global $db, $messageStack;
	global $FieldListings, $FieldValues, $posted_currencies;
	$output = array();
	// first fetch all the fields we need to display
	$FieldListings = '';
	$sql = "select seqnum, params from " . TABLE_REPORT_FIELDS . " 
		where reportid = " . $ReportID . " and entrytype = 'fieldlist' and visible = 1
		order by seqnum";
	$result = $db->Execute($sql);
	while (!$result->EOF) {
		$result->fields['params'] = unserialize($result->fields['params']);
		$FieldListings[] = $result->fields;
		$result->MoveNext();
	}
	// check for at least one field selected to show
	if (!$FieldListings) { // No fields are checked to show, that's bad
		$messageStack->add(RW_RPT_NOROWS, 'caution');
		return;
	}

	// Let's build the sql field list for the general data fields (not totals, blocks or tables)
	$strField = '';
	$index = 0; // index each field to allow one field to be used multiple times since $db->Execute returns assoc array

	foreach ($FieldListings as $OneField) { // check for a data field and build sql field list
		if ($OneField['params']['index'] == 'Data' || $OneField['params']['index'] == 'BarCode') { // then it's data field make sure it's not empty
			if ($OneField['params']['DataField'] <> '') {
				$strField .= $OneField['params']['DataField'] . ' as d' . $index . ', ';
				$index++;
			} else { // the field is empty, bad news, error and exit
				$messageStack->add(RW_RPT_EMPTYFIELD . $OneField['seqnum'], 'error');
				return;
			}
		}
	}
	$strField = substr($strField, 0, -2); // strip the extra comma, space and continue

	// fetch the sort order and add to group by string to finish ORDER BY string
	$strSort = $strGroup;
	if (is_array($Prefs['SortListings'])) while ($FieldValues = array_shift($Prefs['SortListings'])) { 
		if ($FieldValues['params']['default'] == '1') {  // then it's the sort by field match
			if ($strSort == '') $strSort .= $FieldValues['fieldname']; else $strSort .= ', ' . $FieldValues['fieldname'];
			$Prefs['filterdesc'] .= RW_RPT_SORTBY . ' ' . $FieldValues['displaydesc'] . '; ';
			break;
		}
	}

	// fetch date filter info (skip if criteria was passed to generate function)
	$strDate = '';
	if (!isset($Prefs['PassedCrit'])) {
		$dates = gen_build_sql_date($Prefs['datedefault'], $Prefs['datefield']);
		$strDate = $dates['sql'];
	}

	// Fetch the Criteria
	$criteria = build_criteria($Prefs['CritListings']);
	$strCrit = $criteria['sql'];
	if (isset($Prefs['PassedCrit'])) { // add the passed criteria to the default criteria
		for($i=0; $i<count($Prefs['PassedCrit']); $i++) {
			$temp = explode(':', $Prefs['PassedCrit'][$i]);
			switch (count($temp)) {
				case 2:// single value passed (assume equal to)
					if ($strCrit) $strCrit .= ' and ';
					$strCrit .= $temp[0] . " = '" . $temp[1] . "'";
					break;
				case 3: // range passed (assume between inclusive)
					if ($strCrit) $strCrit .= ' and ';
					$strCrit .= $temp[0] . " >= '" . $temp[1] . "' and " . $temp[0] . " <= '" . $temp[2] . "'";
					break;
				default: // error in passed parameters
			}
		}
	}

	// fetch the tables to query
	$tables = array($Prefs['table1'], $Prefs['table2'], $Prefs['table3'], $Prefs['table4'], $Prefs['table5'], $Prefs['table6']);
	$sqlTable = DB_PREFIX . $Prefs['table1'];
	if ($Prefs['table2']) $sqlTable .= ' inner join ' . DB_PREFIX . $Prefs['table2'] . ' on ' . $Prefs['table2criteria'];
	if ($Prefs['table3']) $sqlTable .= ' inner join ' . DB_PREFIX . $Prefs['table3'] . ' on ' . $Prefs['table3criteria'];
	if ($Prefs['table4']) $sqlTable .= ' inner join ' . DB_PREFIX . $Prefs['table4'] . ' on ' . $Prefs['table4criteria'];
	if ($Prefs['table5']) $sqlTable .= ' inner join ' . DB_PREFIX . $Prefs['table5'] . ' on ' . $Prefs['table5criteria'];
	if ($Prefs['table6']) $sqlTable .= ' inner join ' . DB_PREFIX . $Prefs['table6'] . ' on ' . $Prefs['table6criteria'];

	// Build query string and execute
	$sqlCrit = '';
	if ($strCrit  &&  $strDate) $sqlCrit .= $strDate . ' and ' . $strCrit;
	if (!$strCrit &&  $strDate) $sqlCrit .= $strDate;
	if ($strCrit  && !$strDate) $sqlCrit .= $strCrit;

	// We now have the sql, find out how many groups in the query (to determine the number of forms)
	$PageBreakField = $Prefs['formbreakfield'];
	$form_field_list = ($Prefs['filenamesource'] == '') ? $PageBreakField : ($PageBreakField . ', ' . $Prefs['filenamesource']);
	$sql = 'select ' . $form_field_list . ' from ' . $sqlTable;
	if ($sqlCrit) $sql .=' where ' . $sqlCrit;
	$sql .= ' group by ' . $PageBreakField;
	if ($strSort) $sql .= ' order by ' . $strSort;
	// replace table aliases (needed for DB_PREFIX values <> '')
	$sql = GenReplaceTables($sql, $tables);
	// execute sql to see if we have data
//echo 'sql = ' . $sql . '<br />';
	$result = $db->Execute($sql);
	if (!$result->RecordCount()) {
		$messageStack->add(RW_RPT_NOROWS, 'caution');
		return;
	}
	// set the filename for download or email
	if ($Prefs['filenameprefix'] || $Prefs['filenamesource']) {
		$output['filename'] = $Prefs['filenameprefix'] . $result->fields[strip_tablename($Prefs['filenamesource'])] . '.pdf';
	} else {
		$output['filename'] = ReplaceNonAllowedCharacters($Prefs['description']) . '.pdf';
	}

	// create an array for each form
	while (!$result->EOF) {
		$FormPageID[] = $result->fields[strip_tablename($PageBreakField)];
		$result->MoveNext();
	}

	// retrieve the company information
	foreach ($FieldListings as $key => $SingleObject) {
		if ($SingleObject['params']['index'] == 'CDta') {
			$FieldListings[$key]['params']['TextField'] = constant($SingleObject['params']['DataField']);
		}
		if ($SingleObject['params']['index'] == 'CBlk') {
			if (!$SingleObject['params']['Seq']) {
				$messageStack->add(RW_RPT_EMPTYFIELD . $SingleObject['seqnum'], 'error');
				return;
			}
			$TextField = '';
			foreach ($SingleObject['params']['Seq'] as $OneField) {
				$TextField .= AddSep(constant($OneField['TblField']), $OneField['Processing']);
			}
			$FieldListings[$key]['params']['TextField'] = $TextField;
		}
	}

	// patch for special_reports (forms) where the data file is generated externally from the standard class
	if ($Prefs['special_report']) {
		$temp = explode(':', $Prefs['special_report']);
		$form_class = $temp[1];
		if       (file_exists(DIR_FS_MY_FILES . 'custom/reportwriter/classes/' . $form_class . '.php')){
		  $success = include (DIR_FS_MY_FILES . 'custom/reportwriter/classes/' . $form_class . '.php');
		} elseif (file_exists(DIR_FS_MODULES  . 'reportwriter/classes/' . $form_class . '.php')) {
		  $success = include (DIR_FS_MODULES  . 'reportwriter/classes/' . $form_class . '.php');
		} else { 
		  $success = false; 
		}
		if (!$success) {
			$messageStack->add('Special form class: ' . $form_class . ' was called but could not be found!', 'error');
			return;
		}
	}

	// Generate a form for each group element
	$pdf = new PDF();

	foreach ($FormPageID as $formNum => $Fvalue) {
		$pdf->StartPageGroup();
		// find the single line data from the query for the current form page
		$TrailingSQL = " from " . $sqlTable . " where " . ($sqlCrit ? $sqlCrit . " AND " : '') . $PageBreakField . " = '" . $Fvalue . "'";
		if ($Prefs['special_report']) {
			$special_form = new $form_class();
			$FieldValues  = $special_form->load_query_results($PageBreakField, $Fvalue);
		} else {
			$sql         = "select " . $strField . $TrailingSQL;
			$sql         = GenReplaceTables($sql, $tables); // replace table aliases (needed for DB_PREFIX values <> '')
			$result      = $db->Execute($sql);
			$FieldValues = $result->fields;
		}
		// load the posted currency values
		$posted_currencies = array();
		if (ENABLE_MULTI_CURRENCY && strpos($sqlTable, TABLE_JOURNAL_MAIN) !== false) {
			$sql    = "select currencies_code, currencies_value " . $TrailingSQL;
			$sql    = GenReplaceTables($sql, $tables);
			$result = $db->Execute($sql);
			$posted_currencies = array(
				'currencies_code'  => $result->fields['currencies_code'],
				'currencies_value' => $result->fields['currencies_value'],
			);
		} else {
			$posted_currencies = array('currencies_code' => DEFAULT_CURRENCY, 'currencies_value' => 1);
		}
		foreach ($FieldListings as $key => $SingleObject) {
			// Build the text block strings
			if ($SingleObject['params']['index'] == 'TBlk') {
				if (!$SingleObject['params']['Seq']) {
					$messageStack->add(RW_RPT_EMPTYFIELD . $SingleObject['seqnum'], 'error');
					return;
				}
				if ($Prefs['special_report']) {
					$TextField = $special_form->load_text_block_data($SingleObject['params']['Seq']);
				} else {
					$strTxtBlk = ''; // Build the fieldlist
					foreach ($SingleObject['params']['Seq'] as $OneField) $strTxtBlk .= $OneField['TblField'] . ', '; 
					$strTxtBlk    = substr($strTxtBlk, 0, -2); 
					$sql          = "select " . $strTxtBlk . $TrailingSQL;
					$sql          = GenReplaceTables($sql, $tables);
					$result       = $db->Execute($sql);
					$TxtBlkValues = $result->fields;
					$TextField    = '';
					$t            = 0;
					foreach($TxtBlkValues as $Temp) {
						$TextField .= AddSep($Temp, $SingleObject['params']['Seq'][$t]['Processing']);
						$t++;	// mapping counter to separator directive
					}
				}
				$FieldListings[$key]['params']['TextField'] = $TextField;
			}
			// Pre-load all total fields with 'Continued' label for multipage
			if ($SingleObject['params']['index'] == 'Ttl') $FieldListings[$key]['params']['TextField'] = TEXT_CONTINUED;
		}
		$pdf->PageCnt = $pdf->PageNo(); // reset the current page numbering for this new form
		$pdf->AddPage();
		// Send the table
		foreach ($FieldListings as $TableObject) {
			if ($TableObject['params']['index'] == 'Tbl') {
				if (!$TableObject['params']['Seq']) {
					$messageStack->add(RW_RPT_EMPTYFIELD . $TableObject['seqnum'], 'error');
					return;
				}
				// Build the sql
				$tblField = '';
				$tblHeading = array();
				foreach ($TableObject['params']['Seq'] as $TableField) $tblHeading[] = $TableField['TblDesc'];
				if ($Prefs['special_report']) {
					$TableObject['params']['Data'] = $special_form->load_table_data($TableObject['params']['Seq']);
				} else {
					foreach ($TableObject['params']['Seq'] as $TableField) $tblField .= $TableField['TblField'] . ', ';
					$tblField = substr($tblField, 0, -2); // remove the last two chars (comma and space)
					$sql = "select " . $tblField . $TrailingSQL;
					$sql = GenReplaceTables($sql, $tables);
					$result = $db->Execute($sql);
					while (!$result->EOF) {
						$TableObject['params']['Data'][] = $result->fields;
						$result->MoveNext();
					}
				}
				array_unshift($TableObject['params']['Data'], $tblHeading); // set the first data element to the headings
				$StoredTable = $TableObject['params'];
				$pdf->FormTable($TableObject['params']);
			}
		}
		// Send the duplicate data table (only works if each form is contained in a single page [no multi-page])
		foreach ($FieldListings as $SingleObject) {
			if ($SingleObject['params']['index'] == 'TDup') {
				if (!$StoredTable) {
					$messageStack->add(RW_RPT_EMPTYTABLE . $SingleObject['seqnum'], 'error');
					return;
				}
				// insert new coordinates into existing table
				$StoredTable['LineXStrt'] = $SingleObject['params']['LineXStrt'];
				$StoredTable['LineYStrt'] = $SingleObject['params']['LineYStrt'];
				$pdf->FormTable($StoredTable);
			}
		}
		foreach ($FieldListings as $key => $SingleObject) {
			// Set the totals (need to be on last printed page) - Handled in the Footer function in FPDF
			if ($SingleObject['params']['index'] == 'Ttl') {
				if (!$SingleObject['params']['Seq']) {
					$messageStack->add(RW_RPT_EMPTYFIELD . $SingleObject['seqnum'], 'error');
					return;
				}
				if ($Prefs['special_report']) {
					$FieldValues = $special_form->load_total_results($SingleObject['params']);
				} else {
					$ttlField = '';
					foreach ($SingleObject['params']['Seq'] as $Temp) $ttlField .= $Temp . '+';
					$sql         = "select sum(" . substr($ttlField, 0, -1) . ") as form_total" . $TrailingSQL;
					$sql         = GenReplaceTables($sql, $tables);
					$result      = $db->Execute($sql);
					$FieldValues = $result->fields['form_total'];
				}
				$FieldListings[$key]['params']['TextField'] = $FieldValues;
			}
			// Set the data for the last Page if last page only flag checked, pull from temp save
			if ($SingleObject['params']['index'] == 'Data' && $SingleObject['params']['LastOnly'] == '2') {
				$FieldListings[$key]['params']['TextField'] = $FieldListings[$key]['params']['TextTemp'];
			}
		}
		// set the printed flag field if provided
		if ($Prefs['setprintedflag']) {
			$tmp      = GenReplaceTables($PageBreakField, $tables);
			$id_field = $tmp;
			$tmp      = GenReplaceTables($Prefs['setprintedflag'], $tables);
			$temp     = explode('.', $tmp);
			if (sizeof($temp) == 2) { // need the table name and field name
				$sql = "update " . $temp[0] . " set " . $temp[1] . " = " . $temp[1] . " + 1 where " . $id_field . " = '" . $Fvalue . "'";
				$db->Execute($sql);
			}
		}
	}

	// Add additional headers needed for MSIE and send page
	header('Pragma: cache');
	header('Cache-Control: public, must-revalidate, max-age=0');
	$output['pdf'] = $pdf->Output($output['filename'], $delivery_method);

	if ($delivery_method == 'S') {
		return $output;
	}
	exit(); // needs to be here to properly render the pdf file if delivery_method = I or D
}

function BuildSeq($ReportID, $Prefs, $delivery_method = 'D') { // for forms only - Sequential mode
	global $db, $messageStack;
	global $FieldListings, $FieldValues, $posted_currencies;
	$output = array();
	// first fetch all the fields we need to display
	$FieldListings = '';
	$sql = "select seqnum, params from " . TABLE_REPORT_FIELDS . " 
		where reportid = " . $ReportID . " and entrytype = 'fieldlist' and visible = 1
		order by seqnum";
	$result = $db->Execute($sql);
	while (!$result->EOF) {
		$result->fields['params'] = unserialize($result->fields['params']);
		$FieldListings[] = $result->fields;
		$result->MoveNext();
	}
	// check for at least one field selected to show
	if (!$FieldListings) { // No fields are checked to show, that's bad
		$messageStack->add(RW_RPT_NOROWS, 'caution');
		return;
	}

	// Let's build the sql field list for the general data fields (not totals, blocks or tables)
	$strField = '';
	$index = 0; // index each field to allow one field to be used multiple times since $db->Execute returns assoc array

	foreach ($FieldListings as $OneField) { // check for a data field and build sql field list
		if ($OneField['params']['index'] == 'Data' || $OneField['params']['index'] == 'BarCode') { // then it's data field make sure it's not empty
			if ($OneField['params']['DataField'] <> '') {
				$strField .= $OneField['params']['DataField'] . ' as d' . $index . ', ';
				$index++;
			} else { // the field is empty, bad news, error and exit
				$messageStack->add(RW_RPT_EMPTYFIELD . $OneField['seqnum'], 'error');
				return;
			}
		}
	}
	$strField = substr($strField, 0, -2); // strip the extra comma, space and continue

	// fetch the sort order and add to group by string to finish ORDER BY string
	$strSort = $strGroup;
	if (is_array($Prefs['SortListings'])) while ($FieldValues = array_shift($Prefs['SortListings'])) { 
		if ($FieldValues['params']['default'] == '1') {  // then it's the sort by field match
			if ($strSort == '') $strSort .= $FieldValues['fieldname']; else $strSort .= ', ' . $FieldValues['fieldname'];
			$Prefs['filterdesc'] .= RW_RPT_SORTBY . ' ' . $FieldValues['displaydesc'] . '; ';
			break;
		}
	}

	// fetch date filter info (skip if criteria was passed to generate function)
	$strDate = '';
	if (!isset($Prefs['PassedCrit'])) {
		$dates = gen_build_sql_date($Prefs['datedefault'], $Prefs['datefield']);
		$strDate = $dates['sql'];
	}

	// Fetch the Criteria
	$criteria = build_criteria($Prefs['CritListings']);
	$strCrit = $criteria['sql'];
	if (isset($Prefs['PassedCrit'])) { // add the passed criteria to the default criteria
		for($i=0; $i<count($Prefs['PassedCrit']); $i++) {
			$temp = explode(':', $Prefs['PassedCrit'][$i]);
			switch (count($temp)) {
				case 2:// single value passed (assume equal to)
					if ($strCrit) $strCrit .= ' and ';
					$strCrit .= $temp[0] . " = '" . $temp[1] . "'";
					break;
				case 3: // range passed (assume between inclusive)
					if ($strCrit) $strCrit .= ' and ';
					$strCrit .= $temp[0] . " >= '" . $temp[1] . "' and " . $temp[0] . " <= '" . $temp[2] . "'";
					break;
				default: // error in passed parameters
			}
		}
	}

	// fetch the tables to query
	$tables = array($Prefs['table1'], $Prefs['table2'], $Prefs['table3'], $Prefs['table4'], $Prefs['table5'], $Prefs['table6']);
	$sqlTable = DB_PREFIX . $Prefs['table1'];
	if ($Prefs['table2']) $sqlTable .= ' inner join ' . DB_PREFIX . $Prefs['table2'] . ' on ' . $Prefs['table2criteria'];
	if ($Prefs['table3']) $sqlTable .= ' inner join ' . DB_PREFIX . $Prefs['table3'] . ' on ' . $Prefs['table3criteria'];
	if ($Prefs['table4']) $sqlTable .= ' inner join ' . DB_PREFIX . $Prefs['table4'] . ' on ' . $Prefs['table4criteria'];
	if ($Prefs['table5']) $sqlTable .= ' inner join ' . DB_PREFIX . $Prefs['table5'] . ' on ' . $Prefs['table5criteria'];
	if ($Prefs['table6']) $sqlTable .= ' inner join ' . DB_PREFIX . $Prefs['table6'] . ' on ' . $Prefs['table6criteria'];

	// Build query string and execute
	$sqlCrit = '';
	if ($strCrit  &&  $strDate) $sqlCrit .= $strDate . ' and ' . $strCrit;
	if (!$strCrit &&  $strDate) $sqlCrit .= $strDate;
	if ($strCrit  && !$strDate) $sqlCrit .= $strCrit;

	// We now have the sql, find out how many groups in the query (to determine the number of forms)
	$PageBreakField = $Prefs['formbreakfield'];
	$form_field_list = ($Prefs['filenamesource'] == '') ? $PageBreakField : ($PageBreakField . ', ' . $Prefs['filenamesource']);
	$sql = 'select ' . $form_field_list . ' from ' . $sqlTable;
	if ($sqlCrit) $sql .=' where ' . $sqlCrit;
	$sql .= ' group by ' . $PageBreakField;
	if ($strSort) $sql .= ' order by ' . $strSort;
	// replace table aliases (needed for DB_PREFIX values <> '')
	$sql = GenReplaceTables($sql, $tables);
	// execute sql to see if we have data
//echo 'sql = ' . $sql . '<br />';
	$result = $db->Execute($sql);
	if (!$result->RecordCount()) {
		$messageStack->add(RW_RPT_NOROWS, 'caution');
		return;
	}
	// set the filename for download or email
	if ($Prefs['filenameprefix'] || $Prefs['filenamesource']) {
		$output['filename'] = $Prefs['filenameprefix'] . $result->fields[strip_tablename($Prefs['filenamesource'])] . '.pdf';
	} else {
		$output['filename'] = ReplaceNonAllowedCharacters($Prefs['description']) . '.pdf';
	}

	// create an array for each form
	while (!$result->EOF) {
		$FormPageID[] = $result->fields[strip_tablename($PageBreakField)];
		$result->MoveNext();
	}

	// retrieve the company information
	foreach ($FieldListings as $key => $SingleObject) {
		if ($SingleObject['params']['index'] == 'CDta') {
			$FieldListings[$key]['params']['TextField'] = constant($SingleObject['params']['DataField']);
		}
		if ($SingleObject['params']['index'] == 'CBlk') {
			if (!$SingleObject['params']['Seq']) {
				$messageStack->add(RW_RPT_EMPTYFIELD . $SingleObject['seqnum'], 'error');
				return;
			}
			$TextField = '';
			foreach ($SingleObject['params']['Seq'] as $OneField) {
				$TextField .= AddSep(constant($OneField['TblField']), $OneField['Processing']);
			}
			$FieldListings[$key]['params']['TextField'] = $TextField;
		}
	}

	// patch for special_reports (forms) where the data file is generated externally from the standard class
	if ($Prefs['special_report']) {
		$temp = explode(':', $Prefs['special_report']);
		$form_class = $temp[1];
		if       (file_exists(DIR_FS_MY_FILES . 'custom/reportwriter/classes/' . $form_class . '.php')){
		  $success = include (DIR_FS_MY_FILES . 'custom/reportwriter/classes/' . $form_class . '.php');
		} elseif (file_exists(DIR_FS_MODULES  . 'reportwriter/classes/' . $form_class . '.php')) {
		  $success = include (DIR_FS_MODULES  . 'reportwriter/classes/' . $form_class . '.php');
		} else { 
		  $success = false; 
		}
		if (!$success) {
			$messageStack->add('Special form class: ' . $form_class . ' was called but could not be found!', 'error');
			return;
		}
	}

	// Generate a form for each group element
    $output = NULL;
	foreach ($FormPageID as $formNum => $Fvalue) {
		// find the single line data from the query for the current form page
		$TrailingSQL = " from " . $sqlTable . " where " . ($sqlCrit ? $sqlCrit . " AND " : '') . $PageBreakField . " = '" . $Fvalue . "'";
		if ($Prefs['special_report']) {
			$special_form = new $form_class();
			$FieldValues  = $special_form->load_query_results($PageBreakField, $Fvalue);
		} else {
			$sql         = "select " . $strField . $TrailingSQL;
			$sql         = GenReplaceTables($sql, $tables); // replace table aliases (needed for DB_PREFIX values <> '')
			$result      = $db->Execute($sql);
			$FieldValues = $result->fields;
		}
		// load the posted currency values
		$posted_currencies = array();
		if (ENABLE_MULTI_CURRENCY && strpos($sqlTable, TABLE_JOURNAL_MAIN) !== false) {
			$sql    = "select currencies_code, currencies_value " . $TrailingSQL;
			$sql    = GenReplaceTables($sql, $tables);
			$result = $db->Execute($sql);
			$posted_currencies = array(
				'currencies_code'  => $result->fields['currencies_code'],
				'currencies_value' => $result->fields['currencies_value'],
			);
		} else {
			$posted_currencies = array('currencies_code' => DEFAULT_CURRENCY, 'currencies_value' => 1);
		}
		foreach ($FieldListings as $key => $SingleObject) {
		  switch ($SingleObject['params']['index']) {
		    default:
				$value   = ProcessData($SingleObject['params']['TextField'], $SingleObject['params']['Processing']);
				$output .= formatReceipt($value, $SingleObject['params']['BoxWidth'], $SingleObject['params']['FontAlign']);
				break;
		    case 'Data':
				$value   = ProcessData(array_shift($FieldValues), $SingleObject['params']['Processing']);
				$output .= formatReceipt($value, $SingleObject['params']['BoxWidth'], $SingleObject['params']['FontAlign']);
				break;
		    case 'TBlk':
				if (!$SingleObject['params']['Seq']) {
					$messageStack->add(RW_RPT_EMPTYFIELD . $SingleObject['seqnum'], 'error');
					return;
				}
				if ($Prefs['special_report']) {
					$TextField = $special_form->load_text_block_data($SingleObject['params']['Seq']);
				} else {
					$strTxtBlk = ''; // Build the fieldlist
					foreach ($SingleObject['params']['Seq'] as $OneField) $strTxtBlk .= $OneField['TblField'] . ', '; 
					$strTxtBlk    = substr($strTxtBlk, 0, -2); 
					$sql          = "select " . $strTxtBlk . $TrailingSQL;
					$sql          = GenReplaceTables($sql, $tables);
					$result       = $db->Execute($sql);
					$TxtBlkValues = $result->fields;
					$TextField    = '';
					$t            = 0;
					foreach($TxtBlkValues as $Temp) {
						$TextField .= AddSep($Temp, $SingleObject['params']['Seq'][$t]['Processing']);
						$t++;	// mapping counter to separator directive
					}
				}
				$FieldListings[$key]['params']['TextField'] = $TextField;
				$output .= $FieldListings[$key]['params']['TextField'] . "\n";
			    break;
		    case 'Tbl':
				if (!$SingleObject['params']['Seq']) {
					$messageStack->add(RW_RPT_EMPTYFIELD . $SingleObject['seqnum'], 'error');
					return;
				}
				// Build the sql
				$tblField = '';
				$tblHeading = array();
				foreach ($SingleObject['params']['Seq'] as $TableField) $tblHeading[] = $TableField['TblDesc'];
				if ($Prefs['special_report']) {
					$SingleObject['params']['Data'] = $special_form->load_table_data($SingleObject['params']['Seq']);
				} else {
					foreach ($SingleObject['params']['Seq'] as $TableField) $tblField .= $TableField['TblField'] . ', ';
					$tblField = substr($tblField, 0, -2); // remove the last two chars (comma and space)
					$sql = "select " . $tblField . $TrailingSQL;
					$sql = GenReplaceTables($sql, $tables);
					$result = $db->Execute($sql);
					while (!$result->EOF) {
						$SingleObject['params']['Data'][] = $result->fields;
						$result->MoveNext();
					}
				}
//				array_unshift($SingleObject['params']['Data'], $tblHeading); // set the first data element to the headings
				$StoredTable = $SingleObject['params'];
				foreach ($SingleObject['params']['Data'] as $key => $value) {
				  $temp = array();
				  $Col = 0;
				  foreach ($value as $data_key => $data_element) {
//					if ($Params['Seq'][$Col]['TblShow']) {
						$value   = ProcessData($data_element, $SingleObject['params']['Seq'][$data_key]['Processing']);
						$temp[] .= formatReceipt($value, $SingleObject['params']['Seq'][$data_key]['TblColWidth'], $SingleObject['params']['Seq'][$data_key]['FontAlign'], true);
//					}
					$Col++;
				  }
				  $output .= implode("", $temp) . "\n";
				}
				break;
		    case 'TDup':
				if (!$StoredTable) {
					$messageStack->add(RW_RPT_EMPTYTABLE . $SingleObject['seqnum'], 'error');
					return;
				}

// TBD NEED TO FINISH THIS

				break;
		    case 'Ttl':
				if (!$SingleObject['params']['Seq']) {
					$messageStack->add(RW_RPT_EMPTYFIELD . $SingleObject['seqnum'], 'error');
					return;
				}
				if ($Prefs['special_report']) {
					$FieldValues = $special_form->load_total_results($SingleObject['params']);
				} else {
					$ttlField = '';
					foreach ($SingleObject['params']['Seq'] as $Temp) $ttlField .= $Temp . '+';
					$sql         = "select sum(" . substr($ttlField, 0, -1) . ") as form_total" . $TrailingSQL;
					$sql         = GenReplaceTables($sql, $tables);
					$result      = $db->Execute($sql);
					$FieldValues = $result->fields['form_total'];
				}
				$value   = ProcessData($FieldValues, $SingleObject['params']['Processing']);
				$output .= formatReceipt($value, $SingleObject['params']['BoxWidth'], $SingleObject['params']['FontAlign']);
			 	break;
		  }
		}
		// set the printed flag field if provided
		if ($Prefs['setprintedflag']) {
			$tmp      = GenReplaceTables($PageBreakField, $tables);
			$id_field = $tmp;
			$tmp      = GenReplaceTables($Prefs['setprintedflag'], $tables);
			$temp     = explode('.', $tmp);
			if (sizeof($temp) == 2) { // need the table name and field name
				$sql = "update " . $temp[0] . " set " . $temp[1] . " = " . $temp[1] . " + 1 where " . $id_field . " = '" . $Fvalue . "'";
				$db->Execute($sql);
			}
		}
		$output .= "\n" . "\n"; // page break
	}

	$FileSize = strlen($output);
	header("Content-type: application/text");
	header("Content-disposition: attachment; filename=" . $Prefs['description'] . ".txt; size=" . $FileSize);
	header('Pragma: cache');
	header('Cache-Control: public, must-revalidate, max-age=0');
	header('Connection: close');
	header('Expires: ' . date('r', time()+60*60));
	header('Last-Modified: ' . date('r', time()));
	print $output;
	exit();  
}

function formatReceipt($value, $width = '15', $align = 'z', $suppress_nl = false) {
  $temp = explode(chr(10), $value);
  $output = NULL;
  foreach ($temp as $value) {
    switch ($align) {
      case 'L': $output .= str_pad($value, $width, ' ', STR_PAD_RIGHT); break;
      case 'R': $output .= str_pad($value, $width, ' ', STR_PAD_LEFT);  break;
      case 'C': 
	    $num_blanks = (($width - strlen($value)) / 2) + strlen($value);
	    $value   = str_pad($value, intval($num_blanks), ' ', STR_PAD_LEFT);
	    $output .= str_pad($value, $width,              ' ', STR_PAD_RIGHT);  
	    break;
    }
//echo 'value = ' . $value . ' and width = ' . $width . ' and align = ' . $align . ' new string len = ' . strlen($output) . '<br>';
	if (!$suppress_nl) $output .= "\n";
  }
  return $output;
}

function build_criteria($crit_prefs) {
	global $CritChoices;
	$strCrit = '';
	$filCrit = '';
	if (is_array($crit_prefs)) {
		while ($FieldValues = array_shift($crit_prefs)) { 
			$Params = explode(':', $FieldValues['params']);
			if (!$FieldValues['params']['default']) { // if no selection was passed, assume it's the first on the list for that selection menu
				$temp = explode(':', $CritChoices[$FieldValues['params']['value']]);
				$FieldValues['params']['default'] = $temp[1];
			}
			$sc = '';
			$fc = '';
			switch ($FieldValues['params']['default']) {
				case 'RANGE':
					if ($FieldValues['params']['min_val']) { // a from value entered, check
						$sc .= $FieldValues['fieldname'] . " >= '" . $FieldValues['params']['min_val'] . "'";
						$fc .= $FieldValues['displaydesc'] . " >= " . $FieldValues['params']['min_val'];
					}
					if ($FieldValues['params']['max_val']) { // a to value entered, check
						if (strlen($sc)>0) { $sc .= ' AND '; $fc .= ' ' . TEXT_AND . ' '; }
						$sc .= $FieldValues['fieldname'] . " <= '" . $FieldValues['params']['max_val'] . "'";
						$fc .= $FieldValues['displaydesc'] . " <= " . $FieldValues['params']['max_val'];
					}
					break;
				case 'YES':
				case 'TRUE':
				case 'ACTIVE':
				case 'PRINTED':
					$sc .= $FieldValues['fieldname'] . ' = 1';
					$fc .= $FieldValues['displaydesc'] . ' = ' . $FieldValues['params']['default'];
					break;
				case 'NO':
				case 'FALSE':
				case 'INACTIVE':
				case 'UNPRINTED':
					$sc .= $FieldValues['fieldname'] . ' = \'0\'';
					$fc .= $FieldValues['displaydesc'] . ' = ' . $FieldValues['params']['default'];
					break;
				case 'EQUAL':
				case 'NOT_EQUAL':
				case 'GREATER_THAN':
				case 'LESS_THAN':
					if ($FieldValues['params']['default'] == 'EQUAL')        $sign = " = ";
					if ($FieldValues['params']['default'] == 'NOT_EQUAL')    $sign = " <> ";
					if ($FieldValues['params']['default'] == 'GREATER_THAN') $sign = " > ";
					if ($FieldValues['params']['default'] == 'LESS_THAN')    $sign = " < ";
					if (isset($FieldValues['params']['min_val'])) { // a from value entered, check
						$q_field = (strpos($FieldValues['params']['min_val'],'[table') === false) ? ("'" . $FieldValues['params']['min_val'] . "'") : $FieldValues['params']['min_val'];
						$sc .= $FieldValues['fieldname'] . $sign . $q_field;
						$fc .= $FieldValues['displaydesc'] . $sign . $FieldValues['params']['min_val'];
					}
					break;
				case 'IN_LIST':
					if (isset($FieldValues['params']['min_val'])) { // a from value entered, check
						$csv_values = explode(',', $FieldValues['params']['min_val']);
						for ($i = 0; $i < sizeof($csv_values); $i++) $csv_values[$i] = trim($csv_values[$i]); 
						$sc .= $FieldValues['fieldname'] . " in ('" . implode("','", $csv_values) . "')";
						$fc .= $FieldValues['displaydesc'] . " in (" . $FieldValues['params']['min_val'] . ")";
					}
					break;				
				case 'ALL': // sql default anyway
				default:
			}
			if ($sc) {
				if (strlen($strCrit) > 0) {
					$strCrit .= ' and ';
					if ($FieldValues['visible']) $filCrit .= ' ' . TEXT_AND . ' ';
				}
				$strCrit .= $sc;
				if ($FieldValues['visible']) $filCrit .= $fc;
			}
		}
	}
	$criteria = array('sql' => $strCrit, 'description' => $filCrit);
	return $criteria;
}

function strip_tablename($value) {
	return substr($value, strpos($value, '.') + 1);
}

function ReplaceNonAllowedCharacters($String) {
	$DodgyCharactersArray = array('"', ' ', '&', "'");
	$ContainsDodgyCharacters = true;
	while ($ContainsDodgyCharacters == true){
		$ContainsDodgyCharacters = false; //assume all dodgy characters are replaced on the last pass
		foreach ($DodgyCharactersArray as $DodgyCharacter){
			if (strpos($String, $DodgyCharacter, 0)){
				$StrPointer = strpos($String, $DodgyCharacter, 0);
				$String = substr($String, 0, $StrPointer) . '_' . substr($String, $StrPointer+1);
				$ContainsDodgyCharacters = true;
			}
		}
	}
	return $String;
}

function GenReplaceTables($criteria, $tables) {
	if ($tables[0]) $criteria = str_replace('[table1]', DB_PREFIX . $tables[0], $criteria);
	if ($tables[1]) $criteria = str_replace('[table2]', DB_PREFIX . $tables[1], $criteria);
	if ($tables[2]) $criteria = str_replace('[table3]', DB_PREFIX . $tables[2], $criteria);
	if ($tables[3]) $criteria = str_replace('[table4]', DB_PREFIX . $tables[3], $criteria);
	if ($tables[4]) $criteria = str_replace('[table5]', DB_PREFIX . $tables[4], $criteria);
	if ($tables[5]) $criteria = str_replace('[table6]', DB_PREFIX . $tables[5], $criteria);
	return $criteria;
}

function pull_order_qty($ref_id = 0) {
  	global $db, $ReportID;
	$sql = "select qty from " . TABLE_JOURNAL_ITEM  . " where id = " . (int)$ref_id;
	$result = $db->Execute($sql);
	if ($result->RecordCount() == 0) { // no sales/purchase order, was a direct invoice/POS
		$sql = "select qty from " . TABLE_JOURNAL_ITEM  . " where so_po_item_ref_id = " . (int)$ref_id . " and ref_id = " . $ReportID;
		$result = $db->Execute($sql);
	}
	return $result->fields['qty'];
}

  function rw_get_branch_name($id) {
	global $db;
	if (!$id) return COMPANY_ID;
	$result = $db->Execute("select short_name from " . TABLE_CONTACTS . " where id = " . (int)$id);
	if ($result->RecordCount() == 0) return COMPANY_ID;
    return $result->fields['short_name'];
  }

  function rw_get_user_name($id) {
  	global $db;
	if (!$id) return '';
	$result = $db->Execute("select display_name from " . TABLE_USERS . " where admin_id = " . (int)$id);
	if ($result->RecordCount() == 0) return '';
    return $result->fields['display_name'];
  }

  function rw_get_ship_name($id) {
    $parts = explode(':', $id);
	// first standard modules
	$class_name = DIR_FS_MODULES . 'services/shipping/modules/' . $parts[0] . '.php';
	if (file_exists($class_name)) {
	  include_once($class_name);
	  $new_name = constant($parts[0] . '_' . $parts[1]);
	  return ($new_name <> '') ? $new_name : $id;
	}
	// now custom modules
	$class_name = DIR_FS_MY_FILES . 'custom/services/shipping/modules/' . $parts[0] . '.php';
	if (file_exists($class_name)) {
	  include_once($class_name);
	  $new_name = constant($parts[0] . '_' . $parts[1]);
	  return ($new_name <> '') ? $new_name : $id;
	}
	return $id;
  }

?>