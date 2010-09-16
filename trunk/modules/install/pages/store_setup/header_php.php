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
//  Path: /modules/install/pages/store_setup/header_php.php
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
  if (!defined('DB_TYPE') || DB_TYPE == '') {
    echo('Database Type Invalid. Did your configure.php file get written correctly?');
    $zc_install->error = true;
  }

  $db->Connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE) or die("Unable to connect to database");

  if (!isset($_POST['store_id']))               $_POST['store_id']               = load_config_value('COMPANY_ID');
  if (!isset($_POST['store_name']))             $_POST['store_name']             = load_config_value('COMPANY_NAME');
  if (!isset($_POST['store_address1']))         $_POST['store_address1']         = load_config_value('COMPANY_ADDRESS1');
  if (!isset($_POST['store_address2']))         $_POST['store_address2']         = load_config_value('COMPANY_ADDRESS2');
  if (!isset($_POST['store_city_town']))        $_POST['store_city_town']        = load_config_value('COMPANY_CITY_TOWN');
  if (!isset($_POST['store_zone']))             $_POST['store_zone']             = load_config_value('COMPANY_ZONE');
  if (!isset($_POST['store_postal_code']))      $_POST['store_postal_code']      = load_config_value('COMPANY_POSTAL_CODE');
  if (!isset($_POST['store_country']))          $_POST['store_country']          = load_config_value('COMPANY_COUNTRY');
  if (!isset($_POST['store_email']))            $_POST['store_email']            = load_config_value('COMPANY_EMAIL');
  if (!isset($_POST['store_website']))          $_POST['store_website']          = load_config_value('COMPANY_WEBSITE');
  if (!isset($_POST['store_telephone1']))       $_POST['store_telephone1']       = load_config_value('COMPANY_TELEPHONE1');
  if (!isset($_POST['store_telephone2']))       $_POST['store_telephone2']       = load_config_value('COMPANY_TELEPHONE2');
  if (!isset($_POST['store_fax']))              $_POST['store_fax']              = load_config_value('COMPANY_FAX');
  if (!isset($_POST['store_default_currency'])) $_POST['store_default_currency'] = load_config_value('DEFAULT_CURRENCY');

  if (isset($_POST['submit'])) {
    $store_id               = db_prepare_input($_POST['store_id']);
    $store_name             = db_prepare_input($_POST['store_name']);
    $store_address1         = db_prepare_input($_POST['store_address1']);
    $store_address2         = db_prepare_input($_POST['store_address2']);
    $store_city_town        = db_prepare_input($_POST['store_city_town']);
    $store_zone             = db_prepare_input($_POST['store_zone']);
    $store_postal_code      = db_prepare_input($_POST['store_postal_code']);
    $store_country          = db_prepare_input($_POST['store_country']);
    $store_email            = db_prepare_input($_POST['store_email']);
    $store_website          = db_prepare_input($_POST['store_website']);
    $store_telephone1       = db_prepare_input($_POST['store_telephone1']);
    $store_telephone2       = db_prepare_input($_POST['store_telephone2']);
    $store_fax              = db_prepare_input($_POST['store_fax']);
    $store_email            = db_prepare_input($_POST['store_email']);
    $store_default_currency = db_prepare_input($_POST['store_default_currency']);

	// check the fields that are required
    $zc_install->isEmpty($store_id, ERROR_TEXT_STORE_ID_ISEMPTY, ERROR_CODE_STORE_ID_ISEMPTY);
    $zc_install->isEmpty($store_name, ERROR_TEXT_STORE_NAME_ISEMPTY, ERROR_CODE_STORE_NAME_ISEMPTY);
    $zc_install->isEmpty($store_address1, ERROR_TEXT_STORE_ADDRESS1_ISEMPTY, ERROR_CODE_STORE_ADDRESS1_ISEMPTY);
    $zc_install->isEmpty($store_email, ERROR_TEXT_STORE_OWNER_EMAIL_ISEMPTY, ERROR_CODE_STORE_OWNER_EMAIL_ISEMPTY);
    $zc_install->isEmail($store_email, ERROR_TEXT_STORE_OWNER_EMAIL_NOTEMAIL, ERROR_CODE_STORE_OWNER_EMAIL_NOTEMAIL);
    $zc_install->isEmpty($store_postal_code, ERROR_TEXT_STORE_POSTAL_CODE_ISEMPTY, ERROR_CODE_STORE_POSTAL_CODE_ISEMPTY);
    if ($_POST['demo_install'] == 'true') {
      $zc_install->fileExists('sql/current/demo_data.php', ERROR_TEXT_DEMO_SQL_NOTEXIST, ERROR_CODE_DEMO_SQL_NOTEXIST);
    }

    if ($zc_install->error == false) {
      if ($_POST['demo_install'] == 'true') {
		require('sql/current/demo_data.php');
		foreach($extra_sqls as $extra_sql) {
			if (!$db->Execute($extra_sql)) $zc_install->error = true;
		}
//        db_executeSql('sql/current/demo_data.sql', DB_DATABASE, DB_PREFIX);
        // copy the demo image files to company directory
	 	$source_dir = DIR_FS_ADMIN . 'themes/default/images/demo';
	 	$dest_dir = DIR_FS_ADMIN . 'my_files/' . $_SESSION['company'] . '/inventory/images/demo';
	 	dircopy($source_dir, $dest_dir);
      }

      $db->updateConfigureValue('COMPANY_ID',          $store_id);
      $db->updateConfigureValue('COMPANY_NAME',        $store_name);
      $db->updateConfigureValue('COMPANY_ADDRESS1',    $store_address1);
      $db->updateConfigureValue('COMPANY_ADDRESS2',    $store_address2);
      $db->updateConfigureValue('COMPANY_CITY_TOWN',   $store_city_town);
      $db->updateConfigureValue('COMPANY_ZONE',        $store_zone);
      $db->updateConfigureValue('COMPANY_POSTAL_CODE', $store_postal_code);
      $db->updateConfigureValue('COMPANY_COUNTRY',     $store_country);
      $db->updateConfigureValue('COMPANY_EMAIL',       $store_email);
      $db->updateConfigureValue('COMPANY_WEBSITE',     $store_website);
      $db->updateConfigureValue('COMPANY_TELEPHONE1',  $store_telephone1);
      $db->updateConfigureValue('COMPANY_TELEPHONE2',  $store_telephone2);
      $db->updateConfigureValue('COMPANY_FAX',         $store_fax);
      $db->updateConfigureValue('DEFAULT_CURRENCY',    $store_default_currency);
	  // update the default setting in journal_main to default to the selected value
	  $db->Execute("ALTER TABLE " . TABLE_JOURNAL_MAIN . " CHANGE `currencies_code` `currencies_code` CHAR(3) NOT NULL DEFAULT '" . $store_default_currency . "'");
      $db->Close();
	  // create/update the config.php file with the new company name
	  install_build_co_config_file(DB_DATABASE, DB_DATABASE . '_TITLE', $store_name);
	  install_build_co_config_file(DB_DATABASE, 'DB_SERVER_USERNAME',   DB_SERVER_USERNAME);
	  install_build_co_config_file(DB_DATABASE, 'DB_SERVER_PASSWORD',   DB_SERVER_PASSWORD);
	  install_build_co_config_file(DB_DATABASE, 'DB_SERVER',            DB_SERVER);

      header('location: index.php?main_page=chart_setup&language=' . $language);
      exit;
    }
  }

  //if not submit, set some defaults
  $sql = "select countries_iso_code_3, countries_name from " . DB_PREFIX . "countries";
  $country = $db->Execute($sql);
  $country_string = '';
  while (!$country->EOF) {
    $country_string .= '<option value="' . $country->fields['countries_iso_code_3'] . '"' . setSelected($country->fields['countries_iso_code_3'], $_POST['store_country']) . '>' . htmlspecialchars($country->fields['countries_name']) . '</option>';
    $country->MoveNext();
  }

  $sql = "select title, code from " . DB_PREFIX . "currencies";
  $currency = $db->Execute($sql) or die("error in $sql" . $db->ErrorMsg());;
  $currency_string = '';
  while (!$currency->EOF) {
    $currency_string .= '<option value="' . $currency->fields['code'] . '"' . setSelected($currency->fields['code'], $_POST['store_default_currency']) . '>' . htmlspecialchars($currency->fields['title']) . '</option>';
    $currency->MoveNext();
  }

  $db->Close();

  if (!isset($_POST['demo_install'])) $_POST['demo_install'] = false;
  setRadioChecked($_POST['demo_install'], 'DEMO_INSTALL', 'false');
// this sets the first field to email address on login - setting in /common/tpl_main_page.php
  $zc_first_field= 'onload="document.getElementById(\'store_id\').focus()"';
?>