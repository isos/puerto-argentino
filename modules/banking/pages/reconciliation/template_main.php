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
//  Path: /modules/banking/pages/reconciliation/template_main.php
//

// start the form
echo html_form('reconciliation', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '')   . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params']   = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show']       = false;
if ($security_level > 1) {
	$toolbar->icon_list['save']['params'] = 'onclick="submitToDo(\'save\')"';
} else {
	$toolbar->icon_list['save']['show']   = false;
}
$toolbar->icon_list['delete']['show']     = false;
$toolbar->icon_list['print']['show']      = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('07.05.04');
$toolbar->search_period = $period;
$toolbar->period_strict = false; // hide the All option in period selection
echo $toolbar->build_toolbar($add_search = false, $add_period = true); 

// Build the page
?>
<div class="pageHeading"><?php echo BANKING_HEADING_RECONCILIATION; ?></div>
<div align="center"><?php echo TEXT_CASH_ACCOUNT . '&nbsp;' . html_pull_down_menu('gl_account', $account_array, $gl_account, 'onchange="submit();"'); ?></div>
<table id="item_table" align="center" width="900" border="0" cellspacing="0" cellpadding="1">
<?php if (ENABLE_MULTI_CURRENCY) echo '<tr><td colspan="6" class="fieldRequired"> ' . sprintf(GEN_PRICE_SHEET_CURRENCY_NOTE, $currencies->currencies[DEFAULT_CURRENCY]['title']) . '</td></tr>'; ?>
  <tr class="dataTableHeadingRow" valign="top">
<?php
	$heading_array = array(
		'reference'  => TEXT_REFERENCE,
		'post_date'  => TEXT_DATE,
		'dep_amount' => BNK_DEPOSIT_CREDIT,
		'pmt_amount' => BNK_CHECK_PAYMENT,
	);
	$result = html_heading_bar($heading_array, $_GET['list_order'], array(TEXT_SOURCE, TEXT_CLEAR, '&nbsp;'));
	echo $result['html_code'];
?>
  </tr>
	<?php $i = 0;
	if (is_array($combined_list)) foreach ($combined_list as $values) { 
		$bkgnd = ($values['partial']) ? ' style="background-color:yellow"' : '';
	?>
		<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
			<td width="16%" class="dataTableContent"><?php echo $values['reference']; ?></td>
			<td width="10%" class="dataTableContent"><?php echo gen_spiffycal_db_date_short($values['post_date']); ?></td>
			<td width="15%" class="dataTableContent" align="right"><?php echo $values['dep_amount'] ? $currencies->format($values['dep_amount']) : '&nbsp;'; ?></td>
			<td width="15%" class="dataTableContent" align="right"><?php echo $values['pmt_amount'] ? $currencies->format($values['pmt_amount']) : '&nbsp;'; ?></td>
			<td width="30%" class="dataTableContent"><?php echo htmlspecialchars($values['name']); ?></td>
			<td width="7%" class="dataTableContent" align="center">
				<?php if (sizeof($values['detail']) == 1) {
				  echo html_checkbox_field('chk[' . $i . ']', '1', ($values['cleared'] == 1 ? true : false), '', 'onclick="updateBalance()"') . chr(10);
				  echo html_hidden_field('id[' . $i . ']', $values['detail'][0]['id']) . chr(10); 
				  echo html_hidden_field('pmt_' . $i, $values['detail'][0]['payment']) . chr(10); 
				} else {
				  echo html_checkbox_field('sum_' . $i, '1', ($values['cleared'] == 1 ? true : false), '', 'onclick="updateSummary(' . $i . ')"') . chr(10);
				} ?>
			</td>
			<td id="disp_<?php echo $i; ?>" width="7%"<?php echo $bkgnd; ?> onclick="showDetails('<?php echo $i; ?>')"><?php echo (sizeof($values['detail']) > 1) ? TEXT_DETAILS : '&nbsp;'; ?></td>
		</tr>
<?php 
		if (sizeof($values['detail']) > 1) {
		  $j   = 0;
		  $ref = $i;
		  echo '<tr id="detail_' . $i . '" style="display:none"><td colspan="7"><table width="100%">' . chr(10);
		  foreach ($values['detail'] as $detail) { 
?>
		    <tr onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
			  <td width="16%" class="dataTableContent"><?php echo '&nbsp;'; ?></td>
			  <td width="10%" class="dataTableContent"><?php echo gen_spiffycal_db_date_short($detail['post_date']); ?></td>
			  <td width="15%" class="dataTableContent" align="right"><?php echo $detail['dep_amount'] ? $currencies->format($detail['dep_amount']) : '&nbsp;'; ?></td>
			  <td width="15%" class="dataTableContent" align="right"><?php echo $detail['pmt_amount'] ? $currencies->format($detail['pmt_amount']) : '&nbsp;'; ?></td>
			  <td width="30%" class="dataTableContent"><?php echo htmlspecialchars($detail['name']); ?></td>
			  <td width="7%" class="dataTableContent" align="center">
			    <?php echo html_checkbox_field('chk[' . $i . ']', '1', ($detail['cleared'] == 1 ? true : false), '', 'onclick="updateDetail(' . $ref . ')"') . chr(10); ?>
			    <?php echo html_hidden_field('id[' . $i . ']', $detail['id']) . chr(10); ?>
			    <?php echo html_hidden_field('pmt_' . $i, $detail['payment']) . chr(10); ?>
			  </td>
			  <td id="<?php echo 'disp_' . $ref . '_' . $j; ?>" width="7%"><?php echo '&nbsp;'; ?></td>
		    </tr>
<?php
			$i++;
			$j++;
		  }
		  echo '</table></td></tr>' . chr(10);
		} else {
		  $i++;
		}
	} 
?>
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