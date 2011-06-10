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
//  Path: /modules/general/functions/html_functions.php
//

  function html_draw_admin_box($zf_header, $zf_content) {
    $zp_boxes = '<li class="submenu"><a target="_top" href="' . $zf_header['link'] . '">' . $zf_header['text'] . '</a>';
    $zp_boxes .= '<ul>' . "\n";
    for ($i=0; $i<sizeof($zf_content); $i++) {
      $zp_boxes .= '<li>';
      $zp_boxes .= '<a href="' . $zf_content[$i]['link'] . '">' . $zf_content[$i]['text'] . '</a>';
      $zp_boxes .= '</li>' . "\n";
    }
    $zp_boxes .= '</ul>' . "\n";
    $zp_boxes .= '</li>' . "\n";
    return $zp_boxes;
  }

  function html_href_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = false) {
    global $request_type, $session_started, $http_domain, $https_domain;
    if ($page == '') {
      die('</td></tr></table></td></tr></table><br /><br /><font color="#ff0000"><b>Error!</b></font><br /><br /><b>Unable to determine the page link!<br /><br />Function used:<br /><br />html_href_link(\'' . $page . '\', \'' . $parameters . '\', \'' . $connection . '\')</b>');
    }
    if ($connection == 'NONSSL') {
      $link = HTTP_SERVER . DIR_WS_ADMIN;
    } elseif ($connection == 'SSL') {
      $link = DIR_WS_FULL_PATH;
    } else {
      die('</td></tr></table></td></tr></table><br /><br /><font color="#ff0000"><b>Error!</b></font><br /><br /><b>Unable to determine connection method on a link!<br /><br />Known methods: NONSSL SSL<br /><br />Function used:<br /><br />html_href_link(\'' . $page . '\', \'' . $parameters . '\', \'' . $connection . '\')</b>');
    }
    if (!strstr($page, '.php')) $page .= '.php';
    if ($parameters == '') {
      $link = $link . $page;
      $separator = '?';
    } else {
      $link = $link . $page . '?' . $parameters;
      $separator = '&amp;';
    }
    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);
	// Add the session ID when moving from different HTTP and HTTPS servers, or when SID is defined
    if ( ($add_session_id == true) && ($session_started == true) ) {
      if (defined('SID') && gen_not_null(SID)) {
        $sid = SID;
      } elseif ( ( ($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL_ADMIN == 'true') ) || ( ($request_type == 'SSL') && ($connection == 'NONSSL') ) ) {
        if ($http_domain != $https_domain) {
          $sid = session_name() . '=' . session_id();
        }
      }
    }
    if (isset($sid)) $link .= $separator . $sid;
    return $link;
  }

////
  function html_image($src, $alt = '', $width = '', $height = '', $params = '') {
    $image = '<img src="' . $src . '" border="0" alt="' . $alt . '"';
    if ($alt)    $image .= ' title="' . $alt . '"';
    if ($width)  $image .= ' width="' . $width . '"';
    if ($height) $image .= ' height="' . $height . '"';
    if ($params) $image .= ' ' . $params;
    $image .= ' />';
    return $image;
  }

////
  function html_icon($image, $alt = '', $size = 'small', $params = '', $width = '', $height = '', $name = '') {
  	switch ($size) {
		default:
		case 'small':  $subdir = '16x16/';    $height='16'; break;
		case 'medium': $subdir = '22x22/';    $height='22'; break;
		case 'large':  $subdir = '32x32/';    $height='32'; break;
		case 'svg' :   $subdir = 'scalable/';               break;
	}
    $image_html = '<img src="' . DIR_WS_ICONS . $subdir . $image . '" border="0" alt="' . $alt . '"';
    if ($alt)    $image_html .= ' title="' . $alt . '"';
    if ($name)   $image_html .= ' id="' . $name . '"';
    if ($width)  $image_html .= ' width="' . $width . '"';
    if ($height) $image_html .= ' height="' . $height . '"';
    if ($params) $image_html .= ' ' . $params;
    $image_html .= ' />';
    return $image_html;
  }

////
  function html_form($name, $action, $parameters = '', $method = 'post', $params = '', $usessl = true) {
    $form = '<form name="' . gen_output_string($name) . '" id="' . gen_output_string($name) . '" action="';
    if (gen_not_null($parameters)) {
        $form .= html_href_link($action, $parameters, (($usessl) ? 'SSL' : 'NONSSL'));
    } else {
        $form .= html_href_link($action, '', (($usessl) ? 'SSL' : 'NONSSL'));
    }
    $form .= '" method="' . gen_output_string($method) . '"';
    if (gen_not_null($params)) $form .= ' ' . $params;
    $form .= '>';
    return $form;
  }

////
  function html_input_field($name, $value = '', $parameters = '', $required = false, $type = 'text', $reinsert_value = false) {
	if (strpos($name, '[]')) { // don't show id attribute if generic array
	  $id = false;
	} else {
	  $id = str_replace('[','_', gen_output_string($name)); // clean up for array inputs causing html errors
	  $id = str_replace(']','', $id);
    }
    $field = '<input type="' . gen_output_string($type) . '" name="' . gen_output_string($name) . '"';
	if ($id) $field .= ' id="' . $id . '"';
    if (isset($GLOBALS[$name]) && ($reinsert_value == true) && is_string($GLOBALS[$name])) {
      $field .= ' value="' . gen_output_string(stripslashes($GLOBALS[$name])) . '"';
    } elseif (gen_not_null($value)) {
      $field .= ' value="' . gen_output_string($value) . '"';
    }
    if (gen_not_null($parameters)) $field .= ' ' . $parameters;
    $field .= ' />';
    if ($required == true) $field .= TEXT_FIELD_REQUIRED;
    return $field;
  }

////
  function html_hidden_field($name, $value = '', $parameters = '') {
    return html_input_field($name, $value, $parameters, false, 'hidden', false);
  }

////
  function html_password_field($name, $value = '', $required = false) {
    return html_input_field($name, $value, 'maxlength="40"', $required, 'password', false);
  }

////
  function html_file_field($name, $required = false) {
    return html_input_field($name, '', '', $required, 'file', false);
  }

////
  function html_submit_field($name, $value, $parameters = '') {
  	return html_input_field($name, $value, 'style="cursor:pointer" ' . $parameters, false, 'submit', false);
  }

////
  function html_button_field($name, $value, $parameters = '') {
  	return html_input_field($name, $value, $parameters . ' style="cursor:pointer;"', false, 'button', false);
  }

////
  function html_selection_field($name, $type, $value = '', $checked = false, $compare = '', $parameters = '', $reinsert_value = true) {
	if (strpos($name, '[]')) { // don't show id attribute if generic array
	  $id = false;
	} else {
	  $id = str_replace('[','_', gen_output_string($name)); // clean up for array inputs causing html errors
	  $id = str_replace(']','', $id);
    }
	$selection = '<input type="' . gen_output_string($type) . '" name="' . gen_output_string($name) . '"';
	if ($id) $selection .= ' id="' . $id . '"';
    if (gen_not_null($value)) $selection .= ' value="' . gen_output_string($value) . '"';
    if ( ($checked == true) || (($reinsert_value==true) && isset($GLOBALS[$name]) && is_string($GLOBALS[$name]) && ($GLOBALS[$name] == 'on')) || (($reinsert_value==true) && isset($value) && isset($GLOBALS[$name]) && (stripslashes($GLOBALS[$name]) == $value)) || (gen_not_null($value) && gen_not_null($compare) && ($value == $compare)) ) {
      $selection .= ' checked="checked"';
    }
    if (gen_not_null($parameters)) $selection .= ' ' . $parameters;
    $selection .= ' />';
    return $selection;
  }

////
  function html_checkbox_field($name, $value = '', $checked = false, $compare = '', $parameters = '', $reinsert_value = true) {
    return html_selection_field($name, 'checkbox', $value, $checked, $compare, $parameters, $reinsert_value);
  }

////
  function html_radio_field($name, $value = '', $checked = false, $compare = '', $parameters = '', $reinsert_value = true) {
    $selection  = '<input type="radio" name="' . gen_output_string($name) . '" id="' . gen_output_string($name) . '_' . $value . '"';
    $selection .= ' value="' . gen_output_string($value) . '"';
    
    if (($checked == true) || (($reinsert_value==true) && isset($GLOBALS[$name]) && is_string($GLOBALS[$name]) && ($GLOBALS[$name] == 'on')) || (($reinsert_value==true) && isset($value) && isset($GLOBALS[$name]) && (stripslashes($GLOBALS[$name]) == $value)) || (gen_not_null($value) && gen_not_null($compare) && ($value == $compare)) ) {
      $selection .= ' checked="checked" selected="selected"';
    }
    if (gen_not_null($parameters)) $selection .= ' ' . $parameters;
    $selection .= ' />';
    return $selection;
  }

////
  function html_textarea_field($name, $width, $height, $text = '', $parameters = '', $reinsert_value = true) {
    $field = '<textarea name="' . gen_output_string($name) . '" id="' . gen_output_string($name) . '" cols="' . gen_output_string($width) . '" rows="' . gen_output_string($height) . '"';
    if (gen_not_null($parameters)) $field .= ' ' . $parameters;
    $field .= '>';
    if ( (isset($GLOBALS[$name])) && ($reinsert_value == true) ) {
      $field .= stripslashes($GLOBALS[$name]);
    } elseif (gen_not_null($text)) {
      $field .= $text;
    }
    $field .= '</textarea>';
    return $field;
  }

////
  function html_pull_down_menu($name, $values, $default = '', $parameters = '', $required = false) {
	$id = strpos($name, '[') ? false : $name;
    $field = '<select name="' . gen_output_string($name) . '"';
	if ($id) $field .= ' id="' . gen_output_string($id) . '"';
    if (gen_not_null($parameters)) $field .= ' ' . $parameters;
    $field .= '>';
    if (empty($default) && isset($GLOBALS[$name])) $default = stripslashes($GLOBALS[$name]);
	if (sizeof($values) > 0) {
		foreach ($values as $choice) {
		  $field .= '<option value="' . gen_output_string($choice['id']) . '"';
		  if (is_array($default)) { // handles pull down with size and multiple parameters set
		    if (in_array($choice['id'], $default)) $field .= ' selected="selected"';
		  } else {
			if ($default == $choice['id']) $field .= ' selected="selected"';
		  }
	
		  $field .= '>' . htmlspecialchars($choice['text']) . '</option>';
		}
	}
    $field .= '</select>';
    if ($required == true) $field .= TEXT_FIELD_REQUIRED;
    return $field;
  }

////
// Output a combo type box (allows direct entry and pull down selection)
  function html_combo_box($name, $values, $default = '', $parameters = '', $width = '220px', $onchange = '', $id = false) {
	if (!$id) {
	  if (strpos($name, '[]')) { // don't show id attribute if generic array
	    $id = str_replace('[]', '', $name);
	  } else {
	    $id = str_replace('[', '_', gen_output_string($name)); // clean up for array inputs causing html errors
	    $id = str_replace(']', '', $id);
      }
	}
	$field  = '<input type="text" name="' . $name . '"';
	if ($id) $field .= ' id="' . $id . '"';
	$field .= ' value="' . $default . '" ' . $parameters . ' />';
	$field .= '<img name="imgName' . $id . '" id="imgName' . $id . '" alt="" src="' . DIR_WS_ICONS . '16x16/phreebooks/pull_down_inactive.gif" height="16" width="16" align="top" style="border:none;" onmouseover="handleOver(\'imgName' . $id . '\'); return true;" onmouseout="handleOut(\'imgName' . $id . '\'); return true;" onclick="JavaScript:menuActivate(\'' . $id . '\', \'combodiv' . $id . '\', \'combosel' . $id . '\', \'imgName' . $id . '\')" />';
	$field .= '<div id="combodiv' . $id . '" style="position:absolute; display:none; top:0px; left:0px; z-index:10000" onmouseover="javascript:oOverMenu=\'combodiv' . $id . '\';" onmouseout="javascript:oOverMenu=false;">';
	$field .= '<select size="10" id="combosel' . $id . '" style="width:' . $width . '; border-style:none" onchange="JavaScript:textSet(\'' . $id . '\', this.value); ' . $onchange . ';" onkeypress="JavaScript:comboKey(\'' . $id . '\', this, event);">';
    for ($i = 0; $i < sizeof($values); $i++) {
      $field .= '<option value="' . $values[$i]['id'] . '"';
      if ($default == $values[$i]['id']) $field .= ' selected="selected"';
      $field .= '>' . htmlspecialchars($values[$i]['text']) . '</option>';
    }
	$field .= '</select></div>';
	return $field;
  }

  function html_heading_bar($heading_array, $list_order, $extra_headings = array(TEXT_ACTION)) {
	global $PHP_SELF;
	$result = array();
	$href_path = str_replace(DIR_WS_ADMIN, '', $PHP_SELF);
	foreach ($heading_array as $key => $value) {
		if (!isset($result['disp_order'])) $result['disp_order'] = $key; // set the first key to the default
		if (strpos($key, ',') === false) {
			$key_desc = $key . '-desc';
			$disp_desc = $key . ' DESC';
		} else {
			$key_desc = substr($key, 0, strpos($key, ',')) . '-desc';
			$disp_desc = substr($key, 0, strpos($key, ',')) . ' DESC' . substr($key, strpos($key, ','));
		}
		if ($key == $list_order) $result['disp_order'] = $key;
		if ($key_desc == $list_order) $result['disp_order'] = $disp_desc;

		$output .= '<td class="dataTableHeadingContent">' . chr(10);
		$output .= (($list_order == $key || $list_order == $key_desc) ? ('<span class="SortOrderHeader">' . $value . '</span>') : $value);
		$output .= '<br />' . chr(10);
		if ($value <> '') {
			$output .= '<a href="' . html_href_link($href_path, gen_get_all_get_params(array('action', 'list_order')) . '&amp;list_order=' . $key, 'SSL') . '">' . ($list_order == $key ? '<span class="SortOrderHeader">' : '<span class="SortOrderHeaderLink">') . TEXT_ASC . '</span></a>&nbsp;' . chr(10);
			$output .= '<a href="' . html_href_link($href_path, gen_get_all_get_params(array('action', 'list_order')) . '&amp;list_order=' . $key_desc, 'SSL') . '">' . ($list_order == $key_desc ? '<span class="SortOrderHeader">' : '<span class="SortOrderHeaderLink">') . TEXT_DESC . '</span></a>' . chr(10);
		}
		$output .= '</td>' . chr(10);
	}
	if (sizeof($extra_headings) > 0) foreach ($extra_headings as $value) {
		$output .= '<td class="dataTableHeadingContentXtra">' . $value . '</td>' . chr(10);
	}
	$result['html_code'] = $output;
	return $result;
  }

  function html_control_panel($module, $cp_boxes) {
  	global $db;
	$column = 1;
	$output  = '<div style="text-align:right">';
	$output .= '<a href="' . html_href_link(FILENAME_DEFAULT, 'cat=general&amp;module=ctl_panel&amp;pID=' . $module, 'SSL') . '">' . CP_CHANGE_PROFILE . '</a></div>' . chr(10);
	$output .= '<table width="100%" border="0" cellspacing="2" cellpadding="2">' . chr(10);
	$output .= '<tr><td width="33%" valign="top">' . chr(10);
	$output .= '<div id="col_' . $column . '" style="position:relative;">' . chr(10);
	while(!$cp_boxes->EOF) {
		if ($cp_boxes->fields['column_id'] <> $column) {
			while ($cp_boxes->fields['column_id'] <> $column) {
				$column++;
				$output .= '</div>' . chr(10);
				$output .= '</td>' . chr(10);
				$output .= '<td width="33%" valign="top">' . chr(10);
				$output .= '<div id="col_' . $column . '" style="position:relative;">' . chr(10);
			}
		}
		$module_id = $cp_boxes->fields['module_id'];
		$column_id = $cp_boxes->fields['column_id'];
		$row_id = $cp_boxes->fields['row_id'];
		$params = unserialize($cp_boxes->fields['params']);
		include_once (DIR_FS_MODULES . 'general/boxes/' . $module_id . '.php');
		include_once (DIR_FS_MODULES . 'general/language/' . $_SESSION['language'] . '/boxes/' . $module_id . '.php');
		$new_box = new $module_id;
		$new_box->column_id = $column_id;
		$new_box->row_id = $row_id;
		$new_box->page_id = $module;
		$output .= $new_box->Output($params);
		$cp_boxes->MoveNext();
	}

	while (MAX_CP_COLUMNS <> $column) { // fill remaining columns with blank space
		$column++;
		$output .= '    </div>' . chr(10);
		$output .= '  </td>' . chr(10);
		$output .= '  <td width="33%" valign="top">' . chr(10);
		$output .= '    <div id="col_' . $column . '" style="position:relative;">' . chr(10);
	}
    $output .=  '</div>' . chr(10);
    $output .= '</td>' . chr(10);
    $output .= '</tr>' . chr(10);
	$output .= '</table>' . chr(10);
	return $output;
  }
?>