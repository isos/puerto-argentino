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
//  Path: /modules/reportwriter/pages/builder/template_security_setup.php
//

echo html_form('reportsecform', FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=step9');
echo html_hidden_field('ReportID', $ReportID);
echo html_hidden_field('Type', $Type); 
echo html_hidden_field('ReportName', $description);
echo html_hidden_field('todo', '');
// customize the toolbar actions
$toolbar->icon_list['cancel']['show'] = false;
$toolbar->icon_list['open']['show']   = false;
$toolbar->icon_list['save']['params'] = 'onclick="submitToDo(\'update\');"';
$toolbar->icon_list['print']['show']  = false;
$toolbar->icon_list['delete']['show'] = false;
$toolbar->add_icon('back', 'onclick="submitToDo(\'back\')"', $order = 9);
$toolbar->add_icon('finish', 'onclick="submitToDo(\'finish\')"', $order = 10);
$toolbar->add_help('11.01.01');
echo $toolbar->build_toolbar(); 
?>
<h2 align="center"><?php echo $FormParams['heading'] . stripslashes($description) . ' - ' . TEXT_SECURITY; ?></h2>
  <table width="600" align="center" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td align="center" width="33%"><h3><?php echo HEADING_TITLE_USERS; ?></h3></td>
	 <td align="center" width="34%"><h3><?php echo MENU_HEADING_EMPLOYEES; ?></h3></td>
	 <td align="center" width="33%"><h3><?php echo BOX_HR_DEPARTMENTS; ?></h3></td>
   </tr>
   <tr>
	 <td align="center" width="33%"><?php echo html_checkbox_field('UserAll',       '1', (in_array('0', $presets['u'], true) ? true : false)) . ' ' . TEXT_ALL_USERS; ?></td>
	 <td align="center" width="34%"><?php echo html_checkbox_field('EmployeeAll',   '1', (in_array('0', $presets['e'], true) ? true : false)) . ' ' . TEXT_ALL_EMPLOYEES; ?></td>
	 <td align="center" width="33%"><?php echo html_checkbox_field('DepartmentAll', '1', (in_array('0', $presets['d'], true) ? true : false)) . ' ' . TEXT_ALL_DEPTS; ?></td>
   </tr>
   <tr>
	 <td align="center" width="33%"><?php echo html_pull_down_menu('UserList[]',       gen_get_pull_down(TABLE_USERS, true, '1', 'admin_id', 'admin_name'), $presets['u'], 'multiple="multiple" size="20"'); ?></td>
	 <td align="center" width="34%"><?php echo html_pull_down_menu('EmployeeList[]',   gen_get_account_array_by_type('e'), $presets['e'], 'multiple="multiple" size="20"'); ?></td>
	 <td align="center" width="33%"><?php echo html_pull_down_menu('DepartmentList[]', gen_get_pull_down(TABLE_DEPARTMENTS, true, '1'), $presets['d'], 'multiple="multiple" size="20"'); ?></td>
   </tr>
  </table>
</form>
