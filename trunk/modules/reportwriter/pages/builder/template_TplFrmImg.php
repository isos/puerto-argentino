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
//  Path: /modules/reportwriter/pages/builder/template_TplFrmImg.php
//

  $kFontColors = gen_build_pull_down($FontColors);
  echo html_form('FrmImage', FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=step6a', 'post', 'enctype="multipart/form-data"');
  echo html_hidden_field('DisplayName', $DisplayName);
  echo html_hidden_field('index',       $Params['index']);
  echo html_hidden_field('ID',          $FormParams['id']);
  echo html_hidden_field('SeqNum',      $SeqNum);
  echo html_hidden_field('ReportID',    $ReportID);
  echo html_hidden_field('ReportName',  $description);
  echo html_hidden_field('todo', ''); 
//  echo html_hidden_field('rowSeq', '');
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
      <td><?php echo RW_RPT_IMAGECUR; ?></td>
      <td align="center">
	  	<?php if ($Params['filename']) {
          echo '<img src="' . DIR_WS_ADMIN . 'my_files/' . $_SESSION['company'] . '/images/' . $Params['filename'] . '" height="32" border="0">';
          } else echo 'No Image Selected!'; ?>
      </td>
    </tr>
    <tr>
      <th colspan="2"><?php echo RW_RPT_IMAGESEL; ?></th>
    </tr>
	<tr>
	  <td><?php echo html_radio_field('ImgChoice', 'Upload') . RW_RPT_IMAGEUPLOAD; ?></td>
	  <td><input type="file" name="imagefile"></td>
    </tr>
	<tr>
	  <td><?php echo html_radio_field('ImgChoice', 'Select', true) . RW_RPT_IMAGESTORED; ?></td>
	  <td><?php echo html_pull_down_menu('ImgFileName', ReadImages(), $Params['filename'], 'size="6"'); ?></td>
    </tr>
    <tr>
      <th colspan="2"><?php echo RW_RPT_STARTPOS; ?></th>
    </tr>
    <tr>
      <td width="50%" align="center">
	    <?php echo TEXT_ABSCISSA . html_input_field('LineXStrt', (!$Params['LineXStrt']) ? '10' : $Params['LineXStrt'], 'size="4" maxlength="3"'); ?>
      </td>
      <td width="50%" align="center">
	    <?php echo TEXT_ORDINATE . html_input_field('LineYStrt', (!$Params['LineYStrt']) ? '10' : $Params['LineYStrt'], 'size="4" maxlength="3"'); ?>
      </td>
    </tr>
    <tr>
      <th colspan="2"><?php echo RW_RPT_IMAGEDIM; ?></th>
    </tr>
    <tr>
      <td align="center">
	    <?php echo TEXT_WIDTH . html_input_field('BoxWidth', (!$Params['BoxWidth']) ? '' : $Params['BoxWidth'], 'size="4" maxlength="3"'); ?>
      </td>
      <td align="center">
	    <?php echo TEXT_HEIGHT . html_input_field('BoxHeight', (!$Params['BoxHeight']) ? '' : $Params['BoxHeight'], 'size="4" maxlength="3"'); ?>
      </td>
    </tr>
  </table>
</form>