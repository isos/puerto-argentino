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
//  Path: /modules/inventory/pages/transfer/js_include.php
//

?>
<script type="text/javascript">
<!--
ajaxRH["skuDetails"]   = "processSkuDetails";

// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.
var dateReference = new ctlSpiffyCalendarBox("dateReference", "inv_xfer", "post_date", "btnDate1", "<?php echo gen_spiffycal_db_date_short($post_date); ?>", scBTNMODE_CALBTN);

function init() {
  cssjsmenu('navbar');
  document.getElementById('sku_1').focus();
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
function InventoryList() {
  var bID = document.getElementById('source_store_id').value;
  var sku = document.getElementById('sku_1').value;
  window.open("index.php?cat=inventory&module=popup_inv&page=1&type=v&storeID="+bID+"&f1=cog&search_text="+sku,"inventory","width=700,height=550,resizable=1,scrollbars=1,top=150,left=200");
}

function loadSkuDetails(iID) {
  var bID = document.getElementById('source_store_id').value;
  loadXMLReq('index.php?cat=inventory&module=ajax&op=inv_details&fID=skuDetails&iID='+iID+'&bID='+bID);
}

function processSkuDetails(resp) { // call back function
  var text = '';
  data = parseXML(resp);
  if (data.error) {
    alert(data.error);
	return;
  }
  document.getElementById('inv_acct').value    = data.account_inventory_wage;
  document.getElementById('inv_type').value    = data.inventory_type;
  document.getElementById('stock_1').value     = data.branch_qty_in_stock;
  document.getElementById('acct_1').value      = data.account_cost_of_sales;
  document.getElementById('sku_1').value       = data.sku;
  document.getElementById('sku_1').style.color = '';
  document.getElementById('desc_1').value      = data.description_short;
  if (data.inventory_type == 'sr' || data.inventory_type == 'sa') {
    document.getElementById('serial_row').style.display = '';
  }
}

function updateBalance() {
  var stock = parseFloat(document.getElementById('stock_1').value);
  var adj = parseFloat(document.getElementById('adj_qty').value);
  document.getElementById('balance').value = stock - adj;
}

// -->
</script>