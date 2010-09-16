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
//  Path: /modules/banking/pages/popup_bills/template_main.php
//

// start the form
echo html_form('popup_bills', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

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
switch (JOURNAL_ID) {
  case 18: $toolbar->add_help('07.05.02'); break;
  case 20: $toolbar->add_help('07.05.01'); break;
}
if ($search_text) $toolbar->search_text = $search_text;
$toolbar->search_period = $acct_period;
echo $toolbar->build_toolbar($add_search = true, $add_period = true); 

// Build the page
?>
<div class="pageHeading"><?php echo GEN_HEADING_PLEASE_SELECT; ?></div>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER . (JOURNAL_ID == 18 ? TEXT_RECEIPTS : TEXT_PAYMENTS)); ?></div>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr class="dataTableHeadingRow" valign="top"><?php echo $list_header; ?></tr>
<?php
	// build the javascript constructor for creating each address object
	while (!$query_result->EOF) {
?>
  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick='setReturnEntry(<?php echo $query_result->fields['id']; ?>)'>
	<td class="dataTableContent"><?php echo gen_spiffycal_db_date_short($query_result->fields['post_date']); ?></td>
	<td class="dataTableContent"><?php echo $query_result->fields['purchase_invoice_id']; ?></td>
	<td class="dataTableContent"><?php echo $currencies->format($query_result->fields['total_amount']); ?></td>
	<td class="dataTableContent"><?php echo $query_result->fields['bill_primary_name']; ?></td>
  </tr>
<?php
	  $query_result->MoveNext();
	}
?>
</table>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER . (JOURNAL_ID == 18 ? TEXT_RECEIPTS : TEXT_PAYMENTS)); ?></div>
</form>
