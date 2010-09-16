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
//  Path: /modules/accounts/pages/popup_accts/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
var journalID = '<?php echo JOURNAL_ID; ?>';
var fill = '<?php echo $fill; ?>';

function init() {
  document.getElementById('search_text').focus();
  document.getElementById('search_text').select();
}

function check_form() {
  return true;
}
// Insert javscript file references here.


// Insert other page specific functions here.
function setReturnOrder(pointer) {
  var cID = 0; // the customer is in the order.
  var oID = document.getElementById('open_order_'+pointer).value;
  window.opener.ClearForm();
  window.opener.ajaxOrderData(cID, oID, journalID, true, false);
  self.close();
}

function setReturnAccount(cID) {
  var oID = 0; // contact only
  if (fill == 'ship') {
    var ship_only = true;
    window.opener.clearAddress('ship');
  } else {
    var ship_only = false;
//    window.opener.ClearForm();
    window.opener.ClearMainForm(); //solo limpio el formulario de arriba, no borro los items ya cargados
  }
  window.opener.ajaxOrderData(cID, oID, journalID, false, ship_only);
  self.close();
}

// -->
</script>
