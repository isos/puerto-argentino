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
//  Path: /soap/classes/inventory.php
//

class xml_inventory extends xml2Array {
   var $arrOutput = array();
   var $resParser;
   var $strXmlData;
	
	// class constructor
	function xml_inventory() {
		$this->item = array();
		$this->bom = array();
	}

	function processXML($rawXML) {
//echo '<pre>' . $rawXML . '</pre>';
		if (!$this->parse($rawXML)) return false;  // parse the submitted string, check for errors
//echo 'parsed string = '; print_r($this->arrOutput); echo '<br />';
		$this->username = $this->getNodeData(array('ACCESSREQUEST','ACCESSUSERID'), $this->arrOutput);
//echo 'username = ' . $this->username . '<br /><br />';
		$this->password = $this->getNodeData(array('ACCESSREQUEST','ACCESSPASSWORD'), $this->arrOutput);
		if (!$this->validateUser($this->username, $this->password)) return false;  // verify username and password
//echo 'user was validated<br />';
		if (!$this->formatArray()) return false;    // format submitted string into inventory array, check for errors
//echo 'inventory array was formatted<br />';
		if (!$this->buildInventoryItem()) return false;
//echo 'inventory item was inserted<br />';
		return true;
	}

	function formatArray() {
		global $db, $messageStack, $currencies;
		$this->order = array();
		// Here we map the received xml array to the pre-defined generic structure (application specific format later)
		// <AccessRequest>
		$this->request_function = $this->getNodeData(array('ACCESSREQUEST','ACCESSFUNCTION'), $this->arrOutput);
		$this->action = $this->getNodeData(array('ACCESSREQUEST','ACCESSACTION'), $this->arrOutput);
		// <Originator>
		$this->item['sku'] = $this->getNodeData(array('ACCESSREQUEST','INVENTORYITEMENTRY','ITEMDETAILS','ITEMID'), $this->arrOutput);
		$inventory_type = strtoupper($this->getNodeData(array('ACCESSREQUEST','INVENTORYITEMENTRY','ITEMDETAILS','ITEMTYPE'), $this->arrOutput));
		switch ($inventory_type) {
		  case 'STOCKITEM': $this->item['inventory_type'] = 'si'; break;
		  case 'SERIALIZEDITEM': $this->item['inventory_type'] = 'sr'; break;
		  case 'MASTERSTOCKITEM': $this->item['inventory_type'] = 'ms'; break;
		  case 'ITEMASSEMBLY': $this->item['inventory_type'] = 'as'; break;
		  case 'NONSTOCKITEM': $this->item['inventory_type'] = 'ns'; break;
		  case 'LABOR': $this->item['inventory_type'] = 'lb'; break;
		  case 'SERVICE': $this->item['inventory_type'] = 'sv'; break;
		  case 'CAHRGEITEM': $this->item['inventory_type'] = 'ci'; break;
		  case 'ACTIVITYITEM': $this->item['inventory_type'] = 'ai'; break;
		  case 'DESCRIPTION': $this->item['inventory_type'] = 'ds'; break;
		}
		$this->item['description_short'] = $this->getNodeData(array('ACCESSREQUEST','INVENTORYITEMENTRY','ITEMDETAILS','SHORTDESCRIPTION'), $this->arrOutput);
		$this->item['description_purchase'] = $this->getNodeData(array('ACCESSREQUEST','INVENTORYITEMENTRY','ITEMDETAILS','PURCHASEDESCRIPTION'), $this->arrOutput);
		$this->item['minimum_stock_level'] = $this->getNodeData(array('ACCESSREQUEST','INVENTORYITEMENTRY','ITEMDETAILS','MINIMUMSTOCK'), $this->arrOutput);
		$this->item['full_price'] = $this->getNodeData(array('ACCESSREQUEST','INVENTORYITEMENTRY','ITEMDETAILS','LISTPRICE'), $this->arrOutput);
		$this->item['item_cost'] = $this->getNodeData(array('ACCESSREQUEST','INVENTORYITEMENTRY','ITEMDETAILS','ITEMCOST'), $this->arrOutput);
		$this->item['item_weight'] = $this->getNodeData(array('ACCESSREQUEST','INVENTORYITEMENTRY','ITEMDETAILS','ITEMWEIGHT'), $this->arrOutput);
		$this->item['reorder_quantity'] = $this->getNodeData(array('ACCESSREQUEST','INVENTORYITEMENTRY','ITEMDETAILS','REORDERQUANTITY'), $this->arrOutput);
// TBD vendor_id needs to be translated
		$this->item['vendor_id'] = $this->getNodeData(array('ACCESSREQUEST','INVENTORYITEMENTRY','ITEMDETAILS','PREFERREDVENDOR'), $this->arrOutput);
		$this->item['lead_time'] = $this->getNodeData(array('ACCESSREQUEST','INVENTORYITEMENTRY','ITEMDETAILS','PURCHASELEADTIME'), $this->arrOutput);
		// build image with path
		$path = $this->getNodeData(array('ACCESSREQUEST','INVENTORYITEMENTRY','IMAGE','FILEPATH'), $this->arrOutput);
		$filename = $this->getNodeData(array('ACCESSREQUEST','INVENTORYITEMENTRY','IMAGE','FILENAME'), $this->arrOutput);
		$this->item['image_with_path'] = $path . $filename;
		$this->imagebase64 = $this->getNodeData(array('ACCESSREQUEST','INVENTORYITEMENTRY','IMAGE','IMAGEBASE64'), $this->arrOutput);
		// Extra defines 
// TBD default gl_accts
		// custom fields
// TBD
		// <BOM>
		if ($this->item['inventory_type'] == 'as') {
		  $bomArray = $this->getSubArray('BILLOFMATERIALS', $this->arrOutput);
		  $tempArray = array();
		  for ($i = 0; $i < count($bomArray); $i++) {
			$tempArray[0] = $bomArray[$i]; // set to a single line item
			$this->bom[] = array(
			  'sku' => $this->getNodeData(array('BOMITEM','ITEMID'), $tempArray),
			  'description' => $this->getNodeData(array('BOMITEM','DESCRIPTION'), $tempArray),
			  'qty' => $this->getNodeData(array('BOMITEM','QUANTITY'), $tempArray)
			);
		  }
		}
		// Master Stock Items
// TBD
		
		return true;
	}

	function responseXML($code, $text, $level) {
		$strResponse = '';
		$strResponse .= '<?xml version="1.0" encoding="UTF-8" ?>' . chr(10);
		$strResponse .= '<AccessResponse>' . chr(10);
		$strResponse .= '<AccessFunction>InventoryItemEntryResponse</AccessFunction>' . chr(10);
		$strResponse .= '<Version>1.00</Version>' . chr(10);

		switch ($level) {
			case 'error':
				$strResponse .= '<Result>error</Result>' . chr(10);
				$strResponse .= '<ResultCode>' . $code . '</ResultCode>' . chr(10);
				$strResponse .= '<ResultText>' . $text . '</ResultText>' . chr(10);
				break;
			case 'success':
				$strResponse .= '<Result>success</Result>' . chr(10);
				$strResponse .= '<ResultCode>' . $code . '</ResultCode>' . chr(10);
				$strResponse .= '<ResultText>' . $text . '</ResultText>' . chr(10);
				break;
			default:
				$strResponse .= '<Result>error</Result>' . chr(10);
				$strResponse .= '<ResultCode>' . $code . '</ResultCode>' . chr(10);
				$strResponse .= '<ResultText>' . SOAP_UNEXPECTED_ERROR . '</ResultText>' . chr(10);
		}

		$strResponse .= '</AccessResponse>';
		echo $strResponse;
		return false;
	}

// The remaining functions are specific to PhreeBooks. They need to be modified for the specific application.
// It also needs to check for errors, i.e. missing information, bad data, etc. 
	function buildInventoryItem() {
		global $db, $messageStack, $currencies;
		// set some defaults if not present
		if ($this->order['receivables_gl_acct'] <> '') { // see if requestor specifies a AR account else use default
			define('DEF_GL_ACCT',$this->order['receivables_gl_acct']);
		} else {
			define('DEF_GL_ACCT',AR_DEFAULT_GL_ACCT);
		}
		
		// error check input
		// check to see if it exists already
		$result = $db->Execute("select sku from " . TABLE_INVENTORY . " where sku = '" . $this->item['sku'] . "'");
		if ($result->RecordCount() > 0) return $this->responseXML('INV10', sprintf('The sku cannot be created, it already exists in the database: %s', $this->item['sku']), 'error');
		// if assembly, check bom list
		if (is_array($this->bom)) {
		  foreach ($this->bom as $value) {
			$result = $db->Execute("select sku from " . TABLE_INVENTORY . " where sku = '" . $value['sku'] . "'");
			if ($result->RecordCount() <> 1) return $this->responseXML('INV11', sprintf('Could not find Bill of Materials SKU: %s', $value['sku']), 'error');
			if ($value['qty'] <= 0) return $this->responseXML('INV12', sprintf('Quantity must be greater than zero for Bill of Materials SKU: %s', $value['sku']), 'error');
		  }
		}
		
		// if all ok, create the new inventory item
//echo 'ready to create item =><br />'; print_r($this->item); echo '<br />';
		db_perform(TABLE_INVENTORY, $this->item, 'insert');
		// enter the bom, if needed
		if (is_array($this->bom)) {
		  // retrieve newly created record id for linking bom to sku
		  $inv_id = db_insert_id();
		  for ($i = 0; $i < count($this->bom); $i++) {
			$this->bom[$i]['ref_id'] = $inv_id;
//			db_perform(TABLE_INVENTORY_ASSY_LIST, $this->bom[$i], 'insert');
		  }
		}
		// enter the master stock items, if needed
// TBD

//		gen_add_audit_log('XML Inventory Item Added', $this->item['sku']);
		$this->responseXML('0', sprintf(SOAP_INV_SUCCESS, $this->item['sku']), 'success');
		return true;
	}
}
?>