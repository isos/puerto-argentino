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
//  Path: /modules/reportwriter/pages/builder/template_TplFrmData.php
//

  $kFontColors = gen_build_pull_down($FontColors);
  echo html_form('DataFrmLine', FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=step6a');
  echo html_hidden_field('DisplayName', $DisplayName);
  echo html_hidden_field('index', $Params['index']);
  echo html_hidden_field('ID', $FormParams['id']);
  echo html_hidden_field('SeqNum', $SeqNum);
  echo html_hidden_field('ReportID', $ReportID);
  echo html_hidden_field('ReportName', $description);
  echo html_hidden_field('todo', ''); 
//  echo html_hidden_field('rowSeq', '');
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
      <th colspan="2" align="center"><?php echo RW_RPT_TBLFNAME; ?></th>
    </tr>
    <tr>
      <td id="field_list" colspan="2" align="center">
	  	<?php echo html_combo_box('DataField', CreateSpecialDropDown($ReportID), $Params['DataField']); ?>
	  </td>
    </tr>
    <tr>
      <th colspan="2" align="center"><?php echo RW_RPT_STARTPOS; ?></th>
    </tr>
    <tr>
      <td align="center">
	    <?php echo TEXT_ABSCISSA . html_input_field('LineXStrt', (!$Params['LineXStrt']) ? '10' : $Params['LineXStrt'], 'size="4" maxlength="3"'); ?>
      </td>
      <td align="center">
	    <?php echo TEXT_ORDINATE . html_input_field('LineYStrt', (!$Params['LineYStrt']) ? '10' : $Params['LineYStrt'], 'size="4" maxlength="3"'); ?>
      </td>
    </tr>
    <tr>
	  <th colspan="2" align="center"><?php echo RW_RPT_BOXDIM; ?></th>
	</tr>
	<tr>
      <td align="center">
	    <?php echo TEXT_WIDTH . html_input_field('BoxWidth', (!$Params['BoxWidth']) ? '60' : $Params['BoxWidth'], 'size="4" maxlength="3"'); ?>
      </td>
      <td align="center">
	    <?php echo TEXT_HEIGHT . html_input_field('BoxHeight', (!$Params['BoxHeight']) ? '5' : $Params['BoxHeight'], 'size="4" maxlength="3"'); ?>
      </td>
	</tr>
	<tr>
      <th colspan="2"><?php echo RW_RPT_TEXTATTRIB; ?></th>
    </tr>
    <tr>
      <td><?php echo RW_RPT_TEXTPROC; ?></td>
      <td><?php echo html_pull_down_menu('Processing', gen_build_pull_down($FormProcessing), $Params['Processing']); ?></td>
    </tr>
	<tr>
      <td><?php echo TEXT_FONT; ?></td>
      <td><?php echo html_pull_down_menu('Font', gen_build_pull_down($Fonts), $Params['Font']); ?></td>
    </tr>
	<tr>
      <td><?php echo TEXT_SIZE; ?></td>
      <td><?php echo html_pull_down_menu('FontSize', gen_build_pull_down($FontSizes), $Params['FontSize']); ?></td>
    </tr>
	<tr>
      <td><?php echo TEXT_ALIGN; ?></td>
      <td><?php echo html_pull_down_menu('FontAlign', gen_build_pull_down($FontAlign), $Params['FontAlign']); ?></td>
    </tr>
	<tr>
      <td><?php echo TEXT_TRUNCATE; ?></td>
      <td>
	    <?php echo html_radio_field('Trunc', '0', (!$Params['Trunc']) ? true : false) . TEXT_NO; ?>
	    <?php echo html_radio_field('Trunc', '1', ($Params['Trunc'])  ? true : false) . TEXT_YES; ?>
	  </td>
    </tr>
	<tr>
      <td colspan="2"><?php echo RW_TEXT_DISPLAY_ON . ' '; ?>
	    <?php echo html_radio_field('LastOnly', '0', (!$Params['LastOnly'] || $Params['LastOnly'] == '0') ? true : false) . ' ' . RW_TEXT_ALL_PAGES; ?>
	    <?php echo html_radio_field('LastOnly', '1', ($Params['LastOnly'] == '1') ? true : false) . ' ' . RW_TEXT_FIRST_PAGE; ?>
	    <?php echo html_radio_field('LastOnly', '2', ($Params['LastOnly'] == '2') ? true : false) . ' ' . RW_TEXT_LAST_PAGE; ?>
	  </td>
    </tr>
	<tr>
      <td align="center">
	    <?php echo html_radio_field('Color', '1', ($Params['Color'] == '1' || $Params['Color'] == '') ? true : false) . TEXT_STDCOLOR . '<br />'; ?>
        <?php echo html_pull_down_menu('FontColor', $kFontColors, $Params['FontColor']); ?>
      </td>
      <td nowrap="nowrap" align="center">
	    <?php echo html_radio_field('Color', '2', ($Params['Color'] == '2') ? true : false) . TEXT_CUSTCOLOR . '<br />';
	    echo TEXT_RED . html_input_field('FontRed', $Params['FontRed'], 'size="4" maxlength="3"');
	    echo TEXT_GREEN . html_input_field('FontGreen', $Params['FontGreen'], 'size="4" maxlength="3"');
	    echo TEXT_BLUE . html_input_field('FontBlue', $Params['FontBlue'], 'size="4" maxlength="3"'); ?>
      </td>
    </tr>
    <tr>
      <th colspan="2"><?php echo RW_RPT_BRDRLINE; ?></th>
    </tr>
    <tr>
      <td><?php echo html_radio_field('Line', '0', ($Params['Line'] == '0' || $Params['Line'] == '') ? true : false) . RW_RPT_NOBRDR; ?></td>
      <td><?php echo RW_RPT_LINEWIDTH . html_pull_down_menu('LineSize', gen_build_pull_down($LineSizes), $Params['LineSize']); ?></td>
    </tr>
    <tr>
      <td align="center">
	    <?php echo html_radio_field('Line', '1', ($Params['Line'] == '1') ? true : false) . TEXT_STDCOLOR . '<br />'; ?>
        <?php echo html_pull_down_menu('BrdrColor', $kFontColors, $Params['BrdrColor']); ?>
	  </td>
      <td align="center">
	    <?php echo html_radio_field('Line', '2', ($Params['Line'] == '2') ? true : false) . TEXT_CUSTCOLOR . '<br />';
	    echo TEXT_RED . html_input_field('BrdrRed', $Params['BrdrRed'], 'size="4" maxlength="3"');
	    echo TEXT_GREEN . html_input_field('BrdrGreen', $Params['BrdrGreen'], 'size="4" maxlength="3"');
	    echo TEXT_BLUE . html_input_field('BrdrBlue', $Params['BrdrBlue'], 'size="4" maxlength="3"'); ?>
	  </td>
    </tr>
    <tr>
      <th colspan="2"><?php echo TEXT_FILL; ?></th>
    </tr>
    <tr>
      <td colspan="2"><?php echo html_radio_field('Fill', '0', ($Params['Fill'] == '0' || $Params['Fill'] == '') ? true : false) . RW_RPT_NOFILL; ?></td>
    </tr>
    <tr>
      <td align="center">
	    <?php echo html_radio_field('Fill', '1', ($Params['Fill'] == '1') ? true : false) . TEXT_STDCOLOR . '<br />'; ?>
        <?php echo html_pull_down_menu('FillColor', $kFontColors, $Params['FillColor']); ?>
	  </td>
      <td align="center">
	    <?php echo html_radio_field('Fill', '2', ($Params['Fill'] == '2') ? true : false) . TEXT_CUSTCOLOR . '<br />';
	    echo TEXT_RED . html_input_field('FillRed', $Params['FillRed'], 'size="4" maxlength="3"');
	    echo TEXT_GREEN . html_input_field('FillGreen', $Params['FillGreen'], 'size="4" maxlength="3"');
	    echo TEXT_BLUE . html_input_field('FillBlue', $Params['FillBlue'], 'size="4" maxlength="3"'); ?>
	  </td>
    </tr>
  </table>
</form>