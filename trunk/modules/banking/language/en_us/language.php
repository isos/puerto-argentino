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
//  Path: /modules/banking/language/en_us/language.php
//

// **************  Release 1.9 changes  ********************
define('BNK_ERROR_NO_ENCRYPT_KEY', 'There is payment information stored but the encryption key has not been set!');

// **************  Release 1.9 changes  ********************
define('BNK_DEP_20_V_WINDOW_TITLE', 'Vendor Deposits');
define('BNK_20_ENTER_DEPOSIT','Enter Vendor Deposit');

// **************  Release 1.8 changes  ********************
define('BNK_DEP_18_C_WINDOW_TITLE', 'Customer Deposits');
define('BNK_18_ENTER_DEPOSIT','Enter Customer Deposit');

// **************  Release 1.7 and earlier  ********************
// general
define('BNK_CASH_ACCOUNT','Cash Account');
define('BNK_DISCOUNT_ACCOUNT','Discount Account');
define('BNK_AMOUNT_DUE','Amount Due');
define('BNK_DUE_DATE','Due Date');
define('BNK_INVOICE_NUM','Invoice #');
define('BNK_TEXT_CHECK_ALL','Check All');
define('BNK_TEXT_DEPOSIT_ID','Deposit Ticket ID');
define('BNK_TEXT_PAYMENT_ID','Payment Ref #');
define('BNK_TEXT_WITHDRAWAL','Withdrawal');
define('BNK_TEXT_SAVE_PAYMENT_INFO','Save Payment Information ');

define('BNK_REPOST_PAYMENT','The payment record was re-posted, this may duplicate the previous payment with the processor!');
define('TEXT_CCVAL_ERROR_INVALID_DATE', 'The expiration date entered for the credit card is invalid. Please check the date and try again.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'The credit card number entered is invalid. Please check the number and try again.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'The credit card number starting with %s was not entered correctly, or we do not accept that kind of card. Please try again or use another credit card.');
define('BNK_BULK_PAY_NOT_POSITIVE','The payment to vendor: %s was skipped because the total payment amount was less than or equal to zero!');
define('BNK_PAYMENT_NOT_SAVED','Save Payment Information box was checked but the ecryption key is not present. The receipt was processed but the payment information was not saved!');

// Audit Log Messages
define('BNK_LOG_ACCT_RECON','Account Reconciliation, period: ');

// Cash receipts specific definitions
define('BNK_18_ERROR_NO_VENDOR','No Customer was selected!');
define('BNK_18_ENTER_BILLS','Enter Cash Receipts');
define('BNK_18_DELETE_BILLS','Delete Cash Receipts');
define('BNK_18_C_WINDOW_TITLE','Customer Receipts');
define('BNK_18_V_WINDOW_TITLE','Vendor Receipts');
define('BNK_18_BILL_TO','Receive From:');
define('BNK_18_POST_SUCCESSFUL','Successfully posted receipt # ');
define('BNK_18_POST_DELETED','Successfully deleted receipt # ');
define('BNK_18_AMOUNT_PAID','Amt Rcvd');
define('BNK_18_DELETE_ALERT','Are you sure you want to delete this receipt?');
define('BNK_18_NEGATIVE_TOTAL','The receipt amount cannot be less than zero!');

/*
// Point of Sale specific definitions
define('BNK_19_ERROR_NO_VENDOR','No Customer was selected!');
define('BNK_19_ENTER_BILLS','Enter Point of Sale Payments');
define('BNK_19_DELETE_BILLS','Delete Point of Sale Receipts');
define('BNK_19_WINDOW_TITLE','Receipts');
define('BNK_19_BILL_TO','Receive From:');
define('BNK_19_POST_SUCCESSFUL','Successfully posted receipt # ');
define('BNK_19_POST_DELETED','Successfully deleted receipt # ');
define('BNK_19_AMOUNT_PAID','Amt Rcvd');
define('BNK_19_DELETE_ALERT','Are you sure you want to delete this receipt?');
*/
// Cash Distribution specific definitions
define('BNK_20_ERROR_NO_VENDOR','No vendor was selected!');
define('BNK_20_ENTER_BILLS','Enter Cash Disbursements');
define('BNK_20_DELETE_BILLS','Delete Cash Disbursements');
define('BNK_20_V_WINDOW_TITLE','Vendor Payments');
define('BNK_20_C_WINDOW_TITLE','Customer Payments');
define('BNK_20_BILL_TO','Pay To:');
define('BNK_20_POST_SUCCESSFUL','Successfully posted payment # ');
define('BNK_20_POST_DELETED','Successfully deleted payment # ');
define('BNK_20_AMOUNT_PAID','Amt Paid');
define('BNK_20_DELETE_ALERT','Are you sure you want to delete this payment?');
define('BNK_20_NEGATIVE_TOTAL','The payment amount cannot be less than zero!');
/*
// Point of Purchase (Write Checks) specific definitions
define('BNK_21_ERROR_NO_VENDOR','No vendor was selected!');
define('BNK_21_ENTER_BILLS','Enter Point of Purchase Payment');
define('BNK_21_DELETE_BILLS','Delete Point of Purchase Payment');
define('BNK_21_WINDOW_TITLE','Payments');
define('BNK_21_BILL_TO','Pay To:');
define('BNK_21_POST_SUCCESSFUL','Successfully posted payment # ');
define('BNK_21_POST_DELETED','Successfully deleted payment # ');
define('BNK_21_AMOUNT_PAID','Amt Paid');
define('BNK_21_DELETE_ALERT','Are you sure you want to delete this payment?');
*/

// bulk pay bills
define('BNK_CHECK_DATE','Check Date');
define('BNK_TEXT_FIRST_CHECK_NUM','First Check Number');
define('BNK_TOTAL_TO_BE_PAID','Total of All Payments');
define('BNK_INVOICES_DUE_BY','Invoices Due By');
define('BNK_DISCOUNT_LOST_BY','Discounts Lost By');
define('BNK_INVOICE_DATE','Invoice Date');
define('BNK_VENDOR_NAME','Vendor Name');
define('BNK_ACCOUNT_BALANCE','Balance Before Payments');
define('BNK_BALANCE_AFTER_CHECKS','Balance After Payments');

// account reconciliation
define('BANKING_HEADING_RECONCILIATION','Account Reconciliation');
define('BNK_START_BALANCE','Statement Ending Balance');
define('BNK_OPEN_CHECKS','- Outstanding Checks');
define('BNK_OPEN_DEPOSITS','+ Deposits in Transit');
define('BNK_GL_BALANCE','- GL Account Balance');
define('BNK_END_BALANCE','Unreconciled Difference');
define('BNK_DEPOSIT_CREDIT','Deposit/Credit');
define('BNK_CHECK_PAYMENT','Check/Payment');
define('TEXT_MULTIPLE_DEPOSITS','Customer Deposits');
define('TEXT_MULTIPLE_PAYMENTS','Vendor Payments');
define('TEXT_CASH_ACCOUNT','Cash Account');
define('BNK_ERROR_PERIOD_NOT_ALL','Accounting period selected cannot be \'all\' for account reconciliation operation.');
define('BNK_RECON_POST_SUCCESS','Successfully saved changes.');

// Bank account register
define('BANKING_HEADING_REGISTER','Cash Account Register');
define('TEXT_BEGINNING_BALANCE','Beginning Balance');
define('TEXT_ENDING_BALANCE','Ending Balance');
define('TEXT_DEPOSIT','Deposit');

// Cvv stuff for credit cards
define('HEADING_CVV', 'What is CVV?');
define('TEXT_CVV_HELP1', 'Visa, Mastercard, Discover 3 Digit Card Verification Number<br /><br />
                    For your safety and security, we require that you enter your card\'s verification number.<br /><br />
                    The verification number is a 3-digit number printed on the back of your card.
                    It appears after and to the right of your card number.<br />' .
                    html_image(DIR_WS_IMAGES . 'cvv2visa.gif'));

define('TEXT_CVV_HELP2', 'American Express 4 Digit Card Verification Number<br /><br />
                    For your safety and security, we require that you enter your card\'s verification number.<br /><br />
                    The American Express verification number is a 4-digit number printed on the front of your card.
                    It appears after and to the right of your card number.<br />' .
                    html_image(DIR_WS_IMAGES . 'cvv2amex.gif'));
?>