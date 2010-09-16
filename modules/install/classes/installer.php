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
//  Path: /modules/install/classes/installer.php
//

/*
 * installer Class.
 * This class is used during the installation process
 * @package ZenCart_Classes
*/

  class installer {

    function installer() {
      $this->php_version = PHP_VERSION;
      $this->user_agent = $_SERVER['HTTP_USER_AGENT'];
    }

    function test_store_configure_write($zp_error_text, $zp_error_code) {
      if (!is_writeable('../../includes/configure.php')) {
        $this->setError($zp_error_text, $zp_error_code, true);
      }
    }

    function test_store_configure($zp_error_text, $zp_error_code) {
      if (!file_exists('../../includes/configure.php')) {
        @chmod('../includes', 0777);
        @touch('../includes/configure.php');
        @chmod('../includes', 0755);
        if (!file_exists('../includes/configure.php')) {
          $this->setError($zp_error_text, $zp_error_code, true);
        }
      }
      return true;
    }

    function test_php_version ($zp_test, $zp_version, $zp_error_text, $zp_error_code, $zp_fatal) {
      switch ($zp_test) {
        case '=':
	  if ($this->php_version == $zp_version) $this->setError($zp_error_text, $zp_error_code, $zp_fatal);
	break;
        case '<':
	  if ($this->php_version < $zp_version) $this->setError($zp_error_text, $zp_error_code, $zp_fatal);
	break;
      }
    }

    function isEmpty($zp_test, $zp_error_text, $zp_error_code) {
      if (!$zp_test) {
        $this->setError($zp_error_text, $zp_error_code, true);
      }
    }

    function noDots($zp_test, $zp_error_text, $zp_error_code) {
      if (str_replace(array('.','/',"\\"),'',$zp_test) != $zp_test) {
        $this->setError($zp_error_text, $zp_error_code, true);
      }
    }

    function fileExists($zp_file, $zp_error_text, $zp_error_code) {
      if (!file_exists($zp_file)) {
        $this->setError($zp_error_text, $zp_error_code, true);
      }
    }

    function isDir($zp_file, $zp_error_text, $zp_error_code) {
      if (!is_dir($zp_file)) {
        $this->setError($zp_error_text, $zp_error_code, true);
      }
    }

    function isWriteable($zp_file, $zp_error_text, $zp_error_code) {
      if (!is_writeable($zp_file)) {
        $this->setError($zp_error_text, $zp_error_code, true);
      }
    }

    function functionExists($zp_type, $zp_error_text, $zp_error_code) {
      if ($zp_type == 'mysql') {
        $function = 'mysql_connect';
      }
      if ($zp_type == 'postgres') {
       $function = 'pg_connect';
      }
      if (!function_exists($function)) {
        $this->setError($zp_error_text, $zp_error_code, true);
      }
    }

    function dbConnect($zp_type, $zp_host, $zp_database, $zp_username, $zp_pass, $zp_error_text, $zp_error_code, $zp_error_text2=ERROR_TEXT_DB_NOTEXIST, $zp_error_code2=ERROR_CODE_DB_NOTEXIST) {
      if ($this->error == false) {
        if ($zp_type == 'mysql') {
          if (@mysql_connect($zp_host, $zp_username, $zp_pass) == false ) {
            $this->setError($zp_error_text.'<br />'.@mysql_error(), $zp_error_code, true);
          } else {
	    if (!@mysql_select_db($zp_database)) {
              $this->setError($zp_error_text2.'<br />'.@mysql_error(), $zp_error_code2, true);
	    } else {
              @mysql_close();
	    }
          }
        }
        if ($zp_type == 'postgres') {
          if (pg_connect('host=' . $zp_host . ' dbname=' . $zp_database . ' user=' . $zp_username . ' password=' . $zp_pass) == false) {
            $this->setError($zp_error_text, $zp_error_code, true);
          } else {
            @pg_close();
          }
        }
      }
    }

    function dbCreate($zp_create, $zp_type, $zp_name, $zp_error_text, $zp_error_code) {
      if ($zp_create == 'true' && $this->error == false) {
        if ($zp_type == 'mysql' && (@mysql_query('CREATE DATABASE ' . $zp_name) == false)) {
          $this->setError($zp_error_text, $zp_error_code, true);
        }
        if ($zp_type == 'postgres' && (@pg_query("CREATE DATABASE '" . $zp_name . "';") == false)) {
          $this->setError($zp_error_text, $zp_error_code, true);
        }
      }
    }

    function dbExists($zp_create, $zp_type, $zp_host, $zp_username, $zp_pass, $zp_name, $zp_error_text, $zp_error_code) {
//    echo $zp_create;
      if ($zp_create != 'true' && $this->error == false) {
        if ($zp_type == 'mysql') {
          @mysql_connect($zp_host, $zp_username, $zp_pass);
	  if (@mysql_select_db($zp_name) == false) {
            $this->setError($zp_error_text.'<br />'.@mysql_error(), $zp_error_code, true);
	  }
        }
        if ($zp_type == 'postgres') {
	  if (@pg_connect('host=' . $zp_host . ' dbname=' . $zp_name . ' user=' . $zp_username . ' password=' . $zp_pass) == false) {
             $this->setError($zp_error_text, $zp_error_code, true);
          }
	}
      }
    }

    function isEmail($zp_param, $zp_error_text, $zp_error_code) {
      if (validate_email($zp_param) == false) {
        $this->setError($zp_error_text, $zp_error_code, true);
      }
    }

    function isEqual($zp_param1, $zp_param2, $zp_error_text, $zp_error_code) {
      if ($zp_param1 != $zp_param2) {
         $this->setError($zp_error_text, $zp_error_code, true);
      }
    }

    function setError($zp_error_text, $zp_error_code, $zp_fatal = false) {
      $this->error = true;
      $this->fatal_error = $zp_fatal;
      $this->error_array[] = array('text' => $zp_error_text, 'code' => $zp_error_code);
    }
  }