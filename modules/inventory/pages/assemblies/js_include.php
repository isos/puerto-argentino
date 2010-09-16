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
//  Path: /modules/inventory/pages/assemblies/js_include.php
//

?>
<script type="text/javascript">
<!--
ajaxRH["skuDetails"] = "processSkuDetails";
ajaxRH["loadRecord"] = "processEditAssembly";

// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.
var datePost = new ctlSpiffyCalendarBox("datePost", "inv_assy", "post_date", "btnDate2", "<?php echo isset($cInfo->post_date) ? gen_spiffycal_db_date_short($cInfo->post_date) : date(DATE_FORMAT, time()); ?>", scBTNMODE_CALBTN);

function init() {
  cssjsmenu('navbar');
  document.getElementById('sku_1').focus();
<?php if ($action == 'edit') echo '  EditAssembly(' . $oID . ')'; ?>

}

function check_form() {
  var error = 0;
  var error_message = "<?php echo JS_ERROR; ?>";

  var sku = document.getElementById('sku_1').value;
  if (sku == '') { // check for sku not blank
  	error_message += '<?php echo JS_NO_SKU_ENTERED; ?>';
	error = 1;
  }

  var qty = document.getElementById('qty_1').value;
  if (qty == '' || qty == '0') { // check for quantity non-zero
  	error_message += '<?php echo JS_ASSY_VALUE_ZERO; ?>';
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
  document.getElementById('sku_1').value               = '';
  document.getElementById('serial_1').value            = '';
  document.getElementById('desc_1').value              = '';
  document.getElementById('stock_1').value             = '0';
  document.getElementById('qty_1').value               = '';
  document.getElementById('bal_1').value               = '';
  // delete the current rows, if any
  while (document.getElementById("item_table").rows.length > 1) document.getElementById("item_table").deleteRow(-1);
}

function InventoryList() {
  var bID = document.getElementById('store_id').value;
  var sku = document.getElementById('sku_1').value;
  window.open("index.php?cat=inventory&module=popup_inv&page=1&type=v&f1=as&storeID="+bID+"&search_text="+sku,"inventory","width=700,height=550,resizable=1,scrollbars=1,top=150,left=200");
}

function OpenAssyList() {
  clearForm();
  window.open("index.php?cat=inventory&module=popup_assy&page=1","inv_assy_open","width=700,height=550,resizable=1,scrollbars=1,top=150,left=200");
}

function EditAssembly(rID) {
  loadXMLReq('index.php?cat=gen_ledger&module=ajax&op=load_record&rID='+rID);
}

function processEditAssembly(resp) {
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
	    break;
	  case 'asy':
		document.getElementById('sku_1').value    = data.items[iIndex].sku;
		document.getElementById('serial_1').value = data.items[iIndex].serialize;
		document.getElementById('desc_1').value   = data.items[iIndex].description;
		document.getElementById('qty_1').value    = data.items[iIndex].qty;
		var sku = data.items[iIndex].sku;
	  default: // do nothing
	}
  }
  loadSkuStock(sku);
}

function loadSkuStock(sku) {
  var bID = document.getElementById('store_id').value;
  loadXMLReq('index.php?cat=inventory&module=ajax&op=inv_details&fID=skuDetails&sku='+sku+'&bID='+bID+'&strict=1');
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
  document.getElementById('sku_1').value       = data.sku;
  document.getElementById('sku_1').style.color = '';
  if (document.getElementById('desc_1').value == '') { // do not overwrite if already there
    document.getElementById('desc_1').value    = data.description_purchase;
  }
  document.getElementById('stock_1').value     = data.branch_qty_in_stock;
  if (data.inventory_type == 'sr' || data.inventory_type == 'sa') {
    document.getElementById('serial_row').style.display = '';
  }
  // add the new data
  while (document.getElementById("item_table").rows.length > 1) document.getElementById("item_table").deleteRow(-1);
  for (var i=0, j=1; i<data.bom.length; i++, j++) {
	addListRow();
	document.getElementById('assy_sku_'+j).value  = data.bom[i].sku;
	document.getElementById('assy_desc_'+j).value = data.bom[i].description_short;
	document.getElementById('qty_reqd_'+j).value  = data.bom[i].qty;
	document.getElementById('assy_qty_'+j).value  = data.bom[i].qty;
	document.getElementById('stk_'+j).value       = data.bom[i].quantity_on_hand;
  }
  addListRow();
  document.getElementById('assy_desc_'+j).value = '<?php echo TEXT_TOTAL; ?>';
  updateBalance();
}

function addListRow() {
	var cell     = new Array(2);
	var newRow   = document.getElementById("item_table").insertRow(-1);
	var rowCnt   = newRow.rowIndex;
	var newCella = newRow.insertCell(-1); // sku data
	newCella.innerHTML = '<td class="main" align="right"><input type="text" name="assy_sku_'+rowCnt+'" id="assy_sku_'+rowCnt+'" readonly="readonly" size="15"><\/td>';
	var newCellb = newRow.insertCell(-1); // description data
	newCellb.innerHTML = '<td class="main" align="right"><input type="text" name="assy_desc_'+rowCnt+'" id="assy_desc_'+rowCnt+'" readonly="readonly" size="35"><\/td>';
	var newCellc = newRow.insertCell(-1); // qty required
	newCellc.innerHTML = '<td class="main" align="right"><input type="hidden" name="qty_reqd_'+rowCnt+'" id="qty_reqd_'+rowCnt+'"><input type="text" name="assy_qty_'+rowCnt+'" id="assy_qty_'+rowCnt+'" readonly="readonly" style="text-align:right" size="10"><\/td>';
	var newCelld = newRow.insertCell(-1); // qty in stock
	newCelld.innerHTML = '<td class="main" align="right"><input type="text" name="stk_'+rowCnt+'" id="stk_'+rowCnt+'" readonly="readonly" style="text-align:right" size="10"><\/td>';
}

function removeListRow(delRowCnt) {
  document.getElementById("item_table").deleteRow(-1);
} 

function checkBalances() {
	var qtyNeeded;
	var qtyStock;
	var qtyCheck;
	var error = false;
	for (var i=1; i<document.getElementById('item_table').rows.length-1; i++) {
		qtyNeeded = document.getElementById('assy_qty_'+i).value;
		qtyStock = document.getElementById('stk_'+i).value;
		qtyCheck = qtyStock - qtyNeeded;
		if (qtyCheck < 0) {
			document.getElementById('stk_'+i).style.color = 'red';
			error = true;
		} else {
			document.getElementById('stk_'+i).style.color = '';
		}
	}
	if (error) alert('<?php echo JS_NOT_ENOUGH_PARTS; ?>');
}

function updateBalance() {
	var qtyMin, newQtyNeeded, totalNeeded, totalAvailable;
	var stock = parseFloat(document.getElementById('stock_1').value);
	if (isNaN(stock)) stock = 0;
	var build = parseFloat(document.getElementById('qty_1').value);
	if (isNaN(build)) {
		build = 0;
	} else {
		totalNeeded    = 0;
		totalAvailable = 0;
		// update qty required
		for (var i=1; i<document.getElementById('item_table').rows.length-1; i++) {
			qtyMin          = parseFloat(document.getElementById('qty_reqd_'+i).value);
			newQtyNeeded    = build * qtyMin;
			totalNeeded    += newQtyNeeded;
			totalAvailable += parseFloat(document.getElementById('stk_'+i).value);
			document.getElementById('assy_qty_'+i).value = newQtyNeeded;
		}
		document.getElementById('assy_qty_'+i).value = totalNeeded;
		document.getElementById('stk_'+i).value      = totalAvailable;
	}
	var st = new String(stock + build);
	document.getElementById('bal_1').value = st;
	checkBalances();
}

// -->
</script>