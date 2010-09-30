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
//  Path: /modules/accounts/language/en_us/language.php
//

// *************  Release 2.1 changes  *********************
define('RECORD_NUM_REF_ONLY','record ID (Reference only) = ');

// *************  Release 2.0 changes  *********************
define('TEXT_NEW_CONTACT','New Contact');
define('TEXT_COPY_ADDRESS','Transfer Address');
define('TEXT_CONTACTS','Contacts');
define('TEXT_TITLE','Title');
define('TEXT_LINK_TO','Link To:');
define('ACT_CATEGORY_I_ADDRESS','Add/Edit Contact');
define('ACT_CONTACT_HISTORY','Contact History');
define('ACT_I_SHORT_NAME','Contact');
define('ACT_I_HEADING_TITLE','PhreeCRM');
define('ACT_I_TYPE_NAME','Contacts');
define('ACT_I_PAGE_TITLE_EDIT','Edit Contact');
define('ACT_SHORT_NAME','Contact ID');
define('ACT_GL_ACCOUNT_TYPE','Category');
define('ACT_ACCOUNT_NUMBER','Facebook ID');
define('ACT_ID_NUMBER','Twitter ID');
define('ACT_REP_ID','Link to Customer/Vendor');
define('ACT_FIRST_DATE','Creation Date');
define('ACT_LAST_DATE1','Last Update');
define('ACT_ERROR_DUPLICATE_CONTACT','The contact ID already exists in the system, please enter a new contact ID.');

// *************  Release 1.9 changes  *********************
// Text specific to Projects
define('ACT_J_TYPE_NAME','projects');
define('ACT_J_HEADING_TITLE', 'Projects');
define('ACT_J_SHORT_NAME', 'Project ID');
define('ACT_J_ID_NUMBER','Reference PO');
define('ACT_J_REP_ID','Sales Rep ID');
define('ACT_J_PAGE_TITLE_EDIT','Edit Project');
define('ACT_J_ACCOUNT_NUMBER','Break Into Phases:');
define('ACT_ID_AUTO_FILL','(Leave blank for system generated ID)');

// *********************************************************
// Targeted defines (to differentiate wording differences for different account types)
// Text specific to Vendor accounts
define('ACT_V_TYPE_NAME','Vendors');
define('ACT_V_HEADING_TITLE', 'Vendors');
define('ACT_V_SHORT_NAME', 'Vendor ID');
define('ACT_V_GL_ACCOUNT_TYPE','Purchase GL Account');
define('ACT_V_ID_NUMBER','Federal EIN');
define('ACT_V_REP_ID','Purchase Rep ID');
define('ACT_V_ACCOUNT_NUMBER','Account Number');
define('ACT_V_FIRST_DATE','Vendor Since: ');
define('ACT_V_LAST_DATE1','Last Invoice Date: ');
define('ACT_V_LAST_DATE2','Last Payment Date: ');
define('ACT_V_PAGE_TITLE_EDIT','Edit Vendor');
// Text specific to Employee accounts
define('ACT_E_TYPE_NAME','Employees');
define('ACT_E_HEADING_TITLE', 'Employees');
define('ACT_E_SHORT_NAME', 'Employee ID');
define('ACT_E_GL_ACCOUNT_TYPE','Employee Type');
define('ACT_E_ID_NUMBER','Social Security Number');
define('ACT_E_REP_ID','Department ID');
define('ACT_E_ACCOUNT_NUMBER','Not Used');
define('ACT_E_FIRST_DATE','Hire Date: ');
define('ACT_E_LAST_DATE1','Last Raise Date: ');
define('ACT_E_LAST_DATE2','Termination Date: ');
define('ACT_E_PAGE_TITLE_EDIT','Edit Employee');
// Text specific to branch accounts
define('ACT_B_TYPE_NAME','Branches');
define('ACT_B_HEADING_TITLE', 'Branches');
define('ACT_B_SHORT_NAME', 'Branch ID');
define('ACT_B_GL_ACCOUNT_TYPE','Not Used');
define('ACT_B_ID_NUMBER','Not Used');
define('ACT_B_REP_ID','Not Used');
define('ACT_B_ACCOUNT_NUMBER','Not Used');
define('ACT_B_FIRST_DATE','Creation Date: ');
define('ACT_B_LAST_DATE1','Not Used');
define('ACT_B_LAST_DATE2','Not Used');
define('ACT_B_PAGE_TITLE_EDIT','Edit Branch');
// Text specific to Customer accounts (default)
define('ACT_C_TYPE_NAME','Customers');
define('ACT_C_HEADING_TITLE', 'Customers');
define('ACT_C_SHORT_NAME', 'Customer ID');
define('ACT_C_GL_ACCOUNT_TYPE','Sales GL Account');
define('ACT_C_ID_NUMBER','Resale License Number');
define('ACT_C_REP_ID','Sales Rep ID');
define('ACT_C_ACCOUNT_NUMBER','Account Number');
define('ACT_C_FIRST_DATE','Customer Since: ');
define('ACT_C_LAST_DATE1','Last Invoice Date: ');
define('ACT_C_LAST_DATE2','Last Payment Date: ');
define('ACT_C_PAGE_TITLE_EDIT','Edit Customer');

// Category headings
define('ACT_CATEGORY_CONTACT','Contact Information');
define('ACT_CATEGORY_M_ADDRESS','Main Mailing Address');
define('ACT_CATEGORY_S_ADDRESS','Shipping Addresses');
define('ACT_CATEGORY_B_ADDRESS','Billing Addresses');
define('ACT_CATEGORY_P_ADDRESS','Credit Card Payment Information');
define('ACT_CATEGORY_INFORMATION','Account Information');
define('ACT_CATEGORY_PAYMENT_TERMS','Payment Terms');
define('TEXT_ADDRESS_BOOK','Address Book');
define('TEXT_EMPLOYEE_ROLES','Employee Roles');
define('ACT_ACT_HISTORY','Account History');
define('ACT_ORDER_HISTORY','Order History');
define('ACT_SO_HIST','Sales Order History (Most Recent %s Results)');
define('ACT_PO_HIST','Purchase Order History (Most Recent %s Results)');
define('ACT_INV_HIST','Invoice History (Most Recent %s Results)');
define('ACT_SO_NUMBER','SO Number');
define('ACT_PO_NUMBER','PO Number');
define('ACT_INV_NUMBER','Invoice Number');
define('ACT_NO_RESULTS','No Results Found');
define('ACT_PAYMENT_MESSAGE','Enter the payment information to be stored in PhreeBooks.');
define('ACT_PAYMENT_CREDIT_CARD_NUMBER','Credit Card Number');
define('ACT_PAYMENT_CREDIT_CARD_EXPIRES','Credit Card Expiration Date');
define('ACT_PAYMENT_CREDIT_CARD_CVV2','Security Code');
define('AR_CONTACT_STATUS','Customer Status');
define('AP_CONTACT_STATUS','Vendor Status');

// Account Terms (used in several modules)
define('ACT_SPECIAL_TERMS','Special Terms');
define('ACT_TERMS_DUE','Terms (Due)');
define('ACT_TERMS_DEFAULT','Default: ');
define('ACT_TERMS_USE_DEFAULTS', 'Use Default Terms');
define('ACT_COD_SHORT','COD');
define('ACT_COD_LONG','Cash On Delivery');
define('ACT_PREPAID','Prepaid');
define('ACT_SPECIAL_TERMS', 'Due in number of days');
define('ACT_END_OF_MONTH','Due end of month');
define('ACT_DAY_NEXT_MONTH','Due on specified date');
define('ACT_DUE_ON', 'Due on: ');
define('ACT_DISCOUNT', 'Discount ');
define('ACT_EARLY_DISCOUNT', ' percent. ');
define('ACT_EARLY_DISCOUNT_SHORT', '% ');
define('ACT_DUE_IN','Due in ');
define('ACT_TERMS_EARLY_DAYS', ' day(s). ');
define('ACT_TERMS_NET','Net ');
define('ACT_TERMS_STANDARD_DAYS', ' day(s). ');
define('ACT_TERMS_CREDIT_LIMIT', 'Credit limit: ');
define('ACT_AMT_PAST_DUE','Amount Past Due: ');
define('ACT_GOOD_STANDING','Account in Good Standing');
define('ACT_OVER_CREDIT_LIMIT','Account is Over Credit Limit');
define('ACT_HAS_PAST_DUE_AMOUNT','Account has Past Due Balance');

// Account table fields - common to all account types
define('ACT_POPUP_WINDOW_TITLE', 'Account Search');
define('ACT_POPUP_TERMS_WINDOW_TITLE', 'Payment Terms');

// misc information messages
define('ACT_WARN_DELETE_ADDRESS','Are you sure you want to delete this address?');
define('ACT_WARN_DELETE_ACCOUNT', 'Are you sure you want to delete this account?');
define('ACT_WARN_DELETE_PAYMENT', 'Are you sure you want to delete this payment record?');
define('ACT_ERROR_CANNOT_DELETE','Cannot delete this account because a journal record contains this account');
define('ACT_ERROR_DUPLICATE_ACCOUNT','The account ID already exists in the system, please enter a new id.');
define('ACT_ERROR_NO_ACCOUNT_ID','When adding a new Customer/Vendor, the ID field is required, please enter an unique id.');
define('ACT_ERROR_ACCOUNT_NOT_FOUND','The account you are looking for could not be found!');
define('ACT_BILLING_MESSAGE','These fields are not required unless a billing address is being added.');
define('ACT_SHIPPING_MESSAGE','These fields are not required unless a shipping address is being added.');
define('ACT_NO_ENCRYPT_KEY_ENTERED','CAUTION: The encryption key has not been entered. Stored credit card information will not be displayed and values entered here will not be saved!');
define('ACT_PAYMENT_REF','Payment Ref');
define('ACT_LIST_OPEN_ORDERS','Open Orders');
define('ACT_LIST_OPEN_INVOICES','Open Invoices');
define('ACT_CARDHOLDER_NAME','Cardholder Name');
define('ACT_CARD_HINT','Card Hint');
define('ACT_EXP','Exp');

define('ACT_NO_KEY_EXISTS','A payment was specified but the encryption key has not been entered. The payment address was saved but the payment information was not.');

// java script errors
define('ACT_JS_SHORT_NAME', '* The \'ID\' entry cannot be blank.\n');

// Audit log messages
define('ACT_LOG_ADD_ACCOUNT','Added account - ');
define('ACT_LOG_UPDATE_ACCOUNT','Updated account - ');
define('ACT_LOG_DELETE_ACCOUNT','Deleted account - ');

//default actions
define('ACT_ACTION_OPEN','Open');

?>