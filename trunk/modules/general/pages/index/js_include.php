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
//  Path: /modules/general/pages/index/js_include.php
//

?>
<script type="text/javascript">
<!--
// required function called with every page load
function init() {
  cssjsmenu('navbar');
}

// required function called with every form submit. return true on success
function check_form() {
  return true;
}

function box_edit(boxId) {
  document.getElementById(boxId).className = 'modbox_e';
}

function box_cancel(boxId) {
  document.getElementById(boxId).className = 'modbox';
}

var plusSign = new Image(16,16);
plusSign.src = "<?php echo DIR_WS_ICONS; ?>16x16/actions/list-add.png";
var minusSign = new Image(16,16);
minusSign.src= " <?php echo DIR_WS_ICONS; ?>16x16/actions/list-remove.png";

function min_box(boxId) {
  var objBody = document.getElementById(boxId + '_body');
  if (objBody.style.display == 'none') {
	objBody.style.display = '';
	document.getElementById(boxId + '_exp').src = minusSign.src;
	document.getElementById(boxId + '_exp').title = '<?php echo TEXT_COLLAPSE; ?>';
  } else {
	objBody.style.display = 'none';
	document.getElementById(boxId + '_exp').src = plusSign.src;
	document.getElementById(boxId + '_exp').title = '<?php echo TEXT_EXPAND; ?>';
  }
}

function del_box(boxId) {
  if (confirm('<?php echo JS_CTL_PANEL_DELETE_BOX; ?>')) {
	var formId = boxId + '_frm';
	var actionId = boxId + '_action';
	document.getElementById(actionId).value = 'delete';
	document.getElementById(formId).submit();
  }
  return false;
}

function move_box(boxId, direction) {
  var formId = boxId + '_frm';
  var actionId = boxId + '_action';
  switch(direction) {
    case 'move_left':
	  document.getElementById(actionId).value = 'move_left';
	  break;
    case 'move_right':
	  document.getElementById(actionId).value = 'move_right';
	  break;
    case 'move_up':
	  document.getElementById(actionId).value = 'move_up';
	  break;
    case 'move_down':
	  document.getElementById(actionId).value = 'move_down';
	  break;
    default:
  }
  document.getElementById(formId).submit();
}

function del_index(boxId, index) {
  if (confirm('<?php echo JS_CTL_PANEL_DELETE_IDX; ?>')) {
	var formId = boxId + '_frm';
	var removeId = boxId + '_rId';
	document.getElementById(removeId).value = index;
	document.getElementById(formId).submit();
  }
  return false;
}

// -->
</script>