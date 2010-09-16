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
//  Path: /modules/orders/pages/popup_bar_code/template_main.php
//

// start the form
echo html_form('bar_code', FILENAME_DEFAULT) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="self.close()"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['delete']['show']   = false;
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
<div class="pageHeading"><?php echo POPUP_BAR_CODE_TITLE; ?></div>
<table border="0" align="center" cellspacing="1" cellpadding="1">
  <tr>
	<th colspan="2"><?php echo ORD_BAR_CODE_INTRO; ?></th>
  </tr>
  <tr>
	<td align="right"><?php echo TEXT_QUANTITY; ?></td>
	<td><?php echo html_input_field('qty', '1', 'size="6"'); ?></td>
  </tr>
  <tr>
	<td align="right"><?php echo TEXT_UPC_CODE; ?></td>
	<td>
	  <?php echo html_input_field('upc', '', 'size="16"'); ?>
	  <?php echo html_icon('devices/media-floppy.png', TEXT_SAVE, 'small', 'onclick="setReturnItem(true)"'); ?>
	</td>
  </tr>
</table>
</form>