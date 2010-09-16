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
//  Path: /modules/setup/classes/dept_types.php
//

class dept_types {

  function dept_types() {
  	$this->security_id = $_SESSION['admin_security'][SECURITY_ID_DEPT_TYPES];
	$this->db_table = TABLE_DEPT_TYPES;
	$this->title = SETUP_TITLE_DEPT_TYPES;
    $this->extra_buttons = false;
	$this->help_path = '07.07.03';
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
    $description = db_prepare_input($_POST['description']);
	$sql_data_array = array('description' => $description);
    if ($id) {
	  db_perform($this->db_table, $sql_data_array, 'update', "id = '" . (int)$id . "'");
      gen_add_audit_log(SETUP_DEPT_TYPES_LOG . TEXT_UPDATE, $description);
	} else  {
      db_perform($this->db_table, $sql_data_array);
	  gen_add_audit_log(SETUP_DEPT_TYPES_LOG . TEXT_ADD, $description);
	}
	return true;
  }

  function btn_delete() {
  	global $db, $messageStack;
	if ($this->security_id < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		return false;
	}

    $id = db_prepare_input($_POST['rowSeq']);
	// Check for this department type being used in a department, if so do not delete
	$result = $db->Execute("select department_type from " . TABLE_DEPARTMENTS);
	while (!$result->EOF) {
		if ($id == $result->fields['department_type']) {
			$messageStack->add(SETUP_DEPT_TYPES_DELETE_ERROR,'error');
			return false;
		}
		$result->MoveNext();
	}

	// OK to delete
	$result = $db->Execute("select description from " . $this->db_table . " where id = '" . (int)$id . "'");
	$db->Execute("delete from " . $this->db_table . " where id = '" . (int)$id . "'");
	gen_add_audit_log(SETUP_DEPT_TYPES_LOG . TEXT_DELETE, $result->fields['description']);
	return true;
  }

  function build_main_html() {
  	global $db, $messageStack;
    // Build heading bar
	$output  = '<table border="0" width="100%" cellspacing="0" cellpadding="1">' . chr(10);
	$output .= '  <tr class="dataTableHeadingRow" valign="top">' . chr(10);
	$heading_array = array('description' => SETUP_INFO_DEPT_TYPES_NAME);
	$result = html_heading_bar($heading_array, $_GET['list_order']);
	$output .= $result['html_code'];
	$disp_order = $result['disp_order'];
    $output .= '  </tr>' . chr(10);
	// Build field data
    $query_raw = "select id, description from " . $this->db_table . " order by $disp_order";
    $page_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
    $result = $db->Execute($query_raw);
    while (!$result->EOF) {
      $output .= '  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . chr(10);
      $output .= '    <td class="dataTableContent" onclick="loadPopUp(\'edit\', \'' . $result->fields['id'] . '\')">' . htmlspecialchars($result->fields['description']) . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" align="right">' . chr(10);
	  if ($this->security_id > 1) $output .= html_icon('actions/edit-find-replace.png', TEXT_EDIT, 'small', 'onclick="loadPopUp(\'edit\', \'' . $result->fields['id'] . '\')"') . chr(10);
	  if ($this->security_id > 3) $output .= html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . SETUP_DEPT_TYPES_DELETE_INTRO . '\')) submitSeq(\'' . $result->fields['id'] . '\', \'delete\')"') . chr(10);
      $output .= '    </td>' . chr(10);
      $output .= '  </tr>' . chr(10);
      $result->MoveNext();
    }
    $output .= '</table>' . chr(10);
    $output .= '<div class="page_count_right">' . $page_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']) . '</div>' . chr(10);
    $output .= '<div class="page_count">' . $page_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_DEPT_TYPES) . '</div>' . chr(10);
	return $output;
  }

  function build_form_html($action, $id = '') {
    global $db;
    $sql = "select description from " . $this->db_table . " where id = '" . $id . "'";
    $result = $db->Execute($sql);
	if ($action == 'new') {
	  $cInfo = '';
	} else {
      $cInfo = new objectInfo($result->fields);
	}
	$output  = '<table border="0" width="100%" cellspacing="0" cellpadding="1">' . chr(10);
	$output .= '  <tr class="dataTableHeadingRow">' . chr(10);
	$output .= '    <th colspan="2">' . ($action=='new' ? SETUP_INFO_HEADING_NEW_DEPT_TYPES : SETUP_INFO_HEADING_EDIT_DEPT_TYPES) . '</th>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td colspan="2">' . ($action=='new' ? SETUP_DEPT_TYPES_INSERT_INTRO : SETUP_DEPT_TYPES_EDIT_INTRO) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_DEPT_TYPES_NAME . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('description', $cInfo->description) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
    $output .= '</table>' . chr(10);
    return $output;
  }
}
?>