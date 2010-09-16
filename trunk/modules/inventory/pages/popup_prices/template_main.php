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
//  Path: /modules/inventory/pages/popup_prices/template_main.php
//

// start the form
echo html_form('prices', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '')   . chr(10);
echo html_hidden_field('rowSeq', '') . chr(10);
if (!ENABLE_MULTI_CURRENCY) echo html_hidden_field('display_currency', DEFAULT_CURRENCY);

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
$toolbar->add_help('07.04.06');
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo INV_DEFINED_PRICES . $sku; ?></div>
<div style="float:right"><?php echo (ENABLE_MULTI_CURRENCY) ? (TEXT_CURRENCY . ' ' . html_input_field('display_currency', DEFAULT_CURRENCY, 'readonly="readonly" size="4"')) : ''; ?></div>
<table>
  <tr>
    <td><?php echo INV_ENTRY_INVENTORY_DESC_SHORT . ': '; ?></td>
    <td><?php echo $inventory_details->fields['description_short']; ?></td>
  </tr>
  <tr>
    <td><?php echo INV_ENTRY_INV_ITEM_COST . ': '; ?></td>
    <td><?php echo html_input_field('cost', $currencies->precise($inventory_details->fields['item_cost']), 'readonly="readonly" size="10" style="text-align:right"'); ?></td>
  </tr>
  <tr>
    <td><?php echo INV_ENTRY_ITEM_WEIGHT . ': '; ?></td>
    <td><?php echo $inventory_details->fields['item_weight']; ?></td>
  </tr>
</table>

<div class="dataTableHeadingRow"><?php echo INV_ENTRY_FULL_PRICE; ?></div>
<table border="0">
  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="setReturnPrice('<?php echo $rowId; ?>', 'full');">
    <td align="right" ><?php echo html_input_field('full', $currencies->precise($inventory_details->fields['full_price']), 'readonly="readonly" size="10" style="text-align:right"'); ?></td>
  </tr>
</table>
<?php
if (is_object($price_sheets)) {
  if ($price_sheets->RecordCount() > 0) {
    $cnt = 0;
	while (!$price_sheets->EOF) { 
		echo '<div class="dataTableHeadingRow">' . $price_sheets->fields['sheet_name'] . '</div>';
		echo '<table border="0"><tr><th align="center">' . TEXT_QUANTITY . '</th><th align="center">' . TEXT_PRICE . '</th></tr>';
		// remove the first and last element from the price level source array (not used and Level 1 price source)
		$first_source_list = $price_mgr_sources;
		array_shift($first_source_list);
		array_pop($first_source_list);
		// extract the pricing information
		$levels = isset($special_prices[$price_sheets->fields['id']]) ? $special_prices[$price_sheets->fields['id']] : $price_sheets->fields['default_levels'];
		$prices = inv_calculate_prices($inventory_details->fields['item_cost'], $inventory_details->fields['full_price'], $levels);
		foreach ($prices as $price_level) {
			echo '<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="setReturnPrice(\'' . $rowId . '\', \'price_' . $cnt . '\')">';
			echo '<td align="center">' . $price_level['qty'] . '</td>';
			echo '<td align="right">' . html_input_field('price_' . $cnt, $price_level['price'], 'readonly="readonly" size="10" style="text-align:right"') . '</td></tr>';
			$cnt++;
		}
        $price_sheets->MoveNext();
		echo '</table>';
	}
	echo html_hidden_field('num_prices', $cnt);
  } 
} else {
  echo '<div align="center"><h3>' . INV_NO_PRICE_SHEETS . '</h3></div>';
} // end if ($price_sheets->RecordCount() > 0) 
?>
</form>