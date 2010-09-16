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
//  Path: /includes/database_tables.php
//

if (!defined('DB_PREFIX')) define('DB_PREFIX', '');

define('TABLE_ACCOUNTING_PERIODS',        DB_PREFIX . 'accounting_periods');
define('TABLE_ACCOUNTS_HISTORY',          DB_PREFIX . 'accounts_history');
define('TABLE_ADDRESS_BOOK',              DB_PREFIX . 'address_book');
define('TABLE_AUDIT_LOG',                 DB_PREFIX . 'audit_log');
define('TABLE_CHART_OF_ACCOUNTS',         DB_PREFIX . 'chart_of_accounts');
define('TABLE_CHART_OF_ACCOUNTS_HISTORY', DB_PREFIX . 'chart_of_accounts_history');
define('TABLE_CHART_OF_ACCOUNTS_TYPES',   DB_PREFIX . 'chart_of_accounts_types');
define('TABLE_CONFIGURATION',             DB_PREFIX . 'configuration');
define('TABLE_CONTACTS',                  DB_PREFIX . 'contacts');
define('TABLE_COUNTRIES',                 DB_PREFIX . 'countries');
define('TABLE_CURRENCIES',                DB_PREFIX . 'currencies');
define('TABLE_CURRENT_STATUS',            DB_PREFIX . 'current_status');
define('TABLE_DATA_SECURITY',             DB_PREFIX . 'data_security');
define('TABLE_DEPARTMENTS',               DB_PREFIX . 'departments');
define('TABLE_DEPT_TYPES',                DB_PREFIX . 'departments_types');
define('TABLE_IMPORT_EXPORT',             DB_PREFIX . 'import_export');
define('TABLE_INVENTORY',                 DB_PREFIX . 'inventory');
define('TABLE_INVENTORY_ASSY_LIST',       DB_PREFIX . 'inventory_assy_list');
define('TABLE_INVENTORY_CATEGORIES',      DB_PREFIX . 'inventory_categories');
define('TABLE_INVENTORY_COGS_OWED',       DB_PREFIX . 'inventory_cogs_owed');
define('TABLE_INVENTORY_COGS_USAGE',      DB_PREFIX . 'inventory_cogs_usage');
define('TABLE_INVENTORY_FIELDS',          DB_PREFIX . 'inventory_fields');
define('TABLE_INVENTORY_HISTORY',         DB_PREFIX . 'inventory_history');
define('TABLE_INVENTORY_MS_LIST',         DB_PREFIX . 'inventory_ms_list');
define('TABLE_INVENTORY_SPECIAL_PRICES',  DB_PREFIX . 'inventory_special_prices');
define('TABLE_JOURNAL_ITEM',              DB_PREFIX . 'journal_item');
define('TABLE_JOURNAL_MAIN',              DB_PREFIX . 'journal_main');
define('TABLE_PRICE_SHEETS',              DB_PREFIX . 'price_sheets');
define('TABLE_PROJECT_VERSION',           DB_PREFIX . 'project_version');
define('TABLE_PROJECTS_COSTS',            DB_PREFIX . 'projects_costs');
define('TABLE_PROJECTS_PHASES',           DB_PREFIX . 'projects_phases');
define('TABLE_SHIPPING_LOG',              DB_PREFIX . 'shipping_log');
define('TABLE_QUALITY',                   DB_PREFIX . 'quality_main');
define('TABLE_RECONCILIATION',            DB_PREFIX . 'reconciliation');
define('TABLE_REPORTS',                   DB_PREFIX . 'reports');
define('TABLE_REPORT_FIELDS',             DB_PREFIX . 'report_fields');
define('TABLE_TAX_AUTH',                  DB_PREFIX . 'tax_authorities');
define('TABLE_TAX_RATES',                 DB_PREFIX . 'tax_rates');
define('TABLE_USERS',                     DB_PREFIX . 'users');
define('TABLE_USERS_PROFILES',            DB_PREFIX . 'users_profiles');
define('TABLE_ZONES',                     DB_PREFIX . 'zones');

?>