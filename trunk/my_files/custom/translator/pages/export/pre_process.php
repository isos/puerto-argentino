<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2009 PhreeSoft, LLC                               |
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
//  Path: /modules/translator/pages/main/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_TRANSLATOR_MGT];
if ($security_level == 0) { // not supposed to be here
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require_once(DIR_FS_WORKING . 'language/en_us/language.php');
require_once(DIR_FS_WORKING . 'classes/class.Translator.php');

/**************   page specific initialization  *************************/
// make sure the module is installed
$result = $db->Execute("SHOW TABLES LIKE '" . TABLE_TRANSLATOR_RELEASES . "'");
if ($result->RecordCount() == 0) {
  $messageStack->add_session(TRANSLATOR_MGR_NOT_INSTALLED,'caution');
  gen_redirect(html_href_link(FILENAME_DEFAULT, 'cat=translator&module=admin', 'SSL'));
}

$action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];
$error  = false;

/***************   Act on the action request   *************************/
define('TEMPLATE_DIR',    DIR_FS_WORKING  . 'templates/');
define('STORAGE_DIR',     DIR_FS_MY_FILES . 'translator/storage/');
define('EXPORT_TEMP_DIR', DIR_FS_MY_FILES . 'translator/export_temp/');
define('INSTALL_DIR',     DIR_FS_WORKING);

$translator = new Translator('index', $db);
$replace  = array();

// set some defaults for the toolbar
//$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['delete']['show']   = false;
//$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['print']['show']    = false;

// END OF HEADER
switch ($action) {
  default:
  case 'options':
	$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link('index.php?cat=translator&module=main', '', 'SSL') . '\'"';
	$toolbar->icon_list['save']['show']     = true;
	$toolbar->icon_list['save']['params']   = 'onclick="javascript:document.translator.submit()"';
	$include_template = 'template_options.php';
	$release = $translator->getReleaseData($_GET['id']);
  	break;

  case 'p_export':
    $translator->Export($_POST);
    header('Location:index.php?cat=translator&module=main');
    exit;
}

/*****************   prepare to display templates  *************************/

$include_header   = true;
$include_footer   = false;
$include_calendar = false;
$include_tabs     = false;
//$include_template = 'template_main.php';
define('PAGE_TITLE', BOX_TRANSLATOR_MAINTAIN);

?>
