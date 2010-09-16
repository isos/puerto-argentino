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
//  Path: /modules/rma/pages/main/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass some php variables
var createDate = new ctlSpiffyCalendarBox("createDate", "rma", "creation_date","btnDate1", "<?php echo isset($cInfo->creation_date) ? gen_spiffycal_db_date_short($cInfo->creation_date) : ''; ?>", scBTNMODE_CALBTN);
var receiveDate = new ctlSpiffyCalendarBox("receiveDate", "rma", "receive_date", "btnDate1", "<?php echo isset($cInfo->receive_date) ? gen_spiffycal_db_date_short($cInfo->receive_date) : ''; ?>", scBTNMODE_CALBTN);
var closedDate = new ctlSpiffyCalendarBox("closedDate", "rma", "closed_date", "btnDate1", "<?php echo isset($cInfo->closed_date) ? gen_spiffycal_db_date_short($cInfo->closed_date) : ''; ?>", scBTNMODE_CALBTN);
var image_path = '<?php echo DIR_WS_ICONS; ?>';
var image_delete_text = '<?php echo TEXT_DELETE; ?>';
var image_delete_msg = '<?php echo RMA_ROW_DELETE_ALERT; ?>';
var delete_icon_HTML = '<?php echo substr(html_icon("emblems/emblem-unreadable.png", TEXT_DELETE, "small", "onclick=\"if (confirm(\'" . RMA_ROW_DELETE_ALERT . "\')) removeInvRow("), 0, - 1); ?>';

<?php 
  echo $js_disp_code . chr(10);
  echo $js_disp_value . chr(10);
?>

// required function called with every page load
function init() {
	cssjsmenu('navbar');

  <?php if ($action <> 'new' && $action <> 'edit') { // set focus for main window
	echo "  document.getElementById('search_text').focus();";
	echo "  document.getElementById('search_text').select();";
  } ?>
}

function check_form() {
  var error = 0;
  var error_message = "<?php echo JS_ERROR; ?>";

  if (error == 1) {
	alert(error_message);
	return false;
  } else {
	return true;
  }
}

function ItemList(rowCnt) {
//	var storeID = document.getElementById('store_id').value; // No field to load default to main
	var storeID = '0';
	window.open("index.php?cat=rma&module=popup_inv&rowID="+rowCnt+"&storeID="+storeID+"&search_text="+document.getElementById('sku_'+rowCnt).value,"inventory","width=700px,height=550px,resizable=1,scrollbars=1,top=150,left=200");
}

function deleteItem(id) {
	location.href = 'index.php?cat=rma&module=main&action=delete&cID='+id;
}

function addItemRow() {
  var cell = Array();
  var newRow = document.getElementById('item_table').insertRow(-1);
  var newCell;
  rowCnt = newRow.rowIndex;

  cell[0] = '<td align="center">';
  cell[0] += buildIcon(image_path+'16x16/emblems/emblem-unreadable.png', image_delete_text, 'onclick="if (confirm(\''+image_delete_msg+'\')) removeItemRow('+rowCnt+');"') + '</td>';
  cell[1] = '<td class="main" align="center"><input type="text" name="qty_'+rowCnt+'" id="qty_'+rowCnt+'"'+' size="7" maxlength="6" style="text-align:right"></td>';
  cell[2] = '<td nowrap class="main" align="center"><input type="text" name="sku_'+rowCnt+'" id="sku_'+rowCnt+'" value="'+text_search+'" size="12" maxlength="15" onfocus="clearField(\'sku_'+rowCnt+'\', \''+text_search+'\')" onBlur="setField(\'sku_'+rowCnt+'\', \''+text_search+'\')">&nbsp;';
  cell[2] += buildIcon(image_path+'16x16/status/folder-open.png', text_search, 'id="sku_open_'+rowCnt+'" align="absmiddle" style="cursor:pointer" onclick="ItemList('+rowCnt+')"') + '</td>';
// Hidden fields
  cell[2] += '<input type="hidden" name="id_'+rowCnt+'" id="id_'+rowCnt+'" value="">';
// End hidden fields
  cell[2] += '</td>';
  cell[3] = '<td class="main"><input type="text" name="desc_'+rowCnt+'" id="desc_'+rowCnt+'" size="64" maxlength="64"></td>';
  cell[4] = '<td class="main"><select name="actn_'+rowCnt+'" id="actn_'+rowCnt+'"></select></td>';

  for (var i=0; i<cell.length; i++) {
    newCell = newRow.insertCell(-1);
	newCell.innerHTML = cell[i];
  }
  // fill in the select list
  for (var i=0; i<js_disp_code.length; i++) {
	newOpt = document.createElement("option");
	newOpt.text = js_disp_value[i];
	document.getElementById('actn_'+rowCnt).options.add(newOpt);
	document.getElementById('actn_'+rowCnt).options[i].value = js_disp_code[i];
  }
  // change sku searh field to incative text color
  document.getElementById('sku_'+rowCnt).style.color = inactive_text_color;
  return rowCnt;
}

function removeItemRow(delRowCnt) {
  var acctIndex;
  // remove row from display by reindexing and then deleting last row
  for (var i = delRowCnt; i < (document.getElementById('item_table').rows.length - 1); i++) {
	document.getElementById('item_table').rows[i].cells[0].innerHTML = delete_icon_HTML + i + ');">';
	document.getElementById('qty_'+i).value = document.getElementById('qty_'+(i+1)).value;
	document.getElementById('sku_'+i).value = document.getElementById('sku_'+(i+1)).value;
	document.getElementById('desc_'+i).value = document.getElementById('desc_'+(i+1)).value;
	document.getElementById('actn_'+i).value = document.getElementById('actn_'+(i+1)).value;
// Hidden fields
	document.getElementById('id_'+i).value = document.getElementById('id_'+(i+1)).value;
// End hidden fields
  }
  document.getElementById('item_table').deleteRow(-1);
} 

// -->
</script>