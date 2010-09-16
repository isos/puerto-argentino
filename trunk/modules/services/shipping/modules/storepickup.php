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
//  Path: /modules/services/shipping/modules/storepickup.php
//

// fetch the language file, if it exists, and define service levels per FEDEX standards
include_once(DIR_FS_MODULES . 'services/shipping/language/' . $_SESSION['language'] . '/modules/storepickup.php');

define('storepickup_1DEam',MODULE_SHIPPING_STOREPICKUP_1DM);
define('storepickup_1Dam',MODULE_SHIPPING_STOREPICKUP_1DA);
define('storepickup_1Dpm',MODULE_SHIPPING_STOREPICKUP_1DP);
define('storepickup_2Dpm',MODULE_SHIPPING_STOREPICKUP_2DP);
define('storepickup_3Dpm',MODULE_SHIPPING_STOREPICKUP_3DS);
define('storepickup_GND',MODULE_SHIPPING_STOREPICKUP_GND);
define('storepickup_GDR',MODULE_SHIPPING_STOREPICKUP_GDR);

  class storepickup {
    var $code, $title, $description, $icon, $enabled;

// class constructor
    function storepickup() {
      $this->code = 'storepickup';
      $this->title = MODULE_SHIPPING_STOREPICKUP_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_STOREPICKUP_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_STOREPICKUP_SORT_ORDER;
      $this->icon = '';
//      $this->tax_class = MODULE_SHIPPING_STOREPICKUP_TAX_CLASS;
//      $this->tax_basis = MODULE_SHIPPING_ITEM_STOREPICKUP_BASIS;
      $this->enabled = ((MODULE_SHIPPING_STOREPICKUP_STATUS == 'True') ? true : false);
    }

// class methods
    function quote($pkg = '') {
	  $StorePickupQuote = array();
	  $arrRates = array();
	  $methods = array('1DEam','1Dam','1Dpm','2Dpm','3Dpm','GND','GDR');
	  foreach ($methods as $value) {
	    $arrRates[$this->code][$value]['book'] = MODULE_SHIPPING_STOREPICKUP_COST;
	    $arrRates[$this->code][$value]['quote'] = MODULE_SHIPPING_STOREPICKUP_COST;
	    $arrRates[$this->code][$value]['cost'] = MODULE_SHIPPING_STOREPICKUP_COST;
	  }
	  $StorePickupQuote['result'] = 'success';
	  $StorePickupQuote['rates'] = $arrRates;
	  return $StorePickupQuote;
    }

    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_STOREPICKUP_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install() {
      global $db;
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Store Pickup Shipping', 'MODULE_SHIPPING_STOREPICKUP_STATUS', 'True', 'Do you want to offer In Store rate shipping?', '6', '0', 'cfg_select_option(array(\'True\', \'False\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Store Pickup', 'MODULE_SHIPPING_STOREPICKUP_TITLE', 'Store Pickup', 'Title to use for display purposes on shipping rate estimator', '6', '0', '', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Shipping Cost', 'MODULE_SHIPPING_STOREPICKUP_COST', '0.00', 'The shipping cost for all orders using this shipping method.', '6', '0', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_SHIPPING_STOREPICKUP_SORT_ORDER', '0', 'Sort order of display.', '6', '0', now())");
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array(
	  	'MODULE_SHIPPING_STOREPICKUP_STATUS',
		'MODULE_SHIPPING_STOREPICKUP_TITLE',
		'MODULE_SHIPPING_STOREPICKUP_COST',
		'MODULE_SHIPPING_STOREPICKUP_SORT_ORDER');
    }
  }
?>