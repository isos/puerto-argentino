<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2009 PhreeSoft, LLC                               |
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
//  Path: /modules/rma/pages/main/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = $_SESSION['admin_security'][SECURITY_RMA_MGT];
if ($security_level == 0) { // not supposed to be here
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');
require(DIR_FS_WORKING . 'functions/rma.php'); 

/**************   page specific initialization  *************************/
// make sure the module is installed
$result = $db->Execute("SHOW TABLES LIKE '" . TABLE_RMA . "'");
if ($result->RecordCount() == 0) {
  $messageStack->add_session(RMA_MGR_NOT_INSTALLED,'caution');
  gen_redirect(html_href_link(FILENAME_DEFAULT, 'cat=rma&module=admin', 'SSL'));
}

$error = false;
$processed = false;
$cInfo = new objectInfo(array());
$creation_date = ($_POST['creation_date']) ? gen_db_date_short($_POST['creation_date']) : date('Y-m-d', time());
$receive_date  = ($_POST['receive_date'])  ? gen_db_date_short($_POST['receive_date'])  : '';
$closed_date   = ($_POST['closed_date'])   ? gen_db_date_short($_POST['closed_date'])   : '';
$search_text = ($_POST['search_text']) ? db_input(db_prepare_input($_POST['search_text'])) : db_input(db_prepare_input($_GET['search_text']));
if ($search_text == TEXT_SEARCH) $search_text = '';
$action = isset($_GET['action']) ? $_GET['action'] : $_POST['todo'];
if (!$action && $search_text <> '') $action = 'search'; // if enter key pressed and search not blank

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/rma/main/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
	if ($security_level < 3) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$id                  = db_prepare_input($_POST['rowSeq']);
	$rma_num             = db_prepare_input($_POST['rma_num']);
	$status              = db_prepare_input($_POST['status']);
	$entered_by          = db_prepare_input($_POST['entered_by']);
	$caller_name         = db_prepare_input($_POST['caller_name']);
	$caller_telephone1   = db_prepare_input($_POST['caller_telephone1']);
	$caller_email        = db_prepare_input($_POST['caller_email']);
	$purchase_invoice_id = db_prepare_input($_POST['purchase_invoice_id']);
	$return_code         = db_prepare_input($_POST['return_code']);
	$caller_notes        = db_prepare_input($_POST['caller_notes']);
	$received_by         = db_prepare_input($_POST['received_by']);
	$receive_carrier     = db_prepare_input($_POST['receive_carrier']);
	$receive_tracking    = db_prepare_input($_POST['receive_tracking']);
	$receive_notes       = db_prepare_input($_POST['receive_notes']);
	// load the item information
	$x = 1;
	while (isset($_POST['qty_' . $x])) { // while there are item rows to read in
	  if ($_POST['qty_' . $x]) {
		$cInfo->item_rows[] = array(
			'id'   => db_prepare_input($_POST['id_' . $x]),
			'qty'  => $currencies->clean_value(db_prepare_input($_POST['qty_' . $x]), $order->currencies_code),
			'sku'  => ($_POST['sku_' . $x] == TEXT_SEARCH) ? '' : db_prepare_input($_POST['sku_' . $x]),
			'desc' => db_prepare_input($_POST['desc_' . $x]),
			'actn' => db_prepare_input($_POST['actn_' . $x]),
		);
	  }
	  $x++;
	}
	// check for errors, process
	if ($status == 99 && $closed_date == '') $closed_date = date('Y-m-d', time());

	// write the data
	if (!$error) {
	  $sql_data_array = array(
	    'status'              => $status,
	    'entered_by'          => $entered_by,
	    'caller_name'         => $caller_name,
	    'caller_telephone1'   => $caller_telephone1,
	    'caller_email'        => $caller_email,
	    'purchase_invoice_id' => $purchase_invoice_id,
	    'return_code'         => $return_code,
	    'caller_notes'        => $caller_notes,
	    'received_by'         => $received_by,
	    'receive_carrier'     => $receive_carrier,
	    'receive_tracking'    => $receive_tracking,
	    'receive_notes'       => $receive_notes,
	    'creation_date'       => $creation_date,
	    'closed_date'         => $closed_date,
	    'receive_date'        => $receive_date,
	  );
	  // build the item list
      $sql_item_array = array();
	  $id_array = array();
	  if (is_array($cInfo->item_rows)) foreach ($cInfo->item_rows as $value) {
		$sql_item_array[] = array(
		  'id'          => $value['id'],
		  'qty'         => $value['qty'],
		  'sku'         => $value['sku'],
		  'item_action' => $value['actn'],
		  'item_notes'  => $value['desc'],
		);
		if ($value['id']) $id_array[] = $value['id'];
	  }
	  if ($id) {
	    $success = db_perform(TABLE_RMA, $sql_data_array, 'update', 'id = ' . $id);
		if ($success) gen_add_audit_log(RMA_LOG_USER_UPDATE . $rma_num);
		else $error = true;
	  } else {
	    // fetch the RMA number
		$result = $db->Execute("select next_rma_num from " . TABLE_CURRENT_STATUS);
		$rma_num = $result->fields['next_rma_num'];
		$sql_data_array['rma_num'] = $rma_num;
	    $success = db_perform(TABLE_RMA, $sql_data_array, 'insert');
		if ($success) {
		  $id = db_insert_id();
		  $next_num = string_increment($sql_data_array['rma_num']);
		  $db->Execute("update " . TABLE_CURRENT_STATUS . " set next_rma_num = '" . $next_num . "'");
		  gen_add_audit_log(RMA_LOG_USER_ADD . $rma_num);
		} else $error = true;
	  }
	  // update the item
	  if (!$error) {
		$result = $db->Execute("select id from " . TABLE_RMA_ITEM . " where ref_id = " . $id);
	    $current_id = array();
		while (!$result->EOF) {
		  $current_id[] = $result->fields['id'];
		  $result->MoveNext();
		}
		if (sizeof($current_id) > 0) {
		  $diff = array_diff($current_id, $id_array);
		  if (sizeof($diff) > 0) {
		    $db->Execute("delete from " . TABLE_RMA_ITEM . " where id in (" . implode(',', $diff) . ")");
		  }
		}
		foreach($sql_item_array as $value) {
		  $value['ref_id'] = $id;
		  if ($value['id']) {
	        $success = db_perform(TABLE_RMA_ITEM, $value, 'update', 'id = ' . $value['id']);
		  } else {
	        $success = db_perform(TABLE_RMA_ITEM, $value, 'insert');
		  }
		}
	  }
	  if (!$error) {
	    $messageStack->add(($_POST['rowSeq'] ? RMA_MESSAGE_SUCCESS_UPDATE : RMA_MESSAGE_SUCCESS_ADD) . $rma_num,'success');
	  } else {
	    $messageStack->add(RMA_MESSAGE_ERROR, 'error');
	  }
	}
	break;

  case 'edit':
    $id = db_prepare_input($_POST['rowSeq']);
	$result = $db->Execute("select * from " . TABLE_RMA . " where id = " . $id);
	$cInfo = new objectInfo($result->fields);
	$result = $db->Execute("select * from " . TABLE_RMA_ITEM . " where ref_id = " . $id);
	if ($result->RecordCount() > 0) {
	  $cInfo->item_rows = array();
	  while (!$result->EOF) {
	    $cInfo->item_rows[] = array(
		  'id'   => $result->fields['id'],
		  'qty'  => $result->fields['qty'],
		  'sku'  => $result->fields['sku'],
		  'actn' => $result->fields['item_action'],
		  'desc' => $result->fields['item_notes'],
		);
		$result->MoveNext();
	  }
	}
	break;

  case 'delete':
	if ($security_level < 4) {
		$messageStack->add_session(ERROR_NO_PERMISSION,'error');
		gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL'));
		break;
	}
	$id = db_prepare_input($_GET['cID']);

	$result = $db->Execute("select rma_num from " . TABLE_RMA . " where id = " . $id);
	if ($result->RecordCount() > 0) {
	  $db->Execute("delete from " . TABLE_RMA . " where id = " . $id);
	  $db->Execute("delete from " . TABLE_RMA_ITEM . " where ref_id = " . $id);
	  gen_add_audit_log(RMA_MESSAGE_DELETE, $result->fields['rma_num']);
	  gen_redirect(html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('cID', 'action')), 'SSL'));
	} else {
	  $messageStack->add(RMA_ERROR_CANNOT_DELETE, 'error');
	}
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
// build disposition drop-dwn javascript
$js_disp_code  = 'js_disp_code = new Array(' . sizeof($action_codes) . ');' . chr(10);
$js_disp_value = 'js_disp_value = new Array(' . sizeof($action_codes) . ');' . chr(10);
$i = 0;
foreach ($action_codes as $key => $value) {
	$js_disp_code .= 'js_disp_code[' . $i . '] = "' . $key . '";' . chr(10);
	$js_disp_value .= 'js_disp_value[' . $i . '] = "' . gen_js_encode($value) . '";' . chr(10);
	$i++;
}

$include_header = true;
$include_footer = true;
$include_calendar = true;
$include_tabs = false;

switch ($action) {
  case 'new':
    // set some defaults
    $cInfo->creation_date = date('Y-m-d', time());
    $cInfo->status = '1';
  case 'edit':
    define('PAGE_TITLE', BOX_RMA_MAINTAIN);
    $include_template = 'template_detail.php';
    break;
  default:
    // build the list header
	$heading_array = array(
		'rma_num' => TEXT_RMA_ID,
		'creation_date' => TEXT_CREATION_DATE,
		'caller_name' => TEXT_CALLER_NAME,
		'purchase_invoice_id' => TEXT_INVOICE,
		'status' => TEXT_STATUS,
		'closed_date' => TEXT_CLOSED_DATE,
	);
	$result = html_heading_bar($heading_array, $_GET['list_order']);
	$list_header = $result['html_code'];
	$disp_order = $result['disp_order'];
	if (!isset($_GET['disp_order'])) $disp_order = 'rma_num DESC';

	// build the list for the page selected
    if (isset($search_text) && gen_not_null($search_text)) {
      $search_fields = array('rma_num', 'purchase_invoice_id', 'caller_name', 'caller_telephone1');
	  // hook for inserting new search fields to the query criteria.
	  if (is_array($extra_search_fields)) $search_fields = array_merge($search_fields, $extra_search_fields);
	  $search = ' where ' . implode(' like \'%' . $search_text . '%\' or ', $search_fields) . ' like \'%' . $search_text . '%\'';
    } else {
	  $search = '';
	}

	$field_list = array('id', 'rma_num', 'purchase_invoice_id', 'status', 'caller_name', 'creation_date', 'closed_date');

	// hook to add new fields to the query return results
	if (is_array($extra_query_list_fields) > 0) $field_list = array_merge($field_list, $extra_query_list_fields);

    $query_raw = "select " . implode(', ', $field_list)  . " from " . TABLE_RMA . $search . " order by $disp_order, rma_num";

    $query_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $query_raw, $query_numrows);
    $query_result = $db->Execute($query_raw);

	define('PAGE_TITLE', BOX_RMA_MAINTAIN);
    $include_template = 'template_main.php';
	break;
}

?>