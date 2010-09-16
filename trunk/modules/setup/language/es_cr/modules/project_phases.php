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
//  Path: /modules/setup/language/es_cr/modules/project_phases.php
//

define('SETUP_TITLE_PROJECTS_PHASES', 'Fases de Proyecto');

define('TEXT_SHORT_NAME', 'Nombre Corto');
define('TEXT_COST_TYPE', 'Tipo de Costo');
define('TEXT_COST_BREAKDOWN', 'Desglose de Costo');

define('SETUP_PROJECT_PHASES_EDIT_INTRO', 'Haga los cambios necesarios');
define('SETUP_INFO_DESC_SHORT', 'Descripción Corta (Máx 16 caract.)');
define('SETUP_INFO_DESC_LONG', 'Descripción Larga (Máx 64 caract.)');
define('SETUP_INFO_COST_BREAKDOWN', '¿Va a desglosar los costos de esta fase?');
define('SETUP_PROJECT_PHASES_INSERT_INTRO', 'Digite una nueva fase de proyecto y sus características');
define('SETUP_PROJECT_PHASES_DELETE_INTRO', '¿Está seguro que quiere borrar esta fase de proyecto?');
define('SETUP_INFO_HEADING_NEW_PROJECT_PHASES', 'Fase de Proyecto Nueva');
define('SETUP_INFO_HEADING_EDIT_PROJECT_PHASES', 'Edite Fase de Proyecto');
define('SETUP_INFO_COST_TYPE','Tipo de Costo (si no va a desglosar los costos)');
define('SETUP_PROJECT_PHASESS_LOG','Fases de Proyecto - ');
define('SETUP_PROJECT_PHASESS_DELETE_ERROR','¡No se puede borrar esta fase de proyecto, está ligada a una transacción contable!');

define('SETUP_DISPLAY_NUMBER_OF_PROJECT_PHASES', TEXT_DISPLAY_NUMBER . 'fases de proyecto');

define('COST_TYPE_LBR','Mano de Obra');
define('COST_TYPE_MAT','Materiales');
define('COST_TYPE_CNT','Sub-Contratistas');
define('COST_TYPE_EQT','Equipo');
define('COST_TYPE_OTH','Otro');

$project_cost_types = array(
 'LBR' => COST_TYPE_LBR,
 'MAT' => COST_TYPE_MAT,
 'CNT' => COST_TYPE_CNT,
 'EQT' => COST_TYPE_EQT,
 'OTH' => COST_TYPE_OTH,
)
?>
