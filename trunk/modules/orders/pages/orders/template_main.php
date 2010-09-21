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
//  Path: /modules/orders/pages/orders/template_main.php
//

// start the form
echo html_form('orders', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);
$hidden_fields = NULL;

/*** AGREGO ESTAS LINEAS PARA EVITAR EL FORM RESUBMISION  */
	
	$session = new SessionManager();
	echo html_hidden_field('random',$session->init_form() ). chr(10) ;


/*** FIN DE LAS LINEAS PARA EVITAR EL FORM RESUBMISION  */
// include hidden fields
echo html_hidden_field('todo',             '') . chr(10);
echo html_hidden_field('id',               $order->id) . chr(10); // db journal entry id, null = new entry; not null = edit
echo html_hidden_field('recur_id',         $order->recur_id ? $order->recur_id : 0) . chr(10);	// recur entry flag - number of recurs
echo html_hidden_field('recur_frequency',  $order->recur_frequency ? $order->recur_frequency : 0) . chr(10);	// recur entry flag - how often
echo html_hidden_field('so_po_ref_id',     $order->so_po_ref_id) . chr(10);	// PO/SO number assigned to purchase/sales-invoice (if applicable)
echo html_hidden_field('bill_acct_id',     $order->bill_acct_id) . chr(10);	// id of the account in the bill to/remit to
echo html_hidden_field('bill_address_id',  $order->bill_address_id) . chr(10);
echo html_hidden_field('ship_acct_id',     $order->ship_acct_id) . chr(10);	// id of the account in the ship to
echo html_hidden_field('ship_address_id',  $order->ship_address_id) . chr(10);
echo html_hidden_field('terms',            $order->terms) . chr(10);
echo html_hidden_field('item_count',       $order->item_count) . chr(10);
echo html_hidden_field('weight',           $order->weight) . chr(10);
echo html_hidden_field('currencies_code',  $order->currencies_code) . chr(10);
echo html_hidden_field('printed',          $order->printed);
if (!isset($template_options['closed']))        echo html_hidden_field('closed', $order->closed);
if (!isset($template_options['waiting']))       echo html_hidden_field('waiting', $order->waiting);
if (!isset($template_options['terminal_date'])) echo html_hidden_field('terminal_date', gen_spiffycal_db_date_short($order->terminal_date));
if (!isset($template_options['terms']))         echo html_hidden_field('terms_text', $order->terms_text); // placeholder when not used
if (!ENABLE_MULTI_CURRENCY) {
  echo html_hidden_field('display_currency', DEFAULT_CURRENCY) . chr(10);
  echo html_hidden_field('currencies_value', '1') . chr(10);
}
if (!ENABLE_MULTI_BRANCH) echo html_hidden_field('store_id', '0') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['params']   = 'onclick="OpenOrdrList(this)"';
$toolbar->icon_list['delete']['params'] = 'onclick="if (confirm(\'' . ORD_DELETE_ALERT . '\')) submitToDo(\'delete\')"';
$toolbar->icon_list['save']['params']   = 'onclick="submitToDo(\'save\')"';
$toolbar->icon_list['print']['params']  = 'onclick="submitToDo(\'print\')"';
$toolbar->add_icon('new', 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action', 'jID')) . 'jID=' . JOURNAL_ID, 'SSL') . '\'"', 2);
if ($security_level > 1 && ENABLE_BAR_CODE_READERS) {
  $toolbar->add_icon('bar_code', 'onclick="openBarCode()"', 9);
  $toolbar->icon_list['bar_code']['icon'] = 'devices/network-wired.png';
  $toolbar->icon_list['bar_code']['text'] = TEXT_UPC_CODE;
}
if (JOURNAL_ID == 12 && $security_level > 2) {
  $toolbar->add_icon ('post_previous', 'onclick="submitToDo(\'post_previous\')"', 10);
  $toolbar->icon_list['post_previous']['icon'] = 'actions/go-previous.png';
  $toolbar->icon_list['post_previous']['text'] = TEXT_SAVE_OPEN_PREVIOUS;
  $toolbar->add_icon ('post_next', 'onclick="submitToDo(\'post_next\')"', 11);
  $toolbar->icon_list['post_next']['icon'] = 'actions/go-next.png';
  $toolbar->icon_list['post_next']['text'] = TEXT_SAVE_OPEN_NEXT;
}
if ($security_level > 1 && in_array(JOURNAL_ID, array(4, 6, 10, 12))) {
  $toolbar->add_icon('recur', 'onclick="OpenRecurList(this)"', 12);
}
if ($security_level > 1 && JOURNAL_ID == 9) {
  $toolbar->add_icon('cvt_quote', 'onclick="convertQuote()"', 13);
  $toolbar->icon_list['cvt_quote']['icon'] = 'emblems/emblem-symbolic-link.png';
  $toolbar->icon_list['cvt_quote']['text'] = ORD_CONVERT_TO_SO_INV;
}
if ($security_level > 1 && JOURNAL_ID == 10) {
  $toolbar->add_icon('cvt_quote', 'onclick="convertSO()"', 13);
  $toolbar->icon_list['cvt_quote']['icon'] = 'emblems/emblem-symbolic-link.png';
  $toolbar->icon_list['cvt_quote']['text'] = ORD_CONVERT_TO_PO;
}
if ($security_level > 1 && (JOURNAL_ID == 6 || JOURNAL_ID == 12)) {
  $toolbar->add_icon('payment', 'onclick="submitToDo(\'payment\')"', 15); // POS and POP (Purchase)
  $toolbar->add_icon('ship_all', 'onclick="checkShipAll()"', 20);
  if (JOURNAL_ID == 6) $toolbar->icon_list['ship_all']['text'] = TEXT_RECEIVE_ALL;
}
if ($security_level < 4) $toolbar->icon_list['delete']['show'] = false;
if ($security_level < 2 || JOURNAL_ID == 6 || JOURNAL_ID == 7) $toolbar->icon_list['print']['show']  = false;
if ($security_level < 2) {
  $toolbar->icon_list['save']['show']   = false;
  $toolbar->icon_list['new']['show']    = false;
}
if ($security_level < 3 && $order->id) {
  $toolbar->icon_list['save']['show']  = false;
  $toolbar->icon_list['print']['show'] = false;
}

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
  foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
switch(JOURNAL_ID) {
	case  3: $toolbar->add_help('07.02.04'); break;
	case  4: $toolbar->add_help('07.02.03'); break;
	case  6: $toolbar->add_help('07.02.05'); break;
	case  7: $toolbar->add_help('07.02.07'); break;
	case  9: $toolbar->add_help('07.03.04'); break;
	case 10: $toolbar->add_help('07.03.03'); break;
	case 12: $toolbar->add_help('07.03.05'); break;
	case 13: $toolbar->add_help('07.03.07'); break;
	case 18: $toolbar->add_help('07.03.06'); break;
	case 19: $toolbar->add_help('07.03.06'); break;
	case 20: $toolbar->add_help('07.02.06'); break;
	case 21: $toolbar->add_help('07.02.06'); break;
}
echo $toolbar->build_toolbar();

// Build the page
?>
<div class="pageHeading"><?php echo constant('ORD_TEXT_' . JOURNAL_ID . '_WINDOW_TITLE'); ?></div>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	  <table width="100%"  border="0" cellspacing="2" cellpadding="2">
	    <tr>
		  <td width="33%">
			<?php echo ORD_ACCT_ID . ' ' . html_input_field('search', isset($order->short_name) ? $order->short_name : TEXT_SEARCH, 'size="21" maxlength="20" onfocus="clearField(\'search\', \'' . TEXT_SEARCH . '\')" onblur="setField(\'search\', \'' . TEXT_SEARCH . '\');"');
			      echo '&nbsp;' . html_icon('actions/system-search.png', TEXT_SEARCH, 'small', 'align="top" style="cursor:pointer" onclick="accountGuess(true)"'); 
			      echo '&nbsp;' . html_icon('actions/document-properties.png', TEXT_PROPERTIES, 'small', 'align="top" style="cursor:pointer" onclick="ContactProp()"'); 
			?>
          </td>
		  <td id="ship_to_search" width="33%">&nbsp;</td> <!-- place holder for ship to fields -->
		  <td><?php echo TEXT_DATE . '&nbsp;' ?><script type="text/javascript">dateOrdered.writeControl(); dateOrdered.displayLeft=true; dateOrdered.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script></td>
		</tr>
		<tr>
		  <td class="main" width="33%"><?php echo constant('ORD_TEXT_' . JOURNAL_ID . '_BILL_TO'); ?>
		    <?php echo html_pull_down_menu('bill_to_select', gen_null_pull_down(), '', 'onchange="fillAddress(\'bill\')"'); ?>
		  </td>
		  <td class="main" width="40%"><?php echo (ENABLE_SHIPPING_FUNCTIONS) ? ORD_SHIP_TO : '&nbsp;'; ?>
		    <?php echo html_pull_down_menu('ship_to_select', gen_null_pull_down(), '', 'disabled="disabled" onchange="fillAddress(\'ship\')"'); ?>
		  </td>
		  <td width="27%" rowspan="2" valign="top">
			<table width="100%"  border="0" cellspacing="2" cellpadding="2">
<?php if (ENABLE_MULTI_CURRENCY) {	// show currency slection pulldown ?>
			  <tr>
				<td class="main" align="right"><?php echo TEXT_CURRENCY; ?></td>
				<td class="main">
				  <?php echo html_pull_down_menu('display_currency', gen_get_pull_down(TABLE_CURRENCIES, false, false, 'code', 'title'), $order->currencies_code, 'onchange="recalculateCurrencies();"'); ?>
			    </td>
			  </tr>
			  <tr>
				<td class="main" align="right"><?php echo TEXT_EXCHANGE_RATE; ?></td>
				<td class="main">
				  <?php echo html_input_field('currencies_value', $order->currencies_value, 'readonly="readonly"'); ?>
			    </td>
			  </tr>
<?php } ?>
			  <tr>
				<td class="main" align="right"><?php echo constant('ORD_TEXT_' . JOURNAL_ID . '_NUMBER'); ?></td>
				<td class="main"><?php echo html_input_field('purchase_invoice_id', $order->purchase_invoice_id, 'onmouseover="Tip(\'' . ORD_TT_PURCH_INV_NUM . '\')"'); ?></td>
			  </tr>
<?php if (isset($template_options['waiting'])) {	// show waiting for invoice (purchase_receive, vendor cm) checkbox ?>
			  <tr>
				<td class="main" align="right"><?php echo $template_options['waiting']['title']; ?></td>
				<td class="main"><?php echo $template_options['waiting']['field']; ?></td>
			  </tr>
<?php } ?>
<?php if (isset($template_options['closed'])) {	// show close checkbox ?>
			  <tr>
				<td class="main" align="right"><?php echo $template_options['closed']['title']; ?></td>
				<td class="main"><?php echo $template_options['closed']['field']; ?></td>
			  </tr>
<?php } ?>
			  <tr>
				<td class="messageInfo" id="closed_text" align="center" colspan="2"><?php echo '&nbsp;'; ?></td>
			  </tr>
			</table>
		  </td>
		</tr>
		<tr>
		  <td nowrap="nowrap" class="main" valign="top">
<?php
echo html_input_field('bill_primary_name', $order->bill_primary_name, 'size="33" maxlength="32" onfocus="clearField(\'bill_primary_name\', \'' . GEN_PRIMARY_NAME . '\')" onblur="setField(\'bill_primary_name\', \'' . GEN_PRIMARY_NAME . '\')"', true) . chr(10);
echo html_checkbox_field('bill_add_update', '1', ($order->bill_add_update) ? true : false, '', '') . ORD_ADD_UPDATE . '<br />' . chr(10);
echo html_input_field('bill_contact', $order->bill_contact, 'size="33" maxlength="32" onfocus="clearField(\'bill_contact\', \'' . GEN_CONTACT . '\')" onblur="setField(\'bill_contact\', \'' . GEN_CONTACT . '\')"', ADDRESS_BOOK_CONTACT_REQUIRED) . chr(10);
echo(ENABLE_SHIPPING_FUNCTIONS ? html_button_field('copy_ship', ORD_COPY_BILL, 'onclick="copyAddress()"') : '') . '<br />' . chr(10);
echo html_input_field('bill_address1', $order->bill_address1, 'size="33" maxlength="32" onfocus="clearField(\'bill_address1\', \'' . GEN_ADDRESS1 . '\')" onblur="setField(\'bill_address1\', \'' . GEN_ADDRESS1 . '\')"', ADDRESS_BOOK_ADDRESS1_REQUIRED) . '<br />' . chr(10);
echo html_input_field('bill_address2', $order->bill_address2, 'size="33" maxlength="32" onfocus="clearField(\'bill_address2\', \'' . GEN_ADDRESS2 . '\')" onblur="setField(\'bill_address2\', \'' . GEN_ADDRESS2 . '\')"', ADDRESS_BOOK_ADDRESS2_REQUIRED) . '<br />' . chr(10);
echo html_input_field('bill_city_town', $order->bill_city_town, 'size="25" maxlength="24" onfocus="clearField(\'bill_city_town\', \'' . GEN_CITY_TOWN . '\')" onblur="setField(\'bill_city_town\', \'' . GEN_CITY_TOWN . '\')"', ADDRESS_BOOK_CITY_TOWN_REQUIRED) . chr(10);
echo html_input_field('bill_state_province', $order->bill_state_province, 'size="3" maxlength="5" onfocus="clearField(\'bill_state_province\', \'' . GEN_STATE_PROVINCE . '\')" onblur="setField(\'bill_state_province\', \'' . GEN_STATE_PROVINCE . '\')"', ADDRESS_BOOK_STATE_PROVINCE_REQUIRED) . chr(10);
echo html_input_field('bill_postal_code', $order->bill_postal_code, 'size="11" maxlength="10" onfocus="clearField(\'bill_postal_code\', \'' . GEN_POSTAL_CODE . '\')" onblur="setField(\'bill_postal_code\', \'' . GEN_POSTAL_CODE . '\')"', ADDRESS_BOOK_POSTAL_CODE_REQUIRED) . '<br />' . chr(10);
echo html_pull_down_menu('bill_country_code', gen_get_countries(), $order->bill_country_code) . '<br />' . chr(10); 
echo html_input_field('bill_telephone1', $order->bill_telephone1, 'size="21" maxlength="20" onfocus="clearField(\'bill_telephone1\', \'' . GEN_TELEPHONE1 . '\')" onblur="setField(\'bill_telephone1\', \'' . GEN_TELEPHONE1 . '\')"', ADDRESS_BOOK_TELEPHONE1_REQUIRED) . chr(10);
echo html_input_field('bill_email', $order->bill_email, 'size="35" maxlength="48" onfocus="clearField(\'bill_email\', \'' . GEN_EMAIL . '\')" onblur="setField(\'bill_email\', \'' . GEN_EMAIL . '\')"', ADDRESS_BOOK_EMAIL_REQUIRED) . chr(10);
?>
		  </td>
		  <td nowrap="nowrap" class="main" width="33%" valign="top">
<?php if (ENABLE_SHIPPING_FUNCTIONS) { // show shipping address
  echo html_input_field('ship_primary_name', $order->ship_primary_name, 'size="33" maxlength="32" onfocus="clearField(\'ship_primary_name\', \'' . GEN_PRIMARY_NAME . '\')" onblur="setField(\'ship_primary_name\', \'' . GEN_PRIMARY_NAME . '\')"', true) . chr(10);
  echo html_checkbox_field('ship_add_update', '1', ($order->ship_add_update) ? true : false, '', '') . ORD_ADD_UPDATE . '<br />' . chr(10);
  echo html_input_field('ship_contact', $order->ship_contact, 'size="33" maxlength="32" onfocus="clearField(\'ship_contact\', \'' . GEN_CONTACT . '\')" onblur="setField(\'ship_contact\', \'' . GEN_CONTACT . '\')"', ADDRESS_BOOK_SHIP_CONTACT_REQ) . chr(10);
  echo html_checkbox_field('drop_ship', '1', ($order->drop_ship) ? true : false, '','onclick="DropShipView(this)"') . ORD_DROP_SHIP . '<br />' . chr(10);
  echo html_input_field('ship_address1', $order->ship_address1, 'size="33" maxlength="32" onfocus="clearField(\'ship_address1\', \'' . GEN_ADDRESS1 . '\')" onblur="setField(\'ship_address1\', \'' . GEN_ADDRESS1 . '\')"', ADDRESS_BOOK_SHIP_ADD1_REQ) . '<br />' . chr(10);
  echo html_input_field('ship_address2', $order->ship_address2, 'size="33" maxlength="32" onfocus="clearField(\'ship_address2\', \'' . GEN_ADDRESS2 . '\')" onblur="setField(\'ship_address2\', \'' . GEN_ADDRESS2 . '\')"', ADDRESS_BOOK_SHIP_ADD2_REQ) . '<br />' . chr(10);
  echo html_input_field('ship_city_town', $order->ship_city_town, 'size="25" maxlength="24" onfocus="clearField(\'ship_city_town\', \'' . GEN_CITY_TOWN . '\')" onblur="setField(\'ship_city_town\', \'' . GEN_CITY_TOWN . '\')"', ADDRESS_BOOK_SHIP_CITY_REQ) . chr(10);
  echo html_input_field('ship_state_province', $order->ship_state_province, 'size="3" maxlength="5" onfocus="clearField(\'ship_state_province\', \'' . GEN_STATE_PROVINCE . '\')" onblur="setField(\'ship_state_province\', \'' . GEN_STATE_PROVINCE . '\')"', ADDRESS_BOOK_SHIP_STATE_REQ) . chr(10);
  echo html_input_field('ship_postal_code', $order->ship_postal_code, 'size="11" maxlength="10" onfocus="clearField(\'ship_postal_code\', \'' . GEN_POSTAL_CODE . '\')" onblur="setField(\'ship_postal_code\', \'' . GEN_POSTAL_CODE . '\')"', ADDRESS_BOOK_SHIP_POSTAL_CODE_REQ) . '<br />' . chr(10);
  echo html_pull_down_menu('ship_country_code', gen_get_countries(), $order->ship_country_code) . '<br />' . chr(10); 
  echo html_input_field('ship_telephone1', $order->ship_telephone1, 'size="21" maxlength="20" onfocus="clearField(\'ship_telephone1\', \'' . GEN_TELEPHONE1 . '\')" onblur="setField(\'ship_telephone1\', \'' . GEN_TELEPHONE1 . '\')"', ADDRESS_BOOK_TELEPHONE1_REQUIRED) . chr(10);
  echo html_input_field('ship_email', $order->ship_email, 'size="35" maxlength="48" onfocus="clearField(\'ship_email\', \'' . GEN_EMAIL . '\')" onblur="setField(\'ship_email\', \'' . GEN_EMAIL . '\')"', ADDRESS_BOOK_EMAIL_REQUIRED) . chr(10);
} else {
  echo html_hidden_field('ship_primary_name', '')   . chr(10);
  echo html_hidden_field('ship_add_update', '0')    . chr(10);
  echo html_hidden_field('ship_contact', '')        . chr(10);
  echo html_hidden_field('drop_ship', '0')          . chr(10);
  echo html_hidden_field('ship_address1', '')       . chr(10);
  echo html_hidden_field('ship_address2', '')       . chr(10);
  echo html_hidden_field('ship_city_town', '')      . chr(10);
  echo html_hidden_field('ship_state_province', '') . chr(10);
  echo html_hidden_field('ship_postal_code', '')    . chr(10);
  echo html_hidden_field('ship_country_code', COMPANY_COUNTRY) . chr(10); 
  echo html_hidden_field('ship_telephone1', '')     . chr(10);
  echo html_hidden_field('ship_email', '')          . chr(10);
} ?>
		  </td>
		</tr>
	  </table>
	</td>
  </tr>
  <tr>
	<td class="formArea">
      <table width="100%"  border="1" cellspacing="0" cellpadding="0">
        <tr>
          <th class="dataTableHeadingContent"><?php echo constant('ORD_TEXT_' . JOURNAL_ID . '_REF_NUM'); ?></th>
          <?php if (ENABLE_MULTI_BRANCH) echo '<th class="dataTableHeadingContent">' . GEN_STORE_ID . '</th>' . chr(10); ?>
          <th class="dataTableHeadingContent"><?php echo constant('ORD_TEXT_' . JOURNAL_ID . '_TEXT_REP'); ?></th>
<?php if (isset($template_options['terms'])) echo '<th class="dataTableHeadingContent">' . $template_options['terms']['title'] . '</th>'; ?>
<?php if (isset($template_options['terminal_date'])) echo '<th class="dataTableHeadingContent">' . $template_options['terminal_date']['title'] . '</th>'; ?>
          <th class="dataTableHeadingContent"><?php echo DEF_GL_ACCT_TITLE; ?></th>
        </tr>
        <tr>
          <td class="main" align="center"><?php echo html_input_field('purch_order_id', $order->purch_order_id, 'size="21" maxlength="20"'); ?></td>
          <?php if (ENABLE_MULTI_BRANCH) { ?>
            <td class="main" align="center"><?php echo html_pull_down_menu('store_id', gen_get_store_ids(), $order->store_id ? $order->store_id : $_SESSION['admin_prefs']['def_store_id']); ?></td>
		  <?php } ?>
          <td class="main" align="center"><?php echo html_pull_down_menu('rep_id', gen_get_rep_ids($account_type), $order->rep_id ? $order->rep_id : $default_sales_rep); ?></td>
<?php if (isset($template_options['terms'])) echo '<td class="main" align="center">' . $template_options['terms']['field'] . '</td>'; ?>
<?php if (isset($template_options['terminal_date'])) echo '<td class="main" align="center">' . $template_options['terminal_date']['field'] . '</td>'; ?>
          <td class="main" align="center">
			<?php echo html_pull_down_menu('gl_acct_id', $gl_array_list, $order->gl_acct_id, ''); ?>
          </td>
        </tr>
      </table>
	</td>
  </tr>
  <tr>
	<td id="productList" class="formArea">
	  <table id="item_table" width="100%" border="1" cellpadding="1" cellspacing="1">
<?php if (SINGLE_LINE_ORDER_SCREEN) { ?>
        <tr>
          <th class="dataTableHeadingContent"><?php echo html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small'); ?></th>
          <th class="dataTableHeadingContent"><?php echo constant('ORD_TEXT_' . JOURNAL_ID . '_ITEM_COLUMN_1'); ?></th>
          <th class="dataTableHeadingContent"><?php echo constant('ORD_TEXT_' . JOURNAL_ID . '_ITEM_COLUMN_2'); ?></th>
          <th class="dataTableHeadingContent"><?php echo TEXT_SKU; ?></th>
          <th class="dataTableHeadingContent"><?php echo TEXT_DESCRIPTION; ?></th>
          <th class="dataTableHeadingContent"><?php echo TEXT_GL_ACCOUNT; ?></th>
          <th class="dataTableHeadingContent"><?php echo TEXT_UNIT_PRICE; ?></th>
          <th class="dataTableHeadingContent"><?php echo ORD_TAX_RATE; ?></th>
          <th class="dataTableHeadingContent"><?php echo TEXT_AMOUNT; ?></th>
        </tr>
<?php } else { // two line order screen ?>
        <tr>
          <th rowspan="2" class="dataTableHeadingContent"><?php echo html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small'); ?></th>
          <th class="dataTableHeadingContent"><?php echo constant('ORD_TEXT_' . JOURNAL_ID . '_ITEM_COLUMN_1'); ?></th>
          <th class="dataTableHeadingContent"><?php echo constant('ORD_TEXT_' . JOURNAL_ID . '_ITEM_COLUMN_2'); ?></th>
          <th class="dataTableHeadingContent"><?php echo TEXT_SKU; ?></th>
          <th colspan="3" class="dataTableHeadingContent"><?php echo TEXT_DESCRIPTION; ?></th>
          <th colspan="2" class="dataTableHeadingContent"><?php echo TEXT_PROJECT; ?></th>
        </tr>
        <tr>
          <th colspan="3" class="dataTableHeadingContent"><?php echo TEXT_GL_ACCOUNT; ?></th>
          <th class="dataTableHeadingContent"><?php echo TEXT_PRICE; ?></th>
          <th class="dataTableHeadingContent"><?php echo TEXT_DISCOUNT; ?></th>
          <th class="dataTableHeadingContent"><?php echo TEXT_UNIT_PRICE; ?></th>
          <th class="dataTableHeadingContent"><?php echo ORD_TAX_RATE; ?></th>
          <th class="dataTableHeadingContent"><?php echo TEXT_AMOUNT; ?></th>
        </tr>
<?php } // end if single line order screen ?>
<?php
		  if ($order->item_rows) {
			for ($j = 0, $i = 1; $j < count($order->item_rows); $j++, $i++) {
				echo '<tr>' . chr(10);
				// turn off delete icon if required
				if (($order->item_rows[$j]['so_po_item_ref_id']) || ((JOURNAL_ID == 4 || JOURNAL_ID == 10) && $order->item_rows[$j]['pstd'])) {
					echo '  <td rowspan="' . ((SINGLE_LINE_ORDER_SCREEN) ? 1 : 2) . '" align="center">&nbsp;</td>' . chr(10);
					$sku_enable = false;
				} else {
					echo '  <td rowspan="' . ((SINGLE_LINE_ORDER_SCREEN) ? 1 : 2) . '" align="center">' . html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . ORD_ROW_DELETE_ALERT . '\')) removeInvRow(' . $i . ');"') . '</td>' . chr(10);
					$sku_enable = true;
				}
				echo '  <td nowrap="nowrap" class="main" align="center">';
				echo html_input_field('qty_' . $i, $order->item_rows[$j]['qty'], ($item_col_1_enable ? '' : ' readonly="readonly"') . ' size="7" maxlength="6" onchange="updateRowTotal(' . $i . ', true)" style="text-align:right"');
				echo '</td>' . chr(10);
				echo '  <td nowrap="nowrap" class="main" align="center">';
				echo html_input_field('pstd_' . $i, $order->item_rows[$j]['pstd'], ($item_col_2_enable ? '' : ' readonly="readonly"') . ' size="7" maxlength="6" onchange="updateRowTotal(' . $i . ', true)" style="text-align:right"');
				// for serialized items, show the icon
				if (in_array(JOURNAL_ID, array(6,7,12,13,18,20))) echo html_icon('actions/tab-new.png', TEXT_SERIAL_NUMBER, 'small', 'align="top" style="cursor:pointer" onclick="serialList(\'serial_' . $i . '\')"');
				echo '</td>' . chr(10);
				echo '  <td nowrap="nowrap" class="main" align="center">';
				echo html_input_field('sku_' . $i, $order->item_rows[$j]['sku'], ($sku_enable ? '' : ' readonly="readonly"') . ' size="' . (MAX_INVENTORY_SKU_LENGTH + 1) . '" maxlength="' . MAX_INVENTORY_SKU_LENGTH . '" onfocus="clearField(\'sku_' . $i . '\', \'' . TEXT_SEARCH . '\')" onblur="setField(\'sku_' . $i . '\', \'' . TEXT_SEARCH . '\'); loadSkuDetails(0, ' . $i . ')"') . chr(10);
				echo html_icon('status/folder-open.png', TEXT_SEARCH, 'small', 'id="sku_open_' . $i . '" align="top" style="cursor:pointer' . ($sku_enable ? '' : ';display:none') . '" onclick="InventoryList(' . $i . ')"') . chr(10);
				echo '</td>' . chr(10);
// for textarea uncomment below (NOTE: the field length is set in the db to 255, this choice does not control the users input character count, or ...
//				echo '  <td colspan="' . ((SINGLE_LINE_ORDER_SCREEN) ? 1 : 5) . '" class="main">' . html_textarea_field('desc_' . $i, (SINGLE_LINE_ORDER_SCREEN)?50:110, '1', $order->item_rows[$j]['desc'], 'maxlength="255"') . '</td>' . chr(10);
// for standard controlled input, uncommet below (default setting)
				echo '  <td colspan="' . ((SINGLE_LINE_ORDER_SCREEN) ? 1 : 3) . '" class="main">' . html_input_field('desc_' . $i, $order->item_rows[$j]['desc'], 'size="'.((SINGLE_LINE_ORDER_SCREEN)?50:75).'" maxlength="255"') . '</td>' . chr(10);
				if (SINGLE_LINE_ORDER_SCREEN) {
				  echo '  <td class="main">' . html_combo_box('acct_' . $i, $gl_array_list, $order->item_rows[$j]['acct'], 'size="10"') . '</td>' . chr(10);
				} else {
				  echo '  <td colspan="2" class="main">' . html_pull_down_menu('proj_' . $i, $proj_list, $order->item_rows[$j]['proj']) . '</td>' . chr(10);
				  echo '</tr>' . chr(10) . '<tr>' . chr(10);
				  echo '  <td colspan="3" class="main">' . html_pull_down_menu('acct_' . $i, $gl_array_list, $order->item_rows[$j]['acct']) . '</td>' . chr(10);
				  echo '  <td class="main">' . html_input_field('full_' . $i, '', 'readonly="readonly" size="11" maxlength="10" style="text-align:right"') . '</td>' . chr(10);
				  echo '  <td class="main">' . html_input_field('disc_' . $i, '', 'readonly="readonly" size="11" maxlength="10" style="text-align:right"') . '</td>' . chr(10);
				}
				echo '  <td nowrap="nowrap" class="main" align="center">';
				echo html_input_field('price_' . $i, $currencies->precise($order->item_rows[$j]['price'], true, $order->currencies_code, $order->currencies_value), 'size="8" maxlength="20" onchange="updateRowTotal(' . $i . ', false)" style="text-align:right"') . chr(10);
				echo html_icon('status/folder-open.png', TEXT_PRICE_MANAGER, 'small', 'align="top" style="cursor:pointer" onclick="PriceManagerList(' . $i . ')"');
				echo '</td>' . chr(10);
				echo '  <td class="main">' . html_pull_down_menu('tax_' . $i, $tax_rates, $order->item_rows[$j]['tax'], 'onchange="updateRowTotal(' . $i . ', false)"') . '</td>' . chr(10);
				echo '  <td class="main" align="center">' . chr(10);
				// Hidden fields
				echo html_hidden_field('id_' . $i,                $order->item_rows[$j]['id']) . chr(10);
				echo html_hidden_field('so_po_item_ref_id_' . $i, $order->item_rows[$j]['so_po_item_ref_id']) . chr(10);
				echo html_hidden_field('weight_' . $i,            $order->item_rows[$j]['weight']) . chr(10);
				echo html_hidden_field('stock_' . $i,             $order->item_rows[$j]['stock']) . chr(10);
				echo html_hidden_field('inactive_' . $i,          $order->item_rows[$j]['inactive']) . chr(10);
				echo html_hidden_field('lead_' . $i,              $order->item_rows[$j]['lead_time']) . chr(10);
				echo html_hidden_field('serial_' . $i,            $order->item_rows[$j]['serial']) . chr(10);
				if (SINGLE_LINE_ORDER_SCREEN) {
				  echo html_hidden_field('proj_'  . $i, $order->item_rows[$j]['proj']) . chr(10);
				  echo html_hidden_field('full_' . $i, '') . chr(10);
				  echo html_hidden_field('disc_' . $i, '') . chr(10);
				}
				// End hidden fields
				echo html_input_field('total_' . $i, $currencies->format($order->item_rows[$j]['total'], true, $order->currencies_code, $order->currencies_value), 'size="11" maxlength="20" onchange="updateUnitPrice(' . $i . ')" style="text-align:right"') . chr(10);
				echo '  </td>' . chr(10);
				echo '</tr>' . chr(10);
			}
		} else {
			
			$hidden_fields .= '<script type="text/javascript">
							addInvRow(); 
							
							</script>' . chr(10);
		} ?>
      </table>
	</td>
  </tr>
  <tr>
    <td align="left"><?php echo html_icon('actions/list-add.png', TEXT_ADD, 'medium', 'onclick="addInvRow()"'); ?></td>
  </tr>
  <tr>
    <td>
	  <table width="100%" border="0" cellspacing="2" cellpadding="0">
        <tr>
          <td class="main">&nbsp;</td>
          <td class="main" align="right">
<?php echo ORD_SUBTOTAL . ' '; ?>
<?php echo html_input_field('subtotal', $currencies->format($order->subtotal, true, $order->currencies_code, $order->currencies_value), 'readonly="readonly" size="15" maxlength="20" style="text-align:right"'); ?>
		  </td>
        </tr>

<?php if (ENABLE_ORDER_DISCOUNT && in_array(JOURNAL_ID, array(9, 10, 12, 19))) { ?>
        <tr>
          <td class="main">
<?php echo ORD_DISCOUNT_GL_ACCT . ' '; 
      echo html_pull_down_menu('disc_gl_acct_id', $gl_array_list, $order->disc_gl_acct_id, ''); ?>
		  </td>
          <td class="main" align="right">
<?php echo ORD_DISCOUNT_PERCENT . ' ' . html_input_field('disc_percent', ($order->disc_percent ? number_format(100*$order->disc_percent,3) : '0'), 'size="7" maxlength="6" onchange="calculateDiscountPercent()" style="text-align:right"') . ' ' . TEXT_DISCOUNT; ?>
<?php echo html_input_field('discount', $currencies->format(($order->discount ? $order->discount : '0'), true, $order->currencies_code, $order->currencies_value), 'size="15" maxlength="20" onchange="calculateDiscount()" style="text-align:right"'); ?>
		  </td>
        </tr>
<?php } else {
  $hidden_fields .= html_hidden_field('disc_gl_acct_id', '')  . chr(10);
  $hidden_fields .= html_hidden_field('discount',        '0') . chr(10);
  $hidden_fields .= html_hidden_field('disc_percent',    '0') . chr(10);
} ?>
<?php if (ENABLE_SHIPPING_FUNCTIONS) { ?>
        <tr>
          <td class="main">
<?php echo ORD_FREIGHT_GL_ACCT . ' '; 
      echo html_pull_down_menu('ship_gl_acct_id', $gl_array_list, $order->ship_gl_acct_id, ''); ?>
		  </td>
          <td class="main" align="right">
<?php echo html_button_field('estimate', TEXT_ESTIMATE, 'onclick="FreightList()"');
  echo ORD_SHIP_CARRIER . ' ' . html_pull_down_menu('ship_carrier', ord_get_shipping_carriers_array(), $default = '', 'onchange="buildFreightDropdown()"');
  echo ' ' . ORD_FREIGHT_SERVICE . ' ' . html_pull_down_menu('ship_service', ord_get_shipping_service_array(), $default = '');
  echo ' ' . ORD_FREIGHT . ' ';
  echo html_input_field('freight', $currencies->format(($order->freight ? $order->freight : '0.00'), true, $order->currencies_code, $order->currencies_value), 'size="15" maxlength="20" onchange="updateTotalPrices()" style="text-align:right"'); ?>
		  </td>
        </tr>
<?php } else {
  echo '        <tr style="display:none"><td colspan="2">' . chr(10);
  echo html_pull_down_menu('ship_carrier', ord_get_shipping_carriers_array(), $default = '', 'style="visibility:hidden"');
  echo html_pull_down_menu('ship_service', ord_get_shipping_service_array(),  $default = '', 'style="visibility:hidden"');
  echo html_hidden_field('ship_gl_acct_id', '');
  echo html_hidden_field('freight', '0') . chr(10);
  echo '        </td></tr>' . chr(10);
} ?>
        <tr>
          <td class="main">&nbsp;</td>
          <td class="main" align="right">
<?php echo ($account_type == 'v') ? ORD_PURCHASE_TAX . ' ' : ORD_SALES_TAX . ' '; ?>
<?php echo ' ' . html_input_field('sales_tax', $currencies->format(($order->sales_tax ? $order->sales_tax : '0.00'), true, $order->currencies_code, $order->currencies_value), 'readonly="readonly" size="15" maxlength="20" onchange="updateTotalPrices()" style="text-align:right"'); ?>
		  </td>
        </tr>
        <tr>
          <td class="main">&nbsp;</td>
          <td class="main" align="right">
<?php echo ORD_INVOICE_TOTAL . ' '; ?>
<?php echo html_input_field('total', $currencies->format($order->total_amount, true, $order->currencies_code, $order->currencies_value), 'readonly="readonly" size="15" maxlength="20" style="text-align:right"'); ?>
		  </td>
        </tr>
        <tr>
          <td>
<?php if (isset($payment_choices) && count($payment_choices) <> 0){// rene added payment just for pos
	echo '<fieldset>';
    echo '<legend>'. TEXT_PAYMENT_METHOD. '</legend>';
	echo'<div style="position: relative; height: 100px;">';
		echo html_pull_down_menu('payment_method', $payment_choices, $order->shipper_code, 'onchange="activateFields()"') . chr(10);
  		$count = 0;
  		foreach ($installed_modules as $value) {
				echo '          <div id="pm_' . $count . '" style="visibility:hidden; position:absolute; top:22px; left:1px">' . chr(10);
				// 		fetch the html inside of module
				$disp_fields = $$value->selection();
				for($i=0; $i<count($disp_fields['fields']); $i++) {
					echo $disp_fields['fields'][$i]['title'] . '<br />' . chr(10);
	  				echo $disp_fields['fields'][$i]['field'] . '<br />' . chr(10);
					}
				echo '          </div>' . chr(10);
				$count++;
				
  		}
  		echo'          	  </div>';
		echo'</fieldset>';
} else { echo '&nbsp;'; } ?>
		  </td>
 		  <td class="main" align="right"></td>
        </tr>

	</script>
	<tr> <td>&nbsp;</td> <td class="main" align="right" valign="center">Finalizar<a title="Inventario" id="saveButton" href="javascript:submitToDo('save');" style="padding-right:2px;padding-left:90px;">
	<?php echo html_icon('devices/media-floppy.png', "GUARDAR y FINALIZAR", 'large', ''); ?> </a> </td> </tr>
      </table>
    </td>
  </tr>
</table>
<?php // display the hidden fields that are not used in this rendition of the form

echo $hidden_fields;

?>

  
  <div id="save_icon">

  </div></a>

<script> 

      if (journalID == 12) //o sea, es la ventana de ventas
	  	  ajaxOrderData(default_final_consumer_id, 0, default_journal_id, true, false);
      
	/* si es una orden de compra o compra, y no se selecciono el proveedor, entonces no le dejo cargar nada*/
    if ((journalID == 4) || (journalID == 6)) {
        $('#sku_1').focus( function () {
					var proveedor = $('#search').val();
					
					if ((proveedor == 'Busque') || (proveedor = "")) {
						alert('Antes de cargar productos, es necesario seleccionar un proveedor');
						$('#search').focus();
					}
					});
     }
    
	//shortcut para buscar
    bindEvents($(document));
    addBackgroundSearch(); 

   
      
</script>
</form> 
