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
//  Path: /modules/reportwriter/pages/form_gen/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_REPORTS];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'accounts/language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING . 'functions/generator_functions.php');
require(DIR_FS_WORKING . 'classes/form_generator.php');

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/reportwriter/extra_operations.php';
if (file_exists($custom_path)) { include($custom_path); }

/**************   page specific initialization  *************************/
$todo            = (isset($_POST['todo']))     ? $_POST['todo']     : $_GET['todo'];
$ReportID        = (isset($_POST['ReportID'])) ? $_POST['ReportID'] : $_GET['ReportID'];

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

if (!$ReportID) { // then no report was selected, error
	$messageStack->add(RW_FRM_NORPT, 'error');
} else {
	$Prefs = FetchReportDetails($ReportID);  //fetch the defaults 
	switch ($todo) {
		case 'open':
		case 'criteria':
			// Update with passed parameters. if so, bypass filter form a make report
			// NOTE: The max number of parameters to test is currrently set at 10.
			$i = 0;
			while (isset($_GET['cr' . $i])) { // then a criteria was passed update the parameter info
				$Prefs['PassedCrit'][] = $_GET['cr' . $i];
				$i++;
			}
			if (!isset($Prefs['PassedCrit'])) {
				$title = RW_TITLE_CRITERIA;
				$IncludePage = 'template_filter.php';
				break;
			} // else fall through to generate pdf with passed filter parameters
	
		case 'exp_pdf':
			// read from the filter form, fetch user selections for date information
			if (isset($_POST['DefDate'])) { // then we entered from criteria form, get user overrides
				if ($_POST['DefDate'] == 'b') { // then it's a range selection, save to-from dates, else discard
					$Prefs['datedefault'] = $_POST['DefDate'] . ':' . $_POST['DefDateFrom'] . ':' . $_POST['DefDateTo'];
				} else {
					$Prefs['datedefault'] = $_POST['DefDate'];
				}
			}
			// read the sort settings
			if (isset($_POST['defsort'])) { // First clear all defaults and reset the user's choice
				for ($i = 0; $i < count($Prefs['SortListings']); $i++) $Prefs['SortListings'][$i]['params']['default'] = 0;
				if ($_POST['defsort'] <> 0) $Prefs['SortListings'][$_POST['defsort'] - 1]['params']['default'] = '1';
			}
			// Read in the criteria field selection, if any
			$i = 1;
			while (isset($_POST['defcritsel' . $i])) { // then there is at least one criteria
				// Build the criteria default string
				$Prefs['CritListings'][$i-1]['params']['default'] = $_POST['defcritsel' . $i];
				$Prefs['CritListings'][$i-1]['params']['min_val'] = $_POST['fromvalue'  . $i];
				$Prefs['CritListings'][$i-1]['params']['max_val'] = $_POST['tovalue'    . $i];
				$i++;
			}
			// build the pdf pages (this function exits the script if successful; otherwise returns with error)
			if ($Prefs['serialform']) { // build sequential form (receipt)
			  $output = BuildSeq($ReportID, $Prefs, $delivery_method); // build and output form, should not return from this function
			} else { // build PDF
			  $output = BuildPDF($ReportID, $Prefs, $delivery_method); // build and output form, should not return from this function
			}
			// if we are here, there's been an error or delivery method was email
			if ($output['pdf'] && $delivery_method == 'S') {
				// open a temp file
				$temp_file = DIR_FS_MY_FILES . $_SESSION['company'] . '/' . $output['filename'];
				$handle = fopen($temp_file, 'w');
				// put the string into the file
				fwrite($handle, $output['pdf']);
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
			$Prefs = FetchReportDetails($ReportID);  //fetch the defaults 
			// Update with passed parameters if so
			// NOTE: The max number of parameters to test is currrently set at the date and 10 form specific.
			$title = RW_TITLE_CRITERIA;
			$IncludePage = 'template_filter.php';
			break;

		case 'cancel':
		default:
	} // end switch
}

/*****************   prepare to display templates  *************************/
$include_header   = false;
$include_footer   = false;
$include_tabs     = false;
$include_calendar = true;
$include_template = $IncludePage;
define('PAGE_TITLE', TITLE . ' - ' . RW_HEADING_TITLE);

?>