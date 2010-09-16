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
//  Path: /modules/gen_ledger/pages/budget/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.
ajaxRH["loadAccount"] = "processLoadAccount";

num_periods = <?php echo sizeof($fy_array); ?>;

function init() {
  cssjsmenu('navbar');
  calculateTotal();
}

function check_form() {
  return true;
}

// Insert other page specific functions here.
function copyBudget(action) {
  var i, total;
  switch (action) {
    case 'spread':
	  total = cleanCurrency(document.getElementById('total').value);
	  fTotal = parseFloat(total);
	  var allocation = formatCurrency(fTotal / num_periods);
	  for (i = 0; i < num_periods; i++) {
	    document.getElementById('budget_'+i).value = allocation;
	  }
	  break;
	case 'prior':
	  for (i = 0; i < num_periods; i++) {
	    document.getElementById('budget_'+i).value = document.getElementById('prior_'+i).value;
	  }
	  break;
	case 'next':
	  for (i = 0; i < num_periods; i++) {
	    document.getElementById('budget_'+i).value = document.getElementById('next_'+i).value;
	  }
	  break;
	case 'clear':
	  for (i = 0; i < num_periods; i++) {
	    document.getElementById('budget_'+i).value = formatted_zero;
	  }
	  break;
	default:
  }
  calculateTotal();
}

function calculateTotal() {
  var p_temp, b_temp, n_temp;
  var p_total = 0;
  var b_total = 0;
  var n_total = 0;
  for (i = 0; i < num_periods; i++) {
	p_temp   = cleanCurrency(document.getElementById('prior_'+i).value);
	p_total += parseFloat(p_temp);
	b_temp   = cleanCurrency(document.getElementById('budget_'+i).value);
	b_total += parseFloat(b_temp);
	n_temp   = cleanCurrency(document.getElementById('next_'+i).value);
	n_total += parseFloat(n_temp);
  }
  p_temp = new String(p_total);
  b_temp = new String(b_total);
  n_temp = new String(n_total);
  document.getElementById('prior').value = formatCurrency(p_temp);
  document.getElementById('total').value = formatCurrency(b_temp);
  document.getElementById('next').value  = formatCurrency(n_temp);
}

// ajax pair to fetch prior year account acutals
function fetchAcct() {
  var gl_acct = document.getElementById('gl_acct').value;
  var fy      = document.getElementById('fy').value;
  if (!gl_acct) return;
  copyBudget('clear');
  loadXMLReq('index.php?cat=gen_ledger&module=ajax&op=load_gl_data&glAcct='+gl_acct+'&fy='+fy);
}

function processLoadAccount(resp) {
  data = parseXML(resp);
  if (data.error) {
    alert(data.error);
	return;
  }
  for (iIndex=0; iIndex<data.items.length; iIndex++) {
	document.getElementById('budget_'+iIndex).value = data.items[iIndex].balance;
  }
  calculateTotal();
}

// -->
</script>
