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
//  Path: /modules/services/pages/imp_exp/template_main.php
//

// start the form
echo html_form('import_export', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
	echo html_hidden_field('id', $id) . chr(10);
	echo html_hidden_field('definition_name', '') . chr(10);
	echo html_hidden_field('definition_description', '') . chr(10);
	echo html_hidden_field('todo', '') . chr(10);
	echo html_hidden_field('rowSeq', '') . chr(10);
	echo html_hidden_field('moveSeq', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['params'] = 'onclick="submitToDo(\'open\')"';
$toolbar->icon_list['save']['show'] = false;
if ($security_level > 1) $toolbar->add_icon('new', 'onclick="submitToDo(\'new\')"', $order = 10);
if ($security_level > 2) $toolbar->add_icon('rename', 'onclick="if (fetch_def_info()) submitToDo(\'rename\')"', $order = 12);
if ($security_level < 4) {
	$toolbar->icon_list['delete']['show'] = false;
} else {
	$toolbar->icon_list['delete']['params'] = 'onclick="if (confirm(\'' . SRV_DELETE_CONFIRM . '\')) submitToDo(\'delete\')"';
}
$toolbar->icon_list['print']['show'] = false;
if ($security_level > 1) $toolbar->add_icon('copy', 'onclick="if (fetch_def_info()) submitToDo(\'copy\')"', $order = 13);

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('10');
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo IE_HEADING_TITLE; ?></div>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
	<td valign="top">
	  <ul class="tabset_tabs">
<?php 
$show_active = false;
foreach ($tab_groups as $key=>$value) {
	$active = !$show_active ? ' class="active"' : '';
	echo '<li><a href="#' . $key . '"' . $active . '>' .  $value . '</a></li>' . chr(10);
	$show_active = true;
}
?>
	  </ul>
<?php
$query_raw = "select id, group_id, custom, security, title, description, table_name
	from " . TABLE_IMPORT_EXPORT . " order by group_id";
$definitions = $db->Execute($query_raw);
foreach ($tab_groups as $key => $value) {
	echo '<div id="' . $key . '" class="tabset_content">' . chr(10);
	echo '<h2 class="tabset_label">' . $value . '</h2>' . chr(10);
	$definitions->Move(0);
	$definitions->MoveNext();
	while (!$definitions->EOF) {
		if ($definitions->fields['group_id'] == $key) {
			echo html_radio_field('id', $definitions->fields['id'], false, '', '');
			echo $definitions->fields['title'] . ' - ' . $definitions->fields['description'] . chr(10);
			echo '<br />';
		}
		$definitions->MoveNext();
	}
	echo '</div>' . chr(10);
}
?>
	</td>
  </tr>
</table>
</form>