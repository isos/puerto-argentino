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
//  Path: /modules/general/pages/backup/template_main.php
//

// start the form
echo html_form('popup_backup', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show'] = false;
$toolbar->icon_list['save']['params'] = 'onclick="submitToDo(\'save\')"';
$toolbar->icon_list['save']['icon'] = 'actions/document-save.png';
$toolbar->icon_list['save']['text'] = GEN_BACKUP_ICON_TITLE;
$toolbar->icon_list['delete']['show'] = false;
$toolbar->icon_list['print']['show'] = false;
$toolbar->icon_list['restore'] = array(
  'show'   => true, 
  'icon'   => 'devices/drive-optical.png',
  'params' => 'onclick="if (confirm(\'' . GEN_BACKUP_WARNING . '\')) submitToDo(\'restore\')"', 
  'text'   => BOX_HEADING_RESTORE, 
  'order'  => 10,
);

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('01');
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo BOX_HEADING_BACKUP; ?></div>
<table width="500" align="center" border="0" cellspacing="2" cellpadding="2">
  <tr><td colspan="3"><?php echo GEN_BACKUP_GEN_INFO; ?></td></tr> 
  <tr><th colspan="3"><?php echo GEN_BACKUP_COMP_TYPE; ?></th></tr>
  <tr>
	<td class="main" align="center"><?php echo html_radio_field('conv_type', 'bz2',  false, '', '') . GEN_COMP_BZ2; ?></td>
	<td class="main" align="center"><?php echo html_radio_field('conv_type', 'zip',  true,  '', '') . GEN_COMP_ZIP; ?></td>
	<td class="main" align="center"><?php echo html_radio_field('conv_type', 'none', false, '', '') . GEN_COMP_NONE; ?></td>
  </tr>
  <tr><th colspan="3"><?php echo TEXT_OPTIONS; ?></th></tr>
  <tr>
	<td colspan="3" class="main"><?php echo html_radio_field('dl_type', 'db', true, '', '') . GEN_BACKUP_DB_ONLY; ?></td>
  </tr>
  <tr>
	<td colspan="3" class="main"><?php echo html_radio_field('dl_type', 'all', false, '', '') . GEN_BACKUP_FULL; ?></td>
  </tr>
  <tr>
	<td colspan="3" class="main"><?php echo html_checkbox_field('save_local', '1', false, '', '') . GEN_BACKUP_SAVE_LOCAL; ?></td>
  </tr>
</table>
</form>