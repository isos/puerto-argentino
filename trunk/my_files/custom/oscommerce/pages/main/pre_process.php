<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2010 PhreeSoft, LLC                               |
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
//  Path: /my_files/custom/oscommerce/pages/main/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_OSCOMMERCE_INTERFACE];
if ($security_level == 0) { // not supposed to be here
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
@include_once(DIR_FS_WORKING . 'config.php'); // pull the current config info, if it is there
@include_once(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
 require_once(DIR_FS_MODULES . 'services/shipping/language/' . $_SESSION['language'] . '/language.php');
 require_once(DIR_FS_WORKING . 'functions/oscommerce.php'); 
 require_once(DIR_FS_MODULES . 'inventory/functions/inventory.php'); 
 require_once(DIR_FS_WORKING . 'classes/parser.php');
 require_once(DIR_FS_WORKING . 'classes/oscommerce.php'); 
 require_once(DIR_FS_WORKING . 'classes/bulk_upload.php'); 

/**************   page specific initialization  *************************/
// make sure the module is installed
if (!defined('OSCOMMERCE_URL')) {
  $messageStack->add_session(OSCOMMERCE_MOD_NOT_INSTALLED, 'caution');
  gen_redirect(html_href_link(FILENAME_DEFAULT, 'cat=oscommerce&module=admin', 'SSL'));
}

$error     = false;
$ship_date = $_POST['ship_date'] ? gen_db_date_short($_POST['ship_date']) : date('Y-m-d');
$action    = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/oscommerce/main/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'upload':
    $upXML = new oscommerce();
	$id    = db_prepare_input($_POST['rowSeq']);
	if ($upXML->submitXML($id, 'product_ul')) gen_add_audit_log(OSCOMMERCE_UPLOAD_PRODUCT, $upXML->sku);
	break;
  case 'bulkupload':
    $upXML = new bulk_upload();
    $inc_image = isset($_POST['include_images']) ? true : false;
	if ($upXML->bulkUpload($inc_image)) gen_add_audit_log(OSCOMMERCE_BULK_UPLOAD);
    break;
  case 'sync':
    $upXML = new oscommerce();
	if ($upXML->submitXML(0, 'product_sync')) gen_add_audit_log(OSCOMMERCE_PRODUCT_SYNC);
	break;
  case 'confirm':
    $upXML = new oscommerce();
	$upXML->post_date = $ship_date;
	if ($upXML->submitXML(0, 'confirm')) gen_add_audit_log(OSCOMMERCE_SHIP_CONFIRM, $ship_date);
    break;
  default:
}

/*****************   prepare to display templates  *************************/
$include_header   = true;
$include_footer   = true;
$include_calendar = true;
$include_tabs     = false;
$include_template = 'template_main.php';
define('PAGE_TITLE', BOX_OSCOMMERCE_MODULE);

?>