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
//  Path: /modules/general/pages/pw_lost/pre_process.php
//

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'functions/general.php');

/**************   page specific initialization  *************************/
if (isset($_POST['login'])) {
	gen_redirect(html_href_link(FILENAME_DEFAULT, 'cat=general&amp;module=login', 'SSL'));
}

$error_check = false;

if (isset($_POST['submit'])) {

  if ( !$_POST['admin_email'] ) {
    $error_check = true;
    $email_message = ERROR_WRONG_EMAIL_NULL;
  }

  $_SESSION['company'] = $_SESSION['companies'][$_POST['company']];
  $admin_email = db_prepare_input($_POST['admin_email']);
  $sql = "select admin_id, admin_name, admin_email, admin_pass 
  	from " . TABLE_USERS . " where admin_email = '" . db_input($admin_email) . "'";
  $result = $db->Execute($sql);

  if (!($admin_email == $result->fields['admin_email'])) {
    $error_check = true;
    $email_message = ERROR_WRONG_EMAIL;
  }

  if (!$error_check) {
    $new_password = pw_create_random_value(ENTRY_PASSWORD_MIN_LENGTH);
    $admin_pass = pw_encrypt_password($new_password);
    $sql = "update " . TABLE_USERS . " set admin_pass = '" . db_input($admin_pass) . "' 
		where admin_email = '" . $result->fields['admin_email'] . "'";
    $db->Execute($sql);
    $html_msg['EMAIL_CUSTOMERS_NAME'] = $result->fields['admin_name'];
    $html_msg['EMAIL_MESSAGE_HTML'] = sprintf(TEXT_EMAIL_MESSAGE, $new_password);
    validate_send_mail($result->fields['admin_name'], $result->fields['admin_email'], TEXT_EMAIL_SUBJECT, sprintf(TEXT_EMAIL_MESSAGE, $new_password), COMPANY_NAME, EMAIL_FROM, $html_msg);
    $email_message = SUCCESS_PASSWORD_SENT;
	gen_add_audit_log(GEN_LOG_RESEND_PW . $admin_email);
  }
}

/*****************   prepare to display templates  *************************/
$include_header   = false;
$include_footer   = false;
$include_tabs     = false;
$include_calendar = false;
$include_template = 'template_main.php';
define('PAGE_TITLE', TITLE);
?>