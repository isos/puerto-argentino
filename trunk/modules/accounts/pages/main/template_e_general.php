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
//  Path: /modules/accounts/pages/main/template_e_general.php
//
echo html_hidden_field('account_number', $cInfo->account_number); // not used for employees
?>
<div id="cat_general" class="tabset_content">
  <h2 class="tabset_label"><?php echo TEXT_GENERAL; ?></h2>
  <fieldset class="formAreaTitle">
  <legend><?php echo ACT_CATEGORY_CONTACT; ?></legend>
  <table class="formArea" border="0" cellspacing="2" cellpadding="2">
    <tr>
     <td class="main" align="right"><?php echo constant('ACT_' . strtoupper($type) . '_SHORT_NAME'); ?></td>
     <td class="main"><?php echo html_input_field('short_name', $cInfo->short_name, 'size="21" maxlength="20"', true); ?></td>
	 <td class="main" align="right"><?php echo constant('ACT_' . strtoupper($type) . '_ID_NUMBER'); ?></td>
	 <td class="main"><?php echo html_input_field('gov_id_number', $cInfo->gov_id_number, 'size="17" maxlength="16"'); ?></td>
     <td class="main" align="right"><?php echo TEXT_INACTIVE; ?></td>
     <td class="main"><?php echo html_checkbox_field('inactive', '1', $cInfo->inactive); ?></td>
    </tr>
    <tr>
      <td class="main" align="right"><?php echo GEN_FIRST_NAME; ?></td>
      <td class="main"><?php echo html_input_field('contact_first', $cInfo->contact_first, 'size="33" maxlength="32"', false); ?></td>
      <td class="main" align="right"><?php echo GEN_MIDDLE_NAME; ?></td>
      <td class="main"><?php echo html_input_field('contact_middle', $cInfo->contact_middle, 'size="33" maxlength="32"', false); ?></td>
      <td class="main" align="right"><?php echo GEN_LAST_NAME; ?></td>
      <td class="main"><?php echo html_input_field('contact_last', $cInfo->contact_last, 'size="33" maxlength="32"', false); ?></td>
    </tr>
    <tr>
	  <td class="main" align="right"><?php echo constant('ACT_' . strtoupper($type) . '_REP_ID'); ?></td>
	  <td class="main">
	  <?php
		$default_selection = ($action == 'new' ? EMP_DEFAULT_DEPARTMENT : $cInfo->dept_rep_id);
		$selection_array = gen_get_pull_down(TABLE_DEPARTMENTS, true, 1);
		echo html_pull_down_menu('dept_rep_id', $selection_array, $default_selection);
	  ?>
	  </td>
      <td class="main">&nbsp;</td>
      <td class="main">&nbsp;</td>
      <td class="main">&nbsp;</td>
      <td class="main">&nbsp;</td>
    </tr>
    <tr>
	  <td class="main" align="right"><?php echo TEXT_EMPLOYEE_ROLES; ?></td>
	  <?php 
	    $col_count = 1;
		foreach ($employee_types as $key => $value) {
		  $preset = (($action == 'new' && $key == 'e') || (strpos($cInfo->gl_type_account, $key) !== false)) ? '1' : '0';
		  echo '<td class="main">' . html_checkbox_field('gl_type_account[' . $key . ']', '1', $preset) . '&nbsp;' . $value . '</td>';
		  $col_count++;
		  if ($col_count == 6) {
		    echo '</tr><tr>' . chr(10);
			echo '<td class="main">&nbsp;</td>';
		    $col_count = 1;
		  }
		}
	  ?>
    </tr>
  </table>
  </fieldset>

<?php // *********************** Mailing/Main Address (only one allowed) ****************************** ?>
  <fieldset class="formAreaTitle">
    <legend><?php echo ACT_CATEGORY_M_ADDRESS; ?></legend>
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