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
//  Path: /modules/reportwriter/pages/form_gen/template_filter.php
//

$DateArray = explode(':', $Prefs['datedefault']);
if (!isset($DateArray[1])) $DateArray[1] = '';
if (!isset($DateArray[2])) $DateArray[2] = ''; 
$ValidDateChoices = array();
foreach ($DateChoices as $key => $value) {
 if (strpos($Prefs['dateselect'], $key) !== false) $ValidDateChoices[$key] = $value;
}

echo html_form('formfilter', FILENAME_DEFAULT, gen_get_all_get_params(array('action')));
echo html_hidden_field('ReportID',   $ReportID);
echo html_hidden_field('FormFilter', '1');
echo html_hidden_field('todo',       ''); 
// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="self.close()"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['print']['params']  = 'onclick="submitToDo(\'exp_pdf\')"';
$toolbar->icon_list['delete']['show']   = false;
$toolbar->add_help('11.02');
echo $toolbar->build_toolbar();
?>
<h2 align="center"><?php echo $Prefs['description'] . ' - ' . TEXT_CRITERIA; ?></h2>
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
<table align="center" width="550" border="1" cellspacing="1" cellpadding="1">
  <tr>
	<th colspan="4"><?php echo RW_TITLE_CRITERIA; ?></th>
  </tr>
  <tr>
    <td><?php echo RW_FORM_DELIVERY_METHOD; ?></td>
    <td align="center"><?php echo RW_BROWSER .  html_radio_field('delivery_method', 'I', ($delivery_method == 'I') ? true : false, '', 'onclick="hideEmail();"', false); ?></td>
    <td align="center"><?php echo RW_DOWNLOAD . html_radio_field('delivery_method', 'D', ($delivery_method == 'D') ? true : false, '', 'onclick="hideEmail();"', false); ?></td>
    <td align="center"><?php echo TEXT_EMAIL .  html_radio_field('delivery_method', 'S', ($delivery_method == 'S') ? true : false, '', 'onclick="hideEmail();"', false); ?></td>
  </tr>
  <?php if ($Prefs['dateselect'] <>'') { // show the date choices only if form requires it ?>
    <tr>
      <th colspan="2">&nbsp;</th>
      <th align="center"><?php echo TEXT_FROM; ?></th>
      <th align="center"><?php echo TEXT_TO; ?></th>
    </tr>
    <tr>
      <td><?php echo TEXT_DATE; ?></td>
      <td><?php echo html_pull_down_menu('DefDate', gen_build_pull_down($ValidDateChoices), $DateArray[0]); ?></td>
	  <td><script type="text/javascript">dateFrom.writeControl(); dateFrom.displayLeft=true; dateFrom.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script></td>
	  <td><script type="text/javascript">dateTo.writeControl(); dateTo.displayLeft=true; dateTo.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script></td>
    </tr>
  <?php }
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
  <?php } // end if ($SortListings)
  if ($Prefs['CritListings'] <> '') { 
	foreach ($Prefs['CritListings'] as $LineItem) echo BuildCriteria($LineItem);
  } ?>
</table>
</div>
</form>