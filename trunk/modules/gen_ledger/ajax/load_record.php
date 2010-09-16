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
//  Path: /modules/gen_ledger/ajax/load_record.php
//

$function_name = 'loadRecord'; // javascript return function name
/**************   Check user security   *****************************/
$xml = NULL;
$security_level = (int)$_SESSION['admin_id']; // for ajax, just make sure they are logged in
if ($security_level == 0) { // no permission to enter page, return error
  echo createXmlHeader($function_name) . xmlEntry('error', ERROR_NO_PERMISSION) . createXmlFooter();
  die;
}
/**************   include page specific files   *********************/
/**************   page specific initialization  *********************/
$rID   = db_prepare_input($_GET['rID']);
$error = false;
$main  = $db->Execute("select * from " . TABLE_JOURNAL_MAIN . " where id = '" . $rID . "'");
if ($main->RecordCount() <> 1) {
  echo createXmlHeader($function_name) . xmlEntry('error', 'Bad record submitted. No results found!') . createXmlFooter();
  die;
}
$items = $db->Execute("select * from " . TABLE_JOURNAL_ITEM . " where ref_id = '" . $rID . "'");
// build the journal record data
foreach ($main->fields as $key => $value) $xml .= "\t" . xmlEntry($key, $value);
while (!$items->EOF) {
  $xml .= "\t<items>\n";
  foreach ($items->fields as $key => $value) $xml .= "\t\t" . xmlEntry($key, $value);
  $xml .= "\t</items>\n";
  $items->MoveNext();
}

//put it all together
echo createXmlHeader($function_name) . $xml . createXmlFooter();
die;
?>