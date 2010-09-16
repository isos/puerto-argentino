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
//  Path: /my_files/custom/rma/pages/popup_inv/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.

function init() {
  document.getElementById('search_text').focus();
  document.getElementById('search_text').select();
}

function check_form() {
  return true;
}
// Insert javscript file references here.

// Insert other page specific functions here.
function setReturnItem(pointer, rowID, formName, sku, desc, price, acct, weight, stock, taxable, lead_time, cogs_acct, inactive) {
  window.opener.document.getElementById('sku_'+rowID).value = sku;
  window.opener.document.getElementById('sku_'+rowID).style.color = '';
  window.opener.document.getElementById('desc_'+rowID).value = desc;
  self.close();
}

function assyRecord(sku, description, qty, quantity_on_hand) {
  this.sku = sku;
  this.description = description;
  this.qty = qty;
  this.quantity_on_hand = quantity_on_hand;
}

// -->
</script>