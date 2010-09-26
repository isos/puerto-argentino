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
//  Path: /modules/general/pages/login/template_main.php
//

echo html_form('login', FILENAME_DEFAULT, 'cat=general&amp;module=login');
?>
<div style="border:1px solid gold; border-radius:5px; -moz-border-radius:5px; margin-left:30%; margin-top:20px; width:600px">
	<div style="float:left; padding:30px 0px 5px 0px;margin-left:5px">
		    <table style="width:100%; border:0px solid gold; background:#EFFFFF; padding:0px 5px 0px 5px" border="0" cellspacing="0" cellpadding="5">
		      <tr>
		        <td width="35%" class="main">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo TEXT_LOGIN_NAME; ?></td>
		        <td width="65%"><?php echo html_input_field('admin_name', $_POST['admin_name']); ?></td>
		      </tr>
		      <tr>
		        <td class="main">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo TEXT_LOGIN_PASS; ?></td>
		        <td><?php echo html_password_field('admin_pass', ''); ?></td>
		      </tr>
				<?php if ($pass_message) {
				echo '<tr>' . chr(10);
				echo '  <td class="main" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $pass_message . '</td>' . chr(10);
				echo '</tr>' . chr(10);
				} ?>
		      <tr style="visibility:hidden;">
		        <td class="main">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo TEXT_LOGIN_COMPANY; ?></td>
		        <td><?php echo html_pull_down_menu('company', load_company_dropdown(), $admin_company); ?></td>
		      </tr>
		      <tr>
		        <td colspan="2" align="center">
			    <?php echo html_hidden_field('language', DEFAULT_LANGUAGE); ?>
			    <?php echo html_hidden_field('theme', DEFAULT_THEME); ?>
			    <?php echo html_submit_field('submit', TEXT_LOGIN_BUTTON); ?>
			</form>
			</td>
		      </tr>
		      <tr>
		        <td colspan="2" align="center"></td>
		      </tr>
		
		    </table>

		</div>
		<img src="themes/default/images/login.jpg" alt="PhreeBooks Acconting" height="250px" />
	<p style="margin-left:10px; margin-right:10px; text-align:right">
	<?php echo '<a href="' . html_href_link(FILENAME_DEFAULT, 'cat=general&amp;module=pw_lost', 'SSL') . '">' . TEXT_PASSWORD_FORGOTTEN . '</a>'; ?>
	</p>
</div>


