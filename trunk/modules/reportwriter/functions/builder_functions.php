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
//  Path: /modules/reportwriter/functions/builder_functions.php
//

// Used for entry into the report builder tool to list available reports
function build_form_href($array_tree, $ref = '') {
	$entry_string = '';
	if (is_array($array_tree)) foreach ($array_tree as $key => $entry) {
		$new_ref = $ref . $key;
		$entry_string .= '<table border="0" cellpadding="1" cellspacing="1"><tr>' . chr(10);
		if (isset($entry['children'])) {
			$entry_string .= '<td><a id="rpt_' . $new_ref . '" href="javascript:Toggle(\'' . $new_ref . '\');">';
			$entry_string .= html_icon('status/folder-open.png', TEXT_EXPAND, 'small', $params = 'hspace="0" vspace="0"') . '</a>';
		} else {
			$entry_string .= '<td>' . html_radio_field('id', 'f' . $key, false);
		}
		$entry_string .= '&nbsp;' . $entry['desc'] . '</td>' . chr(10);
		$entry_string .= '</tr></table>' . chr(10);

		if (isset($entry['children'])) {
			$entry_string .= '<div id="' . $new_ref . '" style="display:none; margin-left:1em;">' . chr(10) . chr(10);
			$entry_string .= build_form_href($entry['children'], $new_ref) . chr(10);
			$entry_string .= '</div>' . chr(10);
		}
	}
	return $entry_string;
}

function security_check($tokens) {
	$categories = explode(';', $tokens);
	$user_str = ':' . $_SESSION['admin_id'] . ':';
	$emp_str = ':' . ($_SESSION['account_id'] ? $_SESSION['account_id'] : '0') . ':';
	$dept_str = ':' . ($_SESSION['department'] ? $_SESSION['department'] : '0') . ':';
	foreach ($categories as $category) {
		$type = substr($category, 0, 1);
		$approved_ids = substr($category, 1) . ':';
		if (strpos($approved_ids, ':0:') !== false) return true; // for 'all' field
		switch ($type) {
			case 'u': if (strpos($approved_ids, $user_str) !== false) return true; break;
			case 'e': if (strpos($approved_ids, $emp_str) !== false) return true; break;
			case 'd': if (strpos($approved_ids, $dept_str) !== false) return true; break;
		}
	}
	return false;
}

// Include functions needed for reportwriter.php
function PrepStep($StepNum, $template = '') {
	global $db, $Type, $paperwidth, $paperheight, $paperorientation, $marginleft, $marginright, $ReportID;
	$head_type = (($Type == 'frm') ? TEXT_FORM : TEXT_REPORT) . ': ';
	// This function sets the titles and include information to prepare for the defined step number
	switch ($StepNum) {
		case '1': // closes the popup window and triggers a reload of opener window
		default:
			$FormParams['IncludePage'] = false;
			break;
		case '2': // id, copy, new report name form
			$FormParams['title']       = RW_TITLE_RPRBLDR . RW_TITLE_STEP2; 
			$FormParams['heading']     = RW_RPT_RPTID;
			$FormParams['IncludePage'] = 'template_id.php';
			break;
		case '3': // page setup form
			$FormParams['title']       = RW_TITLE_RPRBLDR . RW_TITLE_STEP3; 
			$FormParams['heading']     = $head_type;
			$FormParams['IncludePage'] = 'template_page_setup.php';
			break;
		case '4': // db setup form
			$FormParams['title']       = RW_TITLE_RPRBLDR . RW_TITLE_STEP4; 
			$FormParams['heading']     = $head_type;
			$FormParams['IncludePage'] = 'template_db_setup.php';
			break;
		case '5': // field setup form
			// Load the javascript values
			$PageListings              = RetrieveFields('pagelist');
			$temp                      = $PageListings['lists'][0]['params'];
			$pageproperties            = explode(':',$temp['papersize']);
			$paperwidth                = $pageproperties[1];
			$paperheight               = $pageproperties[2];
			$paperorientation          = $temp['paperorientation'];
			$marginleft                = $temp['marginleft'];
			$marginright               = $temp['marginright'];
			// Prep the form
			$FormParams['title']       = RW_TITLE_RPRBLDR . RW_TITLE_STEP5; 
			$FormParams['heading']     = $head_type;
			$FormParams['IncludePage'] = 'template_field_setup.php';
			break;
		case 'prop': // Form field properties form
			global $Params; // we need the form type from the Params variable to load the correct form
			$FormParams['title']       = RW_TITLE_RPRBLDR . TEXT_PROPERTIES; 
			$FormParams['heading']     = $head_type;
			$FormParams['IncludePage'] = 'template_TplFrm' . $template . '.php';
			break;
		case '6': // criteria setup form
			$sql = "select params from " . TABLE_REPORT_FIELDS . " where reportid = " . $ReportID . " and entrytype = 'pagelist'";
			$result = $db->Execute($sql);
			$FormParams['Prefs']       = unserialize($result->fields['params']);
			$FormParams['title']       = RW_TITLE_RPRBLDR . RW_TITLE_STEP6; 
			$FormParams['heading']     = $head_type;
			$FormParams['IncludePage'] = 'template_crit_setup.php';
			break;
		case 'imp': // import form
			$FormParams['title']       = RW_TITLE_RPRBLDR . RW_RPT_RPTIMPORT; 
			$FormParams['heading']     = RW_RPT_RPTIMPORT; 
			$FormParams['IncludePage'] = 'template_import.php';
			break;
		case 'sec': // criteria setup form
			$FormParams['title']       = RW_TITLE_RPRBLDR . RW_TITLE_SECURITY; 
			$FormParams['heading']     = $head_type;
			$FormParams['IncludePage'] = 'template_security_setup.php';
			break;
	} // end switch $StepNum
	return $FormParams;
}

function RetrieveFields($EntryType) {
	global $db, $ReportID;
	$FieldListings['fields'] = '';
	$sql= "select *	from " . TABLE_REPORT_FIELDS . " 
		where reportid = " . $ReportID . " and entrytype = '" . $EntryType . "'
		order by seqnum";
	$result = $db->Execute($sql);
	while (!$result->EOF) {
		switch ($EntryType) {  // special case where params is not serialized
		  default:
			$result->fields['params'] = unserialize($result->fields['params']);
			break;
		  case 'security':
		    break;
		}
		$FieldListings['lists'][] = $result->fields;
		$result->MoveNext();
	}
	// set the form field defaults
	$FieldListings['defaults']['seqnum']      = '';
	$FieldListings['defaults']['fieldname']   = '';
	$FieldListings['defaults']['displaydesc'] = '';
	$FieldListings['defaults']['visible']     = '';
	$FieldListings['defaults']['columnbreak'] = '';
	$FieldListings['defaults']['columnwidth'] = '';
	$FieldListings['defaults']['params']      = array();
	$FieldListings['defaults']['buttonvalue'] = TEXT_ADD;
	return $FieldListings;
}

function UpdatePageFields($ReportID) {
	global $db, $Type;
	// read previous values to save if not changed here
	$sql = "select params from " . TABLE_REPORT_FIELDS . " where reportid = " . $ReportID . " and entrytype = 'pagelist'";
	$result = $db->Execute($sql);
	$data_array = unserialize($result->fields['params']);
	// Update values, first common values to forms and reports
	$data_array['narrative']        = db_prepare_input($_POST['narrative']);
	$data_array['email_msg']        = db_prepare_input($_POST['email_msg']);
	$data_array['papersize']        = db_prepare_input($_POST['papersize']);
	$data_array['paperorientation'] = db_prepare_input($_POST['paperorientation']);
	$data_array['margintop']        = db_prepare_input($_POST['margintop']);
	$data_array['marginbottom']     = db_prepare_input($_POST['marginbottom']);
	$data_array['marginleft']       = db_prepare_input($_POST['marginleft']);
	$data_array['marginright']      = db_prepare_input($_POST['marginright']);
	$data_array['serialform']       = (isset($_POST['serialform'])) ? '1' : '0';
	// the checkboxes to false if not checked
	if ($Type <> 'frm') { // then it's a report, add more info
		$data_array['coynameshow']      = (isset($_POST['coynameshow'])) ? '1' : '0';
		$data_array['title1show']       = (isset($_POST['title1show']))  ? '1' : '0';
		$data_array['title2show']       = (isset($_POST['title2show']))  ? '1' : '0';
		$data_array['coynamefont']      = db_prepare_input($_POST['coynamefont']);
		$data_array['coynamefontsize']  = db_prepare_input($_POST['coynamefontsize']);
		$data_array['coynamefontcolor'] = db_prepare_input($_POST['coynamefontcolor']);
		$data_array['coynamealign']     = db_prepare_input($_POST['coynamealign']);
		$data_array['coynameshow']      = db_prepare_input($_POST['coynameshow']);
		$data_array['title1desc']       = db_prepare_input(addslashes($_POST['title1desc']));
		$data_array['title1font']       = db_prepare_input($_POST['title1font']);
		$data_array['title1fontsize']   = db_prepare_input($_POST['title1fontsize']);
		$data_array['title1fontcolor']  = db_prepare_input($_POST['title1fontcolor']);
		$data_array['title1fontalign']  = db_prepare_input($_POST['title1fontalign']);
		$data_array['title1show']       = db_prepare_input($_POST['title1show']);
		$data_array['title2desc']       = db_prepare_input(addslashes($_POST['title2desc']));
		$data_array['title2font']       = db_prepare_input($_POST['title2font']);
		$data_array['title2fontsize']   = db_prepare_input($_POST['title2fontsize']);
		$data_array['title2fontcolor']  = db_prepare_input($_POST['title2fontcolor']);
		$data_array['title2fontalign']  = db_prepare_input($_POST['title2fontalign']);
		$data_array['title2show']       = db_prepare_input($_POST['title2show']);
		$data_array['filterfont']       = db_prepare_input($_POST['filterfont']);
		$data_array['filterfontsize']   = db_prepare_input($_POST['filterfontsize']);
		$data_array['filterfontcolor']  = db_prepare_input($_POST['filterfontcolor']);
		$data_array['filterfontalign']  = db_prepare_input($_POST['filterfontalign']);
		$data_array['datafont']         = db_prepare_input($_POST['datafont']);
		$data_array['datafontsize']     = db_prepare_input($_POST['datafontsize']);
		$data_array['datafontcolor']    = db_prepare_input($_POST['datafontcolor']);
		$data_array['datafontalign']    = db_prepare_input($_POST['datafontalign']);
		$data_array['totalsfont']       = db_prepare_input($_POST['totalsfont']);
		$data_array['totalsfontsize']   = db_prepare_input($_POST['totalsfontsize']);
		$data_array['totalsfontcolor']  = db_prepare_input($_POST['totalsfontcolor']);
		$data_array['totalsfontalign']  = db_prepare_input($_POST['totalsfontalign']);
	}

	$sql = "update " . TABLE_REPORT_FIELDS . " set 
		params = '" . serialize($data_array) . "'
		where reportid = " . $ReportID . " and entrytype = 'pagelist'";
	$result = $db->Execute($sql);
	return true;
}

function UpdateCritFields($ReportID, $DateString) {
	global $db;
	// update the page setup fields
	$result = $db->Execute("select params from " . TABLE_REPORT_FIELDS . " 
		where reportid = " . $ReportID . " and entrytype = 'pagelist'");
	$params = unserialize($result->fields['params']);
	$params['dateselect']     = $DateString;
	$params['datedefault']    = db_prepare_input($_POST['DefDate']);
	$params['datefield']      = db_prepare_input($_POST['DateField']);
	$params['trunclong']      = db_prepare_input($_POST['TruncLongDesc']);
	$params['totalonly']      = db_prepare_input($_POST['TotalOnly']);
	$params['setprintedflag'] = db_prepare_input($_POST['SetPrintedFlag']);
	$params['formbreakfield'] = db_prepare_input($_POST['FormBreakField']);
	$params['filenameprefix'] = db_prepare_input($_POST['FileNamePrefix']);
	$params['filenamesource'] = db_prepare_input($_POST['FileNameSource']);
	$sql = "update " . TABLE_REPORT_FIELDS . " set params = '" . serialize($params) . "' 
		where reportid = " . $ReportID . " and entrytype = 'pagelist'";
	$result = $db->Execute($sql);
	return true;
}

function UpdateDBFields($ReportID) {
	global $db, $messageStack;
	// Test inputs to see if they are valid
	$special_report = 0;
	if ($_POST['special_report']) {
		if (!$_POST['sr_name']) {
			$messageStack->add(RW_RPT_NO_SPECIAL_REPORT,'error');
			return false; // error if function name is blank for a special report
		}
		$special_report = '1:' . trim(db_prepare_input($_POST['sr_name']));
	}
	if (!$_POST['Table1']) return false;
	$tables = array(
		db_prepare_input($_POST['Table1']),
		db_prepare_input($_POST['Table2']),
		db_prepare_input($_POST['Table3']),
		db_prepare_input($_POST['Table4']),
		db_prepare_input($_POST['Table5']),
		db_prepare_input($_POST['Table6']));

	$strTable = DB_PREFIX . $tables[0];
	if ($tables[1]) {
		if ($_POST['Table2Criteria']) {
			$strTable .= ' inner join ' . DB_PREFIX . $tables[1] . ' on ' . ReplaceTables($_POST['Table2Criteria'], $tables);
		} else return false;
	}
	if ($tables[2]) {
		if ($_POST['Table3Criteria']) {
			$strTable .= ' inner join ' . DB_PREFIX . $tables[2] . ' on ' . ReplaceTables($_POST['Table3Criteria'], $tables);
		} else return false;
	}
	if ($tables[3]) {
		if ($_POST['Table4Criteria']) {
			$strTable .= ' inner join ' . DB_PREFIX . $tables[3] . ' on ' . ReplaceTables($_POST['Table4Criteria'], $tables);
		} else return false;
	}
	if ($tables[4]) {
		if ($_POST['Table5Criteria']) {
			$strTable .= ' inner join ' . DB_PREFIX . $tables[4] . ' on ' . ReplaceTables($_POST['Table5Criteria'], $tables);
		} else return false;
	}
	if ($tables[5]) {
		if ($_POST['Table6Criteria']) {
			$strTable .= ' inner join ' . DB_PREFIX . $tables[5] . ' on ' . ReplaceTables($_POST['Table6Criteria'], $tables);
		} else return false;
	}
	$sql = "select * from " . $strTable . " limit 1";
	$result = $db->Execute_return_error($sql);
	// if we have a row, sql was valid
	if ($db->error_number) return false; // bad SQL
	if ($result->RecordCount() == 0) { // no rows were returned, could be no data yet so just warn and continue
		$messageStack->add(RW_RPT_NO_TABLE_DATA,'caution');
	}

	$sql = "update " . TABLE_REPORTS . " set 
			special_report = '" . $special_report . "', 
			table1 = '" . $tables[0] . "',
			table2 = '" . $tables[1] . "',
			table2criteria = '" . addslashes(db_prepare_input($_POST['Table2Criteria'])) . "',
			table3 = '" . $tables[2] . "',
			table3criteria = '" . addslashes(db_prepare_input($_POST['Table3Criteria'])) . "',
			table4 = '" . $tables[3] . "',
			table4criteria = '" . addslashes(db_prepare_input($_POST['Table4Criteria'])) . "',
			table5 = '" . $tables[4] . "',
			table5criteria = '" . addslashes(db_prepare_input($_POST['Table5Criteria'])) . "',
			table6 = '" . $tables[5] . "',
			table6criteria = '" . addslashes(db_prepare_input($_POST['Table6Criteria'])) . "'
		where id = " . $ReportID;
	$result = $db->Execute($sql);
	return true;
}

function UpdateSequence($SeqNum, $EntryType) {
	global $db, $ReportID, $Type;
	$Visible     = isset($_POST['Visible'])     ? '1' : '0';
	$ColumnBreak = isset($_POST['ColumnBreak']) ? '1' : '0';
	$Params      = NULL;
	switch ($EntryType) {
	  case 'fieldlist':
	    if ($Type == 'frm') {
		  $Params = array( // for reports
		    'index'       => db_prepare_input($_POST['Params']),
		  );
		} else {
		  $Params = array( // for reports
		    'columnwidth' => db_prepare_input($_POST['ColumnWidth']),
		    'processing'  => db_prepare_input($_POST['Processing']),
		    'index'       => db_prepare_input($_POST['Params']),
		    'align'       => db_prepare_input($_POST['Align']),
		  );
		}
		break;
	  case 'critlist':
		$Params = array(
		  'value'       => db_prepare_input($_POST['cParamsVal']),
		  'min_val'     => db_prepare_input($_POST['MinValue']),
		  'max_val'     => db_prepare_input($_POST['MaxValue']),
		);
	    break;
	  case 'grouplist':
		$Params = array(
		  'default'     => isset($_POST['gParamsDef']) ? '1' : '0',
		  'page_break'  => isset($_POST['gParamsBrk']) ? '1' : '0',
		  'processing'  => db_prepare_input($_POST['gProcessing']),
		);
	    break;
	  case 'sortlist':
		$Params = array(
		  'default'     => isset($_POST['sParamsDef']) ? '1' : '0',
		);
	    break;
	  default:
		$Params = db_prepare_input($_POST['Params']);
		break;
	}
	$sql = "update "     . TABLE_REPORT_FIELDS . " set 
		fieldname = '"   . addslashes(db_prepare_input($_POST['FieldName'])) . "',
		displaydesc = '" . addslashes(db_prepare_input($_POST['DisplayDesc'])) . "',
		visible = '"     . $Visible . "',
		columnbreak = '" . $ColumnBreak . "',
		params = '"      . serialize($Params) . "' 
	  where reportid = " . $ReportID . " and entrytype = '" . $EntryType . "' and seqnum = " . $SeqNum;
	$result = $db->Execute($sql);
	return true;
}

function ChangeSequence($SeqNum, $EntryType, $UpDown) {
	global $db, $ReportID;
	// find the id of the row to move
	$sql = "select id from " . TABLE_REPORT_FIELDS . " 
		where reportid = " . $ReportID." and entrytype = '" . $EntryType . "' and seqnum = " . $SeqNum;
	$result = $db->Execute($sql);
	$OrigID = $result->fields['id'];
	if ($UpDown == 'up') $NewSeqNum = $SeqNum - 1; else $NewSeqNum = $SeqNum + 1;
	// first move affected sequence to seqnum, then seqnum to new position
	$sql = "update " . TABLE_REPORT_FIELDS . " set seqnum='" . $SeqNum . "' 
		where reportid = " . $ReportID . " and entrytype = '" . $EntryType . "' and seqnum = " . $NewSeqNum;
	$result = $db->Execute($sql);
	$sql = "update " . TABLE_REPORT_FIELDS . " set seqnum = '" . $NewSeqNum . "' where id = " . $OrigID;
	$result = $db->Execute($sql);
	return true;
}

function InsertSequence($SeqNum = '0', $EntryType) {
// This function creates a hole in the sequencing to allow inserting new data
	global $db, $ReportID, $Type;
	if (!$SeqNum) $SeqNum = '999';
	// read the sequence numbers for the given EntryType
	$sql = "select id from " . TABLE_REPORT_FIELDS . " 
		where reportid = " . $ReportID . " and entrytype = '" . $EntryType . "' 
		order by seqnum";
	$result = $db->Execute($sql);
	$IDList = array();
	while (!$result->EOF) {
		$IDList[] = $result->fields['id'];
		$result->MoveNext();
	}
	if ((count($IDList) == 0) || ($result->RecordCount() < $SeqNum)) $SeqNum = $result->RecordCount() + 1;
	if ($SeqNum <= $result->RecordCount()) { // shift the fields down to make a sequence hole
		for ($j = $SeqNum - 1; $j < $result->RecordCount(); $j++) {
			$sql = "update " . TABLE_REPORT_FIELDS . " set seqnum = " . ($j + 2) . " where id = " . $IDList[$j];
			$temp = $db->Execute($sql);
		}
	}
	$Visible     = isset($_POST['Visible'])     ? '1' : '0';
	$ColumnBreak = isset($_POST['ColumnBreak']) ? '1' : '0';
	$Params      = NULL; 
	switch ($EntryType) {
	  case 'fieldlist':
	    if ($Type == 'frm') {
		  $Params = array( // for reports
		    'index'       => db_prepare_input($_POST['Params']),
		  );
		} else {
		  $Params = array( // for reports
		    'columnwidth' => db_prepare_input($_POST['ColumnWidth']),
		    'processing'  => db_prepare_input($_POST['Processing']),
		    'index'       => db_prepare_input($_POST['Params']),
		    'align'       => db_prepare_input($_POST['Align']),
		  );
		}
		break;
	  case 'critlist':
		$Params = array(
		  'value'       => db_prepare_input($_POST['cParamsVal']),
		  'min_val'     => db_prepare_input($_POST['MinValue']),
		  'max_val'     => db_prepare_input($_POST['MaxValue']),
		);
	    break;
	  case 'grouplist':
		$Params = array(
		  'default'     => isset($_POST['gParamsDef']) ? '1' : '0',
		  'page_break'  => isset($_POST['gParamsBrk']) ? '1' : '0',
		  'processing'  => db_prepare_input($_POST['gProcessing']),
		);
	    break;
	  case 'sortlist':
		$Params = array(
		  'default'     => isset($_POST['sParamsDef']) ? '1' : '0',
		);
	    break;
	  default:
		$Params = db_prepare_input($_POST['Params']);
		break;
	}
	$sql = "insert into " . TABLE_REPORT_FIELDS . " set 
		reportid = '"     . $ReportID . "', 
		entrytype = '"    . $EntryType . "', 
		seqnum = '"       . $SeqNum . "', 
		fieldname = '"    . addslashes(db_prepare_input($_POST['FieldName'])) . "',
		displaydesc = '"  . addslashes(db_prepare_input($_POST['DisplayDesc'])) . "',
		visible = '"      . $Visible . "',
		columnbreak = '"  . $ColumnBreak . "',
		params = '"       . serialize($Params) . "'";
	$result = $db->Execute($sql);
	return $SeqNum;
}

function DeleteSequence($SeqNum, $EntryType) {
// This function removes a sequence field and fills the sequence hole left behind
	global $db, $ReportID;
	//  delete the sequence number from the list
	$sql = "delete from " . TABLE_REPORT_FIELDS . " 
		where reportid = " . $ReportID . " and entrytype = '" . $EntryType . "' and seqnum = " . $SeqNum;
	$result = $db->Execute($sql);
	// read in the remaining sequences and re-number
	$sql = "select id from " . TABLE_REPORT_FIELDS . " 
		where reportid = " . $ReportID . " and entrytype = '" . $EntryType . "' 
		order by seqnum";
	$result = $db->Execute($sql);
	while (!$result->EOF) {
		$IDList[] = $result->fields['id']; 
		$result->MoveNext();
	}
	if ($result->RecordCount() >= $SeqNum) {	// then not at end of list re-number sequences
		for ($j = $SeqNum-1; $j < $result->RecordCount(); $j++) {
			$sql = "update " . TABLE_REPORT_FIELDS . " set seqnum = " . ($j + 1) . " where id = " . $IDList[$j];
			$temp = $db->Execute($sql);
		}
	}
	return true;
}
function InsertFormSeq(&$Params, $Insert) {
// This function creates a hole in the sequencing to allow inserting new form table field data
	$SeqNum = $_POST['TblSeqNum'];
	if (is_array($Params['Seq'])) {
		if (!$SeqNum) $SeqNum = count($Params['Seq']) + 1; // set sequence to last entry if not entered
		if ($SeqNum > (count($Params['Seq']) + 1)) $SeqNum = count($Params['Seq']) + 1;
	} else {
		$SeqNum = 1;
	}
	if (isset($Params['Seq'][$SeqNum-1]) && $Insert == 'insert') { 
		// then the sequence number exists make a hole for this insert
		for ($j = count($Params['Seq']); $j >= $SeqNum; $j--) {
			$Params['Seq'][$j] = $Params['Seq'][$j-1]; // move the array element down one
			$Params['Seq'][$j]['TblSeqNum'] = $j+1; // increment the sequence number
		}
	} // else it's an update which we do anyway
	// Fill in the new data
	$Params['Seq'][$SeqNum - 1]['TblSeqNum']   = $SeqNum;
	$Params['Seq'][$SeqNum - 1]['TblField']    = db_prepare_input($_POST['TblField']);
	$Params['Seq'][$SeqNum - 1]['TblDesc']     = db_prepare_input($_POST['TblDesc']);
	$Params['Seq'][$SeqNum - 1]['Processing']  = db_prepare_input($_POST['Processing']);
	$Params['Seq'][$SeqNum - 1]['Font']        = db_prepare_input($_POST['Font']);
	$Params['Seq'][$SeqNum - 1]['FontSize']    = db_prepare_input($_POST['FontSize']);
	$Params['Seq'][$SeqNum - 1]['FontAlign']   = db_prepare_input($_POST['FontAlign']);
	$Params['Seq'][$SeqNum - 1]['FontColor']   = db_prepare_input($_POST['FontColor']);
	$Params['Seq'][$SeqNum - 1]['TblColWidth'] = db_prepare_input($_POST['TblColWidth']);
	$Params['Seq'][$SeqNum - 1]['TblShow']     = isset($_POST['TblShow']) ? '1' : '0';
	return true;
}

function ModFormTblEntry(&$Params, $todo, $i) {
	switch ($todo) {
		case 'up':
			if ($i > 1) {
				$Temp = $Params['Seq'][$i - 1];
				$Params['Seq'][$i - 1] = $Params['Seq'][$i - 2];
				$Params['Seq'][$i - 2] = $Temp;
				// update the sequence numbers
				$Params['Seq'][$i-1]['TblSeqNum'] = $i;
				$Params['Seq'][$i-2]['TblSeqNum'] = $i - 1;
			}
			break;
		case 'down':
			$Temp = $Params['Seq'][$i-1];
			$Params['Seq'][$i - 1] = $Params['Seq'][$i];
			$Params['Seq'][$i] = $Temp;
			// update the sequence numbers
			$Params['Seq'][$i - 1]['TblSeqNum'] = $i;
			$Params['Seq'][$i]['TblSeqNum']   = $i + 1;
			break;
		case 'edit':
			// set the defaults to the sequence selected
			// Set the form with the values from the sequence selected
			$Params['TblSeqNum']   = $Params['Seq'][$i-1]['TblSeqNum'];
			$Params['TblField']    = $Params['Seq'][$i-1]['TblField'];
			$Params['TblDesc']     = $Params['Seq'][$i-1]['TblDesc'];
			$Params['Processing']  = $Params['Seq'][$i-1]['Processing'];
			$Params['Font']        = $Params['Seq'][$i-1]['Font'];
			$Params['FontSize']    = $Params['Seq'][$i-1]['FontSize'];
			$Params['FontAlign']   = $Params['Seq'][$i-1]['FontAlign'];
			$Params['FontColor']   = $Params['Seq'][$i-1]['FontColor'];
			$Params['TblColWidth'] = $Params['Seq'][$i-1]['TblColWidth'];
			$Params['TblShow']     = $Params['Seq'][$i-1]['TblShow']; 
			return 'edit';
		case 'delete':
			for ($j = $i; $j < count($Params['Seq']); $j++) {
				$Params['Seq'][$j - 1] = $Params['Seq'][$j];
				$Params['Seq'][$j - 1]['TblSeqNum'] = $j;
			}
			$Temp = array_pop($Params['Seq']);
			break;
	}
	return true;
}

function ValidateField($ReportID, $FieldName, $Description) {
	global $db, $Type, $messageStack;
	// This function checks the fieldname and field reference and validates that it is good.
	// first check if a form (fieldname is not provided unless it's the form page break field)
	if ($Type == 'frm' && $Description <> 'TestField') { // then check for non-zero description unless a fieldname is present
		if (strlen($Description) < 1) return false; else return true;
	}

	// Check for a non-blank entry in the field description or fieldname
	if (strlen($FieldName) < 1 || strlen($Description) < 1) return false;

	// fetch the table values to build sql
	$sql = "select special_report, table1, table2, table2criteria, table3, table3criteria, table4, table4criteria,
			table5, table5criteria, table6, table6criteria
		from " . TABLE_REPORTS . " where id = " . $ReportID;
	$result = $db->Execute($sql);
	$Prefs = $result->fields;
	// now check for a special report.
	// Special reports may have fields names that are not in the db and thus will fail this test, so we skip.
	if ($Prefs['special_report']) return true;	

	// Build the table to search, then test inputs to see if they are valid
	$tables = array($Prefs['table1'], $Prefs['table2'], $Prefs['table3'], $Prefs['table4'], $Prefs['table5'], $Prefs['table6']);
	$strTable = DB_PREFIX . $Prefs['table1'];
	if ($Prefs['table2']) $strTable .= ' inner join ' . DB_PREFIX . $Prefs['table2'] . ' on ' . ReplaceTables($Prefs['table2criteria'], $tables);
	if ($Prefs['table3']) $strTable .= ' inner join ' . DB_PREFIX . $Prefs['table3'] . ' on ' . ReplaceTables($Prefs['table3criteria'], $tables);
	if ($Prefs['table4']) $strTable .= ' inner join ' . DB_PREFIX . $Prefs['table4'] . ' on ' . ReplaceTables($Prefs['table4criteria'], $tables);
	if ($Prefs['table5']) $strTable .= ' inner join ' . DB_PREFIX . $Prefs['table5'] . ' on ' . ReplaceTables($Prefs['table5criteria'], $tables);
	if ($Prefs['table6']) $strTable .= ' inner join ' . DB_PREFIX . $Prefs['table6'] . ' on ' . ReplaceTables($Prefs['table6criteria'], $tables);
	$sql = "select " . ReplaceTables($FieldName, $tables) . " from " . $strTable . " limit 1";
	$result = $db->Execute_return_error($sql);
	// if we have a row, sql was valid
	if ($db->error_number) return false; // bad SQL
	if ($result->RecordCount() == 0) { // no rows were returned, could be no data yet so just warn and continue
		$messageStack->add(RW_RPT_NO_TABLE_DATA,'caution');
	}
	return true;
}

function ReadDefReports($name) {
	global $ReportGroups, $FormGroups;
	$dh = opendir(DIR_FS_REPORTS);
	$i = 0;
	while ($DefRpt = readdir($dh)) {
		$pinfo = pathinfo(DIR_FS_REPORTS . $DefRpt);
		if ($pinfo['extension'] == 'txt') { // then it's a report file read name and type
			$FileLines = file(DIR_FS_REPORTS . $DefRpt);
			foreach ($FileLines as $OneLine) { // find the main reports sql statement, language and execute it
				if (strpos($OneLine, 'ReportNarr:') === 0) $ReportNarr = substr(trim($OneLine), 12, -1);
				if (strpos($OneLine, 'ReportData:') === 0) { // then it's the line we're after with description and groupname
					$GrpPos = strpos($OneLine, "groupname='") + 11;
					$GrpName = substr($OneLine, $GrpPos, strpos($OneLine, "',", $GrpPos) - $GrpPos);
					$RptPos = strpos($OneLine,"description='") + 13;
					$RptName = substr($OneLine, $RptPos, strpos($OneLine, "',", $RptPos) - $RptPos);
					$ReportList[$GrpName][$i]['RptName'] = $RptName;
					$ReportList[$GrpName][$i]['RptNarr'] = $ReportNarr;
					$ReportList[$GrpName][$i]['FileName'] = $pinfo[basename];
					$i++;
				}
			}
		}
	}
	closedir($dh);
	$OptionList = '<select name="' . $name . '" size="15">';
	$LstGroup = '';
	$CloseOptGrp = false;
	$i = 0;
	if (is_array($ReportList)) {
	  ksort($ReportList);
	  foreach ($ReportList as $GrpName => $members) {
		$group_split = explode(':',$GrpName); // if it's a form then remove the report form category id
		$GrpMember = $ReportGroups[$group_split[0]];
		if (!$GrpMember) $GrpMember = TEXT_MISC;
		if (isset($group_split[1])) {
		  $form_group = $FormGroups[$GrpName];
		  if (!$form_group) $form_group = 'uncategorized form';
		  $label = $GrpMember . ' - ' . TEXT_FORMS . ' - ' . $form_group;
		} else {
		  $label = $GrpMember . ' - ' . TEXT_REPORTS;
		}
		$OptionList .= '<optgroup label="' . $label . '" title="' . $GrpName . '">';
		foreach ($members as $Temp) {
			$OptionList .= '<option value="' . $Temp['FileName'] . '">' . htmlspecialchars($Temp['RptName'] . ' - ' . $Temp['RptNarr']) . '</option>';
		}
		$OptionList .= '</optgroup>';
	  }
	}
	return $OptionList . '</select>';
}

function ReadImages() {
	$OptionList = array();
	$dh = opendir(DIR_FS_MY_FILES . $_SESSION['company'] . '/images/');
	while ($DefRpt = readdir($dh)) {
		$pinfo = pathinfo(DIR_FS_MY_FILES . $DefRpt);
		$Ext = strtoupper($pinfo['extension']);
		if ($Ext == 'JPG' || $Ext == 'JPEG' || $Ext == 'PNG') { //fpdf only supports JPG and PNG formats!!!
			$OptionList[] = array('id' => $pinfo['basename'], 'text' => $pinfo['basename']) ;
		}
	}
	closedir($dh);
	return $OptionList;
}

function ImportImage() {
	global $db;
	if ($_POST['ImgChoice'] == 'Select') { // then a locally stored image was chosen, return with image name
		$Rtn['result'] = 'success';
		$Rtn['message'] = $_POST['ImgFileName'] . TEXT_IMP_ERMSG9;
		$Rtn['filename'] = $_POST['ImgFileName'];
		return $Rtn;
	}
	$Rtn['result'] = 'error';
	if ($_FILES['imagefile']['error']) { // php error uploading file
		switch ($_FILES['imagefile']['error']) {
			case '1': $Rtn['message'] = TEXT_IMP_ERMSG1; break;
			case '2': $Rtn['message'] = TEXT_IMP_ERMSG2; break;
			case '3': $Rtn['message'] = TEXT_IMP_ERMSG3; break;
			case '4': $Rtn['message'] = TEXT_IMP_ERMSG4; break;
			default:  $Rtn['message'] = TEXT_IMP_ERMSG5 . $_FILES['imagefile']['error'] . '.';
		}
	} elseif (!is_uploaded_file($_FILES['imagefile']['tmp_name'])) { // file uploaded
		$Rtn['message'] = TEXT_IMP_ERMSG10;
	} elseif (strpos($_FILES['imagefile']['type'],'image') === false) { // not an imsge file extension
		$Rtn['message'] = TEXT_IMP_ERMSG6; 
	} elseif ($_FILES['imagefile']['size'] == 0) { // report contains no data, error
		$Rtn['message'] = TEXT_IMP_ERMSG7;
	} else { // passed all error checking, save the image
		$success = @move_uploaded_file($_FILES['imagefile']['tmp_name'], DIR_FS_MY_FILES . $_SESSION['company'] . '/images/' . $_FILES['imagefile']['name']);
		if (!$success) { // someone tried to hack the script
			$Rtn['message'] = 'Upload error. File cannot be processed, check directory permissions!';
		} else {
			$Rtn['result'] = 'success';
			$Rtn['message'] = $_FILES['imagefile']['name'] . TEXT_IMP_ERMSG9;
			$Rtn['filename'] = $_FILES['imagefile']['name'];
		}
	}
	return $Rtn;
}

function ExportReport($ReportID) {
	global $db, $messageStack;
	$crlf = chr(10);
	$CSVOutput = '/* Report Builder Export Tool */' . $crlf;
	$CSVOutput .= 'version:1.0' . $crlf;
	// Fetch the core report data from table reports
	$sql = "select * from " . TABLE_REPORTS . " where id = " . $ReportID;
	$result = $db->Execute($sql);
	$myrow = $result->fields;
	// Fetch the language dependent db entries
	$ReportName = $myrow['description'];
	// Enter some export file info for language translation
	$CSVOutput .= '/* Report Name: ' . $ReportName . ' */' . $crlf;
	$CSVOutput .= '/* Export File Generated: : ' . date('Y-m-d h:m:s', time()) . ' */' . $crlf . $crlf . $crlf;
	$CSVOutput .= '/* Language Fields. */' . $crlf;
	$CSVOutput .= '/* Only modify the language portion between the single quotes after the colon. */' . $crlf . $crlf;
	$CSVOutput .= '/* Report Name */' . $crlf;
	$CSVOutput .= "ReportName:'" . addslashes($ReportName) . "'" . $crlf;
	$sql = "select params from " . TABLE_REPORT_FIELDS . " where reportid = " . $ReportID . " and entrytype = 'pagelist'";
	$result = $db->Execute($sql);
	$params = unserialize($result->fields['params']);
	$CSVOutput .= "ReportNarr:'" . addslashes($params['narrative']) . "'" . $crlf;
	$CSVOutput .= "EmailMsg:'"   . addslashes($params['email_msg']) . "'" . $crlf;
	
	// Now add the report fields
	$CSVOutput .= $crlf . '/* Report Field Description Information */' . $crlf;
	$sql = "select * from " . TABLE_REPORT_FIELDS . " where reportid = " . $ReportID . " order by entrytype, seqnum";
	$result = $db->Execute($sql);
	$i = 0;
	$skip_array = array('dateselect', 'trunclong', 'pagelist', 'security');
	while (!$result->EOF) {
		if (!in_array($result->fields['entrytype'], $skip_array)) {
			$CSVOutput .= "FieldDesc" . $i . ":'" . addslashes($result->fields['displaydesc']) . "'" . $crlf;
		}
		$sql = 'FieldData' . $i . ':';
		foreach ($result->fields as $key => $value) {
			if ($key<>'id' && $key<>'reportid') $sql .= $key . "='" . addslashes($value) . "', ";
		}
		$sql = substr($sql,0,-2) . ";"; // Strip the last comma and space and add a semicolon
		$FieldData[$i] = $sql;
		$i++;
		$result->MoveNext();
	}
	$CSVOutput .= $crlf . '/* End of language fields. */' . $crlf . $crlf;
	$CSVOutput .= '/* DO NOT EDIT BELOW THIS LINE! */' . $crlf . $crlf . $crlf;
	$CSVOutput .= '/* SQL report data. */' . $crlf;
	// Build the report sql string
	$RptData = 'ReportData:';
	foreach ($myrow as $key => $value) if ($key <> 'id') $RptData .= $key . "='" . addslashes($value) . "', ";
	$RptData = substr($RptData, 0, -2) . ";"; // Strip the last comma and space and add a semicolon
	$CSVOutput .= $RptData . $crlf . $crlf;
	$CSVOutput .= '/* SQL field data. */' . $crlf;
	for ($i = 0; $i < count($FieldData); $i++) $CSVOutput .= $FieldData[$i] . $crlf;
	$CSVOutput .= $crlf;
	$CSVOutput .= '/* End of Export File */' . $crlf;

	// export the file, check to see if save locally or download
	$filename = preg_replace('/ /', '', $ReportName) . '.rpt.txt';
	if (IE_RW_EXPORT_PREFERENCE == 'Local') { // save the file locally
		$full_path_filename = DIR_FS_REPORTS . $filename;
		if (!$handle = fopen($full_path_filename, 'w')) {
			$messageStack->add("Cannot open file ($full_path_filename)",'error');
				return false;
		}
		if (fwrite($handle, $CSVOutput) === false) {
			$messageStack->add("Cannot write to file ($full_path_filename)",'error');
				return false;
		}
		fclose($handle);
	} else { // download the file
		$FileSize = strlen($CSVOutput);
		header("Content-type: application/txt");
		header("Content-disposition: attachment; filename=" . $filename . "; size=" . $FileSize);
		// These next two lines are needed for MSIE
		header('Pragma: cache');
		header('Cache-Control: public, must-revalidate, max-age=0');
		print $CSVOutput;
		exit();
	}
	return true;
}

function ImportReport($RptName) {
	global $db;
	if ($_POST['RptFileName'] <> '') { // then a locally stored report was chosen
		$arrSQL = file(DIR_FS_REPORTS . $_POST['RptFileName']);
	} else { // check for an uploaded file
		$Rtn['result'] = 'error';
		if ($_FILES['reportfile']['error']) { // php error uploading file
			switch ($_FILES['reportfile']['error']) {
				case '1': $Rtn['message'] = TEXT_IMP_ERMSG1; break;
				case '2': $Rtn['message'] = TEXT_IMP_ERMSG2; break;
				case '3': $Rtn['message'] = TEXT_IMP_ERMSG3; break;
				case '4': $Rtn['message'] = TEXT_IMP_ERMSG4; break;
				default:  $Rtn['message'] = TEXT_IMP_ERMSG5 . $_FILES['reportfile']['error'] . '.';
			}
		} elseif (!is_uploaded_file($_FILES['reportfile']['tmp_name'])) { // file uploaded
			$Rtn['message'] = TEXT_IMP_ERMSG10;
		} elseif (strpos($_FILES['reportfile']['type'], 'text') === false)  { // not a text file, error
			$Rtn['message'] = TEXT_IMP_ERMSG6;
		} elseif ($_FILES['reportfile']['size'] == 0) { // report contains no data, error
			$Rtn['message'] = TEXT_IMP_ERMSG7;
		} else { // passed all error checking, read file and reset error message
			$arrSQL = file($_FILES['reportfile']['tmp_name']);
			$Rtn['result'] = '';
		}
		if ($Rtn['result'] == 'error') return $Rtn;
	}
	
	if (is_array($arrSQL)) foreach ($arrSQL as $sql) { // find the report translated description and title information
		if (strpos($sql, 'ReportName:') === 0) $ReportName = substr(trim($sql), 12, -1);
	}
	// check for valid file, duplicate report name
	if ($RptName == '') $RptName = $ReportName; // then no report was entered use description from file
	$sql= "select id from " . TABLE_REPORTS . " where description = '" . addslashes($RptName) . "'";
	$result = $db->Execute($sql);
	if ($result->RecordCount()>0) { // the report name already exists, error 
		$Rtn['result'] = 'error';
		$Rtn['message'] = RW_RPT_REPDUP;
		return $Rtn;
	}
	// Find the line with the table reports element, needs to be written first
	$ValidReportSQL = false;
	if (is_array($arrSQL)) foreach ($arrSQL as $sql) { // find the main reports sql statement, language and execute it
		if (strpos($sql,'ReportData:') === 0) {
			$values = substr(trim($sql), 11);
			$values = substr($values, 0, strlen($values)-1);
			$data_array = explode(',', $values);
			$sql_array = array();
			foreach ($data_array as $value) {
				$parts = explode('=', $value, 2);
				$sql_array[trim($parts[0])] = substr(trim($parts[1]), 1, -1);
			}
			$sql="insert into " . TABLE_REPORTS . " set 
				description = '" . $sql_array['description'] . "', 
				reporttype = '" . $sql_array['reporttype'] . "', 
				groupname = '" . $sql_array['groupname'] . "',  
				standard_report = '" . $sql_array['standard_report'] . "', 
				special_report = '" . $sql_array['special_report'] . "', 
				table1 = '" . $sql_array['table1'] . "', 
				table2 = '" . $sql_array['table2']  . "', 
				table2criteria = '" . $sql_array['table2criteria']  . "', 
				table3 = '" . $sql_array['table3'] . "', 
				table3criteria = '" . $sql_array['table3criteria']  . "', 
				table4 = '" . $sql_array['table4']  . "', 
				table4criteria = '" . $sql_array['table4criteria']  . "', 
				table5 = '" . $sql_array['table5'] . "', 
				table5criteria = '" . $sql_array['table5criteria'] . "', 
				table6 = '" . $sql_array['table6'] . "', 
				table6criteria = '" . $sql_array['table6criteria'] . "'";
			$result = $db->Execute($sql);
			// fetch the id of the row inserted 
			$ReportID = $db->insert_ID();
			if (isset($sql_array['papersize'])) load_page_fields($sql_array, $ReportID); // for pre-release reports and forms
			$ValidReportSQL = true;
		}
	}
	if (!$ValidReportSQL) { // no valid report sql statement found in the text file, error
		$Rtn['result'] = 'error';
		$Rtn['message'] = TEXT_IMP_ERMSG8;
		return $Rtn;
	}
	// update the translated report name and title fields into the newly imported report
	$sql = "update " . TABLE_REPORTS . " set description = '" . $RptName . "' where id = " . $ReportID;
	$result = $db->Execute($sql);
	foreach ($arrSQL as $sql) { // fetch the translations for the field descriptions
		if (strpos($sql,'FieldDesc') === 0) { // then it's a field description, find the index and save
			$sql = trim($sql);
			$FldIndex = substr($sql, 9, strpos($sql, ':') - 9);
			$Language[$FldIndex] = substr($sql, strpos($sql, ':') + 2, -1);
		}
	}
	$needs_update = false;
	foreach ($arrSQL as $sql) {
		if (strpos($sql, 'FieldData') === 0) { // a valid field, write it
			$sql = trim($sql);
			$FldIndex = substr($sql, 9, strpos($sql, ':') - 9);
			$sql = "insert into " . TABLE_REPORT_FIELDS . " set " . substr($sql, strpos($sql, ':') + 1);
			// check for update required (for Pre R1.9 reports) where some fields have been combined
			if (strpos($sql, 'dateselect') || strpos($sql, 'trunclong')) $needs_update = true;
			$result = $db->Execute($sql);
			$FieldID = $db->insert_ID();
			if ($FieldID <> 0) { // A field was successfully written update the report id
				$DispSQL = isset($Language[$FldIndex]) ? ("displaydesc='" . $Language[$FldIndex] . "', ") : '';
				$sql = "update " . TABLE_REPORT_FIELDS . " set " . $DispSQL . " reportid = " . $ReportID . " where id = " . $FieldID;
				$result = $db->Execute($sql);
			}
		}
	}
	if ($needs_update) {
	  require_once(DIR_FS_MODULES . 'install/functions/install.php');
	  update_reports();
	}
	$Rtn['result'] = 'success';
	$Rtn['message'] = $RptName . TEXT_IMP_ERMSG9;
	return $Rtn;
}

function load_page_fields($sql_array, $ReportID) {
	// this function is used to import reports asved in the pre-release format where the page setup was part of the
	// reports table and not a parameter
	// first lose the fields that are still in the reports table, insert the rest as a new pagelist record
	unset($sql_array['description']);
	unset($sql_array['reporttype']);
	unset($sql_array['groupname']);
	unset($sql_array['standard_report']);
	unset($sql_array['special_report']);
	unset($sql_array['table1']);
	unset($sql_array['table2']);
	unset($sql_array['table2criteria']);
	unset($sql_array['table3']);
	unset($sql_array['table3criteria']);
	unset($sql_array['table4']);
	unset($sql_array['table4criteria']);
	unset($sql_array['table5']);
	unset($sql_array['table5criteria']);
	unset($sql_array['table6']);
	unset($sql_array['table6criteria']);
	$sql_array['title1desc'] = addslashes($sql_array['title1desc']);
	$sql_array['title2desc'] = addslashes($sql_array['title2desc']);
	// write the new page field
	$new_array = array();
	$new_array['entrytype'] = 'pagelist';
	$new_array['params'] = serialize($sql_array);
	$new_array['reportid'] = $ReportID;
	db_perform(TABLE_REPORT_FIELDS, $new_array, 'insert');
}

function CreateTableList($ReportID, $Table) {
	global $db;
	$sql = "select table" . $Table . " from " . TABLE_REPORTS . " where id = " . $ReportID;
	$result = $db->Execute($sql);
	$ref_table = $result->fields['table' . $Table];
	
	$TableList = array();
	$TableList[] = array('id' => '', 'text' => TEXT_SELECT); // set the please select option
	$sql = "show tables";
	$result = $db->Execute($sql);
	while (!$result->EOF) {
		$tablename = array_shift($result->fields);
		$BaseTableName = (DB_PREFIX) ? substr($tablename, strlen(DB_PREFIX)) : $tablename;
		$TableList[] = array('id' => $BaseTableName, 'text' => $tablename);
		$result->MoveNext();
	}
	return $TableList;
} // CreateTableList

function CreateFieldArray($ReportID) {
	global $db;
	$sql = "select table1, table2, table3, table4, table5, table6 from " . TABLE_REPORTS . " where id = " . $ReportID;
	$result = $db->Execute($sql);
	$myrow = $result->fields;
	$Fields = array();
	$Fields[] = array('id' => '', 'text' => TEXT_SLCTFIELD); // set the please select option

	for ($i = 0; $i < 6; $i++) {
		if ($myrow['table' . ($i+1)]) {
			$sql = "describe " . DB_PREFIX . $myrow['table' . ($i+1)];
			$result = $db->Execute($sql);
			while (!$result->EOF) {
//				$fieldname = '[table' . ($i+1) . '].' . strtolower($result->fields['Field']);
				$fieldname = '[table' . ($i+1) . '].' . $result->fields['Field'];
				$Fields[] = array('id' => $fieldname, 'text' => $fieldname);
				$result->MoveNext();
			} // while
		} // if
	} // for
	return $Fields;
}  // CreateFieldArray

function CreateSpecialDropDown($ReportID, $type = 'field') {
	global $db;
	$sql = "select special_report from " . TABLE_REPORTS . " where id = " . $ReportID;
	$result = $db->Execute($sql);
	$temp = explode(':', $result->fields['special_report']);
	$SpFunc = $temp[1];
	if (!$SpFunc) return CreateFieldArray($ReportID);
	// pull in the special function class and build drop-down
	if       (file_exists(DIR_FS_MY_FILES . 'custom/reportwriter/classes/' . $SpFunc . '.php')) {
	  require_once(DIR_FS_MY_FILES . 'custom/reportwriter/classes/' . $SpFunc . '.php');
	} elseif (file_exists(DIR_FS_MODULES . 'reportwriter/classes/' . $SpFunc . '.php')) {
	  require_once(DIR_FS_MODULES . 'reportwriter/classes/' . $SpFunc . '.php');
	}
	$output = new $SpFunc();
	if ($type == 'table') {
		return $output->build_table_drop_down();
	} else {
		return $output->build_selection_dropdown();
	}
}

function CreateCompanyArray() {
	global $db;
	include(DIR_FS_MODULES . 'install/language/' . $_SESSION['language'] . '/config_data.php');
	$sql = 'select configuration_key, configuration_title from ' . TABLE_CONFIGURATION . ' where configuration_group_id = 1';
	$result = $db->Execute($sql);
	while (!$result->EOF) {
		$temp[$result->fields['configuration_key']] = constant($result->fields['configuration_title']);
		$result->MoveNext();
	}
	// Company data array - just the ones we want
	$company_array = array();
	$company_array[] = array('id' => '', 'text' => TEXT_SLCTFIELD);
	$company_array[] = array('id' => 'COMPANY_NAME', 'text' => $temp['COMPANY_NAME']);
	$company_array[] = array('id' => 'COMPANY_ADDRESS1', 'text' => $temp['COMPANY_ADDRESS1']);
	$company_array[] = array('id' => 'COMPANY_ADDRESS2', 'text' => $temp['COMPANY_ADDRESS2']);
	$company_array[] = array('id' => 'COMPANY_CITY_TOWN', 'text' => $temp['COMPANY_CITY_TOWN']);
	$company_array[] = array('id' => 'COMPANY_ZONE', 'text' => $temp['COMPANY_ZONE']);
	$company_array[] = array('id' => 'COMPANY_POSTAL_CODE', 'text' => $temp['COMPANY_POSTAL_CODE']);
	$company_array[] = array('id' => 'COMPANY_COUNTRY', 'text' => $temp['COMPANY_COUNTRY']);
	$company_array[] = array('id' => 'COMPANY_TELEPHONE1', 'text' => $temp['COMPANY_TELEPHONE1']);
	$company_array[] = array('id' => 'COMPANY_TELEPHONE2', 'text' => $temp['COMPANY_TELEPHONE2']);
	$company_array[] = array('id' => 'COMPANY_FAX', 'text' => $temp['COMPANY_FAX']);
	$company_array[] = array('id' => 'COMPANY_EMAIL', 'text' => $temp['COMPANY_EMAIL']);
	$company_array[] = array('id' => 'COMPANY_WEBSITE', 'text' => $temp['COMPANY_WEBSITE']);
	$company_array[] = array('id' => 'TAX_ID', 'text' => $temp['TAX_ID']);
	$company_array[] = array('id' => 'COMPANY_ID', 'text' => $temp['COMPANY_ID']);
	$company_array[] = array('id' => 'AR_CONTACT_NAME', 'text' => $temp['AR_CONTACT_NAME']);
	$company_array[] = array('id' => 'AP_CONTACT_NAME', 'text' => $temp['AP_CONTACT_NAME']);
	return $company_array;
}

function ReplaceTables($criteria, $tables) {
	if ($tables[0]) $criteria = str_replace('[table1]', DB_PREFIX . $tables[0], $criteria);
	if ($tables[1]) $criteria = str_replace('[table2]', DB_PREFIX . $tables[1], $criteria);
	if ($tables[2]) $criteria = str_replace('[table3]', DB_PREFIX . $tables[2], $criteria);
	if ($tables[3]) $criteria = str_replace('[table4]', DB_PREFIX . $tables[3], $criteria);
	if ($tables[4]) $criteria = str_replace('[table5]', DB_PREFIX . $tables[4], $criteria);
	if ($tables[5]) $criteria = str_replace('[table6]', DB_PREFIX . $tables[5], $criteria);
	return $criteria;
}

function convertWords($data) {
	if (!$data) return '&nbsp;';
	$words = explode(':', $data);
	foreach ($words as $key => $value) $words[$key] = constant('TEXT_' . $value);
	return implode(' : ', $words);
}

function crit_build_pull_down($keyed_array) {
	$values = array();
	if (is_array($keyed_array)) {
		foreach ($keyed_array as $key => $value) {
			$value = substr($value, 2);
			$words = explode(':', $value);
			foreach ($words as $idx => $word) $words[$idx] = constant('TEXT_' . $word);
			$values[] = array('id' => $key, 'text' => implode(':', $words));
		}
	}
	return $values;
}

?>