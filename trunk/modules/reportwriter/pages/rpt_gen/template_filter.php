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
//  Path: /modules/reportwriter/pages/rpt_gen/template_filter.php
//

$DateArray = explode(':', $Prefs['datedefault']);
if (!isset($DateArray[1])) $DateArray[1] = '';
if (!isset($DateArray[2])) $DateArray[2] = '';
$ValidDateChoices = array();
foreach ($DateChoices as $key => $value) {
 if (strpos($Prefs['dateselect'], $key) !== false) $ValidDateChoices[$key] = $value;
}

echo html_form('reportFilter', FILENAME_DEFAULT, gen_get_all_get_params(array('action')));

echo html_hidden_field('ReportID', $ReportID);
echo html_hidden_field('FormFilter', '1');
echo html_hidden_field('todo', ''); 
echo html_hidden_field('rowSeq', '');

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="self.close()"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['params']   = 'onclick="submitToDo(\'update\');"';
$toolbar->icon_list['print']['params']  = 'onclick="submitToDo(\'exp_pdf\')"';
$toolbar->icon_list['delete']['show']   = false;
$toolbar->add_icon('export_csv',  'onclick="submitToDo(\'exp_csv\')"',  $order = 10);
$toolbar->icon_list['export_html'] = array(
  'show'   => true, 
  'icon'   => 'mimetypes/text-html.png',
  'params' => 'onclick="submitToDo(\'exp_html\')"', 
  'text'   => 'Generate HTML Report', 
  'order'  => '9',
);
$toolbar->add_icon('copy',        'onclick="submitToDo(\'save_as\')"',  $order = 13);
$toolbar->add_help('11.02');
echo $toolbar->build_toolbar(); 

$custom_path = DIR_FS_MY_FILES . 'custom/accounts/main/extra_tabs.php';
if (file_exists($custom_path)) { include($custom_path); }

?>
<div class="pageHeading"><?php echo TEXT_REPORT . ': ' . stripslashes($Prefs['description']); ?></div>

<ul class="tabset_tabs">
<?php // build the tab list's
  $set_default = false;
  foreach ($tab_list as $key => $value) {
  	echo '  <li><a href="#cat_' . $key . '"' . (!$set_default ? ' class="active"' : '') . '>' . $value . '</a></li>' . chr(10);
	$set_default = true;
  }
?>
</ul>

<!-- start the tabsets -->
<div id="cat_crit" class="tabset_content">
  <h2 class="tabset_label"><?php echo TEXT_CRITERIA; ?></h2>

	<div id="rpt_email" style="display:none">
	<table align="center" border="0" cellspacing="0" cellpadding="1">
	  <tr>
		<td align="right"><?php echo TEXT_SENDER_NAME; ?></td>
		<td><?php echo html_input_field('sender_name', $sender_name) . ' ' . TEXT_EMAIL . html_input_field('sender_email', $sender_email, 'size="40"'); ?></td>
	  </tr>
	  <tr>
		<td align="right"><?php echo TEXT_RECEPIENT_NAME; ?></td>
		<td><?php echo html_input_field('recpt_name', $recpt_name) . ' ' . TEXT_EMAIL . html_input_field('recpt_email', $recpt_email, 'size="40"'); ?></td>
	  </tr>
      <tr>
	    <td align="right"><?php echo TEXT_CC_NAME; ?></td>
	    <td><?php echo html_input_field('cc_name', $cc_name) . ' ' . TEXT_EMAIL . html_input_field('cc_email', $cc_email, 'size="40"'); ?></td>
      </tr>
	  <tr>
		<td align="right"><?php echo TEXT_MESSAGE_SUBJECT; ?></td>
		<td><?php echo html_input_field('message_subject', $message_subject, 'size="75"'); ?></td>
	  </tr>
	  <tr>
		<td align="right" valign="top"><?php echo TEXT_MESSAGE_BODY; ?></td>
		<td><?php echo html_textarea_field('message_body', '60', '8', $message_body); ?></td>
	  </tr>
	</table>
	</div>
	<div id="rpt_body">
	  <table align="center" border="1" cellspacing="1" cellpadding="1">
		<tr>
		  <th colspan="4"><?php echo RW_TITLE_CRITERIA; ?></th>
		</tr>
		<tr>
		  <td><?php echo RW_RPT_DELIVERY_METHOD; ?></td>
		  <td align="center"><?php echo RW_BROWSER .  html_radio_field('delivery_method', 'I', ($delivery_method == 'I') ? true : false, '', 'onclick="hideEmail();"', false); ?></td>
		  <td align="center"><?php echo RW_DOWNLOAD . html_radio_field('delivery_method', 'D', ($delivery_method == 'D') ? true : false, '', 'onclick="hideEmail();"', false); ?></td>
		  <td align="center"><?php echo TEXT_EMAIL .  html_radio_field('delivery_method', 'S', ($delivery_method == 'S') ? true : false, '', 'onclick="hideEmail();"', false); ?></td>
		</tr>
		<?php if ($Prefs['dateselect'] <> '') { 
			if ($Prefs['dateselect'] == 'z') { // special case for period pull-down
				echo '<tr><td>' . TEXT_PERIOD . '</td>';
				echo '<td colspan="3">';
				echo html_pull_down_menu('period', gen_get_period_pull_down(false), CURRENT_ACCOUNTING_PERIOD);
				echo '</td></tr>';
			} else { ?>
				<tr>
				  <th colspan="2">&nbsp;</td>
				  <th align="center"><?php echo TEXT_FROM; ?></th>
				  <th align="center"><?php echo TEXT_TO; ?></th>
				</tr>
				<tr>
				  <td><?php echo TEXT_DATE; ?></td>
				  <td><?php echo html_pull_down_menu('defdate', gen_build_pull_down($ValidDateChoices), $DateArray[0]); ?></td>
				  <td><script type="text/javascript">dateFrom.writeControl(); dateFrom.displayLeft=true; dateFrom.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script></td>
				  <td><script type="text/javascript">dateTo.writeControl(); dateTo.displayLeft=true; dateTo.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script></td>
				</tr>
			<?php } 
		}
		if ($Prefs['GroupListings'] <> '') { ?>
		<tr>
		  <td><?php echo TEXT_GROUP; ?></td>
		  <td colspan="3">
			<select name="defgroup">
			   <option value="0"><?php echo TEXT_NONE; ?></option>
			<?php $page_break = false;
				foreach($Prefs['GroupListings'] as $LineItem) {
				if ($LineItem['params']['default'] == '1') {
				  $Selected = ' selected';
				  if ($LineItem['params']['page_break']) $page_break = true;
				} else {
				  $Selected = '';
				}
				echo '<option value="' . $LineItem['seqnum'] . '"' . $Selected . '>' . htmlspecialchars($LineItem['displaydesc']) . '</option>';
			} ?>
			</select>
			<?php echo ' ' . RW_RPT_PAGE_BREAK . ' ' . html_checkbox_field('grpbreak', '1', $page_break); ?>
		  </td>
		</tr>
		<?php } // end if ($GroupListings)
		if ($Prefs['SortListings'] <> '') { ?>
		<tr>
		  <td><?php echo TEXT_SORT; ?></td>
		  <td colspan="3">
			<select name="defsort">
			   <option value="0"><?php echo TEXT_NONE; ?></option>
			<?php foreach($Prefs['SortListings'] as $LineItem) {
				$Selected = ($LineItem['params']['default'] == '1') ? ' selected' : '';
				echo '<option value="' . $LineItem['seqnum'] . '"' . $Selected.'>' . htmlspecialchars($LineItem['displaydesc']) . '</option>';
			} ?>
			</select></td>
		</tr>
		<?php } // end if ($SortListings) ?>
		<tr>
		  <td><?php echo TEXT_TRUNC; ?></td>
		  <td colspan="3">
			<?php echo html_radio_field('deftrunc', '0', ($Prefs['trunclong'] <> '1') ? true : false) . TEXT_NO; ?>
			<?php echo html_radio_field('deftrunc', '1', ($Prefs['trunclong'] == '1') ? true : false) . TEXT_YES; ?>
		  </td>
		</tr>
		<?php if ($Prefs['CritListings'] <> '') { ?>
			<tr>
			  <th><?php echo TEXT_FILTER; ?></th>
			  <th><?php echo TEXT_TYPE; ?></th>
			  <th><?php echo TEXT_FROM; ?></th>
			  <th><?php echo TEXT_TO; ?></th>
			</tr>
			<?php foreach ($Prefs['CritListings'] as $LineItem) echo BuildCriteria($LineItem);
		} // end if ($CritListings <> '') ?>
	  </table>
	</div>
</div>
<?php // ********************  end criteria tab, start fields tab ************************** ?>

<div id="cat_field" class="tabset_content">
  <h2 class="tabset_label"><?php echo TEXT_FIELDS; ?></h2>
	<table align="center" border="0" cellspacing="0" cellpadding="0"><tr>
	  <td>
	    <table id="fieldTable" align="center" border="1" cellspacing="1" cellpadding="1">
		  <tr>
			<th colspan="7"><?php echo TEXT_FIELDS; ?></th>
		  </tr>
		  <tr>
			<td align="center"><?php echo TEXT_FLDNAME; ?></td>
			<td align="center"><?php echo TEXT_SHOW; ?></td>
			<td align="center"><?php echo TEXT_BREAK; ?></td>
			<td align="center"><?php echo TEXT_COLUMN . '<br />' . TEXT_WIDTH; ?></td>
			<td align="center"><?php echo TEXT_COLUMN; ?></td>
			<td align="center"><?php echo TEXT_REPORT  . '<br />' . TEXT_WIDTH; ?></td>
			<td align="center"><?php echo TEXT_MOVE; ?></td>
		  </tr>
		  <?php echo BuildFieldList($Prefs['FieldListings']); ?>
	    </table>
	  </td>
	  <td>&nbsp;</td>
	  <td valign="top">
	    <table align="center" border="1" cellspacing="1" cellpadding="1">
		  <tr>
			<th colspan="2"><?php echo TEXT_USEFUL_INFO; ?></th>
		  </tr>
		  <tr>
			<td align="center"><?php echo RW_RPT_PGMARGIN_L; ?></td>
			<td id="lmData" align="center">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center"><?php echo RW_RPT_PGMARGIN_R; ?></td>
			<td id="rmData" align="center">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center"><?php echo TEXT_ORIEN; ?></td>
			<td id="pageOrientation" align="center">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center"><?php echo TEXT_PAPER_WIDTH; ?></td>
			<td id="pageWidthData" align="center">&nbsp;</td>
		  </tr>
	    </table>
	  </td>
	</tr></table>
	

</div>
<?php // ********************  end fields tab, start page setup tab ************************** ?>

<div id="cat_page" class="tabset_content">
  <h2 class="tabset_label"><?php echo TEXT_PAGE_SETUP; ?></h2>

  <table align="center" border="2" cellspacing="1" cellpadding="1">
    <tr><th colspan="8"><?php echo RW_RPT_PGLAYOUT ?></th></tr>
    <tr>
      <td colspan="4" align="center">
        <?php echo TEXT_PAPER . ' ' . html_pull_down_menu('papersize', gen_build_pull_down($PaperSizes), $Prefs['papersize'], 'onchange="calculateWidth()"'); ?>
      </td>
      <td colspan="4" align="center">
	  	<?php echo TEXT_ORIEN . ' ' . html_radio_field('paperorientation', 'P', ($Prefs['paperorientation'] == 'P') ? true : false, '', 'onchange="calculateWidth()"') . ' ' . TEXT_PORTRAIT; ?>
	  	<?php echo ' ' . html_radio_field('paperorientation', 'L', ($Prefs['paperorientation'] == 'L') ? true : false, '', 'onchange="calculateWidth()"') . '  ' . TEXT_LANDSCAPE; ?>
	  </td>
    </tr>
    <tr><th colspan="8"><?php echo RW_RPT_PGMARGIN; ?></th></tr>
    <tr>
      <td colspan="2" align="center"><?php echo TEXT_TOP . ' ' . html_input_field('margintop', $Prefs['margintop'], 'size="5" maxlength="3"') . ' ' . TEXT_MM; ?></td>
      <td colspan="2" align="center"><?php echo TEXT_BOTTOM . ' ' . html_input_field('marginbottom', $Prefs['marginbottom'], 'size="5" maxlength="3"') . ' ' . TEXT_MM; ?></td>
      <td colspan="2" align="center"><?php echo TEXT_LEFT . ' ' . html_input_field('marginleft', $Prefs['marginleft'], 'size="5" maxlength="3" onchange="calculateWidth()"') . ' ' . TEXT_MM; ?></td>
      <td colspan="2" align="center"><?php echo TEXT_RIGHT . ' ' . html_input_field('marginright', $Prefs['marginright'], 'size="5" maxlength="3" onchange="calculateWidth()"') . ' ' . TEXT_MM; ?></td>
    </tr>
    <tr><th colspan="8"><?php echo RW_RPT_PGHEADER; ?></th></tr>
    <tr>
      <td colspan="3">&nbsp;</td>
      <td align="center"><?php echo TEXT_SHOW; ?></td>
      <td align="center"><?php echo TEXT_FONT; ?></td>
      <td align="center"><?php echo TEXT_SIZE; ?></td>
      <td align="center"><?php echo TEXT_COLOR; ?></td>
      <td align="center"><?php echo TEXT_ALIGN; ?></td>
    </tr>
    <tr>
      <td colspan="3"><?php echo TEXT_PGCOYNM; ?></td>
	  <td align="center"><?php echo html_checkbox_field('coynameshow', '1', ($Prefs['coynameshow'] == '1') ? true : false); ?></td>
      <td align="center"><?php echo html_pull_down_menu('coynamefont', $kFonts, $Prefs['coynamefont']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('coynamefontsize', $kFontSizes, $Prefs['coynamefontsize']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('coynamefontcolor', $kFontColors, $Prefs['coynamefontcolor']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('coynamealign', $kFontAlign, $Prefs['coynamealign']); ?></td>
    </tr>
    <tr>
      <td nowrap="nowrap" colspan="3"><?php echo RW_RPT_PGTITL1 . ' ' . html_input_field('title1desc', $Prefs['title1desc'], 'size="30" maxlength="50"'); ?></td>
	  <td align="center"><?php echo html_checkbox_field('title1show', '1', ($Prefs['title1show'] == '1') ? true : false); ?></td>
      <td align="center"><?php echo html_pull_down_menu('title1font', $kFonts, $Prefs['title1font']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('title1fontsize', $kFontSizes, $Prefs['title1fontsize']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('title1fontcolor', $kFontColors, $Prefs['title1fontcolor']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('title1fontalign', $kFontAlign, $Prefs['title1fontalign']); ?></td>
    </tr>
    <tr>
      <td nowrap="nowrap" colspan="3"><?php echo RW_RPT_PGTITL2 . ' ' . html_input_field('title2desc', $Prefs['title2desc'], 'size="30" maxlength="50"'); ?></td>
	  <td align="center"><?php echo html_checkbox_field('title2show', '1', ($Prefs['title2show'] == '1') ? true : false); ?></td>
      <td align="center"><?php echo html_pull_down_menu('title2font', $kFonts, $Prefs['title2font']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('title2fontsize', $kFontSizes, $Prefs['title2fontsize']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('title2fontcolor', $kFontColors, $Prefs['title2fontcolor']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('title2fontalign', $kFontAlign, $Prefs['title2fontalign']); ?></td>
    </tr>
    <tr>
      <td colspan="4"><?php echo RW_RPT_PGFILDESC; ?></td>
      <td align="center"><?php echo html_pull_down_menu('filterfont', $kFonts, $Prefs['filterfont']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('filterfontsize', $kFontSizes, $Prefs['filterfontsize']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('filterfontcolor', $kFontColors, $Prefs['filterfontcolor']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('filterfontalign', $kFontAlign, $Prefs['filterfontalign']); ?></td>
    </tr>
    <tr>
      <td colspan="4"><?php echo RW_RPT_RPTDATA; ?></td>
      <td align="center"><?php echo html_pull_down_menu('datafont', $kFonts, $Prefs['datafont']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('datafontsize', $kFontSizes, $Prefs['datafontsize']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('datafontcolor', $kFontColors, $Prefs['datafontcolor']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('datafontalign', $kFontAlign, $Prefs['datafontalign']); ?></td>
    </tr>
    <tr>
      <td colspan="4"><?php echo RW_RPT_TOTALS; ?></td>
      <td align="center"><?php echo html_pull_down_menu('totalsfont', $kFonts, $Prefs['totalsfont']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('totalsfontsize', $kFontSizes, $Prefs['totalsfontsize']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('totalsfontcolor', $kFontColors, $Prefs['totalsfontcolor']); ?></td>
      <td align="center"><?php echo html_pull_down_menu('totalsfontalign', $kFontAlign, $Prefs['totalsfontalign']); ?></td>
    </tr>
  </table>

</div>
<?php // end page setup tab ?>
</form>