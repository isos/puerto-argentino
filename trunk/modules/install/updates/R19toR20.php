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
//  Path: /modules/install/updates/R19toR20.php
//

// This script updates Release 1.9 to Release 2.0, it is included as part of the updater script

// *************************** IMPORTANT UPDATE INFORMATION *********************************//


//********************************* END OF IMPORTANT ****************************************//
// Release 1.9 to 2.0

$fields = mysql_list_fields(DB_DATABASE, TABLE_CHART_OF_ACCOUNTS);
$columns = mysql_num_fields($fields);
$field_array[] = array();
for ($i = 0; $i < $columns; $i++) $field_array[] = mysql_field_name($fields, $i);
if (!in_array('heading_only', $field_array)) {
  $db->Execute("ALTER TABLE " . TABLE_CHART_OF_ACCOUNTS . " ADD heading_only ENUM('0', '1') NOT NULL DEFAULT '0' AFTER description");
  $db->Execute("ALTER TABLE " . TABLE_CHART_OF_ACCOUNTS . " ADD INDEX (heading_only)");
  $db->Execute("ALTER TABLE " . TABLE_CHART_OF_ACCOUNTS . " DROP subaccount");  
  $db->Execute("ALTER TABLE " . TABLE_CHART_OF_ACCOUNTS . " DROP next_ref");  
}

if (!defined('AR_DEF_DEPOSIT_ACCT')) {
  $db->Execute("INSERT INTO " .  TABLE_CONFIGURATION . " 
           ( `configuration_title` , `configuration_key` , `configuration_value` , `configuration_description` , `configuration_group_id` , `sort_order` , `last_modified` , `date_added` , `use_function` , `set_function` ) 
    VALUES ( 'CD_02_06_TITLE', 'AR_DEF_DEPOSIT_ACCT', '', 'CD_02_06_DESC', '2', '6', NULL , now(), NULL , 'cfg_pull_down_gl_acct_list(' );");
  $db->Execute("INSERT INTO " .  TABLE_CONFIGURATION . " 
           ( `configuration_title` , `configuration_key` , `configuration_value` , `configuration_description` , `configuration_group_id` , `sort_order` , `last_modified` , `date_added` , `use_function` , `set_function` ) 
    VALUES ( 'CD_03_06_TITLE', 'AP_DEF_DEPOSIT_ACCT', '', 'CD_03_06_DESC', '3', '6', NULL , now(), NULL , 'cfg_pull_down_gl_acct_list(' );");

  // fix the sequencing bug in the dashboard table by re-sequencing
  $result = $db->Execute("select * from " . TABLE_USERS_PROFILES . " order by user_id, page_id, column_id, row_id");
  $row       = 1;
  $last_user = 0; 
  $last_page = ''; 
  $last_col  = 0;
  while(!$result->EOF) {
	$cur_user = $result->fields['user_id']; 
	$cur_page = $result->fields['page_id']; 
	$cur_col  = $result->fields['column_id'];
	$db->Execute("update " . TABLE_USERS_PROFILES . " set row_id = " . $row . " where id = " . $result->fields['id']);
	$row++;
    $result->MoveNext();
	if ($cur_user <> $result->fields['user_id'] || $cur_page <> $result->fields['page_id'] || $cur_col <> $result->fields['column_id']) $row = 1;
  }
}

$fields = mysql_list_fields(DB_DATABASE, TABLE_CURRENCIES);
$columns = mysql_num_fields($fields);
$field_array[] = array();
for ($i = 0; $i < $columns; $i++) $field_array[] = mysql_field_name($fields, $i);
if (!in_array('decimal_precise', $field_array)) {
  $db->Execute("ALTER TABLE " . TABLE_CURRENCIES . " ADD decimal_precise CHAR(1) NOT NULL DEFAULT '2' AFTER decimal_places");
  $db->Execute("UPDATE " . TABLE_CURRENCIES . " set decimal_precise = decimal_places");

  // add price_sheet field to inventory table
  $db->Execute("ALTER TABLE " . TABLE_INVENTORY . " ADD price_sheet VARCHAR(32) NULL AFTER cost_method");
  require_once(DIR_FS_ADMIN . 'modules/inventory/functions/inventory.php');
  inv_sync_inv_field_list();
}

if (!defined('ORD_ENABLE_LINE_ITEM_BAR_CODE')) {
  $db->Execute("INSERT INTO " .  TABLE_CONFIGURATION . " 
           ( `configuration_title` , `configuration_key` , `configuration_value` , `configuration_description` , `configuration_group_id` , `sort_order` , `last_modified` , `date_added` , `use_function` , `set_function` ) 
    VALUES ( 'CD_05_65_TITLE', 'ORD_ENABLE_LINE_ITEM_BAR_CODE', '0', 'CD_05_65_DESC', '5', '65', NULL , now(), NULL, 'cfg_keyed_select_option(array(0 =>\'" . TEXT_NO . "\', 1=>\'" . TEXT_YES . "\'),' );");
  $db->Execute("INSERT INTO " .  TABLE_CONFIGURATION . " 
           ( `configuration_title` , `configuration_key` , `configuration_value` , `configuration_description` , `configuration_group_id` , `sort_order` , `last_modified` , `date_added` , `use_function` ) 
    VALUES ( 'CD_05_70_TITLE', 'ORD_BAR_CODE_LENGTH', '12', 'CD_05_70_DESC', '5', '70', NULL , now(), NULL );");
  $db->Execute("INSERT INTO " .  TABLE_CONFIGURATION . " 
           ( `configuration_title` , `configuration_key` , `configuration_value` , `configuration_description` , `configuration_group_id` , `sort_order` , `last_modified` , `date_added` , `use_function` , `set_function` ) 
    VALUES ( 'CD_15_05_TITLE', 'SESSION_AUTO_REFRESH', '0', 'CD_15_05_DESC', '15', '5', NULL , now(), NULL, 'cfg_keyed_select_option(array(0 =>\'" . TEXT_NO . "\', 1=>\'" . TEXT_YES . "\'),' );");

  // update the reconcilliation from journal_main to journal_item
  // build the array of cash accounts
  $result = $db->Execute("select id from " . TABLE_CHART_OF_ACCOUNTS. " where account_type = 0 order by id");
  $account_array = array();
  while (!$result->EOF) {
    $account_array[] = $result->fields['id'];
    $result->MoveNext();
  }

  $result = $db->Execute("SELECT id FROM " . TABLE_JOURNAL_MAIN . " WHERE closed = '1' and journal_id in (2, 18, 20)");
  while (!$result->EOF) {
    $db->Execute("UPDATE " . TABLE_JOURNAL_ITEM . " SET reconciled = 1 WHERE 
  	  ref_id = " . $result->fields['id'] . " AND gl_account IN ('" . implode("','", $account_array) . "')");
    $result->MoveNext();
  }
}

if (!defined('ENABLE_AUTO_ITEM_COST')) {
  $db->Execute("INSERT INTO " .  TABLE_CONFIGURATION . " 
           ( `configuration_title` , `configuration_key` , `configuration_value` , `configuration_description` , `configuration_group_id` , `sort_order` , `last_modified` , `date_added` , `use_function` , `set_function` ) 
    VALUES ( 'CD_05_75_TITLE', 'ENABLE_AUTO_ITEM_COST', '0', 'CD_05_75_DESC', '5', '75', NULL , now(), NULL, 'cfg_keyed_select_option(array(0=>\'" . TEXT_NO . "\', \'PO\'=>\'" . TEXT_PURCH_ORDER . "\', \'PR\'=>\'" . TEXT_PURCHASE . "\'),' );");
}

?>