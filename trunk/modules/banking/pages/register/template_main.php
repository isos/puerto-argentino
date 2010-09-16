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
//  Path: /modules/banking/pages/register/template_main.php
//

// start the form
echo html_form('register', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['print']['show']    = false;

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
<div class="pageHeading"><?php echo BANKING_HEADING_REGISTER; ?></div>
<div align="center"><?php echo TEXT_CASH_ACCOUNT . '&nbsp;' . html_pull_down_menu('gl_account', $account_array, $gl_account, 'onchange="submit();"'); ?></div>
<table id="item_table" align="center" width="800" border="0" cellspacing="0" cellpadding="1">
<?php if (ENABLE_MULTI_CURRENCY) echo '<tr><td colspan="7" class="fieldRequired"> ' . sprintf(GEN_PRICE_SHEET_CURRENCY_NOTE, $currencies->currencies[DEFAULT_CURRENCY]['title']) . '</td></tr>'; ?>
  <tr class="dataTableHeadingRow" valign="top">
	<td class="dataTableHeadingContent"><?php echo TEXT_DATE; ?></td>
	<td class="dataTableHeadingContent"><?php echo TEXT_REFERENCE; ?></td>
	<td class="dataTableHeadingContent" align="center"><?php echo TEXT_TYPE; ?></td>
	<td class="dataTableHeadingContent"><?php echo TEXT_DESCRIPTION; ?></td>
	<td class="dataTableHeadingContent"><?php echo TEXT_DEPOSIT?></td>
	<td class="dataTableHeadingContent"><?php echo TEXT_PAYMENT; ?></td>
	<td class="dataTableHeadingContent"><?php echo TEXT_BALANCE; ?></td>
  </tr>
  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
	<td class="dataTableContent"><?php echo '&nbsp;'; ?></td>
	<td class="dataTableContent"><?php echo '&nbsp;'; ?></td>
	<td class="dataTableContent"><?php echo '&nbsp;'; ?></td>
	<td class="dataTableContent"><?php echo TEXT_BEGINNING_BALANCE; ?></td>
	<td class="dataTableContent"><?php echo '&nbsp;'; ?></td>
	<td class="dataTableContent"><?php echo '&nbsp;'; ?></td>
	<td class="dataTableContent" align="right"><?php echo $currencies->format($beginning_balance); ?></td>
  </tr>
  <?php $i = 0;
  if (is_array($bank_list)) foreach ($bank_list as $values) { 
	$beginning_balance += $values['dep_amount'] - $values['pmt_amount'];
  ?>
	<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
		<td class="dataTableContent" id="td_<?php echo $i; ?>_4"><?php echo gen_spiffycal_db_date_short($values['post_date']); ?></td>
		<td class="dataTableContent" id="td_<?php echo $i; ?>_1"><?php echo $values['reference']; ?></td>
		<td class="dataTableContent" id="td_<?php echo $i; ?>_2"><?php echo $values['pmt_amount'] ? BNK_TEXT_WITHDRAWAL : TEXT_DEPOSIT; ?></td>
		<td class="dataTableContent" id="td_<?php echo $i; ?>_5"><?php echo htmlspecialchars($values['name']); ?></td>
		<td class="dataTableContent" id="td_<?php echo $i; ?>_6" align="right"><?php echo $values['dep_amount'] ? $currencies->format($values['dep_amount']) : '&nbsp;'; ?></td>
		<td class="dataTableContent" id="td_<?php echo $i; ?>_3" align="right"><?php echo $values['pmt_amount'] ? $currencies->format($values['pmt_amount']) : '&nbsp;'; ?></td>
		<td class="dataTableContent" id="td_<?php echo $i; ?>_0" align="right"><?php echo $currencies->format($beginning_balance); ?></td>
	</tr>
	<?php $i++;
  } ?>
  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
	<td class="dataTableContent"><?php echo '&nbsp;'; ?></td>
	<td class="dataTableContent"><?php echo '&nbsp;'; ?></td>
	<td class="dataTableContent"><?php echo '&nbsp;'; ?></td>
	<td class="dataTableContent"><?php echo TEXT_ENDING_BALANCE; ?></td>
	<td class="dataTableContent"><?php echo '&nbsp;'; ?></td>
	<td class="dataTableContent"><?php echo '&nbsp;'; ?></td>
	<td class="dataTableContent" align="right"><?php echo $currencies->format($beginning_balance); ?></td>
  </tr>
</table>
</form>