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
//  Path: /modules/accounts/pages/popup_accts/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = (int)$_SESSION['admin_id']; // for popups, just make sure they are logged in
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING . 'functions/accounts.php');

/**************   page specific initialization  *************************/
define('JOURNAL_ID',(int)$_GET['jID']);
$account_type = (isset($_GET['type']) ? $_GET['type'] : 'c');	// current types are c (customer) and v (vendor)
switch ($account_type) {
  default:
  case 'c': $terms_type = 'AR'; break;
  case 'v': $terms_type = 'AP'; break;
}

$fill = isset($_GET['fill']) ? $_GET['fill'] : 'bill';
$search_text = ($_POST['search_text']) ? db_input(db_prepare_input($_POST['search_text'])) : db_input(db_prepare_input($_GET['search_text']));
if ($search_text == TEXT_SEARCH) $search_text = '';
$action = isset($_GET['action']) ? $_GET['action'] : $_POST['todo'];
if (!$action && $search_text <> '') $action = 'search'; // if enter key pressed and search not blank

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/accounts/popup_accts/extra_actions.php';
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
	'primary_name'             => GEN_PRIMARY_NAME,
	'address1'                 => GEN_ADDRESS1,
	'city_town,state_province' => GEN_CITY_TOWN,
	'state_province,city_town' => GEN_STATE_PROVINCE,
	'postal_code'              => GEN_POSTAL_CODE,
	'telephone1'               => GEN_TELEPHONE1,
);
switch (JOURNAL_ID) {
	case  6:
	case 12: $extra_headings = array(ACT_LIST_OPEN_ORDERS); break;
	case  7:
	case 13: $extra_headings = array(ACT_LIST_OPEN_INVOICES); break;
	default: $extra_headings = array('&nbsp;'); break;
}
$result      = html_heading_bar($heading_array, $_GET['list_order'], $extra_headings);
$list_header = $result['html_code'];
$disp_order  = $result['disp_order'];

// build the list for the page selected
if (isset($search_text) && gen_not_null($search_text)) {
  $search_fields = array('c.short_name', 'a.primary_name', 'a.contact', 'a.telephone1', 'a.telephone2', 
  	'a.address1', 'a.address2', 'a.city_town', 'a.postal_code', 'c.account_number');
  // hook for inserting new search fields to the query criteria.
  if (is_array($extra_search_fields)) $search_fields = array_merge($search_fields, $extra_search_fields);
  $search = ' and (' . implode(' like \'%' . $search_text . '%\' or ', $search_fields) . ' like \'%' . $search_text . '%\')';
} else {
  $search = '';
}

$field_list = array('a.address_id', 'c.id', 'a.ref_id', 'a.type', 'a.primary_name', 'a.contact', 'a.address1', 
	'a.address2', 'a.city_town', 'a.state_province', 'a.postal_code', 'a.country_code', 'c.short_name', 
	'a.telephone1', 'a.email', 'c.first_date', 'c.last_update', 'c.gl_type_account', 'c.special_terms', 
	'c.last_date_1', 'c.last_date_2', 'c.inactive');
		
// hook to add new fields to the query return results
if (is_array($extra_query_list_fields) > 0) $field_list = array_merge($field_list, $extra_query_list_fields);

$query_raw = "select " . implode(', ', $field_list)  . " 
	from " . TABLE_CONTACTS . " c left join " . TABLE_ADDRESS_BOOK . " a on c.id = a.ref_id 
	where a.type = '" . $account_type . "m'" . $search . " order by $disp_order";

$query_split  = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
$query_result = $db->Execute($query_raw);

$include_header   = false;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = false;
$include_template = 'template_main.php';
define('PAGE_TITLE', ACT_POPUP_WINDOW_TITLE);

?>