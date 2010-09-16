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
//  Path: /modules/inventory/pages/main/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass some php variables
ajaxRH["bomCost"]     = "showBOMCost";
ajaxRH["whereUsed"]   = "showWhereUsed";
ajaxRH["skuDetails"]  = "processSkuDetails";

var image_path        = '<?php echo DIR_WS_ICONS; ?>';
var image_delete_text = '<?php echo TEXT_DELETE; ?>';
var image_delete_msg  = '<?php echo INV_MSG_DELETE_INV_ITEM; ?>';
var text_sku          = '<?php echo TEXT_SKU; ?>';
var delete_icon_HTML  = '<?php echo substr(html_icon("emblems/emblem-unreadable.png", TEXT_DELETE, "small", "onclick=\"if (confirm(\'" . INV_MSG_DELETE_INV_ITEM . "\')) removeBOMRow("), 0, -2); ?>';

// required function called with every page load
function init() {
	cssjsmenu('navbar');

  <?php if ($action <> 'new' && $action <> 'edit') { // set focus for main window
	echo "  document.getElementById('search_text').focus();";
	echo "  document.getElementById('search_text').select();";
  } ?>
  <?php if ($action == 'edit' && $cInfo->inventory_type == 'ms') { // set focus for main window
	echo '  masterStockTitle(0);';
	echo '  masterStockTitle(1);';
	echo '  masterStockBuildSkus();';
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

function check_sku() {
  var error = 0;
  var error_message = "<?php echo JS_ERROR; ?>";

  var sku = document.getElementById('sku').value;
  if (sku == "") {
	error_message = error_message + "<?php echo JS_SKU_BLANK; ?>";
	error = 1;
  }

  if (error == 1) {
	alert(error_message);
	return false;
  } else {
	return true;
  }
}

function setSkuLength() {
	var sku_val = document.getElementById('sku').value;
	if (document.getElementById('inventory_type').value == 'ms') {
		sku_val.substr(0, <?php echo (MAX_INVENTORY_SKU_LENGTH - 5); ?>);
		document.getElementById('sku').value = sku_val.substr(0, <?php echo (MAX_INVENTORY_SKU_LENGTH - 5); ?>);
		document.getElementById('sku').maxLength = <?php echo (MAX_INVENTORY_SKU_LENGTH - 5); ?>;
	} else {
		document.getElementById('sku').maxLength = <?php echo MAX_INVENTORY_SKU_LENGTH; ?>;
	}
}

function deleteItem(id) {
	location.href = 'index.php?cat=inventory&module=main&action=delete&cID='+id;
}

function copyItem(id) {
	var skuID = prompt('<?php echo INV_MSG_COPY_INTRO; ?>', '');
	if (skuID) {
		location.href = 'index.php?cat=inventory&module=main&action=copy&cID='+id+'&sku='+skuID;
	} else {
		return false;
	}
}

function renameItem(id) {
	var skuID = prompt('<?php echo INV_MSG_RENAME_INTRO; ?>', '');
	if (skuID) {
		location.href = 'index.php?cat=inventory&module=main&action=rename&cID='+id+'&sku='+skuID;
	} else {
		return false;
	}
}

function ImgPopup(url) {
  window.open('index.php?cat=inventory&module=popup_image&img='+url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=400,height=400,screenX=150,screenY=150,top=150,left=150')
}

function priceMgr(id, cost, price) {
  window.open('index.php?cat=inventory&module=popup_price_mgr&iID='+id+'&cost='+cost+'&price='+price,"price_mgr","width=800,height=400,resizable=1,scrollbars=1,top=150,left=200");
}

function InventoryList(rowCnt) {
  window.open("index.php?cat=inventory&module=popup_inv&rowID="+rowCnt+"&search_text="+document.getElementById('sku_'+rowCnt).value,"inventory","width=700,height=550,resizable=1,scrollbars=1,top=150,left=200");
}

function loadSkuDetails(iID, rID) {
  loadXMLReq('index.php?cat=inventory&module=ajax&op=inv_details&fID=skuDetails&iID='+iID+'&rID='+rID);
}

function processSkuDetails(resp) { // call back function
  var text = '';
  data = parseXML(resp);
  if (data.error) {
    alert(data.error);
	return;
  }
  var rowID = data.rID;
  document.getElementById('sku_'+rowID).value       = data.sku;
  document.getElementById('sku_'+rowID).style.color = '';
  document.getElementById('desc_'+rowID).value      = data.description_short;
}

function addBOMRow() {
	var cell = Array(4);
	var newRow = document.getElementById("item_table").insertRow(-1);
	var newCell;
	rowCnt = newRow.rowIndex;
	// NOTE: any change here also need to be made below for reload if action fails
	cell[0] = '<td align="center">';
	cell[0] += buildIcon(image_path+'16x16/emblems/emblem-unreadable.png', image_delete_text, 'style="cursor:pointer" onclick="if (confirm(\''+image_delete_msg+'\')) removeBOMRow('+rowCnt+');"') + '<\/td>';
	cell[1] = '<td class="main" align="center">';
	// Hidden fields
	cell[1] += '<input type="hidden" name="id_'+rowCnt+'" id="id_'+rowCnt+'" value="">';
	// End hidden fields
	cell[1] += '<input type="text" name="assy_sku[]" id="sku_'+rowCnt+'" value="" size="<?php echo (MAX_INVENTORY_SKU_LENGTH + 1); ?>" maxlength="<?php echo MAX_INVENTORY_SKU_LENGTH; ?>">&nbsp;';
	cell[1] += buildIcon(image_path+'16x16/actions/system-search.png', text_sku, 'align="top" style="cursor:pointer" onclick="InventoryList('+rowCnt+')"') + '&nbsp;<\/td>';
	cell[2] = '<td class="main"><input type="text" name="assy_desc[]" id="desc_'+rowCnt+'" value="" size="64" maxlength="64"><\/td>';
	cell[3] = '<td class="main"><input type="text" name="assy_qty[]" id="qty_'+rowCnt+'" value="0" size="6" maxlength="5"><\/td>';

	for (var i=0; i<cell.length; i++) {
		newCell = newRow.insertCell(-1);
		newCell.innerHTML = cell[i];
	}
	return rowCnt;
}

function removeBOMRow(delRowCnt) {
  var acctIndex;
  // remove row from display by reindexing and then deleting last row
  for (var i = delRowCnt; i < (document.getElementById("item_table").rows.length - 1); i++) {
	// move the delete icon from the previous row
	if (document.getElementById("item_table").rows[i+1].cells[0].innerHTML == '&nbsp;') {
		document.getElementById("item_table").rows[i].cells[0].innerHTML = '&nbsp;';
	} else {
		document.getElementById("item_table").rows[i].cells[0].innerHTML = delete_icon_HTML + i + ');">';
	}
	document.inventory.elements['qty_'+i].value = document.inventory.elements['qty_'+(i+1)].value;
	document.inventory.elements['sku_'+i].value = document.inventory.elements['sku_'+(i+1)].value;
	document.inventory.elements['desc_'+i].value = document.inventory.elements['desc_'+(i+1)].value;
// Hidden fields
	document.inventory.elements['id_'+i].value = document.inventory.elements['id_'+(i+1)].value;
// End hidden fields
  }
  document.getElementById("item_table").deleteRow(-1);
}

function masterStockTitle(id) {
  if(document.all) { // IE browsers
    document.getElementById('sku_list').rows[1].cells[id+1].innerText = document.getElementById('attr_name_'+id).value;
  } else { //firefox
    document.getElementById('sku_list').rows[1].cells[id+1].textContent = document.getElementById('attr_name_'+id).value;
  }
}

function masterStockBuildList(action, id) {
  switch (action) {
    case 'add':
	  if (document.getElementById('attr_id_'+id).value == '' || document.getElementById('attr_id_'+id).value == '') {
	    alert('<?php echo JS_MS_INVALID_ENTRY; ?>');
		return;
	  }
	  var newOpt = document.createElement("option");
	  newOpt.text = document.getElementById('attr_id_'+id).value + ' : ' + document.getElementById('attr_desc_'+id).value;
	  newOpt.value = document.getElementById('attr_id_'+id).value + ':' + document.getElementById('attr_desc_'+id).value;
	  document.getElementById('attr_index_'+id).options.add(newOpt);
	  document.getElementById('attr_id_'+id).value = '';
	  document.getElementById('attr_desc_'+id).value = '';
	  break;

	case 'delete':
	  if (confirm('<?php echo INV_MSG_DELETE_INV_ITEM; ?>')) {
        var elementIndex = document.getElementById('attr_index_'+id).selectedIndex;
	    document.getElementById('attr_index_'+id).remove(elementIndex);
	  } else {
	    return;
	  }
	  break;

	default:
  }
  masterStockBuildSkus();
}

function masterStockBuildSkus() {
  var newRow, newCell, newValue0, newValue1, newValue2, attrib0, attrib1;
  var ms_attr_0 = '';
  var ms_attr_1 = '';
  while (document.getElementById('sku_list').rows.length > 2) {
	document.getElementById('sku_list').deleteRow(2);
  }
  var sku = document.getElementById('sku').value;
  newValue0 = '';
  newValue1 = '';
  newValue2 = '';
  if (document.getElementById('attr_index_0').length) {
    for (i=0; i<document.getElementById('attr_index_0').length; i++) {
	  attrib0 = document.getElementById('attr_index_0').options[i].value;
	  ms_attr_0 += attrib0 + ',';
	  attrib0 = attrib0.split(':');
  	  newValue0 = sku + '-' + attrib0[0];
	  newValue1 = attrib0[1];
      if (document.getElementById('attr_index_1').length) {
        for (j=0; j<document.getElementById('attr_index_1').length; j++) {
	      attrib1 = document.getElementById('attr_index_1').options[j].value
	      attrib1 = attrib1.split(':');
  	      newValue0 = sku + '-' + attrib0[0] + attrib1[0];
	      newValue2 = attrib1[1];
          insertTableRow(newValue0, newValue1, newValue2);
        }
	  } else {
        insertTableRow(newValue0, newValue1, newValue2);
	  }
    }
  } else { // blank row
    insertTableRow(newValue0, newValue1, newValue2);
  }

  for (j=0; j<document.getElementById('attr_index_1').length; j++) {
    attrib1 = document.getElementById('attr_index_1').options[j].value;
	ms_attr_1 += attrib1 + ',';
  }

  document.getElementById('ms_attr_0').value = ms_attr_0;
  document.getElementById('ms_attr_1').value = ms_attr_1;
}

function insertTableRow(newValue0, newValue1, newValue2) {
  newRow = document.getElementById('sku_list').insertRow(-1);
  if(document.all) { // IE browsers
    newCell = newRow.insertCell(-1);
    newCell.innerText = newValue0;
    newCell = newRow.insertCell(-1);
    newCell.innerText = newValue1;
    newCell = newRow.insertCell(-1);
    newCell.innerText = newValue2;
  } else { //firefox
    newCell = newRow.insertCell(-1);
    newCell.textContent = newValue0;
    newCell = newRow.insertCell(-1);
    newCell.textContent = newValue1;
    newCell = newRow.insertCell(-1);
    newCell.textContent = newValue2
  }
}

// ******* BOF - AJAX BOM Cost function pair *********/
function ajaxAssyCost() {
  var id = document.getElementById('rowSeq').value;
  if (id) loadXMLReq('index.php?cat=inventory&module=ajax&op=inv_details&fID=bomCost&iID='+id);
}

function showBOMCost(resp) {
  data = parseXML(resp);
  if (data.error) {
    alert(data.error);
  } else if (data.assy_cost) {
    alert('<?php echo JS_INV_TEXT_ASSY_COST; ?>'+formatPrecise(data.assy_cost));
  }
}
// ******* EOF - AJAX BOM Cost function pair *********/

// ******* BOF - AJAX BOM Where Used pair *********/
function ajaxWhereUsed() {
  var id = document.getElementById('rowSeq').value;
  if (id) loadXMLReq('index.php?cat=inventory&module=ajax&op=inv_details&fID=whereUsed&iID='+id);
}

function showWhereUsed(resp) {
  var text = '';
  data = parseXML(resp);
  if (data.error) {
    alert(data.error);
  } else if (data.sku_usage) {
    for (var i=0; i<data.sku_usage.length; i++) {
	  text += data.sku_usage[i].text_line + "\n";
	}
	alert(text);
  }
}
// ******* EOF - AJAX BOM Where Used pair *********/

// -->
</script>