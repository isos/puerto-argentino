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
//  Path: /modules/banking/ajax/acct_balance.php
//

/**************   Check user security   *****************************/
// None

/**************  include page specific files    *********************/
require(DIR_FS_MODULES . 'banking/functions/banking.php');

/**************   page specific initialization  *************************/
$gl_acct_id = ($_GET['gl_acct_id']) ? db_prepare_input($_GET['gl_acct_id']) : AP_PURCHASE_INVOICE_ACCOUNT;
$post_date =  ($_GET['post_date'])  ? gen_db_date_short($_GET['post_date']) : date('Y-m-d', time());
$period = gen_calculate_period($post_date);
if (!$period) { // bad post_date was submitted
  $post_date = date('Y-m-d', time());
  $period = 0;
}

$xml = xmlEntry("value", load_cash_acct_balance($post_date, $gl_acct_id, $period));
// error check

//put it all together
$str  = createXmlHeader('acctbal');
$str .= $xml;
$str .= createXmlFooter();

echo $str;
die;
?>