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
//  Path: /modules/inventory/pages/popup_adj/template_main.php
//

// start the form
echo html_form('search_form', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

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
$toolbar->add_help('07.04.02');
if ($search_text) $toolbar->search_text = $search_text;
$toolbar->search_period = $acct_period;
echo $toolbar->build_toolbar($add_search = true, $add_period = true); 

// Build the page
?>
<div class="pageHeading"><?php echo GEN_HEADING_PLEASE_SELECT; ?></div>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER . BOX_INV_ADJUSTMENTS); ?></div>
<table border="0" width="100%" cellspacing="0" cellpadding="1">
  <tr class="dataTableHeadingRow"><?php  echo $list_header; ?></tr>
<?php 
	while (!$query_result->EOF) { 
	  if ($query_result->fields['store_id'] == '0') {
	    $store_name = COMPANY_ID;
	  } else {
	    $result = $db->Execute("select short_name from " . TABLE_CONTACTS . " where id = '" . $query_result->fields['store_id'] . "'");
        $store_name = $result->fields['short_name'];
	  }
?>
  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick='setReturnEntry(<?php echo $query_result->fields['id']; ?>)'>
	<td class="dataTableContent"><?php echo gen_date_short($query_result->fields['post_date']); ?></td>
	<td class="dataTableContent"><?php echo $query_result->fields['purchase_invoice_id']; ?></td>
	<td class="dataTableContent"><?php echo $query_result->fields['qty']; ?></td>
	<td class="dataTableContent"><?php echo $query_result->fields['sku']; ?></td>
	<td class="dataTableContent"><?php echo $query_result->fields['description']; ?></td>
	<?php if (ENABLE_MULTI_BRANCH) echo '<td class="dataTableContent" align="center">' . $store_name . '</td>' . chr(10); ?>
  </tr>
<?php
	  $query_result->MoveNext();
	}
?>
</table>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER . BOX_INV_ADJUSTMENTS); ?></div>
</form>
