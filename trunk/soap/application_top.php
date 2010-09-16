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
//  Path: /soap/application_top.php
//

// Set the level of error reporting
  error_reporting(E_ALL & ~E_NOTICE);

// set php_self in the local scope
  if (!isset($PHP_SELF)) $PHP_SELF = $_SERVER['PHP_SELF'];

// Check for application configuration parameters, may be preloaded in running from a subdirectory, so skip
// currently scripts run from top level (index.php only) and second level, so we only need to check these two levels
  if (!defined('DIR_FS_ADMIN')) {
	  if (file_exists('../includes/configure.php')) {
		require_once('../includes/configure.php');
	  } else {
		die('ERROR: includes/configure.php file not found on PhreeBooks Server.');
	  }
  }

  // load some file system constants
  define('DIR_FS_INCLUDES',  DIR_FS_ADMIN . 'includes/');
  define('DIR_FS_MODULES',   DIR_FS_ADMIN . 'modules/');
  define('DIR_FS_MY_FILES',  DIR_FS_ADMIN . 'my_files/');
  define('DIR_FS_FUNCTIONS', DIR_FS_MODULES . 'general/functions/');
  define('DIR_FS_CLASSES',   DIR_FS_MODULES . 'general/classes/');
  define('FILENAME_DEFAULT', 'index');

// define the inventory types that are tracked in cost of goods sold
  define('COG_ITEM_TYPES','si,sr,ms,mi,as');
  
// set the type of request (secure or not)
  $request_type = (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1' || strstr(strtoupper($_SERVER['HTTP_X_FORWARDED_BY']),'SSL') || strstr(strtoupper($_SERVER['HTTP_X_FORWARDED_HOST']),'SSL'))  ? 'SSL' : 'NONSSL';

// Define how do we update currency exchange rates
// Possible values are 'oanda' 'xe' or ''
  define('CURRENCY_SERVER_BACKUP', 'xe');
  define('CURRENCY_SERVER_PRIMARY', 'oanda');

// define our general functions used application-wide
  require(DIR_FS_FUNCTIONS . 'gen_functions.php');
  require(DIR_FS_FUNCTIONS . 'general.php');
  require(DIR_FS_FUNCTIONS . 'html_functions.php');

// set the session name and save path
  $http_domain  = gen_get_top_level_domain(HTTP_SERVER);
  $https_domain = gen_get_top_level_domain(HTTPS_SERVER);
  $current_domain = (($request_type == 'NONSSL') ? $http_domain : $https_domain);
  if (SESSION_USE_FQDN == 'False') $current_domain = '.' . $current_domain;

// set the session cookie parameters
session_set_cookie_params(0, '/', (gen_not_null($current_domain) ? $current_domain : ''));

$langs_available = load_language_dropdown();

// determine what company to connect to
$db_name = $_GET['db'];
if ($db_name && file_exists(DIR_FS_ADMIN . 'my_files/' . $db_name . '/config.php')) {
  define('DB_DATABASE', $db_name);
  require(DIR_FS_ADMIN . 'my_files/' . $db_name . '/config.php');
} else {
  echo 'No database name passed. Cannot determine which company to connect to!';
  exit();
}

// set the language
if ($_GET['lang']) {
	foreach ($langs_available as $value) if ($_GET['lang'] == $value['id']) define('LANGUAGE',$_GET['lang']);
}
if (!defined('LANGUAGE')) define('LANGUAGE','en_us');

// load general language translation
require (DIR_FS_MODULES . 'general/language/' . LANGUAGE . '/language.php');

// include the list of project database tables
require(DIR_FS_INCLUDES . 'database_tables.php');

// include the list of project security tokens
require(DIR_FS_INCLUDES . 'security_tokens.php');

// include the database functions
require(DIR_FS_FUNCTIONS . 'database.php');
// Load queryFactory db classes
require(DIR_FS_CLASSES . 'db/' . DB_TYPE . '/query_factory.php');
$db = new queryFactory();
$db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);

// set application wide parameters for phreebooks module
$configuration = $db->Execute("select configuration_key as cfgKey, configuration_value as cfgValue
							 from " . TABLE_CONFIGURATION);
while (!$configuration->EOF) {
	define($configuration->fields['cfgKey'], $configuration->fields['cfgValue']);
	$configuration->MoveNext();
}

// load currency classes
require (DIR_FS_CLASSES . 'currencies.php'); 
$currencies = new currencies();

// Include validation functions (right now only email address)
require(DIR_FS_FUNCTIONS . 'validations.php');

// setup our boxes
require(DIR_FS_CLASSES . 'table_block.php');
require(DIR_FS_CLASSES . 'box.php');

// initialize the message stack for output messages
require(DIR_FS_CLASSES . 'message_stack.php');
$messageStack = new messageStack;

// set a default time limit
gen_set_time_limit(GLOBAL_SET_TIME_LIMIT);

// check if a default currency is set
if (!defined('DEFAULT_CURRENCY')) {
  $messageStack->add(ERROR_NO_DEFAULT_CURRENCY_DEFINED, 'error');
}

// include the password crypto functions
require(DIR_FS_FUNCTIONS . 'password_funcs.php');

?>