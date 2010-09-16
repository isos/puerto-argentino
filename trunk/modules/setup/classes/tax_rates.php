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
//  Path: /modules/setup/classes/tax_rates.php
//

class tax_rates {

  function tax_rates() {
  	$this->security_id = $_SESSION['admin_security'][SECURITY_ID_TAX_RATES];
	$this->db_table = TABLE_TAX_RATES;
	$this->title = SETUP_TITLE_TAX_RATES;
    $this->extra_buttons = false;
	$this->help_path = '07.08.03.02';
	$this->type = 'c'; // choices are c for customers and v for vendors
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
    $description_short  = db_prepare_input($_POST['description_short']);
	$rate_accounts      = db_prepare_input($_POST['rate_accounts']);
	$tax_auth_id_add    = db_prepare_input($_POST['tax_auth_id_add']);
	$tax_auth_id_delete = db_prepare_input($_POST['tax_auth_id_delete']);
	$rate_accounts = $this->combine_rates($rate_accounts, $tax_auth_id_add, $tax_auth_id_delete);
	$sql_data_array = array(
		'type'              => $this->type,
		'description_short' => $description_short,
		'description_long'  => db_prepare_input($_POST['description_long']),
		'rate_accounts'     => $rate_accounts,
		'freight_taxable'   => db_prepare_input($_POST['freight_taxable']),
	);
    if ($id) {
	  db_perform($this->db_table, $sql_data_array, 'update', "tax_rate_id = '" . (int)$id . "'");
	  gen_add_audit_log(SETUP_TAX_RATES_LOG . TEXT_UPDATE, $description_short);
	} else  {
      db_perform($this->db_table, $sql_data_array);
	  gen_add_audit_log(SETUP_TAX_RATES_LOG . TEXT_ADD, $description_short);
	}
	return true;
  }

  function btn_delete() {
  	global $db, $messageStack;
	if ($this->security_id < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		return false;
	}
    $tax_rate_id = db_prepare_input($_POST['rowSeq']);

	// Check for this rate as part of a journal entry, if so do not delete
	// Since tax rates are not used explicitly, they can be deleted at any time.

	$result = $db->Execute("select description_short from " . $this->db_table . " where tax_rate_id = " . (int)$tax_rate_id);
    $db->Execute("delete from " . $this->db_table . " where tax_rate_id = " . $tax_rate_id);
	gen_add_audit_log(SETUP_TAX_RATES_LOG . TEXT_DELETE, $result->fields['description_short']);
	return true;
  }

  function build_main_html() {
  	global $db, $messageStack;
    $tax_authorities_array = gen_build_tax_auth_array();
    // Build heading bar
	$output  = '<table border="0" width="100%" cellspacing="0" cellpadding="1">' . chr(10);
	$output .= '  <tr class="dataTableHeadingRow" valign="top">' . chr(10);
	$heading_array = array(
		'description_short' => SETUP_TAX_DESC_SHORT,
		'account_id'        => SETUP_HEADING_TOTAL_TAX,
		'tax_rate'          => SETUP_HEADING_TAX_FREIGHT);
	$result = html_heading_bar($heading_array, $_GET['list_order']);
	$output .= $result['html_code'];
	$disp_order = $result['disp_order'];
    $output .= '  </tr>' . chr(10);
	// Build field data
    $query_raw = "select tax_rate_id, description_short, description_long, rate_accounts, freight_taxable 
		from " . $this->db_table . " where type = '" . $this->type . "' order by $disp_order";
    $page_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
    $result = $db->Execute($query_raw);
    while (!$result->EOF) {
      $output .= '  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . chr(10);
      $output .= '    <td class="dataTableContent" onclick="loadPopUp(\'edit\', ' . $result->fields['tax_rate_id'] . ')">' . htmlspecialchars($result->fields['description_short']) . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" onclick="loadPopUp(\'edit\', ' . $result->fields['tax_rate_id'] . ')">' . gen_calculate_tax_rate($result->fields['rate_accounts'], $tax_authorities_array) . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" onclick="loadPopUp(\'edit\', ' . $result->fields['tax_rate_id'] . ')">' . ($result->fields['freight_taxable'] ? TEXT_YES : TEXT_NO) . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" align="right">' . chr(10);
	  if ($this->security_id > 1) $output .= html_icon('actions/edit-find-replace.png', TEXT_EDIT, 'small', 'onclick="loadPopUp(\'edit\', ' . $result->fields['tax_rate_id'] . ')"') . chr(10);
	  if ($this->security_id > 3) $output .= html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . SETUP_TAX_DELETE_INTRO . '\')) submitSeq(' . $result->fields['tax_rate_id'] . ', \'delete\')"') . chr(10);
      $output .= '    </td>' . chr(10);
      $output .= '  </tr>' . chr(10);
      $result->MoveNext();
    }
    $output .= '</table>' . chr(10);
    $output .= '<div class="page_count_right">' . $page_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']) . '</div>' . chr(10);
    $output .= '<div class="page_count">' . $page_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], SETUP_DISPLAY_NUMBER_OF_TAX_RATES) . '</div>' . chr(10);
	return $output;
  }

  function build_form_html($action, $id = '') {
    global $db;
    $tax_authorities_array = gen_build_tax_auth_array();
    $sql = "select description_short, description_long, rate_accounts, freight_taxable 
	    from " . $this->db_table . " where tax_rate_id = " . $id;
    $result = $db->Execute($sql);
	if ($action == 'new') {
	  $cInfo = '';
	} else {
      $cInfo = new objectInfo($result->fields);
	}

	$output  = '<table border="0" width="100%" cellspacing="0" cellpadding="1">' . chr(10);
	$output .= '  <tr class="dataTableHeadingRow">' . chr(10);
	$output .= '    <th colspan="2">' . ($action=='new' ? SETUP_HEADING_NEW_TAX_RATE : SETUP_HEADING_EDIT_TAX_RATE) . '</th>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td colspan="2">' . ($action=='new' ? SETUP_TAX_INSERT_INTRO : SETUP_TAX_EDIT_INTRO) . '</td>' . chr(10);
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
	$output .= '    <td>' . SETUP_INFO_TAX_AUTHORITIES . '</td>' . chr(10);
	$output .= '    <td>' . html_hidden_field('rate_accounts', $cInfo->rate_accounts) . $this->draw_tax_auths($cInfo->rate_accounts, $tax_authorities_array) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_TAX_AUTH_ADD . '</td>' . chr(10);
	$output .= '    <td>' . html_pull_down_menu('tax_auth_id_add', $this->get_tax_auths()) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_TAX_AUTH_DELETE . '</td>' . chr(10);
	$output .= '    <td>' . html_pull_down_menu('tax_auth_id_delete', $this->get_selected_tax_auths($cInfo->rate_accounts, $tax_authorities_array)) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_FREIGHT_TAXABLE . '</td>' . chr(10);
	$output .= '    <td>' . html_radio_field('freight_taxable', '0', !$cInfo->freight_taxable) . TEXT_NO . html_radio_field('freight_taxable', '1', $cInfo->freight_taxable) . TEXT_YES . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
    $output .= '</table>' . chr(10);
    return $output;
  }

  function draw_tax_auths($tax_authorities_chosen, $tax_auth_array) {
	$field = '<table border="1" width="100%">';
	$chosen_auth_array = explode(':', $tax_authorities_chosen);
	$total_tax_rate = 0;
	while ($chosen_auth = array_shift($chosen_auth_array)) {
	  $field .= '<tr><td>' . $tax_auth_array[$chosen_auth]['description_short'] . '</td><td align="right">' . $tax_auth_array[$chosen_auth]['tax_rate'] . '</td></tr>';
	  $total_tax_rate += $tax_auth_array[$chosen_auth]['tax_rate'];
	}
	$field .= '<tr><td align="right">' . TEXT_TOTAL . '</td><td align="right">' . $total_tax_rate . '</td></tr>';
	$field .= '</table>';
	return $field;
  }

////
// Get list of tax_auth for pull down
  function get_tax_auths() {
    global $db;
    $tax_auth_values = $db->Execute("select tax_auth_id, description_short
		from " . TABLE_TAX_AUTH . " where type = '" . $this->type . "' order by description_short");
    $tax_auth_array = array();
    $tax_auth_array[] = array('id' => '', 'text' => TEXT_NONE);
    while (!$tax_auth_values->EOF) {
      $tax_auth_array[] = array(
	  	'id'   => $tax_auth_values->fields['tax_auth_id'],
        'text' => $tax_auth_values->fields['description_short'],
	  );
      $tax_auth_values->MoveNext();
    }
    return $tax_auth_array;
  }

////
// Get list of tax_auth for for a specific tax rate code to build remove drop down
  function get_selected_tax_auths($tax_authorities_chosen, $tax_auth_choices) {
	$chosen_auth_array = explode(':', $tax_authorities_chosen);
    $tax_auth_array = array();
    $tax_auth_array[] = array('id' => '', 'text' => TEXT_NONE);
	while ($chosen_auth = array_shift($chosen_auth_array)) {
      $tax_auth_array[] = array(
	    'id'   => $chosen_auth, 
	  	'text' => $tax_auth_choices[$chosen_auth]['description_short'],
	  );
	}
    return $tax_auth_array;
  }

////
// regenerate listing string for tax authorities 
  function combine_rates($rate_accounts, $tax_auth_id_add = '', $tax_auth_id_delete = '') {
	$tax_auth_array = explode(':', $rate_accounts);
	$new_tax_auth_array = array();
	while ($tax_auth = array_shift($tax_auth_array)) {
	  if ($tax_auth <> $tax_auth_id_delete) $new_tax_auth_array[] = $tax_auth;
	}
	if (gen_not_null($tax_auth_id_add)) $new_tax_auth_array[] = $tax_auth_id_add;
	return implode(':', $new_tax_auth_array);
  }

}
?>