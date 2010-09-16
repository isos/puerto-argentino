<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2007-2008 PhreeSoft, LLC                          |
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
//  Path: /modules/translator/pages/admin/template_main.php
//

// start the form
echo html_form('admin', FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'post', '', true) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['print']['show']    = false;
echo $toolbar->build_toolbar();

// Build the page
?>
<div class="pageHeading"><?php echo PAGE_TITLE; ?></div>
<table width="500" align="center" border="0" cellspacing="2" cellpadding="2">
  <tr><td><?php echo MODULE_TRANSLATOR_GEN_INFO; ?></td></tr> 
<?php if ($install_trans_module) { ?>
  <tr><th><?php echo MODULE_TRANSLATOR_INSTALL_INFO; ?></th></tr>
  <tr>
	<td class="main" align="center"><?php echo html_submit_field('install', TEXT_INSTALL, ''); ?></td>
  </tr>
<?php } else { ?>
  <tr><th><?php echo MODULE_TRANSLATOR_REMOVE_INFO; ?></th></tr>
  <tr>
	<td class="main" align="center"><?php echo html_submit_field('remove', TEXT_REMOVE, 'onclick="if (!confirm(\'' . MODULE_TRANSLATOR_REMOVE_CONFIRM . '\')) return false"'); ?></td>
  </tr>
<?php } ?>
</table>
</form>