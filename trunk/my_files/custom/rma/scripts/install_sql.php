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
//  Path: /modules/rma/scripts/install_sql.php
//

$tables[TABLE_RMA] = "
	CREATE TABLE " . TABLE_RMA  . " (
	  id int(11) NOT NULL auto_increment,
	  rma_num varchar(16) NOT NULL,
	  entered_by int(11) default NULL,
	  return_code int(11) default NULL,
	  purchase_invoice_id varchar(24) default NULL,
	  caller_name varchar(32) NOT NULL default '',
	  caller_telephone1 varchar(32) NOT NULL default '',
	  caller_email varchar(48) default NULL,
	  caller_notes varchar(255) default NULL,
	  `status` varchar(3) NOT NULL default '',
	  received_by int(11) default NULL,
	  receive_carrier varchar(24) default NULL,
	  receive_tracking varchar(32) default NULL,
	  receive_notes varchar(255) default NULL,
	  creation_date date NOT NULL default '0000-00-00',
	  receive_date date NOT NULL default '0000-00-00',
	  closed_date date NOT NULL default '0000-00-00',
	  PRIMARY KEY  (id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

$tables[TABLE_RMA_ITEM] = "
	CREATE TABLE " . TABLE_RMA_ITEM  . " (
	  id int(11) NOT NULL auto_increment,
	  ref_id int(11) NOT NULL default '0',
	  qty float NOT NULL default '0',
	  sku varchar(16) NOT NULL default '',
	  item_action int(11) default NULL,
	  item_notes varchar(255) default NULL,
	  PRIMARY KEY  (id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

?>