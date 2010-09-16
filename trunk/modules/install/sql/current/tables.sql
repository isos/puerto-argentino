-- phpMyAdmin SQL Dump
-- version 2.9.1
-- http://www.phpmyadmin.net
-- 
-- Host: PhreeSoft, LLC
-- MySQL Server version: 5.0.26
-- PHP Version: 5.2.0
-- File Location: /modules/install/sql/current/tables.sql

-- --------------------------------------------------------

-- 
-- Table structure for table accounting_periods
-- 

CREATE TABLE accounting_periods (
  period int(11) NOT NULL default '0',
  fiscal_year int(11) NOT NULL default '0',
  start_date date NOT NULL default '0000-00-00',
  end_date date NOT NULL default '0000-00-00',
  date_added date NOT NULL default '0000-00-00',
  last_update timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (period)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Defines accounting periods and dates';

-- --------------------------------------------------------

-- 
-- Table structure for table accounts_history
-- 

CREATE TABLE accounts_history (
  id int(11) NOT NULL auto_increment,
  ref_id int(11) NOT NULL default '0',
  acct_id int(11) NOT NULL default '0',
  amount double NOT NULL default '0',
  journal_id int(2) NOT NULL default '0',
  purchase_invoice_id char(24) default NULL,
  so_po_ref_id int(11) default NULL,
  post_date datetime default NULL,
  PRIMARY KEY  (id),
  KEY acct_id (acct_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Customer/Vendor Activity History' ;

-- --------------------------------------------------------

-- 
-- Table structure for table address_book
-- 

CREATE TABLE address_book (
  address_id int(11) NOT NULL auto_increment,
  ref_id int(11) NOT NULL default '0',
  type char(2) NOT NULL default '',
  primary_name varchar(32) NOT NULL default '',
  contact varchar(32) NOT NULL default '',
  address1 varchar(32) NOT NULL default '',
  address2 varchar(32) NOT NULL default '',
  city_town varchar(24) NOT NULL default '',
  state_province varchar(24) NOT NULL default '',
  postal_code varchar(10) NOT NULL default '',
  country_code char(3) NOT NULL default '',
  telephone1 VARCHAR(20) NULL DEFAULT '',
  telephone2 VARCHAR(20) NULL DEFAULT '',
  telephone3 VARCHAR(20) NULL DEFAULT '',
  telephone4 VARCHAR(20) NULL DEFAULT '',
  email VARCHAR(48) NULL DEFAULT '',
  website VARCHAR(48) NULL DEFAULT '',
  notes text,
  PRIMARY KEY  (address_id),
  KEY customer_id (ref_id,type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

-- 
-- Table structure for table audit_log
-- 

CREATE TABLE audit_log (
  id int(15) NOT NULL auto_increment,
  action_date timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  user_id int(11) NOT NULL default '0',
  reference_id varchar(32) NOT NULL default '',
  action varchar(64) default NULL,
  amount float(10,2) NOT NULL default '0.00',
  PRIMARY KEY  (id),
  KEY idx_page_accessed_zen (reference_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

-- 
-- Table structure for table chart_of_accounts
-- 

CREATE TABLE chart_of_accounts (
  id char(15) NOT NULL default '',
  description char(64) NOT NULL default '',
  heading_only enum('0','1') NOT NULL default '0',
  primary_acct_id char(15) default NULL,
  account_type tinyint(4) NOT NULL default '0',
  account_inactive enum('0','1') NOT NULL default '0',
  PRIMARY KEY (id),
  KEY type (account_type),
  KEY heading_only (heading_only)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table chart_of_accounts_history
-- 

CREATE TABLE chart_of_accounts_history (
  id int(11) NOT NULL auto_increment,
  period int(11) NOT NULL default '0',
  account_id char(15) NOT NULL default '',
  beginning_balance double NOT NULL default '0',
  debit_amount double NOT NULL default '0',
  credit_amount double NOT NULL default '0',
  budget double NOT NULL default '0',
  last_update date NOT NULL default '0000-00-00',
  PRIMARY KEY  (id),
  KEY period (period),
  KEY account_id (account_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Chart of Accounts Historical Data' ;

-- --------------------------------------------------------

-- 
-- Table structure for table chart_of_accounts_types
-- 

CREATE TABLE chart_of_accounts_types (
  id tinyint(4) NOT NULL default '0',
  description varchar(30) NOT NULL default '',
  asset enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table configuration
-- 

CREATE TABLE configuration (
  configuration_id int(11) NOT NULL auto_increment,
  configuration_title text,
  configuration_key varchar(255) NOT NULL default '',
  configuration_value text,
  configuration_description text,
  configuration_group_id int(11) NOT NULL default '0',
  sort_order int(5) default NULL,
  last_modified datetime default NULL,
  date_added datetime NOT NULL default '0001-01-01 00:00:00',
  use_function text,
  set_function text,
  PRIMARY KEY  (configuration_id),
  UNIQUE KEY unq_config_key_zen (configuration_key),
  KEY idx_cfg_grp_id_zen (configuration_group_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

-- 
-- Table structure for table contacts
-- 

CREATE TABLE contacts (
  id int(11) NOT NULL auto_increment,
  type char(1) NOT NULL default 'c',
  short_name varchar(20) NOT NULL default '',
  inactive enum('0','1') NOT NULL default '0',
  contact_first varchar(32) default NULL,
  contact_middle varchar(32) default NULL,
  contact_last varchar(32) default NULL,
  store_id varchar(15) NOT NULL default '',
  gl_type_account varchar(15) NOT NULL default '',
  gov_id_number varchar(16) NOT NULL default '',
  dept_rep_id varchar(16) NOT NULL default '',
  account_number varchar(16) NOT NULL default '',
  special_terms varchar(32) NOT NULL default '0',
  price_sheet varchar(32) default NULL,
  first_date date NOT NULL default '0000-00-00',
  last_update date default NULL,
  last_date_1 date default NULL,
  last_date_2 date default NULL,
  PRIMARY KEY  (id),
  KEY type (type),
  KEY short_name (short_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

-- 
-- Table structure for table countries
-- 

CREATE TABLE countries (
  countries_id int(11) NOT NULL auto_increment,
  countries_name varchar(64) NOT NULL default '',
  countries_iso_code_2 char(2) NOT NULL default '',
  countries_iso_code_3 char(3) NOT NULL default '',
  address_format_id int(11) NOT NULL default '0',
  PRIMARY KEY  (countries_id),
  KEY idx_countries_name_zen (countries_name)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

-- 
-- Table structure for table currencies
-- 

CREATE TABLE currencies (
  currencies_id int(11) NOT NULL auto_increment,
  title varchar(32) NOT NULL default '',
  code char(3) NOT NULL default '',
  symbol_left varchar(24) default NULL,
  symbol_right varchar(24) default NULL,
  decimal_point char(1) default NULL,
  thousands_point char(1) default NULL,
  decimal_places char(1) default NULL,
  decimal_precise char(1) NOT NULL default '2',
  value float(13,8) default NULL,
  last_updated datetime default NULL,
  PRIMARY KEY  (currencies_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

-- 
-- Table structure for table current_status
-- 

CREATE TABLE current_status (
  id int(11) NOT NULL auto_increment,
  next_po_num varchar(16) NOT NULL default '1',
  next_so_num varchar(16) NOT NULL default '1',
  next_inv_num varchar(16) NOT NULL default '1',
  next_check_num varchar(16) NOT NULL default '1',
  next_deposit_num varchar(16) NOT NULL default '1',
  next_shipment_num varchar(16) NOT NULL default '1',
  next_cm_num varchar(16) NOT NULL default '1',
  next_vcm_num varchar(16) NOT NULL default '1',
  next_ap_quote_num varchar(16) NOT NULL default '1',
  next_ar_quote_num varchar(16) NOT NULL default '1',
  next_cust_id_num varchar(16) NOT NULL default '1',
  next_vend_id_num varchar(16) NOT NULL default '1',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='System values for entry identification' ;

-- --------------------------------------------------------

-- 
-- Table structure for table data_security
-- 

CREATE TABLE data_security (
  id int(11) NOT NULL auto_increment,
  module varchar(32) NOT NULL DEFAULT '',
  ref_1 int(11) NOT NULL DEFAULT '0',
  ref_2 int(11) NOT NULL DEFAULT '0',
  hint varchar(255) NOT NULL DEFAULT '',
  enc_value varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Encryption data for storage';

-- --------------------------------------------------------

-- 
-- Table structure for table departments
-- 

CREATE TABLE departments (
  id int(11) NOT NULL auto_increment,
  description_short varchar(30) NOT NULL default '',
  description varchar(30) NOT NULL default '',
  subdepartment enum('0','1') NOT NULL default '0',
  primary_dept_id int(11) NOT NULL default '0',
  department_type tinyint(4) NOT NULL default '0',
  department_inactive enum('0','1') NOT NULL default '0',
  PRIMARY KEY (id),
  KEY type (department_type)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Departments for employee organization';

-- --------------------------------------------------------

-- 
-- Table structure for table departments_types
-- 

CREATE TABLE departments_types (
  id int(11) NOT NULL auto_increment,
  description varchar(30) NOT NULL default '',
  PRIMARY KEY (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Type descriptions for the departments' ;

-- --------------------------------------------------------

-- 
-- Table structure for table import_export
-- 

CREATE TABLE import_export (
  id int(11) NOT NULL auto_increment,
  group_id char(3) NOT NULL default '',
  custom enum('0','1') NOT NULL default '1',
  security varchar(10) NOT NULL default '',
  title varchar(32) NOT NULL default '',
  description varchar(255) NOT NULL default '',
  table_name varchar(32) NOT NULL default '',
  primary_key_field varchar(32) NOT NULL default '',
  params text,
  criteria text,
  options text,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Import-Export specifications' ;

-- --------------------------------------------------------

-- 
-- Table structure for table inventory
-- 

CREATE TABLE inventory (
  id int(11) NOT NULL auto_increment,
  sku varchar(24) NOT NULL default '',
  inactive enum('0','1') NOT NULL default '0',
  inventory_type char(2) NOT NULL default 'si',
  description_short varchar(32) NOT NULL default '',
  description_purchase varchar(255) default NULL,
  description_sales varchar(255) default NULL,
  image_with_path varchar(255) default NULL,
  account_sales_income varchar(15) default NULL,
  account_inventory_wage varchar(15) default '',
  account_cost_of_sales varchar(15) default NULL,
  item_taxable int(11) NOT NULL default '0',
  purch_taxable int(11) NOT NULL default '0',
  item_cost float NOT NULL default '0',
  cost_method enum('a','f','l') NOT NULL default 'f',
  price_sheet varchar(32) default NULL,
  full_price float NOT NULL default '0',
  item_weight float NOT NULL default '0',
  quantity_on_hand float NOT NULL default '0',
  quantity_on_order float NOT NULL default '0',
  quantity_on_sales_order float NOT NULL default '0',
  minimum_stock_level float NOT NULL default '0',
  reorder_quantity float NOT NULL default '0',
  vendor_id int(11) NOT NULL default '0',
  lead_time int(3) NOT NULL default '1',
  upc_code varchar(13) NOT NULL DEFAULT '',
  serialize enum('0','1') NOT NULL default '0',
  creation_date datetime NOT NULL default '0000-00-00 00:00:00',
  last_update datetime NOT NULL default '0000-00-00 00:00:00',
  last_journal_date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT = 'Primary inventory table';

-- --------------------------------------------------------

-- 
-- Table structure for table inventory_assy_list
-- 

CREATE TABLE inventory_assy_list (
  id int(11) NOT NULL auto_increment,
  ref_id int(11) NOT NULL default '0',
  sku varchar(24) NOT NULL default '',
  description varchar(32) NOT NULL default '',
  qty float NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY ref_id (ref_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Holds assembly list for inventory items of type: as' ;

-- --------------------------------------------------------

-- 
-- Table structure for table inventory_categories
-- 

CREATE TABLE inventory_categories (
  category_id int(3) NOT NULL auto_increment,
  category_name varchar(32) NOT NULL default '',
  sort_order int(2) NOT NULL default '0',
  category_description varchar(80) NOT NULL default '',
  PRIMARY KEY  (category_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

-- 
-- Table structure for table inventory_cogs_owed
-- 

CREATE TABLE inventory_cogs_owed (
  id int(11) NOT NULL auto_increment,
  journal_main_id int(11) NOT NULL default '0',
  store_id int(11) NOT NULL default '0',
  sku varchar(24) NOT NULL default '',
  qty float NOT NULL default '0',
  post_date date NOT NULL default '0000-00-00',
  PRIMARY KEY (id),
  KEY sku (sku),
  INDEX (store_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT = 'Stores inventory items not in stock for future posting';

-- --------------------------------------------------------

-- 
-- Table structure for table inventory_cogs_usage
-- 

CREATE TABLE inventory_cogs_usage (
  id int(11) NOT NULL auto_increment,
  journal_main_id int(11) NOT NULL default '0',
  qty float NOT NULL default '0',
  inventory_history_id int(11) NOT NULL default '0',
  PRIMARY KEY (id),
  INDEX (journal_main_id, inventory_history_id) 
) ENGINE=innodb DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT = 'Relates inventory usage with inventory purchase history';

-- --------------------------------------------------------

-- 
-- Table structure for table inventory_fields
-- 

CREATE TABLE inventory_fields (
  inv_field_id int(10) NOT NULL auto_increment,
  entry_type varchar(20) NOT NULL default '',
  field_name varchar(32) NOT NULL default '',
  description varchar(64) NOT NULL default '',
  category_id int(11) NOT NULL default '0',
  params text,
  PRIMARY KEY (inv_field_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

-- 
-- Table structure for table inventory_history
-- 

CREATE TABLE inventory_history (
  id int(11) NOT NULL auto_increment,
  ref_id int(11) NOT NULL default '0',
  store_id int(11) NOT NULL default '0',
  journal_id int(2) NOT NULL default '6',
  sku varchar(24) NOT NULL default '',
  qty float NOT NULL default '0',
  serialize_number varchar(24) NOT NULL default '',
  remaining float NOT NULL default '0',
  unit_cost float NOT NULL default '0',
  post_date datetime default NULL,
  PRIMARY KEY (id),
  KEY sku (sku),
  KEY ref_id (ref_id),
  KEY remaining (remaining),
  INDEX (store_id),
  INDEX (journal_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Inventory Purchase History Table';

-- --------------------------------------------------------

-- 
-- Table structure for table inventory_ms_list
-- 

CREATE TABLE inventory_ms_list (
  id int(11) NOT NULL auto_increment,
  sku varchar(24) NOT NULL default '',
  attr_name_0 varchar(16) NULL,
  attr_name_1 varchar(16) NULL,
  attr_0 varchar(255) NULL,
  attr_1 varchar(255) NULL, 
  PRIMARY KEY (id)
) ENGINE = InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT = 'Holds inventory master stock attribute information';

-- --------------------------------------------------------

-- 
-- Table structure for table inventory_special_prices
-- 

CREATE TABLE inventory_special_prices (
  id int(11) NOT NULL auto_increment,
  inventory_id int(11) NOT NULL default '0',
  price_sheet_id int(11) NOT NULL default '0',
  price_levels varchar(255) NOT NULL default '',
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

-- 
-- Table structure for table journal_item
-- 

CREATE TABLE journal_item (
  id int(11) NOT NULL auto_increment,
  ref_id int(11) NOT NULL default '0',
  so_po_item_ref_id int(11) default NULL,
  gl_type char(3) NOT NULL default '',
  reconciled BOOL NOT NULL DEFAULT '0',
  sku varchar(24) default NULL,
  qty float NOT NULL default '0',
  description varchar(255) default NULL,
  debit_amount double default '0',
  credit_amount double default '0',
  gl_account varchar(15) NOT NULL default '',
  taxable int(11) NOT NULL default '0',
  full_price DOUBLE NOT NULL default '0',
  serialize enum('0','1') NOT NULL default '0',
  serialize_number varchar(24) default NULL,
  project_id VARCHAR(16) default NULL,
  post_date date NOT NULL default '0000-00-00',
  date_1 datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (id),
  KEY ref_id (ref_id),
  KEY so_po_item_ref_id (so_po_item_ref_id),
  KEY reconciled (reconciled)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Journal Item Entry (many to one to journal_main)' ;

-- --------------------------------------------------------

-- 
-- Table structure for table journal_main
-- 

CREATE TABLE journal_main (
  id int(11) NOT NULL auto_increment,
  period int(2) NOT NULL default '0',
  journal_id int(2) NOT NULL default '0',
  post_date date NOT NULL default '0000-00-00',
  store_id int(11) default '0',
  description varchar(32) default NULL,
  closed enum('0','1') NOT NULL default '0',
  printed int(11) NOT NULL default '0',
  freight double default '0',
  discount double NOT NULL default '0',
  shipper_code varchar(16) NOT NULL default '',
  terms varchar(32) default '0',
  sales_tax double NOT NULL default '0',
  tax_auths varchar(16) NOT NULL default '0',
  total_amount double NOT NULL default '0',
  currencies_code char(3) NOT NULL DEFAULT '',
  currencies_value DOUBLE NOT NULL DEFAULT '1.0',
  so_po_ref_id int(11) NOT NULL default '0',
  purchase_invoice_id varchar(24) default NULL,
  purch_order_id varchar(24) default NULL,
  recur_id int(11) default NULL,
  admin_id int(11) NOT NULL default '0',
  rep_id int(11) NOT NULL default '0',
  waiting enum('0','1') NOT NULL default '0',
  gl_acct_id varchar(15) default NULL,
  bill_acct_id int(11) NOT NULL default '0',
  bill_address_id int(11) NOT NULL default '0',
  bill_primary_name varchar(32) default NULL,
  bill_contact varchar(32) default NULL,
  bill_address1 varchar(32) default NULL,
  bill_address2 varchar(32) default NULL,
  bill_city_town varchar(24) default NULL,
  bill_state_province varchar(24) default NULL,
  bill_postal_code varchar(10) default NULL,
  bill_country_code char(3) default NULL,
  bill_telephone1 varchar(20) default NULL,
  bill_email varchar(48) default NULL,
  ship_acct_id int(11) NOT NULL default '0',
  ship_address_id int(11) NOT NULL default '0',
  ship_primary_name varchar(32) default NULL,
  ship_contact varchar(32) default NULL,
  ship_address1 varchar(32) default NULL,
  ship_address2 varchar(32) default NULL,
  ship_city_town varchar(24) default NULL,
  ship_state_province varchar(24) default NULL,
  ship_postal_code varchar(24) default NULL,
  ship_country_code char(3) default NULL,
  ship_telephone1 varchar(20) default NULL,
  ship_email varchar(48) default NULL,
  terminal_date date default NULL,
  drop_ship enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY period (period),
  KEY journal_id (journal_id),
  KEY post_date (post_date),
  KEY closed (closed),
  KEY bill_acct_id (bill_acct_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Journal Entry Table for Headings' ;

-- --------------------------------------------------------

-- 
-- Table structure for table price_sheets
-- 

CREATE TABLE price_sheets (
  id int(11) NOT NULL auto_increment,
  sheet_name varchar(32) NOT NULL default '',
  inactive enum('0','1') NOT NULL default '0',
  revision float NOT NULL default '0',
  effective_date date NOT NULL default '0000-00-00',
  expiration_date date default NULL,
  default_sheet enum('0','1') NOT NULL default '0',
  default_levels varchar(255) NOT NULL default '',
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

-- 
-- Table structure for table project_version
-- 

CREATE TABLE project_version (
  project_version_id tinyint(3) NOT NULL auto_increment,
  project_version_key varchar(40) NOT NULL default '',
  project_version_major varchar(20) NOT NULL default '',
  project_version_minor varchar(20) NOT NULL default '',
  project_version_comment varchar(250) NOT NULL default '',
  project_version_date_applied datetime NOT NULL default '0001-01-01 01:01:01',
  PRIMARY KEY  (project_version_id),
  UNIQUE KEY idx_project_version_key_zen (project_version_key)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Database Version Tracking' ;

-- --------------------------------------------------------

-- 
-- Table structure for table projects_phases
-- 

CREATE TABLE projects_phases (
  phase_id int(8) NOT NULL auto_increment,
  description_short varchar(16) collate utf8_unicode_ci NOT NULL default '',
  description_long varchar(64) collate utf8_unicode_ci NOT NULL default '',
  cost_type varchar(3) collate utf8_unicode_ci default NULL,
  cost_breakdown enum('0','1') collate utf8_unicode_ci NOT NULL default '0',
  inactive enum('0','1') collate utf8_unicode_ci NOT NULL default '0',
  PRIMARY KEY (phase_id),
  KEY description_short (description_short)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Project Phases used for Job Costing' ;

-- --------------------------------------------------------

-- 
-- Table structure for table projects_costs
-- 

CREATE TABLE projects_costs (
  cost_id int(8) NOT NULL auto_increment,
  description_short varchar(16) collate utf8_unicode_ci NOT NULL default '',
  description_long varchar(64) collate utf8_unicode_ci NOT NULL default '',
  cost_type varchar(3) collate utf8_unicode_ci default NULL,
  inactive enum('0','1') collate utf8_unicode_ci NOT NULL default '0',
  PRIMARY KEY (cost_id),
  KEY description_short (description_short)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Project Costs used for Job Phase Breakdown' ;

-- --------------------------------------------------------

-- 
-- Table structure for table reconciliation
-- 

CREATE TABLE reconciliation (
  id int(11) NOT NULL auto_increment,
  period int(11) NOT NULL default '0',
  gl_account varchar(15) NOT NULL default '',
  statement_balance double NOT NULL default '0',
  cleared_items text,
  PRIMARY KEY  (id),
  KEY period (period)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

-- 
-- Table structure for table report_fields
-- 

CREATE TABLE report_fields (
  id int(8) NOT NULL auto_increment,
  reportid int(5) NOT NULL default '0',
  entrytype varchar(15) NOT NULL default '',
  seqnum int(3) NOT NULL default '0',
  fieldname varchar(255) NOT NULL default '',
  displaydesc varchar(25) NOT NULL default '',
  visible enum('1','0') NOT NULL default '1',
  columnbreak enum('1','0') NOT NULL default '1',
  params text,
  PRIMARY KEY  (id),
  KEY reportid (reportid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

-- 
-- Table structure for table reports
-- 

CREATE TABLE reports (
  id int(5) NOT NULL auto_increment,
  description varchar(30) NOT NULL default '',
  narrative varchar(255) NOT NULL default '',
  reporttype char(3) NOT NULL default 'rpt',
  groupname varchar(9) NOT NULL default 'misc',
  standard_report enum('1','0') NOT NULL default '1',
  special_report varchar(32) NOT NULL default '0',
  table1 varchar(25) NOT NULL default '',
  table2 varchar(25) default NULL,
  table2criteria varchar(75) default NULL,
  table3 varchar(25) default NULL,
  table3criteria varchar(75) default NULL,
  table4 varchar(25) default NULL,
  table4criteria varchar(75) default NULL,
  table5 varchar(25) default NULL,
  table5criteria varchar(75) default NULL,
  table6 varchar(25) default NULL,
  table6criteria varchar(75) default NULL,
  PRIMARY KEY  (id),
  KEY name (description,groupname)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

-- 
-- Table structure for table shipping_log
-- 

CREATE TABLE shipping_log (
  id int(11) NOT NULL auto_increment,
  shipment_id int(11) NOT NULL default '0',
  ref_id varchar(16) NOT NULL default '0',
  reconciled smallint(4) NOT NULL default '0',
  carrier varchar(16) NOT NULL default '',
  method varchar(8) NOT NULL default '',
  ship_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  deliver_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  actual_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  tracking_id varchar(32) NOT NULL default '',
  cost float NOT NULL default '0',
  notes varchar(255) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY ref_id (ref_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

-- 
-- Table structure for table tax_authorities
-- 

CREATE TABLE tax_authorities (
  tax_auth_id int(3) NOT NULL auto_increment,
  type varchar(1) NOT NULL DEFAULT 'c',
  description_short char(15) NOT NULL default '',
  description_long char(64) NOT NULL default '',
  account_id char(15) NOT NULL default '',
  vendor_id int(5) NOT NULL default '0',
  tax_rate float NOT NULL default '0',
  PRIMARY KEY  (tax_auth_id),
  KEY description_short (description_short)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Sales Tax Authorities' ;

-- --------------------------------------------------------

-- 
-- Table structure for table tax_rates
-- 

CREATE TABLE tax_rates (
  tax_rate_id int(3) NOT NULL auto_increment,
  type varchar(1) NOT NULL DEFAULT 'c',
  description_short varchar(15) NOT NULL default '',
  description_long varchar(64) NOT NULL default '',
  rate_accounts varchar(64) NOT NULL default '',
  freight_taxable enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (tax_rate_id),
  KEY description_short (description_short)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Sales Tax Authorities' ;

-- --------------------------------------------------------

-- 
-- Table structure for table users
-- 

CREATE TABLE users (
  admin_id int(11) NOT NULL auto_increment,
  admin_name varchar(32) NOT NULL default '',
  inactive enum('0','1') NOT NULL default '0',
  display_name varchar(32) NOT NULL default '',
  admin_email varchar(96) NOT NULL default '',
  admin_pass varchar(40) NOT NULL default '',
  account_id int(11) NOT NULL default '0',
  admin_store_id int(11) NOT NULL default '0',
  admin_prefs text,
  admin_security text,
  PRIMARY KEY  (admin_id),
  KEY idx_admin_name_zen (admin_name)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

-- 
-- Table structure for table users_profiles
-- 

CREATE TABLE users_profiles (
  id int(11) NOT NULL auto_increment,
  user_id int(11) NOT NULL default '0',
  page_id varchar(32) NOT NULL default '',
  module_id varchar(32) NOT NULL default '',
  column_id int(3) NOT NULL default '0',
  row_id int(3) NOT NULL default '0',
  params text,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User profile information' ;

-- --------------------------------------------------------

-- 
-- Table structure for table zones
-- 

CREATE TABLE zones (
  zone_id int(11) NOT NULL auto_increment,
  countries_iso_code_3 char(3) NOT NULL default '',
  zone_code varchar(32) NOT NULL default '',
  zone_name varchar(32) NOT NULL default '',
  PRIMARY KEY  (zone_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='State/province mapping to country ISO3 code' ;
