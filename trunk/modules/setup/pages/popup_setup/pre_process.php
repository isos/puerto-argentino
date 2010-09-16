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
//  Path: /modules/setup/pages/popup_setup/pre_process.php
//

/**************  include page specific files    *********************/
$close_popup = false;
$module_name = $_GET['subject'];
if (!$module_name) {
  $messageStack->add_session('The popup_setup script require a module name', 'error');
  $close_popup = true;
}

require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/modules/' . $module_name . '.php');
require(DIR_FS_WORKING . 'classes/' . $module_name . '.php');

/**************   page specific initialization  *************************/
$subject_module = new $module_name();

$sID = $_GET['sID'];
$action = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

/**************   Check user security   *****************************/
$security_level = $subject_module->security_id;
if ($security_level == 0) { // not supposed to be here
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  $close_popup = true;
}

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/inventory/popup_adj/module/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':  //save the posted data and close form
    if ($subject_module->btn_save($sID)) $close_popup = true;
  default:
}

/*****************   prepare to display templates  *************************/

$include_header = false; // include header flag
$include_footer = false; // include footer flag
$include_tabs = false;
$include_calendar = false;

$include_template = 'template_main.php'; // include display template (required)
define('PAGE_TITLE', $subject_module->title);

?>