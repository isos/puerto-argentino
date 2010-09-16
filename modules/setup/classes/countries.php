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
//  Path: /modules/setup/classes/countries.php
//

class countries {

  function countries() {
  	$this->security_id = $_SESSION['admin_security'][SECURITY_ID_COUNTRIES];
	$this->db_table = TABLE_COUNTRIES;
	$this->title = SETUP_TITLE_COUNTRIES;
    $this->extra_buttons = false;
	$this->help_path = '07.08';
  }

  function customize_buttons() {
  	global $toolbar;
//	$toolbar->add_icon('update', 'onclick="submitToDo(\'update\')"', $order = 10);
//	$toolbar->icon_list['update']['text'] = 'Text override here';
  }

  function btn_save($id = '') {
  	global $db, $messageStack;
	if ($this->security_id < 2) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		return false;
	}
    $countries_name = db_prepare_input($_POST['countries_name']);
	$sql_data_array = array(
		'countries_name' => $countries_name,
		'countries_iso_code_2' => db_prepare_input($_POST['countries_iso_code_2']),
		'countries_iso_code_3' => db_prepare_input($_POST['countries_iso_code_3']),
		'address_format_id' => db_prepare_input($_POST['address_format_id']));
    if ($id) {
	  db_perform($this->db_table, $sql_data_array, 'update', "countries_id = " . (int)$id);
      gen_add_audit_log(SETUP_LOG_COUNTRIES . TEXT_UPDATE, $countries_name);
	} else  {
      db_perform($this->db_table, $sql_data_array);
	  gen_add_audit_log(SETUP_LOG_COUNTRIES . TEXT_ADD, $countries_name);
	}
	return true;
  }

  function btn_delete() {
  	global $db, $messageStack;
	if ($this->security_id < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		return false;
	}
    $countries_id = db_prepare_input($_POST['rowSeq']);
	$result = $db->Execute("select countries_name from " . $this->db_table . " where countries_id = " . (int)$countries_id);
	$db->Execute("delete from " . $this->db_table . " where countries_id = " . (int)$countries_id);
	gen_add_audit_log(SETUP_LOG_COUNTRIES . TEXT_DELETE, $result->fields['countries_name']);
	return true;
  }

  function build_main_html() {
  	global $db, $messageStack;
    // Build heading bar
	$output  = '<table border="0" width="100%" cellspacing="0" cellpadding="1">' . chr(10);
	$output .= '  <tr class="dataTableHeadingRow" valign="top">' . chr(10);
	$heading_array = array(
		'countries_name' => SETUP_INFO_COUNTRY_NAME,
		'countries_iso_code_2' => SETUP_INFO_COUNTRY_CODE_2,
		'countries_iso_code_3' => SETUP_INFO_COUNTRY_CODE_3);
	$result = html_heading_bar($heading_array, $_GET['list_order']);
	$output .= $result['html_code'];
	$disp_order = $result['disp_order'];
    $output .= '  </tr>' . chr(10);
	// Build field data
    $query_raw = "select countries_id, countries_name, countries_iso_code_2, countries_iso_code_3  
        from " . $this->db_table . " order by $disp_order";
    $page_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
    $result = $db->Execute($query_raw);
    while (!$result->EOF) {
      $output .= '  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . chr(10);
      $output .= '    <td class="dataTableContent" onclick="loadPopUp(\'edit\', ' . $result->fields['countries_id'] . ')">' . htmlspecialchars($result->fields['countries_name']) . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" onclick="loadPopUp(\'edit\', ' . $result->fields['countries_id'] . ')">' . $result->fields['countries_iso_code_2'] . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" onclick="loadPopUp(\'edit\', ' . $result->fields['countries_id'] . ')">' . $result->fields['countries_iso_code_3'] . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" align="right">' . chr(10);
	  if ($this->security_id > 1) $output .= html_icon('actions/edit-find-replace.png', TEXT_EDIT, 'small', 'onclick="loadPopUp(\'edit\', ' . $result->fields['countries_id'] . ')"') . chr(10);
	  if ($this->security_id > 3) $output .= html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . SETUP_COUNTRY_DELETE_INTRO . '\')) submitSeq(' . $result->fields['countries_id'] . ', \'delete\')"') . chr(10);
      $output .= '    </td>' . chr(10);
      $output .= '  </tr>' . chr(10);
      $result->MoveNext();
    }
    $output .= '</table>' . chr(10);
    $output .= '<div class="page_count_right">' . $page_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']) . '</div>' . chr(10);
    $output .= '<div class="page_count">' . $page_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_COUNTRIES) . '</div>' . chr(10);
	return $output;
  }

  function build_form_html($action, $id = '') {
    global $db;
    $sql = "select countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id 
	    from " . $this->db_table . " where countries_id = " . $id;
    $result = $db->Execute($sql);
	if ($action == 'new') {
	  $cInfo = '';
	} else {
      $cInfo = new objectInfo($result->fields);
	}
	$output  = '<table border="0" width="100%" cellspacing="0" cellpadding="1">' . chr(10);
	$output .= '  <tr class="dataTableHeadingRow">' . chr(10);
	$output .= '    <th colspan="2">' . ($action=='new' ? SETUP_INFO_HEADING_NEW_COUNTRY : SETUP_INFO_HEADING_EDIT_COUNTRY) . '</th>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td colspan="2">' . ($action=='new' ? SETUP_COUNTRY_INSERT_INTRO : SETUP_COUNTRY_EDIT_INTRO) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_COUNTRY_NAME . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('countries_name', $cInfo->countries_name) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_COUNTRY_CODE_2 . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('countries_iso_code_2', $cInfo->countries_iso_code_2) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_COUNTRY_CODE_3 . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('countries_iso_code_3', $cInfo->countries_iso_code_3) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
    $output .= '</table>' . chr(10);
    return $output;
  }

}
?>