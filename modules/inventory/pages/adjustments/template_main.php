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
//  Path: /modules/inventory/pages/adjustments/template_main.php
//

// start the form
echo html_form('inv_adj', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);
$hidden_fields = NULL;

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);
echo html_hidden_field('id', $cInfo->id) . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['params']   = 'onclick="OpenAdjList()"';
$toolbar->icon_list['delete']['params'] = 'onclick="if (confirm(\'' . INV_ADJ_DELETE_ALERT . '\')) submitToDo(\'delete\')"';
$toolbar->icon_list['save']['params']   = 'onclick="submitToDo(\'save\')"';
$toolbar->icon_list['print']['show']    = false;
$toolbar->add_icon('new', 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL') . '\'"', $order = 2);
if ($security_level < 4) $toolbar->icon_list['delete']['show'] = false;
if ($security_level < 2) $toolbar->icon_list['save']['show']   = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
  foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('07.04.02.01');
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo INV_POPUP_ADJ_WINDOW_TITLE; ?></div>
<table align="center" border="0" cellspacing="1" cellpadding="1">
<?php if (ENABLE_MULTI_BRANCH) { ?>
  <tr>
	<td class="main"><?php echo GEN_STORE_ID . '&nbsp;'; ?></td>
    <td colspan="2" class="main"><?php echo html_pull_down_menu('store_id', gen_get_store_ids(), $cInfo->store_id ? $cInfo->store_id : $_SESSION['admin_prefs']['def_store_id']); ?></td>
  </tr>
<?php } else $hidden_fields .= html_hidden_field('store_id', $_SESSION['admin_prefs']['def_store_id']) . chr(10); ?>
  <tr>
	<td class="main"><?php echo TEXT_SKU . '&nbsp;'; ?> </td>
    <td class="main"><?php echo html_input_field('sku_1', $cInfo->sku_1, 'size="' . (MAX_INVENTORY_SKU_LENGTH + 1) . '" maxlength="' . MAX_INVENTORY_SKU_LENGTH . '"') . '&nbsp;';
	  echo html_icon('actions/system-search.png', TEXT_SEARCH, 'small', $params = 'align="top" style="cursor:pointer" onclick="InventoryList()"'); ?></td>
    <td align="right" class="main"><?php echo TEXT_POST_DATE . '&nbsp;'; ?>
	  <script type="text/javascript">dateReference.writeControl(); dateReference.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script></td>
  </tr>
  <tr id="serial_row" style="display:none">
	<td class="main"><?php echo INV_HEADING_SERIAL_NUMBER; ?></td>
	<td class="main"><?php echo html_input_field('serial_1', $cInfo->serial_1, 'size="25" maxlength="24"'); ?></td>
  </tr>
  <tr>
    <td class="main"><?php echo TEXT_REFERENCE; ?></td>
	<td colspan="2" class="main"><?php echo html_input_field('purchase_invoice_id', $cInfo->purchase_invoice_id); ?></td>
  </tr>
  <tr>
	<td colspan="3" class="main"><?php echo html_input_field('desc_1', $cInfo->desc_1, 'size="90"'); ?></td>
  </tr>
  <tr>
	<td class="main"><?php echo INV_ADJUSTMENT_ACCOUNT . '&nbsp;'; ?></td>
	<td colspan="2" class="main"><?php echo html_pull_down_menu('acct_1', $gl_array_list, $cInfo->acct_1, ''); ?></td>
  </tr>
  <tr>
	<td class="main"><?php echo INV_REASON_FOR_ADJUSTMENT; ?></td>
	<td colspan="2" class="main"><?php echo html_input_field('adj_reason', $cInfo->adj_reason, 'size="50"'); ?></td>
  </tr>
  <tr>
	<td class="main"><?php echo TEXT_UNIT_PRICE; ?></td>
	<td class="main">
		<?php echo html_input_field('price_1', $cInfo->price_1, 'size="11" maxlength="20" style="text-align:right"'); ?>
		<?php if (ENABLE_MULTI_CURRENCY) echo ' (' . DEFAULT_CURRENCY . ')'; ?>
	</td>
	<td id="unit_price_id" class="main">&nbsp;</td>
  </tr>
  <tr>
	<td class="main"><?php echo INV_QTY_ON_HAND; ?></td>
	<td colspan="2" class="main"><?php echo html_input_field('stock_1', $cInfo->stock_1, 'disabled="disabled" size="11" maxlength="10" style="text-align:right"'); ?></td>
  </tr>
  <tr>
	<td class="main"><?php echo INV_ADJ_QUANTITY; ?></td>
	<td colspan="2" class="main"><?php echo html_input_field('adj_qty', $cInfo->adj_qty, 'size="11" maxlength="10" style="text-align:right" onchange="updateBalance()"'); ?></td>
  </tr>
  <tr>
	<td class="main"><?php echo TEXT_BALANCE; ?></td>
	<td colspan="2" class="main"><?php echo html_input_field('balance', $cInfo->balance, 'readonly="readonly" size="11" maxlength="10" style="text-align:right"'); ?></td>
  </tr>
</table>
<?php echo $hidden_fields; ?>
</form>
