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
//  Path: /modules/general/pages/users/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_USERS];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/admin_tools.php');

/**************   page specific initialization  *************************/
$error = false;
$action = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/general/users/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
  case 'fill_all': 
	if ($security_level < 2) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$admin_id = db_prepare_input($_POST['rowSeq']);
	$fill_all = db_prepare_input($_POST['fill_all']);
	$prefs = array(
	  'def_store_id'    => db_prepare_input($_POST['def_store_id']),
	  'def_cash_acct'   => db_prepare_input($_POST['def_cash_acct']),
	  'def_ar_acct'     => db_prepare_input($_POST['def_ar_acct']),
	  'def_ap_acct'     => db_prepare_input($_POST['def_ap_acct']),
	  'restrict_store'  => isset($_POST['restrict_store'])  ? '1' : '0',
	  'restrict_period' => isset($_POST['restrict_period']) ? '1' : '0',
	);
	// not the most elegent but look for a colon in the second character position
	$post_keys = array_keys($_POST);
	$admin_security = '';
    foreach ($post_keys as $key) {
	  if (strpos($key, 'sID_') === 0) { // it's a security setting post
		if ($admin_security) $admin_security .= ',';
		$admin_security .= substr($key, 4) . ':' . (($fill_all == '-1') ? substr($_POST[$key], 0, 1) : $fill_all);
	  }
	}
	$sql_data_array = array(
	  'admin_name'     => db_prepare_input($_POST['admin_name']),
	  'inactive'       => isset($_POST['inactive']) ? '1' : '0',
	  'display_name'   => db_prepare_input($_POST['display_name']),
	  'admin_email'    => db_prepare_input($_POST['admin_email']),
	  'account_id'     => db_prepare_input($_POST['account_id']),
	  'admin_prefs'    => serialize($prefs),
	  'admin_security' => $admin_security,
	);
	if ($_POST['password_new']) { 
	  $password_new  = db_prepare_input($_POST['password_new']);
	  $password_conf = db_prepare_input($_POST['password_conf']);
	  if (strlen($password_new) < ENTRY_PASSWORD_MIN_LENGTH) {
		$error = true;
		$messageStack->add(ENTRY_PASSWORD_NEW_ERROR, 'error');
	  } else if ($password_new != $password_conf) {
		$error = true;
		$messageStack->add(ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING, 'error');
	  }
	  $sql_data_array['admin_pass'] = pw_encrypt_password($password_new);
	}
	if (!$error) {
	  if ($admin_id) {
		db_perform(TABLE_USERS, $sql_data_array, 'update', 'admin_id = ' . (int)$admin_id);
		gen_add_audit_log(GEN_LOG_USER_UPDATE . $admin_name);
	  } else {
		db_perform(TABLE_USERS, $sql_data_array);
		$admin_id = db_insert_id();
		gen_add_audit_log(GEN_LOG_USER_ADD . $admin_name);
	  }
	} elseif ($error) {
	  $action = 'edit';
	}
	$uInfo = new objectInfo($_POST);
	$uInfo->admin_security = $admin_security;
	break;

  case 'copy':
	if ($security_level < 4) {
	  $messageStack->add_session(ERROR_NO_PERMISSION,'error');
	  gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
	  break;
	}
	$admin_id = db_prepare_input($_GET['cID']);
	$new_name = db_prepare_input($_GET['name']);
	// check for duplicate user names
	$result = $db->Execute("select admin_name from " . TABLE_USERS . " where admin_name = '" . $new_name . "'");
	if ($result->Recordcount() > 0) {	// error and reload
	  $messageStack->add(GEN_ERROR_DUPLICATE_ID, 'error');
	  break;
	}

	$result   = $db->Execute("select * from " . TABLE_USERS . " where admin_id = " . $admin_id);
	$old_name = $result->fields['admin_name'];
	// clean up the fields (especially the system fields, retain the custom fields)
	$output_array = array();
	foreach ($result->fields as $key => $value) {
	  switch ($key) {
		case 'admin_id':	// Remove from write list fields
		case 'display_name':
		case 'admin_email':
		case 'admin_pass':
		case 'account_id':
		  break;
		case 'admin_name': // set the new user name
		  $output_array[$key] = $new_name;
		  break;
		default:
		  $output_array[$key] = $value;
	  }
	}
	db_perform(TABLE_USERS, $output_array, 'insert');
	$new_id = db_insert_id();
	$messageStack->add(GEN_MSG_COPY_SUCCESS, 'success');

	// now continue with newly copied item by editing it
	gen_add_audit_log(GEN_LOG_USER_COPY, $old_name . ' => ' . $new_name);
	$_POST['rowSeq'] = $new_id;	// set item pointer to new record
	$action = 'edit'; // fall through to edit case

  case 'edit':
	if (isset($_POST['rowSeq'])) $admin_id = db_prepare_input($_POST['rowSeq']);
	$result = $db->Execute("select * from " . TABLE_USERS . " where admin_id = " . (int)$admin_id);
	$result->fields['prefs'] = unserialize($result->fields['admin_prefs']);
	$uInfo = new objectInfo($result->fields);
	break;

  case 'delete':
	if ($security_level < 4) {
	  $messageStack->add_session(ERROR_NO_PERMISSION,'error');
	  gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
	  break;
	}
	$admin_id = (int)db_prepare_input($_POST['rowSeq']);
	// fetch the name for the audit log
	$result = $db->Execute("select admin_name from " . TABLE_USERS . " where admin_id = " . $admin_id);
	$db->Execute("delete from " . TABLE_USERS . " where admin_id = " . $admin_id);
	gen_add_audit_log(GEN_LOG_USER_DELETE . $result->fields['admin_id']);
	gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
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
$fill_all_values = array(
  array('id' => '-1', 'text' => GEN_HEADING_PLEASE_SELECT),
  array('id' => '0',  'text' => TEXT_NONE),
  array('id' => '1',  'text' => TEXT_READ_ONLY),
  array('id' => '2',  'text' => TEXT_ADD),
  array('id' => '3',  'text' => TEXT_EDIT),
  array('id' => '4',  'text' => TEXT_FULL),
);

$include_header = true; // include header flag
$include_footer = true; // include footer flag
$include_tabs = true;
$include_calendar = false;

switch ($action) {
  case 'new':
  case 'edit':
  case 'fill_all':
    $include_template = 'template_detail.php'; // include display template (required)
    define('PAGE_TITLE', HEADING_TITLE_USER_INFORMATION);
	break;
  default:
	// build the list header
	$heading_array = array(
	  'admin_name'   => GEN_USERNAME,
	  'inactive'     => TEXT_INACTIVE,
	  'display_name' => GEN_DISPLAY_NAME,
	  'admin_email'  => GEN_EMAIL);
	$result = html_heading_bar($heading_array, $_GET['list_order']);
	$list_header = $result['html_code'];
	$disp_order = $result['disp_order'];
	
	// build the list for the page selected
	$search_text = ($_GET['search_text'] == TEXT_SEARCH) ? '' : db_input(db_prepare_input($_GET['search_text']));
	if (isset($search_text) && gen_not_null($search_text)) {
	  $search_fields = array('admin_name', 'admin_email', 'display_name');
	  // hook for inserting new search fields to the query criteria.
	  if (is_array($extra_search_fields)) $search_fields = array_merge($search_fields, $extra_search_fields);
	  $search = ' where ' . implode(' like \'%' . $search_text . '%\' or ', $search_fields) . ' like \'%' . $search_text . '%\'';
	} else {
	  $search = '';
	}

	$field_list = array('admin_id', 'inactive', 'display_name', 'admin_name', 'admin_email');
			
	// hook to add new fields to the query return results
	if (is_array($extra_query_list_fields) > 0) $field_list = array_merge($field_list, $extra_query_list_fields);
	
	$query_raw = "select " . implode(', ', $field_list) . " from " . TABLE_USERS . $search . " order by $disp_order";
	
	$query_split  = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
	$query_result = $db->Execute($query_raw);

	$include_template = 'template_main.php'; // include display template (required)
	define('PAGE_TITLE', BOX_HEADING_USERS);
}

?>