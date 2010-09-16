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
//  Path: /modules/inventory/pages/tools/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_GEN_ADMIN_TOOLS];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING . 'functions/inventory_tools.php');

/**************   page specific initialization  *************************/
$cog_type = explode(',', COG_ITEM_TYPES);
$action   = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);
$error    = false;

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/inventory/tools/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'inv_hist_test':
  case 'inv_hist_fix':
	if ($security_level < 4) {
	  $messageStack->add_session(ERROR_NO_PERMISSION,'error');
	  gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
	  break;
	}

	$result = $db->Execute("select sku, qty from " . TABLE_INVENTORY_COGS_OWED);
	$owed = array();
	while (!$result->EOF) {
	  $owed[$result->fields['sku']] += $result->fields['qty'];
	  $result->MoveNext();
	}
	// fetch the inventory items that we track COGS and get qty on hand
	$result = $db->Execute("select sku, quantity_on_hand from " . TABLE_INVENTORY . " 
	  where inventory_type in ('" . implode("', '", $cog_type) . "') order by sku");
	// for each item, find the history remaining Qty's
	$cnt = 0;
	$repair = array();
	while (!$result->EOF) {
	  // check for quantity on hand not rounded properly
	  $on_hand = round($result->fields['quantity_on_hand'], $currencies->currencies[DEFAULT_CURRENCY]['decimal_precise']);
	  if ($on_hand <> $result->fields['quantity_on_hand']) {
	    $repair[$result->fields['sku']] = $on_hand;
		if ($action <> 'inv_hist_fix') {
		  $messageStack->add(sprintf(INV_TOOLS_STOCK_ROUNDING_ERROR, $result->fields['sku'], $result->fields['quantity_on_hand'], $on_hand), 'error');
		  $cnt++;
		}
	  }
	  // now check with inventory hostory
	  $sql = "select sum(remaining) as remaining from " . TABLE_INVENTORY_HISTORY . " 
		where sku = '" . $result->fields['sku'] . "' and remaining > 0";
	  $inv_hist = $db->Execute($sql);
	  if ($inv_hist->fields['remaining'] > 0) {
		$cog_qty  = round($inv_hist->fields['remaining'], $currencies->currencies[DEFAULT_CURRENCY]['decimal_precise']);
		$cog_owed = $owed[$result->fields['sku']] ? $owed[$result->fields['sku']] : 0;
		if ($on_hand <> ($cog_qty - $cog_owed)) {
		  $repair[$result->fields['sku']] = $cog_qty - $cog_owed;
		  if ($action <> 'inv_hist_fix') {
		    $messageStack->add(sprintf(INV_TOOLS_OUT_OF_BALANCE, $result->fields['sku'], $on_hand, ($cog_qty - $cog_owed)), 'error');
		    $cnt++;
		  }
		}
	  }
	  $result->MoveNext();
	}
	// flag the differences
	if ($action == 'inv_hist_fix') { // start repair
	  $precision = 1 / pow(10, $currencies->currencies[DEFAULT_CURRENCY]['decimal_precise'] + 1);
	  $result = $db->Execute("update " . TABLE_INVENTORY_HISTORY . " set remaining = 0 where remaining < " . $precision); // remove rounding errors
	  if (sizeof($repair) > 0) {
	    foreach ($repair as $key => $value) {
		  $sql = "update " . TABLE_INVENTORY . " set quantity_on_hand = " . $value . " 
		  	where sku = '" . $key . "'";
		  $db->Execute($sql);
		  $messageStack->add(sprintf(INV_TOOLS_BALANCE_CORRECTED, $key, $value), 'success');
		}
	  }
	}
	if ($cnt == 0) $messageStack->add(INV_TOOLS_IN_BALANCE, 'success');
    break;

  case 'inv_on_order_fix':
	if ($security_level < 4) {
	  $messageStack->add_session(ERROR_NO_PERMISSION,'error');
	  gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
	  break;
	};

    // fetch the inventory items that we track COGS and get qty on SO, PO
	$cnt = 0;
	$fix = 0;
	$inv = array();
	$po  = array();
	$so  = array();
	$items = $db->Execute("select id, sku, quantity_on_order, quantity_on_sales_order from " . TABLE_INVENTORY . " 
	  where inventory_type in ('" . implode("', '", $cog_type) . "') order by sku");
	while(!$items->EOF) {
	  $inv[$items->fields['sku']] = array(
	    'id'     => $items->fields['id'],
	    'qty_so' => $items->fields['quantity_on_sales_order'],
		'qty_po' => $items->fields['quantity_on_order'],
	  );
	  $items->MoveNext();
	}
	// fetch the PO's and SO's balances
	$po = inv_status_open_orders($journal_id =  4, $gl_type = 'poo');
	$so = inv_status_open_orders($journal_id = 10, $gl_type = 'soo');

	// compare the results and repair
	if (sizeof($inv) > 0) foreach ($inv as $sku => $balance) {
	  if (!isset($po[$sku])) $po[$sku] = 0;
	  if ($balance['qty_po'] <> $po[$sku]) {
	    $messageStack->add(sprintf(INV_TOOLS_PO_ERROR, $sku, $balance['qty_po'], $po[$sku]), 'caution');
		$db->Execute("update " . TABLE_INVENTORY . " set quantity_on_order = " . $po[$sku] . " where id = " . $balance['id']);
		$fix++;
	  }
	  if (!isset($so[$sku])) $so[$sku] = 0;
	  if ($balance['qty_so'] <> $so[$sku]) {
	    $messageStack->add(sprintf(INV_TOOLS_SO_ERROR, $sku, $balance['qty_so'], $so[$sku]), 'caution');
		$db->Execute("update " . TABLE_INVENTORY . " set quantity_on_sales_order = " . $so[$sku] . " where id = " . $balance['id']);
	    $fix++;
	  }
	  $cnt++;
	}
	$messageStack->Add(sprintf(INV_TOOLS_SO_PO_RESULT, $cnt, $fix),'success');
	gen_add_audit_log(sprintf(INV_TOOLS_AUTDIT_LOG_SO_PO,  $cnt), 'Fixed: ' . $fix);
    break;

  default:
}

/*****************   prepare to display templates  *************************/
$include_header   = true;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = true;
$include_template = 'template_main.php';
define('PAGE_TITLE', BOX_INV_TOOLS);

?>