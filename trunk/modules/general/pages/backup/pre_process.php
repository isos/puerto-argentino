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
//  Path: /modules/general/pages/backup/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_BACKUP];
if ($security_level < 2) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/admin_tools.php');
require(DIR_FS_MODULES . 'install/functions/install.php');

/**************   page specific initialization  *************************/
$action = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

$error = false;

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/general/backup/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
  	$conv_type  = $_POST['conv_type'];
	$dl_type    = $_POST['dl_type'];
	$save_local = (isset($_POST['save_local'])) ? true : false;
	// set execution time limit to a large number to allow extra time 
	if (ini_get('max_execution_time') < 20000) set_time_limit(20000);
	// dump db
	$dest_dir           = DIR_FS_MY_FILES . 'backups/';
	$company_dir        = DIR_FS_MY_FILES . $_SESSION['company'] . '/';
	$compressed_dbname  = 'db-' . $_SESSION['company'] . '-' . date('Ymd');
	$compressed_dirname = 'bu-' . $_SESSION['company'] . '-' . date('Ymd');
	$db_filename        = $compressed_dbname . '.sql';
	$db_temp_full_path  = $company_dir . $db_filename;
	$db_save_full_path  = $dest_dir .    $db_filename;
	if (!is_dir($dest_dir)) mkdir($dest_dir);
	if (!$result = dump_db_table($db, 'all', $db_save_full_path, 'both')) break;
	// compress the company directory
	unset($output);
	switch ($conv_type) {
	  case 'bz2':
		$backup_mime = 'application/x-tar';
		if ($dl_type == 'db') {
			$backup_filename = $db_filename . '.bz2';
			exec("cd $dest_dir; nice -n 19 bzip2 -k $db_filename 2>&1", $output, $res);
		} else { // compress all
			$backup_filename = $compressed_dirname . '.tar.bz2';
			exec("cp $db_save_full_path $db_temp_full_path", $output, $res);
			exec("cd $dest_dir; nice -n 19 tar -jcf $compressed_dirname.tar.bz2 $company_dir 2>&1", $output, $res);
		}
		if ($res > 0) {
			$messageStack->add(ERROR_COMPRESSION_FAILED . implode(": ", $output), 'error');
			$error = true;
		}
		break;
	  case 'zip':
		$backup_mime = 'application/zip';
		if (!class_exists('ZipArchive')) {
		  $messageStack->add(GEN_BACKUP_NO_ZIP_CLASS,'error');
		  $error = true;
		  break;
		}
		$zip = new ZipArchive;
		$backup_filename = ($dl_type == 'db') ? $compressed_dbname . '.zip' : $compressed_dirname . '.zip';
		$res = $zip->open($dest_dir . $backup_filename, ZipArchive::CREATE);
		if ($res !== true) {
		  $messageStack->add(GEN_BACKUP_FILE_ERROR . $dest_dir, 'error');
		  $error = true;
		  break;
		}
		if ($dl_type == 'db') {
			$zip->addFile($db_save_full_path);
//			exec("cd $dest_dir; zip $compressed_dbname.zip $db_filename 2>&1", $output, $res);
		} else { // compress all
			$result = @rename($db_save_full_path, $db_temp_full_path); // move the sql file to the company directory to include in backup
			if ($result === false) {
			  $messageStack->add(sprintf(GEN_BACKUP_MOVE_ERROR, $db_temp_full_path), 'error');
		      $error = true;
			} else {
			  addFolderToZip($company_dir, $zip);
//			  exec("cp $db_save_full_path $db_temp_full_path", $output, $res);
//			  exec("cd " . DIR_FS_MY_FILES . "; zip -r $dest_dir/$compressed_dirname.zip " . $_SESSION['company'] . " 2>&1", $output, $res);
			}
		}
		$zip->close();
		if (file_exists($db_save_full_path)) unlink($db_save_full_path);
		if (file_exists($db_temp_full_path)) unlink($db_temp_full_path);
		break;
	  default: // No compression (db only)
		$backup_filename = $db_filename;
		break;
	}

	if (!$error) {
	  gen_add_audit_log(GEN_DB_DATA_BACKUP);
	  // download file and exit script
	  $file_name = $dest_dir . $backup_filename;
	  $handle = fopen($file_name, "rb");
	  $contents = fread($handle, filesize($file_name));
	  fclose($handle);
	  // clean up 
	  if (!$save_local) unlink($file_name); // delete file unless selected to save

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
  default:
}

/*****************   prepare to display templates  *************************/
$include_header   = true;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = false;

switch ($action) {
  case 'restore':
    $custom_html      = true;
    $include_template = 'template_restore.php';
    define('PAGE_TITLE', BOX_HEADING_RESTORE);
    break;
  case 'save':
  default:
    $include_template = 'template_main.php';
    define('PAGE_TITLE', BOX_HEADING_BACKUP);
	break;
}

?>