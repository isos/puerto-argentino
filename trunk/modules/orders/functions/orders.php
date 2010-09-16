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
//  Path: /modules/orders/functions/orders.php
//

  function ord_calculate_tax_drop_down($type = 'c') {
    global $db;
	$tax_auth_array = gen_build_tax_auth_array();
    $sql = "select tax_rate_id, description_short, rate_accounts from " . TABLE_TAX_RATES;
	switch ($type) {
	  default:
	  case 'c':
	  case 'v': $sql .= " where type = '" . $type . "'"; break;
	  case 'b': // both
	}
	$tax_rates = $db->Execute($sql);
    $tax_rate_drop_down = array();
    $tax_rate_drop_down[] = array('id' => '0', 'rate' => '0', 'text' => TEXT_NONE, 'auths' => '');
	while (!$tax_rates->EOF) {
	  $tax_rate_drop_down[] = array(
	    'id'    => $tax_rates->fields['tax_rate_id'],
		'rate'  => gen_calculate_tax_rate($tax_rates->fields['rate_accounts'], $tax_auth_array), 
		'text'  => $tax_rates->fields['description_short'],
		'auths' => $tax_rates->fields['rate_accounts'],
	  );
	  $tax_rates->MoveNext();
	}
	return $tax_rate_drop_down;
  }

////
  function ord_get_shipping_carriers_array() {
    $result_array = array();
    $result_array[] = array('id' => '', 'text' => TEXT_NONE);
	$shipping_carriers = explode(';', MODULE_SHIPPING_INSTALLED);
	sort($shipping_carriers);
	for($i=0; $i<count($shipping_carriers); $i++) {
		$carrier = substr($shipping_carriers[$i], 0, strpos($shipping_carriers[$i], '.'));
		$title = defined('MODULE_SHIPPING_' . strtoupper($carrier) . '_TITLE') ? constant('MODULE_SHIPPING_' . strtoupper($carrier) . '_TITLE') : $carrier;
 		$result_array[] = array('id' => $carrier, 'text' => $title);
	}
    return $result_array;
  }

////
  function ord_get_shipping_service_array() {
  	global $shipping_defaults;
    $result_array = array();
    $result_array[] = array('id' => '', 'text' => TEXT_NONE);
	foreach($shipping_defaults['service_levels'] as $key=>$value) {
 		$result_array[] = array('id' => $key, 'text' => $value);
	}
    return $result_array;
  }

  function ord_get_so_po_num($id = '') {
	global $db;
	$result = $db->Execute("select purchase_invoice_id from " . TABLE_JOURNAL_MAIN . " where id = " . $id);
	return ($result->RecordCount()) ? $result->fields['purchase_invoice_id'] : '';
  }

  function ord_get_shipping_methods() {
    global $shipping_defaults;

	$directory_array  = array();
	// load standard shipping methods
	$module_directory = DIR_FS_MODULES . 'services/shipping/';
	if ($dir = @dir($module_directory . 'modules')) {
	  while ($file = $dir->read()) {
		if (!is_dir($module_directory . 'modules/' . $file)) {
		  if (substr($file, strrpos($file, '.')) == '.php') {
			$class = substr($file, 0, strrpos($file, '.'));
			if (@constant('MODULE_SHIPPING_' . strtoupper($class) . '_STATUS')) { 
			  $directory_array[$class] = array(
			  	'path'  => $module_directory,
			  	'file'  => $file,
			  );
			}
		  }
		}
	  }
	  $dir->close();
	}
	// now custom shipping methods
	$module_directory = DIR_FS_MY_FILES . 'custom/services/shipping/';
	if ($dir = @dir($module_directory . 'modules')) {
	  while ($file = $dir->read()) {
		if (!is_dir($module_directory . 'modules/' . $file)) {
		  if (substr($file, strrpos($file, '.')) == '.php') {
			$class = substr($file, 0, strrpos($file, '.'));
			if (@constant('MODULE_SHIPPING_' . strtoupper($class) . '_STATUS')) { 
			  $directory_array[$class] = array(
			  	'path'  => $module_directory,
			  	'file'  => $file,
			  );
			}
		  }
		}
	  }
	  $dir->close();
	}
	ksort($directory_array);

	$choices = array_keys($shipping_defaults['service_levels']);
	$service_levels = 'var freightLevels = new Array(' . sizeof($choices) . '); ' . chr(10);
	for ($i = 0; $i < sizeof($choices); $i++) {
	  $service_levels .= "freightLevels[" . $i . "]='" . $choices[$i] . "'; " . chr(10);
	}
	$carriers        = 'var freightCarriers = new Array(' . sizeof($directory_array) . '); ' . chr(10);
	$carrier_details = 'var freightDetails = new Array('  . sizeof($directory_array) . '); ' . chr(10);
	$i = 0;
	if (sizeof($directory_array) > 0) {
	  foreach ($directory_array as $class => $details) {
		$carriers .= "freightCarriers[" . $i . "]='" . $class . "';" . chr(10);
		include_once($details['path'] . 'language/' . $_SESSION['language'] . '/modules/' . $details['file']);
		include_once($details['path'] . 'modules/' . $details['file']);
		$carrier_details .= 'freightDetails[' . $i . '] = new Array(' . sizeof($choices) . '); ' . chr(10);
		for ($j = 0; $j < sizeof($choices); $j++) {
		  $carrier_details .= "freightDetails[" . $i . "][" . $j . "]='" . (defined($class . '_' . $choices[$j]) ? constant($class . '_' . $choices[$j]) : "") . "'; " . chr(10);
		}
	    $i++;
	  }
	}
	return $service_levels . $carriers . $carrier_details;
  }

  function ord_get_projects() {
    global $db;
    $result_array = array();
    $result_array[] = array('id' => '', 'text' => TEXT_NONE);
	// fetch cost structure
	$costs = array();
	$result = $db->Execute("select cost_id, description_short from " . TABLE_PROJECTS_COSTS . " where inactive = '0'");
	while(!$result->EOF) {
	  $costs[$result->fields['cost_id']] = $result->fields['description_short'];
	  $result->MoveNext();
	}
	// fetch phase structure
	$phases = array();
	$result = $db->Execute("select phase_id, description_short, cost_breakdown from " . TABLE_PROJECTS_PHASES . " where inactive = '0'");
	while(!$result->EOF) {
	  $phases[$result->fields['phase_id']] = array(
	  	'text'   => $result->fields['description_short'],
		'detail' => $result->fields['cost_breakdown'],
	  );
	  $result->MoveNext();
	}
	// fetch projects
	$result = $db->Execute("select id, short_name, account_number from " . TABLE_CONTACTS . " where type = 'j' and inactive <> '1'");
	while(!$result->EOF) {
	  $base_id   = $result->fields['id'];
	  $base_text = $result->fields['short_name'];
	  if ($result->fields['account_number'] == '1' && sizeof($phases) > 0) { // use phases
		foreach ($phases as $phase_id => $phase) {
		  $phase_base = $base_id   . ':' . $phase_id;
		  $phase_text = $base_text . ' -> ' . $phase['text'];
		  if ($phase['detail'] == '1' && sizeof($costs) > 0) {
		    foreach ($costs as $cost_id => $cost) {
              $result_array[] = array('id' => $phase_base . ':' . $cost_id, 'text' => $phase_text . ' -> ' . $cost);
			}
		  } else {
            $result_array[] = array('id' => $phase_base, 'text' => $phase_text);
		  }
		}
	  } else {
        $result_array[] = array('id' => $base_id, 'text' => $base_text);
	  }
	  $result->MoveNext();
	}
    return $result_array;
  }

?>