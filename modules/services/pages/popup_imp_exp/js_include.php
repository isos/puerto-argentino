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
//  Path: /modules/services/pages/popup_imp_exp/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.

function init() {
<?php
 if ($action == 'save') {
 	echo '  if (document.all) {' . chr(10);
	echo '    window.opener.document.getElementById("field_table").rows[' . ($row_id + 1) . '].cells[1].innerText = "' . $name . '";' . chr(10);
	echo '    window.opener.document.getElementById("field_table").rows[' . ($row_id + 1) . '].cells[2].innerText = "' . $processing . '";' . chr(10);
	echo '    window.opener.document.getElementById("field_table").rows[' . ($row_id + 1) . '].cells[4].innerText = "' . ($show ? TEXT_YES : TEXT_NO) . '";' . chr(10);
	echo '  } else {' . chr(10);
	echo '    window.opener.document.getElementById("field_table").rows[' . ($row_id + 1) . '].cells[1].textContent = "' . $name . '";' . chr(10);
	echo '    window.opener.document.getElementById("field_table").rows[' . ($row_id + 1) . '].cells[2].textContent = "' . $processing . '";' . chr(10);
	echo '    window.opener.document.getElementById("field_table").rows[' . ($row_id + 1) . '].cells[4].textContent = "' . ($show ? TEXT_YES : TEXT_NO) . '";' . chr(10);
	echo '  }' . chr(10);
	echo '   self.close();' . chr(10); 
}
?> 
}

function check_form() {
  return true;
}

// Insert other page specific functions here.

// -->
</script>