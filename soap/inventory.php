<?
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
//  Path: /soap/inventory.php
//

require_once('application_top.php');

require_once('language/' . LANGUAGE . '/language.php');
//require_once(DIR_FS_MODULES . 'gen_ledger/language/' . LANGUAGE . '/language.php');

require_once('classes/parser.php');
require_once('classes/inventory.php'); // soap required classes

//require_once(DIR_FS_MODULES . 'orders/functions/orders.php');
//require_once(DIR_FS_MODULES . 'orders/classes/orders.php');

/*
$rawpost = urldecode(file_get_contents("php://input")); // retrieve the XML raw string
*/

/* This tests the received XML string and puts it into a file to examine. For DEBUG only.
	$filename = "samples/ExampleInventory.xml";
	if (!$fp = fopen($filename, 'w')) {
		echo 'Error: File cannot be opened.';
		exit();
	}
	fwrite ($fp, $rawpost);
	fclose($fp);
	// reply something back to requestor
	echo 'Received file ok.';
	exit();
*/

/* This will allow local execution, gets file from disk, tests parser. For DEBUG only.
*/
	$filename = "samples/ExampleInventory.xml";
	if (!$fp = fopen($filename, 'r')) {
		echo 'Error: File cannot be opened.';
		exit();
	}
	$rawpost = fread ($fp, 8192);
	fclose($fp);
	$temp = new xml_inventory();
	$temp->parse($sample);
	echo 'Parsed XML String = '; print_r($temp->arrOutput); echo '<br />';
/*
*/

// Start processing the received string
$invItem = new xml_inventory();
$invItem->processXML($rawpost);

require_once('application_bottom.php');
?>