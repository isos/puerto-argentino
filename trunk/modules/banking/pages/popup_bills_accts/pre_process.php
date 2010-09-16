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
//  Path: /modules/banking/pages/popup_bills_accts/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = (int)$_SESSION['admin_id']; // for popups, just make sure they are logged in
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING . 'functions/banking.php');

/**************   page specific initialization  *************************/
define('JOURNAL_ID',   $_GET['jID']);
define('ACCOUNT_TYPE', $_GET['type']);

switch (JOURNAL_ID) {
	default:
	case 18: 
		$terms_type = 'AR';
		$default_purchase_invoice_id = 'DP' . date('Ymd', time());
		break;
	case 20: 
		$terms_type = 'AP';
		$result = $db->Execute("select next_check_num from " . TABLE_CURRENT_STATUS);
		$default_purchase_invoice_id = $result->fields['next_check_num'];
		break;
	default: die ('Bad Journal id in modules/banking/popup.php');
}

$search_text = ($_POST['search_text']) ? db_input(db_prepare_input($_POST['search_text'])) : db_input(db_prepare_input($_GET['search_text']));
if ($search_text == TEXT_SEARCH) $search_text = '';
$action = isset($_GET['action']) ? $_GET['action'] : $_POST['todo'];
if (!$action && $search_text <> '') $action = 'search'; // if enter key pressed and search not blank

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/accounts/popup_bills_accts/extra_actions.php';
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
// generate address arrays for javascript
$js_arrays = gen_build_acct_arrays();

// build the list header
$heading_array = array(
	'm.bill_primary_name'                     => GEN_PRIMARY_NAME,
	'm.bill_city_town, m.bill_state_province' => GEN_CITY_TOWN,
	'm.bill_state_province, m.bill_city_town' => GEN_STATE_PROVINCE,
	'm.postal_code'                           => GEN_POSTAL_CODE,
	'total_amount'                            => TEXT_BALANCE . (ENABLE_MULTI_CURRENCY ? ' (' . DEFAULT_CURRENCY . ')' : ''));
$result      = html_heading_bar($heading_array, $_GET['list_order'], array());
$list_header = $result['html_code'];
$disp_order  = $result['disp_order'];

// build the list for the page selected
if (isset($search_text) && gen_not_null($search_text)) {
  $search_fields = array('c.short_name', 'm.bill_primary_name', 'm.bill_contact', 'm.bill_address1', 
    'm.bill_address2', 'm.bill_city_town', 'm.bill_postal_code', 'm.purchase_invoice_id');
  // hook for inserting new search fields to the query criteria.
  if (is_array($extra_search_fields)) $search_fields = array_merge($search_fields, $extra_search_fields);
  $search = ' and (' . implode(' like \'%' . $search_text . '%\' or ', $search_fields) . ' like \'%' . $search_text . '%\')';
} else {
  $search = '';
}

$field_list = array('m.bill_acct_id', 'm.bill_primary_name', 'm.bill_city_town', 
	'm.bill_state_province', 'm.bill_postal_code', 'sum(m.total_amount) as ztotal_amount');
		
// hook to add new fields to the query return results
if (is_array($extra_query_list_fields) > 0) $field_list = array_merge($field_list, $extra_query_list_fields);

$query_raw = "select " . implode(', ', $field_list) . " 
	from " . TABLE_JOURNAL_MAIN . " m inner join " . TABLE_CONTACTS . " c on m.bill_acct_id = c.id
	where c.type = '" . (ACCOUNT_TYPE == 'v' ? 'v' : 'c') . "' 
	and m.journal_id in " . (ACCOUNT_TYPE == 'v' ? '(6, 7)' : '(12, 13)') . " and m.closed = '0'" . $search . " 
	group by m.bill_acct_id order by $disp_order";

$query_split  = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
$query_result = $db->Execute($query_raw);

$include_header   = false;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = false;
$include_template = 'template_main.php';
define('PAGE_TITLE', constant('BNK_' . JOURNAL_ID . '_' . strtoupper(ACCOUNT_TYPE) . '_WINDOW_TITLE'));

?>