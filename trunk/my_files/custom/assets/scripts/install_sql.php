<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2007-2008 PhreeSoft, LLC                          |
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
//  Path: /modules/assets/scripts/install_sql.php
//

$tables[TABLE_ASSETS] = "
	CREATE TABLE " . TABLE_ASSETS  . " (
	  id int(11) NOT NULL auto_increment,
	  asset_id varchar(32) NOT NULL default '',
	  inactive enum('0','1') NOT NULL default '0',
	  asset_type char(2) NOT NULL default 'si',
	  serial_number varchar(32) NOT NULL default '',
	  description_short varchar(32) NOT NULL default '',
	  description_long varchar(255) default NULL,
	  image_with_path varchar(255) default NULL,
	  account_asset varchar(15) default NULL,
	  account_depreciation varchar(15) default '',
	  account_maintenance varchar(15) default NULL,
	  asset_cost float NOT NULL default '0',
	  depreciation_method enum('a','f','l') NOT NULL default 'f',
	  full_price float NOT NULL default '0',
	  acquisition_date date NOT NULL default '0000-00-00',
	  maintenance_date date NOT NULL default '0000-00-00',
	  terminal_date date NOT NULL default '0000-00-00',
	  PRIMARY KEY (id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

$tables[TABLE_ASSETS_FIELDS] = "
	CREATE TABLE " . TABLE_ASSETS_FIELDS  . " (
	  id int(10) NOT NULL auto_increment,
	  category_id int(11) NOT NULL default '0',
	  entry_type varchar(20) NOT NULL default '',
	  field_name varchar(32) NOT NULL default '',
	  description varchar(64) NOT NULL default '',
	  params text,
	  PRIMARY KEY (id)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;";

$tables[TABLE_ASSETS_HISTORY] = "
	CREATE TABLE " . TABLE_ASSETS_HISTORY . " (
	  id int(11) NOT NULL auto_increment,
	  asset_id varchar(32) NOT NULL default '',
	  total_amount float NOT NULL default '0',
	  action_date datetime default NULL,
	  params text,
	  PRIMARY KEY (id),
	  KEY asset_id (asset_id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

$tables[TABLE_ASSETS_TABS] = "
	CREATE TABLE " . TABLE_ASSETS_TABS  . " (
	  category_id int(3) NOT NULL auto_increment,
	  category_name varchar(32) NOT NULL default '',
	  sort_order int(2) NOT NULL default '0',
	  category_description varchar(80) NOT NULL default '',
	  PRIMARY KEY (category_id)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

?>