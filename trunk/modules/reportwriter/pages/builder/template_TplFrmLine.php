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
//  Path: /modules/reportwriter/pages/builder/template_TplFrmLine.php
//

$kFontColors = gen_build_pull_down($FontColors);
echo html_form('FrmLine', FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=step6a');
echo html_hidden_field('DisplayName', $DisplayName);
echo html_hidden_field('index',       $Params['index']);
echo html_hidden_field('ID',          $FormParams['id']);
echo html_hidden_field('SeqNum',      $SeqNum);
echo html_hidden_field('ReportID',    $ReportID);
echo html_hidden_field('ReportName',  $description);
echo html_hidden_field('todo',        ''); 
// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="submitToDo(\'cancel\')"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['params']   = 'onclick="submitToDo(\'update\');"';
$toolbar->icon_list['print']['show']    = false;
$toolbar->icon_list['delete']['show']   = false;
$toolbar->add_icon('finish', 'onclick="submitToDo(\'finish\')"', $order = 10);
$toolbar->add_help('11.01.01');
echo $toolbar->build_toolbar(); 
?>
<h2 align="center"><?php echo TEXT_FORM_FIELD . $DisplayName . ' - ' . TEXT_PROPERTIES; ?></h2>
  <table align="center" border="2" cellspacing="1" cellpadding="1">
    <tr>
      <th colspan="2"><?php echo RW_RPT_STARTPOS; ?></th>
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
      <th colspan="2"><?php echo RW_RPT_ENDPOS; ?></th>
    </tr>
    <tr>
      <td><?php echo html_radio_field('LineType', '1', (!$Params['LineType'] || $Params['LineType'] == '1') ? true : false) . TEXT_HORIZONTAL; ?></td>
      <td><?php echo TEXT_LENGTH . html_input_field('HLength', $Params['HLength'], 'size="4" maxlength="3"'); ?></td>
    </tr>
    <tr>
	  <td><?php echo html_radio_field('LineType', '2', ($Params['LineType'] == '2') ? true : false) . TEXT_VERTICAL; ?></td>
      <td><?php echo TEXT_LENGTH . html_input_field('VLength', $Params['VLength'], 'size="4" maxlength="3"'); ?></td>
    </tr>
    <tr>
	  <td><?php echo html_radio_field('LineType', '3', ($Params['LineType'] == '3') ? true : false) . TEXT_CUSTOM; ?></td>
      <td>
	  	<?php echo TEXT_ABSCISSA . html_input_field('LineXEnd', $Params['LineXEnd'], 'size="4" maxlength="3"'); ?> 
		<?php echo '&nbsp;' . TEXT_ORDINATE . html_input_field('LineYEnd', $Params['LineYEnd'], 'size="4" maxlength="3"'); ?> 
	  </td>
    </tr>
    <tr>
      <th colspan="2"><?php echo RW_RPT_LINEATTRIB; ?></th>
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
      <td><?php echo RW_RPT_LINEWIDTH; ?></td>
      <td><?php echo html_pull_down_menu('LineSize', gen_build_pull_down($LineSizes), $Params['LineSize']); ?></td>
    </tr>
  </table>
</form>