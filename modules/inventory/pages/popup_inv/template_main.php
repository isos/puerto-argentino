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
//  Path: /modules/inventory/pages/popup_inv/template_main.php
//

// start the form
echo html_form('search_form', FILENAME_DEFAULT, gen_get_all_get_params(array('action', 'f0', 'f1', 'f2', 'f3', 'f4', 'f5'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo',   '') . chr(10);
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
$toolbar->add_help('07.04.01');
if ($search_text) $toolbar->search_text = $search_text;
$toolbar->search_period = $acct_period;
echo $toolbar->build_toolbar($add_search = true); 

// Build the page
?>
<div class="pageHeading"><?php echo INV_POPUP_WINDOW_TITLE; ?></div>
<div id="filter_bar">
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td><?php echo TEXT_FILTERS . '&nbsp;' . TEXT_SHOW_INACTIVE . '&nbsp;' . html_checkbox_field('f0', '1', $f0); ?></td>
	<td><?php echo '&nbsp;' . INV_ENTRY_INVENTORY_TYPE . '&nbsp;' . html_pull_down_menu('f1', $type_select_list, $f1, ''); ?></td>
<?php if ($account_type == 'v' && $contactID) {?>
	<td><?php echo '&nbsp;' . INV_HEADING_PREFERRED_VENDOR . '&nbsp;' . html_checkbox_field('f2', '1', $f2); ?></td>
<?php } ?>
	<td><?php echo '&nbsp;' . html_button_field('apply', TEXT_APPLY, 'onclick="form.submit();"'); ?></td>
  </tr>
</table>
</div>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ITEMS); ?></div>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr class="dataTableHeadingRow"><?php  echo $list_header; ?></tr>
<?php
	while (!$query_result->EOF) {
	  $display_stock = true;
	  if (strpos(COG_ITEM_TYPES, $query_result->fields['inventory_type']) === false) {
		$display_stock = false;
		$return_stock  = TEXT_NA;
	  } elseif (ENABLE_MULTI_BRANCH) {
	  	$store_stock  = load_store_stock($query_result->fields['sku'], $store_id);
	  }
	  switch ($account_type) {
		default:
		case 'c': $price = $query_result->fields['full_price']; break;
		case 'v': $price = $query_result->fields['item_cost'];  break;
	  }
	  $bkgnd = ($query_result->fields['inactive']) ? ' style="background-color:pink"' : '';
?>
  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="setReturnItem(<?php echo $query_result->fields['id']; ?>)">
	<td class="dataTableContent"<?php echo $bkgnd; ?>><?php echo $query_result->fields['sku']; ?></td>
	<td class="dataTableContent"><?php echo $query_result->fields['description_short']; ?></td>
	<td class="dataTableContent" align="right"><?php echo $currencies->precise($price); ?></td>
	<td class="dataTableContent" align="center"><?php echo ($display_stock) ? $query_result->fields['quantity_on_hand'] : '&nbsp;'; ?></td>
	<td class="dataTableContent" align="center"><?php echo ($display_stock) ? $query_result->fields['quantity_on_order'] : '&nbsp;'; ?></td>
	<?php if (ENABLE_MULTI_BRANCH) echo '<td class="dataTableContent" align="center">' . ($display_stock ? $store_stock : '&nbsp;') . '</td>' . chr(10); ?>
  </tr>
<?php
	  $query_result->MoveNext();
	}
?>
</table>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ITEMS); ?></div>
</form>