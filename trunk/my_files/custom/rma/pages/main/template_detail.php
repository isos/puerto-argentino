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
//  Path: /modules/rma/pages/main/template_detail.php
//

// start the form
echo html_form('rma', FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'post');

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);
echo html_hidden_field('rowSeq', $cInfo->id) . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action', 'module')) . 'module=main', 'SSL') . '\'"';
$toolbar->icon_list['open']['show'] = false;
$toolbar->icon_list['delete']['show'] = false;
if ($security_level > 2) {
	$toolbar->icon_list['save']['params'] = 'onclick="submitToDo(\'save\')"';
} else {
	$toolbar->icon_list['save']['show'] = false;
}
$toolbar->icon_list['print']['show'] = false;
$toolbar->add_help('');
echo $toolbar->build_toolbar(); 
?>
<div class="pageHeading"><?php echo ($action == 'new') ? MENU_HEADING_NEW_RMA : (MENU_HEADING_RMA . ' - ' . TEXT_RMA_ID . '# ' . $cInfo->rma_num); ?></div>

<fieldset>
  <legend><?php echo TEXT_GENERAL; ?></legend>
  <table border="0" cellspacing="1" cellpadding="1">
	<tr>
	  <td class="main" align="right"><?php echo TEXT_RMA_ID . TEXT_ASSIGNED_BY_SYSTEM; ?></td>
	  <td class="main"><?php echo html_input_field('rma_num', $cInfo->rma_num, 'readonly'); ?> </td>
	  <td class="main" align="right"><?php echo TEXT_CALLER_NAME; ?></td>
	  <td class="main"><?php echo html_input_field('caller_name', $cInfo->caller_name, 'size="33" maxlength="32"', false); ?></td>
	  <td class="main" align="right"><?php echo TEXT_STATUS; ?></td>
	  <td class="main"><?php echo html_pull_down_menu('status', gen_build_pull_down($status_codes), $cInfo->status); ?></td>
	</tr>
	<tr>
	  <td class="main" align="right"><?php echo TEXT_PURCHASE_INVOICE_ID; ?></td>
	  <td class="main"><?php echo html_input_field('purchase_invoice_id', $cInfo->purchase_invoice_id); ?> </td>
	  <td class="main" align="right"><?php echo TEXT_CALLER_TELEPHONE1; ?></td>
	  <td class="main"><?php echo html_input_field('caller_telephone1', $cInfo->caller_telephone1, 'size="33" maxlength="32"'); ?></td>
	  <td class="main" align="right"><?php echo TEXT_CREATION_DATE; ?></td>
	  <td class="main"><script language="javascript">createDate.writeControl(); createDate.displayLeft=true; createDate.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script></td>
	</tr>
	<tr>
	  <td class="main" align="right"><?php echo TEXT_REASON_FOR_RETURN; ?></td>
	  <td class="main"><?php echo html_pull_down_menu('return_code', gen_build_pull_down($reason_codes), $cInfo->return_code); ?></td>
	  <td class="main" align="right"><?php echo TEXT_CALLER_EMAIL; ?></td>
	  <td class="main"><?php echo html_input_field('caller_email', $cInfo->caller_email, 'size="49" maxlength="48"'); ?></td>
	  <td class="main" align="right"><?php echo TEXT_CLOSED_DATE; ?></td>
	  <td class="main"><script language="javascript">closedDate.writeControl(); closedDate.displayLeft=true; closedDate.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script></td>
	</tr>
	<tr>
	  <td class="main" align="right" valign="top"><?php echo TEXT_CALLER_NOTES; ?></td>
	  <td colspan="3" class="main"><?php echo html_textarea_field('caller_notes', true, 60, 3, $cInfo->caller_notes, '', $reinsert_value = true); ?></td>
	  <td class="main" align="right" valign="top"><?php echo TEXT_ENTERED_BY; ?></td>
	  <td class="main" valign="top"><?php echo html_pull_down_menu('entered_by', gen_get_pull_down(TABLE_USERS, false, '1', 'admin_id', 'display_name'), ($cInfo->entered_by ? $cInfo->entered_by : $_SESSION['admin_id'])); ?></td>
	</tr>
  </table>
</fieldset>

<fieldset>
  <legend><?php echo TEXT_DETAILS; ?></legend>
  <table border="0" cellspacing="1" cellpadding="1">
	<tr>
	  <td class="main" align="right"><?php echo TEXT_RECEIVE_DATE; ?></td>
	  <td class="main"><script language="javascript">receiveDate.writeControl(); receiveDate.displayLeft=true; receiveDate.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script></td>
	  <td class="main" align="right" valign="top"><?php echo TEXT_RECEIVED_BY; ?></td>
	  <td class="main" valign="top"><?php echo html_pull_down_menu('received_by', gen_get_pull_down(TABLE_USERS, true, '1', 'admin_id', 'display_name'), ($cInfo->received_by ? $cInfo->received_by : '')); ?></td>
	</tr>
	<tr>
	  <td class="main" align="right"><?php echo TEXT_RECEIVE_CARRIER; ?></td>
	  <td class="main"><?php echo html_input_field('receive_carrier', $cInfo->receive_carrier); ?> </td>
	  <td class="main" align="right"><?php echo TEXT_RECEIVE_TRACKING_NUM; ?></td>
	  <td class="main"><?php echo html_input_field('receive_tracking', $cInfo->receive_tracking); ?> </td>
	</tr>
	<tr>
	  <td class="main" align="right" valign="top"><?php echo TEXT_RECEIVE_NOTES; ?></td>
	  <td colspan="3" class="main"><?php echo html_textarea_field('receive_notes', true, 60, 3, $cInfo->receive_notes, '', $reinsert_value = true); ?></td>
	</tr>
  </table>
  <table border="0" cellspacing="0" cellpadding="0"><tr>
	<td id="productList" class="formArea">
	  <table id="item_table" width="100%" border="1" cellpadding="1" cellspacing="1">
        <tr>
          <th class="dataTableHeadingContent" align="center"><?php echo html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small'); ?></th>
          <th class="dataTableHeadingContent" align="center"><?php echo TEXT_QUANTITY; ?></th>
          <th class="dataTableHeadingContent" align="center"><?php echo TEXT_SKU; ?></th>
          <th class="dataTableHeadingContent" align="center"><?php echo TEXT_NOTES; ?></th>
          <th class="dataTableHeadingContent" align="center"><?php echo TEXT_ACTION; ?></th>
        </tr>
<?php 
if ($cInfo->item_rows) {
	for ($j=0, $i=1; $j<count($cInfo->item_rows); $j++, $i++) { ?>
		<tr>
		  <td align="center"><?php echo html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . RMA_ROW_DELETE_ALERT . '\')) removeItemRow(' . $i . ');"'); ?></td>
		  <td class="main" align="center"><?php echo html_input_field('qty_' . $i, $cInfo->item_rows[$j]['qty'], 'size="7" maxlength="6" style="text-align:right"'); ?></td>
		  <td nowrap class="main" align="center"><?php echo html_input_field('sku_' . $i, $cInfo->item_rows[$j]['sku'], 'size="' . (MAX_INVENTORY_SKU_LENGTH + 1) . '" maxlength="' . MAX_INVENTORY_SKU_LENGTH . '" onfocus="clearField(\'sku_' . $i . '\', \'' . TEXT_SEARCH . '\')" onBlur="setField(\'sku_' . $i . '\', \'' . TEXT_SEARCH . '\')"'); ?>
		  <?php echo '&nbsp;' . html_icon('status/folder-open.png', TEXT_SEARCH, 'small', 'align="absmiddle" style="cursor:pointer" onclick="ItemList(' . $i . ')"'); ?>
		  <?php echo html_hidden_field('id_' . $i, $cInfo->item_rows[$j]['id']); ?>
		  </td>
		  <td class="main"><?php echo html_input_field('desc_' . $i, $cInfo->item_rows[$j]['desc'], 'size="64" maxlength="64"'); ?></td>
		  <td class="main"><?php echo html_pull_down_menu('actn_' . $i, gen_build_pull_down($action_codes), $cInfo->item_rows[$j]['actn']); ?></td>
		</tr>
<?php
	}
} else {
	echo '  <script language="javascript">addItemRow();</script>' . chr(10);
} ?>
      </table>
	</td>
  </tr>
  <tr>
    <td align="left"><?php echo html_icon('actions/list-add.png', TEXT_ADD, 'medium', 'onclick="addItemRow()"'); ?></td>
  </tr></table>
</fieldset>

</form>
