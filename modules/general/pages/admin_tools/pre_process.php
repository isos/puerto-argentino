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
//  Path: /modules/general/pages/admin_tools/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_GEN_ADMIN_TOOLS];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/admin_tools.php');
require(DIR_FS_MODULES . 'gen_ledger/language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING . 'functions/general.php');
require(DIR_FS_MODULES . 'gen_ledger/classes/gen_ledger.php');

/**************   page specific initialization  *************************/
// determine what button was pressed, if any
$action = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

$start_date = ($_POST['start_date']) ? gen_db_date_short($_POST['start_date']) : CURRENT_ACCOUNTING_PERIOD_START;
$end_date   = ($_POST['end_date'])   ? gen_db_date_short($_POST['end_date'])   : CURRENT_ACCOUNTING_PERIOD_END;

$error = false;
/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/general/admin_tools/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'backup_log':
	require(DIR_FS_MODULES . 'install/functions/install.php');
	if (ini_get('max_execution_time') < 20000) set_time_limit(20000);
	$dest_dir          = DIR_FS_MY_FILES . 'backups/';
	$company_dir       = DIR_FS_MY_FILES . $_SESSION['company'] . '/';
	$compressed_dbname = 'log-' . $_SESSION['company'] . '-' . date('Ymd');
	$db_filename       = $compressed_dbname . '.sql';
	$db_save_full_path = $dest_dir . $db_filename;
	if (!is_dir($dest_dir)) mkdir($dest_dir);
	if (!$result = dump_db_table($db, TABLE_AUDIT_LOG, $db_save_full_path, 'both')) break;
	// compress the company directory
	unset($output);
	$backup_mime = 'application/zip';
	if (!class_exists('ZipArchive')) {
	  $messageStack->add(GEN_BACKUP_NO_ZIP_CLASS,'error');
	  $error = true;
	  break;
	}
	$zip = new ZipArchive;
	$backup_filename = $compressed_dbname . '.zip';
	$res = $zip->open($dest_dir . $backup_filename, ZipArchive::CREATE);
	if ($res !== true) {
	  $messageStack->add(GEN_BACKUP_FILE_ERROR . $dest_dir, 'error');
	  $error = true;
	  break;
	}
	$zip->addFile($db_save_full_path);
	$zip->close();
	if (file_exists($db_save_full_path)) unlink($db_save_full_path);

	if (!$error) {
	  gen_add_audit_log(GEN_AUDIT_DB_DATA_BACKUP);
	  // download file and exit script
	  $file_name = $dest_dir . $backup_filename;
	  $handle = fopen($file_name, "rb");
	  $contents = fread($handle, filesize($file_name));
	  fclose($handle);
	  // clean up 
	  unlink($file_name);
	  $file_size = strlen($contents);
	  header("Content-type: $backup_mime");
	  header("Content-disposition: attachment; filename=" . $backup_filename . "; size=" . $file_size);
	  header('Pragma: cache');
	  header('Cache-Control: public, must-revalidate, max-age=0');
	  header('Connection: close');
	  header('Expires: ' . date('r', time() + 60 * 60));
	  header('Last-Modified: ' . date('r', time()));
	  print $contents;
	  exit();  
	}
    break;

  case 'clean_log':
    $temp = gen_get_dates(date('Y-m-d'));
	$current_date = date('Y-m-d', mktime(0, 0, 0, $temp['ThisMonth'], 1, $temp['ThisYear']));
    $result = $db->Execute("delete from " . TABLE_AUDIT_LOG . " where action_date < '" . $current_date . "'");
    $messageStack->add('The number of records deleted was:' . ' ' . $result->AffectedRows(),'success');
	gen_add_audit_log(GEN_AUDIT_DB_DATA_CLEAN);
	break;

  case 'ordr_nums':
	if ($security_level < 3) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}

	// read in the requested status values
	$sequence_array = array(
	  'next_ar_quote_num' => db_prepare_input($_POST['next_ar_quote_num']),
	  'next_ap_quote_num' => db_prepare_input($_POST['next_ap_quote_num']),
	  'next_deposit_num'  => db_prepare_input($_POST['next_deposit_num']),
	  'next_so_num'       => db_prepare_input($_POST['next_so_num']),
	  'next_po_num'       => db_prepare_input($_POST['next_po_num']),
	  'next_check_num'    => db_prepare_input($_POST['next_check_num']),
	  'next_inv_num'      => db_prepare_input($_POST['next_inv_num']),
	  'next_cm_num'       => db_prepare_input($_POST['next_cm_num']),
	  'next_vcm_num'      => db_prepare_input($_POST['next_vcm_num']),
	  'next_shipment_num' => db_prepare_input($_POST['next_shipment_num']),
	  'next_cust_id_num'  => db_prepare_input($_POST['next_cust_id_num']),
	  'next_vend_id_num'  => db_prepare_input($_POST['next_vend_id_num']),
	);
	// post them to the current_status table
	$result = db_perform(TABLE_CURRENT_STATUS, $sequence_array, 'update', 'id > 0');
	$messageStack->add(GEN_ADM_TOOLS_POST_SEQ_SUCCESS,'success');
	gen_add_audit_log(GEN_ADM_TOOLS_AUDIT_LOG_SEQ);
	break;

  case 'repost':
	if ($security_level < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	// determine which journals were selected to re-post
	$valid_journals = array(2,3,4,6,7,8,9,10,12,13,14,16,18,19,20,21,22);
	$journals = array();
	foreach ($valid_journals as $journal_id) if (isset($_POST['jID_' . $journal_id])) $journals[] = $journal_id;
	$repost_cnt = repost_journals($journals, $start_date, $end_date);
	if ($repost_cnt === false) {
	  $messageStack->add(GEN_ADM_TOOLS_RE_POST_FAILED,'caution');
	} else {
	  $messageStack->add(sprintf(GEN_ADM_TOOLS_RE_POST_SUCCESS, $repost_cnt),'success');
	  gen_add_audit_log(GEN_ADM_TOOLS_AUDIT_LOG_RE_POST, implode(',', $journals));
	}
	if (DEBUG) $messageStack->write_debug();
	break;

  case 'coa_hist_test':
  case 'coa_hist_fix':
	if ($security_level < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$success = validate_gl_balances($action);
    break;

  default:
}

/*****************   prepare to display templates  *************************/
$result = $db->Execute("select * from " . TABLE_CURRENT_STATUS);
$cInfo = new objectInfo($result->fields);

$include_header   = true;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = true;
$include_template = 'template_main.php';
define('PAGE_TITLE', BOX_HEADING_ADMIN_TOOLS);

?>