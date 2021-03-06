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
//  Path: /modules/orders/pages/inv_mgr/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_INVOICE_MGR];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING . 'functions/orders.php');

/**************   page specific initialization  *************************/
define('JOURNAL_ID', 12);
define('POPUP_FORM_TYPE','ar:inv');
$error = false;

// fill search and accounting period criteria whether it has been submited through GET or POST (can be passed either way)
$acct_period = ($_GET['search_period']) ? $_GET['search_period'] : CURRENT_ACCOUNTING_PERIOD;
$search_text = ($_POST['search_text']) ? db_input(db_prepare_input($_POST['search_text'])) : db_input(db_prepare_input($_GET['search_text']));
if ($search_text == TEXT_SEARCH) $search_text = '';
$action      = isset($_GET['action']) ? $_GET['action'] : $_POST['todo'];
if (!$action && $search_text <> '') $action = 'search'; // if enter key pressed and search not blank

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/orders/inv_mgr/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'go_first':    $_GET['page'] = 1;     break;
  case 'go_previous': $_GET['page']--;       break;
  case 'go_next':     $_GET['page']++;       break;
  case 'go_last':     $_GET['page'] = 99999; break;
  case 'search':
  case 'search_reset':
  case 'go_page':
  default:
}

/*****************   prepare to display templates  *************************/
// build the list header
if (!isset($_GET['list_order'])) $_GET['list_order'] = 'post_date-desc'; // default to descending by invoice number
$heading_array = array(
  'post_date'           => TEXT_DATE,
  'purchase_invoice_id' => TEXT_INVOICE,
  'closed'              => ORD_PAID,
  'bill_primary_name'   => GEN_PRIMARY_NAME,
  'shipper_code'        => TEXT_CARRIER,
);
$result      = html_heading_bar($heading_array, $_GET['list_order'], array(ORD_SHIPPED, TEXT_ACTION));
$list_header = $result['html_code'];
$disp_order  = $result['disp_order'];

// build the list for the page selected
$period_filter = ($acct_period == 'all') ? '' : (' and period = ' . $acct_period);
if (isset($search_text) && gen_not_null($search_text)) {
  $search_fields = array('bill_primary_name', 'purchase_invoice_id', 'purch_order_id');
  // hook for inserting new search fields to the query criteria.
  if (is_array($extra_search_fields)) $search_fields = array_merge($search_fields, $extra_search_fields);
  $search = ' and (' . implode(' like \'%' . $search_text . '%\' or ', $search_fields) . ' like \'%' . $search_text . '%\')';
} else {
  $search = '';
}

$field_list = array('id', 'post_date', 'shipper_code', 'purchase_invoice_id', 'closed', 'bill_primary_name', 'journal_id');
		
// hook to add new fields to the query return results
if (is_array($extra_query_list_fields) > 0) $field_list = array_merge($field_list, $extra_query_list_fields);

$query_raw = "select " . implode(', ', $field_list) . " from " . TABLE_JOURNAL_MAIN . " 
		where journal_id = " . JOURNAL_ID . $period_filter . $search . " order by $disp_order, purchase_invoice_id DESC";

$query_split  = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
$query_result = $db->Execute($query_raw);

$include_header   = true;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = true;
$include_template = 'template_main.php';
define('PAGE_TITLE', BOX_AR_INVOICE_MGR);

?>