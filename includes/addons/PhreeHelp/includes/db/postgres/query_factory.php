<?php
// +--------------------------------------------------------+
// |            PhreeHelp Open Source Help System           |
// +--------------------------------------------------------+
// | Copyright (c) 2009 PhreeSoft, LLC                      |
// | http://www.phreesoft.com                               |
// | Portions Copyright (c) 2003 osCommerce, 2005 ZenCart   |
// +--------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL  |
// | license that is bundled with this package in the file: |
// | /doc/manual/ch01-Introduction/license.html             |
// +--------------------------------------------------------+
//  Path: /includes/db/postgres/query_factory.php
//

class queryFactory {

  function queryFactory() {
    $this->count_queries = 0;
  }

  function connect($zf_host, $zf_user, $zf_password, $zf_database, $zf_pconnect=false, $zp_real=false) {
//@TODO error class required to virtualise & centralise all error reporting/logging/debugging 
    $this->database = $zf_database;
    $zp_conn_string = "host=" . $zf_host . " dbname=" . $zf_database . " user=" . $zf_user . " password=" . $zf_password; 
    if (!$zf_pconnect) {
      $this->link = @pg_connect($zp_conn_string);
    } else {
      $this->link = @pg_pconnect($zp_conn_string);
    }
    if ($this->link) {
      $this->db_connected = true;
      return true;
    } else {
      $this->set_error(pg_last_error(), $zp_real);  
      return false;
    }
  }  

  function prepare_input($zp_string) {
    if (function_exists('pg_escape_string')) {
      return pg_escape_string($zp_string);
    } else {
      return addslashes($zp_string);
    }
  }
  
  function close() {
    @pg_close($this->zp_db_resource);
  }
  
  function set_error($zp_err_text, $zp_fatal = true) {
    $this->error_text = $zp_err_text;
    if ($zp_fatal) {
      $this->show_error();
      die();
    } 
  }
  
  function show_error() {
    echo $this->error_text;
    echo $this->query;
  }
  
  function Execute($zf_sql, $zf_limit = false, $zf_cache = false, $zf_cachetime=0) {
    if ($zf_limit) {
      $zf_sql = $zf_sql . ' LIMIT ' . $zf_limit;
    }
    $this->query = $zf_sql;
    $time_start = explode(' ', microtime());
    $obj = new queryFactoryResult;
    if (!$this->db_connected) $this->set_error('0', DB_ERROR_NOT_CONNECTED);
    $zp_db_resource = @pg_query($this->link, $zf_sql);
    if (!$zp_db_resource) $this->set_error(pg_last_error());
    $obj->resource = $zp_db_resource;
    $obj->cursor = 0;
    if ($obj->RecordCount() > 0) {
      $obj->EOF = false;
      $zp_result_array = @pg_fetch_array($zp_db_resource, NULL, PGSQL_ASSOC);
      if ($zp_result_array) {
        while (list($key, $value) = each($zp_result_array)) {
          if (!preg_match('/^[0-9]/', $key)) {
            $obj->fields[strtolower($key)] = $value;
          }
        }            
        $obj->EOF = false;
      } else {
        $obj->EOF = true;
      }      
    } else {
      $obj->EOF = true;
    }
    
    $time_end = explode (' ', microtime());
    $query_time = $time_end[1]+$time_end[0]-$time_start[1]-$time_start[0];
    $this->total_query_time += $query_time;
    $this->count_queries++;
    return($obj);
  }
    
  function insert_ID() {
    return @pg_last_oid($this->zp_db_resource);
  }
  
  function metaColumns($zp_table) {
    $res = @pg_query($this->link, "select * from " . $zp_table . " limit 1");
    $num_fields = @pg_num_fields($res);
    for ($i = 0; $i < $num_fields; $i++) {
     $obj[strtoupper(@pg_field_name($res, $i))] = new queryFactoryMeta($i, $res);
    }
    return $obj;

  }
  
  function get_server_info() {
    if ($this->link) {
      return mysql_get_server_info($this->link);
    } else {
      return UNKNOWN;
    }
  }
  
  function queryCount() {
    return $this->count_queries;
  }
  
  function queryTime() {
    return $this->total_query_time;
  }

}

class queryFactoryResult {

  function MoveNext() {
    $zp_result_array = @pg_fetch_array($this->resource, NULL, PGSQL_ASSOC);
    if (!$zp_result_array) {
      $this->EOF = true;
    } else {
	  $this->cursor++;
      while (list($key, $value) = each($zp_result_array)) {
        if (!preg_match('/^[0-9]/', $key)) {
		  $this->fields[strtolower($key)] = $value;
	}
      }
    } 
  }

  function MoveNextRandom() {
    $this->cursor++;
//    echo 'cursor = ' . $this->cursor . '<br />';
//    echo 'limit = ' . $this->Limit . '<br />';
    if ($this->cursor < $this->Limit) {
      $zp_result_array = $this->result[$this->result_random[$this->cursor]];
      while (list($key, $value) = each($zp_result_array)) {
        if (!preg_match('/^[0-9]/', $key)) {
          $this->fields[$key] = $value;
	}
      }
    } else {
      $this->EOF = true;
    } 
  }
  
  function RecordCount() {
    return @pg_num_rows($this->resource);
  }

  function Move($zp_row) {
    global $db;
    if (@pg_result_seek($this->resource, $zp_row)) {
      return;
    } else {
      $db->set_error(pg_last_error());
    }   
  }
}

class queryFactoryMeta {

  function queryFactoryMeta($zp_field, $zp_res) {
    $this->type = @pg_field_type($zp_res, $zp_field);
    $this->max_length = @pg_field_len($zp_res, $zp_field);
  }
}
?>