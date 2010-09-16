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
//  Path: /soap/classes/orders.php
//

class xml_orders extends xml2Array {
   var $arrOutput = array();
   var $resParser;
   var $strXmlData;
	
	// class constructor
	function xml_orders() {
		$this->payment  = array();
		$this->customer = array();
		$this->billing  = array();
		$this->shipping = array();
		$this->items    = array();
	}

	function processXML($rawXML) {
//echo '<pre>' . $rawXML . '</pre>';
		$rawXML = utf8_decode($rawXML);
		$rawXML = iconv("UTF-8","UTF-8//IGNORE",$rawXML); 
//echo '<pre>' . $rawXML . '</pre>';
		if (!$this->parse($rawXML)) return false;  // parse the submitted string, check for errors
//echo 'parsed string = '; print_r($this->arrOutput); echo '<br />';
		$this->username = $this->getNodeData(array('ACCESSREQUEST','ACCESSUSERID'), $this->arrOutput);
		$this->password = $this->getNodeData(array('ACCESSREQUEST','ACCESSPASSWORD'), $this->arrOutput);
		if (!$this->validateUser($this->username, $this->password)) return false;  // verify username and password
//echo 'user was validated<br />';
		if (!$this->formatArray()) return false;    // format submitted string into order array, check for errors
//echo 'array was formatted<br />';
		if (!$this->buildJournalEntry()) return false;
//echo 'journal entry was built and posted<br />';
		return true;
	}

	function formatArray() {
		global $db;
		// build the tax table to set the tax rates
		$tax_rates = ord_calculate_tax_drop_down('c');
		$this->order = array();
		// Here we map the received xml array to the pre-defined generic structure (application specific format later)
		// <OrderRequest>
		$this->order['function']               = $this->getNodeData(array('ACCESSREQUEST','ACCESSFUNCTION'), $this->arrOutput);
		$this->order['action']                 = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','ORDERREQUEST','REQUESTACTION'), $this->arrOutput);
		$this->order['reference_name']         = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','ORDERREQUEST','REFERENCENAME'), $this->arrOutput);
		// <Originator>
		$this->order['store_id']               = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','ORDERREQUEST','ORIGINATOR','STOREID'), $this->arrOutput);
		$this->order['sales_gl_account']       = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','ORDERREQUEST','ORIGINATOR','SALESGLACCOUNT'), $this->arrOutput);
		$this->order['receivables_gl_acct']    = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','ORDERREQUEST','ORIGINATOR','RECEIVABLESGLACCOUNT'), $this->arrOutput);
		// <OrderSummary>
		$this->order['order_id']               = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER','ORDERSUMMARY','SALESORDERID'), $this->arrOutput);
		$this->order['purch_order_id']         = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER','ORDERSUMMARY','PURCHASEORDERID'), $this->arrOutput);
		$this->order['post_date']              = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER','ORDERSUMMARY','SALESORDERDATE'), $this->arrOutput);
		$this->order['order_total']            = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER','ORDERSUMMARY','ORDERTOTAL'), $this->arrOutput);
		$this->order['tax_total']              = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER','ORDERSUMMARY','TAXTOTAL'), $this->arrOutput);
		$this->order['freight_total']          = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER','ORDERSUMMARY','SHIPPINGTOTAL'), $this->arrOutput);
		$this->order['freight_carrier']        = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER','ORDERSUMMARY','SHIPPINGCARRIER'), $this->arrOutput);
		$this->order['freight_method']         = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER','ORDERSUMMARY','SHIPPINGMETHOD'), $this->arrOutput);
		$this->order['discount_total']         = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER','ORDERSUMMARY','DISCOUNTTOTAL'), $this->arrOutput);
		// <Payment>
		$this->order['payment']['holder_name'] = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER','PAYMENT','CARDHOLDERNAME'), $this->arrOutput);
		$this->order['payment']['method']      = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER','PAYMENT','METHOD'), $this->arrOutput);
		$this->order['payment']['type']        = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER','PAYMENT','TYPE'), $this->arrOutput);
		$this->order['payment']['card_number'] = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER','PAYMENT','CARDNUMBER'), $this->arrOutput);
		$this->order['payment']['exp_date']    = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER','PAYMENT','EXPIRATIONDATE'), $this->arrOutput);
		$this->order['payment']['cvv2']        = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER','PAYMENT','CVV2NUMBER'), $this->arrOutput);

// Begin - additional operations added by PhreeSoft for PPS
		$this->order['payment']['hint']        = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER','PAYMENT','HINT'), $this->arrOutput);
		$temp                                  = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER','PAYMENT','ENCVAL'), $this->arrOutput);
		$this->order['payment']['encval']      = base64_decode(strtr($temp, '-_,', '+/='));
// End - additional operations added by PhreeSoft for PPS

		// <Customer> and <Billing> and <Shipping>
		$types = array ('customer', 'billing', 'shipping');
		foreach ($types as $value) {
		  $this->order[$value]['primary_name']   = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER',strtoupper($value),'COMPANYNAME'), $this->arrOutput);
		  $this->order[$value]['contact']        = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER',strtoupper($value),'CONTACT'), $this->arrOutput);
		  $this->order[$value]['address1']       = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER',strtoupper($value),'ADDRESS1'), $this->arrOutput);
		  $this->order[$value]['address2']       = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER',strtoupper($value),'ADDRESS2'), $this->arrOutput);
		  $this->order[$value]['city_town']      = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER',strtoupper($value),'CITYTOWN'), $this->arrOutput);
		  $this->order[$value]['state_province'] = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER',strtoupper($value),'STATEPROVINCE'), $this->arrOutput);
		  $this->order[$value]['postal_code']    = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER',strtoupper($value),'POSTALCODE'), $this->arrOutput);
		  $this->order[$value]['country_code']   = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER',strtoupper($value),'COUNTRYCODE'), $this->arrOutput);
		  $this->order[$value]['telephone']      = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER',strtoupper($value),'TELEPHONE'), $this->arrOutput);
		  $this->order[$value]['email']          = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER',strtoupper($value),'EMAIL'), $this->arrOutput);
		  if ($value == 'customer') { // additional information for the customer record
			$this->order[$value]['customer_id']  = $this->getNodeData(array('ACCESSREQUEST','SALESORDERENTRY','SALESORDER',strtoupper($value),'CUSTOMERID'), $this->arrOutput);
		  }
		}
		// <LineItems>
		$itemArray = $this->getSubArray('LINEITEMS', $this->arrOutput);
		$tempArray = array();
		$this->order['items'] = array();
		for ($i=0; $i<count($itemArray); $i++) {
			$tempArray[0] = $itemArray[$i]; // set to a single line item
			$item = array();
			$sku                 = $this->getNodeData(array('LINEITEMDETAILS','ITEMID'), $tempArray);
			// try to match sku and get the sales gl account
			$result = $db->Execute("select account_sales_income from " . TABLE_INVENTORY . " where sku = '" . $sku . "'");
			if ($result->RecordCount() > 0) {
			  $item['sku']       = $sku;
			  $item['gl_acct']   = $result->fields['account_sales_income'];
			} else {
			  $result = $db->Execute("select sku, account_sales_income from " . TABLE_INVENTORY . " where description_short = '" . $sku . "'");
			  $item['sku']       = $result->fields['sku'];
			  $item['gl_acct']   = $result->fields['account_sales_income'];
			}
			$item['description'] = $this->getNodeData(array('LINEITEMDETAILS','DESCRIPTION'), $tempArray);
			$item['quantity']    = $this->getNodeData(array('LINEITEMDETAILS','QUANTITY'), $tempArray);
			$item['unit_price']  = $this->getNodeData(array('LINEITEMDETAILS','UNITPRICE'), $tempArray);
			$item['tax_percent'] = $this->getNodeData(array('LINEITEMDETAILS','SALESTAXPERCENT'), $tempArray);
//			$item['sales_tax']   = $this->getNodeData(array('LINEITEMDETAILS','SALESTAX'), $tempArray);
			$item['taxable']     = $this->guess_tax_id($tax_rates, $item['tax_percent']);
			$item['total_price'] = $this->getNodeData(array('LINEITEMDETAILS','TOTALPRICE'), $tempArray);
			$this->order['items'][] = $item;
		}
		return true;
	}

	function responseXML($code, $text, $level) {
		switch (JOURNAL_ID) {
			case 12: $function = 'SalesInvoiceResponse'; break;
			case 10: 
			default:
				$function = 'SalesOrderResponse'; break;
		}
		$strResponse = '';
		$strResponse .= '<?xml version="1.0" encoding="UTF-8" ?>' . chr(10);
		$strResponse .= '<AccessResponse>' . chr(10);
		$strResponse .= '<AccessFunction>' . $function . '</AccessFunction>' . chr(10);
		$strResponse .= '<Version>1.00</Version>' . chr(10);
		$strResponse .= '<ReferenceName>' . $this->order['reference_name'] . '</ReferenceName>' . chr(10);

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
	function buildJournalEntry() {
		global $messageStack, $currencies;
		// set some preliminary information
		switch (strtoupper($this->order['function'])) {
			case 'SALESINVOICEENTRY':
				define('JOURNAL_ID',12);
				define('GL_TYPE','sos');
				break;
			case 'SALESORDERENTRY':
			default:
				define('JOURNAL_ID',10);
				define('GL_TYPE','soo');
		}
		if ($this->order['receivables_gl_acct'] <> '') { // see if requestor specifies a AR account else use default
			define('DEF_GL_ACCT',$this->order['receivables_gl_acct']);
		} else {
			define('DEF_GL_ACCT',AR_DEFAULT_GL_ACCT);
		}
		$account_type = 'c';
		$psOrd = new orders();

		// make the received string look like a form submission then post as usual
		$psOrd->account_type        = $account_type;
		$psOrd->id = ''; // should be null unless opening an existing purchase/receive
		$psOrd->journal_id          = JOURNAL_ID;
		$psOrd->post_date           = $this->order['post_date']; // date format should already be YYYY-MM-DD
		$psOrd->terminal_date       = $this->order['post_date']; // make same as order date for now
		$psOrd->period              = gen_calculate_period($psOrd->post_date);
		$psOrd->store_id            = $this->get_account_id($this->order['store_id'], 'b');
		$psOrd->admin_id            = $this->get_user_id($this->username);
		$psOrd->description         = SOAP_XML_SUBMITTED_SO;
		$psOrd->gl_acct_id          = DEF_GL_ACCT;

		$psOrd->freight             = $currencies->clean_value(db_prepare_input($this->order['freight_total']), DEFAULT_CURRENCY);
		$psOrd->discount            = $currencies->clean_value(db_prepare_input($this->order['discount_total']), DEFAULT_CURRENCY);
		$psOrd->sales_tax           = db_prepare_input($this->order['tax_total']);
		$psOrd->total_amount        = db_prepare_input($this->order['order_total']);
		// The order ID should be set by the submitter
		$psOrd->purchase_invoice_id = db_prepare_input($this->order['order_id']);
		$psOrd->purch_order_id      = db_prepare_input($this->order['purch_order_id']);
		$psOrd->shipper_code        = db_prepare_input($this->order['freight_carrier']);
// BOF - Added by PhreeSoft for Portable Power Systems to map the shipping codes to PhreeBooks Codes
		$psOrd->shipper_code        = substr($psOrd->shipper_code, 0, 16);
		switch ($psOrd->shipper_code) {
			default: 
		 	case 'FedEx (Ground):':  $psOrd->shipper_code = 'fedex_v7:GND';    break;
		 	case 'FedEx (Ground LT': $psOrd->shipper_code = 'fedex_v7:GndFrt'; break;
		 	case 'FedEx (Home Deli': $psOrd->shipper_code = 'fedex_v7:GDR';    break;
		 	case 'FedEx (Express S': $psOrd->shipper_code = 'fedex_v7:3Dpm';   break;
		 	case 'FedEx (Express 2': $psOrd->shipper_code = 'fedex_v7:2Dpm';   break;
		 	case 'FedEx (Standard ': $psOrd->shipper_code = 'fedex_v7:1Dpm';   break;
		 	case 'FedEx (Priority ': $psOrd->shipper_code = 'fedex_v7:1Dam';   break;
		 	case 'UPS (Ground):':
		 	case 'UPS (Ground Resi': $psOrd->shipper_code = 'ups:GND';      break;
		 	case 'UPS (3 Day Selec': $psOrd->shipper_code = 'ups:3Dpm';     break;
		 	case 'UPS (2 Day Air):': $psOrd->shipper_code = 'ups:2Dpm';     break;
		 	case 'UPS (Next Day PM': $psOrd->shipper_code = 'ups:1Dpm';     break;
		 	case 'UPS (Next Day):':  $psOrd->shipper_code = 'ups:1Dam';     break;
		 	case 'FREE SHIPPING! (': $psOrd->shipper_code = 'usps:3Dpm';    break;
		 	case 'Flat (Best Way):': $psOrd->shipper_code = 'usps:2Dpm';    break;
		}
// EOF - Added by PhreeSoft for PPS

		/* Values below are not used at this time
		$psOrd->sales_tax_auths
		$psOrd->terms
		$psOrd->drop_ship = 0;
		$psOrd->waiting = 0;
		$psOrd->closed = 0;
		$psOrd->subtotal
		*/
		$psOrd->bill_add_update = 1; // force an address book update
		// see if the customer record exists
		$psOrd->short_name          = db_prepare_input($this->order['customer']['customer_id']);
		$psOrd->ship_short_name     = $psOrd->short_name;
		$result = $this->checkForCustomerExists($psOrd);
		if (!$result) return false;
		$psOrd->ship_add_update     = $result['ship_add_update'];
		$psOrd->bill_acct_id        = $result['bill_acct_id'];
		$psOrd->bill_address_id     = $result['bill_address_id'];
		$psOrd->ship_acct_id        = $result['ship_acct_id'];
		$psOrd->ship_address_id     = $result['ship_address_id'];

		// Phreebooks requires a primary name or the order is not valid, use company name if exists, else contact name
		if ($this->order['billing']['primary_name'] == '') {
		  $psOrd->bill_primary_name   = $this->order['billing']['contact'];
		  $psOrd->bill_contact        = '';
		} else {
		  $psOrd->bill_primary_name   = $this->order['billing']['primary_name'];
		  $psOrd->bill_contact        = $this->order['billing']['contact'];
		}
		$psOrd->bill_address1       = $this->order['billing']['address1'];
		$psOrd->bill_address2       = $this->order['billing']['address2'];
		$psOrd->bill_city_town      = $this->order['billing']['city_town'];
		$psOrd->bill_state_province = $this->order['billing']['state_province'];
		$psOrd->bill_postal_code    = $this->order['billing']['postal_code'];
		$psOrd->bill_country_code   = gen_get_country_iso_3_from_2($this->order['billing']['country_code']);
		$psOrd->bill_telephone1     = $this->order['customer']['telephone'];
		$psOrd->bill_email          = $this->order['customer']['email'];

		if ($this->order['shipping']['primary_name'] == '') {
		  $psOrd->ship_primary_name   = $this->order['shipping']['contact'];
		  $psOrd->ship_contact        = '';
		} else {
		  $psOrd->ship_primary_name   = $this->order['shipping']['primary_name'];
		  $psOrd->ship_contact        = $this->order['shipping']['contact'];
		}
		$psOrd->ship_address1       = $this->order['shipping']['address1'];
		$psOrd->ship_address2       = $this->order['shipping']['address2'];
		$psOrd->ship_city_town      = $this->order['shipping']['city_town'];
		$psOrd->ship_state_province = $this->order['shipping']['state_province'];
		$psOrd->ship_postal_code    = $this->order['shipping']['postal_code'];
		$psOrd->ship_country_code   = gen_get_country_iso_3_from_2($this->order['shipping']['country_code']);
		$psOrd->ship_telephone1     = $this->order['customer']['telephone'];
		$psOrd->ship_email          = $this->order['customer']['email'];


		// check for truncation of addresses
		if (strlen($psOrd->bill_primary_name) > 32 || strlen($psOrd->bill_address1) > 32 || strlen($psOrd->ship_primary_name) > 32 || strlen($psOrd->ship_address1) > 32) {
			$messageStack->add('Either the Primary Name or Address has been truncated to fit in the PhreeBooks database field sizes. Please check source information.', 'caution');
		}

		// load the item rows
		switch (JOURNAL_ID) {
			case 12: $index = 'pstd'; break;
			case 10: 
			default: $index = 'qty'; break;
		}
		for ($i = 0; $i < count($this->order['items']); $i++) {
			$psOrd->item_rows[] = array(
				'gl_type' => GL_TYPE,
				$index    => db_prepare_input($this->order['items'][$i]['quantity']),
				'sku'     => db_prepare_input($this->order['items'][$i]['sku']),
				'desc'    => db_prepare_input($this->order['items'][$i]['description']),
				'price'   => db_prepare_input($this->order['items'][$i]['unit_price']),
				'acct'    => db_prepare_input($this->order['items'][$i]['gl_acct']),
				'tax'     => db_prepare_input($this->order['items'][$i]['taxable']),
				'total'   => db_prepare_input($this->order['items'][$i]['total_price']),
			);
		}
		
		// error check input
		if (!$psOrd->short_name) return $this->responseXML('18', SOAP_NO_CUSTOMER_ID, 'error');
		if (!$psOrd->post_date)  return $this->responseXML('20', SOAP_NO_POST_DATE, 'error');
		if (!$psOrd->period)     return $this->responseXML('21', SOAP_BAD_POST_DATE, 'error');

		if (!$psOrd->bill_primary_name) return $this->responseXML('30', SOAP_NO_BILLING_PRIMARY_NAME, 'error');
		if (ADDRESS_BOOK_CONTACT_REQUIRED && !$psOrd->bill_contact) return $this->responseXML('31', SOAP_NO_BILLING_CONTACT, 'error');
		if (ADDRESS_BOOK_ADDRESS1_REQUIRED && !$psOrd->bill_address1) return $this->responseXML('32', SOAP_NO_BILLING_ADDRESS1, 'error');
		if (ADDRESS_BOOK_ADDRESS2_REQUIRED && !$psOrd->bill_address2) return $this->responseXML('33', SOAP_NO_BILLING_ADDRESS2, 'error');
		if (ADDRESS_BOOK_CITY_TOWN_REQUIRED && !$psOrd->bill_city_town) return $this->responseXML('34', SOAP_NO_BILLING_CITY_TOWN, 'error');
		if (ADDRESS_BOOK_STATE_PROVINCE_REQUIRED && !$psOrd->bill_state_province) return $this->responseXML('35', SOAP_NO_BILLING_STATE_PROVINCE, 'error');
		if (ADDRESS_BOOK_POSTAL_CODE_REQUIRED && !$psOrd->bill_postal_code) return $this->responseXML('36', SOAP_NO_BILLING_POSTAL_CODE, 'error');
		if (!$psOrd->bill_country_code) return $this->responseXML('37', SOAP_NO_BILLING_COUNTRY_CODE, 'error');

		if (!$psOrd->ship_primary_name) return $this->responseXML('40', SOAP_NO_SHIPPING_PRIMARY_NAME, 'error');
		if (ADDRESS_BOOK_CONTACT_REQUIRED && !$psOrd->ship_contact) return $this->responseXML('41', SOAP_NO_SHIPPING_CONTACT, 'error');
		if (ADDRESS_BOOK_ADDRESS1_REQUIRED && !$psOrd->ship_address1) return $this->responseXML('42', SOAP_NO_SHIPPING_ADDRESS1, 'error');
		if (ADDRESS_BOOK_ADDRESS2_REQUIRED && !$psOrd->ship_address2) return $this->responseXML('43', SOAP_NO_SHIPPING_ADDRESS2, 'error');
		if (ADDRESS_BOOK_CITY_TOWN_REQUIRED && !$psOrd->ship_city_town) return $this->responseXML('44', SOAP_NO_SHIPPING_CITY_TOWN, 'error');
		if (ADDRESS_BOOK_STATE_PROVINCE_REQUIRED && !$psOrd->ship_state_province) return $this->responseXML('45', SOAP_NO_SHIPPING_STATE_PROVINCE, 'error');
		if (ADDRESS_BOOK_POSTAL_CODE_REQUIRED && !$psOrd->ship_postal_code) return $this->responseXML('46', SOAP_NO_SHIPPING_POSTAL_CODE, 'error');
		if (!$psOrd->ship_country_code) return $this->responseXML('47', SOAP_NO_SHIPPING_COUNTRY_CODE, 'error');

		// post the sales order
//echo 'ready to post =><br />'; echo 'psOrd object = '; print_r($psOrd); echo '<br />';
		$post_success = $psOrd->post_ordr($action);
		if (!$post_success) { // extract the error message from the messageStack and return with error
			$text = strip_tags($messageStack->output());
			$text = preg_replace('/&nbsp;/', '', $text); // the &nbsp; messes up the response XML
			return $this->responseXML('90', SOAP_SO_POST_ERROR . $text, 'error');
		}

// Begin - additional operations added by PhreeSoft for PPS
		global $db;
		if ($this->order['payment']['encval']) {
			$sql_array = array(
				'module'    => 'contacts',
				'ref_1'     => $psOrd->bill_acct_id,
				'ref_2'     => $psOrd->bill_address_id,
				'hint'      => $this->order['payment']['hint'],
				'enc_value' => $this->order['payment']['encval'],
			);
			$result = $db->Execute("select id from " . TABLE_DATA_SECURITY . " 
				where module = 'contacts' 
				and ref_1 = '" . $psOrd->bill_acct_id . "' 
				and ref_2 = '" . $psOrd->bill_address_id . "' 
				and hint  = '" . $this->order['payment']['hint'] . "'");
			if ($result->RecordCount() > 0) {
				db_perform(TABLE_DATA_SECURITY, $sql_array, 'update', 'id = ' . $result->fields['id']);
			} else {
				db_perform(TABLE_DATA_SECURITY, $sql_array, 'insert');
			}
		}
// End - additional operations added by PhreeSoft for PPS

		gen_add_audit_log(constant('AUDIT_LOG_SOAP_' . JOURNAL_ID . '_ADDED'), $psOrd->purchase_invoice_id, $psOrd->total_amount);
		$this->responseXML('0', sprintf(constant('SOAP_' . JOURNAL_ID . '_SUCCESS'), $psOrd->purchase_invoice_id), 'success');
		return true;
	}

	function checkForCustomerExists($psOrd) {
		global $db;
		$output = array();
		$result = $db->Execute("select id from " . TABLE_CONTACTS . " 
			where type = 'c' and short_name = '" . $psOrd->short_name . "'");
		if ($result->RecordCount() == 0) { // create new record
			$output['bill_acct_id']    = '';
			$output['ship_acct_id']    = '';
			$output['bill_address_id'] = '';
		} else {
			$output['bill_acct_id'] = $result->fields['id'];
			$output['ship_acct_id'] = $output['bill_acct_id']; // no drop ships allowed
			// find main address to update as billing address
			$result = $db->Execute("select address_id from " . TABLE_ADDRESS_BOOK . " 
				where type = 'cm' and ref_id = " . $output['bill_acct_id']);
			if ($result->RecordCount() == 0) return $this->responseXML('19', SOAP_ACCOUNT_PROBLEM, 'error');
			$output['bill_address_id'] = $result->fields['address_id'];
		}
		// check to see if billing and shipping are different, if so set ship update flag
		// for now look at the primary name or address1 to be different, can be expanded to differentiate further if necessary
		if (($psOrd->bill_primary_name <> $psOrd->ship_primary_name) ||
				($psOrd->bill_address1 <> $psOrd->ship_address1)) {
			$result = $db->Execute("select address_id from " . TABLE_ADDRESS_BOOK . " 
				where primary_name = '" . $psOrd->ship_primary_name . "' and 
					address1 = '" . $psOrd->ship_address1 . "' and 
					type = 'cs' and ref_id = " . $output['bill_acct_id']);
			$output['ship_add_update'] = 1;
			$output['ship_address_id'] =  ($result->RecordCount() == 0) ? '' : $result->fields['address_id'];
		} else {
			$output['ship_add_update'] = 0;
			$output['ship_address_id'] = $output['bill_address_id'];
		}
		return $output;
	}

	function guess_tax_id($rate_array, $rate) {
		foreach ($rate_array as $value) {
			if ($value['rate'] == $rate) return $value['id'];
		}
		return 0; // no tax since no rate match
	}
}
?>