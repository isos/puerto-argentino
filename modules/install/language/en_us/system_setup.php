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
//  Path: /modules/install/language/en_us/system_setup.php
//

  define('SAVE_SYSTEM_SETTINGS', 'Save System Settings'); //this comes before TEXT_MAIN
  define('TEXT_MAIN', "We will now setup the PhreeBooks&trade; System environment.  Please carefully review each setting, and change if necessary to suit your directory layout. Then click on <em>".SAVE_SYSTEM_SETTINGS.'</em> to continue.');
  define('TEXT_PAGE_HEADING', 'PhreeBooks&trade; Setup - System Setup');
  define('SERVER_SETTINGS', 'Server Settings');
  define('PHYSICAL_PATH', 'Physical Path');
  define('PHYSICAL_PATH_INSTRUCTION', 'Physical Path to your<br />PhreeBooks directory.<br />Leave no trailing slash.');
  define('VIRTUAL_HTTP_PATH', 'Virtual HTTP Path');
  define('VIRTUAL_HTTP_PATH_INSTRUCTION', 'Virtual Path to your<br />PhreeBooks directory.<br />Leave no trailing slash.');
  define('VIRTUAL_HTTPS_PATH', 'Virtual HTTPS Path');
  define('VIRTUAL_HTTPS_PATH_INSTRUCTION', 'Virtual Path to your<br />secure PhreeBooks directory.<br />Leave no trailing slash.');
  define('VIRTUAL_HTTPS_SERVER', 'Virtual HTTPS Server');
  define('VIRTUAL_HTTPS_SERVER_INSTRUCTION', 'Virtual server for your<br />secure PhreeBooks directory.<br />Leave no trailing slash.');
  define('ENABLE_SSL', 'Enable SSL');
  define('ENABLE_SSL_INSTRUCTION', 'Would you like to enable Secure Sockets Layer?<br />Leave this set to NO unless you\'re SURE you have SSL working.');
?>