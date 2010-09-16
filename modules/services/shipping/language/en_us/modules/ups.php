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
//  Path: /modules/services/shipping/language/en_us/modules/ups.php
//

define('MODULE_SHIPPING_UPS_TEXT_TITLE', 'United Parcel Service');
define('MODULE_SHIPPING_UPS_TITLE_SHORT', 'UPS');
define('MODULE_SHIPPING_UPS_TEXT_DESCRIPTION', 'United Parcel Service');

define('MODULE_SHIPPING_UPS_RATE_URL','https://www.ups.com/ups.app/xml/Rate');
define('MODULE_SHIPPING_UPS_RATE_URL_TEST','https://wwwcie.ups.com/ups.app/xml/Rate');
define('MODULE_SHIPPING_UPS_TNT_URL','https://www.ups.com/ups.app/xml/TimeInTransit');
define('MODULE_SHIPPING_UPS_TNT_URL_TEST','https://wwwcie.ups.com/ups.app/xml/TimeInTransit');
define('MODULE_SHIPPING_UPS_SHIP_URL','https://www.ups.com/ups.app/xml/ShipConfirm');
define('MODULE_SHIPPING_UPS_SHIP_URL_TEST','https://wwwcie.ups.com/ups.app/xml/ShipConfirm');
define('MODULE_SHIPPING_UPS_LABEL_URL','https://www.ups.com/ups.app/xml/ShipAccept');
define('MODULE_SHIPPING_UPS_LABEL_URL_TEST','https://wwwcie.ups.com/ups.app/xml/ShipAccept');
define('MODULE_SHIPPING_UPS_VOID_SHIPMENT','https://www.ups.com/ups.app/xml/Void');
define('MODULE_SHIPPING_UPS_VOID_SHIPMENT_TEST','https://wwwcie.ups.com/ups.app/xml/Void');
define('MODULE_SHIPPING_UPS_QUANTUM_VIEW','https://www.ups.com/ups.app/xml/QVEvents');
define('MODULE_SHIPPING_UPS_QUANTUM_VIEW_TEST','https://wwwcie.ups.com/ups.app/xml/QVEvents');

define('MODULE_SHIPPING_UPS_GND', 'Ground');
define('MODULE_SHIPPING_UPS_1DM', 'Next Day Air Early AM');
define('MODULE_SHIPPING_UPS_1DA', 'Next Day Air');
define('MODULE_SHIPPING_UPS_1DP', 'Next Day Air Saver');
define('MODULE_SHIPPING_UPS_2DM', '2nd Day Air Early AM');
define('MODULE_SHIPPING_UPS_2DP', '2nd Day Air');
define('MODULE_SHIPPING_UPS_3DS', '3 Day Select');
define('MODULE_SHIPPING_UPS_XDM', 'Worldwide Express Plus');
define('MODULE_SHIPPING_UPS_XPR', 'Worldwide Express');
define('MODULE_SHIPPING_UPS_XPD', 'Worldwide Expedited');
define('MODULE_SHIPPING_UPS_STD', 'Standard (Canada)');

define('SHIPPING_UPS_VIEW_REPORTS','View Reports for ');
define('SHIPPING_UPS_CLOSE_REPORTS','Closing Report');
define('SHIPPING_UPS_MULTIWGHT_REPORTS','Multiweight Report');
define('SHIPPING_UPS_HAZMAT_REPORTS','Hazmat Report');
define('SHIPPING_UPS_SHIPMENTS_ON','UPS Shipments on ');

define('SHIPPING_UPS_RATE_ERROR','UPS rate response error: ');
define('SHIPPING_UPS_RATE_CITY_MATCH','City doesn\'t match zip code.');
define('SHIPPING_UPS_RATE_TRANSIT',' Day(s) Transit, arrives ');
define('SHIPPING_UPS_TNT_ERROR',' UPS Time in Transit Error # ');

// Ship manager Defines
define('SRV_SHIP_UPS','Ship a Package');
define('SRV_SHIP_UPS_RECP_INFO','Recepient Information');
define('SRV_SHIP_UPS_EMAIL_NOTIFY','Email Notifications');
define('SRV_SHIP_UPS_BILL_DETAIL','Billing Details');

?>