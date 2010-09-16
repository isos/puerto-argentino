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
//  Path: /modules/services/shipping/forms/shipping_popup_rates.php
//

echo html_form('step2', FILENAME_DEFAULT, gen_get_all_get_params(array('action', 'page')));
echo html_hidden_field('todo', '') . chr(10);
echo html_hidden_field('rowSeq', '') . chr(10);
// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="self.close()"';
$toolbar->icon_list['open']['show'] = false;
$toolbar->icon_list['save']['show'] = false;
$toolbar->icon_list['delete']['show'] = false;
$toolbar->icon_list['print']['show'] = false;
$toolbar->add_icon('back', 'onclick="submitToDo(\'back\')"', $order = 9);
$toolbar->add_help('09');
echo $toolbar->build_toolbar(); 
?>
<div class="pageHeading"><?php echo SHIPPING_POPUP_WINDOW_RATE_TITLE; ?></div>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
<?php
	$temp = $rates['rates'];
	if (is_array($temp)) {
		ksort($temp);
		foreach ($temp as $key => $value) {
			// build the heading row
			echo '<tr class="dataTableHeadingRow"><th colspan="6"><div align="center">';
			echo $shipping_defaults['service_levels'][$key] . '</div></th></tr>' . chr(10);
			echo '<tr>';
			echo '<td class="dataTableHeadingContent" align="center">' . SHIPPING_TEXT_CARRIER . '</td>' . chr(10);
			echo '<td class="dataTableHeadingContent" align="center">' . SHIPPING_TEXT_SERVICE . '</td>' . chr(10);
			echo '<td class="dataTableHeadingContent" align="center">' . SHIPPING_TEXT_FREIGHT_QUOTE . '</td>' . chr(10);
			echo '<td class="dataTableHeadingContent" align="center">' . SHIPPING_TEXT_BOOK_PRICE . '</td>' . chr(10);
			echo '<td class="dataTableHeadingContent" align="center">' . SHIPPING_TEXT_COST . '</td>' . chr(10);
			echo '<td class="dataTableHeadingContent" align="center">' . SHIPPING_TEXT_NOTES . '</td>' . chr(10);
			echo '</tr>';
			if (is_array($value)) foreach ($value as $carrier => $prices) {
				echo '<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="setReturnRate(\'' . $prices['quote'] . '\', \'' . $carrier . '\', \'' . $key . '\')">' . chr(10);
				if (is_file('shipping/images/' . $carrier . '_logo.gif')) $file_name = 'shipping/images/' . $carrier . '_logo.gif';
				if (is_file('shipping/images/' . $carrier . '_logo.png')) $file_name = 'shipping/images/' . $carrier . '_logo.png';
				if (is_file('shipping/images/' . $carrier . '_logo.jpg')) $file_name = 'shipping/images/' . $carrier . '_logo.jgp';
				echo '<td class="dataTableContent" align="center">' . ($no_image ? $carrier : html_image($file_name, $alt = '', '', '24')) . '</td>' . chr(10);
				echo '<td class="dataTableContent">' . constant($carrier . '_' . $key) . '</td>' . chr(10);
				echo '<td class="dataTableContent" align="right">' . $currencies->format($prices['quote']) . '</td>' . chr(10);
				echo '<td class="dataTableContent" align="right">' . $currencies->format($prices['book']) . '</td>' . chr(10);
				echo '<td class="dataTableContent" align="right">' . $currencies->format($prices['cost']) . '</td>' . chr(10);
				echo '<td class="dataTableContent">' . $prices['note'] . '</td>' . chr(10);
				echo '</tr>';
			}
		}
	}
?>
</table>