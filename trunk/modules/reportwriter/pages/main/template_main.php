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
//  Path: /modules/reportwriter/pages/main/template_main.php
//

// start the form
echo html_form('reports', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['params'] = 'onclick="ReportGenPopup(\'open\')"';
if ($security_level < 4) {
	$toolbar->icon_list['delete']['show'] = false;
} else {
	$toolbar->icon_list['delete']['params'] = 'onclick="if (confirm(\'' . RW_RPT_REPDEL . '\')) ReportPopup(\'delete\')"';
}
$toolbar->icon_list['save']['show'] = false;
$toolbar->icon_list['print']['show'] = false;
if ($security_level > 1) $toolbar->add_icon('new', 'onclick="ReportPopup(\'new\')"', $order = 10);
if ($security_level > 2) $toolbar->add_icon('edit', 'onclick="ReportPopup(\'edit\')"', $order = 11);
if ($security_level > 2) $toolbar->add_icon('rename', 'onclick="ReportPopup(\'rename\')"', $order = 12);
if ($security_level > 1) $toolbar->add_icon('copy', 'onclick="ReportPopup(\'copy\')"', $order = 13);
if ($security_level > 1) $toolbar->add_icon('import', 'onclick="ReportPopup(\'import\')"', $order = 14);
if ($security_level > 1) $toolbar->add_icon('export', 'onclick="ReportPopup(\'export\')"', $order = 15);

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('11.02');
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo RW_HEADING_TITLE; ?></div>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
	  <tr>
	  	<td valign="top">
		  <ul class="tabset_tabs">
			<?php 
				$show_active = false;
				foreach ($ReportGroups as $key => $value) {
					$active = !$show_active ? ' class="active"' : '';
					echo '<li><a href="#rw_' . $key . '"' . $active . '>' .  $value . '</a></li>' . chr(10);
					$show_active = true;
				}
			?>
		  </ul>
<?php
	foreach ($ReportGroups as $key => $value) {
		echo '<div id="rw_' . $key . '" class="tabset_content">' . chr(10);
		echo '<h2 class="tabset_label">' . $value . '</h2>' . chr(10);
		echo '<table width="95%" border="0" cellspacing="1" cellpadding="1">' . chr(10);
		echo '<tr>';
		echo '<td align="center" width="40%">' . TEXT_REPORTS . '<br />&nbsp;</td>' . chr(10);
		echo '<td align="center" width="40%">' . TEXT_FORMS . '<br /><a href="javascript:Expand(\'' . $key . '\');">' . TEXT_EXPAND_ALL . '</a> - <a href="javascript:Collapse(\'' . $key . '\');">' . TEXT_COLLAPSE_ALL . '</a></td>' . chr(10);
		echo '<td align="center" width="20%">&nbsp;<br />&nbsp;</td>' . chr(10);
		echo '</tr>';
		echo '<tr><td valign="top">';
		$report_types_heading = array('0' => RW_RPT_MYRPT, '1' => RW_RPT_DEFRPT);
		foreach ($report_types_heading as $standard => $fieldset_title) {
			echo '<fieldset><legend>' . $fieldset_title . '</legend>';
			$definitions->Move(0);
			$definitions->MoveNext();
			while (!$definitions->EOF) {
			  $report_id = $definitions->fields['id'];
			  if (!isset($rr_security[$report_id])) {
			    $rr_security[$report_id] = 'u:0;e:0;d:0'; // enable everyone if security not set
			  }
			  if (security_check($rr_security[$report_id])) {
				if ($definitions->fields['groupname'] == $key && $definitions->fields['standard_report'] == $standard) {
					echo html_radio_field('id', 'r' . $report_id, false);
					echo '&nbsp;' . stripslashes($definitions->fields['description']) . '<br />' . chr(10);
				}
			  }
				$definitions->MoveNext();
			}
			echo '</fieldset>' . chr(10);
		}
		echo '</td>' . chr(10);
		// show form list
		$temp = build_form_href($form_array[$key]['children'], 'rpt_' . $key);
		if ($temp) {
		  echo '<td valign="top"><fieldset>' . $temp . '</fieldset></td>' . chr(10);
		} else {
		  echo '<td valign="top">&nbsp;</td>' . chr(10);
		}
		echo '</tr>' . chr(10);
		echo '</table></div>' . chr(10);
	}
?>
		</td>
	  </tr>
    </table></td>
  </tr>
</table>
</form>