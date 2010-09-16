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
//  Path: /admin/soap/classes/products.php
//

require ('classes/parser.php');

class xml_products extends xml2Array {
   var $arrOutput = array();
   var $resParser;
   var $strXmlData;
	
	// class constructor
	function xml_products() {
		$this->product = array();
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
		if (!$this->validateUser())   return false; // verify username and password
		if (!$this->formatArray())    return false; // format submitted string into products array, check for errors
		if (!$this->updateDatabase()) return false;
		return true;
	}

	function formatArray() { // specific to XML spec for a product upload
		// Here we map the received xml array to the pre-defined generic structure (application specific format later)
		$this->requested_function             = $this->getNodeData(array('ACCESSREQUEST','ACCESSFUNCTION'), $this->arrOutput);
		$this->request_version                = $this->getNodeData(array('ACCESSREQUEST','VERSION'), $this->arrOutput);
		// <RequestHeader>
		$this->product['action']              = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','REQUESTHEADER','REQUESTACTION'), $this->arrOutput);
		$this->product['reference_name']      = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','REQUESTHEADER','REFERENCENAME'), $this->arrOutput);
		// <Originator>
//		$this->product['store_id']            = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','REQUESTHEADER','ORIGINATOR','STOREID'), $this->arrOutput);
//		$this->product['sales_rep_user_name'] = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','REQUESTHEADER','ORIGINATOR','SALESREPID'), $this->arrOutput);
		// <ProductInformation>
		$this->product['sku']                 = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','SKU'), $this->arrOutput);
		$this->product['product_type']        = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','PRODUCTTYPE'), $this->arrOutput);
		$this->product['product_model']       = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','PRODUCTMODEL'), $this->arrOutput);
		$this->product['product_name']        = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','PRODUCTNAME'), $this->arrOutput);
		$this->product['product_description'] = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','PRODUCTDESCRIPTION'), $this->arrOutput);
		$this->product['product_url']         = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','PRODUCTURL'), $this->arrOutput);
		$this->product['image_directory']     = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','PRODUCTIMAGEDIRECTORY'), $this->arrOutput);
		$this->product['image_filename']      = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','PRODUCTIMAGEFILENAME'), $this->arrOutput);
		$this->product['image_data']          = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','PRODUCTIMAGEDATA'), $this->arrOutput);
		$this->product['product_taxable']     = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','PRODUCTTAXABLE'), $this->arrOutput);
		// <ProductPrice>
		$this->product['msrprice']            = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','PRODUCTPRICE','MSRPRICE'), $this->arrOutput);
		$this->product['retail_price']        = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','PRODUCTPRICE','RETAILPRICE'), $this->arrOutput);
		$this->product['price_discount_type'] = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','PRODUCTPRICE','PRICEDISCOUNTS','PRICEDISCOUNTTYPE'), $this->arrOutput);
		// <PriceLevels>
		$itemArray = $this->getSubArray('PRICEDISCOUNTS', $this->arrOutput);
		$tempArray = array();
		$this->product['price_levels'] = array();
//echo 'size of price levels = ' . count($itemArray) . '<br>';
		for ($i = 0; $i < count($itemArray); $i++) {
			$tempArray[0] = $itemArray[$i]; // set to a single price level
			$level = array();
			$discount_level = $this->getNodeData(array('PRICELEVEL','DISCOUNTLEVEL'), $tempArray);
			$level['qty'] = $this->getNodeData(array('PRICELEVEL','QUANTITY'), $tempArray);
			$level['amount'] = $this->getNodeData(array('PRICELEVEL','AMOUNT'), $tempArray);
//echo 'price = ' . $level['amount'] . '<br>';
			$this->product['price_levels'][$discount_level] = $level;
		}
		// Misc attributes
		$this->product['product_weight']        = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','PRODUCTWEIGHT'), $this->arrOutput);
		$this->product['date_added']            = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','DATEADDED'), $this->arrOutput);
		$this->product['date_update']           = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','DATEUPDATE'), $this->arrOutput);
		$this->product['date_available']        = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','DATEAVAILABLE'), $this->arrOutput);
		$this->product['stock_level']           = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','STOCKLEVEL'), $this->arrOutput);
		$this->product['manufacturer']          = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','MANUFACTURER'), $this->arrOutput);
		// ZenCart specific
		$this->product['product_virtual']       = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','PRODUCTVIRTUAL'), $this->arrOutput);
		$this->product['product_status']        = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','PRODUCTSTATUS'), $this->arrOutput);
		$this->product['product_free_shipping'] = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','PRODUCTFREESHIPPING'), $this->arrOutput);
		$this->product['product_hide_price']    = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','PRODUCTHIDEPRICE'), $this->arrOutput);
		$this->product['product_category']      = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','PRODUCTCATEGORY'), $this->arrOutput);
		$this->product['sort_order']            = $this->getNodeData(array('ACCESSREQUEST','PRODUCTUPLOAD','PRODUCTINFORMATION','PRODUCTSORTORDER'), $this->arrOutput);

// Hook for including customization of product attributes
if (file_exists(DIR_FS_ADMIN . 'soap/extra_actions/extra_product_reads.php')) include (DIR_FS_ADMIN . 'soap/extra_actions/extra_product_reads.php');
// EOF - Hook for customization

		return true;
	}

// The remaining functions are specific to ZenCart. they need to be modified for the specific application.
// It also needs to check for errors, i.e. missing information, bad data, etc. 
	function updateDatabase() {
		global $db, $messageStack;

		// error check input
		if (!$this->product['sku']) return $this->responseXML('10', SOAP_NO_SKU, 'error');
		if ($this->product['action'] <> 'InsertUpdate') {
			return $this->responseXML('16', SOAP_BAD_ACTION, 'error');
		}

		// set some preliminary information
		// verify the submitted language exists on the Zencart side
		$languages_code = strtolower(substr($this->product['language'],0,2)); // Take the first two characters of the language iso code (e.g. en_us)
		$result = $db->Execute("select languages_id from " . TABLE_LANGUAGES . " where code = '" . $languages_code . "'");
		if ($result->RecordCount() <> 1) {
			return $this->responseXML('11', SOAP_BAD_LANGUAGE_CODE . $this->product['language'], 'error');
		}
		$languages_id = $result->fields['languages_id'];

		// determine and verify the product_type
		$product_type_name = $this->product['product_type'];
		$result = $db->Execute("select type_id from " . TABLE_PRODUCT_TYPES . " where type_name = '" . $product_type_name . "'");
		if ($result->RecordCount() <> 1) {
			return $this->responseXML('12', sprintf(SOAP_BAD_PRODUCT_TYPE, $product_type_name, $this->product['sku']), 'error');
		}
		$product_type_id = $result->fields['type_id'];
		
		// manufacturer to id
		$manufacturer_name = $this->product['manufacturer'];
		$result = $db->Execute("select manufacturers_id from " . TABLE_MANUFACTURERS . " where manufacturers_name = '" . $manufacturer_name . "'");
		if ($result->RecordCount() <> 1) {
			return $this->responseXML('13', sprintf(SOAP_BAD_MANUFACTURER, $manufacturer_name, $this->product['sku']), 'error');
		}
		$manufacturers_id = $result->fields['manufacturers_id'];

		// categories need to be verified to be lowest level and fetch id
		$categories_name = $this->product['product_category'];
		$result = $db->Execute("select categories_id from " . TABLE_CATEGORIES_DESCRIPTION . " 
			where categories_name = '" . $categories_name . "' and language_id = '" . $languages_id . "'");
		if ($result->RecordCount() <> 1) {
			return $this->responseXML('14', sprintf(SOAP_BAD_CATEGORY, $categories_name, $this->product['sku']), 'error');
		}
		$categories_id = $result->fields['categories_id'];
		// verify that it is the lowest level of category tree (required by zencart)
		$result = $db->Execute("select categories_id from " . TABLE_CATEGORIES . " where parent_id = '" . $categories_id . "'");
		if ($result->RecordCount() <> 0) {
			return $this->responseXML('15', SOAP_BAD_CATEGORY_A, 'error');
		}

		// verify the image and storage location - save image
		$image_directory = $this->product['image_directory'];
		// directory cannot be more than one level down
		if (strpos($image_directory, '/') !== false) {
		  $image_directory = substr($image_directory, 0, strpos($image_directory, '/'));
		}
		$image_filename = $this->product['image_filename'];
		$image_data = $this->product['image_data'];
		if ($image_data) {
			// the str_replace is to necessary to fix a PHP 5 issue with spaces in the base64 encode... see php.net
			$contents = base64_decode(str_replace(" ", "+", $image_data));
			if ($image_directory) {
				if (!is_dir(DIR_FS_CATALOG_IMAGES . $image_directory)) {
					mkdir(DIR_FS_CATALOG_IMAGES . $image_directory);
				}
				$full_path = $image_directory . '/' . $image_filename;
			} else {
				$full_path = $image_filename;
			}
			if (!$handle = fopen(DIR_FS_CATALOG_IMAGES . $full_path, 'wb')) {
				return $this->responseXML('21', SOAP_OPEN_FAILED . $full_path, 'error');
			}
			if (fwrite($handle, $contents) === false) {
				return $this->responseXML('22', SOAP_ERROR_WRITING_IMAGE, 'error');
			}
			fclose($handle);
		}

		// ************** prepare to write tables **************
		// build the products table data
		$sql_data_array = array(
			'phreebooks_sku'       => $this->product['sku'],
			'products_type'        => $product_type_id,
			'manufacturers_id'     => $manufacturers_id,
			'master_categories_id' => $categories_id,
		);

		if (isset($this->product['stock_level']))             $sql_data_array['products_quantity'] = $this->product['stock_level'];
		if (isset($this->product['product_model']))           $sql_data_array['products_model'] = $this->product['product_model'];
		if (isset($full_path)) $sql_data_array['products_image'] = $full_path;
		if (isset($this->product['product_virtual']))         $sql_data_array['products_virtual'] = $this->product['product_virtual'];
		if (isset($this->product['date_added']))              $sql_data_array['products_date_added'] = $this->product['date_added'];
		if (isset($this->product['date_update']))             $sql_data_array['products_last_modified'] = $this->product['date_update'];
		if (isset($this->product['products_date_available'])) $sql_data_array['products_date_available'] = $this->product['products_date_available'];
		if (isset($this->product['product_weight']))          $sql_data_array['products_weight'] = $this->product['product_weight'];
		if (isset($this->product['product_status']))          $sql_data_array['products_status'] = $this->product['product_status'];
		if (isset($this->product['product_hide_price']))      $sql_data_array['product_is_call'] = $this->product['product_hide_price'];
		if (isset($this->product['product_free_shipping']))   $sql_data_array['product_is_always_free_shipping'] = $this->product['product_free_shipping'];
		if (isset($this->product['sort_order']))              $sql_data_array['products_sort_order'] = $this->product['sort_order'];
		if (isset($this->product['price_discount_type'])) {
			$sql_data_array['products_discount_type'] = $this->product['price_discount_type'];
			// set products price to level 1 price since zencart uses products_price for the first level.
			$sql_data_array['products_quantity_order_min'] = $this->product['price_levels'][1]['qty'];
			$sql_data_array['products_price'] = $this->product['price_levels'][1]['amount'];
		} else {
			$sql_data_array['products_discount_type'] = '0';
			if (isset($this->product['retail_price'])) $sql_data_array['products_price'] = $this->product['retail_price'];
		}
		// determine tax class
		$tax_class_id = $this->product['product_taxable'] ? ZENCART_PRODUCT_TAX_CLASS_ID : 0; // constant set in language file
		if ($tax_class_id) $sql_data_array['products_tax_class_id'] = $tax_class_id;
//			'products_ordered' => ,
//			'products_quantity_order_units' => ,
//			'products_priced_by_attribute' => ,
//			'product_is_free' => ,
//			'products_quantity_mixed' => ,
//			'products_qty_box_status' => ,
//			'products_quantity_order_max' => ,
//			'products_discount_type_from' => ,
//			'products_price_sorter' => ,
//			'products_mixed_discount_quantity' => ,
//			'metatags_products_name_status' => ,
//			'metatags_model_status' => ,
//			'metatags_price_status' => ,
//			'metatags_title_tagline_status' => 

		// prepare the products_description data
		$prod_desc_data_array = array('language_id' => $languages_id,);
		if (isset($this->product['product_name']))        $prod_desc_data_array['products_name'] = $this->product['product_name'];
		if (isset($this->product['product_description'])) $prod_desc_data_array['products_description'] = $this->product['product_description'];
		if (isset($this->product['product_url']))         $prod_desc_data_array['products_url'] = str_replace('http://', '', $this->product['product_url']);

// Hook for including customization of product attributes
if (file_exists(DIR_FS_ADMIN . 'soap/extra_actions/extra_product_saves.php')) include (DIR_FS_ADMIN . 'soap/extra_actions/extra_product_saves.php');
// EOF - Hook for customization

		// write to the tables
		$upload_success = true;
		// determine if the SKU exists, if so update else insert the products table
		$result = $db->Execute("select products_id from " . TABLE_PRODUCTS . " where phreebooks_sku = '" . $this->product['sku'] . "'");
		if ($result->RecordCount() == 0) { // new product
			zen_db_perform(TABLE_PRODUCTS, $sql_data_array);
			$products_id = zen_db_insert_id();
			$result = $db->Execute("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . " set categories_id = " . $categories_id . ", products_id = " . $products_id);
			$prod_desc_data_array['products_id'] = $products_id;
			zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $prod_desc_data_array);
		} else { // update product
			$products_id = (int)$result->fields['products_id'];
			zen_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', "products_id = '" . $products_id . "'");
			$result = $db->Execute("update " . TABLE_PRODUCTS_TO_CATEGORIES . " set categories_id = " . $categories_id . " where products_id = " . $products_id);
			zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $prod_desc_data_array, 'update', "products_id = " . $products_id);
		}

		// Update the price levels, first clear out the current price level data
		$db->Execute("delete from " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " where products_id = " . $products_id);
		// set the discount for each level from 2 on (level 1 set in base price)
		for ($i=1, $j=2; $i < count($this->product['price_levels']); $i++, $j++) {
		  if ($this->product['price_levels'][$j]['qty']) {
			$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " set 
				discount_id = " . $i . ", 
				products_id = " . $products_id . ", 
				discount_qty = " . (real)$this->product['price_levels'][$j]['qty'] . ",
				discount_price = " . (real)$this->product['price_levels'][$j]['amount']);
		  }
		}

		// make sure everything went as planned
		if (!$upload_success) { // extract the error message from the messageStack and return with error
			$text = strip_tags($messageStack->output());
			return $this->responseXML('90', SOAP_PU_POST_ERROR . $text, 'error');
		}
// TBD - log the upload activity to the database

		$this->responseXML('0', SOAP_PRODUCT_UPLOAD_SUCCESS_A . $this->product['sku'] . SOAP_PRODUCT_UPLOAD_SUCCESS_B, 'success');
		return true;
	}

}
?>