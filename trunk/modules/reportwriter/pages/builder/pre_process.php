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
//  Path: /modules/reportwriter/pages/builder/pre_process.php
//

/*
This script has the responsibility to gather basic information necessary to retrieve data for reports. 
It is comprised of several steps designed to gather display preferences, database information, field 
information and filter/criteria information. The Report builder process is as follows:

Step 1: (or script entry): displays the current listing of reports. Uses form ReportsHome.html as a UI.
Step 2: (action=step2): After the user has selected an option, this step is followed to enter a report 
	name and the type of report it is for grouping purposes.
Step 3: Handles the page setup information.
Step 4: Handles the database setup and link information.
Step 5: Handles the database field selection.
Step 6: Handles the Criteria and filter selection.
Export: Handled in action=step2, calls ExportReport to save report as a text file.
Import: Handled in action=step8, calls an import function to read the setup information from a text file.
*/

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_REPORTS];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING . 'functions/builder_functions.php');

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/reportwriter/extra_operations.php';
if (file_exists($custom_path)) { include($custom_path); }

/**************   page specific initialization  *************************/
$pageproperties   = explode(':', RW_DEFAULT_PAPERSIZE);
$paperwidth       = $pageproperties[1];
$paperheight      = $pageproperties[2];
$paperorientation = RW_DEFAULT_ORIENTATION;
$marginleft       = RW_DEFAULT_MARGIN;
$marginright      = RW_DEFAULT_MARGIN;

$action   = $_GET['action'];
$todo     = (isset($_POST['todo'])) ? $_POST['todo'] : $_GET['todo'];
$ReportID = (isset($_POST['ReportID'])) ? $_POST['ReportID'] : $_GET['ReportID'];
$Type     = (isset($_POST['Type'])) ? $_POST['Type'] : '';

// a valid report id needs to be passed as a post field to do anything, except create new report
if ($ReportID && !$Type) { // we need to retrieve more info from the db to set up the forms correctly
	$result = $db->Execute("select reporttype, description from " . TABLE_REPORTS . " where id = " . $ReportID);
	$Type        = $result->fields['reporttype'];
	$Description = $result->fields['description'];
}

/***************   Act on the action request   *************************/
switch ($action) {
	case "step2": // entered from select an action (home) page
		// first check to see if a report was selected (except new report and import)
		if (!isset($action) || ($ReportID == '' && $todo <> 'new' && $todo <> 'import')) {
			// skip error message if back from import was pressed
			if (isset($action)) $messageStack->add(RW_FRM_NORPT, 'error');
			$FormParams = PrepStep('1');
			break;
		}
		switch ($todo) {
			case 'new': // Fetch the defaults and got to select id screen
				$ReportID = '';
				$FormParams = PrepStep('2');
				break;
			case 'edit': // fetch the report information and go to the page setup screen
				$PageListings = RetrieveFields('pagelist');
				$myrow = $PageListings['lists'][0]['params'];
				$myrow['description'] = $Description;
				$FormParams = PrepStep('3');
				break;
			case 'rename': // Rename a report was selected, fetch the report name and show rename form
				$sql = "select description from " . TABLE_REPORTS . " where id = " . $ReportID;
				$result = $db->Execute($sql);
				$myrow = $result->fields;
				$ReplaceReportID = $ReportID;
				$_POST['ReportName'] = stripslashes($myrow['description']);
				// continue like copy was pushed
			case 'copy': // Copy a report was selected 
				$FormParams = PrepStep('2');
				break;
			case 'delete': // after confirmation, delete the report and go to the main report admin menu
				$sql= "delete from " . TABLE_REPORTS . " where id = " . $ReportID;
				$result = $db->Execute($sql);
				$sql= "delete from " . TABLE_REPORT_FIELDS . " where reportid = " . $ReportID;
				$result = $db->Execute($sql);
				// reload main entry form
			default:
				$FormParams = PrepStep('1');
				break;
			case 'export':
				$success = ExportReport($ReportID); // We don't return from hereif download
				// we are here so there was an error or the report was saved locally
				if ($success) {
					$messageStack->add_session(RW_RPT_EXPORT_SUCCESS,'success');
				} else {
					$messageStack->add_session(RW_RPT_EXPORT_FAILED,'error');
				}
				$FormParams = PrepStep('1');
				break;
			case 'import': // show the file import form
				$ReportName = '';
				$FormParams = PrepStep('imp');
				break;
		}
		break; // End Step 2
	
	case "step3": // entered from id setup page
		switch ($todo) {
			case 'replace': // Erase the default report and copy a new one with the same name
				if (isset($_POST['ReplaceReportID'])) { // then we need to delete the report to replace
					$sql= "delete from " . TABLE_REPORTS . " where id = " . $_POST['ReplaceReportID'];
					$result = $db->Execute($sql);
					$sql= "delete from " . TABLE_REPORT_FIELDS . " where reportid = " . $_POST['ReplaceReportID'];
					$result = $db->Execute($sql);
				}
				// report has been deleted, continue to create or copy (in case 'Continue' below)
			case 'update': // copy the report and return to the main reports screen
			case 'continue': // fetch the report information and go to the page setup screen
				// input error check description, blank duplicate, bad characters, etc.
				if ($_POST['ReportName']=='') { // no report name was entered, error and reload form
					$messageStack->add(RW_RPT_NORPT, 'error');
					$FormParams = PrepStep('2');
					break;
				}
				// check for duplicate report name
				$sql = "select id from " . TABLE_REPORTS." 
					where description = '" . addslashes($_POST['ReportName']) . "'";
				$result = $db->Execute($sql);
				if ($result->RecordCount() > 0) { // then we have a duplicate report name, error and reload
					$myrow = $result->fields;
					$ReplaceReportID = $myrow['id']; // save the duplicate report id
					$messageStack->add(RW_RPT_SAVEDUP, 'error');
					$messageStack->add(RW_RPT_DEFDEL, 'caution');
					$FormParams = PrepStep('2');
					break;
				}
				// Input validated perform requested operation
				if ($ReportID == '') { // then it's a new report
					// Check to see if a form or report to create
					if ($_POST['NewType']=='') { // then no type selected, error and re-display form
						$messageStack->add(RW_RPT_NORPTTYPE, 'caution');
						$FormParams = PrepStep('2');
						break;
					} elseif ($_POST['NewType']=='rpt') { // a report, read the groupname
						$GroupName = $_POST['GroupName'];
					} elseif ($_POST['NewType']=='frm') { // a form, set the groupname
						$GroupName = $_POST['FormGroup'];
					}
					$Type = $_POST['NewType'];
					$sql = "insert into " . TABLE_REPORTS . " (description, reporttype, groupname, standard_report)
						values ('" . addslashes($_POST['ReportName']) . "', '" . $Type . "', '" . $GroupName . "', '1')";
					$result = $db->Execute($sql);
					$ReportID = $db->insert_ID();
					// Set some default report information: date display default choices to 'ALL'
					if ($Type<>'frm') { // set the truncate long descriptions default
						$sql = "insert into " . TABLE_REPORT_FIELDS . " (reportid, entrytype, params, displaydesc)
							values (" . $ReportID . ", 'trunclong', '0', '')";
						$result = $db->Execute($sql);
					} else { // it's a form so write a default form break record
						$sql = "insert into " . TABLE_REPORT_FIELDS . " (reportid, entrytype, params, displaydesc)
							values (" . $ReportID . ", 'grouplist', '', '')";
						$result = $db->Execute($sql);
					}
					$sql = "insert into " . TABLE_REPORT_FIELDS . " (reportid, entrytype, fieldname, displaydesc)
						values (" . $ReportID . ", 'dateselect', '', 'a')";
					$result = $db->Execute($sql);
					$sql = "insert into " . TABLE_REPORT_FIELDS . " (reportid, entrytype, fieldname, displaydesc)
						values (" . $ReportID . ", 'pagelist', '', '')";
					$result = $db->Execute($sql);
				} else { // copy the report and all fields to the new report name
					$OrigID = $ReportID;
					// Set the report id to 0 to prepare to copy
					$sql = "update " . TABLE_REPORTS . " set id = 0 where id = " . $ReportID;
					$result = $db->Execute($sql);
					$sql = "insert into " . TABLE_REPORTS . " select * from " . TABLE_REPORTS . " where id = 0";
					$result = $db->Execute($sql);
					// Fetch the id entered
					$ReportID = $db->insert_ID();
					// Restore original report ID from 0
					$sql = "update " . TABLE_REPORTS . " set id=".$OrigID." where id=0;";
					$result = $db->Execute($sql);
					// Set the report name and group name per the form
					$sql = "update ".TABLE_REPORTS." set description = '" . addslashes($_POST['ReportName']) . "' 
						where id = " . $ReportID;
					$result = $db->Execute($sql);
					// fetch the fields and duplicate
					$sql = "select * from " . TABLE_REPORT_FIELDS . " where reportid = " . $OrigID;
					$result = $db->Execute($sql);
					while(!$result->EOF) {
						$sql = "insert into " . TABLE_REPORT_FIELDS . " (reportid, entrytype, seqnum, fieldname, 
								displaydesc, visible, columnbreak, params)
							values (" . $ReportID . ", '" . $result->fields['entrytype'] . "', 
								" . $result->fields['seqnum'] . ", '" . $result->fields['fieldname'] . "', 
								'" . $result->fields['displaydesc'] . "', '" . $result->fields['visible']."', 
								'" . $result->fields['columnbreak'] . "', '" . $result->fields['params']."')";
						$db->Execute($sql);
						$result->MoveNext();
					}
				}
				if ($todo == 'update') {
					$FormParams = PrepStep('1');
				} else { // read back in new data for next screen
					$PageListings = RetrieveFields('pagelist');
					$myrow = $PageListings['lists'][0]['params'];
					// set some defaults if it's a new report/form
					if (!isset($myrow['margintop']))        $myrow['margintop']        = RW_DEFAULT_MARGIN;
					if (!isset($myrow['marginbottom']))     $myrow['marginbottom']     = RW_DEFAULT_MARGIN;
					if (!isset($myrow['marginleft']))       $myrow['marginleft']       = RW_DEFAULT_MARGIN;
					if (!isset($myrow['marginright']))      $myrow['marginright']      = RW_DEFAULT_MARGIN;
					if (!isset($myrow['title1desc']))       $myrow['title1desc']       = RW_DEFAULT_TITLE1;
					if (!isset($myrow['title2desc']))       $myrow['title2desc']       = RW_DEFAULT_TITLE2;
					if (!isset($myrow['papersize']))        $myrow['papersize']        = RW_DEFAULT_PAPERSIZE;
					if (!isset($myrow['paperorientation'])) $myrow['paperorientation'] = RW_DEFAULT_ORIENTATION;
					if (!isset($myrow['coynameshow']))      $myrow['coynameshow']      = '1';
					if (!isset($myrow['coynameshow']))      $myrow['coynameshow']      = '1';
					if (!isset($myrow['title1show']))       $myrow['title1show']       = '1';
					if (!isset($myrow['title2show']))       $myrow['title2show']       = '1';
					if (!isset($myrow['coynamefontsize']))  $myrow['coynamefontsize']  = '12';
					if (!isset($myrow['title1fontsize']))   $myrow['title1fontsize']   = '10';
					if (!isset($myrow['title2fontsize']))   $myrow['title2fontsize']   = '10';
					if (!isset($myrow['datafontsize']))     $myrow['datafontsize']     = '10';
					if (!isset($myrow['totalsfontsize']))   $myrow['totalsfontsize']   = '10';
					if (!isset($myrow['coynamealign']))     $myrow['coynamealign']     = 'C';
					if (!isset($myrow['title1fontalign']))  $myrow['title1fontalign']  = 'C';
					if (!isset($myrow['title2fontalign']))  $myrow['title2fontalign']  = 'C';
					$myrow['description'] = $_POST['ReportName'];
					$FormParams = PrepStep('3');
				}
				break;
	
			case 'rename': // Rename a report was selected, fetch the report name and update
				// input error check description, blank duplicate, bad characters, etc.
				if ($_POST['ReportName']=='') { // no report name was entered, error and reload form
					$messageStack->add(RW_RPT_NORPT, 'error');
					$FormParams = PrepStep('2');
					break;
				}
				// check for duplicate report name
				$sql = "select id from " . TABLE_REPORTS . " 
					where description = '" . addslashes($_POST['ReportName']) . "'";
				$result = $db->Execute($sql);
				if ($result->RecordCount() > 0) { // then we have a duplicate report name, error and reload
					$myrow = $result->fields;
					if ($myrow['id'] <> $ReportID) { // then the report has a duplicate name to something other than itself, error
						$messageStack->add(RW_RPT_REPDUP, 'error');
						$FormParams = PrepStep('2');
						break;
					}
				}
				$sql = "update " . TABLE_REPORTS . " set description='". addslashes($_POST['ReportName']) . "' 
					where id = " . $ReportID;
				$result = $db->Execute($sql);
				$messageStack->add(RW_RPT_UPDATED, 'success');
				// continue with default to return to reports home
			case 'back':
			default:	// bail to reports home
				$FormParams = PrepStep('1');
		}
		break;
	
	case "step4": // entered from page setup page
		switch ($todo) {
			case 'update':
				$success = UpdatePageFields($ReportID);
				// read back in new data for next screen (will set defaults as defined in the db)
				$PageListings = RetrieveFields('pagelist');
				$myrow = $PageListings['lists'][0]['params'];
				$myrow['description'] = $Description;
				$FormParams = PrepStep('3');
				break;
			case 'continue': // fetch the report information and go to the db setup screen
				$success = UpdatePageFields($ReportID);
				// read in the data for the next form
				$sql = "select special_report, table1, table2, table2criteria, table3, table3criteria, 
						table4, table4criteria, table5, table5criteria, table6, table6criteria, 
						description	from " . TABLE_REPORTS . " where id = " . $ReportID;
				$result = $db->Execute($sql);
				$myrow = $result->fields;
				$numrows = $result->RecordCount();
				$FormParams = PrepStep('4');
				break;
			case 'back':
			case 'cancel':
			default:	// bail to reports home
				$FormParams = PrepStep('1');
		}
		break;
	
	case "step5": // entered from dbsetup page
		switch ($todo) {
			case 'back':
				$PageListings = RetrieveFields('pagelist');
				$myrow = $PageListings['lists'][0]['params'];
				$myrow['description'] = $_POST['ReportName'];
				$FormParams = PrepStep('3');
				break;
			case 'update':
			case 'continue': // fetch the report information and go to the page setup screen
				if ($_POST['Table1']) {
					$sql = "select table1 from " . TABLE_REPORTS . " where id = " . $ReportID;
					$result = $db->Execute($sql);
					$myrow = $result->fields;
					if (($myrow['table1']) != $_POST['Table1']) {
						unset($_POST['Table2']); unset($_POST['Table2Criteria']);
						unset($_POST['Table3']); unset($_POST['Table3Criteria']);
						unset($_POST['Table4']); unset($_POST['Table4Criteria']);
						unset($_POST['Table5']); unset($_POST['Table5Criteria']);
						unset($_POST['Table6']); unset($_POST['Table6Criteria']);
					}
				}
				$success = UpdateDBFields($ReportID);
				if (!$success || $todo=='update') { // update fields and stay on this form
					if (!$success) $messageStack->add(RW_RPT_DUPDB, 'error');
					// read back in new data for next screen (will set defaults as defined in the db)
					$sql = "select special_report, table1, table2, table2criteria, table3, table3criteria, 
							table4, table4criteria, table5, table5criteria, table6, table6criteria, 
							description	from " . TABLE_REPORTS . " where id = " . $ReportID;
					$result = $db->Execute($sql);
					$myrow = $result->fields;
					$FormParams = PrepStep('4');
					break;
				}
				// read in fields and continue to next form
				$description = stripslashes($_POST['ReportName']);
				$FieldListings = RetrieveFields('fieldlist');
				$FormParams = PrepStep('5');
				break;
			default:	// bail to reports home
				$FormParams = PrepStep('1');
		}
		break;
	
	case "step6": // entered from field setup page
		$rowSeq = $_POST['rowSeq']; //fetch the sequence number
		$SeqNum = (int)$_POST['SeqNum'];
		$description = stripslashes($_POST['ReportName']);
		switch ($todo) {
			case 'up':
				if ($rowSeq <> 1) $success = ChangeSequence($rowSeq, 'fieldlist', 'up');
				$FieldListings = RetrieveFields('fieldlist');
				$FormParams = PrepStep('5');
				break;
			case 'down':
				$sql = "select seqnum from " . TABLE_REPORT_FIELDS . " 
					where reportid = " . $ReportID . " and entrytype = 'fieldlist'";
				$result = $db->Execute($sql);
				if ($rowSeq < $result->RecordCount()) $success = ChangeSequence($rowSeq, 'fieldlist', 'down');
				$FieldListings = RetrieveFields('fieldlist');
				$FormParams = PrepStep('5');
				break;
			case 'edit':
				// pre fill form with the field to edit and change button name 
				$FieldListings = RetrieveFields('fieldlist');
				$sql = "select * from " . TABLE_REPORT_FIELDS . " 
					where reportid = " . $ReportID . " and entrytype = 'fieldlist' and seqnum = " . $rowSeq;
				$result = $db->Execute($sql);
				$FieldListings['defaults'] = $result->fields;
				$Params = unserialize($FieldListings['defaults']['params']);
				$FieldListings['defaults']['buttonvalue'] = TEXT_CHANGE;
				$FormParams = PrepStep('5');
				break;
			case 'delete':
				$success = DeleteSequence($rowSeq, 'fieldlist');
				$FieldListings = RetrieveFields('fieldlist');
				$FormParams = PrepStep('5');
				break;
			case 'back':
				$sql = "select special_report, table1, table2, table2criteria, table3, table3criteria, 
					table4, table4criteria, table5, table5criteria, table6, table6criteria, description
					from " . TABLE_REPORTS . " where id = " . $ReportID;
				$result = $db->Execute($sql);
				$myrow = $result->fields;
				$FormParams = PrepStep('4');
				break;
			case 'add':
			case 'change':
				// error check input
				$IsValidField = ValidateField($ReportID, $_POST['FieldName'], $_POST['DisplayDesc']);
				if (!$IsValidField) { // then user entered a bad fieldname or description, error and reload
					$messageStack->add(RW_RPT_BADFLD, 'error');
					// reload form with bad data entered as field defaults, ready to be editted
					$FieldListings = RetrieveFields('fieldlist');
					$FieldListings['defaults']['seqnum'] = $SeqNum;
					$FieldListings['defaults']['fieldname'] = $_POST['FieldName'];
					$FieldListings['defaults']['displaydesc'] = $_POST['DisplayDesc'];
					$FieldListings['defaults']['columnbreak'] = $_POST['ColumnBreak'];
					$FieldListings['defaults']['visible'] = $_POST['Visible'];
					$Params['columnwidth'] = $_POST['ColumnWidth'];
					$Params['processing'] = $_POST['Processing'];
					$Params['align'] = $_POST['Align'];
					$Params['index'] = $_POST['Params'];
					if ($todo == 'add') { // add new so insert
						$FieldListings['defaults']['buttonvalue'] = TEXT_ADD;
					} else { // exists, so update it.
						$FieldListings['defaults']['buttonvalue'] = TEXT_CHANGE;
					}
					$FormParams = PrepStep('5');
					break;
				} 
				if ($todo == 'add') { // add new so insert
					$SeqNum = InsertSequence($SeqNum, 'fieldlist');
				} else { // exists, so update it.
					$success = UpdateSequence($SeqNum, 'fieldlist');
				}
				if ($Type <> 'frm') {
					$FieldListings = RetrieveFields('fieldlist');
					$FormParams = PrepStep('5');
					break;
				}
				$rowSeq = $SeqNum;
				// Go to the properties screen for the field just entered
			case 'properties': // Enter the properties of a given field
				// see what form needs to be loaded and load based on index stored in params variable
				$SeqNum = $rowSeq;
				$sql = "select id, displaydesc, params from " . TABLE_REPORT_FIELDS . " 
					where reportid = " . $ReportID . " and entrytype = 'fieldlist' and seqnum = " . $SeqNum;
				$result = $db->Execute($sql);
				$myrow = $result->fields;
				$Params = unserialize($myrow['params']);
				if ($Params['index'] == 'Tbl') $TblFieldChoices = CreateSpecialDropDown($ReportID, 'table');
				$ButtonValue = TEXT_ADD; // default the field button to Add New for form entry
				$FormParams = PrepStep('prop', $Params['index']);
				$FormParams['id'] = $myrow['id'];
				$DisplayName = $myrow['displaydesc'];
				break;
			case 'update':
				$FieldListings = RetrieveFields('fieldlist');
				$FormParams = PrepStep('5');
				break;
			case 'continue': // fetch the report information and go to the page setup screen
				$SortListings  = RetrieveFields('sortlist');
				$GroupListings = RetrieveFields('grouplist');
				$CritListings  = RetrieveFields('critlist');
				$FormParams    = PrepStep('6');
				break;
			default: // bail to reports home
				$FormParams = PrepStep('1');
				break;
		}
		break;
	
	case "step6a": // entered from properties page for form fields
		$ButtonValue = TEXT_ADD; // default the field button to Add New unless overidden by the edit image pressed
		$description = stripslashes($_POST['ReportName']);
		$DisplayName = $_POST['DisplayName'];
		$rowSeq      = $_POST['rowSeq'];
		$SeqNum      = (int)$_POST['SeqNum'];
		// first fetch the original Params
		$sql = "select id, params from " . TABLE_REPORT_FIELDS . " 
			where reportid = " . $ReportID . " and entrytype = 'fieldlist' and seqnum = " . $SeqNum;
		$result = $db->Execute($sql);
		$myrow  = $result->fields;
		$Params = unserialize($myrow['params']);
		// fetch the choices with the form post data
		foreach ($_POST as $key => $value) $Params[$key] = $value;
		// check for what button or image was pressed
		switch ($todo) {
			case 'up':
			case 'down':
			case 'edit':
			case 'delete':
				$success = ModFormTblEntry($Params, $todo, $rowSeq);
				if (!$success) { // check for errors
					$messageStack->add(RW_RPT_BADDATA, 'error');
				} else { // update the database
					$sql = "update " . TABLE_REPORT_FIELDS . " set params = '" . serialize($Params) . "' 
						where id = " . $_POST['ID'];
					$result = $db->Execute($sql);
					if ($success === 'edit') { // then the edit button was pressed, change button name from Add New to Change
						$ButtonValue = TEXT_CHANGE;
					} else { // clear the entry text fields
						$Params['TblSeqNum']  = '';
						$Params['TblField']   = '';
						$Params['Processing'] = '';
					}
				}
				// Update field properties 
				if ($Params['index'] == 'Tbl') $TblFieldChoices = CreateSpecialDropDown($ReportID, 'table');
				$FormParams = PrepStep('prop', $Params['index']);
				$FormParams['id'] = $myrow['id'];
				break;
			case 'cancel':
				$FieldListings = RetrieveFields('fieldlist');
				$FormParams = PrepStep('5');
				break;
			case 'add_total': // For the total parameters gather the list of fieldnames
			case 'remove':
				// Process the button pushed
				if ($todo == 'remove') { // the remove button was pressed
					$Index = $_POST['FieldIndex'];
					if ($Index <> '') $Params['Seq'] = array_merge(array_slice($Params['Seq'], 0, $Index), array_slice($Params['Seq'], $Index + 1));
				} else { // it's the add button, error check
					if ($_POST['TotalField'] == '') { 
						$messageStack->add(RW_RPT_BADFLD, 'error');
						// reload form with bad data entered as field defaults, ready to be editted
						$FormParams = PrepStep('prop', $Params['index']);
						$FormParams['id'] = $myrow['id']; 
						break;
					} 
					$Params['Seq'][] = $_POST['TotalField'];
				}
				// Update field properties 
				$sql = "update " . TABLE_REPORT_FIELDS . " set params = '" . serialize($Params) . "' 
					where id = " . $_POST['ID'];
				$result = $db->Execute($sql);
				$Params['TotalField'] = '';
				if ($Params['index'] == 'Tbl') $TblFieldChoices = CreateSpecialDropDown($ReportID, 'table');
				$FormParams = PrepStep('prop', $Params['index']);
				$FormParams['id'] = $myrow['id']; 
				break;
			case 'change':
			case 'add':
				// Error Check input, see if user entered a bad fieldname or description, error and reload
				if ($_POST['TblField'] == '' || ($Params['index'] == 'Tbl' && $_POST['TblDesc'] == '')) { 
					$messageStack->add(RW_RPT_BADFLD, 'error');
					// reload form with bad data entered as field defaults, ready to be editted
					if ($todo == 'add') $ButtonValue = TEXT_ADD;
						else $ButtonValue = TEXT_CHANGE;
					if ($Params['index'] == 'Tbl') $TblFieldChoices = CreateSpecialDropDown($ReportID, 'table');
					$FormParams = PrepStep('prop', $Params['index']);
					$FormParams['id'] = $myrow['id']; 
					break;
				} 
				if ($todo == 'add') {
					$success = InsertFormSeq($Params, 'insert');
				} else { 
					$success = InsertFormSeq($Params, 'update');
				}
			// continue on
			case 'spFunc':
			case 'update':
			case 'finish': // Enter the properties of a given field and return to the field setup screen
				// additional processing for the image upload in the form image type
				if ($Params['index'] == 'Img') {
					$success = ImportImage();
					if ($success['result'] == 'error') { // image upload failed
						$messageStack->add($success['message'], 'error');
						$FormParams = PrepStep('prop', $Params['index']);
						$FormParams['id'] = $myrow['id'];
						break;
					} else {
						$Params['filename'] = $success['filename'];
					}
				}
				// reset the sequence defaults to null for Table type only
				if ($Params['index'] == 'Tbl' || $Params['index'] == 'TBlk' || $Params['index'] == 'CBlk') {
					$Params['TblSeqNum']  = '';
					$Params['TblField']   = '';
					$Params['TblDesc']    = '';
					$Params['Processing'] = '';
				}
				if ($Params['index'] == 'Tbl') $TblFieldChoices = CreateSpecialDropDown($ReportID, 'table');
				if ($todo == 'spFunc') { // for tables a special function change was made
					// clear the table columns
					$Params['Seq'] = '';
				}
				// Update field properties 
				$sql = "update " . TABLE_REPORT_FIELDS . " set params = '" . serialize($Params) . "' 
					where id = " . $_POST['ID'];
				$result = $db->Execute($sql);
				// check for update errors and reload
				if ($todo == 'finish') { // no errors and finished so return to field setup
					$FieldListings = RetrieveFields('fieldlist');
					$FormParams = PrepStep('5');
				} else { // print error message if need be and reload parameter form
					$FormParams = PrepStep('prop', $Params['index']);
					$FormParams['id'] = $myrow['id']; 
				}
				break;
			default: // bail to reports home
				$FormParams = PrepStep('1');
				break;
		}
		break;
	
	case "step7": // entered from criteria setup page
		$OverrideDefaults = false;
		$description      = stripslashes($_POST['ReportName']);
		$rowSeq           = $_POST['rowSeq'];
		$SeqNum           = (int)$_POST['SeqNum'];
		$EntryType        = $_POST['EntryType'];
		switch ($todo) {
			case 'up':
				if ($rowSeq <> 1) $success = ChangeSequence($rowSeq, $EntryType, 'up');
				$FormParams = PrepStep('6');
				break;
			case 'down':
				$sql = "select seqnum from " . TABLE_REPORT_FIELDS . " 
					where reportid = " . $ReportID . " and entrytype = '" . $EntryType . "'";
				$result = $db->Execute($sql);
				if ($rowSeq < $result->Recordcount()) $success = ChangeSequence($rowSeq, $EntryType, 'down');
				$FormParams = PrepStep('6');
				break;
			case 'edit':
				$OverrideDefaults = true;
				// pre fill form with the field to edit and change button name 
				$sql = "select * from " . TABLE_REPORT_FIELDS . " 
					where reportid = " . $ReportID." and entrytype = '" . $EntryType . "' and seqnum = " . $rowSeq;
				$result = $db->Execute($sql);
				$NewDefaults['defaults'] = $result->fields;
				$NewDefaults['defaults']['params'] = unserialize($result->fields['params']);
//				$NewDefaults['defaults']['params']      = $temp_params[0];
//				$NewDefaults['defaults']['minvalue']    = $temp_params[2];
//				$NewDefaults['defaults']['maxvalue']    = $temp_params[3];
				$NewDefaults['defaults']['buttonvalue'] = TEXT_CHANGE;
				$FormParams = PrepStep('6');
				break;
			case 'delete':
				$success = DeleteSequence($rowSeq, $EntryType);
				$FormParams = PrepStep('6');
				break;
			case 'back':
				$FormParams = PrepStep('5');
				break;
			case 'add':
			case 'change':
				// error check input
				$IsValidField = ValidateField($ReportID, $_POST['FieldName'], $_POST['DisplayDesc']);
				if (!$IsValidField) { // then user entered a bad fieldname or description, error and reload
					$messageStack->add(RW_RPT_BADFLD, 'error');
					// reload form with bad data entered as field defaults, ready to be editted
					$OverrideDefaults = true;
					switch($EntryType) {
					  case 'grouplist':
						$NewDefaults['defaults']['seqnum']      = $_POST['gSeqNum'];
						$NewDefaults['defaults']['fieldname']   = $_POST['gFieldName'];
						$NewDefaults['defaults']['displaydesc'] = $_POST['gDisplayDesc'];
						$NewDefaults['defaults']['params']      = array(
						  'default'    => $_POST['gParamsDef'] ? '1' : '0',
						  'page_break' => $_POST['gParamsBrk'] ? '1' : '0',
						  'processing' => $_POST['gProcessing'],
						);
						break;
					  case 'sortlist':
						$NewDefaults['defaults']['seqnum']      = $_POST['sSeqNum'];
						$NewDefaults['defaults']['fieldname']   = $_POST['sFieldName'];
						$NewDefaults['defaults']['displaydesc'] = $_POST['sDisplayDesc'];
						$NewDefaults['defaults']['params']      = array(
						  'default'    => $_POST['sParamsDef'] ? '1' : '0',
						);
						break;
					  case 'critlist':
						$NewDefaults['defaults']['seqnum']      = $_POST['cSeqNum'];
						$NewDefaults['defaults']['fieldname']   = $_POST['cFieldName'];
						$NewDefaults['defaults']['displaydesc'] = $_POST['cDisplayDesc'];
						$NewDefaults['defaults']['params']      = array(
						  'value'      => $_POST['cParamsVal'],
						  'min_val'    => $_POST['MinValue'],
						  'max_val'    => $_POST['MaxValue'],
						);
						break;
					}
					$NewDefaults['defaults']['buttonvalue'] = ($todo == 'add') ? TEXT_ADD : TEXT_CHANGE;
				} else { // fetch the input results and save them
					if ($todo == 'add') { // add new so insert
						$success = InsertSequence($SeqNum, $EntryType);
					} else { // record exists, so update it.
						$success = UpdateSequence($SeqNum, $EntryType);
					}
				}
				$FormParams = PrepStep('6');
				break;
			case 'update': // update the date and general options fields, reload form
			case 'continue': // update fields and return to report manager screen
			default:	// bail to reports home
				// build date string of choices from user
				$DateString = '';
				if (isset($_POST['periods_only'])) { // special case for using accounting periods only
					$DateString .= $_POST['periods_only'];
				} else {
					for ($i = 1; $i <= count($DateChoices); $i++) { 
						if (isset($_POST['DateRange' . $i])) $DateString .= $_POST['DateRange' . $i];
					}
				}
				// error check input for date
				if ($DateString == '' || $DateString == 'a' || $DateString == 'z') { // then the report is date independent
					$_POST['DateField'] = ''; // clear the date field since we don't need it
					$IsValidField = true; // 
				} else { // check the input for a valid fieldname
					$IsValidField = ValidateField($ReportID, $_POST['DateField'], 'TestField');
				}
				if ($Type == 'frm' && $IsValidField) {
					$IsValidField = ValidateField($ReportID, $_POST['FormBreakField'], 'TestField');
				}
				if (!$IsValidField) { // then user entered a bad fieldname or description, error and reload
					$messageStack->add(RW_RPT_BADFLD, 'error');
					// reload form with bad data entered as field defaults, ready to be editted
					$FormParams['Prefs']['dateselect']     = $DateString;
					$FormParams['Prefs']['datedefault']    = $_POST['DefDate'];
					$FormParams['Prefs']['datefield']      = $_POST['DateField'];
					$FormParams['Prefs']['setprintedflag'] = $_POST['SetPrintedFlag'];
					$FormParams['Prefs']['formbreakfield'] = $_POST['FormBreakField'];
					$DateError  = true;
					$FormParams = PrepStep('6');
					break;
				} else { // fetch the input results and save them
					$DateError = false;
					$success = UpdateCritFields($ReportID, $DateString);
				}
				// read in fields for next form
				if ($todo == 'continue') {
					$temp = RetrieveFields('security');
					if (!$temp['lists']) $temp['lists'][0]['params'] = 'u:0;e:0;d:0'; // default to all users, employees, and departments
					$temp = array_pop($temp['lists']);
					$Security = explode(';', $temp['params']);
					$presets = array();
					foreach ($Security as $value) {
						$presets[substr($value,0,1)] = explode(':', substr($value,2));
					}
					$FormParams = PrepStep('sec');
				} else { // update was pressed, return to criteria form
					$FormParams = PrepStep('6');
				}
				break;
		}
		// reload fields to display form
		$FieldListings = RetrieveFields('fieldlist'); // needed for GO Back (fields) screen
		$SortListings  = RetrieveFields('sortlist');
		$GroupListings = RetrieveFields('grouplist');
		$CritListings  = RetrieveFields('critlist');
		// override defaults used for edit of existing fields.
		if ($OverrideDefaults) {
			switch ($EntryType) {
				case "sortlist":
					$SortListings['defaults'] = $NewDefaults['defaults'];
					$SortListings['defaults']['buttonvalue'] = $NewDefaults['defaults']['buttonvalue'];
					break;
				case "grouplist":
					$GroupListings['defaults'] = $NewDefaults['defaults'];
					$GroupListings['defaults']['buttonvalue'] = $NewDefaults['defaults']['buttonvalue'];
					break;
				case "critlist":
					$CritListings['defaults'] = $NewDefaults['defaults'];
					$CritListings['defaults']['buttonvalue'] = $NewDefaults['defaults']['buttonvalue'];
					break;
			}
		}
		break; // End step 7
	
	case "step8": // Entered from import report form
		switch ($todo) {
			case 'continue': // Error check input and import the new report
				$success = ImportReport(trim($_POST['reportname']));
				$messageStack->add($success['message'], $success['result']);
				if ($success['result'] == 'error') {
					$FormParams = PrepStep('imp');
					break;
				}
				// All through and imported successfully, return to reports home page
			case 'back':
			default:
				$FormParams = PrepStep('1');
		}
		break; // End step 8

	case "step9": // Entered from criteria setup form (security settings)
		$description = stripslashes($_POST['ReportName']);
		switch ($todo) {
			case 'back':
				// reload fields to display form
				$FieldListings = RetrieveFields('fieldlist'); // needed for GO Back (fields) screen
				// Below needed to reload criteria form
				$SortListings  = RetrieveFields('sortlist');
				$GroupListings = RetrieveFields('grouplist');
				$CritListings  = RetrieveFields('critlist');
				$FormParams    = PrepStep('6');
				break;
			case 'update': // update the security settings and return to security screen
			case 'finish': // update fields and close window, finished
			default:	// bail to reports home
				$UserAll        = isset($_POST['UserAll'])       ? true : false;
				$EmployeeAll    = isset($_POST['EmployeeAll'])   ? true : false;
				$DepartmentAll  = isset($_POST['DepartmentAll']) ? true : false;
				$UserList       = $_POST['UserList']       ? implode(':', $_POST['UserList'])       : '-1';
				$EmployeeList   = $_POST['EmployeeList']   ? implode(':', $_POST['EmployeeList'])   : '-1';
				$DepartmentList = $_POST['DepartmentList'] ? implode(':', $_POST['DepartmentList']) : '-1';
				$params =  'u:' . ($UserAll       ? '0' : $UserList)     . ';';
				$params .= 'e:' . ($EmployeeAll   ? '0' : $EmployeeList) . ';';
				$params .= 'd:' . ($DepartmentAll ? '0' : $DepartmentList);
				$sql = "update " .TABLE_REPORT_FIELDS . " set params = '" . $params . "'
					where reportid = " . $ReportID . " and entrytype = 'security'";
				$result = $db->Execute($sql);
				if ($result->AffectedRows() == 0) { // create the field, first see if it is there
					$result = $db->Execute("select id from " . TABLE_REPORT_FIELDS . " where reportid = " . $ReportID . " and entrytype = 'security'");
					if ($result->RecordCount() == 0) {
						$sql = "insert into " . TABLE_REPORT_FIELDS . " set 
							reportid = " . $ReportID . ",
							entrytype = 'security',
							params = '" . $params . "'";
						$result = $db->Execute($sql);
					}
				}
				// read in fields for next form
				if ($todo == 'finish') { // then finish was pressed
					$FormParams = PrepStep('1');
				} else { // update was pressed, return to criteria form
					$temp = RetrieveFields('security');
					$temp = array_pop($temp['lists']);
					$Security = explode(';',$temp['params']);
					$presets = array();
					foreach ($Security as $value) {
						$presets[substr($value,0,1)] = explode(':', substr($value,2));
					}
					$FormParams = PrepStep('sec');
				}
		}
		break; // end step 9

	default: die('Bad action number: ' . $action);
} // end switch

/*****************   prepare to display templates  *************************/

$include_header   = false;
$include_footer   = false;
$include_tabs     = false;
$include_calendar = false;
$include_template = $FormParams['IncludePage'];
define('PAGE_TITLE', $FormParams['title']);

?>