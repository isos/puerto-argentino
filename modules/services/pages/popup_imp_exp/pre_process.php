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
//  Path: /modules/services/pages/popup_imp_exp/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = (int)$_SESSION['admin_id']; // for popups, just make sure they are logged in
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files  *********************/
require(DIR_FS_WORKING . 'import_export/language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'reportwriter/language/' . $_SESSION['language'] . '/language.php'); // error messages, qualifiers
require(DIR_FS_WORKING . 'import_export/functions/import_export.php');

/**************   page specific initialization  *************************/
$id = (int)$_GET['id'];
$row_id = (int)$_GET['row_id'];
$action = (isset($_POST['todo'])) ? $_POST['todo'] : '';

$sql = "select params from " . TABLE_IMPORT_EXPORT . " where id = " . $id;
$definitions = $db->Execute($sql);
$params = unserialize($definitions->fields['params']);


/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/accounts/popup_accts/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
	 $name = db_prepare_input($_POST['name']);
	 $processing = db_prepare_input($_POST['processing']);
	 $show = isset($_POST['show']) ? '1' : '0';
// TBD check for errors (just in name only)
	 $params[$row_id]['name'] = $name;
	 $params[$row_id]['proc'] = $processing;
	 $params[$row_id]['show'] = $show;
	 $sql_data_array = array('params' => serialize($params));
	 db_perform(TABLE_IMPORT_EXPORT, $sql_data_array, 'update', 'id = ' . $id);
	 break;
  default:
}

/*****************   prepare to display templates  *************************/

$include_header = false; // include header flag
$include_footer = false; // include footer flag
$include_tabs = false;
$include_calendar = false;

$include_template = 'template_main.php'; // include display template (required)
define('PAGE_TITLE', IE_POPUP_FIELD_TITLE);

?>