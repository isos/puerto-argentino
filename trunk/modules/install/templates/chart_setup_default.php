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
//  Path: /modules/install/templates/chart_setup_default.php
//

?>
<p><?php echo TEXT_MAIN; ?></p>
<?php
  if ($zc_install->error) { require(DIR_WS_INSTALL_TEMPLATE . 'display_errors.php'); }
?>

    <form method="post" action="index.php?main_page=chart_setup&language=<?php echo $language; ?>">
	  <fieldset>
	  <legend><?php echo STORE_INFORMATION; ?></legend>
		<div class="section">
		  <select size="10" id="store_default_coa" tabindex="1" name="store_default_coa">
<?php echo $chart_string; ?>
		  </select>
	      <label for="store_default_coa"><?php echo STORE_DEFAULT_COA; ?></label>
		  <p><?php echo STORE_DEFAULT_COA_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=94\')">' . TEXT_HELP_LINK . '</a>'; ?></p>
	      <?php echo '<a href="javascript:popupWindowChrt(\'popup_help_screen.php?language=' . $language . '&error_code=coa\')">' . STORE_VIEW_COA_DETAILS . '</a>'; ?>
		</div>
	  </fieldset>
	  <input type="submit" name="submit" class="button" tabindex="3" value="<?php echo SAVE_STORE_SETTINGS; ?>" />
    </form>