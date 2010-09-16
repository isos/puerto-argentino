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
//  Path: /modules/accounts/pages/main/template_main.php
//

// start the form
echo html_form('accounts', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '')   . chr(10);
echo html_hidden_field('rowSeq', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['print']['show']    = false;
if ($security_level > 1) $toolbar->add_icon('new', 'onclick="submitToDo(\'new\')"', $order = 10);

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
switch ($type) {
  case 'c': $toolbar->add_help('07.03.02'); break;
  case 'v': $toolbar->add_help('07.02.02'); break;
  case 'e': $toolbar->add_help('07.07.01'); break;
  case 'b': $toolbar->add_help('07.08.04'); break;
}
if ($search_text) $toolbar->search_text = $search_text;
echo $toolbar->build_toolbar($add_search = true);

// Build the page
?>
<div class="pageHeading"><?php echo constant('ACT_' . strtoupper($type) . '_HEADING_TITLE'); ?></div>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER . constant('ACT_' . strtoupper($type) . '_TYPE_NAME')); ?></div>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr class="dataTableHeadingRow"><?php  echo $list_header; ?></tr>
<?php
    while (!$query_result->EOF) {
	  $bkgnd = ($query_result->fields['inactive']) ? ' style="background-color:pink"' : '';
?>
  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
    <td class="dataTableContent"<?php echo $bkgnd; ?> onclick="submitSeq(<?php echo $query_result->fields['id']; ?>, 'edit')"><?php echo htmlspecialchars($query_result->fields['short_name']); ?></td>
    <td class="dataTableContent"<?php echo $bkgnd; ?> onclick="submitSeq(<?php echo $query_result->fields['id']; ?>, 'edit')"><?php echo htmlspecialchars($type == 'e' ? $query_result->fields['contact_first'] . ' ' . $query_result->fields['contact_last'] : $query_result->fields['primary_name']); ?></td>
	<td class="dataTableContent" onclick="submitSeq(<?php echo $query_result->fields['id']; ?>, 'edit')"><?php echo htmlspecialchars($query_result->fields['address1']); ?></td>
	<td class="dataTableContent" onclick="submitSeq(<?php echo $query_result->fields['id']; ?>, 'edit')"><?php echo htmlspecialchars($query_result->fields['city_town']); ?></td>
	<td class="dataTableContent" onclick="submitSeq(<?php echo $query_result->fields['id']; ?>, 'edit')"><?php echo htmlspecialchars($query_result->fields['state_province']); ?></td>
	<td class="dataTableContent" onclick="submitSeq(<?php echo $query_result->fields['id']; ?>, 'edit')"><?php echo htmlspecialchars($query_result->fields['postal_code']); ?></td>
	<td class="dataTableContent" onclick="submitSeq(<?php echo $query_result->fields['id']; ?>, 'edit')"><?php echo htmlspecialchars($query_result->fields['telephone1']); ?></td>
	<td class="dataTableContent" align="right">
<?php
// build the action toolbar
	  // first pull in any extra buttons, this is dynamic since each row can have different buttons
	  if (function_exists('add_extra_action_bar_buttons')) echo add_extra_action_bar_buttons($query_result->fields);

	  if ($security_level > 1) echo html_icon('actions/edit-find-replace.png', TEXT_EDIT, 'small', 'onclick="submitSeq(' . $query_result->fields['id'] . ', \'edit\')"') . chr(10);
	  if ($security_level > 3) echo html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . ACT_WARN_DELETE_ACCOUNT . '\')) submitSeq(' . $query_result->fields['id'] . ', \'delete\')"') . chr(10);
?>
	</td>
  </tr>
<?php
      $query_result->MoveNext();
    }
?>
</table>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER . constant('ACT_' . strtoupper($type) . '_TYPE_NAME')); ?></div>
</form>
