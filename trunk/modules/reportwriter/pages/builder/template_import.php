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
//  Path: /modules/reportwriter/pages/builder/template_import.php
//

echo html_form('reporthome', FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=step8', 'post', 'enctype="multipart/form-data"');
echo html_hidden_field('Type', $Type); 
echo html_hidden_field('todo', ''); 
// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="self.close();"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['print']['show']    = false;
$toolbar->icon_list['delete']['show']   = false;
$toolbar->add_icon('continue', 'onclick="submitToDo(\'continue\')"', $order = 10);
$toolbar->add_help('11.01.01');
echo $toolbar->build_toolbar(); 
?>
<h2 align="center"><?php echo $FormParams['heading']; ?></h2>
  <table width="500" align="center" border="2" cellspacing="1" cellpadding="1">
    <tr>
      <td colspan="2" align="center"><?php echo RW_RPT_DEFIMP; ?></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><?php echo ReadDefReports('RptFileName'); ?></td>
    </tr>
    <tr>
      <td><?php echo RW_RPT_RPTBROWSE; ?></td>
      <td><?php echo html_file_field('reportfile'); ?></td>
    </tr>
    <tr>
      <td><?php echo RW_RPT_RPTENTER . '<br />' . RW_RPT_RPTNOENTER; ?></td>
      <td><?php echo html_input_field('reportname', $ReportName, 'size="32" maxlength="30"'); ?></td>
    </tr>
  </table>
</form>