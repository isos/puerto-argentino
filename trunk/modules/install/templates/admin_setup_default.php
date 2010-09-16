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
//  Path: /modules/install/templates/admin_setup_default.php
//

?>
<p><?php echo TEXT_MAIN; ?></p>
<?php
  if ($zc_install->error) { require(DIR_WS_INSTALL_TEMPLATE . 'display_errors.php'); }
?>

    <form method="post" action="index.php?main_page=admin_setup&language=<?php  echo $language; ?>">
	  <fieldset>
	  <legend><strong><?php echo ADMIN_INFORMATION; ?></strong></legend>
		<div class="section">
		  <input type="text" id="admin_username" name="admin_username" tabindex="1" value="<?php echo ADMIN_USERNAME_VALUE; ?>" />
		  <label for="admin_username"><?php echo ADMIN_USERNAME; ?></label>
		  <p><?php echo ADMIN_USERNAME_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=51\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="password" id="admin_pass" name="admin_pass" tabindex="2" />
		  <label for="admin_pass"><?php echo ADMIN_PASS; ?></label>
		  <p><?php echo ADMIN_PASS_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=53\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="password" id="admin_pass_confirm" name="admin_pass_confirm" tabindex="3"/>
		  <label for="admin_pass_confirm"><?php echo ADMIN_PASS_CONFIRM; ?></label>
		  <p><?php echo ADMIN_PASS_CONFIRM_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=54\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="text" id="admin_email" name="admin_email" tabindex="4" value="<?php echo ADMIN_EMAIL_VALUE; ?>" />
		  <label for="admin_email"><?php echo ADMIN_EMAIL; ?></label>
		  <p><?php echo ADMIN_EMAIL_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=52\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
	  </fieldset>

	  <input type="submit" name="submit" class="button" tabindex="20" value="<?php echo SAVE_ADMIN_SETTINGS; ?>" />
    </form>