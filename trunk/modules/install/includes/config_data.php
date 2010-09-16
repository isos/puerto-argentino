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
//  Path: /modules/install/includes/config_data.php
//

/*
This file sets the configuration variables for PhreeBooks it is installed as part of the installation script.
If the language file is not found, english is used.

The available fields and format are:
$config_data[] = array(
  'configuration_title'       => 'CONSTANT',	// title used in the configuration listing (default \')
  'configuration_key'         => 'CONSTANT',	// key used throughout PhreeBooks (default \')
  'configuration_value'       => 'value',		// constant value user configurable (default \')
  'configuration_description' => 'CONSTANT', 	// description used in the configuration when editing (default \')
  'configuration_group_id'    => 1, 			// group id for configuration organization (default 0)
  'sort_order'                => 1,				// sort order in the configuration listing (default NULL)
  'last_modified'             => '',			// date last modified, usually left blank (default NULL)
  'date_added'                => '',			// date added, should set to today (default NULL)
  'use_function'              => '',			// function to used when reading value (default NULL)
  'set_function'              => ''				// function to use when setting value (default NULL)
  );

*/
$today = date('Y-m-d H:i:s', time());
/*********************************************************************************************************
									Configuration Data
/*********************************************************************************************************/
$config_data = array();
/************************** Group ID 0 (System set constants) ***********************************************/
$config_data[] = array(
  'configuration_title' => 'CD_00_01_TITLE',
  'configuration_key' => 'CURRENT_ACCOUNTING_PERIOD',
  'configuration_value' => '1',
  'configuration_description' => 'CD_00_01_DESC',
  'configuration_group_id' => 0, 
  'sort_order' => 1,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_00_02_TITLE',
  'configuration_key' => 'CURRENT_ACCOUNTING_PERIOD_START',
  'configuration_value' => '',
  'configuration_description' => 'CD_00_02_DESC',
  'configuration_group_id' => 0, 
  'sort_order' => 2,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_00_03_TITLE',
  'configuration_key' => 'CURRENT_ACCOUNTING_PERIOD_END',
  'configuration_value' => '',
  'configuration_description' => 'CD_00_03_DESC',
  'configuration_group_id' => 0, 
  'sort_order' => 3,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_00_04_TITLE',
  'configuration_key' => 'MODULE_SHIPPING_INSTALLED',
  'configuration_value' => 'freeshipper.php;flat.php',
  'configuration_description' => 'CD_00_04_DESC',
  'configuration_group_id' => 0, 
  'sort_order' => 4,
  'date_added' => $today);

/************************** Group ID 1 (My Company) ***********************************************/
$config_data[] = array(
  'configuration_title' => 'CD_01_01_TITLE',
  'configuration_key' => 'COMPANY_NAME',
  'configuration_value' => '',
  'configuration_description' => 'CD_01_01_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 1,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_01_02_TITLE',
  'configuration_key' => 'AR_CONTACT_NAME',
  'configuration_value' => '',
  'configuration_description' => 'CD_01_02_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 2,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_01_03_TITLE',
  'configuration_key' => 'AP_CONTACT_NAME',
  'configuration_value' => '',
  'configuration_description' => 'CD_01_03_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 3,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_01_04_TITLE',
  'configuration_key' => 'COMPANY_ADDRESS1',
  'configuration_value' => '',
  'configuration_description' => 'CD_01_04_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 4,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_01_05_TITLE',
  'configuration_key' => 'COMPANY_ADDRESS2',
  'configuration_value' => '',
  'configuration_description' => 'CD_01_05_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 5,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_01_06_TITLE',
  'configuration_key' => 'COMPANY_CITY_TOWN',
  'configuration_value' => '',
  'configuration_description' => 'CD_01_06_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 6,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_01_07_TITLE',
  'configuration_key' => 'COMPANY_ZONE',
  'configuration_value' => '',
  'configuration_description' => 'CD_01_07_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 7,
  'date_added' => $today,
  'use_function' => 'cfg_get_zone_name',
  'set_function' => 'cfg_pull_down_zone_list(');

$config_data[] = array(
  'configuration_title' => 'CD_01_08_TITLE',
  'configuration_key' => 'COMPANY_POSTAL_CODE',
  'configuration_value' => '',
  'configuration_description' => 'CD_01_08_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 8,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_01_09_TITLE',
  'configuration_key' => 'COMPANY_COUNTRY',
  'configuration_value' => 'USA',
  'configuration_description' => 'CD_01_09_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 9,
  'date_added' => $today,
  'use_function' => 'cfg_get_country_name',
  'set_function' => 'cfg_pull_down_country_list(');

$config_data[] = array(
  'configuration_title' => 'CD_01_10_TITLE',
  'configuration_key' => 'COMPANY_TELEPHONE1',
  'configuration_value' => '',
  'configuration_description' => 'CD_01_10_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 10,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_01_11_TITLE',
  'configuration_key' => 'COMPANY_TELEPHONE2',
  'configuration_value' => '',
  'configuration_description' => 'CD_01_11_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 11,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_01_12_TITLE',
  'configuration_key' => 'COMPANY_FAX',
  'configuration_value' => '',
  'configuration_description' => 'CD_01_12_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 12,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_01_13_TITLE',
  'configuration_key' => 'COMPANY_EMAIL',
  'configuration_value' => '',
  'configuration_description' => 'CD_01_13_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 13,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_01_14_TITLE',
  'configuration_key' => 'COMPANY_WEBSITE',
  'configuration_value' => '',
  'configuration_description' => 'CD_01_14_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 14,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_01_15_TITLE',
  'configuration_key' => 'TAX_ID',
  'configuration_value' => '',
  'configuration_description' => 'CD_01_15_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 15,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_01_16_TITLE',
  'configuration_key' => 'COMPANY_ID',
  'configuration_value' => '',
  'configuration_description' => 'CD_01_16_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 16,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_01_18_TITLE',
  'configuration_key' => 'ENABLE_MULTI_BRANCH',
  'configuration_value' => '0',
  'configuration_description' => 'CD_01_18_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 18,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=>\'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_01_19_TITLE',
  'configuration_key' => 'ENABLE_MULTI_CURRENCY',
  'configuration_value' => '0',
  'configuration_description' => 'CD_01_19_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 19,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=>\'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_01_20_TITLE',
  'configuration_key' => 'USE_DEFAULT_LANGUAGE_CURRENCY',
  'configuration_value' => 'False',
  'configuration_description' => 'CD_01_20_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 20,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=>\'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_01_25_TITLE',
  'configuration_key' => 'ENABLE_SHIPPING_FUNCTIONS',
  'configuration_value' => '1',
  'configuration_description' => 'CD_01_25_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 25,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=>\'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_01_30_TITLE',
  'configuration_key' => 'ENABLE_ENCRYPTION',
  'configuration_value' => '0',
  'configuration_description' => 'CD_01_30_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 30,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=>\'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_01_50_TITLE',
  'configuration_key' => 'ENABLE_ORDER_DISCOUNT',
  'configuration_value' => '0',
  'configuration_description' => 'CD_01_50_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 50,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=>\'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_01_52_TITLE',
  'configuration_key' => 'ROUND_TAX_BY_AUTH',
  'configuration_value' => '0',
  'configuration_description' => 'CD_01_52_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 52,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=>\'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_01_55_TITLE',
  'configuration_key' => 'ENABLE_BAR_CODE_READERS',
  'configuration_value' => '0',
  'configuration_description' => 'CD_01_55_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 55,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=>\'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_01_75_TITLE',
  'configuration_key' => 'SINGLE_LINE_ORDER_SCREEN',
  'configuration_value' => '1',
  'configuration_description' => 'CD_01_75_DESC',
  'configuration_group_id' => 1, 
  'sort_order' => 75,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(1=>\'' . TEXT_SINGLE_MODE . '\', 0=>\'' . TEXT_DOUBLE_MODE . '\'),');

/************************** Group ID 2 (Customer Defaults) ***********************************************/
$config_data[] = array(
  'configuration_title' => 'CD_02_01_TITLE',
  'configuration_key' => 'AR_DEFAULT_GL_ACCT',
  'configuration_value' => '',
  'configuration_description' => 'CD_02_01_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 1,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_02_02_TITLE',
  'configuration_key' => 'AR_DEF_GL_SALES_ACCT',
  'configuration_value' => '',
  'configuration_description' => 'CD_02_02_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 2,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_02_03_TITLE',
  'configuration_key' => 'AR_SALES_RECEIPTS_ACCOUNT',
  'configuration_value' => '',
  'configuration_description' => 'CD_02_03_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 3,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_02_04_TITLE',
  'configuration_key' => 'AR_DISCOUNT_SALES_ACCOUNT',
  'configuration_value' => '',
  'configuration_description' => 'CD_02_04_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 4,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_02_05_TITLE',
  'configuration_key' => 'AR_DEF_FREIGHT_ACCT',
  'configuration_value' => '',
  'configuration_description' => 'CD_02_05_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 5,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_02_06_TITLE',
  'configuration_key' => 'AR_DEF_DEPOSIT_ACCT',
  'configuration_value' => '',
  'configuration_description' => 'CD_02_06_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 6,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_02_07_TITLE',
  'configuration_key' => 'AR_DEF_DEP_LIAB_ACCT',
  'configuration_value' => '',
  'configuration_description' => 'CD_02_07_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 7,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_02_10_TITLE',
  'configuration_key' => 'AR_PAYMENT_TERMS',
  'configuration_value' => '1',
  'configuration_description' => 'CD_02_10_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 10,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_02_11_TITLE',
  'configuration_key' => 'AR_USE_CREDIT_LIMIT',
  'configuration_value' => '1',
  'configuration_description' => 'CD_02_11_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 11,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_02_12_TITLE',
  'configuration_key' => 'AR_CREDIT_LIMIT_AMOUNT',
  'configuration_value' => '2500.00',
  'configuration_description' => 'CD_02_12_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 12,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_02_13_TITLE',
  'configuration_key' => 'AR_NUM_DAYS_DUE',
  'configuration_value' => '30',
  'configuration_description' => 'CD_02_13_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 13,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_02_14_TITLE',
  'configuration_key' => 'AR_PREPAYMENT_DISCOUNT_DAYS',
  'configuration_value' => '0',
  'configuration_description' => 'CD_02_14_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 14,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_02_15_TITLE',
  'configuration_key' => 'AR_PREPAYMENT_DISCOUNT_PERCENT',
  'configuration_value' => '0',
  'configuration_description' => 'CD_02_15_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 15,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_02_16_TITLE',
  'configuration_key' => 'AR_ACCOUNT_AGING_START',
  'configuration_value' => '0',
  'configuration_description' => 'CD_02_16_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 16,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'0\', \'1\'), ');

$config_data[] = array(
  'configuration_title' => 'CD_02_17_TITLE',
  'configuration_key' => 'AR_AGING_PERIOD_1',
  'configuration_value' => '30',
  'configuration_description' => 'CD_02_17_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 17,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_02_18_TITLE',
  'configuration_key' => 'AR_AGING_PERIOD_2',
  'configuration_value' => '60',
  'configuration_description' => 'CD_02_18_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 18,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_02_19_TITLE',
  'configuration_key' => 'AR_AGING_PERIOD_3',
  'configuration_value' => '90',
  'configuration_description' => 'CD_02_19_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 19,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_02_20_TITLE',
  'configuration_key' => 'AR_AGING_HEADING_1',
  'configuration_value' => '0-30',
  'configuration_description' => 'CD_02_20_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 20,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_02_21_TITLE',
  'configuration_key' => 'AR_AGING_HEADING_2',
  'configuration_value' => '31-60',
  'configuration_description' => 'CD_02_21_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 21,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_02_22_TITLE',
  'configuration_key' => 'AR_AGING_HEADING_3',
  'configuration_value' => '61-90',
  'configuration_description' => 'CD_02_22_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 22,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_02_23_TITLE',
  'configuration_key' => 'AR_AGING_HEADING_4',
  'configuration_value' => 'Over 90',
  'configuration_description' => 'CD_02_23_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 23,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_02_24_TITLE',
  'configuration_key' => 'AR_CALCULATE_FINANCE_CHARGE',
  'configuration_value' => '0',
  'configuration_description' => 'CD_02_24_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 24,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_02_30_TITLE',
  'configuration_key' => 'AR_ADD_SALES_TAX_TO_SHIPPING',
  'configuration_value' => '0',
  'configuration_description' => 'CD_02_30_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 30,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_tax_rate_list(');

$config_data[] = array(
  'configuration_title' => 'CD_02_35_TITLE',
  'configuration_key' => 'AUTO_INC_CUST_ID',
  'configuration_value' => '0',
  'configuration_description' => 'CD_02_35_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 35,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=>\'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_02_40_TITLE',
  'configuration_key' => 'AR_SHOW_CONTACT_STATUS',
  'configuration_value' => '0',
  'configuration_description' => 'CD_02_40_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 40,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=>\'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_02_50_TITLE',
  'configuration_key' => 'AR_TAX_BEFORE_DISCOUNT',
  'configuration_value' => '1',
  'configuration_description' => 'CD_02_50_DESC',
  'configuration_group_id' => 2, 
  'sort_order' => 50,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_AFTER_DISCOUNT . '\', 1=>\'' . TEXT_BEFORE_DISCOUNT . '\'),');

/************************** Group ID 3 (Vendor Defaults) ***********************************************/
$config_data[] = array(
  'configuration_title' => 'CD_03_01_TITLE',
  'configuration_key' => 'AP_DEFAULT_INVENTORY_ACCOUNT',
  'configuration_value' => '',
  'configuration_description' => 'CD_03_01_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 1,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_03_02_TITLE',
  'configuration_key' => 'AP_DEFAULT_PURCHASE_ACCOUNT',
  'configuration_value' => '',
  'configuration_description' => 'CD_03_02_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 2,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_03_03_TITLE',
  'configuration_key' => 'AP_PURCHASE_INVOICE_ACCOUNT',
  'configuration_value' => '',
  'configuration_description' => 'CD_03_03_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 3,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_03_04_TITLE',
  'configuration_key' => 'AP_DEF_FREIGHT_ACCT',
  'configuration_value' => '',
  'configuration_description' => 'CD_03_04_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 4,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_03_05_TITLE',
  'configuration_key' => 'AP_DISCOUNT_PURCHASE_ACCOUNT',
  'configuration_value' => '',
  'configuration_description' => 'CD_03_05_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 5,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_03_06_TITLE',
  'configuration_key' => 'AP_DEF_DEPOSIT_ACCT',
  'configuration_value' => '',
  'configuration_description' => 'CD_03_06_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 6,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_03_07_TITLE',
  'configuration_key' => 'AP_DEF_DEP_LIAB_ACCT',
  'configuration_value' => '',
  'configuration_description' => 'CD_03_07_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 7,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_03_10_TITLE',
  'configuration_key' => 'AP_CREDIT_LIMIT_AMOUNT',
  'configuration_value' => '5000.00',
  'configuration_description' => 'CD_03_10_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 10,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_03_11_TITLE',
  'configuration_key' => 'AP_DEFAULT_TERMS',
  'configuration_value' => '0',
  'configuration_description' => 'CD_03_11_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 11,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_03_12_TITLE',
  'configuration_key' => 'AP_NUM_DAYS_DUE',
  'configuration_value' => '30',
  'configuration_description' => 'CD_03_12_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 12,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_03_13_TITLE',
  'configuration_key' => 'AP_PREPAYMENT_DISCOUNT_PERCENT',
  'configuration_value' => '0',
  'configuration_description' => 'CD_03_13_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 13,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_03_14_TITLE',
  'configuration_key' => 'AP_PREPAYMENT_DISCOUNT_DAYS',
  'configuration_value' => '10',
  'configuration_description' => 'CD_03_14_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 14,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_03_15_TITLE',
  'configuration_key' => 'AP_AGING_START_DATE',
  'configuration_value' => '0',
  'configuration_description' => 'CD_03_15_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 15,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'0\', \'1\'), ');

$config_data[] = array(
  'configuration_title' => 'CD_03_16_TITLE',
  'configuration_key' => 'AP_AGING_DATE_1',
  'configuration_value' => '30',
  'configuration_description' => 'CD_03_16_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 16,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_03_17_TITLE',
  'configuration_key' => 'AP_AGING_DATE_2',
  'configuration_value' => '60',
  'configuration_description' => 'CD_03_17_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 17,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_03_18_TITLE',
  'configuration_key' => 'AP_AGING_DATE_3',
  'configuration_value' => '90',
  'configuration_description' => 'CD_03_18_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 18,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_03_19_TITLE',
  'configuration_key' => 'AP_AGING_HEADING_1',
  'configuration_value' => '0-30',
  'configuration_description' => 'CD_03_19_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 19,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_03_20_TITLE',
  'configuration_key' => 'AP_AGING_HEADING_2',
  'configuration_value' => '31-60',
  'configuration_description' => 'CD_03_20_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 20,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_03_21_TITLE',
  'configuration_key' => 'AP_AGING_HEADING_3',
  'configuration_value' => '61-90',
  'configuration_description' => 'CD_03_21_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 21,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_03_22_TITLE',
  'configuration_key' => 'AP_AGING_HEADING_4',
  'configuration_value' => 'Over 90',
  'configuration_description' => 'CD_03_22_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 22,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_03_30_TITLE',
  'configuration_key' => 'AP_ADD_SALES_TAX_TO_SHIPPING',
  'configuration_value' => '0',
  'configuration_description' => 'CD_03_30_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 30,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_tax_rate_list(');

$config_data[] = array(
  'configuration_title' => 'CD_03_35_TITLE',
  'configuration_key' => 'AUTO_INC_VEND_ID',
  'configuration_value' => '0',
  'configuration_description' => 'CD_03_35_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 35,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=>\'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_03_40_TITLE',
  'configuration_key' => 'AP_SHOW_CONTACT_STATUS',
  'configuration_value' => '0',
  'configuration_description' => 'CD_03_40_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 40,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=>\'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_03_50_TITLE',
  'configuration_key' => 'AP_TAX_BEFORE_DISCOUNT',
  'configuration_value' => '1',
  'configuration_description' => 'CD_03_50_DESC',
  'configuration_group_id' => 3, 
  'sort_order' => 50,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_AFTER_DISCOUNT . '\', 1=>\'' . TEXT_BEFORE_DISCOUNT . '\'),');

/************************** Group ID 4 (Employee Defaults) ***********************************************/


/************************** Group ID 5 (Inventory Defaults) ***********************************************/
$config_data[] = array(
  'configuration_title' => 'CD_05_01_TITLE',
  'configuration_key' => 'INV_STOCK_DEFAULT_SALES',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_01_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 1,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_02_TITLE',
  'configuration_key' => 'INV_STOCK_DEFAULT_INVENTORY',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_02_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 2,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_03_TITLE',
  'configuration_key' => 'INV_STOCK_DEFAULT_COS',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_03_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 3,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_04_TITLE',
  'configuration_key' => 'INV_STOCK_DEFAULT_COSTING',
  'configuration_value' => 'f',
  'configuration_description' => 'CD_05_04_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 4,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'a\', \'f\', \'l\'), ');

$config_data[] = array(
  'configuration_title' => 'CD_05_05_TITLE',
  'configuration_key' => 'INV_MASTER_STOCK_DEFAULT_SALES',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_05_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 5,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_06_TITLE',
  'configuration_key' => 'INV_MASTER_STOCK_DEFAULT_INVENTORY',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_06_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 6,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_07_TITLE',
  'configuration_key' => 'INV_MASTER_STOCK_DEFAULT_COS',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_07_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 7,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_08_TITLE',
  'configuration_key' => 'INV_MASTER_STOCK_DEFAULT_COSTING',
  'configuration_value' => 'f',
  'configuration_description' => 'CD_05_08_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 8,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'a\', \'f\', \'l\'), ');

$config_data[] = array(
  'configuration_title' => 'CD_05_11_TITLE',
  'configuration_key' => 'INV_ASSY_DEFAULT_SALES',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_11_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 11,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_12_TITLE',
  'configuration_key' => 'INV_ASSY_DEFAULT_INVENTORY',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_12_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 12,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_13_TITLE',
  'configuration_key' => 'INV_ASSY_DEFAULT_COS',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_13_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 13,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_14_TITLE',
  'configuration_key' => 'INV_ASSY_DEFAULT_COSTING',
  'configuration_value' => 'f',
  'configuration_description' => 'CD_05_14_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 14,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'a\', \'f\', \'l\'), ');

$config_data[] = array(
  'configuration_title' => 'CD_05_16_TITLE',
  'configuration_key' => 'INV_SERIALIZE_DEFAULT_SALES',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_16_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 16,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_17_TITLE',
  'configuration_key' => 'INV_SERIALIZE_DEFAULT_INVENTORY',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_17_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 17,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_18_TITLE',
  'configuration_key' => 'INV_SERIALIZE_DEFAULT_COS',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_18_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 18,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_19_TITLE',
  'configuration_key' => 'INV_SERIALIZE_DEFAULT_COSTING',
  'configuration_value' => 'f',
  'configuration_description' => 'CD_05_19_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 19,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'a\', \'f\', \'l\'), ');

$config_data[] = array(
  'configuration_title' => 'CD_05_21_TITLE',
  'configuration_key' => 'INV_NON_STOCK_DEFAULT_SALES',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_21_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 21,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_22_TITLE',
  'configuration_key' => 'INV_NON_STOCK_DEFAULT_INVENTORY',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_22_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 22,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_23_TITLE',
  'configuration_key' => 'INV_NON_STOCK_DEFAULT_COS',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_23_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 23,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_31_TITLE',
  'configuration_key' => 'INV_SERVICE_DEFAULT_SALES',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_31_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 31,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_32_TITLE',
  'configuration_key' => 'INV_SERVICE_DEFAULT_INVENTORY',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_32_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 32,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_33_TITLE',
  'configuration_key' => 'INV_SERVICE_DEFAULT_COS',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_33_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 33,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_36_TITLE',
  'configuration_key' => 'INV_LABOR_DEFAULT_SALES',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_36_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 36,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_37_TITLE',
  'configuration_key' => 'INV_LABOR_DEFAULT_INVENTORY',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_37_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 37,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_38_TITLE',
  'configuration_key' => 'INV_LABOR_DEFAULT_COS',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_38_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 38,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_41_TITLE',
  'configuration_key' => 'INV_ACTIVITY_DEFAULT_SALES',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_41_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 41,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_42_TITLE',
  'configuration_key' => 'INV_CHARGE_DEFAULT_SALES',
  'configuration_value' => '',
  'configuration_description' => 'CD_05_42_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 42,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_gl_acct_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_50_TITLE',
  'configuration_key' => 'INVENTORY_DEFAULT_TAX',
  'configuration_value' => '0',
  'configuration_description' => 'CD_05_50_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 50,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_tax_rate_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_52_TITLE',
  'configuration_key' => 'INVENTORY_DEFAULT_PURCH_TAX',
  'configuration_value' => '0',
  'configuration_description' => 'CD_05_52_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 52,
  'date_added' => $today,
  'set_function' => 'cfg_pull_down_tax_rate_list(');

$config_data[] = array(
  'configuration_title' => 'CD_05_55_TITLE',
  'configuration_key' => 'INVENTORY_AUTO_ADD',
  'configuration_value' => '0',
  'configuration_description' => 'CD_05_55_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 55,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=>\'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_05_60_TITLE',
  'configuration_key' => 'INVENTORY_AUTO_FILL',
  'configuration_value' => '0',
  'configuration_description' => 'CD_05_60_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 60,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=>\'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_05_65_TITLE',
  'configuration_key' => 'ORD_ENABLE_LINE_ITEM_BAR_CODE',
  'configuration_value' => '0',
  'configuration_description' => 'CD_05_65_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 65,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=>\'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_05_70_TITLE',
  'configuration_key' => 'ORD_BAR_CODE_LENGTH',
  'configuration_value' => '12',
  'configuration_description' => 'CD_05_70_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 70,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_05_75_TITLE',
  'configuration_key' => 'ENABLE_AUTO_ITEM_COST',
  'configuration_value' => '0',
  'configuration_description' => 'CD_05_75_DESC',
  'configuration_group_id' => 5, 
  'sort_order' => 65,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0=>\'' . TEXT_NO . '\', \'PO\'=>\'' . TEXT_PURCH_ORDER . '\', \'PR\'=>\'' . TEXT_PURCHASE . '\'),');

/************************** Group ID 6 (Special Cases (Payment, Shippping, Price Sheets) **************/
// Note, these are the standard included modules and are in english only for installation
$config_data[] = array(
  'configuration_title' => 'Enable Check/Money Order Module',
  'configuration_key' => 'MODULE_PAYMENT_MONEYORDER_STATUS',
  'configuration_value' => 'True',
  'configuration_description' => 'Do you want to accept Check/Money Order payments?',
  'configuration_group_id' => 6, 
  'sort_order' => 1,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'' . TEXT_YES . '\', \'' . TEXT_NO . '\'), ');

$config_data[] = array(
  'configuration_title' => 'Make Payable to:',
  'configuration_key' => 'MODULE_PAYMENT_MONEYORDER_PAYTO',
  'configuration_value' => '',
  'configuration_description' => 'Who should payments be made payable to?',
  'configuration_group_id' => 6, 
  'sort_order' => 1,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'Sort order of display.',
  'configuration_key' => 'MODULE_PAYMENT_MONEYORDER_SORT_ORDER',
  'configuration_value' => '3',
  'configuration_description' => 'Sort order of display. Lowest is displayed first.',
  'configuration_group_id' => 6, 
  'sort_order' => 0,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'Enable Cash On Delivery Module',
  'configuration_key' => 'MODULE_PAYMENT_COD_STATUS',
  'configuration_value' => 'True',
  'configuration_description' => 'Do you want to accept Cash On Delivery payments?',
  'configuration_group_id' => 6, 
  'sort_order' => 1,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'' . TEXT_YES . '\', \'' . TEXT_NO . '\'), ');

$config_data[] = array(
  'configuration_title' => 'Sort order of display.',
  'configuration_key' => 'MODULE_PAYMENT_COD_SORT_ORDER',
  'configuration_value' => '2',
  'configuration_description' => 'Sort order of display. Lowest is displayed first.',
  'configuration_group_id' => 6, 
  'sort_order' => 0,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'Installed Modules',
  'configuration_key' => 'MODULE_PAYMENT_INSTALLED',
  'configuration_value' => 'cod.php;moneyorder.php',
  'configuration_description' => 'List of payment module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: cc.php;cod.php;paypal.php)',
  'configuration_group_id' => 6, 
  'sort_order' => 0,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'Enable Quantity Based Price Sheets',
  'configuration_key' => 'MODULE_PRICE_SHEET_QTY_STATUS',
  'configuration_value' => 'True',
  'configuration_description' => 'Do you want to enable price sheets to allow multilevel pricing base on item quantities purchased?',
  'configuration_group_id' => 6, 
  'sort_order' => 1,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'' . TEXT_YES . '\', \'' . TEXT_NO . '\'), ');

$config_data[] = array(
  'configuration_title' => 'Sort order of display.',
  'configuration_key' => 'MODULE_PRICE_SHEET_QTY_SORT_ORDER',
  'configuration_value' => '0',
  'configuration_description' => 'Sort order of display. Lowest is displayed first.',
  'configuration_group_id' => 6, 
  'sort_order' => 0,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'Enable Flat Shipping',
  'configuration_key' => 'MODULE_SHIPPING_FLAT_STATUS',
  'configuration_value' => 'True',
  'configuration_description' => 'Do you want to offer flat rate shipping?',
  'configuration_group_id' => 6, 
  'sort_order' => 0,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'' . TEXT_YES . '\', \'' . TEXT_NO . '\'), ');

$config_data[] = array(
  'configuration_title' => 'Flat Shipping',
  'configuration_key' => 'MODULE_SHIPPING_FLAT_TITLE',
  'configuration_value' => 'Flat Shipping',
  'configuration_description' => 'Title to use for display purposes on shipping rate estimator',
  'configuration_group_id' => 6, 
  'sort_order' => 0,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'Shipping Cost',
  'configuration_key' => 'MODULE_SHIPPING_FLAT_COST',
  'configuration_value' => '5.00',
  'configuration_description' => 'The shipping cost for all orders using this shipping method.',
  'configuration_group_id' => 6, 
  'sort_order' => 0,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'Sort Order',
  'configuration_key' => 'MODULE_SHIPPING_FLAT_SORT_ORDER',
  'configuration_value' => '2',
  'configuration_description' => 'Sort order of display.',
  'configuration_group_id' => 6, 
  'sort_order' => 0,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'Enable Free Shipping',
  'configuration_key' => 'MODULE_SHIPPING_FREESHIPPER_STATUS',
  'configuration_value' => 'True',
  'configuration_description' => 'Do you want to offer Free shipping?',
  'configuration_group_id' => 6, 
  'sort_order' => 0,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'' . TEXT_YES . '\', \'' . TEXT_NO . '\'), ');

$config_data[] = array(
  'configuration_title' => 'Free Shipping',
  'configuration_key' => 'MODULE_SHIPPING_FREESHIPPER_TITLE',
  'configuration_value' => 'Free Shipping',
  'configuration_description' => 'Title to use for display purposes on shipping rate estimator',
  'configuration_group_id' => 6, 
  'sort_order' => 0,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'Free Shipping Cost',
  'configuration_key' => 'MODULE_SHIPPING_FREESHIPPER_COST',
  'configuration_value' => '0.00',
  'configuration_description' => 'What is the Shipping cost?',
  'configuration_group_id' => 6, 
  'sort_order' => 6,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'Handling Fee',
  'configuration_key' => 'MODULE_SHIPPING_FREESHIPPER_HANDLING',
  'configuration_value' => '0.00',
  'configuration_description' => 'Handling fee for this shipping method.',
  'configuration_group_id' => 6, 
  'sort_order' => 0,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'Sort Order',
  'configuration_key' => 'MODULE_SHIPPING_FREESHIPPER_SORT_ORDER',
  'configuration_value' => '1',
  'configuration_description' => 'Sort order of display.',
  'configuration_group_id' => 6, 
  'sort_order' => 0,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'Installed Modules',
  'configuration_key' => 'MODULE_PRICE_SHEETS_INSTALLED',
  'configuration_value' => 'quantity.php',
  'configuration_description' => 'This is automatically updated. No need to edit.',
  'configuration_group_id' => 6, 
  'sort_order' => 0,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'Installed Modules',
  'configuration_key' => 'MODULE_ZENCART_INSTALLED',
  'configuration_value' => '',
  'configuration_description' => 'This is automatically updated. No need to edit.',
  'configuration_group_id' => 6, 
  'sort_order' => 0,
  'date_added' => $today);

/************************** Group ID 7 (User Account Defaults) ***********************************************/
$config_data[] = array(
  'configuration_title' => 'CD_07_17_TITLE',
  'configuration_key' => 'ENTRY_PASSWORD_MIN_LENGTH',
  'configuration_value' => '5',
  'configuration_description' => 'CD_07_17_DESC',
  'configuration_group_id' => 7, 
  'sort_order' => 10,
  'date_added' => $today);

/************************** Group ID 8 (General Settings) ***********************************************/
$config_data[] = array(
  'configuration_title' => 'CD_08_01_TITLE',
  'configuration_key' => 'MAX_DISPLAY_SEARCH_RESULTS',
  'configuration_value' => '20',
  'configuration_description' => 'CD_08_01_DESC',
  'configuration_group_id' => 8, 
  'sort_order' => 1,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_08_03_TITLE',
  'configuration_key' => 'CFG_AUTO_UPDATE_CHECK',
  'configuration_value' => '1',
  'configuration_description' => 'CD_08_03_DESC',
  'configuration_group_id' => 8, 
  'sort_order' => 3,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_08_05_TITLE',
  'configuration_key' => 'HIDE_SUCCESS_MESSAGES',
  'configuration_value' => '0',
  'configuration_description' => 'CD_08_05_DESC',
  'configuration_group_id' => 8, 
  'sort_order' => 5,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_08_07_TITLE',
  'configuration_key' => 'AUTO_UPDATE_CURRENCY',
  'configuration_value' => '1',
  'configuration_description' => 'CD_08_07_DESC',
  'configuration_group_id' => 8, 
  'sort_order' => 7,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_08_10_TITLE',
  'configuration_key' => 'LIMIT_HISTORY_RESULTS',
  'configuration_value' => '20',
  'configuration_description' => 'CD_08_10_DESC',
  'configuration_group_id' => 8, 
  'sort_order' => 10,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_08_15_TITLE',
  'configuration_key' => 'PDF_APP',
  'configuration_value' => 'TCPDF',
  'configuration_description' => 'CD_08_15_DESC',
  'configuration_group_id' => 8, 
  'sort_order' => 15,
  'date_added' => $today);

/************************** Group ID 9 (Import/Export Settings) ***********************************************/
$config_data[] = array(
  'configuration_title' => 'CD_09_01_TITLE',
  'configuration_key' => 'IE_RW_EXPORT_PREFERENCE',
  'configuration_value' => 'Download',
  'configuration_description' => 'CD_09_01_DESC',
  'configuration_group_id' => 9, 
  'sort_order' => 1,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'' . TEXT_LOCAL . '\', \'' . TEXT_DOWNLOAD . '\'), ');

/************************** Group ID 10 (Shipping Defaults) ***********************************************/
$config_data[] = array(
  'configuration_title' => 'CD_10_01_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_WEIGHT_UNIT',
  'configuration_value' => 'LBS',
  'configuration_description' => 'CD_10_01_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 1,
  'date_added' => $today,
  'set_function' => 'html_pull_down_menu(\'configuration_value\', gen_build_pull_down($shipping_defaults[\'weight_unit\']),');

$config_data[] = array(
  'configuration_title' => 'CD_10_02_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_CURRENCY',
  'configuration_value' => 'USD',
  'configuration_description' => 'CD_10_02_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 2,
  'date_added' => $today,
  'set_function' => 'html_pull_down_menu(\'configuration_value\', gen_get_currency_array(),');

$config_data[] = array(
  'configuration_title' => 'CD_10_03_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_PKG_DIM_UNIT',
  'configuration_value' => 'IN',
  'configuration_description' => 'CD_10_03_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 3,
  'date_added' => $today,
  'set_function' => 'html_pull_down_menu(\'configuration_value\', gen_build_pull_down($shipping_defaults[\'dimension_unit\']),');

$config_data[] = array(
  'configuration_title' => 'CD_10_04_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_RESIDENTIAL',
  'configuration_value' => '1',
  'configuration_description' => 'CD_10_04_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 4,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_UNCHECKED . '\', 1=> \'' . TEXT_CHECKED . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_05_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_PACKAGE_TYPE',
  'configuration_value' => '02',
  'configuration_description' => 'CD_10_05_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 5,
  'date_added' => $today,
  'set_function' => 'html_pull_down_menu(\'configuration_value\', gen_build_pull_down($shipping_defaults[\'package_type\']),');

$config_data[] = array(
  'configuration_title' => 'CD_10_06_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_PICKUP_SERVICE',
  'configuration_value' => '01',
  'configuration_description' => 'CD_10_06_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 6,
  'date_added' => $today,
  'set_function' => 'html_pull_down_menu(\'configuration_value\', gen_build_pull_down($shipping_defaults[\'pickup_service\']),');

$config_data[] = array(
  'configuration_title' => 'CD_10_07_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_LENGTH',
  'configuration_value' => '8',
  'configuration_description' => 'CD_10_07_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 7,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_10_08_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_WIDTH',
  'configuration_value' => '6',
  'configuration_description' => 'CD_10_08_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 8,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_10_09_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_HEIGHT',
  'configuration_value' => '4',
  'configuration_description' => 'CD_10_09_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 9,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_10_10_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_ADDITIONAL_HANDLING_SHOW',
  'configuration_value' => '1',
  'configuration_description' => 'CD_10_10_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 10,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_HIDE . '\', 1=> \'' . TEXT_SHOW . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_12_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_ADDITIONAL_HANDLING_CHECKED',
  'configuration_value' => '0',
  'configuration_description' => 'CD_10_12_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 12,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_UNCHECKED . '\', 1=> \'' . TEXT_CHECKED . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_14_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_INSURANCE_SHOW',
  'configuration_value' => '1',
  'configuration_description' => 'CD_10_14_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 14,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_HIDE . '\', 1=> \'' . TEXT_SHOW . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_16_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_INSURANCE_CHECKED',
  'configuration_value' => '0',
  'configuration_description' => 'CD_10_16_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 16,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_UNCHECKED . '\', 1=> \'' . TEXT_CHECKED . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_18_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_INSURANCE_VALUE',
  'configuration_value' => '100.00',
  'configuration_description' => 'CD_10_18_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 18,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_10_20_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_SPLIT_LARGE_SHIPMENTS_SHOW',
  'configuration_value' => '1',
  'configuration_description' => 'CD_10_20_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 20,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_HIDE . '\', 1=> \'' . TEXT_SHOW . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_22_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_SPLIT_LARGE_SHIPMENTS_CHECKED',
  'configuration_value' => '1',
  'configuration_description' => 'CD_10_22_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 22,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_UNCHECKED . '\', 1=> \'' . TEXT_CHECKED . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_24_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_SPLIT_LARGE_SHIPMENTS_VALUE',
  'configuration_value' => '75',
  'configuration_description' => 'CD_10_24_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 24,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_10_26_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_DELIVERY_COMFIRMATION_SHOW',
  'configuration_value' => '1',
  'configuration_description' => 'CD_10_26_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 26,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_HIDE . '\', 1=> \'' . TEXT_SHOW . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_28_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_DELIVERY_COMFIRMATION_CHECKED',
  'configuration_value' => '0',
  'configuration_description' => 'CD_10_28_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 28,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_UNCHECKED . '\', 1=> \'' . TEXT_CHECKED . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_30_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_DELIVERY_COMFIRMATION_TYPE',
  'configuration_value' => '2',
  'configuration_description' => 'CD_10_30_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 30,
  'date_added' => $today,
  'set_function' => 'html_pull_down_menu(\'configuration_value\', gen_build_pull_down($shipping_defaults[\'delivery_confirmation\']),');

$config_data[] = array(
  'configuration_title' => 'CD_10_32_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_HANDLING_CHARGE_SHOW',
  'configuration_value' => '1',
  'configuration_description' => 'CD_10_32_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 32,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_HIDE . '\', 1=> \'' . TEXT_SHOW . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_34_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_HANDLING_CHARGE_CHECKED',
  'configuration_value' => '0',
  'configuration_description' => 'CD_10_34_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 34,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_UNCHECKED . '\', 1=> \'' . TEXT_CHECKED . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_36_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_HANDLING_CHARGE_VALUE',
  'configuration_value' => '0.00',
  'configuration_description' => 'CD_10_36_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 36,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_10_38_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_COD_SHOW',
  'configuration_value' => '1',
  'configuration_description' => 'CD_10_38_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 38,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_HIDE . '\', 1=> \'' . TEXT_SHOW . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_40_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_COD_CHECKED',
  'configuration_value' => '0',
  'configuration_description' => 'CD_10_40_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 40,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_UNCHECKED . '\', 1=> \'' . TEXT_CHECKED . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_42_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_PAYMENT_TYPE',
  'configuration_value' => '1',
  'configuration_description' => 'CD_10_42_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 42,
  'date_added' => $today,
  'set_function' => 'html_pull_down_menu(\'configuration_value\', gen_build_pull_down($shipping_defaults[\'cod_funds_code\']),');

$config_data[] = array(
  'configuration_title' => 'CD_10_44_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_SATURDAY_PICKUP_SHOW',
  'configuration_value' => '1',
  'configuration_description' => 'CD_10_44_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 44,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_HIDE . '\', 1=> \'' . TEXT_SHOW . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_46_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_SATURDAY_PICKUP_CHECKED',
  'configuration_value' => '0',
  'configuration_description' => 'CD_10_46_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 46,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_UNCHECKED . '\', 1=> \'' . TEXT_CHECKED . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_48_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_SATURDAY_DELIVERY_SHOW',
  'configuration_value' => '1',
  'configuration_description' => 'CD_10_48_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 48,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_HIDE . '\', 1=> \'' . TEXT_SHOW . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_50_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_SATURDAY_DELIVERY_CHECKED',
  'configuration_value' => '0',
  'configuration_description' => 'CD_10_50_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 50,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_UNCHECKED . '\', 1=> \'' . TEXT_CHECKED . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_52_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_HAZARDOUS_SHOW',
  'configuration_value' => '1',
  'configuration_description' => 'CD_10_52_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 52,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_HIDE . '\', 1=> \'' . TEXT_SHOW . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_54_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_HAZARDOUS_MATERIAL_CHECKED',
  'configuration_value' => '0',
  'configuration_description' => 'CD_10_54_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 54,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_UNCHECKED . '\', 1=> \'' . TEXT_CHECKED . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_56_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_DRY_ICE_SHOW',
  'configuration_value' => '1',
  'configuration_description' => 'CD_10_56_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 56,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_HIDE . '\', 1=> \'' . TEXT_SHOW . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_58_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_DRY_ICE_CHECKED',
  'configuration_value' => '0',
  'configuration_description' => 'CD_10_58_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 58,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_UNCHECKED . '\', 1=> \'' . TEXT_CHECKED . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_60_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_RETURN_SERVICE_SHOW',
  'configuration_value' => '1',
  'configuration_description' => 'CD_10_60_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 60,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_HIDE . '\', 1=> \'' . TEXT_SHOW . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_62_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_RETURN_SERVICE_CHECKED',
  'configuration_value' => '0',
  'configuration_description' => 'CD_10_62_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 62,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_UNCHECKED . '\', 1=> \'' . TEXT_CHECKED . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_10_64_TITLE',
  'configuration_key' => 'SHIPPING_DEFAULT_RETURN_SERVICE',
  'configuration_value' => '2',
  'configuration_description' => 'CD_10_64_DESC',
  'configuration_group_id' => 10, 
  'sort_order' => 64,
  'date_added' => $today,
  'set_function' => 'html_pull_down_menu(\'configuration_value\', gen_build_pull_down($shipping_defaults[\'return_label\']),');

/************************** Group ID 11 (Address Book Defaults) ***********************************************/
$config_data[] = array(
  'configuration_title' => 'CD_11_02_TITLE',
  'configuration_key' => 'ADDRESS_BOOK_CONTACT_REQUIRED',
  'configuration_value' => '0',
  'configuration_description' => 'CD_11_02_DESC',
  'configuration_group_id' => 11, 
  'sort_order' => 2,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_11_03_TITLE',
  'configuration_key' => 'ADDRESS_BOOK_ADDRESS1_REQUIRED',
  'configuration_value' => '1',
  'configuration_description' => 'CD_11_03_DESC',
  'configuration_group_id' => 11, 
  'sort_order' => 3,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_11_04_TITLE',
  'configuration_key' => 'ADDRESS_BOOK_ADDRESS2_REQUIRED',
  'configuration_value' => '0',
  'configuration_description' => 'CD_11_04_DESC',
  'configuration_group_id' => 11, 
  'sort_order' => 4,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_11_05_TITLE',
  'configuration_key' => 'ADDRESS_BOOK_CITY_TOWN_REQUIRED',
  'configuration_value' => '1',
  'configuration_description' => 'CD_11_05_DESC',
  'configuration_group_id' => 11, 
  'sort_order' => 5,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_11_06_TITLE',
  'configuration_key' => 'ADDRESS_BOOK_STATE_PROVINCE_REQUIRED',
  'configuration_value' => '1',
  'configuration_description' => 'CD_11_06_DESC',
  'configuration_group_id' => 11, 
  'sort_order' => 6,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_11_07_TITLE',
  'configuration_key' => 'ADDRESS_BOOK_POSTAL_CODE_REQUIRED',
  'configuration_value' => '1',
  'configuration_description' => 'CD_11_07_DESC',
  'configuration_group_id' => 11, 
  'sort_order' => 7,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_11_08_TITLE',
  'configuration_key' => 'ADDRESS_BOOK_TELEPHONE1_REQUIRED',
  'configuration_value' => '0',
  'configuration_description' => 'CD_11_08_DESC',
  'configuration_group_id' => 11, 
  'sort_order' => 8,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_11_09_TITLE',
  'configuration_key' => 'ADDRESS_BOOK_EMAIL_REQUIRED',
  'configuration_value' => '0',
  'configuration_description' => 'CD_11_09_DESC',
  'configuration_group_id' => 11, 
  'sort_order' => 9,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_11_10_TITLE',
  'configuration_key' => 'ADDRESS_BOOK_SHIP_ADD1_REQ',
  'configuration_value' => '1',
  'configuration_description' => 'CD_11_10_DESC',
  'configuration_group_id' => 11, 
  'sort_order' => 10,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_11_11_TITLE',
  'configuration_key' => 'ADDRESS_BOOK_SHIP_ADD2_REQ',
  'configuration_value' => '0',
  'configuration_description' => 'CD_11_11_DESC',
  'configuration_group_id' => 11, 
  'sort_order' => 11,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_11_12_TITLE',
  'configuration_key' => 'ADDRESS_BOOK_SHIP_CONTACT_REQ',
  'configuration_value' => '0',
  'configuration_description' => 'CD_11_12_DESC',
  'configuration_group_id' => 11, 
  'sort_order' => 12,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_11_13_TITLE',
  'configuration_key' => 'ADDRESS_BOOK_SHIP_CITY_REQ',
  'configuration_value' => '1',
  'configuration_description' => 'CD_11_13_DESC',
  'configuration_group_id' => 11, 
  'sort_order' => 13,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_11_14_TITLE',
  'configuration_key' => 'ADDRESS_BOOK_SHIP_STATE_REQ',
  'configuration_value' => '1',
  'configuration_description' => 'CD_11_14_DESC',
  'configuration_group_id' => 11, 
  'sort_order' => 14,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_11_15_TITLE',
  'configuration_key' => 'ADDRESS_BOOK_SHIP_POSTAL_CODE_REQ',
  'configuration_value' => '1',
  'configuration_description' => 'CD_11_15_DESC',
  'configuration_group_id' => 11, 
  'sort_order' => 15,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

/************************** Group ID 12 (E-mail Settings) ***********************************************/
$config_data[] = array(
  'configuration_title' => 'CD_12_01_TITLE',
  'configuration_key' => 'EMAIL_TRANSPORT',
  'configuration_value' => 'smtp',
  'configuration_description' => 'CD_12_01_DESC',
  'configuration_group_id' => 12, 
  'sort_order' => 1,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'PHP\', \'sendmail\', \'sendmail-f\', \'smtp\', \'smtpauth\', \'Qmail\'),');

$config_data[] = array(
  'configuration_title' => 'CD_12_02_TITLE',
  'configuration_key' => 'EMAIL_LINEFEED',
  'configuration_value' => 'LF',
  'configuration_description' => 'CD_12_02_DESC',
  'configuration_group_id' => 12, 
  'sort_order' => 2,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'LF\', \'CRLF\'),');

$config_data[] = array(
  'configuration_title' => 'CD_12_03_TITLE',
  'configuration_key' => 'SEND_EMAILS',
  'configuration_value' => 'true',
  'configuration_description' => 'CD_12_03_DESC',
  'configuration_group_id' => 12, 
  'sort_order' => 3,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'' . TEXT_YES . '\', \'' . TEXT_NO . '\'), ');

$config_data[] = array(
  'configuration_title' => 'CD_12_04_TITLE',
  'configuration_key' => 'EMAIL_USE_HTML',
  'configuration_value' => 'false',
  'configuration_description' => 'CD_12_04_DESC',
  'configuration_group_id' => 12, 
  'sort_order' => 4,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'' . TEXT_YES . '\', \'' . TEXT_NO . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_12_05_TITLE',
  'configuration_key' => 'ENTRY_EMAIL_ADDRESS_CHECK',
  'configuration_value' => 'false',
  'configuration_description' => 'CD_12_05_DESC',
  'configuration_group_id' => 12, 
  'sort_order' => 5,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'' . TEXT_YES . '\', \'' . TEXT_NO . '\'), ');

$config_data[] = array(
  'configuration_title' => 'CD_12_06_TITLE',
  'configuration_key' => 'EMAIL_ARCHIVE',
  'configuration_value' => 'false',
  'configuration_description' => 'CD_12_06_DESC',
  'configuration_group_id' => 12, 
  'sort_order' => 6,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'' . TEXT_YES . '\', \'' . TEXT_NO . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_12_07_TITLE',
  'configuration_key' => 'EMAIL_FRIENDLY_ERRORS',
  'configuration_value' => 'false',
  'configuration_description' => 'CD_12_07_DESC',
  'configuration_group_id' => 12, 
  'sort_order' => 7,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'' . TEXT_YES . '\', \'' . TEXT_NO . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_12_10_TITLE',
  'configuration_key' => 'STORE_OWNER_EMAIL_ADDRESS',
  'configuration_value' => '',
  'configuration_description' => 'CD_12_10_DESC',
  'configuration_group_id' => 12, 
  'sort_order' => 10,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_12_11_TITLE',
  'configuration_key' => 'EMAIL_FROM',
  'configuration_value' => '',
  'configuration_description' => 'CD_12_11_DESC',
  'configuration_group_id' => 12, 
  'sort_order' => 11,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_12_12_TITLE',
  'configuration_key' => 'EMAIL_SEND_MUST_BE_STORE',
  'configuration_value' => 'No',
  'configuration_description' => 'CD_12_12_DESC',
  'configuration_group_id' => 12, 
  'sort_order' => 12,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'' . TEXT_NO . '\', \'' . TEXT_YES . '\'), ');

$config_data[] = array(
  'configuration_title' => 'CD_12_15_TITLE',
  'configuration_key' => 'ADMIN_EXTRA_EMAIL_FORMAT',
  'configuration_value' => 'TEXT',
  'configuration_description' => 'CD_12_15_DESC',
  'configuration_group_id' => 12, 
  'sort_order' => 15,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'TEXT\', \'HTML\'), ');

$config_data[] = array(
  'configuration_title' => 'CD_12_40_TITLE',
  'configuration_key' => 'CONTACT_US_LIST',
  'configuration_value' => '',
  'configuration_description' => 'CD_12_40_DESC',
  'configuration_group_id' => 12, 
  'sort_order' => 40,
  'date_added' => $today,
  'set_function' => 'cfg_textarea(');

$config_data[] = array(
  'configuration_title' => 'CD_12_50_TITLE',
  'configuration_key' => 'CONTACT_US_STORE_NAME_ADDRESS',
  'configuration_value' => '1',
  'configuration_description' => 'CD_12_50_DESC',
  'configuration_group_id' => 12, 
  'sort_order' => 50,
  'date_added' => $today,
  'set_function' => 'cfg_select_option(array(\'0\', \'1\'), ');

$config_data[] = array(
  'configuration_title' => 'CD_12_70_TITLE',
  'configuration_key' => 'EMAIL_SMTPAUTH_MAILBOX',
  'configuration_value' => '',
  'configuration_description' => 'CD_12_70_DESC',
  'configuration_group_id' => 12, 
  'sort_order' => 70,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_12_71_TITLE',
  'configuration_key' => 'EMAIL_SMTPAUTH_PASSWORD',
  'configuration_value' => '',
  'configuration_description' => 'CD_12_71_DESC',
  'configuration_group_id' => 12, 
  'sort_order' => 71,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_12_72_TITLE',
  'configuration_key' => 'EMAIL_SMTPAUTH_MAIL_SERVER',
  'configuration_value' => '',
  'configuration_description' => 'CD_12_72_DESC',
  'configuration_group_id' => 12, 
  'sort_order' => 72,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_12_73_TITLE',
  'configuration_key' => 'EMAIL_SMTPAUTH_MAIL_SERVER_PORT',
  'configuration_value' => '25',
  'configuration_description' => 'CD_12_73_DESC',
  'configuration_group_id' => 12, 
  'sort_order' => 73,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_12_74_TITLE',
  'configuration_key' => 'CURRENCIES_TRANSLATIONS',
  'configuration_value' => '&pound;,£:&euro;,€',
  'configuration_description' => 'CD_12_74_DESC',
  'configuration_group_id' => 12, 
  'sort_order' => 74,
  'date_added' => $today,
  'set_function' => 'cfg_textarea_small(');

/************************** Group ID 13 (General Ledger Settings) ***********************************************/
$config_data[] = array(
  'configuration_title' => 'CD_13_01_TITLE',
  'configuration_key' => 'AUTO_UPDATE_PERIOD',
  'configuration_value' => '1',
  'configuration_description' => 'CD_13_01_DESC',
  'configuration_group_id' => 13, 
  'sort_order' => 1,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 => \'' . TEXT_NO . '\', 1 => \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_13_05_TITLE',
  'configuration_key' => 'SHOW_FULL_GL_NAMES',
  'configuration_value' => '2',
  'configuration_description' => 'CD_13_05_DESC',
  'configuration_group_id' => 13, 
  'sort_order' => 5,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 => \'' . TEXT_NUMBER . '\', 1 => \'' . TEXT_DESCRIPTION . '\', 2 => \'' . TEXT_BOTH . '\'),');

/************************** Group ID 15 (Sessions Settings) ***********************************************/
$config_data[] = array(
  'configuration_title' => 'CD_15_01_TITLE',
  'configuration_key' => 'SESSION_TIMEOUT_ADMIN',
  'configuration_value' => '3600',
  'configuration_description' => 'CD_15_01_DESC',
  'configuration_group_id' => 15, 
  'sort_order' => 1,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_15_05_TITLE',
  'configuration_key' => 'SESSION_AUTO_REFRESH',
  'configuration_value' => '0',
  'configuration_description' => 'CD_15_05_DESC',
  'configuration_group_id' => 15, 
  'sort_order' => 5,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=>\'' . TEXT_YES . '\'),');

/************************** Group ID 17 (Credit Card Settings) ***********************************************/
$config_data[] = array(
  'configuration_title' => 'CD_17_01_TITLE',
  'configuration_key' => 'CC_OWNER_MIN_LENGTH',
  'configuration_value' => '4',
  'configuration_description' => 'CD_17_01_DESC',
  'configuration_group_id' => 17, 
  'sort_order' => 1,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_17_02_TITLE',
  'configuration_key' => 'CC_NUMBER_MIN_LENGTH',
  'configuration_value' => '15',
  'configuration_description' => 'CD_17_02_DESC',
  'configuration_group_id' => 17, 
  'sort_order' => 2,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'CD_17_03_TITLE',
  'configuration_key' => 'CC_ENABLED_VISA',
  'configuration_value' => '1',
  'configuration_description' => 'CD_17_03_DESC',
  'configuration_group_id' => 17, 
  'sort_order' => 3,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_17_04_TITLE',
  'configuration_key' => 'CC_ENABLED_MC',
  'configuration_value' => '1',
  'configuration_description' => 'CD_17_04_DESC',
  'configuration_group_id' => 17, 
  'sort_order' => 4,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_17_05_TITLE',
  'configuration_key' => 'CC_ENABLED_AMEX',
  'configuration_value' => '0',
  'configuration_description' => 'CD_17_05_DESC',
  'configuration_group_id' => 17, 
  'sort_order' => 5,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_17_06_TITLE',
  'configuration_key' => 'CC_ENABLED_DISCOVER',
  'configuration_value' => '0',
  'configuration_description' => 'CD_17_06_DESC',
  'configuration_group_id' => 17, 
  'sort_order' => 6,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_17_07_TITLE',
  'configuration_key' => 'CC_ENABLED_DINERS_CLUB',
  'configuration_value' => '0',
  'configuration_description' => 'CD_17_07_DESC',
  'configuration_group_id' => 17, 
  'sort_order' => 7,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_17_08_TITLE',
  'configuration_key' => 'CC_ENABLED_JCB',
  'configuration_value' => '0',
  'configuration_description' => 'CD_17_08_DESC',
  'configuration_group_id' => 17, 
  'sort_order' => 8,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

$config_data[] = array(
  'configuration_title' => 'CD_17_09_TITLE',
  'configuration_key' => 'CC_ENABLED_AUSTRALIAN_BANKCARD',
  'configuration_value' => '0',
  'configuration_description' => 'CD_17_09_DESC',
  'configuration_group_id' => 17, 
  'sort_order' => 9,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

/************************** Group ID 19 (Layout Settings) ***********************************************/

/************************** Group ID 20 (Website Maintenence) ***********************************************/
$config_data[] = array(
  'configuration_title' => 'CD_20_99_TITLE',
  'configuration_key' => 'DEBUG',
  'configuration_value' => '0',
  'configuration_description' => 'CD_20_99_DESC',
  'configuration_group_id' => 20, 
  'sort_order' => 99,
  'date_added' => $today,
  'set_function' => 'cfg_keyed_select_option(array(0 =>\'' . TEXT_NO . '\', 1=> \'' . TEXT_YES . '\'),');

/************************** Group ID 99 (Alternate (non-displayed Settings) *********************************/
$config_data[] = array(
  'configuration_title' => 'Default Currency',
  'configuration_key' => 'DEFAULT_CURRENCY',
  'configuration_value' => 'USD',
  'configuration_description' => 'Default Currency (ISO Code)',
  'configuration_group_id' => 99, 
  'sort_order' => 1,
  'date_added' => $today);

$config_data[] = array(
  'configuration_title' => 'Encrypted Encryption value',
  'configuration_key' => 'ENCRYPTION_VALUE',
  'configuration_value' => '0',
  'configuration_description' => 'Encrypted key value.',
  'configuration_group_id' => 99, 
  'sort_order' => 2,
  'date_added' => $today);

?>