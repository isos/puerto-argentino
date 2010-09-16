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
//  Path: /modules/install/templates/database_setup_default.php
//

?>
<p><?php echo TEXT_MAIN; ?></p>
<?php
  if ($zc_install->error) { require(DIR_WS_INSTALL_TEMPLATE . 'display_errors.php'); }
?>

    <form method="post" action="index.php?main_page=database_setup<?php if (isset($_GET['language'])) { echo '&language=' . $_GET['language']; } ?>&physical_path=<?php echo $_GET['physical_path']; ?>&virtual_http_path=<?php echo $_GET['virtual_http_path']; ?>&virtual_https_path=<?php echo $_GET['virtual_https_path']; ?>&virtual_https_server=<?php echo $_GET['virtual_https_server']; ?>&enable_ssl=<?php echo $_GET['enable_ssl']; ?>">
	  <fieldset>
	  <legend><?php echo DATABASE_INFORMATION; ?></legend>
	    <div class="section">
		  <select id="db_type" name="db_type" tabindex="1">
		    <option value="mysql"<?php echo setSelected('mysql', $_POST['db_type']); ?>>MySQL</option>
<!--			<option value="postgres"<?php echo setSelected('postgres', $_POST['db_type']); ?>>PostgreSQL</option> -->
		  </select>
	      <label for="db_type"><?php echo DATABASE_TYPE; ?></label>
		  <p><?php echo DATABASE_TYPE_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=14\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
<?php if (!$zc_install->fatal_error) { //do not display prefix field if upgrading ... prefix can be edited on the database-upgrade page, next. ?>
		<div class="section">
		  <input type="text" id="db_prefix" name="db_prefix" tabindex="2" value="<?php echo DATABASE_NAME_PREFIX; ?>" size="18" />
		  <label for="db_prefix"><?php echo DATABASE_PREFIX; ?></label>
		  <p><?php echo DATABASE_PREFIX_INSTRUCTION. '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=19\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
<?php } else { ?>
		  <input type="hidden" id="db_prefix" name="db_prefix" value="<?php echo DATABASE_NAME_PREFIX; ?>" />
<?php } ?>

                <div class="section">
		  <input type="text" id="db_host" name="db_host" tabindex="3" value="<?php echo DATABASE_HOST_VALUE; ?>" size="18" />
		  <label for="db_host"><?php echo DATABASE_HOST; ?></label>
		  <p><?php echo DATABASE_HOST_INSTRUCTION. '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=15\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="text" id="db_username" name="db_username" tabindex="4" value="<?php echo DATABASE_USERNAME_VALUE; ?>" size="18" />
		  <label for="db_username"><?php echo DATABASE_USERNAME; ?></label>
		  <p><?php echo DATABASE_USERNAME_INSTRUCTION. '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=16\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="password" id="db_pass" name="db_pass" tabindex="5" />
		  <label for="db_pass"><?php echo DATABASE_PASSWORD; ?></label>
		  <p><?php echo DATABASE_PASSWORD_INSTRUCTION. '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=17\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="text" id="db_name" name="db_name" tabindex="6" value="<?php echo DATABASE_NAME_VALUE; ?>" size="18" />
		  <label for="db_name"><?php echo DATABASE_NAME; ?></label>
		  <p><?php echo DATABASE_NAME_INSTRUCTION. '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=18\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
       </fieldset>
<?php if (isset($_GET['nogrants'])) echo '<input type="hidden" id="nogrants" name="nogrants" value="'.$_GET['nogrants'].'" />'; ?>
	  <input type="submit" name="submit" class="button" tabindex="15" value="<?php echo SAVE_DATABASE_SETTINGS; ?>" />
    </form>