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
//  Path: /modules/accounts/pages/main/template_j_general.php
//

// *********************** Display account information ****************************** ?>
<script type="text/javascript">
var dateFrom = new ctlSpiffyCalendarBox("dateFrom", "accounts", "contact_first","btnDate2", "<?php echo isset($cInfo->contact_first) ? $cInfo->contact_first : ''; ?>", scBTNMODE_CALBTN);
var dateTo   = new ctlSpiffyCalendarBox("dateTo",   "accounts", "contact_last", "btnDate2", "<?php echo isset($cInfo->contact_last)  ? $cInfo->contact_last  : ''; ?>", scBTNMODE_CALBTN);
</script>

<div id="cat_general" class="tabset_content">
  <h2 class="tabset_label"><?php echo TEXT_GENERAL; ?></h2>
  <fieldset class="formAreaTitle">
  <legend><?php echo ACT_CATEGORY_CONTACT; ?></legend>
  <table width="100%" class="formArea" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td align="right" class="main"><?php echo constant('ACT_' . strtoupper($type) . '_SHORT_NAME'); ?></td>
      <td class="main"><?php echo html_input_field('short_name', $cInfo->short_name, 'size="21" maxlength="20"', true); ?></td>
      <td align="right" class="main"><?php echo TEXT_INACTIVE; ?></td>
      <td class="main">
<?php
echo html_checkbox_field('inactive', '1', $cInfo->inactive) . ' ';
echo constant('ACT_' . strtoupper($type) . '_ACCOUNT_NUMBER') . ' ';
echo html_radio_field('account_number', 1, ($cInfo->account_number == '1' ? true : false)) . TEXT_YES . chr(10);
echo html_radio_field('account_number', 2, (($cInfo->account_number == '' || $cInfo->account_number == '2') ? true : false)) . TEXT_NO  . chr(10);
?>
	  </td>
    </tr>
    <tr>
      <td align="right" class="main"><?php echo constant('ACT_' . strtoupper($type) . '_REP_ID'); ?></td>
      <td class="main">
		  <?php
			$default_selection = ($action == 'new' ? AR_DEF_GL_SALES_ACCT : $cInfo->dept_rep_id);
			$selection_array = gen_get_rep_ids('c');
			echo html_pull_down_menu('dept_rep_id', $selection_array, $default_selection);
		  ?>
	  </td>
      <td align="right" class="main"><?php echo TEXT_START_DATE; ?></td>
      <td class="main">
	    <script type="text/javascript">dateFrom.writeControl(); dateFrom.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script>
	    <?php //echo html_input_field('contact_first', $cInfo->contact_first, 'size="33" maxlength="32"', false); ?>
	  </td>
    </tr>
    <tr>
      <td align="right" class="main"><?php echo constant('ACT_' . strtoupper($type) . '_ID_NUMBER'); ?></td>
      <td class="main"><?php echo html_input_field('gov_id_number', $cInfo->gov_id_number, 'size="17" maxlength="16"'); ?></td>
      <td align="right" class="main"><?php echo TEXT_END_DATE; ?></td>
      <td class="main">
	    <script type="text/javascript">dateTo.writeControl(); dateTo.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script>
		<?php //echo html_input_field('contact_last', $cInfo->contact_last, 'size="33" maxlength="32"', false); ?>
	  </td>
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
