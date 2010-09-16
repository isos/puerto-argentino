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
//  Path: /modules/reportwriter/pages/builder/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.
var paperWidth       = <?php echo $paperwidth; ?>;
var paperHeight      = <?php echo $paperheight; ?>;
var paperOrientation = '<?php echo $paperorientation; ?>';
var marginLeft       = <?php echo $marginleft; ?>;
var marginRight      = <?php echo $marginright; ?>;

function init() {
	if ('<?php echo ($FormParams['IncludePage']) ? 'open' : 'close' ?>' == 'close') {
		window.opener.location.reload();
		self.close();
	}
<?php if ($Type <> 'frm') echo ' if (document.getElementById("tableFieldSetup")) calculateWidth();'; ?>
}

function check_form() {
  return true;
}

// Insert other page specific functions here.
function submitCrit(formId) {
	var temp = '';
	document.getElementById('EntryType').value = formId;
	switch(formId) {
	  case 'grouplist':
		document.getElementById('SeqNum').value      = document.getElementById('gSeqNum').value;
		document.getElementById('FieldName').value   = document.getElementById('gFieldName').value;
		document.getElementById('DisplayDesc').value = document.getElementById('gDisplayDesc').value;
		temp += (document.getElementById('gParamsDef').checked) ? '1' : '0';
		temp += (document.getElementById('gParamsBrk').checked) ? '1' : '0';
        document.getElementById('Params').value      = temp;
	    break;
	  case 'sortlist':
		document.getElementById('SeqNum').value      = document.getElementById('sSeqNum').value;
		document.getElementById('FieldName').value   = document.getElementById('sFieldName').value;
		document.getElementById('DisplayDesc').value = document.getElementById('sDisplayDesc').value;
        document.getElementById('Params').value      = document.getElementById('sParamsDef').checked ? '1' : '0';
	    break;
	  case 'critlist':
		document.getElementById('SeqNum').value      = document.getElementById('cSeqNum').value;
		document.getElementById('FieldName').value   = document.getElementById('cFieldName').value;
		document.getElementById('DisplayDesc').value = document.getElementById('cDisplayDesc').value;
		document.getElementById('Params').value      = document.getElementById('cParamsVal').value;
	    break;
	}
	return true;
}

function critSeq(rowSeq, formId) {
    document.getElementById('rowSeq').value = rowSeq;
	document.getElementById('EntryType').value = formId;
	return true;
}

function calculateWidth() {	// total up the columns
	var seq, rowID, colShow, colBreak, colWidth, tmp;
	var totalFields = document.getElementById('tableFieldSetup').rows.length;
	totalFields = totalFields - 5; // adjust for headings and footer
	var totalWidth = marginLeft;
	var colCount = 1;
	var maxColWidth = 0;
	var rowColCnt = new Array(totalFields);
	var widths = new Array(totalFields);
	var rowWidth = new Array(totalFields);
	for (seq=0; seq<totalFields; seq++) {
		if(document.all) { // IE browsers
		  document.getElementById('total_'+seq).innerText = '';
		  widths[seq] = document.getElementById('width_'+seq).innerText;
		} else { //firefox
		  document.getElementById('total_'+seq).textContent = '';
		  widths[seq] = document.getElementById('width_'+seq).textContent;
		}
	}
	for (seq=0; seq<totalFields; seq++) {
		colShow  = document.getElementById('vis_'+(seq+1)).checked ? true : false;
		colBreak = document.getElementById('brk_'+(seq+1)).checked ? true : false;
		colWidth = parseFloat(widths[seq]);
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
	pageWidth = (paperOrientation == 'P') ? paperWidth : paperHeight;
	var pageProperties = '<?php echo RW_RPT_FLDLIST; ?>';
	pageProperties += ' ('+'<?php echo TEXT_ORIEN; ?>'+': '+'<?php echo  $PaperOrientation[$paperorientation]; ?>';
	pageProperties += ', '+'<?php echo TEXT_WIDTH; ?>'+': '+pageWidth;
	pageProperties += ', '+'<?php echo RW_RPT_PGMARGIN_L; ?>'+': '+marginLeft;
	pageProperties += ', '+'<?php echo RW_RPT_PGMARGIN_R; ?>'+': '+marginRight+')';
	if(document.all) { // IE browsers
	  document.getElementById('fieldListHeading').innerText = pageProperties;
	} else { //firefox
	  document.getElementById('fieldListHeading').textContent = pageProperties;
	}

	for (seq=0; seq<totalFields; seq++) {
	  colCount = rowColCnt[seq];
	  if (colCount != 0) {
	    colWidth = rowWidth[colCount];
		if(document.all) { // IE browsers
		  document.getElementById('total_'+seq).innerText = colWidth;
		} else { //firefox
		  document.getElementById('total_'+seq).textContent = colWidth;
		}
	  } else {
		if(document.all) { // IE browsers
		  document.getElementById('total_'+seq).innerText = ' ';
		} else { //firefox
		  document.getElementById('total_'+seq).textContent = ' ';
		}
	  }
	}
}

// -->
</script>