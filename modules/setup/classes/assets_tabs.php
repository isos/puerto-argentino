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
//  Path: /modules/setup/classes/assets_tabs.php
//

class assets_tabs {

  function assets_tabs() {
    global $db, $messageStack;
  	$this->security_id = $_SESSION['admin_security'][SECURITY_ASSET_MGT_TABS];
	$this->db_table = TABLE_ASSETS_TABS;
	$this->title = BOX_ASSET_MODULE_TABS;
    $this->extra_buttons = false;
	$this->help_path = '';

	// make sure the module is installed
	$result = $db->Execute("SHOW TABLES LIKE '" . TABLE_ASSETS . "'");
	if ($result->RecordCount() == 0) {
	  $messageStack->add_session(ASSET_MGR_NOT_INSTALLED,'caution');
	  gen_redirect(html_href_link(FILENAME_DEFAULT, 'cat=assets&amp;module=admin', 'SSL'));
	}


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
    $category_name = db_prepare_input($_POST['category_name']);

	$sql_data_array = array(
		'category_name' => db_prepare_input($_POST['category_name']),
		'category_description' => db_prepare_input($_POST['category_description']),
		'sort_order' => db_prepare_input($_POST['sort_order']));
    if ($id) {
	  db_perform($this->db_table, $sql_data_array, 'update', "category_id = " . $id);
      gen_add_audit_log(ASSETS_TABS_LOG . TEXT_UPDATE, $category_name);
	} else {
	  // Test for duplicates.
	  $result = $db->Execute("select category_id from " . TABLE_INVENTORY_CATEGORIES . " where category_name = '" . $category_name . "'");
	  if ($result->RecordCount() > 0) {
	  	$messageStack->add(ASSETS_INFO_DELETE_ERROR,'error');
		return false;
	  }
	  $sql_data_array['category_id'] = db_prepare_input($_POST['rowSeq']);
      db_perform($this->db_table, $sql_data_array);
	  gen_add_audit_log(ASSETS_TABS_LOG . TEXT_ADD, $category_name);
	}
	return true;
  }

  function btn_delete() {
  	global $db, $messageStack;
	if ($this->security_id < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		return false;
	}
	$id = (int)db_prepare_input($_POST['rowSeq']);
	$result = $db->Execute("select field_name from " . TABLE_ASSETS_FIELDS . " where category_id = " . $id);
	if ($result->RecordCount() > 0) {
		$messageStack->add(ASSETS_CATEGORY_CANNOT_DELETE . $result->fields['field_name'],'error');
		return false;
	}
	$result = $db->Execute("select category_name from " . $this->db_table . " where category_id = " . (int)$id);
	$db->Execute("delete from " . TABLE_ASSETS_TABS . " where category_id = " . $id);
	gen_add_audit_log(ASSETS_TABS_LOG . TEXT_DELETE, $result->fields['category_name']);
	return true;
  }

  function build_main_html() {
  	global $db, $messageStack;
    // Build heading bar
	$output  = '<table border="0" width="100%" cellspacing="0" cellpadding="1">' . chr(10);
	$output .= '  <tr class="dataTableHeadingRow" valign="top">' . chr(10);
	$heading_array = array(
		'category_name' => ASSETS_HEADING_CATEGORY_NAME,
		'category_description' => TEXT_DESCRIPTION,
		'sort_order' => TEXT_SORT_ORDER);
	$result = html_heading_bar($heading_array, $_GET['list_order']);
	$output .= $result['html_code'];
	$disp_order = $result['disp_order'];
    $output .= '  </tr>' . chr(10);
	// Build field data
    $query_raw = "select category_id, category_name, category_description, sort_order from " . $this->db_table . " order by $disp_order";
    $page_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
    $result = $db->Execute($query_raw);
    while (!$result->EOF) {
      $output .= '  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . chr(10);
      $output .= '    <td class="dataTableContent" onclick="loadPopUp(\'edit\', \'' . $result->fields['category_id'] . '\')">' . htmlspecialchars($result->fields['category_name']) . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" onclick="loadPopUp(\'edit\', \'' . $result->fields['category_id'] . '\')">' . htmlspecialchars($result->fields['category_description']) . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" onclick="loadPopUp(\'edit\', \'' . $result->fields['category_id'] . '\')">' . $result->fields['sort_order'] . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" align="right">' . chr(10);
	  if ($this->security_id > 1) $output .= html_icon('actions/edit-find-replace.png', TEXT_EDIT, 'small', 'onclick="loadPopUp(\'edit\', \'' . $result->fields['category_id'] . '\')"') . chr(10);
	  if ($this->security_id > 3) $output .= html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . ASSETS_INFO_DELETE_INTRO . '\')) submitSeq(\'' . $result->fields['category_id'] . '\', \'delete\')"') . chr(10);
      $output .= '    </td>' . chr(10);
      $output .= '  </tr>' . chr(10);
      $result->MoveNext();
    }
    $output .= '</table>' . chr(10);
    $output .= '<div class="page_count_right">' . $page_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']) . '</div>' . chr(10);
    $output .= '<div class="page_count">' . $page_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_CATEGORIES) . '</div>' . chr(10);
	return $output;
  }

  function build_form_html($action, $id = '') {
    global $db;
    $sql = "select category_id, category_name, category_description, sort_order from " . $this->db_table . " where category_id = " . $id;
    $result = $db->Execute($sql);
	if ($action == 'new') {
	  $cInfo = '';
	} else {
      $cInfo = new objectInfo($result->fields);
	}
	$output  = '<table border="0" width="100%" cellspacing="0" cellpadding="1">' . chr(10);
	$output .= '  <tr class="dataTableHeadingRow">' . chr(10);
	$output .= '    <th colspan="2">' . ($action=='new' ? ASSETS_INFO_HEADING_NEW_CATEGORY : ASSETS_INFO_HEADING_EDIT_CATEGORY) . '</th>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td colspan="2">' . ($action=='new' ? ASSETS_INFO_INSERT_INTRO : ASSETS_EDIT_INTRO) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . ASSETS_INFO_CATEGORY_NAME . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('category_name', $cInfo->category_name) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . ASSETS_INFO_CATEGORY_DESCRIPTION . '</td>' . chr(10);
	$output .= '    <td>' . html_textarea_field('category_description', 30, 10, $cInfo->category_description) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . TEXT_SORT_ORDER . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('sort_order', $cInfo->sort_order) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
    $output .= '</table>' . chr(10);
    return $output;
  }
}
?>