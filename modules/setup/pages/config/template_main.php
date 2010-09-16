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
//  Path: /modules/setup/pages/config/template_main.php
//

// start the form
echo html_form('config', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);

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
$toolbar->add_help('04');
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo $config_groups[$gID]['title']; ?></div>
<div><?php echo $config_groups[$gID]['description']; ?></div>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" width="55%"><?php echo TEXT_TITLE; ?></td>
                <td class="dataTableHeadingContent"><?php echo TEXT_VALUE; ?></td>
                <td class="dataTableHeadingContentXtra"><?php echo TEXT_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $configuration = $db->Execute("select configuration_id, configuration_title, configuration_value, configuration_key,
		use_function from " . TABLE_CONFIGURATION . "
		where configuration_group_id = '" . (int)$gID . "'
		order by sort_order");
  while (!$configuration->EOF) {
    if ($configuration->fields['use_function']) {
      $use_function = $configuration->fields['use_function'];
      $cfgValue = setup_call_function($use_function, $configuration->fields['configuration_value']);
    } else {
      $cfgValue = $configuration->fields['configuration_value'];
    }
    if ((!isset($_GET['cID']) || (isset($_GET['cID']) && ($_GET['cID'] == $configuration->fields['configuration_id']))) && !isset($cInfo) && (substr($action, 0, 3) != 'new')) {
      $cfg_extra = $db->Execute("select configuration_key, configuration_description, date_added,
                                        last_modified, use_function, set_function
                                 from " . TABLE_CONFIGURATION . "
                                 where configuration_id = '" . (int)$configuration->fields['configuration_id'] . "'");
      $cInfo_array = array_merge($configuration->fields, $cfg_extra->fields);
      $cInfo = new objectInfo($cInfo_array);
    }

    if ( (isset($cInfo) && is_object($cInfo)) && ($configuration->fields['configuration_id'] == $cInfo->configuration_id) ) {
      echo '                  <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('gID', 'cID', 'action')) . 'gID=' . $_GET['gID'] . '&amp;cID=' . $cInfo->configuration_id . '&amp;action=edit', 'SSL') . '\'">' . "\n";
    } else {
      echo '                  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('gID', 'cID', 'action')) . 'gID=' . $_GET['gID'] . '&amp;cID=' . $configuration->fields['configuration_id'] . '&amp;action=edit', 'SSL') . '\'">' . "\n";
    }
?>
                <td class="dataTableContent"><?php echo defined($configuration->fields['configuration_title']) ? constant($configuration->fields['configuration_title']) : $configuration->fields['configuration_title']; ?></td>
                <td class="dataTableContent"><?php echo htmlspecialchars($cfgValue); ?></td>
                <td class="dataTableContent" align="right">
					<?php if ((isset($cInfo) && is_object($cInfo)) && ($configuration->fields['configuration_id'] == $cInfo->configuration_id) ) {
						echo html_icon('actions/go-next.png'); 
					} else {
						echo '<a href="' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('gID', 'cID', 'action')) . 'gID=' . $_GET['gID'] . '&amp;cID=' . $configuration->fields['configuration_id'], 'SSL') . '">' . html_icon('apps/help-browser.png', TEXT_INFO) . '</a>'; 
					} ?>
				&nbsp;</td>
              </tr>
<?php
    $configuration->MoveNext();
  }
?>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'edit':
      $heading[] = array('text' => '<b>' . (defined($cInfo->configuration_title) ? constant($cInfo->configuration_title) : $cInfo->configuration_title) . '</b>');

      if ($cInfo->set_function) {
        eval('$value_field = ' . $cInfo->set_function . '"' . htmlspecialchars($cInfo->configuration_value) . '");');
      } else {
        $value_field = html_input_field('configuration_value', $cInfo->configuration_value, 'size="60"');
      }

      $contents = array('form' => html_form('configuration', FILENAME_DEFAULT, gen_get_all_get_params(array('gID', 'cID', 'action')) . 'gID=' . $_GET['gID'] . '&amp;cID=' . $cInfo->configuration_id . '&amp;action=save'));
      if (ADMIN_CONFIGURATION_KEY_ON == 1) {
        $contents[] = array('text' => '<strong>Key: ' . $cInfo->configuration_key . '</strong><br />');
      }
      $contents[] = array('text' => SETUP_CONFIG_EDIT_INTRO);
      $contents[] = array('text' => '<br /><b>' . (defined($cInfo->configuration_title) ? constant($cInfo->configuration_title) : $cInfo->configuration_title) . '</b><br />' . (defined($cInfo->configuration_description) ? constant($cInfo->configuration_description) : $cInfo->configuration_description) . '<br />' . $value_field);
      if ($_SESSION['admin_security'][SECURITY_ID_CONFIGURATION] > 2) $contents[] = array('align' => 'center', 'text' => '<br />' . html_button_field('action', TEXT_UPDATE, 'onclick="submitToDo(\'save\')"') . html_button_field('cancel', TEXT_CANCEL, 'onclick="location.href=\'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('gID', 'cID', 'action')) . 'gID=' . $_GET['gID'] . '&amp;cID=' . $cInfo->configuration_id, 'SSL') . '\'"'));
      if ($_SESSION['admin_security'][SECURITY_ID_CONFIGURATION] <= 2) $contents[] = array('align' => 'center', 'text' => '<br />' . html_button_field('cancel', TEXT_CANCEL, 'onclick="location.href=\'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('gID', 'cID', 'action')) . 'gID=' . $_GET['gID'] . '&amp;cID=' . $cInfo->configuration_id, 'SSL') . '\'"'));
      break;
    default:
      if (isset($cInfo) && is_object($cInfo)) {
        $heading[] = array('text' => '<b>' . (defined($cInfo->configuration_title) ? constant($cInfo->configuration_title) : $cInfo->configuration_title) . '</b>');
        if (ADMIN_CONFIGURATION_KEY_ON == 1) {
          $contents[] = array('text' => '<strong>Key: ' . $cInfo->configuration_key . '</strong><br />');
        }

        if ($_SESSION['admin_security'][SECURITY_ID_CONFIGURATION] > 2) $contents[] = array('align' => 'center', 'text' => html_button_field('edit', TEXT_EDIT, 'onclick="location.href=\'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('gID', 'cID', 'action')) . 'gID=' . $_GET['gID'] . '&amp;cID=' . $cInfo->configuration_id . '&amp;action=edit', 'SSL') . '\'"'));
        $contents[] = array('text' => '<br />' . (defined($cInfo->configuration_description) ? constant($cInfo->configuration_description) : $cInfo->configuration_description));
        $contents[] = array('text' => '<br />' . SETUP_INFO_DATE_ADDED . ' ' . gen_date_short($cInfo->date_added));
        if (gen_not_null($cInfo->last_modified)) $contents[] = array('text' => SETUP_INFO_LAST_MODIFIED . ' ' . gen_date_short($cInfo->last_modified));
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
<!-- body_text_eof //-->
  </tr>
</table>
</form>
