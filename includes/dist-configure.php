<?php
//
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
//  Path: /includes/dist-configure.php
//

// Define the webserver and path parameters
// Main webserver: eg, http://localhost - should not be empty for productive servers
  define('HTTP_SERVER', 'http://localhost');
// Secure webserver: eg, https://localhost - should not be empty for productive servers
  define('HTTPS_SERVER', 'https://localhost'); // eg, https://localhost 
// secure webserver for admin areas?
  define('ENABLE_SSL_ADMIN', 'false');

// NOTE: be sure to leave the trailing '/' at the end of these lines if you make changes!
// * DIR_WS_* = Webserver directories (virtual/URL)
// these paths are relative to top of your webspace ... (ie: under the public_html or httpdocs folder)
  define('DIR_WS_ADMIN', '/');

// * DIR_FS_* = Filesystem directories (local/physical)
//the following path is a COMPLETE path to your PhreeBooks files. eg: /var/www/vhost/accountname/public_html/app_dir/
  define('DIR_FS_ADMIN', '/');

// define the default language
  define('DEFAULT_LANGUAGE','en_us'); 

// define our database connection
  define('DB_TYPE', 'mysql');
  define('DB_PREFIX', '');

?>