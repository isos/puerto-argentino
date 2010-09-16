<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2008 PhreeSoft, LLC                               |
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
//  Path: /modules/assets/pages/main/template_main.php
//

echo html_form('assets', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);
echo html_hidden_field('todo', '') . chr(10);
echo html_hidden_field('rowSeq', '') . chr(10);
// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show'] = false;
$toolbar->icon_list['delete']['show'] = false;
$toolbar->icon_list['save']['show'] = false;
$toolbar->icon_list['print']['show'] = false;
if ($security_level > 1) $toolbar->add_icon('new', 'onclick="submitToDo(\'new\')"', $order = 10);

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

$toolbar->add_help('');
if ($search_text) $toolbar->search_text = $search_text;
echo $toolbar->build_toolbar($add_search = true); 
?>
<div class="pageHeading"><?php echo BOX_ASSETS_MAINTAIN; ?></div>
<table border="0" width="100%" cellspacing="0" cellpadding="1">
  <tr class="dataTableHeadingRow"><?php  echo $list_header; ?></tr>
<?php
    while (!$query_result->EOF) {
		// only show quantity on hand if it is an asset trackable item
		$qty_in_stock = '';
?>
  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
	<td class="dataTableContent" onclick="submitSeq(<?php echo $query_result->fields['id'] . ', \'edit\''; ?>)"><?php echo $query_result->fields['asset_id']; ?></td>
	<td class="dataTableContent" onclick="submitSeq(<?php echo $query_result->fields['id'] . ', \'edit\''; ?>)"><?php echo $assets_types[$query_result->fields['asset_type']]; ?></td>
	<td class="dataTableContent" align="center" onclick="submitSeq(<?php echo $query_result->fields['id'] . ', \'edit\''; ?>)"><?php echo $query_result->fields['serial_number']; ?></td>
	<td class="dataTableContent" onclick="submitSeq(<?php echo $query_result->fields['id'] . ', \'edit\''; ?>)"><?php echo $query_result->fields['description_short']; ?></td>
	<td class="dataTableContent" align="center" onclick="submitSeq(<?php echo $query_result->fields['id'] . ', \'edit\''; ?>)"><?php echo ($query_result->fields['inactive'] == '0' ? '' : TEXT_YES); ?></td>
	<td class="dataTableContent" align="right">
<?php 
// build the action toolbar
	  // first pull in any extra buttons, this is dynamic since each row can have different buttons
	  if (function_exists('add_extra_action_bar_buttons')) echo add_extra_action_bar_buttons($query_result->fields);

	  if ($security_level > 1) echo html_icon('actions/edit-find-replace.png', TEXT_EDIT, 'small', 'onclick="submitSeq(' . $query_result->fields['id'] . ', \'edit\')"') . chr(10);
	  if ($security_level > 3) echo html_icon('apps/accessories-text-editor.png', TEXT_RENAME, 'small', 'onclick="renameItem(' . $query_result->fields['id'] . ')"') . chr(10);
	  if ($security_level > 3) echo html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . ASSETS_MSG_DELETE_ASSET . '\')) deleteItem(' . $query_result->fields['id'] . ')"') . chr(10);
	  if ($security_level > 1) echo html_icon('actions/edit-copy.png', TEXT_COPY_TO, 'small', 'onclick="copyItem(' . $query_result->fields['id'] . ')"') . chr(10);
?>
	</td>
  </tr> 
<?php
      $query_result->MoveNext();
    }
?>
</table>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER . TEXT_ASSETS); ?></div>
</form>