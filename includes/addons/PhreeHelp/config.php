<?php
/* $Revision: 1.00 $ */
// User configurable variables

/* Added to include in PhreeBooks standard release to pull information directly from main configure file. */
require('../../../includes/configure.php');
/* End added for PhreeBooks */

//---------------------------------------------------------------------------------------------
// Set the path to the root directory of the help files
  define('DOC_ROOT_URL', HTTP_SERVER . DIR_WS_ADMIN . 'doc/manual');

// Set the path to the root directory of the help files relative to the PhreeHelp index file
  define('DOC_REL_PATH','../../../doc/manual');

// URL to the external help site, BBS, application website, usergroup, etc.
  define('DOC_WWW_HELP','http://www.phreesoft.com/phreebooks/documentation.php');

// Path to the startup page to first display in the main frame (relative to the DOC_ROOT_URL)
  define('DOC_HOME_PAGE','welcome.php');

/* Added to include in PhreeBooks standard release to pull information directly from main configure file.
// define our database connection
  define('DB_TYPE', 'mysql');
  define('DB_PREFIX', '');
  define('DB_SERVER', 'localhost'); // eg, localhost - should not be empty
  define('DB_SERVER_USERNAME', '');
  define('DB_SERVER_PASSWORD', '');
*/
  // go find a phreebooks install to build the help files
  define('DIR_FS_MY_FILES', DIR_FS_ADMIN . 'my_files/');
  if ($dir = @dir(DIR_FS_MY_FILES)) {
	while ($file = $dir->read()) {
	  if ($file <> '.' && $file <> '..' && is_dir(DIR_FS_MY_FILES . $file)) {
		if (file_exists(DIR_FS_MY_FILES . $file . '/config.php')) {
		  require_once(DIR_FS_MY_FILES . $file . '/config.php');
		  if (defined('DB_SERVER')) {
		    define('DB_DATABASE', $file);
			$dir->close();
		    break;
		  }
		}
	  }
	}
  }
  if (!defined('DB_DATABASE')) die('Could not connect to a PhreeBooks database to retrieve the help files.');
/* End of PhreeBooks modification */

// Default language to use if the requested language is not passed with the POST url
  if(!defined('DEFAULT_LANGUAGE')) define('DEFAULT_LANGUAGE', 'en_us');
  define('DEFAULT_STYLE','default');

// Document version filename (relative to the root document path)
// This file is scanned and changes to the version number within will reload the help file database 
  define('VERSION_FILENAME','version.txt');

// Extensions allowed for inclusion (separated by commas, no spaces)
  define('VALID_EXTENSIONS','html,htm,php,asp');

// END OF USER CONFIGURABLE VARIABLES
//---------------------------------------------------------------------------------------------
error_reporting (E_ALL & ~E_NOTICE);
?>