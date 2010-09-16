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
//  Path: /modules/setup/pages/company_mgr/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_COMPANY_MGR];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'install/functions/install.php');
require(DIR_FS_MODULES . 'general/functions/general.php');

/**************   page specific initialization  *************************/
$error = false;
$action = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/setup/company_mgr/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'new':
  case 'copy':
	$company      = db_prepare_input($_POST['company']);
	$db_server    = db_prepare_input($_POST['db_server']);
	$db_user      = db_prepare_input($_POST['db_user']);
	$db_pw        = db_prepare_input($_POST['db_pw']);
	$company_name = db_prepare_input($_POST['company_name']);
	// read the checkboxes
	$cb_demo      = isset($_POST['demo'])      ? 1 : 0;
	$cb_all       = isset($_POST['all'])       ? 1 : 0;
	$cb_chart     = isset($_POST['chart'])     ? 1 : 0;
	$cb_reports   = isset($_POST['reports'])   ? 1 : 0;
	$cb_inventory = isset($_POST['inventory']) ? 1 : 0;
	$cb_customers = isset($_POST['customers']) ? 1 : 0;
	$cb_vendors   = isset($_POST['vendors'])   ? 1 : 0;
	$cb_employees = isset($_POST['employees']) ? 1 : 0;
	$cb_users     = isset($_POST['users'])     ? 1 : 0;

	// error check company name and company full name
	if (!$company || !$company_name) {
		$messageStack->add(SETUP_CO_MGR_ERROR_EMPTY_FIELD,'error');
		break;
	}
	if ($company == $_SESSION['company']) {
		$messageStack->add(SETUP_CO_MGR_DUP_DB_NAME,'error');
		break;
	}

	// check for database already exists
	$db_old = new queryFactory;
	$db_old->connect($_SESSION['db_server'], $_SESSION['db_user'], $_SESSION['db_pw'], $_SESSION['company']);
	$db = new queryFactory;
	if (!$db->connect($db_server, $db_user, $db_pw, $company)) {
		$result = $db_old->Execute_return_error("create database " . $company);
		if ($db_old->error_number) {
			$messageStack->add('DB Error # ' . $db_old->error_number . ' ' . $db_old->error_text,'error');
			$messageStack->add(SETUP_CO_MGR_NO_DB,'error');
			break;
		} else {
			if (!$db->connect(DB_SERVER, $db_user, $db_pw, $company)) {
				$messageStack->add(SETUP_CO_MGR_CANNOT_CONNECT,'error');
				break;
			}
		}
	}

	$result = db_executeSql(DIR_FS_MODULES . 'install/sql/current/tables.sql', $company, DB_PREFIX);
	if (count($result['errors']) > 0) {
		$messageStack->add(SETUP_CO_MGR_ERROR_1,'error');
		break;
	}

	// copy the required table data
	if ($action == 'new' || ($action == 'copy' && !$cb_all)) { // only if not copying all the data
		$result = load_startup_table_data($language = 'en_us');
		if (!$result) {
			$messageStack->add(SETUP_CO_MGR_ERROR_2,'error');
			break;
		}
	}

	// create the new directory and sub-directories
	if (!install_build_dirs($company, $cb_demo)) {
		$messageStack->add(SETUP_CO_MGR_ERROR_3,'error');
		break;
	}

	// create the config.php file and update COMPANY_NAME configuration parameter in table
	install_build_co_config_file(DB_DATABASE, DB_DATABASE . '_TITLE', $company_name);
	install_build_co_config_file(DB_DATABASE, 'DB_SERVER_USERNAME',   $db_user);
	install_build_co_config_file(DB_DATABASE, 'DB_SERVER_PASSWORD',   $db_pw);
	install_build_co_config_file(DB_DATABASE, 'DB_SERVER',            $db_server);
	
	$sql = "update " . DB_PREFIX . "configuration set configuration_value = '" . $company_name . "' where configuration_key = 'COMPANY_NAME'";
	$db->Execute($sql);

	$temp_file = DIR_FS_ADMIN . 'my_files/' . $company . '/temp/temp.sql';
	if ($action == 'copy') {
		if ($cb_all || $cb_inventory) { // duplicate the inventory table since new fields may have been entered
			if (!copy_db_table($db_old, array('inventory'), $temp_file, 'structure')) $error = true;
		}
		if ($cb_all && !$error) {
			$result = $db->Execute("show tables"); // pull table list from new install to avoid PhreeHelp tables
			$table_list = array();
			while (!$result->EOF) {
				$table_list[] = array_shift($result->fields);
				$result->MoveNext();
			}
			if (!copy_db_table($db_old, $table_list, $temp_file)) $error = true;
		} else {
			if ($cb_inventory && !$error) { 
				$table_list = array(TABLE_INVENTORY, TABLE_INVENTORY_ASSY_LIST, TABLE_INVENTORY_CATEGORIES, TABLE_INVENTORY_FIELDS, TABLE_INVENTORY_MS_LIST, TABLE_INVENTORY_SPECIAL_PRICES, TABLE_PRICE_SHEETS);
				if (!copy_db_table($db_old, $table_list, $temp_file, 'both')) $error = true;
			}
			if ($cb_chart) {
				$table_list = array(TABLE_CHART_OF_ACCOUNTS);
				if (!copy_db_table($db_old, $table_list, $temp_file)) $error = true;
			}
			if ($cb_reports) {
				$table_list = array(TABLE_REPORTS, TABLE_REPORT_FIELDS);
				if (!copy_db_table($db_old, $table_list, $temp_file, 'both')) $error = true;
			}
			if ($cb_customers) {
				if (!copy_db_table($db_old, array(TABLE_CONTACTS), $temp_file, 'data', " where type = 'c'")) $error = true;
				if (!copy_db_table($db_old, array(TABLE_ADDRESS_BOOK), $temp_file, 'data', " where type like 'c%'")) $error = true;
			}
			if ($cb_vendors) {
				if (!copy_db_table($db_old, array(TABLE_CONTACTS), $temp_file, 'data', " where type = 'v'")) $error = true;
				if (!copy_db_table($db_old, array(TABLE_ADDRESS_BOOK), $temp_file, 'data', " where type like 'v%'")) $error = true;
			}
			if ($cb_employees) {
				if (!copy_db_table($db_old, array(TABLE_CONTACTS), $temp_file, 'data', " where type = 'e'")) $error = true;
				if (!copy_db_table($db_old, array(TABLE_ADDRESS_BOOK), $temp_file, 'data', " where type like 'e%'")) $error = true;
			}
			if ($cb_users) {
				$table_list = array(TABLE_USERS, TABLE_USERS_PROFILES);
				if (!copy_db_table($db_old, $table_list, $temp_file)) $error = true;
			} else { // Write the current user to db with full access so they can log in, set all security levels to 4.
				$sql = "select admin_name, admin_email, admin_pass, account_id, admin_prefs  
					from " . TABLE_USERS . " where admin_id = " . $_SESSION['admin_id'];
				$result = $db_old->Execute($sql);
				$fields = $result->fields;
				$fields['admin_security'] = load_full_access_security();
				$result = db_perform(TABLE_USERS, $fields, 'insert');
			}
		}
	}

	if (!$error) { // reset SESSION['company'] to new company and redirect to install->store_setup
		$messageStack->add(SETUP_CO_MGR_CREATE_SUCCESS,'success');
		gen_add_audit_log(SETUP_CO_MGR_LOG . ($action=='new' ? TEXT_NEW : TEXT_COPY), $company);
		$_SESSION['company']   = $company; // save the necessary db variables to continue setup
		$_SESSION['db_server'] = $db_server;
		$_SESSION['db_user']   = $db_user;
		$_SESSION['db_pw']     = $db_pw;
		gen_redirect(html_href_link(DIR_WS_MODULES . 'install/index.php?main_page=' . ($action=='new' ? 'admin_setup' : 'store_setup') . '&language=' . $_SESSION['language'], '', 'SSL'));
	}
	break;

  case 'delete':
	$company = $_SESSION['companies'][$_POST['company']];
	// Failsafe to prevent current company from being deleted accidently
	if ($company <> $_SESSION['company']) {
		$db->Execute("drop database " . $company);
		delete_dir(DIR_FS_MY_FILES . $company);
	}
	gen_add_audit_log(SETUP_CO_MGR_LOG . TEXT_DELETE, $company);
	$messageStack->add(SETUP_CO_MGR_DELETE_SUCCESS,'success');
	break;

  default:
}

/*****************   prepare to display templates  *************************/
$include_header   = true;
$include_footer   = true;
$include_calendar = false;
$include_template = 'template_main.php';
define('PAGE_TITLE', BOX_COMPANY_MANAGER);
?>