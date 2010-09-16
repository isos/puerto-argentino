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
//  Path: /modules/reportwriter/pages/builder/template_db_setup.php
//

echo html_form('DBPageSetup', FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=step5');
echo html_hidden_field('ReportID',   $ReportID);
echo html_hidden_field('Type',       $Type); 
echo html_hidden_field('ReportName', $myrow['description']); 
echo html_hidden_field('todo',       ''); 
// customize the toolbar actions
$toolbar->icon_list['cancel']['show'] = false;
$toolbar->icon_list['open']['show']   = false;
$toolbar->icon_list['save']['params'] = 'onclick="submitToDo(\'update\');"';
$toolbar->icon_list['print']['show']  = false;
$toolbar->icon_list['delete']['show'] = false;
$toolbar->add_icon('back', 'onclick="submitToDo(\'back\')"', $order = 9);
$toolbar->add_icon('continue', 'onclick="submitToDo(\'continue\')"', $order = 10);
$toolbar->add_help('11.01.01');
echo $toolbar->build_toolbar(); 
?>
<h2 align="center"><?php echo $FormParams['heading'] . stripslashes($myrow['description']) . ' - ' . TEXT_DB_LINKS; ?></h2>
  <table align="center" border="2" cellspacing="1" cellpadding="1">
    <tr>
      <th colspan="2"><div align="center"><?php echo RW_RPT_TBLNAME; ?></div></th>
      <th><?php echo RW_RPT_LINKEQ; ?></th>
    </tr>
    <tr>
      <td><?php echo TEXT_TABLE1; ?></td>
      <td><?php echo html_pull_down_menu('Table1', CreateTableList($ReportID, 1), $myrow['table1'], 'onchange="submitToDo(\'update\')"'); ?></td>
	      <?php $rpt_special = ($myrow['special_report']) ? explode(':',$myrow['special_report']) : array(0, ''); ?>
      <td><?php 
	  	echo html_checkbox_field('special_report', '1', (($rpt_special[0]) ? true : false));
	    echo RW_RPT_SPECIAL_REPORT . html_input_field('sr_name', $rpt_special[1], ''); ?>
	  </td>
    </tr>
    <tr>
      <td><?php echo TEXT_TABLE2; ?></td>
      <td><?php if ($myrow['table1']) echo html_pull_down_menu('Table2', CreateTableList($ReportID, 2), $myrow['table2']); ?></td>
      <td><?php echo html_input_field('Table2Criteria', $myrow['table2criteria'], 'size="76" maxlength="75" onblur="submitToDo(\'update\')"'); ?><td>
    </tr>
    <tr>
      <td><?php echo TEXT_TABLE3; ?></td>
      <td><?php if ($myrow['table2']) echo html_pull_down_menu('Table3', CreateTableList($ReportID, 3), $myrow['table3']); ?></td>
      <td><?php echo html_input_field('Table3Criteria', $myrow['table3criteria'], 'size="76" maxlength="75" onblur="submitToDo(\'update\')"'); ?><td>
    </tr>
    <tr>
      <td><?php echo TEXT_TABLE4; ?></td>
      <td><?php if ($myrow['table3']) echo html_pull_down_menu('Table4', CreateTableList($ReportID, 4), $myrow['table4']); ?></td>
      <td><?php echo html_input_field('Table4Criteria', $myrow['table4criteria'], 'size="76" maxlength="75" onblur="submitToDo(\'update\')"'); ?><td>
    </tr>
    <tr>
      <td><?php echo TEXT_TABLE5; ?></td>
      <td><?php if ($myrow['table4']) echo html_pull_down_menu('Table5', CreateTableList($ReportID, 5), $myrow['table5']); ?></td>
      <td><?php echo html_input_field('Table5Criteria', $myrow['table5criteria'], 'size="76" maxlength="75" onblur="submitToDo(\'update\')"'); ?><td>
    </tr>
    <tr>
      <td><?php echo TEXT_TABLE6; ?></td>
      <td><?php if ($myrow['table5']) echo html_pull_down_menu('Table6', CreateTableList($ReportID, 6), $myrow['table6']); ?></td>
      <td><?php echo html_input_field('Table6Criteria', $myrow['table6criteria'], 'size="76" maxlength="75" onblur="submitToDo(\'update\')"'); ?><td>
    </tr>
	<tr>
	  <td colspan="3"><?php echo RW_RPT_DB_LINK_HELP; ?></td>
	</tr>
  </table>
</form>