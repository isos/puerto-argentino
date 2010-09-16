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
//  Path: /modules/setup/pages/config/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_CONFIGURATION];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
// need to shipping defines to set the shipping defaults
require(DIR_FS_MODULES . 'services/shipping/language/' . $_SESSION['language'] . '/language.php');
if (file_exists(DIR_FS_MODULES . 'install/language/' . $_SESSION['language'] . '/config_data.php')) {
  require(DIR_FS_MODULES . 'install/language/' . $_SESSION['language'] . '/config_data.php');
} else {
  require(DIR_FS_MODULES . 'install/language/en_us/config_data.php');
}

require(DIR_FS_WORKING . 'functions/setup.php');

/**************   page specific initialization  *************************/
$action = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/setup/config/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
	$configuration_value = db_prepare_input($_POST['configuration_value']);
	$cID = db_prepare_input($_GET['cID']);
	$db->Execute("update " . TABLE_CONFIGURATION . "
		set configuration_value = '" . db_input($configuration_value) . "',
		last_modified = now() where configuration_id = '" . (int)$cID . "'");
	$configuration_query = 'select configuration_key as cfgkey, configuration_value as cfgvalue
		from ' . TABLE_CONFIGURATION;
	$configuration = $db->Execute($configuration_query);
	// set the WARN_BEFORE_DOWN_FOR_MAINTENANCE to false if DOWN_FOR_MAINTENANCE = true
	if ( (WARN_BEFORE_DOWN_FOR_MAINTENANCE == 'true') && (DOWN_FOR_MAINTENANCE == 'true') ) {
	$db->Execute("update " . TABLE_CONFIGURATION . "
		set configuration_value = 'false', last_modified = '" . NOW . "'
		where configuration_key = 'WARN_BEFORE_DOWN_FOR_MAINTENANCE'"); }
	$configuration_query = "select configuration_key as cfgkey, configuration_value as cfgvalue
		from " . TABLE_CONFIGURATION;
	$configuration = $db->Execute($configuration_query);
	break;
  default:
}

/*****************   prepare to display templates  *************************/
$gID = (isset($_GET['gID'])) ? $_GET['gID'] : 1;
$_GET['gID'] = $gID;

if ($gID == 7) {
	$shipping_errors = '';
	if (gen_get_configuration_key_value('SHIPPING_ORIGIN_ZIP') == 'NONE' or gen_get_configuration_key_value('SHIPPING_ORIGIN_ZIP') == '') {
	  $shipping_errors .= '<br />' . ERROR_SHIPPING_ORIGIN_ZIP;
	}
	if (gen_get_configuration_key_value('ORDER_WEIGHT_ZERO_STATUS') == '1' and !defined('MODULE_SHIPPING_FREESHIPPER_STATUS')) {
	  $shipping_errors .= '<br />' . ERROR_ORDER_WEIGHT_ZERO_STATUS;
	}
	if ($shipping_errors != '') {
	  $messageStack->add(SHIPPING_ERROR_CONFIGURATION . $shipping_errors, 'caution');
	}
}

$include_header   = true;
$include_footer   = true;
$include_calendar = false;
$include_template = 'template_main.php';
define('PAGE_TITLE', $config_groups[$gID]['title']);
?>