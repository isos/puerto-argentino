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
//  Path: /modules/orders/ajax/load_searches.php
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
require(DIR_FS_MODULES . 'accounts/functions/accounts.php');

/**************   page specific initialization  *************************/
$search_text = db_prepare_input($_GET['guess']);
$type        = db_prepare_input($_GET['type']);
$jID         = db_prepare_input($_GET['jID']);

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

switch ($jID) {
  case  6: $search_journal = 4;  break;
  case  7: $search_journal = 6;  break;
  case 12: $search_journal = 10; break;
  case 13: $search_journal = 12; break;
  default: $search_journal = false;
}
if ($search_journal) {
  if ($open_order_array = load_open_orders($cID, $search_journal)) {
	echo createXmlHeader($function_name) . xmlEntry('result', 'fail') . createXmlFooter();
	die;
  }
}

$contact    = $db->Execute("select * from " . TABLE_CONTACTS . " where id = '" . $cID . "'");
$terms_type = ($type == 'v') ? 'AP' : 'AR';
$contact->fields['terms_text'] = gen_terms_to_language($contact->fields['special_terms'], true, $terms_type);
$contact->fields['ship_gl_acct_id'] = ($type == 'v') ? AP_DEF_FREIGHT_ACCT : AR_DEF_FREIGHT_ACCT;
$bill_add   = $db->Execute("select * from " . TABLE_ADDRESS_BOOK . " 
  where ref_id = '" . $cID . "' and type in ('" . $type . "m', '" . $type . "b')");
//fix some special fields
if (!$contact->fields['dept_rep_id']) unset($contact->fields['dept_rep_id']); // clear the rep field if not set to a contact

$ship_add = $db->Execute("select * from " . TABLE_ADDRESS_BOOK . " 
  where ref_id = '" . $cID . "' and type in ('" . $type . "m', '" . $type . "s')");

// build the form data
$xml .= xmlEntry('result', 'success');
if ($contact->fields) {
  $xml .= "\t<contact>\n";
  foreach ($contact->fields as $key => $value) $xml .= "\t" . xmlEntry($key, $value);
  $xml .= "\t</contact>\n";
}
if ($bill_add->fields) while (!$bill_add->EOF) {
  $xml .= "\t<billaddress>\n";
  foreach ($bill_add->fields as $key => $value) $xml .= "\t" . xmlEntry($key, $value);
  $xml .= "\t</billaddress>\n";
  $bill_add->MoveNext();
}
if (ENABLE_SHIPPING_FUNCTIONS && $ship_add->fields) while (!$ship_add->EOF) {
  $xml .= "\t<shipaddress>\n";
  foreach ($ship_add->fields as $key => $value) $xml .= "\t" . xmlEntry($key, $value);
  $xml .= "\t</shipaddress>\n";
  $ship_add->MoveNext();
}

//put it all together
echo createXmlHeader($function_name) . $xml . createXmlFooter();
die;
?>