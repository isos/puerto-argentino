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
//  Path: /modules/gen_ledger/pages/beg_bal/template_main.php
//

// start the form
echo html_form('beg_bal', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, 'cat=gen_ledger&amp;module=utils', 'SSL') . '\'"';
$toolbar->icon_list['open']['show'] = false;
$toolbar->icon_list['save']['params'] = 'onclick="submitToDo(\'save\')"';
$toolbar->icon_list['delete']['show'] = false;
$toolbar->icon_list['print']['show'] = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('03.04.02');
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo GL_HEADING_BEGINNING_BALANCES; ?></div>
<?php if ($security_level > 1) {
  echo '<div align="center">' . html_button_field('bb_inv', GL_BTN_IMP_BEG_BALANCES, 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, 'cat=gen_ledger&amp;module=beg_bal_imp', 'SSL') . '\'"') . '</div>' . chr(10);
} ?>
<table id="item_table" align="center" border="1" cellspacing="1" cellpadding="1">
  <tr>
	<th><?php echo TEXT_GL_ACCOUNT; ?></th>
	<th><?php echo TEXT_DESCRIPTION; ?></th>
	<th><?php echo TEXT_ACCOUNT_TYPE; ?></th>
	<th nowrap="nowrap"><?php echo TEXT_DEBIT_AMOUNT; ?></th>
	<th nowrap="nowrap"><?php echo TEXT_CREDIT_AMOUNT; ?></th>
  </tr>
	<?php $i = 0;
	foreach ($glEntry->beg_bal as $coa_id => $values) { ?>
		<tr>
			<td class="main" align="center"><?php echo $coa_id; ?></td>
			<td class="main"><?php echo htmlspecialchars($values['desc']); ?></td>
			<td class="main"><?php echo $values['type_desc']; ?></td>
		<?php if ($coa_types[$values['type']]['asset']) { ?>
			<td class="main" align="center"><?php echo html_input_field('coa_value[' . $i . ']', (($values['beg_bal'] <> 0) ? strval($values['beg_bal']) : '0'), 'style="text-align:right" size="13" maxlength="12" onchange="updateBalance()"'); ?></td>
			<td class="main" align="center" bgcolor="#cccccc">&nbsp;</td>
		<?php } else { ?>
			<td class="main" align="center" bgcolor="#cccccc">&nbsp;</td>
			<td class="main" align="center"><?php echo html_input_field('coa_value[' . $i . ']', (($values['beg_bal'] <> 0) ? strval(-$values['beg_bal']) : '0'), 'style="text-align:right" size="13" maxlength="12" onchange="updateBalance()"'); ?></td>
		<?php } ?>
		</tr>
		<?php $i++;
	} ?>
  <tr>
	<td colspan="3" align="right"><?php echo TEXT_TOTAL; ?></td>
	<td align="right"><?php echo html_input_field('debit_total', '0', 'readonly="readonly" style="text-align:right" size="13"'); ?></td>
	<td align="right"><?php echo html_input_field('credit_total', '0', 'readonly="readonly" style="text-align:right" size="13"'); ?></td>
  </tr>
  <tr>
	<td colspan="4" align="right"><?php echo GL_OUT_OF_BALANCE; ?></td>
	<td align="right"><?php echo html_input_field('balance_total', '0', 'readonly="readonly" style="text-align:right" size="13"'); ?></td>
  </tr>
</table>
</form>