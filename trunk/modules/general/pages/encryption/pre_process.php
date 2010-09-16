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
//  Path: /modules/general/pages/encryption/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_ENCRYPTION];
if ($security_level < 1) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/admin_tools.php'); // holds encryption defines
require(DIR_FS_WORKING . 'functions/general.php');

/**************   page specific initialization  *************************/
$action = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

$error = false;

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/general/encryption/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
    $enc_key = db_prepare_input($_POST['enc_key']);
    $enc_key_confirm = db_prepare_input($_POST['enc_key_confirm']);
	if ($enc_key <> $enc_key_confirm) {
      $error = $messageStack->add(ERROR_WRONG_ENCRYPT_KEY_MATCH,'error');
	} elseif ($enc_key) if (!pw_validate_encrypt($enc_key)) {
      $error = $messageStack->add(ERROR_WRONG_ENCRYPT_KEY,'error');
    }
	if (!$error) {
	  $_SESSION['admin_encrypt'] = $enc_key;
      $messageStack->add(GEN_ENCRYPTION_KEY_SET,'success');
	}
	break;

  case 'encrypt_key':
	if ($security_level < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$old_key =         db_prepare_input($_POST['old_encrypt_key']);
	$new_key =         db_prepare_input($_POST['new_encrypt_key']);
	$new_key_confirm = db_prepare_input($_POST['new_encrypt_confirm']);
    if (ENCRYPTION_VALUE && !pw_validate_password($old_key, ENCRYPTION_VALUE)) {
      $error = true;
      $messageStack->add(ERROR_OLD_ENCRYPT_NOT_CORRECT,'error');
    }
	if (strlen($new_key) < ENTRY_PASSWORD_MIN_LENGTH) {
		$error = true;
		$messageStack->add(ENTRY_PASSWORD_NEW_ERROR, 'error');
	}
	if ($new_key != $new_key_confirm) {
		$error = true;
		$messageStack->add(ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING, 'error');
	}
	if (!$error) {
	  $db->Execute("update " . TABLE_CONFIGURATION . " set configuration_value = '" . pw_encrypt_password($new_key) . "' 
		where configuration_key = 'ENCRYPTION_VALUE'");
      $messageStack->add(GEN_ENCRYPTION_KEY_CHANGED,'success');
	}
    break;

  default:
}

/*****************   prepare to display templates  *************************/
$include_header = true; // include header flag
$include_footer = true; // include footer flag
$include_tabs = false;
$include_calendar = false;

$include_template = 'template_main.php'; // include display template (required)
define('PAGE_TITLE', BOX_HEADING_ENCRYPTION);
?>