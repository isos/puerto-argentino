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
//  Path: /modules/install/pages/database_setup/header_php.php
//

$zc_show_progress='yes';

  $zc_install->error = false;
  $zc_install->fatal_error = false;
  $zc_install->error_list = array();

  if (isset($_POST['submit'])) {
    if ($_POST['db_type'] != 'mysql') $_POST['db_prefix'] = '';  // if not using mysql, don't support prefixes
    $zc_install->noDots($_POST['db_prefix'], ERROR_TEXT_DB_PREFIX_NODOTS, ERROR_CODE_DB_PREFIX_NODOTS);
    $zc_install->isEmpty($_POST['db_host'], ERROR_TEXT_DB_HOST_ISEMPTY, ERROR_CODE_DB_HOST_ISEMPTY);
    $zc_install->isEmpty($_POST['db_username'], ERROR_TEXT_DB_USERNAME_ISEMPTY, ERROR_CODE_DB_USERNAME_ISEMPTY);
    $zc_install->isEmpty($_POST['db_name'], ERROR_TEXT_DB_NAME_ISEMPTY, ERROR_CODE_DB_NAME_ISEMPTY);
    $zc_install->fileExists('sql/current/tables.sql', ERROR_TEXT_DB_SQL_NOTEXIST, ERROR_CODE_DB_SQL_NOTEXIST);
    $zc_install->functionExists($_POST['db_type'], ERROR_TEXT_DB_NOTSUPPORTED, ERROR_CODE_DB_NOTSUPPORTED);
    $zc_install->dbConnect($_POST['db_type'], $_POST['db_host'], $_POST['db_name'], $_POST['db_username'], $_POST['db_pass'], ERROR_TEXT_DB_CONNECTION_FAILED, ERROR_CODE_DB_CONNECTION_FAILED,ERROR_TEXT_DB_NOTEXIST, ERROR_CODE_DB_NOTEXIST);
    $zc_install->dbExists(false, $_POST['db_type'], $_POST['db_host'], $_POST['db_username'], $_POST['db_pass'], $_POST['db_name'], ERROR_TEXT_DB_NOTEXIST, ERROR_CODE_DB_NOTEXIST);

    if (!$zc_install->error) {
      $virtual_http_path = parse_url($_GET['virtual_http_path']);
      $http_server = $virtual_http_path['scheme'] . '://' . $virtual_http_path['host'];
      $http_catalog = $virtual_http_path['path'];
      if (isset($virtual_http_path['port']) && !empty($virtual_http_path['port'])) {
        $http_server .= ':' . $virtual_http_path['port'];
      }
      if (substr($http_catalog, -1) != '/') {
        $http_catalog .= '/';
      }
      $https_server = $_GET['virtual_https_server'];
      $https_catalog = $_GET['virtual_https_path'];

      //if the https:// entries were left blank, use catalog versions
      if ($https_server=='' || $https_server=='https://') $https_server = $http_server;

      $db->Connect($_POST['db_host'], $_POST['db_username'], $_POST['db_pass'], $_POST['db_name'], true);

      // On to a fresh install...
      // check for the table users and block install if exists
	  $sql = "show tables like '" . $_POST['db_prefix'] . "users'";
	  $result = $db->Execute($sql);
	  if ($result->RecordCount() > 0) {
        $zc_install->setError(ERROR_TEXT_DB_EXISTS, ERROR_CODE_DB_EXISTS, true);
	  }

      //now let's write the files
      if (!$zc_install->fatal_error) {
	    require('includes/admin_configure.php');
        $fp = fopen($_GET['physical_path'] . '/includes/configure.php', 'w');
        fputs($fp, $file_contents);
        fclose($fp);
        @chmod($_GET['physical_path'] . '/includes/configure.php', 0644);

        // test whether the files were written successfully
        $ztst_http_server = install_read_config_value('HTTP_SERVER');
        if ($ztst_http_server != $http_server) {
          $zc_install->setError(ERROR_TEXT_COULD_NOT_WRITE_CONFIGURE_FILES, ERROR_CODE_COULD_NOT_WRITE_CONFIGURE_FILES, true);
        }
	  }

      if (!$zc_install->fatal_error) { // load the fresh database
		 session_start();
		 $_SESSION['company']   = $_POST['db_name'];     // save the company name as a session variable as if logged in
		 $_SESSION['db_server'] = $_POST['db_host'];     // save the db server as a session variable as if logged in
		 $_SESSION['db_user']   = $_POST['db_username']; // save the db user as a session variable as if logged in
		 $_SESSION['db_pw']     = $_POST['db_pass'];     // save the db pw as a session variable as if logged in		 
         //OK, files written -- now let's connect to the database and load the tables:
         if ($zc_show_progress == 'yes') {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PhreeBooks&trade; Installer</title>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_INSTALL_CSS; ?>stylesheet.css">
</head>
<div id="wrap">
  <div id="header"><img src="<?php echo DIR_WS_INSTALL_IMAGES; ?>phreebooks_logo.png" height="80"></div>
  <div class="progress" align="center">Installation In Progress...<br /><br />
<?php
         }
		 // create the database tables
         db_executeSql('sql/current/tables.sql', $_POST['db_name'], $_POST['db_prefix']);
		 // populate the necessary table data
         require('../../includes/database_tables.php');
		 load_startup_table_data($language = $_GET['language']);

         $db->Close();
		 // Create the directory and subdirectories to store company data
		 define('DIR_FS_MY_FILES','../../my_files/');
		 install_build_dirs($_POST['db_name'], false);

         // done - now onto next page for Store Setup (entries into database)

         if ($zc_show_progress == 'yes') {
           $linkto = 'index.php?main_page=admin_setup&language=' . $language;
           $link = '<a href="' . $linkto . '">' . '<br /><br />Done!<br />Click Here To Continue<br /><br />' . '</a>';
           echo "\n<script type=\"text/javascript\">\nwindow.location=\"$linkto\";\n</script>\n";
           echo '<noscript>'.$link.'</noscript><br /><br />';
           echo '<div id="footer"><p>Copyright &copy; ' . date('Y', time()) . '<a href="http://www.PhreeSoft.com" target="_blank">PhreeSoft</a></p></div></div></body></html>';
         }
         header('location: index.php?main_page=admin_setup&language=' . $language);
         exit;
      }
    }
  }

  $zdb_type       = 'MySQL';
  $zdb_prefix     = '';
  $zdb_server     = 'localhost';
  $zdb_user       = 'root';
  $zdb_name       = 'mycompany';

  if (!isset($_POST['db_host']))     $_POST['db_host']    = $zdb_server;
  if (!isset($_POST['db_username'])) $_POST['db_username']= $zdb_user;
  if (!isset($_POST['db_name']))     $_POST['db_name']    = $zdb_name;
  if (!isset($_POST['db_prefix']))   $_POST['db_prefix']  = $zdb_prefix;
  if (!isset($_POST['db_type']))     $_POST['db_type']    = $zdb_type;

  setInputValue($_POST['db_host'],    'DATABASE_HOST_VALUE', $zdb_server);
  setInputValue($_POST['db_username'],'DATABASE_USERNAME_VALUE', $zdb_user);
  setInputValue($_POST['db_name'],    'DATABASE_NAME_VALUE', $zdb_name);
  setInputValue($_POST['db_prefix'],  'DATABASE_NAME_PREFIX', $zdb_prefix );
?>