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
//  Path: /modules/banking/pages/bills_deposit/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
ajaxRH["acctbal"]    = "showNewBalance";
ajaxRH["contactPmt"] = "showNewPayment";
ajaxRH["fillOrder"]  = "fillOrderData";

// Include translations here as well.
var pmt_array          = new Array(); // holds the encrypted payment information
var add_array          = new Array("<?php echo implode('", "', $js_arrays['fields']); ?>");
var default_array      = new Array("<?php echo implode('", "', $js_arrays['text']); ?>");
var journalID          = '<?php echo JOURNAL_ID; ?>';
var account_type       = '<?php echo $type; ?>';
var defaultGlAcct      = '<?php echo DEF_DEP_GL_ACCT; ?>';
var defaultDiscAcct    = '';
var defaultPostDate    = '<?php echo date(DATE_FORMAT, time()); ?>';
var store_country_code = '<?php echo STORE_COUNTRY; ?>';
var payments_installed = <?php echo count($payment_choices) ? 'true' : 'false'; ?>;
var dateOrdered        = new ctlSpiffyCalendarBox("dateOrdered", "bills_deposit", "post_date", "btnDate2", "<?php echo isset($order->post_date) ? gen_spiffycal_db_date_short($order->post_date) : date(DATE_FORMAT, time()); ?>", scBTNMODE_CALBTN);
var text_enter_new     = '<?php echo TEXT_ENTER_NEW; ?>';

// List the gl accounts for line item pull downs
<?php echo $js_gl_array; ?>

function init() {
	cssjsmenu('navbar');
	document.getElementById('bill_to_select').style.visibility = 'hidden';
	activateFields();
	// change color of the bill and ship address fields if they are the default values
	var add_id;
	for (var i=0; i<add_array.length; i++) {
		add_id = add_array[i];
		if (document.getElementById('bill_'+add_id).value == default_array[i]) {
			document.getElementById('bill_'+add_id).style.color = inactive_text_color;
		}
	}

	document.getElementById('search').focus();
<?php 
  if ($action == 'pmt') echo 'loadNewPayment();';
  echo 'updateDepositPrice();';
?>

<?php 
  if ($post_success && $action == 'print') {
	echo '  ClearForm();';
	echo '  var printWin = window.open("index.php?cat=reportwriter&module=popup_form&gn=' . POPUP_FORM_TYPE . '&mID=' . $order->id . '&cr0=' . TABLE_JOURNAL_MAIN . '.id:' . $order->id . '","forms","width=700px,height=550px,resizable=1,scrollbars=1,top=150px,left=200px");';
    echo '  printWin.focus();';
  }
?>
}

function check_form() {
  var error = 0;
  var error_message = "<?php echo JS_ERROR; ?>";

  var todo = document.getElementById('todo').value;

  if (journalID == '18' && (todo == 'save' || todo == 'print')) { // only check payment if saving
    var index = document.getElementById('shipper_code').selectedIndex;
    var payment_method = document.getElementById('shipper_code').options[index].value;
	<?php
	  foreach ($installed_modules as $value) { // fetch the javascript validation of payments module
		echo $$value->javascript_validation();
	  }
	?>
  }

  if (error == 1) {
    alert(error_message);
    return false;
  }
  return true;
}

// Insert other page specific functions here.
function billsAcctList() {
	window.open("index.php?cat=accounts&module=popup_accts&type="+account_type+"&form=bills_deposit&fill=bill&jID="+journalID+"&search_text="+document.getElementById('search').value,"accounts","width=850px,height=550px,resizable=1,scrollbars=1,top=150,left=100");
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
  if (data.contact) orderFillAddress(data.contact[0], data.billaddress, 'bill', fill_address);
}

function orderFillAddress(contact, address, type, set_default) {
  var newOpt, i;
  insertValue(type+'_acct_id', contact.id);
  var mainType = contact.type + 'm';
  bill_add = address;
  altType = contact.type + 'b';
  insertValue('search', contact.short_name);

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


// ******* AJAX balance request function pair *********/
function loadNewBalance(gl_acct) { // request funtion
  // if the table has no rows from a form clear, add them here
  if (document.getElementById("item_table").rows.length == 1) {
    var cell = Array();
    var newRow = document.getElementById("item_table").insertRow(-1);
    var newCell;
    rowCnt = newRow.rowIndex;
    cell[0]  = '<td class="main" align="center">';
    cell[0] += '<?php echo html_hidden_field('id_1',  $order->id_1); ?>';
    cell[0] += '<?php echo html_input_field('desc_1', $order->desc_1, 'size="64" maxlength="64"'); ?>';
    cell[0] += '</td>';
    cell[1]  = '<td class="main" align="center"><select name="acct_1" id="acct_1"></select></td>';
    cell[2]  = '<td class="main" align="center"><?php echo html_input_field('total_1', $currencies->format($order->total_1), 'size="11" maxlength="20" onchange="updateDepositPrice()" style="text-align:right"'); ?></td>';
    for (var i=0; i<cell.length; i++) {
      newCell = newRow.insertCell(-1);
	  newCell.innerHTML = cell[i];
	}
  }
  if (js_gl_array) buildDropDown('acct_1', js_gl_array, defaultGlAcct);
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
// ******* END - AJAX balance request function pair *********/

// ******* AJAX payment stored payment values request function pair *********/
function loadNewPayment() { // request funtion
  var contact_id = document.getElementById('bill_acct_id').value;
  if (!contact_id) return;
  loadXMLReq('index.php?cat=banking&module=ajax&op=stored_payments&contact_id='+contact_id);
}

function showNewPayment(resp) { // call back function
  data = parseXML(resp); //convert to an array
//alert('received pmt array back length = '+data.respTXT);
  // clear the dropdown
  while (document.getElementById('payment_id').options.length) {
	document.getElementById('payment_id').remove(0);
  }
  if (data.payments) {
    buildPaymentDropDown(data.payments); // the array is under payments tag
  } else {
    document.getElementById('payment_id').style.visibility = 'hidden';
  }
}

function buildPaymentDropDown(data) {
  // build the dropdown
  newOpt = document.createElement("option");
  newOpt.text = '<?php echo TEXT_ENTER_NEW; ?>';
  document.getElementById('payment_id').options.add(newOpt);	
  document.getElementById('payment_id').options[0].value = '';
  pmt_array[0] = new Object();
  pmt_array[0].field_0 = '';
  pmt_array[0].field_1 = '';
  pmt_array[0].field_2 = '';
  pmt_array[0].field_3 = '';
  pmt_array[0].field_4 = '';
  for (i=0, j=1; i<data.length; i++, j++) {
	newOpt = document.createElement("option");
	newOpt.text = data[i].name;
	if (data[i].hint) newOpt.text += ', ' + data[i].hint;
	document.getElementById('payment_id').options.add(newOpt);
	document.getElementById('payment_id').options[j].value = data[i].id;
	pmt_array[j] = new Object();
	if (data[i].field_0) pmt_array[j].field_0 = data[i].field_0;
	if (data[i].field_1) pmt_array[j].field_1 = data[i].field_1;
	if (data[i].field_2) pmt_array[j].field_2 = data[i].field_2;
	if (data[i].field_3) pmt_array[j].field_3 = data[i].field_3;
	if (data[i].field_4) pmt_array[j].field_4 = data[i].field_4;
  }
  if (data.length > 0) document.getElementById('payment_id').style.visibility = '';
}
// ******* END - AJAX payment stored payment values request function pair *********/

function fillPayment() {
  var index = document.getElementById('shipper_code').selectedIndex;
  var pmtMethod = document.getElementById('shipper_code').options[index].value;
  var pmtIndex = document.getElementById('payment_id').selectedIndex;
  if (document.getElementById(pmtMethod+'_field_0')) 
    document.getElementById(pmtMethod+'_field_0').value = pmt_array[pmtIndex].field_0;
  if (document.getElementById(pmtMethod+'_field_1')) 
    document.getElementById(pmtMethod+'_field_1').value = pmt_array[pmtIndex].field_1;
  if (document.getElementById(pmtMethod+'_field_2')) 
    document.getElementById(pmtMethod+'_field_2').value = pmt_array[pmtIndex].field_2;
  if (document.getElementById(pmtMethod+'_field_3')) 
    document.getElementById(pmtMethod+'_field_3').value = pmt_array[pmtIndex].field_3;
  if (document.getElementById(pmtMethod+'_field_4')) 
    document.getElementById(pmtMethod+'_field_4').value = pmt_array[pmtIndex].field_4;
}

function updateDepositPrice() {
  var temp  = cleanCurrency(document.getElementById('total_1').value);
  var total = parseFloat(temp);
  var tot = new String(total);
  document.getElementById('total').value   = formatCurrency(tot);
  document.getElementById('total_1').value = formatCurrency(tot);
  temp  = cleanCurrency(document.getElementById('acct_balance').value);
  var bank_bal = parseFloat(temp);
  tot = new String(bank_bal - total);
  document.getElementById('end_balance').value = formatCurrency(tot);
}

function buildFreightDropdown() {}

// -->
</script>
<script type="text/javascript" src="modules/banking/javascript/banking.js"></script>
