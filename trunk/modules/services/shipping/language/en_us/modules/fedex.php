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
//  Path: /modules/services/shipping/language/en_us/modules/fedex.php
//

define('FEDEX_LTL_RATE_URL','http://www.fedexfreight.fedex.com/XMLLTLRating.jsp');
define('FEDEX_EXPRESS_RATE_URL','https://gateway.fedex.com:443/GatewayDC');
define('FEDEX_EXPRESS_TEST_RATE_URL','https://gatewaybeta.fedex.com:443/GatewayDC');

define('MODULE_SHIPPING_FEDEX_TEXT_TITLE', 'Federal Express');
define('MODULE_SHIPPING_FEDEX_TITLE_SHORT', 'FedEx');
define('MODULE_SHIPPING_FEDEX_TEXT_DESCRIPTION', 'FedEx Express');

define('MODULE_SHIPPING_FEDEX_GND','Ground');
define('MODULE_SHIPPING_FEDEX_GDR','Home Delivery');
define('MODULE_SHIPPING_FEDEX_1DM','First Overnight');
define('MODULE_SHIPPING_FEDEX_1DA','Priority Overnight');
define('MODULE_SHIPPING_FEDEX_1DP','Standard Overnight');
define('MODULE_SHIPPING_FEDEX_2DP','Express 2 Day');
define('MODULE_SHIPPING_FEDEX_3DS','Express Saver');
define('MODULE_SHIPPING_FEDEX_XDM','Int. First');
define('MODULE_SHIPPING_FEDEX_XPR','Int. Priority');
define('MODULE_SHIPPING_FEDEX_XPD','Int. Economy');
define('MODULE_SHIPPING_FEDEX_1DF','1 Day Freight');
define('MODULE_SHIPPING_FEDEX_2DF','2 Day Freight');
define('MODULE_SHIPPING_FEDEX_3DF','3 Day Freight');
define('MODULE_SHIPPING_FEDEX_GDF','Ground LTL Freight');

define('SHIPPING_FEDEX_VIEW_REPORTS','View Reports for ');
define('SHIPPING_FEDEX_CLOSE_REPORTS','Closing Report');
define('SHIPPING_FEDEX_MULTIWGHT_REPORTS','Multiweight Report');
define('SHIPPING_FEDEX_HAZMAT_REPORTS','Hazmat Report');
define('SHIPPING_FEDEX_SHIPMENTS_ON','FedEx Shipments on ');

define('SHIPPING_FEDEX_RATE_ERROR','FedEx rate response error: ');
define('SHIPPING_FEDEX_RATE_CITY_MATCH','City doesn\'t match zip code.');
define('SHIPPING_FEDEX_RATE_TRANSIT',' Day(s) Transit, arrives ');
define('SHIPPING_FEDEX_TNT_ERROR',' FedEx Time in Transit Error # ');

// Ship manager Defines
define('SRV_SHIP_FEDEX','Ship a Package');
define('SRV_CLOSE_FEDEX_SHIP','Close Today\'s FedEx Shipments');
define('SRV_SHIP_FEDEX_RECP_INFO','Recepient Information');
define('SRV_SHIP_FEDEX_EMAIL_NOTIFY','Email Notifications');
define('SRV_SHIP_FEDEX_BILL_DETAIL','Billing Details');
define('SRV_SHIP_FEDEX_LTL_FREIGHT','LTL Freight');
define('SRV_FEDEX_LTL_CLASS','Freight Class');

?>