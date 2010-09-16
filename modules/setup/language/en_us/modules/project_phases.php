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
//  Path: /modules/setup/language/en_us/modules/project_phases.php
//

define('SETUP_TITLE_PROJECTS_PHASES', 'Project Phases');

define('TEXT_SHORT_NAME', 'Short Name');
define('TEXT_COST_TYPE', 'Cost Type');
define('TEXT_COST_BREAKDOWN', 'Cost Breakdown');

define('SETUP_PROJECT_PHASES_EDIT_INTRO', 'Please make any necessary changes');
define('SETUP_INFO_DESC_SHORT', 'Short Name (16 chars max)');
define('SETUP_INFO_DESC_LONG', 'Long Description (64 chars max)');
define('SETUP_INFO_COST_BREAKDOWN', 'Use Cost Breakdowns for this phase?');
define('SETUP_PROJECT_PHASES_INSERT_INTRO', 'Please enter the new project phase with its properties');
define('SETUP_PROJECT_PHASES_DELETE_INTRO', 'Are you sure you want to delete this project phase?');
define('SETUP_INFO_HEADING_NEW_PROJECT_PHASES', 'New Project Phase');
define('SETUP_INFO_HEADING_EDIT_PROJECT_PHASES', 'Edit Project Phase');
define('SETUP_INFO_COST_TYPE','Cost Type (if not using cost breakdowns)');
define('SETUP_PROJECT_PHASESS_LOG','Project Phases - ');
define('SETUP_PROJECT_PHASESS_DELETE_ERROR','Cannot delete this project phase, it is being use in a journal entry.');

define('SETUP_DISPLAY_NUMBER_OF_PROJECT_PHASES', TEXT_DISPLAY_NUMBER . 'project phases');

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