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
//  Path: /modules/zencart/pages/admin/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_ZENCART_ADMIN];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
@include(DIR_FS_WORKING . 'config.php'); // pull the current config info, if it is there
require(DIR_FS_WORKING  . 'language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING  . 'functions/zencart.php'); 

/**************   page specific initialization  *************************/
$error  = false; 
$action = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

if (defined('ZENCART_URL')) { // initialize the values
  $url         = ZENCART_URL;
  $username    = ZENCART_USERNAME;
  $password    = ZENCART_PASSWORD;
  $tax_class   = ZENCART_PRODUCT_TAX_CLASS;
  $use_prices  = ZENCART_USE_PRICE_SHEETS;
  $price_sheet = ZENCART_PRICE_SHEET;
  $shipped_id  = ZENCART_STATUS_CONFIRM_ID;
  $partial_id  = ZENCART_STATUS_PARTIAL_ID;
}
/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
    // read the values
    $url         = db_prepare_input($_POST['zencart_url']);
    $username    = db_prepare_input($_POST['zencart_username']);
    $password    = db_prepare_input($_POST['zencart_password']);
    $tax_class   = db_prepare_input($_POST['zencart_tax_class']);
    $use_prices  = isset($_POST['zencart_use_prices']) ? '1' : '0';
    $price_sheet = isset($_POST['zencart_use_prices']) ? db_prepare_input($_POST['zencart_price_sheet']) : '';
    $shipped_id  = db_prepare_input($_POST['zencart_shipped_id']);
    $partial_id  = db_prepare_input($_POST['zencart_partial_id']);
	// pre-process 
	if (strrpos($url, '/') == strlen($url) - 1) $url = substr($url, 0, strlen($url) - 1);

	// build the constant array
	$config = array(
      'ZENCART_URL'               => $url,
      'ZENCART_USERNAME'          => $username,
      'ZENCART_PASSWORD'          => $password,
      'ZENCART_PRODUCT_TAX_CLASS' => $tax_class,
      'ZENCART_USE_PRICE_SHEETS'  => $use_prices,
      'ZENCART_PRICE_SHEET'       => $price_sheet,
      'ZENCART_STATUS_CONFIRM_ID' => $shipped_id,
      'ZENCART_STATUS_PARTIAL_ID' => $partial_id,
	);
	// write the config file to the zencart dir
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
define('PAGE_TITLE', BOX_ZENCART_ADMIN);

?>