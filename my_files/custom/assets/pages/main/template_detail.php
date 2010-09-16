<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2008 PhreeSoft, LLC                               |
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
//  Path: /modules/assets/pages/main/template_detail.php
//

// start the form
echo html_form('assets', FILENAME_DEFAULT, gen_get_all_get_params(array('action', 'cID', 'asset_id')), 'post', 'enctype="multipart/form-data"');

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);
echo html_hidden_field('rowSeq', $cInfo->id) . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action','module')) . 'module=main', 'SSL') . '\'"';
$toolbar->icon_list['open']['show'] = false;
$toolbar->icon_list['delete']['show'] = false;
if ($security_level > 2) {
	$toolbar->icon_list['save']['params'] = 'onclick="submitToDo(\'save\')"';
} else {
	$toolbar->icon_list['save']['show'] = false;
}
$toolbar->icon_list['print']['show'] = false;
$toolbar->add_help('');
echo $toolbar->build_toolbar(); 
?>
<div class="pageHeading"><?php echo MENU_HEADING_ASSETS . ' - ' . TEXT_ASSET_ID . '# ' . $cInfo->asset_id; ?></div>
<ul class="tabset_tabs">
<?php 
	echo '  <li><a href="#' . TEXT_GENERAL . '" class="active">' . TEXT_GENERAL . '</a></li>' . chr(10);
	while (!$category_list->EOF) {
		echo '  <li><a href="#cat_' . $category_list->fields['category_id'] . '">' . $category_list->fields['category_name'] . '</a></li>' . chr(10);
		$category_list->MoveNext();
	} 
?>
</ul>

<!-- start the tabsets -->
<div id="<?php echo TEXT_GENERAL;?>" class="tabset_content">
  <h2 class="tabset_label"><?php echo TEXT_GENERAL; ?></h2>
  <table border="0" cellspacing="2" cellpadding="2">
	<tr>
	  <td class="main"><?php echo TEXT_ASSET_ID; ?></td>
	  <td class="main">
		<?php echo html_input_field('asset_id', $cInfo->asset_id, 'readonly', false); ?>
		<?php echo TEXT_INACTIVE; ?>
		<?php echo html_checkbox_field('inactive', '1', $cInfo->inactive); ?>
	  </td>
	  <td rowspan="4" class="main" align="center">
		<?php if ($cInfo->image_with_path) { // show image if it is defined
			echo html_image(DIR_WS_HTTPS_ADMIN . 'my_files/' . $_SESSION['company'] . '/assets/images/' . $cInfo->image_with_path, $cInfo->image_with_path, '', '100', 'style="cursor:pointer" onclick="ImgPopup(\'' . DIR_WS_HTTPS_ADMIN . 'my_files/' . $_SESSION['company'] . '/assets/images/' . $cInfo->image_with_path . '\')" LANGUAGE="javascript"');
		} else echo '&nbsp;'; ?>
	  </td>
	  <td class="main"><?php echo ASSETS_ENTRY_SELECT_IMAGE . ' (' . TEXT_REMOVE . ' ' . html_checkbox_field('remove_image', '1', $cInfo->remove_image) . ')'; ?></td>
	</tr>
	<tr>
	  <td class="main"><?php echo ASSETS_ENTRY_ASSETS_DESC_SHORT; ?></td>
	  <td class="main"><?php echo html_input_field('description_short', $cInfo->description_short, 'size="33" maxlength="32"', false); ?></td>
	  <td class="main"><?php echo html_file_field('asset_image'); ?></td>
	</tr>
	<tr>
	  <td class="main"><?php echo ASSETS_ENTRY_ASSETS_TYPE; ?></td>
	  <td class="main"><?php echo html_hidden_field('asset_type', $cInfo->asset_type);
		echo html_input_field('inv_type_desc', $assets_types[$cInfo->asset_type], 'readonly', false); ?> </td>
	  <td class="main"><?php echo ASSETS_ENTRY_IMAGE_PATH; ?></td>
	</tr>
	<tr>
	  <td class="main"><?php echo ASSETS_ENTRY_FULL_PRICE; ?></td>
	  <td class="main">
	  	<?php echo html_input_field('full_price', $currencies->format($cInfo->full_price), 'size="11" maxlength="10" style="text-align:right"', false) . (ENABLE_MULTI_CURRENCY ? (' (' . DEFAULT_CURRENCY . ')') : ''); 
		?>
	  </td>
	  <td class="main">
		<?php echo html_hidden_field('image_with_path', $cInfo->image_with_path); 
		echo html_input_field('asset_path', substr($cInfo->image_with_path, 0, strrpos($cInfo->image_with_path, '/'))); ?>
	  </td>
	</tr>
	<tr>
	  <td class="main"><?php echo ASSETS_ENTRY_ASSETS_SERIALIZE; ?></td>
	  <td class="main"><?php echo html_input_field('serial_number', $cInfo->serial_number, 'size="33" maxlength="32"'); ?></td>
	  <td class="main"><?php echo '&nbsp;'; ?></td>
	  <td class="main"><?php echo '&nbsp;'; ?></td>
	</tr>
	<tr>
	  <td class="main" valign="top"><?php echo ASSETS_ENTRY_ASSETS_DESC_PURCHASE; ?></td>
	  <td colspan="3" class="main"><?php echo html_textarea_field('description_long', true, 75, 3, $cInfo->description_long, '', $reinsert_value = true); ?></td>
	</tr>
	<tr>
	  <td class="main"><?php echo ASSETS_ENTRY_ACCT_SALES; ?></td>
	  <td class="main"><?php echo html_pull_down_menu('account_asset', $gl_array_list, $cInfo->account_asset); ?></td>
	  <td class="main"><?php echo ASSETS_DATE_ACCOUNT_CREATION; ?></td>
	  <td class="main"><script language="javascript">date1.writeControl(); date1.displayLeft=true; date1.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script></td>
	</tr>
	<tr>
	  <td class="main"><?php echo ASSETS_ENTRY_ACCT_INV; ?></td>
	  <td class="main"><?php echo html_pull_down_menu('account_depreciation', $gl_array_list, $cInfo->account_depreciation); ?></td>
	  <td class="main"><?php echo ASSETS_DATE_LAST_UPDATE; ?></td>
	  <td class="main"><script language="javascript">date2.writeControl(); date2.displayLeft=true; date2.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script></td>
	</tr>
	<tr>
	  <td class="main"><?php echo ASSETS_ENTRY_ACCT_COS; ?></td>
	  <td class="main"><?php echo html_pull_down_menu('account_maintenance', $gl_array_list, $cInfo->account_maintenance); ?></td>
	  <td class="main"><?php echo ASSETS_DATE_LAST_JOURNAL_DATE; ?></td>
	  <td class="main"><script language="javascript">date3.writeControl(); date3.displayLeft=true; date3.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script></td>
	</tr>
  </table>
</div>

<?php
//********************************* List Custom Fields Here ***********************************
$category_list->Move(0);
$category_list->MoveNext();
while (!$category_list->EOF) {
	echo '<div id="cat_' . $category_list->fields['category_id'] . '" class="tabset_content">' . chr(10);
	echo '  <h2 class="tabset_label">' . $category_list->fields['category_name'] . '</h2>' . chr(10);
	echo '  <table border="0" cellspacing="2" cellpadding="2">' . chr(10);
	$field_list->Move(0);
	$field_list->MoveNext();
	while (!$field_list->EOF) {
		if ($category_list->fields['category_id'] == $field_list->fields['category_id']) {
			echo build_field_entry($field_list->fields, $cInfo) . chr(10);
		}
		$field_list->MoveNext();
	}
	echo '  </table>';
	echo '</div>' . chr(10);
	$category_list->MoveNext();
}
// *********************** End Custom Fields  ************************************* ?>

</form>