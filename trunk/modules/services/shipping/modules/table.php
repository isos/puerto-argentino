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
//  Path: /modules/services/shipping/modules/table.php
//

// fetch the language file, if it exists, and define service levels per FEDEX standards
include_once(DIR_FS_MODULES . 'services/shipping/language/' . $_SESSION['language'] . '/modules/table.php');

define('table_1DEam',MODULE_SHIPPING_TABLE_1DM);
define('table_1Dam',MODULE_SHIPPING_TABLE_1DA);
define('table_1Dpm',MODULE_SHIPPING_TABLE_1DP);
define('table_2Dpm',MODULE_SHIPPING_TABLE_2DP);
define('table_3Dpm',MODULE_SHIPPING_TABLE_3DS);
define('table_GND',MODULE_SHIPPING_TABLE_GND);
define('table_GDR',MODULE_SHIPPING_TABLE_GDR);

  class table {
    var $code, $title, $description, $icon, $enabled;

// class constructor
    function table() {
      $this->code = 'table';
      $this->title = MODULE_SHIPPING_TABLE_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_TABLE_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_TABLE_SORT_ORDER;
      $this->icon = '';
//      $this->tax_class = MODULE_SHIPPING_TABLE_TAX_CLASS;
//      $this->tax_basis = MODULE_SHIPPING_TABLE_TAX_BASIS;
      $this->enabled = ((MODULE_SHIPPING_TABLE_STATUS == 'True') ? true : false);
    }

// class methods
    function quote($pkg = '') {
      if (MODULE_SHIPPING_TABLE_MODE == 'price') {
        $order_total = $pkg->pkg_total;
      } else { // weight
        $order_total = $pkg->pkg_weight;
      }
      $table_cost = split("[:,]" , MODULE_SHIPPING_TABLE_COST);
      $size = sizeof($table_cost);
      for ($i=0, $n=$size; $i<$n; $i+=2) {
        if ($order_total <= $table_cost[$i]) {
          $shipping = $table_cost[$i+1];
          break;
        }
      }

	  $ItemQuote = array();
	  $arrRates = array();
	  if ($pkg->pkg_item_count) {
	    $methods = array('1DEam','1Dam','1Dpm','2Dpm','3Dpm','GND','GDR');
	    foreach ($methods as $value) {
		  $arrRates[$this->code][$value]['book']  = $shipping + MODULE_SHIPPING_TABLE_HANDLING;
		  $arrRates[$this->code][$value]['quote'] = $shipping + MODULE_SHIPPING_TABLE_HANDLING;
		  $arrRates[$this->code][$value]['cost']  = $shipping + MODULE_SHIPPING_TABLE_HANDLING;
	    }
	  }
	  $ItemQuote['result'] = 'success';
	  $ItemQuote['rates'] = $arrRates;
	  return $ItemQuote;
    }

    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_TABLE_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install() {
      global $db;
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable Table Method', 'MODULE_SHIPPING_TABLE_STATUS', 'True', 'Do you want to offer table rate shipping?', '6', '0', 'cfg_select_option(array(\'True\', \'False\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Table Method', 'MODULE_SHIPPING_TABLE_TITLE', 'Table Method', 'Title to use for display purposes on shipping rate estimator', '6', '0', '', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Shipping Table', 'MODULE_SHIPPING_TABLE_COST', '25:8.50,50:5.50,10000:0.00', 'The shipping cost is based on the total cost or weight of items. Example: 25:8.50,50:5.50,etc.. Up to 25 charge 8.50, from there to 50 charge 5.50, etc', '6', '0', 'cfg_textarea(', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Table Method', 'MODULE_SHIPPING_TABLE_MODE', 'weight', 'The shipping cost is based on the order total or the total weight of the items ordered.', '6', '0', 'cfg_select_option(array(\'weight\', \'price\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Handling Fee', 'MODULE_SHIPPING_TABLE_HANDLING', '0', 'Handling fee for this shipping method.', '6', '0', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_SHIPPING_TABLE_SORT_ORDER', '0', 'Sort order of display.', '6', '0', now())");
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array(
	  	'MODULE_SHIPPING_TABLE_STATUS',
		'MODULE_SHIPPING_TABLE_TITLE',
		'MODULE_SHIPPING_TABLE_COST',
		'MODULE_SHIPPING_TABLE_MODE',
		'MODULE_SHIPPING_TABLE_HANDLING',
		'MODULE_SHIPPING_TABLE_SORT_ORDER');
    }
  }
?>