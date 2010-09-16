<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2010 PhreeSoft, LLC                               |
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
//  Path: /my_files/custom/oscommerce/pages/main/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass some php variables
var shipDate = new ctlSpiffyCalendarBox("shipDate", "oscommerce", "ship_date","btnDate1", "<?php echo gen_spiffycal_db_date_short($ship_date); ?>", scBTNMODE_CALBTN);

// required function called with every page load
function init() {
  cssjsmenu('navbar');
}

function check_form() {
  return true;
}

// -->
</script>