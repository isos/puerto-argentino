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
//  Path: /modules/install/templates/system_setup_default.php
//

?>
<p><?php echo TEXT_MAIN; ?></p>
<?php
  if ($zc_install->error) { require(DIR_WS_INSTALL_TEMPLATE . 'display_errors.php'); }
?>

    <form method="post" action="index.php?main_page=system_setup<?php if (isset($_GET['language'])) { echo '&language=' . $_GET['language']; } ?>">
	  <fieldset>
	  <legend><?php echo SERVER_SETTINGS; ?></legend>
		<div class="section">
		  <input type="text" id="physical_path" name="physical_path" tabindex = "1" value="<?php echo PHYSICAL_PATH_VALUE; ?>" size="50" />
		  <label for="physical_path"><?php echo PHYSICAL_PATH; ?></label>
		  <p><?php echo PHYSICAL_PATH_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=4\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="text" id="virtual_http_path" name="virtual_http_path" tabindex="2" value="<?php echo VIRTUAL_HTTP_PATH_VALUE; ?>" size="50" />
		  <label for="virtual_http_path"><?php echo VIRTUAL_HTTP_PATH; ?></label>
		  <p><?php echo VIRTUAL_HTTP_PATH_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=5\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>

		<div class="section">
		  <input type="text" id="virtual_https_server" name="virtual_https_server" tabindex="3" value="<?php echo VIRTUAL_HTTPS_SERVER_VALUE; ?>" size="50" />
		  <label for="virtual_https_server"><?php echo VIRTUAL_HTTPS_SERVER; ?></label>
		  <p><?php echo VIRTUAL_HTTPS_SERVER_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=6\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>

		<div class="section">
		  <input type="text" id="virtual_https_path" name="virtual_https_path" tabindex="4" value="<?php echo VIRTUAL_HTTPS_PATH_VALUE; ?>" size="50" />
		  <label for="virtual_https_path"><?php echo VIRTUAL_HTTPS_PATH; ?></label>
		  <p><?php echo VIRTUAL_HTTPS_PATH_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=7\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
	  
		<div class="section">
		  <div class="input">
		    <input type="radio" id="enable_ssl_yes" name="enable_ssl" tabindex="6" value="true" <?php echo ENABLE_SSL_TRUE; ?>/>
		    <label for="enable_ssl_yes"><?php echo YES; ?></label>
		    <input type="radio" id="enable_ssl_no" name="enable_ssl" tabindex="7" value="false" <?php echo ENABLE_SSL_FALSE; ?>/>
		    <label for="enable_ssl_no"><?php echo NO; ?></label>
		  </div>
		  <span class="label"><?php echo ENABLE_SSL; ?></span>
		  <p><?php echo ENABLE_SSL_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=8\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
          
	  </fieldset>
	  <input type="submit" name="submit" class="button" tabindex = "10" value="<?php echo SAVE_SYSTEM_SETTINGS; ?>" />
    </form>