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
//  Path: /modules/orders/pages/popup_delivery/template_main.php
//

// start the form
echo html_form('popup_delivery', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);
echo html_hidden_field('rowSeq', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="self.close()"';
$toolbar->icon_list['open']['show'] = false;
$toolbar->icon_list['save']['params'] = 'onclick="submitToDo(\'save\', \'eta_dates\')"';
$toolbar->icon_list['delete']['show'] = false;
$toolbar->icon_list['print']['show'] = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
switch (JOURNAL_ID) {
  case 4: $toolbar->add_help('07.02.03.04'); break;
  case 6: $toolbar->add_help('07.03.03.04'); break;
}
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo ORD_EXPECTED_DATES . constant('ORD_TEXT_' . JOURNAL_ID . '_NUMBER') . ' ' . $ordr_items->fields['purchase_invoice_id']; ?></div>
<table border="0" cellspacing="0" cellpadding="1">
  <tr>
	<th><?php echo TEXT_QUANTITY; ?></th>
	<th><?php echo TEXT_SKU; ?></th>
	<th><?php echo TEXT_DESCRIPTION; ?></th>
	<th><?php echo ORD_DELIVERY_DATES; ?></th>
	<th><?php echo ORD_NEW_DELIVERY_DATES; ?></th>
  </tr>
<?php
	$j = 1;
	while (!$ordr_items->EOF) {
		$price = $currencies->format($level_info[0] ? $level_info[0] : (($i == 0) ? $full_price : 0));
		echo '<tr>' . chr(10);
		echo '  <td align="center">' . $ordr_items->fields['qty'] . '</td>' . chr(10);
		echo '  <td align="center">' . $ordr_items->fields['sku'] . '</td>' . chr(10);
		echo '  <td>' . $ordr_items->fields['description'] . '</td>' . chr(10);
		echo '  <td align="center">' . gen_date_short($ordr_items->fields['date_1']) . '</td>' . chr(10);
		echo '  <td align="center">';
		echo html_hidden_field('id_' . $j, $ordr_items->fields['id']) . chr(10);
		echo '  <script type="text/javascript">date_' . $j . '.writeControl(); date_' . $j . '.displayLeft=true; date_' . $j . '.dateFormat="' . DATE_FORMAT_SPIFFYCAL . '";</script>' . chr(10);
		echo '  </td>' . chr(10);
		echo '</tr>';
		$j++;
		$ordr_items->MoveNext();
	}
?>
</table>
</form>