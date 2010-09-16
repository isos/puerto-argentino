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
//  Path: /modules/reportwriter/pages/builder/template_field_setup.php
//

  echo html_form('RptFieldForm', FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=step6');
  echo html_hidden_field('ReportID',   $ReportID);
  echo html_hidden_field('Type',       $Type); 
  echo html_hidden_field('ReportName', $description);
  echo html_hidden_field('todo',       '');
  echo html_hidden_field('rowSeq',     '');
  // customize the toolbar actions
  $toolbar->icon_list['cancel']['show'] = false;
  $toolbar->icon_list['open']['show']   = false;
  $toolbar->icon_list['save']['params'] = 'onclick="submitToDo(\'update\');"';
  $toolbar->icon_list['print']['show']  = false;
  $toolbar->icon_list['delete']['show'] = false;
  $toolbar->add_icon('back',     'onclick="submitToDo(\'back\')"',     $order = 9);
  $toolbar->add_icon('continue', 'onclick="submitToDo(\'continue\')"', $order = 10);
  $toolbar->add_help('11.01.01');
  echo $toolbar->build_toolbar(); 
?>
<h2 align="center"><?php echo $FormParams['heading'] . stripslashes($description) . ' - ' . TEXT_FIELD_SETUP; ?></h2>
  <table id="tableFieldSetup" align="center"  border="1" cellspacing="1" cellpadding="1">
    <tr>
      <th colspan="20"><?php echo RW_RPT_ENTRFLD; ?></th>
    </tr>
    <tr>
      <th><?php echo TEXT_ORDER; ?></th>
      <?php if ($Type <> 'frm') echo '<th>' . RW_RPT_TBLFNAME . '</th>'; ?>
      <th><?php echo RW_RPT_DISPNAME; ?></th>
      <?php if ($Type <> 'frm') echo '<th>' . TEXT_COLUMN . '<br />' . TEXT_BREAK . '</th>'; ?>
      <?php if ($Type <> 'frm') echo '<th>' . TEXT_COLUMN . '<br />' . TEXT_WIDTH . '</th>'; ?>
      <?php if ($Type <> 'frm') echo '<th>' . TEXT_TOTAL . '<br />' . TEXT_WIDTH . '</th>'; ?>
      <th><?php echo TEXT_SHOW . '<br />' . TEXT_FIELD; ?></th>
      <?php if ($Type <> 'frm') echo '<th>' . RW_RPT_TEXTPROC . '</th>'; ?>
      <th><?php echo ($Type=='frm') ? TEXT_TYPE : (TEXT_TOTAL . '<br />' . TEXT_COLUMN); ?></th>
      <?php if ($Type <> 'frm') echo '<th>' . TEXT_ALIGN . '</th>'; ?>
      <th>&nbsp;</th>
    </tr>
    <tr>
	  <td align="center">
		<?php if ($FieldListings['defaults']['buttonvalue'] == TEXT_ADD) { 
		  echo html_input_field('SeqNum', $FieldListings['defaults']['seqnum'], 'size="4" maxlength="3"');
		} else { 
		  echo html_hidden_field('SeqNum', $FieldListings['defaults']['seqnum']) . $FieldListings['defaults']['seqnum']; 
		} // end if ?>
	  </td>
	  <?php if ($Type <> 'frm') echo '<td>' . html_combo_box('FieldName', CreateSpecialDropDown($ReportID), $FieldListings['defaults']['fieldname']) . '</td>'; ?>
      <td><?php echo html_input_field('DisplayDesc', $FieldListings['defaults']['displaydesc'], 'size="20" maxlength="25"'); ?></td>
      <?php if ($Type <> 'frm') {
	    echo '<td align="center">' . html_checkbox_field('ColumnBreak', '1', ($FieldListings['defaults']['columnbreak'] == '1') ? true : false) . '</td>';
		echo '<td align="center">' . html_input_field('ColumnWidth', ($Params['columnwidth'] ? $Params['columnwidth'] : RW_DEFAULT_COLUMN_WIDTH), 'size="4" maxlength="3"') . '</td>';
		echo '<td align="center">&nbsp;</td>';
	  } ?>
      <td align="center"><?php echo html_checkbox_field('Visible', '1', ($FieldListings['defaults']['visible'] == '1') ? true : false); ?></td>
      <?php if ($Type <> 'frm') echo '<td>' . html_pull_down_menu('Processing', gen_build_pull_down($FormProcessing), $Params['processing']) . '</td>'; ?>
      <td>
	    <?php if ($Type == 'frm') {
		  if ($FieldListings['defaults']['buttonvalue'] == TEXT_NEW || $FieldListings['defaults']['buttonvalue'] == TEXT_ADD) {
		    echo html_pull_down_menu('Params', gen_build_pull_down($FormEntries), $Params['index']);
		  } else {
		    echo $FormEntries[$Params['index']] . html_hidden_field('Params', $Params['index']);
		  }
	    } else {
		  echo html_pull_down_menu('Params', gen_build_pull_down($TotalLevels), $Params['index']);
	    } ?>
      </td>
	  <?php if ($Type <> 'frm') echo '<td>' . html_pull_down_menu('Align', gen_build_pull_down($FontAlign), $Params['align']) . '</td>'; ?>
      <td align = "center">
	    <?php if ($FieldListings['defaults']['buttonvalue'] == TEXT_ADD) {
		  echo html_icon('actions/list-add.png', TEXT_ADD, 'medium', 'onclick="submitToDo(\'add\')"');
		} else {
		  echo html_icon('actions/view-refresh.png', TEXT_CHANGE, 'medium', 'onclick="submitToDo(\'change\')"');
		} ?>
	  </td>
    </tr>
    <tr><th id="fieldListHeading" colspan="20"><?php echo RW_RPT_FLDLIST; ?></th></tr>
	<?php if (!$FieldListings['lists']) {
		echo '<tr><td align="center" colspan="20">' . RW_RPT_NOFIELD . '</td></tr>';
	} else { 
	  foreach ($FieldListings['lists'] as $FieldDetails) { 
	    $Params = $FieldDetails['params']; ?>
		<tr>
		  <td align = "center"><?php echo $FieldDetails['seqnum']; ?></td>
		  <?php if ($Type <> 'frm') echo '<td>' . $FieldDetails['fieldname'] . '</td>' ?>
		  <td><?php echo $FieldDetails['displaydesc']; ?></td>
		  <?php if ($Type <> 'frm') {
		  	echo '<td align="center">' . html_checkbox_field('brk_' . $FieldDetails['seqnum'], '1', (($FieldDetails['columnbreak'] == '1') ? true : false), '', 'disabled="disabled"') . '</td>';
		  	echo '<td id="width_' . ($FieldDetails['seqnum'] - 1) . '" align="center">' . ($Params['columnwidth'] ? $Params['columnwidth'] : RW_DEFAULT_COLUMN_WIDTH) . '</td>';
			echo '<td id="total_' . ($FieldDetails['seqnum'] - 1) . '" align="center">&nbsp;</td>';
		  } 
		  echo '<td align="center">' . html_checkbox_field('vis_' . $FieldDetails['seqnum'], '1', (($FieldDetails['visible'] == '1') ? true : false), '', 'disabled="disabled"') . '</td>';
		  if ($Type <> 'frm') echo '<td>' . $FormProcessing[$Params['processing']] . '&nbsp;</td>' ?>
		  <td><?php echo ($Type == 'frm') ? $FormEntries[$Params['index']] : $TotalLevels[$Params['index']]; ?>&nbsp;</td>
		  <?php if ($Type <> 'frm') echo '<td>' . $FontAlign[$Params['align']] . '&nbsp;</td>' ?>
		  <td nowrap="nowrap">
		    <?php 
			  echo html_icon('actions/go-up.png', TEXT_UP, 'small', 'onclick="submitSeq(' . $FieldDetails['seqnum'] . ', \'up\')"'); 
			  echo html_icon('actions/go-down.png', TEXT_DOWN, 'small', 'onclick="submitSeq(' . $FieldDetails['seqnum'] . ', \'down\')"'); 
			  echo html_icon('actions/edit-find-replace.png', TEXT_EDIT, 'small', 'onclick="submitSeq(' . $FieldDetails['seqnum'] . ', \'edit\')"'); 
			  echo html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . TEXT_DELETE_ENTRY . '\')) submitSeq(' . $FieldDetails['seqnum'] . ', \'delete\')"'); 
			  if ($Type == 'frm') echo html_icon('actions/document-properties.png', TEXT_PROPERTIES, 'small', 'onclick="submitSeq(' . $FieldDetails['seqnum'] . ', \'properties\')"'); 
			?>
		  </td>
		</tr>
	  <?php } // end foreach 
      if ($Type <> 'frm') echo '<tr><td colspan="20">' . RW_RPT_FIELD_HELP . '</td></tr>';
    } // end else ?>
  </table>
</form>