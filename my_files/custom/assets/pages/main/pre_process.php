<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2008 PhreeSoft, LLC                               |
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
//  Path: /modules/assets/pages/main/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ASSET_MGT];
if ($security_level == 0) { // not supposed to be here
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
//require(DIR_FS_WORKING . 'functions/assets.php');

require(DIR_FS_MODULES . 'inventory/functions/inventory.php');
/**************   page specific initialization  *************************/
// make sure the module is installed
$result = $db->Execute("SHOW TABLES LIKE '" . TABLE_ASSETS . "'");
if ($result->RecordCount() == 0) {
  $messageStack->add_session(ASSET_MGR_NOT_INSTALLED,'caution');
  gen_redirect(html_href_link(FILENAME_DEFAULT, 'cat=assets&module=admin', 'SSL'));
}

$error = false;
$processed = false;

$action = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/assets/main/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'new':
	$asset = '';
	$cInfo = '';
	break;

  case 'create':
	require(DIR_FS_MODULES . 'install/functions/install.php');
	if ($security_level < 2) {
		$messageStack->add_session(ERROR_NO_PERMISSION, 'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$asset_id = db_prepare_input($_POST['asset_id']);
	$asset_type = db_prepare_input($_POST['asset_type']);
	if (!$asset_id) {
		$messageStack->add(ASSETS_ERROR_SKU_BLANK, 'error');
		$action = 'new';
		break;
	}
	if (gen_validate_sku($asset_id)) {
		$messageStack->add(ASSETS_ERROR_DUPLICATE_SKU, 'error');
		$action = 'new';
		break;
	}

	$sql_data_array = array(
		'asset_id' => $asset_id,
		'asset_type' => $asset_type,
		'acquisition_date' => 'now()');
	switch ($asset_type) {
	  case 'vh':
		$sql_data_array['account_asset'] = best_acct_guess(8,TEXT_VEHICLE,'');
		$sql_data_array['account_depreciation'] = best_acct_guess(10,TEXT_VEHICLE,'');
		$sql_data_array['account_maintenance'] = best_acct_guess(34,TEXT_VEHICLE,'');
		break;
	  case 'bd':
		$sql_data_array['account_asset'] = best_acct_guess(8,TEXT_BUILDING,'');
		$sql_data_array['account_depreciation'] = best_acct_guess(10,TEXT_BUILDING,'');
		$sql_data_array['account_maintenance'] = best_acct_guess(34,TEXT_BUILDING,'');
		break;
	  case 'fn':
		$sql_data_array['account_asset'] = best_acct_guess(8,TEXT_FURNITURE,'');
		$sql_data_array['account_depreciation'] = best_acct_guess(10,TEXT_FURNITURE,'');
		$sql_data_array['account_maintenance'] = best_acct_guess(34,TEXT_FURNITURE,'');
		break;
	  case 'pc':
		$sql_data_array['account_asset'] = best_acct_guess(8,TEXT_COMPUTER,'');
		$sql_data_array['account_depreciation'] = best_acct_guess(10,TEXT_COMPUTER,'');
		$sql_data_array['account_maintenance'] = best_acct_guess(34,TEXT_COMPUTER,'');
		break;
	  case 'ld':
		$sql_data_array['account_asset'] = best_acct_guess(8,TEXT_LAND,'');
		$sql_data_array['account_depreciation'] = best_acct_guess(10,TEXT_LAND,'');
		$sql_data_array['account_maintenance'] = best_acct_guess(34,TEXT_LAND,'');
		break;
	  case 'sw':
		$sql_data_array['account_asset'] = best_acct_guess(8,TEXT_SOFTWARE,'');
		$sql_data_array['account_depreciation'] = best_acct_guess(10,TEXT_SOFTWARE,'');
		$sql_data_array['account_maintenance'] = best_acct_guess(34,TEXT_SOFTWARE,'');
		break;
	}
	db_perform(TABLE_ASSETS, $sql_data_array, 'insert');
	$id = db_insert_id();
	gen_add_audit_log(AESSETS_LOG_ASSETS . TEXT_ADD, 'Type: ' . $asset_type . ' - ' . $asset_id);
	gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('cID', 'action', 'page')) . 'cID=' . $id . '&action=edit', 'SSL'));
	break;

  case 'delete':
	if ($security_level < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$id = db_prepare_input($_GET['cID']);
	$result = $db->Execute("select asset_id, asset_type from " . TABLE_ASSETS . " where id = " . $id);
	$asset_id = $result->fields['asset_id'];
	$asset_type = $result->fields['asset_type'];

	$sql = "select id from " . TABLE_JOURNAL_ITEM . " where asset_id = '" . $asset_id . "' limit 1";
	$result = $db->Execute($sql);
	if ($result->Recordcount() == 0) {
		$db->Execute("delete from " . TABLE_ASSETS . " where id = " . $id);
		if ($asset_type == 'ms') {
			$db->Execute("delete from " . TABLE_ASSETS . " where asset_id like '" . $asset_id . "-%'");
		}
// TBD delete the pictures if they exists
		gen_add_audit_log(AESSETS_LOG_ASSETS . TEXT_DELETE, $asset_id);
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('cID', 'action')), 'SSL'));
	} else {
		$messageStack->add(ASSETS_ERROR_CANNOT_DELETE, 'error');
	}
	break;

  case 'save':
	if ($security_level < 3) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$id = (int)db_prepare_input($_POST['rowSeq']);
	$asset_id = db_prepare_input($_POST['asset_id']);
	$image_with_path = db_prepare_input($_POST['image_with_path']); // the current image name with path relative from my_files/company_db/asset/images directory
	$asset_path = db_prepare_input($_POST['asset_path']);
	if (substr($asset_path, 0, 1) == '/') $asset_path = substr($asset_path, 1); // remove leading '/' if there
	if (substr($asset_path, -1, 1) == '/') $asset_path = substr($asset_path, 0, strlen($asset_path)-1); // remove trailing '/' if there
	$asset_type = db_prepare_input($_POST['asset_type']);
	$sql_data_array = array();
	$asset_fields = $db->Execute("select field_name, entry_type from " . TABLE_ASSETS_FIELDS);
	while (!$asset_fields->EOF) {
		$field_name = $asset_fields->fields['field_name'];
		if (!isset($_POST[$field_name]) && $asset_fields->fields['entry_type'] == 'check_box') {
			$sql_data_array[$field_name] = '0'; // special case for unchecked check boxes
		} elseif (isset($_POST[$field_name]) && $field_name <> 'id') {
			$sql_data_array[$field_name] = db_prepare_input($_POST[$field_name]);
		}
		if ($asset_fields->fields['entry_type'] == 'date_time') {
			$sql_data_array[$field_name] = ($sql_data_array[$field_name]) ? gen_db_date_short($sql_data_array[$field_name]) : '';
		}
		$asset_fields->MoveNext();
	}
	// special cases for checkboxes of system fields (don't return a POST value if unchecked)
	$remove_image = $_POST['remove_image'] == '1' ? true : false;
	unset($sql_data_array['remove_image']); // this is not a db field, just an action
	$sql_data_array['inactive'] = ($sql_data_array['inactive'] == '1' ? '1' : '0');
	// special cases for monetary values in system fields
	$sql_data_array['full_price'] = $currencies->clean_value($sql_data_array['full_price']);
	$sql_data_array['asset_cost'] = $currencies->clean_value($sql_data_array['asset_cost']);

	// TBD - validate input

	if ($remove_image) { // update the image with relative path
		$_POST['image_with_path'] = '';
		$sql_data_array['image_with_path'] = ''; 
// TBD retrieve image with path info and delete image from my_files (no delete, warn only if image also pointed to by another SKU)
	}

	if (!$error && is_uploaded_file($_FILES['asset_image']['tmp_name'])) {
// TBD first check to see if the image was moved from a different directory... if so, delete it
		$file_path = DIR_FS_MY_FILES . $_SESSION['company'] . '/asset/images';
        $asset_path = str_replace('\\', '/', $asset_path);
		// strip beginning and trailing slashes if present
		if (substr($asset_path, -1, 1) == '/') $asset_path = substr($asset_path, 0, -1);
		if (substr($asset_path, 0, 1) == '/') $asset_path = substr($asset_path, 1);
		if ($asset_path) $file_path .= '/' . $asset_path;

		$temp_file_name = $_FILES['asset_image']['tmp_name'];
		$file_name = $_FILES['asset_image']['name'];
		if (!validate_path($file_path)) {
			$messageStack->add(ASSETS_IMAGE_PATH_ERROR, 'error');
			$error = true;
		} elseif (!validate_upload('asset_image', 'image', 'jpg')) {
			$messageStack->add(ASSETS_IMAGE_FILE_TYPE_ERROR, 'error');
			$error = true;
		} else { // passed all test, write file
			if (!copy($temp_file_name, $file_path . '/' . $file_name)) {
				$messageStack->add(ASSETS_IMAGE_FILE_WRITE_ERROR, 'error');
				$error = true;
			} else {
				$image_with_path = ($asset_path ? ($asset_path . '/') : '') . $file_name;
				$_POST['image_with_path'] = $image_with_path;
				$sql_data_array['image_with_path'] = $image_with_path; // update the image with relative path
			}
		}
	}

	// Ready to write update
	if (!$error) {
		db_perform(TABLE_ASSETS, $sql_data_array, 'update', "id = " . $id);
		gen_add_audit_log(AESSETS_LOG_ASSETS . TEXT_UPDATE, $asset_id . ' - ' . $sql_data_array['description_short']);
	} else if ($error == true) {
		$category_list = $db->Execute("select category_id, category_name, category_description 
			from " . TABLE_ASSETS_TABS . " order by sort_order");
		$_POST['id'] = $id;
		$cInfo = new objectInfo($_POST);
		$processed = true;
	}
	break;

  case 'copy':
	if ($security_level < 2) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$id = db_prepare_input($_GET['cID']);
	$asset_id = db_prepare_input($_GET['asset_id']);
	// check for duplicate skus
	$result = $db->Execute("select id from " . TABLE_ASSETS . " where asset_id = '" . $asset_id . "'");
	if ($result->Recordcount() > 0) {	// error and reload
		$messageStack->add(ASSETS_ERROR_DUPLICATE_SKU, 'error');
		break;
	}

	$result = $db->Execute("select * from " . TABLE_ASSETS . " where id = " . $id);
	$old_sku = $result->fields['asset_id'];
	// clean up the fields (especially the system fields, retain the custom fields)
	$output_array = array();
	foreach ($result->fields as $key => $value) {
		switch ($key) {
			case 'id':	// Remove from write list fields
			case 'maintenance_date':
			case 'terminal_date':
				break;
			case 'asset_id': // set the new asset_id
				$output_array[$key] = $asset_id;
				break;
			case 'acquisition_date':
				$output_array[$key] = date('Y-m-d H:i:s');
				break;
			default:
				$output_array[$key] = $value;
		}
	}
	db_perform(TABLE_ASSETS, $output_array, 'insert');
	$new_id = db_insert_id();

	// Pictures are not copied over...
	// now continue with newly copied item by editing it
	gen_add_audit_log(AESSETS_LOG_ASSETS . TEXT_COPY, $old_sku . ' => ' . $asset_id);
	$_POST['rowSeq'] = $new_id;	// set item pointer to new record
	$action = 'edit'; // fall through to edit case

  case 'edit':
    $id = db_prepare_input(isset($_POST['rowSeq']) ? $_POST['rowSeq'] : $_GET['cID']);
	$category_list = $db->Execute("select category_id, category_name, category_description 
		from " . TABLE_ASSETS_TABS . " order by sort_order");
	$field_list = $db->Execute("select field_name, description, category_id, params 
		from " . TABLE_ASSETS_FIELDS . " order by description");
	if ($field_list->RecordCount() < 1) inv_sync_inv_field_list();
	$query = '';
	while (!$field_list->EOF) {
		$query .= $field_list->fields['field_name'] . ', ';
		$field_list->MoveNext();
	}
	$full_inv_query = ($query == '') ? '*' : substr($query, 0, -2);
	$sql = "select " . $full_inv_query . " from " . TABLE_ASSETS . " 
		where id = " . (int)$id . " order by asset_id";
	$asset = $db->Execute($sql);
	$cInfo = new objectInfo($asset->fields);
	break;

  case 'rename':
	if ($security_level < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$id = db_prepare_input($_GET['cID']);
	$asset_id = db_prepare_input($_GET['asset_id']);
	// check for duplicate skus
	$result = $db->Execute("select id from " . TABLE_ASSETS . " where asset_id = '" . $asset_id . "'");
	if ($result->Recordcount() > 0) {	// error and reload
		$messageStack->add(ASSETS_ERROR_DUPLICATE_SKU, 'error');
		break;
	}

	$result = $db->Execute("select asset_id, asset_type from " . TABLE_ASSETS . " where id = " . $id);
	$orig_sku = $result->fields['asset_id'];
	$asset_type = $result->fields['asset_type'];
	$sku_list = array($orig_sku);
	if ($asset_type == 'ms') { // build list of asset_id's to rename (without changing contents)
		$result = $db->Execute("select asset_id from " . TABLE_ASSETS ." where asset_id like '". $orig_sku . "-%'");
		while(!$result->EOF) {
			$sku_list[] = $result->fields['asset_id'];
			$result->MoveNext();
		}
	}

	// start transaction (needs to all work or reset to avoid unsyncing tables)
	$db->transStart();
	// rename the afffected tables
	for($i = 0; $i < count($sku_list); $i++) {
		$new_sku = str_replace($orig_sku, $asset_id, $sku_list[$i], $count = 1);
		$result = $db->Execute("update " . TABLE_ASSETS . " set asset_id = '" . $new_sku . "' where asset_id = '" . $sku_list[$i] . "'");
		$result = $db->Execute("update " . TABLE_ASSETS_HISTORY . " set asset_id = '" . $new_sku . "' where asset_id = '" . $sku_list[$i] . "'");
//		$result = $db->Execute("update " . TABLE_JOURNAL_ITEM . " set sku = '" . $new_sku . "' where sku = '" . $sku_list[$i] . "'");
	}
	$db->transCommit();	// finished successfully
	break;

  case 'go_first':     $_GET['page'] = 1;         break;
  case 'go_previous':  $_GET['page']--;           break;
  case 'go_next':      $_GET['page']++;           break;
  case 'go_last':      $_GET['page'] = 99999;     break;
  case 'search':
  case 'search_reset':
  case 'go_page':
  default:
}

/*****************   prepare to display templates  *************************/
// load gl accounts
$gl_array_list = gen_get_pull_down(TABLE_CHART_OF_ACCOUNTS, false, SHOW_FULL_GL_NAMES);

$include_header = true;
$include_footer = true;
$include_calendar = true;

switch ($action) {
  case 'new':
    define('PAGE_TITLE', BOX_ASSETS_MAINTAIN);
    $include_template = 'template_id.php';
    break;
  case 'edit':
    define('PAGE_TITLE', BOX_ASSETS_MAINTAIN);
    $include_tabs = true;
    $include_template = 'template_detail.php';
    break;
  default:
    // build the list header
	$heading_array = array(
		'asset_id' => TEXT_ASSET_ID,
		'asset_type' => ASSETS_ENTRY_ASSETS_TYPE,
		'serial_number' => ASSETS_ENTRY_ASSETS_SERIALIZE,
		'description_short' => TEXT_DESCRIPTION,
		'inactive' => TEXT_INACTIVE,
	);
	$result = html_heading_bar($heading_array, $_GET['list_order']);
	$list_header = $result['html_code'];
	$disp_order = $result['disp_order'];

	// build the list for the page selected
	$search_text = ($_GET['search_text'] == TEXT_SEARCH) ? '' : db_input(db_prepare_input($_GET['search_text']));
    if (isset($search_text) && gen_not_null($search_text)) {
      $search_fields = array('asset_id', 'serial_number', 'description_short', 'description_long');
	  // hook for inserting new search fields to the query criteria.
	  if (is_array($extra_search_fields)) $search_fields = array_merge($search_fields, $extra_search_fields);
	  $search = ' where ' . implode(' like \'%' . $search_text . '%\' or ', $search_fields) . ' like \'%' . $search_text . '%\'';
    } else {
	  $search = '';
	}

	$field_list = array('id', 'asset_id', 'asset_type', 'inactive', 'serial_number', 'description_short');

	// hook to add new fields to the query return results
	if (is_array($extra_query_list_fields) > 0) $field_list = array_merge($field_list, $extra_query_list_fields);

    $query_raw = "select " . implode(', ', $field_list)  . " from " . TABLE_ASSETS . $search . " order by $disp_order, asset_id";

    $query_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
    $query_result = $db->Execute($query_raw);

	define('PAGE_TITLE', BOX_ASSETS_MAINTAIN);
    $include_template = 'template_main.php';
	break;
}

?>