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
//  Path: /modules/reportwriter/pages/popup_form/template_main.php
//

// start the form
echo html_form('popup_form', FILENAME_DEFAULT, 'cat=reportwriter&amp;module=form_gen&amp;show=criteria' . $crit_string) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="self.close()"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['print']['params']  = 'onclick="submitToDo(\'criteria\');"';
$toolbar->icon_list['delete']['show']   = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('11.02');
echo $toolbar->build_toolbar();

// Build the page
?>
<div class="pageHeading"><?php echo RW_FORM_DELIVERY_METHOD; ?></div>
  <table width="300" border="0" cellspacing="1" cellpadding="1">
	<tr>
      <td width="33%" align="center"><?php echo RW_BROWSER . html_radio_field('delivery_method', 'I', ($delivery_method == 'I') ? true : false, '', 'onclick="hideEmail();"', false); ?></td>
      <td width="33%" align="center"><?php echo RW_DOWNLOAD . html_radio_field('delivery_method', 'D', ($delivery_method == 'D') ? true : false, '', 'onclick="hideEmail();"', false); ?></td>
      <td width="33%" align="center"><?php echo ($enable_email) ? (TEXT_EMAIL . html_radio_field('delivery_method', 'S', ($delivery_method == 'S') ? true : false, '', 'onclick="hideEmail();"', false)) : '&nbsp;'; ?></td>
    </tr>
  </table>
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
<div class="pageHeading"><?php echo RW_RPT_FORMOUTPUT; ?></div>
<?php
  while (!$formnames->EOF) {
	echo '<div>' . html_radio_field('ReportID', $formnames->fields['id'], false, '', 'onchange="fetchEmailMsg()"');
	echo '&nbsp;' . $formnames->fields['description'] . '</div>' . chr(10);
	$formnames->MoveNext();
  }
?>
</div>
</form>