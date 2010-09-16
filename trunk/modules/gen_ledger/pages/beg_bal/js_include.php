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
//  Path: /modules/gen_ledger/pages/beg_bal/js_include.php
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

  // check for balance of credits and debits
  var bal_total = cleanCurrency(document.getElementById('balance_total').value);
  if (bal_total != 0) {
  	error_message += "<?php echo GL_ERROR_OUT_OF_BALANCE; ?>";
  	error = 1;
  }

  if (error == 1) {
    alert(error_message);
    return false;
  }
  return true;
}

// Insert other page specific functions here.
function updateBalance() {
  var entry;
  var debit_total = 0;
  var credit_total = 0;
  var balance_total = 0;
  for (var i=0; i<isDebit.length; i++) {
	entry = parseFloat(cleanCurrency(document.getElementById('coa_value['+i+']').value));
  	if (isDebit[i]) {
		if (!isNaN(entry)) debit_total += entry;
	} else {
	  	if (!isNaN(entry)) credit_total += entry;
	}
	var temp = new String(entry);
	document.getElementById('coa_value['+i+']').value = formatCurrency(temp);
  }
  balance_total = debit_total - credit_total;
  var dt = new String(debit_total);
  document.getElementById('debit_total').value = formatCurrency(dt);
  var ct = new String(credit_total);
  document.getElementById('credit_total').value = formatCurrency(ct);
  var tot = new String(balance_total);
  document.getElementById('balance_total').value = formatCurrency(tot);
  var numExpr = Math.round(eval(balance_total) * Math.pow(10, decimal_places));
  if (numExpr == 0) {
  	document.getElementById('balance_total').style.color = '';
  } else {
  	document.getElementById('balance_total').style.color = 'red';
  }
}

var isDebit = new Array(<?php echo count($glEntry->beg_bal); ?>);
<?php
$i = 0;
foreach ($glEntry->beg_bal as $coa_id => $values) {
	if ($coa_types[$values['type']]['asset']) { // it is a debit
		echo 'isDebit[' . $i . '] = 1;' . chr(10);
	} else {
		echo 'isDebit[' . $i . '] = 0;' . chr(10);
	}
	$i++;
}
?>

// -->
</script>