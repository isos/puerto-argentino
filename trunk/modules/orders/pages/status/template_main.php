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
//  Path: /modules/orders/pages/status/template_main.php
//

// start the form
echo html_form('status', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '')   . chr(10);
echo html_hidden_field('rowSeq', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['print']['show']    = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
  foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
switch (JOURNAL_ID) {
  case  3: $toolbar->add_help('07.02.03.04'); break;
  case  4: $toolbar->add_help('07.02.03.04'); break;
  case  9: $toolbar->add_help('07.03.03.04'); break;
  case 10: $toolbar->add_help('07.03.03.04'); break;
}
if ($search_text) $toolbar->search_text = $search_text;
$toolbar->search_period = $acct_period;
echo $toolbar->build_toolbar($add_search = true, $add_periods = true,$add_date=false,$add_closed=true);
?> 

<div class="pageHeading"><?php echo PAGE_TITLE; ?></div>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?>
</div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], constant('ORD_TEXT_' . JOURNAL_ID . '_NUMBER_OF_ORDERS')); ?>
</div>
<table border="0" width="100%" cellspacing="0" cellpadding="1">
  <tr class="dataTableHeadingRow"><?php echo $list_header; ?></tr>
<?php
	while (!$query_result->EOF) {
	  $oID               = $query_result->fields['id'];
	  $bill_primary_name = $query_result->fields['bill_primary_name'];
	  $total_amount      = $currencies->format_full($query_result->fields['total_amount'], true, $query_result->fields['currencies_code'], $query_result->fields['currencies_value']);
	  if (ENABLE_MULTI_CURRENCY) $total_amount .= ' (' . $query_result->fields['currencies_code'] . ')';
?>
  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
	<td class="dataTableContent" onclick="window.open('<?php echo html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;oID=' . $oID . '&amp;jID=' . JOURNAL_ID . '&amp;action=edit', 'SSL'); ?>','_blank')"><?php echo gen_spiffycal_db_date_short($query_result->fields['post_date']); ?></td>
	<td class="dataTableContent" onclick="window.open('<?php echo html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;oID=' . $oID . '&amp;jID=' . JOURNAL_ID . '&amp;action=edit', 'SSL'); ?>','_blank')"><?php echo htmlspecialchars($query_result->fields['purchase_invoice_id']); ?></td>
	<td class="dataTableContent" onclick="window.open('<?php echo html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;oID=' . $oID . '&amp;jID=' . JOURNAL_ID . '&amp;action=edit', 'SSL'); ?>','_blank')"><?php echo htmlspecialchars($query_result->fields['purch_order_id']); ?></td>
	<td class="dataTableContent" onclick="window.open('<?php echo html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;oID=' . $oID . '&amp;jID=' . JOURNAL_ID . '&amp;action=edit', 'SSL'); ?>','_blank')"><?php echo (($query_result->fields['closed']) ? TEXT_YES : ''); ?></td>
	<td class="dataTableContent" onclick="window.open('<?php echo html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;oID=' . $oID . '&amp;jID=' . JOURNAL_ID . '&amp;action=edit', 'SSL'); ?>','_blank')"><?php echo htmlspecialchars($bill_primary_name); ?></td>
	<td class="dataTableContent" align="right" onclick="window.open('<?php echo html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;oID=' . $oID . '&amp;jID=' . JOURNAL_ID . '&amp;action=edit', 'SSL'); ?>','_blank')"><?php echo $total_amount; ?></td>
	<td class="dataTableContent" align="right">
<?php
	// build the action toolbar
	if (function_exists('add_extra_action_bar_buttons')) echo add_extra_action_bar_buttons($query_result->fields);

	switch (JOURNAL_ID) {
	  case  3: break;
	  case  4: 
		if (!$query_result->fields['closed']) echo html_button_field('invoice_' . $oID, TEXT_RECEIVE, 'onclick="window.open(\'' . html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;oID=' . $oID . '&amp;jID=6&amp;action=prc_so', 'SSL') . '\',\'_blank\')"') . chr(10);
		echo html_button_field('delivery_' . $oID, ORD_DELIVERY_DATES, 'onclick="deliveryList(' . $oID . ')"') . chr(10);
	    break;
	  case  9: break;
	  case 10: 
		if (!$query_result->fields['closed']) echo html_button_field('invoice_' . $oID, TEXT_INVOICE, 'onclick="window.open(\'' . html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;oID=' . $oID . '&amp;jID=12&amp;action=prc_so', 'SSL') . '\',\'_blank\')"') . chr(10);
		echo html_button_field('delivery_' . $oID, ORD_DELIVERY_DATES, 'onclick="deliveryList(' . $oID . ')"') . chr(10);
	    break;
	}
	echo html_icon('actions/document-print.png', TEXT_PRINT, 'small', 'onclick="printOrder(' . $oID . ')"') . chr(10);
	echo html_icon('actions/edit-find-replace.png', TEXT_EDIT, 'small', 'onclick="window.open(\'' . html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;oID=' . $oID . '&amp;jID=' . JOURNAL_ID . '&amp;action=edit', 'SSL') . '\',\'_blank\')"') . chr(10);
?>
	</td>
  </tr>
<?php
	  $query_result->MoveNext();
	}
?>
</table>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], constant('ORD_TEXT_' . JOURNAL_ID . '_NUMBER_OF_ORDERS')); ?></div>
</form>
