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
//  Path: /modules/services/pages/popup_shipping/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = (int)$_SESSION['admin_id']; // for popups, just make sure they are logged in
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files  *********************/
require(DIR_FS_WORKING . 'shipping/language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING . 'shipping/functions/shipping.php');
require(DIR_FS_WORKING . 'shipping/classes/shipping.php');

define('DEFAULT_MOD_DIR', DIR_FS_WORKING . 'shipping/modules/');
define('CUSTOM_MOD_DIR', DIR_FS_MY_FILES . 'custom/services/shipping/modules/');

/**************   page specific initialization  *************************/
$error       = false;
$pkg         = new shipment();
$module_list = load_shipping_module_list(); // load list of modules that are loaded and enabled
$action      = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/services/popup_shipping/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'rates':
	// overwrite the defaults with data from the form
	reset ($_POST);
	while (list($key, $value) = each($_POST)) $pkg->$key = db_prepare_input($value);
	// generate ISO2 codes for countries (needed by FedEx and others)
	$pkg->ship_from_country_iso2 = gen_get_country_iso_2_from_3($pkg->ship_country_code);
	$pkg->ship_to_country_iso2   = gen_get_country_iso_2_from_3($pkg->ship_to_country_code);
	// read checkboxes
	$pkg->residential_address    = isset($_POST['residential_address']) ? '1' : '0';
	$pkg->additional_handling    = isset($_POST['additional_handling']) ? '1' : '0';
	$pkg->insurance              = isset($_POST['insurance']) ? '1' : '0';
	$pkg->split_large_shipments  = isset($_POST['split_large_shipments']) ? '1' : '0';
	$pkg->delivery_confirmation  = isset($_POST['delivery_confirmation']) ? '1' : '0';
	$pkg->handling_charge        = isset($_POST['handling_charge']) ? '1' : '0';
	$pkg->cod                    = isset($_POST['cod']) ? '1' : '0';
	$pkg->saturday_pickup        = isset($_POST['saturday_pickup']) ? '1' : '0';
	$pkg->saturday_delivery      = isset($_POST['saturday_delivery']) ? '1' : '0';
	$pkg->hazardous_material     = isset($_POST['hazardous_material']) ? '1' : '0';

	// read the modules installed
	$rates = array();
	foreach ($module_list as $value) {
		if (isset($_POST['ship_method_' . $value['id']])) {
//echo 'finding rate for ' . $value['id'] . '<br />';
			if (file_exists(DEFAULT_MOD_DIR . $value['id'] . '.php')) {
				require(DEFAULT_MOD_DIR . $value['id'] . '.php');
			} else {
				require(CUSTOM_MOD_DIR . $value['id'] . '.php');
			}
			$subject = new $value['id'];
			$result = $subject->quote($pkg); // will return false if there was an error
//echo $value['id'] . ' rate array='; print_r($result); echo '<br />';
			if (is_array($result)) {
				$rates = array_merge_recursive($result, $rates);
			} else {
				$error = true;
			}
		}
	}
//echo 'Final rate array='; print_r($rates); echo '<br />';
	if ($error) $action = ''; // reload selection form
	break;

  default:
}

/*****************   prepare to display templates  *************************/

$include_header   = false;
$include_footer   = false;
$include_tabs     = false;
$include_calendar = true;

switch ($action) {
  case 'rates':
    $include_template = 'template_detail.php';
    define('PAGE_TITLE', SHIPPING_POPUP_WINDOW_RATE_TITLE);
	break;
  default:
	$currency_array = gen_get_currency_array();
    $include_template = 'template_main.php';
    define('PAGE_TITLE', SHIPPING_ESTIMATOR_OPTIONS);
}

?>