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
//  Path: /modules/inventory/pages/popup_price_mgr/template_main.php
//

// start the form
echo html_form('price_mgr', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '')   . chr(10);
echo html_hidden_field('rowSeq', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="self.close()"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['params']   = 'onclick="submitToDo(\'save\')"';
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['print']['show']    = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('07.04.06');
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo INV_POPUP_PRICE_MGR_WINDOW_TITLE; ?></div>
<table border="0" cellspacing="2" cellpadding="2">
	<tr>
		<td nowrap="nowrap" class="main"><?php echo TEXT_SKU . ': '; ?></td>
		<td nowrap="nowrap" class="main"><?php echo $inventory_details->fields['sku']; ?></td>
		<td nowrap="nowrap" width="10%" class="main">&nbsp;</td>
		<td nowrap="nowrap" class="main"><?php echo INV_ENTRY_INVENTORY_DESC_SHORT . ': '; ?></td>
		<td nowrap="nowrap" class="main"><?php echo $inventory_details->fields['description_short']; ?></td>
	</tr>
	<tr>
		<td nowrap="nowrap" class="main"><?php echo INV_QTY_ON_HAND . ': '; ?></td>
		<td nowrap="nowrap" class="main"><?php echo $inventory_details->fields['quantity_on_hand']; ?></td>
		<td nowrap="nowrap" class="main">&nbsp;</td>
		<td nowrap="nowrap" class="main">&nbsp;</td>
		<td nowrap="nowrap" class="main">&nbsp;</td>
	</tr>
	<tr>
		<td nowrap="nowrap" class="main"><?php echo INV_QTY_ON_ORDER . ': '; ?></td>
		<td nowrap="nowrap" class="main"><?php echo $inventory_details->fields['quantity_on_order']; ?></td>
		<td nowrap="nowrap" class="main">&nbsp;</td>
		<td nowrap="nowrap" class="main"><?php echo INV_ENTRY_INV_ITEM_COST . ': '; ?></td>
		<td nowrap="nowrap" class="main"><?php echo $currencies->precise($item_cost); ?></td>
	</tr>
	<tr>
		<td nowrap="nowrap" class="main"><?php echo INV_QTY_ON_SALES_ORDER . ': '; ?></td>
		<td nowrap="nowrap" class="main"><?php echo $inventory_details->fields['quantity_on_sales_order']; ?></td>
		<td nowrap="nowrap" class="main">&nbsp;</td>
		<td nowrap="nowrap" class="main"><?php echo INV_ENTRY_FULL_PRICE . ': '; ?></td>
		<td nowrap="nowrap" class="main"><?php echo $currencies->precise($full_price); ?></td>
	</tr>
</table>

<?php
if ($price_sheets->RecordCount() > 0) {
	if (ENABLE_MULTI_CURRENCY) echo '<p class="fieldRequired"> ' . sprintf(GEN_PRICE_SHEET_CURRENCY_NOTE, $currencies->currencies[DEFAULT_CURRENCY]['title']) . '</p>';
	echo '<ul class="tabset_tabs">' . chr(10);
	$j=1;
	while (!$price_sheets->EOF) {
		echo '<li><a href="#tab_' . $price_sheets->fields['id'] . '"' . ($j==1 ? ' class="active"' : '') . '>' . $price_sheets->fields['sheet_name'] . ' (Rev. ' . $price_sheets->fields['revision'] . ')</a></li>' . chr(10);
		$price_sheets->MoveNext();
		$j++;
	}
	$price_sheets->Move(0);
	$price_sheets->MoveNext();
	echo '</ul>' . chr(10);

	$m = 1;
	while (!$price_sheets->EOF) { ?>
		<!-- start the tabsets -->
		<div id="<?php echo 'tab_' . $price_sheets->fields['id'];?>" class="tabset_content">
		  <h2 class="tabset_label"><?php echo $price_sheets->fields['sheet_name']; ?></h2>
<?php
			$checked = isset($special_prices[$price_sheets->fields['id']]) ? false : true;
			echo html_checkbox_field('def_' . $m, '1', $checked, '', $parameters = '') . '&nbsp;' . TEXT_USE_DEFAULT_PRICE_SHEET . '<br />';
			echo html_hidden_field('id_' . $m, $price_sheets->fields['id']);
?>
			<table width="90%"  border="1" cellspacing="1" cellpadding="1">
			  <tr>
				<td align="center"><?php echo TEXT_LEVEL; ?></td>
				<td align="center"><?php echo TEXT_QUANTITY; ?></td>
				<td align="center"><?php echo TEXT_SOURCE; ?></td>
				<td align="center"><?php echo TEXT_ADJUSTMENT; ?></td>
				<td align="center"><?php echo INV_ADJ_VALUE; ?></td>
				<td align="center"><?php echo INV_ROUNDING; ?></td>
				<td align="center"><?php echo INV_RND_VALUE; ?></td>
				<td align="center"><?php echo TEXT_PRICE; ?></td>
			  </tr>
<?php
			$levels = isset($special_prices[$price_sheets->fields['id']]) ? $special_prices[$price_sheets->fields['id']] : $price_sheets->fields['default_levels'];
			$price_levels = explode(';', $levels);
			// remove the first and last element from the price level source array (not used and Level 1 price source)
			$first_source_list = $price_mgr_sources;
			array_shift($first_source_list);
			array_pop($first_source_list);
			for ($i=0, $j=1; $i < MAX_NUM_PRICE_LEVELS; $i++, $j++) {
				$objID = $m . '_' . $j;
				$level_info = explode(':', $price_levels[$i]);
				$price = $level_info[0] ? $level_info[0] : (($i == 0) ? $full_price : 0);
				$qty = $level_info[1] ? $level_info[1] : $j;
				$src = $level_info[2] ? $level_info[2] : 0;
				$adj = $level_info[3] ? $level_info[3] : 0;
				$adj_val = $level_info[4] ? $level_info[4] : '0';
				$rnd = $level_info[5] ? $level_info[5] : 0;
				$rnd_val = $level_info[6] ? $level_info[6] : '0';
		
				echo '<tr>';
				echo '<td align="center">' . $j . '</td>';
				echo '<td>' . html_input_field('qty_'     . $objID, $qty, 'size="5" style="text-align:right" onchange="updatePrice(' . $m . ')"') . '</td>';
				echo '<td>' . html_pull_down_menu('src_'  . $objID, gen_build_pull_down(($i==0) ? $first_source_list : $price_mgr_sources), $src, 'onchange="updatePrice(' . $m . ')"') . '</td>';
				echo '<td>' . html_pull_down_menu('adj_'  . $objID, gen_build_pull_down($price_mgr_adjustments), $adj, 'onchange="updatePrice(' . $m . ')"') . '</td>';
				echo '<td>' . html_input_field('adj_val_' . $objID, $currencies->format($adj_val), 'size="10" style="text-align:right" onchange="updatePrice(' . $m . ')"') . '</td>';
				echo '<td>' . html_pull_down_menu('rnd_'  . $objID, gen_build_pull_down($price_mgr_rounding), $rnd, 'onchange="updatePrice(' . $m . ')"') . '</td>';
				echo '<td>' . html_input_field('rnd_val_' . $objID, $currencies->precise($rnd_val), 'size="10" style="text-align:right" onchange="updatePrice(' . $m . ')"') . '</td>';
				echo '<td>' . html_input_field('price_'   . $objID, $currencies->precise($price), 'size="11"style="text-align:right" onchange="updatePrice(' . $m . ')"') . '</td>';
				echo '</tr>';
			}
?>
			</table>
		</div>
		<!-- end of tabsets -->
	<?php $price_sheets->MoveNext();
		$m++;
	} 
} else {
	echo '<p><div align="center"><h3>' . INV_NO_PRICE_SHEETS . '</h3></div></p>';
} // end ($price_sheets->RecordCount() > 0) 
?>
</form>
