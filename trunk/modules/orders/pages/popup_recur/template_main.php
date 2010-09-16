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
//  Path: /modules/orders/pages/popup_recur/template_main.php
//

// start the form
echo html_form('recur', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="self.close()"';
$toolbar->icon_list['open']['show'] = false;
$toolbar->icon_list['save']['params'] = 'onclick="setReturnRecur()"';
$toolbar->icon_list['delete']['show'] = false;
$toolbar->icon_list['print']['show'] = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('07');
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo constant('ORD_RECUR_WINDOW_TITLE_' . JOURNAL_ID); ?></div>
<table border="0" width="100%" cellspacing="0" cellpadding="1">
  <tr>
	<td><?php echo '&nbsp;'; ?></td>
  </tr>
  <tr>
	<td><?php echo ORD_RECUR_INTRO; ?></td>
  </tr>
  <tr>
	<th align="center"><?php echo ORD_RECUR_ENTRIES; ?></th>
  </tr>
  <tr>
	<td align="center"><?php echo html_input_field('recur_id', '1', 'size="3"'); ?></td>
  </tr>
  <tr>
	<th align="center"><?php echo ORD_RECUR_FREQUENCY; ?></th>
  </tr>
  <tr>
	<td>
<?php
echo html_radio_field('recur_frequency', 1, false) . ORD_TEXT_WEEKLY . '<br />' . chr(10);
echo html_radio_field('recur_frequency', 2, false) . ORD_TEXT_BIWEEKLY . '<br />' . chr(10);
echo html_radio_field('recur_frequency', 3, true) . ORD_TEXT_MONTHLY . '<br />' . chr(10);
echo html_radio_field('recur_frequency', 4, false) . ORD_TEXT_QUARTERLY . '<br />' . chr(10);
echo html_radio_field('recur_frequency', 5, false) . ORD_TEXT_YEARLY . chr(10);
?>
	</td>
  </tr>
</table>
</form>