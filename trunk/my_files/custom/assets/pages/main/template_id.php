<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2008 PhreeSoft, LLC                               |
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
//  Path: /modules/assets/pages/cat_inv/template_id.php
//

echo html_form('asset', FILENAME_DEFAULT, gen_get_all_get_params(array('action')));
echo html_hidden_field('todo', '') . chr(10);
// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action','module')) . '&module=main', 'SSL') . '\'"';
$toolbar->icon_list['open']['show'] = false;
$toolbar->icon_list['delete']['show'] = false;
$toolbar->icon_list['save']['show'] = false;
$toolbar->icon_list['print']['show'] = false;
$toolbar->add_icon('continue', 'onclick="submitToDo(\'create\')"', $order = 10);
$toolbar->add_help('');
echo $toolbar->build_toolbar(); 
?>
  <div class="pageHeading"><?php echo ASSETS_HEADING_NEW_ITEM; ?></div>
  <table width="500" align="center" cellspacing="0" cellpadding="1">
    <tr>
	  <th nowrap colspan="2"><?php echo ASSETS_ENTER_ASSET_ID; ?></th>
    </tr>
    <tr>
	  <td class="main" align="right"><?php echo TEXT_ASSET_ID; ?></td>
	  <td class="main"><?php echo html_input_field('asset_id', $asset_id, 'size="17" maxlength="16"'); ?></td>
    </tr>
    <tr>
	  <td class="main" align="right"><?php echo ASSETS_ENTRY_ASSET_TYPE; ?></td>
	  <td class="main"><?php echo html_pull_down_menu('asset_type', gen_build_pull_down($assets_types), isset($asset_type) ? $asset_type : 'vh'); ?></td>
    </tr>
    <tr>
	  <td nowrap colspan="2"><?php echo '&nbsp;'; ?></td>
    </tr>
  </table>
</form>