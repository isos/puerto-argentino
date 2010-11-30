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
//  Path: /modules/inventory/pages/main/template_tab_gen.php
//

// start the general tab html
?>
<div id="SYSTEM" class="tabset_content">
  <h2 class="tabset_label"><?php echo TEXT_GENERAL; ?></h2>
  <table border="0" cellspacing="0" cellpadding="0"><tr><td>
    <table border="0" cellspacing="1" cellpadding="1"><tr>
	  <td class="main"><?php echo TEXT_SKU; ?></td>
	  <td class="main">
		<?php echo html_input_field('sku', $cInfo->sku, 'readonly="readonly" size="' . (MAX_INVENTORY_SKU_LENGTH + 1) . '" maxlength="' . MAX_INVENTORY_SKU_LENGTH . '"', false); ?>
		<?php echo TEXT_INACTIVE; ?>
		<?php echo html_checkbox_field('inactive', '1', $cInfo->inactive); ?>
	  </td>
	  <td rowspan="4" class="main" align="center">
		<?php if ($cInfo->image_with_path) { // show image if it is defined
			echo html_image(DIR_WS_FULL_PATH . 'my_files/' . $_SESSION['company'] . '/inventory/images/' . $cInfo->image_with_path, $cInfo->image_with_path, '', '100', 'style="cursor:pointer" onclick="ImgPopup(\'' . DIR_WS_FULL_PATH . 'my_files/' . $_SESSION['company'] . '/inventory/images/' . $cInfo->image_with_path . '\')" LANGUAGE="javascript"');
		} else echo '&nbsp;'; ?>
	  </td>
	  <td class="main"><?php echo html_checkbox_field('remove_image', '1', $cInfo->remove_image) . ' ' . TEXT_REMOVE . ': ' . $cInfo->image_with_path . '<br />' . INV_ENTRY_SELECT_IMAGE; ?></td>
	</tr>
	<tr>
	  <td class="main"><?php echo INV_ENTRY_INVENTORY_DESC_SHORT; ?></td>
	  <td class="main">
	  	<?php echo html_input_field('description_short', $cInfo->description_short, 'size="33" maxlength="32"', false); ?>
		<?php if ($cInfo->id) echo '&nbsp;' . html_icon('categories/preferences-system.png', TEXT_WHERE_USED, 'small', 'onclick="ajaxWhereUsed()"') . chr(10); ?>
	  </td>
	  <td class="main"><?php echo html_file_field('inventory_image'); ?></td>
	</tr>
	<tr>
	  <td class="main"><?php echo INV_ENTRY_INVENTORY_TYPE; ?></td>
	  <td class="main"><?php echo html_hidden_field('inventory_type', $cInfo->inventory_type);
		echo html_input_field('inv_type_desc', $inventory_types_plus[$cInfo->inventory_type], 'readonly="readonly"', false); ?> </td>
	  <td class="main"><?php echo INV_ENTRY_IMAGE_PATH; ?></td>
	</tr>
	<tr>
	  <td class="main"><?php echo INV_HEADING_UPC_CODE; ?></td>
	  <td class="main"><?php echo html_input_field('upc_code', $cInfo->upc_code, 'size="16" maxlength="13" style="text-align:right"', false); ?></td>
	  <td class="main">
		<?php echo html_hidden_field('image_with_path', $cInfo->image_with_path); 
		echo html_input_field('inventory_path', substr($cInfo->image_with_path, 0, strrpos($cInfo->image_with_path, '/'))); ?>
	  </td>
	</tr>
	<tr>
	  <td class="main" valign="top"><?php echo INV_ENTRY_INVENTORY_DESC_PURCHASE; ?></td>
	  <td colspan="3" class="main"><?php echo html_textarea_field('description_purchase', 75, 2, $cInfo->description_purchase, '', $reinsert_value = true); ?></td>
	</tr>
	<tr>
	  <td class="main" valign="top"><?php echo INV_ENTRY_INVENTORY_DESC_SALES; ?></td>
	  <td colspan="3" class="main"><?php echo html_textarea_field('description_sales', 75, 2, $cInfo->description_sales, '', $reinsert_value = true); ?></td>
	</tr>
	<tr>
	  <td class="main"><?php echo INV_ENTRY_ACCT_SALES; ?></td>
	  <td class="main"><?php echo html_pull_down_menu('account_sales_income', $gl_array_list, $cInfo->account_sales_income); ?></td>
	  <td class="main" align="right"><?php echo INV_ENTRY_ITEM_WEIGHT; ?></td>
	  <td class="main"><?php echo html_input_field('item_weight', $cInfo->item_weight, 'size="11" maxlength="9" style="text-align:right"', false); ?></td>
	</tr>
	<tr>
	  <td class="main"><?php echo INV_ENTRY_ACCT_INV; ?></td>
	  <td class="main"><?php echo html_pull_down_menu('account_inventory_wage', $gl_array_list, $cInfo->account_inventory_wage); ?></td>
	  <td class="main" align="right"><?php echo INV_ENTRY_ITEM_MINIMUM_STOCK; ?></td>
	  <td class="main"><?php echo html_input_field('minimum_stock_level', $cInfo->minimum_stock_level, 'size="6" maxlength="5" style="text-align:right"', false); ?></td>
	</tr>
	<tr>
	  <td class="main"><?php echo INV_ENTRY_ACCT_COS; ?></td>
	  <td class="main"><?php echo html_pull_down_menu('account_cost_of_sales', $gl_array_list, $cInfo->account_cost_of_sales); ?></td>
	  <td class="main" align="right"><?php echo INV_ENTRY_ITEM_REORDER_QUANTITY; ?></td>
	  <td class="main"><?php echo html_input_field('reorder_quantity', $cInfo->reorder_quantity, 'size="6" maxlength="5" style="text-align:right"', false); ?></td>
	</tr>
	<tr>
	  <td class="main"><?php echo INV_ENTRY_ITEM_TAXABLE; ?></td>
	  <td class="main"><?php echo html_pull_down_menu('item_taxable', $tax_rates, $cInfo->item_taxable); ?></td>
	  <td class="main" align="right"><?php echo INV_HEADING_PREFERRED_VENDOR; ?></td>
	  <td class="main"><?php echo html_pull_down_menu('vendor_id', gen_get_account_array_by_type('v'), $cInfo->vendor_id); ?></td>
	</tr>
	<tr>
	  <td class="main"><?php echo INV_ENTRY_PURCH_TAX; ?></td>
	  <td class="main"><?php echo html_pull_down_menu('purch_taxable', $purch_tax_rates, $cInfo->purch_taxable); ?></td>
	  <td class="main" align="right"><?php echo INV_HEADING_LEAD_TIME; ?></td>
	  <td class="main"><?php echo html_input_field('lead_time', $cInfo->lead_time, 'size="6" maxlength="5" style="text-align:right"', false); ?></td>
	</tr>
	<tr>
	  <td class="main"><?php echo INV_ENTRY_INVENTORY_COST_METHOD; ?></td>
	  <td class="main">
		<?php foreach ($cost_methods as $key=>$value) $cost_pulldown_array[] = array('id' => $key, 'text' => $value); ?>
		<?php echo html_pull_down_menu('cost_method', $cost_pulldown_array, $cInfo->cost_method, (is_null($cInfo->last_journal_date) ? '' : 'disabled="disabled"')); ?>
	    <?php echo ' ' . INV_ENTRY_INVENTORY_SERIALIZE . ' ' . html_checkbox_field('serialize', '1', $cInfo->serialize, '', 'disabled="disabled"'); ?>
	  </td>
	  <td class="main" align="right">&nbsp;</td>
	  <td class="main">&nbsp;</td>
	</tr>
	<tr>
	  <td class="main"><?php echo TEXT_DEFAULT_PRICE_SHEET; ?></td>
	  <td class="main"><?php echo html_pull_down_menu('price_sheet', get_price_sheet_data(), $cInfo->price_sheet); ?></td>
	  <td class="main" align="right"><?php echo INV_QTY_ON_HAND; ?></td>
	  <td class="main"><?php echo html_input_field('quantity_on_hand', $cInfo->quantity_on_hand, 'disabled="disabled" size="6" maxlength="5" style="text-align:right"', false); ?></td>
	</tr>
	<tr>
	  <td class="main"><?php echo INV_ENTRY_INV_ITEM_COST; ?></td>
	  <td class="main">
	  	<?php echo html_input_field('item_cost', $currencies->precise($cInfo->item_cost), 'size="15" maxlength="20" style="text-align:right"', false); ?>
		<?php if (ENABLE_MULTI_CURRENCY) echo ' (' . DEFAULT_CURRENCY . ')'; ?>
		<?php if (($cInfo->inventory_type == 'as' || $cInfo->inventory_type == 'sa') && $cInfo->id) echo '&nbsp;' . html_icon('apps/accessories-calculator.png', TEXT_CURRENT_COST, 'small', 'onclick="ajaxAssyCost()"') . chr(10); ?>
	  </td>
	  <td class="main" align="right"><?php echo INV_QTY_ON_ORDER; ?></td>
	  <td class="main"><?php echo html_input_field('quantity_on_order', $cInfo->quantity_on_order, 'disabled="disabled" size="6" maxlength="5" style="text-align:right"', false); ?></td>
	</tr>
	<tr>
	  <td class="main"><?php echo INV_ENTRY_FULL_PRICE; ?></td>
	  <td class="main">
	  	<?php echo html_input_field('full_price', $currencies->precise($cInfo->full_price), 'size="15" maxlength="20" style="text-align:right"', false); 
			if (ENABLE_MULTI_CURRENCY) echo ' (' . DEFAULT_CURRENCY . ')'; 
		    echo '&nbsp;' . html_icon('status/mail-attachment.png', BOX_PRICE_SHEET_MANAGER, 'small', $params = 'onclick="priceMgr(' . $cInfo->id . ', ' . $currencies->clean_value($cInfo->item_cost) . ', ' . $currencies->clean_value($cInfo->full_price) . ')"') . chr(10); ?>
	  </td>
	  <td class="main" align="right"><?php echo INV_QTY_ON_SALES_ORDER; ?></td>
	  <td class="main"><?php echo html_input_field('quantity_on_sales_order', $cInfo->quantity_on_sales_order, 'disabled="disabled" size="6" maxlength="5" style="text-align:right"', false); ?></td>
	</tr>
	</table>
<?php if (ENABLE_MULTI_BRANCH) { ?>
  </td><td valign="top">
    <table border="1" cellspacing="1" cellpadding="1">
	  <tr>
	    <th><?php echo GEN_STORE_ID; ?></th>
	    <th><?php echo INV_HEADING_QTY_IN_STOCK; ?></th>
	  </tr>
	    <?php foreach ($store_stock as $stock) {
	  	  echo '<tr>' . chr(10);
		  echo '<td class="main">' . $stock['store'] . '</td>' . chr(10);
		  echo '<td class="main" align="center">' . $stock['qty'] . '</td>' . chr(10);
	      echo '</tr>' . chr(10);
		} ?>
    </table>
<?php } ?>
  </td></tr></table>
</div>
<script>



$(document).ready(function() {
		if ($("#price_sheet").val() != "") { 
			$("#full_price").css("text-decoration","line-through")
			$("#price_sheet").css("background-color","yellow"); 
		}
		});

</script>
