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
//  Path: /modules/general/pages/login/pre_process.php
//

// include module extra functions
  require(DIR_FS_MODULES . 'general/functions/general.php');
  $error = false;
  $pass_message = NULL;

// process posted information
  if (isset($_POST['submit'])) {
    $admin_name     = db_prepare_input($_POST['admin_name']);
    $admin_pass     = db_prepare_input($_POST['admin_pass']);
    $admin_company  = $_SESSION['companies'][$_POST['company']];
    $admin_language = db_prepare_input($_POST['language']);
    $admin_theme    = db_prepare_input($_POST['theme']);
    $sql = "select admin_id, admin_name, inactive, admin_pass, account_id, admin_prefs, admin_security 
		from " . TABLE_USERS . " where admin_name = '" . db_input($admin_name) . "'";
    $result = $db->Execute($sql);
    if (!($admin_name == $result->fields['admin_name']) || $result->fields['inactive']) {
      $error = true;
      $pass_message = ERROR_WRONG_LOGIN;
    }
    if (!pw_validate_password($admin_pass, $result->fields['admin_pass'])) {
      $error = true;
      $pass_message = ERROR_WRONG_LOGIN;
    }
    if (!$error) {
      $_SESSION['admin_id']       = $result->fields['admin_id'];
	  $_SESSION['admin_prefs']    = unserialize($result->fields['admin_prefs']);
	  $_SESSION['company']        = $admin_company;
      $_SESSION['language']       = $admin_language;
      $_SESSION['theme']          = $admin_theme;
	  $_SESSION['account_id']     = $result->fields['account_id'];
	  $dept = $db->Execute("select dept_rep_id from " . TABLE_CONTACTS . " where id = " . $result->fields['account_id']);
	  $_SESSION['department']     = $dept->fields['dept_rep_id'];
      $_SESSION['admin_security'] = gen_parse_permissions($result->fields['admin_security']);
	  // set some cookies for the next visit to remember the company, language, and theme
	  $cookie_exp = 2592000 + time(); // one month
	  setcookie('pb_company' , $admin_company,  $cookie_exp);
	  setcookie('pb_language', $admin_language, $cookie_exp);
	  setcookie('pb_theme',    $admin_theme,    $cookie_exp);
	  // check for software updates
	  if (CFG_AUTO_UPDATE_CHECK) {
	    if (web_connected($silent = false)) {
	  	  $line           = @file(NEW_VERSION_CHECKUP_URL);
		  $latest_version = trim($line[0]);
		  // Determine the Program patch level
		  include(DIR_FS_ADMIN . 'includes/version.php');
		  $installed_version = PROJECT_VERSION_MAJOR . '.' . PROJECT_VERSION_MINOR;
		  if ($latest_version > $installed_version) {
		    $messageStack->add_session(sprintf(TEXT_VERSION_CHECK_NEW_VER, $installed_version, $latest_version), 'success'); 
		  }
		}
	  }
	  // load the latest currency exchange rates
	  if (AUTO_UPDATE_CURRENCY && ENABLE_MULTI_CURRENCY) {
	    if (web_connected($silent = false)) {
	      require (DIR_FS_MODULES . 'setup/classes/currency.php');
		  require (DIR_FS_MODULES . 'setup/language/' . $_SESSION['language'] . '/modules/currency.php');
		  $exchange_rates = new currency();
		  $exchange_rates->btn_update();
		}
	  }
	  if (AUTO_UPDATE_PERIOD) gen_auto_update_period();
	  gen_add_audit_log(GEN_LOG_LOGIN . $admin_name);
	  // check for session timeout to reload to requested page
	  $get_params = '';
	  if (isset($_SESSION['pb_cat'])) {
	    $get_params  = 'cat='    . $_SESSION['pb_cat'];
	    $get_params .= '&amp;module=' . $_SESSION['pb_module'];
	    if (isset($_SESSION['pb_jID']))  $get_params .= '&amp;jID='  . $_SESSION['pb_jID'];
	    if (isset($_SESSION['pb_type'])) $get_params .= '&amp;type=' . $_SESSION['pb_type'];
	  }
      gen_redirect(html_href_link(FILENAME_DEFAULT, $get_params, 'SSL'));
    } else {
	  // Note: This is assigned to admin id = 1 since the user is not logged in.
	  gen_add_audit_log(GEN_LOG_LOGIN_FAILED . $admin_name);
	}
  }

// prepare to display form
if(isset($_COOKIE['pb_company'])) {
  $admin_company  = $_COOKIE['pb_company'];
  $admin_language = $_COOKIE['pb_language'];
  $admin_theme    = $_COOKIE['pb_theme'];
} else{
  $admin_theme    = 'default';
}

define('PAGE_TITLE', TITLE);

?>