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
//  Path: /modules/setup/classes/currency.php
//

class currency {

  function currency() {
  	$this->security_id   = $_SESSION['admin_security'][SECURITY_ID_CURRENCIES];
	$this->db_table      = TABLE_CURRENCIES;
	$this->title         = SETUP_TITLE_CURRENCIES;
    $this->extra_buttons = true;
	$this->help_path     = '07.08.02';
  }

  function customize_buttons() {
  	global $toolbar;
	$toolbar->add_icon('update', 'onclick="submitToDo(\'update\')"', $order = 10);
	$toolbar->icon_list['update']['text'] = SETUP_UPDATE_EXC_RATE;
  }

  function btn_save($id = '') {
  	global $db, $messageStack;
	if ($this->security_id < 3) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		return false;
	}
	$title = db_prepare_input($_POST['title']);
	$code = strtoupper(db_prepare_input($_POST['code']));
	$sql_data_array = array(
		'title'           => $title,
		'code'            => $code,
		'symbol_left'     => db_prepare_input($_POST['symbol_left']),
		'symbol_right'    => db_prepare_input($_POST['symbol_right']),
		'decimal_point'   => db_prepare_input($_POST['decimal_point']),
		'thousands_point' => db_prepare_input($_POST['thousands_point']),
		'decimal_places'  => db_prepare_input($_POST['decimal_places']),
		'decimal_precise' => db_prepare_input($_POST['decimal_precise']),
		'value'           => db_prepare_input($_POST['value']),
	);
    if ($id) {
	  db_perform($this->db_table, $sql_data_array, 'update', "currencies_id = " . (int)$id);
      gen_add_audit_log(SETUP_LOG_CURRENCY . TEXT_UPDATE, $title);
	} else  {
      db_perform($this->db_table, $sql_data_array);
      gen_add_audit_log(SETUP_LOG_CURRENCY . TEXT_ADD, $title);
	}

	if (isset($_POST['default']) && ($_POST['default'] == 'on')) {
	  // first check to see if there are any general ledger entries
	  $result = $db->Execute("select id from " . TABLE_JOURNAL_MAIN . " limit 1");
	  if ($result->RecordCount() > 0) {
		$messageStack->add_session(SETUP_ERROR_CANNOT_CHANGE_DEFAULT,'error');
	  } else {
	    $db->Execute("update " . TABLE_CONFIGURATION . " set configuration_value = '" . db_input($code) . "'
			where configuration_key = 'DEFAULT_CURRENCY'");
	    $db->Execute("alter table " . TABLE_JOURNAL_MAIN . " 
			change `currencies_code` `currencies_code` CHAR(3) NOT NULL DEFAULT '" . db_input($code) . "'");
	  }
	}
	return true;
  }

  function btn_update() { // updates the currency rates
  	global $db, $messageStack;
/* commented out so everyone can update currency exchange rates
	if ($this->security_id < 1) {
		$messageStack->add(ERROR_NO_PERMISSION,'error');
		return false;
	}
*/
	$server_used = CURRENCY_SERVER_PRIMARY;
	$currency = $db->Execute("select currencies_id, code, title from " . $this->db_table);
	while (!$currency->EOF) {
	  $quote_function = 'quote_' . CURRENCY_SERVER_PRIMARY . '_currency';
	  $rate = $quote_function($currency->fields['code']);
	  if (empty($rate) && (gen_not_null(CURRENCY_SERVER_BACKUP))) {
		$messageStack->add(sprintf(SETUP_WARN_PRIMARY_SERVER_FAILED, CURRENCY_SERVER_PRIMARY, $currency->fields['title'], $currency->fields['code']), 'caution');
		$quote_function = 'quote_' . CURRENCY_SERVER_BACKUP . '_currency';
		$rate = $quote_function($currency->fields['code']);
		$server_used = CURRENCY_SERVER_BACKUP;
	  }
	  if (gen_not_null($rate)) {
		$db->Execute("update " . $this->db_table . "
					  set value = '" . $rate . "', last_updated = now()
					  where currencies_id = '" . (int)$currency->fields['currencies_id'] . "'");
		$messageStack->add(sprintf(SETUP_INFO_CURRENCY_UPDATED, $currency->fields['title'], $currency->fields['code'], $server_used), 'success');
	  } else {
		$messageStack->add(sprintf(SETUP_ERROR_CURRENCY_INVALID, $currency->fields['title'], $currency->fields['code'], $server_used), 'error');
	  }
	  $currency->MoveNext();
	}
	return true;
  }

  function btn_delete() {
  	global $db, $messageStack;
	if ($this->security_id < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		return false;
	}
	$currencies_id = db_prepare_input($_POST['rowSeq']);
	$currency = $db->Execute("select currencies_id
							  from " . $this->db_table . "
							  where code = '" . DEFAULT_CURRENCY . "'");
	if ($currency->fields['currencies_id'] == $currencies_id) {
	  $db->Execute("update " . TABLE_CONFIGURATION . "
					set configuration_value = ''
					where configuration_key = 'DEFAULT_CURRENCY'");
	}
	$result = $db->Execute("select title from " . $this->db_table . " where currencies_id = " . (int)$currencies_id);
	$db->Execute("delete from " . $this->db_table . " where currencies_id = " . (int)$currencies_id);
	gen_add_audit_log(SETUP_LOG_CURRENCY . TEXT_DELETE, $result->fields['title']);
	return true;
  }

  function build_main_html() {
  	global $db, $messageStack;
    // Build heading bar
	$output  = '<table border="0" width="100%" cellspacing="0" cellpadding="1">' . chr(10);
	$output .= '  <tr class="dataTableHeadingRow" valign="top">' . chr(10);
	$heading_array = array(
		'title' => SETUP_CURRENCY_NAME,
		'code'  => SETUP_CURRENCY_CODES,
		'value' => TEXT_VALUE,
	);
	$result     = html_heading_bar($heading_array, $_GET['list_order']);
	$output    .= $result['html_code'];
	$disp_order = $result['disp_order'];
    $output    .= '  </tr>' . chr(10);
	// Build field data
    $query_raw = "select currencies_id, title, code, symbol_left, symbol_right, decimal_point, thousands_point, decimal_places, last_updated, value 
	    from " . TABLE_CURRENCIES . " order by $disp_order";
    $page_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
    $currency = $db->Execute($query_raw);
    while (!$currency->EOF) {
      $output .= '  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . chr(10);
      if (DEFAULT_CURRENCY == $currency->fields['code']) {
        $output .= '    <td class="dataTableContent" onclick="loadPopUp(\'edit\', ' . $currency->fields['currencies_id'] . ')"><b>' . htmlspecialchars($currency->fields['title']) . ' (' . TEXT_DEFAULT . ')</b></td>' . chr(10);
      } else {
        $output .= '    <td class="dataTableContent" onclick="loadPopUp(\'edit\', ' . $currency->fields['currencies_id'] . ')">' . htmlspecialchars($currency->fields['title']) . '</td>' . chr(10);
      }
      $output .= '    <td class="dataTableContent" onclick="loadPopUp(\'edit\', ' . $currency->fields['currencies_id'] . ')">' . $currency->fields['code'] . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" align="right" onclick="loadPopUp(\'edit\', ' . $currency->fields['currencies_id'] . ')">' . number_format($currency->fields['value'], 8) . '</td>' . chr(10);
      $output .= '    <td class="dataTableContent" align="right">' . chr(10);
	  if ($this->security_id > 1) $output .= html_icon('actions/edit-find-replace.png', TEXT_EDIT, 'small', 'onclick="loadPopUp(\'edit\', ' . $currency->fields['currencies_id'] . ')"') . chr(10);
	  if ($this->security_id > 3) $output .= html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . SETUP_CURR_DELETE_INTRO . '\')) submitSeq(' . $currency->fields['currencies_id'] . ', \'delete\')"') . chr(10);
      $output .= '    </td>' . chr(10);
      $output .= '  </tr>' . chr(10);
      $currency->MoveNext();
    }
    $output .= '</table>' . chr(10);
    $output .= '<div class="page_count_right">' . $page_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']) . '</div>' . chr(10);
    $output .= '<div class="page_count">' . $page_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_CURRENCIES) . '</div>' . chr(10);
	return $output;
  }

  function build_form_html($action, $id) {
    global $db;
    $sql = "select * from " . $this->db_table . " where currencies_id = '" . $id . "'";
    $result = $db->Execute($sql);
	if ($action == 'new') {
	  $cInfo = '';
	} else {
      $cInfo = new objectInfo($result->fields);
	}
	$output  = '<table border="0" width="100%" cellspacing="0" cellpadding="1">' . chr(10);
	$output .= '  <tr class="dataTableHeadingRow">' . chr(10);
	$output .= '    <th colspan="2">' . ($action=='new' ? SETUP_INFO_HEADING_NEW_CURRENCY : SETUP_INFO_HEADING_EDIT_CURRENCY) . '</th>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td colspan="2">' . ($action=='new' ? SETUP_CURR_INSERT_INTRO : SETUP_CURR_EDIT_INTRO) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_CURRENCY_TITLE . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('title', $cInfo->title) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_CURRENCY_CODE . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('code', $cInfo->code) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_CURRENCY_SYMBOL_LEFT . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('symbol_left', htmlspecialchars($cInfo->symbol_left)) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_CURRENCY_SYMBOL_RIGHT . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('symbol_right', htmlspecialchars($cInfo->symbol_right)) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_CURRENCY_DECIMAL_POINT . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('decimal_point', $cInfo->decimal_point) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_CURRENCY_THOUSANDS_POINT . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('thousands_point', $cInfo->thousands_point) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_CURRENCY_DECIMAL_PLACES . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('decimal_places', $cInfo->decimal_places) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_CURRENCY_DECIMAL_PRECISE . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('decimal_precise', $cInfo->decimal_precise) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	$output .= '  <tr class="dataTableRow">' . chr(10);
	$output .= '    <td>' . SETUP_INFO_CURRENCY_VALUE . '</td>' . chr(10);
	$output .= '    <td>' . html_input_field('value', $cInfo->value) . '</td>' . chr(10);
    $output .= '  </tr>' . chr(10);
	if (DEFAULT_CURRENCY != $cInfo->code) {
	  $output .= '  <tr class="dataTableRow">' . chr(10);
	  $output .= '    <td colspan="2">' . html_checkbox_field('default') . ' ' . SETUP_INFO_SET_AS_DEFAULT . '</td>' . chr(10);
      $output .= '  </tr>' . chr(10);
	}
    $output .= '</table>' . chr(10);
    return $output;
  }

}
?>