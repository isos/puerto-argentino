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
//  Path: /modules/orders/pages/popup_bar_code/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.
var skuLength     = <?php echo ORD_BAR_CODE_LENGTH; ?>;

// Set for standard UCC bar codes
var journal_id       = '<?php echo $jID; ?>';
var resClockID       = 0;
ajaxRH["upcDetails"] = "processUpcDetails";

function init() {
  document.getElementById('upc').focus();
  refreshOrderClock();
}

function check_form() {
  return true;
}

// Insert other page specific functions here.
function refreshOrderClock() {
  if (resClockID) {
    clearTimeout(resClockID);
    resClockID = 0;
  }
  setReturnItem(false); // do something
  // reset the clock
  resClockID = setTimeout("refreshOrderClock()", 250);
}

// AJAX balance request function pair
function setReturnItem(override) { // request funtion
  var upc = document.getElementById('upc').value;
  if (!override && upc.length < skuLength) return; // not enough characters
  var qty = document.getElementById('qty').value;
  var id = window.opener.document.getElementById('bill_acct_id').value;
  document.getElementById('upc').value = '';
  document.getElementById('qty').value = '1';
  if (!qty) {
    alert('The quantity cannot be less than or equal to zero!');
    return;
  }
  loadXMLReq('index.php?cat=inventory&module=ajax&op=inv_details&fID=upcDetails&cID='+id+'&qty='+qty+'&upc='+upc);
  document.getElementById('upc').focus();
}

function processUpcDetails(resp) { // call back function
  var rowID = 1;
  var i     = 1;
  //convert to an array
  data = parseXML(resp);
  if (data.error) {
    alert(data.error);
	return;
  }
  // retrieve the current empty row
  while (true) {
    if (!window.opener.document.getElementById('sku_'+i)) {
      window.opener.addInvRow();
	  break;
	}
    if (window.opener.document.getElementById('sku_'+i).value == '<?php echo TEXT_SEARCH; ?>') break;
	i++;
	if (i>1000) break; // failsafe
  }
  rowID = i;
  // fill in the data
  var exchange_rate = window.opener.document.getElementById('currencies_value').value;
  switch (journal_id) {
	case  '3':
    case  '4':
	case  '9':
	case '10':
      window.opener.document.getElementById('qty_'+rowID).value  = data.qty;
	  break;
	default:
      window.opener.document.getElementById('pstd_'+rowID).value = data.qty;
  }
  window.opener.document.getElementById('sku_'+rowID).value       = data.sku;
  window.opener.document.getElementById('sku_'+rowID).style.color = '';
  window.opener.document.getElementById('desc_'+rowID).value      = data.description_sales;
  window.opener.document.getElementById('full_'+rowID).value      = formatCurrency(data.full_price  * exchange_rate);
  window.opener.document.getElementById('price_'+rowID).value     = formatCurrency(data.sales_price * exchange_rate);
  window.opener.document.getElementById('acct_'+rowID).value      = data.account_sales_income;
  window.opener.document.getElementById('weight_'+rowID).value    = data.item_weight;
  window.opener.document.getElementById('stock_'+rowID).value     = data.quantity_on_hand;
  window.opener.document.getElementById('tax_'+rowID).value       = data.item_taxable;
  window.opener.document.getElementById('lead_'+rowID).value      = data.lead_time;
  window.opener.document.getElementById('inactive_'+rowID).value  = data.inactive;
  window.opener.updateRowTotal(rowID, true);
  window.opener.addInvRow();
}

// -->
</script>