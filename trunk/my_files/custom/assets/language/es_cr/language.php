<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2008 PhreeSoft, LLC                               |
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
//  Path: /modules/assets/language/es_cr/language.php
//

// Headings 
define('BOX_ASSETS_MAINTAIN','Mantenimiento de Activos');
define('MENU_HEADING_ASSETS','Detalles de Activos');

// General Defines
define('TEXT_ASSETS','Activos');
define('TEXT_VEHICLE','Vehículo');
define('TEXT_BUILDING','Edificio');
define('TEXT_FURNITURE','Mueble');
define('TEXT_COMPUTER','Computador');
define('TEXT_LAND','Lote');
define('TEXT_SOFTWARE','Software');
define('TEXT_ASSET_ID','Activo No.');
//define('','');

//************ Assets defines *********************/
define('ASSETS_HEADING_NEW_ITEM','Activo Nuevo');
define('ASSETS_ENTER_ASSET_ID','Crear Activo Nuevo');
define('ASSETS_ENTRY_ASSET_TYPE','Tipo de Activo');
define('ASSETS_ENTRY_ASSETS_DESC_SHORT','Descripción Corta');
define('ASSETS_ENTRY_ASSETS_TYPE','Tipo de Activo');
define('ASSETS_ENTRY_FULL_PRICE','Costo Original');
define('ASSETS_ENTRY_ASSETS_DESC_PURCHASE','Descripción Detallada');
define('ASSETS_ENTRY_ACCT_SALES','Cuenta de Activos');
define('ASSETS_ENTRY_ACCT_INV','Cuenta de Depreciación');
define('ASSETS_ENTRY_ACCT_COS','Cuenta de Mantenimiento');
define('ASSETS_ENTRY_ASSETS_SERIALIZE','Número de Serie (o VIN)');
define('ASSETS_DATE_ACCOUNT_CREATION','Fecha de Compra');
define('ASSETS_DATE_LAST_UPDATE','Ultima Fecha de Mantenimiento');
define('ASSETS_DATE_LAST_JOURNAL_DATE','Fecha de Retiro');
define('ASSETS_ENTRY_SELECT_IMAGE','Imagen');
define('ASSETS_ENTRY_IMAGE_PATH','Ubicación de la Imagen');
define('ASSETS_MSG_COPY_INTRO','Activo No.');
define('ASSETS_MSG_RENAME_INTRO','Nuevo número de activo.');

//************ admin defines *************/
define('MODULE_ASSET_GEN_INFO','Herramientas para la Administración del Administrador de Activos. Seleccione una acción:');
define('MODULE_ASSET_INSTALL_INFO','Instale el Módulo Administrador de Activos');
define('MODULE_ASSET_REMOVE_INFO','Desinstale el Módulo Administrador de Activos');
define('MODULE_ASSET_REMOVE_CONFIRM','¿Está seguro que quiere desinstalar el Módulo Administrador de Activos?');
define('MODULE_ASSET_SAVE_FILES','Borre también los archivos del directorio my_files');

//************ Asset Field manager *********/
define('ASSETS_FIELD_HEADING_TITLE','Administrador de Campos de Base de Datos de Activos');
define('ASSETS_DELETE_INTRO_FIELDS','¿Está seguro que quiere eliminar este campo de la base de datos de activos?');

// Error Messages
define('ASSETS_ERROR_INSTALL_MSG','¡Hubo un error durante la instalación!');

// Javascrpt defines
define('ASSETS_MSG_DELETE_ASSET','¿Está seguro que quiere eliminar este activo?');

// Asset Selection defines
// the asset type indexes should not be changed or the asset module won't work.
$assets_types = array(
	'vh' => TEXT_VEHICLE,
	'bd' => TEXT_BUILDING,
	'fn' => TEXT_FURNITURE,
	'pc' => TEXT_COMPUTER,
	'ld' => TEXT_LAND,
	'sw' => TEXT_SOFTWARE,
);


?>
