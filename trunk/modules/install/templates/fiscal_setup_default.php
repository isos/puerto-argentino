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
//  Path: /modules/install/templates/fiscal_setup_default.php
//

?>
<p><?php echo TEXT_MAIN; ?></p>
<?php
  if ($zc_install->error) { require(DIR_WS_INSTALL_TEMPLATE . 'display_errors.php'); }
?>

    <form method="post" action="index.php?main_page=fiscal_setup&language=<?php echo $language; ?>">
	  <fieldset>
	  <legend><?php echo STORE_INFORMATION; ?></legend>
		<div class="section">
		  <select id="store_period_1" tabindex="1" name="store_period_1">
<?php echo $period_string; ?>
		  </select>
	      <label for="store_period_1"><?php echo STORE_DEFAULT_PERIOD; ?></label>
		  <p><?php echo STORE_DEFAULT_PERIOD_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=95\')">' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <select id="store_fiscal_year" tabindex="1" name="store_fiscal_year">
<?php echo $fiscal_string; ?>
		  </select>
	      <label for="store_fiscal_year"><?php echo STORE_DEFAULT_FY; ?></label>
		  <p><?php echo STORE_DEFAULT_FY_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=95\')">' . TEXT_HELP_LINK . '</a>'; ?></p>
		  <?php if ($fy_exists) echo sprintf(TEXT_FISCAL_YEAR_EXISTS, $from_num, $to_num); ?>
		</div>
	  </fieldset>
<?php if ($fy_exists) { ?>
	  <input type="submit" name="skip" class="button" tabindex="3" value="<?php echo SKIP_STORE_SETTINGS; ?>" />
<?php } else { ?>
	  <input type="submit" name="submit" class="button" tabindex="3" value="<?php echo SAVE_STORE_SETTINGS; ?>" />
<?php } ?>
    </form>