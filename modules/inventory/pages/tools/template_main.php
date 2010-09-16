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
//  Path: /modules/inventory/pages/tools/template_main.php
//

// start the form
echo html_form('tools', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

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
<div class="pageHeading"><?php echo BOX_INV_TOOLS; ?></div>
<fieldset>
<legend><?php echo INV_TOOLS_VALIDATE_INVENTORY; ?></legend>
<p><?php echo INV_TOOLS_VALIDATE_INV_DESC; ?></p>
  <table align="center" border="0" cellspacing="2" cellpadding="1">
    <tr>
	  <th><?php echo INV_TOOLS_REPAIR_TEST; ?></th>
	  <th><?php echo INV_TOOLS_REPAIR_FIX; ?></th>
	</tr>
	<tr>
	  <td align="center"><?php echo html_button_field('inv_hist_test', INV_TOOLS_BTN_TEST, 'onclick="submitToDo(\'inv_hist_test\')"'); ?></td>
	  <td align="center"><?php echo html_button_field('inv_hist_fix', INV_TOOLS_BTN_REPAIR, 'onclick="if (confirm(\'' . INV_TOOLS_REPAIR_CONFIRM . '\')) submitToDo(\'inv_hist_fix\')"'); ?></td>
	</tr>
  </table>
</fieldset>
<fieldset>
<legend><?php echo INV_TOOLS_VALIDATE_SO_PO; ?></legend>
<p><?php echo INV_TOOLS_VALIDATE_SO_PO_DESC; ?></p>
  <table align="center" border="0" cellspacing="2" cellpadding="1">
    <tr>
	  <th><?php echo INV_TOOLS_REPAIR_SO_PO; ?></th>
	</tr>
	<tr>
	  <td align="center"><?php echo html_button_field('inv_on_order_fix', INV_TOOLS_BTN_SO_PO_FIX, 'onclick="submitToDo(\'inv_on_order_fix\')"'); ?></td>
	</tr>
  </table>
</fieldset>
</form>