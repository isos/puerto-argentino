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
//  Path: /modules/services/pages/popup_tracking/template_main.php
//

// start the form
echo html_form('popup_tracking', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="self.close()"';
$toolbar->icon_list['open']['show'] = false;
$toolbar->icon_list['save']['params'] = 'onclick="submitToDo(\'save\')"';
$toolbar->icon_list['delete']['show'] = false;
$toolbar->icon_list['print']['show'] = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('');
echo $toolbar->build_toolbar();

// Build the page
?>
<div class="pageHeading"><?php echo SHIPPING_SHIPMENT_DETAILS; ?></div>
<table border="0" width="100%" cellspacing="0" cellpadding="1">
  <tr class="dataTableRow">
	<td><?php echo SHIPPING_TEXT_SHIPMENT_ID . SHIPPING_SET_BY_SYSTEM; ?></td>
	<td><?php echo html_input_field('shipment_id', $cInfo->shipment_id, 'readonly="readonly"'); ?></td>
  </tr>
  <tr class="dataTableRow">
	<td><?php echo SHIPPING_TEXT_REFERENCE_ID; ?></td>
	<td><?php echo html_input_field('ref_id', $cInfo->ref_id); ?></td>
  </tr>
  <tr class="dataTableRow">
	<td><?php echo SHIPPING_TEXT_CARRIER; ?></td>
	<td><?php echo html_pull_down_menu('carrier', ord_get_shipping_carriers_array(), $cInfo->carrier, 'onchange="buildFreightDropdown()"'); ?></td>
  </tr>
  <tr class="dataTableRow">
	<td><?php echo SHIPPING_TEXT_SERVICE; ?></td>
	<td><?php echo html_pull_down_menu('method', ord_get_shipping_service_array(), $cInfo->method); ?></td>
  </tr>
  <tr class="dataTableRow">
	<td><?php echo SHIPPING_TEXT_TRACKING_NUM; ?></td>
	<td><?php echo html_input_field('tracking_id', $cInfo->tracking_id); ?></td>
  </tr>
  <tr class="dataTableRow">
	<td><?php echo SHIPPING_TEXT_SHIPMENT_DATE; ?></td>
	<td><script type="text/javascript">ship_cal.writeControl(); ship_cal.displayLeft=true; ship_cal.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script></td>
  </tr>
  <tr class="dataTableRow">
	<td><?php echo SHIPPING_TEXT_EXPECTED_DATE; ?></td>
	<td><script type="text/javascript">cal.writeControl(); cal.displayLeft=true; cal.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script></td>
  </tr>
  <tr class="dataTableRow">
	<td><?php echo SHIPPING_TEXT_COST; ?></td>
	<td><?php echo html_input_field('cost', $cInfo->cost); ?></td>
  </tr>
</table>
</form>