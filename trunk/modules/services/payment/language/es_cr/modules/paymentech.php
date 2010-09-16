<?php
/**
 * Paymentech Payment Module V.1.0 created by s_mack - 09/18/2007 Released under GPL
 *
 * @package languageDefines
 * @copyright Portions Copyright 2007 s_mack
 * @copyright Portions Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */


// Admin Configuration Items
  define('MODULE_PAYMENT_PAYMENTECH_TEXT_TITLE', 'Paymentech'); // Payment option title as displayed in the admin
  define('MODULE_PAYMENT_PAYMENTECH_TEXT_DESCRIPTION', 'Procesamiento de tarjeta de crédito vía Chase Orbital/Paymentech');

// Catalog Items
  define('MODULE_PAYMENT_PAYMENTECH_TEXT_CATALOG_TITLE', 'Tarjeta de Crédito');  // Payment option title as displayed to the customer
  define('MODULE_PAYMENT_PAYMENTECH_TEXT_CREDIT_CARD_TYPE', 'Tipo de tarjeta de crédito:');
  define('MODULE_PAYMENT_PAYMENTECH_TEXT_CREDIT_CARD_OWNER', 'Dueño de la tarjeta de crédito:');
  define('MODULE_PAYMENT_PAYMENTECH_TEXT_CREDIT_CARD_NUMBER', 'Número de la tarjeta de crédito:');
  define('MODULE_PAYMENT_PAYMENTECH_TEXT_CREDIT_CARD_EXPIRES', 'Fecha de vencimiento de la tarjeta de crédito:');
  define('MODULE_PAYMENT_PAYMENTECH_TEXT_CVV', 'Número CVV (<a href="javascript:popupWindowCvv()">' . 'Más Información' . '</a>)');
  define('MODULE_PAYMENT_PAYMENTECH_TEXT_POPUP_CVV_LINK', '¿Qué es esto?');
  define('MODULE_PAYMENT_PAYMENTECH_TEXT_JS_CC_OWNER', '* El nombre del dueño de la tarjeta de crédito debe ser de al menos ' . CC_OWNER_MIN_LENGTH . ' caracteres.\n');
  define('MODULE_PAYMENT_PAYMENTECH_TEXT_JS_CC_NUMBER', '* El número de la tarjeta de crédito debe ser de al menos ' . CC_NUMBER_MIN_LENGTH . ' caracteres.\n');
  define('MODULE_PAYMENT_PAYMENTECH_TEXT_JS_CC_CVV', '* Hace falta el código CVV de 3 o 4 dígitos que está en la parte de atrás de la tarjeta de crédito.\n');
  define('MODULE_PAYMENT_PAYMENTECH_TEXT_GATEWAY_ERROR', 'Ocurrió un error inesperado en la comunicación.  La órden no se procesó.');
  define('MODULE_PAYMENT_PAYMENTECH_TEXT_DECLINED_MESSAGE', 'No se autorizó la tarjeta de crédito por esta razón: <i>Negada (%s)</i>.');
  define('MODULE_PAYMENT_PAYMENTECH_NO_DUPS','La tarjeta de crédito no se procesó porque ya ha sido procesada.  Para volver a cargar la tarjeta, la tarjeta de crédito debe ser válida y no contener ningún caracter *.');
  define('MODULE_PAYMENT_PAYMENTECH_TEXT_ERROR', '¡Error de tarjeta de crédito!');
  define('MODULE_PAYMENT_PAYMENTECH_TEST_URL_PRIMARY', 'https://orbitalvar1.paymentech.net');
  define('MODULE_PAYMENT_PAYMENTECH_PRODUCTION_URL_PRIMARY', 'https://orbital1.paymentech.net/authorize');
  define('MODULE_PAYMENT_PAYMENTECH_EMAIL_GATEWAY_ERROR_SUBJECT', 'Problema con el enlace a Paymentech');
  define('MODULE_PAYMENT_PAYMENTECH_EMAIL_SYSTEM_ERROR_SUBJECT', 'Problema con el sistema Paymentech');
  define('MODULE_PAYMENT_PAYMENTECH_EMAIL_DECLINED_SUBJECT', 'Transacción rechazada por Paymentech');
?>
