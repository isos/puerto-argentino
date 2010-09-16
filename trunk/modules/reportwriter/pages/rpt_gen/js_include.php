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
//  Path: /modules/reportwriter/pages/rpt_gen/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.
var dateFrom = new ctlSpiffyCalendarBox("dateFrom", "reportFilter", "DefDateFrom", "btnDate1", "<?php echo $DateArray[1]; ?>", scBTNMODE_CALBTN);
var dateTo = new ctlSpiffyCalendarBox("dateTo", "reportFilter", "DefDateTo", "btnDate1", "<?php echo $DateArray[2]; ?>", scBTNMODE_CALBTN);
var theTable, theTableBody;
var textLandscape = '<?php echo TEXT_LANDSCAPE; ?>';
var textPortrait = '<?php echo TEXT_PORTRAIT; ?>';

function init() {
  theTable = (document.all) ? document.all.fieldTable : document.getElementById("fieldTable");
  theTableBody = theTable.tBodies[0];
//  hideEmail();
  calculateWidth()
}

function check_form() {
  return true;
}

// Insert other page specific functions here.
function hideEmail() {
  for (var i=0; i<document.reportFilter.delivery_method.length; i++) {
    if (document.reportFilter.delivery_method[i].checked) {
      break;
    }
  }
  var deliveryValue = document.reportFilter.delivery_method[i].value;
  if (deliveryValue == 'S') {
    document.getElementById('rpt_email').style.display = 'block';
  } else {
    document.getElementById('rpt_email').style.display = 'none';
  }
}

<?php echo BuildjsArrays($Prefs['FieldListings']); ?>

function appendRow(form) {
insertTableRow(form, -1);
}
function addRow(form) {
insertTableRow(form, form.insertIndex.value);
}

function exchange(rowID, direction) {
	var tmp, oldSeq, newSeq;
	for (var seq=0; seq<fieldIdx.length; seq++) {
		if (fieldIdx[seq] == rowID) {
			oldSeq = seq + 2;
			if (direction == 'up' && seq > 0) {
				exchangeID = fieldIdx[seq-1];
				fieldIdx[seq-1] = rowID;
				fieldIdx[seq] = exchangeID;
				newSeq = oldSeq - 1;
			} else if (direction == 'down' && seq < fieldIdx.length-1) {
				exchangeID = fieldIdx[seq+1];
				fieldIdx[seq+1] = rowID;
				fieldIdx[seq] = exchangeID;
				newSeq = oldSeq + 1;
			} else {
			  return;
			}
			tmp = document.getElementById('seq_'+exchangeID).value;
			document.getElementById('seq_'+exchangeID).value = document.getElementById('seq_'+rowID).value;
			document.getElementById('seq_'+rowID).value = tmp;
			break;
		}
	}

	var trs = theTableBody.getElementsByTagName("tr");
	if (oldSeq == newSeq + 1) {
		theTableBody.insertBefore(trs[oldSeq], trs[newSeq]);
	} else if (newSeq == oldSeq + 1) {
		theTableBody.insertBefore(trs[newSeq], trs[oldSeq]);
	}
	calculateWidth();
}

function calculateWidth() {	// total up the columns
	var rowID, colShow, colBreak, colWidth, tmp;
	var totalWidth = parseFloat(document.getElementById('marginleft').value);
	var colCount = 1;
	var maxColWidth = 0;
	var rowColCnt = new Array(fieldIdx.length);
	var rowWidth = new Array(fieldIdx.length);
	for (var seq=0; seq<fieldIdx.length; seq++) {
		if(document.all) { // IE browsers
		  document.getElementById('col_'+seq).innerText = '';
		  document.getElementById('tot_'+seq).innerText = '';
		} else { //firefox
		  document.getElementById('col_'+seq).textContent = '';
		  document.getElementById('tot_'+seq).textContent = '';
		}
	}
	for (var seq=0; seq<fieldIdx.length; seq++) {
		rowID = fieldIdx[seq];
		colShow  = document.getElementById('show_'+rowID).checked ? true : false;
		colBreak = document.getElementById('break_'+rowID).checked ? true : false;
		colWidth = parseFloat(document.getElementById('width_'+rowID).value);
		if (colShow) {
			if (colWidth > maxColWidth) {
			  totalWidth += colWidth - maxColWidth;
			  maxColWidth = colWidth;
			  rowWidth[colCount] = totalWidth;
			}
		    rowColCnt[seq] = colCount;
			if (colBreak) {
				colCount++;
				maxColWidth = 0;
			}
		} else {
		  rowColCnt[seq] = 0;
		}
	}

	// set the page information
	for (var i = 0; i < document.reportFilter.paperorientation.length; i++) {
		if (document.reportFilter.paperorientation[i].checked) break;
	}
	var orientation = document.reportFilter.paperorientation[i].value;
	orienText = (orientation == 'P' ? textPortrait : textLandscape);
	var index = document.getElementById('papersize').selectedIndex;
	var paperValue = document.getElementById('papersize').options[index].value;
	var marginValues = paperValue.split(':');
	pageWidth = (orientation == 'P') ? marginValues[1] : marginValues[2];
	if(document.all) { // IE browsers
	  document.getElementById('pageOrientation').innerText = orienText;
	  document.getElementById('pageWidthData').innerText = pageWidth;
	  document.getElementById('lmData').innerText = document.getElementById('marginleft').value;
	  document.getElementById('rmData').innerText = document.getElementById('marginright').value;
	} else { //firefox
	  document.getElementById('pageOrientation').textContent = orienText;
	  document.getElementById('pageWidthData').textContent = pageWidth;
	  document.getElementById('lmData').textContent = document.getElementById('marginleft').value;
	  document.getElementById('rmData').textContent = document.getElementById('marginright').value;
	}

	for (var seq=0; seq<fieldIdx.length; seq++) {
	  rowID = fieldIdx[seq];
	  colCount = rowColCnt[seq];
	  if (colCount != 0) {
	    colWidth = rowWidth[colCount];
		if(document.all) { // IE browsers
		  document.getElementById('col_'+rowID).innerText = colCount;
		  document.getElementById('tot_'+rowID).innerText = colWidth;
		} else { //firefox
		  document.getElementById('col_'+rowID).textContent = colCount;
		  document.getElementById('tot_'+rowID).textContent = colWidth;
		}
	  }
	}
}
// -->
</script>




