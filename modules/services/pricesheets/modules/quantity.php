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
//  Path: /modules/services/pricesheets/modules/quantity.php
//

  class quantity {
    var $code, $title, $description, $enabled;

// class constructor
    function quantity() {
      global $order;

      $this->code = 'quantity';
      $this->title = MODULE_PRICE_SHEET_QTY_TEXT_TITLE;
      $this->description = MODULE_PRICE_SHEET_QTY_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PRICE_SHEET_QTY_SORT_ORDER;
      $this->enabled = ((MODULE_PRICE_SHEET_QTY_STATUS == 'True') ? true : false);

//      if ((int)MODULE_PRICE_SHEET_QTY_STATUS > 0) {
//        $this->order_status = MODULE_PRICE_SHEET_QTY_ORDER_STATUS_ID;
//      }
    }

// class methods
    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PRICE_SHEET_QTY_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install() {
      global $db;
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Quantity Based Price Sheets', 'MODULE_PRICE_SHEET_QTY_STATUS', 'True', 'Do you want to enable price sheets to allow multilevel pricing base on item quantities purchased?', '6', '1', 'cfg_select_option(array(\'True\', \'False\'), ', now());");
//      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Make Payable to:', 'MODULE_PRICE_SHEET_QTY_PAYTO', '', 'Who should payments be made payable to?', '6', '1', now());");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort order of display.', 'MODULE_PRICE_SHEET_QTY_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PRICE_SHEET_QTY_STATUS', 
//		'MODULE_PRICE_SHEET_QTY_PAYTO', 
		'MODULE_PRICE_SHEET_QTY_SORT_ORDER');
    }
  }
?>