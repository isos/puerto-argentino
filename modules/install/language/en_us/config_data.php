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
//  Path: /modules/install/language/en_us/config_data.php
//

// Set some general translations (may be set in general/language already
define('TEXT_YES','Yes');
define('TEXT_NO','No');
define('TEXT_SINGLE_MODE','Single Line Item Mode');
define('TEXT_DOUBLE_MODE','Two Line Item Mode');
define('TEXT_AFTER_DISCOUNT','After Discount');
define('TEXT_BEFORE_DISCOUNT','Before Discount');
define('TEXT_LOCAL','Local');
define('TEXT_DOWNLOAD','Download');
define('TEXT_CHECKED','Checked');
define('TEXT_UNCHECKED','Unchecked');
define('TEXT_HIDE','Hide');
define('TEXT_SHOW','Show');
define('TEXT_NUMBER','Number');
define('TEXT_DESCRIPTION','Description');
define('TEXT_BOTH','Both');
define('TEXT_PURCH_ORDER','Purchase Orders');
define('TEXT_PURCHASE','Purchases');

/*********************************************************************************************************
									Configuration Data
/*********************************************************************************************************/
/************************** Group ID 0 (System set constants) ***********************************************/
// code CD_xx_yy_TITLE : CD - config data, xx - group ID, yy - sort order
define('CD_00_01_TITLE','Current Accounting Period');
define('CD_00_01_DESC', 'This value defines the current accounting period. IT IS SET BY THE SYSTEM.');
define('CD_00_02_TITLE','Current Accounting Period - Start Date');
define('CD_00_02_DESC', 'This value defines the current accounting period start date. IT IS SET BY THE SYSTEM.');
define('CD_00_03_TITLE','Current Accounting Period - End Date');
define('CD_00_03_DESC', 'This value defines the current accounting period end date. IT IS SET BY THE SYSTEM.');
define('CD_00_04_TITLE','Installed Modules');
define('CD_00_04_DESC', 'List of shipping module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: ups.php;flat.php;item.php)');
/************************** Group ID 1 (My Company) ***********************************************/
define('CD_01_01_TITLE','Company Name');
define('CD_01_01_DESC', 'The name of my company');
define('CD_01_02_TITLE','Receivables Contact Name');
define('CD_01_02_DESC', 'The default name or identifier to use for all receivable operations.');
define('CD_01_03_TITLE','Payables Contact Name');
define('CD_01_03_DESC', 'The default name or identifier to use for all payable operations.');
define('CD_01_04_TITLE','Address Line 1');
define('CD_01_04_DESC', 'First address line');
define('CD_01_05_TITLE','Address Line 2');
define('CD_01_05_DESC', 'Second address line');
define('CD_01_06_TITLE','City or Town');
define('CD_01_06_DESC', 'The city or town where this company is located');
define('CD_01_07_TITLE','State or Region');
define('CD_01_07_DESC', 'The state or region where this company is located');
define('CD_01_08_TITLE','Postal Code');
define('CD_01_08_DESC', 'Postal or Zip code where this company is located');
define('CD_01_09_TITLE','Country');
define('CD_01_09_DESC', 'The country this company is located <br /><br /><strong>Note: Please remember to update the company state or region.</strong>');
define('CD_01_10_TITLE','Primary Telephone Number');
define('CD_01_10_DESC', 'Enter the company\'s primary telephone number');
define('CD_01_11_TITLE','Secondary Telephone Number');
define('CD_01_11_DESC', 'Secondary telephone number (may also be toll free number)');
define('CD_01_12_TITLE','Fax Telephone Number');
define('CD_01_12_DESC', 'Enter the company\'s fax number');
define('CD_01_13_TITLE','Company E-mail Address');
define('CD_01_13_DESC', 'Enter the general company email address');
define('CD_01_14_TITLE','Company Website');
define('CD_01_14_DESC', 'Enter the homepage of the company website (without the http://)');
define('CD_01_15_TITLE','Company Tax ID Number');
define('CD_01_15_DESC', 'Enter the company\'s (Federal) tax ID number');
define('CD_01_16_TITLE','Company ID');
define('CD_01_16_DESC', 'Enter the company ID number. This number is used to identify transactions generated locally versus imported/exported transactions.');
define('CD_01_18_TITLE','Enable Multi-Branch Support');
define('CD_01_18_DESC', 'Enable multiple branch functionality.<br />If No is selected, only one company location will be assumed.');
define('CD_01_19_TITLE','Enable Multi-Currency Displays');
define('CD_01_19_DESC', 'Enable multiple currencies in user entry screens.<br />If No is selected, only the default currency wil be used.');
define('CD_01_20_TITLE','Switch To Default Language Currency');
define('CD_01_20_DESC', 'Automatically switch to the language\'s currency when it is changed');
define('CD_01_25_TITLE','Enable Shipping Functions');
define('CD_01_25_DESC', 'Whether or not to enable the shipping functions and shipping fields.');
define('CD_01_30_TITLE','Enable Encryption of Information');
define('CD_01_30_DESC', 'Whether or not allow storage of encrypted fields.');
define('CD_01_50_TITLE','Enable percent/value discounts on order totals');
define('CD_01_50_DESC', 'This feature adds two additional fields to the order screens to enter an order level discount value or percent. If disabled, the fields will not be displayed on the order screens.');
define('CD_01_52_TITLE','Round tax by authority');
define('CD_01_52_DESC', 'Enabling this feature will cause PhreeBooks to round calculated taxes by authority prior to adding up all applicable authorities. For tax rates with a single authority, this will only keep math precision errors from entering the journal. For multi-authority tax rates, this could cause too much or too little tax from being collected. If not sure, leave set to No.');
define('CD_01_55_TITLE','Enable bar code readers');
define('CD_01_55_DESC', 'If set to true, this option will enable data entry on order forms for USB and supported bar code readers.');
define('CD_01_75_TITLE','Use Single Line Item Order Screen');
define('CD_01_75_DESC', 'If set to true, this option uses a single line order screen without displayed fields for full price and discount. The single line screen uses GL account numbers versus allowing full GL account numbers/descriptions in two line mode.');
/************************** Group ID 2 (Customer Defaults) ***********************************************/
define('CD_02_01_TITLE','Default Account - Accounts Receivable');
define('CD_02_01_DESC', 'Default Accounts Receivable Account');
define('CD_02_02_TITLE','Default GL Sales Account');
define('CD_02_02_DESC', 'Default general ledger account for sales transactions');
define('CD_02_03_TITLE','Default GL Cash Receipts Account');
define('CD_02_03_DESC', 'General ledger account to apply receipts to when customers pay invoices.');
define('CD_02_04_TITLE','Default GL Discount Account');
define('CD_02_04_DESC', 'General ledger account to apply discounts to when customers pay on early schedule with a discount applied.');
define('CD_02_05_TITLE','Default Freight Account');
define('CD_02_05_DESC', 'Default account to record freight charges');
define('CD_02_06_TITLE','Default Customer Deposit Account');
define('CD_02_06_DESC', 'Default cash account to use for customer deposits.');
define('CD_02_07_TITLE','Default Customer Deposit Liability Account');
define('CD_02_07_DESC', 'Default Other Current Liabilities account to use for customer deposits.');
define('CD_02_10_TITLE','Payment Terms');
define('CD_02_10_DESC', 'Payment Terms Selection');
define('CD_02_11_TITLE','Use Credit Limit');
define('CD_02_11_DESC', 'Use customer credit limit when processing orders');
define('CD_02_12_TITLE','Credit Limit Amount');
define('CD_02_12_DESC', 'Default amount to use for customer credit limit.');
define('CD_02_13_TITLE','Num Days Due');
define('CD_02_13_DESC', 'The number of days payment is due for use when terms are accepted (due in # of days, dus on day)');
define('CD_02_14_TITLE','Prepayment Discount Number of Days');
define('CD_02_14_DESC', 'Number of days to use for prepayment discount. Use in conjunction with Prepayment Discount below. Enter 0 for no prepayment discount.');
define('CD_02_15_TITLE','Prepayment Discount Percent');
define('CD_02_15_DESC', 'Percent discount for early payment. Not used unless Prepayment Discount Number of Days is equal to zero.');
define('CD_02_16_TITLE','Account Aging Calculation Start Date');
define('CD_02_16_DESC', 'Sets the start time for account aging. Choices are:<br />0 - Invoice Date or 1 - Due Date');
define('CD_02_17_TITLE','Account Aging Period 1');
define('CD_02_17_DESC', 'Determines the number of days for the first warning of past due invoices. The period starts from the Account Aging Start Date Field.');
define('CD_02_18_TITLE','Account Aging Period 2');
define('CD_02_18_DESC', 'Determines the number of days for the first warning of past due invoices. The period starts from the Account Aging Start Date Field.');
define('CD_02_19_TITLE','Account Aging Period 3');
define('CD_02_19_DESC', 'Determines the number of days for the first warning of past due invoices. The period starts from the Account Aging Start Date Field.');
define('CD_02_20_TITLE','Account Aging Heading 1');
define('CD_02_20_DESC', 'This is the heading used on reports to show account aging for due date number 1.');
define('CD_02_21_TITLE','Account Aging Heading 2');
define('CD_02_21_DESC', 'This is the heading used on reports to show account aging for due date number 2.');
define('CD_02_22_TITLE','Account Aging Heading 3');
define('CD_02_22_DESC', 'This is the heading used on reports to show account aging for due date number 3.');
define('CD_02_23_TITLE','Account Aging Heading 4');
define('CD_02_23_DESC', 'This is the heading used on reports to show account aging for due date number 4.');
define('CD_02_24_TITLE','Calculate Finance Charge');
define('CD_02_24_DESC', 'Determines whether or not to calculate finance charges on past due invoices.');
define('CD_02_30_TITLE','Add Tax to Customer Shipping Charges');
define('CD_02_30_DESC', 'If enabled, shipping charges will be added to the calculation of sales tax. If not enabled, shipping will not be taxed.');
define('CD_02_35_TITLE','Auto Increment Customer ID');
define('CD_02_35_DESC', 'If set to true, this option will automatically assign an ID to new customer/vendor when they are created.');
define('CD_02_40_TITLE','Show popup with customer account status on order screens');
define('CD_02_40_DESC', 'This feature displays a customer status popup on the order screens when a customer is selected from the contact search popup. It displays balances, account aging as well as the active status of the account.');
define('CD_02_50_TITLE','Calculate Customer Sales Tax Before Discount Applied');
define('CD_02_50_DESC', 'If order level discounts are enabled, this switch determines whether the sales tax is calculated before or after the discount is applied to Sales Orders, Sales/Invoices, and Customer Quotes.');
/************************** Group ID 3 (Vendor Defaults) ***********************************************/
define('CD_03_01_TITLE','Default Item Purchase Account');
define('CD_03_01_DESC', 'The default account for all items unless specified in the individual item record.');
define('CD_03_02_TITLE','Default GL Purchase Account');
define('CD_03_02_DESC', 'The default account for all purchases unless specified in the individual vendor record.');
define('CD_03_03_TITLE','Default GL Cash Payments Account');
define('CD_03_03_DESC', 'General ledger account to apply payments to when vendor invoices are paid.');
define('CD_03_04_TITLE','Vendor Default Freight Account (Freight in)');
define('CD_03_04_DESC', 'Default account to record freight charges for shipments from vendors');
define('CD_03_05_TITLE','Discount Purchase Account');
define('CD_03_05_DESC', 'The discount account for purchase paid with early discount payment terms');
define('CD_03_06_TITLE','Default Vendor Deposit Account');
define('CD_03_06_DESC', 'Default cash account to use for vendor deposits.');
define('CD_03_07_TITLE','Default Vendor Deposit Liability Account');
define('CD_03_07_DESC', 'Default Other Current Liabilities account to use for vendor deposits.');
define('CD_03_10_TITLE','Default Vendor Credit Limit');
define('CD_03_10_DESC', 'The default credit limit for the vendor unless over-ridden in the specific vendor account');
define('CD_03_11_TITLE','Vendor Terms');
define('CD_03_11_DESC', 'Default terms for payment');
define('CD_03_12_TITLE','Payment Terms Number of Days');
define('CD_03_12_DESC', 'The number of days the payment is due (only used for due in # of days and due on day settings)');
define('CD_03_13_TITLE','Early Payment Discount Percent');
define('CD_03_13_DESC', 'Discount percent for early payment. Used with Early Payment Numer of Days');
define('CD_03_14_TITLE','Discount Payment Number of Days');
define('CD_03_14_DESC', 'Number of days the early payment discount applies');
define('CD_03_15_TITLE','Payables Aging Start Date');
define('CD_03_15_DESC', 'The start date used for payables aging<br />0= Invoice Date 1= Due Date');
define('CD_03_16_TITLE','Account Aging Day Count 1');
define('CD_03_16_DESC', 'Number of days from the aging start date for the warning number 1');
define('CD_03_17_TITLE','Account Aging Day Count 2');
define('CD_03_17_DESC', 'Number of days from the aging start date for the warning number 2');
define('CD_03_18_TITLE','Account Aging Day Count 3');
define('CD_03_18_DESC', 'Number of days from the aging start date for the warning number 3');
define('CD_03_19_TITLE','Account Aging Heading 1');
define('CD_03_19_DESC', 'The heading used in reports for account aging date 1');
define('CD_03_20_TITLE','Account Aging Heading 2');
define('CD_03_20_DESC', 'The heading used in reports for account aging date 2');
define('CD_03_21_TITLE','Account Aging Heading 3');
define('CD_03_21_DESC', 'The heading used in reports for account aging date 3');
define('CD_03_22_TITLE','Account Aging Heading 4');
define('CD_03_22_DESC', 'The heading used in reports for account aging date 4');
define('CD_03_30_TITLE','Add Tax to Vendor Shipping Charges');
define('CD_03_30_DESC', 'If enabled, shipping charges will be added to the calculation of sales tax. If not enabled, shipping will not be taxed.');
define('CD_03_35_TITLE','Auto Increment Vendor ID');
define('CD_03_35_DESC', 'If set to true, this option will automatically assign an ID to new vendors when they are created.');
define('CD_03_40_TITLE','Show popup with vendor account status on order screens');
define('CD_03_40_DESC', 'This feature displays a vendor status popup on the order screens when a vendor is selected from the contact search popup. It displays balances, account aging as well as the active status of the account.');
define('CD_03_50_TITLE','Calculate Vendor Sales Tax Before Discount Applied');
define('CD_03_50_DESC', 'If order level discounts are enabled, this switch determines whether the sales tax is calculated before or after the discount is applied to Purchase Orders, Purchases, and Vendor Quotes.');
/************************** Group ID 4 (Employee Defaults) ***********************************************/

/************************** Group ID 5 (Inventory Defaults) ***********************************************/
define('CD_05_01_TITLE','Stock Item GL Sales/Income Default Account');
define('CD_05_01_DESC', 'Default general ledger sales/income account for inventory of type: Stock Items');
define('CD_05_02_TITLE','Stock Item GL Inventory Default Account');
define('CD_05_02_DESC', 'Default general ledger inventory account for inventory of type: Stock Items');
define('CD_05_03_TITLE','Stock Item GL Cost of Sales Default Account');
define('CD_05_03_DESC', 'Default general ledger cost of sales account for inventory of type: Stock Items');
define('CD_05_04_TITLE','Stock Item GL Costing Method Default');
define('CD_05_04_DESC', 'Default costing method for inventory of type: Stock Items<br />f - FIFO, l - LIFO, a - Average');
define('CD_05_05_TITLE','Master Stock Item GL Sales/Income Default Account');
define('CD_05_05_DESC', 'Default general ledger sales/income account for inventory of type: Master Stock Items');
define('CD_05_06_TITLE','Master Stock Item GL Inventory Default Account');
define('CD_05_06_DESC', 'Default general ledger inventory account for inventory of type: Master Stock Items');
define('CD_05_07_TITLE','Master Stock Item GL Cost of Sales Default Account');
define('CD_05_07_DESC', 'Default general ledger cost of sales account for inventory of type: Master Stock Items');
define('CD_05_08_TITLE','Master Stock Item GL Costing Method Default');
define('CD_05_08_DESC', 'Default costing method for inventory of type: Master Stock Items<br />f - FIFO, l - LIFO, a - Average');
define('CD_05_11_TITLE','Assembly Item GL Sales/Income Default Account');
define('CD_05_11_DESC', 'Default general ledger sales/income account for inventory of type: Assembly Items');
define('CD_05_12_TITLE','Assembly Item GL Inventory Default Account');
define('CD_05_12_DESC', 'Default general ledger inventory account for inventory of type: Assembly Items');
define('CD_05_13_TITLE','Assembly Item GL Cost of Sales Default Account');
define('CD_05_13_DESC', 'Default general ledger cost of sales account for inventory of type: Assmebly Items');
define('CD_05_14_TITLE','Assembly Item GL Costing Method Default');
define('CD_05_14_DESC', 'Default costing method for inventory of type: Assembly Items<br />f - FIFO, l - LIFO, a - Average');
define('CD_05_16_TITLE','Serialized Item GL Sales/Income Default Account');
define('CD_05_16_DESC', 'Default general ledger sales/income account for inventory of type: Serialized Items');
define('CD_05_17_TITLE','Serialized Item GL Inventory Default Account');
define('CD_05_17_DESC', 'Default general ledger inventory account for inventory of type: Serialized Items');
define('CD_05_18_TITLE','Serialized Item GL Cost of Sales Default Account');
define('CD_05_18_DESC', 'Default general ledger cost of sales account for inventory of type: Serialized Items');
define('CD_05_19_TITLE','Serialized Item GL Costing Method Default');
define('CD_05_19_DESC', 'Default costing method for inventory of type: Serialized Items<br />f - FIFO, l - LIFO, a - Average');
define('CD_05_21_TITLE','Non-Stock Item GL Sales/Income Default Account');
define('CD_05_21_DESC', 'Default general ledger sales/income account for inventory of type: Non-Stock Items');
define('CD_05_22_TITLE','Non-Stock Item GL Inventory Default Account');
define('CD_05_22_DESC', 'Default general ledger inventory account for inventory of type: Non-Stock Items');
define('CD_05_23_TITLE','Non-Stock Item GL Cost of Sales Default Account');
define('CD_05_23_DESC', 'Default general ledger cost of sales account for inventory of type: Non-Stock Items');
define('CD_05_31_TITLE','Service Item GL Sales/Income Default Account');
define('CD_05_31_DESC', 'Default general ledger sales/income account for inventory of type: Service Items');
define('CD_05_32_TITLE','Service Item GL Inventory Default Account');
define('CD_05_32_DESC', 'Default general ledger inventory account for inventory of type: Service Items');
define('CD_05_33_TITLE','Service Item GL Cost of Sales Default Account');
define('CD_05_33_DESC', 'Default general ledger cost of sales account for inventory of type: Service Items');
define('CD_05_36_TITLE','Labor Item GL Sales/Income Default Account');
define('CD_05_36_DESC', 'Default general ledger sales/income account for inventory of type: Labor Items');
define('CD_05_37_TITLE','Labor Item GL Inventory Default Account');
define('CD_05_37_DESC', 'Default general ledger inventory account for inventory of type: Labor Items');
define('CD_05_38_TITLE','Labor Item GL Cost of Sales Default Account');
define('CD_05_38_DESC', 'Default general ledger cost of sales account for inventory of type: Labor Items');
define('CD_05_41_TITLE','Activity Item GL Sales/Income Default Account');
define('CD_05_41_DESC', 'Default general ledger sales/income account for inventory of type: Activity Items');
define('CD_05_42_TITLE','Charge Item GL Sales/Income Default Account');
define('CD_05_42_DESC', 'Default general ledger sales/income account for inventory of type: Charge Items');
define('CD_05_50_TITLE','Default Sales Tax Rate For New Inventory Items');
define('CD_05_50_DESC', 'Determines the default sales tax rate to use when adding inventory items.<br /><br />NOTE: This value is applied to inventory Auto-Add but can be changed in the Inventory => Maintain screen. The tax rates are selected from the table tax_rates and must be setup through Setup => Sales tax Rates.');
define('CD_05_52_TITLE','Default Purchase Tax Rate For New Inventory Items');
define('CD_05_52_DESC', 'Determines the default purchase tax rate to use when adding inventory items.<br /><br />NOTE: This value is applied to inventory Auto-Add but can be changed in the Inventory => Maintain screen. The tax rates are selected from the table tax_rates and must be setup through Setup => Purchase tax Rates.');
define('CD_05_55_TITLE','Enable Automatic Creation of Inventory Items');
define('CD_05_55_DESC', 'Allows the automatic creation of inventory items in the order screens.<br /><br />SKUs are not required in PhreeBooks for non-trackable inventory types. This feature allows for the automatic creation of SKUs in the inventory database table. The inventory type used will be stock items. The GL accounts used will be the default accounts and costing method for stock items.');
define('CD_05_60_TITLE','AutoFill Inventory Pull Down When Entering SKUs on Order Screens');
define('CD_05_60_DESC', 'Allows an ajax call to fill in possible choices as data is entered into the SKU field. his feature is helpful when the SKUs are known and expedites filling in order forms. May slow down SKU entries when bar code scanners are used.');
define('CD_05_65_TITLE','Enable auto search of SKU matches on order screen');
define('CD_05_65_DESC', 'When enabled, PhreeBooks looks for a SKU length in the order form equal to the Bar Code Length value and when the length is reached, attempts to match with an inventory item. This allow fast entry of items when using bar code readers.');
define('CD_05_70_TITLE','Length of SKU for Bar code readers in order screens');
define('CD_05_70_DESC', 'Sets the number of characters to expect when reading inventory bar code values. PhreeBooks only searches when the number of characters has been reached. Typical values are 12 and 13 characters.');
define('CD_05_75_TITLE','Enable automatic update of item cost in inventory for PO/ Purchases');
define('CD_05_75_DESC', 'When enabled, PhreeBooks will update the item cost in the inventory table with either the PO price or Purchase/Receive price. Usefule for on the fly PO/Purchases and updating prices from the order screen without having to update the inventory tables first.');
/************************** Group ID 6 (Special Cases (Payment, Shippping, Price Sheets) **************/
// 
// This group is from add-on modules which will not have a language translation here.
// They should be included with the module.
// 
/************************** Group ID 7 (User Account Defaults) ***********************************************/
define('CD_07_17_TITLE','Password');
define('CD_07_17_DESC', 'Minimum length of password');
/************************** Group ID 8 (General Settings) ***********************************************/
define('CD_08_01_TITLE','Maximum search results per page');
define('CD_08_01_DESC', 'Maximum number of search results returned per page');
define('CD_08_03_TITLE','Auto check for program updates');
define('CD_08_03_DESC', 'Automatically check for program updates at login to PhreeBooks.');
define('CD_08_05_TITLE','Hide Success Messages');
define('CD_08_05_DESC', 'Hides messages on successful operations.<br />Only caution and error messages will be displayed.');
define('CD_08_07_TITLE','Auto Update Currency');
define('CD_08_07_DESC', 'Updates the exchange rate for loaded currencies at every login.<br />If disabled, currencies may be manually updated in the Setup => Currencies menu.');
define('CD_08_10_TITLE','Limit Customer/Vendor History Results');
define('CD_08_10_DESC', 'Limits the length of history values shown in customer/vendor accounts for sales/purchases.');
define('CD_08_15_TITLE','Default Application to Generate PDF Reports and Forms');
define('CD_08_15_DESC', 'Sets the default third party application to use for generating reoports and forms. FPDF is more stable and produces more reliable results but cannot handle UTF-8 fonts or barcodes. TCPDF is more robust but is still undergoing development pains and may require additional updates to stay with the current version.');
/************************** Group ID 9 (Import/Export Settings) ***********************************************/
define('CD_09_01_TITLE','Report/Form Export Preference');
define('CD_09_01_DESC', 'Specifies the export preference when exporting reports and forms. Local will save them in the /my_files/reports directory of the webserver for use with all companies. Download will download the file to your browser to save/print on your local machine.');
/************************** Group ID 10 (Shipping Defaults) ***********************************************/
define('CD_10_01_TITLE','Default weight unit of measure');
define('CD_10_01_DESC', 'Sets the default unit of measure for all packages. Valid values are:<br />LBS - Pounds<br />KGS - Kilograms');
define('CD_10_02_TITLE','Default currency to use for shipping options');
define('CD_10_02_DESC', 'Valid values are<br />USD - US Dollars<br />EUR - Euros');
define('CD_10_03_TITLE','Default package dimension unit of measure');
define('CD_10_03_DESC', 'Package unit of measure. Valid values are:<br />IN - Inches<br />CM - Centimeters');
define('CD_10_04_TITLE','Pre-selects the Residential address checkbox');
define('CD_10_04_DESC', '0 - Sets the default residential ship box to unchecked (commercial address)<br />1 - Sets the default residential ship box to checked (residential address)');
define('CD_10_05_TITLE','Specifies the default package type');
define('CD_10_05_DESC', 'Specify the default package type to use for shipping.');
define('CD_10_06_TITLE','Default package pickup service');
define('CD_10_06_DESC', 'Specify the default type of pickup service for your package service.');
define('CD_10_07_TITLE','Pre-sets the default package length');
define('CD_10_07_DESC', 'Enter the default package length to use for a standard shipment.');
define('CD_10_08_TITLE','Pre-sets the default package width');
define('CD_10_08_DESC', 'Enter the default package width to use for a standard shipment.');
define('CD_10_09_TITLE','Pre-sets the default package height');
define('CD_10_09_DESC', 'Enter the default package height to use for a standard shipment.');
define('CD_10_10_TITLE','Show the additional handling charge checkbox');
define('CD_10_10_DESC', 'Show the additional handling charge checkbox');
define('CD_10_12_TITLE','Pre-select the additional handling checkbox');
define('CD_10_12_DESC', 'Pre-select the additional handling checkbox');
define('CD_10_14_TITLE','Show insurance selection option');
define('CD_10_14_DESC', 'Shows the insurance selection option.');
define('CD_10_16_TITLE','Pre-select the insurance option');
define('CD_10_16_DESC', 'Pre-selects the insurance option check box as the default setting.');
define('CD_10_18_TITLE','Default package insurance value');
define('CD_10_18_DESC', 'Specifies the default monetary value (based onthe currency used) to add for insurance. This value will be typically over-ridden by the calling application with the sales/purchase value when the shipping estimator is invoked.');
define('CD_10_20_TITLE','Show split large shipments checkbox');
define('CD_10_20_DESC', 'Show the checkbox to allow heavy shipments to be broken down for small package service.');
define('CD_10_22_TITLE','Pre-selects the split large shipment checkbox');
define('CD_10_22_DESC', 'Pre-select the split shipment box. This feature will break large weight shipments into smaller (user-selectable weight) pieces to ship via small package carrier, i.e. UPS, FedEx, DHL, etc.');
define('CD_10_24_TITLE','Split large shipment weight value');
define('CD_10_24_DESC', 'Default weight to use when splitting large shipments for small package carriers.');
define('CD_10_26_TITLE','Show Delivery Confirmation Checkbox');
define('CD_10_26_DESC', 'Show the delivery confirmation checkbox');
define('CD_10_28_TITLE','Pre-select the delivery confirmation check box.');
define('CD_10_28_DESC', 'Pre-selects the delivery confirmation check box. Valid values are:<br />0 - Un-checked<br />1 - Checked');
define('CD_10_30_TITLE','Type of delivery confirmation requested.');
define('CD_10_30_DESC', 'Specifies the default value for the type of delivery confirmation requested');
define('CD_10_32_TITLE','Show the handling charge checkbox');
define('CD_10_32_DESC', 'Show the handling charge checkbox.');
define('CD_10_34_TITLE','Pre-selects checkbox for shipment handling charges');
define('CD_10_34_DESC', 'Pre-selects the handling charge option on shipping.');
define('CD_10_36_TITLE','Default shipment handling charge value');
define('CD_10_36_DESC', 'Sets the default handling charge for a shipment based on the currency unit of measure ');
define('CD_10_38_TITLE','Show shipping COD options');
define('CD_10_38_DESC', 'Enable the COD checkbox and options');
define('CD_10_40_TITLE','Pre-select the COD checkbox');
define('CD_10_40_DESC', 'Pre-select the COD checkbox');
define('CD_10_42_TITLE','Default payment type');
define('CD_10_42_DESC', 'Select the type of payment to accept as the default');
define('CD_10_44_TITLE','Show Saturday pickup checkbox');
define('CD_10_44_DESC', 'Show the checkbox for Saturday pickup');
define('CD_10_46_TITLE','Pre-select the Saturday pickup checkbox');
define('CD_10_46_DESC', 'Pre-select the Saturday pickup checkbox');
define('CD_10_48_TITLE','Show Saturday delivery checkbox');
define('CD_10_48_DESC', 'Show Saturday delivery checkbox');
define('CD_10_50_TITLE','Pre-select the Saturday delivery checkbox');
define('CD_10_50_DESC', 'Pre-select the Saturday delivery checkbox');
define('CD_10_52_TITLE','Show Hazardous Material checkbox');
define('CD_10_52_DESC', 'Show Hazardous Material checkbox');
define('CD_10_54_TITLE','Pre-select the hazardous material checkbox');
define('CD_10_54_DESC', 'Pre-select the hazardous material checkbox');
define('CD_10_56_TITLE','Show dry ice checkbox');
define('CD_10_56_DESC', 'Show dry ice checkbox');
define('CD_10_58_TITLE','Pre-select the dry ice checkbox');
define('CD_10_58_DESC', 'Pre-select the dry ice checkbox');
define('CD_10_60_TITLE','Show return services checkbox');
define('CD_10_60_DESC', 'Show return services checkbox');
define('CD_10_62_TITLE','Pre-selects the return services checkbox');
define('CD_10_62_DESC', 'Pre-selects the return services checkbox');
define('CD_10_64_TITLE','Default selection for return services (call tags)');
define('CD_10_64_DESC', 'Select the default to use if the return services checkbos is selected.');
/************************** Group ID 11 (Address Book Defaults) ***********************************************/
define('CD_11_02_TITLE','Account Contact Field Required');
define('CD_11_02_DESC', 'Whether or not to require contact field to be entered in accounts setup (vendors, customers, employees)');
define('CD_11_03_TITLE','Account Address1 Field Required');
define('CD_11_03_DESC', 'Whether or not to require address 1 field to be entered in accounts setup (vendors, customers, employees)');
define('CD_11_04_TITLE','Account Address2 Field Required');
define('CD_11_04_DESC', 'Whether or not to require address 2 field to be entered in accounts setup (vendors, customers, employees)');
define('CD_11_05_TITLE','Account City/Town Field Required');
define('CD_11_05_DESC', 'Whether or not to require the city/town field to be entered in accounts setup (vendors, customers, employees)');
define('CD_11_06_TITLE','Account State/Province Field Required');
define('CD_11_06_DESC', 'Whether or not to require the state/province field to be entered in accounts setup (vendors, customers, employees)');
define('CD_11_07_TITLE','Account Postal Code Field Required');
define('CD_11_07_DESC', 'Whether or not to require the postal code field to be entered in accounts setup (vendors, customers, employees)');
define('CD_11_08_TITLE','Account Telephone 1 Field Required');
define('CD_11_08_DESC', 'Whether or not to require the telephone 1 field to be entered in accounts setup (vendors, customers, employees)');
define('CD_11_09_TITLE','Account Email Address Field Required');
define('CD_11_09_DESC', 'Whether or not to require the email field to be entered in accounts setup (vendors, customers, employees)');
define('CD_11_10_TITLE','Shipping Address1 Field Required');
define('CD_11_10_DESC', 'Whether or not to require address 1 field to be entered in shipping fields.');
define('CD_11_11_TITLE','Shipping Address2 Field Required');
define('CD_11_11_DESC', 'Whether or not to require address 2 field to be entered in shipping fields.');
define('CD_11_12_TITLE','Shipping Contact Field Required');
define('CD_11_12_DESC', 'Whether or not to require the contact field to be entered in shipping fields.');
define('CD_11_13_TITLE','Shipping City/Town Field Required');
define('CD_11_13_DESC', 'Whether or not to require the city/town field to be entered in shipping fields.');
define('CD_11_14_TITLE','Shipping State/Province Field Required');
define('CD_11_14_DESC', 'Whether or not to require the state/province field to be entered in shipping fields.');
define('CD_11_15_TITLE','Shipping Postal Code Field Required');
define('CD_11_15_DESC', 'Whether or not to require the postal code field to be entered in shipping fields.');
/************************** Group ID 12 (E-mail Settings) ***********************************************/
define('CD_12_01_TITLE','E-Mail Transport Method');
define('CD_12_01_DESC', 'Defines the method for sending mail.<br /><strong>PHP</strong> is the default, and uses built-in PHP wrappers for processing.<br />Servers running on Windows and MacOS should change this setting to <strong>SMTP</strong>.<br /><br /><strong>SMTPAUTH</strong> should only be used if your server requires SMTP authorization to send messages. You must also configure your SMTPAUTH settings in the appropriate fields in this admin section.<br /><br /><strong>sendmail</strong> is for linux/unix hosts using the sendmail program on the server<br /><strong>"sendmail -f"</strong> is only for servers which require the use of the -f parameter to send mail. This is a security setting often used to prevent spoofing. Will cause errors if your host mailserver is not configured to use it.<br /><br /><strong>Qmail</strong> is used for linux/unix hosts running Qmail as sendmail wrapper at /var/qmail/bin/sendmail.');
define('CD_12_02_TITLE','E-Mail Linefeeds');
define('CD_12_02_DESC', 'Defines the character sequence used to separate mail headers.');
define('CD_12_03_TITLE','Send E-Mails');
define('CD_12_03_DESC', 'Send out e-mails');
define('CD_12_04_TITLE','Use MIME HTML When Sending Emails');
define('CD_12_04_DESC', 'Send e-mails in HTML format');
define('CD_12_05_TITLE','Verify E-Mail Addresses Through DNS');
define('CD_12_05_DESC', 'Verify e-mail address through a DNS server');
define('CD_12_06_TITLE','Email Archiving Active?');
define('CD_12_06_DESC', 'If you wish to have email messages archived/stored when sent, set this to "true".');
define('CD_12_07_TITLE','E-Mail Friendly-Errors');
define('CD_12_07_DESC', 'Do you want to display friendly errors if emails fail?  Setting this to false will display PHP errors and likely cause the script to fail. Only set to false while troubleshooting, and true for a live shop.');
define('CD_12_10_TITLE','Email Address (Displayed to Contact you)');
define('CD_12_10_DESC', 'Email address of Store Owner.  Used as "display only" when informing customers of how to contact you.');
define('CD_12_11_TITLE','Email Address (sent FROM)');
define('CD_12_11_DESC', 'Address from which email messages will be "sent" by default. Can be over-ridden at compose-time in admin modules.');
define('CD_12_12_TITLE','Emails must send from known domain?');
define('CD_12_12_DESC', 'Does your mailserver require that all outgoing emails have their "from" address match a known domain that exists on your webserver?<br /><br />This is often set in order to prevent spoofing and spam broadcasts.  If set to Yes, this will cause the email address (sent FROM) to be used as the "from" address on all outgoing mail.');
define('CD_12_15_TITLE','Email Admin Format?');
define('CD_12_15_DESC', 'Please select the Admin extra email format');
define('CD_12_40_TITLE','Set "Contact Us" Email Dropdown List');
define('CD_12_40_DESC', 'On the "Contact Us" Page, set the list of email addresses , in this format: Name 1 &lt;email@address1&gt;, Name 2 &lt;email@address2&gt;');
define('CD_12_50_TITLE','Contact Us - Show Store Name and Address');
define('CD_12_50_DESC', 'Include Store Name and Address<br />0= off 1= on');
define('CD_12_70_TITLE','SMTP Email Account Mailbox');
define('CD_12_70_DESC', 'Enter the mailbox account name (me@mydomain.com) supplied by your host. This is the account name that your host requires for SMTP authentication.<br />Only required if using SMTP Authentication for email.');
define('CD_12_71_TITLE','SMTP Email Account Password');
define('CD_12_71_DESC', 'Enter the password for your SMTP mailbox. <br />Only required if using SMTP Authentication for email.');
define('CD_12_72_TITLE','SMTP Email Mail Host');
define('CD_12_72_DESC', 'Enter the DNS name of your SMTP mail server.<br />ie: mail.mydomain.com<br />or 55.66.77.88<br />Only required if using SMTP Authentication for email.');
define('CD_12_73_TITLE','SMTP Email Mail Server Port');
define('CD_12_73_DESC', 'Enter the IP port number that your SMTP mailserver operates on.<br />Only required if using SMTP Authentication for email.');
define('CD_12_74_TITLE','Convert currencies for Text emails');
define('CD_12_74_DESC', 'What currency conversions do you need for Text emails?<br />Default = &amp;pound;,£:&amp;euro;,€');
/************************** Group ID 13 (General Ledger Settings) ***********************************************/
define('CD_13_01_TITLE','Auto-change Accounting Period');
define('CD_13_01_DESC', 'Automatically changes the current accounting period based on the server date and current fiscal calendar. If not enabled, the current accounting period must be manually changed in the General Ledger => Utilities menu.');
define('CD_13_05_TITLE','Show Full GL Account Names');
define('CD_13_05_DESC', 'Determines how to display the general ledger accounts in pull-down menus.<br />Number - GL Account Number Only.<br />Description - GL Account Description Only.<br />Both - Both gl number and name will be displayed.');
/************************** Group ID 15 (Sessions Settings) ***********************************************/
define('CD_15_01_TITLE','Session Time Out in Seconds');
define('CD_15_01_DESC', 'Enter the time in seconds. Default=3600<br />Example: 3600= 1 hour<br /><br />Note: Too few seconds can result in timeout issues when adding/editing products.');
define('CD_15_05_TITLE','Auto-renew session to avoid timeouts between page reloads');
define('CD_15_05_DESC', 'When enabled, this option will use ajax to refresh the session timer every 5 minnutes preventing the session from expiring and logging out the user. This feature helps prevent dropped posts when PhreeBooks has been inactive and a post results in a login screen.');
/************************** Group ID 17 (Credit Card Settings) ***********************************************/
define('CD_17_01_TITLE','Credit Card Owner Name Minimum Length');
define('CD_17_01_DESC', 'Enter the minimum length of the credit card owners name.');
define('CD_17_02_TITLE','Credit Card Number Minimum Length');
define('CD_17_02_DESC', 'Enter the minimum length of the credit card number.');
define('CD_17_03_TITLE','Enable Visa Credit Cards');
define('CD_17_03_DESC', 'Enable Visa Credit Cards.');
define('CD_17_04_TITLE','Enable Master Card Credit Cards');
define('CD_17_04_DESC', 'Enable Master Card Credit Cards.');
define('CD_17_05_TITLE','Enable American Express Credit Cards');
define('CD_17_05_DESC', 'Enable American Express Credit Cards.');
define('CD_17_06_TITLE','Enable Discover Credit Cards');
define('CD_17_06_DESC', 'Enable Discover Credit Cards.');
define('CD_17_07_TITLE','Enable Diners Club Credit Cards');
define('CD_17_07_DESC', 'Enable Diners Club Credit Cards.');
define('CD_17_08_TITLE','Enable JCB Credit Cards');
define('CD_17_08_DESC', 'Enable JCB Credit Cards.');
define('CD_17_09_TITLE','Enable Australian Bankcard');
define('CD_17_09_DESC', 'Enable Australian Bankcard.');
/************************** Group ID 19 (Layout Settings) ***********************************************/

/************************** Group ID 20 (Website Maintenence) ***********************************************/
define('CD_20_99_TITLE','Enable Debug Trace File Generation');
define('CD_20_99_DESC', 'Enable trace generation for debug purposes.<br />If Yes is selected, an additional menu will be added to the Tools menu to download the trace information to help debug posting problems.');
/************************** Group ID 99 (Alternate (non-displayed Settings) *********************************/
// 
// This group is from add-on modules which will not have a language translation here.
// They should be included with the module.
// 

?>