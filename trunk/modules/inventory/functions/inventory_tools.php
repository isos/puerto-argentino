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
//  Path: /modules/inventory/functions/inventory_tools.php
//

function inv_status_open_orders($journal_id, $gl_type) {	// checks order status for order balances, items received/shipped
  global $db;
  $item_list = array();
  $orders = $db->Execute("select id from " . TABLE_JOURNAL_MAIN . " 
  	where journal_id = " . $journal_id . " and closed = '0'");
  while (!$orders->EOF) {
    $id = $orders->fields['id'];
	// retrieve information for requested id
	$sql = " select sku, qty from " . TABLE_JOURNAL_ITEM . " 
		where ref_id = " . $id . " and gl_type = '" . $gl_type . "'";
	$ordr_items = $db->Execute($sql);
	while (!$ordr_items->EOF) {
	  $item_list[$ordr_items->fields['sku']] += $ordr_items->fields['qty'];
	  $ordr_items->MoveNext();
	}
	// calculate received/sales levels (SO and PO)
	$sql = "select i.qty, i.sku 
		from " . TABLE_JOURNAL_MAIN . " m left join " . TABLE_JOURNAL_ITEM . " i on m.id = i.ref_id
		where m.so_po_ref_id = " . $id;
	$posted_items = $db->Execute($sql);
	while (!$posted_items->EOF) {
	  foreach ($item_list as $sku => $balance) {
		if ($sku == $posted_items->fields['sku']) $item_list[$sku] -= $posted_items->fields['qty'];
	  }
	  $posted_items->MoveNext();
	}
	$orders->MoveNext();
  } // end for each open order
  return $item_list;
}

?>