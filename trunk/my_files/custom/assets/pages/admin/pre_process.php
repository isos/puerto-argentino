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
//  Path: /modules/assets/pages/admin/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ASSET_MGT_ADMIN];
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
	// first, create the directories
	//must be done before our main function includes are called.  (no trailing slashes)
	$base_path = DIR_FS_MY_FILES . $_SESSION['company'] . '/assets';
	mkdir($basepath);
	mkdir($basepath . '/images');

	// load the database
	require(DIR_FS_WORKING . 'scripts/install_sql.php');
	foreach($tables as $create_table_sql) if (!$db->Execute($create_table_sql)) $error = true;
//	foreach($extra_sqls as $extra_sql) if (!$db->Execute($extra_sql)) $error = true;
	if ($error) $messagStack->add(ASSETS_ERROR_INSTALL_MSG,'error');
	break;
  case 'remove';
    break;
  default:
}

/*****************   prepare to display templates  *************************/
$result = $db->Execute("SHOW TABLES LIKE '" . TABLE_ASSETS . "'");
if ($result->RecordCount() == 0) $install_doc_mgr = true;

$include_header = true; // include header flag
$include_footer = true; // include footer flag
$include_tabs = false;
$include_calendar = false;

$include_template = 'template_main.php';
define('PAGE_TITLE', BOX_ASSET_MODULE_ADM);
?>