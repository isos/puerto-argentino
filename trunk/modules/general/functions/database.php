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
//  Path: /modules/general/functions/database.php
//

  function db_perform($table, $data, $action = 'insert', $parameters = '', $link = 'db_link') {
    global $db;
    reset($data);
    if ($action == 'insert') {
      $query = 'insert into ' . $table . ' (';
      while (list($columns, ) = each($data)) {
        $query .= $columns . ', ';
      }
      $query = substr($query, 0, -2) . ') values (';
      reset($data);
      while (list(, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= 'now(), ';
            break;
          case 'null':
            $query .= 'null, ';
            break;
          default:
            $query .= '\'' . db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ')';
    } elseif ($action == 'update') {
      $query = 'update ' . $table . ' set ';
      while (list($columns, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= $columns . ' = now(), ';
            break;
          case 'null':
            $query .= $columns .= ' = null, ';
            break;
          default:
            $query .= $columns . ' = \'' . db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ' where ' . $parameters;
    }
//echo 'includes/functions/database.php sql = ' . $query . '<br />';
    return $db->Execute($query);
  }

  function db_insert_id() {
    return mysql_insert_id();
  }

  function db_input($string) {
    return addslashes($string);
  }

  function db_prepare_input($string, $required = false) {
    if (is_string($string)) {
      $temp = trim(stripslashes($string));
	  if ($required && (strlen($temp) == 0)) {
	  	return false;
	  } else {
	    return $temp;
	  }
    } elseif (is_array($string)) {
      reset($string);
      while (list($key, $value) = each($string)) {
        $string[$key] = db_prepare_input($value);
      }
      return $string;
    } else {
      return $string;
    }
  }

  function db_executeSql($sql_file, $database, $table_prefix = '', $isupgrade = false) {
    if (!defined('DB_PREFIX')) define('DB_PREFIX',$table_prefix);
//echo 'start SQL execute';
    global $db;
    $ignored_count = 0;
    // prepare for upgrader processing 
//    if ($isupgrade) gen_create_upgrader_table(); // only creates table if doesn't already exist

    if (!get_cfg_var('safe_mode')) {
      @set_time_limit(1200);
    }

    $lines = file($sql_file);
//echo 'read number of lines = ' . count($lines) . '<br />';
    $newline = '';
    foreach ($lines as $line) {
      $line = trim($line);
      $keep_together = 1; // count of number of lines to treat as a single command

      // split the line into words ... starts at $param[0] and so on.  Also remove the ';' from end of last param if exists
      $param=explode(" ",(substr($line,-1) == ';') ? substr($line,0,strlen($line) - 1) : $line);

      // The following command checks to see if we're asking for a block of commands to be run at once.
      // Syntax: #NEXT_X_ROWS_AS_ONE_COMMAND:6     for running the next 6 commands together (commands denoted by a ;)
      if (substr($line,0,28) == '#NEXT_X_ROWS_AS_ONE_COMMAND:') $keep_together = substr($line,28);
      if (substr($line,0,1) != '#' && substr($line,0,1) != '-' && $line != '') {
          $line_upper=strtoupper($line);
          switch (true) {
          case (substr($line_upper, 0, 21) == 'DROP TABLE IF EXISTS '):
            $line = 'DROP TABLE IF EXISTS ' . $table_prefix . substr($line, 21);
            break;
          case (substr($line_upper, 0, 11) == 'DROP TABLE ' && $param[2] != 'IF'):
            if (!$checkprivs = db_check_database_privs('DROP')) $result=sprintf(REASON_NO_PRIVILEGES,'DROP');
            if (!install_table_exists($param[2]) || gen_not_null($result)) {
              install_write_to_upgrade_exceptions_table($line, (gen_not_null($result) ? $result : sprintf(REASON_TABLE_DOESNT_EXIST,$param[2])), $sql_file);
              $ignore_line=true;
              $result=(gen_not_null($result) ? $result : sprintf(REASON_TABLE_DOESNT_EXIST,$param[2])); //duplicated here for on-screen error-reporting
              break;
            } else {
              $line = 'DROP TABLE ' . $table_prefix . substr($line, 11);
            }
            break;
          case (substr($line_upper, 0, 13) == 'CREATE TABLE '):
            // check to see if table exists
            $table = (strtoupper($param[2].' '.$param[3].' '.$param[4]) == 'IF NOT EXISTS') ? $param[5] : $param[2];
            $result=install_table_exists($table);
            if ($result==true) {
              install_write_to_upgrade_exceptions_table($line, sprintf(REASON_TABLE_ALREADY_EXISTS,$table), $sql_file);
              $ignore_line=true;
              $result=sprintf(REASON_TABLE_ALREADY_EXISTS,$table); //duplicated here for on-screen error-reporting
              break;
            } else {
              $line = (strtoupper($param[2].' '.$param[3].' '.$param[4]) == 'IF NOT EXISTS') ? 'CREATE TABLE IF NOT EXISTS ' . $table_prefix . substr($line, 27) : 'CREATE TABLE ' . $table_prefix . substr($line, 13);
            }
            break;
          case (substr($line_upper, 0, 12) == 'INSERT INTO '):
            //check to see if table prefix is going to match
			$param[2] = str_replace('`', '', $param[2]);
            if (!$tbl_exists = install_table_exists($param[2])) $result=sprintf(REASON_TABLE_NOT_FOUND,$param[2]).' CHECK PREFIXES!';
            // check to see if INSERT command may be safely executed for "configuration" or "product_type_layout" tables
            if (($param[2]=='configuration'       && ($result=install_check_config_key($line))) or 
                (!$tbl_exists)    ) {
              install_write_to_upgrade_exceptions_table($line, $result, $sql_file);
              $ignore_line=true;
              break;
            } else {
              $line = 'INSERT INTO ' . $table_prefix . substr($line, 12);
            }
            break;
          case (substr($line_upper, 0, 12) == 'ALTER TABLE '):
            // check to see if ALTER command may be safely executed
            if ($result=install_check_alter_command($param)) {
              install_write_to_upgrade_exceptions_table($line, $result, $sql_file);
              $ignore_line=true;
              break;
            } else {
              $line = 'ALTER TABLE ' . $table_prefix . substr($line, 12);
            }
            break;
          case (substr($line_upper, 0, 13) == 'RENAME TABLE '):
            // RENAME TABLE command cannot be parsed to insert table prefixes, so skip if using prefixes
            if (gen_not_null(DB_PREFIX)) {
              install_write_to_upgrade_exceptions_table($line, 'RENAME TABLE command not supported by upgrader. Please use phpMyAdmin instead.', $sql_file);
              $ignore_line=true;
            }
            break;
          case (substr($line_upper, 0, 7) == 'UPDATE '):
            //check to see if table prefix is going to match
            if (!$tbl_exists = install_table_exists($param[1])) {
              install_write_to_upgrade_exceptions_table($line, sprintf(REASON_TABLE_NOT_FOUND,$param[1]).' CHECK PREFIXES!', $sql_file);
              $result=sprintf(REASON_TABLE_NOT_FOUND,$param[1]).' CHECK PREFIXES!';
              $ignore_line=true;
              break;
            } else {
            $line = 'UPDATE ' . $table_prefix . substr($line, 7);
            }
            break;
          case (substr($line_upper, 0, 12) == 'DELETE FROM '):
            $line = 'DELETE FROM ' . $table_prefix . substr($line, 12);
            break;
          case (substr($line_upper, 0, 11) == 'DROP INDEX '):
            // check to see if DROP INDEX command may be safely executed
            if ($result=install_drop_index_command($param)) {
              install_write_to_upgrade_exceptions_table($line, $result, $sql_file);
              $ignore_line=true;
              break;
            } else {
              $line = 'DROP INDEX ' . $param[2] . ' ON ' . $table_prefix . $param[4];
            }
            break;
          case (substr($line_upper, 0, 13) == 'CREATE INDEX ' || (strtoupper($param[0])=='CREATE' && strtoupper($param[2])=='INDEX')):
            // check to see if CREATE INDEX command may be safely executed
            if ($result=install_create_index_command($param)) {
              install_write_to_upgrade_exceptions_table($line, $result, $sql_file);
              $ignore_line=true;
              break;
            } else {
              if (strtoupper($param[1])=='INDEX') {
                $line = trim('CREATE INDEX ' . $param[2] .' ON '. $table_prefix . implode(' ',array($param[4],$param[5],$param[6],$param[7],$param[8],$param[9],$param[10],$param[11],$param[12],$param[13])) ).';'; // add the ';' back since it was removed from $param at start
              } else {
                $line = trim('CREATE '. $param[1] .' INDEX ' .$param[3]. ' ON '. $table_prefix . implode(' ',array($param[5],$param[6],$param[7],$param[8],$param[9],$param[10],$param[11],$param[12],$param[13])) ); // add the ';' back since it was removed from $param at start
              }
            }
            break;
          case (substr($line_upper, 0, 8) == 'SELECT (' && substr_count($line,'FROM ')>0):
            $line = str_replace('FROM ','FROM '. $table_prefix, $line);
            break;
          case (substr($line_upper, 0, 10) == 'LEFT JOIN '):
            $line = 'LEFT JOIN ' . $table_prefix . substr($line, 10);
            break;
          case (substr($line_upper, 0, 5) == 'FROM '):
            if (substr_count($line,',')>0) { // contains FROM and a comma, thus must parse for multiple tablenames
              $tbl_list = explode(',',substr($line,5));
              $line = 'FROM ';
              foreach($tbl_list as $val) {
                $line .= $table_prefix . trim($val) . ','; // add prefix and comma
              } //end foreach
              if (substr($line,-1)==',') $line = substr($line,0,(strlen($line)-1)); // remove trailing ','
            } else { //didn't have a comma, but starts with "FROM ", so insert table prefix
              $line = str_replace('FROM ', 'FROM '.$table_prefix, $line); 
            }//endif substr_count(,)
            break;
          default:
            break;
          } //end switch
        $newline .= $line . ' ';

        if ( substr($line,-1) ==  ';') {
          //found a semicolon, so treat it as a full command, incrementing counter of rows to process at once
          if (substr($newline,-1)==' ') $newline = substr($newline,0,(strlen($newline)-1)); 
          $lines_to_keep_together_counter++; 
          if ($lines_to_keep_together_counter == $keep_together) { // if all grouped rows have been loaded, go to execute.
            $complete_line = true;
            $lines_to_keep_together_counter=0;
          } else {
            $complete_line = false;
          }
        } //endif found ';'

        if ($complete_line) {
          if ($debug==true) echo ((!$ignore_line) ? '<br />About to execute.': 'Ignoring statement. This command WILL NOT be executed.').'<br />Debug info:<br />$ line='.$line.'<br />$ complete_line='.$complete_line.'<br />$ keep_together='.$keep_together.'<br />SQL='.$newline.'<br /><br />';
          if (get_magic_quotes_runtime() > 0) $newline=stripslashes($newline);
          if (trim(str_replace(';','',$newline)) != '' && !$ignore_line) $output=$db->Execute($newline);
          $results++;
          $string .= $newline.'<br />';
          $return_output[]=$output;
          if (gen_not_null($result)) $errors[]=$result;
          // reset var's
          $newline = '';
          $keep_together=1;
          $complete_line = false;
          if ($ignore_line) $ignored_count++;
          $ignore_line=false;

          // show progress bar
          global $zc_show_progress;
          if ($zc_show_progress=='yes') {
             $counter++;
             if ($counter/5 == (int)($counter/5)) echo '~ ';
             if ($counter>200) {
               echo '<br /><br />';
               $counter=0;
             }
             @ob_flush();
             @flush();
          }
        } //endif $complete_line
      } //endif ! # or -
    } // end foreach $lines
    return array('queries'=> $results, 'string'=>$string, 'output'=>$return_output, 'ignored'=>($ignored_count), 'errors'=>$errors);
  } //end function

?>