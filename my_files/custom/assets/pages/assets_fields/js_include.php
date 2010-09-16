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
//  Path: /modules/assets/pages/assets_fields/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.
// var jsVariable = '<?php echo CONSTANT; ?>';

function init() {
  cssjsmenu('navbar'); // include the navigtion bar
}

function check_form() {
  var error = 0;
  var error_message = "<?php echo JS_ERROR; ?>";

<?php if ($action == 'edit' || $action == 'update') { ?>
  var field_name = document.assets_fields.field_name.value;
  if (field_name == "") {
	error_message = error_message + "<?php echo JS_FIELD_NAME; ?>";
	error = 1;
  }
<?php } ?>

  if (error == 1) {
	alert(error_message);
	return false;
  } else {
	return true;
  }
}
// Insert javscript file references here.


// Insert other page specific functions here.


// -->
</script>