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
//  Path: /modules/banking/pages/bulk_bills/template_main.php
//

// start the form
echo html_form('bulk_bills', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['print']['params']  = 'onclick="submitToDo(\'print\')"';
if ($security_level < 2) $toolbar->icon_list['print']['show'] = false;
$toolbar->add_icon('ship_all', 'onclick="checkShipAll()"', 20);
$toolbar->icon_list['ship_all']['text'] = BNK_TEXT_CHECK_ALL;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('07.05.01');
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo constant('BNK_' . JOURNAL_ID . '_V_WINDOW_TITLE'); ?></div>
<div>
  <table align="center" border="0" cellspacing="4" cellpadding="0">
	<tr>
	  <td width="45%" align="right" valign="top">
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td class="main" align="right"><?php echo BNK_CHECK_DATE . '&nbsp;'; ?></td>
			<td class="main" align="right"><script type="text/javascript">datePosted.writeControl(); datePosted.displayLeft=true; datePosted.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script></td>
		  </tr>
		  <tr>
			<td class="main" align="right"><?php echo BNK_TEXT_FIRST_CHECK_NUM . '&nbsp;'; ?></td>
			<td class="main" align="right"><?php echo html_input_field('purchase_invoice_id', $purchase_invoice_id, 'style="text-align:right"'); ?></td>
		  </tr>
		  <tr>
			<td class="main" align="right"><?php echo TEXT_REFERENCE . '&nbsp;'; ?></td>
			<td class="main" align="right"><?php echo html_input_field('purch_order_id', $purch_order_id, ''); ?></td>
		  </tr>
		</table>
	  </td>
	  <td width="10%">&nbsp;</td>
	  <td width="45%" valign="top">
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td class="main" align="right"><?php echo BNK_CASH_ACCOUNT . '&nbsp;'; ?></td>
			<td class="main" align="right"><?php echo html_pull_down_menu('gl_acct_id', $gl_array_list, $gl_acct_id, 'onchange="loadNewBalance()"'); ?></td>
		  </tr>
		  <tr>
			<td class="main" align="right"><?php echo BNK_DISCOUNT_ACCOUNT . '&nbsp;'; ?></td>
			<td class="main" align="right"><?php echo html_pull_down_menu('gl_disc_acct_id', $gl_array_list, $gl_disc_acct_id, ''); ?></td>
		  </tr>
		</table>
	  </td>
	</tr>
	<tr>
	  <td colspan="3"><hr /></td>
	</tr>
	<tr>
	  <td class="main" align="right" valign="top">
	    <?php echo BNK_INVOICES_DUE_BY . '&nbsp;'; ?>
	    <script type="text/javascript">dateInvoice.writeControl(); dateInvoice.displayLeft=true; dateInvoice.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script>
	    <?php echo '<br />' . BNK_DISCOUNT_LOST_BY . '&nbsp;'; ?>
	    <script type="text/javascript">dateDiscount.writeControl(); dateDiscount.displayLeft=true; dateDiscount.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script>
	  </td>
	  <td class="main" align="center">
		<?php echo '&nbsp;' . html_icon('actions/system-search.png', TEXT_SEARCH, 'large', 'style="cursor:pointer;" onclick="submitToDo(\'search\')"'); ?>
	  </td>
	  <td align="right" valign="top">
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td class="main" align="right"><?php echo BNK_ACCOUNT_BALANCE . '&nbsp;'; ?></td>
			<td class="main" align="right">
			  <?php echo html_input_field('acct_balance', $currencies->format($acct_balance), 'readonly="readonly" size="15" maxlength="20" style="text-align:right"'); ?>
			  <?php echo (ENABLE_MULTI_CURRENCY) ? ' (' . DEFAULT_CURRENCY . ')' : '' ; ?>
			  </td>
		  </tr>
		  <tr>
			<td class="main" align="right"><?php echo BNK_TOTAL_TO_BE_PAID . '&nbsp;'; ?></td>
			<td class="main" align="right">
			  <?php echo html_input_field('total', $currencies->format(0), 'readonly="readonly" size="15" maxlength="20" style="text-align:right"'); ?>
			  <?php echo (ENABLE_MULTI_CURRENCY) ? ' (' . DEFAULT_CURRENCY . ')' : '' ; ?>
			</td>
		  </tr>
		  <tr>
			<td class="main" align="right"><?php echo BNK_BALANCE_AFTER_CHECKS . '&nbsp;'; ?></td>
			<td class="main" align="right">
			  <?php echo html_input_field('end_balance', $currencies->format($acct_balance), 'readonly="readonly" size="15" maxlength="20" style="text-align:right"'); ?>
			  <?php echo (ENABLE_MULTI_CURRENCY) ? ' (' . DEFAULT_CURRENCY . ')' : '' ; ?>
			</td>
		  </tr>
		</table>
	  </td>
	</tr>
  </table>
</div>

<div>
  <table id="item_table" align="center" border="0" cellpadding="1" cellspacing="0">
<?php if (ENABLE_MULTI_CURRENCY) echo '<tr><td colspan="9" class="fieldRequired"> ' . sprintf(GEN_PRICE_SHEET_CURRENCY_NOTE, $currencies->currencies[DEFAULT_CURRENCY]['title']) . '</td></tr>'; ?>
  <tr class="dataTableHeadingRow" valign="top"><?php echo $list_header; ?></tr>
<?php
	// build the javascript constructor for creating each address object
	$idx = 1;
	while (!$query_result->EOF) {
	  $due_dates = calculate_terms_due_dates($query_result->fields['post_date'], $query_result->fields['terms'], 'AP');
	  if ($due_dates['net_date'] > $invoice_date && $due_dates['early_date'] > $discount_date) {
	    $query_result->MoveNext();
		continue; // skip if not within selected discount window
	  }
	  if ($invoice_date < $due_dates['net_date']) {
	    if ($discount_date < $due_dates['early_date']) {
	      $query_result->MoveNext();
		  continue; // skip if not within selected discount window
		}
	  }
	  $already_paid = fetch_partially_paid($query_result->fields['id']);
	  $amount_due = $query_result->fields['total_amount'] - $already_paid;
	  if ($query_result->fields['journal_id'] == 7) $amount_due = -$amount_due; // vendor credit memos
	  $discount = $currencies->format(($query_result->fields['total_amount'] - $already_paid) * $due_dates['discount']);
	  if ($post_date > $due_dates['early_date']) $discount = 0; // past the early date
	  $extra_params = $query_result->fields['waiting'] == '1' ? 'readonly="readonly" ' : '';
	  echo '<tr' . (($extra_params) ? ' class="rowInactive"' : '') . '>' . chr(10);
	  echo '<td class="dataTableContent" align="center">' . chr(10);
	  echo gen_spiffycal_db_date_short($query_result->fields['post_date']) . chr(10);
	  // Hidden fields
	  echo html_hidden_field('id_' . $idx,           $query_result->fields['id']) . chr(10);
	  echo html_hidden_field('bill_acct_id_' . $idx, $query_result->fields['bill_acct_id']) . chr(10);
	  echo html_hidden_field('amt_' . $idx,          $amount_due) . chr(10);
	  echo html_hidden_field('inv_' . $idx,          $query_result->fields['purchase_invoice_id']) . chr(10);
	  echo html_hidden_field('origdisc_' . $idx,     $currencies->clean_value($discount)) . chr(10);
	  echo html_hidden_field('discdate_' . $idx,     gen_spiffycal_db_date_short($due_dates['early_date'])) . chr(10);
	  echo html_hidden_field('acct_' . $idx,         $query_result->fields['gl_acct_id']) . chr(10);
	  // End hidden fields
	  echo '</td>' . chr(10);
	  echo '<td class="main">' . htmlspecialchars($query_result->fields['bill_primary_name']) . '</td>' . chr(10);
	  echo '<td class="main" align="center">' . $query_result->fields['purchase_invoice_id'] . '</td>' . chr(10);
	  echo '<td class="main" align="center" style="text-align:right">' . $currencies->format($amount_due) . '</td>' . chr(10);
	  echo '<td class="main" align="center">' . html_input_field('desc_' . $idx, $query_result->fields['purch_order_id'], $extra_params . 'size="32"') . '</td>' . chr(10);
	  echo '<td class="main" align="center">' . gen_spiffycal_db_date_short($due_dates['net_date']) . '</td>' . chr(10);
	  echo '<td class="main" align="center">' . html_input_field('dscnt_' . $idx, $discount, $extra_params . 'size="11" maxlength="20" onchange="updateDiscTotal(' . $idx . ')" style="text-align:right"') . '</td>' . chr(10);
	  echo '<td class="main" align="center">' . html_input_field('total_' . $idx, '', $extra_params . 'size="11" maxlength="20" onchange="updateLineTotal(' . $idx . ')" style="text-align:right"') . '</td>' . chr(10);
	  echo '<td class="main" align="center">' . html_checkbox_field('pay_' . $idx, '1', false, '', ($extra_params ? 'disabled="disabled" ' : '') . 'onclick="updatePayValues(' . $idx . ')"') . '</td>' . chr(10);
	  echo '</tr>' . chr(10);
	  $idx++;
	  $query_result->MoveNext();
	}
?>
  </table>
</div>
</form>