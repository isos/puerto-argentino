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
//  Path: /modules/orders/pages/inv_mgr/template_main.php
//

// start the form
echo html_form('inv_mgr', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

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
$toolbar->add_help('07.03.05.04');
if ($search_text) $toolbar->search_text = $search_text;
$toolbar->search_period = $acct_period;
echo $toolbar->build_toolbar($add_search = true, $add_periods = true); 

// Build the page
?>
<div class="pageHeading"><?php echo BOX_AR_INVOICE_MGR; ?></div>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], constant('ORD_TEXT_' . JOURNAL_ID . '_NUMBER_OF_ORDERS')); ?></div>
<table border="0" width="100%" cellspacing="0" cellpadding="1">
  <tr class="dataTableHeadingRow" valign="top"><?php echo $list_header; ?></tr>
<?php
	while (!$query_result->EOF) {
	  $oID = $query_result->fields['id'];
	  $post_date = $query_result->fields['post_date'];
	  $purchase_invoice_id = $query_result->fields['purchase_invoice_id'];
	  $closed = $query_result->fields['closed'];
	  $result = $db->Execute("select id, shipment_id from " . TABLE_SHIPPING_LOG . " where ref_id like '" . $purchase_invoice_id . "%'");
	  if ($result->RecordCount() > 0) {
	    $sID = $result->fields['id'];
	    $shipped = $result->fields['shipment_id'];
	  } else {
	    $sID = 0;
	    $shipped = false;
	  }
	  $temp = explode(':', $query_result->fields['shipper_code']);
	  $shipper_code = $temp[0];
	  $ship_method = $temp[1];
	  $bill_primary_name = $query_result->fields['bill_primary_name'];
?>
  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
	<td class="dataTableContent" onclick="window.open('<?php echo html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;oID=' . $oID . '&amp;jID=12&amp;action=edit', 'SSL'); ?>','_blank')"><?php echo gen_spiffycal_db_date_short($post_date); ?></td>
	<td class="dataTableContent" onclick="window.open('<?php echo html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;oID=' . $oID . '&amp;jID=12&amp;action=edit', 'SSL'); ?>','_blank')"><?php echo $purchase_invoice_id; ?></td>
	<td class="dataTableContent" onclick="window.open('<?php echo html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;oID=' . $oID . '&amp;jID=12&amp;action=edit', 'SSL'); ?>','_blank')"><?php echo (($closed) ? TEXT_YES : ''); ?></td>
	<td class="dataTableContent" onclick="window.open('<?php echo html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;oID=' . $oID . '&amp;jID=12&amp;action=edit', 'SSL'); ?>','_blank')"><?php echo $bill_primary_name; ?></td>
	<td class="dataTableContent" onclick="window.open('<?php echo html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;oID=' . $oID . '&amp;jID=12&amp;action=edit', 'SSL'); ?>','_blank')"><?php echo $shipper_code; ?></td>
	<td class="dataTableContent" onclick="window.open('<?php echo html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;oID=' . $oID . '&amp;jID=12&amp;action=edit', 'SSL'); ?>','_blank')"><?php echo (($shipped) ? TEXT_YES : ($temp[0] ? '' : ORD_NA)); ?></td>
	<td class="dataTableContent" align="right">
<?php
		if ($shipper_code <> '') {
			if ($shipped) {
				echo html_button_field('void_' . $oID, ORD_VOID_SHIP, 'onclick="voidShipment(' . $shipped . ', \'' . $shipper_code . '\')"') . chr(10);
	  			echo html_icon('phreebooks/stock_id.png', TEXT_VIEW_SHIP_LOG, 'small', 'onclick="loadPopUp(\'' . $shipper_code . '\', \'edit\', ' . $sID . ')"') . chr(10);
			} elseif (!$shipped) {
				echo html_button_field('ship_' . $oID, TEXT_SHIP, 'onclick="shipList(' . $oID . ', \'' . $shipper_code . '\')"') . chr(10);
			}
		}

	    // first pull in any extra buttons, this is dynamic since each row can have different buttons
	    if (function_exists('add_extra_action_bar_buttons')) echo add_extra_action_bar_buttons($query_result->fields);

	  	if (!$closed) echo html_icon('apps/accessories-calculator.png', TEXT_PAYMENT, 'small', 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, 'cat=banking&amp;module=bills&amp;type=c&amp;jID=18&amp;oID=' . $oID . '&amp;action=pmt', 'SSL') . '\';"') . chr(10);
	  	echo html_icon('actions/document-print.png', TEXT_PRINT, 'small', 'onclick="printOrder(' . $oID . ')"') . chr(10);
	    echo html_icon('actions/edit-find-replace.png', TEXT_EDIT, 'small', 'onclick="window.open(\'' . html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;oID=' . $oID . '&amp;jID=12&amp;action=edit', 'SSL') . '\',\'_blank\')"') . chr(10);
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