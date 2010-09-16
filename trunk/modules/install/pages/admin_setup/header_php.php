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
//  Path: /modules/install/pages/admin_setup/header_php.php
//

  $zc_install->error = false;
  $zc_install->fatal_error = false;
  $zc_install->error_list = array();


  if (isset($_POST['submit'])) {
    require(DIR_FS_ADMIN . 'includes/configure.php');
    require(DIR_FS_ADMIN . 'includes/security_tokens.php');
	// include the list of project menu navigation configurations
	include(DIR_FS_ADMIN . 'includes/menu_navigation.php');
	// include the list of extra database tables and filenames
	$extra_datafiles_dir = DIR_FS_ADMIN . 'my_files/custom/extra_menus/';
	if ($dir = @dir($extra_datafiles_dir)) {
	  while ($file = $dir->read()) {
		if (!is_dir($extra_datafiles_dir . $file)) {
		  if (preg_match('/\.php$/', $file) > 0) {
			include($extra_datafiles_dir . $file);
		  }
		}
	  }
	  $dir->close();
	}

	if (!isset($_POST['admin_username'])) $_POST['admin_username'] = '';
	if (!isset($_POST['admin_email'])) $_POST['admin_email'] = '';
	if (!isset($_POST['admin_pass'])) $_POST['admin_pass'] = '';
	if (!isset($_POST['admin_pass_confirm'])) $_POST['admin_pass_confirm'] = '';

	$admin_username = db_prepare_input($_POST['admin_username']);
	$admin_email = db_prepare_input($_POST['admin_email']);
	$admin_pass = db_prepare_input($_POST['admin_pass']);
	$admin_pass_confirm = db_prepare_input($_POST['admin_pass_confirm']);

    $zc_install->isEmpty($admin_username, ERROR_TEXT_ADMIN_USERNAME_ISEMPTY, ERROR_CODE_ADMIN_USERNAME_ISEMPTY);
    $zc_install->isEmpty($admin_email, ERROR_TEXT_ADMIN_EMAIL_ISEMPTY, ERROR_CODE_ADMIN_EMAIL_ISEMPTY);
    $zc_install->isEmail($admin_email, ERROR_TEXT_ADMIN_EMAIL_NOTEMAIL, ERROR_CODE_ADMIN_EMAIL_NOTEMAIL);
    $zc_install->isEmpty($admin_pass, ERROR_TEXT_LOGIN_PASS_ISEMPTY, ERROR_CODE_ADMIN_PASS_ISEMPTY);
    $zc_install->isEqual($admin_pass, $admin_pass_confirm, ERROR_TEXT_LOGIN_PASS_NOTEQUAL, ERROR_CODE_ADMIN_PASS_NOTEQUAL);


    if (!$zc_install->error) {
	  session_start();
	  if (isset($_SESSION['company'])) {
	    define('DB_DATABASE',$_SESSION['company']);
		define('DB_SERVER',$_SESSION['db_server']);
		define('DB_SERVER_USERNAME',$_SESSION['db_user']);
		define('DB_SERVER_PASSWORD',$_SESSION['db_pw']);
	  } else {
	    die("Unknown company database name.");
	  }
      $db->Connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE) or die("Unable to connect to database");
      $security = load_full_access_security();
      $sql = "insert into " . DB_PREFIX . "users set admin_name = '" . $admin_username . "', admin_email = '" . $admin_email . "', 
	  		admin_pass = '" . pw_encrypt_password($admin_pass) . "', admin_security = '" . $security . "'";
	  $db->Execute($sql);
	  $_SESSION['admin_id'] = db_insert_id();
	  $_SESSION['language'] = $language;
	  $_SESSION['admin_security'] = gen_parse_permissions($security);

	  $db->Close();
      header('location: index.php?main_page=store_setup&language=' . $language);
 	  exit;
	}
  }
  if (!isset($_POST['admin_username'])) $_POST['admin_username'] = '';
  if (!isset($_POST['admin_email'])) $_POST['admin_email'] = '';

  setInputValue($_POST['admin_username'], 'ADMIN_USERNAME_VALUE', '');
  setInputValue($_POST['admin_email'], 'ADMIN_EMAIL_VALUE', '');

// this sets the first field to email address on login - setting in /common/tpl_main_page.php
  $zc_first_field= 'onload="document.getElementById(\'admin_username\').focus()"';

?>