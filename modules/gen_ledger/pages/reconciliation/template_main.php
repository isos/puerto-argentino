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
//  Path: /modules/gen_ledger/pages/reconciliation/template_main.php
//

// start the form
echo html_form('reconciliation', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);
echo html_hidden_field('rowSeq', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show'] = false;
if ($security_level > 1) {
	$toolbar->icon_list['save']['params'] = 'onclick="submitToDo(\'save\')"';
} else {
	$toolbar->icon_list['save']['show'] = false;
}
$toolbar->icon_list['delete']['show'] = false;
$toolbar->icon_list['print']['show'] = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('07.05.04');
$toolbar->search_period = $period;
echo $toolbar->build_toolbar($add_search = false, $add_period = true); 

// Build the page
?>
<div class="pageHeading"><?php echo BANKING_HEADING_RECONCILIATION; ?></div>
<div align="center"><?php echo TEXT_CASH_ACCOUNT . '&nbsp;' . html_pull_down_menu('gl_account', $account_array, $gl_account, 'onchange="submit()";'); ?></div>
<table id="item_table" align="center" width="900" border="0" cellspacing="0" cellpadding="1">
<?php if (ENABLE_MULTI_CURRENCY) echo '<tr><td colspan="6" class="fieldRequired"> ' . sprintf(GEN_PRICE_SHEET_CURRENCY_NOTE, $currencies->currencies[DEFAULT_CURRENCY]['title']) . '</td></tr>'; ?>
  <tr class="dataTableHeadingRow" valign="top">
<?php
	$heading_array = array(
		'reference' => TEXT_REFERENCE,
		'post_date' => TEXT_DATE,
		'dep_amount' => BNK_DEPOSIT_CREDIT,
		'pmt_amount' => BNK_CHECK_PAYMENT);
	$result = html_heading_bar($heading_array, $_GET['list_order'], array(TEXT_DESCRIPTION, TEXT_CLEAR));
	echo $result['html_code'];
?>
  </tr>
	<?php $i = 0;
	if (is_array($combined_list)) foreach ($combined_list as $values) { ?>
		<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
			<td class="dataTableContent" id="td_<?php echo $i; ?>_0"><?php echo $values['reference']; ?></td>
			<td class="dataTableContent" id="td_<?php echo $i; ?>_1"><?php echo gen_spiffycal_db_date_short($values['post_date']); ?></td>
			<td class="dataTableContent" id="td_<?php echo $i; ?>_2" align="right"><?php echo $values['dep_amount'] ? $currencies->format($values['dep_amount']) : '&nbsp;'; ?></td>
			<td class="dataTableContent" id="td_<?php echo $i; ?>_3" align="right"><?php echo $values['pmt_amount'] ? $currencies->format($values['pmt_amount']) : '&nbsp;'; ?></td>
			<td class="dataTableContent" id="td_<?php echo $i; ?>_4"><?php echo $values['name']; ?></td>
			<td class="dataTableContent" id="td_<?php echo $i; ?>_5" align="center">
				<?php echo html_checkbox_field('id[' . $i . ']', '1', ($values['cleared'] == 1 ? true : false), '', 'onclick="updateBalance()"'); ?>
				<?php echo html_hidden_field('ref[' . $i . ']', $values['ref_id']); ?>
			</td>
		</tr>
		<?php $i++;
	} ?>
  <tr>
	<td colspan="5" align="right"><?php echo BNK_START_BALANCE . '&nbsp;'; ?></td>
	<td align="right"><?php echo html_input_field('start_balance', $statement_balance, 'style="text-align:right" size="13" onchange="updateBalance()"'); ?></td>
  </tr>
  <tr>
	<td colspan="5" align="right"><?php echo BNK_OPEN_CHECKS . '&nbsp;'; ?></td>
	<td align="right"><?php echo html_input_field('open_checks', '0', 'disabled="disabled" style="text-align:right" size="13"'); ?></td>
  </tr>
  <tr>
	<td colspan="5" align="right"><?php echo BNK_OPEN_DEPOSITS . '&nbsp;'; ?></td>
	<td align="right"><?php echo html_input_field('open_deposits', '0', 'disabled="disabled" style="text-align:right" size="13"'); ?></td>
  </tr>
  <tr>
	<td colspan="5" align="right"><?php echo BNK_GL_BALANCE . '&nbsp;'; ?></td>
	<td align="right"><?php echo html_input_field('gl_balance', $gl_balance, 'disabled="disabled" style="text-align:right" size="13"'); ?></td>
  </tr>
  <tr>
	<td colspan="5" align="right"><?php echo BNK_END_BALANCE . '&nbsp;'; ?></td>
	<td id="balance_total" align="right"><?php echo html_input_field('balance', '0', 'readonly="readonly" style="text-align:right" size="13"'); ?></td>
  </tr>
</table>
</form>