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
//  Path: /modules/services/shipping/label_mgr/item/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.
var dateShipped = new ctlSpiffyCalendarBox("dateShipped", "label_mgr", "ship_date","btnDate2", "<?php echo (isset($sInfo->ship_date)) ? gen_spiffycal_db_date_short($sInfo->ship_date) : date('m/d/Y', time()); ?>", scBTNMODE_CALBTN);
var dateExpected = new ctlSpiffyCalendarBox("dateExpected", "label_mgr", "deliver_date","btnDate2", "<?php echo (isset($sInfo->deliver_date)) ? gen_spiffycal_db_date_short($sInfo->deliver_date) : date('m/d/Y', time()); ?>", scBTNMODE_CALBTN);

function init() {
  <?php if (!$error && ($action == 'save' || $action == 'delete')) {
	echo '  window.opener.location.reload();' . chr(10);
	echo '  self.close();' . chr(10);
  } ?>
}

function check_form() {
  return true;
}

// Insert other page specific functions here.

// -->
</script>