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
//  Path: /modules/banking/pages/bulk_bills/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
ajaxRH["acctbal"] = "showNewBalance";

// Include translations here as well.
var journalID    = '<?php echo JOURNAL_ID; ?>';
var datePosted   = new ctlSpiffyCalendarBox("datePosted", "bulk_bills", "post_date", "btnDate2", "<?php echo gen_spiffycal_db_date_short($post_date); ?>", scBTNMODE_CALBTN);
datePosted.JStoRunOnSelect="loadNewBalance();";
var dateInvoice  = new ctlSpiffyCalendarBox("dateInvoice", "bulk_bills", "invoice_date", "btnDate2", "<?php echo gen_spiffycal_db_date_short($invoice_date); ?>", scBTNMODE_CALBTN);
var dateDiscount = new ctlSpiffyCalendarBox("dateDiscount", "bulk_bills", "discount_date", "btnDate2", "<?php echo gen_spiffycal_db_date_short($discount_date); ?>", scBTNMODE_CALBTN);

function init() {
  cssjsmenu('navbar');
  checkShipAll();

<?php 
  if ($post_success && $action == 'print') {
    echo '  var printWin = window.open("index.php?cat=reportwriter&module=popup_form&gn=' . POPUP_FORM_TYPE . '&cr0=' . TABLE_JOURNAL_MAIN . '.purchase_invoice_id:' . $check_range . '","forms","width=700px,height=550px,resizable=1,scrollbars=1,top=150px,left=200px");';
    echo '  printWin.focus();';
  }
?>
}

function check_form() {
  var error = 0;
  var error_message = "<?php echo JS_ERROR; ?>";

  if (error == 1) {
    alert(error_message);
    return false;
  }
  return true;
}

// Insert other page specific functions here.
function checkShipAll() {
  var amt_due;
  for (var i=1; i<document.getElementById("item_table").rows.length; i++) {
  	amt_due = parseFloat(document.getElementById('amt_'+i).value);
	if (document.getElementById('pay_'+i).disabled == false && amt_due > 0) {
	  document.getElementById('pay_'+i).checked = true;
	  updatePayValues(i);
	}
  }
}

function updateDiscTotal(rowCnt) {
	var discount_amount = cleanCurrency(document.getElementById('dscnt_'+rowCnt).value);
	document.getElementById('dscnt_'+rowCnt).value = formatCurrency(discount_amount);
	var pay_total = parseFloat(document.getElementById('amt_'+rowCnt).value) - discount_amount;
	var total_l = new String(pay_total);
	document.getElementById('total_'+rowCnt).value = formatCurrency(total_l);
	document.getElementById('pay_'+rowCnt).checked = true;
	updateTotalPrices();
}

function updateLineTotal(rowCnt) {
	var total_line = cleanCurrency(document.getElementById('total_'+rowCnt).value);
	document.getElementById('total_'+rowCnt).value = formatCurrency(total_line);
	document.getElementById('dscnt_'+rowCnt).value = formatCurrency('0');
	document.getElementById('pay_'+rowCnt).checked = true;
	updateTotalPrices();
}

function updatePayValues(rowCnt) {
	var postDate = document.getElementById('post_date').value;
	var discDate = document.getElementById('discdate_'+rowCnt).value;
	if (document.getElementById('pay_'+rowCnt).checked) {
		var amount = parseFloat(document.getElementById('amt_'+rowCnt).value);
		var discount = parseFloat(document.getElementById('origdisc_'+rowCnt).value);
		if (postDate > discDate) {
			discount = 0;
			document.getElementById('dscnt_'+rowCnt).value = formatCurrency('0');
		} else {
			document.getElementById('dscnt_'+rowCnt).value = formatCurrency(new String(discount));
		}
		var new_total = new String(amount - discount);
		document.getElementById('total_'+rowCnt).value = formatCurrency(new_total);
	} else {
		document.getElementById('dscnt_'+rowCnt).value = (postDate > discDate) ? formatCurrency('0') : document.getElementById('origdisc_'+rowCnt).value;
		document.getElementById('total_'+rowCnt).value = '';
	}
	updateTotalPrices();
}

function updateTotalPrices() {
  var temp = '';
  var total = 0;
  var start_balance = cleanCurrency(document.getElementById('acct_balance').value);
  for (var i=1; i<document.getElementById("item_table").rows.length; i++) {
	if (document.getElementById('total_'+i).value) {
		temp = cleanCurrency(document.getElementById('total_'+i).value);
		total += parseFloat(temp);
	}
  }
  var total_checks = new String(total);
  document.getElementById('total').value = formatCurrency(total_checks);
  temp = new String(start_balance - total_checks);
  document.getElementById('end_balance').value = formatCurrency(temp);
}

// AJAX balance request function pair
function loadNewBalance() { // request funtion
  var gl_acct   = document.getElementById('gl_acct_id').value;
  var post_date = document.getElementById('post_date').value;
  loadXMLReq('index.php?cat=banking&module=ajax&op=acct_balance&gl_acct_id='+gl_acct+'&post_date='+post_date);
}

function showNewBalance(resp) { // call back function
  //convert to an array
  data = parseXML(resp);
  var start_balance = data.value;
  var total_checks = cleanCurrency(document.getElementById('total').value);
  balance_remain = new String(start_balance - total_checks);
  sb = new String(start_balance);
  document.getElementById('acct_balance').value = formatCurrency(sb);
  document.getElementById('end_balance').value  = formatCurrency(balance_remain);
}

// -->
</script>
