<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2010 PhreeSoft, LLC                               |
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
//  Path: /modules/oscommerce/language/es_cr/language.php
//

// Headings 
define('MODULE_OSCOMMERCE_INSTALL_HEADING','Estatus de la Instalación');
define('MODULE_OSCOMMERCE_CONFIG_HEADING','Configuración de la Interface ');

// General Defines
define('OSCOMMERCE_CONFIRM_MESSAGE','Su órden se envío %s vía %s %s, número de seguimiento: %s');
define('OSCOMMERCE_BULK_UPLOAD_SUCCESS','Cargó exitósamente %s artículo(s) a osCommerce.');
define('OSCOMMERCE_ADMIN_URL','Ruta a Admin en osCommerce (sin slash al final)');
define('OSCOMMERCE_ADMIN_USERNAME','Nombre de usuario admin de osCommerce (puede ser exclusivo a para la interfase con PhreeBooks');
define('OSCOMMERCE_ADMIN_PASSWORD','Contraseña de admin de osCommerce (puede ser exclusivo a para la interfase con PhreeBooks)');
define('OSCOMMERCE_TAX_CLASS','Digite el campo de texto para la clase de impuestos de osCommerce.  Debe calzar exactamente al valor en osCommerce si cobra impuestos)');
define('OSCOMMERCE_USE_PRICES','¿Quiere usar hojas de escala de precios?');
define('OSCOMMERCE_TEXT_PRICE_SHEET','Hoja de escala de precios de osCommerce a usar');
define('OSCOMMERCE_TEXT_ERROR','Error # ');
define('OSCOMMERCE_SHIP_ID','Código numérico de estatus en osCommerce para órdenes enviadas');
define('OSCOMMERCE_PARTIAL_ID','Código numérico de estatus en osCommerce para órdenes parcialmente enviadas');
define('OSCOMMERCE_IVENTORY_UPLOAD','Suba a osCommerce');
define('OSCOMMERCE_BULK_UPLOAD_TITLE','Suba en bloque');
define('OSCOMMERCE_BULK_UPLOAD_INFO','Suba en bloque todos los productos seleccionado que van a ser mostrados en la tienda de osCommerce.  Las imágenes no se incluyen a no ser que la casilla correspondiente esté marcada.');
define('OSCOMMERCE_BULK_UPLOAD_TEXT','Suba en bloque productos a la tienda de osCommerce');
define('OSCOMMERCE_INCLUDE_IMAGES','Incluya imágenes');
define('OSCOMMERCE_BULK_UPLOAD_BTN','Suba en bloque');
define('OSCOMMERCE_PRODUCT_SYNC_TITLE','Sincronice Productos');
define('OSCOMMERCE_PRODUCT_SYNC_INFO','Sincronice los productos activos de la base de datos de PhreeBooks (para ser mostrados en el catálogo como activos) con la lista actual de osCommerce.  Los códigos que no deben estar listados en osCommerce están mostrados.  Deben ser removidos manualmente de osCommerce a través de la interfase de admin de osCommerce.');
define('OSCOMMERCE_PRODUCT_SYNC_TEXT','Sincronice productos con la tienda de osCommerce');
define('OSCOMMERCE_PRODUCT_SYNC_BTN','Sincronice');
define('OSCOMMERCE_SHIP_CONFIRM_TITLE','Confirme Envíos');
define('OSCOMMERCE_SHIP_CONFIRM_INFO','Confirma todos los envíos en la fecha seleccionada del Administrador de Envíos y fija el estatus en osCommerce.  Actualización de órdenes finalizadas y envíos parciales. No se enviaron notificaciones por correo electrónico a los clientes.');
define('OSCOMMERCE_SHIP_CONFIRM_TEXT','Mande confirmaciones de envíos');
define('OSCOMMERCE_TEXT_CONFIRM_ON','Para órdenes enviados el');
define('OSCOMMERCE_SHIP_CONFIRM_BTN','Confirme Envíos');

// osCommerce admin defines
define('MODULE_OSCOMMERCE_CONFIG_INFO','Favor defina los valores de configuración para su tienda en osCommerce.');

// Error Messages
define('OSCOMMERCE_MOD_NOT_INSTALLED','¡No está configurado el módulo de osCommerce! Ha sido redirigido a módulo de administración para fijar los parámetros de configuración.');
define('OSCOMMERCE_MOD_NOT_SETUP','¡No está configurado el módulo de osCommerce!');
define('OSCOMMERCE_ERROR_NO_ITEMS','No se seleccionaron artículos de inventario para subir al catálogo de osCommerce.  Buscando el campo de la casilla con nombre de catálogo para identificar los artículos a subir.');
define('OSCOMMERCE_ERROR_CONFRIM_NO_DATA','No se encontraron registros con esta fecha para confirmar con osCommerce.');
define('OSCOMMERCE_ERROR_NO_PRICE_SHEET','No se encontró un escala de precios predeterminada para:  ');
define('OSCOMMERCE_CANNOT_WRITE_CONFIG','No se puedo abrir el archivo (%s) para escribir la información de configuración. Revise los permisos.');
define('OSCOMMERCE_INVALID_ACTION','Se solicitó una acción inválida. ¡Abortando!');
define('OSCOMMERCE_INVALID_SKU','Error con la identificación del código de inventario.  No se pudo encontrar el registro en la base de datos');

// Javascrpt Defines

// Audit Log Messages
define('OSCOMMERCE_UPLOAD_PRODUCT','Subir Productos a osCommerce');
define('OSCOMMERCE_BULK_UPLOAD','Subir un bloque de productos a osCommerce');
define('OSCOMMERCE_PRODUCT_SYNC','Sincronización de productos con osCommerce');
define('OSCOMMERCE_SHIP_CONFIRM','Confirmacíon de Envío de osCommerce');

?>
