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
//  Path: /modules/install/language/en_us/chart_setup.php
//

  define('SAVE_STORE_SETTINGS', 'Save Chart of Account Settings'); //this comes before TEXT_MAIN
  define('TEXT_MAIN', "This section of the PhreeBooks&trade; setup tool will help you set up your company chart of accounts.  PhreeBooks includes several sample chart of accounts for you to choose from. You will be able to change any of these settings later using the General Ledger menu.  Please select a chart of accounts type and press <em>".SAVE_STORE_SETTINGS.'</em> to continue.<br /><br />NOTE: IF you plan to install the demo data, use the chart titled \'US - Retail store simple Chart of Accounts\' to assure the cost accounts align properly. Failure to do so will require the customer/vendor accounts and inventory charge accounts to be corrected with the proper gl accounts.');
  define('TEXT_PAGE_HEADING', 'PhreeBooks&trade; Setup - Chart of Accounts Setup');
  define('STORE_INFORMATION', 'Chart of Accounts Information');
  define('STORE_VIEW_COA_DETAILS','View Chart Details');

  define('STORE_DEFAULT_COA', 'Available Chart of Accounts');
  define('STORE_DEFAULT_COA_INSTRUCTION', 'Choose the template that you would like for your default chart of accounts. Accounts may be added or deleted later through the General Journal menu.');
?>