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
//  Path: /modules/accounts/pages/main/template_detail.php
//

// start the form
echo html_form('accounts', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);
echo html_hidden_field('id', $cInfo->id) . chr(10);
echo html_hidden_field('del_add_id', '') . chr(10);
echo html_hidden_field('del_pmt_id', '') . chr(10);
echo html_hidden_field('payment_id', '') . chr(10);

// customize the toolbar actions
if ($action == 'properties') {
  $toolbar->icon_list['cancel']['params'] = 'onclick="self.close()"';
  $toolbar->icon_list['save']['show']     = false;
} else {
  $toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL') . '\'"';
  $toolbar->icon_list['save']['params']   = 'onclick="submitToDo(\'save\')"';
  if ($security_level < 2) $toolbar->icon_list['save']['show'] = false;
}
$toolbar->icon_list['open']['show']       = false;
$toolbar->icon_list['delete']['show']     = false;
$toolbar->icon_list['print']['show']      = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
  foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
switch ($type) {
  case 'c': $toolbar->add_help('07.03.02.02'); break;
  case 'v': $toolbar->add_help('07.02.02.02'); break;
  case 'e': $toolbar->add_help('07.07.01.02'); break;
  case 'b': $toolbar->add_help('07.08.04');    break;
  default:
}
if ($search_text) $toolbar->search_text = $search_text;
echo $toolbar->build_toolbar(); 

// Build the page
$custom_path = DIR_FS_MY_FILES . 'custom/accounts/main/extra_tabs.php';
if (file_exists($custom_path)) { include($custom_path); }

function tab_sort($a, $b) {
  if ($a['order'] == $b['order']) return 0;
  return ($a['order'] > $b['order']) ? 1 : -1;
}
usort($tab_list, 'tab_sort');

?>
<div class="pageHeading"><?php echo ($action == 'new') ? $page_title_new : constant('ACT_' . strtoupper($type) . '_PAGE_TITLE_EDIT') . ' - ' . $edit_text; ?></div>
<ul class="tabset_tabs">
<?php // build the tab list's
  $set_default = false;
  foreach ($tab_list as $value) {
  	echo '  <li><a href="#cat_' . $value['tag'] . '"' . (!$set_default ? ' class="active"' : '') . '>' . $value['text'] . '</a></li>' . chr(10);
	$set_default = true;
  }
?>
</ul>
<?php
  foreach ($tab_list as $value) {
  	if (file_exists(DIR_FS_MY_FILES . 'custom/accounts/main/template_' . $type . '_' . $value['tag'] . '.php')) {
	  include(DIR_FS_MY_FILES . 'custom/accounts/main/template_' . $type . '_' . $value['tag'] . '.php');
	} else {
	  include(DIR_FS_WORKING . 'pages/main/template_' . $type . '_' . $value['tag'] . '.php');
	}
  }
?>
</form>