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
//  Path: /modules/gen_ledger/ajax/load_gl_data.php
//

$function_name = 'loadAccount'; // javascript return function name
/**************   Check user security   *****************************/
$xml = NULL;
$security_level = (int)$_SESSION['admin_id']; // for ajax, just make sure they are logged in
if ($security_level == 0) { // no permission to enter page, return error
  echo createXmlHeader($function_name) . xmlEntry('error', ERROR_NO_PERMISSION) . createXmlFooter();
  die;
}
/**************   include page specific files   *********************/
require(DIR_FS_MODULES . 'gen_ledger/language/' . $_SESSION['language'] . '/language.php');

/**************   page specific initialization  *********************/
$gl_acct = db_prepare_input($_GET['glAcct']);
$fy      = db_prepare_input($_GET['fy']);
$error   = false;
$result  = $db->Execute("select period, start_date, end_date from " . TABLE_ACCOUNTING_PERIODS . " 
	where fiscal_year = '" . ($fy - 1) . "' order by period");
if ($result->RecordCount() == 0) { // no earlier data found
  echo createXmlHeader($function_name) . xmlEntry('error', ERROR_NO_GL_ACCT_INFO) . createXmlFooter();
  die;
}
$periods = array();
while (!$result->EOF) {
  $periods[] = $result->fields['period'];
  $result->MoveNext();
}
$result = $db->Execute("select debit_amount - credit_amount as balance from " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " 
	where account_id = '" . $gl_acct . "' and period in (" . implode(',', $periods) . ")");
while (!$result->EOF) {
  $xml .= "\t<items>\n";
  $xml .= "\t\t" . xmlEntry('balance', $currencies->format($result->fields['balance']));
  $xml .= "\t</items>\n";
  $result->MoveNext();
}

//put it all together
echo createXmlHeader($function_name) . $xml . createXmlFooter();
die;
?>