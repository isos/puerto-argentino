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
//  Path: /modules/gen_ledger/pages/utils/template_main.php
//

// start the form
echo html_form('gl_utils', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show'] = false;
$toolbar->icon_list['delete']['show'] = false;
$toolbar->icon_list['save']['show'] = false;
$toolbar->icon_list['print']['show'] = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('07.06.03');
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo GL_UTIL_HEADING_TITLE; ?></div>
<fieldset>
<legend><?php echo GL_UTIL_PERIOD_LEGEND; ?></legend>
  <table width="100%" border="0" cellspacing="0" cellpadding="1">
    <tr>
	  <td class="dataTableContent" valign="top">
		<?php echo '<p>' . GL_CURRENT_PERIOD . $period . '</p>'; 
		echo '<p>' . GL_UTIL_FISCAL_YEAR_TEXT . '</p>'; ?>
	  </td>
	  <td align="center" valign="top"><table align="center" border="0" cellspacing="0" cellpadding="1">
	    <tr>
		  <td class="dataTableHeadingContent" align="center"><?php echo GL_FISCAL_YEAR; ?>
		  <?php echo html_pull_down_menu('fy', get_fiscal_year_pulldown(), $fy, 'onchange="submit()"'); ?></td>
	    </tr>
	    <tr>
		  <td><table id="item_table" width="100%" border="1" cellpadding="0" cellspacing="0">
		    <tr>
			  <th><?php echo TEXT_PERIOD; ?></th>
			  <th><?php echo TEXT_START_DATE; ?></th>
			  <th><?php echo TEXT_END_DATE; ?></th>
		    </tr>
		  <?php
		  $i = 0;
		  foreach ($fy_array as $key => $value) { 
			echo '<tr><td width="33%" align="center">' . $key . html_hidden_field('per_' . $i, $key) . '</td>' . chr(10);
			echo '<td width="33%" align="center" nowrap="nowrap">' . html_input_field('start_' . $i, gen_date_short($value['start']), 'readonly="readonly"', false, 'text', false) . '</td>' . chr(10);
			if ($key > $max_period) { // only allow changes if nothing has bee posted above this period
				echo '<td width="33%" nowrap="nowrap"><script type="text/javascript">P' . $i . 'End.writeControl(); P' . $i . 'End.dateFormat="' .  DATE_FORMAT_SPIFFYCAL . '"; P' . $i . 'End.JStoRunOnSelect="updateEnd(' . $i . ')";</script></td>' . chr(10);
			} else {
				echo '<td width="33%" align="center" nowrap="nowrap">' . html_input_field('end_' . $i, gen_date_short($value['end']), 'readonly="readonly"', false, 'text', false) . '</td>' . chr(10);
			}
			echo '</tr>' . chr(10);
			$i++;
		  } ?>		  
		  </table></td>
	    </tr>
	  </table></td>
	  <td valign="top" align="right">
		<?php echo html_hidden_field('period', '') . chr(10);
		echo '<p>' . html_submit_field('change', GL_BTN_CHG_ACCT_PERIOD, 'onclick="if (!fetchPeriod()) return false"') . '</p>' . chr(10);
		echo '<p>' . html_submit_field('update', GL_BTN_UPDATE_FY) . '</p>' . chr(10);
		echo '<p>' . html_submit_field('new', GL_BTN_NEW_FY, 'onclick="if (!confirm(\'' . GL_WARN_ADD_FISCAL_YEAR . ($highest_fy + 1). '\')) return false"') . '</p>' . chr(10);
		?>
	  </td>
    </tr>
  </table>
</fieldset>
<fieldset>
<legend><?php echo GL_UTIL_BEG_BAL_LEGEND; ?></legend>
  <table width="100%" border="0" cellspacing="0" cellpadding="1">
    <tr>
	  <td><?php echo GL_UTIL_BEG_BAL_TEXT; ?></td>
	  <td align="right"><?php echo html_submit_field('beg_balances', GL_BTN_BEG_BAL); ?></td>
    </tr>
  </table>
</fieldset>
<fieldset>
<legend><?php echo GL_UTIL_PURGE_ALL; ?></legend>
  <table width="100%" border="0" cellspacing="0" cellpadding="1">
    <tr>
	  <td><?php echo GL_UTIL_PURGE_DB; ?></td>
	  <td valign="top" align="right">
	    <?php echo html_input_field('purge_confirm', '', 'size="10" maxlength="10"') . ' ';
	      echo html_submit_field('purge_db', GL_BTN_PURGE_DB, 'onclick="if (!confirm(\'' . GL_UTIL_PURGE_DB_CONFIRM . '\')) return false"');
	    ?>
	  </td>
    </tr>
  </table>
</fieldset>
</form>