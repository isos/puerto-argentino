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
//  Path: /includes/application_top.php
//

// Start the clock for the page parse time log
  define('PAGE_PARSE_START_TIME',     microtime());
  define('PAGE_EXECUTION_START_TIME', microtime(true));

// set php_self in the local scope
  if (!isset($PHP_SELF)) $PHP_SELF = $_SERVER['PHP_SELF'];

// Check for application configuration parameters
  if (file_exists('includes/configure.php')) {
    require('includes/configure.php');
  } elseif (file_exists('modules/install/index.php')) {
	header('Location: modules/install/index.php');
  } else {
	die('ERROR: includes/configure.php file not found. Suggest running modules/install/index.php?');
  }

  // Load some path constants
  $path = ((ENABLE_SSL_ADMIN == 'true') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_ADMIN;
  define('DIR_WS_FULL_PATH', $path);	// full http path (or https if secure)
  define('DIR_WS_MODULES',   'modules/');

  // load some file system constants
  define('DIR_FS_INCLUDES',  DIR_FS_ADMIN    . 'includes/');
  define('DIR_FS_MODULES',   DIR_FS_ADMIN    . 'modules/');
  define('DIR_FS_MY_FILES',  DIR_FS_ADMIN    . 'my_files/');
  define('DIR_FS_REPORTS',   DIR_FS_MY_FILES . 'reports/');
  define('DIR_FS_THEMES',    DIR_FS_ADMIN    . 'themes/');
  define('DIR_FS_ADDONS',    DIR_FS_INCLUDES . 'addons/');
  define('DIR_FS_FUNCTIONS', DIR_FS_MODULES  . 'general/functions/');
  define('DIR_FS_CLASSES',   DIR_FS_MODULES  . 'general/classes/');
  define('FILENAME_DEFAULT','index');
  
// set the type of request (secure or not)
  $request_type = (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1' || strstr(strtoupper($_SERVER['HTTP_X_FORWARDED_BY']),'SSL') || strstr(strtoupper($_SERVER['HTTP_X_FORWARDED_HOST']),'SSL'))  ? 'SSL' : 'NONSSL';

// customization for the design layout
  define('BOX_WIDTH', 125); // how wide the boxes should be in pixels (default: 125)
  define('MAX_CP_COLUMNS',3); // set the maximum number of control panel columns to 3

// define how do we update currency exchange rates. Possible values are 'oanda' 'xe' or ''
  define('CURRENCY_SERVER_PRIMARY', 'oanda');
  define('CURRENCY_SERVER_BACKUP',  'xe');

// define the inventory types that are tracked in cost of goods sold
  define('COG_ITEM_TYPES','si,sr,ms,mi,as,sa');
  
// define our general functions used application-wide
  require(DIR_FS_FUNCTIONS . 'gen_functions.php');
  require(DIR_FS_FUNCTIONS . 'html_functions.php');

// setup our boxes
  require(DIR_FS_CLASSES . 'table_block.php');
  require(DIR_FS_CLASSES . 'box.php');

// set the session name and save path
  $http_domain  = gen_get_top_level_domain(HTTP_SERVER);
  $https_domain = gen_get_top_level_domain(HTTPS_SERVER);
  $current_domain = (($request_type == 'NONSSL') ? $http_domain : $https_domain);
  if (SESSION_USE_FQDN == 'False') $current_domain = '.' . $current_domain;

// set the session cookie parameters
//   if (function_exists('session_set_cookie_params')) {
  session_set_cookie_params(0, '/', (gen_not_null($current_domain) ? $current_domain : ''));
//  } elseif (function_exists('ini_set')) {
//    @ini_set('session.cookie_lifetime', '0');
//    @ini_set('session.cookie_path', DIR_WS_ADMIN);
//  }

// lets start our session
//  session_save_path(DIR_FS_MY_FILES . 'sessions/');
//  @ini_set('session.gc_probability', 1);
//  @ini_set('session.gc_divisor', 2);
  @ini_set('session.gc_maxlifetime', (SESSION_TIMEOUT_ADMIN < 900 ? (SESSION_TIMEOUT_ADMIN + 900) : SESSION_TIMEOUT_ADMIN));
  session_start();
  $session_started = true;

// see if the user is logged in
  $user_validated = ($_SESSION['admin_id']) ? true : false;

// determine what theme to use
  if (isset($_POST['theme'])) {
    define('DIR_WS_THEMES', DIR_WS_FULL_PATH . 'themes/' . $_POST['theme'] . '/');
	$_SESSION['theme'] = $_POST['theme'];
  } elseif (isset($_SESSION['theme'])) {
    define('DIR_WS_THEMES', DIR_WS_FULL_PATH . 'themes/' . $_SESSION['theme'] . '/');
  } else {
    define('DIR_WS_THEMES', DIR_WS_FULL_PATH . 'themes/default/');
	$_SESSION['theme'] = 'default';
  }
  define('DIR_WS_IMAGES', DIR_WS_THEMES . 'images/');
  if (file_exists(DIR_WS_THEMES . 'icons/')) {
    define('DIR_WS_ICONS',  DIR_WS_THEMES . 'icons/');
  } else { // use default
    define('DIR_WS_ICONS',  DIR_WS_FULL_PATH . 'themes/default/icons/');
  }

// determine what company to connect to
  $db_company = (isset($_SESSION['company'])) ? $_SESSION['company'] : $_SESSION['companies'][$_POST['company']];
  if ($db_company && file_exists(DIR_FS_ADMIN . 'my_files/' . $db_company . '/config.php')) {
	define('DB_DATABASE', $db_company);
    require(DIR_FS_ADMIN . 'my_files/' . $db_company . '/config.php');
	$use_db = true;
  } else {
	$use_db = false;
  }

// set the language
  if (isset($_GET['language'])) {
    $_SESSION['language'] = $_GET['language'];
  } elseif (!$_SESSION['language']) {
   	if (defined('DEFAULT_LANGUAGE')) {
	  $_SESSION['language'] = DEFAULT_LANGUAGE;
	} else {
	  $_SESSION['language'] = 'en_us';
	}
  }

// include the list of project database tables
  require(DIR_FS_INCLUDES . 'database_tables.php');

// include the list of project security tokens
  require(DIR_FS_INCLUDES . 'security_tokens.php');

// include the database functions
  if ($use_db) {
	require(DIR_FS_FUNCTIONS . 'database.php');
	// Load queryFactory db classes
	require(DIR_FS_CLASSES . 'db/' . DB_TYPE . '/query_factory.php');
	$db = new queryFactory();
	$db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);
	
	// set application wide parameters for phreebooks module
	$configuration = $db->Execute_return_error("select configuration_key as cfgKey, configuration_value as cfgValue
								 from " . TABLE_CONFIGURATION);
	if ($db->error_number) { // there was a problem, report and halt
	  die('There was an error returned while retrieving the configuration data.<br />PhreeBooks was able to connect to the database but could not find the configuration table. Looks like the table is missing! Options include deleting /includes/configure.php and re-installing (for new installations) or restoring the database tables (database crash).');	
	}
	while (!$configuration->EOF) {
		define($configuration->fields['cfgKey'], $configuration->fields['cfgValue']);
		$configuration->MoveNext();
	}

	// Define the project version  (must come after db class is loaded)
	require(DIR_FS_INCLUDES . 'version.php');
	// Determine the DATABASE patch level
	$project_db_info= $db->Execute("select * from " . TABLE_PROJECT_VERSION . " WHERE project_version_key = 'PhreeBooks Database' ");
	define('PROJECT_DB_VERSION_MAJOR',$project_db_info->fields['project_version_major']);
	define('PROJECT_DB_VERSION_MINOR',$project_db_info->fields['project_version_minor']);
	if ((PROJECT_VERSION_MAJOR . PROJECT_VERSION_MINOR) <> (PROJECT_DB_VERSION_MAJOR . PROJECT_DB_VERSION_MINOR)) {
		// run the upgrade script if necessary
		$filepath = DIR_FS_MODULES . 'install/updater.php';
		if (file_exists($filepath)) { // execute the sql
		  require_once(DIR_FS_MODULES . 'general/language/' . $_SESSION['language'] . '/language.php');
		  require($filepath);
		  execute_upgrade();
		} else {
		  die ('Trying to upgrade to Release ' . PROJECT_VERSION_MAJOR . '.' . PROJECT_VERSION_MINOR . ' but the upgrade file could not be found!');
		}
	}

	// load currency classes
	require(DIR_FS_CLASSES . 'currencies.php'); 
	$currencies = new currencies();

  }

// initialize the message stack for output messages, must be after session starts and configuration variables load
  require(DIR_FS_CLASSES . 'message_stack.php');
  $messageStack = new messageStack;
  $messageStack->debug("\nGET Vars = " . arr2string($_GET));
  $messageStack->debug("\nPOST Vars = " . arr2string($_POST));

// pull in the custom language over-rides for this module (to pre-define the standard language)
  $custom_path = DIR_FS_MY_FILES . 'custom/' . $cat . '/' . $module . '/extra_defines.php';
  if (file_exists($custom_path)) { include($custom_path); }

// load general language translation, Check for global define overrides first
  $extra_datafiles_dir = DIR_FS_MY_FILES . 'custom/extra_defines/';
  if ($dir = @dir($extra_datafiles_dir)) {
    while ($file = $dir->read()) {
      if (!is_dir($extra_datafiles_dir . $file)) {
        if (preg_match('/\.php$/', $file) > 0) {
          include_once($extra_datafiles_dir . $file);
        }
      }
    }
    $dir->close();
  }
  require_once(DIR_FS_MODULES . 'general/language/' . $_SESSION['language'] . '/language.php');

// include the list of project menu navigation configurations
  require(DIR_FS_INCLUDES . 'menu_navigation.php');

// include the list of extra database tables and filenames
  $extra_datafiles_dir = DIR_FS_MY_FILES . 'custom/extra_menus/';
  if ($dir = @dir($extra_datafiles_dir)) {
    while ($file = $dir->read()) {
      if (!is_dir($extra_datafiles_dir . $file)) {
        if (preg_match('/\.php$/', $file) > 0) {
          include_once($extra_datafiles_dir . $file);
        }
      }
    }
    $dir->close();
  }

  $dh  = opendir(DIR_FS_MODULES);
  $files = array();
  while (($filename = readdir($dh)) !== false) {
	if ($filename <> '.' && $filename <> '..') $files[] = $filename;
  }

// define our localization functions
  require(DIR_FS_FUNCTIONS . 'localization.php');

// Include validation functions
  require(DIR_FS_FUNCTIONS . 'validations.php');
  require(DIR_FS_FUNCTIONS . 'xml.php');

// initiate the toolbar
  require(DIR_FS_CLASSES . 'toolbar.php');
  $toolbar = new toolbar;

//  split-page-results
  require(DIR_FS_CLASSES . 'split_page_results.php');

// entry/item info classes
  require(DIR_FS_CLASSES . 'object_info.php');

// set a default time limit
  gen_set_time_limit(GLOBAL_SET_TIME_LIMIT);

// check if a default currency is set
  if (!defined('DEFAULT_CURRENCY')) {
    $messageStack->add(ERROR_NO_DEFAULT_CURRENCY_DEFINED, 'error');
  }

  if (function_exists('ini_get') && ((bool)ini_get('file_uploads') == false) ) {
    $messageStack->add(WARNING_FILE_UPLOADS_DISABLED, 'warning');
  }

// include the password crypto functions
  require(DIR_FS_FUNCTIONS . 'password_funcs.php');

// incluyo las funciones para controlar la sesion y los formularios
require(DIR_FS_FUNCTIONS . 'SessionManager.php');
?>
