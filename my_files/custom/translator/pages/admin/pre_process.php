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
//  Path: /modules/translator/pages/admin/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_TRANSLATOR_MGT_ADMIN];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/en_us/language.php');

/**************   page specific initialization  *************************/
if (isset($_POST['install'])) $action = 'install';
if (isset($_POST['remove']))  $action = 'remove';

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
	if (is_array($tables))     foreach ($tables as $create_table_sql) if (!$db->Execute($create_table_sql)) $error = true;
	if (is_array($extra_sqls)) foreach ($extra_sqls as $extra_sql)    if (!$db->Execute($extra_sql))        $error = true;
	@mkdir(DIR_FS_MY_FILES . 'translator');
	@mkdir(DIR_FS_MY_FILES . 'translator/install');
	@mkdir(DIR_FS_MY_FILES . 'translator/storage');
	@mkdir(DIR_FS_MY_FILES . 'translator/install_temp');
	@mkdir(DIR_FS_MY_FILES . 'translator/export_temp');

	if ($error) $messageStack->add(RMAS_ERROR_INSTALL_MSG,'error');
	gen_redirect(html_href_link(FILENAME_DEFAULT, 'cat=translator&module=main', 'SSL'));
	break;
  case 'remove';
	if ($security_level < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
	}
	// remove the database tables
	$db->Execute("DROP TABLE " . TABLE_TRANSLATOR_FILES);
	$db->Execute("DROP TABLE " . TABLE_TRANSLATOR_TRANSLATIONS);
	$db->Execute("DROP TABLE " . TABLE_TRANSLATOR_RELEASES);
	$db->Execute("DROP TABLE " . TABLE_TRANSLATOR_MODULES);
	$messageStack->add(TRANSLATOR_ERROR_DELETE_MSG,'success');
    break;
  default:
}

/*****************   prepare to display templates  *************************/
$result = $db->Execute("SHOW TABLES LIKE '" . TABLE_TRANSLATOR_RELEASES . "'");
if ($result->RecordCount() == 0) $install_trans_module = true;

$include_header   = true;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = false;
$include_template = 'template_main.php';
define('PAGE_TITLE', BOX_TRANSLATOR_MODULE_ADM);

?>
