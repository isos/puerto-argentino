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
//  Path: /modules/reportwriter/pages/popup_form/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = (int)$_SESSION['admin_id']; // for popups, just make sure they are logged in
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files  *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');

/***************   hook for custom operations  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/reportwriter/extra_operations.php';
if (file_exists($custom_path)) { include($custom_path); }

/**************   page specific initialization  *************************/
if (!isset($_GET['gn'])) { // error this script needs a groupname id to work
	die('Error! - This script needs a form group name to operate');
} else {
	$groupname = $_GET['gn'];
}
// check for a journal main id to retrieve email information
$mID = isset($_GET['mID']) ? $_GET['mID'] : $_POST['mID'];

// fetch the list of criteria to pass on
$crit_string = '';
for ($i = 0; $i < 10; $i++) {
  if (isset($_GET['cr' . $i])) {
    $crit_string .= '&amp;cr' . $i . '=' . $_GET['cr' . $i];
  } else {
    break;
  }
}

$delivery_method = ($_POST['delivery_method']) ? $_POST['delivery_method'] : 'I';

/*****************   prepare to display templates  *************************/
$include_header   = false;
$include_footer   = false;
$include_tabs     = false;
$include_calendar = false;

// fetch the email information
if ($mID) {
  $result = $db->Execute("select display_name, admin_email from " . TABLE_USERS . " where admin_id = " . $_SESSION['admin_id']);
  $sender_name  = $result->fields['display_name'];
  $sender_email = $result->fields['admin_email'];

  $result       = $db->Execute("select bill_primary_name, bill_acct_id from " . TABLE_JOURNAL_MAIN . " where id = " . $mID);
  $recpt_name   = $result->fields['bill_primary_name'];

  $result = $db->Execute("select email from " . TABLE_ADDRESS_BOOK . " 
  	where ref_id = '" . $result->fields['bill_acct_id'] . "' and type like '%m'"); 
  $recpt_email = $result->fields['email'];

  $message_subject = TEXT_FROM . ' ' . COMPANY_NAME;

  $report_title = $FormGroups[$groupname];
  $message_body = sprintf(RW_EMAIL_BODY, $report_title, COMPANY_NAME);
  $enable_email = true;
} else {
  $enable_email = false;
}

// fetch the available forms
$sql = "select id, description from " . TABLE_REPORTS . " where groupname = '" . $groupname . "' order by description";
$formnames = $db->Execute($sql);

$include_template = 'template_main.php'; // include display template (required)
define('PAGE_TITLE', TITLE . ' - ' . COMPANY_NAME);

?>