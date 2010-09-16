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
//  Path: /modules/orders/language/en_us/language.php
//

/********************* Release R2.1 additions ***********************/
define('TEXT_SAVE_OPEN_PREVIOUS','Save - Open Previous Invoice');
define('TEXT_SAVE_OPEN_NEXT','Save - Open Next Invoice');
define('ORD_WARN_FORM_MODIFIED','There appears to be data in this form already. Do you want to search for an existing contact?');

/********************* Release R2.0 additions ***********************/
define('ORD_ERROR_NOT_CUR_PERIOD','Your permissions prevent you from posting to a period other than the current period!');
define('ORD_ERROR_DEL_NOT_CUR_PERIOD','Your permissions prevent you from deleting an order from a period other than the current period!');

/********************* Release R1.9 additions ***********************/
define('ORD_DISCOUNT_GL_ACCT','Discount GL Account');
define('ORD_FREIGHT_GL_ACCT','Freight GL Account');
define('ORD_INV_STOCK_LOW','Not enough stock on hand of this item.');
define('ORD_INV_STOCK_BAL','The number of units in stock is: ');
define('ORD_INV_OPEN_POS','The following open POs are in the system:');
define('ORD_INV_STOCK_STATUS','Store: %s PO: %s Qty: %s Due: %s');
define('ORD_JS_SKU_NOT_UNIQUE','No unique matches for this sku could be found. Either the SKU search field resulted in multiple matches or no matches were found.');
define('ORD_JS_NO_CID','The contact information must be loaded into this form before the properties can be retrieved.');

/********************* Release R1.7 additions ***********************/
define('POPUP_BAR_CODE_TITLE','Bar Code Entry');
define('ORD_BAR_CODE_INTRO','Enter the quantity and scan the item.');
define('TEXT_UPC_CODE','Bar Code');

/********************************************************************/
// General
define('ORD_ADD_UPDATE', 'Add/Update');
define('ORD_AP_ACCOUNT', 'A/P Account');
define('ORD_AR_ACCOUNT', 'A/R Account');
define('ORD_CASH_ACCOUNT', 'Cash Account');
define('ORD_CLOSED','Closed?');
define('ORD_COPY_BILL','Copy -->');
define('ORD_CUSTOMER_NAME','Customer Name');
define('ORD_DELETE_ALERT','Are you sure you want to delete this order?');
define('ORD_DELIVERY_DATES', 'Delivery Dates');
define('ORD_DISCOUNT_PERCENT','Discount Percent (%)');
define('ORD_DROP_SHIP', 'Drop Ship');
define('ORD_EXPECTED_DATES','Expected Delivery Dates - ');
define('ORD_FREIGHT', 'Freight');
define('ORD_FREIGHT_ESTIMATE', 'Freight Estimate');
define('ORD_FREIGHT_SERVICE', 'Service');
define('ORD_INVOICE_TOTAL', 'Invoice Total');
define('ORD_MANUAL_ENTRY', 'Manual Entry');
define('ORD_NA','N/A');
define('ORD_NEW_DELIVERY_DATES', 'New Delivery Dates');
define('ORD_PAID', 'Paid');
define('ORD_PURCHASE_TAX', 'Purchase Tax');
define('ORD_ROW_DELETE_ALERT','Are you sure you want to delete this row?');
define('ORD_SALES_TAX', 'Sales Tax');
define('ORD_SHIP_CARRIER', 'Carrier');
define('ORD_SHIP_TO', 'Ship to:');
define('ORD_SHIPPED', 'Shipped');
define('ORD_SUBTOTAL', 'Subtotal');
define('ORD_TAX_RATE', 'Tax Rate');
define('ORD_TAXABLE', 'Taxable');
define('ORD_VENDOR_NAME','Vendor Name');
define('ORD_VOID_SHIP','Void Shipment');
define('ORD_WAITING_FOR_INVOICE','Waiting for Invoice');
define('ORD_WAITING','Waiting?');
define('ORD_SO_INV_MESSAGE','Leave the Sales Order or Invoice Number blank to let the system assign a number.');
define('ORD_CONVERT_TO_SO_INV','Convert to SO/Invoice');
define('ORD_CONVERT_TO_SO','Convert to SO ');
define('ORD_CONVERT_TO_INV','Convert to Invoice ');
define('ORD_PO_MESSAGE','Leave the Purchase Order number blank to let the system assign a number.');
define('ORD_CONVERT_TO_SO_INV','Convert to Sales Order/Invoice');
define('ORD_CONVERT_TO_PO','Auto Generate Purchase Order ');

// Javascript Messages
define('ORD_JS_RECUR_NO_INVOICE','For a recurring transaction, a starting invoice number needs to be entered. PhreeBooks will increment it for each recurring entry.');
define('ORD_JS_RECUR_ROLL_REQD','This is a recurring entry. Do you want to update future entries as well? (Press Cancel to update only this entry)');
define('ORD_JS_RECUR_DEL_ROLL_REQD','This is a recurring entry. Do you want to delete future entries as well? (Press Cancel to delete only this entry)');
define('ORD_JS_WAITING_FOR_PAYMENT','Either Waiting for Invoice needs to be checked or an invoice number needs to be entered.');
define('ORD_JS_SERIAL_NUM_PROMPT','Enter the serial number for this line item. NOTE: The quantiy must be 1 for serialized items.');
define('ORD_JS_NO_STOCK_A','Caution! There is not enough of item SKU ');
define('ORD_JS_NO_STOCK_B',' in stock to fill the order.\nThe number of items in stock is: ');
define('ORD_JS_NO_STOCK_C','\n\nPress OK to continue or Cancel to return to the order form.');
define('ORD_JS_INACTIVE_A','Caution! SKU: ');
define('ORD_JS_INACTIVE_B',' is an inactive item.\n\nPress OK to continue or Cancel to return to the order form');
define('ORD_JS_CANNOT_CONVERT_QUOTE','An un-Posted Sales Quote cannot be converted to Sales Order or a Sales/Invoice!');
define('ORD_JS_CANNOT_CONVERT_SO','An un-Posted Sales Order cannot be converted to a Purchase Order!');

// Audit log messages
define('ORD_DELIVERY_DATES','PO/SO Delivery Dates - ');

// Recur Transactions
define('ORD_RECUR_INTRO','This transaction can be duplicated in the future by selecting the number of entries to be created and the frequency for which they are posted. The current entry is considered the first recurrence.');
define('ORD_RECUR_ENTRIES','Enter the number of entries to create');
define('ORD_RECUR_FREQUENCY','How often to post entries');
define('ORD_TEXT_WEEKLY','Weekly');
define('ORD_TEXT_BIWEEKLY','Bi-Weekly');
define('ORD_TEXT_MONTHLY','Monthy');
define('ORD_TEXT_QUARTERLY','Quarterly');
define('ORD_TEXT_YEARLY','Yearly');
define('ORD_PAST_LAST_PERIOD','The posted transaction cannot recur past the last period in the system!');

// Tooltips
define('ORD_TT_PURCH_INV_NUM','If you leave this field blank, Phreebooks will automatically assign a number.');

// Purchase Quote Specific
define('ORD_TEXT_3_BILL_TO', 'Remit to:');
define('ORD_TEXT_3_REF_NUM', 'Reference #');
define('ORD_TEXT_3_WINDOW_TITLE','Request For Quote');
define('ORD_TEXT_3_EXPIRES', 'Expiration Date');
define('ORD_TEXT_3_NUMBER', 'Quote Number');
define('ORD_TEXT_3_TEXT_REP', 'Buyer');
define('ORD_TEXT_3_ITEM_COLUMN_1','Qty');
define('ORD_TEXT_3_ITEM_COLUMN_2','Rcvd');
define('ORD_TEXT_3_ERROR_NO_VENDOR','No vendor was selected! Either select a vendor from the popup menu or enter the information and select: ' . ORD_ADD_UPDATE);
define('ORD_TEXT_3_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'vendor quotes');
define('ORD_TEXT_3_CLOSED_TEXT',TEXT_CLOSE);

// Purchase Order Specific
define('ORD_TEXT_4_BILL_TO', 'Remit to:');
define('ORD_TEXT_4_REF_NUM', 'Reference #');
define('ORD_TEXT_4_WINDOW_TITLE','Purchase Order');
define('ORD_TEXT_4_EXPIRES', 'Expiration Date');
define('ORD_TEXT_4_NUMBER', 'PO Number');
define('ORD_TEXT_4_TEXT_REP', 'Buyer');
define('ORD_TEXT_4_ITEM_COLUMN_1','Qty');
define('ORD_TEXT_4_ITEM_COLUMN_2','Rcvd');
define('ORD_TEXT_4_ERROR_NO_VENDOR','No vendor was selected! Either select a vendor from the popup menu or enter the information and select: ' . ORD_ADD_UPDATE);
define('ORD_TEXT_4_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'purchase orders');
define('ORD_TEXT_4_CLOSED_TEXT',TEXT_CLOSE);

// Purchase/Receive Specific
define('ORD_TEXT_6_BILL_TO', 'Remit to:');
define('ORD_TEXT_6_REF_NUM', 'Reference #');
define('ORD_TEXT_6_WINDOW_TITLE','Purchase/Receive Inventory');
define('ORD_TEXT_6_ERROR_NO_VENDOR','No vendor was selected! Either select a vendor from the popup menu or enter the information and select: ' . ORD_ADD_UPDATE);
define('ORD_TEXT_6_NUMBER', 'Invoice Number');
define('ORD_TEXT_6_TEXT_REP', 'Buyer');
define('ORD_TEXT_6_ITEM_COLUMN_1','PO Bal');
define('ORD_TEXT_6_ITEM_COLUMN_2','Rcvd');
define('ORD_TEXT_6_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'item receipts');
define('ORD_TEXT_6_CLOSED_TEXT','Invoice Paid');

// Vendor Credit Memo Specific
define('ORD_TEXT_7_BILL_TO', 'Remit to:');
define('ORD_TEXT_7_REF_NUM', 'Reference #');
define('ORD_TEXT_7_WINDOW_TITLE','Vendor Credit Memo');
define('ORD_TEXT_7_ERROR_NO_VENDOR','No vendor was selected! Either select a vendor from the popup menu or enter the information and select: ' . ORD_ADD_UPDATE);
define('ORD_TEXT_7_NUMBER', 'Credit Memo Number');
define('ORD_TEXT_7_TEXT_REP', 'Buyer');
define('ORD_TEXT_7_ITEM_COLUMN_1','Received');
define('ORD_TEXT_7_ITEM_COLUMN_2','Returned');
define('ORD_TEXT_7_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'vendor invoices');
define('ORD_TEXT_7_CLOSED_TEXT','Credit Taken');

// Customer Quote Specific
define('ORD_TEXT_9_BILL_TO', 'Bill to:');
define('ORD_TEXT_9_REF_NUM', 'Purchase Order #');
define('ORD_TEXT_9_WINDOW_TITLE','Customer Quote');
define('ORD_TEXT_9_EXPIRES', 'Expiration Date');
define('ORD_TEXT_9_NUMBER', 'Quote Number');
define('ORD_TEXT_9_TEXT_REP', 'Sales Rep');
define('ORD_TEXT_9_ITEM_COLUMN_1','Qty');
define('ORD_TEXT_9_ITEM_COLUMN_2','Invoiced');
define('ORD_TEXT_9_ERROR_NO_VENDOR','No customer was selected! Either select a customer from the popup menu or enter the information and select: ' . ORD_ADD_UPDATE);
define('ORD_TEXT_9_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'customer quotes');
define('ORD_TEXT_9_CLOSED_TEXT',TEXT_CLOSE);

// Sales Order Specific
define('ORD_TEXT_10_BILL_TO', 'Bill to:');
define('ORD_TEXT_10_REF_NUM', 'Purchase Order #');
define('ORD_TEXT_10_WINDOW_TITLE','Sales Order');
define('ORD_TEXT_10_EXPIRES', 'Ship By Date');
define('ORD_TEXT_10_NUMBER', 'SO Number');
define('ORD_TEXT_10_TEXT_REP', 'Sales Rep');
define('ORD_TEXT_10_ITEM_COLUMN_1','Qty');
define('ORD_TEXT_10_ITEM_COLUMN_2','Invoiced');
define('ORD_TEXT_10_ERROR_NO_VENDOR','No customer was selected! Either select a customer from the popup menu or enter the information and select: ' . ORD_ADD_UPDATE);
define('ORD_TEXT_10_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'sales orders');
define('ORD_TEXT_10_CLOSED_TEXT',TEXT_CLOSE);

// Sales/Invoice Specific
define('ORD_TEXT_12_BILL_TO', 'Bill to:');
define('ORD_TEXT_12_REF_NUM', 'Purchase Order #');
define('ORD_TEXT_12_WINDOW_TITLE','Sales/Invoice');
define('ORD_TEXT_12_EXPIRES', 'Ship By Date');
define('ORD_TEXT_12_ERROR_NO_VENDOR','No customer was selected!');
define('ORD_TEXT_12_NUMBER', 'Invoice Number');
define('ORD_TEXT_12_TEXT_REP', 'Sales Rep');
define('ORD_TEXT_12_ITEM_COLUMN_1','SO Bal');
define('ORD_TEXT_12_ITEM_COLUMN_2','Qty');
define('ORD_TEXT_12_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'invoices');
define('ORD_TEXT_12_CLOSED_TEXT','Paid in Full');

// Customer Credit Memo Specific
define('ORD_TEXT_13_BILL_TO', 'Bill to:');
define('ORD_TEXT_13_REF_NUM', 'Reference');
define('ORD_TEXT_13_WINDOW_TITLE','Customer Credit Memo');
define('ORD_TEXT_13_EXPIRES', 'Ship By Date');
define('ORD_TEXT_13_ERROR_NO_VENDOR','No customer was selected!');
define('ORD_TEXT_13_NUMBER', 'Credit Memo Number');
define('ORD_TEXT_13_TEXT_REP', 'Sales Rep');
define('ORD_TEXT_13_ITEM_COLUMN_1','Shipped');
define('ORD_TEXT_13_ITEM_COLUMN_2','Returned');
define('ORD_TEXT_13_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'invoices');
define('ORD_TEXT_13_CLOSED_TEXT','Credit Paid');

/*
// Cash Receipts Specific
define('ORD_TEXT_18_BILL_TO', 'Sale to:');
define('ORD_TEXT_18_REF_NUM', 'Purchase Order #');
define('ORD_TEXT_18_WINDOW_TITLE','Cash Receipts');
define('ORD_TEXT_18_EXPIRES', 'Ship By Date');
define('ORD_TEXT_18_ERROR_NO_VENDOR','No customer was selected!');
define('ORD_TEXT_18_NUMBER', 'Receipt Number');
define('ORD_TEXT_18_TEXT_REP', 'Sales Rep');
define('ORD_TEXT_18_ITEM_COLUMN_1','SO Bal');
define('ORD_TEXT_18_ITEM_COLUMN_2','Qty');
define('ORD_TEXT_18_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'receipts');
*/
// Point of Sale Specific
define('ORD_TEXT_19_BILL_TO', 'Sale to:');
define('ORD_TEXT_19_REF_NUM', 'Purchase Order #');
define('ORD_TEXT_19_WINDOW_TITLE','Point of Sale');
define('ORD_TEXT_19_EXPIRES', 'Ship By Date');
define('ORD_TEXT_19_ERROR_NO_VENDOR','No customer was selected!');
define('ORD_TEXT_19_NUMBER', 'Receipt Number');
define('ORD_TEXT_19_TEXT_REP', 'Sales Rep');
define('ORD_TEXT_19_ITEM_COLUMN_1','SO Bal');
define('ORD_TEXT_19_ITEM_COLUMN_2','Qty');
define('ORD_TEXT_19_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'sales');
define('ORD_TEXT_19_CLOSED_TEXT','Paid in Full');
/*
// Cash Distribution Journal
define('ORD_TEXT_20_BILL_TO', 'Remit to:');
define('ORD_TEXT_20_REF_NUM', 'Reference #');
define('ORD_TEXT_20_WINDOW_TITLE','Cash Distribution');
define('ORD_TEXT_20_ERROR_NO_VENDOR','No vendor was selected! Either select a vendor from the popup menu or enter the information and select: ' . ORD_ADD_UPDATE);
define('ORD_TEXT_20_NUMBER', 'Payment Number');
define('ORD_TEXT_20_TEXT_REP', 'Buyer');
define('ORD_TEXT_20_ITEM_COLUMN_1','PO Bal');
define('ORD_TEXT_20_ITEM_COLUMN_2','Rcvd');
define('ORD_TEXT_20_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'payments');
*/
// Direct Inventory Purchase/Receive (Checks)
define('ORD_TEXT_21_BILL_TO', 'Remit to:');
define('ORD_TEXT_21_REF_NUM', 'Reference #');
define('ORD_TEXT_21_WINDOW_TITLE','Direct Purchase');
define('ORD_TEXT_21_ERROR_NO_VENDOR','No vendor was selected! Either select a vendor from the popup menu or enter the information and select: ' . ORD_ADD_UPDATE);
define('ORD_TEXT_21_NUMBER', 'Payment Number');
define('ORD_TEXT_21_TEXT_REP', 'Buyer');
define('ORD_TEXT_21_ITEM_COLUMN_1','PO Bal');
define('ORD_TEXT_21_ITEM_COLUMN_2','Rcvd');
define('ORD_TEXT_21_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'payments');
define('ORD_TEXT_21_CLOSED_TEXT','Paid in Full');

// popup specific
define('ORD_POPUP_WINDOW_TITLE_3', 'Vendor Quotes');
define('ORD_POPUP_WINDOW_TITLE_4', 'Purchase Orders');
define('ORD_POPUP_WINDOW_TITLE_6', 'Purchase/Receive Inventory');
define('ORD_POPUP_WINDOW_TITLE_7', 'Vendor Credit Memo');
define('ORD_POPUP_WINDOW_TITLE_9', 'Request for Quote');
define('ORD_POPUP_WINDOW_TITLE_10', 'Sales Orders');
define('ORD_POPUP_WINDOW_TITLE_12', 'Sales/Invoices');
define('ORD_POPUP_WINDOW_TITLE_13', 'Credit Memo');
define('ORD_POPUP_WINDOW_TITLE_19', 'Point of Sale');
define('ORD_POPUP_WINDOW_TITLE_21', 'Inventory Direct Purchase');

// recur specific
define('ORD_RECUR_WINDOW_TITLE_2', 'Recur General Journal Entries');
define('ORD_RECUR_WINDOW_TITLE_3', 'Recur Vendor Quotes');
define('ORD_RECUR_WINDOW_TITLE_4', 'Recur Purchase Orders');
define('ORD_RECUR_WINDOW_TITLE_6', 'Recur Purchase/Receive Inventory');
define('ORD_RECUR_WINDOW_TITLE_7', 'Recur Vendor Credit Memo');
define('ORD_RECUR_WINDOW_TITLE_9', 'Recur Request for Quote');
define('ORD_RECUR_WINDOW_TITLE_10', 'Recur Sales Orders');
define('ORD_RECUR_WINDOW_TITLE_12', 'Recur Sales/Invoices');
define('ORD_RECUR_WINDOW_TITLE_13', 'Recur Credit Memo');
define('ORD_RECUR_WINDOW_TITLE_19', 'Recur Point of Sale');
define('ORD_RECUR_WINDOW_TITLE_21', 'Recur Inventory Direct Purchase');

define('ORD_HEADING_NUMBER_3', 'Quote Number');
define('ORD_HEADING_NUMBER_4', 'PO Number');
define('ORD_HEADING_NUMBER_6', 'Invoice #');
define('ORD_HEADING_NUMBER_7', 'Credit Memo Number');
define('ORD_HEADING_NUMBER_9', 'Quote Number');
define('ORD_HEADING_NUMBER_10', 'SO Number');
define('ORD_HEADING_NUMBER_12', 'Invoice #');
define('ORD_HEADING_NUMBER_13', 'Credit Memo Number');
define('ORD_HEADING_NUMBER_19', 'Receipt Number');
define('ORD_HEADING_NUMBER_21', 'Payment Number');

define('ORD_HEADING_STATUS_3', ORD_CLOSED);
define('ORD_HEADING_STATUS_4', ORD_CLOSED);
define('ORD_HEADING_STATUS_6', ORD_WAITING);
define('ORD_HEADING_STATUS_7', ORD_WAITING);
define('ORD_HEADING_STATUS_9', ORD_CLOSED);
define('ORD_HEADING_STATUS_10', ORD_CLOSED);
define('ORD_HEADING_STATUS_12', TEXT_PAID);
define('ORD_HEADING_STATUS_13', TEXT_PAID);
define('ORD_HEADING_STATUS_19', ORD_CLOSED);
define('ORD_HEADING_STATUS_21', ORD_CLOSED);

define('ORD_HEADING_NAME_3',ORD_VENDOR_NAME);
define('ORD_HEADING_NAME_4',ORD_VENDOR_NAME);
define('ORD_HEADING_NAME_6',ORD_VENDOR_NAME);
define('ORD_HEADING_NAME_7',ORD_VENDOR_NAME);
define('ORD_HEADING_NAME_9',ORD_CUSTOMER_NAME);
define('ORD_HEADING_NAME_10',ORD_CUSTOMER_NAME);
define('ORD_HEADING_NAME_12',ORD_CUSTOMER_NAME);
define('ORD_HEADING_NAME_13',ORD_CUSTOMER_NAME);
define('ORD_HEADING_NAME_19',ORD_CUSTOMER_NAME);
define('ORD_HEADING_NAME_21',ORD_VENDOR_NAME);
?>