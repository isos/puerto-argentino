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
//  Path: /modules/assets/pages/assets_fields/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ASSET_MGT_FIELDS];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
//require(DIR_FS_WORKING . 'functions/assets.php'); 

// Use many of the inventory functions and language since this feature is similar
require(DIR_FS_MODULES . 'inventory/language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'inventory/functions/inventory.php');

/**************   page specific initialization  *************************/
// make sure the module is installed
$result = $db->Execute("SHOW TABLES LIKE '" . TABLE_ASSETS . "'");
if ($result->RecordCount() == 0) {
  $messageStack->add_session(ASSET_MGR_NOT_INSTALLED,'caution');
  gen_redirect(html_href_link(FILENAME_DEFAULT, 'cat=assets&module=admin', 'SSL'));
}

$error = false;
$action = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/assets/assets_fields/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'new':
	if ($security_level < 2) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$form_array = array();
	$form_array['entry_type'] = 'text'; // default to text type
	$form_array = inv_prep_field_form($form_array);  //load form defaults
	$cInfo = new objectInfo($form_array);
	break;

  case 'save':
  case 'update':
	if ($security_level < 2) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$field_id = (int)db_prepare_input($_POST['rowSeq']);
	$field_name = db_prepare_input($_POST['field_name']);
	$description = db_prepare_input($_POST['description']);
	$category_id = db_prepare_input($_POST['category_id']);
	$entry_type = db_prepare_input($_POST['entry_type']);
	$field_name = ereg_replace("[^A-Za-z0-9_]", "", $field_name); // clean out all non-allowed values
	if (!$field_name) $error = $messageStack->add(INV_ERROR_FIELD_BLANK,'error');
// TBD - validate input reserved words. Below needs to be cleaned up to generically look at mysql
// result error num and text and show the error in messgeStack NOT crash.
	$reserved_names = array('select', 'delete', 'insert', 'update', 'to', 'from', 'where', 'and', 'or',
		'alter', 'table', 'add', 'change', 'in', 'order', 'set', 'inner');
	if (in_array($field_name, $reserved_names)) $error = $messageStack->add(INV_FIELD_RESERVED_WORD,'error');
	// check for duplicate field names
	$sql = "select id from " . TABLE_ASSETS_FIELDS . " where field_name = '" . $field_name . "'";
	$result = $db->Execute($sql);
	if ($result->RecordCount() > 0 && $action == 'save') $error = $messageStack->add(INV_ERROR_FIELD_DUPLICATE,'error');

	$values = array();
	$params = array('type' => $entry_type);
	switch ($entry_type) {
		case 'text':
		case 'html':
			$params['length'] = intval(db_prepare_input($_POST['text_length']));
			$params['default'] = db_prepare_input($_POST['text_default']);
			if ($params['length']<1) $params['length'] = DEFAULT_TEXT_LENGTH;
			if ($params['length']<256) {
				$values['entry_type'] = 'varchar(' . $params['length'] . ')';
				$values['entry_params'] = " default '" . $params['default'] . "'";
			} elseif ($_POST['TextLength'] < 65536) { 
				$values['entry_type'] = 'text';
			} elseif ($_POST['TextLength'] < 16777216) {
				$values['entry_type'] = 'mediumtext';
			} elseif ($_POST['TextLength'] < 65535) {
				$values['entry_type'] = 'longtext';
			}
			break;
		case 'hyperlink':
		case 'image_link':
		case 'inventory_link':
			$params['default'] = db_prepare_input($_POST['link_default']);
			$values['entry_type'] = 'varchar(255)';
			$values['entry_params'] = " default '".$params['default']."'";
			break;
		case 'integer':
			$params['select'] = db_prepare_input($_POST['integer_range']);
			$params['default'] = (int)db_prepare_input($_POST['integer_default']);
			switch ($params['select']) {
				case "0": $values['entry_type'] = 'tinyint'; break;
				case "1": $values['entry_type'] = 'smallint'; break;
				case "2": $values['entry_type'] = 'mediumint'; break;
				case "3": $values['entry_type'] = 'int'; break;
				case "4": $values['entry_type'] = 'bigint';
			}
			$values['entry_params'] = " default '" . $params['default'] . "'";
			break;
		case 'decimal':
			$params['select'] = db_prepare_input($_POST['decimal_range']);
			$params['display'] = db_prepare_input($_POST['decimal_display']);
			$params['default'] = $currencies->clean_value(db_prepare_input($_POST['decimal_default']));
			if ($params['display']=='') $params['display'] = DEFAULT_REAL_DISPLAY_FORMAT;
//TBD - evaluate the format entered to see if it makes sense
			switch ($params['select']) {
				case "0": $values['entry_type'] = 'float(' . $params['display'] . ')'; break;
				case "1": $values['entry_type'] = 'double(' . $params['display'] . ')';
			}
			$values['entry_params'] = " default '" . $params['default'] . "'";
			break;
		case 'drop_down':
		case 'radio':
			$params['default'] = db_prepare_input($_POST['radio_default']);
			$choices = explode(',',$params['default']);
			$max_choice_size = 0;
			while ($choice = array_shift($choices)) {
				$a_choice = explode(':',$choice);
				if ($a_choice[2] == 1) $values['entry_params'] = " default '" . $a_choice[0] . "'";
				if (strlen($a_choice[0]) > $max_choice_size) $max_choice_size = strlen($a_choice[0]);
			}
			$values['entry_type'] = 'char(' . $max_choice_size . ')';
			break;
		case 'date':
			$values['entry_type'] = 'date';
			break;
		case 'time':
			$values['entry_type'] = 'time';
			break;
		case 'date_time':
			$values['entry_type'] = 'datetime';
			break;
		case 'check_box':
			$params['select'] = db_prepare_input($_POST['check_box_range']);
			$values['entry_type'] = 'enum("0","1")';
			$values['entry_params'] = " default '" . $params['select'] . "'";
			break;
		case 'time_stamp':
			$values['entry_type'] = 'timestamp';
			break;
		default:
	}

	if (!$error) {
		$sql_data_array = array('description' => $description);
		if ($category_id <> '0') {
			$sql_data_array['entry_type'] = $entry_type;
			$sql_data_array['field_name'] = $field_name;
			$sql_data_array['category_id'] = $category_id;
			$sql_data_array['params'] = serialize($params);
		}
		if ($action == 'save') {
			$id = db_insert_id();
			$sql = "alter table " . TABLE_ASSETS . " 
				add column " . $field_name . " " . $values['entry_type'] . (isset($values['entry_params']) ? $values['entry_params'] : '');
			$db->Execute($sql);
			db_perform(TABLE_ASSETS_FIELDS, $sql_data_array, 'insert');
			gen_add_audit_log(ASSET_LOG_FIELDS . TEXT_NEW, $category_id . ' - ' . $field_name);
		} else {
			if (isset($values['entry_type'])) {
				$sql = "alter table " . TABLE_ASSETS . " change " . $field_name . " " . $field_name . " 
					" . $values['entry_type'] . (isset($values['entry_params']) ? $values['entry_params'] : '');
				$result = $db->Execute($sql);
			}
			db_perform(TABLE_ASSETS_FIELDS, $sql_data_array, 'update', "id = " . $field_id);
			gen_add_audit_log(ASSET_LOG_FIELDS . TEXT_UPDATE, $category_id . ' - ' . $field_name);
		}
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
	} else {
		$cInfo = new objectInfo($_POST);
		$action = 'new';
	}
	break;

  case 'delete':
	if ($security_level < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$id = (int)db_prepare_input($_POST['rowSeq']);

	$temp = $db->Execute("select field_name, category_id from " . TABLE_ASSETS_FIELDS . " where id = " . $id);
	$field_name = $temp->fields['field_name'];
	$category_id = $temp->fields['category_id'];
	if ($category_id <> '0') { // don't allow deletion of system fields
		$db->Execute("delete from " . TABLE_ASSETS_FIELDS . " where id = " . $id);
		$db->Execute("alter table " . TABLE_ASSETS . " drop column " . $field_name);
		gen_add_audit_log(ASSET_LOG_FIELDS . TEXT_DELETE, $category_id . ' - ' . $field_name);
	} else {
		$messageStack->add_session(ASSET_CANNOT_DELETE_SYSTEM,'error');
	}
	gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
	break;

  case 'edit':
	inv_sync_inv_field_list();
	$inventory = $db->Execute("select id, entry_type, field_name, description, category_id, params 
		from " . TABLE_ASSETS_FIELDS . " 
		where id = " . (int)$_POST['rowSeq']);
	$params = unserialize($inventory->fields['params']);
	foreach ($params as $key=>$value) $inventory->fields[$key] = $value;
	$form_array = $inventory->fields;
	$form_array = inv_prep_field_form($form_array);
	$cInfo = new objectInfo($form_array);
	break;

  case 'go_first':     $_GET['page'] = 1;         break;
  case 'go_previous':  $_GET['page']--;           break;
  case 'go_next':      $_GET['page']++;           break;
  case 'go_last':      $_GET['page'] = 99999;     break;
  case 'search':
  case 'search_reset':
  case 'go_page':      break;

  default: // check to see if the field list is sync'd with the field properties, on first entry
	inv_sync_inv_field_list(TABLE_ASSETS, TABLE_ASSETS_FIELDS);
}

/*****************   prepare to display templates  *************************/
// prepare category drop-down
$category_array = inv_get_field_categories(TABLE_ASSETS_TABS);

$include_header = true; // include header flag
$include_footer = true; // include footer flag
$include_tabs = false;
$include_calendar = false;

switch ($action) {
  case 'edit':
  case 'update':
  case 'new':
    $include_template = 'template_detail.php'; // include display template (required)
    define('PAGE_TITLE', ASSETS_FIELD_HEADING_TITLE);
	break;
  default:
    $heading_array = array(
		'description' => TEXT_ACCT_DESCRIPTION,
		'category_id' => TEXT_CATEGORY_NAME,
		'entry_type' => TEXT_TYPE);
	$result = html_heading_bar($heading_array, $_GET['list_order']);
	$list_header = $result['html_code'];
	$disp_order = $result['disp_order'];

	// build the list for the page selected
	$search_text = ($_GET['search_text'] == TEXT_SEARCH) ? '' : db_input(db_prepare_input($_GET['search_text']));
    if (isset($search_text) && gen_not_null($search_text)) {
      $search_fields = array('entry_type', 'field_name', 'description');
	  // hook for inserting new search fields to the query criteria.
	  if (is_array($extra_search_fields)) $search_fields = array_merge($search_fields, $extra_search_fields);
	  $search = ' where ' . implode(' like \'%' . $search_text . '%\' or ', $search_fields) . ' like \'%' . $search_text . '%\'';
    } else {
	  $search = '';
	}

	$field_list = array('id', 'field_name', 'entry_type', 'description', 'category_id');

	// hook to add new fields to the query return results
	if (is_array($extra_query_list_fields) > 0) $field_list = array_merge($field_list, $extra_query_list_fields);

    $query_raw = "select " . implode(', ', $field_list)  . " from " . TABLE_ASSETS_FIELDS . $search . " order by $disp_order";

    $query_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
    $query_result = $db->Execute($query_raw);

    $include_template = 'template_main.php'; // include display template (required)
    define('PAGE_TITLE', ASSETS_FIELD_HEADING_TITLE);
}

?>