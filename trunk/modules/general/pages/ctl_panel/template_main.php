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
//  Path: /modules/general/pages/ctl_panel/template_main.php
//

// start the form
echo html_form('cpanel', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['save']['params']   = 'onclick="submitToDo(\'save\')"';
$toolbar->icon_list['print']['show']    = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('07.09.01');
echo $toolbar->build_toolbar();

// Build the page
?>
<div class="pageHeading"><?php echo CP_ADD_REMOVE_BOXES; ?></div>
<table border="1" width="100%" cellspacing="0" cellpadding="1">
  <tr>
	<th><?php echo TEXT_SHOW; ?></th>
	<th><?php echo TEXT_TITLE; ?></th>
	<th><?php echo TEXT_DESCRIPTION; ?></th>
  </tr>
	<?php foreach ($the_list as $value) {
		if (!$value['security'] || $_SESSION['admin_security'][$value['security']] > 0) { // make sure user can view this control panel element
			echo '<tr><td align="center">';
			$checked = (in_array($value['module_id'], $my_profile)) ? ' selected' : '';
			echo html_checkbox_field($value['module_id'], '1', $checked, '', $parameters = '');
			echo '</td><td>' . $value['title'] . '</td><td>' . $value['description'] . '</td></tr>';
		}
	} ?>
</table>
</form>