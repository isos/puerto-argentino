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
//  Path: /modules/install/functions/install.php
//

  if (!defined('TABLE_UPGRADE_EXCEPTIONS')) define('TABLE_UPGRADE_EXCEPTIONS','upgrade_exceptions');

function setInputValue($input, $constant, $default) {
  if (isset($input)) {
    define($constant, $input);
  } else {
    define($constant, $default);
  }
}

function setRadioChecked($input, $constant, $default) {
  if ($input == '') {
	$input = $default;
  }
  if ($input == 'true') {
	define($constant . '_FALSE', '');
	define($constant . '_TRUE', 'checked="checked" ');
  } else {
	define($constant . '_FALSE', 'checked="checked" ');
	define($constant . '_TRUE', '');
  }
}

function setSelected($input, $selected) {
  if ($input == $selected) {
    return ' selected="selected"';
  }
}

  function install_read_config_value($value) {
    $files_array = array();
    $files_array[] = '../../includes/configure.php';

    if ($za_dir = @dir('../../includes/extra_configures')) {
      while ($zv_file = $za_dir->read()) {
        if (strstr($zv_file, '.php')) {
          //echo $zv_file.'<br />';
          $files_array[] = $zv_file;
        }
      }
    }
	$string = false;
    foreach ($files_array as $filename) {
     if (!file_exists($filename)) continue;
     //echo $filename . '!<br />';
     $lines = file($filename);
     foreach($lines as $line) { // read the configure.php file for specific variables
       $def_string=array();
       $def_string=explode("'",$line);
       //define('CONSTANT','value');
       //[1]=TABLE_CONSTANT
       //[2]=,
       //[3]=value
       //[4]=);
       //[5]=
       if (strtoupper($def_string[1]) == $value ) $string .= $def_string[3];
     }//end foreach $line
    }//end foreach $filename
    return $string;
  }

  function install_read_chart_desc() {
  	$output = array();
    if ($za_dir = @dir('charts')) {
      while ($zv_file = $za_dir->read()) {
	    unset($chart_description);
		if (substr($zv_file, strrpos($zv_file, '.')) == '.php') {
          require('charts/' . $zv_file);
		  if ($chart_description) $output[] = array('id' => $zv_file, 'text' => $chart_description);
        }
      }
    }
    return $output;
  }

  function install_table_exists($tablename, $pre_install=false) {
    global $db, $db_test;
    if ($pre_install==true) {
      $tables = $db_test->Execute("SHOW TABLES like '" . DB_PREFIX . $tablename . "'");
    } else {
      $tables = $db->Execute("SHOW TABLES like '" . DB_PREFIX . $tablename . "'");
    }
//    if (ZC_UPG_DEBUG3==true) echo 'Table check ('.$tablename.') = '. $tables->RecordCount() .'<br />';
    if ($tables->RecordCount() > 0) {
      return true;
    } else {
      return false;
    }   
  }

  function db_check_database_privs($priv='',$table='',$show_privs=false) {
    //bypass for now ... will attempt to use with modifications in a new release later
    if ($show_privs==true) return 'Not Checked|||Not Checked';
    return true;
    // end bypass
    global $zdb_server, $zdb_user, $zdb_name;
    if (!gen_not_null($zdb_server)) $zdb_server = install_read_config_value('DB_SERVER');
    if (!gen_not_null($zdb_user)) $zdb_user     = $_SESSION['db_user'];
    if (!gen_not_null($zdb_name)) $zdb_name     = $_SESSION['company'];
    if (isset($_GET['nogrants']) || isset($_POST['nogrants']) ) return true; // bypass if flag set
    //Display permissions, or check for suitable permissions to carry out a particular task
      //possible outputs:
      //GRANT ALL PRIVILEGES ON *.* TO 'xyz'@'localhost' WITH GRANT OPTION
      //GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, FILE, INDEX, ALTER ON *.* TO 'xyz'@'localhost' IDENTIFIED BY PASSWORD '2344'	
      //GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, INDEX, ALTER ON `db1`.* TO 'xyz'@'localhost'
      //GRANT SELECT (id) ON db1.tablename TO 'xyz'@'localhost
    global $db;
    global $db_test;
    $granted_privs_list='';
    if (ZC_UPG_DEBUG3==true) echo '<br />Checking for priv: ['.(gen_not_null($priv) ? $priv : 'none specified').']<br />';
    if (!defined('DB_SERVER'))          define('DB_SERVER',$zdb_server);
    if (!defined('DB_SERVER_USERNAME')) define('DB_SERVER_USERNAME',$zdb_user);
    if (!defined('DB_DATABASE'))        define('DB_DATABASE',$zdb_name);
    $user = DB_SERVER_USERNAME."@".DB_SERVER;
    if ($user == 'DB_SERVER_USERNAME@DB_SERVER' || DB_DATABASE=='DB_DATABASE') return true; // bypass if constants not set properly
    $sql = "show grants for ".$user;
    if (ZC_UPG_DEBUG3==true) echo $sql.'<br />';
    if (is_object($db)) {
      $result = $db->Execute($sql);
    } elseif (is_object($db_test)) {
      $result = $db_test->Execute($sql);
    }
    while (!$result->EOF) {
      if (ZC_UPG_DEBUG3==true) echo $result->fields['Grants for '.$user].'<br />';
      $grant_syntax = $result->fields['Grants for '.$user] . ' ';
      $granted_privs = str_replace('GRANT ','',$grant_syntax); // remove "GRANT" keyword
      $granted_privs = substr($granted_privs,0,strpos($granted_privs,' TO ')); //remove anything after the "TO" keyword
      $granted_db = str_replace(array('`','\\'),'',substr($granted_privs,strpos($granted_privs,' ON ')+4) ); //remove backquote and find "ON" string
      if (ZC_UPG_DEBUG3==true) echo 'privs_list = '.$granted_privs.'<br />';
      if (ZC_UPG_DEBUG3==true) echo 'granted_db = '.$granted_db.'<br />';
      $db_priv_ok += ($granted_db == '*.*' || $granted_db==DB_DATABASE.'.*' || $granted_db==DB_DATABASE.'.'.$table) ? true : false;
      if (ZC_UPG_DEBUG3==true) echo 'db-priv-ok='.$db_priv_ok.'<br />';

      if ($db_priv_ok) {  // if the privs list pertains to the current database, or is *.*, carry on
        $granted_privs = substr($granted_privs,0,strpos($granted_privs,' ON ')); //remove anything after the "ON" keyword
        $granted_privs_list .= ($granted_privs_list=='') ? $granted_privs : ', '.$granted_privs;

        $specific_priv_found = (gen_not_null($priv) && substr_count($granted_privs,$priv)==1);
        if (ZC_UPG_DEBUG3==true) echo 'specific priv['.$priv.'] found ='.$specific_priv_found.'<br />';

        if (ZC_UPG_DEBUG3==true) echo 'spec+db='.($specific_priv_found && $db_priv_ok == true).' ||| ';
        if (ZC_UPG_DEBUG3==true) echo 'all+db='.($granted_privs == 'ALL PRIVILEGES' && $db_priv_ok==true).'<br /><br />';

        if (($specific_priv_found && $db_priv_ok == true) || ($granted_privs == 'ALL PRIVILEGES' && $db_priv_ok==true)) {
          return true; // privs found
        }
      } // endif $db_priv_ok
      $result->MoveNext();
    }
    if ($show_privs) {
      if (ZC_UPG_DEBUG3==true) echo 'LIST OF PRIVS='.$granted_privs_list.'<br />';
      return $db_priv_ok . '|||'. $granted_privs_list;
    } else {
      return false; // if not found, return false
    }
  }

  function install_drop_index_command($param) {
    if (!$checkprivs = db_check_database_privs('INDEX')) return sprintf(REASON_NO_PRIVILEGES,'INDEX');
    //this is only slightly different from the ALTER TABLE DROP INDEX command
    global $db;
    if (!gen_not_null($param)) return "Empty SQL Statement";
    $index = $param[2];
    $sql = "show index from " . DB_PREFIX . $param[4];
    $result = $db->Execute($sql);
    while (!$result->EOF) {
      if (ZC_UPG_DEBUG3==true) echo $result->fields['Key_name'].'<br />';
      if  ($result->fields['Key_name'] == $index) {
//        if (!$checkprivs = db_check_database_privs('INDEX')) return sprintf(REASON_NO_PRIVILEGES,'INDEX');
        return; // if we get here, the index exists, and we have index privileges, so return with no error
      }
      $result->MoveNext();
    }
    // if we get here, then the index didn't exist
    return sprintf(REASON_INDEX_DOESNT_EXIST_TO_DROP,$index,$param[4]);
  }

  function install_create_index_command($param) {
    //this is only slightly different from the ALTER TABLE CREATE INDEX command
    if (!$checkprivs = db_check_database_privs('INDEX')) return sprintf(REASON_NO_PRIVILEGES,'INDEX');
    global $db;
    if (!gen_not_null($param)) return "Empty SQL Statement";
    $index = (strtoupper($param[1])=='INDEX') ? $param[2] : $param[3];
    if (in_array('USING',$param)) return 'USING parameter found. Cannot validate syntax. Please run manually in phpMyAdmin.';
    $table = (strtoupper($param[2])=='INDEX' && strtoupper($param[4])=='ON') ? $param[5] : $param[4];
    $sql = "show index from " . DB_PREFIX . $table;
    $result = $db->Execute($sql);
    while (!$result->EOF) {
      if (ZC_UPG_DEBUG3==true) echo $result->fields['Key_name'].'<br />';
      if (strtoupper($result->fields['Key_name']) == strtoupper($index)) {
        return sprintf(REASON_INDEX_ALREADY_EXISTS,$index,$table);
      }
      $result->MoveNext();
    }
/*
 * @TODO: verify that individual columns exist, by parsing the index_col_name parameters list
 *        Structure is (colname(len)), 
 *                  or (colname),
 */
  }

  function install_check_alter_command($param) {
    global $db;
    if (!gen_not_null($param)) return "Empty SQL Statement";
    if (!$checkprivs = db_check_database_privs('ALTER')) return sprintf(REASON_NO_PRIVILEGES,DB_SERVER_USERNAME, DB_SERVER, 'ALTER');
    switch (strtoupper($param[3])) {
      case ("ADD"):
        if (strtoupper($param[4]) == 'INDEX') {
          // check that the index to be added doesn't already exist
          $index = $param[5];
          $sql = "show index from " . DB_PREFIX . $param[2];
          $result = $db->Execute($sql);
          while (!$result->EOF) {
            if (ZC_UPG_DEBUG3==true) echo 'KEY: '.$result->fields['Key_name'].'<br />';
            if  ($result->fields['Key_name'] == $index) {
              return sprintf(REASON_INDEX_ALREADY_EXISTS,$index,$param[2]);
            }
            $result->MoveNext();
          }
        } elseif (strtoupper($param[4])=='PRIMARY') {
          // check that the primary key to be added doesn't exist
          if ($param[5] != 'KEY') return;
          $sql = "show index from " . DB_PREFIX . $param[2];
          $result = $db->Execute($sql);
          while (!$result->EOF) {
            if (ZC_UPG_DEBUG3==true) echo $result->fields['Key_name'].'<br />';
            if  ($result->fields['Key_name'] == 'PRIMARY') {
              return sprintf(REASON_PRIMARY_KEY_ALREADY_EXISTS,$param[2]);
            }
            $result->MoveNext();
          }

        } elseif (!in_array(strtoupper($param[4]),array('CONSTRAINT','UNIQUE','PRIMARY','FULLTEXT','FOREIGN','SPATIAL') ) ) {
        // check that the column to be added does not exist
          $colname = ($param[4]=='COLUMN') ? $param[5] : $param[4];
          $sql = "show fields from " . DB_PREFIX . $param[2];
          $result = $db->Execute($sql);
          while (!$result->EOF) {
            if (ZC_UPG_DEBUG3==true) echo $result->fields['Field'].'<br />';
            if  ($result->fields['Field'] == $colname) {
              return sprintf(REASON_COLUMN_ALREADY_EXISTS,$colname);
            }
            $result->MoveNext();
          } //endif COLUMN
/* 
 * @TODO -- add check for AFTER parameter, to check that the AFTER colname specified actually exists first
 *       -- same with FIRST
 */
        }
        break;
      case ("DROP"):
        if (strtoupper($param[4]) == 'INDEX') {
          // check that the index to be dropped exists
          $index = $param[5];
          $sql = "show index from " . DB_PREFIX . $param[2];
          $result = $db->Execute($sql);
          while (!$result->EOF) {
            if (ZC_UPG_DEBUG3==true) echo $result->fields['Key_name'].'<br />';
            if  ($result->fields['Key_name'] == $index) {
              return; // exists, so return with no error
            }
            $result->MoveNext();
          }
          // if we get here, then the index didn't exist
          return sprintf(REASON_INDEX_DOESNT_EXIST_TO_DROP,$index,$param[2]);

        } elseif (strtoupper($param[4])=='PRIMARY') {
          // check that the primary key to be dropped exists
          if ($param[5] != 'KEY') return;
          $sql = "show index from " . DB_PREFIX . $param[2];
          $result = $db->Execute($sql);
          while (!$result->EOF) {
            if (ZC_UPG_DEBUG3==true) echo $result->fields['Key_name'].'<br />';
            if  ($result->fields['Key_name'] == 'PRIMARY') {
              return; // exists, so return with no error
            }
            $result->MoveNext();
          }
          // if we get here, then the primary key didn't exist
          return sprintf(REASON_PRIMARY_KEY_DOESNT_EXIST_TO_DROP,$param[2]);

        } elseif (!in_array(strtoupper($param[4]),array('CONSTRAINT','UNIQUE','PRIMARY','FULLTEXT','FOREIGN','SPATIAL'))) {
          // check that the column to be dropped exists
          $colname = ($param[4]=='COLUMN') ? $param[5] : $param[4];
          $sql = "show fields from " . DB_PREFIX . $param[2];
          $result = $db->Execute($sql);
          while (!$result->EOF) {
            if (ZC_UPG_DEBUG3==true) echo $result->fields['Field'].'<br />';
            if  ($result->fields['Field'] == $colname) {
              return; // exists, so return with no error
            }
            $result->MoveNext();
          }
          // if we get here, then the column didn't exist
          return sprintf(REASON_COLUMN_DOESNT_EXIST_TO_DROP,$colname);
        }//endif 'DROP'
        break;
      case ("ALTER"):
      case ("MODIFY"):
      case ("CHANGE"):
        // just check that the column to be changed 'exists'
        $colname = ($param[4]=='COLUMN') ? $param[5] : $param[4];
        $sql = "show fields from " . DB_PREFIX . $param[2];
        $result = $db->Execute($sql);
        while (!$result->EOF) {
          if (ZC_UPG_DEBUG3==true) echo $result->fields['Field'].'<br />';
          if  ($result->fields['Field'] == $colname) {
            return; // exists, so return with no error
          }
          $result->MoveNext();
        }
        // if we get here, then the column didn't exist
        return sprintf(REASON_COLUMN_DOESNT_EXIST_TO_CHANGE,$colname);
        break;
      default: 
        // if we get here, then we're processing an ALTER command other than what we're checking for, so let it be processed.
        return; 
        break;
    } //end switch
  }

  function load_config_value($key) {
	global $db;
    $sql = "select configuration_value from " . DB_PREFIX . "configuration where configuration_key = '".$key."'";
    $result = $db->Execute($sql);
    if ($result->RecordCount() > 0 ) return $result->fields['configuration_value'];
	return false;
  }

  function load_acct_type_desc($id) {
	global $db;
    $sql = "select description from " . DB_PREFIX . "chart_of_accounts_types where id = " . $id;
    $result = $db->Execute($sql);
    if ($result->RecordCount() > 0 ) return $result->fields['description'];
  }

  function best_acct_guess($id, $keyword, $default) {
    global $db;
	$pulldown = '';
    $best_guess = load_config_value($default);
	if (!$best_guess) {
	  $sql = "select c.id 
		from " . DB_PREFIX . "chart_of_accounts c inner join " . DB_PREFIX . "chart_of_accounts_types t on c.account_type = t.id
		where t.id = " . $id . " and c.description like '%" . $keyword . "%' limit 1";
	  $result = $db->Execute($sql);
	  if ($result->RecordCount() == 0) { // no record found, fetch at first account of specified type
		$result = $db->Execute("select id from " . DB_PREFIX . "chart_of_accounts where account_type = " . $id . " order by id");
	  }
      $best_guess = $result->fields['id'];
	}
    return $best_guess;
  }

  function smart_acct_list($id, $keyword, $default) {
    global $db;
	$best_guess = best_acct_guess($id, $keyword, $default);
	
	$result = $db->Execute("select id from " . DB_PREFIX . "chart_of_accounts order by id");
	while (!$result->EOF) {
	  $acct = $result->fields['id'];
	  $pulldown .= '<option value="' . $acct . '"' . ($acct==$best_guess ? ' selected' : '') . '>' . urlencode($acct) . '</option>';
	  $result->MoveNext();
	}
	return $pulldown;
  }

  function install_check_config_key($line) {
    global $db;
    $values=array();
    $values=explode("'",$line);
     //INSERT INTO configuration blah blah blah VALUES ('title','key', blah blah blah);
     //[0]=INSERT INTO.....
     //[1]=title
     //[2]=,
     //[3]=key
     //[4]=blah blah
    $title = $values[1];
    $key  =  $values[3];
    $sql = "select configuration_title from " . DB_PREFIX . "configuration where configuration_key='".$key."'";
    $result = $db->Execute($sql);
    if ($result->RecordCount() >0 ) return sprintf(REASON_CONFIG_KEY_ALREADY_EXISTS,$key);
  }

  function install_write_to_upgrade_exceptions_table($line, $reason, $sql_file) {
    global $db;
    install_create_exceptions_table();
    $sql="INSERT INTO " . DB_PREFIX . TABLE_UPGRADE_EXCEPTIONS . " VALUES ('','". $sql_file."','".$reason."', now(), '".addslashes($line)."')";
     if (ZC_UPG_DEBUG3==true) echo '<br />sql='.$sql.'<br />';
    $result = $db->Execute($sql);
    return $result;
  }

  function load_new_chart($filename) {
    global $db;
	require('charts/' . $filename);
	$db->Execute("delete from ". DB_PREFIX . "chart_of_accounts");
	foreach ($chart_array as $value) {
	  $db->Execute("insert into " . DB_PREFIX . "chart_of_accounts set id = '" . $value[0] . "', 
	  		description = '" . $value[1] . "', account_type = " . $value[2]);
	}
  }

  function install_purge_exceptions_table() {
    global $db;
    install_create_exceptions_table();
    $result = $db->Execute("TRUNCATE TABLE " . DB_PREFIX . TABLE_UPGRADE_EXCEPTIONS );
    return $result;
  }

  function install_create_exceptions_table() {
    global $db;
    if (!install_table_exists(TABLE_UPGRADE_EXCEPTIONS)) {  
      $result = $db->Execute("CREATE TABLE `" . DB_PREFIX . TABLE_UPGRADE_EXCEPTIONS ."` (
            `upgrade_exception_id` smallint(5) NOT NULL auto_increment,
            `sql_file` varchar(50) default NULL,
            `reason` varchar(200) default NULL,
            `errordate` datetime default '0001-01-01 00:00:00',
            `sqlstatement` text, PRIMARY KEY  (`upgrade_exception_id`)
          ) TYPE=MyISAM");
    return $result;
    }
  }

  function delete_dir($dir_name) {
    if (empty($dir_name)) return true;
    if (file_exists($dir_name)) {
	   $dir = dir($dir_name);
	   while ($file = $dir->read()) {
		   if ($file != '.' && $file != '..') {
			   if (is_dir($dir_name . '/' . $file)) {
				   delete_dir($dir_name . '/' . $file);
			   } else {
				   @unlink($dir_name . '/' . $file) or die('File ' . $dir_name.'/' . $file . ' couldn\'t be deleted!');
			   }
		   }
	   }
	   $dir->close();
	   @rmdir($dir_name) or die('Folder ' . $dir_name . ' could not be deleted!');
    } else {
	   return false;
    }
    return true;
  } 

  function install_build_dirs($company, $include_demo = false) {
    global $messageStack;
	if (!file_exists(DIR_FS_MY_FILES . 'backups'))            $status = mkdir(DIR_FS_MY_FILES . 'backups');
	if (!$status) {
	  $messageStack->add('Cannot create directory (' . DIR_FS_MY_FILES . 'backups' . ') check your permissions.', 'error');
	  return false;
	}
	install_blank_webpage(DIR_FS_MY_FILES . 'backups/index.html'); // protect backups directory from spiders
	if (!file_exists(DIR_FS_MY_FILES . $company))                       mkdir(DIR_FS_MY_FILES . $company);
	install_blank_webpage(DIR_FS_MY_FILES . $company . '/index.html'); // protect company directory from spiders
	if (!file_exists(DIR_FS_MY_FILES . $company . '/images'))           mkdir(DIR_FS_MY_FILES . $company . '/images');
	if (!file_exists(DIR_FS_MY_FILES . $company . '/inventory'))        mkdir(DIR_FS_MY_FILES . $company . '/inventory');
	if (!file_exists(DIR_FS_MY_FILES . $company . '/inventory/images')) mkdir(DIR_FS_MY_FILES . $company . '/inventory/images');
	if (!file_exists(DIR_FS_MY_FILES . $company . '/shipping'))         mkdir(DIR_FS_MY_FILES . $company . '/shipping');
	if (!file_exists(DIR_FS_MY_FILES . $company . '/temp'))             mkdir(DIR_FS_MY_FILES . $company . '/temp');
	@chmod(DIR_FS_MY_FILES . $company . '/temp', 0777); // needed for db access 
	// now copy some startup files
	$source = DIR_FS_MY_FILES . '../themes/default/images/phreebooks_logo.jpg'; // default logo for forms
	$dest = DIR_FS_MY_FILES . $company . '/images/phreebooks_logo.jpg';
	copy($source, $dest);
	if ($include_demo) { // now copy the demo image files
	  $source_dir = DIR_FS_MY_FILES . '../themes/default/images/demo';
	  $dest_dir = DIR_FS_MY_FILES . $company . '/inventory/images/demo';
	  dircopy($source_dir, $dest_dir);
	}
	return true;
  }

  function load_full_access_security() {
	global $menu;  
	foreach ($menu as $value) $security .= $value['security_id'] . ':4,';
	if (!$security) $security = '1:4,'; // if loading security tokens fails this will allow access to the user menu
	$security = substr($security, 0, -1);
	return $security;
  }

  function install_build_co_config_file($company, $key, $value) {
	$filename = DIR_FS_ADMIN . 'my_files/' . $company . '/config.php';
	if (file_exists($filename)) { // update
		$lines = file($filename);
		$found_it = false;
		for ($x = 0; $x < count($lines); $x++) {
			if (trim(substr($lines[$x], 0, strpos($lines[$x], '='))) == $key) {
				$lines[$x] = "define('" . $key . "','" . $value . "');" . "\n";
				$found_it = true;
				break;
			}
		}
		if (!$found_it) $lines[] = "define('" . $key . "','" . $value . "');" . "\n";
	} else { // create the config file, because it doesn't exist
		$lines = array();
		$lines[] = '<?php' . "\n";
		$lines[] = '/* config.php */' . "\n";
		$lines[] = "define('" . $key . "','" . $value . "');" . "\n";
	}
	$line = implode('', $lines);
	if (!$handle = @fopen($filename, 'w')) die('Cannot open file (' . $filename . ') for writing check your permissions.');
	fwrite($handle, $line);
	fclose($handle);
	return true;
  }

  function copy_db_table($source_db, $table_list, $temp_file, $copy_type = 'data', $params = '') {
    if (is_array($table_list)) {
	  foreach($table_list as $table) {
		if (!dump_db_table($source_db, $table, $temp_file, $copy_type, $params)) return false;
		if (!load_db_table($temp_file)) return false;
	  }
	}
	return true;
  }

  function dump_db_table($db, $table = 'all', $filename, $copy_type = 'data', $params = '') {
  	global $messageStack;
	define('lnbr',chr(10));
	$query = '';
	$tables = array();

	if ($table == 'all') {
		$table_list = $db->Execute("show tables");
		while (!$table_list->EOF) {
			$tablename = array_shift($table_list->fields);
			$tables[] = $tablename;
			$table_list->MoveNext();
		}
	} else {
		$tables[] = $table;
	}

	foreach ($tables as $table) {
		if ($copy_type == 'structure' || $copy_type == 'both') {
			$query .= "-- Table structure for table `$table`" . lnbr;
			$query .= "DROP TABLE IF EXISTS `$table`;" . lnbr . lnbr;
			$result = $db->Execute("show create table `$table`");
			$query .= $result->fields['Create Table'] . ";" . lnbr . lnbr;
		}
	
		if ($copy_type == 'data' || $copy_type == 'both') {
			$result = $db->Execute('SELECT * FROM ' . $table . $params);
			if ($result->RecordCount() > 0) {
			  $temp_array = $result->fields;
			  while (list($key, $value) = each($temp_array)) $data['keys'][] = $key; 
			  $sql_head  = 'INSERT INTO `' . $table .'` (`' . join($data['keys'], '`, `') . '`) VALUES ' . lnbr;
			  $max_count = 200; // max 300 to work with BigDump
			  $count     = 0; // set to max_count to force the sql_head at the start
			  $query .= $sql_head;
			  while (!$result->EOF) {
				$data = array();
				$temp_array = $result->fields;
				while (list($key, $value) = each($temp_array)) {
					$data[] = addslashes($value);
				} 
				$query .= "('" . implode("', '", $data) . "')";
				$result->MoveNext();
				$count++;
				if ($result->EOF) {
					$query .= ';' . lnbr;
				} elseif ($count > $max_count) {
					$count = 0;
					$query .= ';' . lnbr . $sql_head;
				} else {
					$query .= ',' . lnbr;
				}
			  }
			}
		}
		$query .= lnbr . lnbr;
	}

	$handle = @fopen($filename, 'w');
	if ($handle === false) {
		$messageStack->add('Cannot open file (' . $filename . ') for writing check your permissions.', 'error');
		return false;
	}
	fwrite($handle, $query);
	fclose($handle);
	return true;
  }

  function load_db_table($filename) {
  	global $messageStack;

	$result = db_executeSql($filename, DB_DATABASE);
	if (count($result['errors']) > 0) {
		$messageStack->add(SETUP_CO_MGR_ERROR_1,'error');
		break;
	}
	return true;
  }

  function load_startup_table_data ($language = 'en_us') {
    global $db;
	// set current status to intial levels
	$db->Execute("INSERT INTO " . TABLE_CURRENT_STATUS . " VALUES (1, 5000, '10000', 20000, 100, '1', 1, 'CM1000', 'VCM1000', 'RFQ1000', 'QU1000', 'C10000', 'V10000')");
	// set the project db version
	require_once(DIR_FS_INCLUDES . 'version.php');
	$db->Execute("INSERT INTO " . TABLE_PROJECT_VERSION . " VALUES (1, 'PhreeBooks Database', '" . PROJECT_VERSION_MAJOR . "', '" . PROJECT_VERSION_MINOR . "', 'Fresh Installation', '" . date('Y-m-d H:i:s', time()) . "');");
	// load the configuration values (config_data.php)
	require_once(DIR_FS_MODULES . 'install/language/' . $language . '/config_data.php');
	require_once(DIR_FS_MODULES . 'install/includes/config_data.php');
	foreach($config_data as $entry) db_perform(TABLE_CONFIGURATION, $entry, 'insert');
// TBD -  set the accounting period and period start and end dates
	// load the chart_of_accounts_types_list
	require_once(DIR_FS_MODULES . 'install/language/' . $language . '/chart_of_accounts_types_list.php');
	foreach ($chart_of_accounts_types_list as $entry) db_perform(TABLE_CHART_OF_ACCOUNTS_TYPES, $entry, 'insert');
	// load the countries_list
	require_once(DIR_FS_MODULES . 'install/language/' . $language . '/countries_list.php');
	foreach($countries_list as $entry) db_perform(TABLE_COUNTRIES, $entry, 'insert');
	// load the currencies_list
	require_once(DIR_FS_MODULES . 'install/language/' . $language . '/currencies_list.php');
	foreach($currencies_list as $entry) db_perform(TABLE_CURRENCIES, $entry, 'insert');
	// load the import_export_list
	require_once(DIR_FS_MODULES . 'install/language/' . $language . '/import_export_list.php');
	foreach($import_export_list as $entry) db_perform(TABLE_IMPORT_EXPORT, $entry, 'insert');
	// load the state_province_list
	require_once(DIR_FS_MODULES . 'install/language/' . $language . '/state_province_list.php');
	foreach($state_province_list as $entry) db_perform(TABLE_ZONES, $entry, 'insert');
	// load the reports and forms (import from my_files);
	require_once(DIR_FS_MODULES . 'reportwriter/functions/builder_functions.php');
	require_once(DIR_FS_MODULES . 'reportwriter/language/' . $language . '/language.php');
	require_once(DIR_FS_MODULES . 'install/report_list.php');
	define('DIR_FS_REPORTS', '../../my_files/reports/');
	foreach ($report_list as $report) {
		$_POST['RptFileName'] = $report; // to fake out the import function to load report from my_files
		if (file_exists(DIR_FS_REPORTS . $report)) {
			ImportReport($RptName = '');
		}
	}
	// synchronize the inventory fields before any customization is done to them
	require(DIR_FS_MODULES . 'inventory/functions/inventory.php');
	inv_sync_inv_field_list();
	return true;
  }

	function dircopy($src_dir, $dst_dir, $verbose = false, $use_cached_dir_trees = false) {    
        static $cached_src_dir;
        static $src_tree; 
        static $dst_tree;
        $num = 0;

        if (($slash = substr($src_dir, -1)) == "\\" || $slash == "/") $src_dir = substr($src_dir, 0, strlen($src_dir) - 1); 
        if (($slash = substr($dst_dir, -1)) == "\\" || $slash == "/") $dst_dir = substr($dst_dir, 0, strlen($dst_dir) - 1);  

        if (!$use_cached_dir_trees || !isset($src_tree) || $cached_src_dir != $src_dir) {
            $src_tree = get_dir_tree($src_dir);
            $cached_src_dir = $src_dir;
            $src_changed = true;  
        }
        if (!$use_cached_dir_trees || !isset($dst_tree) || $src_changed) $dst_tree = get_dir_tree($dst_dir);
        if (!is_dir($dst_dir)) mkdir($dst_dir, 0777, true);  

        foreach ($src_tree as $file => $src_mtime) {
            if (!isset($dst_tree[$file]) && $src_mtime === false) mkdir("$dst_dir/$file"); 
            elseif (!isset($dst_tree[$file]) && $src_mtime || isset($dst_tree[$file]) && $src_mtime > $dst_tree[$file]) {
                if (copy("$src_dir/$file", "$dst_dir/$file")) {
                    if($verbose) echo "Copied '$src_dir/$file' to '$dst_dir/$file'<br />\r\n";
                    touch("$dst_dir/$file", $src_mtime); 
                    $num++; 
                } else echo "<font color='red'>File '$src_dir/$file' could not be copied!</font><br />\r\n";
            }        
        }

        return $num; 
    }

    function get_dir_tree($dir, $root = true)  {
        static $tree;
        static $base_dir_length; 

        if ($root) { 
            $tree = array();  
            $base_dir_length = strlen($dir) + 1;  
        }

        if (is_file($dir)) {
            $tree[substr($dir, $base_dir_length)] = filemtime($dir); 
        } elseif (is_dir($dir) && $di = dir($dir)) { 
            if (!$root) $tree[substr($dir, $base_dir_length)] = false;  
            while (($file = $di->read()) !== false) 
                if ($file != "." && $file != "..")
                    get_dir_tree("$dir/$file", false);  
            $di->close(); 
        }

        if ($root) return $tree;     
    }

	// Function to recursively add a directory, sub-directories and files to a zip archive
	function addFolderToZip($dir, $zipArchive) {
	  if (is_dir($dir)) {
		if ($dh = opendir($dir)) { //Add the directory
		  $zipArchive->addEmptyDir($dir);
		  while (($file = readdir($dh)) !== false) { // Loop through all the files
			if(!is_file($dir . $file)){ //If it's a folder, run the function again!
//echo 'directory = ' . $dir . $file . '<br />';
			  if ($file !== "." && $file !== "..") addFolderToZip($dir . $file . "/", $zipArchive);
			} else { // Add the files
//echo 'file = ' . $dir . $file . '<br />';
			  $zipArchive->addFile($dir . $file);
			}
		  }
		}
	  }
	}

function update_reports() {
  global $db;
  $result = $db->Execute("select id, entrytype, params from " . TABLE_REPORT_FIELDS);
  while(!$result->EOF) {
    $params = NULL;
    switch ($result->fields['entrytype']) {
	  case 'grouplist':
	    if (!$result->fields['params']) $result->fields['params'] = '00';
		if (strlen($result->fields['params']) > 2) break; // skip if in proper format
	    $params = array(
		  'default'    => substr($result->fields['params'], 0, 1),
		  'page_break' => substr($result->fields['params'], 1, 1),
		  'processing' => '0',
		);
	    break;
	  case 'sortlist':
	    if (!$result->fields['params']) $result->fields['params'] = '0';
		if (strlen($result->fields['params']) > 1) break; // skip if in proper format
	    $params = array(
		  'default'    => substr($result->fields['params'],0,1),
		);
	    break;
	  case 'critlist':
	    if (!$result->fields['params']) $result->fields['params'] = '0:::';
		$temp = explode(':', $result->fields['params']);
	    if (sizeof($temp) <> 4) break; // skip if not in proper compressed format
		$params = array(
		  'value'   => $temp[0],
		  'default' => $temp[1],
		  'min_val' => $temp[2],
		  'max_val' => $temp[3],
		);
	    break;
	  default: $params = NULL; // do nothing
	}
	if ($params) {
	  $db->Execute("update " . TABLE_REPORT_FIELDS . " set params = '" . serialize($params) . "' 
	    where id = " . $result->fields['id']);
	}
    $result-> MoveNext();
  }

  // move the trunc long description field to the page properties as part of the page setup
  $result = $db->Execute("select id, reportid, params from " . TABLE_REPORT_FIELDS . " where entrytype = 'pagelist'");
  while(!$result->EOF) {
    $params = unserialize($result->fields['params']);
    $trunc = $db->Execute("select id, params from " . TABLE_REPORT_FIELDS . " 
	   where reportid = " . $result->fields['reportid'] . " and entrytype = 'trunclong'");
	if ($trunc->RecordCount() > 0) {
	  $params['trunclong'] = $trunc->fields['params'];
	  $db->Execute("update " . TABLE_REPORT_FIELDS . " set params = '" . serialize($params) . "' 
	    where id = " . $result->fields['id']);
	  $db->Execute("delete from " . TABLE_REPORT_FIELDS . " where id = " . $trunc->fields['id']);
	}
	$result->MoveNext();
  }

  // move the date information field to the page properties as part of the page setup
  $result = $db->Execute("select id, reportid, params from " . TABLE_REPORT_FIELDS . " where entrytype = 'pagelist'");
  while(!$result->EOF) {
    $params = unserialize($result->fields['params']);
    $dates = $db->Execute("select id, fieldname, displaydesc, params from " . TABLE_REPORT_FIELDS . " 
	   where reportid = " . $result->fields['reportid'] . " and entrytype = 'dateselect'");
	if ($dates->RecordCount() > 0) {
	  $params['datedefault'] = $dates->fields['params'];
	  $params['datefield']   = $dates->fields['fieldname'];
	  $params['dateselect']  = $dates->fields['displaydesc'];
	  $db->Execute("update " . TABLE_REPORT_FIELDS . " set params = '" . serialize($params) . "' 
	    where id = " . $result->fields['id']);
	  $db->Execute("delete from " . TABLE_REPORT_FIELDS . " where id = " . $dates->fields['id']);
	}
	$result->MoveNext();
  }

  // move the form page break field to the page properties as part of the page setup
  $result = $db->Execute("select f.id, f.reportid, f.params 
    from " . TABLE_REPORTS . " r inner join " . TABLE_REPORT_FIELDS . " f on r.id = f.reportid
	where r.reporttype = 'frm' and f.entrytype = 'pagelist'");
  while(!$result->EOF) {
    $params = unserialize($result->fields['params']);
    $brkfield = $db->Execute("select id, fieldname from " . TABLE_REPORT_FIELDS . " 
	   where reportid = " . $result->fields['reportid'] . " and entrytype = 'grouplist'");
	if ($brkfield->RecordCount() > 0) {
	  $params['formbreakfield'] = $brkfield->fields['fieldname'];
	  $db->Execute("update " . TABLE_REPORT_FIELDS . " set params = '" . serialize($params) . "' 
	    where id = " . $result->fields['id']);
	  $db->Execute("delete from " . TABLE_REPORT_FIELDS . " where id = " . $brkfield->fields['id']);
	}
	$result->MoveNext();
  }
}

?>