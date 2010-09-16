<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2010 PhreeSoft, LLC                          |
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
//  Path: /my_files/custom/oscommerce/pages/admin/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_OSCOMMERCE_ADMIN];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
@include(DIR_FS_WORKING . 'config.php'); // pull the current config info, if it is there
require(DIR_FS_WORKING  . 'language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING  . 'functions/oscommerce.php'); 

/**************   page specific initialization  *************************/
$error  = false; 
$action = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

if (defined('OSCOMMERCE_URL')) { // initialize the values
  $url         = OSCOMMERCE_URL;
  $username    = OSCOMMERCE_USERNAME;
  $password    = OSCOMMERCE_PASSWORD;
  $tax_class   = OSCOMMERCE_PRODUCT_TAX_CLASS;
  $use_prices  = OSCOMMERCE_USE_PRICE_SHEETS;
  $price_sheet = OSCOMMERCE_PRICE_SHEET;
  $shipped_id  = OSCOMMERCE_STATUS_CONFIRM_ID;
  $partial_id  = OSCOMMERCE_STATUS_PARTIAL_ID;
}
/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
    // read the values
    $url         = db_prepare_input($_POST['oscommerce_url']);
    $username    = db_prepare_input($_POST['oscommerce_username']);
    $password    = db_prepare_input($_POST['oscommerce_password']);
    $tax_class   = db_prepare_input($_POST['oscommerce_tax_class']);
    $use_prices  = isset($_POST['oscommerce_use_prices']) ? '1' : '0';
    $price_sheet = isset($_POST['oscommerce_use_prices']) ? db_prepare_input($_POST['oscommerce_price_sheet']) : '';
    $shipped_id  = db_prepare_input($_POST['oscommerce_shipped_id']);
    $partial_id  = db_prepare_input($_POST['oscommerce_partial_id']);
	// pre-process 
	if (strrpos($url, '/') == strlen($url) - 1) $url = substr($url, 0, strlen($url) - 1);

	// build the constant array
	$config = array(
      'OSCOMMERCE_URL'               => $url,
      'OSCOMMERCE_USERNAME'          => $username,
      'OSCOMMERCE_PASSWORD'          => $password,
      'OSCOMMERCE_PRODUCT_TAX_CLASS' => $tax_class,
      'OSCOMMERCE_USE_PRICE_SHEETS'  => $use_prices,
      'OSCOMMERCE_PRICE_SHEET'       => $price_sheet,
      'OSCOMMERCE_STATUS_CONFIRM_ID' => $shipped_id,
      'OSCOMMERCE_STATUS_PARTIAL_ID' => $partial_id,
	);
	// write the config file to the oscommerce dir
	write_config(DIR_FS_WORKING . 'config.php', $config);
    break;
  default:
}

/*****************   prepare to display templates  *************************/
$include_header   = true;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = false;
$include_template = 'template_main.php';
define('PAGE_TITLE', BOX_OSCOMMERCE_ADMIN);

?>