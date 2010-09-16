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
//  Path: /modules/services/import_export/language/es_cr/language.php
//

define('IE_HEADING_TITLE', 'Importar/Exportar');
define('IE_HEADING_TITLE_CRITERIA', 'Criterios para Importar/Exportar');
define('IE_POPUP_FIELD_TITLE','Parámetros de Campo para Importar/Exportar');
define('IE_HEADING_FIELDS_IMPORT', '¿Importar?');
define('IE_HEADING_CRITERIA', 'Criterios para Exportar');

define('IE_CRITERIA_FILTER_FIELD', 'Filtro para el Campo');
define('IE_CRITERIA_FILTER_ADD_FIELD', 'Agregue Nuevo Filtro para el Campo');

define('IE_INFO_NO_CRITERIA', '¡No hay criterios de filtro definidos!');
define('IE_INFO_DELETE_CONFIRM', '¿Está seguro que quiere borrar esta definición de importar/exportar?');
define('IE_ERROR_NO_DELETE', 'Esta es una definición estandard de importar/exportar.  ¡No se puede borrar!');
define('IE_ERROR_NO_NAME', '¡El nombre de una definición de Importar/Exportar no puede dejarse en blanco!');
define('IE_ERROR_DUPLICATE_NAME', 'Una definición de Importar/Exportar con este nombre ya existe.  ¡Inténtelo de nuevo!');

// Audit log messages
define('IE_LOG_MESSAGE','Importar/Exportar- ');

// General
define('IE_OPTIONS_GENERAL_SETTINGS', 'Configuración General');
define('IE_OPTIONS_DELIMITER', 'Delimitador');
define('IE_OPTIONS_QUALIFIER', 'Calificador de Texto');
define('IE_OPTIONS_IMPORT_SETTINGS', 'Configuración de Importe');
define('IE_OPTIONS_IMPORT_PATH', 'Localización del archivo de importe');
define('IE_OPTIONS_INCLUDE_NAMES', 'La primera fila es de encabezado');
define('IE_OPTIONS_EXPORT_SETTINGS', 'Configuración de Exporte');
define('IE_OPTIONS_EXPORT_PATH', 'Nombre del archivo de Exportación');
define('IE_OPTIONS_INCLUDE_FIELD_NAMES', 'Incluya el encabezado en la primera fila');

define('IE_DB_FIELD_NAME','Nombre del campo de la Base de Datos: ');
define('IE_FIELD_NAME','Nombre del Campo');
define('IE_PROCESSING','Procesando');
define('IE_INCLUDE','Incluya');

define('SRV_NO_DEF_SELECTED','No ha seleccionado ninguna definición de Importar/Exportar.  Seleccione una definición y vuelva a intentar.');
define('SRV_DELETE_CRITERIA','¿Está seguro que quiere borrar este criterio?');
define('SRV_DELETE_CONFIRM','¿Está seguro que quiere borrar esta definición de Importar/Exportar?');
define('SRV_JS_DEF_NAME','Digite el nombre para esta definición');
define('SRV_JS_DEF_DESC','Digite una descripción para esta definición');
define('SRV_JS_SEQ_NUM','Digite el nuevo número de secuencia para este registro.');

//************  For Import/Export Module, set the display tabs (DO NOT EDIT)  ********************
$tab_groups = array(
	'ar' => TEXT_RECEIVABLES,
	'ap' => TEXT_PAYABLES,
	'inv' => TEXT_INVENTORY,
	'hr' => TEXT_HR,
	'gl' => TEXT_GL,
	'bnk' => TEXT_BANKING,
	);
?>
