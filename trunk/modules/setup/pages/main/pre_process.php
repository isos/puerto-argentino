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
//  Path: /modules/setup/pages/main/pre_process.php
//

/**************  include page specific files    *********************/
$module_name = $_GET['subject'];
if (!$module_name) {
  $messageStack->add_session(SETUP_NO_MODULE_NAME, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/modules/' . $module_name . '.php');
require(DIR_FS_WORKING . 'classes/' . $module_name . '.php');

/**************   page specific initialization  *************************/
$subject_module = new $module_name();

/**************   Check user security   *****************************/
$security_level = $subject_module->security_id;
if ($security_level == 0) { // not supposed to be here
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

$action = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/setup/main/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'insert':      $subject_module->btn_insert(); break;
  case 'save':        $subject_module->btn_save();   break;
  case 'delete':      $subject_module->btn_delete(); break;
  case 'update':      $subject_module->btn_update(); break;
  case 'go_first':    $_GET['page'] = 1;             break;
  case 'go_previous': $_GET['page']--;               break;
  case 'go_next':     $_GET['page']++;               break;
  case 'go_last':     $_GET['page'] = 99999;         break;
  case 'search':
  case 'search_reset':
  case 'go_page':
  default:
}

/*****************   prepare to display templates  *************************/

$include_header   = true;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = false;
$include_template = 'template_main.php';
define('PAGE_TITLE', $subject_module->title);
?>