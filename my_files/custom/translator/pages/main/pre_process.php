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
define('UPLOAD_DIR',      DIR_FS_MY_FILES);
define('STORAGE_DIR',     DIR_FS_MY_FILES . 'translator/storage/');
define('INSTALL_TEMP_DIR',DIR_FS_MY_FILES . 'translator/install_temp/');
define('INSTALL_DIR',     DIR_FS_WORKING);

$translator = new Translator('index', $db);
$replace  = array();

// set some defaults for the toolbar
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['delete']['params'] = '';
$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['print']['show']    = false;
// END OF HEADER

switch ($action) {
  default:
  case '':
	if ($security_level > 1) $toolbar->add_icon('new', 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=new', 'SSL') . '\'"', $order = 10);
	$include_template = 'template_releases.php';
	break;

  case 'new':
	$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=releases', 'SSL') . '\'"';
	$include_template = 'template_installable.php';
    $files = $translator->getInstallableReleases();
	break;

  case 'install_options':
	$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=new', 'SSL') . '\'"';
	$toolbar->icon_list['save']['show']     = true;
	$toolbar->icon_list['save']['params']   = 'onclick="javascript:document.translator.submit()"';
	$include_template = 'template_install_step1.php';
	break;

  case 'p_install_options':
	$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=new', 'SSL') . '\'"';
	$toolbar->icon_list['save']['show']     = true;
	$toolbar->icon_list['save']['params']   = 'onclick="javascript:document.translator.submit()"';
	$include_template = 'template_install_step2.php';
	//save post data
	$_SESSION['release_options']['title'] = $_POST['title'];
	$_SESSION['release_options']['source_lang'] = $_POST['source_lang'];
	$_SESSION['release_options']['destination_lang'] = $_POST['destination_lang'];
	$_SESSION['release_options']['translated_only'] = $_POST['translated_only'];
	$_SESSION['release_options']['description'] = $_POST['description'];
	$_SESSION['translation_modules'] = Array();
	if ($_POST['id'] != 'current_installation')
	{
	  $translator->extractRelease($_POST['id']);
	  $temproot = $translator->getTempRoot();
	}
	else
	  $temproot = $translator->getTempRoot(true);
	  
	$translator->searchModules($temproot,$_POST['source_lang']);
	break;

  case 'p_install':
    $translator->addRelease($_POST);
    if($_POST['id'] != 'current_installation')
		$translator->delete_directory(INSTALL_TEMP_DIR.session_id());
    header('Location:index.php?cat=translator&module=main');
    exit;

  case 'mod';
	$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=releases', 'SSL') . '\'"';
	$toolbar->icon_list['save']['show']     = true;
	$toolbar->icon_list['save']['params']   = 'onclick="javascript:document.translator.submit()"';
	$toolbar->icon_list['delete']['params'] = 'onclick="document.translator.action.value=\'p_delete\'; document.translator.submit()"';
	$toolbar->icon_list['delete']['show']   = true;
	$include_template = 'template_mod.php';
    $release = $translator->getReleaseData($_GET['id']);
	break;

  case 'p_mod':
    $translator->updateRelease($_POST);
    header('Location:index.php?cat=translator&module=main');
    exit;

  case 'p_delete':
	if(strstr($_POST['remove'],'m_') !== false)
	{
	  $id = str_replace('m_','',$_POST['remove']);
	  //exit;
	  $translator->deleteLangModule($id);
	}
	else if(strstr($_POST['remove'],'f_') !== false)
	{
	  $id = str_replace('f_','',$_POST['remove']);
	  $translator->deleteLangFile($id);
	}

	header('Location:index.php?cat=translator&module=main&action=mod&id='.$_POST['id']);
	exit;

  case 'installable_delete':
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
