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
//  Path: /modules/orders/javascript/orders.js
//
// AJAX stuff first
ajaxRH["fillGuess"]    = "processGuess";
ajaxRH["custDefaults"] = "processCustomerDefaults";
ajaxRH["skuPrice"]     = "processSkuPrice";
ajaxRH["skuDetails"]   = "processSkuDetails";
ajaxRH["skuValid"]     = "processSkuProp";
ajaxRH["fillOrder"]    = "fillOrderData";

var bill_add = new Array(0);
var ship_add = new Array(0);

var current_row = "" ; //cada vez que se pone el foco sobre una fila, marco aqui cual es la fila actual

function ClearMainForm() {
	clearAddress('bill');
	clearAddress('ship');
    document.getElementById('search').value             = text_search;
	document.getElementById('purchase_invoice_id').value= '';
	document.getElementById('id').value                 = '';
	document.getElementById('recur_id').value           = '0';
	document.getElementById('recur_frequency').value    = '0';
    document.getElementById('terms').value              = '0';
    document.getElementById('terms_text').value         = text_terms;
    document.getElementById('item_count').value         = '0';
    document.getElementById('weight').value             = '0';
    document.getElementById('printed').value            = '0';
	document.getElementById('so_po_ref_id').value       = '0';
}

function ClearForm() {
       ClearMainForm();
	document.getElementById('purch_order_id').value     = '';
	document.getElementById('store_id').value           = '';
	document.getElementById('rep_id').value             = '';
	document.getElementById('post_date').value          = defaultPostDate;
	document.getElementById('terminal_date').value      = defaultTerminalDate;
	document.getElementById('gl_acct_id').value         = default_GL_acct;
	document.getElementById('disc_gl_acct_id').value    = default_disc_acct;
	document.getElementById('disc_percent').value       = formatted_zero;
	document.getElementById('discount').value           = formatted_zero;
	document.getElementById('ship_gl_acct_id').value    = default_freight_acct;
	document.getElementById('ship_carrier').value       = '';
	document.getElementById('ship_service').value       = '';
	document.getElementById('freight').value            = formatted_zero;
	document.getElementById('display_currency').value   = defaultCurrency;
	document.getElementById('currencies_code').value    = defaultCurrency;
	document.getElementById('currencies_value').value   = '1';
	// handle checkboxes
	document.getElementById('waiting').checked          = false;
	document.getElementById('drop_ship').checked        = false;
	document.getElementById('closed').checked           = false;
	document.getElementById('bill_add_update').checked  = false;
	document.getElementById('ship_add_update').checked  = false;

	document.getElementById('ship_to_search').innerHTML = '&nbsp;'; // turn off ship to id search
	document.getElementById('purchase_invoice_id').readOnly = false;


	document.getElementById('sales_tax').value          = formatted_zero;
	document.getElementById('total').value              = formatted_zero;

// remove all item rows and add a new blank one
	var size = (single_line_list == '1') ? 1 : 2;
	while (document.getElementById('item_table').rows.length > size) removeInvRow(size);
	addInvRow();
}

function clearAddress(type) {
  for (var i=0; i<add_array.length; i++) {
	var add_id = add_array[i];
	document.getElementById(type+'_acct_id').value      = '';
	document.getElementById(type+'_address_id').value   = '';
	document.getElementById(type+'_country_code').value = store_country_code;
	if (type=='bill') {
	  if (add_id != 'country_code') document.getElementById(type+'_'+add_id).style.color = inactive_text_color;
	  document.getElementById(type+'_'+add_id).value = default_array[i];
	}
	if (type=='ship') {
	  switch (journalID) {
		case '3':
		case '4':
		case '6':
		case '7':
		case '20':
		case '21':
		  document.getElementById(type+'_'+add_id).style.color = '';
		  document.getElementById(type+'_'+add_id).value = company_array[i];
		  break;
		case '9':
		case '10':
		case '12':
		case '13':
		case '18':
		case '19':
			if (add_id != 'country_code') document.getElementById(type+'_'+add_id).style.color = inactive_text_color;
			document.getElementById(type+'_'+add_id).value = default_array[i];
			break;
		default:
	  }
  	  document.getElementById(type+'_to_select').style.visibility = 'hidden';
  	  if (document.getElementById(type+'_to_select')) {
    	while (document.getElementById(type+'_to_select').options.length) {
	  	  document.getElementById(type+'_to_select').remove(0);
    	}
  	  }
	}
  }
}

function ajaxOrderData(cID, oID, jID, open_order, ship_only) {
  var open_so_po = (open_order) ? '1' : '0';
  var only_ship  = (ship_only)  ? '1' : '0';
  loadXMLReq('index.php?cat=orders&module=ajax&op=load_order&cID='+cID+'&oID='+oID+'&jID='+jID+'&so_po='+open_so_po+'&ship_only='+only_ship);
}

function fillOrderData(resp) { // edit response form fill
  data = parseXML(resp);
  if (data.debug) alert(data.debug);
  if (data.error) {
	alert(data.error);
	return;
  }
  var fill_address = (data.order) ? false : true;
  if (data.contact) {
    orderFillAddress(data.contact[0], data.billaddress, 'bill', fill_address);
  }
  if (data.shipcontact && !data.billaddress) {
    orderFillAddress(data.shipcontact[0], data.shipaddress, 'ship', true);
  } else if (data.shipcontact && data.billaddress) {
	orderFillAddress(data.shipcontact[0], data.shipaddress, 'ship', false);
  } else if (data.shipaddress){
	orderFillAddress(data.contact[0], data.shipaddress, 'ship', false);
  }
  if (data.order) fillOrder(data.order[0], data.items);
}

function orderFillAddress(contact, address, type, set_default) {
  var newOpt, i;
  insertValue(type+'_acct_id', contact.id);
  while (document.getElementById(type+'_to_select').options.length) document.getElementById(type+'_to_select').remove(0);
  var mainType = contact.type + 'm';
  switch (type) {
	default:
    case 'bill': 
	  bill_add         = address;
	  altType          = contact.type + 'b';
      default_inv_acct = contact.gl_type_account;
	  insertValue('terms', contact.special_terms);
	  insertValue('terms_text', contact.terms_text);
	  insertValue('search', contact.short_name);
  	  insertValue('acct_1', default_inv_acct);
  	  insertValue('rep_id', contact.dept_rep_id);
  	  insertValue('ship_gl_acct_id', contact.ship_gl_acct_id);
	  if (show_status == '1') {
 	    window.open("index.php?cat=orders&module=popup_status&form=orders&id="+contact.id,"contact_status","width=500px,height=300px,resizable=0,scrollbars=1,top=150,left=200");
	  }
	  break;
	case 'ship':
	  ship_add = address;
	  altType  = contact.type + 's';
	  insertValue('ship_to_search', contact.short_name);
	  break;
  }

  for (i=0; i<address.length; i++) {
    newOpt = document.createElement("option");
	newOpt.text = address[i].primary_name + ', ' + address[i].city_town + ', ' + address[i].postal_code;
	document.getElementById(type+'_to_select').options.add(newOpt);
	document.getElementById(type+'_to_select').options[i].value = i;
    if (set_default && address[i].type == mainType) { // also fill the fields
     insertValue(type+'_address_id', address[i].address_id);
     for (var dVal in address[i]) {
	    if (document.getElementById(type+'_'+dVal)) {
	      document.getElementById(type+'_'+dVal).value = address[i][dVal];
	      document.getElementById(type+'_'+dVal).style.color = '';
	    }
      }
    }
  }
  // add a option for creating a new address
  newOpt = document.createElement("option");
  newOpt.text = text_enter_new;
  document.getElementById(type+'_to_select').options.add(newOpt);	
  document.getElementById(type+'_to_select').options[i].value = 'new';
  document.getElementById(type+'_to_select').style.visibility = 'visible';
  document.getElementById(type+'_to_select').disabled = false;
}

function fillOrder(data, items) {
  for (var dVal in data) {
	if (document.getElementById(dVal)) {
	  document.getElementById(dVal).value = data[dVal];
	  document.getElementById(dVal).style.color = '';
	}
  }
  // fix some special cases, checkboxes, and active fields
  document.getElementById('display_currency').value = data.currencies_code;
  document.getElementById('closed').checked    = data.cb_closed    == '1' ? true : false;
  document.getElementById('waiting').checked   = data.cb_waiting   == '1' ? true : false;
  document.getElementById('drop_ship').checked = data.cb_drop_ship == '1' ? true : false;
// Uncomment to set Sales Invoice number = Sales Order number when invoicing a Sales Order
//  if (journalID == '12' && data.purch_order_num) document.getElementById('purchase_invoice_id').value = data.purch_order_num;
//
  if (data.id && journalID != '6' && journalID != '7') document.getElementById('purchase_invoice_id').readOnly = true;
  buildFreightDropdown();
  insertValue('ship_service', data.ship_service);
  if (data.cb_closed == '1') {
	switch (journalID) {
	  case  '6':
	  case  '7':
	  case '12':
	  case '13':
		if (document.all) { // IE browsers
		  document.getElementById('closed_text').innerText = closed_text;
		} else { //firefox
		  document.getElementById('closed_text').textContent = closed_text;
		}
		removeElement('tb_main_0', 'tb_icon_payment');
		break;
	  default:
	}
  }
  // disable the purchase_invoice_id field since it cannot change, except purchase/receive
  if (data.id && journalID != '6' && journalID != '7' && journalID != '21') {
	document.getElementById('purchase_invoice_id').readOnly = true;
  }
  // turn off some icons
  if (data.id && securityLevel < 3) {
	removeElement('tb_main_0', 'tb_icon_print');
	removeElement('tb_main_0', 'tb_icon_save');
	removeElement('tb_main_0', 'tb_icon_payment');
  }

  // fill inventory rows and add a new blank one
  var order_discount = 0;
  var jIndex = 1;
  for (iIndex=0; iIndex<items.length; iIndex++) {
    switch (items[iIndex].gl_type) {
	  case 'ttl':
	  case 'tax': // the total and tax will be recalculated when the form is loaded
	    break;
	  case 'dsc':
	    order_discount =                            items[iIndex].total;
		if (items[iIndex].gl_account) insertValue('disc_gl_acct_id', items[iIndex].gl_account);
		break;
	  case 'frt':
		insertValue('freight',                      items[iIndex].total);
		if (items[iIndex].gl_account) insertValue('ship_gl_acct_id', items[iIndex].gl_account);
		break;
	  case 'soo':
	  case 'sos':
	  case 'poo':
	  case 'por':
		insertValue('id_'  + jIndex,                items[iIndex].id);
		insertValue('so_po_item_ref_id_'  + jIndex, items[iIndex].so_po_item_ref_id);
		insertValue('qty_' + jIndex,                items[iIndex].qty);
		insertValue('pstd_' + jIndex,               items[iIndex].pstd);
		insertValue('sku_'  + jIndex,               items[iIndex].sku);
		insertValue('desc_'  + jIndex,              items[iIndex].description);
		insertValue('proj_'  + jIndex,              items[iIndex].proj_id);
		insertValue('acct_'  + jIndex,              items[iIndex].gl_account);
		insertValue('tax_'  + jIndex,               items[iIndex].taxable);
		insertValue('full_'  + jIndex,              items[iIndex].full_price);
		insertValue('weight_'  + jIndex,            items[iIndex].weight);
		insertValue('serial_'  + jIndex,            items[iIndex].serialize);
		insertValue('stock_'  + jIndex,             items[iIndex].stock);
		insertValue('inactive_'  + jIndex,          items[iIndex].inactive);
		insertValue('lead_' + jIndex,               items[iIndex].lead);
		insertValue('price_' + jIndex,              items[iIndex].unit_price);
		insertValue('total_' + jIndex,              items[iIndex].total);
	    if (items[iIndex].so_po_item_ref_id || ((journalID == '04' || journalID == '10') && items[iIndex].pstd)) {
	      // don't allow sku to change, hide the sku search icon
	      document.getElementById('sku_' + jIndex).readOnly = true;
	      document.getElementById('sku_open_' + jIndex).style.display = 'none';
	      // don't allow row to be removed, turn off the delete icon
	      rowOffset = (single_line_list == '1') ? jIndex : jIndex * 2;
	      document.getElementById("item_table").rows[rowOffset].cells[0].innerHTML = '&nbsp;';
	    }
		updateRowTotal(jIndex, false);
		addInvRow();
		jIndex++;
	  default: // do nothing
	}
  }
  insertValue('discount', order_discount);
  calculateDiscount();
}

function accountGuess(force) {
  if (force) {
	AccountList();
	return;
  } 
  if (post_error) return; // leave the data there, since form was reloaded with failed post data
  if (document.getElementById('id').value) return; // if there's an id, it's an edit, return
  var warn = true;
  var guess = document.getElementById('search').value;
  // test for data already in the form
  if (guess != text_search && guess != '') {
    if (document.getElementById('bill_acct_id').value ||
        document.getElementById('bill_primary_name').value != default_array[0]) {
          warn = confirm(warn_form_modified);
	}
	if (warn) {
	  loadXMLReq('index.php?cat=orders&module=ajax&op=load_searches&type='+account_type+'&guess='+guess+'&jID='+journalID);
    }
  }
}

function processGuess(resp) {
  data = parseXML(resp);
  if (data.error) {
    alert (data.error);
  } else if (data.result == 'success') {
    fillOrderData(resp);
  } else {
	AccountList();
  }
}

function AccountList(currObj) {
  var fill;
  switch (journalID) {
	case '3':
	case '4':
	case '6':
	case '7':
	case '20':
	case '21': var fill = 'bill'; break;
	case '9':
	case '10':
	case '12':
	case '13':
	case '18':
	case '19': var fill = 'both'; break;
	default:
  }
  window.open("index.php?cat=accounts&module=popup_accts&type="+account_type+"&form=orders&fill="+fill+"&jID="+journalID+"&search_text="+document.getElementById('search').value,"accounts","width=850px,height=550px,resizable=1,scrollbars=1,top=150,left=100");
}

function DropShipList(currObj) {
	window.open("index.php?cat=accounts&module=popup_accts&type=c&form=orders&fill=ship&jID="+journalID+"&search_text="+document.getElementById('ship_search').value,"accounts","width=850px,height=550px,resizable=1,scrollbars=1,top=150,left=100");
}

function OpenOrdrList(currObj) {
	window.open("index.php?cat=orders&module=popup_orders&form=orders&jID="+journalID,"search_po","width=700px,height=550px,resizable=1,scrollbars=1,top=150,left=200");
}

function OpenRecurList(currObj) {
	window.open("index.php?cat=orders&module=popup_recur&jID="+journalID,"recur","width=400px,height=300px,resizable=1,scrollbars=1,top=150,left=200");
}

function InventoryList(rowCnt) {
	var storeID = document.getElementById('store_id').value;
	var sku     = document.getElementById('sku_'+rowCnt).value;
	var cID     = document.getElementById('bill_acct_id').value;
	var preffered = '';
	if (cID != '')
		preffered = "&f2=1";
	window.open("index.php?cat=inventory&module=popup_inv&type="+account_type+"&rowID="+rowCnt+"&storeID="+storeID+"&cID="+cID+"&search_text="+sku+preffered,"inventory","width=700px,height=550px,resizable=1,scrollbars=1,top=150,left=200");
}

function GLList(elementID) {
	window.open("index.php?cat=gen_ledger&module=popup_gl_acct&form=orders&id="+elementID,"gen_ledger","width=550px,height=550px,resizable=1,scrollbars=1,top=150,left=200");
}

function PriceManagerList(elementID) {
	var sku = document.getElementById('sku_'+elementID).value;
	window.open("index.php?cat=inventory&module=popup_prices&rowId="+elementID+"&sku="+sku,"prices","width=550px,height=550px,resizable=1,scrollbars=1,top=150,left=200");
}

function TermsList() {
	var terms = document.getElementById('terms').value;
	window.open("index.php?cat=accounts&module=popup_terms&type="+account_type+"&form=orders&val="+terms,"terms","width=500px,height=300px,resizable=1,scrollbars=1,top=150,left=200");
}

function FreightList() {
	window.open("index.php?cat=services&module=popup_shipping&form=orders","shipping","width=900px,height=650px,resizable=1,scrollbars=1,top=150,left=200");
}

function convertQuote() {
  var id = document.getElementById('id').value;
  if (id != '') {
	window.open("index.php?cat=orders&module=popup_convert&oID="+id,"popup_convert","width=500px,height=300px,resizable=1,scrollbars=1,top=150,left=200");
  } else {
    alert(cannot_convert_quote);
  }
}

function convertSO() {
  var id = document.getElementById('id').value;
  if (id != '') {
	window.open("index.php?cat=orders&module=popup_convert_po&oID="+id,"popup_convert_po","width=500px,height=300px,resizable=1,scrollbars=1,top=150,left=200");
  } else {
    alert(cannot_convert_so);
  }
}

function serialList(rowID) {
   var choice    = document.getElementById(rowID).value;
   var newChoice = prompt(serial_num_prompt, choice);
   if (newChoice) document.getElementById(rowID).value = newChoice;
}

function openBarCode() {
  window.open("index.php?cat=orders&module=popup_bar_code&jID="+journalID,"bar_code","width=300px,height=150px,resizable=1,scrollbars=1,top=110,left=200");
}

function DropShipView(currObj) {
	var add_id;
	if (document.getElementById('drop_ship').checked) {
		for (var i=0; i<add_array.length; i++) {
			add_id = add_array[i];
			if (add_id != 'country_code') document.getElementById('ship_'+add_id).style.color = inactive_text_color;
			document.getElementById('ship_'+add_id).value = default_array[i];
		}
		document.getElementById('ship_country_code').value  = store_country_code;
		document.getElementById('ship_add_update').checked  = false;
		document.getElementById('ship_add_update').disabled = false;
		// turn on ship to id search
		document.getElementById('ship_to_search').innerHTML = ship_search_HTML;
	} else {
		while (document.getElementById('ship_to_select').options.length) {
			document.getElementById('ship_to_select').remove(0);
		}
		for (var i=0; i<add_array.length; i++) {
			add_id = add_array[i];
			switch (journalID) {
				case '3':
				case '4':
				case '6':
				case '7':
				case '20': // fill company address
				case '21':
					document.getElementById('ship_'+add_id).style.color = '';
					document.getElementById('ship_'+add_id).value       = company_array[i];
					break;
				case '9':
				case '10':
				case '12':
				case '13':
				case '18': // fill default address text
				case '19':
					if (add_id != 'country_code') document.getElementById('ship_'+add_id).style.color = inactive_text_color;
					document.getElementById('ship_'+add_id).value = default_array[i];
					break;
				default:
			}
		}
		document.getElementById('ship_country_code').value = store_country_code;
		document.getElementById('ship_add_update').checked = false;
		document.getElementById('ship_add_update').disabled = false;
		document.getElementById('ship_to_select').style.visibility = 'hidden';
		document.getElementById('ship_to_search').innerHTML = '&nbsp;'; // turn off ship to id search
	}
}

function fillAddress(type) {
	var index = document.getElementById(type+'_to_select').value;
	var address;
	if (type == "bill") address = bill_add[index];
	if (type == "ship") address = ship_add[index];
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

function copyAddress() {
	document.getElementById('ship_address_id').value = document.getElementById('bill_address_id').value;
	document.getElementById('ship_acct_id').value    = document.getElementById('bill_acct_id').value;
	var add_id;
	for (var i=0; i<add_array.length; i++) {
		add_id = add_array[i];
		if (document.getElementById('bill_'+add_id).value != default_array[i]) {
			document.getElementById('ship_'+add_id).style.color = '';
			document.getElementById('ship_'+add_id).value = document.getElementById('bill_'+add_id).value;
		} else {
			if (add_id != 'country_code') document.getElementById('ship_'+add_id).style.color = inactive_text_color;
			document.getElementById('ship_'+add_id).value = default_array[i];
		}
	}
	document.getElementById('ship_country_code').selectedIndex = document.getElementById('bill_country_code').selectedIndex;
}

/**** CAMBIOS INTRODUCIDOS POR GONZALO *********/
/*
 * Al generarse nuevas filas en las órdenes, no se linkean los eventos pre-existentes a los nuevos elementos. 
 * Con esta funcion, vuelvo a linkear los objetos del formulario con los eventos predefinidos
 * @param jQuery_object : indica a que objeto se le engancharán los eventos. Pueden ser los input, el document o lo que sea necesario . Simplifica la 
 * 					legibilidad  
 * */
function bindEvents(jQuery_object) {
	
	// abro la ventana de busqueda de productos
	jQuery_object.bind('keydown',search_item_shortcut, function() { InventoryList($(current_row).attr('id').substring(4));  } );

	// guardo la orden
	jQuery_object.bind('keydown',save_order_shortcut, function() { submitToDo('save'); } );
	
}

/* 
 * Inicia una busqueda de un producto a medida que se tipea el sku, a partir de una longitud minima
 * */

function backgroundSearch(sku_input) {
	sku_input.blur();	
}

/*
 * agrega el evento sobre los input de sku para que realice la busqueda en background
 * */
function addBackgroundSearch() {
	   /*
	    * agrega el evento sobre los input de sku para que realice la busqueda en background
	    * */
	   
	   	$(".sku_input_text").keydown(function(event) {
	   		if (event.keyCode == '13') {
	   			backgroundSearch($(this));
	   		}
	   	} );


}

/**** FIN CAMBIOS INTRODUCIDOS POR GONZALO *********/
function addInvRow() {
  var newCell;
  var cell;
  var newRow    = document.getElementById('item_table').insertRow(-1);
  if (single_line_list == '1') {
    var rowCnt  = newRow.rowIndex;
  } else {
    var newRow2 = document.getElementById('item_table').insertRow(-1);
    var rowCnt  = (newRow2.rowIndex - 1)/2;
  }
  

  // NOTE: any change here also need to be made to template form for reload if action fails
//  cell = '<td rowspan="'+(single_line_list?1:2)+'" align="center">';
  cell  = '<td align="center">';
  cell += buildIcon(image_path+'16x16/emblems/emblem-unreadable.png', image_delete_text, 'onclick="if (confirm(\''+image_delete_msg+'\')) removeInvRow('+rowCnt+');"') + '</td>';
  newCell = newRow.insertCell(-1);
  newCell.innerHTML = cell;
  if (single_line_list != '1') newCell.rowSpan = 2;
  cell = '<td nowrap="nowrap" class="main" align="center"><input type="text" name="qty_'+rowCnt+'" id="qty_'+rowCnt+'"'+(item_col_1_enable == '1' ? " " : " readonly=\"readonly\"")+' size="7" maxlength="6" onchange="updateRowTotal('+rowCnt+', true)" style="text-align:right" /></td>';
  newCell = newRow.insertCell(-1);
  newCell.innerHTML = cell;
  cell = '<td nowrap="nowrap" class="main" align="center"><input type="text" name="pstd_'+rowCnt+'" id="pstd_'+rowCnt+'"'+(item_col_2_enable == '1' ? " " : " readonly=\"readonly\"")+' size="7" maxlength="6" onchange="updateRowTotal('+rowCnt+', true)" style="text-align:right" />';
  switch (journalID) {
    case  '6':
	case  '7':
	case '12':
	case '13':
	case '18':
    case '19':
	case '20':
    case '21':
      cell += '&nbsp;' + buildIcon(image_path+'16x16/actions/tab-new.png', image_ser_num, 'onclick="serialList(\'serial_'+rowCnt+'\')"');
    default:
  }
  cell += '</td>';
  newCell = newRow.insertCell(-1);
  newCell.innerHTML = cell;
  
  cell  = '<td nowrap="nowrap" class="main" align="center"><input type="text" class="sku_input_text" name="sku_'+rowCnt+'" id="sku_'+rowCnt+'" size="'+(max_sku_len+1)+'" maxlength="'+max_sku_len+'" onfocus="current_row=this; clearField(\'sku_'+rowCnt+'\', \''+text_search+'\')" onblur="setField(\'sku_'+rowCnt+'\', \''+text_search+'\'); loadSkuDetails(0, '+rowCnt+')" />&nbsp;';
  cell += buildIcon(image_path+'16x16/actions/system-search.png', text_search, 'id="sku_open_'+rowCnt+'" align="top" style="cursor:pointer" onclick="InventoryList('+rowCnt+')"');
  cell += buildIcon(image_path+'16x16/actions/document-properties.png', text_properties, 'id="sku_prop_'+rowCnt+'" align="top" style="cursor:pointer" onclick="InventoryProp('+rowCnt+')"');
  cell += '</td>';
  newCell = newRow.insertCell(-1);
  newCell.innerHTML = cell;
  // for textarea uncomment below, (No control over input length, truncated to 255 by db) or ...
//  cell = '<td class="main"><textarea name="desc_'+rowCnt+'" id="desc_'+rowCnt+'" cols="'+((single_line_list=='1')?50:110)+'" rows="1" maxlength="255"></textarea></td>';
  // for standard controlled input, uncommet below
  cell = '<td class="main"><input name="desc_'+rowCnt+'" id="desc_'+rowCnt+'" size="'+((single_line_list=='1')?50:75)+'" maxlength="255" /></td>';
  newCell = newRow.insertCell(-1);
  newCell.innerHTML = cell;
  if (single_line_list != '1') newCell.colSpan = 3;
  // Project field
  if (single_line_list != '1') {
    cell = '<td class="main"><select name="proj_'+rowCnt+'" id="proj_'+rowCnt+'"></select></td>';
    newCell = newRow.insertCell(-1);
    newCell.innerHTML = cell;
    newCell.colSpan = 2;
  }
  // second row ( or continued first row if option selected)
  if (single_line_list != '1') {
    cell = '<td nowrap="nowrap" class="main"><select name="acct_'+rowCnt+'" id="acct_'+rowCnt+'"></select></td>';
    newCell = newRow2.insertCell(-1);
  } else {
	cell = '<td nowrap="nowrap" class="main">' + htmlComboBox('acct_'+rowCnt, values = '', default_inv_acct, 'size="10"', '220px', '') + '</td>';
    newCell = newRow.insertCell(-1);
  }
  newCell.innerHTML = cell;
  if (single_line_list != '1') newCell.colSpan = 3;
  if (single_line_list != '1') {
    cell  = '<td nowrap="nowrap" class="main" align="center"><input type="text" name="full_'+rowCnt+'" id="full_'+rowCnt+'"'+'readonly="readonly" size="11" maxlength="10" style="text-align:right" /></td>';
    newCell = newRow2.insertCell(-1);
    newCell.innerHTML = cell;
    cell  = '<td nowrap="nowrap" class="main" align="center"><input type="text" name="disc_'+rowCnt+'" id="disc_'+rowCnt+'"'+'readonly="readonly" size="11" maxlength="10" style="text-align:right" /></td>';
    newCell = newRow2.insertCell(-1);
    newCell.innerHTML = cell;
  }
  cell  = '<td nowrap="nowrap" class="main" align="center"><input type="text" name="price_'+rowCnt+'" id="price_'+rowCnt+'" size="10" maxlength="15" onchange="updateRowTotal('+rowCnt+', false)" style="text-align:right" />&nbsp;';
  cell += buildIcon(image_path+'16x16/status/mail-attachment.png', text_price_manager, 'align="top" style="cursor:pointer" onclick="PriceManagerList('+rowCnt+')"') + '</td>';
  if (single_line_list != '1') {
    newCell = newRow2.insertCell(-1);
  } else {
    newCell = newRow.insertCell(-1);
  }
  newCell.innerHTML = cell;
  cell  = '<td nowrap="nowrap" class="main"><select name="tax_'+rowCnt+'" id="tax_'+rowCnt+'" onchange="updateRowTotal('+rowCnt+', false)"></select></td>';
  if (single_line_list != '1') {
    newCell = newRow2.insertCell(-1);
  } else {
    newCell = newRow.insertCell(-1);
  }
  newCell.innerHTML = cell;
  cell  = '<td class="main" align="center">';
// Hidden fields
  cell += '<input type="hidden" name="id_'+rowCnt+'" id="id_'+rowCnt+'" value="" />';
  cell += '<input type="hidden" name="so_po_item_ref_id_'+rowCnt+'" id="so_po_item_ref_id_'+rowCnt+'" value="" />';
  cell += '<input type="hidden" name="weight_'+rowCnt+'" id="weight_'+rowCnt+'" value="0" />';
  cell += '<input type="hidden" name="stock_'+rowCnt+'" id="stock_'+rowCnt+'" value="NA" />';
  cell += '<input type="hidden" name="inactive_'+rowCnt+'" id="inactive_'+rowCnt+'" value="0" />';
  cell += '<input type="hidden" name="lead_'+rowCnt+'" id="lead_'+rowCnt+'" value="0" />';
  cell += '<input type="hidden" name="serial_'+rowCnt+'" id="serial_'+rowCnt+'" value="" />';
  if (single_line_list == '1') {
	cell += '<input type="hidden" name="proj_'+rowCnt+'"  id="proj_'+rowCnt+'"  value="" />';
    cell += '<input type="hidden" name="full_'+rowCnt+'" id="full_'+rowCnt+'" value="" />';
    cell += '<input type="hidden" name="disc_'+rowCnt+'" id="disc_'+rowCnt+'" value="" />';
  }
// End hidden fields
  cell += '<input type="text" name="total_'+rowCnt+'" id="total_'+rowCnt+'" value="'+formatted_zero+'" size="11" maxlength="20" onchange="updateUnitPrice('+rowCnt+')" style="text-align:right" /></td>';
  if (single_line_list != '1') {
    newCell = newRow2.insertCell(-1);
  } else {
    newCell = newRow.insertCell(-1);
  }
  newCell.innerHTML = cell;

  // populate the drop downs
  var selElement = (single_line_list == '1') ? ('comboselacct_'+rowCnt) : ('acct_'+rowCnt);
  if (js_gl_array) buildDropDown(selElement, js_gl_array, default_inv_acct);
  if (tax_rates)   buildDropDown('tax_'+rowCnt,  tax_rates, false);
  if (proj_list && single_line_list != '1') buildDropDown('proj_'+rowCnt, proj_list, false);

  setField('sku_'+rowCnt, text_search);
  setId = rowCnt; // set the upc auto-reader to the newest line added
  
  
  bindEvents($("input:text"));
  addBackgroundSearch();
  
  return rowCnt;
}



function removeInvRow(index) {
  var i, acctIndex, offset, newOffset;
  if (single_line_list == '1') {
	var numRows = document.getElementById('item_table').rows.length-1;
  } else {
	var numRows = (document.getElementById('item_table').rows.length-2)/2;
  }
  // remove row from display by reindexing and then deleting last row
  for (i=index; i<numRows; i++) {
	// move the delete icon from the previous row
	offset = (single_line_list == '1') ? i+1 : (i*2)+2;
	newOffset = (single_line_list == '1') ? i : i*2;
	if (document.getElementById('item_table').rows[offset].cells[0].innerHTML == '&nbsp;') {
	  document.getElementById('item_table').rows[newOffset].cells[0].innerHTML = '&nbsp;';
	} else {
	  document.getElementById('item_table').rows[newOffset].cells[0].innerHTML = delete_icon_HTML + i + ');">';
	}
	document.getElementById('qty_'+i).value               = document.getElementById('qty_'+(i+1)).value;
	document.getElementById('pstd_'+i).value              = document.getElementById('pstd_'+(i+1)).value;
	document.getElementById('sku_'+i).value               = document.getElementById('sku_'+(i+1)).value;
	document.getElementById('sku_'+i).readOnly            =(document.getElementById('sku_'+(i+1)).readOnly) ? true : false;
	document.getElementById('sku_open_'+i).style.display  =(document.getElementById('sku_'+(i+1)).readOnly) ? 'none' : '';
	document.getElementById('desc_'+i).value              = document.getElementById('desc_'+(i+1)).value;
	document.getElementById('proj_'+i).value              = document.getElementById('proj_'+(i+1)).value;
	document.getElementById('price_'+i).value             = document.getElementById('price_'+(i+1)).value;
	document.getElementById('acct_'+i).value              = document.getElementById('acct_'+(i+1)).value;
	document.getElementById('tax_'+i).selectedIndex       = document.getElementById('tax_'+(i+1)).selectedIndex;
// Hidden fields
	document.getElementById('id_'+i).value                = document.getElementById('id_'+(i+1)).value;
	document.getElementById('so_po_item_ref_id_'+i).value = document.getElementById('so_po_item_ref_id_'+(i+1)).value;
	document.getElementById('weight_'+i).value            = document.getElementById('weight_'+(i+1)).value;
	document.getElementById('stock_'+i).value             = document.getElementById('stock_'+(i+1)).value;
	document.getElementById('inactive_'+i).value          = document.getElementById('inactive_'+(i+1)).value;
	document.getElementById('lead_'+i).value              = document.getElementById('lead_'+(i+1)).value;
	document.getElementById('serial_'+i).value            = document.getElementById('serial_'+(i+1)).value;
	document.getElementById('full_'+i).value              = document.getElementById('full_'+(i+1)).value;
	document.getElementById('disc_'+i).value              = document.getElementById('disc_'+(i+1)).value;
// End hidden fields
	document.getElementById('total_'+i).value             = document.getElementById('total_'+(i+1)).value;
  }
  document.getElementById('item_table').deleteRow(-1);
  if (single_line_list != '1') document.getElementById('item_table').deleteRow(-1);
  updateTotalPrices();
} 

function updateRowTotal(rowCnt, useAjax) {
	var unit_price = cleanCurrency(document.getElementById('price_'+rowCnt).value);
	var full_price = cleanCurrency(document.getElementById('full_'+rowCnt).value);
	switch (journalID) {
		case  '3':
		case  '4':
		case  '9':
		case '10': 
		  var qty = parseFloat(document.getElementById('qty_'+rowCnt).value);
		  if (isNaN(qty)) qty = 0; // if blank or a non-numeric value is in the qty field, assume zero
		  break;
		case  '6':
		case  '7':
		case '12':
		case '13':
		case '18':
		case '19':
		case '21':
		case '20': 
		  var qty = parseFloat(document.getElementById('pstd_'+rowCnt).value);
		  if (isNaN(qty)) qty = 0; // if blank or a non-numeric value is in the pstd field, assume zero
		  break;
		default:
	}
	var total_line = qty * unit_price;
	var total_l = new String(total_line);
	document.getElementById('price_'+rowCnt).value = formatPrecise(unit_price);
	document.getElementById('total_'+rowCnt).value = formatCurrency(total_l);
	// calculate discount
	if (full_price > 0) {
	  var discount = (full_price - unit_price)/full_price;
	  document.getElementById('disc_'+rowCnt).value = new String(Math.round(1000*discount)/10) + ' %';
	}
	updateTotalPrices();
	// call the ajax price sheet update based on customer
	if (useAjax && qty != 0 && sku != '' && sku != text_search) {
	  switch (journalID) {
		case  '9': // only update prices for sales and if no SO was used
		case '10':
		case '12':
		case '19':
		  var sku          = document.getElementById('sku_'+rowCnt).value;
		  var bill_acct_id = document.getElementById('bill_acct_id').value;
		  so_exists        = document.getElementById('so_po_item_ref_id_'+rowCnt).value;
		  if (!so_exists && auto_load_sku) {
	        loadXMLReq('index.php?cat=inventory&module=ajax&op=inv_details&fID=skuPrice&cID='+bill_acct_id+'&sku='+sku+'&qty='+qty+'&rID='+rowCnt);
		  }
		  break;
		default: // no AJAX
	  }
	}
}

// ajax response to price sheet request
function processSkuPrice(resp) { // call back function
// convert to an array
  data = parseXML(resp);
  var rowCnt = data.rID;
  document.getElementById('price_'+rowCnt).value = formatPrecise(data.sales_price);
  updateRowTotal(rowCnt, false);
}

function updateUnitPrice(rowCnt) {
  var total_line = cleanCurrency(document.getElementById('total_'+rowCnt).value);
  document.getElementById('total_'+rowCnt).value = formatCurrency(total_line);
  switch (journalID) {
	case '3':
	case '4':
	case '9':
	case '10':
	  var qty = parseFloat(document.getElementById('qty_'+rowCnt).value);
	  if (isNaN(qty)) {
		qty = 1;
		document.getElementById('qty_'+rowCnt).value = qty;
	  }
	  break;
	case '6':
	case '7':
	case '12':
	case '13':
	case '18':
	case '19':
	case '20':
	case '21':
	  var qty = parseFloat(document.getElementById('pstd_'+rowCnt).value);
	  if (isNaN(qty)) {
		qty = 1;
		document.getElementById('pstd_'+rowCnt).value = qty;
	  }
	  break;
	default:
  }
  var unit_price = total_line / qty;
  var unit_p = new String(unit_price);
  document.getElementById('price_'+rowCnt).value = formatPrecise(unit_p);
  updateTotalPrices();
}

function updateTotalPrices() {
  var discount = parseFloat(cleanCurrency(document.getElementById('discount').value));
  if (isNaN(discount)) discount = 0;
  var discountPercent = parseFloat(cleanCurrency(document.getElementById('disc_percent').value));
  if (isNaN(discountPercent)) discountPercent = 0;
  var item_count       = 0;
  var shipment_weight  = 0;
  var subtotal         = 0;
  var taxable_subtotal = 0;
  var lineTotal        = '';
  if (single_line_list == '1') {
	var numRows = document.getElementById('item_table').rows.length;
  } else {
	var numRows = document.getElementById('item_table').rows.length/2;
  }
  for (var i=1; i<numRows; i++) {
	switch (journalID) {
	  case  '3':
	  case  '4':
	  case  '9':
	  case '10':
   	    item_count      += parseFloat(document.getElementById('qty_'+i).value);
  	    shipment_weight += document.getElementById('qty_'+i).value * document.getElementById('weight_'+i).value;
	    break;
	  case  '6':
	  case  '7':
	  case '12':
	  case '13':
	  case '18':
	  case '19':
	  case '20':
	  case '21':
   	    item_count      += parseFloat(document.getElementById('pstd_'+i).value);
  	    shipment_weight += document.getElementById('pstd_'+i).value * document.getElementById('weight_'+i).value;
	    break;
	  default:
	}
    lineTotal = parseFloat(cleanCurrency(document.getElementById('total_'+i).value));
  	if (document.getElementById('tax_'+i).value != '0') {
      tax_index = document.getElementById('tax_'+i).selectedIndex;
	  if (tax_index == -1) { // if the rate array index is not defined
		tax_index = 0;
		document.getElementById('tax_'+i).value = tax_index;
	  }
	  if (tax_before_discount == '0') { // tax after discount
        taxable_subtotal += lineTotal * (1-(discountPercent/100)) * (tax_rates[tax_index].rate / 100);
	  } else { 
        taxable_subtotal += lineTotal * (tax_rates[tax_index].rate / 100);
	  }
	}
	subtotal += lineTotal;
  }

  // recalculate discount
  discount = subtotal * (discountPercent/100);
  var strDiscount = new String(discount);
  document.getElementById('discount').value = formatCurrency(strDiscount);
  // freight
  var strFreight = cleanCurrency(document.getElementById('freight').value);
  var freight = parseFloat(strFreight);
  if (isNaN(freight)) freight = 0;
  strFreight = new String(freight);
  document.getElementById('freight').value = formatCurrency(strFreight);
  if (tax_freight != 0) for (keyVar in tax_rates) {
    if (tax_rates[keyVar].id == tax_freight) taxable_subtotal += parseFloat(freight) * tax_rates[keyVar].rate / 100;
  }

  var nst = new String(taxable_subtotal);
  document.getElementById('sales_tax').value = formatCurrency(nst);

  document.getElementById('item_count').value = item_count;
  document.getElementById('weight').value = shipment_weight;
  var st = new String(subtotal);
  document.getElementById('subtotal').value = formatCurrency(st);
  var new_total = subtotal - discount + freight + taxable_subtotal;
  var tot = new String(new_total);
  document.getElementById('total').value = formatCurrency(tot);
}

function calculateDiscountPercent() {
  var percent  = parseFloat(cleanCurrency(document.getElementById('disc_percent').value));
  var subTotal = parseFloat(cleanCurrency(document.getElementById('subtotal').value));
  var discount = new String((percent / 100) * subTotal);
  document.getElementById('discount').value = formatCurrency(discount);
  updateTotalPrices();
}

function calculateDiscount() {
  // determine the discount percent
  var discount = parseFloat(cleanCurrency(document.getElementById('discount').value));
  if (isNaN(discount)) discount = 0;
  var subTotal = parseFloat(cleanCurrency(document.getElementById('subtotal').value));
  if (subTotal != 0) {
    var percent = 100000 * (1 - ((subTotal - discount) / subTotal));
    document.getElementById('disc_percent').value = Math.round(percent) / 1000;
  } else {
  	document.getElementById('disc_percent').value = formatted_zero;
  }
  updateTotalPrices();
}

function checkShipAll() {
  var item_count;
  if (single_line_list == '1') {
	var numRows = document.getElementById('item_table').rows.length;
  } else {
	var numRows = document.getElementById('item_table').rows.length/2;
  }
  for (var i=1; i<numRows; i++) {
   	item_count = parseFloat(document.getElementById('qty_'+i).value);
  	if (item_count != 0 && !isNaN(item_count)) {
	  document.getElementById('pstd_'+i).value = item_count;
	}
	updateRowTotal(i, false);
  }
}

function activateFields() {
  if (payments_installed) {
    var index = document.getElementById('payment_method').selectedIndex;
    for (var i=0; i<document.getElementById('payment_method').options.length; i++) {
  	  document.getElementById('pm_'+i).style.visibility = 'hidden';
    }
    document.getElementById('pm_'+index).style.visibility = '';
  }
}

function updateDesc(rowID) {
 // this function not used - it sets the chart of accounts description if required by the form
}

function buildFreightDropdown() {
  // fetch the selection
  if (!freightCarriers) return;
  var selectedCarrier = document.getElementById('ship_carrier').value;
  for (var i=0; i<freightCarriers.length; i++) {
	if (freightCarriers[i] == selectedCarrier) break;
  }
  var selectedMethod = document.getElementById('ship_service').value;
  for (var j=0; j<freightLevels.length; j++) {
	if (freightLevels[j] == selectedMethod) break;
  }
  // erase the drop-down
  while (document.getElementById('ship_service').options.length) document.getElementById('ship_service').remove(0);
  // build the new one, first check to see if None was selected
  if (i == freightCarriers.length) return; // None was selected, leave drop-down empty
  var m = 0; // allows skip if method is not available
  for (var k=0; k<freightLevels.length; k++) {
	if (freightDetails[i][k] != '') {
	  var newOpt = document.createElement("option");
	  newOpt.text = freightDetails[i][k];
	  document.getElementById('ship_service').options.add(newOpt);
	  document.getElementById('ship_service').options[m].value = freightLevels[k];
	  m++;
	}
  }
  // set the default choice 
  document.getElementById('ship_service').value = selectedMethod;
}

function recalculateCurrencies() {
  var workingTotal, workingUnitValue, itemTotal, newTotal;
  var currentCurrency = document.getElementById('currencies_code').value;
  var currentValue = parseFloat(document.getElementById('currencies_value').value);
  var desiredCurrency = document.getElementById('display_currency').value;
  for (var i=0; i<js_currency_codes.length; i++) {
	if (js_currency_codes[i] == desiredCurrency) var newValue = js_currency_values[i];
  }
  // update the line item table
  if (single_line_list == '1') {
	var numRows = document.getElementById('item_table').rows.length;
  } else {
	var numRows = document.getElementById('item_table').rows.length/2;
  }
  for (var i=1; i<numRows; i++) {
	itemTotal = parseFloat(cleanCurrency(document.getElementById('total_'+i).value, currentCurrency));
	if (isNaN(itemTotal)) continue;
	workingTotal = itemTotal / currentValue;
    newTotal = workingTotal * newValue;
	switch (journalID) {
	  case '3':
	  case '4':
	  case '9':
	  case '10':
		workingUnitValue = newTotal / document.getElementById('qty_'+i).value;
		break;
	  case '6':
	  case '7':
	  case '12':
	  case '13':
	  case '18':
	  case '19':
	  case '20':
	  case '21':
		workingUnitValue = newTotal / document.getElementById('pstd_'+i).value;
		break;
	  default:
	}
	if (isNaN(workingUnitValue)) continue;
	document.getElementById('total_'+i).value = formatCurrency(new String(newTotal), desiredCurrency);
	document.getElementById('price_'+i).value = formatPrecise(new String(workingUnitValue), desiredCurrency);
  }
  // convert shipping
  var newFreight = parseFloat(document.getElementById('freight').value);
  newFreight = (newFreight / currentValue) * newValue;
  document.getElementById('freight').value = formatCurrency(new String(newFreight), desiredCurrency);

  updateTotalPrices();
  // prepare the page settings for post
  document.getElementById('currencies_code').value = desiredCurrency;
  document.getElementById('currencies_value').value = new String(newValue);
}

// AJAX auto load SKU pair
function loadSkuDetails(iID, rowCnt) {
  var qty, sku;
  if (!rowCnt) return;
  // if a sales order or purchase order exists, keep existing information.
  so_exists = document.getElementById('so_po_item_ref_id_'+rowCnt).value;
  if (so_exists != '') return;
  // check to see if there is a sku present
  if (!iID) {
	sku = document.getElementById('sku_'+rowCnt).value; // read the search field as the real value	  
  }
  if (sku == text_search) return;

  var cID = document.getElementById('bill_acct_id').value;
  var bID = document.getElementById('store_id').value;
  switch (journalID) {
	case  '3':
	case  '4':
	case  '9':
	case '10':
		qty = document.getElementById('qty_'+rowCnt).value;
		break;
	case  '6':
	case  '7':
	case '12':
	case '13':
	case '18':
	case '19':
	case '20':
	case '21':
		qty = document.getElementById('pstd_'+rowCnt).value;
		break;
	default:
  }
  loadXMLReq('index.php?cat=inventory&module=ajax&op=inv_details&fID=skuDetails&bID='+bID+'&cID='+cID+'&qty='+qty+'&iID='+iID+'&sku='+sku+'&rID='+rowCnt+'&jID='+journalID);
}

function processSkuDetails(resp) { // call back function
  var qty_pstd;
  var text = '';
  data = parseXML(resp);
  if (data.error) {
//    alert(data.error);
	return;
  }
  var rowCnt = data.rID;
  var exchange_rate = document.getElementById('currencies_value').value;
  document.getElementById('sku_'     +rowCnt).value       = data.sku;
  document.getElementById('sku_'     +rowCnt).style.color = '';
  document.getElementById('full_'    +rowCnt).value       = formatCurrency(data.full_price * exchange_rate);
  document.getElementById('weight_'  +rowCnt).value       = data.item_weight;
  document.getElementById('stock_'   +rowCnt).value       = data.branch_qty_in_stock; // stock at this branch
//document.getElementById('stock_'   +rowCnt).value       = data.quantity_on_hand; // to insert total stock available
  document.getElementById('lead_'    +rowCnt).value       = data.lead_time;
  document.getElementById('inactive_'+rowCnt).value       = data.inactive;
  switch (journalID) {
	case  '3':
	case  '4':
	  qty_pstd = 'qty_';
	  document.getElementById('qty_'   +rowCnt).value     = data.qty;
	  document.getElementById('acct_'  +rowCnt).value     = data.account_inventory_wage;
	  document.getElementById('price_' +rowCnt).value     = formatPrecise(data.item_cost * exchange_rate);
	  document.getElementById('tax_'   +rowCnt).value     = data.purch_taxable;
	  if (data.description_purchase) {
	    document.getElementById('desc_'  +rowCnt).value   = data.description_purchase;
	  } else {
	    document.getElementById('desc_'  +rowCnt).value   = data.description_short;
	  }
	  break;
	case  '6':
	case  '7':
    case '21':
	  qty_pstd = 'pstd_';
	  document.getElementById('pstd_'  +rowCnt).value     = data.qty;
	  document.getElementById('acct_'  +rowCnt).value     = data.account_inventory_wage;
	  document.getElementById('price_' +rowCnt).value     = formatPrecise(data.item_cost * exchange_rate);
	  document.getElementById('tax_'   +rowCnt).value     = data.purch_taxable;
	  if (data.description_purchase) {
	    document.getElementById('desc_'  +rowCnt).value   = data.description_purchase;
	  } else {
	    document.getElementById('desc_'  +rowCnt).value   = data.description_short;
	  }
	  break;
	case  '9':
	case '10':
	  qty_pstd = 'qty_';
	  document.getElementById('qty_'   +rowCnt).value     = data.qty;
	  document.getElementById('acct_'  +rowCnt).value     = data.account_sales_income;
	  document.getElementById('price_' +rowCnt).value     = formatPrecise(data.sales_price * exchange_rate);
	  document.getElementById('tax_'   +rowCnt).value     = data.item_taxable;
	  if (data.description_sales) {
	    document.getElementById('desc_'  +rowCnt).value   = data.description_sales;
	  } else {
	    document.getElementById('desc_'  +rowCnt).value   = data.description_short;
	  }
	  break;
	case '12':
	case '13':
	case '19':
	  qty_pstd = 'pstd_';
	  document.getElementById('pstd_'  +rowCnt).value     = data.qty;
	  document.getElementById('acct_'  +rowCnt).value     = data.account_sales_income;
	  document.getElementById('price_' +rowCnt).value     = formatPrecise(data.sales_price * exchange_rate);
	  document.getElementById('tax_'   +rowCnt).value     = data.item_taxable;
	  if (data.description_sales) {
	    document.getElementById('desc_'  +rowCnt).value   = data.description_sales;
	  } else {
	    document.getElementById('desc_'  +rowCnt).value   = data.description_short;
	  }
	  break;
	default:
  }
  updateRowTotal(rowCnt, false);
  if (data.stock_note) {
    for (var i=0; i<data.stock_note.length; i++) {
	  text += data.stock_note[i].text_line + "\n";
	}
	
	$(current_row).parent().parent().parent().css("background","#FF0000");
//	alert(text); //en vez de mostrar un mensaje de error diciendo que no hay STOCK, pongo la fila con borde rojo
  }
  if (single_line_list == '1') {
	rowCnt = document.getElementById('item_table').rows.length - 1;
  } else {
	rowCnt = parseInt((document.getElementById('item_table').rows.length / 2) - 1);
  }
  var qty = document.getElementById(qty_pstd+rowCnt).value;
  var sku = document.getElementById('sku_'+rowCnt).value;
  if (qty != '' && sku != '' && sku != text_search) rowCnt = addInvRow();
  document.getElementById('sku_'+rowCnt).focus();
}

function InventoryProp(elementID) {
  var sku = document.getElementById('sku_'+elementID).value;
  if (sku != text_search && sku != '') {
    loadXMLReq('index.php?cat=inventory&module=ajax&op=inv_details&fID=skuValid&strict=1&sku='+sku);
  }
}

function processSkuProp(resp) { // call back function
  data = parseXML(resp);
  if (data.error) {
    alert(data.error);
  } else if (data.id != 0) {
	window.open("index.php?cat=inventory&module=main&action=properties&cID="+data.id,"inventory","width=800px,height=600px,resizable=1,scrollbars=1,top=50,left=50");
  }
}

function ContactProp() {
  var bill_acct_id = document.getElementById('bill_acct_id').value;
  switch (journalID) {
	case  '3':
	case  '4':
	case  '9':
	case '10':
		var type = 'v';
		break;
	case  '6':
	case  '7':
	case '12':
	case '13':
	case '18':
	case '19':
	case '20':
	case '21':
		var type = 'c';
		break;
	default:
  }
  if (bill_acct_id == 0 || bill_acct_id == '') {
	alert(no_contact_id);
  } else {
    window.open("index.php?cat=accounts&module=main&type="+type+"&action=properties&cID="+bill_acct_id,"contacts","width=800px,height=700px,resizable=1,scrollbars=1,top=50,left=50");
  }
}
