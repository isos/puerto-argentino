<?php // prep some data
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
//  Path: /modules/reportwriter/pages/rpt_gen/template_save.php
//

echo html_form('reportSaveAs', FILENAME_DEFAULT, gen_get_all_get_params(array('action')));

echo html_hidden_field('ReportID', $ReportID);
echo html_hidden_field('todo', '');

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="self.close()"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['params']   = 'onclick="submitToDo(\'save\');"';
$toolbar->icon_list['print']['show']    = false;
$toolbar->icon_list['delete']['show']   = false;
if ($ShowReplace) $toolbar->add_icon('rename', 'onclick="submitToDo(\'rename\')"', $order = 10);
$toolbar->add_help('11.02');
echo $toolbar->build_toolbar(); 
?>
<h2 align="center"><?php echo RW_TITLE_RPTFRM . stripslashes($Prefs['description']) . ' - ' . RW_TITLE_PAGESAVE; ?></h2>
  <table width="400" align="center" border="1" cellspacing="1" cellpadding="1">
	<tr>
	  <th><?php echo RW_RPT_RPTENTER; ?></th>
	</tr>
	<tr>
	  <td align="center"><?php echo html_input_field('ReportName', $Prefs['description'], 'size="32" maxlength="30"'); ?></td>
	</tr>
  </table>
</form>
