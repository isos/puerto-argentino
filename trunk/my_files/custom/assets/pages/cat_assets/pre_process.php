<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2008 PhreeSoft, LLC                               |
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
//  Path: /modules/assets/pages/cat_assets/pre_process.php
//

define('MAX_CP_COLUMNS',3); // set the maximum number of control panel columns to 3

require_once (DIR_FS_CLASSES . 'ctl_panel.php');

$action = $_POST['action'];

switch ($action) {
	case 'save':
		$module_id = db_prepare_input($_POST['module_id']);
		include_once (DIR_FS_MODULES . 'general/boxes/' . $module_id . '.php');
		$new_box = new $module_id;
		$new_box->Update();
		break;
	case 'delete':
		$module_id = db_prepare_input($_POST['module_id']);
		include (DIR_FS_ADMIN . 'modules/general/boxes/' . $module_id . '.php');
		$rm_box = new $module_id;
		$rm_box->page_id = $module;
		$rm_box->module_id = $module_id;
		$rm_box->Remove();
		gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
		break;
	case 'move_up': 
	case 'move_down':
		$module_id = db_prepare_input($_POST['module_id']);
		$sql = "select column_id, row_id from " . TABLE_USERS_PROFILES . " 
			where user_id = " . $_SESSION['admin_id'] . " and page_id = '" . $module . "' and module_id = '" . $module_id . "'";
		$result = $db->Execute($sql);
		$current_row = $result->fields['row_id'];
		$current_column = $result->fields['column_id'];
		$new_row = ($action == 'move_up') ? ($current_row - 1) : ($current_row + 1);
		$sql = "select max(row_id) as max_row from " . TABLE_USERS_PROFILES . " 
			where user_id = " . $_SESSION['admin_id'] . " and page_id = '" . $module . "' and column_id = '" . $current_column . "'";
		$result = $db->Execute($sql);
		$max_row = $result->fields['max_row'];
		if (($new_row >= 1 && $action == 'move_up') || ($new_row <= $max_row && $action == 'move_down')) {
			$sql = "update  " . TABLE_USERS_PROFILES . " set row_id = 0 
				where user_id = " . $_SESSION['admin_id'] . " and page_id = '" . $module . "' 
				and column_id = " . $current_column . " and row_id = '" . $current_row . "'";
			$db->Execute($sql);
			$sql = "update  " . TABLE_USERS_PROFILES . " set row_id = " . $current_row . "  
				where user_id = " . $_SESSION['admin_id'] . " and page_id = '" . $module . "' 
				and column_id = " . $current_column . " and row_id = '" . $new_row . "'";
			$db->Execute($sql);
			$sql = "update  " . TABLE_USERS_PROFILES . " set row_id = " . $new_row . "  
				where user_id = " . $_SESSION['admin_id'] . " and page_id = '" . $module . "' 
				and column_id = " . $current_column . " and row_id = 0";
			$db->Execute($sql);
		}
		break;
	case 'move_left':
	case 'move_right':
		$module_id = db_prepare_input($_POST['module_id']);
		$sql = "select column_id, row_id from " . TABLE_USERS_PROFILES . " 
			where user_id = " . $_SESSION['admin_id'] . " and page_id = '" . $module . "' and module_id = '" . $module_id . "'";
		$result = $db->Execute($sql);
		$current_row = $result->fields['row_id'];
		$current_column = $result->fields['column_id'];
		$new_col = ($action == 'move_left') ? ($current_column - 1) : ($current_column + 1);
		if (($new_col >= 1 && $action == 'move_left') || ($new_col <= MAX_CP_COLUMNS && $action == 'move_right')) {
			$sql = "select max(row_id) as max_row from " . TABLE_USERS_PROFILES . " 
				where user_id = " . $_SESSION['admin_id'] . " and page_id = '" . $module . "' and column_id = '" . $new_col . "'";
			$result = $db->Execute($sql);
			$new_max_row = $result->fields['max_row'] + 1;
			$sql = "update  " . TABLE_USERS_PROFILES . " set column_id = " . $new_col . ", row_id = " . $new_max_row . " 
				where user_id = " . $_SESSION['admin_id'] . " and page_id = '" . $module . "' and module_id = '" . $module_id . "'";
			$db->Execute($sql);
			$sql = "update  " . TABLE_USERS_PROFILES . " set row_id = row_id - 1 
				where user_id = " . $_SESSION['admin_id'] . " and page_id = '" . $module . "' 
				and column_id = " . $current_column . " and row_id >= '" . $current_row . "'";
			$db->Execute($sql);
		}
		break;
	default:
}

// prepare to display template
$cp_boxes = $db->Execute("select * from " . TABLE_USERS_PROFILES . " 
	where user_id = " . $_SESSION['admin_id'] . " and page_id = '" . $module . "' order by column_id, row_id");
define('PAGE_TITLE', COMPANY_NAME . ' - ' . TITLE);
$include_header = true;
$include_footer = true;

?>