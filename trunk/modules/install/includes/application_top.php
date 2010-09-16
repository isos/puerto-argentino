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
//  Path: /modules/install/includes/application_top.php
//

// set the level of error reporting
  error_reporting(E_ALL & ~E_NOTICE);

  define('PAGE_PARSE_START_TIME', microtime());
  define('PAGE_EXECUTION_START_TIME', microtime(true));

// define the project version
//  require('version.php');
// set php_self in the local scope
  if (!isset($PHP_SELF)) $PHP_SELF = $_SERVER['PHP_SELF'];
  require('../general/functions/database.php'); // main database functions
  require('../general/functions/gen_functions.php'); // main general functions
  require('../general/functions/validations.php');
  require('../general/functions/password_funcs.php');
  require('../general/classes/db/mysql/query_factory.php');
  $db = new queryFactory;

  require('functions/install.php');
  require('classes/installer.php');
  $zc_install = new installer;

  define('DIR_WS_INSTALL_TEMPLATE', 'templates/');
  define('DIR_WS_INSTALL_CSS', '../../themes/default/css/');
  define('DIR_WS_INSTALL_IMAGES', '../../themes/default/images/');
  define('DIR_WS_IMAGES','../../themes/default/images/');
  define('DIR_FS_INCLUDES','../../includes/');
  define('DIR_FS_MODULES','../');
  define('DIR_FS_ADMIN','../../');
  define('DIR_FS_MY_FILES',  DIR_FS_ADMIN . 'my_files/');

  $language = 'en_us';
  if  (isset($_GET['language'])) $language = $_GET['language'];
  if (!isset($_GET['language'])) $_GET['language'] = $language;

// initialize the message stack for output messages
  require('classes/boxes.php');
  require('classes/message_stack.php');
  $messageStack = new messageStack;

?>