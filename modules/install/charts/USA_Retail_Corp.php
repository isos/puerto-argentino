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
//  Path: /modules/install/charts/USA_Retail_Corp.php
//

// Chart of Accounts for USA simple retail
$chart_description = "US - Retail store simple Chart of Accounts (Corporations, S Corporations)";
$chart_array = array();

$chart_array[] = array("1000","Cash","0");
$chart_array[] = array("1020","Checking Account","0");
$chart_array[] = array("1100","Accounts Receivable","2");
$chart_array[] = array("1150","Allowance for Doubtful Debt","2");
$chart_array[] = array("1200","Inventory","4");
$chart_array[] = array("1400","Prepaid Expenses","6");
$chart_array[] = array("1500","Property and Equipment","8");
$chart_array[] = array("1900","Accum. depreciation - Prop and","10");
$chart_array[] = array("2000","Accounts Payable","20");
$chart_array[] = array("2310","Sales Tax Payable","22");
$chart_array[] = array("2312","City Tax Payable","22");
$chart_array[] = array("2314","County Tax Payable","22");
$chart_array[] = array("2316","State Tax Payable","22");
$chart_array[] = array("2320","Deductons Payable","22");
$chart_array[] = array("2330","Federal Payroll Taxes Payable","22");
$chart_array[] = array("2340","FUTA Payable","22");
$chart_array[] = array("2350","State Payroll Taxes Payable","22");
$chart_array[] = array("2360","SUTA Payable","22");
$chart_array[] = array("2370","Local Taxes Payable","22");
$chart_array[] = array("2380","Income Taxes Payable","22");
$chart_array[] = array("2400","Customer Deposits","22");
$chart_array[] = array("2500","Current Portion Long-Term Debt","22");
$chart_array[] = array("2700","Long Term Debt - Noncurrent","22");
$chart_array[] = array("3100","Common Stock","40");
$chart_array[] = array("3200","Paid In Capital","40");
$chart_array[] = array("3500","Dividends Paid","42");
$chart_array[] = array("3800","Retained Earnings","44");
$chart_array[] = array("4000","Sales Income","30");
$chart_array[] = array("4100","Interest Income","30");
$chart_array[] = array("4200","Finance Charge Income","30");
$chart_array[] = array("4300","Other Income","30");
$chart_array[] = array("4900","Sales Discounts","30");
$chart_array[] = array("5000","Cost of Sales","32");
$chart_array[] = array("5100","Cost of Sales - Freight","32");
$chart_array[] = array("5400","Cost of Sales - Salary & Wage","32");
$chart_array[] = array("5900","Inventory Adjustments","32");
$chart_array[] = array("6000","Wages Expense","34");
$chart_array[] = array("6050","Employee Benefit Programs Expe","34");
$chart_array[] = array("6100","Payroll Tax Expense","34");
$chart_array[] = array("6150","Bad Debt Expense","34");
$chart_array[] = array("6200","Income Tax Expense","34");
$chart_array[] = array("6250","Other Taxes Expense","34");
$chart_array[] = array("6300","Rent or Lease Expense","34");
$chart_array[] = array("6350","Maintenance & Repairs Expense","34");
$chart_array[] = array("6400","Utilities Expense","34");
$chart_array[] = array("6450","Office Supplies Expense","34");
$chart_array[] = array("6500","Telephone Expense","34");
$chart_array[] = array("6550","Other Office Expense","34");
$chart_array[] = array("6600","Advertising Expense","34");
$chart_array[] = array("6650","Commissions & Fees Expense","34");
$chart_array[] = array("6700","Franchise Fees Expense","34");
$chart_array[] = array("6750","Equipment Rental Expense","34");
$chart_array[] = array("6800","Freight Expense","34");
$chart_array[] = array("6850","Service Charge Expense","34");
$chart_array[] = array("6900","Purchase Discount Expense","34");
$chart_array[] = array("6950","Insurance Expense","34");
$chart_array[] = array("7000","Over and Short Expense","34");
$chart_array[] = array("7050","Depreciation Expense","34");
$chart_array[] = array("7100","Gain/Loss - Sale of Assets Exp","34");

?>