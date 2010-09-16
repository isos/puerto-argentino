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
//  Path: /modules/install/pages/fiscal_setup/header_php.php
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
  require('../../includes/database_tables.php');
  if (!defined('DB_TYPE') || DB_TYPE=='') {
    echo('Database Type Invalid. Did your configure.php file get written correctly?');
    $zc_install->error = true;
  }

  $db->Connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE) or die("Unable to connect to database");

  if (isset($_POST['submit'])) {
    $month = db_prepare_input($_POST['store_period_1']);
    $fiscal_year = db_prepare_input($_POST['store_fiscal_year']);
	$first_date = $fiscal_year . '-' . $month . '-01';
 
    if ($zc_install->error == false) {
	  require_once(DIR_FS_MODULES . 'gen_ledger/functions/gen_ledger.php');
	  require_once(DIR_FS_MODULES . 'general/functions/gen_functions.php');
	  require_once(DIR_FS_MODULES . 'general/functions/general.php');
	  validate_fiscal_year($fiscal_year, '1', $first_date);
	  build_and_check_account_history_records();
	  gen_auto_update_period(false);
	  $db->Close();
      header('location: index.php?main_page=coa_defaults&language=' . $language);
      exit();
    }
  }

  if (isset($_POST['skip'])) {
    $db->Close();
    header('location: index.php?main_page=coa_defaults&language=' . $language);
    exit();
  }

  //if not submit, set some defaults
  $period_string = '';
  foreach ($period_values as $value) {
    $period_string .= '<option value="' . $value['id'] . '">' . $value['text'] . '</option>';
  }

  $fiscal_string = '';
  $current_year = date('Y');
  foreach ($fiscal_years as $value) {
    $fiscal_string .= '<option value="' . $value['id'] . '"' . ($value['id']==$current_year ? ' selected' : '') . '>' . $value['text'] . '</option>';
  }
  $result = $db->Execute("select min(fiscal_year) as min, max(fiscal_year) as max from " . DB_PREFIX . "accounting_periods");
  if ($result->fields['min'] <> '') {
  	$extra_text = '<em>' . TEXT_FISCAL_YEAR_EXISTS . '</em>';
	$fy_exists = true;
	$from_num = $result->fields['min'];
	$to_num = $result->fields['max'];
  } else {
  	$extra_text = '';
	$fy_exists = false;
  }

  $db->Close();

// this sets the first field to email address on login - setting in /common/tpl_main_page.php
  $zc_first_field= 'onload="document.getElementById(\'store_period_1\').focus()"';
?>