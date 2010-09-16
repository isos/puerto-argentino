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
//  Path: /modules/setup/pages/company_mgr/template_main.php
//

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['print']['show']    = false;
$toolbar->add_icon('new', 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL') . '\'"', $order = 2);

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('04.05');
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo BOX_COMPANY_MANAGER; ?></div>
<div>
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
	  <tr>
		<td valign="top" width="50%">
		 <?php echo html_form('company_mgr_dup', FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . '&action=copy'); ?>
		 <fieldset><legend><?php echo SETUP_CO_MGR_COPY_CO; ?></legend>
		 <table border="0" cellspacing="0" cellpadding="0">
		  <tr><td><?php echo '&nbsp;'; ?></td></tr>
		  <tr><td><?php echo SETUP_CO_MGR_COPY_HDR; ?></td></tr>
		  <tr><td><?php echo SETUP_CO_MGR_SRVR_NAME . html_input_field('db_server', 'localhost', 'size="40"', true); ?></td></tr>
		  <tr><td><?php echo '&nbsp;'; ?></td></tr>
		  <tr><td><?php echo SETUP_CO_MGR_DB_NAME . html_input_field('company', '', '', true); ?></td></tr>
		  <tr><td><?php echo '&nbsp;'; ?></td></tr>
		  <tr><td><?php echo SETUP_CO_MGR_DB_USER . html_input_field('db_user', '', '', true); ?></td></tr>
		  <tr><td><?php echo '&nbsp;'; ?></td></tr>
		  <tr><td><?php echo SETUP_CO_MGR_DB_PW . html_password_field('db_pw', '', true); ?></td></tr>
		  <tr><td><?php echo '&nbsp;'; ?></td></tr>
		  <tr><td><?php echo SETUP_CO_MGR_CO_NAME . html_input_field('company_name', '', 'size="50"', true); ?></td></tr>
		  <tr><td><?php echo '&nbsp;'; ?></td></tr>
		  <tr><td><?php echo SETUP_CO_MGR_SELECT_OPTIONS; ?></td></tr>
		  <tr><td><?php echo html_checkbox_field('all', '1', true) . '&nbsp;' . SETUP_CO_MGR_OPTION_1; ?></td></tr>
		  <tr><td><?php echo html_checkbox_field('chart', '1') . '&nbsp;' . SETUP_CO_MGR_OPTION_2; ?></td></tr>
		  <tr><td><?php echo html_checkbox_field('reports', '1') . '&nbsp;' . SETUP_CO_MGR_OPTION_3; ?></td></tr>
		  <tr><td><?php echo html_checkbox_field('inventory', '1') . '&nbsp;' . SETUP_CO_MGR_OPTION_4; ?></td></tr>
		  <tr><td><?php echo html_checkbox_field('customers', '1') . '&nbsp;' . SETUP_CO_MGR_OPTION_5; ?></td></tr>
		  <tr><td><?php echo html_checkbox_field('vendors', '1') . '&nbsp;' . SETUP_CO_MGR_OPTION_6; ?></td></tr>
		  <tr><td><?php echo html_checkbox_field('employees', '1') . '&nbsp;' . SETUP_CO_MGR_OPTION_7; ?></td></tr>
		  <tr><td><?php echo html_checkbox_field('users', '1') . '&nbsp;' . SETUP_CO_MGR_OPTION_8; ?></td></tr>
		  <tr><td align="right"><?php echo html_submit_field('button', SETUP_CO_MGR_COPY_CO); ?></td></tr>
		 </table>
		 </fieldset></form>
		</td>
	    <td valign="top" width="50%">
		 <?php echo html_form('company_mgr_add', FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . '&action=new', 'post', 'if (!confirm(\'Really delete this database?\')) return false', true); ?>
		 <fieldset><legend><?php echo SETUP_CO_MGR_ADD_NEW_CO; ?></legend>
		 <table border="0" cellspacing="0" cellpadding="0">
		  <tr><td><?php echo '&nbsp;'; ?></td></tr>
		  <tr><td><?php echo SETUP_CO_MGR_COPY_HDR; ?></td></tr>
		  <tr><td><?php echo SETUP_CO_MGR_SRVR_NAME . html_input_field('db_server', 'localhost', 'size="40"', true); ?></td></tr>
		  <tr><td><?php echo '&nbsp;'; ?></td></tr>
		  <tr><td><?php echo SETUP_CO_MGR_DB_NAME . html_input_field('company', '', '', true); ?></td></tr>
		  <tr><td><?php echo '&nbsp;'; ?></td></tr>
		  <tr><td><?php echo SETUP_CO_MGR_DB_USER . html_input_field('db_user', '', '', true); ?></td></tr>
		  <tr><td><?php echo '&nbsp;'; ?></td></tr>
		  <tr><td><?php echo SETUP_CO_MGR_DB_PW . html_password_field('db_pw', '', true); ?></td></tr>
		  <tr><td><?php echo '&nbsp;'; ?></td></tr>
		  <tr><td><?php echo SETUP_CO_MGR_CO_NAME . html_input_field('company_name', '', 'size="50"', true); ?></td></tr>
		  <tr><td><?php echo '&nbsp;'; ?></td></tr>
		  <tr><td align="right"><?php echo html_submit_field('button', SETUP_CO_MGR_ADD_NEW_CO); ?></td></tr>
		 </table>
		 </fieldset></form>
		 <?php echo html_form('company_mgr_del', FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . '&action=delete'); ?>
		 <fieldset><legend><?php echo SETUP_CO_MGR_DEL_CO; ?></legend>
		 <table width="100%" border="0" cellspacing="2" cellpadding="2">
		  <tr><td><?php echo SETUP_CO_MGR_SELECT_DELETE; ?></td></tr>
		  <tr><td><?php echo SETUP_CO_MGR_DELETE_CONFIRM; ?></td></tr>
		  <tr><td><?php echo html_pull_down_menu('company', load_company_dropdown(true)); ?></td></tr>
		  <tr><td align="right"><?php echo html_submit_field('button', SETUP_CO_MGR_DEL_CO, 'onclick="if (!confirm(\'' . SETUP_CO_MGR_JS_DELETE_CONFIRM . '\')) return false"'); ?></td></tr>
		 </table>
		 </fieldset></form>
		</td>
	  </tr>
	 </table>
</div>
