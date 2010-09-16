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
//  Path: /modules/reportwriter/pages/builder/template_TplFrmTbl.php
//

  $kFontColors = gen_build_pull_down($FontColors);
  // add a new field to auto align with data in the table
  $tempAlign = $FontAlign;
  $tempAlign['A'] = TEXT_AUTO_ALIGN;

  echo html_form('FrmTable', FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=step6a');
  echo html_hidden_field('DisplayName', $DisplayName);
  echo html_hidden_field('index', $Params['index']);
  echo html_hidden_field('ID', $FormParams['id']);
  echo html_hidden_field('SeqNum', $SeqNum);
  echo html_hidden_field('ReportID', $ReportID);
  echo html_hidden_field('ReportName', $description);
  echo html_hidden_field('todo', ''); 
  echo html_hidden_field('rowSeq', '');
  // customize the toolbar actions
  $toolbar->icon_list['cancel']['params'] = 'onclick="submitToDo(\'cancel\')"';
  $toolbar->icon_list['open']['show'] = false;
  $toolbar->icon_list['save']['params'] = 'onclick="submitToDo(\'update\');"';
  $toolbar->icon_list['print']['show'] = false;
  $toolbar->icon_list['delete']['show'] = false;
  $toolbar->add_icon('finish', 'onclick="submitToDo(\'finish\')"', $order = 10);
  $toolbar->add_help('11.01.01');
  echo $toolbar->build_toolbar(); 
?>
<h2 align="center"><?php echo TEXT_FORM_FIELD . $DisplayName . ' - ' . TEXT_PROPERTIES; ?></h2>
  <table align="center" border="2" cellspacing="1" cellpadding="1">
    <tr>
      <th colspan="2"><?php echo RW_RPT_STARTPOS; ?></th>
      <th colspan="2"><?php echo RW_RPT_BOXDIM; ?></th>
    </tr>
    <tr>
      <td width="25%" align="center">
	    <?php echo TEXT_ABSCISSA . html_input_field('LineXStrt', (!$Params['LineXStrt']) ? '10' : $Params['LineXStrt'], 'size="4" maxlength="3"'); ?>
      </td>
      <td width="25%" align="center">
	    <?php echo TEXT_ORDINATE . html_input_field('LineYStrt', (!$Params['LineYStrt']) ? '10' : $Params['LineYStrt'], 'size="4" maxlength="3"'); ?>
      </td>
      <td width="25%" align="center">
	    <?php echo TEXT_WIDTH . html_input_field('BoxWidth', (!$Params['BoxWidth']) ? '60' : $Params['BoxWidth'], 'size="4" maxlength="3"'); ?>
      </td>
      <td width="25%" align="center">
	    <?php echo TEXT_HEIGHT . html_input_field('BoxHeight', (!$Params['BoxHeight']) ? '5' : $Params['BoxHeight'], 'size="4" maxlength="3"'); ?>
      </td>
    </tr>
    <tr>
      <th colspan="4"><?php echo RW_RPT_TABLE_HEADING_PROP; ?></th>
    </tr>
    <tr>
      <td align="center"><?php echo TEXT_FONT  . ' ' . html_pull_down_menu('hFont', gen_build_pull_down($Fonts), $Params['hFont']); ?></td>
      <td align="center"><?php echo TEXT_SIZE  . ' ' . html_pull_down_menu('hFontSize', gen_build_pull_down($FontSizes), $Params['hFontSize']); ?></td>
      <td align="center"><?php echo TEXT_ALIGN . ' ' . html_pull_down_menu('hFontAlign', gen_build_pull_down($tempAlign), $Params['hFontAlign']); ?></td>
      <td align="center"><?php echo TEXT_COLOR . ' ' . html_pull_down_menu('hFontColor', $kFontColors, $Params['hFontColor']); ?></td>
    </tr>
    <tr>
      <td colspan="2">
        <?php echo html_radio_field('hLine', '0', ($Params['hLine'] == '0' || $Params['hLine'] == '') ? true : false) . RW_RPT_NOBRDR . '<br />';
	    echo html_radio_field('hLine', '1', ($Params['hLine'] == '1') ? true : false) . TEXT_STDCOLOR . ' ';
        echo html_pull_down_menu('hBrdrColor', $kFontColors, $Params['hBrdrColor']);
        echo RW_RPT_LINEWIDTH . html_pull_down_menu('hLineSize', gen_build_pull_down($LineSizes), $Params['hLineSize']) . '<br />';
	    echo html_radio_field('hLine', '2', ($Params['hLine'] == '2') ? true : false) . TEXT_CUSTCOLOR;
	    echo TEXT_RED .   html_input_field('hBrdrRed',   $Params['hBrdrRed'],   'size="4" maxlength="3"');
	    echo TEXT_GREEN . html_input_field('hBrdrGreen', $Params['hBrdrGreen'], 'size="4" maxlength="3"');
	    echo TEXT_BLUE .  html_input_field('hBrdrBlue',  $Params['hBrdrBlue'],  'size="4" maxlength="3"'); ?>
	  </td>
      <td colspan="2">
        <?php echo html_radio_field('hFill', '0', ($Params['hFill'] == '0' || $Params['hFill'] == '') ? true : false) . RW_RPT_NOFILL . '<br />';
	    echo html_radio_field('hFill', '1', ($Params['hFill'] == '1') ? true : false) . TEXT_STDCOLOR . ' ';
        echo html_pull_down_menu('hFillColor', $kFontColors, $Params['hFillColor']) . '<br />';
	    echo html_radio_field('hFill', '2', ($Params['hFill'] == '2') ? true : false) . TEXT_CUSTCOLOR;
	    echo TEXT_RED .   html_input_field('hFillRed',   $Params['hFillRed'],   'size="4" maxlength="3"');
	    echo TEXT_GREEN . html_input_field('hFillGreen', $Params['hFillGreen'], 'size="4" maxlength="3"');
	    echo TEXT_BLUE .  html_input_field('hFillBlue',  $Params['hFillBlue'],  'size="4" maxlength="3"'); ?>
	  </td>
    </tr>
    <tr>
      <th colspan="4"><?php echo RW_RPT_TABLE_BODY_PROP; ?></th>
    </tr>
    <tr>
      <td colspan="2">
        <?php echo html_radio_field('Line', '0', ($Params['Line'] == '0' || $Params['Line'] == '') ? true : false) . RW_RPT_NOBRDR . '<br />';
	    echo html_radio_field('Line', '1', ($Params['Line'] == '1') ? true : false) . TEXT_STDCOLOR . ' ';
        echo html_pull_down_menu('BrdrColor', $kFontColors, $Params['BrdrColor']);
        echo RW_RPT_LINEWIDTH . html_pull_down_menu('LineSize', gen_build_pull_down($LineSizes), $Params['LineSize']) . '<br />';
	    echo html_radio_field('hLine', '2', ($Params['hLine'] == '2') ? true : false) . TEXT_CUSTCOLOR;
	    echo TEXT_RED .   html_input_field('BrdrRed',   $Params['BrdrRed'],   'size="4" maxlength="3"');
	    echo TEXT_GREEN . html_input_field('BrdrGreen', $Params['BrdrGreen'], 'size="4" maxlength="3"');
	    echo TEXT_BLUE .  html_input_field('BrdrBlue',  $Params['BrdrBlue'],  'size="4" maxlength="3"'); ?>
	  </td>
      <td colspan="2">
        <?php echo html_radio_field('Fill', '0', ($Params['Fill'] == '0' || $Params['Fill'] == '') ? true : false) . RW_RPT_NOFILL . '<br />';
	    echo html_radio_field('Fill', '1', ($Params['Fill'] == '1') ? true : false) . TEXT_STDCOLOR . ' ';
        echo html_pull_down_menu('FillColor', $kFontColors, $Params['FillColor']) . '<br />';
	    echo html_radio_field('Fill', '2', ($Params['hFill'] == '2') ? true : false) . TEXT_CUSTCOLOR;
	    echo TEXT_RED .   html_input_field('FillRed',   $Params['FillRed'],   'size="4" maxlength="3"');
	    echo TEXT_GREEN . html_input_field('FillGreen', $Params['FillGreen'], 'size="4" maxlength="3"');
	    echo TEXT_BLUE .  html_input_field('FillBlue',  $Params['FillBlue'],  'size="4" maxlength="3"'); ?>
	  </td>
    </tr>
</table>
<table align="center" border="2" cellspacing="1" cellpadding="1">
    <tr>
      <th colspan="8"><?php echo TEXT_FIELDS; ?></th>
    </tr>
    <tr>
      <td align="center"><?php echo TEXT_SEQ; ?></td>
      <td colspan="2" align="center"><?php echo RW_RPT_TBLFNAME; ?></td>
      <td colspan="2" align="center"><?php echo RW_RPT_DISPNAME; ?></td>
      <td colspan="2" align="center"><?php echo RW_RPT_TEXTPROC; ?></td>
      <td rowspan="4" align="center">
	    <?php if ($ButtonValue == TEXT_ADD) {
		  echo html_icon('actions/list-add.png', TEXT_ADD, 'medium', 'onclick="submitToDo(\'add\')"');
		} else {
		  echo html_icon('actions/view-refresh.png', TEXT_CHANGE, 'medium', 'onclick="submitToDo(\'change\')"');
		} ?>
	  </td>
    </tr>
    <tr>
      <td rowspan="3" align="center">
		  <?php if ($ButtonValue == TEXT_CHANGE) { 
		    echo html_hidden_field('TblSeqNum', $Params['TblSeqNum']) . $Params['TblSeqNum'];
		  } else { 
		  	echo html_input_field('TblSeqNum', $Params['TblSeqNum'], 'size="3" maxlength="2"');
		  } ?>
	  </td>
      <td id="field_list" colspan="2"><?php echo html_combo_box('TblField', $TblFieldChoices, $Params['TblField']); ?></td>
      <td colspan="2"><?php echo html_input_field('TblDesc', $Params['TblDesc'], ''); ?></td>
      <td colspan="2"><?php echo html_pull_down_menu('Processing', gen_build_pull_down($FormProcessing), $Params['Processing']); ?></td>
    </tr>
    <tr>
      <td align="center"><?php echo TEXT_FONT; ?></td>
      <td align="center"><?php echo TEXT_SIZE; ?></td>
      <td align="center"><?php echo TEXT_ALIGN; ?></td>
      <td align="center"><?php echo TEXT_COLOR; ?></td>
      <td align="center"><?php echo TEXT_WIDTH; ?></td>
      <td align="center"><?php echo TEXT_SHOW; ?></td>
    </tr>
    <tr>
      <td align="center"><?php echo html_pull_down_menu('Font', gen_build_pull_down($Fonts), $Params['Font']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('FontSize', gen_build_pull_down($FontSizes), $Params['FontSize']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('FontAlign', gen_build_pull_down($FontAlign), $Params['FontAlign']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('FontColor', $kFontColors, $Params['FontColor']); ?></td>
      <td align="center"><?php echo html_input_field('TblColWidth', (!$Params['TblColWidth']) ? '20' : $Params['TblColWidth'], 'size="4" maxlength="3"'); ?></td>
      <td align="center"><?php echo html_checkbox_field('TblShow', '1', ($Params['TblShow'] == '1' || $Params['TblShow'] == '') ? true : false); ?></td>
    </tr>
    <tr>
      <th colspan="8"><?php echo RW_RPT_FLDLIST; ?></th>
    </tr>
	<?php if (is_array($Params['Seq'])) {
		while ($myrow = array_shift($Params['Seq'])) {
			echo '<tr><td align="center">' . $myrow['TblSeqNum'] . '</td>';
			echo '<td align="center" colspan="2">' . $myrow['TblField'] . '</td>';
			echo'<td align="center" colspan="2">' . $myrow['TblDesc'] . '</td>';
			echo '<td align="center" colspan="2">' . $FormProcessing[$myrow['Processing']] . '</td>';
			echo '<td>';
			echo html_icon('actions/go-up.png', TEXT_UP, 'small', 'onclick="submitSeq(' . $myrow['TblSeqNum'] . ', \'up\')"'); 
			echo html_icon('actions/go-down.png', TEXT_DOWN, 'small', 'onclick="submitSeq(' . $myrow['TblSeqNum'] . ', \'down\')"'); 
			echo html_icon('actions/edit-find-replace.png', TEXT_EDIT, 'small', 'onclick="submitSeq(' . $myrow['TblSeqNum'] . ', \'edit\')"'); 
			echo html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . TEXT_DELETE_ENTRY . '\')) submitSeq(' . $myrow['TblSeqNum'] . ', \'delete\')"'); 
			echo '</td></tr>';
		}
	} else {
		echo '<tr><td align="center" colspan="8">' . RW_RPT_NOROWS . '</td></tr>';
	}?>
    <tr>
      <th colspan="8"><?php echo 'Note: Changing the special table selection choice will erase the table field list!<br />The table column properties will need to be regenerated! '; ?></th>
    </tr>
  </table>
</form>