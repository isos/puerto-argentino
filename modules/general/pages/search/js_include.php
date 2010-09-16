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
//  Path: /modules/general/pages/search/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.
var dateFrom = new ctlSpiffyCalendarBox("dateFrom", "site_search", "date_from", "btnDate2", "<?php echo $_GET['date_from']; ?>", scBTNMODE_CALBTN);
var dateTo = new ctlSpiffyCalendarBox("dateTo", "site_search", "date_to", "btnDate2", "<?php echo $_GET['date_to']; ?>", scBTNMODE_CALBTN);

function init() {
  cssjsmenu('navbar');
}

function check_form() {
  return true;
}
// Insert javscript file references here.


// Insert other page specific functions here.


// -->
</script>