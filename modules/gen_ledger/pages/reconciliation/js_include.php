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
//  Path: /modules/gen_ledger/pages/reconciliation/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.

function init() {
	cssjsmenu('navbar');
	updateBalance();
}

function check_form() {
  var error = 0;
  var error_message = "<?php echo JS_ERROR; ?>";

  if (error == 1) {
    alert(error_message);
    return false;
  }
  return true;
}

// Insert other page specific functions here.
function updateBalance() {
  var entry;
  var temp;
  var start_balance = parseFloat(cleanCurrency(document.getElementById('start_balance').value));
  var open_checks = 0;
  var open_deposits = 0;
  var gl_balance = parseFloat(cleanCurrency(document.getElementById('gl_balance').value));
  for (var i=0; i<isCheck.length; i++) {
    if (!document.getElementById('id['+i+']').checked) {
	  if (isCheck[i]) {
	    if(document.all) { // IE browsers
		  temp = document.getElementById('td_'+i+'_3').innerText ;
        } else { //firefox
		  temp = document.getElementById('td_'+i+'_3').textContent ;
		}
		entry = parseFloat(cleanCurrency(temp));
		if (!isNaN(entry)) open_checks += entry;
	  } else {
	    if(document.all) { // IE browsers
		  temp = document.getElementById('td_'+i+'_2').innerText ;
        } else { //firefox
		  temp = document.getElementById('td_'+i+'_2').textContent ;
		}
		entry = parseFloat(cleanCurrency(temp));
	  	if (!isNaN(entry)) open_deposits += entry;
	  }
	}
  }
  var sb = new String(start_balance);
  document.getElementById('start_balance').value = formatCurrency(sb);
  var dt = new String(open_checks);
  document.getElementById('open_checks').value = formatCurrency(dt);
  var ct = new String(open_deposits);
  document.getElementById('open_deposits').value = formatCurrency(ct);

  var balance = start_balance - open_checks + open_deposits - gl_balance;
  var tot = new String(balance);
  document.getElementById('balance').value = formatCurrency(tot);
  var numExpr = Math.round(eval(balance) * Math.pow(10, decimal_places));
  if (numExpr == 0) {
  	document.getElementById('balance').style.color = '';
  } else {
  	document.getElementById('balance').style.color = 'red';
  }
}

var isCheck = new Array(<?php echo count($combined_list); ?>);
<?php
$i = 0;
foreach ($combined_list as $values) {
	if ($values['payment']) { // it is a payment (Payable)
		echo 'isCheck[' . $i . '] = 1;' . chr(10);
	} else {
		echo 'isCheck[' . $i . '] = 0;' . chr(10);
	}
	$i++;
}
?>

// -->
</script>