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
//  Path: /modules/services/pages/ship_mgr/template_main.php
//

// start the form
echo html_form('ship_mgr', FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'post', 'enctype="multipart/form-data"', true) . chr(10);

// include hidden fields
echo html_hidden_field('todo',   '')    . chr(10);
echo html_hidden_field('rowSeq', '')    . chr(10);
echo html_hidden_field('module_id', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['print']['show']    = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('09');
echo $toolbar->build_toolbar($add_search = false, false, true); 

// Build the page
?>
<div class="pageHeading"><?php echo BOX_SHIPPING_MANAGER; ?></div>
<div>
	  <ul class="tabset_tabs">
<?php 
	$show_active = false;
	$image_types = array('gif', 'png', 'jpg', 'jpeg');
	$path = DIR_WS_MODULES . 'services/shipping/images/';
	foreach ($installed_modules as $value) {
      $image_file = DIR_WS_MODULES . 'services/shipping/images/no_logo.png';
	  foreach ($image_types as $ext) {
	    if (file_exists('my_files/custom/services/shipping/images/' . $value . '_logo.' . $ext)) {
		  $image_file = 'my_files/custom/services/shipping/images/' . $value . '_logo.' . $ext;
		  break;
		}
	    if (file_exists(DIR_WS_MODULES . 'services/shipping/images/' . $value . '_logo.' . $ext)) {
		  $image_file = DIR_WS_MODULES . 'services/shipping/images/' . $value . '_logo.' . $ext;
		  break;
		}
	  }
	  $active = !$show_active ? ' class="active"' : '';
	  echo '<li><a href="#' . $value . '"' . $active . '><img src="' . $image_file . '" alt="' . $value . '" height="30" hspace="0" vspace="0" border="0" />' .  '</a></li>' . chr(10);
	  $show_active = true;
	}
?>
	  </ul>
<?php
	$modules_installed = explode(';', MODULE_SHIPPING_INSTALLED);
	foreach ($installed_modules as $value) {
		echo '<div id="' . $value . '" class="tabset_content">' . chr(10);
		echo '<h2 class="tabset_label">' . constant('MODULE_SHIPPING_' . strtoupper($value) . '_TEXT_TITLE') . '</h2>' . chr(10);
	    if (file_exists(DIR_FS_MY_FILES . 'custom/services/shipping/ship_mgr/' . $value . '.php')) {
		  include (DIR_FS_MY_FILES . 'custom/services/shipping/ship_mgr/' . $value . '.php');
		} else {
		  include (DIR_FS_WORKING . 'shipping/ship_mgr/' . $value . '.php');
		}
		echo '</div>' . chr(10);
	}
?>
</div>
</form>
