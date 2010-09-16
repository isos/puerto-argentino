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
//  Path: /modules/install/includes/admin_configure.php
//

$file_contents =
'<'.'?php' . "\n" .
'// +-----------------------------------------------------------------+' . "\n" .
'// |                   PhreeBooks Open Source ERP                    |' . "\n" .
'// +-----------------------------------------------------------------+' . "\n" .
'// | Copyright (c) 2008, 2009, 2010 PhreeSoft, LLC                   |' . "\n" .
'// | http://www.PhreeSoft.com                                        |' . "\n" .
'// +-----------------------------------------------------------------+' . "\n" .
'// | This program is free software: you can redistribute it and/or   |' . "\n" .
'// | modify it under the terms of the GNU General Public License as  |' . "\n" .
'// | published by the Free Software Foundation, either version 3 of  |' . "\n" .
'// | the License, or any later version.                              |' . "\n" .
'// |                                                                 |' . "\n" .
'// | This program is distributed in the hope that it will be useful, |' . "\n" .
'// | but WITHOUT ANY WARRANTY; without even the implied warranty of  |' . "\n" .
'// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the   |' . "\n" .
'// | GNU General Public License for more details.                    |' . "\n" .
'// |                                                                 |' . "\n" .
'// | The license that is bundled with this package is located in the |' . "\n" .
'// | file: /doc/manual/ch01-Introduction/license.html.               |' . "\n" .
'// | If not, see http://www.gnu.org/licenses/                        |' . "\n" .
'// +-----------------------------------------------------------------+' . "\n" .
'//  Path: /includes/configure.php' . "\n" .
'//' . "\n\n" .
'// Define the webserver and path parameters' . "\n" .
'// Main webserver: eg, http://localhost - should not be empty for productive servers' . "\n" .
'  define(\'HTTP_SERVER\', \'' . $http_server . '\');' . "\n" .
'// Secure webserver: eg, https://localhost - should not be empty for productive servers' . "\n" .
'  define(\'HTTPS_SERVER\', \'' . $https_server . '\'); // eg, https://localhost ' . "\n" .
'// secure webserver for admin areas?' . "\n" .
'  define(\'ENABLE_SSL_ADMIN\', \'' . $_GET['enable_ssl'] . '\');' . "\n\n" .
'// NOTE: be sure to leave the trailing \'/\' at the end of these lines if you make changes!' . "\n" .
'// * DIR_WS_* = Webserver directories (virtual/URL)' . "\n" .
'// these paths are relative to top of your webspace ... (ie: under the public_html or httpdocs folder)' . "\n" .
'  define(\'DIR_WS_ADMIN\', \'' . $http_catalog . '\');' . "\n\n" .
'// * DIR_FS_* = Filesystem directories (local/physical)' . "\n" .
'//the following path is a COMPLETE path to your PhreeBooks files. eg: /var/www/vhost/accountname/public_html/app_dir/' . "\n" .
'  define(\'DIR_FS_ADMIN\', \'' . $_GET['physical_path'] . '/\');' . "\n\n" .
'// define the default language' . "\n" .
'  define(\'DEFAULT_LANGUAGE\',\'en_us\');' . "\n\n" .
'// define our database connection' . "\n" .
'  define(\'DB_TYPE\', \'' . $_POST['db_type']. '\');' . "\n" .
'  define(\'DB_PREFIX\', \'' . $_POST['db_prefix']. '\');' . "\n" .
'?' . '>';
?>