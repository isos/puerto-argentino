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
//  Path: /modules/services/pages/ship_mgr/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.
var cal = new ctlSpiffyCalendarBox("cal", "ship_mgr", "search_date", "btnDate2", "<?php echo gen_spiffycal_db_date_short($date); ?>", scBTNMODE_CALBTN);
cal.JStoRunOnSelect="calendarPage('<?php echo js_get_all_get_params(array('search_text', 'page', 'action')); ?>');";

function init() {
  cssjsmenu('navbar'); // include the navigtion bar
}

function check_form() {
  return true;
}

// Insert other page specific functions here.
function loadPopUp(subject, action, id) {
  window.open("index.php?cat=services&module=popup_tracking&subject="+subject+"&action="+action+"&sID="+id,"popup_tracking","width=500,height=350,resizable=1,scrollbars=1,top=150,left=200");
}

function submitAction(module_id, action) {
  document.getElementById('module_id').value = module_id;
  submitToDo(action);
}

function submitShipSequence(module_id, rowSeq, todo) {
  document.getElementById('module_id').value = module_id;
  submitSeq(rowSeq, todo);
}

function calendarPage(get_params) {
  var searchDate = document.ship_mgr.search_date.value;
  location.href = 'index.php?'+get_params+'search_date='+searchDate;
}

// -->
</script>