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
//  Path: /modules/install/language/en_us/fiscal_setup.php
//

  define('SAVE_STORE_SETTINGS', 'Save Fiscal Year Settings'); //this comes before TEXT_MAIN
  define('SKIP_STORE_SETTINGS', 'Fiscal Year Exists - Skip'); //this comes before TEXT_MAIN
  define('TEXT_MAIN', "This section of the PhreeBooks&trade; setup tool will help you set up your company's fiscal year. You will be able to change any of these settings later using the General Ledger menu.  Please make your selections and press <em>".SAVE_STORE_SETTINGS."</em> to continue. If a fiscal year already exists in the db, the button <em>".SKIP_STORE_SETTINGS."</em> will appear instead. Press this button to bypass this step.");
  define('TEXT_FISCAL_YEAR_EXISTS','Fiscal years from <b>%d</b> to <b>%d</b> are already in the database, Please press <em>' . SKIP_STORE_SETTINGS . '</em> to continue.');
  define('TEXT_PAGE_HEADING', 'PhreeBooks&trade; Setup - Fiscal Year Setup');
  define('STORE_INFORMATION', 'Fiscal Year Information');

  define('STORE_DEFAULT_PERIOD', 'First Accounting Period');
  define('STORE_DEFAULT_PERIOD_INSTRUCTION', 'Select a starting month to set as your first accounting period. PhreeBooks will initially set the start at the first day of the selected month as period 1.');

  define('STORE_DEFAULT_FY', 'Fiscal Year');
  define('STORE_DEFAULT_FY_INSTRUCTION', 'Select a starting year to set as your first fiscal year. The month selected above and this year selection will be the earliest date that journal entries can be made.');

  define('TEXT_JAN','January');
  define('TEXT_FEB','February');
  define('TEXT_MAR','March');
  define('TEXT_APR','April');
  define('TEXT_MAY','May');
  define('TEXT_JUN','June');
  define('TEXT_JUL','July');
  define('TEXT_AUG','August');
  define('TEXT_SEP','September');
  define('TEXT_OCT','October');
  define('TEXT_NOV','November');
  define('TEXT_DEC','December');
  
  $period_values = array();
  $period_values[] = array('id' => '01', 'text' => TEXT_JAN);
  $period_values[] = array('id' => '02', 'text' => TEXT_FEB);
  $period_values[] = array('id' => '03', 'text' => TEXT_MAR);
  $period_values[] = array('id' => '04', 'text' => TEXT_APR);
  $period_values[] = array('id' => '05', 'text' => TEXT_MAY);
  $period_values[] = array('id' => '06', 'text' => TEXT_JUN);
  $period_values[] = array('id' => '07', 'text' => TEXT_JUL);
  $period_values[] = array('id' => '08', 'text' => TEXT_AUG);
  $period_values[] = array('id' => '09', 'text' => TEXT_SEP);
  $period_values[] = array('id' => '10', 'text' => TEXT_OCT);
  $period_values[] = array('id' => '11', 'text' => TEXT_NOV);
  $period_values[] = array('id' => '12', 'text' => TEXT_DEC);

  $fiscal_years = array();
  $fiscal_years[] = array('id' => '2005', 'text' => '2005');
  $fiscal_years[] = array('id' => '2006', 'text' => '2006');
  $fiscal_years[] = array('id' => '2007', 'text' => '2007');
  $fiscal_years[] = array('id' => '2008', 'text' => '2008');
  $fiscal_years[] = array('id' => '2009', 'text' => '2009');
  $fiscal_years[] = array('id' => '2010', 'text' => '2010');
  $fiscal_years[] = array('id' => '2011', 'text' => '2011');
  $fiscal_years[] = array('id' => '2012', 'text' => '2012');
  $fiscal_years[] = array('id' => '2013', 'text' => '2013');
  $fiscal_years[] = array('id' => '2014', 'text' => '2014');
  $fiscal_years[] = array('id' => '2015', 'text' => '2015');
  $fiscal_years[] = array('id' => '2016', 'text' => '2016');
  $fiscal_years[] = array('id' => '2017', 'text' => '2017');
  $fiscal_years[] = array('id' => '2018', 'text' => '2018');
?>