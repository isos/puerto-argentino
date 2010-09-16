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
//  Path: /modules/accounts/pages/popup_accts/template_main.php
//

// start the form
echo html_form('popup_accts', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '')   . chr(10);
echo html_hidden_field('rowSeq', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="self.close()"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['print']['show']    = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
switch ($account_type) {
  case 'c': $toolbar->add_help('07.02.02'); break;
  case 'v': $toolbar->add_help('07.03.02'); break;
}
if ($search_text) $toolbar->search_text = $search_text;
echo $toolbar->build_toolbar($add_search = true); 

// Build the page
?>
<div class="pageHeading"><?php echo GEN_HEADING_PLEASE_SELECT; ?></div>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER . constant('ACT_' . strtoupper($account_type) . '_TYPE_NAME')); ?></div>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr class="dataTableHeadingRow"><?php echo $list_header; ?></tr>
<?php
  $pointer = 0;
  while (!$query_result->EOF) {
    $cancel_single_result_exit = false;	// if there is only one search result but has pull down window choices
	$acct_id = $query_result->fields['id'];
	$bkgnd   = ($query_result->fields['inactive']) ? ' style="background-color:pink"' : '';
?>
  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
	<td class="dataTableContent"<?php echo $bkgnd; ?> onclick="<?php echo 'setReturnAccount(' . $acct_id . ')'; ?>"><?php echo htmlspecialchars($query_result->fields['primary_name']); ?></td>
	<td class="dataTableContent" onclick="<?php echo 'setReturnAccount(' . $acct_id . ')'; ?>"><?php echo htmlspecialchars($query_result->fields['address1']); ?></td>
	<td class="dataTableContent" onclick="<?php echo 'setReturnAccount(' . $acct_id . ')'; ?>"><?php echo htmlspecialchars($query_result->fields['city_town']); ?></td>
	<td class="dataTableContent" onclick="<?php echo 'setReturnAccount(' . $acct_id . ')'; ?>"><?php echo htmlspecialchars($query_result->fields['state_province']); ?></td>
	<td class="dataTableContent" onclick="<?php echo 'setReturnAccount(' . $acct_id . ')'; ?>"><?php echo htmlspecialchars($query_result->fields['postal_code']); ?></td>
	<td class="dataTableContent" onclick="<?php echo 'setReturnAccount(' . $acct_id . ')'; ?>"><?php echo htmlspecialchars($query_result->fields['telephone1']); ?></td>
	<?php switch (JOURNAL_ID) {
		case  6:
		case  7:
		case 12:
		case 13:
			switch (JOURNAL_ID) {
				case  6: $search_journal = 4;  break;
				case  7: $search_journal = 6;  break;
				case 12: $search_journal = 10; break;
				case 13: $search_journal = 12; break;
			}
			$open_order_array = load_open_orders($acct_id, $search_journal);
			if ($open_order_array) {
				$selection = html_pull_down_menu('open_order_' . $pointer, $open_order_array, '', 'onchange="setReturnOrder(' . $pointer . ')"');
				$cancel_single_result_exit = true;
			} else {
				$selection = html_hidden_field('open_order_' . $pointer, '');
			}
			break;
		default:
			$selection = html_hidden_field('open_order_' . $pointer, '') . '&nbsp;';
	} 
	if ($cancel_single_result_exit) { ?>
	  <td class="dataTableContent" ><?php echo $selection; ?></td>
	<?php } else { ?>
	  <td class="dataTableContent" onclick="<?php echo 'setReturnAccount(' . $acct_id . ')'; ?>"><?php echo $selection; ?></td>
	<?php } ?>
  </tr>
<?php
	  $pointer++;
	  $query_result->MoveNext();
	}
?>
</table>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER . constant('ACT_' . strtoupper($account_type) . '_TYPE_NAME')); ?></div>
</form>

<?php 
if (($query_result->RecordCount() == 1) && ($_POST['page'] == 1) && (!$cancel_single_result_exit)) { // then only one entry return with it
  echo '<script type="text/javascript">' . chr(10);
  echo 'setReturnAccount(' . $acct_id . ');' . chr(10);
  echo '</script>' . chr(10);
}
?>