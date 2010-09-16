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
//  Path: /modules/gen_ledger/language/en_us/language.php
//

// ******************* Release 2.0 Additions ******************/
define('GENERAL_JOURNAL_18_C_DESC','Customer Receipts Entry');
define('GENERAL_JOURNAL_18_V_DESC','Vendor Receipts Entry');
define('GENERAL_JOURNAL_20_V_DESC','Vendor Payment Entry');
define('GENERAL_JOURNAL_20_C_DESC','Customer Payment Entry');
define('GL_BUDGET_HEADING_TITLE','Budget Manager');
define('GL_BUDGET_INTRO_TEXT','This tool sets the budgets for general ledger accounts.<br />NOTE: The Save icon must be pressed after data entry before the account or fiscal year is changed!');
define('GL_COPY_ACTUAL_CONFIRM','Are you sure you want to replace the budget amounts in all general ledger accounts for the selected fiscal year with actuals from the prior fiscal year? This operation cannot be undone!');
define('GL_BUDGET_COPY_HINT','Copy Actuals From Prior FY');
define('GL_CLEAR_ACTUAL_CONFIRM','Are you sure you want to clear the budget amounts in all general ledger accounts for the selected fiscal year? This operation cannot be undone!');
define('TEXT_BUDGET_CLEAR_HINT','Clear All Budgets For This FY');
define('TEXT_LOAD_ACCT_PRIOR','Load Actuals From Prior FY');
define('ERROR_NO_GL_ACCT_INFO','There is no data for the prior fiscal year selected!');
define('TEXT_PERIOD_DATES','Period / Dates');
define('TEXT_PRIOR_FY','Prior FY');
define('TEXT_BUDGET','Budget');
define('TEXT_NEXT_FY','Next FY');
define('GL_TEXT_COPY_PRIOR','Copy Prior Budget to Current Budget');
define('GL_TEXT_ALLOCATE','Allocate Total Through Fiscal Year');
define('GL_TEXT_COPY_NEXT','Copy Next Budget to Current Budget');
define('GL_JS_CANNOT_COPY','This record cannot be copied since it has not been saved yet!');
define('GL_JS_COPY_CONFIRM','You have chosen to copy this journal record. This will create a copy of the current record with the modified fields. NOTE: The reference must be different or this operation will fail posting. Press OK to continue or Cancel to return to the form.');

// ************************************************************/
// General
define('TEXT_SELECT_FILE','File to import: ');

// Titles and headings
define('GL_ENTRY_TITLE','General Journal Entry');
define('GL_HEADING_BEGINNING_BALANCES','Chart of Accounts - Beginning Balances');
define('GL_HEADING_IMPORT_BEG_BALANCES','Import Beginning Balances');

// Audit Log Messages
define('GL_LOG_ADD_JOURNAL','General Journal Entry - ');
define('GL_LOG_FY_UPDATE','General Journal Fiscal Year - ');
define('GL_LOG_PURGE_DB','General Journal - Purge Database');

// Special buttons
define('GL_BTN_PURGE_DB','Purge Journal Entries');
define('GL_BTN_BEG_BAL','Enter Beginning Balances');
define('GL_BTN_IMP_BEG_BALANCES','Import Inventory, Accounts Payable, Accounts Receivable Beginning Balances');
define('GL_BTN_CHG_ACCT_PERIOD', 'Change Current Accounting Period');
define('GL_BTN_NEW_FY', 'Generate Next Fiscal Year');
define('GL_BTN_UPDATE_FY', 'Update Fiscal Year Changes');
define('GL_BB_IMPORT_INVENTORY','Import Inventory');
define('GL_BB_IMPORT_PAYABLES','Import Accounts Payable');
define('GL_BB_IMPORT_RECEIVABLES','Import Accounts Receivable');
define('GL_BB_IMPORT_SALES_ORDERS','Import Sales Orders');
define('GL_BB_IMPORT_PURCH_ORDERS','Import Purchase Orders');
define('GL_BB_IMPORT_HELP_MSG','Refer to the help file for format requirements.');

// GL Utilities
define('GL_UTIL_HEADING_TITLE', 'General Journal Maintenance, Setup and Utilities');
define('GL_UTIL_PERIOD_LEGEND','Accounting Periods and Fiscal Years');
define('GL_UTIL_BEG_BAL_LEGEND','General Journal Beginning Balances');
define('GL_UTIL_PURGE_ALL','Purge all Journal Transactions (re-start)');
define('GL_FISCAL_YEAR','Fiscal Year');
define('GL_UTIL_FISCAL_YEAR_TEXT','Fiscal period calendar dates can be modified here. Please note that fiscal year dates cannot be changed for any period up to and including the last general journal entry in the system.');
define('GL_UTIL_BEG_BAL_TEXT','For initial set-ups and transfers from another accounting system.');
define('GL_UTIL_PURGE_DB','Delete all Journal Entries (type \'purge\' in the text box and press purge button)<br />');
define('GL_UTIL_PURGE_DB_CONFIRM','Are you sure you want to clear all journal entries?');
define('GL_UTIL_PURGE_CONFIRM','Deleted all journal records and cleaned up databases.');
define('GL_UTIL_PURGE_FAIL','No journal entries were affected!');
define('GL_CURRENT_PERIOD','Current Accounting Period is: ');
define('GL_WARN_ADD_FISCAL_YEAR','Are you sure you want to add fiscal year: ');
define('GL_ERROR_FISCAL_YEAR_SEQ','The last period of the modified fiscal year does not align with the start date of the next fiscal year. The start date of the next fiscal year has been modified and should be reviewed.');
define('GL_WARN_CHANGE_ACCT_PERIOD','Enter the accounting period to make current:');
define('GL_ERROR_BAD_ACCT_PERIOD','The accounting period selected has not been setup. Either re-enter the period or add a fiscal year to continue.');
define('GL_ERROR_NO_BALANCE','Cannot update beginning balances because debits and credits do not match!');
define('GL_ERROR_UPDATE_COA_HISTORY','Error updating Chart of Accounts History after setting beginning balances!');
define('GL_BEG_BAL_ERROR_0',' found on line ');
define('GL_BEG_BAL_ERROR_1','Invalid chart of account id found on line ');
define('GL_BEG_BAL_ERROR_2A','No invoice number found on line ');
define('GL_BEG_BAL_ERROR_2B','. Flagged as waiting for payment!');
define('GL_BEG_BAL_ERROR_3','Exiting import. No invoice number found on line ');
define('GL_BEG_BAL_ERROR_4A','Exiting script. Bad date format found on line ');
define('GL_BEG_BAL_ERROR_4B','. Expecting format ');
define('GL_BEG_BAL_ERROR_5','Skipping line. Zero total amount found on line ');
define('GL_BEG_BAL_ERROR_6','Invalid chart of account id found on line ');
define('GL_BEG_BAL_ERROR_7','Skipping inventory item. Zero quantity found on line ');
define('GL_BEG_BAL_ERROR_8A','Failed updating sku # ');
define('GL_BEG_BAL_ERROR_8B',', the process was terminated.');
define('GL_BEG_BAL_ERROR_9A','Failed updating account # ');

// GL popup
define('TEXT_DISPLAY_NUMBER_OF_ACCTS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> GL accounts)');

// General Ledger Translations
define('GL_ERROR_JOURNAL_BAD_ACCT','General Ledger account number cannot be found!');
define('GL_ERROR_OUT_OF_BALANCE','The entry cannot be posted because the debits and credits do not balance!');
define('GL_ERROR_BAD_ACCOUNT','One or more of the GL account numbers are invalid. Please correct and re-submit.');
define('GL_ERROR_NO_REFERENCE','For recurring transactions, a starting reference number needs to be entered. PhreeBooks will increment it for each recurring entry.');
define('GL_ERROR_RECUR_ROLL_REQD','This is a recurring entry. Do you want to update future entries as well? (Press Cancel to update only this entry)');
define('GL_ERROR_RECUR_DEL_ROLL_REQD','This is a recurring entry. Do you want to delete future entries as well? (Press Cancel to delete only this entry)');
define('GL_ERROR_NO_ITEMS','There were no items posted, In order for an item to be registered, the quantity must be non-blank.');
define('GL_ERROR_NO_POST','There were errors during processing, the record was not posted.');
define('GL_ERROR_NO_DELETE','There were errors during processing, the record was not deleted.');
define('GL_ERROR_CANNOT_FIND_NEXT_ID','Could not read the next order/invoice number from table: ' . TABLE_CURRENT_STATUS);
define('GL_ERROR_CANNOT_DELETE_MAIN','Failed deleting the journal main record # ');
define('GL_ERROR_CANNOT_DELETE_ITEM','Failed deleting the journal item record # %d. No rows were found!');
define('GL_ERROR_NEVER_POSTED','Cannot delete this entry because it was never posted.');
define('GL_DELETE_GL_ROW','Are you sure you want to delete this journal row?');
define('GL_DELETE_ALERT','Are you sure you want to delete this journal entry?');
define('GL_ERROR_DIED_CREATING_RECORD','Died trying to build a journal entry with id = ');
define('GL_ERROR_POSTING_CHART_BALANCES','Error posting chart of account balances to account id: ');
define('GL_ERROR_OUT_OF_BALANCE_A','Trial balance is out of balance. Debits: ');
define('GL_ERROR_OUT_OF_BALANCE_B',' and credits: ');
define('GL_ERROR_OUT_OF_BALANCE_C',' in period ');
define('GL_ERROR_NO_GL_ACCT_NUMBER','No account number provided in /gen_ledger.php function: ');
define('GL_ERROR_UPDATING_ACCOUNT_HISTORY','Error updating customer/vendor account history.');
define('GL_ERROR_DELETING_ACCOUNT_HISTORY','Error deleting customer/vendor account history record');
define('GL_ERROR_UPDATING_INVENTORY_STATUS','Updating inventory status requires the sku to be in the database. The failing SKU was: ');
define('GL_ERROR_CALCULATING_COGS','Calculating the cost of goods sold requires the sku to be in the database, the operation failed.');
define('GL_ERROR_POSTING_INV_HISTORY','Error posting inventory history.');
define('GL_ERROR_UNPOSTING_COGS','Error rolling back the cost of goods sold. SKU: ');
define('GL_ERROR_BAD_SKU_ENTERED','The sku entered could not be found. No action was taken.');
define('GL_ERROR_SKU_NOT_ASSY','Cannot assemble an inventory item that has no components. SKU: ');
define('GL_ERROR_NOT_ENOUGH_PARTS','Not enough parts to build the requested number of assemblies. SKU: ');
define('GL_ERROR_POSTING_NEG_INVENTORY','Error posting cost of good sold for a vendor credit, inventory will go negative and cogs cannot be calculated. Affected SKU is: ');
define('GL_ERROR_SERIALIZE_QUANTITY','Error calculating COGS for a serialized item, the quantity was not equal to 1 per line item submitted.');
define('GL_ERROR_SERIALIZE_EMPTY','Error calculating COGS for a serialized item, the serial number entered was blank.');
define('GL_ERROR_SERIALIZE_COGS','COGS Error. Either did not find serial number or more than one item with matching serial numbers were found.');
define('GL_ERROR_NO_RETAINED_EARNINGS_ACCOUNT','Zero or more than one retained earnings accounts found. There needs to be one and only one retained earnings account in PhreeBooks to operate properly!');

define('GL_DISPLAY_NUMBER_OF_ENTRIES', TEXT_DISPLAY_NUMBER . ' GL Entries');
define('GL_TOTALS','Totals:');
define('GL_OUT_OF_BALANCE','Out of Balance:');
define('GL_ACCOUNT_INCREASED','Account will be increased');
define('GL_ACCOUNT_DECREASED','Account will be decreased');

define('GL_JOURNAL_ENTRY_COGS','Cost of Goods Sold');

// Journal Entries
define('GENERAL_JOURNAL_0_DESC','Import Inventory Beginning Balances Entry');
define('GL_MSG_IMPORT_0_SUCCESS','Successfully imported Inventory beginning balances. The number of records imported was: ');
define('GL_MSG_IMPORT_0','Imported Inventory Beginning Balances');

define('GENERAL_JOURNAL_2_DESC','General Journal Entry');
define('GENERAL_JOURNAL_2_ERROR_2','GL - The general journal Reference number you entered is a duplicate, please enter a new reference number!');

define('GENERAL_JOURNAL_3_DESC','Purchase Quote Entry');
define('GENERAL_JOURNAL_3_ERROR_2','PQ - The purchase quote number you entered is a duplicate, please enter a new purchase quote number!');
define('GENERAL_JOURNAL_3_ERROR_5','PQ - Failed incrementing the purchase quote number!');
define('GENERAL_JOURNAL_3_LEDGER_DISCOUNT','Purchase Quote Discount Amount');
define('GENERAL_JOURNAL_3_LEDGER_FREIGHT','Purchase Quote Freight Amount');
define('GENERAL_JOURNAL_3_LEDGER_HEADING','Purchase Quote Total');

define('GENERAL_JOURNAL_4_DESC','Purchase Order Entry');
define('GENERAL_JOURNAL_4_ERROR_2','PO - The purchase order number you entered is a duplicate, please enter a new purchase order number!');
define('GENERAL_JOURNAL_4_ERROR_5','PO - Failed incrementing the purchase order number!');
define('GENERAL_JOURNAL_4_ERROR_6','PO - A purchase order cannot be deleted if there are items that have been received!');
define('GENERAL_JOURNAL_4_LEDGER_DISCOUNT','Purchase Order Discount Amount');
define('GENERAL_JOURNAL_4_LEDGER_FREIGHT','Purchase Order Freight Amount');
define('GENERAL_JOURNAL_4_LEDGER_HEADING','Purchase Order Total');
define('GL_MSG_IMPORT_4_SUCCESS','Successfully imported Purchase Orders. The number of records imported was: ');
define('GL_MSG_IMPORT_4','Imported Purchase Orders');

define('GENERAL_JOURNAL_6_DESC','Purchase/Receive Entry');
define('GENERAL_JOURNAL_6_ERROR_2','P/R - The invoice number you entered is a duplicate, please enter a new invoice number!');
define('GENERAL_JOURNAL_6_ERROR_6','P/R - A purchase cannot be deleted if there has been a credit memo or payment applied!');
define('GENERAL_JOURNAL_6_LEDGER_DISCOUNT','Purchase/Receive Discount Amount');
define('GENERAL_JOURNAL_6_LEDGER_FREIGHT','Purchase/Receive Freight Amount');
define('GENERAL_JOURNAL_6_LEDGER_HEADING','Purchase/Receive Inventory Total');
define('GL_MSG_IMPORT_6_SUCCESS','Successfully imported Accounts Payable entries. The number of records imported was: ');
define('GL_MSG_IMPORT_6','Imported Accounts Payable');

define('GENERAL_JOURNAL_7_DESC','Vendor Credit Memo Entry');
define('GENERAL_JOURNAL_7_ERROR_2','VCM - The credit memo number you entered is a duplicate, please enter a new credit memo number!');
define('GENERAL_JOURNAL_7_ERROR_5','VCM - Failed incrementing the credit memo number!');
define('GENERAL_JOURNAL_7_ERROR_6','VCM - An credit memo cannot be deleted if there has been a payment applied!');
define('GENERAL_JOURNAL_7_LEDGER_DISCOUNT','Vendor Credit Memo Discount Amount');
define('GENERAL_JOURNAL_7_LEDGER_FREIGHT','Vendor Credit Memo Freight Amount');
define('GENERAL_JOURNAL_7_LEDGER_HEADING','Vendor Credit Memo Total');

define('GENERAL_JOURNAL_9_DESC','Sales Quote Entry');
define('GENERAL_JOURNAL_9_ERROR_2','SQ - The sales quote number you entered is a duplicate, please enter a new sales quote number!');
define('GENERAL_JOURNAL_9_ERROR_5','SQ - Failed incrementing the sales quote number!');
define('GENERAL_JOURNAL_9_LEDGER_DISCOUNT','Sales Quote Discount Amount');
define('GENERAL_JOURNAL_9_LEDGER_FREIGHT','Sales Quote Freight Amount');
define('GENERAL_JOURNAL_9_LEDGER_HEADING','Sales Quote Total');

define('GENERAL_JOURNAL_10_DESC','Sales Order Entry');
define('GENERAL_JOURNAL_10_ERROR_2','SO - The sales order number you entered is a duplicate, please enter a new sales order number!');
define('GENERAL_JOURNAL_10_ERROR_5','SO - Failed incrementing the sales order number!');
define('GENERAL_JOURNAL_10_ERROR_6','SO - A sales order cannot be deleted if there are items that have been shipped!');
define('GENERAL_JOURNAL_10_LEDGER_DISCOUNT','Sales Order Discount Amount');
define('GENERAL_JOURNAL_10_LEDGER_FREIGHT','Sales Order Freight Amount');
define('GENERAL_JOURNAL_10_LEDGER_HEADING','Sales Order Total');
define('GL_MSG_IMPORT_10_SUCCESS','Successfully imported Sales Orders. The number of records imported was: ');
define('GL_MSG_IMPORT_10','Imported Sales Orders');

define('GENERAL_JOURNAL_12_DESC','Sales/Invoice Entry');
define('GENERAL_JOURNAL_12_ERROR_2','S/I - The invoice number you entered is a duplicate, please enter a new invoice number!');
define('GENERAL_JOURNAL_12_ERROR_5','S/I - Failed incrementing the invoice number!');
define('GENERAL_JOURNAL_12_ERROR_6','S/I - An invoice cannot be deleted if there has been a credit memo or payment applied!');
define('GENERAL_JOURNAL_12_LEDGER_DISCOUNT','Sales/Invoice Discount Amount');
define('GENERAL_JOURNAL_12_LEDGER_FREIGHT','Sales/Invoice Freight Amount');
define('GENERAL_JOURNAL_12_LEDGER_HEADING','Sales/Invoice Total');
define('GL_MSG_IMPORT_12','Imported Accounts Receivable Entry');
define('GL_MSG_IMPORT_12_SUCCESS','Successfully imported Accounts Receivable. The number of records imported was: ');
define('GL_MSG_IMPORT_12','Imported Invoices');

define('GENERAL_JOURNAL_13_DESC','Customer Credit Memo Entry');
define('GENERAL_JOURNAL_13_ERROR_2','CCM - The credit memo number you entered is a duplicate, please enter a new credit memo number!');
define('GENERAL_JOURNAL_13_ERROR_5','CCM - Failed incrementing the credit memo number!');
define('GENERAL_JOURNAL_13_ERROR_6','CCM - An credit memo cannot be deleted if there has been a payment applied!');
define('GENERAL_JOURNAL_13_LEDGER_DISCOUNT','Customer Credit Memo Discount Amount');
define('GENERAL_JOURNAL_13_LEDGER_FREIGHT','Customer Credit Memo Freight Amount');
define('GENERAL_JOURNAL_13_LEDGER_HEADING','Customer Credit Memo Total');

define('GENERAL_JOURNAL_14_DESC','Inventory Assembly Entry');

define('GENERAL_JOURNAL_16_DESC','Inventory Adjustment Entry');

define('GENERAL_JOURNAL_18_DESC','Customer Receipts Entry');
define('GENERAL_JOURNAL_18_ERROR_2','C/R - The receipt number you entered is a duplicate, please enter a new receipt number!');
define('GENERAL_JOURNAL_18_ERROR_5','C/R - Failed incrementing the receipt number!');
define('GENERAL_JOURNAL_18_ERROR_6','C/R - An receipt cannot be deleted if the entry has been reconciled with the bank!');
define('GENERAL_JOURNAL_18_DISCOUNT_HEADING','Customer Receipt Discount');
define('GENERAL_JOURNAL_18_LEDGER_HEADING','Customer Receipt Total');
/*
define('GENERAL_JOURNAL_19_DESC','Point of Sale Entry');
define('GENERAL_JOURNAL_19_ERROR_2','S/I - The receipt number you entered is a duplicate, please enter a new receipt number!');
define('GENERAL_JOURNAL_19_ERROR_5','S/I - Failed incrementing the receipt number!');
define('GENERAL_JOURNAL_19_ERROR_6','S/I - An receipt cannot be deleted if there has been a payment applied!');
define('GENERAL_JOURNAL_19_LEDGER_DISCOUNT','Point of Sale Discount Amount');
define('GENERAL_JOURNAL_19_LEDGER_FREIGHT','Point of Sale Freight Amount');
define('GENERAL_JOURNAL_19_DISCOUNT_HEADING','Customer Receipt Discount');
define('GENERAL_JOURNAL_19_LEDGER_HEADING','Point of Sale Total');
*/
define('GENERAL_JOURNAL_20_DESC','Vendor Payment Entry');
define('GENERAL_JOURNAL_20_ERROR_2','V/P - The check number you entered is a duplicate, please enter a new check number!');
define('GENERAL_JOURNAL_20_ERROR_5','V/P - Failed incrementing the payment number!');
define('GENERAL_JOURNAL_20_ERROR_6','V/P - A payment cannot be deleted if the entry has been reconciled with the bank!');
define('GENERAL_JOURNAL_20_DISCOUNT_HEADING','Vendor Payment Discount');
define('GENERAL_JOURNAL_20_LEDGER_HEADING','Vendor Payment Total');
/*
define('GENERAL_JOURNAL_21_DESC','Purchase Entry');
define('GENERAL_JOURNAL_21_ERROR_2','P/R - The check number you entered is a duplicate, please enter a new check number!');
define('GENERAL_JOURNAL_21_ERROR_6','P/R - A purchase cannot be deleted if there has been a payment applied!');
define('GENERAL_JOURNAL_21_LEDGER_DISCOUNT','Purchase Discount Amount');
define('GENERAL_JOURNAL_21_LEDGER_FREIGHT','Purchase Freight Amount');
define('GENERAL_JOURNAL_21_DISCOUNT_HEADING','Purchase Discount');
define('GENERAL_JOURNAL_21_LEDGER_HEADING','Purchase Total');
*/
?>