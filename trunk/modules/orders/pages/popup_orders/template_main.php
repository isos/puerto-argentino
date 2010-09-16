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
//  Path: /modules/orders/pages/popup_orders/template_main.php
//

// start the form
echo html_form('popup_orders', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

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
switch(JOURNAL_ID) {
	case  3: $toolbar->add_help('07.02.04.02'); break;
	case  4: $toolbar->add_help('07.02.03.02'); break;
	case  6: $toolbar->add_help('07.02.05.02'); break;
	case  7: $toolbar->add_help('07.02.07.02'); break;
	case  9: $toolbar->add_help('07.03.04.02'); break;
	case 10: $toolbar->add_help('07.03.03.02'); break;
	case 12: $toolbar->add_help('07.03.05.02'); break;
	case 13: $toolbar->add_help('07.03.07.02'); break;
	case 18: $toolbar->add_help('07.05.02');    break;
//	case 19: $toolbar->add_help('07.03.06.02'); break;
	case 20: $toolbar->add_help('07.05.01');    break;
//	case 21: $toolbar->add_help('07.02.06.02'); break;
}
if ($search_text) $toolbar->search_text = $search_text;
$toolbar->search_period = $acct_period;
echo $toolbar->build_toolbar($add_search = true, $add_period = true); 

// Build the page
?>
<div class="pageHeading"><?php echo constant('ORD_POPUP_WINDOW_TITLE_' . JOURNAL_ID); ?></div>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], constant('ORD_TEXT_' . JOURNAL_ID . '_NUMBER_OF_ORDERS')); ?></div>
<table border="0" width="100%" cellspacing="0" cellpadding="1">
  <tr class="dataTableHeadingRow"><?php echo $list_header; ?></tr>
<?php
	while (!$query_result->EOF) {
	  switch (JOURNAL_ID) {
	  	case  3:
	  	case  4:
	  	case  9:
	  	case 10:
	  	case 12:
//	  	case 19:
	  	case 13: $closed = $query_result->fields['closed'];  break;
	  	case  6:
//	  	case 21:
	  	case  7: $closed = $query_result->fields['waiting']; break;
	  }
	  $purch_order_id = ($query_result->fields['so_po_ref_id']) ? ord_get_so_po_num($query_result->fields['so_po_ref_id']): '';
	  $total_amount   = $currencies->format_full($query_result->fields['total_amount'], true, $query_result->fields['currencies_code'], $query_result->fields['currencies_value']);
	  if (ENABLE_MULTI_CURRENCY) $total_amount .= ' (' . $query_result->fields['currencies_code'] . ')';
?>
  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="setReturnOrdr(<?php echo $query_result->fields['id']; ?>, false)">
	<td class="dataTableContent"><?php echo gen_spiffycal_db_date_short($query_result->fields['post_date']); ?></td>
	<td class="dataTableContent"><?php echo $query_result->fields['purchase_invoice_id']; ?></td>
	<?php switch (JOURNAL_ID) {
		case  6:
		case 12:
			echo '<td class="dataTableContent">' . $purch_order_id . '</td>'; break;
		case  7:
		case 13:
			echo '<td class="dataTableContent">' . $query_result->fields['purch_order_id'] . '</td>'; break;
		default:
	} ?>
	<td class="dataTableContent"><?php echo ($closed ? TEXT_YES : ''); ?></td>
	<td class="dataTableContent"><?php echo $query_result->fields['bill_primary_name']; ?></td>
	<td class="dataTableContent" align="right"><?php echo $total_amount; ?></td>
  </tr>
<?php
	  $query_result->MoveNext();
	}
?>
</table>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], constant('ORD_TEXT_' . JOURNAL_ID . '_NUMBER_OF_ORDERS')); ?></div>
</form>
