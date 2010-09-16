<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2010 PhreeSoft, LLC                               |
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
//  Path: /modules/zencart/functions/zencart.php
//

if (!function_exists('write_config')) {
  function write_config($filename, $data) {
    global $messageStack;
	$lines = array();
	$lines[] = '<?php' . "\n";
	$lines[] = '/* config.php - last updated ' . date('Y-m-d') . ' */' . "\n";
  	foreach ($data as $key => $value) {
	  $lines[] = "define('" . $key . "','" . addslashes($value) . "');" . "\n";
	}
	$lines[] = '?>' . "\n";
	$line = implode('', $lines);
	if (!$handle = @fopen($filename, 'w')) {
	  $messageStack->add(sprintf(ZENCART_CANNOT_WRITE_CONFIG, $filename), 'error');
	  return false;
	}
	fwrite($handle, $line);
	fclose($handle);
	return true;
  }
}

function pull_down_price_sheet_list() {
  global $db;
  $output = array(array('id' => '0', 'text' => TEXT_NONE));
  $sql = "select distinct sheet_name from " . TABLE_PRICE_SHEETS . " 
	where '" . date('Y-m-d',time()) . "' >= effective_date and inactive = '0'";
  $result = $db->Execute($sql);
  while(!$result->EOF) {
    $output[] = array('id' => $result->fields['sheet_name'], 'text' => $result->fields['sheet_name']);
    $result->MoveNext();
  }
  return $output;
}

?>