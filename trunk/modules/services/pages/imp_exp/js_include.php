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
//  Path: /modules/services/pages/imp_exp/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.

function init() {
  cssjsmenu('navbar'); // include the navigtion bar
}

function check_form() {
  return true;
}

// Insert other page specific functions here.
function fetch_def_info() {
  var entry = prompt('<?php echo SRV_JS_DEF_NAME; ?>', '');
  if (entry != null) {
    document.getElementById('definition_name').value = entry;
  } else {
    return false;
  }
  entry = prompt('<?php echo SRV_JS_DEF_DESC; ?>', '');
  if (entry != null) {
    document.getElementById('definition_description').value = entry;
  } else {
    return false;
  }
  return true;
}

function moveField(rowSeq, todo) {
   var entry = prompt('<?php echo SRV_JS_SEQ_NUM; ?>', '');
   if (entry != null) {
      document.getElementById('moveSeq').value = entry;
	  document.getElementById('rowSeq').value = rowSeq;
	  document.getElementById('todo').value = todo;
      document.import_export.submit();
   }
}

function fieldEdit(id, row_id) {
  window.open("index.php?cat=services&module=popup_imp_exp&id="+id+"&row_id="+row_id,"import_export","width=500,height=200,resizable=1,scrollbars=1,top=150,left=200");
}

// -->
</script>