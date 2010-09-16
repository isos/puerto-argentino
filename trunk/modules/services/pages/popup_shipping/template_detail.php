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
//  Path: /modules/services/pages/popup_shipping/template_detail.php
//

// start the form
echo html_form('step2', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '')   . chr(10);
echo html_hidden_field('rowSeq', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="self.close()"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['print']['show']    = false;
$toolbar->add_icon('back', 'onclick="submitToDo(\'back\')"', $order = 9);

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('09');
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo SHIPPING_POPUP_WINDOW_RATE_TITLE; ?></div>
<?php
  $temp = $rates['rates'];
//echo 'temp array = '; print_r($temp); echo '<br />';
  if (is_array($temp)) {
	ksort($temp);
	foreach ($temp as $carrier => $value) {
		// build the heading row
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">';
		echo '<tr>';
		$def_filename  = DIR_WS_MODULES . 'services/shipping/images/' . $carrier . '_logo';
		$cust_filename = 'my_files/custom/services/shipping/images/' . $carrier . '_logo';
		$filename = false;
		if      (is_file($def_filename . '.gif'))  { $filename = $def_filename . '.gif'; }
		else if (is_file($def_filename . '.png'))  { $filename = $def_filename . '.png'; }
		else if (is_file($def_filename . '.jpg'))  { $filename = $def_filename . '.jpg'; }
		else if (is_file($cust_filename . '.gif')) { $filename = $cust_filename . '.gif'; }
		else if (is_file($cust_filename . '.png')) { $filename = $cust_filename . '.png'; }
		else if (is_file($cust_filename . '.jpg')) { $filename = $cust_filename . '.jpg'; }
		echo '<th width="10%" rowspan="99" class="dataTableContent" valign="top" align="center">' . $carrier . '<br />' . ($filename ? html_image($filename, $alt = $carrier, '60', '') : '&nbsp;') . '</th>' . chr(10);
		echo '<th width="20%" class="dataTableHeadingContent" align="center">' . SHIPPING_TEXT_SERVICE       . '</th>' . chr(10);
		echo '<th width="14%" class="dataTableHeadingContent" align="center">' . SHIPPING_TEXT_FREIGHT_QUOTE . '</th>' . chr(10);
		echo '<th width="14%" class="dataTableHeadingContent" align="center">' . SHIPPING_TEXT_BOOK_PRICE    . '</th>' . chr(10);
		echo '<th width="14%" class="dataTableHeadingContent" align="center">' . SHIPPING_TEXT_COST          . '</th>' . chr(10);
		echo '<th width="28%" class="dataTableHeadingContent" align="center">' . SHIPPING_TEXT_NOTES         . '</th>' . chr(10);
		echo '</tr>';
		if (is_array($value)) foreach ($value as $key => $prices) {
			echo '<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="setReturnRate(\'' . $currencies->format($prices['quote']) . '\', \'' . $carrier . '\', \'' . $key . '\')">' . chr(10);
			echo '<td class="dataTableContent">' . constant($carrier . '_' . $key) . '</td>' . chr(10);
			echo '<td class="dataTableContent" align="right">' . (($prices['quote'] !== '') ? $currencies->format($prices['quote']) : '&nbsp;') . '</td>' . chr(10);
			echo '<td class="dataTableContent" align="right">' . (($prices['book']  !== '') ? $currencies->format($prices['book']) : '&nbsp;') . '</td>' . chr(10);
			echo '<td class="dataTableContent" align="right">' . (($prices['cost']  !== '') ? $currencies->format($prices['cost']) : '&nbsp;') . '</td>' . chr(10);
			echo '<td class="dataTableContent" align="center">' . $prices['note'] . '</td>' . chr(10);
			echo '</tr>';
		}
		echo '</table>';
	}
  }
?>
</form>