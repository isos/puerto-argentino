<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2009 PhreeSoft, LLC                               |
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
//  Path: /modules/accounts/pages/main/template_i_history.php
//
?>
<div id="cat_history" class="tabset_content">
  <h2 class="tabset_label"><?php echo TEXT_HISTORY; ?></h2>

<?php // ***********************  History Section  ****************************** ?>
  <fieldset class="formAreaTitle">
    <legend><?php echo ACT_CONTACT_HISTORY; ?></legend>
    <table border="0" width="100%" cellspacing="6" cellpadding="0">
	  <tr>
	    <td width="50%"><?php echo ACT_FIRST_DATE . ' ' . gen_spiffycal_db_date_short($cInfo->first_date); ?></td>
	  </tr>
	  <tr>
	    <td width="50%"><?php echo ACT_LAST_DATE1 . ' ' . gen_spiffycal_db_date_short($cInfo->last_update); ?></td>
	  </tr>
	</table>
  </fieldset>

</div>