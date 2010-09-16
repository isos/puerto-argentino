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
//  Path: /modules/install/pages/chart_setup/header_php.php
//

  $zc_install->error = false;

  session_start();
  if (isset($_SESSION['company'])) {
	define('DB_DATABASE',$_SESSION['company']);
	define('DB_SERVER',$_SESSION['db_server']);
	define('DB_SERVER_USERNAME',$_SESSION['db_user']);
	define('DB_SERVER_PASSWORD',$_SESSION['db_pw']);
  } else {
	die("Unknown company database name");
  }
  require('../../includes/configure.php');
  if (!defined('DB_TYPE') || DB_TYPE=='') {
    echo('Database Type Invalid. Did your configure.php file get written correctly?');
    $zc_install->error = true;
  }

  $db->Connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE) or die("Unable to connect to database");

  if (isset($_POST['submit'])) {
    $filename = db_prepare_input($_POST['store_default_coa']);
	
	// check the fields that are required
    $zc_install->isEmpty($filename, ERROR_TEXT_CHART_NAME_ISEMPTY, ERROR_CODE_CHART_NAME_ISEMPTY);

    if ($zc_install->error == false) {
	  if ($filename != 'default') { // clear out the db and write new chart of accounts
		load_new_chart($filename);
	  }
      $db->Close();
      header('location: index.php?main_page=fiscal_setup&language=' . $language);
      exit;
    }
  }

  //if not submit, set some defaults
  $chart_string = '';
  $result = $db->Execute("select id from " . DB_PREFIX . "chart_of_accounts limit 1");
  if ($result->RecordCount() > 0) { // there are already values in the table, option to keep them
  	$chart_string .= '<option value="default">' . urlencode(TEXT_CURRENT_SETTINGS). '</option>';
  }
  $store_chart = install_read_chart_desc();
  foreach ($store_chart as $value) {
    $chart_string .= '<option value="' . $value['id'] . '">' . htmlspecialchars($value['text']) . '</option>';
  }

  $db->Close();

  if (!isset($_POST['demo_install'])) $_POST['demo_install'] = false;
  setRadioChecked($_POST['demo_install'], 'DEMO_INSTALL', 'false');
// this sets the first field to email address on login - setting in /common/tpl_main_page.php
  $zc_first_field= 'onload="document.getElementById(\'store_default_coa\').focus()"';
?>