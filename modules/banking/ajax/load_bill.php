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
//  Path: /modules/banking/ajax/load_bill.php
//

$function_name = 'fillBill'; // javascript return function name

/**************   Check user security   *****************************/
$xml = NULL;
$security_level = (int)$_SESSION['admin_id']; // for ajax, just make sure they are logged in
if ($security_level == 0) { // no permission to enter page, return error
  echo createXmlHeader($function_name) . xmlEntry('error', ERROR_NO_PERMISSION) . createXmlFooter();
  die;
}

/**************  include page specific files    *********************/
require(DIR_FS_MODULES . 'accounts/language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'banking/functions/banking.php');

/**************   page specific initialization  *************************/
$cID = db_prepare_input($_GET['cID']); // contact record ID
$bID = db_prepare_input($_GET['bID']); // journal record ID
$jID = db_prepare_input($_GET['jID']); // journal ID

define('JOURNAL_ID',$jID);
$error = false;

switch (JOURNAL_ID) {
  case 18: break;
  case 20: break;
  default:
}

if ($bID) {
  $bill = $db->Execute("select * from " . TABLE_JOURNAL_MAIN . " where id = '" . $bID . "'");
  if ($bill->fields['bill_acct_id']) $cID = $bill->fields['bill_acct_id']; // replace bID with ID from payment
} else {
  $bill = new objectInfo();
}
// select the customer and build the contact record
$contact = $db->Execute("select * from " . TABLE_CONTACTS . " where id = '" . $cID . "'");
$type = $contact->fields['type'];
define('ACCOUNT_TYPE', $type);
$bill_add  = $db->Execute("select * from " . TABLE_ADDRESS_BOOK . " 
  where ref_id = '" . $cID . "' and type in ('" . $type . "m', '" . $type . "b')");

// fetch the line items
$invoices  = fill_paid_invoice_array($bID, $cID, $type);
$item_list = $invoices['invoices'];

// some adjustments based on what we are doing
$bill->fields['payment_fields'] = $invoices['payment_fields'];
$bill->fields['post_date']      = gen_spiffycal_db_date_short($bill->fields['post_date']);

// build the form data
if ($contact->fields) {
  $xml .= "\t<contact>\n";
  foreach ($contact->fields as $key => $value) $xml .= "\t\t" . xmlEntry($key, $value);
  $xml .= "\t</contact>\n";
}
if ($bill_add->fields) while (!$bill_add->EOF) {
  $xml .= "\t<billaddress>\n";
  foreach ($bill_add->fields as $key => $value) $xml .= "\t\t" . xmlEntry($key, $value);
  $xml .= "\t</billaddress>\n";
  $bill_add->MoveNext();
}

if ($bill->fields) { // there was an bill to open
  $xml .= "\t<bill>\n";
  foreach ($bill->fields as $key => $value) $xml .= "\t\t" . xmlEntry($key, $value);
  $xml .= "\t</bill>\n";
}
foreach ($item_list as $item) { // there should always be invoices to pull
  $xml .= "\t<items>\n";
  foreach ($item as $key => $value) $xml .= "\t\t" . xmlEntry($key, $value);
  $xml .= "\t</items>\n";
}

//put it all together
$str  = createXmlHeader($function_name);
$str .= $xml;
$str .= createXmlFooter();
echo $str;
die;
?>