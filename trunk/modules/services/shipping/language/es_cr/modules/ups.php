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
//  Path: /modules/services/shipping/language/es_cr/modules/ups.php
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

define('MODULE_SHIPPING_UPS_GND', 'Tierra');
define('MODULE_SHIPPING_UPS_1DM', 'Aéreo Día Siguiente Temprano AM');
define('MODULE_SHIPPING_UPS_1DA', 'Aéreo Día Siguiente');
define('MODULE_SHIPPING_UPS_1DP', 'Aéreo Día Siguiente Ahorrativo');
define('MODULE_SHIPPING_UPS_2DM', 'Segundo Día Aéreo Temprano AM');
define('MODULE_SHIPPING_UPS_2DP', 'Segundo Día Aéreo');
define('MODULE_SHIPPING_UPS_3DS', '3 Días Selecto');
define('MODULE_SHIPPING_UPS_XDM', 'Worldwide Express Plus');
define('MODULE_SHIPPING_UPS_XPR', 'Worldwide Express');
define('MODULE_SHIPPING_UPS_XPD', 'Worldwide Expeditado');
define('MODULE_SHIPPING_UPS_STD', 'Estandard (Canada)');

define('SHIPPING_UPS_VIEW_REPORTS','Vea Reportes para ');
define('SHIPPING_UPS_CLOSE_REPORTS','Reporte de Cierre');
define('SHIPPING_UPS_MULTIWGHT_REPORTS','Reporte Multipesos');
define('SHIPPING_UPS_HAZMAT_REPORTS','Reporte Hazmat (Materiales Peligrosos)');
define('SHIPPING_UPS_SHIPMENTS_ON','Envíos UPS el día ');

define('SHIPPING_UPS_RATE_ERROR','Error en respuesta de tarifa UPS: ');
define('SHIPPING_UPS_RATE_CITY_MATCH','La ciudad no concuerda con el código póstal.');
define('SHIPPING_UPS_RATE_TRANSIT',' Día(s) en Tránsito, Llega ');
define('SHIPPING_UPS_TNT_ERROR',' Error en tiempo de tránsito UPST # ');

// Ship manager Defines
define('SRV_SHIP_UPS','Envíe un Paquete');
define('SRV_SHIP_UPS_RECP_INFO','Información del Destinatario');
define('SRV_SHIP_UPS_EMAIL_NOTIFY','Notificaciones Email');
define('SRV_SHIP_UPS_BILL_DETAIL','Detalles de Facturación');

?>
