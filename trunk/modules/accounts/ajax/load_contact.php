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
//  Path: /modules/accounts/ajax/load_contact.php
//

$function_name = 'fillContact'; // javascript return function name

/**************   Check user security   *****************************/
$xml = NULL;
$security_level = (int)$_SESSION['admin_id']; // for ajax, just make sure they are logged in
if ($security_level == 0) { // no permission to enter page, return error
  echo createXmlHeader($function_name) . xmlEntry('error', ERROR_NO_PERMISSION) . createXmlFooter();
  die;
}

/**************  include page specific files    *********************/
require(DIR_FS_MODULES . 'accounts/language/' . $_SESSION['language'] . '/language.php');

/**************   page specific initialization  *************************/
$cID   = db_prepare_input($_GET['cID']);
$error = false;


  // select the customer and build the contact record
$contact    = $db->Execute("select * from " . TABLE_CONTACTS . " where id = '" . $cID . "'");
$type       = $contact->fields['type'];
$terms_type = ($type == 'c') ? 'AR' : 'AP';
$contact->fields['terms_text'] = gen_terms_to_language($contact->fields['special_terms'], true, $terms_type);
$contact->fields['ship_gl_acct_id'] = ($type == 'v') ? AP_DEF_FREIGHT_ACCT : AR_DEF_FREIGHT_ACCT;
$bill_add   = $db->Execute("select * from " . TABLE_ADDRESS_BOOK . " 
  where ref_id = '" . $cID . "' and type in ('" . $type . "m', '" . $type . "b')");
//fix some special fields
if (!$contact->fields['dept_rep_id']) unset($contact->fields['dept_rep_id']); // clear the rep field if not set to a contact
$ship_add = $db->Execute("select * from " . TABLE_ADDRESS_BOOK . " 
  where ref_id = '" . $cID . "' and type in ('" . $type . "m', '" . $type . "s')");

// build the form data
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
$str  = createXmlHeader($function_name);
$str .= $xml;
$str .= createXmlFooter();
echo $str;
die;
?>