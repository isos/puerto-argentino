<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2009 PhreeSoft, LLC                               |
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
//  Path: /modules/rma/pages/popup_assets/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.
// var jsVariable = '<?php echo CONSTANT; ?>';

function init() {
  document.getElementById('search_text').focus();
  document.getElementById('search_text').select();
}

function check_form() {
  return true;
}
// Insert javscript file references here.


// Insert other page specific functions here.
function setReturnItem(pointer, rowID, formName, sku, desc, price, acct, weight, stock, taxable, lead_time, cogs_acct, inactive) {
	switch (formName) {
		case 'inv_assy': // inventory assemblies [/modules/inventory/assemblies.php]
			window.opener.document.getElementById('sku_'+rowID).value = sku;
			window.opener.document.getElementById('desc_'+rowID).value = desc;
			window.opener.document.getElementById('stock_'+rowID).value = stock;
			// delete the current rows, if any
			while (window.opener.document.getElementById("item_table").rows.length > 1) { window.opener.removeListRow(1); }
			// add the new data
			for (var i=0; i<assy_list[pointer].length; i++) {
				window.opener.addListRow();
				window.opener.document.getElementById('assy_sku_'+(i+1)).value = assy_list[pointer][i].sku;
				window.opener.document.getElementById('assy_desc_'+(i+1)).value = assy_list[pointer][i].description;
				window.opener.document.getElementById('qty_reqd_'+(i+1)).value = assy_list[pointer][i].qty;
				window.opener.document.getElementById('assy_qty_'+(i+1)).value = assy_list[pointer][i].qty;
				window.opener.document.getElementById('stk_'+(i+1)).value = assy_list[pointer][i].quantity_on_hand;
			}
			window.opener.updateBalance();
			break;
		case 'inv_adj': // inventory adjustments [/modules/inventory/adjustments.php]
			window.opener.document.getElementById('price_'+rowID).value = formatCurrency(price);
			window.opener.document.getElementById('stock_'+rowID).value = stock;
			window.opener.document.getElementById('acct_'+rowID).value = cogs_acct;
			window.opener.document.getElementById('sku_'+rowID).value = sku;
			window.opener.document.getElementById('desc_'+rowID).value = desc;
			break;
		case 'inventory': // inventory (type assembly) [/modules/inventory/inventory.php]
			window.opener.document.getElementById('sku_'+rowID).value = sku;
			window.opener.document.getElementById('desc_'+rowID).value = desc;
			break;
		default: // [/modules/orders/order.php]
			var exchange_rate = window.opener.document.getElementById('currencies_value').value;
			window.opener.document.getElementById('sku_'+rowID).value = sku;
			window.opener.document.getElementById('desc_'+rowID).value = desc;
			window.opener.document.getElementById('price_'+rowID).value = price * exchange_rate;
			window.opener.document.getElementById('acct_'+rowID).value = acct;
			window.opener.document.getElementById('weight_'+rowID).value = weight;
			window.opener.document.getElementById('stock_'+rowID).value = stock;
			window.opener.document.getElementById('tax_'+rowID).value = taxable;
			window.opener.document.getElementById('lead_'+rowID).value = lead_time;
			window.opener.document.getElementById('inactive_'+rowID).value = inactive;

			window.opener.updateRowTotal(rowID);
			window.opener.document.getElementById('freight').focus();
	}
	self.close();
}

function assyRecord(sku, description, qty, quantity_on_hand) {
	this.sku = sku;
	this.description = description;
	this.qty = qty;
	this.quantity_on_hand = quantity_on_hand;
}

// -->
</script>