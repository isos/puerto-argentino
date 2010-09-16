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
//  Path: /modules/general/boxes/company_links.php
//

class company_links extends ctl_panel {

  function company_links() {
	$this->module_id   = 'company_links';
	$this->category    = 'misc';
	$this->title       = CP_COMPANY_LINKS_TITLE;
	$this->security    = 0; // unrestricted access to install
	$this->description = CP_COMPANY_LINKS_DESCRIPTION;
  }

  function Install($column_id = 1, $row_id = 0) {
	global $db;
	if (!$row_id) $row_id = $this->get_next_row();
	// fetch the pages params to copy to new install
	$result = $db->Execute("select params from " . TABLE_USERS_PROFILES . "
	  where page_id = '" . $this->page_id . "' and module_id = '" . $this->module_id . "'"); // just need one
	$db->Execute("insert into " . TABLE_USERS_PROFILES . " set 
	  user_id = "    . $_SESSION['admin_id'] . ", 
	  page_id = '"   . $this->page_id . "', 
	  module_id = '" . $this->module_id . "', 
	  column_id = "  . $column_id . ", 
	  row_id = "     . $row_id . ", 
	  params = '" . $result->fields['params'] . "'");
  }

  function Remove() {
	global $db;
	$result = $db->Execute("delete from " . TABLE_USERS_PROFILES . " 
	  where user_id = " . $_SESSION['admin_id'] . " and page_id = '" . $this->page_id . "' and module_id = '" . $this->module_id . "'");
  }

  function Output($params) {
	global $db;
	// Build control box form data
	$control  = '<div class="row">';
	$control .= '<div style="white-space:nowrap">';
	if ($_SESSION['admin_security'][SECURITY_ID_USERS] > 1) { // only show add new if user permission is set to add
	  $control .= TEXT_TITLE . '&nbsp;' . html_input_field('co_title') . '<br />';
	  $control .= TEXT_URL   . '&nbsp;' . html_input_field('co_url', '', 'size="50"');
	  $control .= '&nbsp;&nbsp;&nbsp;&nbsp;';
	  $control .= html_submit_field('co_company_links', TEXT_ADD);
	}
	$control .= html_hidden_field($this->module_id . '_rId', '');
	$control .= '</div></div>';
	// Build content box
	$contents = '';
	if (is_array($params)) {
	  $index = 1;
	  foreach ($params as $title => $hyperlink) {
		if ($_SESSION['admin_security'][SECURITY_ID_USERS] > 3) { // only let delete if user permission is full
		  $contents .= '<div style="float:right; height:16px;">';
		  $contents .= html_icon('phreebooks/dashboard-remove.png', TEXT_REMOVE, 'small', 'onclick="return del_index(\'' . $this->module_id . '\', ' . $index . ')"');
		  $contents .= '</div>';
		}
		$contents .= '<div style="height:16px;">';
		$contents .= '  <a href="' . $hyperlink . '" target="_blank">' . $title . '</a>' . chr(10);
		$contents .= '</div>';
		$index++;
	  }
	} else {
	  $contents = CP_COMPANY_LINKS_NO_RESULTS;
	}
	return $this->build_div($this->title, $contents, $control);
  }

  function Update() {
	global $db;
	$admin_id  = $_SESSION['admin_id'];
	$my_title  = db_prepare_input($_POST['co_title']);
	$my_url    = db_prepare_input($_POST['co_url']);
	$remove_id = db_prepare_input($_POST[$this->module_id . '_rId']);
	$page_id   = $_GET['module'] ? $_GET['module'] : 'index';
	// do nothing if no title or url entered
	if (!$remove_id && ($my_title == '' || $my_url == '')) return; 
	// fetch the current params
	$result = $db->Execute("select params from " . TABLE_USERS_PROFILES . "
	  where page_id = '" . $page_id . "' and module_id = '" . $this->module_id . "'"); // just need one
	if ($remove_id) { // remove element
	  $params     = unserialize($result->fields['params']);
	  $first_part = array_slice($params, 0, $remove_id - 1);
	  $last_part  = array_slice($params, $remove_id);
	  $params     = array_merge($first_part, $last_part);
	} elseif ($result->fields['params']) { // append new url and sort
	  $params     = unserialize($result->fields['params']);
	  $params[$my_title] = $my_url;
	  ksort($params);
	} else { // first entry
	  $params     = array($my_title => $my_url);
	}
	$db->Execute("update " . TABLE_USERS_PROFILES . " set params = '" . serialize($params) . "' 
	  where page_id = '" . $page_id . "' and module_id = '" . $this->module_id . "'");
  }

}
?>