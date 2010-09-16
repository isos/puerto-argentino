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
//  Path: /modules/inventory/pages/main/template_tab_bom.php
//

// start the bill of materials tab html
?>
<div id="BOM" class="tabset_content">
  <h2 class="tabset_label"><?php echo INV_BOM; ?></h2>
  <table id="item_table" align="center" width="650" border="1" cellspacing="0" cellpadding="0">
	<tr>
	  <th class="main"><?php echo html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small'); ?></th>
	  <th class="main" align="center"><?php echo TEXT_SKU; ?></th>
	  <th class="main" align="center"><?php echo INV_ENTRY_INVENTORY_DESC_SHORT; ?></th>
	  <th class="main" align="center"><?php echo TEXT_QUANTITY; ?></th>
	</tr>
<?php
	$bom_list = build_bom_list($cInfo->id, $error);
	if (count($bom_list)) {
		for($j = 0, $i = 1; $j < count($bom_list); $j++, $i++) {
			echo '    <tr>';
			echo '      <td align="center">';
			if ($cInfo->last_journal_date == '0000-00-00 00:00:00') {
				echo html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . INV_MSG_DELETE_INV_ITEM . '\')) removeBOMRow(' . $i . ');"');
				$readonly = '';
			} else {
				echo '&nbsp;';
				$readonly = 'readonly="readonly" ';
			}
			echo '      </td>' . chr(10);
			echo '      <td class="main" align="center">';
			// Hidden fields
			echo '      <input type="hidden" name="id_' . $i . '" id="id_' . $i . '" value="' . $bom_list[$j]['id'] . '" />' . chr(10);
			// End hidden fields
			echo '<input type="text" name="assy_sku[]" id="sku_' . $i . '" value="' . $bom_list[$j]['sku'] . '" ' . $readonly . 'size="' . (MAX_INVENTORY_SKU_LENGTH + 1) . '" maxlength="' . MAX_INVENTORY_SKU_LENGTH . '" />&nbsp;' . chr(10);
			if ($cInfo->last_journal_date == '0000-00-00 00:00:00') echo html_icon('actions/system-search.png', TEXT_SKU, 'small', $params = 'align="top" style="cursor:pointer" onclick="InventoryList(' . $i . ')"') . chr(10);
			echo '      </td>' . chr(10);
			echo '      <td class="main"><input type="text" name="assy_desc[]" id="desc_' . $i . '" value="' . $bom_list[$j]['description'] . '" ' . $readonly . 'size="64" maxlength="64" /></td>' . chr(10);
			echo '      <td class="main"><input type="text" name="assy_qty[]" id="qty_' . $i . '" value="' . $bom_list[$j]['qty'] . '" ' . $readonly . 'size="6" maxlength="5" /></td>' . chr(10);
			echo '    </tr>';
		}
	} else {
		echo '<script language="JavaScript">addBOMRow();</script>';
	}
?>
  </table>
  <table align="center" width="650" border="0" cellspacing="0" cellpadding="0">
    <tr>
	  <td>
		<?php if ($cInfo->last_journal_date == '0000-00-00 00:00:00') { // show add button if no posting have been made
				echo html_icon('actions/list-add.png', TEXT_ADD, 'medium', 'onclick="addBOMRow()"');
			} else {
				echo '&nbsp;';
			} ?>
	  </td>
    </tr>
  </table>
</div>
