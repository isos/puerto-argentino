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
//  Path: /modules/orders/pages/popup_delivery/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.

function init() {
<?php if ($action == 'save') echo '  self.close();' ?>
}

function check_form() {
  return true;
}

// Insert other page specific functions here.

// -->
</script>
<?php 
echo '<script language="JavaScript">' . chr(10);
for ($i=0, $j=1; $i<$num_items; $i++, $j++) {
	echo '  var date_' . $j . ' = new ctlSpiffyCalendarBox("date_' . $j . '", "popup_delivery", "eta_date_' . $j . '", "btnDate2", "", scBTNMODE_CALBTN);' . chr(10);
}
echo '</script>' . chr(10);
?>
