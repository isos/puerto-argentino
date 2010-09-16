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
//  Path: /modules/reportwriter/pages/builder/template_page_setup.php
//

  $kFonts      = gen_build_pull_down($Fonts);
  $kFontSizes  = gen_build_pull_down($FontSizes);
  $kFontColors = gen_build_pull_down($FontColors);
  $kFontAlign  = gen_build_pull_down($FontAlign);
  // initialize the fields to display
  $show = array();
  switch($Type) {
	default:
    case 'rpt':
	  $show['layout'] = true;
	  $show['header'] = true;
	  $show['serial'] = false;
	  break;
    case 'frm':
	  $show['layout'] = true;
	  $show['header'] = false;
	  $show['serial'] = true;
	  break;
  }

  echo html_form('RptPageSetup', FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=step4');
  echo html_hidden_field('ReportID',   $ReportID);
  echo html_hidden_field('Type',       $Type); 
  echo html_hidden_field('ReportName', $myrow['description']); 
  echo html_hidden_field('todo',       ''); 
  // customize the toolbar actions
  $toolbar->icon_list['cancel']['params'] = 'onclick="self.close();"';
  $toolbar->icon_list['open']['show']     = false;
  $toolbar->icon_list['save']['params']   = 'onclick="submitToDo(\'update\');"';
  $toolbar->icon_list['print']['show']    = false;
  $toolbar->icon_list['delete']['show']   = false;
  $toolbar->add_icon('continue', 'onclick="submitToDo(\'continue\')"', $order = 10);
  $toolbar->add_help('11.01.01');
  echo $toolbar->build_toolbar(); 
?>
<h2 align="center"><?php echo $FormParams['heading'] . stripslashes($myrow['description']) . ' - ' . TEXT_PAGE_SETUP; ?></h2>
  <table align="center" border="2" cellspacing="1" cellpadding="1">
    <tr>
      <th colspan="8"><?php echo RW_NARRATIVE_DETAIL; ?></th>
    </tr>
    <tr>
      <td colspan="8" width="100%"><?php echo html_textarea_field('narrative', 80, 3, $myrow['narrative'], ''); ?></td>
    </tr>
    <tr>
      <th colspan="8"><?php echo RW_EMAIL_MSG_DETAIL; ?></th>
    </tr>
    <tr>
      <td colspan="8" width="100%"><?php echo html_textarea_field('email_msg', 80, 3, $myrow['email_msg'], ''); ?></td>
    </tr>
<?php if ($show['layout']) { ?>
<?php if ($show['serial']) { ?>
    <tr>
      <td colspan="1" align="center"><?php echo html_checkbox_field('serialform', '1', $myrow['serialform'] ? true : false, '', ''); ?></td>
      <td colspan="7"><?php echo RW_SERIAL_FORM; ?></td>
    </tr>
<?php } // end $show['serial'] ?>
    <tr>
      <th colspan="8"><?php echo RW_RPT_PGLAYOUT; ?></th>
    </tr>
    <tr>
      <td colspan="4" width="50%" align="center">
        <?php echo TEXT_PAPER . ' ' . html_pull_down_menu('papersize', gen_build_pull_down($PaperSizes), $myrow['papersize']); ?>
      </td>
      <td colspan="4" width="50%" align="center">
	  	<?php echo TEXT_ORIEN . ' ' . html_radio_field('paperorientation', 'P', ($myrow['paperorientation'] == 'P') ? true : false) . ' ' . TEXT_PORTRAIT; ?>
	  	<?php echo ' ' . html_radio_field('paperorientation', 'L', ($myrow['paperorientation'] == 'L') ? true : false) . '  ' . TEXT_LANDSCAPE; ?>
	  </td>
    </tr>
    <tr>
      <th colspan="8"><?php echo RW_RPT_PGMARGIN; ?></th>
    </tr>
    <tr>
      <td colspan="2" width="25%" align="center"><?php echo TEXT_TOP .    ' ' . html_input_field('margintop',    $myrow['margintop'], 'size="5" maxlength="3"') . ' ' . TEXT_MM; ?></td>
      <td colspan="2" width="25%" align="center"><?php echo TEXT_BOTTOM . ' ' . html_input_field('marginbottom', $myrow['marginbottom'], 'size="5" maxlength="3"') . ' ' . TEXT_MM; ?></td>
      <td colspan="2" width="25%" align="center"><?php echo TEXT_LEFT .   ' ' . html_input_field('marginleft',   $myrow['marginleft'], 'size="5" maxlength="3"') . ' ' . TEXT_MM; ?></td>
      <td colspan="2" width="25%" align="center"><?php echo TEXT_RIGHT .  ' ' . html_input_field('marginright',  $myrow['marginright'], 'size="5" maxlength="3"') . ' ' . TEXT_MM; ?></td>
    </tr>
<?php } // end $show['layout'] ?>
<?php if ($show['header']) { ?>
    <tr>
	  <th colspan="8"><?php echo RW_RPT_PGHEADER; ?></th>
	</tr>
    <tr>
      <td colspan="3">&nbsp;</td>
      <td width="13%" align="center"><?php echo TEXT_SHOW; ?></td>
      <td width="12%" align="center"><?php echo TEXT_FONT; ?></td>
      <td width="13%" align="center"><?php echo TEXT_SIZE; ?></td>
      <td width="12%" align="center"><?php echo TEXT_COLOR; ?></td>
      <td width="13%" align="center"><?php echo TEXT_ALIGN; ?></td>
    </tr>
    <tr>
      <td colspan="3"><?php echo TEXT_PGCOYNM; ?></td>
	  <td align="center"><?php echo html_checkbox_field('coynameshow', '1', ($myrow['coynameshow'] == '1') ? true : false); ?></td>
      <td align="center"><?php echo html_pull_down_menu('coynamefont', $kFonts, $myrow['coynamefont']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('coynamefontsize', $kFontSizes, $myrow['coynamefontsize']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('coynamefontcolor', $kFontColors, $myrow['coynamefontcolor']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('coynamealign', $kFontAlign, $myrow['coynamealign']); ?></td>
    </tr>
    <tr>
      <td nowrap="nowrap" colspan="3"><?php echo RW_RPT_PGTITL1 . ' ' . html_input_field('title1desc', $myrow['title1desc'], 'size="30" maxlength="50"'); ?></td>
	  <td align="center"><?php echo html_checkbox_field('title1show', '1', ($myrow['title1show'] == '1') ? true : false); ?></td>
      <td align="center"><?php echo html_pull_down_menu('title1font', $kFonts, $myrow['title1font']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('title1fontsize', $kFontSizes, $myrow['title1fontsize']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('title1fontcolor', $kFontColors, $myrow['title1fontcolor']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('title1fontalign', $kFontAlign, $myrow['title1fontalign']); ?></td>
    </tr>
    <tr>
      <td nowrap="nowrap" colspan="3"><?php echo RW_RPT_PGTITL2 . ' ' . html_input_field('title2desc', $myrow['title2desc'], 'size="30" maxlength="50"'); ?></td>
	  <td align="center"><?php echo html_checkbox_field('title2show', '1', ($myrow['title2show'] == '1') ? true : false); ?></td>
      <td align="center"><?php echo html_pull_down_menu('title2font', $kFonts, $myrow['title2font']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('title2fontsize', $kFontSizes, $myrow['title2fontsize']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('title2fontcolor', $kFontColors, $myrow['title2fontcolor']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('title2fontalign', $kFontAlign, $myrow['title2fontalign']); ?></td>
    </tr>
    <tr>
      <td colspan="4"><?php echo RW_RPT_PGFILDESC; ?></td>
      <td align="center"><?php echo html_pull_down_menu('filterfont', $kFonts, $myrow['filterfont']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('filterfontsize', $kFontSizes, $myrow['filterfontsize']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('filterfontcolor', $kFontColors, $myrow['filterfontcolor']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('filterfontalign', $kFontAlign, $myrow['filterfontalign']); ?></td>
    </tr>
    <tr>
      <td colspan="4"><?php echo RW_RPT_RPTDATA; ?></td>
      <td align="center"><?php echo html_pull_down_menu('datafont', $kFonts, $myrow['datafont']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('datafontsize', $kFontSizes, $myrow['datafontsize']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('datafontcolor', $kFontColors, $myrow['datafontcolor']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('datafontalign', $kFontAlign, $myrow['datafontalign']); ?></td>
    </tr>
    <tr>
      <td colspan="4"><?php echo RW_RPT_TOTALS; ?></td>
      <td align="center"><?php echo html_pull_down_menu('totalsfont', $kFonts, $myrow['totalsfont']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('totalsfontsize', $kFontSizes, $myrow['totalsfontsize']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('totalsfontcolor', $kFontColors, $myrow['totalsfontcolor']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('totalsfontalign', $kFontAlign, $myrow['totalsfontalign']); ?></td>
    </tr>
<?php } // end $show['header'] ?>
  </table>
</form>