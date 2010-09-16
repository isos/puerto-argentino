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
//  Path: /includes/security_tokens.php
//

// Security id's (values from 1 through 199 are reserved for current and future PhreeBooks additions)
// Use 200+ for customization
// General 1-25
define('SECURITY_ID_USERS',                1);
define('SECURITY_ID_IMPORT_EXPORT',        2);
define('SECURITY_ID_REPORTS',              3);
define('SECURITY_ID_SEARCH',               4);
define('SECURITY_ID_CURRENCIES',           5);
define('SECURITY_ID_TAX_AUTHORITIES',      6);
define('SECURITY_ID_TAX_RATES',            7);
define('SECURITY_ID_COUNTRIES',            8);
define('SECURITY_ID_ZONES',                9);
define('SECURITY_ID_GEO_ZONES',           10);
define('SECURITY_ID_CONFIGURATION',       11);
define('SECURITY_ID_COMPANY_MGR',         12);
define('SECURITY_ID_SHIPPING_MANAGER',    13);
define('SECURITY_ID_SHIPPING_MGR',        14);
define('SECURITY_ID_MAINTAIN_BRANCH',     15);
define('SECURITY_ID_MAINTAIN_PROJECTS',   16);
define('SECURITY_ID_SHIPPING',            17);
define('SECURITY_ID_BACKUP',              18);
define('SECURITY_ID_GEN_ADMIN_TOOLS',     19);
define('SECURITY_ID_ENCRYPTION',          20);
define('SECURITY_ID_TAX_AUTHS_VEND',      21);
define('SECURITY_ID_TAX_RATES_VEND',      22);
// Receivables 26-50
define('SECURITY_ID_MAINTAIN_CUSTOMERS',  26);
define('SECURITY_ID_SALES_ORDER',         28);
define('SECURITY_ID_SALES_QUOTE',         29);
define('SECURITY_ID_SALES_INVOICE',       30);
define('SECURITY_ID_SALES_CREDIT',        31);
define('SECURITY_ID_SALES_STATUS',        32);
//define('SECURITY_ID_POINT_OF_SALE',     33);
define('SECURITY_ID_INVOICE_MGR',         34);
define('SECURITY_ID_QUOTE_STATUS',        35);
define('SECURITY_ID_PROJECT_PHASES',      36);
define('SECURITY_ID_PROJECT_COSTS',       37);
define('SECURITY_ID_PHREECRM',            49);

// Payables 51-74
define('SECURITY_ID_MAINTAIN_VENDORS',    51);
define('SECURITY_ID_PURCHASE_ORDER',      53);
define('SECURITY_ID_PURCHASE_QUOTE',      54);
define('SECURITY_ID_PURCHASE_INVENTORY',  55);
//define('SECURITY_ID_POINT_OF_PURCHASE', 56);
define('SECURITY_ID_PURCHASE_CREDIT',     57);
define('SECURITY_ID_PURCHASE_STATUS',     58);
define('SECURITY_ID_RFQ_STATUS',          59);
// Human Resources 75-99
define('SECURITY_ID_MAINTAIN_EMPLOYEES',  76);
define('SECURITY_ID_DEPARTMENTS',         78);
define('SECURITY_ID_DEPT_TYPES',          79);
define('SECURITY_ID_PAYROLL_ENTRY',       80);
define('SECURITY_ID_PAYMENT',             81);
define('SECURITY_ID_PRICE_SHEETS',        87);
define('SECURITY_ID_PRICE_SHEET_MANAGER', 88);
// Banking 100-125
define('SECURITY_ID_SELECT_PAYMENT',     101);
define('SECURITY_ID_CUSTOMER_RECEIPTS',  102);
define('SECURITY_ID_PAY_BILLS',          103);
define('SECURITY_ID_ACCT_RECONCILIATION',104);
define('SECURITY_ID_ACCT_REGISTER',      105);
define('SECURITY_ID_VOID_CHECKS',        106);
define('SECURITY_ID_CUSTOMER_PAYMENTS',  107);
define('SECURITY_ID_VENDOR_RECEIPTS',    108);
define('SECURITY_ID_CUSTOMER_DEPOSITS',  109);
define('SECURITY_ID_VENDOR_DEPOSITS',    110);
// General Journal 126-150
define('SECURITY_ID_JOURNAL_ENTRY',      126);
define('SECURITY_ID_CHART_ACCOUNTS',     127);
define('SECURITY_ID_GL_UTILITIES',       128);
define('SECURITY_ID_GL_BUDGET',          129);
// Inventory 151-175
define('SECURITY_ID_MAINTAIN_INVENTORY', 151);
define('SECURITY_ID_ADJUST_INVENTORY',   152);
define('SECURITY_ID_ASSEMBLE_INVENTORY', 153);
define('SECURITY_ID_INV_TABS',           154);
define('SECURITY_ID_INV_FIELDS',         155);
define('SECURITY_ID_TRANSFER_INVENTORY', 156);
define('SECURITY_ID_INV_TOOLS',          157);
// Quality 176-199
define('SECURITY_ID_QUALITY_HOME',       176);

?>