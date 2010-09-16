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
//  Path: /includes/menu_navigation.php
//

// This array lists the headings in sequence as displayed in the menu bar followed by the company heading at the end.
// The array index is the relative order (no dups), and the link is the the file to redirect to.

// define the order here but may be overridden in /my_files/custom/extra_defines/extra_globals.php file
define('MENU_HEADING_CUSTOMERS_ORDER',10);
define('MENU_HEADING_VENDORS_ORDER',  20);
define('MENU_HEADING_INVENTORY_ORDER',30);
define('MENU_HEADING_BANKING_ORDER',  40);
define('MENU_HEADING_GL_ORDER',       50);
define('MENU_HEADING_EMPLOYEES_ORDER',60);
define('MENU_HEADING_TOOLS_ORDER',    70);
define('MENU_HEADING_QUALITY_ORDER',  80);
define('MENU_HEADING_SETUP_ORDER',    90);
define('MENU_HEADING_COMPANY_ORDER',  99);
$pb_headings[MENU_HEADING_CUSTOMERS_ORDER] = array('text' => MENU_HEADING_CUSTOMERS, 
				'link' => html_href_link(FILENAME_DEFAULT, 'cat=general&amp;module=index&amp;tpl=cat_ar', 'SSL'));
$pb_headings[MENU_HEADING_VENDORS_ORDER] = array('text' => MENU_HEADING_VENDORS, 
				'link' => html_href_link(FILENAME_DEFAULT, 'cat=general&amp;module=index&amp;tpl=cat_ap', 'SSL'));
$pb_headings[MENU_HEADING_INVENTORY_ORDER] = array('text' => MENU_HEADING_INVENTORY, 
				'link' => html_href_link(FILENAME_DEFAULT, 'cat=general&amp;module=index&amp;tpl=cat_inv', 'SSL'));
$pb_headings[MENU_HEADING_BANKING_ORDER] = array('text' => MENU_HEADING_BANKING, 
				'link' => html_href_link(FILENAME_DEFAULT, 'cat=general&amp;module=index&amp;tpl=cat_bnk', 'SSL'));
$pb_headings[MENU_HEADING_GL_ORDER] = array('text' => MENU_HEADING_GL, 
				'link' => html_href_link(FILENAME_DEFAULT, 'cat=general&amp;module=index&amp;tpl=cat_gl', 'SSL'));
$pb_headings[MENU_HEADING_EMPLOYEES_ORDER] = array('text' => MENU_HEADING_EMPLOYEES, 
				'link' => html_href_link(FILENAME_DEFAULT, 'cat=general&amp;module=index&amp;tpl=cat_hr', 'SSL'));
$pb_headings[MENU_HEADING_TOOLS_ORDER] = array('text' => MENU_HEADING_TOOLS, 
				'link' => html_href_link(FILENAME_DEFAULT, 'cat=general&amp;module=index&amp;tpl=cat_setup', 'SSL'));
$pb_headings[MENU_HEADING_QUALITY_ORDER] = array('text' => MENU_HEADING_QUALITY, 
				'link' => html_href_link(FILENAME_DEFAULT, 'cat=general&amp;module=index&amp;tpl=cat_qa', 'SSL'));
$pb_headings[MENU_HEADING_SETUP_ORDER] = array('text' => MENU_HEADING_SETUP, 
				'link' => html_href_link(FILENAME_DEFAULT, 'cat=general&amp;module=index&amp;tpl=cat_setup', 'SSL'));
// The following heading should not be re-indexed...
$pb_headings[MENU_HEADING_COMPANY_ORDER] = array('text' => MENU_HEADING_COMPANY, 
				'link' => html_href_link(FILENAME_DEFAULT, 'cat=general&amp;module=index&amp;tpl=cat_co', 'SSL'));

// This array sets the members of the headings.
// text - the displayed text on the pull down menu
// heading - what category heading the menu item is a part of (must match exactly with a pb_headings text string)
// rank - the order position in the pull down 
// security_id - a unique integer to be used for user access
// link - where selection the menu item will redirect the page

// ************************** Customers **************************
if (SECURITY_ID_MAINTAIN_CUSTOMERS > 1) $menu[] = array(
  'text'        => BOX_ACCOUNTS_NEW_CUSTOMER, 
  'heading'     => MENU_HEADING_CUSTOMERS, 
  'rank'        => 5, 
  'hide'        => true,
  'security_id' => SECURITY_ID_MAINTAIN_CUSTOMERS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=accounts&amp;module=main&amp;action=new&amp;type=c', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_ACCOUNTS_MAINTAIN_CUSTOMERS, 
  'heading'     => MENU_HEADING_CUSTOMERS, 
  'rank'        => 10, 
  'security_id' => SECURITY_ID_MAINTAIN_CUSTOMERS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=accounts&amp;module=main&amp;type=c&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_PHREECRM_MODULE, 
  'heading'     => MENU_HEADING_CUSTOMERS, 
  'rank'        => 15, 
  'security_id' => SECURITY_ID_PHREECRM, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=accounts&amp;module=main&amp;type=i&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_AR_QUOTE, 
  'heading'     => MENU_HEADING_CUSTOMERS, 
  'rank'        => 20, 
  'security_id' => SECURITY_ID_SALES_QUOTE, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;jID=9&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_AR_QUOTE_STATUS, 
  'heading'     => MENU_HEADING_CUSTOMERS, 
  'rank'        => 25, 
  'security_id' => SECURITY_ID_QUOTE_STATUS, 
 'link'         => html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=status&amp;jID=9&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_AR_SALES_ORDER, 
  'heading'     => MENU_HEADING_CUSTOMERS, 
  'rank'        => 30, 
  'security_id' => SECURITY_ID_SALES_ORDER, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;jID=10&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_AR_ORDER_STATUS, 
  'heading'     => MENU_HEADING_CUSTOMERS, 
  'rank'        => 35, 
  'security_id' => SECURITY_ID_SALES_STATUS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=status&amp;jID=10&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_AR_INVOICE, 
  'heading'     => MENU_HEADING_CUSTOMERS, 
  'rank'        => 40, 
  'security_id' => SECURITY_ID_SALES_INVOICE, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;jID=12&amp;page=1', 'SSL'),
);
/*
$menu[] = array(
  'text'        => BOX_AR_POINT_OF_SALE,
  'heading'     => MENU_HEADING_CUSTOMERS,
  'rank'        => 45,
  'security_id' => SECURITY_ID_POINT_OF_SALE,
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;jID=19&amp;page=1', 'SSL'),
);
*/
$menu[] = array(
  'text'        => BOX_AR_INVOICE_MGR, 
  'heading'     => MENU_HEADING_CUSTOMERS, 
  'rank'        => 50, 
  'security_id' => SECURITY_ID_INVOICE_MGR, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=inv_mgr&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_AR_CREDIT_MEMO, 
  'heading'     => MENU_HEADING_CUSTOMERS, 
  'rank'        => 55, 
  'security_id' => SECURITY_ID_SALES_CREDIT, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;jID=13&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_ACCOUNTS_MAINTAIN_PROJECTS, 
  'heading'     => MENU_HEADING_CUSTOMERS, 
  'rank'        => 60, 
  'security_id' => SECURITY_ID_MAINTAIN_PROJECTS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=accounts&amp;module=main&amp;type=j&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_PRICE_SHEET_MANAGER, 
  'heading'     => MENU_HEADING_CUSTOMERS, 
  'rank'        => 65, 
  'security_id' => SECURITY_ID_PRICE_SHEET_MANAGER, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=services&amp;module=price_sheets&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => MENU_HEADING_REPORTS, 
  'heading'     => MENU_HEADING_CUSTOMERS, 
  'rank'        => 99, 
  'security_id' => SECURITY_ID_REPORTS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=reportwriter&amp;module=main#rw_ar', 'SSL'),
);

// ************************** Vendors **************************
if (SECURITY_ID_MAINTAIN_VENDORS > 1) $menu[] = array(
  'text'        => BOX_ACCOUNTS_NEW_VENDOR, 
  'heading'     => MENU_HEADING_VENDORS, 
  'rank'        => 5, 
  'hide'        => true,
  'security_id' => SECURITY_ID_MAINTAIN_VENDORS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=accounts&amp;module=main&amp;action=new&amp;type=v', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_ACCOUNTS_MAINTAIN_VENDORS, 
  'heading'     => MENU_HEADING_VENDORS, 
  'rank'        => 10, 
  'security_id' => SECURITY_ID_MAINTAIN_VENDORS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=accounts&amp;module=main&amp;type=v&amp;page=1', 'SSL'),
);
/*
$menu[] = array(
  'text'        => BOX_PHREECRM_MODULE, 
  'heading'     => MENU_HEADING_VENDORS, 
  'rank'        => 15, 
  'security_id' => SECURITY_ID_PHREECRM, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=accounts&amp;module=main&amp;type=i&amp;page=1', 'SSL'),
);
*/
$menu[] = array(
  'text'        => BOX_AP_REQUEST_QUOTE, 
  'heading'     => MENU_HEADING_VENDORS, 
  'rank'        => 20, 
  'security_id' => SECURITY_ID_PURCHASE_QUOTE, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;jID=3&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_AP_RFQ_STATUS, 
  'heading'     => MENU_HEADING_VENDORS, 
  'rank'        => 25, 
  'security_id' => SECURITY_ID_RFQ_STATUS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=status&amp;jID=3&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_AP_PURCHASE_ORDER, 
  'heading'     => MENU_HEADING_VENDORS, 
  'rank'        => 30, 
  'security_id' => SECURITY_ID_PURCHASE_ORDER, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;jID=4&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_AP_ORDER_STATUS, 
  'heading'     => MENU_HEADING_VENDORS, 
  'rank'        => 35, 
  'security_id' => SECURITY_ID_PURCHASE_STATUS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=status&amp;jID=4&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_AP_RECEIVE_INVENTORY, 
  'heading'     => MENU_HEADING_VENDORS, 
  'rank'        => 40, 
  'security_id' => SECURITY_ID_PURCHASE_INVENTORY, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;jID=6&amp;page=1', 'SSL'),
);
/*
$menu[] = array(
  'text'        => BOX_AP_POINT_OF_PURCHASE,
  'heading'     => MENU_HEADING_VENDORS,
  'rank'        => 45,
  'security_id' => SECURITY_ID_POINT_OF_PURCHASE,
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;jID=21&amp;page=1', 'SSL'),
);
*/
$menu[] = array(
  'text'        => BOX_AP_CREDIT_MEMO, 
  'heading'     => MENU_HEADING_VENDORS, 
  'rank'        => 50, 
  'security_id' => SECURITY_ID_PURCHASE_CREDIT, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;jID=7&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => MENU_HEADING_REPORTS, 
  'heading'     => MENU_HEADING_VENDORS, 
  'rank'        => 99, 
  'security_id' => SECURITY_ID_REPORTS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=reportwriter&amp;module=main#rw_ap', 'SSL'),
);

// ************************** Employees **************************
if (SECURITY_ID_MAINTAIN_EMPLOYEES > 1) $menu[] = array(
  'text'        => BOX_ACCOUNTS_NEW_EMPLOYEE,
  'heading'     => MENU_HEADING_EMPLOYEES, 
  'rank'        => 5, 
  'hide'        => true,
  'security_id' => SECURITY_ID_MAINTAIN_EMPLOYEES, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=accounts&amp;module=main&amp;action=new&amp;type=e', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_ACCOUNTS_MAINTAIN_EMPLOYEES, 
  'heading'     => MENU_HEADING_EMPLOYEES, 
  'rank'        => 10, 
  'security_id' => SECURITY_ID_MAINTAIN_EMPLOYEES, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=accounts&amp;module=main&amp;type=e&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_HR_DEPARTMENTS, 
  'heading'     => MENU_HEADING_EMPLOYEES, 
  'rank'        => 50, 
  'security_id' => SECURITY_ID_DEPARTMENTS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=setup&amp;module=main&amp;subject=departments&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_HR_DEPT_TYPES, 
  'heading'     => MENU_HEADING_EMPLOYEES, 
  'rank'        => 55, 
  'security_id' => SECURITY_ID_DEPT_TYPES, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=setup&amp;module=main&amp;subject=dept_types&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => MENU_HEADING_REPORTS, 
  'heading'     => MENU_HEADING_EMPLOYEES, 
  'rank'        => 99, 
  'security_id' => SECURITY_ID_REPORTS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=reportwriter&amp;module=main#rw_hr', 'SSL'),
);

// ************************** Banking **************************
$menu[] = array(
  'text'        => BOX_BANKING_CUSTOMER_RECEIPTS,
  'heading'     => MENU_HEADING_BANKING,
  'rank'        => 5,
  'security_id' => SECURITY_ID_CUSTOMER_RECEIPTS,
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=banking&amp;module=bills&amp;jID=18&amp;type=c', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_BANKING_CUSTOMER_DEPOSITS,
  'heading'     => MENU_HEADING_BANKING,
  'rank'        => 10,
  'security_id' => SECURITY_ID_CUSTOMER_DEPOSITS,
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=banking&amp;module=bills_deposit&amp;type=c', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_BANKING_PAY_BILLS,
  'heading'     => MENU_HEADING_BANKING,
  'rank'        => 15,
  'security_id' => SECURITY_ID_PAY_BILLS,
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=banking&amp;module=bills&amp;jID=20&amp;type=v', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_BANKING_SELECT_FOR_PAYMENT,
  'heading'     => MENU_HEADING_BANKING,
  'rank'        => 20,
  'security_id' => SECURITY_ID_SELECT_PAYMENT,
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=banking&amp;module=bulk_bills', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_BANKING_BANK_ACCOUNT_REGISTER,
  'heading'     => MENU_HEADING_BANKING,
  'rank'        => 25,
  'security_id' => SECURITY_ID_ACCT_REGISTER,
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=banking&amp;module=register', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_BANKING_ACCOUNT_RECONCILIATION,
  'heading'     => MENU_HEADING_BANKING,
  'rank'        => 30,
  'security_id' => SECURITY_ID_ACCT_RECONCILIATION,
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=banking&amp;module=reconciliation', 'SSL'),
);
/*
$menu[] = array(
  'text'        => BOX_BANKING_VOID_CHECKS,
  'heading'     => MENU_HEADING_BANKING,
  'rank'        => 35,
  'security_id' => SECURITY_ID_VOID_CHECKS,
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=banking&amp;module=', 'SSL'),
);
*/
$menu[] = array(
  'text'        => BOX_BANKING_CUSTOMER_PAYMENTS,
  'heading'     => MENU_HEADING_BANKING,
  'rank'        => 40,
  'security_id' => SECURITY_ID_CUSTOMER_PAYMENTS,
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=banking&amp;module=bills&amp;jID=20&amp;type=c', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_BANKING_VENDOR_RECEIPTS,
  'heading'     => MENU_HEADING_BANKING,
  'rank'        => 45,
  'security_id' => SECURITY_ID_VENDOR_RECEIPTS,
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=banking&amp;module=bills&amp;jID=18&amp;type=v', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_BANKING_VENDOR_DEPOSITS,
  'heading'     => MENU_HEADING_BANKING,
  'rank'        => 50,
  'security_id' => SECURITY_ID_VENDOR_DEPOSITS,
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=banking&amp;module=bills_deposit&amp;type=v', 'SSL'),
);
$menu[] = array(
  'text'        => MENU_HEADING_REPORTS, 
  'heading'     => MENU_HEADING_BANKING, 
  'rank'        => 99, 
  'security_id' => SECURITY_ID_REPORTS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=reportwriter&amp;module=main#rw_bnk', 'SSL'),
);

// ************************** General Ledger **************************
$menu[] = array(
  'text'        => BOX_GL_JOURNAL_ENTRY, 
  'heading'     => MENU_HEADING_GL, 
  'rank'        => 5, 
  'security_id' => SECURITY_ID_JOURNAL_ENTRY, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=gen_ledger&amp;module=journal', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_GL_ACCOUNTS, 
  'heading'     => MENU_HEADING_GL, 
  'rank'        => 10, 
  'security_id' => SECURITY_ID_CHART_ACCOUNTS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=setup&amp;module=main&amp;subject=chart_of_accounts&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_GL_BUDGET, 
  'heading'     => MENU_HEADING_GL, 
  'rank'        => 50, 
  'security_id' => SECURITY_ID_GL_BUDGET, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=gen_ledger&amp;module=budget', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_GL_UTILITIES,
  'heading'     => MENU_HEADING_GL,
  'rank'        => 95,
  'security_id' => SECURITY_ID_GL_UTILITIES, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=gen_ledger&amp;module=utils', 'SSL'),
);
$menu[] = array(
  'text'        => MENU_HEADING_REPORTS, 
  'heading'     => MENU_HEADING_GL, 
  'rank'        => 99, 
  'security_id' => SECURITY_ID_REPORTS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=reportwriter&amp;module=main#rw_gl', 'SSL'),
);

// ************************** Inventory **************************
$menu[] = array(
  'text'        => BOX_INV_MAINTAIN, 
  'heading'     => MENU_HEADING_INVENTORY, 
  'rank'        => 5, 
  'security_id' => SECURITY_ID_MAINTAIN_INVENTORY, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=inventory&amp;module=main&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_INV_ADJUSTMENTS, 
  'heading'     => MENU_HEADING_INVENTORY, 
  'rank'        => 15, 
  'security_id' => SECURITY_ID_ADJUST_INVENTORY, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=inventory&amp;module=adjustments', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_INV_ASSEMBLIES, 
  'heading'     => MENU_HEADING_INVENTORY, 
  'rank'        => 20, 
  'security_id' => SECURITY_ID_ASSEMBLE_INVENTORY, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=inventory&amp;module=assemblies', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_INV_TABS, 
  'heading'     => MENU_HEADING_INVENTORY, 
  'rank'        => 25, 
  'security_id' => SECURITY_ID_INV_TABS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=setup&amp;module=main&amp;subject=inv_tabs&amp;page=1', 'SSL'),
);

$menu[] = array(
  'text'        => BOX_INV_FIELDS, 
  'heading'     => MENU_HEADING_INVENTORY, 
  'rank'        => 30, 
  'security_id' => SECURITY_ID_INV_FIELDS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=inventory&amp;module=inv_fields&amp;page=1', 'SSL'),
);
if (ENABLE_MULTI_BRANCH) $menu[] = array(
  'text'        => BOX_INV_TRANSFER, 
  'heading'     => MENU_HEADING_INVENTORY, 
  'rank'        => 80, 
  'security_id' => SECURITY_ID_TRANSFER_INVENTORY, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=inventory&amp;module=transfer', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_INV_TOOLS,
  'heading'     => MENU_HEADING_INVENTORY,
  'rank'        => 85,
  'security_id' => SECURITY_ID_INV_TOOLS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=inventory&amp;module=tools', 'SSL'),
);
$menu[] = array(
  'text'        => MENU_HEADING_REPORTS, 
  'heading'     => MENU_HEADING_INVENTORY, 
  'rank'        => 99, 
  'security_id' => SECURITY_ID_REPORTS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=reportwriter&amp;module=main#rw_inv', 'SSL'),
);

// ************************** Quality **************************
/*
$menu[] = array(
  'text'        => BOX_QUALITY_HOME, 
  'heading'     => MENU_HEADING_QUALITY, 
  'rank'        => 5, 
  'security_id' => SECURITY_ID_QUALITY_HOME, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=quality&amp;module=&amp;page=1', 'SSL'),
);
*/
// ************************** Tools **************************
if (DEBUG) $menu[] = array(
  'text'        => 'Debug Download',
  'heading'     => MENU_HEADING_TOOLS,
  'rank'        => 0,
  'hide'        => true,
  'security_id' => SECURITY_ID_CONFIGURATION,
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=general&amp;module=debug', 'SSL'),
);
if (ENABLE_ENCRYPTION) $menu[] = array(
  'text'        => BOX_HEADING_ENCRYPTION,
  'heading'     => MENU_HEADING_TOOLS,
  'rank'        => 1,
  'security_id' => SECURITY_ID_ENCRYPTION,
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=general&amp;module=encryption', 'SSL'),
);
if (ENABLE_SHIPPING_FUNCTIONS) $menu[] = array(
  'text'        => BOX_SHIPPING_MANAGER, 
  'heading'     => MENU_HEADING_TOOLS, 
  'rank'        => 5, 
  'security_id' => SECURITY_ID_SHIPPING_MANAGER, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=services&amp;module=ship_mgr', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_COMPANY_MANAGER,
  'heading'     => MENU_HEADING_TOOLS, 
  'rank'        => 15, 
  'security_id' => SECURITY_ID_COMPANY_MGR, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=setup&amp;module=company_mgr', 'SSL'),
);
$menu[] = array(
  'text'        => MENU_HEADING_REPORTS, 
  'heading'     => MENU_HEADING_TOOLS, 
  'rank'        => 20, 
  'security_id' => SECURITY_ID_REPORTS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=reportwriter&amp;module=main', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_IMPORT_EXPORT, 
  'heading'     => MENU_HEADING_TOOLS, 
  'rank'        => 50, 
  'security_id' => SECURITY_ID_IMPORT_EXPORT, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=services&amp;module=imp_exp', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_HEADING_ADMIN_TOOLS,
  'heading'     => MENU_HEADING_TOOLS,
  'rank'        => 70,
  'security_id' => SECURITY_ID_GEN_ADMIN_TOOLS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=general&amp;module=admin_tools', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_HEADING_SEARCH,
  'heading'     => MENU_HEADING_TOOLS,
  'rank'        => 90,
  'security_id' => SECURITY_ID_SEARCH, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=general&amp;module=search&amp;journal_id=-1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_HEADING_BACKUP,
  'heading'     => MENU_HEADING_TOOLS,
  'rank'        => 95,
  'security_id' => SECURITY_ID_BACKUP, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=general&amp;module=backup', 'SSL'),
);
// ************************** Setup **************************
$menu[] = array(
  'text'        => BOX_CURRENCIES,
  'heading'     => MENU_HEADING_SETUP,
  'rank'        => 5,
  'security_id' => SECURITY_ID_CURRENCIES, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=setup&amp;module=main&amp;subject=currency&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_TAX_AUTH, 
  'heading'     => MENU_HEADING_SETUP, 
  'rank'        => 10, 
  'security_id' => SECURITY_ID_TAX_AUTHORITIES, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=setup&amp;module=main&amp;subject=tax_auths&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_TAX_AUTH_VEND, 
  'heading'     => MENU_HEADING_SETUP, 
  'rank'        => 12, 
  'security_id' => SECURITY_ID_TAX_AUTHS_VEND, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=setup&amp;module=main&amp;subject=tax_auths_vend&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_TAX_RATES, 
  'heading'     => MENU_HEADING_SETUP, 
  'rank'        => 15, 
  'security_id' => SECURITY_ID_TAX_RATES, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=setup&amp;module=main&amp;subject=tax_rates&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_TAX_RATES_VEND, 
  'heading'     => MENU_HEADING_SETUP, 
  'rank'        => 17, 
  'security_id' => SECURITY_ID_TAX_RATES_VEND, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=setup&amp;module=main&amp;subject=tax_rates_vend&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_TAXES_COUNTRIES, 
  'heading'     => MENU_HEADING_SETUP, 
  'rank'        => 20, 
  'security_id' => SECURITY_ID_COUNTRIES, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=setup&amp;module=main&amp;subject=countries&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_TAXES_ZONES, 
  'heading'     => MENU_HEADING_SETUP, 
  'rank'        => 25, 
  'security_id' => SECURITY_ID_ZONES, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=setup&amp;module=main&amp;subject=zones&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_PROJECTS_PHASES, 
  'heading'     => MENU_HEADING_SETUP, 
  'rank'        => 30, 
  'security_id' => SECURITY_ID_PROJECT_PHASES, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=setup&amp;module=main&amp;subject=project_phases&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_PROJECTS_COSTS, 
  'heading'     => MENU_HEADING_SETUP, 
  'rank'        => 35, 
  'security_id' => SECURITY_ID_PROJECT_COSTS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=setup&amp;module=main&amp;subject=project_costs&amp;page=1', 'SSL'),
);
if (ENABLE_MULTI_BRANCH) { // don't show menu if multi-branch is disabled
  if (SECURITY_ID_MAINTAIN_BRANCH > 1) $menu[] = array(
    'text'        => BOX_ACCOUNTS_NEW_BRANCH, 
	'heading'     => MENU_HEADING_SETUP, 
	'rank'        => 55, 
	'hide'        => true,
	'security_id' => SECURITY_ID_MAINTAIN_BRANCH, 
	'link'        => html_href_link(FILENAME_DEFAULT, 'cat=accounts&amp;module=main&amp;action=new&amp;type=b', 'SSL'),
  );
  $menu[] = array(
    'text'        => BOX_ACCOUNTS_MAINTAIN_BRANCHES, 
	'heading'     => MENU_HEADING_SETUP, 
	'rank'        => 56, 
	'security_id' => SECURITY_ID_MAINTAIN_BRANCH, 
	'link'        => html_href_link(FILENAME_DEFAULT, 'cat=accounts&amp;module=main&amp;type=b&amp;page=1', 'SSL'),
  );
} // end disable if not looking at branches
if (ENABLE_SHIPPING_FUNCTIONS) $menu[] = array(
  'text'        => BOX_SHIPPING, 
  'heading'     => MENU_HEADING_SETUP, 
  'rank'        => 60, 
  'security_id' => SECURITY_ID_SHIPPING, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=services&amp;module=main&amp;set=shipping&amp;page=1', 'SSL'),
  );
$menu[] = array(
  'text'        => BOX_PAYMENTS, 
  'heading'     => MENU_HEADING_SETUP, 
  'rank'        => 65, 
  'security_id' => SECURITY_ID_PAYMENT, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=services&amp;module=main&amp;set=payment&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_PRICE_SHEETS, 
  'heading'     => MENU_HEADING_SETUP, 
  'rank'        => 70, 
  'security_id' => SECURITY_ID_PRICE_SHEETS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=services&amp;module=main&amp;set=pricesheets&amp;page=1', 'SSL'),
);
$menu[] = array(
  'text'        => BOX_HEADING_USERS,
  'heading'     => MENU_HEADING_SETUP,
  'rank'        => 99,
  'security_id' => SECURITY_ID_USERS, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=general&amp;module=users&amp;page=1', 'SSL'),
);

// ************************** Company **************************
$menu[] = array(
  'text'        => BOX_COMPANY_CONFIG,
  'heading'     => MENU_HEADING_COMPANY, 
  'rank'        => 99, 
  'security_id' => SECURITY_ID_CONFIGURATION, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=setup&amp;module=config', 'SSL'),
);

/*********************************************************************************************************
									Configuration Groups
/*********************************************************************************************************/
// reserved indexes => 6 - used for services, put in order to appear in menu
$config_groups = array(
  '1'  => array('title' => CG_01_TITLE, 'description' => CG_01_DESC), // My Company
  '2'  => array('title' => CG_02_TITLE, 'description' => CG_02_DESC), // Customer Defaults
  '3'  => array('title' => CG_03_TITLE, 'description' => CG_03_DESC), // Vendor Defaults
  '4'  => array('title' => CG_04_TITLE, 'description' => CG_04_DESC), // Employee Defaults
  '5'  => array('title' => CG_05_TITLE, 'description' => CG_05_DESC), // Inventory Defaults
  '13' => array('title' => CG_13_TITLE, 'description' => CG_13_DESC), // General Ledger Defaults
  '7'  => array('title' => CG_07_TITLE, 'description' => CG_07_DESC), // User Account Defaults
  '8'  => array('title' => CG_08_TITLE, 'description' => CG_08_DESC), // General Settings
  '9'  => array('title' => CG_09_TITLE, 'description' => CG_09_DESC), // Import / Export Settings
  '10' => array('title' => CG_10_TITLE, 'description' => CG_10_DESC), // Shipping Defaults
  '11' => array('title' => CG_11_TITLE, 'description' => CG_11_DESC), // Address Book Defaults
  '12' => array('title' => CG_12_TITLE, 'description' => CG_12_DESC), // E-Mail Options
  '15' => array('title' => CG_15_TITLE, 'description' => CG_15_DESC), // Sessions
  '17' => array('title' => CG_17_TITLE, 'description' => CG_17_DESC), // Credit Cards
  '19' => array('title' => CG_19_TITLE, 'description' => CG_19_DESC), // Layout Settings
  '20' => array('title' => CG_20_TITLE, 'description' => CG_20_DESC), // Website Maintenance
);

?>