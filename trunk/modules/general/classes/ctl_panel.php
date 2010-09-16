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
//  Path: /modules/general/classes/ctl_panel.php
//

class ctl_panel {
  function ctl_panel() {
  }

  function build_div($title, $contents, $controls) {
	$output = '<!--// start: ' . $this->module_id . ' //-->' . chr(10);
	$output .= '<div id="' . $this->module_id . '" class="modbox" style="position:relative;">' . chr(10);
	$output .= '<table width="100%" class="mhdr" cellspacing="0" cellpadding="0">' . chr(10);
	$output .= '<tr>' . chr(10);
	// heading text
	$output .= '<td width="90%" class="mttl">' . $title . '&nbsp;</td>' . chr(10);
	// edit/cancel image (text)
	$output .= '<td class="medit">' . chr(10);
	$output .= '  <a href="javascript:void(0)" class="el" onclick ="return box_edit(\'' . $this->module_id . '\');">';
	$output .= html_icon('categories/preferences-system.png', TEXT_PROPERTIES, $size = 'small', '', '16', '16', $this->module_id . '_add');
//	$output .= TEXT_EDIT;
	$output .= '  </a>' . chr(10);
	$output .= '  <a href="javascript:void(0)" class="csl" onclick ="return box_cancel(\'' . $this->module_id . '\');">';
//	$output .= TEXT_CANCEL;
	$output .= html_icon('status/dialog-error.png', TEXT_CANCEL, $size = 'small', '', '16', '16', $this->module_id . '_can');
	$output .= '  </a>' . chr(10);
	$output .= '</td>' . chr(10);
	// minimize/maximize image
	$output .= '<td class="mttlz">' . chr(10);
	$output .= '<a href="javascript:void(0)" class="box minbox" id="' . $this->module_id . '_min" onclick="this.blur(); return min_box(\'' . $this->module_id . '\')">' . chr(10);
	$output .= html_icon('actions/list-remove.png', TEXT_COLLAPSE, $size = 'small', '', '16', '16', $this->module_id . '_exp');
	$output .= '</a></td>' . chr(10);
	// delete image
	$output .= '<td class="mttld">' . chr(10);
	$output .= '<a href="javascript:void(0)" class="box delbox" id="' . $this->module_id . '_del" onclick="return del_box(\'' . $this->module_id . '\')">';
	$output .= html_icon('emblems/emblem-unreadable.png', TEXT_REMOVE, $size = 'small');
	$output .= '</a>' . chr(10);
	$output .= '</td></tr></table>' . chr(10);
	// box properties section
	$output .= '<table class="mehdr" cellspacing="0" cellpadding="0">' . chr(10);
	$output .= '<tr class="es">' . chr(10);
	$output .= '<td class="meditbox">' . chr(10);
	$output .= html_form($this->module_id . '_frm', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);
	$output .= $this->build_move_buttons($this->column_id, $this->row_id);
	$output .= $controls . chr(10);
	$output .= '<input type="hidden" name="module_id" value="' . $this->module_id . '" />' . chr(10);
	$output .= '<input type="hidden" name="column_id" value="' . $this->column_id . '" />' . chr(10);
	$output .= '<input type="hidden" name="row_id" value="' . $this->row_id . '" />' . chr(10);
	$output .= '<input type="hidden" name="action" id="' . $this->module_id . '_action" value="save" />' . chr(10);
	$output .= '</form></td></tr></table>' . chr(10);
	// box Contents
	$output .= '<div class="row" id="' . $this->module_id . '_body" style="overflow:hidden;">' . chr(10);
	$output .= $contents;
	$output .= '</div>';
	// finish it up
	$output .= '</div>' . chr(10);
	$output .= '<!--// end: ' . $this->module_id . ' //--><br />' . chr(10) . chr(10);
	return $output;
  }

  function build_move_buttons($column_id, $row_id) {
	$output = '<table cellspacing="0" cellpadding="0"><tr>' . chr(10);
	// move button - Left
	if ($column_id > 1) {
	  $output .= '<td class="mttlz">' . chr(10);
	  $output .= '<a href="javascript:void(0)" class="box minbox" onclick="return move_box(\'' . $this->module_id . '\', \'move_left\')">';
	  $output .= html_icon('actions/go-previous.png', TEXT_MOVE_LEFT, $size = 'small');
	  $output .= '</a>' . chr(10);
	  $output .= '</td>' . chr(10);
	}
	// move button - Right
	if ($column_id < MAX_CP_COLUMNS) {
	  $output .= '<td class="mttlz">' . chr(10);
	  $output .= '<a href="javascript:void(0)" class="box minbox" onclick="return move_box(\'' . $this->module_id . '\', \'move_right\')">';
	  $output .= html_icon('actions/go-next.png', TEXT_MOVE_RIGHT, $size = 'small');
	  $output .= '</a>' . chr(10);
	  $output .= '</td>' . chr(10);
	}
	// move button - Up
	if ($row_id > 1) {
	  $output .= '<td class="mttlz">' . chr(10);
	  $output .= '<a href="javascript:void(0)" class="box minbox" onclick="return move_box(\'' . $this->module_id . '\', \'move_up\')">';
	  $output .= html_icon('actions/go-up.png', TEXT_MOVE_UP, $size = 'small');
	  $output .= '</a>' . chr(10);
	  $output .= '</td>' . chr(10);
	}
	// move button - Down
	if ($row_id < $this->get_next_row($column_id) - 1) {
	  $output .= '<td class="mttlz">' . chr(10);
	  $output .= '<a href="javascript:void(0)" class="box minbox" onclick="return move_box(\'' . $this->module_id . '\', \'move_down\')">';
	  $output .= html_icon('actions/go-down.png', TEXT_MOVE_DOWN, $size = 'small');
	  $output .= '</a>' . chr(10);
	  $output .= '</td>' . chr(10);
	}
	$output .= '</tr></table>';
	return $output;
  }

  function get_next_row($column_id = 1) {
	global $db;
	$result = $db->Execute("select max(row_id) as max_row from " . TABLE_USERS_PROFILES . " 
	  where user_id = " . $_SESSION['admin_id'] . " and page_id = '" . $this->page_id . "' and column_id = " . $column_id);
	return ($result->fields['max_row'] + 1);
  }

}
?>