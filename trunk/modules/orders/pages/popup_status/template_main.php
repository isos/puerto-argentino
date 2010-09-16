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
//  Path: /modules/orders/pages/popup_status/template_main.php
//

// start the form
echo html_form('status', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="self.close()"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['print']['show']    = false;

// build the toolbar
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo constant($type . '_CONTACT_STATUS'); ?></div>
<table border="1" width="100%" cellspacing="0" cellpadding="1">
  <tr>
	<td colspan="5" align="center"<?php echo $inactive_flag; ?>><?php echo $status_text; ?></td>
  </tr>
  <tr><th colspan="5"><?php echo ACT_POPUP_TERMS_WINDOW_TITLE; ?></th></tr>
  <tr><td colspan="5"><?php echo ACT_TERMS_DUE . ': ' . $special_terms . ACT_TERMS_CREDIT_LIMIT . $currencies->format($credit_limit); ?></td></tr>
<?php if ($past_due <> 0) { ?>
  <tr><td colspan="5"><?php echo ACT_AMT_PAST_DUE . $currencies->format($past_due); ?></td></tr>
<?php } ?>
  <tr><th colspan="5"><?php echo ACT_ACT_HISTORY; ?></th></tr>
  <tr>
	<th align="center"><?php echo ($type == 'AP') ? AP_AGING_HEADING_1 : AR_AGING_HEADING_1; ?></th>
	<th align="center"><?php echo ($type == 'AP') ? AP_AGING_HEADING_2 : AR_AGING_HEADING_2; ?></th>
	<th align="center"><?php echo ($type == 'AP') ? AP_AGING_HEADING_3 : AR_AGING_HEADING_3; ?></th>
	<th align="center"><?php echo ($type == 'AP') ? AP_AGING_HEADING_4 : AR_AGING_HEADING_4; ?></th>
	<th align="center"><?php echo TEXT_TOTAL; ?></th>
  </tr>
  <tr>
	<td align="center"><?php echo $currencies->format($new_data['balance_0']); ?></td>
	<td align="center"><?php echo $currencies->format($new_data['balance_30']); ?></td>
	<td align="center"><?php echo $currencies->format($new_data['balance_60']); ?></td>
	<td align="center"><?php echo $currencies->format($new_data['balance_90']); ?></td>
	<td align="center"><?php echo $currencies->format($total_outstanding); ?></td>
  </tr>
  <tr><th colspan="5"><?php echo TEXT_NOTES; ?></th></tr>
  <tr><td colspan="5"><?php echo $notes; ?></td></tr>
</table>
</form>