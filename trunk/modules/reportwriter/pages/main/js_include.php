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
//  Path: /modules/reportwriter/pages/main/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.
var journal_ID = '<?php echo JOURNAL_ID; ?>';

function init() {
  cssjsmenu('navbar');
}

function check_form() {
  return true;
}

// Insert other page specific functions here.
function ReportPopup(action) { // find what report radio button was pushed and call the report_builder popup
  var rpt_id = '';
  var rID = '';
  if ((action != 'new') && (action != 'import')) {
    for (var i = 0; i < document.reports.elements['id'].length; i++) {
	  if (document.reports.id[i].checked) {
		rpt_id = document.reports.id[i].value;
		break;
	  }
	}
	if (!rpt_id) { // there may only be one report.
	  if (document.reports.id.checked) rpt_id = document.reports.id.value;
	}
    rID = rpt_id.slice(1);
  }
  if (rID || (action == 'new') || (action == 'import')) {
	window.open("index.php?cat=reportwriter&module=builder&action=step2&todo="+action+"&ReportID="+rID,"reports","width=900,height=650,resizable=1,scrollbars=1,top=150,left=200");
  } else {
	alert('<?php echo RW_FRM_NO_SELECTION; ?>');
  }
}

function ReportGenPopup(action) { // find what report radio button was pushed and call the report_generator popup
	var rpt_id = '';
	var type_id = '';
	for (var i = 0; i < document.reports.elements['id'].length; i++) {
		if (document.reports.id[i].checked) {
			rpt_id = document.reports.id[i].value;
			break;
		}
	}

	if (!rpt_id) { // there may only be one report.
	  if (document.reports.id.checked) rpt_id = document.reports.id.value;
	}
	type_id = rpt_id.charAt(0);
	var rID = rpt_id.slice(1);
	if (rID) {
		if (type_id == 'f') {
			window.open("index.php?cat=reportwriter&module=form_gen&ReportID="+rID+"&todo="+action,"forms","width=900,height=650,resizable=1,scrollbars=1,top=150,left=200");
		} else {
			window.open("index.php?cat=reportwriter&module=rpt_gen&ReportID="+rID+"&todo="+action,"reports","width=900,height=650,resizable=1,scrollbars=1,top=150,left=200");		
		}
	} else {
		alert('<?php echo RW_JS_SELECT_REPORT; ?>');
	}
}

function ReloadPage() {
	location.reload(true);
}

function Toggle(item) {
   obj = document.getElementById(item);
   visible = (obj.style.display!="none");
   key = document.getElementById("rpt_" + item);
   if (visible) {
     obj.style.display = "none";
     key.innerHTML = buildIcon('<?php echo DIR_WS_ICONS . "16x16/status/folder-open.png"; ?>', '<?php echo TEXT_EXPAND; ?>', 'hspace="0" vspace="0"');
   } else {
      obj.style.display = "block";
      key.innerHTML = buildIcon('<?php echo DIR_WS_ICONS . "16x16/actions/document-open.png"; ?>', '<?php echo TEXT_COLLAPSE; ?>', 'hspace="0" vspace="0"');
   }
}

function Expand(tab_type) {
	var tab_type_length = tab_type.length;
	divs = document.getElementsByTagName("DIV");
	for (i=0; i<divs.length; i++) {
		div_id = divs[i].id;
		if (div_id.substr(0,(4+tab_type_length)) == ('rpt_'+tab_type)) {
			divs[i].style.display = "block";
			key=document.getElementById("rpt_" + div_id);
			key.innerHTML = buildIcon('<?php echo DIR_WS_ICONS . "16x16/actions/document-open.png"; ?>', '<?php echo TEXT_COLLAPSE; ?>', 'hspace="0" vspace="0"');
		}
	}
}

function Collapse(tab_type) {
	var tab_type_length = tab_type.length;
	divs = document.getElementsByTagName("DIV");
	for (i=0; i<divs.length; i++) {
		div_id = divs[i].id;
		if (div_id.substr(0,(4+tab_type_length)) == ('rpt_'+tab_type)) {
			divs[i].style.display = "none";
			key=document.getElementById("rpt_" + div_id);
			key.innerHTML = buildIcon('<?php echo DIR_WS_ICONS . "16x16/status/folder-open.png"; ?>', '<?php echo TEXT_EXPAND; ?>', 'hspace="0" vspace="0"');
		}
	}
}

function fetch_def_info() {
	var entry = prompt('<?php echo RW_JS_ENTER_EXPORT_NAME; ?>', '');
	if (entry != null) {
		document.import_export.definition_name.value = entry;
	}
	var desc = document.import_export.definition_description.value;
	var entry = prompt('<?php echo RW_JS_ENTER_DESCRIPTION; ?>', desc);
	if (entry != null) {
		document.import_export.definition_description.value = entry;
	}
}

// -->
</script>