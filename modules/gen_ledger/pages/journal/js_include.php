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
//  Path: /modules/gen_ledger/pages/journal/js_include.php
//

?>
<script type="text/javascript">
<!--
ajaxRH["loadRecord"] = "processEditJournal";

// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.
var image_path        = '<?php echo DIR_WS_ICONS; ?>';
var image_delete_text = '<?php echo TEXT_DELETE; ?>';
var image_delete_msg  = '<?php echo GL_DELETE_GL_ROW; ?>';
var text_acct_ID      = '<?php echo TEXT_GL_ACCOUNT; ?>';
var text_increased    = '<?php echo GL_ACCOUNT_INCREASED; ?>';
var text_decreased    = '<?php echo GL_ACCOUNT_DECREASED; ?>';
var journalID         = '<?php echo JOURNAL_ID; ?>';
var showGLNames       = '<?php echo SHOW_FULL_GL_NAMES; ?>';
var datePost = new ctlSpiffyCalendarBox("datePost", "journal", "post_date", "btnDate2", "<?php echo gen_spiffycal_db_date_short($post_date); ?>", scBTNMODE_CALBTN);

<?php echo $js_gl_array; ?>

function init() {
  cssjsmenu('navbar');
<?php if ($action == 'edit') echo '  EditJournal(' . $oID . ')'; ?>
}

function check_form() {
  var error = 0;
  var error_message = "<?php echo JS_ERROR; ?>";

  // check for balance of credits and debits
  var bal_total = cleanCurrency(document.getElementById('balance_total').value);
  if (bal_total != 0) {
  	error_message += "<?php echo GL_ERROR_OUT_OF_BALANCE; ?>";
  	error = 1;
  }

  // check for all accounts valid
  for (var i = 1; i <= ((document.getElementById("item_table").rows.length - 1) / 2); i++) {
	if (!updateDesc(i)) {
	  error_message += "<?php echo GL_ERROR_BAD_ACCOUNT; ?>";
	  error = 1;
	  break;
	}
  }

  // With edit of order and recur, ask if roll through future entries or only this entry
  var todo = document.getElementById('todo').value;
  if (document.getElementById('id').value != "" && document.getElementById('recur_id').value > 0) {
	switch (todo) {
	  case 'delete':
		message = '<?php echo GL_ERROR_RECUR_DEL_ROLL_REQD; ?>';
		break;
	  default:
	  case 'save':
		message = '<?php echo GL_ERROR_RECUR_ROLL_REQD; ?>';
	}
	if (confirm(message)) {
	  document.getElementById('recur_frequency').value = '1';
	} else {
	  document.getElementById('recur_frequency').value = '0';
	}		    
  }
  // Check for purchase_invoice_id exists with a recurring entry
  if (document.getElementById('purchase_invoice_id').value == "" && document.getElementById('recur_id').value > 0) {
	error_message += "<?php echo GL_ERROR_NO_REFERENCE; ?>";
	error = 1; // exit the script
  }

  if (error == 1) {
    alert(error_message);
    return false;
  }
  return true;
}

function GLList(elementID) {
  window.open("index.php?cat=gen_ledger&module=popup_gl_acct&page=1&form=journal&id="+elementID,"acct_list","width=550,height=550,resizable=1,scrollbars=1,top=150,left=200");
}

function OpenGLList() {
  window.open("index.php?cat=gen_ledger&module=popup_journal&page=1&form=journal","gl_open","width=700,height=550,resizable=1,scrollbars=1,top=150,left=200");
}

function OpenRecurList(currObj) {
	window.open("index.php?cat=orders&module=popup_recur&jID="+journalID,"recur","width=400px,height=300px,resizable=1,scrollbars=1,top=150,left=200");
}

function verifyCopy() {
  var id = document.getElementById('id').value;
  if (!id) {
    alert('<?php echo GL_JS_CANNOT_COPY; ?>');
	return;
  }
  if (confirm('<?php echo GL_JS_COPY_CONFIRM; ?>')) {
    // don't allow recurring entries for copy
    document.getElementById('recur_id').value        = '0';
    document.getElementById('recur_frequency').value = '0';
    submitToDo('copy');
  }
}

// Insert other page specific functions here.
function EditJournal(rID) {
  loadXMLReq('index.php?cat=gen_ledger&module=ajax&op=load_record&rID='+rID);
}

function processEditJournal(resp) {
  var DebitOrCredit;
  data = parseXML(resp);
  if (data.error) {
    alert(data.error);
	return;
  }
  document.getElementById('id').value                  = data.id;
  document.getElementById('purchase_invoice_id').value = data.purchase_invoice_id;
  document.getElementById('post_date').value           = formatDate(data.post_date);
  document.getElementById('recur_id').value            = data.recur_id;
  // delete the rows
  while (document.getElementById("item_table").rows.length > 1) document.getElementById("item_table").deleteRow(-1);
  // fill item rows
  for (iIndex=0, jIndex=1; iIndex<data.items.length; iIndex++, jIndex++) {
	var rowCnt = addGLRow();
	document.getElementById('id_'+jIndex).value     = data.items[iIndex].id;
	document.getElementById('desc_'+jIndex).value   = data.items[iIndex].description;
	document.getElementById('acct_'+jIndex).value   = data.items[iIndex].gl_account;
	document.getElementById('debit_'+jIndex).value  = data.items[iIndex].debit_amount;
	document.getElementById('credit_'+jIndex).value = data.items[iIndex].credit_amount;
	DebitOrCredit = (data.items[iIndex].debit_amount != 0) ? 'd' : 'c';
	formatRow(jIndex, DebitOrCredit);
  }
  updateBalance();
}

function glProperties(id, description, asset) {
  this.id          = id;
  this.description = description;
  this.asset       = asset;
}

function addGLRow() {
	var cell = new Array();
	var newRow = document.getElementById("item_table").insertRow(-1);
	var rowCnt = (newRow.rowIndex + 1) / 2;
	// NOTE: any change here also need to be made below for reload if action fails
	cell[0]  = '<td align="center">';
	cell[0] += buildIcon(image_path+'16x16/emblems/emblem-unreadable.png', image_delete_text, 'style="cursor:pointer" onclick="if (confirm(\''+image_delete_msg+'\')) removeGLRow('+rowCnt+');"') + '<\/td>';
	cell[1]  = '<td class="main" align="center" nowrap="nowrap">';
	cell[1] += '<select name="acct_'+rowCnt+'" id="acct_'+rowCnt+'" onchange="updateDesc('+rowCnt+')"><\/select>&nbsp;';
	// Hidden fields
	cell[1] += '<input type="hidden" name="id_'+rowCnt+'" id="id_'+rowCnt+'" value="" />';
	// End hidden fields
//	cell[1] += buildIcon(image_path+'16x16/status/folder-open.png', text_acct_ID, 'align="top" style="cursor:pointer" onclick="GLList(\'acct_'+rowCnt+'\')"') + '&nbsp;<\/td>';
	cell[2] = '<td class="main"><input type="text" name="desc_'+rowCnt+'" id="desc_'+rowCnt+'" size="64" maxlength="64"><\/td>';
	cell[3] = '<td class="main" align="right"><input type="text" name="debit_'+rowCnt+'" id="debit_'+rowCnt+'" style="text-align:right" size="13" maxlength="12" onchange="formatRow('+rowCnt+', \'d\')"><\/td>';
	cell[4] = '<td class="main" align="right"><input type="text" name="credit_'+rowCnt+'" id="credit_'+rowCnt+'" style="text-align:right" size="13" maxlength="12" onchange="formatRow('+rowCnt+', \'c\')"><\/td>';

	var newCell, cellCnt, newDiv, divIdName, newDiv, newOpt;
	for (var i=0; i<cell.length; i++) {
		newCell = newRow.insertCell(-1);
		newCell.innerHTML = cell[i];
	}
	// build the account dropdown
    newOpt = document.createElement("option");
    newOpt.text = '<?php echo GEN_HEADING_PLEASE_SELECT; ?>';
    document.getElementById('acct_'+rowCnt).options.add(newOpt);	
    document.getElementById('acct_'+rowCnt).options[0].value = '';
    for (i=0, j=1; i<js_gl_array.length; i++, j++) {
	  newOpt = document.createElement("option");
	  switch (showGLNames) {
	    default:
		case '0': // account only
          newOpt.text = js_gl_array[i].id;
		  break;
	    case '1': // description only
          newOpt.text = js_gl_array[i].description;
		  break;
	    case '2': // both
          newOpt.text = js_gl_array[i].id + ' : ' + js_gl_array[i].description;
		  break;
	  }
	  document.getElementById('acct_'+rowCnt).options.add(newOpt);
	  document.getElementById('acct_'+rowCnt).options[j].value = js_gl_array[i].id;
    }
	// insert information row
	newRow = document.getElementById("item_table").insertRow(-1);
	newRow.bgColor = inactive_bg_color;
	newCell = newRow.insertCell(-1);
	newCell.colSpan = 3;
	newCell.innerHTML = '<td colspan="3" class="main">&nbsp;<\/td>';
	newCell = newRow.insertCell(-1);
	newCell.colSpan = 2;
	newCell.innerHTML = '<td colspan="2" id="msg_'+rowCnt+'" class="main">&nbsp;<\/td>';
	return rowCnt;
}

function removeGLRow(delRowCnt) {
  var glIndex = (delRowCnt * 2) - 1;
  // remove row from display by reindexing and then deleting last row
  for (var i = delRowCnt; i < ((document.getElementById("item_table").rows.length - 1) / 2); i++) {
	// remaining cell values
	document.getElementById('acct_'+i).value   = document.getElementById('acct_'+(i+1)).value;
	document.getElementById('desc_'+i).value   = document.getElementById('desc_'+(i+1)).value;
	document.getElementById('debit_'+i).value  = document.getElementById('debit_'+(i+1)).value;
	document.getElementById('credit_'+i).value = document.getElementById('credit_'+(i+1)).value;
// Hidden fields
	document.getElementById('id_'+i).value = document.getElementById('id_'+(i+1)).value;
// End hidden fields
	// move information fields
	document.getElementById("item_table").rows[glIndex+1].cells[0].innerHTML = document.getElementById("item_table").rows[glIndex+3].cells[0].innerHTML;
	document.getElementById("item_table").rows[glIndex+1].cells[1].innerHTML = document.getElementById("item_table").rows[glIndex+3].cells[1].innerHTML;
	glIndex = glIndex + 2; // increment the row counter (two rows per entry)
  }
  document.getElementById("item_table").deleteRow(-1);
  document.getElementById("item_table").deleteRow(-1);
  updateBalance();
}

function showAction(rowID, DebitOrCredit) {
  var acct = document.getElementById('acct_'+rowID).value;
  var textValue = ' ';

  for (var i = 0; i < js_gl_array.length; i++) {
	if (js_gl_array[i].id == acct) {
	  if ((js_gl_array[i].asset == '1' && DebitOrCredit == 'd') || (js_gl_array[i].asset == '0' && DebitOrCredit == 'c')) {
	    textValue = text_increased;
	  } else {
	    textValue = text_decreased;
	  }
	  break;
	}
  }

  if (document.getElementById('debit_'+rowID).value == '' && document.getElementById('credit_'+rowID).value == '') {
    textValue = ' ';
  }

  if(document.all) { // IE browsers
    document.getElementById("item_table").rows[rowID*2].cells[1].innerText = textValue;  
  } else { //firefox
    document.getElementById("item_table").rows[rowID*2].cells[1].textContent = textValue;  
  }
}

function formatRow(rowID, DebitOrCredit) {
  var temp;

  showAction(rowID, DebitOrCredit);
  if (DebitOrCredit == 'd') {
  	if (document.getElementById('debit_'+rowID).value != '') {
		temp = cleanCurrency(document.getElementById('debit_'+rowID).value);
		document.getElementById('debit_'+rowID).value = formatCurrency(temp);
		document.getElementById('credit_'+rowID).value = '';
	}
  } else {
  	if (document.getElementById('credit_'+rowID).value != '') {
		temp = cleanCurrency(document.getElementById('credit_'+rowID).value);
		document.getElementById('credit_'+rowID).value = formatCurrency(temp);
		document.getElementById('debit_'+rowID).value = '';
	}
  }
  updateBalance();
}

function updateBalance() {
  var debit_total = 0;
  var credit_total = 0;
  var balance_total = 0;
  for (var i = 1; i < ((document.getElementById('item_table').rows.length + 1) / 2); i++) {
	temp = parseFloat(cleanCurrency(document.getElementById('debit_'+i).value));
  	if (!isNaN(temp)) debit_total += temp;
	temp = parseFloat(cleanCurrency(document.getElementById('credit_'+i).value));
  	if (!isNaN(temp)) credit_total += temp;
  }
  balance_total = debit_total - credit_total;
  var dt = new String(debit_total);
  document.getElementById('debit_total').value = formatCurrency(dt);
  var ct = new String(credit_total);
  document.getElementById('credit_total').value = formatCurrency(ct);
  var tot = new String(balance_total);
  document.getElementById('balance_total').value = formatCurrency(tot);
  if (document.getElementById('balance_total').value == formatted_zero) {
  	document.getElementById('balance_total').style.color = '';
  } else {
  	document.getElementById('balance_total').style.color = 'red';
  }
}

function updateDesc(rowID) {
  var acct = document.getElementById('acct_'+rowID).value;
  var DebitOrCredit = '';
  var textValue = '<?php echo GL_ERROR_JOURNAL_BAD_ACCT ?>';
  var error = true;
  document.getElementById('acct_'+rowID).style.color = 'red';

  if (document.getElementById('debit_'+rowID).value != '') {
  	DebitOrCredit = 'd';
  } else if (document.getElementById('credit_'+rowID).value != '') {
  	DebitOrCredit = 'c';
  }

  if (!acct) {
    textValue = '.';
	document.getElementById('acct_'+rowID).style.color = '';
	error = false;
  }

  for (var i=0; i<js_gl_array.length; i++) {
	if (js_gl_array[i].id == acct) {
	  textValue = js_gl_array[i].description;
	  document.getElementById('acct_'+rowID).style.color = '';
      error = false;
	  break;
	}
  }

  showAction(rowID, DebitOrCredit);
  if(document.all) { // IE browsers
    document.getElementById('item_table').rows[rowID*2].cells[0].innerText = textValue;
  } else { //firefox
    document.getElementById('item_table').rows[rowID*2].cells[0].textContent = textValue;
  }
  if (error) return false;
  return true;
}

// -->
</script>