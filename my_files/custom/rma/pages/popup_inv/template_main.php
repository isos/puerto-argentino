<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2009 PhreeSoft, LLC                               |
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
//  Path: /my_files/custom/rma/pages/popup_inv/template_main.php
//

// start the form
echo html_form('search_form', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);
echo html_hidden_field('rowSeq', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="self.close()"';
$toolbar->icon_list['open']['show'] = false;
$toolbar->icon_list['save']['show'] = false;
$toolbar->icon_list['delete']['show'] = false;
$toolbar->icon_list['print']['show'] = false;

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
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr class="dataTableHeadingRow"><?php  echo $list_header; ?></tr>
<?php
	$java_string = 'var assy_list = new Array(' . $query_result->RecordCount() . ');' . chr(10);

	$pointer = 0;
	while (!$query_result->EOF) {
	  $sku = $query_result->fields['sku'];
	  $inactive = $query_result->fields['inactive'];
	  $weight = $query_result->fields['item_weight'];
	  $stock = $query_result->fields['quantity_on_hand'];
	  // set the quantity on hand to big for non-cogs type items
	  $display_stock = true;
	  if (!in_array($query_result->fields['inventory_type'], $inv_cogs_calculated_types)) {
		$display_stock = false;
		$return_stock = 'NA';
	  } elseif (ENABLE_MULTI_BRANCH) {
	  	$store_stock = load_store_stock($sku, $store_id);
		$return_stock = $store_stock;
	  } else {
		$return_stock = $stock;
	  }
	  $on_order = $query_result->fields['quantity_on_order'];
	  $taxable = $query_result->fields['item_taxable'];
	  $lead_time = $query_result->fields['lead_time'];
	  $acct_cogs = $query_result->fields['account_cost_of_sales'];
	  switch ($account_type) {
		default:
		case 'c':
			$price = $query_result->fields['full_price'];
			$acct = $query_result->fields['account_sales_income'];
			$desc = addslashes($query_result->fields['description_short']);
			break;
		case 'v': // purchases and purchase orders
			$price = $query_result->fields['item_cost'];
			$acct = $query_result->fields['account_inventory_wage'];
			$desc = addslashes($query_result->fields['description_purchase']);
			break;
	  }
?>
  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" 
  onclick='setReturnItem(<?php echo $pointer . ', ' .  $rowID . ', "' .  $form_name . '", "' .  $sku . '", "' . $desc . '", "' . $price . '", "' . $acct . '", "' . $weight . '", "' . $return_stock . '", ' . $taxable . ', ' . $lead_time . ', "' . $acct_cogs . '", "' . $inactive . '"'; ?>)'>
	<td class="dataTableContent"><?php echo $sku; ?></td>
	<td class="dataTableContent"><?php echo $query_result->fields['description_short']; ?></td>
	<td class="dataTableContent"><?php echo ($display_stock) ? $stock : '&nbsp;'; ?></td>
	<td class="dataTableContent"><?php echo ($display_stock) ? $on_order : '&nbsp;'; ?></td>
	<?php if (ENABLE_MULTI_BRANCH) echo '<td class="dataTableContent">' . ($display_stock ? $store_stock : '&nbsp;') . '</td>'; ?>
  </tr>
<?php
	  if ($query_result->fields['inventory_type'] == 'as') $java_string .= build_assy_list($pointer, $sku, 0, $store_id);
	  $pointer++;
	  $query_result->MoveNext();
	}
?>
</table>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ITEMS); ?></div>
</form>

<script type="text/javascript">
<!--
<?php echo $java_string; ?>
// -->
</script>

<?php 
  if (($query_result->RecordCount() == 1) && ($_GET['page'] == 1)) { // then only one item return with it
//  	echo '<script type="text/javascript">';
//	echo 'setReturnItem(' . ($pointer - 1) . ', ' .  $rowID . ', "' .  $form_name . '", "' .  $sku . '", "' . $desc . '", "' . $price . '", "' . $acct . '", "' . $weight . '", "' . $stock . '", ' . $taxable . ', ' . $lead_time . ', "' . $acct_cogs . '", "' . $inactive . '");';
//	echo '</' . 'script>';
  }
?>