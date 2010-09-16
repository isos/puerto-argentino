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
//  Path: /modules/services/payment/language/es_cr/modules/nova_xml.php
//

// Admin Configuration Items
  define('MODULE_PAYMENT_NOVA_XML_TEXT_TITLE', 'Nova (Mercante Virtual)'); // Payment option title as displayed in the admin
  define('MODULE_PAYMENT_NOVA_XML_TEXT_DESCRIPTION', 'Cuando en modo de prueba, las tarjetas devuelven un código de éxito sin embargo, no son procesadas.<br /><br />');

// Catalog Items
  define('MODULE_PAYMENT_NOVA_XML_TEXT_CATALOG_TITLE', 'Tarjeta de Crédito');  // Payment option title as displayed to the customer
  define('MODULE_PAYMENT_NOVA_XML_TEXT_CREDIT_CARD_TYPE', 'Tipo de tarjeta de crédito:');
  define('MODULE_PAYMENT_NOVA_XML_TEXT_CREDIT_CARD_OWNER', 'Dueño de la tarjeta de crédito:');
  define('MODULE_PAYMENT_NOVA_XML_TEXT_CREDIT_CARD_NUMBER', 'Número de la tarjeta de crédito:');
  define('MODULE_PAYMENT_NOVA_XML_TEXT_CREDIT_CARD_EXPIRES', 'Fecha de vencimiento de la tarjeta de crédito:');
  define('MODULE_PAYMENT_NOVA_XML_TEXT_CVV', 'Número CVV (<a href="javascript:popupWindowCvv()">' . 'Más Información' . '</a>)');
  define('MODULE_PAYMENT_NOVA_XML_TEXT_JS_CC_OWNER', '* El nombre del dueño de la tarjeta de crédito debe ser de al menos ' . CC_OWNER_MIN_LENGTH . ' caracteres.\n');
  define('MODULE_PAYMENT_NOVA_XML_TEXT_JS_CC_NUMBER', '* El número de la tarjeta de crédito debe ser de al menos ' . CC_NUMBER_MIN_LENGTH . ' caracteres.\n');
  define('MODULE_PAYMENT_NOVA_XML_TEXT_JS_CC_CVV', '* Debe digitarse el código CVV de 3 o 4 dígitos que está en la parte de atrás de la tarjeta de crédito.\n');
  define('MODULE_PAYMENT_NOVA_XML_TEXT_DECLINED_MESSAGE', 'La transacción de la tarjeta de crédito no se procesó correctamente.  Si no se da una razón, la tarjeta fue rechazada por el banco.');
  define('MODULE_PAYMENT_NOVA_XML_NO_DUPS','La tarjeta de crédito no se procesó porque ya fue procesada.  Para volver a cargar la tarjeta, la tarjeta de crédito debe ser válida y no contener caracteres *.');
  define('MODULE_PAYMENT_NOVA_XML_TEXT_ERROR', '¡Error de tarjeta de crédito!');
?>
