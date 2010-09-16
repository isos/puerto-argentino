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
//  Path: /modules/rma/language/es_cr/language.php
// RMA  Autorización para Devolver Mercadería

// Headings 
define('BOX_RMA_MAINTAIN','RMA - Control de Garantías a Clientes');
define('MENU_HEADING_RMA','Detalles de Garantías a Clientes (RMA)');
define('MENU_HEADING_NEW_RMA','Reclamo de Garantía Nueva (RMA)');

// General Defines
define('TEXT_RMAS','Garantías (RMA)');
define('TEXT_RMA_ID','Número de RMA');
define('TEXT_ASSIGNED_BY_SYSTEM',' (Asignado por el Sistema)');
define('TEXT_CREATION_DATE','Creado');
define('TEXT_CLOSED_DATE','Resuelto');
define('TEXT_PURCHASE_INVOICE_ID','Factura #');
define('TEXT_CREATION_DATE','Fecha de Reclamo');
define('TEXT_CLOSED_DATE','Fecha de Resolución');
define('TEXT_CALLER_NAME','Cliente');
define('TEXT_CALLER_TELEPHONE1','Teléfono');
define('TEXT_CALLER_EMAIL','Correo Electrónico');
define('TEXT_CALLER_NOTES','Comentarios del Cliente');
define('TEXT_DETAILS','Detalles');
define('TEXT_REASON_FOR_RETURN','Razón para la Devolución');
define('TEXT_ENTERED_BY','Digitado Por');
define('TEXT_RECEIVE_DATE','Recibido');
define('TEXT_RECEIVED_BY','Recibido por');
define('TEXT_RECEIVE_CARRIER','Transportista');
define('TEXT_RECEIVE_TRACKING_NUM','Número de paquete');
define('TEXT_RECEIVE_NOTES','Comentarios del que lo recibió');

//************ RMA admin defines *************/
define('MODULE_RMA_GEN_INFO','RMA - Herramientas para la Administración del Módulo.  Seleccione una acción:');
define('MODULE_RMA_INSTALL_INFO','Instale el Módulo RMA');
define('MODULE_RMA_REMOVE_INFO','Desinstale el Módulo RMA');
define('MODULE_RMA_REMOVE_CONFIRM','Está seguro que quiere desinstalar el Módulo RMA?');
define('MODULE_RMA_SAVE_FILES','También elimine los archivos de my_files directory');
define('RMAS_ERROR_DELETE_MSG','La base de datos ha sido eliminada.  Para eliminar completamente el módulo, elimine todos los archivos de la carpeta /my_files/custom/rma y el archivo de configuración /my_files/custom/extra_menus/rma.php');

// Error Messages
define('RMA_ERROR_INSTALL_MSG','¡Hubo un error durante la instalación!');

// Javascrpt defines
define('RMA_MSG_DELETE_RMA','¿Está seguro que quiere borrar esta Garantía (RMA)?');
define('RMA_ROW_DELETE_ALERT','¿Está seguro que quiere borrar el ítem de este renglón?');

// audit log messages
define('RMA_LOG_USER_ADD','RMA Creado - RMA # ');
define('RMA_LOG_USER_UPDATE','RMA Actualizado - RMA # ');
define('RMA_MESSAGE_SUCCESS_ADD','Creado exitosamente RMA # ');
define('RMA_MESSAGE_SUCCESS_UPDATE','Actualizado exitosamente RMA # ');
define('RMA_MESSAGE_ERROR','Hubo un error creando/actualizando el RMA.');
define('RMA_MESSAGE_DELETE','El RMA se borró exitosamente.');
define('RMA_ERROR_CANNOT_DELETE','Hubo un error borrando el RMA.');

//  codes for status and RMA reason
$status_codes = array(
  '0'  => 'Seleccione el estatus...', // do not remove from top position
  '1'  => 'RMA Creado/Esperando repuesto',
  '2'  => 'Repuesto Recibido',
  '3'  => 'En Inspección',
  '4'  => 'Resolviendo',
  '5'  => 'Siendo Probado',
  '6'  => 'Esperando Acreditar la Cuenta del Cliente',
  '7'  => 'Resuelto - Remplazado',
//'8'  => 'Code Available',
  '90' => 'Resuelto - No se recibió',
  '99' => 'Resuelto',
);

$reason_codes = array(
  '0'  => 'Seleccione la razón del RMA ...', // do not remove from top position
  '1'  => 'El cliente no lo necesitó',
  '2'  => 'Compró el artículo equivocado',
  '3'  => 'No es compatible',
  '4'  => 'Defectuoso/Reemplazado',
  '5'  => 'Dañado en tránsito',
//'6'  => 'Code Available',
//'7'  => 'Code Available',
  '80' => 'Conector equivocado',
  '99' => 'Otro (Especifique en las notas)',
);

$action_codes = array(
  '0'  => 'Seleccione Acción...', // do not remove from top position
  '1'  => 'Devuelto a Inventario',
  '2'  => 'Devuelto a Cliente',
  '3'  => 'Pruebe y Reemplace',
  '4'  => 'Reemplazado bajo garantía',
  '5'  => 'Pérdida',
//'6'  => 'Code Available',
//'7'  => 'Code Available',
  '99' => 'Otro (Especifique en las notas)',
);

?>
