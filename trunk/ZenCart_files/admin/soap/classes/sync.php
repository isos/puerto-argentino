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
//  Path: /admin/soap/classes/sync.php
//

class xml_sync extends xml2Array {
  var $arrOutput = array();
  var $resParser;
  var $strXmlData;
	
  // class constructor
  function xml_sync() {
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
	if (!$this->validateUser()) return false; // verify username and password
	if (!$this->formatArray())  return false; // format submitted string into products array, check for errors
	if (!$this->syncProducts()) return false;
	return true;
  }

  function formatArray() { // specific to XML spec for a product sync
	// Here we map the received xml array to the pre-defined generic structure (application specific format later)
	$this->requested_function        = $this->getNodeData(array('ACCESSREQUEST','ACCESSFUNCTION'), $this->arrOutput);
	$this->request_version           = $this->getNodeData(array('ACCESSREQUEST','VERSION'), $this->arrOutput);
	// <RequestHeader>
	$this->product['action']         = $this->getNodeData(array('ACCESSREQUEST','PRODUCTSYNC','REQUESTHEADER','REQUESTACTION'), $this->arrOutput);
	$this->product['reference_name'] = $this->getNodeData(array('ACCESSREQUEST','PRODUCTSYNC','REQUESTHEADER','REFERENCENAME'), $this->arrOutput);
	// <ProductDetails>
	$itemArray = $this->getSubArray('PRODUCTDETAILS', $this->arrOutput);
	$tempArray = array();
	$this->sku_array = array();
//echo 'number of skus = '; sizeof($itemArray); echo '<br>';
	for ($i = 0; $i < count($itemArray); $i++) {
	  $tempArray[0] = $itemArray[$i]; // set to a single price level
	  $this->sku_array[] = $this->getNodeData(array('SKU'), $tempArray);
	}
	return true;
  }

// The remaining functions are specific to ZenCart. they need to be modified for the specific application.
// It also needs to check for errors, i.e. missing information, bad data, etc. 
  function syncProducts() {
	global $db, $messageStack;
	// error check input
	if (sizeof($this->sku_array) == 0)          return $this->responseXML('20', SOAP_NO_SKUS_UPLOADED, 'error');
	if ($this->product['action'] <> 'Validate') return $this->responseXML('16', SOAP_BAD_ACTION, 'error');
	
	$result = $db->Execute("select phreebooks_sku from " . TABLE_PRODUCTS);
	$missing_skus = array();
	while(!$result->EOF) {
	  if (!in_array($result->fields['phreebooks_sku'], $this->sku_array)) {
		$missing_skus[] = $result->fields['phreebooks_sku'];
	  }
	  $result->MoveNext();
	}

	// make sure everything went as planned
	if (sizeof($missing_skus) > 0) {
	  $text = SOAP_SKUS_MISSING . implode(', ', $missing_skus);
	  return $this->responseXML('0', $text, 'caution');
	}

	$this->responseXML('0', SOAP_PRODUCTS_IN_SYNC, 'success');
	return true;
  }
}
?>