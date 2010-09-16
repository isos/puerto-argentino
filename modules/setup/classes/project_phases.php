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
//  Path: /modules/setup/classes/project_phases.php
//

class project_phases {

  function project_phases() {
  	$this->security_id   = $_SESSION['admin_security'][SECURITY_ID_PROJECT_PHASES];
	$this->db_table      = TABLE_PROJECTS_PHASES;
	$this->title         = SETUP_TITLE_PROJECTS_PHASES;
    $this->extra_buttons = false;
	$this->help_path     = '';
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
    $description_short = db_prepare_input($_POST['description_short']);
	$sql_data_array = array(
	  'description_short' => $description_short,
	  'description_long'  => db_prepare_input($_POST['description_long']),
	  'cost_type'         => db_prepare_input($_POST['cost_type']),
	  'cost_breakdown'    => isset($_POST['cost_breakdown']) ? '1' : '0',
	  'inactive'          => isset($_POST['inactive'])       ? '1' : '0',
	);
    if ($id) {
	  db_perform($this->db_table, $sql_data_array, 'update', "phase_id = '" . (int)$id . "'");
	  gen_add_audit_log(SETUP_PROJECT_PHASESS_LOG . TEXT_UPDATE, $description_short);
	} else  {
      db_perform($this->db_table, $sql_data_array);
	  gen_add_audit_log(SETUP_PROJECT_PHASESS_LOG . TEXT_ADD, $description_short);
	}
	return true;
  }

  function btn_delete() {
  	global $db, $messageStack;
	if ($this->security_id < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		return false;
	}
    $phase_id = db_prepare_input($_POST['rowSeq']);
/*
	// Check for this project phase being used in a journal entry, if so do not allow deletion
	$result = $db->Execute("select projects from " . TABLE_JOURNAL_ITEM . " 
		where projects like '%" . $phase_id . "%'");
	while (!$result->EOF) {
		$phase_ids = explode(':', $result->fields['projects']);
		for ($i = 0; $i < count($phase_ids); $i++) {
			if ($phase_id == $phase_ids[$i]) {
				$messageStack->add(SETUP_PROJECT_PHASESS_DELETE_ERROR,'error');
				return false;
			}
		}
		$result->MoveNext();
	}
*/
	// OK to delete
	$result = $db->Execute("select description_short from " . $this->db_table . " where phase_id = " . (int)$phase_id);
	$db->Execute("delete from " . $this->db_table . " where phase_id = " . (int)$phase_id);
	gen_add_audit_log(SETUP_PROJECT_PHASESS_LOG . TEXT_DELETE, $result->fields['description_short']);
	return true;
  }

  function build_main_html() {
  	global $db, $messageStack, $project_cost_types;
    // Build heading bar
	$output  = '<table border="0" width="100%" cellspacing="0" cellpadding="1">' . chr(10);
	$output .= '  <tr class="dataTableHeadingRow" valign="top">' . chr(10);
	$heading_array = array(
	  'description_short' => TEXT_SHORT_NAME,
	  'cost_type'         => TEXT_COST_TYPE,
	  'cost_breakdown'    => TEXT_COST_BREAKDOWN,
	  'inactive'          => TEXT_INACTIVE,
	);
	$result = html_heading_bar($heading_array, $_GET['list_order']);
	$output .= $result['html_code'];
	$disp_order = $result['disp_order'];
    $output .= '  </tr>' . chr(10);
	// Build field data
    $query_raw = "select phase_id, description_short, cost_type, cost_breakdown, inactive 
	from " . $this->db_table . " order by $disp_order";
    $page_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
    $result = $db->Execute($query_raw);
    while (!$result->EOF) {
      $output .= '  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . chr(10);
      $output .= '    <td class="dataTableContent" onclick="loadPopUp(\'edit\', ' . $result->fields['phase_id'] . ')">' . htmlspecialchars($result->fields['description_short']) . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" onclick="loadPopUp(\'edit\', ' . $result->fields['phase_id'] . ')">' . $project_cost_types[$result->fields['cost_type']] . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" onclick="loadPopUp(\'edit\', ' . $result->fields['phase_id'] . ')">' . ($result->fields['cost_breakdown'] ? TEXT_YES : '') . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" onclick="loadPopUp(\'edit\', ' . $result->fields['phase_id'] . ')">' . ($result->fields['inactive'] ? TEXT_YES : '') . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" align="right">' . chr(10);
	  if ($this->security_id > 1) $output .= html_icon('actions/edit-find-replace.png', TEXT_EDIT,   'small', 'onclick="loadPopUp(\'edit\', ' . $result->fields['phase_id'] . ')"') . chr(10);
	  if ($this->security_id > 3) $output .= html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . SETUP_PROJECT_PHASES_DELETE_INTRO . '\')) submitSeq(' . $result->fields['phase_id'] . ', \'delete\')"') . chr(10);
      $output .= '    </td>' . chr(10);
      $output .= '  </tr>' . chr(10);
      $result->MoveNext();
    }
    $output .= '</table>' . chr(10);
    $output .= '<div class="page_count_right">' . $page_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']) . '</div>' . chr(10);
    $output .= '<div class="page_count">' . $page_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], SETUP_DISPLAY_NUMBER_OF_PROJECT_PHASES) . '</div>' . chr(10);
	return $output;
  }

  function build_form_html($action, $id = '') {
    global $db, $project_cost_types;
    $sql = "select description_short, description_long, cost_type, cost_breakdown, inactive 
	    from " . $this->db_table . " where phase_id = '" . $id . "'";
    $result = $db->Execute($sql);
	$cInfo = new objectInfo($result->fields);

	$output  = '<table border="0" width="100%" cellspacing="0" cellpadding="1">' . chr(10);
	$output .= '  <tr class="dataTableHeadingRow">' . chr(10);
	$output .= '    <th colspan="2">' . ($action=='new' ? SETUP_INFO_HEADING_NEW_PROJECT_PHASES : SETUP_INFO_HEADING_EDIT_PROJECT_PHASES) . '</th>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td colspan="2">' . ($action=='new' ? SETUP_PROJECT_PHASES_INSERT_INTRO : SETUP_PROJECT_PHASES_EDIT_INTRO) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_DESC_SHORT . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('description_short', $cInfo->description_short, 'size="17" maxlength="16"') . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_DESC_LONG . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('description_long', $cInfo->description_long, 'size="50" maxlength="64"') . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_COST_TYPE . '</td>' . chr(10);
	$output .= '    <td>' . html_pull_down_menu('cost_type', gen_build_pull_down($project_cost_types), $cInfo->cost_type) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_COST_BREAKDOWN . '</td>' . chr(10);
	$output .= '    <td>' . html_checkbox_field('cost_breakdown', '', $cInfo->cost_breakdown) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . TEXT_INACTIVE . '</td>' . chr(10);
	$output .= '    <td>' . html_checkbox_field('inactive', '1', $cInfo->inactive ? true : false) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
    $output .= '</table>' . chr(10);
    return $output;
  }
}
?>