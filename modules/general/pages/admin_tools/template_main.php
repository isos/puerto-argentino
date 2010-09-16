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
//  Path: /modules/general/pages/admin_tools/template_main.php
//

// start the form
echo html_form('admin_tools', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

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
$toolbar->add_help('01');
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo GEN_ADM_TOOLS_TITLE; ?></div>
<fieldset>
<legend><?php echo GEN_ADM_TOOLS_CLEAN_LOG; ?></legend>
<p><?php echo GEN_ADM_TOOLS_CLEAN_LOG_DESC; ?></p>
  <table align="center" border="0" cellspacing="2" cellpadding="1">
    <tr>
	  <th><?php echo GEN_ADM_TOOLS_CLEAN_LOG_BACKUP; ?></th>
	  <th><?php echo GEN_ADM_TOOLS_CLEAN_LOG_CLEAN; ?></th>
	</tr>
	<tr>
	  <td align="center"><?php echo html_button_field('backup_log', GEN_ADM_TOOLS_BTN_BACKUP, 'onclick="submitToDo(\'backup_log\')"'); ?></td>
	  <td align="center"><?php echo html_button_field('clean_log',  GEN_ADM_TOOLS_BTN_CLEAN,  'onclick="if (confirm(\'' . GEN_ADM_TOOLS_BTN_CLEAN_CONFIRM . '\')) submitToDo(\'clean_log\')"'); ?></td>
	</tr>
  </table>
</fieldset>

<fieldset>
<legend><?php echo GEN_ADM_TOOLS_SEQ_HEADING; ?></legend>
<p><?php echo GEN_ADM_TOOLS_SEQ_DESC; ?></p>
  <table align="center" border="0" cellspacing="2" cellpadding="1">
    <tr>
	  <th colspan="2"><?php echo GEN_ADM_TOOLS_AR; ?></th>
	  <th colspan="2"><?php echo GEN_ADM_TOOLS_AP; ?></th>
	  <th colspan="2"><?php echo GEN_ADM_TOOLS_BNK; ?></th>
	</tr>
	<tr>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_ARQ; ?></td>
	  <td class="dataTableContent"><?php echo  html_input_field('next_ar_quote_num', $cInfo->next_ar_quote_num); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_APQ; ?></td>
	  <td class="dataTableContent"><?php echo  html_input_field('next_ap_quote_num', $cInfo->next_ap_quote_num); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_BNKD; ?></td>
	  <td class="dataTableContent"><?php echo  html_input_field('next_deposit_num', $cInfo->next_deposit_num); ?></td>
	</tr>
	<tr>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_ARSO; ?></td>
	  <td class="dataTableContent"><?php echo  html_input_field('next_so_num', $cInfo->next_so_num); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_APPO; ?></td>
	  <td class="dataTableContent"><?php echo  html_input_field('next_po_num', $cInfo->next_po_num); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_BNKCK; ?></td>
	  <td class="dataTableContent"><?php echo  html_input_field('next_check_num', $cInfo->next_check_num); ?></td>
	</tr>
	<tr>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_ARINV; ?></td>
	  <td class="dataTableContent"><?php echo  html_input_field('next_inv_num', $cInfo->next_inv_num); ?></td>
	  <td class="dataTableContent" colspan="2">&nbsp;</td>
	  <th colspan="2"><?php echo GEN_ADM_TOOLS_OTHER; ?></th>
	</tr>
	<tr>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_ARCM; ?></td>
	  <td class="dataTableContent"><?php echo  html_input_field('next_cm_num', $cInfo->next_cm_num); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_APCM; ?></td>
	  <td class="dataTableContent"><?php echo  html_input_field('next_vcm_num', $cInfo->next_vcm_num); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_SHIP; ?></td>
	  <td class="dataTableContent"><?php echo  html_input_field('next_shipment_num', $cInfo->next_shipment_num); ?></td>
	</tr>
	<tr>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_CUSTID; ?></td>
	  <td class="dataTableContent"><?php echo  html_input_field('next_cust_id_num', $cInfo->next_cust_id_num); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_VENDID; ?></td>
	  <td class="dataTableContent"><?php echo  html_input_field('next_vend_id_num', $cInfo->next_vend_id_num); ?></td>
	  <td class="dataTableContent" colspan="2">&nbsp;</td>
	  <td class="dataTableContent" colspan="2">&nbsp;</td>
	</tr>
	<tr>
	  <td colspan="6" align="right"><?php echo html_button_field('ordr_nums', GEN_ADM_TOOLS_BTN_SAVE, 'onclick="submitToDo(\'ordr_nums\')"'); ?></td>
    </tr>
  </table>
</fieldset>

<fieldset>
<legend><?php echo GEN_ADM_TOOLS_REPOST_HEADING; ?></legend>
<p><?php echo GEN_ADM_TOOLS_REPOST_DESC; ?></p>
  <table align="center" border="0" cellspacing="2" cellpadding="1">
    <tr>
	  <th colspan="2"><?php echo GEN_ADM_TOOLS_AR; ?></th>
	  <th colspan="2"><?php echo GEN_ADM_TOOLS_AP; ?></th>
	  <th colspan="2"><?php echo GEN_ADM_TOOLS_BNK_ETC; ?></th>
	  <th colspan="2"><?php echo GEN_ADM_TOOLS_DATE_RANGE; ?></th>
	</tr>
	<tr>
	  <td class="dataTableContent"><?php echo  html_checkbox_field('jID_9', '1', false); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_J09; ?></td>
	  <td class="dataTableContent"><?php echo  html_checkbox_field('jID_3', '1', false); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_J03; ?></td>
	  <td class="dataTableContent"><?php echo  html_checkbox_field('jID_2', '1', false); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_J02; ?></td>
  	  <td class="dataTableContent" colspan="2"><?php echo GEN_ADM_TOOLS_START_DATE; ?></td>
	</tr>
	<tr>
	  <td class="dataTableContent"><?php echo  html_checkbox_field('jID_10', '1', false); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_J10; ?></td>
	  <td class="dataTableContent"><?php echo  html_checkbox_field('jID_4', '1', false); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_J04; ?></td>
	  <td class="dataTableContent"><?php echo  html_checkbox_field('jID_8', '1', false); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_J08; ?></td>
	  <td class="dataTableContent" colspan="2"><script type="text/javascript">startDate.writeControl(); startDate.displayLeft=true; startDate.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script></td>
	</tr>
	<tr>
	  <td class="dataTableContent"><?php echo  html_checkbox_field('jID_12', '1', false); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_J12; ?></td>
	  <td class="dataTableContent"><?php echo  html_checkbox_field('jID_6', '1', false); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_J06; ?></td>
	  <td class="dataTableContent"><?php echo  html_checkbox_field('jID_14', '1', false); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_J14; ?></td>
  	  <td class="dataTableContent" colspan="2"><?php echo GEN_ADM_TOOLS_END_DATE; ?></td>
	</tr>
	<tr>
	  <td class="dataTableContent"><?php echo  html_checkbox_field('jID_13', '1', false); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_J13; ?></td>
	  <td class="dataTableContent"><?php echo  html_checkbox_field('jID_7', '1', false); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_J07; ?></td>
	  <td class="dataTableContent"><?php echo  html_checkbox_field('jID_16', '1', false); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_J16; ?></td>
	  <td class="dataTableContent" colspan="2"><script type="text/javascript">endDate.writeControl(); endDate.displayLeft=true; endDate.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script></td>
	</tr>
	<tr>
	  <td class="dataTableContent"><?php echo  html_checkbox_field('jID_19', '1', false); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_J19; ?></td>
	  <td class="dataTableContent"><?php echo  html_checkbox_field('jID_21', '1', false); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_J21; ?></td>
	  <td class="dataTableContent"><?php echo  html_checkbox_field('jID_18', '1', false); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_J18; ?></td>
	</tr>
	<tr>
	  <td class="dataTableContent" colspan="2">&nbsp;</td>
	  <td class="dataTableContent" colspan="2">&nbsp;</td>
	  <td class="dataTableContent"><?php echo  html_checkbox_field('jID_20', '1', false); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_J20; ?></td>
	  <td colspan="2" align="right"><?php echo html_button_field('repost', GEN_ADM_TOOLS_BTN_REPOST, 'onclick="if (confirm(\'' . GEN_ADM_TOOLS_REPOST_CONFIRM . '\')) submitToDo(\'repost\')"'); ?></td>
	</tr>
  </table>
</fieldset>

<fieldset>
<legend><?php echo GEN_ADM_TOOLS_REPAIR_CHART_HISTORY; ?></legend>
<p><?php echo GEN_ADM_TOOLS_REPAIR_CHART_DESC; ?></p>
  <table align="center" border="0" cellspacing="2" cellpadding="1">
    <tr>
	  <th><?php echo GEN_ADM_TOOLS_REPAIR_TEST; ?></th>
	  <th><?php echo GEN_ADM_TOOLS_REPAIR_FIX; ?></th>
	</tr>
	<tr>
	  <td align="center"><?php echo html_button_field('coa_hist_test', GEN_ADM_TOOLS_BTN_TEST, 'onclick="submitToDo(\'coa_hist_test\')"'); ?></td>
	  <td align="center"><?php echo html_button_field('coa_hist_fix', GEN_ADM_TOOLS_BTN_REPAIR, 'onclick="if (confirm(\'' . GEN_ADM_TOOLS_REPAIR_CONFIRM . '\')) submitToDo(\'coa_hist_fix\')"'); ?></td>
	</tr>
  </table>
</fieldset>
</form>
