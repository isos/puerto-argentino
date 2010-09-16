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
//  Path: /modules/general/pages/search/template_main.php
//

// start the form
echo html_form('site_search', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['print']['show']    = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('');
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo HEADING_TITLE_SEARCH_INFORMATION; ?></div>
<?php if ($query_numrows > 0) { ?>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER . TEXT_RESULTS); ?></div>
<?php } ?>
<table border="0" align="center" cellspacing="1" cellpadding="1">
  <tr>
	<td colspan="4" align="right"><?php echo html_icon('actions/view-refresh.png', TEXT_RESET, 'large', 'style="cursor:pointer;" onclick="submitToDo(\'reset\')"');
    echo '&nbsp;' . html_icon('actions/system-search.png', TEXT_SEARCH, 'large', 'style="cursor:pointer;" onclick="submitToDo(\'search\')"'); ?></td>
  </tr>
  <tr>
    <td><?php echo TEXT_TRANSACTION_DATE; ?></td>
    <td><?php echo html_pull_down_menu('date_id', gen_build_pull_down($DateChoices), $_GET['date_id'], $params = ''); ?></td>
    <td><script type="text/javascript">dateFrom.writeControl(); dateFrom.displayLeft=true; dateFrom.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script></td>
    <td><script type="text/javascript">dateTo.writeControl(); dateTo.displayLeft=true; dateTo.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script></td>
  </tr>
  <tr>
    <td><?php echo TEXT_TRANSACTION_TYPE; ?></td>
    <td colspan="3"><?php echo html_pull_down_menu('journal_id', gen_build_pull_down($journal_choices), $_GET['journal_id']); ?></td>
  </tr>
  <tr>
    <th><?php echo TEXT_FILTER; ?></th>
    <th><?php echo TEXT_TYPE; ?></th>
    <th><?php echo TEXT_FROM; ?></th>
    <th><?php echo TEXT_TO; ?></th>
  </tr>
  <tr>
    <td><?php echo TEXT_REFERENCE_NUMBER; ?></td>
    <td><?php echo html_pull_down_menu('ref_id', gen_build_pull_down($choices), $_GET['ref_id'], $params = ''); ?></td>
    <td><?php echo html_input_field('ref_id_from', $_GET['ref_id_from'], $params = ''); ?></td>
    <td><?php echo html_input_field('ref_id_to', $_GET['ref_id_to'], $params = ''); ?></td>
  </tr>
  <tr>
    <td><?php echo TEXT_CUST_VEND_ACCT; ?></td>
    <td><?php echo html_pull_down_menu('account_id', gen_build_pull_down($choices), $_GET['account_id'], $params = ''); ?></td>
    <td><?php echo html_input_field('account_id_from', $_GET['account_id_from'], $params = ''); ?></td>
    <td><?php echo html_input_field('account_id_to', $_GET['account_id_to'], $params = ''); ?></td>
  </tr>
  <tr>
    <td><?php echo TEXT_INVENTORY_ITEM; ?></td>
    <td><?php echo html_pull_down_menu('sku_id', gen_build_pull_down($choices), $_GET['sku_id'], $params = ''); ?></td>
    <td><?php echo html_input_field('sku_id_from', $_GET['sku_id_from'], $params = ''); ?></td>
    <td><?php echo html_input_field('sku_id_to', $_GET['sku_id_to'], $params = ''); ?></td>
  </tr>
  <tr>
    <td><?php echo TEXT_TRANSACTION_AMOUNT; ?></td>
    <td><?php echo html_pull_down_menu('amount_id', gen_build_pull_down($choices), $_GET['amount_id'], $params = ''); ?></td>
    <td><?php echo html_input_field('amount_id_from', $_GET['amount_id_from'], $params = ''); ?></td>
    <td><?php echo html_input_field('amount_id_to', $_GET['amount_id_to'], $params = ''); ?></td>
  </tr>
  <tr>
    <td><?php echo TEXT_GENERAL_LEDGER_ACCOUNT; ?></td>
    <td><?php echo html_pull_down_menu('gl_acct_id', gen_build_pull_down($choices), $_GET['gl_acct_id'], $params = ''); ?></td>
    <td><?php echo html_pull_down_menu('gl_acct_id_from', $gl_array_list, $_GET['gl_acct_id_from']); ?></td>
    <td><?php echo html_pull_down_menu('gl_acct_id_to', $gl_array_list, $_GET['gl_acct_id_to']); ?></td>
  </tr>
  <tr>
    <td><?php echo TEXT_JOURNAL_RECORD_ID; ?></td>
    <td><?php echo html_pull_down_menu('main_id', gen_build_pull_down($choices), $_GET['main_id'], $params = ''); ?></td>
    <td><?php echo html_input_field('main_id_from', $_GET['main_id_from'], $params = ''); ?></td>
    <td><?php echo html_input_field('main_id_to', $_GET['main_id_to'], $params = ''); ?></td>
  </tr>
</table>
<table border="0" width="100%" cellspacing="0" cellpadding="1">
  <tr class="dataTableHeadingRow" valign="top"><?php echo $list_header; ?></tr>
	<?php
	while (!$query_result->EOF) {
	  $jID = (int)$query_result->fields['journal_id'];
	  switch ($jID) {
	    case  2: 
		  $security_level = $_SESSION['admin_security'][SECURITY_ID_JOURNAL_ENTRY]; 
		  $cat = 'gen_ledger'; 
		  $mod = 'journal'; 
		  break;
		case  3: 
		  $security_level = $_SESSION['admin_security'][SECURITY_ID_PURCHASE_QUOTE]; 
		  $cat = 'orders'; 
		  $mod = 'orders'; 
		  break;
		case  4: 
		  $security_level = $_SESSION['admin_security'][SECURITY_ID_PURCHASE_ORDER]; 
		  $cat = 'orders'; 
		  $mod = 'orders'; 
		  break;
		case  6: 
		  $security_level = $_SESSION['admin_security'][SECURITY_ID_PURCHASE_INVENTORY]; 
		  $cat = 'orders'; 
		  $mod = 'orders'; 
		  break;
		case  7: 
		  $security_level = $_SESSION['admin_security'][SECURITY_ID_PURCHASE_CREDIT]; 
		  $cat = 'orders'; 
		  $mod = 'orders'; 
		  break;
		case  9: 
		  $security_level = $_SESSION['admin_security'][SECURITY_ID_SALES_QUOTE]; 
		  $cat = 'orders'; 
		  $mod = 'orders'; 
		  break;
		case 10: 
		  $security_level = $_SESSION['admin_security'][SECURITY_ID_SALES_ORDER]; 
		  $cat = 'orders'; 
		  $mod = 'orders'; 
		  break;
		case 12: 
		  $security_level = $_SESSION['admin_security'][SECURITY_ID_SALES_INVOICE]; 
		  $cat = 'orders'; 
		  $mod = 'orders'; 
		  break;
		case 13: 
		  $security_level = $_SESSION['admin_security'][SECURITY_ID_SALES_CREDIT]; 
		  $cat = 'orders'; 
		  $mod = 'orders'; 
		  break;
	    case 14: 
		  $security_level = $_SESSION['admin_security'][SECURITY_ID_ASSEMBLE_INVENTORY]; 
		  $cat = 'inventory'; 
		  $mod = 'assemblies'; 
		  break;
	    case 16: 
		  $security_level = $_SESSION['admin_security'][SECURITY_ID_ADJUST_INVENTORY]; 
		  $cat = 'inventory'; 
		  $mod = 'adjustments'; 
		  break;
	    case 18:
		  $security_level = $_SESSION['admin_security'][SECURITY_ID_CUSTOMER_RECEIPTS]; 
		  $cat = 'banking'; 
		  $mod = 'bills'; 
		  $type = gen_get_account_type($query_result->fields['bill_acct_id']);
		  break;
//	    case 19: 
//		  $security_level = $_SESSION['admin_security'][SECURITY_ID_POINT_OF_SALE]; 
//		  $cat = 'orders'; $mod = 'orders'; 
//		  break;
	    case 20: 
		  $security_level = $_SESSION['admin_security'][SECURITY_ID_PAY_BILLS]; 
		  $cat = 'banking'; 
		  $mod = 'bills'; 
		  $type = gen_get_account_type($query_result->fields['bill_acct_id']);
		  break;
//	    case 21: 
//		  $security_level = $_SESSION['admin_security'][SECURITY_ID_WRITE_CHECKS]; 
//		  $cat = 'orders'; $mod = 'orders'; 
//		  break;
		default: 
		  $security_level = $_SESSION['admin_security'][SECURITY_ID_SEARCH]; 
		  $cat = 'orders'; 
		  $mod = 'orders'; 
		  break;
	  }
	  if ($security_level > 0) {
	  	$params = 'cat=' . $cat . '&amp;module=' . $mod . '&amp;oID=' . $query_result->fields['id'] . '&amp;jID=' . $jID . '&amp;action=edit';
		if ($type) $params .= '&amp;type=' . $type;
	?>
  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
	<td class="dataTableContent" onclick="window.open('<?php echo html_href_link(FILENAME_DEFAULT, $params, 'SSL'); ?>','_blank')"><?php echo $query_result->fields['id']; ?></td>
	<td class="dataTableContent" onclick="window.open('<?php echo html_href_link(FILENAME_DEFAULT, $params, 'SSL'); ?>','_blank')"><?php echo $query_result->fields['description']; ?></td>
	<td class="dataTableContent" onclick="window.open('<?php echo html_href_link(FILENAME_DEFAULT, $params, 'SSL'); ?>','_blank')"><?php echo $query_result->fields['bill_primary_name']; ?></td>
	<td class="dataTableContent" onclick="window.open('<?php echo html_href_link(FILENAME_DEFAULT, $params, 'SSL'); ?>','_blank')"><?php echo gen_spiffycal_db_date_short($query_result->fields['post_date']); ?></td>
	<td class="dataTableContent" onclick="window.open('<?php echo html_href_link(FILENAME_DEFAULT, $params, 'SSL'); ?>','_blank')"><?php echo $query_result->fields['purchase_invoice_id']; ?></td>
	<td class="dataTableContent" align="right" onclick="window.open('<?php echo html_href_link(FILENAME_DEFAULT, $params, 'SSL'); ?>','_blank')"><?php echo $currencies->format($query_result->fields['total_amount']); ?></td>
	<td class="dataTableContent" align="right">
<?php 
// build the action toolbar
	  // first pull in any extra buttons, this is dynamic since each row can have different buttons
	  if (function_exists('add_extra_action_bar_buttons')) echo add_extra_action_bar_buttons($query_result->fields);
	  echo html_icon('actions/edit-find-replace.png', TEXT_EDIT, 'small', 'onclick="window.open(\'' . html_href_link(FILENAME_DEFAULT, $params, 'SSL') . '\',\'_blank\')"') . chr(10);
?>
	</td>
  </tr>
<?php
	  } else { // no permission
?>
  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
	<td colspan="7" class="dataTableContent"><?php echo $query_result->fields['description'] . ' - ' . ERROR_NO_SEARCH_PERMISSION; ?></td>
  </tr>
<?php	  
	  }
	  $query_result->MoveNext();
	}
?>
</table>
<?php if ($query_numrows > 0) { ?>
<div class="page_count_right"><?php echo $query_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
<div class="page_count"><?php echo $query_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER . TEXT_RESULTS); ?></div>
<?php } ?>
</form>