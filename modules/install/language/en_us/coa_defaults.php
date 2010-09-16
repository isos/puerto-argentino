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
//  Path: /modules/install/language/en_us/coa_defaults.php
//

  define('SAVE_STORE_SETTINGS', 'Save Default Settings'); //this comes before TEXT_MAIN
  define('TEXT_MAIN', "This section of the PhreeBooks&trade; setup tool will help you set up your company's default accounts. You will be able to change any of these settings later using the Company menu.  Please make your selections and press <em>".SAVE_STORE_SETTINGS."</em> to continue. <br /><br />NOTE: PhreeBooks will take an educated guess at the default inventory accounts during this step. It is recommended to review these settings through the <em>Company</em> menu before setting up inventory items.");
  define('TEXT_PAGE_HEADING', 'PhreeBooks&trade; Setup - Account Defaults');
  define('STORE_INFORMATION', 'Default Account Information');
  define('COA_REFERENCE','Your Chart of Accounts for Reference:');

// for best guess of accounts to pre-set the account pull downs
  define('TEXT_INVENTORY','inventory');
  define('TEXT_PAYABLE','payable');
  define('TEXT_PURCHASE_DISCOUNT','purchase discount');
  define('ORD_FREIGHT','freight');
  define('TEXT_CHECKING','checking');
  define('TEXT_SALES','sales');
  define('TEXT_RECEIVABLES','receivables');
  define('TEXT_SALES_DISCOUNT','sales discount');
  define('TEXT_COGS','cost of sales');

  define('STORE_DEFAULT_INV_ACCT','Default Inventory Item Purchase Account');
  define('STORE_DEFAULT_INV_ACT_INSTRUCTION','Select an account to use for inventory managed items purchased from vendors. This account should be an \'Inventory\' type account.');
  define('STORE_DEFAULT_AP_PURCH','Default Purchase Account');
  define('STORE_DEFAULT_AP_PURCH_INSTRUCTION','Select an account to use for inventory managed items purchased from vendors. This account should be an \'Accounts Payable\' type account.');
  define('STORE_DEFAULT_AP_DISC','Default Purchase Discount Account');
  define('STORE_DEFAULT_AP_DISC_INSTRUCTION','Select an account to use for discounts on payments made to vendors. This account should be an \'Income\' type account.');
  define('STORE_DEFAULT_AP_FRT','Default Purchase Freight In Account ');
  define('STORE_DEFAULT_AP_FRT_INSTRUCTION','Select an account to use for freight payments on purchases. This account should be an \'Expense\' type account.');
  define('STORE_DEFAULT_AP_PMT','Default Vendor Payment Account');
  define('STORE_DEFAULT_AP_PMT_INSTRUCTION','Select an account to use for payments made to vendors for invoices, inventory payments, etc. This account should be an \'Cash\' type account.');
  define('STORE_DEFAULT_AR_SALES','Default Sales Account');
  define('STORE_DEFAULT_AR_SALES_INSTRUCTION','Select an account to use for sales to customers. This account should be an \'Income\' type account.');
  define('STORE_DEFAULT_AR_RCV','Default Accounts Receivable Account');
  define('STORE_DEFAULT_AR_RCV_INSTRUCTION','Select an account to use for invoiced sales to customers. This account should be an \'Accounts Receivable\' type account.');
  define('STORE_DEFAULT_AR_DISC','Default Sales Discount Account');
  define('STORE_DEFAULT_AR_DISC_INSTRUCTION','Select an account to use for discounts to customers for promotions, early payments, etc. This account should be an \'Income\' type account.');
  define('STORE_DEFAULT_AR_FRT','Default Sales Freight Out Account');
  define('STORE_DEFAULT_AR_FRT_INSTRUCTION','Select an account to use for freight charges associated with shipments to customers. This account should be an \'Income\' type account.');
  define('STORE_DEFAULT_AR_RCPT','Default Customer Payment Account');
  define('STORE_DEFAULT_AR_RCPT_INSTRUCTION','Select an account to use for payments received from customers. This account should be an \'Cash\' type account.');

?>