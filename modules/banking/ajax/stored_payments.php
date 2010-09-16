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
//  Path: /modules/banking/ajax/stored_payments.php
//

$function_name = 'contactPmt'; // javascript return function name

/**************   Check user security   *****************************/
$security_level = (int)$_SESSION['admin_id']; // for ajax, just make sure they are logged in
if ($security_level == 0) { // no permission to enter page, return error
  echo createXmlHeader($function_name) . xmlEntry('error', ERROR_NO_PERMISSION) . createXmlFooter();
  die;
}

/**************  include page specific files    *********************/
require(DIR_FS_MODULES . 'banking/language/' . $_SESSION['language'] . '/language.php');
require_once(DIR_FS_MODULES . 'general/classes/encryption.php');

/**************   page specific initialization  *************************/
$contact_id = db_prepare_input($_GET['contact_id']);
$xml = NULL;

$enc_data = new encryption();
$sql = "select id, hint, enc_value from " . TABLE_DATA_SECURITY . " 
	where module = 'contacts' and ref_1 = " . $contact_id;
$result = $db->Execute($sql);
while (!$result->EOF) {
	$data = $enc_data->decrypt($_SESSION['admin_encrypt'], $result->fields['enc_value']);
	$fields = explode(':', $data);
	$xml .= "\t<payments>\n";
	$xml .= "\t\t" . xmlEntry("id",   $result->fields['id']);
	$xml .= "\t\t" . xmlEntry("name", $fields[0]); // will be the name field for credit cards
	$xml .= "\t\t" . xmlEntry("hint", $result->fields['hint']);
	for ($i = 0; $i < sizeof($fields); $i++) {
		$xml .= "\t\t" . xmlEntry("field_" . $i, $fields[$i]);
	}
	$xml .= "\t</payments>\n";
	$result->MoveNext();
}
// error check
if (!$_SESSION['admin_encrypt'] && $result->RecordCount() > 0) { // no permission to enter page, return error
  echo createXmlHeader($function_name) . xmlEntry('error', BNK_ERROR_NO_ENCRYPT_KEY) . createXmlFooter();
  die;
}

//put it all together
$str  = createXmlHeader($function_name);
$str .= $xml;
$str .= createXmlFooter();

echo $str;
die;
?>