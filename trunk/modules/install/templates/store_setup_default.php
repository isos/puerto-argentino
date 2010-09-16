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
//  Path: /modules/install/templates/store_setup_default.php
//

?>
<p><?php echo TEXT_MAIN; ?></p>
<?php
  if ($zc_install->error) { require(DIR_WS_INSTALL_TEMPLATE . 'display_errors.php'); }
?>

    <form method="post" action="index.php?main_page=store_setup&language=<?php echo $language; ?>">
	  <fieldset>
	  <legend><?php echo STORE_INFORMATION; ?></legend>
		<div class="section">
		  <input type="text" id="store_id" name="store_id" tabindex="1" size="15" value="<?php echo $_POST['store_id']; ?>" />
		  <label for="store_id"><?php echo STORE_ID; ?></label>
		  <p><?php echo STORE_ID_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=90\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="text" id="store_name" name="store_name" tabindex="2" size="35" value="<?php echo  $_POST['store_name']; ?>" />
		  <label for="store_name"><?php echo STORE_NAME; ?></label>
		  <p><?php echo STORE_NAME_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=37\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
        <div class="section">
		  <input type="text" id="store_address1" name="store_address1" tabindex="3" size="35" value="<?php echo  $_POST['store_address1']; ?>" />
		  <label for="store_address1"><?php echo STORE_ADDRESS1; ?></label>
		  <p><?php echo STORE_ADDRESS1_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=42\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
        <div class="section">
		  <input type="text" id="store_address2" name="store_address2" tabindex="4" size="35" value="<?php echo  $_POST['store_address2']; ?>" />
		  <label for="store_address2"><?php echo STORE_ADDRESS2; ?></label>
		  <p><?php echo STORE_ADDRESS2_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=42\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="text" id="store_city_town" name="store_city_town" tabindex="5" size="25" value="<?php echo  $_POST['store_city_town']; ?>" />
		  <label for="store_city_town"><?php echo STORE_CITY_TOWN; ?></label>
		  <p><?php echo STORE_CITY_TOWN_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=38\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="text" id="store_zone" name="store_zone" tabindex="6" size="30" value="<?php echo  $_POST['store_zone']; ?>" />
	      <label for="store_zone"><?php echo STORE_ZONE; ?></label>
		  <p><?php echo STORE_ZONE_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=41\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="text" id="store_postal_code" name="store_postal_code" tabindex="7" size="12" value="<?php echo  $_POST['store_postal_code']; ?>" />
		  <label for="store_city_town"><?php echo STORE_POSTAL_CODE; ?></label>
		  <p><?php echo STORE_POSTAL_CODE_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=91\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <select id="store_country" name="store_country" tabindex="8">
			<?php echo $country_string; ?>
		  </select>
	      <label for="store_country"><?php echo STORE_COUNTRY; ?></label>
		  <p><?php echo STORE_COUNTRY_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=40\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="text" id="store_email" name="store_email" tabindex="9"  size="30" value="<?php echo  $_POST['store_email']; ?>" />
		  <label for="store_owner_email"><?php echo STORE_OWNER_EMAIL; ?></label>
		  <p><?php echo STORE_OWNER_EMAIL_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=39\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="text" id="store_website" name="store_website" tabindex="10"  size="30" value="<?php echo  $_POST['store_website']; ?>" />
		  <label for="store_website"><?php echo STORE_WEBSITE; ?></label>
		  <p><?php echo STORE_WEBSITE_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=93\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="text" id="store_telephone1" name="store_telephone1" tabindex="11"  size="20" value="<?php echo  $_POST['store_telephone1']; ?>" />
		  <label for="store_telephone1"><?php echo STORE_TELEPHONE1; ?></label>
		  <p><?php echo STORE_TELEPHONE1_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=92\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="text" id="store_telephone2" name="store_telephone2" tabindex="12"  size="20" value="<?php echo  $_POST['store_telephone2']; ?>" />
		  <label for="store_telephone2"><?php echo STORE_TELEPHONE2; ?></label>
		  <p><?php echo STORE_TELEPHONE2_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=92\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="text" id="store_fax" name="store_fax" tabindex="13"  size="20" value="<?php echo  $_POST['store_fax']; ?>" />
		  <label for="store_fax"><?php echo STORE_FAX; ?></label>
		  <p><?php echo STORE_FAX_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=92\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
    	<div class="section">
		  <select id="store_default_currency" tabindex="15" name="store_default_currency">
			<?php echo $currency_string; ?>
		  </select>
	      <label for="store_default_currency"><?php echo STORE_DEFAULT_CURRENCY; ?></label>
		  <p><?php echo STORE_DEFAULT_CURRENCY_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=44\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
	  </fieldset>
	  <fieldset>
	    <legend><?php echo DEMO_INFORMATION; ?></legend>
		<div class="section">
		  <div class="input">
		    <input type="radio" name="demo_install" id="demo_install_yes" tabindex="16" value="true" <?php echo DEMO_INSTALL_TRUE; ?>/>
		    <label for="demo_install_yes"><?php echo YES; ?></label>
		    <input type="radio" name="demo_install" id="demo_install_no" tabindex="17" value="false" <?php echo DEMO_INSTALL_FALSE; ?>/>
		    <label for="demo_install_no"><?php echo NO; ?></label>
		  </div>
		  <span class="label"><?php echo DEMO_INSTALL; ?></span>
		  <p><?php echo DEMO_INSTALL_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=45\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
	  </fieldset>
	  <input type="submit" name="submit" class="button" tabindex="18" value="<?php echo SAVE_STORE_SETTINGS; ?>" />
    </form>