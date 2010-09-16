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
//  Path: /modules/services/pages/popup_imp_exp/template_main.php
//

// start the form
echo html_form('ie_field', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '');

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="self.close();"';
$toolbar->icon_list['open']['show'] = false;
$toolbar->icon_list['delete']['show'] = false;
$toolbar->icon_list['save']['params'] = 'onclick="submitToDo(\'save\')"';
$toolbar->icon_list['print']['show'] = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('10');
echo $toolbar->build_toolbar();

// Build the page
?>
<div class="pageHeading"><?php echo IE_POPUP_FIELD_TITLE; ?></div>
<table border="0" cellspacing="2" cellpadding="2">
  <tr>
	<td colsapn="2"><?php echo IE_DB_FIELD_NAME . $params[$row_id]['field']; ?></td>
  </tr>
  <tr>
	<td class="main"><?php echo IE_FIELD_NAME; ?></td>
	<td class="main"><?php echo html_input_field('name', $params[$row_id]['name']); ?></td>
  </tr>
  <tr>
	<td class="main"><?php echo IE_PROCESSING; ?></td>
	<td class="main" valign="top"><?php echo html_pull_down_menu('processing', $imp_exp_funcs, $params[$row_id]['proc']); ?></td>
  </tr>
  <tr>
	<td class="main"><?php echo TEXT_SHOW; ?></td>
	<td class="main" valign="top"><?php echo html_checkbox_field('show', $value = '', ($params[$row_id]['show']) ? true : false); ?></td>
  </tr>
</table>
</form>