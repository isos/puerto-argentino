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
//  Path: /modules/setup/classes/chart_of_accounts.php
//

require(DIR_FS_MODULES . 'gen_ledger/functions/gen_ledger.php');

class chart_of_accounts {

  function chart_of_accounts() {
  	$this->security_id   = $_SESSION['admin_security'][SECURITY_ID_CHART_ACCOUNTS];
	$this->db_table      = TABLE_CHART_OF_ACCOUNTS;
	$this->title         = GL_POPUP_WINDOW_TITLE;
    $this->extra_buttons = false;
	$this->help_path     = '07.06.01';
  }

  function customize_buttons() {
  }

  function btn_save($id = '') {
  	global $db, $messageStack;
	if ($this->security_id < 2) {
	  $messageStack->add(ERROR_NO_PERMISSION,'error');
	  return false;
	}
	$description      = db_prepare_input($_POST['description']);
	$heading_only     = isset($_POST['heading_only']) ? '1' : '0';
	$primary_acct_id  = db_prepare_input($_POST['primary_acct_id']);
	$account_type     = db_prepare_input($_POST['account_type']);
	$account_inactive = isset($_POST['account_inactive']) ? '1' : '0';

	if ($account_type == '') {
	  $messageStack->add(ERROR_ACCT_TYPE_REQ,'error');
	  return false;
	}
	if ($heading_only && $id) { // see if this was a non-heading account converted to a heading account
	  $sql = "select max(debit_amount) as debit, max(credit_amount) as credit, max(beginning_balance) as beg_bal 
		from " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " where account_id = '" . $id . "'";
	  $result = $db->Execute($sql);
	  if ($result->fields['debit'] <> 0 || $result->fields['credit'] <> 0 || $result->fields['beg_bal'] <> 0) {
		$messageStack->add(GL_ERROR_CANT_MAKE_HEADING, 'error');
		return false;
	  }
	}

	$sql_data_array = array(
		'description'      => $description,
		'heading_only'     => $heading_only,
		'primary_acct_id'  => $primary_acct_id,
		'account_type'     => $account_type,
		'account_inactive' => $account_inactive,
	);
    if ($id) {
	  db_perform($this->db_table, $sql_data_array, 'update', "id = '" . $id . "'");
      gen_add_audit_log(GL_LOG_CHART_OF_ACCOUNTS . TEXT_UPDATE, $id);
	} else  {
	  $sql_data_array['id'] = db_prepare_input($_POST['id']);
      db_perform($this->db_table, $sql_data_array);
	  gen_add_audit_log(GL_LOG_CHART_OF_ACCOUNTS . TEXT_ADD, $id);
	}
	build_and_check_account_history_records(); // add/modify account to history table
	return true;
  }

  function btn_delete() {
  	global $db, $messageStack;
	if ($this->security_id < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		return false;
	}
    $id = db_prepare_input($_POST['rowSeq']);
	// Don't allow delete if there is account activity for this account
	$sql = "select max(debit_amount) as debit, max(credit_amount) as credit, max(beginning_balance) as beg_bal 
		from " . TABLE_CHART_OF_ACCOUNTS_HISTORY . " where account_id = '" . $id . "'";
	$result = $db->Execute($sql);
	if ($result->fields['debit'] <> 0 || $result->fields['credit'] <> 0 || $result->fields['beg_bal'] <> 0) {
		$messageStack->add(GL_ERROR_CANT_DELETE, 'error');
		return false;
	}
	// OK to delete
	$db->Execute("delete from " . $this->db_table . " where id = '" . $id . "'");
	modify_account_history_records($id, $add_acct = false);
	gen_add_audit_log(GL_LOG_CHART_OF_ACCOUNTS . TEXT_DELETE, $id);
	return true;
  }

  function build_main_html() {
  	global $db, $messageStack;
    // Build heading bar
	$output  = '<table border="0" width="100%" cellspacing="0" cellpadding="1">' . chr(10);
	$output .= '  <tr class="dataTableHeadingRow" valign="top">' . chr(10);
	$heading_array = array(
		'id'               => GL_HEADING_ACCOUNT_NAME,
		'description'      => TEXT_ACCT_DESCRIPTION,
		'account_type'     => GL_INFO_ACCOUNT_TYPE,
		'subaccount'       => GL_HEADING_SUBACCOUNT,
	);
	$result     = html_heading_bar($heading_array, $_GET['list_order']);
	$output    .= $result['html_code'];
	$disp_order = $result['disp_order'];
    $output    .= '  </tr>' . chr(10);
	// Build field data
    $query_raw = "select id, description, heading_only, primary_acct_id, account_type, account_inactive 
		from " . $this->db_table . " order by $disp_order";
    $page_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
    $result = $db->Execute($query_raw);
    while (!$result->EOF) {
	  $bkgnd = ($result->fields['account_inactive']) ? 'style="background-color:pink"' : '';
	  $account_type_desc = gen_get_type_description(TABLE_CHART_OF_ACCOUNTS_TYPES, $result->fields['account_type'], false);
      if ($result->fields['heading_only']) {
	    $account_type_desc = TEXT_HEADING;
		$bkgnd = 'style="background-color:#cccccc"';
	  }
	  $output .= '  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . chr(10);
      $output .= '    <td class="dataTableContent" ' . $bkgnd . ' onclick="loadPopUp(\'edit\', \'' . $result->fields['id'] . '\')">' . $result->fields['id'] . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" ' . $bkgnd . ' onclick="loadPopUp(\'edit\', \'' . $result->fields['id'] . '\')">' . htmlspecialchars($result->fields['description']) . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" ' . $bkgnd . ' onclick="loadPopUp(\'edit\', \'' . $result->fields['id'] . '\')">' . $account_type_desc . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" ' . $bkgnd . ' onclick="loadPopUp(\'edit\', \'' . $result->fields['id'] . '\')">' . htmlspecialchars($result->fields['primary_acct_id'] ? TEXT_YES . ' - ' . $result->fields['primary_acct_id'] : TEXT_NO) . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" align="right">' . chr(10);
	  if ($this->security_id > 1) $output .= html_icon('actions/edit-find-replace.png', TEXT_EDIT, 'small', 'onclick="loadPopUp(\'edit\', \'' . $result->fields['id'] . '\')"') . chr(10);
	  if ($this->security_id > 3) $output .= html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . GL_INFO_DELETE_INTRO . '\')) submitSeq(\'' . $result->fields['id'] . '\', \'delete\')"') . chr(10);
      $output .= '    </td>' . chr(10);
      $output .= '  </tr>' . chr(10);
      $result->MoveNext();
    }
    $output .= '</table>' . chr(10);
    $output .= '<div class="page_count_right">' . $page_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']) . '</div>' . chr(10);
    $output .= '<div class="page_count">' . $page_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], GL_DISPLAY_NUMBER_OF_COA) . '</div>' . chr(10);
	return $output;
  }

  function build_form_html($action, $id = '') {
    global $db;
    $sql = "select id, description, heading_only, primary_acct_id, account_type, account_inactive 
	    from " . $this->db_table . " where id = '" . $id . "'";
    $result = $db->Execute($sql);
	if ($result->RecordCount() == 0) {
	  $cInfo = new objectInfo($_POST);
	} else {
      $cInfo = new objectInfo($result->fields);
	}
	$output  = '<table border="0" width="100%" cellspacing="2" cellpadding="1">' . chr(10);
	$output .= '  <tr class="dataTableHeadingRow">' . chr(10);
	$output .= '    <th colspan="2">' . (!$result->fields['id'] ? GL_INFO_NEW_ACCOUNT : GL_INFO_EDIT_ACCOUNT) . '</th>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td colspan="2">' . (!$result->fields['id'] ? GL_INFO_INSERT_INTRO : GL_EDIT_INTRO) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . TEXT_GL_ACCOUNT . '</td>' . chr(10);
	$output .= '    <td>' . (!$result->fields['id'] ? html_input_field('id', $cInfo->id) : $cInfo->id) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . TEXT_ACCT_DESCRIPTION . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('description', $cInfo->description, 'size="48" maxlength="64"') . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . GL_INFO_HEADING_ONLY . '</td>' . chr(10);
	$output .= '    <td>' . html_checkbox_field('heading_only', '1', $cInfo->heading_only) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . GL_INFO_PRIMARY_ACCT_ID . '</td>' . chr(10);
	$output .= '    <td>' . html_pull_down_menu('primary_acct_id', gen_coa_pull_down(SHOW_FULL_GL_NAMES, true, true, true), $cInfo->primary_acct_id) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . GL_INFO_ACCOUNT_TYPE . '</td>' . chr(10);
	$output .= '    <td>' . html_pull_down_menu('account_type', gen_get_pull_down(TABLE_CHART_OF_ACCOUNTS_TYPES, true, '1'), $cInfo->account_type) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . GL_INFO_ACCOUNT_INACTIVE . '</td>' . chr(10);
	$output .= '    <td>' . html_checkbox_field('account_inactive', '', $cInfo->account_inactive) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
    $output .= '</table>' . chr(10);
    return $output;
  }
}
?>
