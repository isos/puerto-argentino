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
//  Path: /modules/inventory/pages/bulk_prices/template_main.php
//

// start the form
echo html_form('bulk_prices', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['params']   = 'onclick="submitToDo(\'save\')"';
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['print']['show']    = false;
if ($security_level < 3) $toolbar->icon_list['save']['show'] = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
  foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('07.04.06');
if ($search_text) $toolbar->search_text = $search_text;
echo $toolbar->build_toolbar($add_search = true); 

// Build the page
?>
<div class="pageHeading"><?php echo INV_BULK_SKU_ENTRY_TITLE; ?></div>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER . TEXT_ITEMS); ?></div>
<table border="0" width="100%" cellspacing="0" cellpadding="1">
  <tr class="dataTableHeadingRow"><?php echo $list_header; ?></tr>
<?php
	$j = 1;
    while (!$query_result->EOF) {
?>
  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
	<td class="dataTableContent"><?php echo html_hidden_field('id_' . $j, $query_result->fields['id']) . $query_result->fields['sku']; ?></td>
	<td class="dataTableContent"><?php echo ($query_result->fields['inactive'] == '1' ? TEXT_YES : ''); ?></td>
	<td class="dataTableContent"><?php echo $query_result->fields['description_short']; ?></td>
	<td class="dataTableContent"><?php echo html_input_field('lead_' . $j, $query_result->fields['lead_time'], 'size="11" style="text-align:right"'); ?></td>
	<td class="dataTableContent"><?php echo html_input_field('cost_' . $j, $currencies->precise($query_result->fields['item_cost']), 'size="11" style="text-align:right"'); ?></td>
	<td class="dataTableContent"><?php echo html_input_field('sell_' . $j, $currencies->precise($query_result->fields['full_price']), 'size="11" style="text-align:right"'); ?></td>
	<td class="dataTableContent" align="right"><?php if ($security_level > 1) echo html_icon('status/mail-attachment.png', BOX_PRICE_SHEET_MANAGER, 'small', $params = 'onclick="priceMgr(' . $j . ', ' . $query_result->fields['id'] . ')"'); ?></td>
  </tr>
<?php
		$j++;
		$query_result->MoveNext();
    }
?>
</table>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER . TEXT_ITEMS); ?></div>
</form>
