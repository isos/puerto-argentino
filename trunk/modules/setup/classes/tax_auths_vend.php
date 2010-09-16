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
//  Path: /modules/setup/classes/tax_auths_vend.php
//

class tax_auths_vend {

  function tax_auths_vend() {
  	$this->security_id = $_SESSION['admin_security'][SECURITY_ID_TAX_AUTHS_VEND];
	$this->db_table = TABLE_TAX_AUTH;
	$this->title = SETUP_TITLE_TAX_AUTHS_VEND;
    $this->extra_buttons = false;
	$this->help_path = '07.08.03.01';
	$this->type = 'v'; // choices are c for customers and v for vendors
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
		'type'              => $this->type,
		'description_short' => $description_short,
		'description_long'  => db_prepare_input($_POST['description_long']),
		'account_id'        => db_prepare_input($_POST['account_id']),
		'vendor_id'         => db_prepare_input($_POST['vendor_id']),
		'tax_rate'          => db_prepare_input($_POST['tax_rate']),
	);
    if ($id) {
	  db_perform($this->db_table, $sql_data_array, 'update', "tax_auth_id = '" . (int)$id . "'");
	  gen_add_audit_log(SETUP_TAX_AUTHS_LOG . TEXT_UPDATE, $description_short);
	} else  {
      db_perform($this->db_table, $sql_data_array);
	  gen_add_audit_log(SETUP_TAX_AUTHS_LOG . TEXT_ADD, $description_short);
	}
	return true;
  }

  function btn_delete() {
  	global $db, $messageStack;
	if ($this->security_id < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		return false;
	}
    $tax_auth_id = db_prepare_input($_POST['rowSeq']);

	// Check for this authority being used in a tax rate calculation, if so do not delete
	$result = $db->Execute("select tax_auths from " . TABLE_JOURNAL_MAIN . " 
		where tax_auths like '%" . $tax_auth_id . "%'");
	while (!$result->EOF) {
		$auth_ids = explode(':', $result->fields['tax_auths']);
		for ($i = 0; $i < count($auth_ids); $i++) {
			if ($tax_auth_id == $auth_ids[$i]) {
				$messageStack->add(SETUP_TAX_AUTHS_DELETE_ERROR,'error');
				return false;
			}
		}
		$result->MoveNext();
	}

	// OK to delete
	$result = $db->Execute("select description_short from " . $this->db_table . " where tax_auth_id = " . (int)$tax_auth_id);
	$db->Execute("delete from " . $this->db_table . " where tax_auth_id = " . (int)$tax_auth_id);
	gen_add_audit_log(SETUP_TAX_AUTHS_LOG . TEXT_DELETE, $result->fields['description_short']);
	return true;
  }

  function build_main_html() {
  	global $db, $messageStack;
    // Build heading bar
	$output  = '<table border="0" width="100%" cellspacing="0" cellpadding="1">' . chr(10);
	$output .= '  <tr class="dataTableHeadingRow" valign="top">' . chr(10);
	$heading_array = array(
		'description_short' => SETUP_TAX_DESC_SHORT,
		'account_id'        => SETUP_TAX_GL_ACCT,
		'tax_rate'          => SETUP_TAX_RATE);
	$result = html_heading_bar($heading_array, $_GET['list_order']);
	$output .= $result['html_code'];
	$disp_order = $result['disp_order'];
    $output .= '  </tr>' . chr(10);
	// Build field data
    $query_raw = "select tax_auth_id, description_short, account_id, tax_rate 
	  from " . $this->db_table . " where type = '" . $this->type . "' order by $disp_order";
    $page_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
    $result = $db->Execute($query_raw);
    while (!$result->EOF) {
      $output .= '  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . chr(10);
      $output .= '    <td class="dataTableContent" onclick="loadPopUp(\'edit\', ' . $result->fields['tax_auth_id'] . ')">' . htmlspecialchars($result->fields['description_short']) . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" onclick="loadPopUp(\'edit\', ' . $result->fields['tax_auth_id'] . ')">' . gen_get_type_description(TABLE_CHART_OF_ACCOUNTS, $result->fields['account_id']) . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" onclick="loadPopUp(\'edit\', ' . $result->fields['tax_auth_id'] . ')">' . $result->fields['tax_rate'] . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" align="right">' . chr(10);
	  if ($this->security_id > 1) $output .= html_icon('actions/edit-find-replace.png', TEXT_EDIT, 'small', 'onclick="loadPopUp(\'edit\', ' . $result->fields['tax_auth_id'] . ')"') . chr(10);
	  if ($this->security_id > 3) $output .= html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . SETUP_TAX_AUTH_DELETE_INTRO . '\')) submitSeq(' . $result->fields['tax_auth_id'] . ', \'delete\')"') . chr(10);
      $output .= '    </td>' . chr(10);
      $output .= '  </tr>' . chr(10);
      $result->MoveNext();
    }
    $output .= '</table>' . chr(10);
    $output .= '<div class="page_count_right">' . $page_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']) . '</div>' . chr(10);
    $output .= '<div class="page_count">' . $page_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], SETUP_DISPLAY_NUMBER_OF_TAX_AUTH) . '</div>' . chr(10);
	return $output;
  }

  function build_form_html($action, $id = '') {
    global $db;
    $sql = "select description_short, description_long, account_id, vendor_id, tax_rate 
	    from " . $this->db_table . " where tax_auth_id = " . $id;
    $result = $db->Execute($sql);
	if ($action == 'new') {
	  $cInfo = '';
	} else {
      $cInfo = new objectInfo($result->fields);
	}
	$output  = '<table border="0" width="100%" cellspacing="0" cellpadding="1">' . chr(10);
	$output .= '  <tr class="dataTableHeadingRow">' . chr(10);
	$output .= '    <th colspan="2">' . ($action=='new' ? SETUP_INFO_HEADING_NEW_TAX_AUTH : SETUP_INFO_HEADING_EDIT_TAX_AUTH) . '</th>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td colspan="2">' . ($action=='new' ? SETUP_TAX_AUTH_INSERT_INTRO : SETUP_TAX_AUTH_EDIT_INTRO) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_DESC_SHORT . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('description_short', $cInfo->description_short, 'size="16" maxlength="15"') . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_DESC_LONG . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('description_long', $cInfo->description_long, 'size="33" maxlength="64"') . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_GL_ACCOUNT . '</td>' . chr(10);
	$output .= '    <td>' . html_pull_down_menu('account_id', gen_coa_pull_down(), $cInfo->account_id) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_VENDOR_ID . '</td>' . chr(10);
	$output .= '    <td>' . html_pull_down_menu('vendor_id', gen_get_account_array_by_type('v'), $cInfo->vendor_id) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_TAX_RATE . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('tax_rate', $cInfo->tax_rate) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
    $output .= '</table>' . chr(10);
    return $output;
  }
}
?>