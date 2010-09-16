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
//  Path: /my_files/custom/zencart/classes/zencart.php
//

class zencart extends parser {
  var $arrOutput = array();
  var $resParser;
  var $strXML;

  function zencart() {
  }

  function submitXML($id, $action = '', $hide_success = false, $inc_image = true) {
	global $messageStack;
	switch ($action) {
	  case 'product_ul': 
		if (!$this->buildProductUploadXML($id, $inc_image = true)) return false;
		$url = 'products.php';
		break;
	  case 'product_sync':
		if (!$this->buildProductSyncXML()) return false;
		$url = 'sync.php';
		break;
	  case 'confirm':
		if (!$this->buildConfirmXML()) return false;
		$url = 'confirm.php';
		break;
	  default:
		$messageStack->add(ZENCART_INVALID_ACTION, 'error');
		return false;
	}
//echo 'Submit XML string = <pre>' . $this->strXML . '</pre><br>';
	$this->response = $this->doCURLRequest('POST', ZENCART_URL . '/soap/' . $url, $this->strXML);
//echo 'XML response (at the PhreeBooks side from Zencart) => <pre>' . htmlspecialchars($this->response) . '</pre><br>' . chr(10);
	if (!$this->response) return false;
	if (!$this->parse($this->response)) {
//$messageStack->add('bad sku = ' . substr($this->strXML, strpos($this->strXML, '<SKU>') + 5, 18), 'caution');
	  return false;  // parse the response string, check for errors
	}
//echo 'Parsed string = '; print_r($this->arrOutput); echo '<br>';
	$this->result = $this->getNodeData(array('ACCESSRESPONSE','RESULT'),     $this->arrOutput);
	$this->code   = $this->getNodeData(array('ACCESSRESPONSE','RESULTCODE'), $this->arrOutput);
	$this->text   = $this->getNodeData(array('ACCESSRESPONSE','RESULTTEXT'), $this->arrOutput);
	if ($this->code == 0) {
	  if (!$hide_success) $messageStack->add($this->text, strtolower($this->result));
	  return true;
	} else {
	  $messageStack->add(ZENCART_TEXT_ERROR . $this->code . ' - ' . $this->text, strtolower($this->result));
	  return false;
	}
  }

/*************************************************************************************/
//                           Product Upload XML string generation
/*************************************************************************************/
  function buildProductUploadXML($id, $inc_image = true) {
	global $db, $currencies, $messageStack;
	$result = $db->Execute("select * from " . TABLE_INVENTORY . " where id = " . $id);
	if ($result->RecordCount() <> 1) {
	  $messageStack->add(ZENCART_INVALID_SKU,'error');
	  return false;
	}
	$this->sku = $result->fields['sku'];
	if (ZENCART_USE_PRICE_SHEETS == '1') {
	  $sql = "select id, default_levels from " . TABLE_PRICE_SHEETS . " 
		where '" . date('Y-m-d',time()) . "' >= effective_date 
		and sheet_name = '" . ZENCART_PRICE_SHEET . "' and inactive = '0'";
	  $default_levels = $db->Execute($sql);
	  if ($default_levels->RecordCount() == 0) {
		$messageStack->add(ZENCART_ERROR_NO_PRICE_SHEET . ZENCART_PRICE_SHEET, 'error');
		return false;
	  }
	  $sql = "select price_levels from " . TABLE_INVENTORY_SPECIAL_PRICES . " 
		where inventory_id = " . $id . " and price_sheet_id = " . $default_levels->fields['id'];
	  $special_levels = $db->Execute($sql);
	  if ($special_levels->RecordCount() > 0) {
		$price_levels = $special_levels->fields['price_levels'];
	  } else {
		$price_levels = $default_levels->fields['default_levels'];
	  }
	}

	// prepare some information before assembling string
	if ($inc_image && $result->fields['image_with_path']) { // image file
	  $filename = DIR_FS_MY_FILES . $_SESSION['company'] . '/inventory/images/' . $result->fields['image_with_path'];
	  if (file_exists($filename)) {
		if ($handle = fopen($filename, "rb")) {
		  $contents = fread($handle, filesize($filename));
		  fclose($handle);
		  // Zencart only support one level, so we'll use the first path dir and filename only 
		  $temp = explode('/', $result->fields['image_with_path']);
		  if (sizeof($temp) > 1) { 
		    $image_path     = $temp[0];
		    $image_filename = array_pop($temp);
		  } else {
		    $image_path     = '';
		    $image_filename = $temp[0];
		  }
		  $image_data = base64_encode($contents);
		}
	  } else {
		unset($image_data);
	  }
	}
	// url encode all of the values to avoid upload bugs
	foreach ($result->fields as $key => $value) {
	  $result->fields[$key] = urlencode($result->fields[$key]);
	}

	$this->strXML = '<?xml version="1.0" encoding="iso-8859-1" ?>' . chr(10);
	$this->strXML .= '<AccessRequest>' . chr(10);
	$this->strXML .= '<AccessUserID>' . ZENCART_USERNAME . '</AccessUserID>' . chr(10);
	$this->strXML .= '<AccessPassword>' . ZENCART_PASSWORD . '</AccessPassword>' . chr(10);
	$this->strXML .= '<AccessFunction>ProductUpload</AccessFunction>' . chr(10);
	$this->strXML .= '<Version>1.00</Version>' . chr(10);
	$this->strXML .= '<ProductUpload>' . chr(10);
	$this->strXML .= '<RequestHeader>' . chr(10);
	$this->strXML .= '<RequestAction>InsertUpdate</RequestAction>' . chr(10);
	$this->strXML .= '<ReferenceName>Product Upload sku: ' . $result->fields['sku'] . '</ReferenceName>' . chr(10);
	$this->strXML .= '<Originator>' . chr(10);
//	$this->strXML .= '<StoreID>' . ZENCART_STORE_ID . '</StoreID>' . chr(10);
//	$this->strXML .= '<SalesRepID>' . ZENCART_SALES_REP_ID . '</SalesRepID>' . chr(10);
	$this->strXML .= '<Language>' . $_SESSION['language'] . '</Language>' . chr(10);
	$this->strXML .= '</Originator>' . chr(10);
	$this->strXML .= '</RequestHeader>' . chr(10);
	$this->strXML .= '<ProductInformation>' . chr(10);
	$this->strXML .= '<SKU>' . $result->fields['sku'] . '</SKU>' . chr(10);

// Specific to Zencart
	$this->strXML .= '<ProductVirtual>0</ProductVirtual>' . chr(10);
	$this->strXML .= '<ProductStatus>' . ($result->fields['inactive'] ? '0' : '1') . '</ProductStatus>' . chr(10);
	$this->strXML .= '<ProductFreeShipping>0</ProductFreeShipping>' . chr(10);
	$this->strXML .= '<ProductHidePrice>0</ProductHidePrice>' . chr(10);
	$this->strXML .= '<ProductCategory>' . $result->fields['category_id'] . '</ProductCategory>' . chr(10);
	$this->strXML .= '<ProductSortOrder>' . $result->fields['id'] . '</ProductSortOrder>' . chr(10);
// End specific to Zencart

// TBD need to map ProductType
	$this->strXML .= '<ProductType>Product - General</ProductType>' . chr(10);
	$this->strXML .= '<ProductName>' . $result->fields['description_short'] . '</ProductName>' . chr(10);
	$this->strXML .= '<ProductModel>' . $result->fields['description_short'] . '</ProductModel>' . chr(10);
	$this->strXML .= '<ProductDescription>' . $result->fields['description_sales'] . '</ProductDescription>' . chr(10);
	$this->strXML .= '<ProductURL>' . $result->fields['spec_file'] . '</ProductURL>' . chr(10);
	if (isset($image_data)) {
	  $this->strXML .= '<ProductImageDirectory>' . $image_path . '</ProductImageDirectory>' . chr(10);
	  $this->strXML .= '<ProductImageFileName>' . $image_filename . '</ProductImageFileName>' . chr(10);
	  $this->strXML .= '<ProductImageData>' . $image_data . '</ProductImageData>' . chr(10);
	}
// TBD need mappping for TaxClassType
	$this->strXML .= '<ProductTaxable>' . ($result->fields['item_taxable'] ? 'True' : 'False') . '</ProductTaxable>' . chr(10);
	$this->strXML .= '<TaxClassType>' . ZENCART_PRODUCT_TAX_CLASS . '</TaxClassType>' . chr(10);
	// Price Levels
	$this->strXML .= '<ProductPrice>' . chr(10);
	$this->strXML .= '<MSRPrice>' . $result->fields['full_price'] . '</MSRPrice>' . chr(10);
	$this->strXML .= '<RetailPrice>' . $result->fields['full_price'] . '</RetailPrice>' . chr(10);
	if (ZENCART_USE_PRICE_SHEETS) {
	  $this->strXML .= '<PriceDiscounts>' . chr(10);
	  $this->strXML .= '<PriceDiscountType>2</PriceDiscountType>' . chr(10); // set to actual price type
	  $prices = inv_calculate_prices($result->fields['item_cost'], $result->fields['full_price'], $price_levels);
	  foreach ($prices as $level => $amount) {
		$this->strXML .= '<PriceLevel>' . chr(10);
		$this->strXML .= '<DiscountLevel>' . ($level + 1) . '</DiscountLevel>' . chr(10);
		$this->strXML .= '<Quantity>' . $amount['qty'] . '</Quantity>' . chr(10);
		$this->strXML .= '<Amount>' . $currencies->clean_value($amount['price']) . '</Amount>' . chr(10);
		$this->strXML .= '</PriceLevel>' . chr(10);
	  }
	  $this->strXML .= '</PriceDiscounts>' . chr(10);
	} else {
	  $this->strXML .= '<PriceDiscounts>' . chr(10);
	  $this->strXML .= '<PriceDiscountType>0</PriceDiscountType>' . chr(10); // clear qty discount flag
	  $this->strXML .= '</PriceDiscounts>' . chr(10);
	}
	$this->strXML .= '</ProductPrice>' . chr(10);
	$this->strXML .= '<ProductWeight>' . $result->fields['item_weight'] . '</ProductWeight>' . chr(10);
	$this->strXML .= '<DateAdded>' . $result->fields['creation_date'] . '</DateAdded>' . chr(10);
	$this->strXML .= '<DateUpdated>' . $result->fields['last_update'] . '</DateUpdated>' . chr(10);
//		$this->strXML .= '<DateAvailable>' . $result->fields['creation_date'] . '</DateAvailable>' . chr(10);
	$this->strXML .= '<StockLevel>' . $result->fields['quantity_on_hand'] . '</StockLevel>' . chr(10);
	$this->strXML .= '<Manufacturer>' . $result->fields['manufacturer'] . '</Manufacturer>' . chr(10);

// Hook for including customiation of product attributes
if (file_exists(DIR_FS_MY_FILES . 'custom/zencart/extra_actions/extra_product_attrs.php')) {
       include (DIR_FS_MY_FILES . 'custom/zencart/extra_actions/extra_product_attrs.php');
}
// EOF _ Hook for customization

	$this->strXML .= '</ProductInformation>' . chr(10);
	$this->strXML .= '</ProductUpload>' . chr(10);
	$this->strXML .= '</AccessRequest>';
	return true;
  }

/*************************************************************************************/
//                           Product Syncronizer string generation
/*************************************************************************************/
  function buildProductSyncXML() { 
	global $db, $messageStack;
	$result = $db->Execute("select sku from " . TABLE_INVENTORY . " where catalog = '1'");
	if ($result->RecordCount() == 0) {
	  $messageStack->add(ZENCART_ERROR_NO_ITEMS, 'error');
	  return false;
	}

	$this->strXML  = '<?xml version="1.0" encoding="iso-8859-1" ?>' . chr(10);
	$this->strXML .= '<AccessRequest>' . chr(10);
	$this->strXML .= '<AccessUserID>'   . ZENCART_USERNAME . '</AccessUserID>'   . chr(10);
	$this->strXML .= '<AccessPassword>' . ZENCART_PASSWORD . '</AccessPassword>' . chr(10);
	$this->strXML .= '<AccessFunction>ProductSync</AccessFunction>' . chr(10);
	$this->strXML .= '<Version>1.00</Version>' . chr(10);
	$this->strXML .= '<ProductSync>'   . chr(10);
	$this->strXML .= '<RequestHeader>' . chr(10);
	$this->strXML .= '<RequestAction>Validate</RequestAction>' . chr(10);
	$this->strXML .= '<ReferenceName>Product Syncronizer</ReferenceName>' . chr(10);
	$this->strXML .= '</RequestHeader>' . chr(10);
	$this->strXML .= '<ProductDetails>' . chr(10);
	while(!$result->EOF) {
	  $this->strXML .= '<SKU>' . urlencode($result->fields['sku']) . '</SKU>' . chr(10);
	  $result->MoveNext();
	}
	$this->strXML .= '</ProductDetails>' . chr(10);
	$this->strXML .= '</ProductSync>'    . chr(10);
	$this->strXML .= '</AccessRequest>';
	return true;
  }

/*************************************************************************************/
//                           Product Shipping Confirmation String Generation
/*************************************************************************************/
  function buildConfirmXML() {
    global $db, $messageStack;
	$methods = $this->loadShippingMethods();
	$this->strXML  = '<?xml version="1.0" encoding="iso-8859-1" ?>' . chr(10);
	$this->strXML .= '<AccessRequest>'  . chr(10);
	$this->strXML .= '<AccessUserID>'   . ZENCART_USERNAME . '</AccessUserID>' . chr(10);
	$this->strXML .= '<AccessPassword>' . ZENCART_PASSWORD . '</AccessPassword>' . chr(10);
	$this->strXML .= '<AccessFunction>ShipConfirm</AccessFunction>' . chr(10);
	$this->strXML .= '<Version>1.00</Version>' . chr(10);
	$this->strXML .= '<OrderConfirm>'   . chr(10);
	$this->strXML .= '<RequestHeader>'  . chr(10);
	$this->strXML .= '<RequestAction>Confirm</RequestAction>' . chr(10);
	$this->strXML .= '<ReferenceName>Order Ship Confirmation</ReferenceName>' . chr(10);
	$this->strXML .= '</RequestHeader>' . chr(10);
	// fetch every shipment for the given post_date
	$result = $db->Execute("select ref_id, carrier, method, tracking_id from " . TABLE_SHIPPING_LOG . " 
	  where ship_date = '" . $this->post_date . "'");
	if ($result->RecordCount() == 0) {
	  $messageStack->add(ZENCART_ERROR_CONFRIM_NO_DATA, 'caution');
	  return false;
	}
	// foreach shipment, fetch the PO Number (it is the ZenCart order number)
	$this->strXML .= '<Orders>'  . chr(10);
	while (!$result->EOF) {
	  $details = $db->Execute("select so_po_ref_id from " . TABLE_JOURNAL_MAIN . " 
	    where journal_id = 12 and purchase_invoice_id = '" . $result->fields['ref_id'] . "' 
		order by id desc limit 1");
		// check to see if the order is complete
		if ($details->fields['so_po_ref_id']) {
		  $details = $db->Execute("select closed, purchase_invoice_id from " . TABLE_JOURNAL_MAIN . " 
	        where id = '" . $details->fields['so_po_ref_id'] . "'");
		  if ($details->RecordCount() == 1) {
		    $message = sprintf(ZENCART_CONFIRM_MESSAGE, $this->post_date, $methods[$result->fields['carrier']]['title'], $methods[$result->fields['carrier']][$result->fields['method']], $result->fields['tracking_id']);
		    $this->strXML .= '<Order>'   . chr(10);
		    $this->strXML .= '<ID>'      . $details->fields['purchase_invoice_id'] . '</ID>' . chr(10);
		    $this->strXML .= '<Status>'  . ($details->fields['closed'] ? ZENCART_STATUS_CONFIRM_ID : ZENCART_STATUS_PARTIAL_ID) . '</Status>' . chr(10);			
		    $this->strXML .= '<Message>' . $message . '</Message>' . chr(10);
		    $this->strXML .= '</Order>'  . chr(10);
		  }
		}
		$result->MoveNext();
	}
	$this->strXML .= '</Orders>'  . chr(10);
	$this->strXML .= '</OrderConfirm>'    . chr(10);
	$this->strXML .= '</AccessRequest>';
	return true;
  }

/*************************************************************************************/
//                           Support Functions
/*************************************************************************************/
  function loadShippingMethods() {
    global $shipping_defaults;
	$directory_array  = array();
	// load standard shipping methods
	$module_directory = DIR_FS_MODULES . 'services/shipping/';
	if ($dir = @dir($module_directory . 'modules')) {
	  while ($file = $dir->read()) {
		if (!is_dir($module_directory . 'modules/' . $file)) {
		  if (substr($file, strrpos($file, '.')) == '.php') {
			$class = substr($file, 0, strrpos($file, '.'));
			if (@constant('MODULE_SHIPPING_' . strtoupper($class) . '_STATUS')) { 
			  $directory_array[$class] = array(
			  	'path'  => $module_directory,
			  	'file'  => $file,
			  );
			}
		  }
		}
	  }
	  $dir->close();
	}
	// now custom shipping methods
	$module_directory = DIR_FS_MY_FILES . 'custom/services/shipping/';
	if ($dir = @dir($module_directory . 'modules')) {
	  while ($file = $dir->read()) {
		if (!is_dir($module_directory . 'modules/' . $file)) {
		  if (substr($file, strrpos($file, '.')) == '.php') {
			$class = substr($file, 0, strrpos($file, '.'));
			if (@constant('MODULE_SHIPPING_' . strtoupper($class) . '_STATUS')) { 
			  $directory_array[$class] = array(
			  	'path'  => $module_directory,
			  	'file'  => $file,
			  );
			}
		  }
		}
	  }
	  $dir->close();
	}
	ksort($directory_array);
	$output = array();
	$choices = array_keys($shipping_defaults['service_levels']);
	if (sizeof($directory_array) > 0) {
	  foreach ($directory_array as $class => $details) {
		include_once($details['path'] . 'language/' . $_SESSION['language'] . '/modules/' . $details['file']);
		include_once($details['path'] . 'modules/' . $details['file']);
		$output[$class]['title'] = constant('MODULE_SHIPPING_' . strtoupper($class) . '_TEXT_TITLE');
		foreach ($choices as $value) {
		  $output[$class][$value] = defined($class . '_' . $value) ? constant($class . '_' . $value) : "";
		}
	  }
	}
	return $output;  
  }

}
?>