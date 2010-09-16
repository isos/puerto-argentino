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
//  Path: /modules/reportwriter/pages/form_gen/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.
var dateFrom = new ctlSpiffyCalendarBox("dateFrom", "formfilter", "DefDateFrom", "btnDate1", "<?php echo $DateArray[1]; ?>", scBTNMODE_CALBTN);
var dateTo = new ctlSpiffyCalendarBox("dateTo", "formfilter", "DefDateTo", "btnDate1", "<?php echo $DateArray[2]; ?>", scBTNMODE_CALBTN);

function init() {
  hideEmail();
<?php if ($Prefs['serialform']) {
  echo '  document.print();';
} ?>

}

function check_form() {
  return true;
}

// Insert other page specific functions here.
function hideEmail() {
  for (var i=0; i<document.formfilter.delivery_method.length; i++) {
    if (document.formfilter.delivery_method[i].checked) {
      break;
    }
  }
  var deliveryValue = document.formfilter.delivery_method[i].value;
  if (deliveryValue == 'S') {
    document.getElementById('rpt_email').style.display = 'block';
  } else {
    document.getElementById('rpt_email').style.display = 'none';
  }
}
// -->
</script>