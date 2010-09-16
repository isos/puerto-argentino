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
//  Path: /soap/language/es_cr/language.php
//

define('SOAP_NO_USER_PW','El nombre y cláve del usuario no se encontraron en la frase XML.');
define('SOAP_USER_NOT_FOUND','El nombre del usuario no es válido.');
define('SOAP_PASSWORD_NOT_FOUND','La clave del usuario no es válida.');
define('SOAP_UNEXPECTED_ERROR','El servidor reportó que ocurrió un error de proceso inesperado.');
define('SOAP_XML_SUBMITTED_SO','Órden de Venta en formato XML.');
define('SOAP_NO_CUSTOMER_ID','La identificación del cliente no está o no es válida.');
define('SOAP_NO_POST_DATE','La fecha de la transacción no está o no es válida.');
define('SOAP_BAD_POST_DATE','La fecha de la transacción está fuera de los años fiscales disponibles definidos en Phreebooks.');

define('SOAP_NO_BILLING_PRIMARY_NAME','Hace falta el nombre principal para el cobro.');
define('SOAP_NO_BILLING_CONTACT','Hace falta el contacto para el cobro.');
define('SOAP_NO_BILLING_ADDRESS1','Hace falta la dirección línea 1 para el cobro.');
define('SOAP_NO_BILLING_ADDRESS2','Hace falta la dirección línea 2 para el cobro.');
define('SOAP_NO_BILLING_CITY_TOWN','Hace falta la ciudad para el cobro.');
define('SOAP_NO_BILLING_STATE_PROVINCE','Hace falta la provincia/estado para el cobro.');
define('SOAP_NO_BILLING_POSTAL_CODE','Hace falta el código postal para el cobro.');
define('SOAP_NO_BILLING_COUNTRY_CODE','Hace falta el código de país ISO 2 para el cobro.');
define('SOAP_NO_SHIPPING_PRIMARY_NAME','Hace falta el nombre principal para el envío.');
define('SOAP_NO_SHIPPING_CONTACT','Hace falta el contacto para el envío.');
define('SOAP_NO_SHIPPING_ADDRESS1','Hace falta la dirección línea 1 para el envío.');
define('SOAP_NO_SHIPPING_ADDRESS2','Hace falta la dirección línea 2 para el envío.');
define('SOAP_NO_SHIPPING_CITY_TOWN','Hace falta la ciudad para el envío.');
define('SOAP_NO_SHIPPING_STATE_PROVINCE','Hace falta la provincia/estado para el envío.');
define('SOAP_NO_SHIPPING_POSTAL_CODE','Hace falta el código postal para el cliente.');
define('SOAP_NO_SHIPPING_COUNTRY_CODE','Hace falta el código de país ISO 2 para el cliente.');

define('SOAP_SO_POST_ERROR','Hubo un error registrando la Órden de Venta. Descripción - ');
define('SOAP_ACCOUNT_PROBLEM','No se pudo encontrar la dirección principal para un cliente existente.  Problema serio con la base de datos de direcciones de PhreeBooks.');

// particular to order type
define('AUDIT_LOG_SOAP_10_ADDED','SOAP Orden de Venta - Agregada');
define('AUDIT_LOG_SOAP_12_ADDED','SOAP Factura - Agregada');
define('SOAP_10_SUCCESS','La Órden de Venta %s fue descargada exitósamente.');
define('SOAP_12_SUCCESS','La Factura %s fue descargada exitósamente.');

?>
