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
//  Path: /modules/banking/javascript/banking.js
//
// AJAX stuff first
ajaxRH["fillGuess"] = "processGuess";
ajaxRH["fillBill"]  = "fillBillData";

var bill_add = new Array(0);

function ClearForm() {
  var add_id;
  document.getElementById('id').value                     = '';
  document.getElementById('bill_acct_id').value           = '';
  document.getElementById('bill_address_id').value        = '';
  document.getElementById('bill_telephone1').value        = '';
  document.getElementById('bill_email').value             = '';
  document.getElementById('search').value                 = text_search;
//  document.getElementById('purchase_invoice_id').value  = ''; // this erases the current receipt/check number
  document.getElementById('post_date').value              = defaultPostDate;
  document.getElementById('purch_order_id').value         = '';
  document.getElementById('gl_acct_id').value             = defaultGlAcct;
  document.getElementById('gl_disc_acct_id').value        = defaultDiscAcct;
  document.getElementById('total').value                  = '';
//  document.getElementById('acct_balance').value         = formatted_zero; // this is calculated in loadNewBalance below
//  document.getElementById('end_balance').value          = formatted_zero;
  document.getElementById('shipper_code').value           = '';
  // some special initialization
  document.getElementById('search').style.color           = inactive_text_color;
  document.getElementById('purchase_invoice_id').readOnly = false;
  document.getElementById('bill_country_code').value      = store_country_code;
  for (var i=0; i<add_array.length; i++) {
	add_id = add_array[i];
	if (add_id != 'country_code') document.getElementById('bill_'+add_id).style.color = inactive_text_color;
	document.getElementById('bill_'+add_id).value = default_array[i];
  }
  while (document.getElementById('bill_to_select').options.length) {
	document.getElementById('bill_to_select').remove(0);
  }
  while (document.getElementById('payment_id').options.length) {
	document.getElementById('payment_id').remove(0);
  }
  while (document.getElementById("item_table").rows.length > 1) {
	document.getElementById("item_table").deleteRow(-1); 
  }
  loadNewBalance(defaultGlAcct);
}

function accountGuess(force) {
  var guess = document.getElementById('search').value;
  if (!force) {
    if (document.getElementById('bill_acct_id').value) return; // data has already been filled
  }
  if (!post_error && (force || (guess != text_search && guess != ''))) {
    loadXMLReq('index.php?cat=banking&module=ajax&op=load_searches&type='+account_type+'&guess='+guess);
  }
}

function processGuess(resp) {
  data = parseXML(resp);
  if (data.error) {
    alert (data.error);
  } else if (data.result == 'success') {
    fillBillData(resp);
  } else {
    window.open("index.php?cat=banking&module=popup_bills_accts&page=1&jID="+journalID+"&type="+account_type+"&search_text="+document.getElementById('search').value,"invoices","width=700px,height=550px,resizable=1,scrollbars=1,top=150,left=200");
  }
}

function OpenOrdrList(currObj) {
  window.open("index.php?cat=banking&module=popup_bills&page=1&form=bills_form&jID="+journalID+"&type="+account_type,"invoices","width=700px,height=550px,resizable=1,scrollbars=1,top=150,left=200");
}

function popupWindowCvv() {
  window.open("index.php?cat=banking&module=popup_cvv","popup_payment_cvv","width=550,height=550,resizable=1,scrollbars=1,top=150,left=200");
}

function ajaxBillData(cID, bID, jID) {
  loadXMLReq('index.php?cat=banking&module=ajax&op=load_bill&cID='+cID+'&bID='+bID+'&jID='+jID);
}

function fillBillData(resp) { // edit response form fill 
  data = parseXML(resp);
  if (data.debug) alert(data.debug);
  if (data.error) {
	alert(data.error);
	return;
  }
  ClearForm();
  billFillAddress(data.contact[0], data.billaddress);
  if (data.bill) fillBill(data.bill[0], data.items);
  loadNewPayment();
}

function billFillAddress(contact, address) {
  var newOpt, i;
  insertValue('bill_acct_id', contact.id);
  while (document.getElementById('bill_to_select').options.length) document.getElementById('bill_to_select').remove(0);
  var mainType = contact.type + 'm';
  bill_add = address;
  insertValue('search', contact.short_name);

  for (i=0; i<address.length; i++) {
    newOpt = document.createElement("option");
	newOpt.text = address[i].primary_name + ', ' + address[i].city_town + ', ' + address[i].postal_code;
	document.getElementById('bill_to_select').options.add(newOpt);
	document.getElementById('bill_to_select').options[i].value = i;
    if (address[i].type == mainType) { // also fill the fields
     insertValue('bill_address_id', address[i].address_id);
     for (var dVal in address[i]) {
	    if (document.getElementById('bill_'+dVal) && address[i][dVal]) {
	      document.getElementById('bill_'+dVal).value = address[i][dVal];
	      document.getElementById('bill_'+dVal).style.color = '';
	    }
      }
    }
  }
  // add a option for creating a new address
  newOpt = document.createElement("option");
  newOpt.text = text_enter_new;
  document.getElementById('bill_to_select').options.add(newOpt);	
  document.getElementById('bill_to_select').options[i].value = 'new';
  document.getElementById('bill_to_select').style.visibility = 'visible';
  document.getElementById('bill_to_select').disabled = false;
}

function fillBill(data, items) {
  for (var dVal in data) {
	if (document.getElementById(dVal)) {
	  document.getElementById(dVal).value = data[dVal];
	  document.getElementById(dVal).style.color = '';
	}
  }
  // fix some special cases, checkboxes, and active fields
  if (data.shipper_code && journalID == '18') { // holds payment method for receipts
	var shipper_code = data.shipper_code;
	document.getElementById('shipper_code').value = shipper_code;
	activateFields();
	if (data.payment_fields) {
	  var fieldArray = data.payment_fields.split(':');
	  for (i=0, j=1; i<fieldArray.length; i++, j++) {
		if (document.getElementById(shipper_code+'_field_'+i))
		  document.getElementById(shipper_code+'_field_'+i).value = fieldArray[j];
	  }
	}
  }

  // fill invoice rows
  for (iIndex=0, j=1; iIndex<items.length; iIndex++, j++) {
//alert('index = '+iIndex+' and row ID = '+j+' and gl_type = '+items[iIndex].gl_type);
	var rowCnt = addInvRow();
	insertValue('id_'  + j,    items[iIndex].id);
	insertValue('inv_' + j,    items[iIndex].purchase_invoice_id);
	insertValue('prcnt_' + j,  items[iIndex].percent);
	insertValue('early_'  + j, items[iIndex].early_date);
	insertValue('due_'  + j,   items[iIndex].net_date);
	insertValue('amt_'  + j,   items[iIndex].total_amount);
	insertValue('acct_'  + j,  items[iIndex].gl_acct_id);
	insertValue('desc_'  + j,  items[iIndex].description);
	insertValue('dscnt_'  + j, items[iIndex].discount);
	insertValue('total_'  + j, items[iIndex].amount_paid);
	if (items[iIndex].waiting == '1') { // waiting for invoice (no invoice number)
		document.getElementById('desc_' + j).readOnly  = true;
		document.getElementById('dscnt_' + j).readOnly = true;
		document.getElementById('total_' + j).readOnly = true;
		document.getElementById('item_table').rows[rowCnt].className = 'rowInactive';
		document.getElementById('item_table').rows[rowCnt].cells[6].innerHTML = '&nbsp;'; // remove checkbox
	} else if (items[iIndex].amount_paid) {
		document.getElementById('pay_' + j).checked    = true;
	}
  }
  updateTotalPrices();
}

function fillAddress(type) {
	var index   = document.getElementById('bill_to_select').value;
	var address = bill_add[index];
	if (!address) {
	  document.getElementById(type+'_acct_id').value    = 0;
	  document.getElementById(type+'_address_id').value = 0;
	  for (var i=0; i<add_array.length; i++) {
		add_id = add_array[i];
		if (add_id != 'country_code') document.getElementById(type+'_'+add_id).style.color = inactive_text_color;
		document.getElementById(type+'_'+add_id).value = default_array[i];
	  }
	  return;
	}
	document.getElementById(type+'_acct_id').value    = address.ref_id;
	document.getElementById(type+'_address_id').value = (index == 'new') ? '0' : address.address_id;
	var add_id;
	for (var i=0; i<add_array.length; i++) {
		add_id = add_array[i];
		if (index != 'new' && address[add_id]) {
			document.getElementById(type+'_'+add_id).style.color = '';
			document.getElementById(type+'_'+add_id).value = address[add_id];
		} else {
			if (add_id != 'country_code') document.getElementById(type+'_'+add_id).style.color = inactive_text_color;
			document.getElementById(type+'_'+add_id).value = default_array[i];
		}
	}
}

function addInvRow() {
   var cell = Array(7);
   var newRow = document.getElementById("item_table").insertRow(-1);
   var newCell;
   rowCnt = newRow.rowIndex;

   // NOTE: any change here also need to be made below for reload if action fails
   cell[0] = '<td class="main" align="center"><input type="text" name="inv_'+rowCnt+'" id="inv_'+rowCnt+'" readonly="readonly" size="15">';
// Hidden fields
   cell[0] += '<input type="hidden" name="id_'+rowCnt+'"    id="id_'+rowCnt+'"    value="">';
   cell[0] += '<input type="hidden" name="prcnt_'+rowCnt+'" id="prcnt_'+rowCnt+'" value="">';
   cell[0] += '<input type="hidden" name="early_'+rowCnt+'" id="early_'+rowCnt+'" value="">';
   cell[0] += '<input type="hidden" name="acct_'+rowCnt+'"  id="acct_'+rowCnt+'"  value="">';
// End hidden fields
   cell[0] += '</td>';
   cell[1] = '<td class="main" align="center"><input type="text" name="due_'+rowCnt+'" id="due_'+rowCnt+'" readonly="readonly" size="15"></td>';
   cell[2] = '<td class="main" align="center"><input type="text" name="amt_'+rowCnt+'" id="amt_'+rowCnt+'" readonly="readonly" size="12" style="text-align:right"></td>';
   cell[3] = '<td class="main" align="center"><input type="text" name="desc_'+rowCnt+'" id="desc_'+rowCnt+'" size="64" maxlength="64"></td>';
   cell[4] = '<td class="main" align="center"><input type="text" name="dscnt_'+rowCnt+'" id="dscnt_'+rowCnt+'" size="15" maxlength="20" onchange="updateRowTotal('+rowCnt+')" style="text-align:right"></td>';
   cell[5] = '<td class="main" align="center"><input type="text" name="total_'+rowCnt+'" id="total_'+rowCnt+'" value="'+formatted_zero+'" size="15" maxlength="20" onchange="updateUnitPrice('+rowCnt+')" style="text-align:right"></td>';
   cell[6] = '<td class="main" align="center"><input type="checkbox" name="pay_'+rowCnt+'" id="pay_'+rowCnt+'" value="1" onclick="updatePayValues('+rowCnt+')"></td>';

   for (var i=0; i<cell.length; i++) {
		newCell = newRow.insertCell(-1);
		newCell.innerHTML = cell[i];
	}
	return rowCnt;
}

function addBulkRow() {
   var cell = Array(7);
   var newRow = document.getElementById("item_table").insertRow(-1);
   var newCell;
   rowCnt = newRow.rowIndex;

   // NOTE: any change here also need to be made below for reload if action fails
   cell[0] = '<td class="main" align="center"><input type="text" name="due_'+rowCnt+'" id="due_'+rowCnt+'" readonly="readonly" size="15"></td>';
// Hidden fields
   cell[0] += '<input type="hidden" name="id_'+rowCnt+'" id="id_'+rowCnt+'" value="">';
   cell[0] += '<input type="hidden" name="prcnt_'+rowCnt+'" id="prcnt_'+rowCnt+'" value="">';
   cell[0] += '<input type="hidden" name="early_'+rowCnt+'" id="early_'+rowCnt+'" value="">';
   cell[0] += '<input type="hidden" name="acct_'+rowCnt+'" id="acct_'+rowCnt+'" value="">';
// End hidden fields
   cell[0] += '</td>';
   cell[1] = '<td class="main" align="center"><input type="text" name="disc_'+rowCnt+'" id="disc_'+rowCnt+'" readonly="readonly" size="15"></td>';
   cell[2] = '<td class="main" align="center"><input type="text" name="desc_'+rowCnt+'" id="desc_'+rowCnt+'" size="40"></td>';
   cell[3] = '<td class="main" align="center"><input type="text" name="inv_'+rowCnt+'" id="inv_'+rowCnt+'" readonly="readonly" size="15">';
   cell[4] = '<td class="main" align="center"><input type="text" name="amt_'+rowCnt+'" id="amt_'+rowCnt+'" readonly="readonly" size="12" style="text-align:right"></td>';
   cell[5] = '<td class="main" align="center"><input type="text" name="dscnt_'+rowCnt+'" id="dscnt_'+rowCnt+'" size="11" maxlength="10" onchange="updateRowTotal('+rowCnt+')" style="text-align:right"></td>';
   cell[6] = '<td class="main" align="center"><input type="text" name="total_'+rowCnt+'" id="total_'+rowCnt+'" value="'+formatted_zero+'" size="11" maxlength="20" onchange="updateUnitPrice('+rowCnt+')" style="text-align:right"></td>';
   cell[7] = '<td class="main" align="center"><input type="checkbox" name="pay_'+rowCnt+'" id="pay_'+rowCnt+'" value="1" onclick="updatePayValues('+rowCnt+')"></td>';

   for (var i=0; i<cell.length; i++) {
		newCell = newRow.insertCell(-1);
		newCell.innerHTML = cell[i];
	}
	return rowCnt;
}

function updateRowTotal(rowCnt) {
	var discount_amount = cleanCurrency(document.getElementById('dscnt_'+rowCnt).value);
	document.getElementById('dscnt_'+rowCnt).value = formatCurrency(discount_amount);
	var pay_total = parseFloat(cleanCurrency(document.getElementById('amt_'+rowCnt).value)) - discount_amount;
	var total_l = new String(pay_total);
	document.getElementById('total_'+rowCnt).value = formatCurrency(total_l);
	document.getElementById('pay_'+rowCnt).checked = true;
	updateTotalPrices();
}

function updateUnitPrice(rowCnt) {
	var total_line = cleanCurrency(document.getElementById('total_'+rowCnt).value);
	document.getElementById('total_'+rowCnt).value = formatCurrency(total_line);
	document.getElementById('dscnt_'+rowCnt).value = '';
	document.getElementById('pay_'+rowCnt).checked = true;
	updateTotalPrices();
}

function updatePayValues(rowCnt) {
	if (document.getElementById('pay_'+rowCnt).checked) {
		var postDate = new Date(document.getElementById('post_date').value);
		var earlyDate = new Date(document.getElementById('early_'+rowCnt).value);
		var amount = cleanCurrency(document.getElementById('amt_'+rowCnt).value);
		var discountPercent = parseFloat(document.getElementById('prcnt_'+rowCnt).value);
		if (isNaN(discountPercent)) discountPercent = 0;
		var discountAmount = new String(discountPercent * amount);
		if (postDate > earlyDate) { // no discount if post date after early date
			discountPercent = 0;
			discountAmount = '0';
		}
		document.getElementById('dscnt_'+rowCnt).value = formatCurrency(discountAmount);
		var new_total = new String(amount - parseFloat(document.getElementById('dscnt_'+rowCnt).value));
		document.getElementById('total_'+rowCnt).value = formatCurrency(new_total);
	} else {
		document.getElementById('dscnt_'+rowCnt).value = '';
		document.getElementById('total_'+rowCnt).value = formatCurrency('0');
	}
	updateTotalPrices();
}

function updateTotalPrices() {
  var temp = '';
  var total = 0;
  for (var i=1; i<document.getElementById("item_table").rows.length; i++) {
	if (document.getElementById('total_'+i).value) {
		temp = cleanCurrency(document.getElementById('total_'+i).value);
		total += parseFloat(temp);
	}
  }
  var tot = new String(total);
  document.getElementById('total').value = formatCurrency(tot);
  if (journalID == 20) {
    var start_balance = cleanCurrency(document.getElementById('acct_balance').value);
    temp = new String(start_balance - tot);
    document.getElementById('end_balance').value = formatCurrency(temp);
  }
}

function activateFields() {
  if (payments_installed) {
    var index = document.getElementById('shipper_code').selectedIndex;
    for (var i=0; i<document.getElementById('shipper_code').options.length; i++) {
  	  document.getElementById('pm_'+i).style.visibility = 'hidden';
    }
    document.getElementById('pm_'+index).style.visibility = '';
  }
}
