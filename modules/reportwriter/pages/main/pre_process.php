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
//  Path: /modules/reportwriter/pages/main/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_REPORTS];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING . 'functions/builder_functions.php');

/**************   page specific initialization  *************************/
$action = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/reportwriter/main/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   hook for custom operations  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/reportwriter/extra_operations.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  default:
}

/*****************   prepare to display templates  *************************/
// load the report security tokens
$rr_security = array();
$result = $db->Execute("select reportid, params from " . TABLE_REPORT_FIELDS . " where entrytype = 'security'");
while (!$result->EOF) {
  $rr_security[$result->fields['reportid']] = $result->fields['params'];
  $result->MoveNext();
}

$query_raw = "select id, description, groupname, standard_report
	from " . TABLE_REPORTS . " order by groupname, standard_report desc, description";
$definitions = $db->Execute($query_raw);
// build form list array by groupname
$form_array = array();
while (!$definitions->EOF) {
  // prep the form arrays
  $element = explode(':', $definitions->fields['groupname']);
  if (isset($element[1])) {
	  $form_array[$element[0]]['children'][$element[1]]['desc'] = $FormGroups[$definitions->fields['groupname']];
	  $form_array[$element[0]]['children'][$element[1]]['children'][$definitions->fields['id']]['desc'] = $definitions->fields['description'];
  }
  $definitions->MoveNext();
}

$include_header = true; // include header flag
$include_footer = true; // include footer flag
$include_tabs = true;
$include_calendar = false;

$include_template = 'template_main.php'; // include display template (required)
define('PAGE_TITLE', RW_HEADING_TITLE);

?>