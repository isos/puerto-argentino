<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2007-2008 PhreeSoft, LLC                          |
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
//  Path: /modules/rma/pages/admin/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_RMA_MGT_ADMIN];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');

/**************   page specific initialization  *************************/
if (isset($_POST['install'])) $action = 'install';
if (isset($_POST['remove'])) $action = 'remove';

$error = false; 
/***************   Act on the action request   *************************/
switch ($action) {
  case 'install':
	if ($security_level < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
	}
	// load the database
	require(DIR_FS_WORKING . 'scripts/install_sql.php');
	if (is_array($tables)) foreach ($tables as $create_table_sql) if (!$db->Execute($create_table_sql)) $error = true;
	if (is_array($extra_sqls)) foreach ($extra_sqls as $extra_sql) if (!$db->Execute($extra_sql)) $error = true;
	// add a current status field for the RMA number
	$fields = mysql_list_fields(DB_DATABASE, TABLE_CURRENT_STATUS);
	$columns = mysql_num_fields($fields);
	$field_array = array();
	for ($i = 0; $i < $columns; $i++) $field_array[] = mysql_field_name($fields, $i);
	if (!in_array('next_rma_num', $field_array)) {
	  $db->Execute("ALTER TABLE " . TABLE_CURRENT_STATUS . " ADD next_rma_num VARCHAR( 16 ) NOT NULL DEFAULT 'RMA1000';");
	}

	if ($error) $messagStack->add(RMAS_ERROR_INSTALL_MSG,'error');
	break;
  case 'remove';
	if ($security_level < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
	}
	// remove the database tables
	$db->Execute("DROP TABLE " .  TABLE_RMA);
	$db->Execute("DROP TABLE " .  TABLE_RMA_ITEM);
	$messagStack->add(RMAS_ERROR_DELETE_MSG,'success');
    break;
  default:
}

/*****************   prepare to display templates  *************************/
$result = $db->Execute("SHOW TABLES LIKE '" . TABLE_RMA . "'");
if ($result->RecordCount() == 0) $install_rma_module = true;

$include_header   = true;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = false;
$include_template = 'template_main.php';
define('PAGE_TITLE', BOX_RMA_MODULE_ADM);

?>