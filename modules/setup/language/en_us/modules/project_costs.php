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
//  Path: /modules/setup/language/en_us/modules/project_costs.php
//

define('SETUP_TITLE_PROJECTS_COSTS', 'Project Costs');

define('TEXT_SHORT_NAME', 'Short Name');
define('TEXT_COST_TYPE', 'Cost Type');

define('SETUP_PROJECT_COSTS_EDIT_INTRO', 'Please make any necessary changes');
define('SETUP_INFO_DESC_SHORT', 'Short Name (16 chars max)');
define('SETUP_INFO_DESC_LONG', 'Long Description (64 chars max)');
define('SETUP_PROJECT_COSTS_INSERT_INTRO', 'Please enter the new project cost with its properties');
define('SETUP_PROJECT_COSTS_DELETE_INTRO', 'Are you sure you want to delete this project cost?');
define('SETUP_INFO_HEADING_NEW_PROJECT_COSTS', 'New Project Cost');
define('SETUP_INFO_HEADING_EDIT_PROJECT_COSTS', 'Edit Project Cost');
define('SETUP_INFO_COST_TYPE','Cost Type');
define('SETUP_PROJECT_COSTS_LOG','Project Costs - ');
define('SETUP_PROJECT_COSTS_DELETE_ERROR','Cannot delete this project cost, it is being use in a journal entry.');

define('SETUP_DISPLAY_NUMBER_OF_PROJECT_COSTS', TEXT_DISPLAY_NUMBER . 'project costs');

define('COST_TYPE_LBR','Labor');
define('COST_TYPE_MAT','Materials');
define('COST_TYPE_CNT','Contractors');
define('COST_TYPE_EQT','Equipment');
define('COST_TYPE_OTH','Other');

$project_cost_types = array(
 'LBR' => COST_TYPE_LBR,
 'MAT' => COST_TYPE_MAT,
 'CNT' => COST_TYPE_CNT,
 'EQT' => COST_TYPE_EQT,
 'OTH' => COST_TYPE_OTH,
)
?>