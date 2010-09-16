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
//  Path: /modules/install/updates/R18toR19.php
//

// This script updates Release 1.8 to Release 1.9, it is included as part of the updater script

// *************************** IMPORTANT UPDATE INFORMATION *********************************//


//********************************* END OF IMPORTANT ****************************************//
// Release 1.8 to 1.9

if (!file_exists(DIR_FS_MY_FILES . $_SESSION['company'] . '/index.html')) {
  install_blank_webpage(DIR_FS_MY_FILES . '/index.html');
  install_blank_webpage(DIR_FS_MY_FILES . 'backups/index.html');
  install_blank_webpage(DIR_FS_MY_FILES . $_SESSION['company'] . '/index.html');
}

$fields = mysql_list_fields(DB_DATABASE, TABLE_JOURNAL_MAIN);
$columns = mysql_num_fields($fields);
$field_array[] = array();
for ($i = 0; $i < $columns; $i++) $field_array[] = mysql_field_name($fields, $i);
if (!in_array('printed', $field_array)) {
  $db->Execute("ALTER TABLE " . TABLE_JOURNAL_MAIN . " ADD printed enum('0','1') NOT NULL DEFAULT '0' AFTER closed");
  $db->Execute("ALTER TABLE " . TABLE_JOURNAL_MAIN . " ADD INDEX (closed)");
  $db->Execute("ALTER TABLE " . TABLE_JOURNAL_MAIN . " ADD INDEX (bill_acct_id)");
}

$fields  = mysql_list_fields(DB_DATABASE, TABLE_JOURNAL_ITEM);
$columns = mysql_num_fields($fields);
$field_array = array();
for ($i = 0; $i < $columns; $i++) $field_array[] = mysql_field_name($fields, $i);
if (!in_array('project_id', $field_array)) {
  $db->Execute("CREATE TABLE " . TABLE_PROJECTS_PHASES . " (
	phase_id int(8) NOT NULL auto_increment,
	description_short varchar(16) collate utf8_unicode_ci NOT NULL default '',
	description_long varchar(64) collate utf8_unicode_ci NOT NULL default '',
	cost_type varchar(3) collate utf8_unicode_ci default NULL,
	cost_breakdown enum('0','1') collate utf8_unicode_ci NOT NULL default '0',
	inactive enum('0','1') collate utf8_unicode_ci NOT NULL default '0',
	PRIMARY KEY (phase_id),
	KEY description_short (description_short)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Project Phases used for Job Costing'");

  $db->Execute("CREATE TABLE " . TABLE_PROJECTS_COSTS . " (
	cost_id int(8) NOT NULL auto_increment,
	description_short varchar(16) collate utf8_unicode_ci NOT NULL default '',
	description_long varchar(64) collate utf8_unicode_ci NOT NULL default '',
	cost_type varchar(3) collate utf8_unicode_ci default NULL,
	inactive enum('0','1') collate utf8_unicode_ci NOT NULL default '0',
	PRIMARY KEY (cost_id),
	KEY description_short (description_short)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Project Costs used for Job Phase Breakdown'");

  $db->Execute("ALTER TABLE " . TABLE_JOURNAL_ITEM . " ADD project_id VARCHAR(16) NULL AFTER serialize_number");
}

if (!defined('ROUND_TAX_BY_AUTH')) {
  $db->Execute("INSERT INTO " .  TABLE_CONFIGURATION . " 
           ( `configuration_title` , `configuration_key` , `configuration_value` , `configuration_description` , `configuration_group_id` , `sort_order` , `last_modified` , `date_added` , `use_function` , `set_function` ) 
    VALUES ( 'CD_01_52_TITLE', 'ROUND_TAX_BY_AUTH', '0', 'CD_01_52_DESC', '1', '52', NULL , now(), NULL , 'cfg_keyed_select_option(array(0 =>\'" . TEXT_NO . "\', 1=>\'" . TEXT_YES . "\'),' );");

  // add gl_type to adjustments for ajaz page loading
  $result = $db->Execute("update " . TABLE_JOURNAL_MAIN . " m inner join " . TABLE_JOURNAL_ITEM . " i on m.id = i.ref_id 
	set i.gl_type = 'adj' where m.journal_id = 16 and i.gl_type = '' and i.sku <> ''");
  $result = $db->Execute("update " . TABLE_JOURNAL_MAIN . " m inner join " . TABLE_JOURNAL_ITEM . " i on m.id = i.ref_id 
	set i.gl_type = 'ttl' where m.journal_id = 16 and i.gl_type = '' and i.sku = ''");
  // change printed type to integer for incrmenting print counts of a record
  $result = $db->Execute("ALTER TABLE " . TABLE_JOURNAL_MAIN . " CHANGE printed printed INT( 11 ) NOT NULL DEFAULT '0'");

  // update reports
  require_once(DIR_FS_MODULES . 'install/functions/install.php');
  update_reports();
}

?>