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
//  Path: /modules/services/pages/imp_exp/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_ID_IMPORT_EXPORT];
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'import_export/language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_MODULES . 'reportwriter/language/'  . $_SESSION['language'] . '/language.php'); // error messages, qualifiers
require(DIR_FS_WORKING . 'import_export/functions/import_export.php');

/**************   page specific initialization  *************************/
$default_tab = 'criteria';

$action = $_POST['todo'];
$id = (int)db_prepare_input($_POST['id']);
if ((!$id && $action) && ($action <> 'new')) { // action without a report to work on
	$messageStack->add_session(SRV_NO_DEF_SELECTED, 'error');
	gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
}
// read the defaults
$sql = "select id, group_id, custom, security, title, description, table_name, primary_key_field,
	params, criteria, options from " . TABLE_IMPORT_EXPORT . " where id = " . $id;
$definitions = $db->Execute($sql);
// read user choices from form
$form_data = ie_read_io_form_data();
$params = unserialize($definitions->fields['params']);
//		$params = $form_data['params'];
$criteria = $form_data['criteria'];
$options = $form_data['options'];

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/services/imp_exp/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'new':
	$messageStack->add('New Import/Export definition functionality has not be written','error');
	$action = '';
	break;
  case 'open': // fetch the details of the particular imp/exp request
	$sql = "select id, group_id, custom, security, title, description, table_name, primary_key_field,
		params, criteria, options from " . TABLE_IMPORT_EXPORT . " where id = " . $id;
	$definitions = $db->Execute($sql);
	$params = unserialize($definitions->fields['params']);
	$criteria = unserialize($definitions->fields['criteria']);
	$options = unserialize($definitions->fields['options']);
	$params = ie_sync_field_list($params, $definitions->fields['table_name']);
	$sql_data_array = array('params' => serialize($params));
	db_perform(TABLE_IMPORT_EXPORT, $sql_data_array, 'update', "id = " . $id);
	break;
  case 'import':
	if ($security_level < 2) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$result = ie_import_data($definitions->fields, $params, $criteria, $options);
	gen_add_audit_log(IE_LOG_MESSAGE . TEXT_IMPORT, $definitions->fields['title']);
	break;
  case 'export':
	ie_export_data($definitions->fields, $params, $criteria, $options);
	gen_add_audit_log(IE_LOG_MESSAGE . TEXT_EXPORT, $definitions->fields['title']);
	break;
  case 'delete': // deletes an import/export definition
	if ($security_level < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	if ($definitions->fields['custom'] <> '0') {
		$db->Execute("delete from " . TABLE_IMPORT_EXPORT . " where id = " . $id);
		gen_add_audit_log(IE_LOG_MESSAGE . TEXT_DELETE, $definitions->fields['title']);
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
	} else {
		$messageStack->add(IE_ERROR_NO_DELETE, 'error');
	}
    break;
  case 'save':
	if ($security_level < 2) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$sql_data_array = array(
		'params' => serialize($params),
		'criteria' => serialize($criteria),
		'options' => serialize($options));
	db_perform(TABLE_IMPORT_EXPORT, $sql_data_array, 'update', "id = '" . $id . "'");
	gen_add_audit_log(IE_LOG_MESSAGE . TEXT_UPDATE, $definitions->fields['title']);
	break;
  case 'rename':
    if ($security_level < 2) {
	  $messageStack->add_session(ERROR_NO_PERMISSION,'error');
	  gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
	  break;
    }
    $definition_name = db_prepare_input($_POST['definition_name']);
    $definition_description = db_prepare_input($_POST['definition_description']);
    if (!gen_not_null($definition_name)) {
	  $messageStack->add(IE_ERROR_NO_NAME, 'error');
      $action = '';
	  break;
    }
    $duplicates = $db->Execute("select id from " . TABLE_IMPORT_EXPORT . " where title = '" . $definition_name . "'");
    if ($duplicates->RecordCount() > 0) {
	  $error = false;
	  while (!$duplicates->EOF) {
	    if ($duplicates->fields['id'] <> $id) { // only if duplicate name of different definition (allow name to remain the same)
	      $messageStack->add(IE_ERROR_DUPLICATE_NAME, 'error');
          $sql = "select id, group_id, custom, security, title, description, table_name, primary_key_field 
	      from " . TABLE_IMPORT_EXPORT . " where id = '" . $id . "'";
          $definitions = $db->Execute($sql);
	      $action = '';
		  $error = true;
		  break;
	    }
		$duplicates->MoveNext();
	  }
	  if ($error) break;
    }
    $sql_data_array = array(
	  'group_id'          => $definitions->fields['group_id'],
	  'custom'            => '1',
	  'security'          => $definitions->fields['security'],
	  'title'             => $definition_name,
	  'description'       => $definition_description,
	  'table_name'        => $definitions->fields['table_name'],
	  'primary_key_field' => $definitions->fields['primary_key_field'],
	  'params'            => serialize($params),
	  'criteria'          => serialize($criteria),
	  'options'           => serialize($options)
	  );
    db_perform(TABLE_IMPORT_EXPORT, $sql_data_array, 'update', "id = " . $id);
    gen_add_audit_log(IE_LOG_MESSAGE . TEXT_RENAME, $definitions->fields['title']);
    break;
  case 'copy':
    if ($security_level < 2) {
	  $messageStack->add_session(ERROR_NO_PERMISSION,'error');
	  gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
	  break;
    }
    $definition_name = db_prepare_input($_POST['definition_name']);
    $definition_description = db_prepare_input($_POST['definition_description']);
    if (!gen_not_null($definition_name)) {
	  $messageStack->add(IE_ERROR_NO_NAME, 'error');
	  break;
    }
    $duplicates = $db->Execute("select id from " . TABLE_IMPORT_EXPORT . " where title = '" . $definition_name . "'");
    if ($duplicates->RecordCount() > 0) {
	  $messageStack->add(IE_ERROR_DUPLICATE_NAME, 'error');
	  break;
    }
    $sql_data_array = array(
	  'group_id'          => $definitions->fields['group_id'],
	  'custom'            => '1',
	  'security'          => $definitions->fields['security'],
	  'title'             => $definition_name,
	  'description'       => $definition_description,
	  'table_name'        => $definitions->fields['table_name'],
	  'primary_key_field' => $definitions->fields['primary_key_field'],
	  'params'            => serialize($params),
	  'criteria'          => serialize($criteria),
	  'options'           => serialize($options)
	  );
    db_perform(TABLE_IMPORT_EXPORT, $sql_data_array, 'insert');
    $id = db_insert_id();
    $sql = "select id, group_id, custom, security, title, description, table_name, primary_key_field 
	  from " . TABLE_IMPORT_EXPORT . " where id = '" . $id . "'";
    $definitions = $db->Execute($sql);
    gen_add_audit_log(IE_LOG_MESSAGE . TEXT_COPY, $definitions->fields['title']);
    break;
  case 'add':
    $index = is_array($criteria) ? count($criteria) : 0;
    $criteria[$index]['cfield'] = $form_data['new_crit']['new_cname'];
    $criteria[$index]['ctype']  = $form_data['new_crit']['new_crit'];
    break;
  case 'remove':
    $key = $_POST['rowSeq'];
    $trash = array_splice($criteria, $key, 1);
    break;
  case 'up':
    $key = $_POST['rowSeq'];
    if ($key > 0) {
	  $temp = $params[$key];
	  $params[$key] = $params[$key - 1];
	  $params[$key - 1] = $temp;
    }
    // save the new order to the db
    db_perform(TABLE_IMPORT_EXPORT, array('params' => serialize($params)), 'update', "id = " . $id);
    $default_tab = 'fields';
    break;
  case 'down':
    $key = $_POST['rowSeq'];
    if ($key < (count($params) - 1)) {
	  $temp = $params[$key];
	  $params[$key] = $params[$key + 1];
	  $params[$key + 1] = $temp;
    }
    // save the new order to the db
    db_perform(TABLE_IMPORT_EXPORT, array('params' => serialize($params)), 'update', "id = " . $id);
    $default_tab = 'fields';
    break;
  case 'move':
    $key = $_POST['rowSeq'];
    $new_key = $_POST['moveSeq'];
    if ($new_key > 0 && $new_key <= count($params)) {
  	  // pull the record to move and remove it from the array
	  $temp = $params[$key];
	  $arrTemp1 = array_slice($params, 0, $key);
	  $arrTemp2 = array_slice($params, $key + 1);
	  $params   = array_merge($arrTemp1, $arrTemp2);
	  // put it back together with the new data
	  $arrTemp1 = array_slice($params, 0, $new_key - 1);
	  $arrTemp2 = array_slice($params, $new_key - 1);
	  $params   = array_merge($arrTemp1, array($temp), $arrTemp2);
    }
    // save the new order to the db
    db_perform(TABLE_IMPORT_EXPORT, array('params' => serialize($params)), 'update', "id = " . $id);
    $default_tab = 'fields';
    break;
  default:
}

/*****************   prepare to display templates  *************************/
$include_header   = true;
$include_footer   = true;
$include_tabs     = true;
$include_calendar = false;

if ($action) {
  $include_template = 'template_detail.php';
  define('PAGE_TITLE', IE_HEADING_TITLE_CRITERIA . ' - ' . $definitions->fields['title']);
} else {
  $include_template = 'template_main.php';
  define('PAGE_TITLE', IE_HEADING_TITLE);
}
?>