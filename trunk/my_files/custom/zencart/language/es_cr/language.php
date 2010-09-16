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
//  Path: /modules/zencart/language/es_cr/language.php
//

// Headings 
define('MODULE_ZENCART_INSTALL_HEADING','Estatus de la Instalación');
define('MODULE_ZENCART_CONFIG_HEADING','Configuración de la Interface ');

// General Defines
define('ZENCART_CONFIRM_MESSAGE','Su órden se envío %s vía %s %s, número de seguimiento: %s');
define('ZENCART_BULK_UPLOAD_SUCCESS','Cargó exitósamente %s artículo(s) a ZenCart.');
define('ZENCART_ADMIN_URL','Ruta a Admin en ZenCart (sin slash al final)');
define('ZENCART_ADMIN_USERNAME','Nombre de usuario admin de ZenCart (puede ser exclusivo a para la interfase con PhreeBooks');
define('ZENCART_ADMIN_PASSWORD','Contraseña de admin de ZenCart (puede ser exclusivo a para la interfase con PhreeBooks)');
define('ZENCART_TAX_CLASS','Digite el campo de texto para la clase de impuestos de ZenCart.  Debe calzar exactamente al valor en ZenCart si cobra impuestos)');
define('ZENCART_USE_PRICES','¿Quiere usar hojas de escala de precios?');
define('ZENCART_TEXT_PRICE_SHEET','Hoja de escala de precios de ZenCart a usar');
define('ZENCART_TEXT_ERROR','Error # ');
define('ZENCART_SHIP_ID','Código numérico de estatus en ZenCart para órdenes enviadas');
define('ZENCART_PARTIAL_ID','Código numérico de estatus en ZenCart para órdenes parcialmente enviadas');
define('ZENCART_IVENTORY_UPLOAD','Suba a ZenCart');
define('ZENCART_BULK_UPLOAD_TITLE','Suba en bloque');
define('ZENCART_BULK_UPLOAD_INFO','Suba en bloque todos los productos seleccionado que van a ser mostrados en la tienda de ZenCart.  Las imágenes no se incluyen a no ser que la casilla correspondiente esté marcada.');
define('ZENCART_BULK_UPLOAD_TEXT','Suba en bloque productos a la tienda de ZenCart');
define('ZENCART_INCLUDE_IMAGES','Incluya imágenes');
define('ZENCART_BULK_UPLOAD_BTN','Suba en bloque');
define('ZENCART_PRODUCT_SYNC_TITLE','Sincronice Productos');
define('ZENCART_PRODUCT_SYNC_INFO','Sincronice los productos activos de la base de datos de PhreeBooks (para ser mostrados en el catálogo como activos) con la lista actual de ZenCart.  Los códigos que no deben estar listados en ZenCart están mostrados.  Deben ser removidos manualmente de ZenCart a través de la interfase de admin de ZenCart.');
define('ZENCART_PRODUCT_SYNC_TEXT','Sincronice productos con la tienda de ZenCart');
define('ZENCART_PRODUCT_SYNC_BTN','Sincronice');
define('ZENCART_SHIP_CONFIRM_TITLE','Confirme Envíos');
define('ZENCART_SHIP_CONFIRM_INFO','Confirma todos los envíos en la fecha seleccionada del Administrador de Envíos y fija el estatus en ZenCart.  Actualización de órdenes finalizadas y envíos parciales. No se enviaron notificaciones por correo electrónico a los clientes.');
define('ZENCART_SHIP_CONFIRM_TEXT','Mande confirmaciones de envíos');
define('ZENCART_TEXT_CONFIRM_ON','Para órdenes enviados el');
define('ZENCART_SHIP_CONFIRM_BTN','Confirme Envíos');

// ZenCart admin defines
define('MODULE_ZENCART_CONFIG_INFO','Favor defina los valores de configuración para su tienda en ZenCart.');

// Error Messages
define('ZENCART_MOD_NOT_INSTALLED','¡No está configurado el módulo de ZenCart! Ha sido redirigido a módulo de administración para fijar los parámetros de configuración.');
define('ZENCART_MOD_NOT_SETUP','¡No está configurado el módulo de ZenCart!');
define('ZENCART_ERROR_NO_ITEMS','No se seleccionaron artículos de inventario para subir al catálogo de ZenCart.  Buscando el campo de la casilla con nombre de catálogo para identificar los artículos a subir.');
define('ZENCART_ERROR_CONFRIM_NO_DATA','No se encontraron registros con esta fecha para confirmar con ZenCart.');
define('ZENCART_ERROR_NO_PRICE_SHEET','No se encontró un escala de precios predeterminada para:  ');
define('ZENCART_CANNOT_WRITE_CONFIG','No se puedo abrir el archivo (%s) para escribir la información de configuración. Revise los permisos.');
define('ZENCART_INVALID_ACTION','Se solicitó una acción inválida. ¡Abortando!');
define('ZENCART_INVALID_SKU','Error con la identificación del código de inventario.  No se pudo encontrar el registro en la base de datos');

// Javascrpt Defines

// Audit Log Messages
define('ZENCART_UPLOAD_PRODUCT','Subir Productos a ZenCart');
define('ZENCART_BULK_UPLOAD','Subir un bloque de productos a ZenCart');
define('ZENCART_PRODUCT_SYNC','Sincronización de productos con ZenCart');
define('ZENCART_SHIP_CONFIRM','Confirmacíon de Envío de ZenCart');

?>
