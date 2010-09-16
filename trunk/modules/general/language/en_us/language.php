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
//  Path: /modules/general/language/en_us/language.php
//

// NOTE: NEW RELEASE ADDITIONS/UPDATES/CHANGES ARE AT THE BOTTOM OF THIS FILE 

define('LANGUAGE','English (US)');

// look in your $PATH_LOCALE/locale directory for available locales.
// on RedHat6.0 I used 'en_US'
// on FreeBSD 4.0 I use 'en_US.ISO_8859-1'
// this may not work under win32 environments..
setlocale(LC_ALL, 'en_US.UTF-8');
setlocale(LC_CTYPE, 'C');

define('DATE_FORMAT', 'm/d/Y'); // this is used for date(), use only values: Y, m and d (case sensitive)
define('DATE_DELIMITER', '/'); // must match delimiter used in DATE_FORMAT
define('DATE_TIME_FORMAT', DATE_FORMAT . ' h:i:s a');
define('DATE_FORMAT_SPIFFYCAL', 'MM/dd/yyyy');  //Use only 'dd', 'MM' and 'yyyy' here in any order
define('MAX_NUM_PRICE_LEVELS', 5);
define('MAX_NUM_ADDRESSES', 5); // *****  For Import/Export Module, set the maximum number of addresses *****
define('MAX_INVENTORY_SKU_LENGTH', 15); // database is currently set for a maximum of 24 characters

// Global entries for the <html> tag
define('HTML_PARAMS','lang="en-US" xml:lang="en-US"');

// charset for web pages and emails
define('CHARSET', 'UTF-8');
define("LANG_I18N","en");

// Meta-tags: page title
define('TITLE', 'PhreeBooks');

// **************  Release 2.1 changes  ********************
define('BOX_PHREEFORM_MODULE','PhreeForm');
define('BOX_PHREEFORM_MODULE_ADM','PhreeForm Admin');
define('TEXT_HERE', 'here');
define('TEXT_COPYRIGHT','Copyright');
define('TEXT_COPYRIGHT_NOTICE','This program is free software: you can redistribute it and/or 
modify it under the terms of the GNU General Public License as 
published by the Free Software Foundation, either version 3 of 
the License, or any later version. This program is distributed 
in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
without even the implied warranty of MERCHANTABILITY or FITNESS 
FOR A PARTICULAR PURPOSE. See the GNU General Public License for 
more details. The license that is bundled with this package is 
located %s.');
define('TEXT_EXCHANGE_RATE','Exchange Rate');
define('TEXT_BRANCH','Branch');

// **************  Release 2.0 changes  ********************
define('TEXT_HEADING','Heading');
define('TEXT_MOVE_LEFT','Move Left');
define('TEXT_MOVE_RIGHT','Move Right');
define('TEXT_MOVE_UP','Move Up');
define('TEXT_MOVE_DOWN','Move Down');
define('TEXT_PROFILE','Profile');
define('TEXT_FIND','Find ...');
define('TEXT_DETAILS','Details');
define('TEXT_HIDE','Hide');
define('BOX_PHREECRM_MODULE','PhreeCRM');
define('BOX_ACCOUNTS_NEW_CONTACT','New Contact');
define('TEXT_ENCRYPTION_ENABLED','Encryption Key is Set');
define('BOX_GL_BUDGET','Budgeting');
define('TEXT_DEFAULT_PRICE_SHEET','Default Price Sheet');
define('TEXT_PURCH_ORDER','Purchase Orders');
define('TEXT_PURCHASE','Purchases');

// **************  Release 1.9 changes  ********************
define('TEXT_START_DATE','Start Date');
define('TEXT_END_DATE','End Date');
define('TEXT_PROJECT','Project');
define('DB_ERROR_NOT_CONNECTED', 'Database Error: Could not connect to the Database!');
define('BOX_BANKING_VENDOR_DEPOSITS', 'Vendor Deposits');
define('BOX_AR_QUOTE_STATUS', 'Sales Quote Manager');
define('BOX_AP_RFQ_STATUS', 'Purchase Quote Manager');
define('BOX_PROJECTS_PHASES','Project Phases');
define('BOX_PROJECTS_COSTS','Project Costs');
define('BOX_ACCOUNTS_MAINTAIN_PROJECTS','Maintain Projects');
define('BOX_ACCOUNTS_NEW_PROJECT', 'New Project');
define('TEXT_JAN', 'Jan');
define('TEXT_FEB', 'Feb');
define('TEXT_MAR', 'Mar');
define('TEXT_APR', 'Apr');
define('TEXT_MAY', 'May');
define('TEXT_JUN', 'Jun');
define('TEXT_JUL', 'Jul');
define('TEXT_AUG', 'Aug');
define('TEXT_SEP', 'Sep');
define('TEXT_OCT', 'Oct');
define('TEXT_NOV', 'Nov');
define('TEXT_DEC', 'Dec');
define('TEXT_SUN', 'S');
define('TEXT_MON', 'M');
define('TEXT_TUE', 'T');
define('TEXT_WED', 'W');
define('TEXT_THU', 'T');
define('TEXT_FRI', 'F');
define('TEXT_SAT', 'S');

// **************  Release 1.8 changes  ********************
define('BOX_BANKING_CUSTOMER_DEPOSITS', 'Customer Deposits');
define('GEN_CALENDAR_FORMAT_ERROR', "A submitted date format was in error, please check all your dates! Received: %s. (Date Format: " . DATE_FORMAT . ") Please check your SEPARATOR in /modules/general/language/langname/language.php is consistent for SpiffyCal also: " . DATE_FORMAT_SPIFFYCAL);

// **************  Release 1.7 and earlier  ********************
// header text in includes/header.php
define('HEADER_TITLE_TOP', 'Home');
define('HEADER_TITLE_LOGOFF', 'Logoff');

// Menu heading translations
define('MENU_HEADING_CUSTOMERS', 'Customers');
define('MENU_HEADING_VENDORS', 'Vendors');
define('MENU_HEADING_INVENTORY', 'Inventory');
define('MENU_HEADING_BANKING', 'Banking');
define('MENU_HEADING_GL', 'General Ledger');
define('MENU_HEADING_EMPLOYEES', 'Employees');
define('MENU_HEADING_SETUP', 'Setup');
define('MENU_HEADING_TOOLS', 'Tools');
define('MENU_HEADING_QUALITY','Quality');
define('MENU_HEADING_REPORTS', 'Reports');
define('MENU_HEADING_COMPANY','Company');

// Report Group Definitions (import/export tabs, reports/forms)
define('TEXT_RECEIVABLES','Receivables');
define('TEXT_PAYABLES','Payables');
define('TEXT_INVENTORY','Inventory');
define('TEXT_HR','Human Resources');
define('TEXT_MANUFAC','Manufacturing');
define('TEXT_BANKING','Banking');
define('TEXT_GL','General Ledger');
define('TEXT_MISC','Miscellaneous');

// General Ledger Menu Labels
define('BOX_GL_JOURNAL_ENTRY', 'Journal Entry');
define('BOX_GL_ACCOUNTS', 'Chart of Accounts');
define('BOX_GL_UTILITIES', 'General Journal Utilities');

// Accounts Menu Labels
define('BOX_ACCOUNTS_NEW_CUSTOMER', 'New Customer');
define('BOX_ACCOUNTS_MAINTAIN_CUSTOMERS', 'Maintain Customers');
define('BOX_ACCOUNTS_NEW_EMPLOYEE', 'New Employee');
define('BOX_ACCOUNTS_MAINTAIN_EMPLOYEES', 'Maintain Employees');
define('BOX_ACCOUNTS_NEW_VENDOR', 'New Vendor');
define('BOX_ACCOUNTS_MAINTAIN_VENDORS', 'Maintain Vendors');
define('BOX_ACCOUNTS_NEW_BRANCH', 'New Branch');
define('BOX_ACCOUNTS_MAINTAIN_BRANCHES', 'Maintain Branches');

// Banking Menu Labels
define('BOX_BANKING_CUSTOMER_RECEIPTS', 'Customer Receipts');
define('BOX_BANKING_CUSTOMER_PAYMENTS', 'Customer Refunds');
define('BOX_BANKING_PAY_BILLS', 'Pay Bills');
define('BOX_BANKING_VENDOR_RECEIPTS', 'Refunds from Vendors');
define('BOX_BANKING_SELECT_FOR_PAYMENT', 'Select for Payment');
define('BOX_BANKING_BANK_ACCOUNT_REGISTER', 'Bank Account Register');
define('BOX_BANKING_ACCOUNT_RECONCILIATION', 'Account Reconciliation');
define('BOX_BANKING_VOID_CHECKS', 'Void Checks');

// HR Menu Labels
define('BOX_HR_MAINTAIN_REPS', 'Maintain Sales Reps');
define('BOX_HR_PAYROLL_ENTRY', 'Payroll Entry');
define('BOX_HR_DEPARTMENTS', 'Departments');
define('BOX_HR_DEPT_TYPES', 'Department Types');

// Inventory Menu labels
define('BOX_INV_MAINTAIN', 'Edit/Maintain');
define('BOX_INV_PURCHASE_RECEIVE', 'Purchase/Receive');
define('BOX_INV_ADJUSTMENTS', 'Adjustments');
define('BOX_INV_ASSEMBLIES', 'Assemblies');
define('BOX_INV_DEFAULTS', 'Inventory Defaults');
define('BOX_INV_REPORTS', 'Reports');
define('BOX_INV_TABS', 'Setup Inventory Field Tabs');
define('BOX_INV_FIELDS', 'Setup Inventory Fields');
define('BOX_INV_TRANSFER','Transfer Inventory');

// Payables Menu Labels
define('BOX_AP_PURCHASE_ORDER', 'Purchase Orders');
define('BOX_AP_CREDIT_MEMO', 'Vendor Credit Memos');
define('BOX_AP_DEFAULTS', 'Vendor Defaults');
define('BOX_AP_REPORTS', 'Reports');
define('BOX_AP_REQUEST_QUOTE', 'Request for Quote');
define('BOX_AP_RECEIVE_INVENTORY', 'Purchase/Receive');
define('BOX_AP_ORDER_STATUS', 'Purchase Order Manager');
//define('BOX_AP_WRITE_CHECK', 'Write Checks');

// Receivables Menu Labels
define('BOX_AR_SALES_ORDER', 'Sales Orders');
define('BOX_AR_QUOTE', 'Quotes');
define('BOX_AR_INVOICE', 'Sales/Invoices');
define('BOX_AR_CREDIT_MEMO', 'Customer Credit Memos');
define('BOX_AR_SHIPMENTS', 'Shipments');
define('BOX_AR_ORDER_STATUS', 'Sales Order Manager');
define('BOX_AR_DEFAULTS', 'Customer Defaults');
//define('BOX_AR_POINT_OF_SALE','Point of Sale');
define('BOX_AR_INVOICE_MGR', 'Invoice Manager');

// Setup/Misc Menu Labels
define('BOX_TAX_AUTH', 'Sales Tax Authorities');
define('BOX_TAX_AUTH_VEND', 'Purchase Tax Authorities');
define('BOX_TAX_RATES', 'Sales Tax Rates');
define('BOX_TAX_RATES_VEND', 'Purchase Tax Rates');
define('BOX_TAXES_COUNTRIES', 'Countries');
define('BOX_TAXES_ZONES', 'State/Provinces');
define('BOX_CURRENCIES', 'Currencies');
define('BOX_LANGUAGES', 'Languages');

// Configuration and defaults menu
define('BOX_HEADING_SEARCH','Search');
define('BOX_HEADING_USERS','Users');
define('BOX_HEADING_BACKUP','Company Backup');
define('BOX_COMPANY_CONFIG','Configuration Settings');

// Tools Menu Labels
define('BOX_HEADING_ENCRYPTION', 'Data Encryption');
define('BOX_IMPORT_EXPORT', 'Import/Export');
define('BOX_SHIPPING_MANAGER', 'Shipping Manager');
define('BOX_COMPANY_MANAGER', 'Company Manager');
define('BOX_HEADING_ADMIN_TOOLS', 'Administrative Tools');

// Services Menu Labels
define('BOX_SHIPPING', 'Shipping Settings');
define('BOX_PAYMENTS', 'Payment Settings');
define('BOX_PRICE_SHEETS', 'Price Sheet Settings');
define('BOX_PRICE_SHEET_MANAGER', 'Price Sheet Manager');

// Quality Menu Labels
define('BOX_QUALITY_HOME','Quality Home');

// General Headings
define('GEN_HEADING_PLEASE_SELECT','Please Select...');

// User Manager
define('HEADING_TITLE_USERS','Users');
define('HEADING_TITLE_USER_INFORMATION','User Information');
define('HEADING_TITLE_SEARCH_INFORMATION','Search for Journal Entries');

// Address/contact identifiers
define('GEN_PRIMARY_NAME', 'Name/Company');
define('GEN_EMPLOYEE_NAME', 'Employee Name');
define('GEN_CONTACT', 'Attention');
define('GEN_ADDRESS1', 'Address1');
define('GEN_ADDRESS2', 'Address2');
define('GEN_CITY_TOWN', 'City');
define('GEN_STATE_PROVINCE', 'State');
define('GEN_POSTAL_CODE', 'ZipCode');
define('GEN_COUNTRY', 'Country');
define('GEN_COUNTRY_CODE', 'ISO Code');

define('GEN_FIRST_NAME','First Name');
define('GEN_MIDDLE_NAME','Middle Name');
define('GEN_LAST_NAME','Last Name');
define('GEN_TELEPHONE1', 'Telephone');
define('GEN_TELEPHONE2', 'Alt Telephone');
define('GEN_FAX','Fax');
define('GEN_TELEPHONE4', 'Mobile Phone');

define('GEN_USERNAME','Username');
define('GEN_DISPLAY_NAME','Display Name');
define('GEN_ACCOUNT_ID', 'Account ID');
define('GEN_CUSTOMER_ID', 'Customer ID:');
define('GEN_STORE_ID', 'Store ID');
define('GEN_VENDOR_ID', 'Vendor ID:');
define('GEN_EMAIL','Email');
define('GEN_WEBSITE','Website');
define('GEN_ACCOUNT_LINK','Link to Employee Account');

// General definitions
define('TEXT_ABSCISSA','Abscissa');
define('TEXT_ACCOUNT_TYPE', 'Account Type');
define('TEXT_ACCOUNTING_PERIOD', 'Accounting Period');
define('TEXT_ACCOUNTS', 'Accounts');
define('TEXT_ACCT_DESCRIPTION', 'Account Description');
define('TEXT_ACTIVE','Active');
define('TEXT_ACTION','Action');
define('TEXT_ADD','Add');
define('TEXT_ADJUSTMENT','Adjustment');
define('TEXT_ALL','All');
define('TEXT_ALIGN','Align');
define('TEXT_AMOUNT','Amount');
define('TEXT_AND','and');
define('TEXT_BACK','Back');
define('TEXT_BALANCE','Balance');
define('TEXT_BOTTOM','Bottom');
define('TEXT_BREAK','Break');
define('TEXT_CANCEL','Cancel');
define('TEXT_CARRIER','Carrier');
define('TEXT_CATEGORY_NAME', 'Category Name');
define('TEXT_CAUTION','Caution');
define('TEXT_CENTER','Center');
define('TEXT_CHANGE','Change');
define('TEXT_CLEAR','Clear');
define('TEXT_CLOSE','Close');
define('TEXT_COLLAPSE','Collapse');
define('TEXT_COLLAPSE_ALL','Collapse All');
define('TEXT_COLOR','Color');
define('TEXT_COLUMN','Column');
define('TEXT_CONTAINS','Contains');
define('TEXT_COPY','Copy');
define('TEXT_COPY_TO','Copy To');
define('TEXT_CONFIRM_PASSWORD','Confirm Password');
define('TEXT_CONTINUE','Continue');
define('TEXT_CREDIT_AMOUNT','Credit Amount');
define('TEXT_CRITERIA','Criteria');
define('TEXT_CUSTCOLOR','Custom Color (Range 0-255)');
define('TEXT_CURRENCY','Currency');
define('TEXT_CURRENT','Current');
define('TEXT_CUSTOM','Custom');
define('TEXT_DATE','Date');
define('TEXT_DEBIT_AMOUNT','Debit Amount');
define('TEXT_DELETE','Delete');
define('TEXT_DEFAULT','Default');
define('TEXT_DEPARTMENT','Department');
define('TEXT_DESCRIPTION','Description');
define('TEXT_DISCOUNT','Discount');
define('TEXT_DOWN','Down');
define('TEXT_EDIT','Edit');
define('TEXT_ENTER_NEW', 'Enter New ...');
define('TEXT_ERROR','Error');
define('TEXT_EQUAL','Equal To');
define('TEXT_ESTIMATE','Estimate');
define('TEXT_EXPAND','Expand');
define('TEXT_EXPAND_ALL','Expand All');
define('TEXT_EXPORT','Export');
define('TEXT_EXPORT_CSV','Export CSV');
define('TEXT_EXPORT_PDF','Export PDF');
define('TEXT_FALSE','False');
define('TEXT_FIELD', 'Field');
define('TEXT_FIELDS','Fields');
define('TEXT_FILE_UPLOAD','File Upload');
define('TEXT_FILL','Fill');
define('TEXT_FILTER','Filter');
define('TEXT_FINISH','Finish');
define('TEXT_FORM','Form');
define('TEXT_FORMS','Forms');
define('TEXT_FLDNAME','Field Name');
define('TEXT_FONT','Font');
define('TEXT_FROM','From');
define('TEXT_FULL','Full');
define('TEXT_GENERAL','General'); // typical, standard
define('TEXT_GET_RATES','Get Rates');
define('TEXT_GL_ACCOUNT','GL Account');
define('TEXT_GREATER_THAN','Greater Than');
define('TEXT_GROUP','Group');
define('TEXT_HEIGHT','Height');
define('TEXT_HELP', 'Help');
define('TEXT_HISTORY','History');
define('TEXT_HORIZONTAL','Horizontal');
define('TEXT_IMPORT','Import');
define('TEXT_INACTIVE','Inactive');
define('TEXT_INFO', 'Info'); // Information
define('TEXT_INSERT', 'Insert');
define('TEXT_INSTALL', 'Install');
define('TEXT_INVOICE', 'Invoice');
define('TEXT_INVOICES', 'Invoices');
define('TEXT_IN_LIST', 'In List (csv)');
define('TEXT_ITEMS', 'Items');
define('TEXT_JOURNAL_TYPE', 'Journal Type');
define('TEXT_LEFT','Left');
define('TEXT_LENGTH','Length');
define('TEXT_LESS_THAN','Less Than');
define('TEXT_LEVEL','Level');
define('TEXT_MOVE','Move');
define('TEXT_NA','N/A'); // not applicable
define('TEXT_NO','No');
define('TEXT_NONE', '- None -');
define('TEXT_NOTE', 'Note:');
define('TEXT_NOTES', 'Notes');
define('TEXT_NEW', 'New');
define('TEXT_NOT_EQUAL','Not Equal To');
define('TEXT_NUM_AVAILABLE', '# Available');
define('TEXT_NUM_REQUIRED', '# Required');
define('TEXT_OF','of');
define('TEXT_OPEN','Open');
define('TEXT_OPTIONS','Options');
define('TEXT_ORDER','Order');
define('TEXT_ORDINATE','Ordinate');
define('TEXT_PAGE','Page');
define('TEXT_PAID','Paid');
define('TEXT_PASSWORD','Password');
define('TEXT_PAY','Pay');
define('TEXT_PAYMENT','Payment');
define('TEXT_PAYMENT_METHOD','Payment Method');
define('TEXT_PAYMENTS','Payments');
define('TEXT_PERIOD','Period');
define('TEXT_PGCOYNM','Company Name');
define('TEXT_POST_DATE', 'Post Date');
define('TEXT_PRICE', 'Price');
define('TEXT_PRICE_MANAGER', 'Price Sheets');
define('TEXT_PRINT','Print');
define('TEXT_PRINTED','Printed');
define('TEXT_PROCESSING', 'Processing');
define('TEXT_PROPERTIES','Properties');
define('TEXT_PO_NUMBER', 'PO #');
define('TEXT_QUANTITY','Quantity');
define('TEXT_RANGE','Range');
define('TEXT_READ_ONLY','Read Only');
define('TEXT_RECEIVE','Receive');
define('TEXT_RECEIVE_ALL','Receive PO');
define('TEXT_RECEIPTS','Receipts');
define('TEXT_RECUR','Recur');
define('TEXT_REFERENCE','Reference');
define('TEXT_REMOVE','Remove');
define('TEXT_RENAME','Rename');
define('TEXT_REPLACE','Replace');
define('TEXT_REPORT','Report');
define('TEXT_REPORTS','Reports');
define('TEXT_RESET','Reset');
define('TEXT_RESULTS','Results');
define('TEXT_REVISE','Revise');
define('TEXT_RIGHT','Right');
define('TEXT_SAVE', 'Save');
define('TEXT_SAVE_AS', 'Save As');
define('TEXT_SEARCH', 'Search');
define('TEXT_SECURITY','Security');
define('TEXT_SECURITY_SETTINGS','Security Settings');
define('TEXT_SELECT','Select');
define('TEXT_SEND','Send');
define('TEXT_SEPARATOR','Separator');
define('TEXT_SERIAL_NUMBER','Serial Number');
define('TEXT_SERVICE_NAME','Service Name');
define('TEXT_SEQUENCE', 'Sequence');
define('TEXT_SHIP','Ship');
define('TEXT_SHIP_ALL','Fill SO');
define('TEXT_SHOW','Show');
define('TEXT_SLCTFIELD','Select a field...');
define('TEXT_SEQ','Sequence');
define('TEXT_SIZE','Size');
define('TEXT_SKU','SKU');
define('TEXT_SORT','Sort');
define('TEXT_SORT_ORDER','Sort Order');
define('TEXT_SOURCE', 'Source');
define('TEXT_STATUS','Status');
define('TEXT_STATISTICS','Statistics');
define('TEXT_STDCOLOR','Standard Color');
define('TEXT_SUCCESS','Success');
define('TEXT_SYSTEM','System');
define('TEXT_TIME','Time');
define('TEXT_TITLE','Title');
define('TEXT_TO','To');
define('TEXT_TOP','Top');
define('TEXT_TOTAL','Total');
define('TEXT_TRANSACTION_DATE','Transaction Date');
define('TEXT_TRANSACTION_TYPE','Transaction Type');
define('TEXT_TRIM','Trim');
define('TEXT_TRUE','True');
define('TEXT_TRUNCATE','Truncate');
define('TEXT_TRUNC','Truncate Long Descriptions');
define('TEXT_TYPE','Type');
define('TEXT_UNIT_PRICE','Unit Price');
define('TEXT_UNPRINTED','Unprinted');
define('TEXT_UP','Up');
define('TEXT_UPDATE','Update');
define('TEXT_URL','URL');
define('TEXT_USERS','Users');
define('TEXT_UTILITIES','Utilities');
define('TEXT_VALUE', 'Value');
define('TEXT_VERTICAL','Vertical');
define('TEXT_VIEW','View');
define('TEXT_VIEW_SHIP_LOG','View Ship Log');
define('TEXT_WEIGHT','Weight');
define('TEXT_WIDTH','Width');
define('TEXT_YES','Yes');

// javascript messages
define('JS_ERROR', 'Errors have occurred during the processing of your form!\nPlease make the following corrections:\n\n');
define('JS_CTL_PANEL_DELETE_BOX','Do you really want to delete this box?');
define('JS_CTL_PANEL_DELETE_IDX','Do you really want to delete this index?');

// Audit log messages
define('GEN_LOG_LOGIN','User Login -> ');
define('GEN_LOG_LOGIN_FAILED','Failed User Login - id -> ');
define('GEN_LOG_LOGOFF','User Logoff -> ');
define('GEN_LOG_RESEND_PW','Re-sent Password to email -> ');
define('GEN_LOG_USER_ADD','User Maintenance - Added Username -> ');
define('GEN_LOG_USER_COPY','User Maintenance - Copy');
define('GEN_MSG_COPY_INTRO','Please enter the new user name.');
define('GEN_ERROR_DUPLICATE_ID','The username is already in use. Please select a different name.');
define('GEN_MSG_COPY_SUCCESS','The user was copied. Please set the password and any other properties for this new user.');
define('GEN_LOG_USER_UPDATE','User Maintenance - Updated Username -> ');
define('GEN_LOG_USER_DELETE','User Maintenance - Deleted Username -> ');
define('GEN_DB_DATA_BACKUP','Company Database Backup');
define('GEN_LOG_PERIOD_CHANGE','Accounting Period - Change');

// constants for use in prev_next_display function
define('TEXT_SHOW_NO_LIMIT', ' (0 for unlimited) ');
define('TEXT_RESULT_PAGE', 'Page %s of %d');
define('TEXT_GO_FIRST','Jump to first page');
define('TEXT_GO_PREVIOUS','Previous page');
define('TEXT_GO_NEXT','Next page');
define('TEXT_GO_LAST','Jump to last page');
define('TEXT_DISPLAY_NUMBER', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b>) ');
define('PREVNEXT_BUTTON_PREV', '&lt;&lt;');
define('PREVNEXT_BUTTON_NEXT', '&gt;&gt;');
define('TEXT_FIELD_REQUIRED', '&nbsp;<span class="fieldRequired">*</span>');

// misc error messages
define('GEN_ERRMSG_NO_DATA','A required field has been left blank. Field: ');
define('ERROR_MSG_ACCT_PERIOD_CHANGE','The Accounting Period has been automatically changed to: %s');
define('ERROR_MSG_BAD_POST_DATE','Caution! The post date falls outside of the current accounting period!');
define('ERROR_MSG_POST_DATE_NOT_IN_FISCAL_YEAR','The post date specified is not within any of the currently defined fiscal years. Either change the post date or add the necessary fiscal year.');
define('ERROR_NO_PERMISSION','You do not have permission to perform the requested operation. Please contact the administrator to request access permissions.');
define('ERROR_NO_SEARCH_PERMISSION','You do not have permission to view this search result.');
define('ERROR_NO_DEFAULT_CURRENCY_DEFINED', 'Error: There is currently no default currency set. Please set one at: Setup->Currencies');
define('ERROR_CANNOT_CREATE_DIR','Backup directory could not be created in /my_files. Check permissions.');
define('ERROR_COMPRESSION_FAILED','Backup compression failed: ');
define('TEXT_EMAIL','Email: ');
define('TEXT_SENDER_NAME','Sender Name: ');
define('TEXT_RECEPIENT_NAME','Recepient Name: ');
define('TEXT_MESSAGE_SUBJECT','Message Subject: ');
define('TEXT_MESSAGE_BODY','Message Body: ');
define('EMAIL_SEND_FAILED','The email message was not sent.');
define('EMAIL_SEND_SUCCESS','The email was sent successfully.');
define('GEN_PRICE_SHEET_CURRENCY_NOTE','NOTE: All values are in: %s');
define('DEBUG_TRACE_MISSING','Couldn\'t find the trace file. Make sure you capture a trace before trying to download the file!');

// search filters
define('TEXT_ASC','Asc');
define('TEXT_DESC','Desc');
define('TEXT_INFO_SEARCH_DETAIL_FILTER','Search Filter: ');
define('TEXT_INFO_SEARCH_PERIOD_FILTER','Accounting Period: ');
define('HEADING_TITLE_SEARCH_DETAIL','Search: ');
define('TEXT_TRANSACTION_AMOUNT','Transaction Amount');
define('TEXT_REFERENCE_NUMBER','Invoice/Order Number');
define('TEXT_CUST_VEND_ACCT','Customer/Vendor Account');
define('TEXT_INVENTORY_ITEM','Inventory Item');
define('TEXT_GENERAL_LEDGER_ACCOUNT','General Ledger Account');
define('TEXT_JOURNAL_RECORD_ID','Journal Record ID');

// Version Check notices
define('TEXT_VERSION_CHECK_NEW_VER','There is a new PhreeBooks version available. Installed Version: <b>%s</b> available version = <b>%s</b>');

// control panel defines
define('CP_ADD_REMOVE_BOXES','Add/Remove Profile Boxes');
define('CP_CHANGE_PROFILE','change profile...');

// Defines for login screen
define('HEADING_TITLE', 'PhreeBooks Login');
define('TEXT_LOGIN_NAME', 'Username: ');
define('TEXT_LOGIN_PASS', 'Password: ');
define('TEXT_LOGIN_ENCRYPT', 'Encryption Key (Leave blank if not used): ');
define('TEXT_LOGIN_COMPANY','Select Company: ');
define('TEXT_LOGIN_LANGUAGE','Select Language: ');
define('TEXT_LOGIN_THEME','Select Theme: ');
define('TEXT_LOGIN_BUTTON','Login');
define('ERROR_WRONG_LOGIN', 'You entered the wrong username or password.');
define('TEXT_PASSWORD_FORGOTTEN', 'Resend Password');

// Defines for users.php
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'The Password Confirmation must match your new Password.');
define('ENTRY_PASSWORD_NEW_ERROR', 'Your new Password must contain a minimum of ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');
define('TEXT_DELETE_INTRO_USERS', 'Are you sure you want to delete this user account?');
define('TEXT_DELETE_ENTRY', 'Are you sure you want to delete this entry?');
define('TEXT_FILL_ALL_LEVELS','Fill all to level');

// defines for password forgotten
define('LOST_HEADING_TITLE', 'Resend Password');
define('TEXT_ADMIN_EMAIL', 'Email Address: ');
define('ERROR_WRONG_EMAIL', '<p>You entered the wrong email address.</p>');
define('ERROR_WRONG_EMAIL_NULL', '<p>Nice try mate :-P</p>');
define('SUCCESS_PASSWORD_SENT', '<p>Success: A new password has been sent to your e-mail address.</p>');
define('TEXT_EMAIL_SUBJECT', 'Your requested password reset request');
define('TEXT_EMAIL_FROM', EMAIL_FROM);
define('TEXT_EMAIL_MESSAGE', 'A new password was requested from your email address.' . "\n\n" . 'Your new password to \'' . COMPANY_NAME . '\' is:' . "\n\n" . '   %s' . "\n\n");

// Error messages for importing reports, forms and import/export functions
define('TEXT_IMP_ERMSG1','The filesize exceeds the upload_max_filesize directive in you php.ini settings.');
define('TEXT_IMP_ERMSG2','The filesize exceeds the MAX_FLE_SIZE directive in the PhreeBooks form.');
define('TEXT_IMP_ERMSG3','The file was not completely uploaded. Please retry.');
define('TEXT_IMP_ERMSG4','No file was selected to upload.');
define('TEXT_IMP_ERMSG5','Unknown php upload error, php returned error # ');
define('TEXT_IMP_ERMSG6','This file is not reported by the server as a text file.');
define('TEXT_IMP_ERMSG7','The uploaded file does not contain any data!');
define('TEXT_IMP_ERMSG8','PhreeBooks could not find a valid report to import in the uploaded file!');
define('TEXT_IMP_ERMSG9',' was successfully imported!');
define('TEXT_IMP_ERMSG10','There was an unexpected error uploading the file!');
define('TEXT_IMP_ERMSG11','The file was successfully imported!');
define('TEXT_IMP_ERMSG12','The export file did not contain any data!');
define('TEXT_IMP_ERMSG13','There was an unexpected error uploading the file! No file was uploaded.');
define('TEXT_IMP_ERMSG14','Error in input file. Found more than 2 text qualifiers! Failed text string was: ');
define('TEXT_IMP_ERMSG15','The import file needs an index reference value to process the data! Include data and check the \'Show\' box for field name: ');

/********************* Release R1.7 additions *************************/
define('BOX_INV_TOOLS','Inventory Tools');

/********************* Release R1.8 additions *************************/
// Configuration Groups - Moved menu from DB to here since it's loaded every time, allows translation
// code CD_xx_TITLE : CG - config group, xx - index, must match with menu_navigation.php
define('CG_01_TITLE','My Company');
define('CG_01_DESC', 'General information about my company');
define('CG_02_TITLE','Customer Defaults');
define('CG_02_DESC', 'Default settings for customer accounts');
define('CG_03_TITLE','Vendor Defaults');
define('CG_03_DESC', 'Default settings for vendor accounts');
define('CG_04_TITLE','Employee Defaults');
define('CG_04_DESC', 'Default settings for employees');
define('CG_05_TITLE','Inventory Defaults');
define('CG_05_DESC', 'Default settings for inventory accounts');
define('CG_07_TITLE','User Account Defaults');
define('CG_07_DESC', 'Default settings for user accounts');
define('CG_08_TITLE','General Settings');
define('CG_08_DESC', 'General application settings');
define('CG_09_TITLE','Import / Export Settings');
define('CG_09_DESC', 'Import / export default settings');
define('CG_10_TITLE','Shipping Defaults');
define('CG_10_DESC', 'Shipping/freight default settings');
define('CG_11_TITLE','Address Book Defaults');
define('CG_11_DESC', 'Default settings for the address book');
define('CG_12_TITLE','E-Mail Options');
define('CG_12_DESC', 'General setting for E-Mail transport and HTML E-Mails');
define('CG_13_TITLE','General Ledger Defaults');
define('CG_13_DESC', 'Default settings for general ledger accounts');
define('CG_15_TITLE','Sessions');
define('CG_15_DESC', 'Session options');
define('CG_17_TITLE','Credit Cards');
define('CG_17_DESC', 'Credit Cards Accepted');
define('CG_19_TITLE','Layout Settings');
define('CG_19_DESC', 'Layout Options');
define('CG_20_TITLE','Website Maintenance');
define('CG_20_DESC', 'Website Maintenance Options');

/********************* Release R1.9 additions *************************/
define('TEXT_EMPLOYEE','Employee');
define('TEXT_SALES_REP','Sales Rep');
define('TEXT_BUYER','Buyer');

?>