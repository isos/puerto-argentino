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
//  Path: /modules/services/pages/main/template_main.php
//

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['print']['show']    = false;
if ($subject_module->extra_buttons) $subject_module->customize_buttons();

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
  foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('07.08.09');
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo HEADING_TITLE_SERVICES; ?></div>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TEXT_SERVICE_NAME; ?></td>
                <td class="dataTableHeadingContent">&nbsp;</td>
                <td class="dataTableHeadingContentXtra"><?php echo TEXT_SORT_ORDER; ?></td>
<?php if ($module_type == 'payment') { ?>
                <td class="dataTableHeadingContent" align="center" width="100"><?php echo TEXT_STATUS; ?></td>
<?php } ?>
                <td class="dataTableHeadingContentXtra"><?php echo TEXT_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $file_extension = substr($PHP_SELF, strrpos($PHP_SELF, '.'));
  $directory_array = array();
  // standard modules
  if ($dir = @dir(DEFAULT_MOD_DIR)) {
    while ($file = $dir->read()) {
      if (!is_dir(DEFAULT_MOD_DIR . $file)) {
        if (substr($file, strrpos($file, '.')) == $file_extension) {
          $directory_array[] = $file;
        }
      }
    }
    $dir->close();
  }
  // custom modules
  if ($dir = @dir(CUSTOM_MOD_DIR)) {
    while ($file = $dir->read()) {
      if (!is_dir(CUSTOM_MOD_DIR . $file)) {
        if (substr($file, strrpos($file, '.')) == $file_extension) {
          $directory_array[] = $file;
        }
      }
    }
    $dir->close();
  }
  sort($directory_array);

  $installed_modules = array();
  for ($i=0, $n=sizeof($directory_array); $i<$n; $i++) {
    $file = $directory_array[$i];
	if (file_exists(DEFAULT_MOD_DIR . $file)) {
      include_once(DEFAULT_MOD_DIR . '../language/' . $_SESSION['language'] . '/modules/' . $file);
      include_once(DEFAULT_MOD_DIR . $file);
	} else {
      include_once(CUSTOM_MOD_DIR . '../language/' . $_SESSION['language'] . '/modules/' . $file);
      include_once(CUSTOM_MOD_DIR . $file);
	}
    $class = substr($file, 0, strrpos($file, '.'));
    if (class_exists($class)) {
      $module_set = new $class;
      if ($module_set->check() > 0) {
        if ($module_set->sort_order > 0) {
          $installed_modules[$module_set->sort_order] = $file;
        } else {
          $installed_modules[] = $file;
        }
      }
      if ((!isset($_GET['subject']) || (isset($_GET['subject']) && ($_GET['subject'] == $class))) && !isset($mInfo)) {
        $module_info = array(
			'code'        => $module_set->code,
			'title'       => $module_set->title,
			'description' => $module_set->description,
			'status'      => $module_set->check(),
		);
        $module_keys = $module_set->keys();
        $keys_extra  = array();
        for ($j=0, $k=sizeof($module_keys); $j<$k; $j++) {
          $key_value = $db->Execute("select configuration_title, configuration_value, configuration_key,
			configuration_description, use_function, set_function
			 from " . TABLE_CONFIGURATION . "
             where configuration_key = '" . $module_keys[$j] . "'");

          $keys_extra[$module_keys[$j]]['title']        = $key_value->fields['configuration_title'];
          $keys_extra[$module_keys[$j]]['value']        = $key_value->fields['configuration_value'];
          $keys_extra[$module_keys[$j]]['description']  = $key_value->fields['configuration_description'];
          $keys_extra[$module_keys[$j]]['use_function'] = $key_value->fields['use_function'];
          $keys_extra[$module_keys[$j]]['set_function'] = $key_value->fields['set_function'];
        }
        $module_info['keys'] = $keys_extra;
        $mInfo = new objectInfo($module_info);
      }
      if (isset($mInfo) && is_object($mInfo) && ($class == $mInfo->code) ) {
        if ($module_set->check() > 0) {
          echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('set', 'subject')) . 'set=' . $module_type . '&amp;subject=' . $class, 'SSL') . '\'">' . "\n";
        } else {
          echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . "\n";
        }
      } else {
        echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('set', 'subject')) . 'set=' . $module_type . '&amp;subject=' . $class, 'SSL') . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo $module_set->title; ?></td>
                <td class="dataTableContent"><?php echo $module_set->code; ?></td>
                <td class="dataTableContent" align="right">
				  <?php if (is_numeric($module_set->sort_order)) echo $module_set->sort_order; ?>
                  <?php
                    // show current status
                    if ($module_type == 'payment' || $module_type == 'shipping') {
                      echo '&nbsp;' . ((!empty($module_set->enabled) && is_numeric($module_set->sort_order)) ? html_icon('emotes/face-smile.png') : ((empty($module_set->enabled) && is_numeric($module_set->sort_order)) ? html_icon('categories/applications-development.png') : html_icon('actions/media-record.png')));
                    } else {
                      echo '&nbsp;' . (is_numeric($module_set->sort_order) ? html_icon('emotes/face-smile.png') : html_icon('actions/media-record.png'));
                    }
                  ?>
				</td>
<?php
  if ($module_type == 'payment') {
	echo '<td>&nbsp;</td>';
} ?>
                <td class="dataTableContent" align="right">
					<?php if (isset($mInfo) && is_object($mInfo) && ($class == $mInfo->code) ) {
						echo html_icon('actions/go-next.png'); 
					} else {
						echo '<a href="' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('set', 'subject')) . 'set=' . $module_type . '&amp;subject=' . $class, 'SSL') . '">' . html_icon('apps/help-browser.png', TEXT_INFO) . '</a>'; 
					} ?>
				&nbsp;</td>
              </tr>
<?php
    }
  }
  ksort($installed_modules);
  $check = $db->Execute("select configuration_value
                         from " . TABLE_CONFIGURATION . "
             where configuration_key = '" . $module_key . "'");

  if ($check->RecordCount() > 0) {
    if ($check->fields['configuration_value'] != implode(';', $installed_modules)) {
      $db->Execute("update " . TABLE_CONFIGURATION . "
                  set configuration_value = '" . implode(';', $installed_modules) . "', last_modified = now()
          where configuration_key = '" . $module_key . "'");
    }
  } else {
    $db->Execute("insert into " . TABLE_CONFIGURATION . "
                (configuration_title, configuration_key, configuration_value,
                 configuration_description, configuration_group_id, sort_order, date_added)
                values ('Installed Modules', '" . $module_key . "', '" . implode(';', $installed_modules) . "',
                        'This is automatically updated. No need to edit.', '6', '0', now())");
  }
?>
            </table></td>
<?php
  $heading  = array();
  $contents = array();
  switch ($action) {
    case 'edit':
      $keys = '';
      reset($mInfo->keys);
      while (list($key, $value) = each($mInfo->keys)) {
        $keys .= '<b>' . $value['title'] . '</b><br />' . $value['description'] . '<br />';
        if ($value['set_function']) {
          eval('$keys .= ' . $value['set_function'] . "'" . $value['value'] . "', '" . $key . "');");
        } else {
          $keys .= html_input_field('configuration[' . $key . ']', $value['value']);
        }
        $keys .= '<br /><br />';
      }
      $keys = substr($keys, 0, strrpos($keys, '<br /><br />'));
      $heading[] = array('text' => '<b>' . $mInfo->title . '</b>');
      $contents = array('form' => html_form('modules', FILENAME_DEFAULT, gen_get_all_get_params(array('action', 'set', 'subject')) . 'set=' . $module_type . ($_GET['subject'] != '' ? '&amp;subject=' . $_GET['subject'] : '') . '&amp;action=save'));
      if (ADMIN_CONFIGURATION_KEY_ON == 1) {
        $contents[] = array('text' => '<strong>Key: ' . $mInfo->code . '</strong><br />');
      }
      $contents[] = array('text' => $keys);
	  // special conditions 
	  if ($module_type == 'shipping' && $mInfo->code == 'fedex' && MODULE_SHIPPING_FEDEX_RATE_LICENSE == '' && MODULE_SHIPPING_FEDEX_ACCOUNT_NUMBER <> '') {
    	$contents[] = array('align' => 'center', 'text' => '<br />' . html_button_field('get_key', 'Get FedEx Meter Number', 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action', 'set', 'subject')) . 'set=' . $module_type .  '&amp;subject=fedex&amp;action=get_fedex_key', 'SSL') . '\'"'));
	  }
      $contents[] = array('align' => 'center', 'text' => '<br />' . html_submit_field('update', TEXT_UPDATE) . html_button_field('cancel', TEXT_CANCEL, 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action', 'set', 'subject')) . 'set=' . $module_type . ($_GET['subject'] != '' ? '&amp;subject=' . $_GET['subject'] : ''), 'SSL') . '\'"'));
      break;
    default:
      $heading[] = array('text' => '<b>' . $mInfo->title . '</b>');

      if ($mInfo->status == '1') {
        $keys = '';
        reset($mInfo->keys);
        while (list(, $value) = each($mInfo->keys)) {
          $keys .= '<b>' . $value['title'] . '</b><br />';
          if ($value['use_function']) {
            $use_function = $value['use_function'];
            $keys .= setup_call_function($use_function, $value['value']);
          } else {
            $keys .= $value['value'];
          }
          $keys .= '<br /><br />';
        }

        if (ADMIN_CONFIGURATION_KEY_ON == 1) {
          $contents[] = array('text' => '<strong>Key: ' . $mInfo->code . '</strong><br />');
        }
        $keys = substr($keys, 0, strrpos($keys, '<br /><br />'));
        $contents[] = array('align' => 'center', 'text' => (($security_level > 3) ? html_button_field('remove', TEXT_REMOVE, 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action', 'set', 'subject')) . 'set=' . $module_type . '&amp;subject=' . $mInfo->code . '&amp;action=remove', 'SSL') . '\'"') : '') . (($security_level > 1) ? html_button_field('edit', TEXT_EDIT, 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action', 'set', 'subject')) . 'set=' . $module_type . (isset($_GET['subject']) ? '&amp;subject=' . $_GET['subject'] : '') . '&amp;action=edit', 'SSL') . '\'"') : ''));
        $contents[] = array('text' => '<br />' . $mInfo->description);
        $contents[] = array('text' => '<br />' . $keys);
      } else {
        $contents[] = array('align' => 'center', 'text' => (($security_level > 1) ? html_button_field('install', TEXT_INSTALL, 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action', 'set', 'subject')) . 'set=' . $module_type . '&amp;subject=' . $mInfo->code . '&amp;action=install', 'SSL') . '\'"') : '&nbsp;'));
        $contents[] = array('text' => '<br />' . $mInfo->description);
      }
      break;
  }
  if ( (gen_not_null($heading)) && (gen_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";
    $box = new box;
    echo $box->infoBox($heading, $contents);
    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
