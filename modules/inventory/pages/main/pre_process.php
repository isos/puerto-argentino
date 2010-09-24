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
//  Path: /modules/inventory/pages/main/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_MAINTAIN_INVENTORY];
if ($security_level == 0) { // not supposed to be here
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require_once(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
require_once(DIR_FS_WORKING . 'functions/inventory.php');

/**************   page specific initialization  *************************/
$error = false;
$processed = false;
$search_text = ($_POST['search_text']) ? db_input(db_prepare_input($_POST['search_text'])) : db_input(db_prepare_input($_GET['search_text']));

if ($search_text == TEXT_SEARCH) $search_text = '';
$action = isset($_GET['action']) ? $_GET['action'] : $_POST['todo'];
if (!$action && $search_text <> '') $action = 'search'; // if enter key pressed and search not blank

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/inventory/main/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'new':
	$inventory = '';
	$cInfo     = '';
	break;

  case 'create':
	if ($security_level < 2) {
		$messageStack->add_session(ERROR_NO_PERMISSION, 'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$sku            = db_prepare_input($_POST['sku']);
	$inventory_type = db_prepare_input($_POST['inventory_type']);
	$cost_method    = db_prepare_input($_POST['cost_method']);
	if (!$sku) {
		$messageStack->add(INV_ERROR_SKU_BLANK, 'error');
		$action = 'new';
		break;
	}
	if (gen_validate_sku($sku)) {
		$messageStack->add(INV_ERROR_DUPLICATE_SKU, 'error');
		$action = 'new';
		break;
	}

	$sql_data_array = array(
		'sku'            => $sku,
		'inventory_type' => $inventory_type,
		'cost_method'    => $cost_method,
		'creation_date'  => 'now()',
		'last_update'    => 'now()',
		'item_taxable'   => INVENTORY_DEFAULT_TAX,
		'purch_taxable'  => INVENTORY_DEFAULT_PURCH_TAX,
	);
	switch ($inventory_type) {
	  case 'si':
		$sql_data_array['account_sales_income']   = INV_STOCK_DEFAULT_SALES;
		$sql_data_array['account_inventory_wage'] = INV_STOCK_DEFAULT_INVENTORY;
		$sql_data_array['account_cost_of_sales']  = INV_STOCK_DEFAULT_COS;
		break;
	  case 'sa': // Serialized Assembly
	  case 'sr': // Serialized Item
		$sql_data_array['account_sales_income']   = INV_SERIALIZE_DEFAULT_SALES;
		$sql_data_array['account_inventory_wage'] = INV_SERIALIZE_DEFAULT_INVENTORY;
		$sql_data_array['account_cost_of_sales']  = INV_SERIALIZE_DEFAULT_COS;
		$sql_data_array['serialize']              = '1';
		break;
	  case 'ms':
		$sql_data_array['account_sales_income']   = INV_MASTER_STOCK_DEFAULT_SALES;
		$sql_data_array['account_inventory_wage'] = INV_MASTER_STOCK_DEFAULT_INVENTORY;
		$sql_data_array['account_cost_of_sales']  = INV_MASTER_STOCK_DEFAULT_COS;
		break;
	  case 'as':
		$sql_data_array['account_sales_income']   = INV_ASSY_DEFAULT_SALES;
		$sql_data_array['account_inventory_wage'] = INV_ASSY_DEFAULT_INVENTORY;
		$sql_data_array['account_cost_of_sales']  = INV_ASSY_DEFAULT_COS;
		break;
	  case 'ns':
		$sql_data_array['account_sales_income']   = INV_NON_STOCK_DEFAULT_SALES;
		$sql_data_array['account_inventory_wage'] = INV_NON_STOCK_DEFAULT_INVENTORY;
		$sql_data_array['account_cost_of_sales']  = INV_NON_STOCK_DEFAULT_COS;
		break;
	  case 'lb':
		$sql_data_array['account_sales_income']   = INV_LABOR_DEFAULT_SALES;
		$sql_data_array['account_inventory_wage'] = INV_LABOR_DEFAULT_INVENTORY;
		$sql_data_array['account_cost_of_sales']  = INV_LABOR_DEFAULT_COS;
		break;
	  case 'sv':
		$sql_data_array['account_sales_income']   = INV_SERVICE_DEFAULT_SALES;
		$sql_data_array['account_inventory_wage'] = INV_SERVICE_DEFAULT_INVENTORY;
		$sql_data_array['account_cost_of_sales']  = INV_SERVICE_DEFAULT_COS;
		break;
	  case 'ci':
		$sql_data_array['account_sales_income']   = INV_CHARGE_DEFAULT_SALES;
		break;
	  case 'ai':
		$sql_data_array['account_sales_income']   = INV_ACTIVITY_DEFAULT_SALES;
		break;
	  default:
	  case 'ds':	// description only item type
	}
	db_perform(TABLE_INVENTORY, $sql_data_array, 'insert');
	$id = db_insert_id();
	gen_add_audit_log(INV_LOG_INVENTORY . TEXT_ADD, 'Type: ' . $inventory_type . ' - ' . $sku);
	gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('cID', 'action')) . 'cID=' . $id . '&action=edit', 'SSL'));
	break;

  case 'delete':
	if ($security_level < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$id = db_prepare_input($_GET['cID']);
	$result = $db->Execute("select sku, image_with_path, inventory_type from " . TABLE_INVENTORY . " where id = " . $id);
	$sku             = $result->fields['sku'];
	$image_with_path = $result->fields['image_with_path'];
	$inventory_type  = $result->fields['inventory_type'];
	if ($inventory_type == 'mi') { // this is disabled in the form but just in case, error here as well
		$messageStack->add_session('Master Stock Sub Items are not allowed to be deleted separately!','error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
	}

	// check to see if there is inventory history remaining, if so don't allow delete
	$result = $db->Execute("select id from " . TABLE_INVENTORY_HISTORY . " where sku = '" . sku . "' and remaining > 0");
	if ($result->RecordCount() > 0) {
		$messageStack->add(INV_ERROR_DELETE_HISTORY_EXISTS, 'error');
		break;
	}
	// check to see if this item is part of an assembly
	$result = $db->Execute("select id from " . TABLE_INVENTORY_ASSY_LIST . " where sku = '" . sku . "'");
	if ($result->RecordCount() > 0) {
		$messageStack->add(INV_ERROR_DELETE_ASSEMBLY_PART, 'error');
		break;
	}
	if ($inventory_type == 'ms') {
		$sql = "select id from " . TABLE_JOURNAL_ITEM . " where sku like '" . $sku . "-%' limit 1";
	} else {
		$sql = "select id from " . TABLE_JOURNAL_ITEM . " where sku = '" . $sku . "' limit 1";
	}
	$result = $db->Execute($sql);
	if ($result->Recordcount() == 0) {
		$db->Execute("delete from " . TABLE_INVENTORY . " where id = " . $id);
		if ($inventory_type == 'ms') {
			$db->Execute("delete from " . TABLE_INVENTORY_MS_LIST . " where sku = '" . $sku . "'");
			$db->Execute("delete from " . TABLE_INVENTORY . " where sku like '" . $sku . "-%'");
		}
		// clean up some other tables
		if ($image_with_path) { // delete image
		  $file_path = DIR_FS_MY_FILES . $_SESSION['company'] . '/inventory/images/';
		  if (file_exists($file_path . $image_with_path)) unlink ($file_path . $image_with_path);
		}
		$db->Execute("delete from " . TABLE_INVENTORY_SPECIAL_PRICES . " where inventory_id = '" . $id . "'");
		gen_add_audit_log(INV_LOG_INVENTORY . TEXT_DELETE, $sku);
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('cID', 'action')), 'SSL'));
	} else {
		$messageStack->add(INV_ERROR_CANNOT_DELETE, 'error');
	}
	break;

  case 'save':
	if ($security_level < 3) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$id              = (int)db_prepare_input($_POST['rowSeq']);
	$sku             = db_prepare_input($_POST['sku']);
	$image_with_path = db_prepare_input($_POST['image_with_path']); // the current image name with path relative from my_files/company_db/inventory/images directory
	$inventory_path  = db_prepare_input($_POST['inventory_path']);
	if (substr($inventory_path, 0, 1) == '/')  $inventory_path = substr($inventory_path, 1); // remove leading '/' if there
	if (substr($inventory_path, -1, 1) == '/') $inventory_path = substr($inventory_path, 0, strlen($inventory_path)-1); // remove trailing '/' if there
	$inventory_type  = db_prepare_input($_POST['inventory_type']);
	$sql_data_array  = array();
	$inventory_fields = $db->Execute("select field_name, entry_type from " . TABLE_INVENTORY_FIELDS);
	while (!$inventory_fields->EOF) {
		$field_name = $inventory_fields->fields['field_name'];
		if (!isset($_POST[$field_name]) && $inventory_fields->fields['entry_type'] == 'check_box') {
			$sql_data_array[$field_name] = '0'; // special case for unchecked check boxes
		} elseif (isset($_POST[$field_name]) && $field_name <> 'id') {
			$sql_data_array[$field_name] = db_prepare_input($_POST[$field_name]);
		}
		$inventory_fields->MoveNext();
	}
	$sql_data_array['last_update'] = date('Y-m-d H-i-s');
	// special cases for checkboxes of system fields (don't return a POST value if unchecked)
	$remove_image = $_POST['remove_image'] == '1' ? true : false;
	unset($sql_data_array['remove_image']); // this is not a db field, just an action
	$sql_data_array['inactive']   = ($sql_data_array['inactive'] == '1' ? '1' : '0');
	// special cases for monetary values in system fields
	$sql_data_array['full_price'] = $currencies->clean_value($sql_data_array['full_price']);
	$sql_data_array['item_cost']  = $currencies->clean_value($sql_data_array['item_cost']);

	// if it's a master stock item, process
	if ($inventory_type == 'ms') {
	  $attributes = array(
		'attr_name_0' => db_prepare_input($_POST['attr_name_0']),
		'ms_attr_0'   => substr(db_prepare_input($_POST['ms_attr_0']), 0, -1),
		'attr_name_1' => db_prepare_input($_POST['attr_name_1']),
		'ms_attr_1'   => substr(db_prepare_input($_POST['ms_attr_1']), 0, -1));
	  save_ms_items($sql_data_array, $attributes);
	}

	// if it's an assembly, retrieve the BOM (if no journal_entries have been posted)
	$update_bom = false;
	if ($inventory_type == 'as' || $inventory_type == 'sa') {
		$result = $db->Execute("select last_journal_date from " . TABLE_INVENTORY . " where id = " . $id);
		if ($result->fields['last_journal_date'] == '0000-00-00 00:00:00') { // only update if no posting has been performed
			$x = 1;
			$bom_array = array();
			for($x=0; $x<count($_POST['assy_sku']); $x++) {
				$assy_sku = db_prepare_input($_POST['assy_sku'][$x]);
				$assy_qty = $currencies->clean_value(db_prepare_input($_POST['assy_qty'][$x]));
				if (gen_validate_sku($assy_sku) && $assy_qty > 0) { // error check sku is valid and qty > 0
					$bom_array[] = array(
						'ref_id'      => $id,
						'sku'         => $assy_sku,
						'description' => db_prepare_input($_POST['assy_desc'][$x]),
						'qty'         => $assy_qty,
					);
				} elseif ($assy_sku <> '' || $assy_qty < 0) { // show error, bad sku, negative quantity, skip the blank lines
					$messageStack->add(INV_ERROR_BAD_SKU . $assy_sku, 'error');
				}
			}
			$update_bom = true;
		}
	}

	$img = $db->Execute("select image_with_path from " . TABLE_INVENTORY . " where id = " . $id);
	$file_path = DIR_FS_MY_FILES . $_SESSION['company'] . '/inventory/images';
	if ($remove_image) { // update the image with relative path
		if ($img->fields['image_with_path'] && file_exists($file_path . '/' . $img->fields['image_with_path'])) unlink ($file_path . '/' . $img->fields['image_with_path']);
		$_POST['image_with_path'] = '';
		$sql_data_array['image_with_path'] = ''; 
	}

	if (!$error && is_uploaded_file($_FILES['inventory_image']['tmp_name'])) {
		if ($img->fields['image_with_path'] && file_exists($file_path . '/' . $img->fields['image_with_path'])) unlink ($file_path . '/' . $img->fields['image_with_path']);
        $inventory_path = str_replace('\\', '/', $inventory_path);
		// strip beginning and trailing slashes if present
		if (substr($inventory_path, -1, 1) == '/') $inventory_path = substr($inventory_path, 0, -1);
		if (substr($inventory_path, 0, 1) == '/') $inventory_path = substr($inventory_path, 1);
		if ($inventory_path) $file_path .= '/' . $inventory_path;

		$temp_file_name = $_FILES['inventory_image']['tmp_name'];
		$file_name = $_FILES['inventory_image']['name'];
		if (!validate_path($file_path)) {
			$messageStack->add(INV_IMAGE_PATH_ERROR, 'error');
			$error = true;
		} elseif (!validate_upload('inventory_image', 'image', 'jpg')) {
			$messageStack->add(INV_IMAGE_FILE_TYPE_ERROR, 'error');
			$error = true;
		} else { // passed all test, write file
			if (!copy($temp_file_name, $file_path . '/' . $file_name)) {
				$messageStack->add(INV_IMAGE_FILE_WRITE_ERROR, 'error');
				$error = true;
			} else {
				$image_with_path = ($inventory_path ? ($inventory_path . '/') : '') . $file_name;
				$_POST['image_with_path'] = $image_with_path;
				$sql_data_array['image_with_path'] = $image_with_path; // update the image with relative path
			}
		}
	}

	// Ready to write update
	if (!$error) {
		if (($inventory_type == 'as' || $inventory_type == 'sa') && $update_bom) {
			$result = $db->Execute("delete from " . TABLE_INVENTORY_ASSY_LIST . " where ref_id = " . $id);
			while ($list_array = array_shift($bom_array)) {
				db_perform(TABLE_INVENTORY_ASSY_LIST, $list_array, 'insert');
			}
		}
		db_perform(TABLE_INVENTORY, $sql_data_array, 'update', "id = " . $id);
		gen_add_audit_log(INV_LOG_INVENTORY . TEXT_UPDATE, $sku . ' - ' . $sql_data_array['description_short']);
	} else if ($error == true) {
		$category_list = $db->Execute("select category_id, category_name, category_description 
			from " . TABLE_INVENTORY_CATEGORIES . " order by sort_order");
		$_POST['id'] = $id;
		$cInfo = new objectInfo($_POST);
		$processed = true;
	}
	break;

  case 'copy': 	// Pictures are not copied over...
	if ($security_level < 2) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$id  = db_prepare_input($_GET['cID']);
	$sku = db_prepare_input($_GET['sku']);
	// check for duplicate skus
	$result = $db->Execute("select id from " . TABLE_INVENTORY . " where sku = '" . $sku . "'");
	if ($result->Recordcount() > 0) {	// error and reload
		$messageStack->add(INV_ERROR_DUPLICATE_SKU, 'error');
		break;
	}

	$result = $db->Execute("select * from " . TABLE_INVENTORY . " where id = " . $id);
	$old_sku = $result->fields['sku'];
	// clean up the fields (especially the system fields, retain the custom fields)
	$output_array = array();
	foreach ($result->fields as $key => $value) {
		switch ($key) {
			case 'id':	// Remove from write list fields
			case 'last_journal_date':
			case 'item_cost':
			case 'upc_code':
			case 'image_with_path':
			case 'quantity_on_hand':
			case 'quantity_on_order':
			case 'quantity_on_sales_order':
				break;
			case 'sku': // set the new sku
				$output_array[$key] = $sku;
				break;
			case 'creation_date':
			case 'last_update':
				$output_array[$key] = date('Y-m-d H:i:s');
				break;
			default:
				$output_array[$key] = $value;
		}
	}
	db_perform(TABLE_INVENTORY, $output_array, 'insert');
	$new_id = db_insert_id();

	if ($result->fields['inventory_type'] == 'ms') { // create master stock items
		$ms_result   = $db->Execute("select * from " . TABLE_INVENTORY_MS_LIST . " where sku = '" . $old_sku . "'");
		$ms_attr_0   = ($ms_result->RecordCount() > 0) ? $ms_result->fields['attr_0'] : '';
		$attr_name_0 = ($ms_result->RecordCount() > 0) ? $ms_result->fields['attr_name_0'] : '';
		$ms_attr_1   = ($ms_result->RecordCount() > 0) ? $ms_result->fields['attr_1'] : '';
		$attr_name_1 = ($ms_result->RecordCount() > 0) ? $ms_result->fields['attr_name_1'] : '';
		$attributes  = array(
			'attr_name_0' => $attr_name_0,
			'ms_attr_0'   => $ms_attr_0,
			'attr_name_1' => $attr_name_1,
			'ms_attr_1'   => $ms_attr_1);
		save_ms_items($output_array, $attributes);
	}

	if ($result->fields['inventory_type'] == 'as' ||$result->fields['inventory_type'] == 'sa') { // copy assembly list if it's an assembly
	  $result = $db->Execute("select sku, description, qty from " . TABLE_INVENTORY_ASSY_LIST . " where ref_id = " . $id);
	  while (!$result->EOF) {
		$output_array = array(
		  'ref_id'      => $new_id,
		  'sku'         => $result->fields['sku'],
		  'description' => $result->fields['description'],
		  'qty'         => $result->fields['qty'],
		);
		db_perform(TABLE_INVENTORY_ASSY_LIST, $output_array, 'insert');
		$result->MoveNext();
	  }
	}
	// copy over price sheet
	$result = $db->Execute("select price_sheet_id, price_levels 
	  from " . TABLE_INVENTORY_SPECIAL_PRICES . " where inventory_id = " . $id);
	while(!$result->EOF) {
	  $output_array = array(
		'inventory_id'   => $new_id,
		'price_sheet_id' => $result->fields['price_sheet_id'],
		'price_levels'   => $result->fields['price_levels'],
	  );
	  db_perform(TABLE_INVENTORY_SPECIAL_PRICES, $output_array, 'insert');
	  $result->MoveNext();
	}
	// now continue with newly copied item by editing it
	gen_add_audit_log(INV_LOG_INVENTORY . TEXT_COPY, $old_sku . ' => ' . $sku);
	$_POST['rowSeq'] = $new_id;	// set item pointer to new record
	$action = 'edit'; // fall through to edit case

  case 'edit':
  case 'properties':
    $id = isset($_POST['rowSeq']) ? (int)db_prepare_input($_POST['rowSeq']) : (int)db_prepare_input($_GET['cID']);
	$category_list = $db->Execute("select category_id, category_name, category_description 
		from " . TABLE_INVENTORY_CATEGORIES . " order by sort_order");
	$field_list = $db->Execute("select field_name, description, category_id, params 
		from " . TABLE_INVENTORY_FIELDS . " order by description");
	if ($field_list->RecordCount() < 1) inv_sync_inv_field_list();
	$query = '';
	while (!$field_list->EOF) {
		$query .= $field_list->fields['field_name'] . ', ';
		$field_list->MoveNext();
	}
	$full_inv_query = ($query == '') ? '*' : substr($query, 0, -2);
	$sql = "select " . $full_inv_query . " from " . TABLE_INVENTORY . " where id = " . $id . " order by sku";
	$inventory = $db->Execute($sql);
	$cInfo = new objectInfo($inventory->fields);
	// gather the history
	$sku_history = gather_history($inventory->fields['sku']);
	// get the branch stock
	if (ENABLE_MULTI_BRANCH) {
		$sql = " select id, short_name from " . TABLE_CONTACTS . " where type = 'b'";
		$result = $db->Execute($sql);
		$store_stock = array();
		$store_stock[] = array('store' => COMPANY_ID, 'qty' => load_store_stock($inventory->fields['sku'], 0));
		while (!$result->EOF) {
			$store_stock[] = array(
				'store' => $result->fields['short_name'], 
				'qty'   => load_store_stock($inventory->fields['sku'], $result->fields['id']),
			);
			$result->MoveNext();
		}
		
	}
	// master stock, fetch attributes
	if ($cInfo->inventory_type == 'ms') {  
		$result = $db->Execute("select * from " . TABLE_INVENTORY_MS_LIST . " where sku = '" . $cInfo->sku . "'");
		$cInfo->ms_attr_0   = ($result->RecordCount() > 0) ? $result->fields['attr_0'] : '';
		$cInfo->attr_name_0 = ($result->RecordCount() > 0) ? $result->fields['attr_name_0'] : '';
		$cInfo->ms_attr_1   = ($result->RecordCount() > 0) ? $result->fields['attr_1'] : '';
		$cInfo->attr_name_1 = ($result->RecordCount() > 0) ? $result->fields['attr_name_1'] : '';
		$attr_array0 = array();
		if ($cInfo->ms_attr_0) {
			$temp = explode(',', $cInfo->ms_attr_0);
			for ($i = 0; $i < count($temp); $i++) {
				$code = substr($temp[$i], 0, strpos($temp[$i], ':'));
				$desc = substr($temp[$i], strpos($temp[$i], ':') + 1);
				$attr_array0[] = array('id' => $code . ':' . $desc, 
					'text' => $code . ' : ' . $desc);
			}
		}
		$attr_array1 = array();
		if ($cInfo->ms_attr_1) {
			$temp = explode(',', $cInfo->ms_attr_1);
			for ($i = 0; $i < count($temp); $i++) {
				$code = substr($temp[$i], 0, strpos($temp[$i], ':'));
				$desc = substr($temp[$i], strpos($temp[$i], ':') + 1);
				$attr_array1[] = array('id' => $code . ':' . $desc, 
					'text' => $code . ' : ' . $desc);
			}
		}
	}
	break;

  case 'rename':
	if ($security_level < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$id  = db_prepare_input($_GET['cID']);
	$sku = db_prepare_input($_GET['sku']);
	// check for duplicate skus
	$result = $db->Execute("select id from " . TABLE_INVENTORY . " where sku = '" . $sku . "'");
	if ($result->Recordcount() > 0) {	// error and reload
		$messageStack->add(INV_ERROR_DUPLICATE_SKU, 'error');
		break;
	}

	$result = $db->Execute("select sku, inventory_type from " . TABLE_INVENTORY . " where id = " . $id);
	$orig_sku = $result->fields['sku'];
	$inventory_type = $result->fields['inventory_type'];
	$sku_list = array($orig_sku);
	if ($inventory_type == 'ms') { // build list of sku's to rename (without changing contents)
		$result = $db->Execute("select sku from " . TABLE_INVENTORY . " where sku like '" . $orig_sku . "-%'");
		while(!$result->EOF) {
			$sku_list[] = $result->fields['sku'];
			$result->MoveNext();
		}
	}

	// start transaction (needs to all work or reset to avoid unsyncing tables)
	$db->transStart();
	// rename the afffected tables
	for ($i = 0; $i < count($sku_list); $i++) {
		$new_sku = str_replace($orig_sku, $sku, $sku_list[$i], $count = 1);
		$result = $db->Execute("update " . TABLE_INVENTORY .           " set sku = '" . $new_sku . "' where sku = '" . $sku_list[$i] . "'");
		$result = $db->Execute("update " . TABLE_INVENTORY_ASSY_LIST . " set sku = '" . $new_sku . "' where sku = '" . $sku_list[$i] . "'");
		$result = $db->Execute("update " . TABLE_INVENTORY_COGS_OWED . " set sku = '" . $new_sku . "' where sku = '" . $sku_list[$i] . "'");
		$result = $db->Execute("update " . TABLE_INVENTORY_HISTORY .   " set sku = '" . $new_sku . "' where sku = '" . $sku_list[$i] . "'");
		$result = $db->Execute("update " . TABLE_INVENTORY_MS_LIST .   " set sku = '" . $new_sku . "' where sku = '" . $sku_list[$i] . "'");
		$result = $db->Execute("update " . TABLE_JOURNAL_ITEM .        " set sku = '" . $new_sku . "' where sku = '" . $sku_list[$i] . "'");
	}
	$db->transCommit();	// finished successfully
	break;

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
// load the tax rates
$tax_rates       = inv_calculate_tax_drop_down('c');
$purch_tax_rates = inv_calculate_tax_drop_down('v');

// load gl accounts
$gl_array_list    = gen_coa_pull_down();

$include_header   = true;
$include_footer   = true;
$include_tabs     = false;
$include_calendar = false;

switch ($action) {
  case 'new':
    define('PAGE_TITLE', BOX_INV_MAINTAIN);
    $include_template = 'template_id.php';
    break;
  case 'edit':
    define('PAGE_TITLE', BOX_INV_MAINTAIN);
    $include_tabs = true;
    $include_template = 'template_detail.php';
    break;
  case 'properties':
	$include_header = false;
	$include_footer = false;
    $include_tabs   = true;
    define('PAGE_TITLE', BOX_INV_MAINTAIN);
    $include_template = 'template_detail.php';
    break;
  default:
    // build the list header
	$heading_array = array(
		'sku'                     => TEXT_SKU,
		'description_short'       => TEXT_DESCRIPTION,
		'item_cost' => INV_ENTRY_INV_ITEM_COST,
		'full_price' => INV_ENTRY_FULL_PRICE,
		'quantity_on_hand'        => INV_HEADING_QTY_ON_HAND,
		'inactive'                => TEXT_INACTIVE);
	//	'quantity_on_order'       => INV_HEADING_QTY_ON_ORDER,
	//	'quantity_on_sales_order' => INV_HEADING_QTY_ON_SO);
	$result = html_heading_bar($heading_array, $_GET['list_order']);
	$list_header = $result['html_code'];
	$disp_order = $result['disp_order'];

	// build the list for the page selected
    if (isset($search_text) && gen_not_null($search_text)) {
      $search_fields = array('sku', 'description_short', 'description_purchase');
	  // hook for inserting new search fields to the query criteria.
	  if (is_array($extra_search_fields)) $search_fields = array_merge($search_fields, $extra_search_fields);
	  $search = ' where ' . implode(' like \'%' . $search_text . '%\' or ', $search_fields) . ' like \'%' . $search_text . '%\'';
    } else {
	  $search = '';
	}

	$field_list = array('id', 'sku', 'inactive', 'inventory_type', 'description_short', 'item_cost', 'full_price', 
			'quantity_on_hand', 'quantity_on_order', 'quantity_on_sales_order');

	// hook to add new fields to the query return results
	if (is_array($extra_query_list_fields) > 0) $field_list = array_merge($field_list, $extra_query_list_fields);

    $query_raw = "select " . implode(', ', $field_list)  . " from " . TABLE_INVENTORY . $search . " order by $disp_order, sku";

    $query_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
    $query_result = $db->Execute($query_raw);

	define('PAGE_TITLE', BOX_INV_MAINTAIN);
    $include_template = 'template_main.php';
	break;
}

?>
