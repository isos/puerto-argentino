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
//  Path: /modules/orders/ajax/load_order.php
//

$function_name = 'fillOrder'; // javascript return function name

/**************   Check user security   *****************************/
$xml   = NULL;
$debug = NULL;
$security_level = (int)$_SESSION['admin_id']; // for ajax, just make sure they are logged in
if ($security_level == 0) { // no permission to enter page, return error
  echo createXmlHeader($function_name) . xmlEntry('error', ERROR_NO_PERMISSION) . createXmlFooter();
  die;
}

/**************  include page specific files    *********************/
require(DIR_FS_MODULES . 'accounts/language/' . $_SESSION['language'] . '/language.php');

/**************   page specific initialization  *************************/
$cID       = db_prepare_input($_GET['cID']);
$oID       = db_prepare_input($_GET['oID']);
$jID       = db_prepare_input($_GET['jID']);
$so_po     = db_prepare_input($_GET['so_po']); // pull from a so/po for invoice/receipt
$just_ship = db_prepare_input($_GET['ship_only']);

define('JOURNAL_ID',$jID);
$error = false;

switch (JOURNAL_ID) {
  case  3:
  case  4: define('GL_TYPE','poo'); break;
  case 21:
  case  6:
  case  7: define('GL_TYPE','por'); break;
  case  9:
  case 10: define('GL_TYPE','soo'); break;
  case 19:
  case 12:
  case 13: define('GL_TYPE','sos'); break;
  case 18: define('GL_TYPE','swr'); break;
  case 20: define('GL_TYPE','pwp'); break;
  default:
}

  if ($oID) {
    $order = $db->Execute("select * from " . TABLE_JOURNAL_MAIN . " where id = '" . $oID . "'");
    if ($order->fields['bill_acct_id']) $cID = $order->fields['bill_acct_id']; // replace cID with ID from order
	$currencies_code  = $order->fields['currencies_code'];
	$currencies_value = $order->fields['currencies_value'];
  } else {
	$order = new objectInfo();
  }
  // select the customer and build the contact record
  if ($just_ship) {
    $ship_acct  = $db->Execute("select * from " . TABLE_CONTACTS . " where id = '" . $cID . "'");
    $type       = $ship_acct->fields['type'];
  } else {
    $contact    = $db->Execute("select * from " . TABLE_CONTACTS . " where id = '" . $cID . "'");
    $type       = $contact->fields['type'];
	$terms_type = ($type == 'v') ? 'AP' : 'AR';
	$contact->fields['terms_text'] = gen_terms_to_language($contact->fields['special_terms'], true, $terms_type);
	$contact->fields['ship_gl_acct_id'] = ($type == 'v') ? AP_DEF_FREIGHT_ACCT : AR_DEF_FREIGHT_ACCT;
    $bill_add   = $db->Execute("select * from " . TABLE_ADDRESS_BOOK . " 
      where ref_id = '" . $cID . "' and type in ('" . $type . "m', '" . $type . "b')");
	//fix some special fields
	if (!$contact->fields['dept_rep_id']) unset($contact->fields['dept_rep_id']); // clear the rep field if not set to a contact
  }
  $ship_add = $db->Execute("select * from " . TABLE_ADDRESS_BOOK . " 
    where ref_id = '" . $cID . "' and type in ('" . $type . "m', '" . $type . "s')");

  // Now fill the order, if it is requested
  if ($order->fields) {
	if ($order->fields['drop_ship']) { // build drop ship information
	  $ship_acct = $db->Execute("select * from " . TABLE_CONTACTS . " where id = '" . $order->fields['ship_acct_id'] . "'");
	  $order->fields['drop_ship_short_name'] = $ship_acct->fields['short_name'];
  	  $type = $ship_acct->fields['type'];
  	  $ship_add = $db->Execute("select * from " . TABLE_ADDRESS_BOOK . " 
        where ref_id = '" . $order->fields['ship_acct_id'] . "' and type in ('" . $type . "m', '" . $type . "s')");
	}
	// correct check boxes since changing the values will not affect the check status but change the value behind it
	$order->fields['cb_closed']     = ($order->fields['closed']    == '1') ? 1 : 0;
	$order->fields['cb_waiting']    = ($order->fields['waiting']   == '1') ? 1 : 0;
	$order->fields['cb_drop_ship']  = ($order->fields['drop_ship'] == '1') ? 1 : 0;
	unset($order->fields['closed']);
	unset($order->fields['waiting']);
	unset($order->fields['drop_ship']);
	// some adjustments based on what we are doing
    $order->fields['search']        = $contact->fields['short_name'];
	$order->fields['post_date']     = gen_spiffycal_db_date_short($order->fields['post_date']);
	$order->fields['terms_text']    = gen_terms_to_language($order->fields['terms'], true, $terms_type);
	$order->fields['disc_percent']  = '0';
	if ($order->fields['terminal_date'] == '000-00-00' || $order->fields['terminal_date'] == '') {
	  unset($order->fields['terminal_date']);
	} else {
	  $order->fields['terminal_date'] = gen_spiffycal_db_date_short($order->fields['terminal_date']);
	}
	if (!$order->fields['rep_id']) unset($order->fields['rep_id']);
	$ship_level = explode(':',$order->fields['shipper_code']);
    $order->fields['ship_carrier'] = $ship_level[0];
    $order->fields['ship_service'] = $ship_level[1];
	if ($so_po) { // opening a SO/PO for Invoice/Receive
	  $id                              = 0;
	  $so_po_ref_id                    = $order->fields['id'];
	  $order->fields['so_po_ref_id']   = $so_po_ref_id;
	  $order->fields['cb_closed']      = 0;
      $order->fields['purch_order_num'] = $order->fields['purchase_invoice_id']; // set the ref field to the SO/PO #
	  unset($order->fields['id']);
	  unset($order->fields['purchase_invoice_id']);
	  unset($order->fields['id']);
	  unset($order->fields['post_date']);
	  unset($order->fields['recur_id']);
	  unset($order->fields['recur_frequency']);
	} else {
	  $id           = $order->fields['id'];
	  $so_po_ref_id = $order->fields['so_po_ref_id'];
	}

	// fetch the line items
	$item_list  = array();
	if ($so_po_ref_id) {	// then there is a purchase order/sales order to load first
	  // fetch the so/po line items per the original order
	  $ordr_items = $db->Execute("select * from " . TABLE_JOURNAL_ITEM . " where ref_id = " . $so_po_ref_id);
	  while (!$ordr_items->EOF) {
		$total = $ordr_items->fields['credit_amount'] + $ordr_items->fields['debit_amount'];
	  	if (in_array($ordr_items->fields['gl_type'], array('poo', 'soo'))) {
		  $subtotal += $total;
		  $inv_details = $db->Execute("select inactive, item_weight, quantity_on_hand, lead_time 
		    from " . TABLE_INVENTORY . " where sku = '" . $ordr_items->fields['sku'] . "'");
		  $item_list[] = array(
			'so_po_item_ref_id' => $ordr_items->fields['id'],
			'qty'               => $ordr_items->fields['qty'],
			'sku'               => $ordr_items->fields['sku'],
			'gl_type'           => $ordr_items->fields['gl_type'],
			'description'       => $ordr_items->fields['description'],
			'gl_account'        => $ordr_items->fields['gl_account'],
			'taxable'           => $ordr_items->fields['taxable'],
			'serialize'         => $ordr_items->fields['serialize_number'],
			'proj_id'           => $ordr_items->fields['project_id'],
			'unit_price'        => $currencies->precise($ordr_items->fields['qty'] ? ($total / $ordr_items->fields['qty']) : '0', true, $currencies_code, $currencies_value),
			'total'             => $currencies->format($total, true, $currencies_code, $currencies_value),
			'full_price'        => $currencies->format($ordr_items->fields['full_price'], true, $currencies_code, $currencies_value),
			'inactive'          => $inv_details->fields['inactive'],
			'weight'            => $inv_details->fields['item_weight'],
			'stock'             => $inv_details->fields['quantity_on_hand'],
			'lead'              => $inv_details->fields['lead_time'],
		  );
		} else if ($ordr_items->fields['gl_type'] == 'dsc') {
		  $discount = $ordr_items->fields['credit_amount'] + $ordr_items->fields['debit_amount'];
		} else {
		  $inv_details = new objectInfo();
		}
		$ordr_items->MoveNext();
	  }
	  // calculate remaining qty levels not including this order
	  $sql = "select i.qty, i.sku, i.so_po_item_ref_id
			from " . TABLE_JOURNAL_MAIN . " m left join " . TABLE_JOURNAL_ITEM . " i on m.id = i.ref_id 
			where m.so_po_ref_id = " . $so_po_ref_id . " and m.id <> " . $id;
	  $posted_items = $db->Execute($sql);
	  while (!$posted_items->EOF) {
		for ($i = 0; $i < count($item_list); $i++) {
		  if ($item_list[$i]['so_po_item_ref_id'] == $posted_items->fields['so_po_item_ref_id']) {
			$item_list[$i]['qty'] -= $posted_items->fields['qty'];
			$item_list[$i]['qty']  = max(0, $item_list[$i]['qty']); // don't let it go negative
			break;
		  }
		}
		$posted_items->MoveNext();
	  }
	}
	if ($id) {
	  // retrieve item information
	  $subtotal = 0;
	  $ordr_items = $db->Execute("select * from " . TABLE_JOURNAL_ITEM . " where ref_id = " . $id);
	  switch (JOURNAL_ID) { // determine where to put value, qty or pstd
		case  3:
		case  4:
		case  9:
		case 10: $qty_pstd = 'qty';  break;
		case  6:
		case  7:
		case 12:
		case 19:
		case 21:
		case 13: $qty_pstd = 'pstd'; break;
		default:
	  }
	  while (!$ordr_items->EOF) {
	    $found = false;
	    $total = $ordr_items->fields['credit_amount'] + $ordr_items->fields['debit_amount'];
	  	if (in_array($ordr_items->fields['gl_type'], array('poo', 'soo', 'por', 'sos'))) {
		  $subtotal += $total;
		  $inv_details = $db->Execute("select inactive, item_weight, quantity_on_hand, lead_time 
		    from " . TABLE_INVENTORY . " where sku = '" . $ordr_items->fields['sku'] . "'");
		} else if ($ordr_items->fields['gl_type'] == 'dsc') {
		  $discount = $ordr_items->fields['credit_amount'] + $ordr_items->fields['debit_amount'];
		} else {
		  $inv_details = new objectInfo();
		}
	    if ($so_po_ref_id) {
//$debug .= ' processing quantity_on_hand = ' . $inv_details->fields['quantity_on_hand'] . ' and total = ' . $total . chr(10);
		  for ($i = 0; $i < count($item_list); $i++) {
		    if ($ordr_items->fields['so_po_item_ref_id'] && $item_list[$i]['so_po_item_ref_id'] == $ordr_items->fields['so_po_item_ref_id']) {
			  $item_list[$i]['id']          = $ordr_items->fields['id'];
			  $item_list[$i]['gl_type']     = $ordr_items->fields['gl_type'];
			  $item_list[$i][$qty_pstd]     = $ordr_items->fields['qty'];
			  $item_list[$i]['description'] = $ordr_items->fields['description'];
			  $item_list[$i]['gl_account']  = $ordr_items->fields['gl_account'];
			  $item_list[$i]['taxable']     = $ordr_items->fields['taxable'];
			  $item_list[$i]['serialize']   = $ordr_items->fields['serialize_number'];
			  $item_list[$i]['proj_id']     = $ordr_items->fields['project_id'];
			  $item_list[$i]['unit_price']  = $currencies->precise($ordr_items->fields['qty'] ? ($total / $ordr_items->fields['qty']) : '0', true, $currencies_code, $currencies_value);
			  $item_list[$i]['total']       = $currencies->format($total, true, $currencies_code, $currencies_value);
			  $item_list[$i]['full_price']  = $currencies->format($ordr_items->fields['full_price'], true, $currencies_code, $currencies_value);
			  $item_list[$i]['inactive']    = $inv_details->fields['inactive'];
			  $item_list[$i]['weight']      = $inv_details->fields['item_weight'];
			  $item_list[$i]['stock']       = $inv_details->fields['quantity_on_hand'];
			  $item_list[$i]['lead']        = $inv_details->fields['lead_time'];
			  $found = true;
			  break;
		    }
		  }
	    }
	    if (!$found) {	// it's an addition to the po/so entered at the purchase/sales window
		  $item_list[] = array(
			'id'          => $ordr_items->fields['id'],
			'gl_type'     => $ordr_items->fields['gl_type'],
			$qty_pstd     => $ordr_items->fields['qty'],
			'sku'         => $ordr_items->fields['sku'],
			'description' => $ordr_items->fields['description'],
			'gl_account'  => $ordr_items->fields['gl_account'],
			'taxable'     => $ordr_items->fields['taxable'],
			'serialize'   => $ordr_items->fields['serialize_number'],
			'proj_id'     => $ordr_items->fields['project_id'],
			'unit_price'  => $currencies->precise($ordr_items->fields['qty'] ? ($total / $ordr_items->fields['qty']) : '0', true, $currencies_code, $currencies_value),
			'total'       => $currencies->format($total, true, $currencies_code, $currencies_value),
			'full_price'  => $currencies->format($ordr_items->fields['full_price'], true, $currencies_code, $currencies_value),
			'inactive'    => $inv_details->fields['inactive'],
			'weight'      => $inv_details->fields['item_weight'],
			'stock'       => $inv_details->fields['quantity_on_hand'],
			'lead'        => $inv_details->fields['lead_time'],
		  );
	    }
	    $ordr_items->MoveNext();
	  }
	  $order->fields['disc_percent'] = ($subtotal <> 0) ? 100 * (1 - (($subtotal - $discount) / $subtotal)) : '0';
	}
	// calculate received/sales levels (SO and PO)
	if (JOURNAL_ID == 4 || JOURNAL_ID == 10) {
	  $sql = "select i.qty, i.sku, i.so_po_item_ref_id 
		  from " . TABLE_JOURNAL_MAIN . " m left join " . TABLE_JOURNAL_ITEM . " i on m.id = i.ref_id
		  where m.so_po_ref_id = " . $id;
	  $posted_items = $db->Execute($sql);
	  while (!$posted_items->EOF) {
		for ($i=0; $i<count($item_list); $i++) {
		  if ($item_list[$i]['id'] == $posted_items->fields['so_po_item_ref_id']) {
			$item_list[$i]['pstd'] += $posted_items->fields['qty'];
			break;
		  }
		}
		$posted_items->MoveNext();
	  }
	}
  }

// build the form data
if ($contact->fields) {
  $xml .= "\t<contact>\n";
  foreach ($contact->fields as $key => $value) $xml .= "\t" . xmlEntry($key, $value);
  $xml .= "\t</contact>\n";
}
if ($bill_add->fields) while (!$bill_add->EOF) {
  $xml .= "\t<billaddress>\n";
  foreach ($bill_add->fields as $key => $value) $xml .= "\t" . xmlEntry($key, $value);
  $xml .= "\t</billaddress>\n";
  $bill_add->MoveNext();
}
if (ENABLE_SHIPPING_FUNCTIONS && $ship_add->fields) while (!$ship_add->EOF) {
  $xml .= "\t<shipaddress>\n";
  foreach ($ship_add->fields as $key => $value) $xml .= "\t" . xmlEntry($key, $value);
  $xml .= "\t</shipaddress>\n";
  $ship_add->MoveNext();
}
if ($ship_acct->fields) { // there was a drop ship address
  $xml .= "\t<shipcontact>\n";
  foreach ($ship_acct->fields as $key => $value) $xml .= "\t" . xmlEntry($key, $value);
  $xml .= "\t</shipcontact>\n";
}

if ($order->fields) { // there was an order to open
  $xml .= "\t<order>\n";
  foreach ($order->fields as $key => $value) $xml .= "\t" . xmlEntry($key, strval($value));
  $xml .= "\t</order>\n";
  foreach ($item_list as $item) {
	$xml .= "\t<items>\n";
	foreach ($item as $key => $value) $xml .= "\t\t" . xmlEntry($key, strval($value));
	$xml .= "\t</items>\n";
  }
}

if ($debug) $xml .= xmlEntry('debug', $debug);
//put it all together
$str  = createXmlHeader($function_name);
$str .= $xml;
$str .= createXmlFooter();
echo $str;
die;
?>