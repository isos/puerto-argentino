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
//  Path: /modules/services/pages/imp_exp/template_detail.php
//

// start the form 
echo html_form('import_export', FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'post', 'enctype="multipart/form-data"', true) . chr(10);

// include hidden fields
echo html_hidden_field('id', $id) . chr(10);
echo html_hidden_field('definition_name', '') . chr(10);
echo html_hidden_field('definition_description', '') . chr(10);
echo html_hidden_field('todo', '') . chr(10);
echo html_hidden_field('rowSeq', '') . chr(10);
echo html_hidden_field('moveSeq', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL') . '\'"';
$toolbar->icon_list['open']['show'] = false;
$toolbar->icon_list['save']['params'] = 'onclick="submitToDo(\'save\')"';
if ($security_level > 1) $toolbar->add_icon('import', 'onclick="submitToDo(\'import\')"', $order = 14);
if ($security_level > 1) $toolbar->add_icon('export', 'onclick="submitToDo(\'export\')"', $order = 15);
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
<div class="pageHeading"><?php echo IE_HEADING_TITLE_CRITERIA . ' - ' . $definitions->fields['title']; ?></div>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
	<td valign="top">
	  <ul class="tabset_tabs">
		<li><a href="#fields"<?php echo ($default_tab == 'fields' ? ' class="active"' : '') ?>><?php echo TEXT_FIELDS; ?></a></li>
		<li><a href="#criteria"<?php echo ($default_tab == 'criteria' ? ' class="active"' : '') ?>><?php echo IE_HEADING_CRITERIA; ?></a></li>
		<li><a href="#options"<?php echo ($default_tab == 'options' ? ' class="active"' : '') ?>><?php echo TEXT_OPTIONS; ?></a></li>
	  </ul>

	  <div id="fields" class="tabset_content">
		<h2 class="tabset_label"><?php echo TEXT_FIELDS; ?></h2>
		<table id="field_table" border="0" width="100%" cellspacing="0" cellpadding="2">
			<tr class="dataTableHeadingRow">
				<td class="dataTableHeadingContent" align="center"><?php echo TEXT_SEQUENCE; ?></td>
				<td class="dataTableHeadingContent" align="center"><?php echo TEXT_FLDNAME; ?></td>
				<td class="dataTableHeadingContent" align="center"><?php echo TEXT_PROCESSING; ?></td>
				<td class="dataTableHeadingContent" align="center"><?php echo IE_HEADING_FIELDS_IMPORT; ?></td>
				<td class="dataTableHeadingContent" align="center"><?php echo TEXT_SHOW; ?></td>
				<td class="dataTableHeadingContent" align="center"><?php echo TEXT_ACTION; ?></td>
			</tr>
		<?php
			if (is_array($params)) foreach ($params as $key => $value) {
				$field_list[] = array('id' => $value['field'], 'text' => $value['name']);
				echo '<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . chr(10);
				echo '<td align="center">' . ($key + 1) . '</td>' . chr(10);
				echo '<td>' . $value['name'] . '</td>' . chr(10);
				echo '<td>' . $value['proc'] . '</td>' . chr(10);
				echo '<td align="center">' . ($value['mode']=='e' ? TEXT_NO : TEXT_YES) . '</td>' . chr(10);
				echo '<td align="center">' . ($value['show']=='1' ? TEXT_YES : TEXT_NO) . '</td>' . chr(10);
				echo '<td align="center">';
				echo html_icon('actions/edit-find-replace.png', TEXT_EDIT, 'small', 'onclick="fieldEdit(' . $id . ', ' . $key . ')"') . chr(10);
				echo html_icon('actions/view-fullscreen.png', TEXT_MOVE, 'small', 'onclick="moveField(' . $key . ', \'move\')"') . chr(10);
				echo html_icon('actions/go-up.png', TEXT_UP, 'small', 'onclick="submitSeq(' . $key . ', \'up\')"') . chr(10);
				echo html_icon('actions/go-down.png', TEXT_DOWN, 'small', 'onclick="submitSeq(' . $key . ', \'down\')"') . chr(10);
				echo '</td>' . chr(10);
				echo '</tr>' . chr(10);
			}
		?>
		</table>
	  </div>

	  <div id="criteria" class="tabset_content">
		<h2 class="tabset_label"><?php echo IE_HEADING_CRITERIA; ?></h2>
		<table border="0" width="100%" cellspacing="0" cellpadding="2">
			<tr class="dataTableHeadingRow">
				<td class="dataTableHeadingContent"><?php echo IE_CRITERIA_FILTER_FIELD; ?></td>
				<td class="dataTableHeadingContent"><?php echo TEXT_TYPE; ?></td>
				<td class="dataTableHeadingContent" align="center"><?php echo TEXT_FROM; ?></td>
				<td class="dataTableHeadingContent" align="center"><?php echo TEXT_TO; ?></td>
				<td class="dataTableHeadingContent" align="center"><?php echo TEXT_ACTION; ?></td>
			</tr>
		<?php
			if (!$criteria) {
				echo '<tr><td colspan="5">' . IE_INFO_NO_CRITERIA . '</td></tr>';
			} else {
				foreach ($criteria as $key => $value) {
					echo '<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">';
					echo html_hidden_field('cfield_' . $key, $value['cfield']);
					echo html_hidden_field('ctype_' . $key, $value['ctype']);
					echo '<td>' . ie_find_field_name($value['cfield'], $params) . '</td>';
					echo '<td>' . html_pull_down_menu('crit_' . $key, ie_convert_criteria_types($value['ctype']), $value['crit'], $parameters = '') . '</td>';
					echo '<td align="center">' . ($value['ctype']=='all_range' ? html_input_field('from_' . $key, $value['from'], $parameters = '') : '&nbsp;') . '</td>';
					echo '<td align="center">' . ($value['ctype']=='all_range' ? html_input_field('to_' . $key, $value['to'], $parameters = '') : '&nbsp;') . '</td>';
					echo '<td align="center">' . html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . SRV_DELETE_CRITERIA . '\')) submitSeq(' . $key . ', \'remove\')"') . '</td>';
					echo '</tr>';
				}
			}
			echo '<tr><td colspan="5">&nbsp;</td></tr>';
			echo '<tr class="dataTableHeadingRow"><td colspan="5" class="dataTableHeadingContent">' . IE_CRITERIA_FILTER_ADD_FIELD . '</td></tr>';
			echo '<tr>';
			echo '<td>' . html_pull_down_menu('new_cname', $field_list, '', $parameters = '') . '</td>';
			echo '<td>' . html_pull_down_menu('new_crit', $criteria_funcs, '', $parameters = '') . '</td>';
			echo '<td>&nbsp</td>';
			echo '<td>&nbsp</td>';
			echo '<td align="center">' . html_icon('actions/list-add.png', TEXT_ADD, 'medium', 'onclick="submitToDo(\'add\')"') . '</td>';
			echo '</tr>';
		?>
		</table>
	  </div>

	  <div id="options" class="tabset_content">
		<h2 class="tabset_label"><?php echo TEXT_OPTIONS; ?></h2>
		<table width="100%" border="0" cellspacing="0" cellpadding="2">
			<tr class="dataTableHeadingRow">
				<td colspan="2" class="dataTableHeadingContent"><?php echo IE_OPTIONS_GENERAL_SETTINGS; ?></td>
			</tr>
			<tr>
				<td><?php echo IE_OPTIONS_DELIMITER; ?></td>
				<td><?php echo html_pull_down_menu('delimiter', $delimiters, $options['delimiter']); ?></td>
			</tr>
			<tr>
				<td><?php echo IE_OPTIONS_QUALIFIER; ?></td>
				<td><?php echo html_pull_down_menu('qualifier', $qualifiers, isset($options['qualifier']) ? $options['qualifier'] : 'double_quote'); ?></td>
			</tr>
			<tr class="dataTableHeadingRow">
				<td colspan="2" class="dataTableHeadingContent"><?php echo IE_OPTIONS_IMPORT_SETTINGS; ?></td>
			</tr>
			<tr>
				<td><?php echo IE_OPTIONS_IMPORT_PATH; ?></td>
				<td><?php echo html_file_field('import_file_name'); ?></td>
			</tr>
			<tr>
				<td><?php echo IE_OPTIONS_INCLUDE_NAMES; ?></td>
				<td><?php echo html_checkbox_field('imp_headings', '1', $options['imp_headings'], '', $parameters = ''); ?></td>
			</tr>
			<tr class="dataTableHeadingRow">
				<td colspan="2" class="dataTableHeadingContent"><?php echo IE_OPTIONS_EXPORT_SETTINGS; ?></td>
			</tr>
			<tr>
				<td><?php echo IE_OPTIONS_EXPORT_PATH; ?></td>
				<td><?php echo html_input_field('export_file_name', $options['export_file_name'], $parameters = ''); ?></td>
			</tr>
			<tr>
				<td><?php echo IE_OPTIONS_INCLUDE_FIELD_NAMES; ?></td>
				<td><?php echo html_checkbox_field('exp_headings', '1', $options['exp_headings'], '', $parameters = ''); ?></td>
			</tr>
		</table>
	  </div>
	</td>
  </tr>
</table>
</form>