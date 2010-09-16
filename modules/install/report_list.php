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
//  Path: /modules/install/report_list.php
//

/* This file holds the list of reports to import during setup. */
$report_list = array();

// Receivables Reports and Forms
$report_list[] = 'AgedReceivables.rpt.txt';
$report_list[] = 'CreditMemo.rpt.txt';
$report_list[] = 'CustomerInvoiceHistory.rpt.txt';
$report_list[] = 'CustomerList.rpt.txt';
$report_list[] = 'CustomerPayments.rpt.txt';
$report_list[] = 'CustomerQuotes.rpt.txt';
$report_list[] = 'Invoice.rpt.txt';
$report_list[] = 'OpenSalesOrders.rpt.txt';
$report_list[] = 'PackingSlip.rpt.txt';
$report_list[] = 'SalesOrder.rpt.txt';
$report_list[] = 'SalesReport.rpt.txt';

// Payables Reports and Forms
$report_list[] = 'OpenPurchaseOrders.rpt.txt';
$report_list[] = 'PurchaseOrder.rpt.txt';
$report_list[] = 'PODeliveryDates.rpt.txt';
$report_list[] = 'RequestforQuote.rpt.txt';
$report_list[] = 'VendorList.rpt.txt';
$report_list[] = 'VendorPayments.rpt.txt';

// Inventory Reports and Forms
$report_list[] = 'AssemblyItemList.rpt.txt';
$report_list[] = 'InventoryList.rpt.txt';
$report_list[] = 'InventoryRe-orderWorksheet.rpt.txt';

// Human Resources Reports and Forms
$report_list[] = 'EmployeeList.rpt.txt';

// Manufacturing Reports and Forms

// General Ledger Reports and Forms
$report_list[] = 'BalanceSheet.rpt.txt';
$report_list[] = 'ChartofAccounts.rpt.txt';
$report_list[] = 'GeneralLedger.rpt.txt';
$report_list[] = 'GeneralLedgerTrialBalance.rpt.txt';
$report_list[] = 'IncomeStatement.rpt.txt';

// Banking Reports and Forms
$report_list[] = 'BankCheck-ThreePart.rpt.txt';
$report_list[] = 'DepositSlip.rpt.txt';

// Miscellaneous Reports and Forms
$report_list[] = 'AuditLog.rpt.txt';

?>