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
//  Path: /modules/gen_ledger/pages/utils/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.

function init() {
  cssjsmenu('navbar');
}

function check_form() {
  return true;
}

// Insert other page specific functions here.
function fetchPeriod() {
  var acctPeriod = prompt('<?php echo GL_WARN_CHANGE_ACCT_PERIOD; ?>', '');
  if (acctPeriod) {
	document.getElementById('period').value = acctPeriod;
    return true;
  } else {
    return false;
  }
}

function updateEnd(index) {
  if (index != 11) {
	var tmp = document.getElementById('end_'+index).value;
	var temp = cleanDate(tmp);
	var thisDay = parseFloat(temp.substr(8,2));
	var thisMonth = parseFloat(temp.substr(5,2)) - 1;
	var thisYear = temp.substr(0,4);
	var nextDay = new Date(thisYear, thisMonth, thisDay);
	var oneDay = 1000 * 60 * 60 * 24;
	var dateInMs = nextDay.getTime();
	dateInMs += oneDay;
	nextDay.setTime(dateInMs);
	thisDay = nextDay.getDate();
	if (thisDay < 10) thisDay = '0' + thisDay;
	thisMonth = nextDay.getMonth() + 1;
	if (thisMonth < 10) thisMonth = '0' + thisMonth;
	thisYear = nextDay.getFullYear();
	temp = thisYear + '-' + thisMonth + '-' + thisDay;
	document.getElementById('start_'+(index+1)).value = formatDate(temp);
  }
}

// -->
</script>
<?php
// set up a calendar variable for each possible calendar
echo '<script type="text/javascript">' . chr(10);
$i = 0;
foreach ($fy_array as $key => $value) {
  if ($key > $max_period) { // only allow changes if nothing has bee posted above this period
	$ctl_end = 'P' . $i . 'End';
	echo 'var ' . $ctl_end . '=new ctlSpiffyCalendarBox("' . $ctl_end . '", "gl_utils", "end_' . $i . '", "btnDate2", "' . gen_spiffycal_db_date_short($value['end']) . '", scBTNMODE_CALBTN);' . chr(10);
	echo $ctl_end . '.readonly=true; ' . $ctl_end . '.displayLeft=true; ';
  }
  $i++;
}
echo '</script>' . chr(10);
?>
