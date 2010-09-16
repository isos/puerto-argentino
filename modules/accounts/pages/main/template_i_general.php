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
//  Path: /modules/accounts/pages/main/template_i_general.php
//

// some setup
$acct_def = (!$cInfo->dept_rep_id) ? array() : array(array('id'=>$cInfo->dept_rep_id, 'text'=>gen_get_account_name($cInfo->dept_rep_id)));

// *********************** Display account information ****************************** ?>

<div id="cat_general" class="tabset_content">
  <h2 class="tabset_label"><?php echo TEXT_GENERAL; ?></h2>
  <fieldset class="formAreaTitle">
    <legend><?php echo ACT_CATEGORY_CONTACT; ?></legend>
    <table width="100%" class="formArea" border="0" cellspacing="2" cellpadding="2">
      <tr>
       <td align="right" class="main"><?php echo ACT_SHORT_NAME; ?></td>
       <td class="main">
	     <?php echo html_input_field('short_name', $cInfo->short_name, 'size="21" maxlength="20"', true); ?>
         <?php echo ' ' . TEXT_INACTIVE . ' '; ?>
         <?php echo html_checkbox_field('inactive', '1', $cInfo->inactive); ?>
	   </td>
       <td align="right" class="main"><?php echo TEXT_TITLE; ?></td>
       <td class="main"><?php echo html_input_field('contact_middle', $cInfo->contact_middle, 'size="33" maxlength="32"', false); ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><?php echo GEN_FIRST_NAME; ?></td>
        <td class="main"><?php echo html_input_field('contact_first', $cInfo->contact_first, 'size="33" maxlength="32"', false); ?></td>
        <td align="right" class="main"><?php echo GEN_LAST_NAME; ?></td>
        <td class="main"><?php echo html_input_field('contact_last', $cInfo->contact_last, 'size="33" maxlength="32"', false); ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><?php echo ACT_ACCOUNT_NUMBER; ?></td>
        <td class="main"><?php echo html_input_field('account_number', $cInfo->account_number, 'size="17" maxlength="16"'); ?></td>
        <td align="right" class="main"><?php echo ACT_ID_NUMBER; ?></td>
        <td class="main"><?php echo html_input_field('gov_id_number', $cInfo->gov_id_number, 'size="17" maxlength="16"'); ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><?php echo TEXT_LINK_TO . ' '; ?></td>
        <td class="main"><?php echo html_combo_box('dept_rep_id', $acct_def, $cInfo->dept_rep_id, 'onkeyup="loadContacts()"'); ?></td>
        <td class="main">&nbsp;</td>
        <td class="main">&nbsp;</td>
      </tr>
    </table>
  </fieldset>

<?php // *********************** Mailing/Main Address (only one allowed) ****************************** ?>
  <fieldset class="formAreaTitle">
    <legend><?php echo ACT_CATEGORY_I_ADDRESS; ?></legend>
    <table border="0" width="100%" cellspacing="2" cellpadding="2">
      <?php 
	    $var_name = $type . 'm_address';
		$temp_array = $cInfo->$var_name;
		$tmp = array();
		if (is_array($temp_array)) foreach ($temp_array[0] as $key => $value) {
		  $tmp[$type . 'm_' . $key] = $value;
		}
		$aInfo = new objectInfo($tmp);
	  	echo draw_address_fields($aInfo, $type . 'm', false, false, false); 
	  ?>
    </table>
  </fieldset>
</div>
