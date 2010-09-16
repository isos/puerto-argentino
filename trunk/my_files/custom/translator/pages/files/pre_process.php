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

//echo 'POST = '; print_r($_POST); echo '<br>';
//echo 'GET = '; print_r($_GET); echo '<br>';

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
define('INSTALL_DIR',     DIR_FS_WORKING);

$translator = new Translator('index', $db);
$replace  = array();

// set some defaults for the toolbar
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['print']['show']    = false;

// END OF HEADER
switch ($action) {
  default:
  case 'p_files':
  case 'files':
	$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'module=main&action=releases', 'SSL') . '\'"';
	$include_template = 'template_files.php';
    $release = $translator->getReleaseData($_REQUEST['id']);
	$files = $translator->getFilesForRelease($_REQUEST['id'],$_REQUEST['modules']);
	break;

  case 'p_translate':
	$translator->updateTranslationStrings($_POST);
  case 'p_search':
  case 'translate':
	$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'module=files&action=files&id=' . $_REQUEST['release'], 'SSL') . '\'"';
	$toolbar->icon_list['save']['show']     = true;
	$toolbar->icon_list['save']['params']   = 'onclick="javascript:document.translator.submit()"';
	$include_template = 'template_translate.php';
	$translations = $translator->getStringsToTranslateForFile($_REQUEST['id'],$_REQUEST['defined_key'],$_REQUEST['original'],$_REQUEST['translation'],$_REQUEST['translated']);
	break;
}

/*****************   prepare to display templates  *************************/

$include_header   = true;
$include_footer   = false;
$include_calendar = false;
$include_tabs     = false;
define('PAGE_TITLE', BOX_TRANSLATOR_MAINTAIN);

?>
