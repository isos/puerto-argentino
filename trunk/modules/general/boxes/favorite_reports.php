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
//  Path: /modules/general/boxes/favorite_reports.php
//

require (DIR_FS_MODULES . 'reportwriter/functions/builder_functions.php'); // needed for security check

class favorite_reports extends ctl_panel {

	// class constructor
	function favorite_reports() {
		$this->module_id   = 'favorite_reports';
		$this->category    = 'tools';
		$this->title       = CP_FAVORITE_REPORTS_TITLE;
		$this->security    = SECURITY_ID_REPORTS; // reports security code
		$this->description = CP_FAVORITE_REPORTS_DESCRIPTION;
	}

	function Install($column_id = 1, $row_id = 0) {
		global $db;
		if (!$row_id) $row_id = $this->get_next_row();
		$result = $db->Execute("insert into " . TABLE_USERS_PROFILES . " set 
			user_id = "    . $_SESSION['admin_id'] . ", 
			page_id = '"   . $this->page_id . "', 
			module_id = '" . $this->module_id . "', 
			column_id = "  . $column_id . ", 
			row_id = "     . $row_id . ", 
			params = ''");
	}

	function Remove() {
		global $db;
		$result = $db->Execute("delete from " . TABLE_USERS_PROFILES . " 
			where user_id = " . $_SESSION['admin_id'] . " and page_id = '" . $this->page_id . "' and module_id = '" . $this->module_id . "'");
	}

	function Output($params) {
		global $db;
		// load the report security tokens
		$rr_security = array();
		$result = $db->Execute("select reportid, params from " . TABLE_REPORT_FIELDS . " where entrytype = 'security'");
		while (!$result->EOF) {
		  $rr_security[$result->fields['reportid']] = $result->fields['params'];
		  $result->MoveNext();
		}
		// load the report list
		$query_raw = "select id, reporttype, description from " . TABLE_REPORTS . " order by description";
		$reports = $db->Execute($query_raw);
		$data_array = array(array('id' => '', 'text' => GEN_HEADING_PLEASE_SELECT));
		$type_array = array();
		while(!$reports->EOF) {
		  $type_array[$reports->fields['id']] = $reports->fields['reporttype'];
		  if (security_check($rr_security[$reports->fields['id']])) {
		    $data_array[] = array('id' => $reports->fields['id'], 'text' => $reports->fields['description']);
		  }
		  $reports->MoveNext();
		}
		// Build control box form data
		$control  = '<div class="row">';
		$control .= '<div style="white-space:nowrap">';
		$control .= TEXT_REPORT . '&nbsp;' . html_pull_down_menu('report_id', $data_array);
		$control .= '&nbsp;&nbsp;&nbsp;&nbsp;';
		$control .= html_submit_field('my_favorite_reports', TEXT_ADD);
		$control .= html_hidden_field($this->module_id . '_rId', '');
		$control .= '</div></div>';

		// Build content box
		$contents = '';
		if (is_array($params)) {
			$index = 1;
			foreach ($params as $id => $description) {
		  		$contents .= '<div style="float:right; height:16px;">';
				$contents .= html_icon('phreebooks/dashboard-remove.png', TEXT_REMOVE, 'small', 'onclick="return del_index(\'' . $this->module_id . '\', ' . $index . ')"');
				$contents .= '</div>';
		  		$contents .= '<div style="height:16px;">';
				$contents .= '  <a href="index.php?cat=reportwriter&amp;module=' . ($type_array[$id]=='frm' ? 'form_gen' : 'rpt_gen') . '&amp;ReportID=' . $id . '&amp;todo=open" target="_blank">' . $description . '</a>' . chr(10);
				$contents .= '</div>';
				$index++;
			}
		} else {
			$contents = CP_FAVORITE_REPORTS_NO_RESULTS;
		}
		return $this->build_div($this->title, $contents, $control);
	}

	function Update() {
		global $db;
		$admin_id    = $_SESSION['admin_id'];
		$report_id   = db_prepare_input($_POST['report_id']);
		$description = gen_get_type_description(TABLE_REPORTS, $report_id, false);
		$remove_id   = db_prepare_input($_POST[$this->module_id . '_rId']);
		$page_id     = ($_GET['module']) ? $_GET['module'] : 'index';

		// do nothing if no title or url entered
		if (!$remove_id && $report_id == '') return; 
		// fetch the current params
		$result = $db->Execute("select params from " . TABLE_USERS_PROFILES . "
			where page_id = '" . $page_id . "' and user_id = " . $admin_id . " and module_id = '" . $this->module_id . "'");
		if ($remove_id) { // remove element
			$params = unserialize($result->fields['params']);
			$temp   = array();
			$index  = 1;
			foreach ($params as $key => $value) {
				if ($index <> $remove_id) $temp[$key] = $value;
				$index++;
			}
			$params = $temp;
		} elseif ($result->fields['params']) { // append new url and sort
			$params = unserialize($result->fields['params']);
			$params[$report_id] = $description;
			asort($params);
		} else { // first entry
			$params = array($report_id => $description);
		}
		$db->Execute("update " . TABLE_USERS_PROFILES . " set params = '" . serialize($params) . "' 
			where user_id = " . $admin_id . " and page_id = '" . $page_id . "' and module_id = '" . $this->module_id . "'");
	}

}
?>