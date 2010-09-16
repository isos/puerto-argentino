<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2010 PhreeSoft, LLC                               |
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
//  Path: /admin/soap/classes/confirm.php
//

class xml_confirm extends xml2Array {
  var $arrOutput = array();
  var $resParser;
  var $strXmlData;
	
  // class constructor
  function xml_confirm() {
  }

  function processXML($rawXML) {
	$rawXML = str_replace('&', '&amp;', $rawXML); // this character causes parser to break
//echo '<pre>' . $rawXML . '</pre><br>';
	if (!$this->parse($rawXML)) {
//echo '<pre>' . $rawXML . '</pre><br>';
//echo 'parsed string at shopping cart = '; print_r($this->arrOutput); echo '<br>';
	  return false;  // parse the submitted string, check for errors
	}
	// try to determine the language used, default to en_us
	$this->product['language'] = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','REQUESTHEADER','ORIGINATOR','LANGUAGE'), $this->arrOutput);
	if (file_exists('language/' . $this->product['language'] . '/language.php')) {
	  require ('language/' . $this->product['language'] . '/language.php');
	} else {
	  require ('language/en_us/language.php');
	}
	if (!$this->validateUser()) return false;
	if (!$this->formatArray())  return false;
	if (!$this->orderConfirm()) return false;
	return true;
  }

  function formatArray() { // specific to XML spec for a product sync
	// Here we map the received xml array to the pre-defined generic structure (application specific format later)
	$this->requested_function        = $this->getNodeData(array('ACCESSREQUEST','ACCESSFUNCTION'), $this->arrOutput);
	$this->request_version           = $this->getNodeData(array('ACCESSREQUEST','VERSION'), $this->arrOutput);
	// <RequestHeader>
	$this->product['action']         = $this->getNodeData(array('ACCESSREQUEST','ORDERCONFIRM','REQUESTHEADER','REQUESTACTION'), $this->arrOutput);
	$this->product['reference_name'] = $this->getNodeData(array('ACCESSREQUEST','ORDERCONFIRM','REQUESTHEADER','REFERENCENAME'), $this->arrOutput);
	// <ProductDetails>
	$itemArray = $this->getSubArray('ORDERS', $this->arrOutput);
	$tempArray = array();
	$this->sku_array = array();
	for ($i = 0; $i < count($itemArray); $i++) {
	  $tempArray[0] = $itemArray[$i]; // set to a single price level
	  $this->order_array[] = array(
	    'id'     => $this->getNodeData(array('ORDER','ID'),      $tempArray),
	    'msg'    => $this->getNodeData(array('ORDER','MESSAGE'), $tempArray),
		'status' => $this->getNodeData(array('ORDER','STATUS'),  $tempArray),
	  );
	}
	return true;
  }

// The remaining functions are specific to ZenCart. they need to be modified for the specific application.
// It also needs to check for errors, i.e. missing information, bad data, etc. 
  function orderConfirm() {
	global $db, $messageStack;
	// error check input
	if (sizeof($this->order_array) == 0)       return $this->responseXML('20', SOAP_NO_ORDERS_TO_CONFIRM, 'error');
	if ($this->product['action'] <> 'Confirm') return $this->responseXML('16', SOAP_BAD_ACTION, 'error');

    $order_cnt = 0;
	$order_list = array();
    foreach ($this->order_array as $value) { 
	  $result = $db->Execute("select orders_status from " . TABLE_ORDERS . " where orders_id = '" . (int)$value ['id'] . "'");
	  if ($result->RecordCount() == 0 || $result->fields['orders_status'] == $value['status']) continue; // skip this order, not a zencart order
//echo 'element = '; print_r($value); echo '<br>';
	  // insert a new status in the order status table
	  $db->Execute("insert into " . TABLE_ORDERS_STATUS_HISTORY . " set 
		orders_id = " . (int)$value ['id'] . ", 
		orders_status_id = " . zen_db_input($value['status']) . ", 
		date_added = now(), 
		customer_notified = '0', 
	    comments = '" . zen_db_input($value['msg']) . "'");
      // update the status in the orders table
	  $db->Execute("update " . TABLE_ORDERS . " set 
	    orders_status = " . zen_db_input($value['status']) . ",
		last_modified = now() 
		where orders_id = " . (int)$value ['id']);
	  $order_cnt++;
	  $order_list[] = $value ['id'];
	}
	$orders = (sizeof($order_list) > 0) ? (' (' . implode(', ', $order_list) . ')') : ''; 
	$this->responseXML('0', sprintf(SOAP_CONFIRM_SUCCESS, $order_cnt . $orders), 'success');
	return true;
  }
}
?>