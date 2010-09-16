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
//  Path: /modules/general/pages/ctl_panel/pre_process.php
//

/**************   Check user security   *****************************/
/*
$security_level = $_SESSION['admin_security'][SECURITY_ID_USERS];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}
*/
/**************  include page specific files    *********************/
require_once (DIR_FS_WORKING . 'classes/ctl_panel.php');

/**************   page specific initialization  *************************/
$page_id = $_GET['pID'];

// retrieve all modules from directory
$dh  = opendir(DIR_FS_MODULES . 'general/boxes/');
$files = array();
while (($module_id = readdir($dh)) !== false) {
   if (strpos($module_id, '.php') !== false) $files[] = substr($module_id, 0, strpos($module_id, '.php'));
}
$the_list = array();
for ($i=0; $i<count($files); $i++) {
	$module_id = $files[$i];
	include_once (DIR_FS_MODULES . 'general/language/' . $_SESSION['language'] . '/boxes/' . $module_id . '.php');
	include_once (DIR_FS_MODULES . 'general/boxes/' . $module_id . '.php');
	$classname = 'cl_' . $module_id;
	$$classname = new $module_id;
	$the_list[$i]['module_id']   = $$classname->module_id;
	$the_list[$i]['title']       = $$classname->title;
	$the_list[$i]['description'] = $$classname->description;
	$the_list[$i]['security']    = $$classname->security;
}

// retireve current user profile for this page
$my_profile = array();
$result = $db->Execute("select module_id from " . TABLE_USERS_PROFILES . " 
	where user_id = " . $_SESSION['admin_id'] . " and page_id = '" . $page_id . "'");
while (!$result->EOF) {
	$my_profile[] = $result->fields['module_id'];
	$result->MoveNext();
}

$action = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/general/ctl_panel/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
	foreach($the_list as $value) {
		$module_id = $value['module_id'];
		$classname = 'cl_' . $module_id;
		$$classname->page_id = $page_id;
		$$classname->module_id = $module_id;
		if (isset($_POST[$module_id]) && !in_array($module_id, $my_profile)) { // add it
			$$classname->Install();
			$my_profile[] = $module_id;
		}
		if (!isset($_POST[$module_id]) && in_array($module_id, $my_profile)) { // delete it
			$$classname->Remove();
			$id_pos = array_search($module_id, $my_profile);
			array_splice($my_profile, $id_pos, $id_pos + 1);
		}
	}
	gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
	break;
  default:
}

/*****************   prepare to display templates  *************************/

$include_header   = true;
$include_footer   = true;
$include_tabs     = true;
$include_calendar = false;
$include_template = 'template_main.php';
define('PAGE_TITLE', CP_ADD_REMOVE_BOXES);

?>