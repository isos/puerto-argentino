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
//  Path: /modules/services/pages/ship_mgr/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_SHIPPING_MANAGER];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'shipping/language/' . $_SESSION['language'] . '/language.php');

/**************   page specific initialization  *************************/
$date        = $_GET['search_date']       ? gen_db_date_short($_GET['search_date']) : date('Y-m-d', time());
$search_text = $_GET['search_text'] == TEXT_SEARCH ? ''         : db_input(db_prepare_input($_GET['search_text']));
$action      = isset($_GET['action'])     ? $_GET['action']     : $_POST['todo'];
$module_id   = isset($_POST['module_id']) ? $_POST['module_id'] : '';
$row_seq     = isset($_POST['rowSeq'])    ? $_POST['rowSeq']    : '';

$file_extension = substr($PHP_SELF, strrpos($PHP_SELF, '.'));
$directory_array = array();
// load standard modules
define('DEFAULT_MOD_DIR', DIR_FS_WORKING . 'shipping/');
if ($dir = @dir(DEFAULT_MOD_DIR . 'modules/')) {
  while ($file = $dir->read()) {
	if (!is_dir(DEFAULT_MOD_DIR . 'modules/' . $file)) {
	  if (substr($file, strrpos($file, '.')) == $file_extension) $directory_array[] = $file;
	}
  }
  $dir->close();
}
// load custom modules
define('CUSTOM_MOD_DIR', DIR_FS_MY_FILES . 'custom/services/shipping/');
if ($dir = @dir(CUSTOM_MOD_DIR . 'modules/')) {
  while ($file = $dir->read()) {
	if (!is_dir(CUSTOM_MOD_DIR . 'modules/' . $file)) {
	  if (substr($file, strrpos($file, '.')) == $file_extension) $directory_array[] = $file;
	}
  }
  $dir->close();
}
sort($directory_array);

// load the classes, standard first
$installed_modules = array();
for ($i = 0; $i < sizeof($directory_array); $i++) {
	$file = $directory_array[$i];
	@include_once(DEFAULT_MOD_DIR . 'modules/' . $file);
	$class = substr($file, 0, strrpos($file, '.'));
	if (class_exists($class)) {
		@include(DEFAULT_MOD_DIR . 'language/' . $_SESSION['language'] . '/modules/' . $file);
		$subject = new $class;
		if ($subject->check() > 0) {
			if ($subject->sort_order > 0) {
				$installed_modules[$subject->sort_order] = $class;
			} else {
				$installed_modules[] = $class;
			}
		}
	}
}
// load the custom classes
for ($i = 0; $i < sizeof($directory_array); $i++) {
	$file = $directory_array[$i];
	@include_once(CUSTOM_MOD_DIR . 'modules/' . $file);
	$class = substr($file, 0, strrpos($file, '.'));
	if (class_exists($class)) {
		@include(CUSTOM_MOD_DIR . 'language/' . $_SESSION['language'] . '/modules/' . $file);
		$subject = new $class;
		if ($subject->check() > 0) {
			if ($subject->sort_order > 0) {
				$installed_modules[$subject->sort_order] = $class;
			} else {
				$installed_modules[] = $class;
			}
		}
	}
}
ksort($installed_modules);

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/services/ship_mgr/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'track':
    if (!$module_id) break;
	$tracking = new $module_id;
	$tracking->trackPackages($date, $row_seq);
	break;
  case 'reconcile':
    if (!$module_id) break;
	$reconcile = new $module_id;
	$reconcile->reconcileInvoice();
	break;
  case 'search':
  case 'search_reset': 
  default:
}

/*****************   prepare to display templates  *************************/
$include_header   = true;
$include_footer   = true;
$include_tabs     = true;
$include_calendar = true;
$include_template = 'template_main.php';
define('PAGE_TITLE', BOX_SHIPPING_MANAGER);

?>