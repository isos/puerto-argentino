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
//  Path: /modules/general/pages/users/template_detail.php
//

// start the form
echo html_form('users', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo',   '')        . chr(10);
echo html_hidden_field('rowSeq', $admin_id) . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL') . '\'"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['print']['show']    = false;
if ($security_level > 2) {
  $toolbar->icon_list['save']['params'] = 'onclick="submitToDo(\'save\')"';
} else {
  $toolbar->icon_list['save']['show']   = false;
}

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('07.08.07');
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo HEADING_TITLE_USER_INFORMATION; ?></div>
  <fieldset class="formAreaTitle">
  <legend><?php echo TEXT_GENERAL; ?></legend>
  <table border="0" align="center" cellspacing="1" cellpadding="1">
  <tr>
    <td align="right"><?php echo GEN_USERNAME . ' '  . html_input_field('admin_name', $uInfo->admin_name, 'size="25"'); ?></td>
    <td><?php echo TEXT_INACTIVE . ' ' . html_checkbox_field('inactive', '1', ($uInfo->inactive ? true : false)); ?></td>
    <td><?php echo GEN_DISPLAY_NAME . ' ' . html_input_field('display_name', $uInfo->display_name, 'size="25"'); ?></td>
  </tr>
  <tr>
    <td align="right"><?php echo TEXT_PASSWORD . ' ' . html_password_field('password_new', ''); ?></td>
    <td><?php echo '&nbsp;'; ?></td>
    <td><?php echo GEN_EMAIL . ' ' . html_input_field('admin_email', $uInfo->admin_email, 'size="33"'); ?></td>
  </tr>
  <tr>
    <td align="right"><?php echo TEXT_CONFIRM_PASSWORD . ' ' . html_password_field('password_conf', ''); ?></td>
    <td><?php echo '&nbsp;'; ?></td>
    <td><?php echo GEN_ACCOUNT_LINK . ' ' . html_pull_down_menu('account_id', gen_get_account_array_by_type('e'), $uInfo->account_id, ''); ?></td>
  </tr>
  </table>
  </fieldset>

  <fieldset class="formAreaTitle">
  <legend><?php echo TEXT_PROFILE; ?></legend>
  <table border="0" align="center" cellspacing="1" cellpadding="1">
  <tr>
    <td><?php echo GEN_DEFAULT_STORE . ' ' . html_pull_down_menu('def_store_id',  gen_get_store_ids(), $error ? $_POST['def_store_id'] : $uInfo->prefs['def_store_id'], ''); ?></td>
    <td><?php echo GEN_DEF_CASH_ACCT . ' ' . html_pull_down_menu('def_cash_acct', gen_coa_pull_down(), $error ? $_POST['def_cash_acct'] : $uInfo->prefs['def_cash_acct'], ''); ?></td>
    <td><?php echo '&nbsp;'; ?></td>
  </tr>
  <tr>
    <td><?php echo GEN_RESTRICT_STORE . ' ' . html_checkbox_field('restrict_store', '1', (($error && $_POST['restrict_store']) || $uInfo->prefs['restrict_store']) ? true : false); ?></td>
    <td><?php echo GEN_DEF_AR_ACCT    . ' ' . html_pull_down_menu('def_ar_acct', gen_coa_pull_down(), $error ? $_POST['def_ar_acct'] : $uInfo->prefs['def_ar_acct'], ''); ?></td>
    <td><?php echo '&nbsp;'; ?></td>
  </tr>
  <tr>
    <td><?php echo GEN_RESTRICT_PERIOD . ' ' . html_checkbox_field('restrict_period', '1', (($error && $_POST['restrict_period']) || $uInfo->prefs['restrict_period']) ? true : false); ?></td>
    <td><?php echo GEN_DEF_AP_ACCT     . ' ' . html_pull_down_menu('def_ap_acct', gen_coa_pull_down(), $error ? $_POST['def_ap_acct'] : $uInfo->prefs['def_ap_acct'], ''); ?></td>
    <td><?php echo '&nbsp;'; ?></td>
  </tr>
  </table>
  </fieldset>

  <fieldset class="formAreaTitle">
  <legend><?php echo TEXT_SECURITY_SETTINGS; ?></legend>
    <div><?php echo TEXT_FILL_ALL_LEVELS . ' ' . html_pull_down_menu('fill_all', $fill_all_values, '-1', 'onchange="submitToDo(\'fill_all\')"'); ?></div>
    <ul class="tabset_tabs">
<?php 
	$show_active = false;
	foreach ($pb_headings as $key => $value) {
		$active = !$show_active ? ' class="active"' : '';
		echo '<li><a href="#usr_' . $key . '"' . $active . '>' .  $value['text'] . '</a></li>' . chr(10);
		$show_active = true;
	}
?>
    </ul>
<?php
$settings     = gen_parse_permissions($uInfo->admin_security);
$column_break = true;
// array pb_headings is defined in /includes/header_navigation.php
foreach ($pb_headings as $key => $menu_heading) {
	echo '<div id="usr_' . $key . '" class="tabset_content">' . chr(10);
	echo '<h2 class="tabset_label">' . $menu_heading['text'] . '</h2>' . chr(10);
	echo '<table width="95%" border="0" align="center" cellspacing="0" cellpadding="0">' . chr(10);
	echo '<tr valign="top">' . chr(10);
	echo '<td width="50%">&nbsp;</td>' . chr(10);
	echo '<td width="10%" align="center">' . TEXT_FULL      . '</td>' . chr(10);
	echo '<td width="10%" align="center">' . TEXT_EDIT      . '</td>' . chr(10);
	echo '<td width="10%" align="center">' . TEXT_ADD       . '</td>' . chr(10);
	echo '<td width="10%" align="center">' . TEXT_READ_ONLY . '</td>' . chr(10);
	echo '<td width="10%" align="center">' . TEXT_NONE      . '</td></tr>' . chr(10);
	foreach ($menu as $item)  {
//echo 'item = '; print_r($item); echo '<br />';
		if (isset($item['heading'])) {
			if ($item['heading'] == $menu_heading['text']) {
				if ($item['text'] == TEXT_REPORTS && $item['heading'] <> MENU_HEADING_TOOLS) continue;  // special case for reports listings not in Tools menu
				$checked = array();
				if ($item['hide'] === true) {
					continue; // skip if menu only item
				} elseif (isset($settings[$item['security_id']])) {
					$checked[0] = false;
					$checked[$settings[$item['security_id']]] = true;
				} elseif ($error) {
					$checked[0] = false;
					$checked[$_POST['sID_' . $item['security_id']]] = true;
				} else {
					$checked[0] = true;	// default to no access
				}
				echo '<tr valign="top" class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">';
				echo '<td>' . $item['text'] . '</td>' . chr(10);
				echo '<td align="center">' . html_radio_field('sID_' . $item['security_id'], '4', $checked[4]) . '</td>' . chr(10);
				echo '<td align="center">' . html_radio_field('sID_' . $item['security_id'], '3', $checked[3]) . '</td>' . chr(10);
				echo '<td align="center">' . html_radio_field('sID_' . $item['security_id'], '2', $checked[2]) . '</td>' . chr(10);
				echo '<td align="center">' . html_radio_field('sID_' . $item['security_id'], '1', $checked[1]) . '</td>' . chr(10);
				echo '<td align="center">' . html_radio_field('sID_' . $item['security_id'], '0', $checked[0]) . '</td></tr>' . chr(10);
			}
		}
	}
	echo '</table></div>' . chr(10);
} ?>
  </fieldset>
</form>
