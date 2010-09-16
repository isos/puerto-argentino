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
//  Path: /modules/services/import_export/language/en_us/language.php
//

define('IE_HEADING_TITLE', 'Import/Export Information');
define('IE_HEADING_TITLE_CRITERIA', 'Import/Export Criteria');
define('IE_POPUP_FIELD_TITLE','Import/Export Field Parameters');
define('IE_HEADING_FIELDS_IMPORT', 'Import?');
define('IE_HEADING_CRITERIA', 'Export Criteria');

define('IE_CRITERIA_FILTER_FIELD', 'Filter Field');
define('IE_CRITERIA_FILTER_ADD_FIELD', 'Add New Filter Field');

define('IE_INFO_NO_CRITERIA', 'There are no criteria filters defined!');
define('IE_INFO_DELETE_CONFIRM', 'Are you sure you want to delete this import/export definition?');
define('IE_ERROR_NO_DELETE', 'This is a standard import/export definition. It cannot be deleted!');
define('IE_ERROR_NO_NAME', 'Import/Export definition name cannot be blank!');
define('IE_ERROR_DUPLICATE_NAME', 'An import/export definition with this name already exists, please retry!');

// Audit log messages
define('IE_LOG_MESSAGE','Import/Export - ');

// General
define('IE_OPTIONS_GENERAL_SETTINGS', 'General Settings');
define('IE_OPTIONS_DELIMITER', 'Delimiter');
define('IE_OPTIONS_QUALIFIER', 'Text Qualifier');
define('IE_OPTIONS_IMPORT_SETTINGS', 'Import Settings');
define('IE_OPTIONS_IMPORT_PATH', 'Path to import file');
define('IE_OPTIONS_INCLUDE_NAMES', 'First row contains field names');
define('IE_OPTIONS_EXPORT_SETTINGS', 'Export Settings');
define('IE_OPTIONS_EXPORT_PATH', 'Export File Name');
define('IE_OPTIONS_INCLUDE_FIELD_NAMES', 'Include field name on first row');

define('IE_DB_FIELD_NAME','Database Field Name: ');
define('IE_FIELD_NAME','Field Name');
define('IE_PROCESSING','Processing');
define('IE_INCLUDE','Include');

define('SRV_NO_DEF_SELECTED','No Import/Export definition was selected, please select a definition and retry.');
define('SRV_DELETE_CRITERIA','Are you sure you want to delete this criteria?');
define('SRV_DELETE_CONFIRM','Are you sure you want to delete this Import/Export definition?');
define('SRV_JS_DEF_NAME','Enter a name for this definition');
define('SRV_JS_DEF_DESC','Enter a description for this definition');
define('SRV_JS_SEQ_NUM','Enter the sequence number to move this entry to.');

//************  For Import/Export Module, set the display tabs (DO NOT EDIT)  ********************
$tab_groups = array(
  'ar'  => TEXT_RECEIVABLES,
  'ap'  => TEXT_PAYABLES,
  'inv' => TEXT_INVENTORY,
  'hr'  => TEXT_HR,
  'gl'  => TEXT_GL,
  'bnk' => TEXT_BANKING,
);
?>