<?php
/*** CONFIGURACION DEL SCRIPT ***/

	/** CONFIGURACION IMPORTANTE **/
	$base_dir = "/datos/workspaces/phpworkspace/KioscoHugo/";
   	$company = "phreebooks2";
	$database = "phreebooks2";

	
/*****FIN DE LA CONFIGURACION*******/
  $save_local = true;
set_include_path($base_dir);

define(DIR_FS_WORKING,$base_dir."modules/general/");
define(DIR_FS_MY_FILES,$base_dir."my_files/");
define(DIR_FS_MODULES,$base_dir."modules/");

chdir($base_dir);
require("includes/application_top.php");
require("includes/configure.php");
require("includes/addons/PHPMailer/class.phpmailer.php");

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $lang . '/language.php');
require(DIR_FS_WORKING . 'language/' . $lang . '/admin_tools.php');

require(DIR_FS_MODULES . 'install/functions/install.php');


/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/general/backup/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }
	

	// set execution time limit to a large number to allow extra time 
	if (ini_get('max_execution_time') < 20000) set_time_limit(20000);

	// dump db
	require(DIR_FS_WORKING . 'functions/database.php');
        // Load queryFactory db classes
    require(DIR_FS_WORKING. 'classes/db/mysql/query_factory.php');
	require(DIR_FS_MY_FILES . $company. '/config.php');
	$db = new queryFactory();
    $db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, $database);
        
	$dest_dir           = DIR_FS_MY_FILES . 'backups/';
	$company_dir        = DIR_FS_MY_FILES . $company. '/';
	$compressed_dbname  = 'db-' . $company . '-' . date('Ymd');
	$compressed_dirname = 'bu-' . $company . '-' . date('Ymd');
	$db_filename        = $compressed_dbname . '.sql';
	$db_temp_full_path  = $company_dir . $db_filename;
	$db_save_full_path  = $dest_dir .    $db_filename;
	if (!is_dir($dest_dir)) mkdir($dest_dir);

	/***  PARA HACER EL DUMP, usamos directamente mysqldump**********/
    	    
        $command = "mysqldump --opt -h ".DB_SERVER." -u".DB_SERVER_USERNAME." -p".DB_SERVER_PASSWORD." ".$database." > ".$dest_dir.$db_filename;
        
        system($command);
	/************/
        
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


/*****ENVIO EL CORREO A LA DIRECCION $mailto*****/
	 $mail = new PHPMailer(true);
 	 $mail->addAddress($mailto,$mailto_name);
	 $mail->Subject = $mailto_subject;
	 $mail->SetFrom($mailto,$mailto_name);
	 $mail->AddAttachment($file_name);
	 $mail->AltBody=$mailto_body;
	 $mail->MsgHTML('<h2>'.$mailto_body.'</h2>');

	 $mail->IsSMTP();
	 $mail->Host = $smtp_host;
	 $mail->SMTPAuth = true;
	 $mail->Username = $smtp_username;
	 $mail->Password = $smtp_password;


	 $mail->Send();

/*	  $file_size = strlen($contents);
	  header("Content-type: $backup_mime");
	  header("Content-disposition: attachment; filename=" . $backup_filename . "; size=" . $file_size);
	  header('Pragma: cache');
	  header('Cache-Control: public, must-revalidate, max-age=0');
	  header('Connection: close');
	  header('Expires: ' . date('r', time() + 60 * 60));
	  header('Last-Modified: ' . date('r', time()));
	  print $contents;
	  exit();  */
  }


?>
