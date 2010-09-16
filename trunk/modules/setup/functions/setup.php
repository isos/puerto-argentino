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
//  Path: /modules/setup/functions/setup.php
//

  function setup_call_function($function, $parameter, $object = '') {
	if (!$function) return;
    if ($object == '') {
      return call_user_func($function, $parameter);
    } elseif (PHP_VERSION < 4) {
      return call_user_method($function, $object, $parameter);
    } else {
      return call_user_func(array($object, $function), $parameter);
    }
  }

////
  function setup_get_country_zones($country_id) {
    global $db;
    $zones_array = array();
    $zones = $db->Execute("select zone_code, zone_name
                           from " . TABLE_ZONES . "
                           where countries_iso_code_3 = '" . $country_id . "'
                           order by zone_name");

    while (!$zones->EOF) {
      $zones_array[] = array('id' => $zones->fields['zone_code'],
                             'text' => $zones->fields['zone_name']);
      $zones->MoveNext();
    }

    return $zones_array;
  }

////
  function cfg_pull_down_country_list($country_id, $key = '') {
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
    return html_pull_down_menu($name, gen_get_countries(), $country_id);
  }

////
  function cfg_pull_down_country_list_none($country_id, $key = '') {
    $country_array = gen_get_countries(true);
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
    return html_pull_down_menu($name, $country_array, $country_id);
  }

////
  function cfg_pull_down_zone_list($zone_id, $key = '') {
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
    return html_pull_down_menu($name, setup_get_country_zones(COMPANY_COUNTRY), $zone_id);
  }

////
  function cfg_pull_down_gl_acct_list($acct_id, $key = '') {
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
    return html_pull_down_menu($name, gen_coa_pull_down(), $acct_id);
  }

////
  function cfg_pull_down_tax_rate_list($rate_id, $key = '') {
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
    return html_pull_down_menu($name, gen_get_pull_down(TABLE_TAX_RATES, true, '1', 'tax_rate_id', 'description_short'), $rate_id);
  }

////
  function cfg_pull_down_price_sheet_list($default_id, $key = '') {
    global $db;
	$sql = "select distinct sheet_name from " . TABLE_PRICE_SHEETS . " where '" . date('Y-m-d',time()) . "' >= effective_date and inactive = '0'";
    $output = array();
	$result = $db->Execute($sql);
	while(!$result->EOF) {
	  $output[] = array('id' => $result->fields['sheet_name'], 'text' => $result->fields['sheet_name']);
	  $result->MoveNext();
	}
	$name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
    return html_pull_down_menu($name, $output, $default_id);
  }

////
 function cfg_textarea($text, $key = '') {
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
    return html_textarea_field($name, 60, 5, $text);
  }

////
 function cfg_password($text, $key = '') {
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
    return html_password_field($name, $text);
  }

////
 function cfg_password_show() {
    return '********';
  }

////
 function cfg_textarea_small($text, $key = '') {
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
    return html_textarea_field($name, 35, 1, $text);
  }

////
  function cfg_get_country_name($country_id) {
    global $db;
    $country = $db->Execute("select countries_name from " . TABLE_COUNTRIES . "
                             where countries_id = '" . (int)$country_id . "'");
    if ($country->RecordCount() < 1) {
      return $country_id;
    } else {
      return $country->fields['countries_name'];
    }
  }

////
  function cfg_get_zone_name($zone_id) {
    global $db;
    $zone = $db->Execute("select zone_name from " . TABLE_ZONES . "
                          where zone_id = '" . (int)$zone_id . "'");
    if ($zone->RecordCount() < 1) {
      return $zone_id;
    } else {
      return $zone->fields['zone_name'];
    }
  }

////
  function cfg_select_option($select_array, $key_value, $key = '') {
    $string = '';
    for ($i=0, $n=sizeof($select_array); $i<$n; $i++) {
      $name = ((gen_not_null($key)) ? 'configuration[' . $key . ']' : 'configuration_value');
      $string .= '<br /><input type="radio" name="' . $name . '" value="' . $select_array[$i] . '"';
      if ($key_value == $select_array[$i]) $string .= ' CHECKED';
      $string .= '> ' . $select_array[$i];
    }
    return $string;
  }

  function cfg_select_drop_down($select_array, $key_value, $key = '') {
    $name = ((gen_not_null($key)) ? 'configuration[' . $key . ']' : 'configuration_value');
    return html_pull_down_menu($name, $select_array, (int)$key_value);
  }

////
  function cfg_keyed_select_option($select_array, $key_value) {
    reset($select_array);
    while (list($key, $value) = each($select_array)) {
      $string .= '<br /><input type="radio" name="configuration_value" value="' . $key . '"';
      if ($key_value == $key) $string .= ' CHECKED';
      $string .= '> ' . $value;
    }

    return $string;
  }

////
  function cfg_mod_select_option($select_array, $key_name, $key_value) {
    reset($select_array);
    while (list($key, $value) = each($select_array)) {
      if (is_int($key)) $key = $value;
      $string .= '<br /><input type="radio" name="configuration[' . $key_name . ']" value="' . $key . '"';
      if ($key_value == $key) $string .= ' CHECKED';
      $string .= '> ' . $value;
    }

    return $string;
  }

////
  function cfg_select_multioption($select_array, $key_value, $key = '') {
    for ($i=0; $i<sizeof($select_array); $i++) {
      $name = (($key) ? 'configuration[' . $key . '][]' : 'configuration_value');
      $string .= '<br /><input type="checkbox" name="' . $name . '" value="' . $select_array[$i] . '"';
      $key_values = explode( ", ", $key_value);
      if ( in_array($select_array[$i], $key_values) ) $string .= ' CHECKED';
      $string .= '> ' . $select_array[$i];
    }
    $string .= '<input type="hidden" name="' . $name . '" value="--none--">';
    return $string;
  }

////
  function cfg_select_assoc_multioption($select_array, $key_value, $key = '') {
    foreach($select_array as $code => $desc) {
      $name = (($key) ? 'configuration[' . $key . '][]' : 'configuration_value');
      $string .= '<br /><input type="checkbox" name="' . $name . '" value="' . $code . '"';
      $key_values = explode( ", ", $key_value);
      if ( in_array($code, $key_values) ) $string .= ' CHECKED';
      $string .= '> ' . $desc;
    }
    $string .= '<input type="hidden" name="' . $name . '" value="--none--">';
    return $string;
  }

?>