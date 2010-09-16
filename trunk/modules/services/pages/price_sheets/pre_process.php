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
//  Path: /modules/services/pages/price_sheets/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_PRICE_SHEET_MANAGER];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'pricesheets/language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'inventory/language/'   . $_SESSION['language'] . '/language.php');

/**************   page specific initialization  *************************/
$search_text = ($_POST['search_text']) ? db_input(db_prepare_input($_POST['search_text'])) : db_input(db_prepare_input($_GET['search_text']));
if ($search_text == TEXT_SEARCH) $search_text = '';
$action = isset($_GET['action']) ? $_GET['action'] : $_POST['todo'];
if (!$action && $search_text <> '') $action = 'search'; // if enter key pressed and search not blank

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/services/price_sheets/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
  case 'update':
	if ($security_level < 2) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$id             = db_prepare_input($_POST['id']);
	$sheet_name     = db_prepare_input($_POST['sheet_name']);
	$revision       = db_prepare_input($_POST['revision']);
	$effective_date = gen_db_date_short($_POST['effective_date']);
	$default_sheet  = isset($_POST['default_sheet']) ? 1 : 0;
	$encoded_prices = array();
	for ($i=0, $j=1; $i < MAX_NUM_PRICE_LEVELS; $i++, $j++) {
		$price   = $currencies->clean_value(db_prepare_input($_POST['price_'   . $j]));
		$adj     = db_prepare_input($_POST['adj_' . $j]);
		$adj_val = $currencies->clean_value(db_prepare_input($_POST['adj_val_' . $j]));
		$rnd     = db_prepare_input($_POST['rnd_' . $j]);
		$rnd_val = $currencies->clean_value(db_prepare_input($_POST['rnd_val_' . $j]));
		$level_data = ($_POST['price_' . $j]) ? $price : '0';
		$level_data .= ':' . db_prepare_input($_POST['qty_' . $j]);
		$level_data .= ':' . db_prepare_input($_POST['src_' . $j]);
		$level_data .= ':' . ($_POST['adj_' . $j]     ? $adj     : '0');
		$level_data .= ':' . ($_POST['adj_val_' . $j] ? $adj_val : '0');
		$level_data .= ':' . ($_POST['rnd_' . $j]     ? $rnd     : '0');
		$level_data .= ':' . ($_POST['rnd_val_' . $j] ? $rnd_val : '0');
		$encoded_prices[] = $level_data;
	}
	$default_levels = implode(';', $encoded_prices);
	// Check for duplicate price sheet names
	if ($action == 'save') {
		$result = $db->Execute("select id from " . TABLE_PRICE_SHEETS . " where sheet_name = '" . $sheet_name . "'");
		if ($result->RecordCount() > 0) {
			$messageStack->add(SRVCS_DUPLICATE_SHEET_NAME,'error');
			$effective_date = gen_spiffycal_db_date_short($effective_date);
			$action = 'new';
			break;
		}
	}

	// Reset all other price sheet default flags if set to this price sheet
	if ($default_sheet) {
		$db->Execute("update " . TABLE_PRICE_SHEETS . " 
			set default_sheet = '0' 
			where sheet_name <> '" . $sheet_name . "'");
	}

	$sql = ($action == 'save') ? 'insert into ' : 'update ';
	$sql .= TABLE_PRICE_SHEETS . " set 
		sheet_name = '" . $sheet_name . "', 
		revision = '" . $revision . "', 
		effective_date = '" . $effective_date . "', 
		default_sheet = '" . $default_sheet . "', 
		default_levels = '" . $default_levels . "'";
	$sql .= ($action == 'save') ? '' : ' where id = ' . $id;
	$result = $db->Execute($sql);

	// Set all price sheets with this name to default
	if ($default_sheet) {
		$db->Execute("update " . TABLE_PRICE_SHEETS . " 
			set default_sheet = '1' 
			where sheet_name = '" . $sheet_name . "'");
	}

	// set expiration date of previous rev if there is a older rev of this price sheet
	if ($effective_date <> '') {
		$db->Execute("update " . TABLE_PRICE_SHEETS . " 
			set expiration_date = '" . gen_specific_date($effective_date, -1) . "' 
			where sheet_name = '" . $sheet_name . "' and revision = " . ($revision-1));
	}
	gen_add_audit_log(PRICE_SHEETS_LOG . ($action == 'save') ? TEXT_SAVE : TEXT_UPDATE, $sheet_name);
	gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('psID', 'action')), 'SSL'));
	break;

  case 'delete':
	if ($security_level < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$id = (int)db_prepare_input($_GET['psID']);
	$result = $db->Execute("select sheet_name from " . TABLE_PRICE_SHEETS . " where id = " . $id);
	$sheet_name = $result->fields['sheet_name'];
// TBD check to see if this is the default if so, remind to pick another
	$db->Execute("delete from " . TABLE_PRICE_SHEETS . " where id = '" . $id . "'");
// TBD delete special pricing
	gen_add_audit_log(PRICE_SHEETS_LOG . TEXT_DELETE, $sheet_name);
	gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('psID', 'action')), 'SSL'));
	break;

  case 'revise':
	if ($security_level < 2) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$id = db_prepare_input($_GET['psID']);
	$result = $db->Execute("select * from " . TABLE_PRICE_SHEETS . " where id = " . $id);
	$old_rev = (int)$result->fields['revision'];
	$output_array = array(
		'sheet_name'     => $result->fields['sheet_name'],
		'revision'       => $result->fields['revision'] + 1,
		'effective_date' => $result->fields['expiration_date'],
		'default_sheet'  => $result->fields['default_sheet'],
		'default_levels' => $result->fields['default_levels'],
	);
	db_perform(TABLE_PRICE_SHEETS, $output_array, 'insert');
	$sheet_id = db_insert_id();
	// Copy special pricing information to new sheet
	$levels = $db->Execute("select inventory_id, price_levels from " . TABLE_INVENTORY_SPECIAL_PRICES . " 
			where price_sheet_id = " . $id);
	while (!$levels->EOF){
		$db->Execute("insert into " . TABLE_INVENTORY_SPECIAL_PRICES . " set 
			inventory_id = "   . $levels->fields['inventory_id'] . ", 
			price_sheet_id = " . $sheet_id . ", 
			price_levels = '"  . $levels->fields['price_levels'] . "'");
		$levels->MoveNext();
	}
	gen_add_audit_log(PRICE_SHEETS_LOG . TEXT_REVISE, $result->fields['sheet_name'] . ' Rev. ' . $old_rev . ' => ' . ($old_rev + 1));
	$action = '';
	break;
  case 'edit':
	$id             = db_prepare_input($_POST['rowSeq']);
	$result         = $db->Execute("select * from " . TABLE_PRICE_SHEETS . " where id = " . $id);
	$sheet_name     = $result->fields['sheet_name'];
	$revision       = $result->fields['revision'];
	$effective_date = gen_spiffycal_db_date_short($result->fields['effective_date']);
	$default_sheet  = ($result->fields['default_sheet']) ? '1' : '0';
	$default_levels = $result->fields['default_levels'];
	break;
  case 'go_first':    $_GET['page'] = 1;     break;
  case 'go_previous': $_GET['page']--;       break;
  case 'go_next':     $_GET['page']++;       break;
  case 'go_last':     $_GET['page'] = 99999; break;
  case 'search':
  case 'search_reset':
  case 'go_page':
  case 'new':
  default:
}

/*****************   prepare to display templates  *************************/

$include_header   = true;
$include_footer   = true;
$include_tabs     = true;
$include_calendar = true;

switch ($action) {
  case 'new':
  case 'edit':
    $include_template = 'template_detail.php';
    define('PAGE_TITLE', ($action == 'new') ? PRICE_SHEET_NEW_TITLE : PRICE_SHEET_EDIT_TITLE);
	break;

  default:
	$heading_array = array(
		'sheet_name'      => TEXT_SHEET_NAME,
		'inactive'        => TEXT_INACTIVE,
		'revision'        => TEXT_REVISION,
		'default_sheet'   => TEXT_DEFAULT,
		'effective_date'  => TEXT_EFFECTIVE_DATE,
		'expiration_date' => TEXT_EXPIRATION_DATE,
	);
	$result = html_heading_bar($heading_array, $_GET['list_order'], array(TEXT_SPECIAL_PRICING, TEXT_ACTION));
	$list_header = $result['html_code'];
	$disp_order = $result['disp_order'];

	// find the highest rev level by sheet name
	$result = $db->Execute("select distinct sheet_name, max(revision) as rev from " . TABLE_PRICE_SHEETS . " group by sheet_name");
	$rev_levels = array();
	while(!$result->EOF) {
		$rev_levels[$result->fields['sheet_name']] = $result->fields['rev'];
		$result->MoveNext();
	}

	// build the list for the page selected
	if (isset($search_text) && gen_not_null($search_text)) {
	  $search_fields = array('sheet_name', 'revision');
	  // hook for inserting new search fields to the query criteria.
	  if (is_array($extra_search_fields)) $search_fields = array_merge($search_fields, $extra_search_fields);
	  $search = ' where ' . implode(' like \'%' . $search_text . '%\' or ', $search_fields) . ' like \'%' . $search_text . '%\'';
	} else {
	  $search = '';
	}
	
	$field_list = array('id', 'inactive', 'sheet_name', 'revision', 'effective_date', 'expiration_date', 'default_sheet');
	
	// hook to add new fields to the query return results
	if (is_array($extra_query_list_fields) > 0) $field_list = array_merge($field_list, $extra_query_list_fields);
	
	$query_raw = "select " . implode(', ', $field_list)  . " from " . TABLE_PRICE_SHEETS . $search . " order by $disp_order";
	
	$query_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
	$query_result = $db->Execute($query_raw);

    $include_template = 'template_main.php';
    define('PAGE_TITLE', PRICE_SHEET_HEADING_TITLE);
}

?>