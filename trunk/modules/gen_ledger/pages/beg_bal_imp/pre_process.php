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
//  Path: /modules/gen_ledger/pages/beg_bal_imp/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_GL_UTILITIES];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');

require(DIR_FS_MODULES . 'accounts/language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'gen_ledger/language/' . $_SESSION['language'] . '/language.php');

require(DIR_FS_WORKING . 'classes/gen_ledger.php');
require(DIR_FS_WORKING . 'classes/beg_balances_imp.php');

/**************   page specific initialization  *************************/
if (isset($_POST['import_inv'])) {
	$action = 'import_inv';
	$upload_name = 'file_name_inv';
	define('JOURNAL_ID',0);
} elseif (isset($_POST['import_po'])) {
	$action = 'import_po';
	$upload_name = 'file_name_po';
	define('JOURNAL_ID',4);
	define('DEF_INV_GL_ACCT',AP_DEFAULT_INVENTORY_ACCOUNT);
	define('BB_ACCOUNT_TYPE','v');
	define('BB_GL_TYPE','poo');
} elseif (isset($_POST['import_ap'])) {
	$action = 'import_ap';
	$upload_name = 'file_name_ap';
	define('JOURNAL_ID',6);
	define('DEF_INV_GL_ACCT',AP_DEFAULT_INVENTORY_ACCOUNT);
	define('BB_ACCOUNT_TYPE','v');
	define('BB_GL_TYPE','por');
} elseif (isset($_POST['import_so'])) {
	$action = 'import_so';
	$upload_name = 'file_name_so';
	define('JOURNAL_ID',10);
	define('DEF_INV_GL_ACCT',AR_DEFAULT_INVENTORY_ACCOUNT);
	define('BB_ACCOUNT_TYPE','c');
	define('BB_GL_TYPE','soo');
} elseif (isset($_POST['import_ar'])) {
	$action = 'import_ar';
	$upload_name = 'file_name_ar';
	define('JOURNAL_ID',12);
	define('DEF_INV_GL_ACCT',AR_DEFAULT_INVENTORY_ACCOUNT);
	define('BB_ACCOUNT_TYPE','c');
	define('BB_GL_TYPE','sos');
} else {
	define('JOURNAL_ID',0);
	$action = '';
	$upload_name = '';
}

define('BB_IMPORT_MSG',constant('GENERAL_JOURNAL_' . JOURNAL_ID . '_DESC'));

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/gen_ledger/beg_bal_imp/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
if ($action) {
	if ($security_level < 3) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
	}
	// preload the chart of accounts
	$error = false;
	$result = $db->Execute("select id from " . TABLE_CHART_OF_ACCOUNTS);
	$coa = array();
	while (!$result->EOF) {
		$coa[] = $result->fields['id'];
		$result->MoveNext();
	}
	$result = $db->Execute("select start_date from " . TABLE_ACCOUNTING_PERIODS . " where period = 1");
	$first_date = $result->fields['start_date'];

	// first verify the file was uploaded ok
	if (!validate_upload($upload_name, 'text', 'csv')) {
	  $action = '';
	  $error = true;
	}
	$so_po = new beg_bal_import();
	switch ($action) {
		case 'import_inv':
			if (!$so_po->processInventory($upload_name)) $error = true;
			break;
		case 'import_po':
			if (!$so_po->processCSV($upload_name)) $error = true;
			break;
		case 'import_ap':
			if (!$so_po->processCSV($upload_name)) $error = true;
			break;
		case 'import_so':
			if (!$so_po->processCSV($upload_name)) $error = true;
			break;
		case 'import_ar':
			if (!$so_po->processCSV($upload_name)) $error = true;
			break;
		default:
	} // end switch
	if ($error) {
		$messageStack->add(GL_ERROR_NO_POST, 'error');
	} else {
		$messageStack->add_session(constant('GL_MSG_IMPORT_' . JOURNAL_ID . '_SUCCESS') . $so_po->line_count,'success');
		gen_add_audit_log(constant('GL_MSG_IMPORT_' . JOURNAL_ID), $so_po->line_count);
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
	}
}

/*****************   prepare to display templates  *************************/

$include_header = true; // include header flag
$include_footer = true; // include footer flag
$include_tabs = false;
$include_calendar = false;

$include_template = 'template_main.php'; // include display template (required)
define('PAGE_TITLE', GL_HEADING_IMPORT_BEG_BALANCES);

?>