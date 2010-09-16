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
//  Path: /modules/install/pages/coa_defaults/header_php.php
//

  $zc_install->error = false;

  session_start();
  if (isset($_SESSION['company'])) {
	define('DB_DATABASE',$_SESSION['company']);
	define('DB_SERVER',$_SESSION['db_server']);
	define('DB_SERVER_USERNAME',$_SESSION['db_user']);
	define('DB_SERVER_PASSWORD',$_SESSION['db_pw']);
  } else {
	die("Unknown company database name");
  }
  require('../../includes/configure.php');
  if (!defined('DB_TYPE') || DB_TYPE=='') {
    echo('Database Type Invalid. Did your configure.php file get written correctly?');
    $zc_install->error = true;
  }

  $db->Connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE) or die("Unable to connect to database");

  if (isset($_POST['submit'])) {
    $ap_inventory_acct = db_prepare_input($_POST['ap_inventory_acct']);
    $ap_purch_acct = db_prepare_input($_POST['ap_purch_acct']);
    $ap_disc_acct = db_prepare_input($_POST['ap_disc_acct']);
    $ap_freight_acct = db_prepare_input($_POST['ap_freight_acct']);
    $ap_purch_payment_acct = db_prepare_input($_POST['ap_purch_payment_acct']);
    $ar_sales_acct = db_prepare_input($_POST['ar_sales_acct']);
    $ar_recv_acct = db_prepare_input($_POST['ar_recv_acct']);
    $ar_disc_acct = db_prepare_input($_POST['ar_disc_acct']);
    $ar_freight_acct = db_prepare_input($_POST['ar_freight_acct']);
    $ar_cash_rcpt_acct = db_prepare_input($_POST['ar_cash_rcpt_acct']);
 
    if ($zc_install->error == false) {
	  $db->updateConfigureValue('AP_DEFAULT_INVENTORY_ACCOUNT', $ap_inventory_acct);
	  $db->updateConfigureValue('AP_DEFAULT_PURCHASE_ACCOUNT', $ap_purch_acct);
	  $db->updateConfigureValue('AP_DISCOUNT_PURCHASE_ACCOUNT', $ap_disc_acct);
	  $db->updateConfigureValue('AP_DEF_FREIGHT_ACCT', $ap_freight_acct);
	  $db->updateConfigureValue('AP_PURCHASE_INVOICE_ACCOUNT', $ap_purch_payment_acct);
	  $db->updateConfigureValue('AR_DEF_GL_SALES_ACCOUNT', $ar_sales_acct);
	  $db->updateConfigureValue('AR_DEFAULT_GL_ACCT', $ar_recv_acct);
	  $db->updateConfigureValue('AR_DISCOUNT_SALES_ACCOUNT', $ar_disc_acct);
	  $db->updateConfigureValue('AR_DEF_FREIGHT_ACCOUNT', $ar_freight_acct);
	  $db->updateConfigureValue('AR_SALES_RECEIPTS_ACCOUNT', $ar_cash_rcpt_acct);
	  // now take a best guess for the inventory accounts, can be changed later
	  $db->updateConfigureValue('INV_STOCK_DEFAULT_SALES',best_acct_guess(30,TEXT_SALES,'INV_STOCK_DEFAULT_SALES'));
	  $db->updateConfigureValue('INV_STOCK_DEFAULT_INVENTORY',best_acct_guess(4,TEXT_INVENTORY,'INV_STOCK_DEFAULT_INVENTORY'));
	  $db->updateConfigureValue('INV_STOCK_DEFAULT_COS',best_acct_guess(32,TEXT_COGS,'INV_STOCK_DEFAULT_COS'));
	  $db->updateConfigureValue('INV_MASTER_STOCK_DEFAULT_SALES',best_acct_guess(30,TEXT_SALES,'INV_MASTER_STOCK_DEFAULT_SALES'));
	  $db->updateConfigureValue('INV_MASTER_STOCK_DEFAULT_INVENTORY',best_acct_guess(4,TEXT_INVENTORY,'INV_MASTER_STOCK_DEFAULT_INVENTORY'));
	  $db->updateConfigureValue('INV_MASTER_STOCK_DEFAULT_COS',best_acct_guess(32,TEXT_COGS,'INV_MASTER_STOCK_DEFAULT_COS'));
	  $db->updateConfigureValue('INV_ASSY_DEFAULT_SALES',best_acct_guess(30,TEXT_SALES,'INV_ASSY_DEFAULT_SALES'));
	  $db->updateConfigureValue('INV_ASSY_DEFAULT_INVENTORY',best_acct_guess(4,TEXT_INVENTORY,'INV_ASSY_DEFAULT_INVENTORY'));
	  $db->updateConfigureValue('INV_ASSY_DEFAULT_COS',best_acct_guess(32,TEXT_COGS,'INV_ASSY_DEFAULT_COS'));
	  $db->updateConfigureValue('INV_SERIALIZE_DEFAULT_SALES',best_acct_guess(30,TEXT_SALES,'INV_SERIALIZE_DEFAULT_SALES'));
	  $db->updateConfigureValue('INV_SERIALIZE_DEFAULT_INVENTORY',best_acct_guess(4,TEXT_INVENTORY,'INV_SERIALIZE_DEFAULT_INVENTORY'));
	  $db->updateConfigureValue('INV_SERIALIZE_DEFAULT_COS',best_acct_guess(32,TEXT_COGS,'INV_SERIALIZE_DEFAULT_COS'));
	  $db->updateConfigureValue('INV_NON_STOCK_DEFAULT_SALES',best_acct_guess(30,TEXT_SALES,'INV_NON_STOCK_DEFAULT_SALES'));
	  $db->updateConfigureValue('INV_NON_STOCK_DEFAULT_INVENTORY',best_acct_guess(4,TEXT_INVENTORY,'INV_NON_STOCK_DEFAULT_INVENTORY'));
	  $db->updateConfigureValue('INV_NON_STOCK_DEFAULT_COS',best_acct_guess(32,TEXT_COGS,'INV_NON_STOCK_DEFAULT_COS'));
	  $db->updateConfigureValue('INV_SERVICE_DEFAULT_SALES',best_acct_guess(30,TEXT_SALES,'INV_SERVICE_DEFAULT_SALES'));
	  $db->updateConfigureValue('INV_SERVICE_DEFAULT_INVENTORY',best_acct_guess(4,TEXT_INVENTORY,'INV_SERVICE_DEFAULT_INVENTORY'));
	  $db->updateConfigureValue('INV_SERVICE_DEFAULT_COS',best_acct_guess(32,TEXT_COGS,'INV_SERVICE_DEFAULT_COS'));
	  $db->updateConfigureValue('INV_LABOR_DEFAULT_SALES',best_acct_guess(30,TEXT_SALES,'INV_LABOR_DEFAULT_SALES'));
	  $db->updateConfigureValue('INV_LABOR_DEFAULT_INVENTORY',best_acct_guess(4,TEXT_INVENTORY,'INV_LABOR_DEFAULT_INVENTORY'));
	  $db->updateConfigureValue('INV_LABOR_DEFAULT_COS',best_acct_guess(32,TEXT_COGS,'INV_LABOR_DEFAULT_COS'));
	  $db->updateConfigureValue('INV_SERIALIZE_DEFAULT_SALES',best_acct_guess(30,TEXT_SALES,'INV_SERIALIZE_DEFAULT_SALES'));
	  $db->updateConfigureValue('INV_SERIALIZE_DEFAULT_INVENTORY',best_acct_guess(4,TEXT_INVENTORY,'INV_SERIALIZE_DEFAULT_INVENTORY'));
	  $db->updateConfigureValue('INV_SERIALIZE_DEFAULT_COS',best_acct_guess(32,TEXT_COGS,'INV_SERIALIZE_DEFAULT_COS'));

      $db->Close();
      header('location: index.php?main_page=finished&language=' . $language);
      exit();
    }
  }

  //if not submit, set some defaults
  $type_array = array();
  $result = $db->Execute("select id, description, account_type from " . DB_PREFIX . "chart_of_accounts order by id");
  $max_id = 0;
  $max_desc = 0;
  $max_type = 0;
  while (!$result->EOF) {
  	$type = $result->fields['account_type'];
  	$type_array[$type] = load_acct_type_desc($type);
  	if (strlen($result->fields['id']) > $max_id) $max_id = strlen($result->fields['id']);
  	if (strlen($result->fields['description']) > $max_desc) $max_desc = strlen($result->fields['description']);
  	if (strlen($type_array[$type]) > $max_type) $max_type = strlen($type_array[$type]);
    $result->MoveNext();
  }
  $coa_string = '';
  $result->Move(0);
  $result->MoveNext();
  while (!$result->EOF) {
    $tabbed_list = str_pad($result->fields['id'],$max_id) . ' | ' . str_pad($result->fields['description'],$max_desc) . ' | ' . str_pad($type_array[$result->fields['account_type']],$max_type);
	$tabbed_list = str_replace(' ','&nbsp;',$tabbed_list);
    $coa_string .= '<option value="' . $result->fields['id'] . '">' . $tabbed_list . '</option>';
    $result->MoveNext();
  }

  $pulldown_array = array();
  $pulldown_array[] = smart_acct_list(4,TEXT_INVENTORY,'AP_DEFAULT_INVENTORY_ACCOUNT');
  $pulldown_array[] = smart_acct_list(20,TEXT_PAYABLE,'AP_DEFAULT_PURCHASE_ACCOUNT');
  $pulldown_array[] = smart_acct_list(30,TEXT_PURCHASE_DISCOUNT,'AP_DISCOUNT_PURCHASE_ACCOUNT');
  $pulldown_array[] = smart_acct_list(34,ORD_FREIGHT,'AP_DEF_FREIGHT_ACCT');
  $pulldown_array[] = smart_acct_list(0,TEXT_CHECKING,'AP_PURCHASE_INVOICE_ACCOUNT');
  $pulldown_array[] = smart_acct_list(30,TEXT_SALES,'AR_DEF_GL_SALES_ACCOUNT');
  $pulldown_array[] = smart_acct_list(2,TEXT_RECEIVABLES,'AR_DEFAULT_GL_ACCT');
  $pulldown_array[] = smart_acct_list(30,TEXT_SALES_DISCOUNT,'AR_DISCOUNT_SALES_ACCOUNT');
  $pulldown_array[] = smart_acct_list(30,ORD_FREIGHT,'AR_DEF_FREIGHT_ACCOUNT');
  $pulldown_array[] = smart_acct_list(0,TEXT_CHECKING,'AR_SALES_RECEIPTS_ACCOUNT');

  $db->Close();

// this sets the first field to email address on login - setting in /common/tpl_main_page.php
  $zc_first_field= 'onload="document.getElementById(\'ap_inventory_acct\').focus()"';
?>