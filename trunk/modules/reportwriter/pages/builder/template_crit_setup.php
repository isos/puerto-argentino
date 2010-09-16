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
//  Path: /modules/reportwriter/pages/builder/template_crit_setup.php
//

  $notes = '<u><b>' . TEXT_NOTES . '</b></u>';
  $kFields = CreateFieldArray($ReportID);
  echo html_form('CritFormMain', FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=step7');
  echo html_hidden_field('ReportID',    $ReportID);
  echo html_hidden_field('Type',        $Type); 
  echo html_hidden_field('ReportName',  $description); 
  echo html_hidden_field('todo',        ''); 
  echo html_hidden_field('rowSeq',      '');
  echo html_hidden_field('EntryType',   'main');
  echo html_hidden_field('SeqNum',      '');
  echo html_hidden_field('FieldName',   '');
  echo html_hidden_field('DisplayDesc', '');
  echo html_hidden_field('Params',      '');
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
<h2 align="center"><?php echo $FormParams['heading'] . stripslashes($description) . ' - ' . TEXT_CRITERIA; ?></h2>
  <table width="700" align="center" border="2" cellspacing="1" cellpadding="1">
    <tr>
      <th colspan="3"><?php echo RW_RPT_DATEINFO; ?></th>
    </tr>
    <tr>
      <td width="33%" valign="top">
	  	<?php echo RW_RPT_DATELIST; ?><br /><br />
		<?php echo RW_RPT_DATEINST; ?><br /><br />
	    <?php echo html_checkbox_field('periods_only', 'z', (strpos($FormParams['Prefs']['dateselect'], 'z') === false) ? false : true) . TEXT_USE_ACCOUNTING_PERIODS; ?><br />
	  </td>
      <td width="33%">
	    <?php
		echo html_checkbox_field('DateRange1', 'a', (strpos($FormParams['Prefs']['dateselect'], 'a') === false) ? false : true) . $DateChoices['a'] . '<br />';
		echo html_checkbox_field('DateRange2', 'b', (strpos($FormParams['Prefs']['dateselect'], 'b') === false) ? false : true) . $DateChoices['b'] . '<br />';
		echo html_checkbox_field('DateRange3', 'c', (strpos($FormParams['Prefs']['dateselect'], 'c') === false) ? false : true) . $DateChoices['c'] . '<br />';
		echo html_checkbox_field('DateRange4', 'd', (strpos($FormParams['Prefs']['dateselect'], 'd') === false) ? false : true) . $DateChoices['d'] . '<br />';
		echo html_checkbox_field('DateRange5', 'e', (strpos($FormParams['Prefs']['dateselect'], 'e') === false) ? false : true) . $DateChoices['e'] . '<br />';
		echo html_checkbox_field('DateRange12','l', (strpos($FormParams['Prefs']['dateselect'], 'l') === false) ? false : true) . $DateChoices['l'];
	    ?>
	  </td>
      <td width="33%">
	    <?php 
		echo html_checkbox_field('DateRange6', 'f', (strpos($FormParams['Prefs']['dateselect'], 'f') === false) ? false : true) . $DateChoices['f'] .'<br />';
		echo html_checkbox_field('DateRange7', 'g', (strpos($FormParams['Prefs']['dateselect'], 'g') === false) ? false : true) . $DateChoices['g'] .'<br />';
		echo html_checkbox_field('DateRange8', 'h', (strpos($FormParams['Prefs']['dateselect'], 'h') === false) ? false : true) . $DateChoices['h'] .'<br />';
		echo html_checkbox_field('DateRange9', 'i', (strpos($FormParams['Prefs']['dateselect'], 'i') === false) ? false : true) . $DateChoices['i'] .'<br />';
		echo html_checkbox_field('DateRange10','j', (strpos($FormParams['Prefs']['dateselect'], 'j') === false) ? false : true) . $DateChoices['j'] .'<br />';
		echo html_checkbox_field('DateRange11','k', (strpos($FormParams['Prefs']['dateselect'], 'k') === false) ? false : true) . $DateChoices['k'];
	    ?>
	  </td>
    </tr>
    <tr>
      <td><?php echo RW_RPT_DATEDEF; ?></td>
      <td colspan="2"><?php echo html_pull_down_menu('DefDate', gen_build_pull_down($DateChoices), $FormParams['Prefs']['datedefault']); ?></td>
    </tr>
    <tr>
      <td><?php echo RW_RPT_DATEFNAME; ?></td>
      <td colspan="4"><?php echo html_pull_down_menu('DateField', $kFields, $FormParams['Prefs']['datefield']); ?></td>
    </tr>
<?php if ($Type <> 'frm') { ?>
	<tr>
	  <td><?php echo TEXT_TRUNC; ?></td>
	  <td colspan="4">
        <?php echo html_radio_field('TruncLongDesc', '1', ($FormParams['Prefs']['trunclong'] == '1') ? true : false) . TEXT_YES; ?>
	    <?php echo html_radio_field('TruncLongDesc', '0', ($FormParams['Prefs']['trunclong'] <> '1') ? true : false) . TEXT_NO; ?>
	  </td>
	</tr>
	<tr>
	  <td><?php echo RW_TEXT_TOTAL_ONLY; ?></td>
	  <td colspan="4">
        <?php echo html_radio_field('TotalOnly', '1', ($FormParams['Prefs']['totalonly'] == '1') ? true : false) . TEXT_YES; ?>
	    <?php echo html_radio_field('TotalOnly', '0', ($FormParams['Prefs']['totalonly'] <> '1') ? true : false) . TEXT_NO; ?>
	  </td>
	</tr>
<?php } else { // for forms ?>
		<tr>
		  <td><?php echo RW_FRM_SET_PRINTED . '<sup>1</sup>'; $notes .= '<br /><sup>1 </sup>' . RW_FRM_SET_PRINTED_NOTE; ?></td>
		  <td colspan="4"><?php echo html_pull_down_menu('SetPrintedFlag', $kFields, $FormParams['Prefs']['setprintedflag']); ?></td>
		</tr>
		<tr>
		  <td><?php echo RW_FRM_PAGE_BREAK; ?></td>
		  <td colspan="4"><?php echo html_pull_down_menu('FormBreakField', $kFields, $FormParams['Prefs']['formbreakfield']); ?></td>
		</tr>
<?php } // end if ($Type<>'frm') ?>
    <tr>
      <td><?php echo RW_DL_FILENAME_SOURCE; ?></td>
      <td colspan="4">
	    <?php echo RW_TEXT_PREFIX . html_input_field('FileNamePrefix', $FormParams['Prefs']['filenameprefix'], 'size="24" maxlength="24"'); ?>
	    <?php echo RW_TEXT_SOURCE_FIELD . html_pull_down_menu('FileNameSource', $kFields, $FormParams['Prefs']['filenamesource']); ?>
	  </td>
    </tr>
  </table>
  <table align="center" border="2" cellspacing="1" cellpadding="1">
<?php if ($Type <> 'frm') { ?>
    <tr>
      <th colspan="20"><?php echo RW_RPT_GRPLIST; ?></th>
    </tr>
    <tr>
      <th><?php echo TEXT_SEQ; ?></th>
      <th align="center"><?php echo RW_RPT_TBLFNAME; ?></th>
      <th align="center"><?php echo RW_RPT_DISPNAME; ?></th>
      <th align="center"><?php echo TEXT_DEFAULT; ?></th>
      <th align="center"><?php echo RW_RPT_PAGE_BREAK; ?></th>
      <th align="center"><?php echo RW_RPT_TEXTPROC; ?></th>
      <th align="center"><?php echo TEXT_ACTION; ?></th>
    </tr>
    <tr>
      <th colspan="20"><?php //echo 'GroupListings = '; print_r($GroupListings); echo '<br />'; ?></th>
    </tr>
    <tr>
	  <td align="center">
	    <?php if ($GroupListings['defaults']['buttonvalue'] == TEXT_CHANGE) {
		  echo html_hidden_field('gSeqNum', $GroupListings['defaults']['seqnum']) . $GroupListings['defaults']['seqnum'];
		} else {
		  echo html_input_field('gSeqNum', $GroupListings['defaults']['seqnum'], 'size="4" maxlength="3"');
		} ?>
	  </td>
      <td><?php echo html_pull_down_menu('gFieldName', $kFields, $GroupListings['defaults']['fieldname']); ?></td>
      <td><?php echo html_input_field('gDisplayDesc', $GroupListings['defaults']['displaydesc'], 'size="26" maxlength="25"'); ?></td>
      <td align="center"><?php echo html_checkbox_field('gParamsDef', '1', $GroupListings['defaults']['params']['default'] == '1'    ? true : false); ?></td>
      <td align="center"><?php echo html_checkbox_field('gParamsBrk', '1', $GroupListings['defaults']['params']['page_break'] == '1' ? true : false); ?></td>
      <td><?php echo html_pull_down_menu('gProcessing', gen_build_pull_down($FormProcessing), $GroupListings['defaults']['params']['processing']); ?></td>
      <td align="center">
	    <?php if ($GroupListings['defaults']['buttonvalue'] == TEXT_ADD) {
		  echo html_icon('actions/list-add.png', TEXT_ADD, 'medium', 'onclick="if (submitCrit(\'grouplist\')) submitToDo(\'add\');"');
		} else {
		  echo html_icon('actions/view-refresh.png', TEXT_CHANGE, 'medium', 'onclick="if (submitCrit(\'grouplist\')) submitToDo(\'change\');"');
		} ?>
	  </td>
	</tr>
	<?php if (!$GroupListings['lists']) {
		echo '<tr><td align="center" colspan="20">' . RW_RPT_NOFIELD . '</td></tr>';
	} else { 
		foreach ($GroupListings['lists'] as $FieldDetails) { ?>
			<tr>
			  <td align="center"><?php echo $FieldDetails['seqnum']; ?></td>
			  <td><?php echo $FieldDetails['fieldname']; ?></td>
			  <td><?php echo $FieldDetails['displaydesc']; ?></td>
			  <td align="center"><?php echo html_checkbox_field('def', '1', ($FieldDetails['params']['default']    == '1' ? true : false), '', 'disabled="disabled"'); ?></td>
			  <td align="center"><?php echo html_checkbox_field('brk', '1', ($FieldDetails['params']['page_break'] == '1' ? true : false), '', 'disabled="disabled"'); ?></td>
			  <td><?php echo $FormProcessing[$FieldDetails['params']['processing']]; ?></td>
			  <td>
			  	<?php 
				  echo html_icon('actions/go-up.png', TEXT_UP, 'small', 'onclick="if (critSeq(' . $FieldDetails['seqnum'] . ', \'grouplist\')) submitToDo(\'up\');"'); 
				  echo html_icon('actions/go-down.png', TEXT_DOWN, 'small', 'onclick="if (critSeq(' . $FieldDetails['seqnum'] . ', \'grouplist\')) submitToDo(\'down\');"'); 
				  echo html_icon('actions/edit-find-replace.png', TEXT_EDIT, 'small', 'onclick="if (critSeq(' . $FieldDetails['seqnum'] . ', \'grouplist\')) submitToDo(\'edit\');"'); 
				  echo html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . TEXT_DELETE_ENTRY . '\')) { critSeq(' . $FieldDetails['seqnum'] . ', \'grouplist\'); submitToDo(\'delete\'); }"'); 
				?>
			  </td>
			</tr>
		<?php } // end foreach ?>
	<?php } // end else  ?>
<?php } // end if ($Type <> 'frm') ?>
    <tr>
      <th colspan="20"><?php echo RW_RPT_SORTLIST; ?></th>
    </tr>
    <tr>
      <th><?php echo TEXT_SEQ; ?></th>
      <th><?php echo RW_RPT_TBLFNAME; ?></th>
      <th><?php echo RW_RPT_DISPNAME; ?></th>
      <th><?php echo TEXT_DEFAULT; ?></th>
      <th><?php echo '&nbsp;'; ?></th>
      <th><?php echo '&nbsp;'; ?></th>
      <th><?php echo TEXT_ACTION; ?></th>
    </tr>
    <tr>
	  <td align="center">
	    <?php if ($SortListings['defaults']['buttonvalue'] == TEXT_CHANGE) {
		  echo html_hidden_field('sSeqNum', $SortListings['defaults']['seqnum']) . $SortListings['defaults']['seqnum'];
		} else {
		  echo html_input_field('sSeqNum', $SortListings['defaults']['seqnum'], 'size="4" maxlength="3"');
		} ?>
	  </td>
      <td><?php echo html_pull_down_menu('sFieldName', $kFields, $SortListings['defaults']['fieldname']); ?></td>
      <td><?php echo html_input_field('sDisplayDesc', $SortListings['defaults']['displaydesc'], 'size="26" maxlength="25"'); ?></td>
      <td align="center"><?php echo html_checkbox_field('sParamsDef', '1', $SortListings['defaults']['params']['default'] == '1' ? true : false); ?></td>
      <td><?php echo '&nbsp;'; ?></td>
      <td><?php echo '&nbsp;'; ?></td>
      <td align="center">
	    <?php if ($SortListings['defaults']['buttonvalue'] == TEXT_ADD) {
		  echo html_icon('actions/list-add.png', TEXT_ADD, 'medium', 'onclick="if (submitCrit(\'sortlist\')) submitToDo(\'add\');"');
		} else {
		  echo html_icon('actions/view-refresh.png', TEXT_CHANGE, 'medium', 'onclick="if (submitCrit(\'sortlist\')) submitToDo(\'change\')"');
		} ?>
	  </td>
	</tr>
	<?php if (!$SortListings['lists']) {
		echo '<tr><td align="center" colspan="20">' . RW_RPT_NOFIELD . '</td></tr>';
	} else { 
		foreach ($SortListings['lists'] as $FieldDetails) { ?>
			<tr>
			  <td align="center"><?php echo $FieldDetails['seqnum']; ?></td>
			  <td><?php echo $FieldDetails['fieldname']; ?></td>
			  <td><?php echo $FieldDetails['displaydesc']; ?></td>
			  <td align="center"><?php echo html_checkbox_field('def' . $FieldDetails['seqnum'], '1', (($FieldDetails['params']['default'] == '1') ? true : false), '', 'disabled="disabled"'); ?></td>
			  <td align="center"><?php echo '&nbsp;'; ?></td>
			  <td align="center"><?php echo '&nbsp;'; ?></td>
			  <td>
			  	<?php 
				  echo html_icon('actions/go-up.png', TEXT_UP, 'small', 'onclick="if (critSeq(' . $FieldDetails['seqnum'] . ', \'sortlist\')) submitToDo(\'up\');"'); 
				  echo html_icon('actions/go-down.png', TEXT_DOWN, 'small', 'onclick="if (critSeq(' . $FieldDetails['seqnum'] . ', \'sortlist\')) submitToDo(\'down\');"'); 
				  echo html_icon('actions/edit-find-replace.png', TEXT_EDIT, 'small', 'onclick="if (critSeq(' . $FieldDetails['seqnum'] . ', \'sortlist\')) submitToDo(\'edit\');"'); 
				  echo html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . TEXT_DELETE_ENTRY . '\')) { critSeq(' . $FieldDetails['seqnum'] . ', \'sortlist\'); submitToDo(\'delete\'); }"'); 
				?>
			  </td>
			</tr>
		<?php } // end foreach
	} // end else ?>
  </table>
  <table align="center" border="2" cellspacing="1" cellpadding="1">
    <tr>
      <th colspan="20"><?php echo TEXT_CRITERIA; ?></th>
    </tr>
    <tr>
      <th><?php echo TEXT_SEQ; ?></th>
      <th align="center"><?php echo RW_RPT_TBLFNAME; ?></th>
      <th align="center"><?php echo RW_RPT_DISPNAME; ?></th>
      <th align="center"><?php echo TEXT_SHOW; ?></th>
      <th align="center"><?php echo RW_RPT_CRITTYPE; ?></th>
      <th align="center"><?php echo RW_TEXT_MIN_VALUE; ?></th>
      <th align="center"><?php echo RW_TEXT_MAX_VALUE; ?></th>
      <th align="center"><?php echo TEXT_ACTION; ?></th>
    </tr>
    <tr>
	  <td align="center">
	    <?php if ($CritListings['defaults']['buttonvalue'] == TEXT_CHANGE) {
		  echo html_hidden_field('cSeqNum', $CritListings['defaults']['seqnum']) . $CritListings['defaults']['seqnum'];
		} else {
		  echo html_input_field('cSeqNum', $CritListings['defaults']['seqnum'], 'size="4" maxlength="3"');
		} ?>
	  </td>
      <td><?php echo html_pull_down_menu('cFieldName', $kFields, $CritListings['defaults']['fieldname']); ?></td>
      <td><?php echo html_input_field('cDisplayDesc', $CritListings['defaults']['displaydesc'], 'size="26" maxlength="25"'); ?></td>
      <td align="center"><?php echo html_checkbox_field('Visible', '1', ($CritListings['defaults']['visible']) ? true : false); ?></td>
      <td><?php echo html_pull_down_menu('cParamsVal', crit_build_pull_down($CritChoices), $CritListings['defaults']['params']['value']); ?></td>
      <td><?php echo html_input_field('MinValue', $CritListings['defaults']['params']['min_val'], 'size="10"'); ?></td>
      <td><?php echo html_input_field('MaxValue', $CritListings['defaults']['params']['max_val'], 'size="10"'); ?></td>
      <td align="center">
	    <?php if ($CritListings['defaults']['buttonvalue'] == TEXT_ADD) {
		  echo html_icon('actions/list-add.png', TEXT_ADD, 'medium', 'onclick="if (submitCrit(\'critlist\')) submitToDo(\'add\');"');
		} else {
		  echo html_icon('actions/view-refresh.png', TEXT_CHANGE, 'medium', 'onclick="if (submitCrit(\'critlist\')) submitToDo(\'change\');"');
		} ?>
	  </td>
	</tr>
<?php
	if (!$CritListings['lists']) {
		echo '<tr><td align="center" colspan="20">' . RW_RPT_NOFIELD . '</td></tr>';
	} else { 
		foreach ($CritListings['lists'] as $FieldDetails) { ?>
			<tr>
			  <td align="center"><?php echo $FieldDetails['seqnum']; ?></td>
			  <td><?php echo $FieldDetails['fieldname']; ?></td>
			  <td><?php echo $FieldDetails['displaydesc']; ?></td>
			  <td align="center"><?php echo html_checkbox_field('def' . $FieldDetails['seqnum'], '1', (($FieldDetails['visible'] == '1') ? true : false), '', 'disabled="disabled"'); ?></td>
			  <td align="center"><?php echo $CritChoices[$FieldDetails['params']['value']]; ?></td>
     		  <td align="center"><?php echo $FieldDetails['params']['min_val'] <> '' ? $FieldDetails['params']['min_val'] : '&nbsp;'; ?></td>
     		  <td align="center"><?php echo $FieldDetails['params']['max_val'] <> '' ? $FieldDetails['params']['max_val'] : '&nbsp;'; ?></td>
			  <td>
			  	<?php 
				  echo html_icon('actions/go-up.png', TEXT_UP, 'small', 'onclick="if (critSeq(' . $FieldDetails['seqnum'] . ', \'critlist\')) submitToDo(\'up\');"'); 
				  echo html_icon('actions/go-down.png', TEXT_DOWN, 'small', 'onclick="if (critSeq(' . $FieldDetails['seqnum'] . ', \'critlist\')) submitToDo(\'down\');"'); 
				  echo html_icon('actions/edit-find-replace.png', TEXT_EDIT, 'small', 'onclick="if (critSeq(' . $FieldDetails['seqnum'] . ', \'critlist\')) submitToDo(\'edit\');"'); 
				  echo html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . TEXT_DELETE_ENTRY . '\')) { critSeq(' . $FieldDetails['seqnum'] . ', \'critlist\'); submitToDo(\'delete\'); }"'); 
				?>
			  </td>
			</tr>
		<?php } // end foreach
	} // end else ?>
  </table>
  <?php echo $notes; ?>
</form>