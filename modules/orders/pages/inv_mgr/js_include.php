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
//  Path: /modules/orders/pages/inv_mgr/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.

function init() {
  cssjsmenu('navbar');
  document.getElementById('search_text').focus();
  document.getElementById('search_text').select();
}

function check_form() {
  return true;
}

// Insert other page specific functions here.
function shipList(oID, carrier) {
	window.open("index.php?cat=services&module=popup_label_mgr&subject="+carrier+"&oID="+oID,"ship_mgr","width=800,height=700,resizable=1,scrollbars=1,top=50,left=50");
}

function voidShipment(sID, carrier) {
	window.open("index.php?cat=services&module=popup_label_mgr&subject="+carrier+"&sID="+sID+"&action=delete","ship_mgr","width=800,height=700,resizable=1,scrollbars=1,top=50,left=50");
}

function closeShipment(carrier) {
	window.open("index.php?cat=services&module=popup_label_mgr&subject="+carrier+"&action=close","ship_mgr","width=800,height=700,resizable=1,scrollbars=1,top=50,left=50");
}

function printOrder(id) {
  var printWin = window.open("index.php?cat=reportwriter&module=popup_form&gn=<?php echo POPUP_FORM_TYPE; ?>&mID="+id+"&cr0=<?php echo TABLE_JOURNAL_MAIN; ?>.id:"+id,"forms","width=700px,height=550px,resizable=1,scrollbars=1,top=150px,left=200px");
  printWin.focus();
}

function loadPopUp(subject, action, id) {
  window.open("index.php?cat=services&module=popup_tracking&subject="+subject+"&action="+action+"&sID="+id,"popup_tracking","width=500,height=350,resizable=1,scrollbars=1,top=150,left=200");
}

// -->
</script>