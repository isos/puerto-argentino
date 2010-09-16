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
//  Path: /modules/general/pages/pw_lost/template_main.php
//

// start the form
echo html_form('pw_lost', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);
?>
<table align="center" border="0">
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>
  <fieldset>
	<legend><?php echo TEXT_PASSWORD_FORGOTTEN; ?></legend>
	<label for="admin_email"><?php echo TEXT_ADMIN_EMAIL; ?>
	<?php echo html_input_field('admin_email', $_POST['admin_email']); ?></label>
	<?php echo $email_message; ?>
    <br /><label for="company"><?php echo TEXT_LOGIN_COMPANY; ?>
	<?php echo html_pull_down_menu('company', load_company_dropdown(), ''); ?>
	</label>
	<br /><?php echo html_submit_field('submit', TEXT_PASSWORD_FORGOTTEN) . '&nbsp;&nbsp;'; ?>
  </fieldset>
  </td></tr>
</table>
</form>