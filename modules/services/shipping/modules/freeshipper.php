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
//  Path: /modules/services/shipping/modules/freeshipper.php
//

// fetch the language file, if it exists, and define service levels per FEDEX standards
include_once(DIR_FS_MODULES . 'services/shipping/language/' . $_SESSION['language'] . '/modules/freeshipper.php');

define('freeshipper_1DEam', MODULE_SHIPPING_FREESHIPPER_1DM);
define('freeshipper_1Dam',  MODULE_SHIPPING_FREESHIPPER_1DA);
define('freeshipper_1Dpm',  MODULE_SHIPPING_FREESHIPPER_1DP);
define('freeshipper_2Dpm',  MODULE_SHIPPING_FREESHIPPER_2DP);
define('freeshipper_3Dpm',  MODULE_SHIPPING_FREESHIPPER_3DS);
define('freeshipper_GND',   MODULE_SHIPPING_FREESHIPPER_GND);
define('freeshipper_GDR',   MODULE_SHIPPING_FREESHIPPER_GDR);

  class freeshipper {
    var $code, $title, $description, $icon, $enabled;

// class constructor
    function freeshipper() {
      $this->code        = 'freeshipper';
      $this->title       = MODULE_SHIPPING_FREESHIPPER_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_FREESHIPPER_TEXT_DESCRIPTION;
      $this->sort_order  = MODULE_SHIPPING_FREESHIPPER_SORT_ORDER;
      $this->icon        = '';
//    $this->tax_class   = MODULE_SHIPPING_FREESHIPPER_TAX_CLASS;
      $this->enabled     = ((MODULE_SHIPPING_FREESHIPPER_STATUS == 'True') ? true : false);
    }

// class methods
    function quote($pkg = '') {
	  $FreeShipperQuote = array();
	  $arrRates         = array();
	  $methods          = array('1DEam','1Dam','1Dpm','2Dpm','3Dpm','GND','GDR');
	  foreach ($methods as $value) {
		$arrRates[$this->code][$value]['book']  = MODULE_SHIPPING_FREESHIPPER_COST + MODULE_SHIPPING_FREESHIPPER_HANDLING;
		$arrRates[$this->code][$value]['quote'] = MODULE_SHIPPING_FREESHIPPER_COST + MODULE_SHIPPING_FREESHIPPER_HANDLING;
		$arrRates[$this->code][$value]['cost']  = MODULE_SHIPPING_FREESHIPPER_COST + MODULE_SHIPPING_FREESHIPPER_HANDLING;
	  }
	  $FreeShipperQuote['result'] = 'success';
	  $FreeShipperQuote['rates']  = $arrRates;
	  return $FreeShipperQuote;
    }

    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_FREESHIPPER_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install() {
      global $db;
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Free Shipping', 'MODULE_SHIPPING_FREESHIPPER_STATUS', 'True', 'Do you want to offer Free shipping?', '6', '0', 'cfg_select_option(array(\'True\', \'False\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Free Shipping', 'MODULE_SHIPPING_FREESHIPPER_TITLE', 'Free Shipping', 'Title to use for display purposes on shipping rate estimator', '6', '0', '', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Free Shipping Cost', 'MODULE_SHIPPING_FREESHIPPER_COST', '0.00', 'What is the Shipping cost?', '6', '6', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Handling Fee', 'MODULE_SHIPPING_FREESHIPPER_HANDLING', '0', 'Handling fee for this shipping method.', '6', '0', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_SHIPPING_FREESHIPPER_SORT_ORDER', '0', 'Sort order of display.', '6', '0', now())");
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array(
	  	'MODULE_SHIPPING_FREESHIPPER_STATUS',
		'MODULE_SHIPPING_FREESHIPPER_TITLE',
		'MODULE_SHIPPING_FREESHIPPER_COST',
		'MODULE_SHIPPING_FREESHIPPER_HANDLING',
		'MODULE_SHIPPING_FREESHIPPER_SORT_ORDER',
	  );
    }
  }
?>