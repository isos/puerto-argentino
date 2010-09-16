<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2008 PhreeSoft, LLC                               |
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
//  Path: /modules/assets/pages/main/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass some php variables
var date1=new ctlSpiffyCalendarBox("date1", "assets", "acquisition_date","btnDate1", "<?php echo isset($cInfo->acquisition_date) ? gen_spiffycal_db_date_short($cInfo->acquisition_date) : ''; ?>", scBTNMODE_CALBTN);
var date2=new ctlSpiffyCalendarBox("date2", "assets", "maintenance_date","btnDate1", "<?php echo isset($cInfo->maintenance_date) ? gen_spiffycal_db_date_short($cInfo->maintenance_date) : ''; ?>", scBTNMODE_CALBTN);
var date3=new ctlSpiffyCalendarBox("date3", "assets", "terminal_date",   "btnDate1", "<?php echo isset($cInfo->terminal_date) ? gen_spiffycal_db_date_short($cInfo->terminal_date) : ''; ?>", scBTNMODE_CALBTN);

// required function called with every page load
function init() {
	cssjsmenu('navbar');

  <?php if ($action <> 'new' && $action <> 'edit') { // set focus for main window
	echo "  document.getElementById('search_text').focus();";
  } ?>
  <?php if ($action == 'new') { // set focus for main window
	echo "  document.getElementById('asset_id').focus();";
  } ?>
}

function check_form() {
  var error = 0;
  var error_message = "<?php echo JS_ERROR; ?>";

  if (error == 1) {
	alert(error_message);
	return false;
  } else {
	return true;
  }
}

function deleteItem(id) {
	location.href = 'index.php?cat=asset&module=main&action=delete&cID='+id;
}

function copyItem(id) {
	var skuID = prompt('<?php echo ASSETS_MSG_COPY_INTRO; ?>', '');
	if (skuID) {
		location.href = 'index.php?cat=assets&module=main&action=copy&cID='+id+'&asset_id='+skuID;
	} else {
		return false;
	}
}

function renameItem(id) {
	var skuID = prompt('<?php echo ASSETS_MSG_RENAME_INTRO; ?>', '');
	if (skuID) {
		location.href = 'index.php?cat=assets&module=main&action=rename&cID='+id+'&asset_id='+skuID;
	} else {
		return false;
	}
}

function ImgPopup(url) {
  window.open('index.php?cat=inventory&module=popup_image&img='+url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=400,height=400,screenX=150,screenY=150,top=150,left=150');
}

// -->
</script>