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
//  Path: /modules/install/pages/system_setup/header_php.php
//

  // Determine Document Root
  $script_filename = $_SERVER['PATH_TRANSLATED'];
  if (empty($script_filename)) {
    $script_filename = $_SERVER['SCRIPT_FILENAME'];
  }
  $script_filename = str_replace(array('\\','//'), '/', $script_filename);

  $dir_fs_www_root_array = explode('/', dirname($script_filename));
  $dir_fs_www_root = array();
  for ($i=0, $n=sizeof($dir_fs_www_root_array)-2; $i<$n; $i++) {
    $dir_fs_www_root[] = $dir_fs_www_root_array[$i];
  }
  $dir_fs_www_root = implode('/', $dir_fs_www_root);

  // Determine http path
  $virtual_path = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
  $virtual_path = substr($virtual_path, 0, strpos($virtual_path, '/modules/install'));

  // Determine the https directory.  This is a best-guess since we're not likely installing over SSL connection:
  $virtual_https_server = getenv('HTTP_HOST');
  $virtual_https_path = $virtual_path;

  // Set form input values
  if (!isset($_POST['physical_path'])) $_POST['physical_path']=$dir_fs_www_root;
  if (!isset($_POST['virtual_http_path'])) $_POST['virtual_http_path']= 'http://' . $virtual_path;
  if (!isset($_POST['virtual_https_path'])) $_POST['virtual_https_path']='https://' . $virtual_https_path;
  if (!isset($_POST['virtual_https_server'])) $_POST['virtual_https_server']='https://' . $virtual_https_server;
  if (!isset($_POST['enable_ssl'])) $_POST['enable_ssl']=$enable_ssl;
  
  setInputValue($_POST['physical_path'], 'PHYSICAL_PATH_VALUE', $dir_fs_www_root);
  setInputValue($_POST['virtual_http_path'], 'VIRTUAL_HTTP_PATH_VALUE', 'http://' . $virtual_path);
  setInputValue($_POST['virtual_https_path'], 'VIRTUAL_HTTPS_PATH_VALUE', 'https://' . $virtual_https_path);
  setInputValue($_POST['virtual_https_server'], 'VIRTUAL_HTTPS_SERVER_VALUE', 'https://' . $virtual_https_server);
  setRadioChecked($_POST['enable_ssl'], 'ENABLE_SSL', $enable_ssl);

  $zc_install->error = false;
  $zc_install->fatal_error = false;
  $zc_install->error_list = array();
  
  if (isset($_POST['submit'])) {
    $zc_install->isEmpty($_POST['physical_path'], ERROR_TEXT_PHYSICAL_PATH_ISEMPTY, ERROR_CODE_PHYSICAL_PATH_ISEMPTY);
    $zc_install->fileExists($_POST['physical_path'], ERROR_TEXT_PHYSICAL_PATH_INCORRECT, ERROR_CODE_PHYSICAL_PATH_INCORRECT);  
    $zc_install->isEmpty($_POST['virtual_http_path'], ERROR_TEXT_VIRTUAL_HTTP_ISEMPTY, ERROR_CODE_VIRTUAL_HTTP_ISEMPTY);
    if ($_POST['enable_ssl'] == 'true') {
      $zc_install->isEmpty($_POST['virtual_https_path'], ERROR_TEXT_VIRTUAL_HTTPS_ISEMPTY, ERROR_CODE_VIRTUAL_HTTPS_ISEMPTY);
      $zc_install->isEmpty($_POST['virtual_https_server'], ERROR_TEXT_VIRTUAL_HTTPS_SERVER_ISEMPTY, ERROR_CODE_VIRTUAL_HTTPS_SERVER_ISEMPTY);
    }

    if (!$zc_install->fatal_error) {
      header('location: index.php?main_page=database_setup&language=' . $language . '&physical_path='.$_POST['physical_path'].'&virtual_http_path='.$_POST['virtual_http_path'].'&virtual_https_path='.$_POST['virtual_https_path'].'&virtual_https_server='.$_POST['virtual_https_server'].'&enable_ssl='.$_POST['enable_ssl']);
    exit;
    }
  }
?>