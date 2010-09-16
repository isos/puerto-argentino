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
//  Path: /modules/setup/language/es_cr/modules/project_costs.php
//

define('SETUP_TITLE_PROJECTS_COSTS', 'Costos De Proyecto');

define('TEXT_SHORT_NAME', 'Nombre Corto');
define('TEXT_COST_TYPE', 'Tipo de Costo');

define('SETUP_PROJECT_COSTS_EDIT_INTRO', 'Haga los cambios necesarios');
define('SETUP_INFO_DESC_SHORT', 'Descripción Corta (máx 16 caract.)');
define('SETUP_INFO_DESC_LONG', 'Descripción Larga (máx 64 caract.)');
define('SETUP_PROJECT_COSTS_INSERT_INTRO', 'Digite el costo de proyecto nuevo y sus características');
define('SETUP_PROJECT_COSTS_DELETE_INTRO', '¿Está seguro que quiere borrar este costo de proyecto?');
define('SETUP_INFO_HEADING_NEW_PROJECT_COSTS', 'Costo de Proyecto Nuevo');
define('SETUP_INFO_HEADING_EDIT_PROJECT_COSTS', 'Edite el Costo de Proyecto');
define('SETUP_INFO_COST_TYPE','Tipo de Costo');
define('SETUP_PROJECT_COSTS_LOG','Costos de Proyecto - ');
define('SETUP_PROJECT_COSTS_DELETE_ERROR','¡No se puede borrar este costo de proyecto, está ligado a transacciones contables!');

define('SETUP_DISPLAY_NUMBER_OF_PROJECT_COSTS', TEXT_DISPLAY_NUMBER . 'costos de proyecto');

define('COST_TYPE_LBR','Mano de Obra');
define('COST_TYPE_MAT','Materiales');
define('COST_TYPE_CNT','Sub-Contratistas');
define('COST_TYPE_EQT','Equipo');
define('COST_TYPE_OTH','Otros');

$project_cost_types = array(
 'LBR' => COST_TYPE_LBR,
 'MAT' => COST_TYPE_MAT,
 'CNT' => COST_TYPE_CNT,
 'EQT' => COST_TYPE_EQT,
 'OTH' => COST_TYPE_OTH,
)
?>
