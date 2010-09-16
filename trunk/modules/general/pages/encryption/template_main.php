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
//  Path: /modules/general/pages/encryption/template_main.php
//

// start the form
echo html_form('popup_backup', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
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
<div class="pageHeading"><?php echo BOX_HEADING_ENCRYPTION; ?></div>
<fieldset>
<legend><?php echo GEN_ADM_TOOLS_SET_ENCRYPTION_KEY; ?></legend>
<p><?php echo GEN_ENCRYPTION_GEN_INFO; ?></p>
<table align="center" border="0" cellspacing="2" cellpadding="2">
  <tr><th colspan="2"><?php echo GEN_ENCRYPTION_COMP_TYPE; ?></th></tr>
  <tr>
	<td class="main" align="center"><?php echo GEN_ENCRYPTION_KEY . html_password_field('enc_key', ''); ?></td>
  </tr>
  <tr>
	<td class="main" align="center"><?php echo GEN_ENCRYPTION_KEY_CONFIRM . html_password_field('enc_key_confirm', ''); ?></td>
  </tr>
</table>
</fieldset>
<fieldset>
<legend><?php echo GEN_ADM_TOOLS_SET_ENCRYPTION_PW; ?></legend>
<p><?php echo GEN_ADM_TOOLS_SET_ENCRYPTION_PW_DESC; ?></p>
  <table align="center" border="0" cellspacing="2" cellpadding="1">
    <tr>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_ENCRYPT_OLD_PW; ?></td>
	  <td class="dataTableContent"><?php echo  html_password_field('old_encrypt_key'); ?></td>
	  <td colspan="2" align="right"><?php echo html_button_field('encrypt_key', GEN_ADM_TOOLS_BTN_SAVE, 'onclick="submitToDo(\'encrypt_key\')"'); ?></td>
	</tr>
    <tr>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_ENCRYPT_PW; ?></td>
	  <td class="dataTableContent"><?php echo  html_password_field('new_encrypt_key'); ?></td>
	  <td class="dataTableContent"><?php echo GEN_ADM_TOOLS_ENCRYPT_PW_CONFIRM; ?></td>
	  <td class="dataTableContent"><?php echo  html_password_field('new_encrypt_confirm'); ?></td>
	</tr>
  </table>
</fieldset>
</form>