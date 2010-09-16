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
//  Path: /modules/banking/ajax/load_searches.php
//

$function_name = 'fillGuess'; // javascript return function name

/**************   Check user security   *****************************/
$error = false;
$xml   = NULL;

$security_level = (int)$_SESSION['admin_id']; // for ajax, just make sure they are logged in
if ($security_level == 0) { // no permission to enter page, return error
  echo createXmlHeader($function_name) . xmlEntry('error', ERROR_NO_PERMISSION) . createXmlFooter();
  die;
}

/**************  include page specific files    *********************/
require(DIR_FS_MODULES . 'accounts/language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'banking/functions/banking.php');

/**************   page specific initialization  *************************/
$search_text = db_prepare_input($_GET['guess']);
$type        = db_prepare_input($_GET['type']);
$bID         = 0;
// select the customer and build the contact record
if (isset($search_text) && gen_not_null($search_text)) {
  $search_fields = array('a.primary_name', 'a.contact', 'a.telephone1', 'a.telephone2', 'a.address1', 
	'a.address2', 'a.city_town', 'a.postal_code', 'c.short_name');
  $search = ' and (' . implode(' like \'%' . $search_text . '%\' or ', $search_fields) . ' like \'%' . $search_text . '%\')';
} else {
  echo createXmlHeader($function_name) . xmlEntry('result', 'fail') . createXmlFooter();
  die;
}

$query_raw = "select c.id from " . TABLE_CONTACTS . " c left join " . TABLE_ADDRESS_BOOK . " a on c.id = a.ref_id 
	where a.type = '" . $type . "m'" . $search . " limit 2";
$result = $db->Execute($query_raw);
if ($result->RecordCount() <> 1) {
  echo createXmlHeader($function_name) . xmlEntry('result', 'fail') . createXmlFooter();
  die;
}
$cID = $result->fields['id'];

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
$bill_add = $db->Execute("select * from " . TABLE_ADDRESS_BOOK . " 
  where ref_id = '" . $cID . "' and type in ('" . $type . "m', '" . $type . "b')");

// fetch the line items
$invoices  = fill_paid_invoice_array($bID, $cID, $type);
$item_list = $invoices['invoices'];
if (sizeof($item_list) == 0) {
  echo createXmlHeader($function_name) . xmlEntry('result', 'fail') . createXmlFooter();
  die;
}

// some adjustments based on what we are doing
$bill->fields['payment_fields'] = $invoices['payment_fields'];
$bill->fields['post_date']      = gen_spiffycal_db_date_short($bill->fields['post_date']);

// build the form data

$xml .= xmlEntry('result', 'success');
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