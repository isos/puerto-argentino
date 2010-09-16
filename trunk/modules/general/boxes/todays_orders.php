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
//  Path: /modules/general/boxes/todays_orders.php
//

class todays_orders extends ctl_panel {

  function todays_orders() {
	$this->module_id   = 'todays_orders';
	$this->category    = 'customers';
	$this->title       = CP_TODAYS_ORDERS_TITLE;
	$this->security    = SECURITY_ID_SALES_ORDER;
	$this->description = CP_TODAYS_ORDERS_DESCRIPTION;
  }

  function Install($column_id = 1, $row_id = 0) {
	global $db;
	if (!$row_id) $row_id = $this->get_next_row();
	$params['num_rows'] = '';	// defaults to unlimited rows
	$result = $db->Execute("insert into " . TABLE_USERS_PROFILES . " set 
	  user_id = "    . $_SESSION['admin_id'] . ", 
	  page_id = '"   . $this->page_id . "', 
	  module_id = '" . $this->module_id . "', 
	  column_id = "  . $column_id . ", 
	  row_id = "     . $row_id . ", 
	  params = '"    . serialize($params) . "'");
  }

  function Remove() {
	global $db;
	$result = $db->Execute("delete from " . TABLE_USERS_PROFILES . " 
      where user_id = " . $_SESSION['admin_id'] . " and page_id = '" . $this->page_id . "' and module_id = '" . $this->module_id . "'");
  }

  function Output($params) {
	global $db, $currencies;
	// Build control box form data
	$control  = '<div class="row">';
	$control .= '<div style="white-space:nowrap">' . TEXT_SHOW . TEXT_SHOW_NO_LIMIT;
	$control .= '<select name="num_rows" onchange="">';
	for ($i = 0; $i <= 20; $i++) {
	  $control .= '<option value="' . $i . '"' . ($params['num_rows'] == $i ? ' selected="selected"' : '') . '>' . $i . '</option>';
	}
	$control .= '</select> ' . TEXT_ITEMS . '&nbsp;&nbsp;&nbsp;&nbsp;';
	$control .= '<input type="submit" value="' . TEXT_SAVE . '" />';
	$control .= '</div></div>';

	// Build content box
	$total = 0;
	$sql = "select id, purchase_invoice_id, total_amount, bill_primary_name, currencies_code, currencies_value 
	  from " . TABLE_JOURNAL_MAIN . " 
	  where journal_id = 10 and post_date = '" . date('Y-m-d') . "' order by purchase_invoice_id";
	if ($params['num_rows']) $sql .= " limit " . $params['num_rows'];
	$result = $db->Execute($sql);
	if ($result->RecordCount() < 1) {
	  $contents = CP_TODAYS_ORDERS_NO_RESULTS;
	} else {
	  while (!$result->EOF) {
	 	$total += $result->fields['total_amount'];
		$contents .= '<div style="float:right">' . $currencies->format_full($result->fields['total_amount'], true, $result->fields['currencies_code'], $result->fields['currencies_value']) . '</div>';
		$contents .= '<div>';
		$contents .= '<a href="' . html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;oID=' . $result->fields['id'] . '&amp;jID=10&amp;action=edit', 'SSL') . '">';
		$contents .= $result->fields['purchase_invoice_id'] . ' - ';
		$contents .= $result->fields['bill_primary_name'];
		$contents .= '</a></div>' . chr(10);
		$result->MoveNext();
	  }
	}
	if (!$params['num_rows']) {
	  $contents .= '<div style="float:right">' . $currencies->format_full($total, true, $result->fields['currencies_code'], $result->fields['currencies_value']) . '</div>';
	  $contents .= '<div><b>' . TEXT_TOTAL . '</b></div>' . chr(10);
	}
	return $this->build_div($this->title, $contents, $control);
  }

  function Update() {
	global $db;
	$params['num_rows'] = db_prepare_input($_POST['num_rows']);
	$column_id          = db_prepare_input($_POST['column_id']);
	$row_id             = db_prepare_input($_POST['row_id']);
	$admin_id           = $_SESSION['admin_id'];
	$page_id            = ($_GET['module']) ? $_GET['module'] : 'index';

	$db->Execute("update " . TABLE_USERS_PROFILES . " set 
		column_id = "  . $column_id . ", 
		row_id = "     . $row_id . ", 
		params = '"    . serialize($params) . "' 
	  where user_id = " . $admin_id . " and page_id = '" . $page_id . "' and module_id = '" . $this->module_id . "'");
  }
}
?>