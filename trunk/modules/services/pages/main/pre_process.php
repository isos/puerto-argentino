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
//  Path: /modules/services/pages/main/pre_process.php
//

/**************  include page specific files    *********************/
require(DIR_FS_MODULES . 'setup/functions/setup.php');
require(DIR_FS_WORKING . 'classes/class.base.php');

/**************   page specific initialization  *************************/
$module_type = (isset($_GET['set']) ? $_GET['set'] : '');
$action      = (isset($_GET['action']) ? $_GET['action'] : '');

define('DEFAULT_MOD_DIR', DIR_FS_WORKING . $module_type . '/modules/');
define('CUSTOM_MOD_DIR',  DIR_FS_MY_FILES . 'custom/services/' . $module_type . '/modules/');
/***************   hook for custom services  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/services/main/extra_sets.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($module_type) {
  case 'shipping':
	// validate security settings
	$security_level = $_SESSION['admin_security'][SECURITY_ID_SHIPPING];
	if ($security_level == 0) { // not supposed to be here
	  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
	  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
	}
	include_once (DIR_FS_WORKING . 'shipping/language/' . $_SESSION['language'] . '/language.php');
	$module_key = 'MODULE_SHIPPING_INSTALLED';
	define('HEADING_TITLE_SERVICES', HEADING_TITLE_MODULES_SHIPPING);
	$shipping_errors = '';
	if (gen_get_configuration_key_value('SHIPPING_ORIGIN_ZIP') == 'NONE' || gen_get_configuration_key_value('SHIPPING_ORIGIN_ZIP') == '') {
	  $shipping_errors .= '<br />' . ERROR_SHIPPING_ORIGIN_ZIP;
	}
	if (gen_get_configuration_key_value('ORDER_WEIGHT_ZERO_STATUS') == '1' && !defined('MODULE_SHIPPING_FREESHIPPER_STATUS')) {
	  $shipping_errors .= '<br />' . ERROR_ORDER_WEIGHT_ZERO_STATUS;
	}
	if (defined('MODULE_SHIPPING_USPS_STATUS') and (MODULE_SHIPPING_USPS_USERID=='NONE' || MODULE_SHIPPING_USPS_SERVER == 'test')) {
	  $shipping_errors .= '<br />' . SHIPPING_USPS_ERROR_STATUS;
	}
	if ($shipping_errors != '') {
	  $messageStack->add(SHIPPING_ERROR_CONFIGURATION . $shipping_errors, 'caution');
	}
	break;
  case 'pricesheets':
	// validate security settings
	$security_level = $_SESSION['admin_security'][SECURITY_ID_PRICE_SHEETS];
	if ($security_level == 0) { // not supposed to be here
	  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
	  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
	}
	include_once(DIR_FS_WORKING . 'pricesheets/language/' . $_SESSION['language'] . '/language.php');
	$module_key = 'MODULE_PRICE_SHEETS_INSTALLED';
	define('HEADING_TITLE_SERVICES', HEADING_TITLE_MODULES_PRICE_SHEETS);
	break;
  case 'payment':
	// validate security settings
	$security_level = $_SESSION['admin_security'][SECURITY_ID_PAYMENT];
	if ($security_level == 0) { // not supposed to be here
	  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
	  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
	}
	include_once(DIR_FS_WORKING . 'payment/language/' . $_SESSION['language'] . '/language.php');
	$module_key = 'MODULE_PAYMENT_INSTALLED';
	define('HEADING_TITLE_SERVICES', HEADING_TITLE_MODULES_PAYMENT);
	break;
  default:
}

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/services/main/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

switch ($action) {
  case 'save':
	while (list($key, $value) = each($_POST['configuration'])) {
	  if (is_array($value)) {
		$value = implode(", ", $value);
		$value = str_replace(", --none--", "", $value);
	  }
	  $db->Execute("update " . TABLE_CONFIGURATION . " set configuration_value = '" . $value . "'
		where configuration_key = '" . $key . "'");
	}
	$configuration_query = 'select configuration_key as cfgkey, configuration_value as cfgvalue
					  from ' . TABLE_CONFIGURATION;
	$configuration = $db->Execute($configuration_query);
	gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action', 'subject')) . ($_GET['subject'] != '' ? '&subject=' . $_GET['subject'] : ''), 'SSL'));
	break;
  case 'install':
  case 'remove':
	$class = $_GET['subject'];
	if (file_exists(DEFAULT_MOD_DIR . $class . '.php')) {
	  $module_directory = DEFAULT_MOD_DIR . $class . '.php';
	} else if (file_exists(CUSTOM_MOD_DIR . $class . '.php')) {
	  $module_directory = CUSTOM_MOD_DIR . $class . '.php';
	} else {
	  $module_directory = false;
	}
	if ($module_directory) {
	  include($module_directory);
	  $module_set = new $class;
	  if ($action == 'install') {
		if ($security_level < 2) {
			$messageStack->add_session(ERROR_NO_PERMISSION,'error');
			gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
			break;
		}
		$module_set->install();
	  } elseif ($action == 'remove') {
		if ($security_level < 4) {
			$messageStack->add_session(ERROR_NO_PERMISSION,'error');
			gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
			break;
		}
		$module_set->remove();
	  }
	}
	gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
	break;

  default:
}

/*****************   prepare to display templates  *************************/

$include_header   = true;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = false;
$include_template = 'template_main.php';
define('PAGE_TITLE', HEADING_TITLE_SERVICES);
?>
