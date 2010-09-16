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
//  Path: /modules/reportwriter/pages/popup_form/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.
ajaxRH["emailMsg"]  = "fillEmailMsg";

function init() {
  hideEmail();
  if (!document.popup_form.ReportID.length) { // there is only one form to pick from so select it
	document.popup_form.ReportID.checked = true;
	fetchEmailMsg();
  }
  self.focus();
}

function check_form() {
  var rpt_id = false;
  for (var i = 0; i < document.popup_form.ReportID.length; i++) {
	if (document.popup_form.ReportID[i].checked) rpt_id = true;
  }
  if (!document.popup_form.ReportID.length) {
	if (document.popup_form.ReportID.value) rpt_id = true; // for single form entries
  }
  if (!rpt_id) {
	alert('<?php echo RW_FRM_NO_SELECTION; ?>');
	return false;
  }
  return true;
}

// Insert other page specific functions here.
function hideEmail() {
  for (var i=0; i<document.forms[0].delivery_method.length; i++) {
    if (document.forms[0].delivery_method[i].checked) {
      break;
    }
  }
  var deliveryValue = document.forms[0].delivery_method[i].value;
  if (deliveryValue == 'S') {
    document.getElementById('rpt_email').style.display = 'block';
  } else {
    document.getElementById('rpt_email').style.display = 'none';
  }
}

// ajax pair to fetch email message specific to a given report/form
function fetchEmailMsg() {
  var rID;
  for (var i = 0; i < document.popup_form.ReportID.length; i++) {
	if (document.popup_form.ReportID[i].checked) rID = document.popup_form.ReportID[i].value;
  }
  if (!document.popup_form.ReportID.length) {
	if (document.popup_form.ReportID.value) rID = document.popup_form.ReportID.value; // for single form entries
  }
  if (rID) {
    loadXMLReq('index.php?cat=reportwriter&module=ajax&op=load_email_msg&rID='+rID);
  }
}

function fillEmailMsg(resp) {
  //convert to an array
  data = parseXML(resp);
  if (data.msg) document.getElementById('message_body').value = data.msg;
}

// -->
</script>