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
//  Path: /modules/reportwriter/ajax/load_email_msg.php
//

/**************   Check user security   *****************************/
// None

/**************  include page specific files    *********************/
require(DIR_FS_MODULES . 'reportwriter/language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'reportwriter/functions/generator_functions.php');

/**************   page specific initialization  *************************/
$rID = $_GET['rID'];
if (!$rID) die;

$result       = $db->Execute("select description from " . TABLE_REPORTS . " where id = '" . $rID . "'");
$report_title = $result->fields['description'];

$result       = $db->Execute("select params from " . TABLE_REPORT_FIELDS . " where entrytype = 'pagelist' and reportid = '" . $rID . "'");
$Prefs        = unserialize($result->fields['params']);
if (!$Prefs['email_msg']) {
  $msg = sprintf(RW_EMAIL_BODY, $report_title, COMPANY_NAME);
} else {
  $msg = TextReplace($Prefs['email_msg']);
}

$xml  = '';
$xml .= "\t" . xmlEntry("msg", $msg);

// error check

//put it all together
$str  = createXmlHeader('emailMsg');
$str .= $xml;
$str .= createXmlFooter();

echo $str;
die;
?>