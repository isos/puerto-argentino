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
//  Path: /modules/inventory/pages/inv_fields/template_detail.php
//

// start the form
echo html_form('inventory', FILENAME_DEFAULT, gen_get_all_get_params(array('action')));

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);
echo html_hidden_field('rowSeq', $cInfo->inv_field_id) . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL') . '\'"';
$toolbar->icon_list['open']['show'] = false;
$toolbar->icon_list['delete']['show'] = false;
if (($action == 'edit' || $action == 'update') && $security_level > 2) {
	$toolbar->icon_list['save']['params'] = 'onclick="submitToDo(\'update\')"';
} elseif ($security_level > 1) {
	$toolbar->icon_list['save']['params'] = 'onclick="submitToDo(\'save\')"';
} else {
	$toolbar->icon_list['save']['show'] = false;
}
$toolbar->icon_list['print']['show'] = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('07.04.05.01');
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo INV_FIELD_HEADING_TITLE; ?></div>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
	<td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
	  <tr>
		<td class="main"><?php echo INV_FIELD_NAME; ?></td>
		<td class="main">
<?php
	$system_disable = false;
  	if ($cInfo->category_id == '0') {
		$system_disable = true; 
	}
	if ($action <> 'new' || $system_disable) {
		echo html_hidden_field('category_id', '0');
		echo html_input_field('field_name', $cInfo->field_name, 'readonly="readonly" size="33" maxlength="32"', false);
	} else {
		echo html_input_field('field_name', '', 'size="33" maxlength="32"', false);
	}
?>
		</td>
		<td class="main" align="right"><?php echo INV_DESCRIPTION; ?></td>
		<td class="main">
<?php
	echo html_input_field('description', $cInfo->description, 'size="65" maxlength="64"', false);
?>
		</td>
	  </tr>
	  <tr>
		<td colspan="2" class="main"><?php echo INV_FIELD_NAME_RULES; ?></td>
		<td class="main"><?php echo INV_CATEGORY_MEMBER; ?></td>
		<td class="main">
<?php
if ($cInfo->category_id == '0') {
	$list_array = array('id' => '0', 'text' => TEXT_SYSTEM);
} else {
	$list_array = gen_build_pull_down($category_array);
	array_shift($list_array);
}
echo html_pull_down_menu('category_id', $list_array, $cInfo->category_id, ($system_disable ? ' disabled="disabled" ' : ''));
?>
		</td>
	  </tr>
	</table></td>
  </tr>
  
  <tr>
	<td><table border="0" width="100%" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="formAreaTitle"><?php echo INV_HEADING_FIELD_PROPERTIES; ?></td>
	  </tr>
	</table></td>
  </tr>

  <tr>
	<td class="formArea"><table border="1" cellspacing="2" cellpadding="1">
	  <tr>
		<td class="main" valign="top">
<?php
	echo html_radio_field('entry_type', $value = 'text', ($cInfo->entry_type=='text' ? true : false), '', ($system_disable ? ' disabled="disabled" ' : ''));
	echo '&nbsp;' . INV_LABEL_TEXT_FIELD;
	echo '<br />' . html_radio_field('entry_type', $value = 'html', ($cInfo->entry_type=='html' ? true : false), '', ($system_disable ? ' disabled="disabled" ' : ''));
	echo '&nbsp;' . INV_LABEL_HTML_TEXT_FIELD;
?>
		</td>
		<td class="main">
<?php
	echo INV_LABEL_MAX_NUM_CHARS;
	echo '<br />' . html_input_field('text_length', ($cInfo->text_length ? $cInfo->text_length : '32'), ($system_disable ? ' disabled="disabled" ' : '') . 'size="10" maxlength="9"', false);
	echo '<br />' . INV_LABEL_DEFAULT_TEXT_VALUE . '<br />' . INV_LABEL_MAX_255;
	echo '<br />' . html_textarea_field('text_default', 35, 6, $cInfo->text_default, ($system_disable ? ' disabled="disabled" ' : ''));
?>
		</td>
	  </tr>
	  <tr>
		<td class="main" valign="top">
<?php
	echo html_radio_field('entry_type', $value = 'hyperlink', ($cInfo->entry_type=='hyperlink' ? true : false), '', ($system_disable ? ' disabled="disabled" ' : ''));
	echo '&nbsp;' . INV_LABEL_HYPERLINK;
	echo '<br />' . html_radio_field('entry_type', $value = 'image_link', ($cInfo->entry_type=='image_link' ? true : false), '', ($system_disable ? ' disabled="disabled" ' : ''));
	echo '&nbsp;' . INV_LABEL_IMAGE_LINK;
	echo '<br />' . html_radio_field('entry_type', $value = 'inventory_link', ($cInfo->entry_type=='inventory_link' ? true : false), '', ($system_disable ? ' disabled="disabled" ' : ''));
	echo '&nbsp;' . INV_LABEL_INVENTORY_LINK;
?>
		</td>
		<td class="main">
<?php
	echo INV_LABEL_FIXED_255_CHARS;
	echo '<br />' . INV_LABEL_DEFAULT_TEXT_VALUE;
	echo '<br />' . html_textarea_field('link_default', 35, 3, $cInfo->link_default, ($system_disable ? ' disabled="disabled" ' : ''));
?>
		</td>
	  </tr>
	  <tr>
		<td class="main" valign="top">
<?php
	echo html_radio_field('entry_type', $value = 'integer', ($cInfo->entry_type=='integer' ? true : false), '', ($system_disable ? ' disabled="disabled" ' : ''));
	echo '&nbsp;' . INV_LABEL_INTEGER_FIELD;
?>
		</td>
		<td class="main">
<?php
	foreach ($integer_lengths as $key=>$value) {
      $integer_pulldown_array[] = array('id' => $key, 'text' => $value);
	}
	echo INV_LABEL_INTEGER_RANGE;
	echo '<br />' . html_pull_down_menu('integer_range', $integer_pulldown_array, $cInfo->integer_range, ($system_disable ? ' disabled="disabled" ' : ''));
	echo '<br />' . INV_LABEL_DEFAULT_TEXT_VALUE;
	echo html_input_field('integer_default', $cInfo->integer_default, ($system_disable ? ' disabled="disabled" ' : '') . 'size="16"', false);
?>
		</td>
	  </tr>
	  <tr>
		<td class="main" valign="top">
<?php
	echo html_radio_field('entry_type', $value = 'decimal', ($cInfo->entry_type=='decimal' ? true : false), '', ($system_disable ? ' disabled="disabled" ' : ''));
	echo '&nbsp;' . INV_LABEL_DECIMAL_FIELD;
?>
		</td>
		<td class="main">
<?php
	foreach ($decimal_lengths as $key=>$value) {
      $decimal_pulldown_array[] = array('id' => $key, 'text' => $value);
	}
	echo INV_LABEL_DECIMAL_RANGE;
	echo html_pull_down_menu('decimal_range', $decimal_pulldown_array, $cInfo->decimal_range, ($system_disable ? ' disabled="disabled" ' : ''));
	echo '<br />' . INV_LABEL_DEFAULT_DISPLAY_VALUE;
	echo html_input_field('decimal_display', $cInfo->decimal_display, ($system_disable ? ' disabled="disabled" ' : '') . 'size="6" maxlength="5"', false);
	echo '<br />' . INV_LABEL_DEFAULT_TEXT_VALUE;
	echo html_input_field('decimal_default', $cInfo->decimal_default, ($system_disable ? ' disabled="disabled" ' : '') . 'size="16"', false);
?>
		</td>
	  </tr>
	  <tr>
		<td class="main" valign="top">
<?php
	echo html_radio_field('entry_type', $value = 'drop_down', ($cInfo->entry_type=='drop_down' ? true : false), '', ($system_disable ? ' disabled="disabled" ' : ''));
	echo '&nbsp;' . INV_LABEL_DROP_DOWN_FIELD;
	echo '<br />' . html_radio_field('entry_type', $value = 'radio', ($cInfo->entry_type=='radio' ? true : false), '', ($system_disable ? ' disabled="disabled" ' : ''));
	echo '&nbsp;' . INV_LABEL_RADIO_FIELD;
?>
		</td>
		<td class="main">
<?php
	echo INV_LABEL_CHOICES;
	echo '<br />' . html_textarea_field('radio_default', 35, 6, $cInfo->radio_default, ($system_disable ? ' disabled="disabled" ' : ''));
?>
		</td>
	  </tr>
	  <tr>
		<td class="main" valign="top">
<?php
	echo html_radio_field('entry_type', $value = 'check_box', ($cInfo->entry_type=='check_box' ? true : false), '', ($system_disable ? ' disabled="disabled" ' : ''));
	echo '&nbsp;' . INV_LABEL_CHECK_BOX_FIELD;
?>
		</td>
		<td class="main">
<?php
	foreach ($check_box_choices as $key=>$value) {
      $check_box_pulldown_array[] = array('id' => $key, 'text' => $value);
	}
	echo INV_LABEL_DEFAULT_TEXT_VALUE;
	echo html_pull_down_menu('check_box_range', $check_box_pulldown_array, $cInfo->check_box_range, ($system_disable ? ' disabled="disabled" ' : ''));
?>
		</td>
	  </tr>
	  <tr>
		<td class="main" valign="top">
<?php
	echo html_radio_field('entry_type', $value = 'date', ($cInfo->entry_type=='date' ? true : false), '', ($system_disable ? ' disabled="disabled" ' : ''));
	echo '&nbsp;' . TEXT_DATE;
?>
		</td>
		<td class="main">&nbsp;</td>
	  </tr>
	  <tr>
		<td class="main" valign="top">
<?php
	echo html_radio_field('entry_type', $value = 'time', ($cInfo->entry_type=='time' ? true : false), '', ($system_disable ? ' disabled="disabled" ' : ''));
	echo '&nbsp;' . TEXT_TIME;
?>
		</td>
		<td class="main">&nbsp;</td>
	  </tr>
	  <tr>
		<td class="main" valign="top">
<?php
	echo html_radio_field('entry_type', $value = 'date_time', ($cInfo->entry_type=='date_time' ? true : false), '', ($system_disable ? ' disabled="disabled" ' : ''));
	echo '&nbsp;' . INV_LABEL_DATE_TIME_FIELD;
?>
		</td>
		<td class="main">&nbsp;</td>
	  </tr>
	  <tr>
		<td class="main" valign="top">
<?php
	echo html_radio_field('entry_type', $value = 'time_stamp', ($cInfo->entry_type=='time_stamp' ? true : false), '', ($system_disable ? ' disabled="disabled" ' : ''));
	echo '&nbsp;' . INV_LABEL_TIME_STAMP_FIELD;
?>
		</td>
		<td class="main"><?php echo INV_LABEL_TIME_STAMP_VALUE; ?>
		</td>
	  </tr>
	</table></td>
  </tr>
</table>
</form>