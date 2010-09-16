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
//  Path: /modules/inventory/pages/adjustments/js_include.php
//

?>
<script type="text/javascript">
<!--
ajaxRH["skuDetails"] = "processSkuDetails";
ajaxRH["skuStock"]   = "processSkuStock";
ajaxRH["loadRecord"] = "processEditAdjustment";

// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.
var adj_qty = 0;
var unit_price_placeholder = false;
var unit_price_note = '<?php echo JS_COGS_AUTO_CALC; ?>';
var dateReference = new ctlSpiffyCalendarBox("dateReference", "inv_adj", "post_date","btnDate1", "<?php echo isset($cInfo->post_date) ? gen_spiffycal_db_date_short($cInfo->post_date) : date(DATE_FORMAT, time()); ?>", scBTNMODE_CALBTN);

function init() {
  cssjsmenu('navbar');
  document.getElementById('sku_1').focus();
<?php if ($action == 'edit') echo '  EditAdjustment(' . $oID . ')'; ?>

}

function check_form() {
  var error = 0;
  var error_message = '<?php echo JS_ERROR; ?>';

  var sku = document.getElementById('sku_1').value;
  if (sku == '') { // check for sku not blank
  	error_message += '<?php echo JS_NO_SKU_ENTERED; ?>';
	error = 1;
  }

  var qty = document.getElementById('adj_qty').value;
  if (qty == '' || qty == '0') { // check for quantity non-zero
  	error_message += '<?php echo JS_ADJ_VALUE_ZERO; ?>';
	error = 1;
  }

  if (error == 1) {
    alert(error_message);
    return false;
  }
  return true;
}

// Insert other page specific functions here.
function clearForm() {
  document.getElementById('id').value                  = 0;
  document.getElementById('store_id').value            = 0;
  document.getElementById('purchase_invoice_id').value = '';
  document.getElementById('post_date').value           = '<?php echo date(DATE_FORMAT, time()); ?>';
  document.getElementById('adj_reason').value          = '';
  document.getElementById('acct_1').value              = '';
  document.getElementById('sku_1').value               = '';
  document.getElementById('serial_1').value            = '';
  document.getElementById('desc_1').value              = '';
  document.getElementById('stock_1').value             = '0';
  document.getElementById('price_1').value             = '';
  document.getElementById('adj_qty').value             = '';
  document.getElementById('balance').value             = '';
}

function InventoryList(rowCnt) {
  var bID = document.getElementById('store_id').value;
  var sku = document.getElementById('sku_1').value;
  window.open("index.php?cat=inventory&module=popup_inv&page=1&type=v&storeID="+bID+"&search_text="+sku,"inventory","width=700,height=550,resizable=1,scrollbars=1,top=150,left=200");
}

function OpenAdjList() {
  clearForm();
  window.open("index.php?cat=inventory&module=popup_adj&page=1&form=inv_adj","inv_adj_open","width=700,height=550,resizable=1,scrollbars=1,top=150,left=200");
}

function loadSkuDetails(iID) {
  var bID = document.getElementById('store_id').value;
  loadXMLReq('index.php?cat=inventory&module=ajax&op=inv_details&fID=skuDetails&iID='+iID+'&bID='+bID);
}

function processSkuDetails(resp) { // call back function
  var text = '';
  data = parseXML(resp);
  if (data.error) {
    alert(data.error);
	return;
  }
  document.getElementById('price_1').value     = formatPrecise(data.item_cost);
  document.getElementById('acct_1').value      = data.account_cost_of_sales;
  document.getElementById('stock_1').value     = data.branch_qty_in_stock;
alert('qty in sotck = '+data.quantity_on_hand+' and branch qty = '+data.branch_qty_in_stock);
  document.getElementById('sku_1').value       = data.sku;
  document.getElementById('sku_1').style.color = '';
  document.getElementById('desc_1').value      = data.description_purchase;
  if (data.inventory_type == 'sr' || data.inventory_type == 'sa') {
    document.getElementById('serial_row').style.display = '';
  }
}

function EditAdjustment(rID) {
  loadXMLReq('index.php?cat=gen_ledger&module=ajax&op=load_record&rID='+rID);
}

function processEditAdjustment(resp) {
  data = parseXML(resp);
  if (data.error) {
    alert(data.error);
	return;
  }
  document.getElementById('id').value                  = data.id;
  document.getElementById('store_id').value            = data.store_id;
  document.getElementById('purchase_invoice_id').value = data.purchase_invoice_id;
  document.getElementById('post_date').value           = formatDate(data.post_date);
  // fill item rows
  for (iIndex=0; iIndex<data.items.length; iIndex++) {
	switch (data.items[iIndex].gl_type) {
	  case 'ttl':
		document.getElementById('adj_reason').value = data.items[iIndex].description;
		document.getElementById('acct_1').value     = data.items[iIndex].gl_account;
	    break;
	  case 'adj':
		document.getElementById('sku_1').value      = data.items[iIndex].sku;
		document.getElementById('serial_1').value   = data.items[iIndex].serialize;
		document.getElementById('desc_1').value     = data.items[iIndex].description;
		document.getElementById('price_1').value    = formatPrecise(data.items[iIndex].debit_amount / data.items[iIndex].qty);
		document.getElementById('adj_qty').value    = data.items[iIndex].qty;
		adj_qty = data.items[iIndex].qty;
		var sku = data.items[iIndex].sku;
	  default: // do nothing
	}
  }
  loadSkuStock(sku);
}

function loadSkuStock(sku) {
  var bID = document.getElementById('store_id').value;
  loadXMLReq('index.php?cat=inventory&module=ajax&op=inv_details&fID=skuStock&sku='+sku+'&bID='+bID);
  updateBalance()
}

function processSkuStock(resp) { // call back function
  var text = '';
  data = parseXML(resp);
  if (data.error) {
    alert(data.error);
	return;
  }
  document.getElementById('stock_1').value = data.branch_qty_in_stock - adj_qty;
  updateBalance();
}

function updateBalance() {
  var stock = parseFloat(document.getElementById('stock_1').value);
  var adj   = parseFloat(document.getElementById('adj_qty').value);
  document.getElementById('balance').value = stock + adj;
  if (adj < 0) {
	unit_price_placeholder = document.getElementById('price_1').value;
	document.getElementById('price_1').value = '';
	document.getElementById('price_1').readOnly = true;
	if (document.all) { // IE browsers
	  document.getElementById('unit_price_id').innerText = unit_price_note;
	} else { //firefox
	  document.getElementById('unit_price_id').textContent = unit_price_note;
	}
  } else {
	if (unit_price_placeholder) document.getElementById('price_1').value = unit_price_placeholder;
	document.getElementById('price_1').readOnly = false;	
	if(document.all) { // IE browsers
	  document.getElementById('unit_price_id').innerText = '';
	} else { //firefox
	  document.getElementById('unit_price_id').textContent = '';
	}
  }
}

// -->
</script>