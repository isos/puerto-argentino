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
//  Path: /modules/install/charts/USA_General.php
//

// Chart of Accounts for USA simple General company
$chart_description = "US - General store simple Chart of Accounts (LLC and Partnerships)";
$chart_array = array();

$chart_array[] = array('1060','Checking Account','0');
$chart_array[] = array('1065','Petty Cash','0');
$chart_array[] = array('1200','Accounts Receivables','2');
$chart_array[] = array('1205','Allowance for doubtful accounts','2');
$chart_array[] = array('1500','Inventory','4');
$chart_array[] = array('1800','Capital assets','8');
$chart_array[] = array('1820','Office Furniture & Equipment','8');
$chart_array[] = array('1825','Accum. Amort. - Furn. & Equip.','8');
$chart_array[] = array('1840','Vehicle','8');
$chart_array[] = array('1845','Accum. Amort. - Vehicle','8');
$chart_array[] = array('2100','Accounts Payable','20');
$chart_array[] = array('2110','Accrued Income Tax - Federal','22');
$chart_array[] = array('2120','Accrued Income Tax - State','22');
$chart_array[] = array('2130','Accrued Franchise Tax','22');
$chart_array[] = array('2140','Accrued Real & Personal Prop Tax','22');
$chart_array[] = array('2150','Sales Tax','22');
$chart_array[] = array('2160','Accrued Use Tax Payable','22');
$chart_array[] = array('2210','Accrued Wages','22');
$chart_array[] = array('2220','Accrued Comp Time','22');
$chart_array[] = array('2230','Accrued Holiday Pay','22');
$chart_array[] = array('2240','Accrued Vacation Pay','22');
$chart_array[] = array('2310','Accr. Benefits - 401K','22');
$chart_array[] = array('2320','Accr. Benefits - Stock Purchase','22');
$chart_array[] = array('2330','Accr. Benefits - Med, Den','22');
$chart_array[] = array('2340','Accr. Benefits - Payroll Taxes','22');
$chart_array[] = array('2350','Accr. Benefits - Credit Union','22');
$chart_array[] = array('2360','Accr. Benefits - Savings Bond','22');
$chart_array[] = array('2370','Accr. Benefits - Garnish','22');
$chart_array[] = array('2380','Accr. Benefits - Charity Cont.','22');
$chart_array[] = array('2620','Bank Loans','24');
$chart_array[] = array("3400","Owners Contribution","42");
$chart_array[] = array("3600","Owners Draw","42");
$chart_array[] = array("3800","Retained Earnings","44");
$chart_array[] = array('4010','Sales','30');
$chart_array[] = array('4400','Other Revenue','30');
$chart_array[] = array('4430','Shipping & Handling','30');
$chart_array[] = array('4440','Interest','30');
$chart_array[] = array('4450','Foreign Exchange Gain','30');
$chart_array[] = array('5010','Cost of Goods Sold','32');
$chart_array[] = array('5100','Freight','32');
$chart_array[] = array('5400','Payroll Expenses','34');
$chart_array[] = array('5410','Wages & Salaries','34');
$chart_array[] = array('5420','Wages - Overtime','34');
$chart_array[] = array('5430','Benefits - Comp Time','34');
$chart_array[] = array('5440','Benefits - Payroll Taxes','34');
$chart_array[] = array('5450','Benefits - Workers Comp','34');
$chart_array[] = array('5460','Benefits - 401K','34');
$chart_array[] = array('5470','Benefits - General Benefits','34');
$chart_array[] = array('5510','Inc Tax Exp - Federal','34');
$chart_array[] = array('5520','Inc Tax Exp - State','34');
$chart_array[] = array('5530','Taxes - Real Estate','34');
$chart_array[] = array('5540','Taxes - Personal Property','34');
$chart_array[] = array('5550','Taxes - Franchise','34');
$chart_array[] = array('5560','Taxes - Foreign Withholding','34');
$chart_array[] = array('5600','General & Administrative Expenses','34');
$chart_array[] = array('5610','Accounting & Legal','34');
$chart_array[] = array('5615','Advertising & Promotions','34');
$chart_array[] = array('5620','Bad Debts','34');
$chart_array[] = array('5660','Amortization Expense','34');
$chart_array[] = array('5685','Insurance','34');
$chart_array[] = array('5690','Interest & Bank Charges','34');
$chart_array[] = array('5700','Office Supplies','34');
$chart_array[] = array('5760','Rent','34');
$chart_array[] = array('5765','Repair & Maintenance','34');
$chart_array[] = array('5780','Telephone','34');
$chart_array[] = array('5785','Travel & Entertainment','34');
$chart_array[] = array('5790','Utilities','34');
$chart_array[] = array('5795','Registrations','34');
$chart_array[] = array('5800','Licenses','34');
$chart_array[] = array('5810','Foreign Exchange Loss','34');

?>