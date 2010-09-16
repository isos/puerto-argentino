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
//  Path: /modules/accounts/pages/main/template_c_contacts.php
//

?>
<div id="cat_contacts" class="tabset_content">
  <h2 class="tabset_label"><?php echo TEXT_CONTACTS; ?></h2>
  <?php // *********************** Contact List ****************************** ?>
  <?php 
	// load the information
	$crm_headings = load_crm_headings();
	$crm_contacts = load_contacts($cInfo->id);
	if ($crm_contacts) {
  ?>
  <fieldset class="formAreaTitle">
    <legend><?php echo TEXT_CONTACTS; ?></legend>
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
	  <tr class="dataTableHeadingRow"><?php echo $crm_headings; ?></tr>
	<?php while (!$crm_contacts->EOF) {
	  $bkgnd = ($crm_contacts->fields['inactive']) ? ' style="background-color:pink"' : '';
	?>
	  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
		<td class="dataTableContent"<?php echo $bkgnd; ?> onclick="editContact(<?php echo $crm_contacts->fields['id']; ?>)"><?php echo $crm_contacts->fields['contact_last']; ?></td>
		<td class="dataTableContent"<?php echo $bkgnd; ?> onclick="editContact(<?php echo $crm_contacts->fields['id']; ?>)"><?php echo $crm_contacts->fields['contact_first']; ?></td>
		<td class="dataTableContent" onclick="editContact(<?php echo $crm_contacts->fields['id']; ?>)"><?php echo $crm_contacts->fields['contact_middle']; ?></td>
		<td class="dataTableContent" onclick="editContact(<?php echo $crm_contacts->fields['id']; ?>)"><?php echo $crm_contacts->fields['telephone1']; ?></td>
		<td class="dataTableContent" onclick="editContact(<?php echo $crm_contacts->fields['id']; ?>)"><?php echo $crm_contacts->fields['telephone4']; ?></td>
		<td class="dataTableContent" onclick="editContact(<?php echo $crm_contacts->fields['id']; ?>)"><?php echo $crm_contacts->fields['email']; ?></td>
		<td class="dataTableContent" align="right">
	<?php // build the action toolbar
		if ($security_level > 1) echo html_icon('actions/edit-find-replace.png', TEXT_EDIT,   'small', 'onclick="editContact(' . $crm_contacts->fields['id'] . ')"') . chr(10);
//		if ($security_level > 3) echo html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . ACT_WARN_DELETE_ACCOUNT . '\')) submitSeq(' . $crm_contacts->fields['id'] . ', \'crm_delete\')"') . chr(10);
	?>
		</td>
	  </tr>
	<?php
		  $crm_contacts->MoveNext();
		}
	?>
	</table>
  </fieldset>
  <?php } ?>
  <?php // *********************** Mailing/Main Address (only one allowed) ****************************** ?>
  <fieldset class="formAreaTitle">
    <legend><?php echo ACT_CATEGORY_I_ADDRESS; ?></legend>
      <table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td>
<?php // build a secondary toolbar for the contact form
	$passbar = new toolbar('i');
	$passbar->icon_list['cancel']['show'] = false;
	$passbar->icon_list['open']['show']   = false;
	$passbar->icon_list['save']['show']   = false;
	$passbar->icon_list['delete']['show'] = false;
	$passbar->icon_list['print']['show']  = false;
	$passbar->add_icon('new', 'onclick="clearContactForm()"', $order = 10);
	$passbar->icon_list['new']['icon']    = 'actions/contact-new.png';
	$passbar->icon_list['new']['text']    = TEXT_NEW_CONTACT;
	$passbar->add_icon('copy', 'onclick="copyContactAddress(\'' . $type . '\')"', 20);
	$passbar->icon_list['copy']['text']   = TEXT_COPY_ADDRESS;
	echo $output;
	echo $passbar->build_toolbar();
?>
    </td></tr></table>
    <table width="100%" class="formArea" border="0" cellspacing="2" cellpadding="2">
      <tr>
       <td align="right" class="main"><?php echo ACT_SHORT_NAME . html_hidden_field('i_id', ''); ?></td>
       <td class="main"><?php echo html_input_field('i_short_name', $cInfo->i_short_name, 'size="21" maxlength="20"', true); ?></td>
       <td align="right" class="main"><?php echo TEXT_TITLE; ?></td>
       <td class="main"><?php echo html_input_field('i_contact_middle', $cInfo->i_contact_middle, 'size="33" maxlength="32"', false); ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><?php echo GEN_FIRST_NAME; ?></td>
        <td class="main"><?php echo html_input_field('i_contact_first', $cInfo->i_contact_first, 'size="33" maxlength="32"', false); ?></td>
        <td align="right" class="main"><?php echo GEN_LAST_NAME; ?></td>
        <td class="main"><?php echo html_input_field('i_contact_last', $cInfo->i_contact_last, 'size="33" maxlength="32"', false); ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><?php echo ACT_ACCOUNT_NUMBER; ?></td>
        <td class="main"><?php echo html_input_field('i_account_number', $cInfo->i_account_number, 'size="17" maxlength="16"'); ?></td>
        <td align="right" class="main"><?php echo ACT_ID_NUMBER; ?></td>
        <td class="main"><?php echo html_input_field('i_gov_id_number', $cInfo->i_gov_id_number, 'size="17" maxlength="16"'); ?></td>
      </tr>
    </table>
    <table width="100%" class="formArea" border="0" cellspacing="0" cellpadding="0">
      <?php echo draw_address_fields($cInfo, 'im', false, false, false); ?>
    </table>
  </fieldset>
</div>
