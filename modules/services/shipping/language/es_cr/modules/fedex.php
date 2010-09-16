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
//  Path: /modules/services/shipping/language/es_cr/modules/fedex.php
//

define('FEDEX_LTL_RATE_URL','http://www.fedexfreight.fedex.com/XMLLTLRating.jsp');
define('FEDEX_EXPRESS_RATE_URL','https://gateway.fedex.com:443/GatewayDC');
define('FEDEX_EXPRESS_TEST_RATE_URL','https://gatewaybeta.fedex.com:443/GatewayDC');

define('MODULE_SHIPPING_FEDEX_TEXT_TITLE', 'Viejo - Federal Express');
define('MODULE_SHIPPING_FEDEX_TITLE_SHORT', 'Viejo - FedEx');
define('MODULE_SHIPPING_FEDEX_TEXT_DESCRIPTION', 'Viejo - FedEx Express');

define('MODULE_SHIPPING_FEDEX_GND','Tierra');
define('MODULE_SHIPPING_FEDEX_1DM','Primero De un Día Para Otro');
define('MODULE_SHIPPING_FEDEX_1DA','Prioridad De un Día Para Otro');
define('MODULE_SHIPPING_FEDEX_1DP','Estandard De un Día Para Otro');
define('MODULE_SHIPPING_FEDEX_2DP','Express 2 Días');
define('MODULE_SHIPPING_FEDEX_3DS','Express Ahorrativo');
define('MODULE_SHIPPING_FEDEX_XDM','Int. Primero');
define('MODULE_SHIPPING_FEDEX_XPR','Int. Prioridad');
define('MODULE_SHIPPING_FEDEX_XPD','Int. Económico');

define('MODULE_SHIPPING_FEDEX_1DF','1 Día Carga');
define('MODULE_SHIPPING_FEDEX_2DF','2 Día Carga');
define('MODULE_SHIPPING_FEDEX_3DF','3 Día Carga');
define('MODULE_SHIPPING_FEDEX_GDF','Tierra Carga LTL');

define('SHIPPING_FEDEX_VIEW_REPORTS','Vea Reportes para ');
define('SHIPPING_FEDEX_CLOSE_REPORTS','Reporte de Cierre');
define('SHIPPING_FEDEX_MULTIWGHT_REPORTS','Reporte Multipesos');
define('SHIPPING_FEDEX_HAZMAT_REPORTS','Reporte Hazmat (Materiales Peligrosos)');
define('SHIPPING_FEDEX_SHIPMENTS_ON','Envíos FedEx del día ');

define('SHIPPING_FEDEX_RATE_ERROR','Error de respuesta de tarifa FedEx: ');
define('SHIPPING_FEDEX_RATE_CITY_MATCH','La Ciudad no concuerda con el Código Postal.');
define('SHIPPING_FEDEX_RATE_TRANSIT',' Día(s) de Transito, Llega ');
define('SHIPPING_FEDEX_TNT_ERROR',' Error en Tiempo de Transito FedEx # ');

// Ship manager Defines
define('SRV_SHIP_FEDEX','Envíe un Paquete');
define('SRV_CLOSE_FEDEX_SHIP','Cierre los Envíos FedEx de Hoy');
define('SRV_SHIP_FEDEX_RECP_INFO','Informacion de Destinatario');
define('SRV_SHIP_FEDEX_EMAIL_NOTIFY','Notificaciones por Email');
define('SRV_SHIP_FEDEX_BILL_DETAIL','Detalles de Facturación');
define('SRV_SHIP_FEDEX_LTL_FREIGHT','Carga LTL');
define('SRV_FEDEX_LTL_CLASS','Clase de Carga');

?>
