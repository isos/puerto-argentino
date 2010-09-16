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
//  Path: /modules/install/templates/coa_defaults_default.php
//

?>
<p><?php echo TEXT_MAIN; ?></p>
<?php
  if ($zc_install->error) { require(DIR_WS_INSTALL_TEMPLATE . 'display_errors.php'); }
?>

    <form method="post" action="index.php?main_page=coa_defaults&language=<?php echo $language; ?>">
	  <fieldset>
	  <legend><?php echo STORE_INFORMATION; ?></legend>
		<div class="section">
	      <label for="chart_list"><?php echo COA_REFERENCE; ?></label>
		  <select size="10" id="chart_list" tabindex="19" name="chart_list" style="font-family:Courier">
            <?php echo $coa_string; ?>
		  </select>
		  <p>&nbsp;</p>
		</div>
		<div class="section">
		  <select id="ap_inventory_acct" tabindex="1" name="ap_inventory_acct">
		    <?php echo $pulldown_array[0]; ?>
	      </select>
	      <label for="ap_inventory_acct"><?php echo STORE_DEFAULT_INV_ACCT; ?></label>
		  <p><?php echo STORE_DEFAULT_INV_ACT_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=96\')">' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <select id="ap_purch_acct" tabindex="2" name="ap_purch_acct">
		    <?php echo $pulldown_array[1]; ?>
		  </select>
	      <label for="ap_purch_acct"><?php echo STORE_DEFAULT_AP_PURCH; ?></label>
		  <p><?php echo STORE_DEFAULT_AP_PURCH_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=97\')">' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <select id="ap_disc_acct" tabindex="3" name="ap_disc_acct">
		    <?php echo $pulldown_array[2]; ?>
		  </select>
	      <label for="ap_disc_acct"><?php echo STORE_DEFAULT_AP_DISC; ?></label>
		  <p><?php echo STORE_DEFAULT_AP_DISC_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=98\')">' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <select id="ap_freight_acct" tabindex="4" name="ap_freight_acct">
		    <?php echo $pulldown_array[3]; ?>
		  </select>
	      <label for="ap_freight_acct"><?php echo STORE_DEFAULT_AP_FRT; ?></label>
		  <p><?php echo STORE_DEFAULT_AP_FRT_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=99\')">' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <select id="ap_purch_payment_acct" tabindex="5" name="ap_purch_payment_acct">
		    <?php echo $pulldown_array[4]; ?>
		  </select>
	      <label for="ap_purch_payment_acct"><?php echo STORE_DEFAULT_AP_PMT; ?></label>
		  <p><?php echo STORE_DEFAULT_AP_PMT_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=100\')">' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <select id="ar_sales_acct" tabindex="6" name="ar_sales_acct">
		    <?php echo $pulldown_array[5]; ?>
		  </select>
	      <label for="ar_sales_acct"><?php echo STORE_DEFAULT_AR_SALES; ?></label>
		  <p><?php echo STORE_DEFAULT_AR_SALES_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=101\')">' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <select id="ar_recv_acct" tabindex="7" name="ar_recv_acct">
		    <?php echo $pulldown_array[6]; ?>
		  </select>
	      <label for="ar_recv_acct"><?php echo STORE_DEFAULT_AR_RCV; ?></label>
		  <p><?php echo STORE_DEFAULT_AR_RCV_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=102\')">' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <select id="ar_disc_acct" tabindex="8" name="ar_disc_acct">
		    <?php echo $pulldown_array[7]; ?>
		  </select>
	      <label for="ar_disc_acct"><?php echo STORE_DEFAULT_AR_DISC; ?></label>
		  <p><?php echo STORE_DEFAULT_AR_DISC_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=103\')">' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <select id="ar_freight_acct" tabindex="9" name="ar_freight_acct">
		    <?php echo $pulldown_array[8]; ?>
		  </select>
	      <label for="ar_freight_acct"><?php echo STORE_DEFAULT_AR_FRT; ?></label>
		  <p><?php echo STORE_DEFAULT_AR_FRT_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=104\')">' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <select id="ar_cash_rcpt_acct" tabindex="10" name="ar_cash_rcpt_acct">
		    <?php echo $pulldown_array[9]; ?>
		  </select>
	      <label for="ar_cash_rcpt_acct"><?php echo STORE_DEFAULT_AR_RCPT; ?></label>
		  <p><?php echo STORE_DEFAULT_AR_RCPT_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=105\')">' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
	  </fieldset>
	  <input type="submit" name="submit" class="button" tabindex="11" value="<?php echo SAVE_STORE_SETTINGS; ?>" />
    </form>