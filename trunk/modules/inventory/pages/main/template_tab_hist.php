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
//  Path: /modules/inventory/pages/main/template_tab_hist.php
//

// start the history tab html
?>

<div id="HISTORY" class="tabset_content">
  <h2 class="tabset_label"><?php echo TEXT_HISTORY; ?></h2>

<?php // ***********************  History Section  ****************************** ?>
  <fieldset class="formAreaTitle">
    <legend><?php echo INV_SKU_HISTORY; ?></legend>
	<table border="0" cellspacing="1" cellpadding="1">
	  <tr>
	    <td class="main"><?php echo INV_DATE_ACCOUNT_CREATION; ?></td>
	    <td class="main"><?php echo html_input_field('creation_date', gen_spiffycal_db_date_short($cInfo->creation_date), 'disabled="disabled" size="20"', false); ?></td>
	    <td class="main"><?php echo INV_DATE_LAST_UPDATE; ?></td>
	    <td class="main"><?php echo html_input_field('last_update', gen_spiffycal_db_date_short($cInfo->last_update), 'disabled="disabled" size="20"', false); ?></td>
	    <td class="main"><?php echo INV_DATE_LAST_JOURNAL_DATE; ?></td>
	    <td class="main"><?php echo html_input_field('last_journal_date', gen_spiffycal_db_date_short($cInfo->last_journal_date), 'disabled="disabled" size="20"', false); ?></td>
	  </tr>
	</table>
  </fieldset>
  <fieldset class="formAreaTitle">
   <legend><?php echo INV_SKU_ACTIVITY; ?></legend>
   <table border="0" width="100%" cellspacing="1" cellpadding="1">
	  <tr><td valign="top" width="50%">
		<table border="1" width="100%" cellspacing="1" cellpadding="1">
		  <tr><th colspan="4"><?php echo INV_OPEN_PO; ?></th></tr>
		  <tr>
		    <th><?php echo INV_PO_NUMBER; ?></th>
		    <th><?php echo INV_PO_DATE; ?></th>
		    <th><?php echo TEXT_QUANTITY; ?></th>
		    <th><?php echo INV_PO_RCV_DATE; ?></th>
		  </tr>
		  <?php 
			if ($sku_history['open_po']) {
			  foreach ($sku_history['open_po'] as $value) {
				echo '<tr>' . chr(10);
				echo '  <td align="center"><a href="' . html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;action=edit&amp;jID=4&amp;oID=' . $value['id'], 'SSL') . '">' . $value['purchase_invoice_id'] . '</a></td>' . chr(10);
				echo '  <td align="center">' . gen_spiffycal_db_date_short($value['post_date']) . '</td>' . chr(10);
				echo '  <td align="center">' . ($value['qty'] ? $value['qty'] : '&nbsp;') . '</td>' . chr(10);
				echo '  <td align="center">' . gen_spiffycal_db_date_short($value['date_1']) . '</td>' . chr(10);
				echo '</tr>' . chr(10);
			  }
			} else {
			  echo '<tr><td align="center" colspan="4">' . INV_NO_RESULTS . '</td></tr>' . chr(10);
			}
		  ?>
		  <tr><th colspan="4"><?php echo INV_OPEN_SO; ?></th></tr>
		  <tr>
		    <th><?php echo INV_SO_NUMBER; ?></th>
		    <th><?php echo INV_SO_DATE; ?></th>
		    <th><?php echo TEXT_QUANTITY; ?></th>
		    <th><?php echo INV_SO_SHIP_DATE; ?></th>
		  </tr>
		  <?php 
			if ($sku_history['open_so']) {
			  foreach ($sku_history['open_so'] as $value) {
				echo '<tr>' . chr(10);
				echo '  <td align="center"><a href="' . html_href_link(FILENAME_DEFAULT, 'cat=orders&amp;module=orders&amp;action=edit&amp;jID=10&amp;oID=' . $value['id'], 'SSL') . '">' . $value['purchase_invoice_id'] . '</a></td>' . chr(10);
				echo '  <td align="center">' . gen_spiffycal_db_date_short($value['post_date']) . '</td>' . chr(10);
				echo '  <td align="center">' . ($value['qty'] ? $value['qty'] : '&nbsp;') . '</td>' . chr(10);
				echo '  <td align="center">' . gen_spiffycal_db_date_short($value['date_1']) . '</td>' . chr(10);
				echo '</tr>' . chr(10);
			  }
			} else {
			  echo '<tr><td align="center" colspan="4">' . INV_NO_RESULTS . '</td></tr>' . chr(10);
			}
		  ?>
		  <tr><th colspan="4"><?php echo 'Average Usage (not including this month)'; ?></th></tr>
		  <tr>
		    <th><?php echo TEXT_LAST_MONTH; ?></th>
		    <th><?php echo TEXT_LAST_3_MONTH; ?></th>
		    <th><?php echo TEXT_LAST_6_MONTH; ?></th>
		    <th><?php echo TEXT_LAST_12_MONTH; ?></th>
		  </tr>
		  <tr>
		    <td align="center"><?php echo $sku_history['averages']['1month']; ?></td>
		    <td align="center"><?php echo $sku_history['averages']['3month']; ?></td>
		    <td align="center"><?php echo $sku_history['averages']['6month']; ?></td>
		    <td align="center"><?php echo $sku_history['averages']['12month']; ?></td>
		  </tr>
		</table>
	  </td>
	  <td valign="top" width="25%">
		<table border="1" width="100%" cellspacing="1" cellpadding="1">
		  <tr><th colspan="4"><?php echo INV_PURCH_BY_MONTH; ?></th></tr>
		  <tr>
		    <th><?php echo TEXT_MONTH; ?></th>
		    <th><?php echo TEXT_QUANTITY; ?></th>
		    <th><?php echo INV_PURCH_COST; ?></th>
		  </tr>
      <?php 
		if ($sku_history['purchases']) {
		  foreach ($sku_history['purchases'] as $value) {
		    echo '<tr>' . chr(10);
			echo '  <td align="center">' . gen_spiffycal_db_date_short($value['post_date']) . '</td>' . chr(10);
		    echo '  <td align="center">' . ($value['qty'] ? $value['qty'] : '&nbsp;') . '</td>' . chr(10);
		    echo '  <td align="right">' . ($value['total_amount'] ? $currencies->format($value['total_amount']) : '&nbsp;') . '</td>' . chr(10);
			echo '</tr>' . chr(10);
		  }
		} else {
		  echo '<tr><td align="center" colspan="4">' . INV_NO_RESULTS . '</td></tr>' . chr(10);
		}
	  ?>
		</table>
	  </td>
	  <td valign="top" width="25%">
		<table border="1" width="100%" cellspacing="1" cellpadding="1">
		  <tr><th colspan="4"><?php echo INV_SALES_BY_MONTH; ?></th></tr>
		  <tr>
		    <th><?php echo TEXT_MONTH; ?></th>
		    <th><?php echo TEXT_QUANTITY; ?></th>
		    <th><?php echo INV_SALES_INCOME; ?></th>
		  </tr>
      <?php 
		if ($sku_history['sales']) {
		  foreach ($sku_history['sales'] as $value) {
		    echo '<tr>' . chr(10);
			echo '  <td align="center">' . gen_spiffycal_db_date_short($value['post_date']) . '</td>' . chr(10);
		    echo '  <td align="center">' . ($value['qty'] ? $value['qty'] : '&nbsp;') . '</td>' . chr(10);
		    echo '  <td align="right">' . ($value['total_amount'] ? $currencies->format($value['total_amount']) : '&nbsp;') . '</td>' . chr(10);
			echo '</tr>' . chr(10);
		  }
		} else {
		  echo '<tr><td align="center" colspan="4">' . INV_NO_RESULTS . '</td></tr>' . chr(10);
		}
	  ?>
		</table>
	  </td>
	  </tr>
    </table>
  </fieldset>
</div>
