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
//  Path: /modules/reportwriter/pages/builder/template_id.php
//

  echo html_form('reportidform', FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=step3') . chr(10);
  echo html_hidden_field('ReportID',        $ReportID) . chr(10);
  echo html_hidden_field('ReplaceReportID', $ReplaceReportID) . chr(10);
  echo html_hidden_field('Type',            $Type) . chr(10);
  echo html_hidden_field('todo',            '') . chr(10);
  // customize the toolbar actions
  $toolbar->icon_list['cancel']['params'] = 'onclick="self.close();"';
  $toolbar->icon_list['open']['show']     = false;
  $toolbar->icon_list['save']['params']   = 'onclick="submitToDo(\'update\');"';
  $toolbar->icon_list['print']['show']    = false;
  $toolbar->icon_list['delete']['show']   = false;
  if (isset($_POST['ReportName']) && $todo <> 'rename') {
    $toolbar->add_icon('replace', 'onclick="if confirm(\'' . RW_RPT_REPOVER . '\') submitToDo(\'rename\')"', $order = 10);
  }
  if ($todo == 'rename') {
    $toolbar->add_icon('rename',   'onclick="submitToDo(\'rename\')"',   $order = 10);
  } else {
    $toolbar->add_icon('continue', 'onclick="submitToDo(\'continue\')"', $order = 10);
  }
  $toolbar->add_help('11.01.01');
  echo $toolbar->build_toolbar(); 
?>
<h2 align="center"><?php echo $FormParams['heading']; ?></h2>
  <table align="center"  border="1" cellspacing="1" cellpadding="1">
   <tr>
     <td><?php if ($Type == 'frm') echo RW_FRM_RPTENTER; else echo RW_RPT_RPTENTER; ?></td>
     <td><?php echo html_input_field('ReportName', (isset($_POST['ReportName'])) ? $_POST['ReportName'] : '') . RW_RPT_MAX30; ?></td>
   </tr>
   <?php if (!$ReportID) { ?>
	   <tr>
		 <th colspan="2"><?php echo RW_RPT_TYPECREATE; ?></th>
	   </tr>
	   <tr>
		 <td><?php echo html_radio_field('NewType', 'rpt') . TEXT_REPORT . ' ====&gt; ' . RW_RPT_RPTGRP; ?></td>
		 <td><?php echo html_pull_down_menu('GroupName', gen_build_pull_down($ReportGroups)); ?></td>
	   </tr>
	   <tr>
		 <th colspan="2">&nbsp;</th>
	   </tr>
	   <tr>
		 <td><?php echo html_radio_field('NewType', 'frm') . TEXT_FORM . ' ====&gt; ' . RW_FRM_RPTGRP; ?></td>
		 <td><?php echo html_pull_down_menu('FormGroup', gen_build_pull_down($FormGroups)); ?></td>
	   </tr>
   <?php } // end if ?>
  </table>
</form>
