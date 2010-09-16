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
//  Path: /modules/reportwriter/pages/rpt_gen/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_REPORTS];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING . 'functions/generator_functions.php');
require(DIR_FS_WORKING . 'classes/report_generator.php');

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/reportwriter/extra_operations.php';
if (file_exists($custom_path)) { include($custom_path); }

/**************   page specific initialization  *************************/
$todo     = (isset($_POST['todo']))     ? $_POST['todo']     : $_GET['todo'];
$ReportID = (isset($_POST['ReportID'])) ? $_POST['ReportID'] : $_GET['ReportID'];

$result = $db->Execute("select description from " . TABLE_REPORTS . " where id = " . $ReportID);
$report_title    = $result->fields['description'];

$result = $db->Execute("select params from " . TABLE_REPORT_FIELDS . " where entrytype = 'pagelist' and reportid = " . $ReportID);
$Prefs           = unserialize($result->fields['params']);

$result = $db->Execute("select display_name, admin_email from " . TABLE_USERS . " where admin_id = " . $_SESSION['admin_id']);
$sender_name     = $result->fields['display_name'];
$sender_email    = $result->fields['admin_email'];
$recpt_name      = '';
$recpt_email     = '';
$message_subject = $report_title . ' ' . TEXT_FROM . ' ' . COMPANY_NAME;
$message_body    = ($Prefs['email_msg']) ? TextReplace($Prefs['email_msg']) : sprintf(RW_EMAIL_BODY, $report_title, COMPANY_NAME);

$delivery_method = ($_POST['delivery_method'])   ? $_POST['delivery_method'] : 'I';
if ($delivery_method == 'S') {
	$from_name     = ($_POST['sender_name'])     ? $_POST['sender_name']     : $sender_name;
	$from_address  = ($_POST['sender_email'])    ? $_POST['sender_email']    : $sender_email;
	$to_name       = ($_POST['recpt_name'])      ? $_POST['recpt_name']      : $recpt_name;
	$to_address    = ($_POST['recpt_email'])     ? $_POST['recpt_email']     : $recpt_email;
	$cc_name       = ($_POST['cc_name'])         ? $_POST['cc_name']         : $_POST['cc_email'];
	$cc_address    = ($_POST['cc_email'])        ? $_POST['cc_email']        : '';
	$email_subject = ($_POST['message_subject']) ? $_POST['message_subject'] : $message_subject;
	$email_text    = ($_POST['message_body'])    ? $_POST['message_body']    : $message_body;
}

// the form entered from somewhere other than itself or contained a bad ID, show start form
if (isset($todo) && (!isset($ReportID))) { // Error - button without report selected
	$messageStack->add(RW_RPT_NORPT, 'error');
} else { // a submit button was pressed, find out which one
	$IncludePage = 'template_filter.php'; // default unless overwritten
	$Prefs = FetchReportDetails($ReportID);  //fetch the defaults
	switch ($todo) {
		case 'delete': // enter here only from My Report selection, never from default report
			$sql = "delete from " . TABLE_REPORTS . " where id = " . $ReportID;
			$result = $db->Execute($sql);
			$sql= "delete from " . TABLE_REPORT_FIELDS . " where reportid = " . $ReportID;
			$result = $db->Execute($sql);
			// Recreate drop down list and return to report home (handled in Cancel below)
		case 'save':
		case 'rename':
			$AllowOverwrite = ($todo == 'Replace') ? true : false;
			$success = SaveNewReport($ReportID, $AllowOverwrite);
			if ($success['result'] == 'success') { // Reload criteria page
				$ReportID = $success['ReportID'];
				$Prefs = FetchReportDetails($ReportID);  //fetch the defaults
			} else { // an error message was sent so reload save form
				$ShowReplace = ($success['default'] == false) ? true : false;
				$Prefs['description'] = $_POST['ReportName'];
				$IncludePage = 'template_save.php';
			}
			$messageStack->add($success['message'], $success['result']);	
			break;
		case 'save_as': 
			$Prefs = ReadPostData($ReportID, $Prefs, $_POST); // fetch the current saved values
			if ($Prefs['standard_report']) $Prefs['description'] = ''; // clear name if default report
			$ShowReplace = false;
			$IncludePage = 'template_save.php';
			break;
		case 'update':
			// Overrride stored settings with selected values
			$Prefs = ReadPostData($ReportID, $Prefs, $_POST, 'save'); // reads and updates the database
			break;
		case 'exp_csv': 
		case 'exp_pdf':
		case 'exp_html':
			$Prefs = ReadPostData($ReportID, $Prefs, $_POST);
			$ReportData = '';
			$success = BuildSQL($Prefs);
			$failed = false;
			if ($success['level'] == 'success') { // Generate the output data array
				$sql = $success['data'];
				$Prefs['filterdesc'] = $success['filterdesc']; // fetch the filter message
				$ReportData = BuildDataArray($ReportID, $sql, $Prefs);
				// Check for the report returning with data
				if (!$ReportData) {
					$messageStack->add(RW_RPT_NODATA . ' The failing sql= ' . $sql, 'caution');
					$failed = true;
				} 
			} else { // Houston, we have a problem, sql build failed
					$messageStack->add($success['message'], $success['level']);
					$failed = true;
			}
			if (!$failed) { // send the report
				if ($todo == 'exp_csv')  GenerateCSVFile($ReportData, $Prefs); // No return from this function
				if ($todo == 'exp_html') GenerateHTMLFile($ReportData, $Prefs); // No return from this function
				if ($todo == 'exp_pdf')  $output = GeneratePDFFile($ReportData, $Prefs, $delivery_method);
				// if we are here, delivery method was email
				if ($output) {
					// open a temp file
					$temp_file = DIR_FS_MY_FILES . $_SESSION['company'] . '/temp/' . microtime() . '.pdf';
					$handle = fopen($temp_file, 'w');
					// put the string into the file
					fwrite($handle, $output);
					fclose($handle);
					// generate the email
					$block = array();
					if ($cc_address) {
						$block['EMAIL_CC_NAME']    = $cc_name;
						$block['EMAIL_CC_ADDRESS'] = $cc_address;
					}
					$attachments_list['file'] = $temp_file;
					$success = validate_send_mail($to_name, $to_address, $email_subject, $email_text, $from_name, $from_address, $block, $attachments_list);
					if ($success) $messageStack->add(EMAIL_SEND_SUCCESS, 'success');
					// remove the temp file
					unlink($temp_file);
				}
			}
			break;
		default:
	}
}

/*****************   prepare to display templates  *************************/
$tab_list = array(
  'crit'  => TEXT_CRITERIA,
  'field' => TEXT_FIELDS,
  'page'  => TEXT_PAGE_SETUP
);

$kFonts      = gen_build_pull_down($Fonts);
$kFontSizes  = gen_build_pull_down($FontSizes);
$kFontColors = gen_build_pull_down($FontColors);
$kFontAlign  = gen_build_pull_down($FontAlign);

$include_header   = false;
$include_footer   = false;
$include_tabs     = true;
$include_calendar = true;
$include_template = $IncludePage;
define('PAGE_TITLE', RW_TITLE_REPORT_GEN);

?>