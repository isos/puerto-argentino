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
//  Path: /modules/services/shipping/modules/fedex.php
//

// fetch the language file, if it exists, and define service levels per FEDEX standards
include_once(DIR_FS_MODULES . 'services/shipping/language/' . $_SESSION['language'] . '/modules/fedex.php');

// Set the FedEx tracking URL
define('FEDEX_TRACKING_URL','http://www.fedex.com/Tracking?ascend_header=1&amp;clienttype=dotcom&amp;cntry_code=us&amp;language=english&amp;tracknumbers=');

// Set the defaults for Thermal printing
define('IMAGETYPE', 'ELTRON'); // (ELTRON, ZEBRA, UNIMARK)
define('LABELSTOCKORIENTATION', 'LEADING'); // (LEADING, TRAILING, NONE) - Use NONE for 4x6 labels w/o tabs
define('DOCTABLOCATION', 'TOP'); // only valid for thermal labels (TOP, BOTTOM) - as it comes out of the printer
define('DOCTABCONTENT', 'ZONE001'); // (STANDARD, ZONE001, BARCODED, NONE) - default is STANDARD

$ZONE001_DEFINES = array( // up to 12 zones can be defined
	'1'  => array('Header' => TEXT_DATE,  'Value' => 'FDXShipRequest/ShipDate'),
	'2'  => array('Header' => 'Del Date', 'Value' => 'FDXShipReply/Routing/DeliveryDate'),
	'3'  => array('Header' => 'DV',       'Value' => 'FDXShipRequest/DeclaredValue/Value'),
	'5'  => array('Header' => TEXT_WEIGHT,'Value' => 'FDXShipRequest/Weight'),
	'6'  => array('Header' => 'PO Num',   'Value' => 'FDXShipRequest/ReferenceInfo/PONumber'),
	'7'  => array('Header' => 'Inv Num',  'Value' => 'FDXShipRequest/ReferenceInfo/InvoiceNumber'),
	'8'  => array('Header' => 'Cust Ref', 'Value' => 'FDXShipRequest/ReferenceInfo/CustomerReference'),
	'9'  => array('Header' => 'List',     'Value' => 'FDXShipReply/EstimatedCharges/ListCharges/NetCharge'),
	'12' => array('Header' => 'Net',      'Value' => 'FDXShipReply/EstimatedCharges/DiscountedCharges/NetCharge'),
//	''   => array('Header' => 'Service',  'Value' => 'FDXShipRequest/Service'),
//	''   => array('Header' => 'Srvc Cmt', 'Value' => 'FDXShipReply/Routing/ServiceCommitment'),
//	''   => array('Header' => 'Trk Num',  'Value' => 'FDXShipReply/Tracking/TrackingNumber'),
);

// constants used in rate screen to match carrier descrptions
define('fedex_1DEam', MODULE_SHIPPING_FEDEX_1DM);
define('fedex_1Dam',  MODULE_SHIPPING_FEDEX_1DA);
define('fedex_1Dpm',  MODULE_SHIPPING_FEDEX_1DP);
define('fedex_2Dpm',  MODULE_SHIPPING_FEDEX_2DP);
define('fedex_3Dpm',  MODULE_SHIPPING_FEDEX_3DS);
define('fedex_GND',   MODULE_SHIPPING_FEDEX_GND);
define('fedex_GDR',   MODULE_SHIPPING_FEDEX_GDR);
define('fedex_I2DEam',MODULE_SHIPPING_FEDEX_XDM);
define('fedex_I2Dam', MODULE_SHIPPING_FEDEX_XPR);
define('fedex_I3D',   MODULE_SHIPPING_FEDEX_XPD);
define('fedex_1DFrt', MODULE_SHIPPING_FEDEX_1DF);
define('fedex_2DFrt', MODULE_SHIPPING_FEDEX_2DF);
define('fedex_3DFrt', MODULE_SHIPPING_FEDEX_3DF);
define('fedex_GndFrt',MODULE_SHIPPING_FEDEX_GDF);

  class fedex {
	// FedEx Rate code maps
	var $FedExRateCodes = array(	
		'FIRSTOVERNIGHT'       =>'1DEam',
		'PRIORITYOVERNIGHT'    =>'1Dam',
		'STANDARDOVERNIGHT'    =>'1Dpm',
		'FEDEX2DAY'            =>'2Dpm',
		'FEDEXEXPRESSSAVER'    =>'3Dpm',
		'FEDEXGROUND'          =>'GND',
		'GROUNDHOMEDELIVERY'   =>'GDR',
		'INTERNATIONALFIRST'   =>'I2DEam',
		'INTERNATIONALPRIORITY'=>'I2Dam',
		'INTERNATIONALECONOMY' =>'I3D',
		'FEDEX1DAYFREIGHT'     => '1DFrt',
		'FEDEX2DAYFREIGHT'     => '2DFrt',
		'FEDEX3DAYFREIGHT'     => '3DFrt',
		'FEDEXLTLFREIGHT'      => 'GndFrt',
	);

	var $FedExPickupMap = array(
		'01' => 'REGULARPICKUP',
		'06' => 'REQUESTCOURIER',
		'19' => 'DROPBOX',
		'20' => 'BUSINESSSERVICECENTER',
		'03' => 'STATION',
	);

	var $ReturnServiceMap = array(
//		''  => 'NONRETURN',
		'1' => 'PRINTRETURNLABEL',
//		''  => 'EMAILABEL',
		'2' => 'FEDEXTAG',
	);

	var $PackageMap = array(
		'01' => 'FEDEXENVELOPE',
		'04' => 'FEDEXPAK',
		'21' => 'FEDEXBOX',
		'03' => 'FEDEXTUBE',
		'25' => 'FEDEX10KGBOX',
		'24' => 'FEDEX25KGBOX',
		'02' => 'YOURPACKAGING',
	);

	var $CODMap = array(
		'4' => 'ANY',
		'3' => 'GUARANTEEDFUNDS',	// money order
		'2' => 'GUARANTEEDFUNDS',
		'1' => 'GUARANTEEDFUNDS',	// check not a great match, but the best
		'0' => 'CASH',
	);

	var $HandlingMap = array(
		'' => 'FIXED_AMOUNT',
		'' => 'PERCENTAGE_OF_BASE',
		'' => 'PERCENTAGE_OF_NET',
		'' => 'PERCENTAGE_OF_NET_EXCL_TAXES',
	);

	var $PaymentMap = array(
		'0' => 'SENDER',
		'1' => 'RECIPIENT',
		'2' => 'THIRDPARTY',
		'3' => 'COLLECT',
	);

	var $SignatureMap = array(
		'1' => 'DELIVERYWITHOUTSIGNATURE',
		'2' => 'INDIRECT',	// closest match to signature required (other: DIRECT which requires the exact person)
		'3' => 'ADULT',
	);

// class constructor
	function fedex() {
      $this->code = 'fedex';
      $this->title = MODULE_SHIPPING_FEDEX_TEXT_TITLE;
	  $this->title_short = MODULE_SHIPPING_FEDEX_TITLE_SHORT;
      $this->description = MODULE_SHIPPING_FEDEX_TEXT_DESCRIPTION;
	  $this->enabled = ((MODULE_SHIPPING_FEDEX_STATUS == 'True') ? true : false);
      $this->sort_order = MODULE_SHIPPING_FEDEX_SORT_ORDER;

	  $this->rate_url = (MODULE_SHIPPING_FEDEX_TEST_MODE == 'Test') ? FEDEX_EXPRESS_TEST_RATE_URL : FEDEX_EXPRESS_RATE_URL;	  
    }

// class methods
    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_FEDEX_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install() {
      global $db;
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable FedEx Shipping', 'MODULE_SHIPPING_FEDEX_STATUS', 'True', 'Do you want to offer FedEx shipping?', '6', '0', 'cfg_select_option(array(\'True\', \'False\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('FedEx', 'MODULE_SHIPPING_FEDEX_TITLE', 'FedEx', 'Title to use for display purposes on shipping rate estimator', '6', '1', '', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('FedEx Account Number', 'MODULE_SHIPPING_FEDEX_ACCOUNT_NUMBER', '', 'Enter the FedEx account number to use for rate estimates', '6', '2', '', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('FedEx LTL Account Number', 'MODULE_SHIPPING_FEDEX_LTL_ACCOUNT_NUMBER', '', 'Enter the FedEx LTL account number to use for rate estimates. Leave this field blank if no LTL will be used.', '6', '3', '', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('FedEx LTL Registration Key', 'MODULE_SHIPPING_FEDEX_LTL_REG_KEY', '', 'Enter the FedEx LTL registration key provided by FedEx to use for rate estimates.', '6', '4', '', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('FedEx Meter Number', 'MODULE_SHIPPING_FEDEX_RATE_LICENSE', '', 'Enter the rate and service request license number supplied to you from FedEx.', '6', '5', '', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('FedEx Test Mode', 'MODULE_SHIPPING_FEDEX_TEST_MODE', 'Test', 'Test mode used for testing shipping labels', '6', '6', 'cfg_select_option(array(\'Test\', \'Production\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('FedEx Label Printer Type', 'MODULE_SHIPPING_FEDEX_PRINTER_TYPE', 'PDF', 'Type of printer to use for printing labels. PDF for plain paper, Thermal for FedEx 2844 Thermal Label Printer (See Help file before selecting Thermal printer)', '6', '7', 'cfg_select_option(array(\'PDF\', \'Thermal\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Sort order of display.', 'MODULE_SHIPPING_FEDEX_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '8', '', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Shipping Methods:', 'MODULE_SHIPPING_FEDEX_TYPES', '1DEam, 1Dam, 1Dpm, 1DFrt, 2Dam, 2Dpm, 2DFrt, 3Dpm, 3DFrt, GND, GDR, GndFrt, I2DEam, I2Dam, I3D, IGND', 'Select the FEDEX services to be offered by default.', '6', '10', 'cfg_select_assoc_multioption(array(\'1DEam\'=>\'" . MODULE_SHIPPING_FEDEX_1DM . "\',\'1Dam\'=>\'" . MODULE_SHIPPING_FEDEX_1DA . "\',\'1Dpm\'=>\'" . MODULE_SHIPPING_FEDEX_1DP . "\',\'1DFrt\'=>\'" . MODULE_SHIPPING_FEDEX_1DF . "\',\'2Dpm\'=>\'" . MODULE_SHIPPING_FEDEX_2DP . "\',\'2DFrt\'=>\'" . MODULE_SHIPPING_FEDEX_2DF . "\',\'3Dpm\'=>\'" . MODULE_SHIPPING_FEDEX_3DS . "\',\'3DFrt\'=>\'" . MODULE_SHIPPING_FEDEX_3DF . "\',\'GND\'=>\'" . MODULE_SHIPPING_FEDEX_GND . "\',\'GDR\'=>\'" . MODULE_SHIPPING_FEDEX_GDR . "\',\'GndFrt\'=>\'" . MODULE_SHIPPING_FEDEX_GDF . "\',\'I2DEam\'=>\'" . MODULE_SHIPPING_FEDEX_XDM . "\',\'I2Dam\'=>\'" . MODULE_SHIPPING_FEDEX_XPR . "\',\'I3D\'=>\'" . MODULE_SHIPPING_FEDEX_XPD . "\'), ', now() )");
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_FEDEX_STATUS',
	  	'MODULE_SHIPPING_FEDEX_TITLE',
		'MODULE_SHIPPING_FEDEX_ACCOUNT_NUMBER',
		'MODULE_SHIPPING_FEDEX_LTL_ACCOUNT_NUMBER',
		'MODULE_SHIPPING_FEDEX_LTL_REG_KEY',
		'MODULE_SHIPPING_FEDEX_RATE_LICENSE',
		'MODULE_SHIPPING_FEDEX_TEST_MODE',
		'MODULE_SHIPPING_FEDEX_PRINTER_TYPE',
		'MODULE_SHIPPING_FEDEX_TYPES',
		'MODULE_SHIPPING_FEDEX_SORT_ORDER',
	  );
    }

// ***************************************************************************************************************
//								FEDEX RATE AND SERVICE REQUEST
// ***************************************************************************************************************
    function quote($pkg) {
		global $messageStack;
		if ($pkg->pkg_weight == 0) {
			$messageStack->add(SHIPPING_ERROR_WEIGHT_ZERO, 'error');
			return false;
		}
		if ($pkg->ship_to_postal_code == '') {
			$messageStack->add(SHIPPING_FEDEX_ERROR_POSTAL_CODE, 'error');
			return false;
		}
		$status = $this->getFedExRates($pkg);
		if ($status['result'] == 'error') {
			$messageStack->add(SHIPPING_FEDEX_RATE_ERROR . $status['message'], 'error');
			return false;
		}
		return $status;
    }

	function FormatFedExRateRequest($pkg, $num_packages) {
		global $debug;
		$crlf = chr(13) . chr(10);
		
		$sBody = '<?xml version="1.0" encoding="UTF-8" ?>';
		$sBody .= $crlf . '<FDXRateAvailableServicesRequest xmlns:api="http://www.fedex.com/fsmapi" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="FDXRateAvailableServicesRequest.xsd">';
		$sBody .= $crlf . '<RequestHeader>';
		$sBody .= $crlf . '<CustomerTransactionIdentifier>FedEx Rate Shoppping Request</CustomerTransactionIdentifier>';
		$sBody .= $crlf . '<AccountNumber>' . MODULE_SHIPPING_FEDEX_ACCOUNT_NUMBER . '</AccountNumber>';
		$sBody .= $crlf . '<MeterNumber>' . MODULE_SHIPPING_FEDEX_RATE_LICENSE . '</MeterNumber>';
//		if ($CarrierCode <> 'ALL')	$sBody .= $crlf . '<CarrierCode>' . $pkg->carrier_code . '</CarrierCode>';	// spec says required but no code for ALL
		$sBody .= $crlf . '</RequestHeader>';
		$sBody .= $crlf . '<ShipDate>' . date('Y-m-d', strtotime($pkg->terminal_date)) . '</ShipDate>';
//		$sBody .= $crlf . '<ReturnShipmentIndicator>' . $pkg->return_ship_flag . '</ReturnShipmentIndicator>';
		$sBody .= $crlf . '<DropoffType>' . $this->FedExPickupMap[$pkg->pickup_service] . '</DropoffType>';
		$sBody .= $crlf . '<Packaging>' . $this->PackageMap[$pkg->pkg_type] . '</Packaging>';
		$sBody .= $crlf . '<WeightUnits>' . $pkg->pkg_weight_unit . '</WeightUnits>';
		$sBody .= $crlf . '<Weight>' . $pkg->pkg_weight . '</Weight>';
		if ($pkg->ship_to_country_code <> 'USA') {	// Cannot rate shop on international
			$sBody .= $crlf . '<ListRate>0</ListRate>';
		} else {
			$sBody .= $crlf . '<ListRate>1</ListRate>';
		}
		$sBody .= $crlf . '<OriginAddress>';
		if ($pkg->ship_state_province) $sBody .= $crlf . '<StateOrProvinceCode>' . $pkg->ship_state_province . '</StateOrProvinceCode>';
		$sBody .= $crlf . '<PostalCode>' . $pkg->ship_postal_code . '</PostalCode>';
		$sBody .= $crlf . '<CountryCode>' . $pkg->ship_from_country_iso2 . '</CountryCode>';
		$sBody .= $crlf . '</OriginAddress>';
		$sBody .= $crlf . '<DestinationAddress>';
		if ($pkg->ship_to_state) $sBody .= $crlf . '<StateOrProvinceCode>' . $pkg->ship_to_state . '</StateOrProvinceCode>';
		if ($pkg->ship_to_postal_code) $sBody .= $crlf . '<PostalCode>' . $pkg->ship_to_postal_code . '</PostalCode>';
		if ($pkg->ship_to_country_code) $sBody .= $crlf . '<CountryCode>' . $pkg->ship_to_country_iso2 . '</CountryCode>';
		$sBody .= $crlf . '</DestinationAddress>';
		$sBody .= $crlf . '<Payment>';
		$sBody .= $crlf . '<PayorType>' . 'SENDER' . '</PayorType>'; // needs to be blank or SENDER to get rates or 0 is returned
		$sBody .= $crlf . '</Payment>';
		$sBody .= $crlf . '<Dimensions>';
		$sBody .= $crlf . '<Length>' . $pkg->pkg_length . '</Length>';
		$sBody .= $crlf . '<Width>' . $pkg->pkg_width . '</Width>';
		$sBody .= $crlf . '<Height>' . $pkg->pkg_height . '</Height>';
		$sBody .= $crlf . '<Units>' . $pkg->pkg_dimension_unit . '</Units>';
		$sBody .= $crlf . '</Dimensions>';
		if ($pkg->insurance) {
			$sBody .= $crlf . '<DeclaredValue>';
			$sBody .= $crlf . '<Value>' . $pkg->insurance_value . '</Value>';
			$sBody .= $crlf . '<CurrencyCode>' . $pkg->insurance_currency . '</CurrencyCode>';
			$sBody .= $crlf . '</DeclaredValue>';
		}
		$sBody .= $crlf . '<SpecialServices>';
		//COD
		if ($pkg->cod) {
			$sBody .= $crlf . '<COD>';
			$sBody .= $crlf . '<CollectionAmount>' . $pkg->cod_amount . '</CollectionAmount>';
			$sBody .= $crlf . '<CollectionType>' . $this->CODMap[$pkg->cod_payment_type] . '</CollectionType>';
			$sBody .= $crlf . '</COD>';
		}
//		$sBody .= $crlf . '<HoldAtLocation>' . $pkg->hold_at . '</HoldAtLocation>'; // NOT USED AT THIS TIME
//		$sBody .= $crlf . '<DangerousGoods>';
//		$sBody .= $crlf . '<Accessibility>' . $pkg->accessibility . '</Accessibility>'; // NOT USED AT THIS TIME
//		$sBody .= $crlf . '</DangerousGoods>';
		if ($pkg->dry_ice) $sBody .= $crlf . '<DryIce>1</DryIce>';
//		$sBody .= $crlf . '<ResidentialPickup>' . $pkg->res_pickup . '</ResidentialPickup>'; // NOT USED AT THIS TIME
// FedEx Freight doesn't support residential address?????????????
		if ($pkg->residential_address && !((int)$num_packages == 1 && $pkg->pkg_weight > 150)) {
			$sBody .= $crlf . '<ResidentialDelivery>1</ResidentialDelivery>';
		}
//		$sBody .= $crlf . '<InsidePickup>' . $pkg->inside_pickup . '</InsidePickup>';
//		$sBody .= $crlf . '<InsideDelivery>' . $pkg->inside_delivery . '</InsideDelivery>';
		if ($pkg->saturday_pickup) $sBody .= $crlf . '<SaturdayPickup>1</SaturdayPickup>';
		if ($pkg->saturday_delivery) $sBody .= $crlf . '<SaturdayDelivery>1</SaturdayDelivery>';
//		$sBody .= $crlf . '<AOD>' . $pkg->aod . '</AOD>';
//		$sBody .= $crlf . '<AutoPOD>' . $pkg->auto_pod . '</AutoPOD>';
		if ($pkg->additional_handling) $sBody .= $crlf . '<NonstandardContainer>1</NonstandardContainer>';
		$sBody .= $crlf . '</SpecialServices>';
		$sBody .= $crlf . '<PackageCount>' . $num_packages . '</PackageCount>';
		if ($pkg->handling_charge) {
			$sBody .= $crlf . '<VariableHandlingCharges>';
			$sBody .= $crlf . '<Level>SHIPMENT</Level>'; // assume at the shipment level
			$sBody .= $crlf . '<Type>FIXED_AMOUNT</Type>';
			$sBody .= $crlf . '<AmountOrPercentage>' . $pkg->handling_charge_value . '</AmountOrPercentage>';
			$sBody .= $crlf . '</VariableHandlingCharges>';
		}
		$sBody .= $crlf . '</FDXRateAvailableServicesRequest>';
		$sBody .= $crlf;
		return $sBody;
	}

// ******************************************************************************************************************
//								FEDEX LTL FREIGHT RATE REQUEST
// ******************************************************************************************************************
	function FormatFedExLTLRequest($pkg, $carrier = 'FXF') {
		$sBody = NULL;
		$sBody .= '&regKey='       . MODULE_SHIPPING_FEDEX_LTL_REG_KEY;
		$sBody .= '&as_opco='      . $carrier;
		$sBody .= '&as_iamthe='    . 'shipper';
		$sBody .= '&as_acctnbr='   . MODULE_SHIPPING_FEDEX_LTL_ACCOUNT_NUMBER;
		$sBody .= '&as_shipterms=' . 'prepaid';
		$sBody .= '&as_shzip='     . COMPANY_POSTAL_CODE;
		$sBody .= '&as_shcntry='   . gen_get_country_iso_2_from_3(COMPANY_COUNTRY);
		$sBody .= '&as_shcity='    . COMPANY_CITY_TOWN;
		$sBody .= '&as_shstate='   . COMPANY_ZONE;
		$sBody .= '&as_cnzip='     . $pkg->ship_to_postal_code;
		$sBody .= '&as_cncntry='   . $pkg->ship_to_country_iso2;
		if ($pkg->ship_to_city)  $sBody .= '&as_cncity='    . $pkg->ship_to_city;
		if ($pkg->ship_to_state) $sBody .= '&as_cnstate='   . $pkg->ship_to_state;
		$sBody .= '&as_class1='    . $pkg->ltl_class;
		$sBody .= '&as_weight1='   . round($pkg->pkg_weight);
//		$sBody .= '&as_pcs1='      . '1';
		$sBody .= '&as_descr1='    . $pkg->ltl_description;
//		$sBody .= '&as_nmfc1='     . '';
//		$sBody .= '&as_haz1='      . '';
		$sBody .= '&as_decvalue='  . $pkg->insurance_value;
//		$sBody .= '&as_units='     . '';
		if ($pkg->cod) {
			$sBody .= '&as_codamount=' . $pkg->cod_amount;
			$sBody .= '&as_codfee=' . 'collect';
		}
//		$sBody .= '&as_insidedelivery=' . '';
//		$sBody .= '&as_insidepickup=' . '';
//		$sBody .= '&as_residentialpickup=' . '';
		if ($pkg->residential_address) $sBody .= '&as_residentialdelivery=' . 'Y';
//		$sBody .= '&as_freezable=' . '';
//		$sBody .= '&as_callbefore=' . '';
		if ($pkg->liftgate_required) $sBody .= '&as_liftgate=' . 'Y';
		$sBody .= '&as_singleshipment=' . 'Y';
//		$sBody .= '&as_limitedaccesspickup=' . '';
//		$sBody .= '&as_limitedaccessdelivery=' . '';
		return $sBody;
	}

// ***************************************************************************************************************
//								Parse function to retrieve FEDEX rates
// ***************************************************************************************************************
	function getFedExRates($pkg) {
		global $messageStack, $currencies, $pkg;

		$user_choices = explode(',', str_replace(' ', '', MODULE_SHIPPING_FEDEX_TYPES));  

		$FedExQuote = array();	// Initialize the Response Array

		$this->package = $pkg->split_shipment($pkg);
		if (!$this->package) {
			$messageStack->add(SHIPPING_FEDEX_PACKAGE_ERROR . $pkg->pkg_weight, 'error');
			return false;
		}

		// fisrt check if small package
// TBD convert weight to pounds if in KGs
		if ($pkg->split_large_shipments || ($pkg->num_packages == 1 && $pkg->pkg_weight <= 150)) {
			$arrRates = $this->queryFedEx($pkg, $user_choices, $pkg->num_packages);
		} else {
			$arrRates = array();
		}
		// now check if freight
		if ($pkg->pkg_weight > 150) {
			$freightRates = $this->queryFedEx($pkg, $user_choices, '1');
			if (is_array($arrRates) && is_array($freightRates)) {
				$arrRates = array_merge_recursive($this->queryFedEx($pkg, $user_choices, '1'), $arrRates);
			} elseif (is_array($freightRates)) {
				$arrRates = $freightRates;
			}
		}

		// now check Ground LTL
		if ($pkg->pkg_weight >= 150) {
// TBD TO and FROM US and CANADA ONLY !!!!!!!!!!
			// Fetch FedEx LTL quote (assumes FedEx Freight service and single skid shipment)
			$strXML = $this->FormatFedExLTLRequest($pkg, $carrier = 'FXF');
//echo 'FedEx Express Freight XML Submit String:<br />' . htmlspecialchars($strXML) . '<br />';
			$SubmitXML = GetXMLString($strXML, FEDEX_LTL_RATE_URL, 'GET');
			// Check for XML request errors
			if ($SubmitXML['result'] == 'error') {
				$messageStack->add(SHIPPING_FEDEX_CURL_ERROR . $SubmitXML['message'], 'error');
				return false;
			}
			$ResponseXML = trim($SubmitXML['xmlString']);
//echo '<br />XML Return String:<br />' . htmlspecialchars($ResponseXML) . '<br />';
			$pkg->parse(trim($SubmitXML['xmlString']));
//echo 'parsed array  = '; print_r($pkg->arrOutput); echo '<br />';
			// Check for errors
			$XMLFail = $pkg->arrOutput[0]['name'];
			if ($XMLFail == 'REQUEST-ERROR') {
			  foreach($pkg->arrOutput[0]['children'] as $error) {
			    if ($error['name'] == 'MESSAGES') {
				  $messageStack->add('FedEx Ground Freight LTL Rate Error. Description: ' . $error['tagData'], 'error');
				}
			  }
			} else {
			  $fuel_surcharge   = 0;
			  $freight_discount = 0;
			  $arrRates[$this->code]['GndFrt']['note'] = 'Call FedEx LTL for Transit Time';
			  foreach ($pkg->arrOutput[0]['children'] as $line) {
				switch ($line['name']) {
				  case 'LTLFUELSURCHARGE':
				    $fuel_surcharge = $line['tagData'];
				    break;
				  case 'NET-FREIGHT-CHARGES':
				    $arrRates[$this->code]['GndFrt']['cost'] = $line['tagData'];
				    break;
				  case 'TRANSIT-DAYS':
				    $arrRates[$this->code]['GndFrt']['note'] = $line['tagData'] . ' Day(s) Transit.';
				    break;
				  case 'DISCOUNTS':
			  		foreach ($line['children'] as $discount) {
			    	  if ($discount['name'] == 'DISC-AMOUNT') $freight_discount = $discount['tagData'];
					}
					break;
				  default:
				}
			  }
			  $base_cost = $arrRates[$this->code]['GndFrt']['cost'] - $fuel_surcharge;
			  $net_percent =  $base_cost / ($base_cost + $freight_discount);
			  if ($net_percent) $arrRates[$this->code]['GndFrt']['book']  = ($base_cost + $fuel_surcharge) / $net_percent;
			  if (function_exists('fedex_shipping_rate_calc')) {
				$arrRates[$this->code]['GndFrt']['quote'] = fedex_shipping_rate_calc($arrRates[$this->code]['GndFrt']['book'], $arrRates[$this->code]['GndFrt']['cost'], 'GndFrt');
			  } else {
				$arrRates[$this->code]['GndFrt']['quote'] = $arrRates[$this->code]['GndFrt']['book'];
			  }
			}
		}

		// All calculations finished, return
		$FedExQuote['result'] = 'success';
		$FedExQuote['rates'] = $arrRates;
		return $FedExQuote;
	}	// End FEDEX Rate Function

	function queryFedEx($pkg, $user_choices, $num_packages) {		// Fetch the book rates from FEDEX
		global $messageStack, $currencies;
		$arrRates = array();
		$strXML = $this->FormatFedExRateRequest($pkg, $num_packages);
//echo 'FedEx Express XML Submit String:<br />' . htmlspecialchars($strXML) . '<br />';
		$SubmitXML = GetXMLString($strXML, $this->rate_url, "POST");
		// Check for XML request errors
		if ($SubmitXML['result'] == 'error') {
			$messageStack->add(SHIPPING_FEDEX_CURL_ERROR . $SubmitXML['message'], 'error');
			return false;
		}
		$ResponseXML = $SubmitXML['xmlString'];
//echo '<br />XML Return String:<br />' . htmlspecialchars($ResponseXML) . '<br />';
		// Check for errors
		$XMLFail = GetNodeData($ResponseXML, 'Error:Code');
		if ($XMLFail) {	// fetch the error code
			$XMLErrorDesc = GetNodeData($ResponseXML, 'Error:Message');
			$FEDEXQuote['result'] = 'error';
			$messageStack->add(SHIPPING_FEDEX_RATE_ERROR . $XMLFail . ' - ' . $XMLErrorDesc,'error');
			return false;
		}
		// Fetch the FedEx Rates
		$XMLStart = 'Entry';
		$XMLIndexName = 'Service';	// name of the index in array
		$TagsToFind = array(
			'DeliveryDOW'  => 'DeliveryDay',	//index name and path from XMLStart to get data
			'TransitDays'  => 'TimeInTransit',
			'ShipmentCost' => 'EstimatedCharges:DiscountedCharges:NetCharge',
			'BookCharges'  => 'EstimatedCharges:ListCharges:NetCharge');
		$fdxRates = GetNodeArray($ResponseXML, $XMLStart, $XMLIndexName, $TagsToFind);
//echo 'FedEx rate array = '; print_r($fdxRates); echo '<br />';
		foreach ($this->FedExRateCodes as $key => $value) {
			if (isset($fdxRates[$key]) && in_array($value, $user_choices)) {
				if ($fdxRates[$key]['BookCharges']  <> "") $arrRates[$this->code][$value]['book'] = $currencies->clean_value($fdxRates[$key]['BookCharges']);
				if ($fdxRates[$key]['ShipmentCost'] <> "") $arrRates[$this->code][$value]['cost'] = $currencies->clean_value($fdxRates[$key]['ShipmentCost']);
				$arrRates[$this->code][$value]['note'] = '';
				if ($fdxRates[$key]['TransitDays'] <> "") $arrRates[$this->code][$value]['note'] .= $fdxRates[$key]['TransitDays'] . ' Day(s) Transit. ';
				if ($fdxRates[$key]['DeliveryDOW'] <> "") $arrRates[$this->code][$value]['note'] .= 'Arrives ' . $fdxRates[$key]['DeliveryDOW'];
				if (function_exists('fedex_shipping_rate_calc')) {
					$arrRates[$this->code][$value]['quote'] = fedex_shipping_rate_calc($arrRates[$this->code][$value]['book'], $arrRates[$this->code][$value]['cost'], $value);
				} else {
					if ($fdxRates[$key]['BookCharges'] <> "") $arrRates[$this->code][$value]['quote'] = $fdxRates[$key]['BookCharges'];
				}
			}
		}
		return $arrRates;
	}

	// special XML request to apply for a subscription meter number - Use only once to establish a number
	function retrieveMeterNumber() {
		global $messageStack;
		$strXML = $this->FedExSubscriptionRequest();
		$SubmitXML = GetXMLString($strXML, $this->rate_url, "POST");
		// Check for XML request errors
		if ($SubmitXML['result']=='error') {
			$messageStack->add(SHIPPING_FEDEX_CURL_ERROR . $SubmitXML['message'], 'error');
			return false;
		}
		$ResponseXML = $SubmitXML['xmlString'];
		// Check for errors returned from FedEx
		$XMLFail = GetNodeData($ResponseXML, 'Error:Code');
		if ($XMLFail) {	// fetch the error code
			$XMLErrorDesc = GetNodeData($ResponseXML, 'Error:Message');
			$messageStack->add('Meter Request failed. FedEx returned the following error: ' . GetNodeData($ResponseXML, 'Error:Message'), 'error');
			return false;
		}
		// Fetch the FedEx meter number
		$meter_number = GetNodeData($ResponseXML, 'MeterNumber');
		$messageStack->add('You FedEx meter number is ' . $meter_number . '. Your subscribed services are: ' . GetNodeData($ResponseXML, 'SubscribedService'),'success');
		return $meter_number;
	}

	function FedExSubscriptionRequest($contact_name = 'Shipping Dept') {
		global $debug;
		$crlf = chr(13).chr(10);
		$sBody = '<?xml version="1.0" encoding="UTF-8" ?>';
		$sBody .= $crlf . '<FDXSubscriptionRequest xmlns:api="http://www.fedex.com/fsmapi" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="FDXSubscriptionRequest.xsd">';
		$sBody .= $crlf . '<RequestHeader>';
		$sBody .= $crlf . '<CustomerTransactionIdentifier>FedEx Subscription Request</CustomerTransactionIdentifier>';
		$sBody .= $crlf . '<AccountNumber>' . MODULE_SHIPPING_FEDEX_ACCOUNT_NUMBER . '</AccountNumber>';
		$sBody .= $crlf . '</RequestHeader>';
		$sBody .= $crlf . '<Contact>';
		$sBody .= $crlf . '<PersonName>' . $contact_name . '</PersonName>';
		$sBody .= $crlf . '<CompanyName>' . COMPANY_NAME . '</CompanyName>';
		$sBody .= $crlf . '<PhoneNumber>' . strip_alphanumeric(COMPANY_TELEPHONE1) . '</PhoneNumber>';
		if (COMPANY_FAX) $sBody .= $crlf . '<FaxNumber>' . strip_alphanumeric(COMPANY_FAX) . '</FaxNumber>';
		if (COMPANY_EMAIL) $sBody .= $crlf . '<E-MailAddress>' . COMPANY_EMAIL . '</E-MailAddress>';
		$sBody .= $crlf . '</Contact>';
		$sBody .= $crlf . '<Address>';
		$sBody .= $crlf . '<Line1>' . COMPANY_ADDRESS1 . '</Line1>';
		if (COMPANY_ADDRESS2) $sBody .= $crlf . '<Line2>' . COMPANY_ADDRESS2 . '</Line2>';
		$sBody .= $crlf . '<City>' . COMPANY_CITY_TOWN . '</City>';
		$country_code = gen_get_country_iso_2_from_3(COMPANY_COUNTRY);
		if ($country_code == 'US' || $country_code == 'CA') $sBody .= $crlf . '<StateOrProvinceCode>' . COMPANY_ZONE . '</StateOrProvinceCode>';
		if ($country_code == 'US' || $country_code == 'CA' || COMPANY_POSTAL_CODE <> '') {
			$sBody .= $crlf . '<PostalCode>' . strip_alphanumeric(COMPANY_POSTAL_CODE) . '</PostalCode>';
		}
		$sBody .= $crlf . '<CountryCode>' . $country_code . '</CountryCode>';
		$sBody .= $crlf . '</Address>';
		$sBody .= $crlf . '</FDXSubscriptionRequest>';
		return $sBody;
	}

// ***************************************************************************************************************
//								FEDEX LABEL REQUEST (multipiece compatible) 
// ***************************************************************************************************************
	function retrieveLabel($sInfo) {
		global $messageStack;
		$fedex_results = array();
		if (in_array($sInfo->ship_method, array('I2DEam','I2Dam','I3D','GndFrt'))) { // unsupported ship methods
			$messageStack->add('The ship method requested is not supported by this tool presently. Please ship the package via a different tool.','error');
			return false;
		}
		for ($key = 0; $key < count($sInfo->package); $key++) {
			$strXML = $this->FormatFedExShipRequest($sInfo, $key);
//echo 'xmlString = ' . htmlspecialchars($strXML) . '<br />';
			// error check for overweight, etc
			$SubmitXML = GetXMLString($strXML, $this->rate_url, "POST");
//echo 'response string = ' . htmlspecialchars($SubmitXML['xmlString']) . '<br />';
			// Check for XML request errors
			if ($SubmitXML['result'] == 'error') {
				$messageStack->add(SHIPPING_FEDEX_CURL_ERROR . $SubmitXML['message'], 'error');
				return false;
			}
			$ResponseXML = $SubmitXML['xmlString'];
			$XMLFail = GetNodeData($ResponseXML, 'Error:Code'); // Check for errors returned from FedEx
			if ($XMLFail) {	// fetch the error code
				$messageStack->add('FedEx Label Error # ' . $XMLFail . ' - ' . GetNodeData($ResponseXML, 'Error:Message'),'error');
				return false;
			}
			// TBD check for soft errors
	
			// Fetch the FedEx label information
			$fedex_results[$key] = array(
				'tracking'      => GetNodeData($ResponseXML, 'Tracking:TrackingNumber'),
				'dim_weight'    => GetNodeData($ResponseXML, 'EstimatedCharges:DimWeightUsed'),
				'zone'          => GetNodeData($ResponseXML, 'EstimatedCharges:RateZone'),
				'billed_weight' => GetNodeData($ResponseXML, 'EstimatedCharges:BilledWeight'),
				'net_cost'      => GetNodeData($ResponseXML, 'EstimatedCharges:DiscountedCharges:NetCharge'),
				'book_cost'     => GetNodeData($ResponseXML, 'EstimatedCharges:ListCharges:NetCharge'),
				'delivery_date' => $this->FedExDate(GetNodeData($ResponseXML, 'Routing:DeliveryDate')));
			if ($key == 0) {
				$sInfo->master_tracking = $fedex_results[0]['tracking'];
				$sInfo->form_id = GetNodeData($ResponseXML, 'Tracking:FormID');
			}

			$label = GetNodeData($ResponseXML, 'Labels:OutboundLabel');
			if ($label) {
				$date = explode('-',$sInfo->terminal_date); // date format YYYY-MM-DD
				$file_path = DIR_FS_MY_FILES . $_SESSION['company'] . '/shipping/labels/' . $this->code . '/' . $date[0] . '/' . $date[1] . '/' . $date[2] . '/';
				validate_path($file_path);
				// check for label to be for thermal printer or plain paper
				if (MODULE_SHIPPING_FEDEX_PRINTER_TYPE == 'Thermal') {
					// keep the thermal label encoded for now
					$label = base64_decode($label);
					$file_name = $fedex_results[$key]['tracking'] . '.lpt'; // thermal printer
				} else {
					$label = base64_decode($label);
					$file_name = $fedex_results[$key]['tracking'] . '.pdf'; // plain paper
				}
				if (!$handle = fopen($file_path . $file_name, 'w')) { 
					$messageStack->add('Cannot open file (' . $file_path . $file_name . ')','error');
					return false;
				}
				if (fwrite($handle, $label) === false) {
					$messageStack->add('Cannot write to file (' . $file_path . $file_name . ')','error');
					return false;
				}
				fclose($handle);
				$messageStack->add_session('Successfully retrieved the FedEx shipping label. Tracking # ' . $fedex_results[$key]['tracking'],'success');
			} else {
				$messageStack->add('Error - No label found in return string.','error');
				return false;				
			}
		}
		return $fedex_results;
	}

	function FormatFedExShipRequest($pkg, $key) {
		global $ZONE001_DEFINES, $debug;
		$crlf = chr(13) . chr(10);

		if ($pkg->ship_method == 'GND' || $pkg->ship_method == 'GDR') {
			$carrier_code = 'FDXG';	// Ground and Ground Home Delivery
		} else {
			$carrier_code = 'FDXE';	// Express (all types)
		}
		$sBody = '<?xml version="1.0" encoding="UTF-8" ?>';
		$sBody .= $crlf . '<FDXShipRequest xmlns:api="http://www.fedex.com/fsmapi" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="FDXShipRequest.xsd">';
		$sBody .= $crlf . '<RequestHeader>';
		$sBody .= $crlf . '<CustomerTransactionIdentifier>FedEx Ship Request</CustomerTransactionIdentifier>';
		$sBody .= $crlf . '<AccountNumber>' . MODULE_SHIPPING_FEDEX_ACCOUNT_NUMBER . '</AccountNumber>';
		$sBody .= $crlf . '<MeterNumber>' . MODULE_SHIPPING_FEDEX_RATE_LICENSE . '</MeterNumber>';
		$sBody .= $crlf . '<CarrierCode>' . $carrier_code . '</CarrierCode>';
		$sBody .= $crlf . '</RequestHeader>';
		$sBody .= $crlf . '<ShipDate>' . $pkg->terminal_date . '</ShipDate>';
		$sBody .= $crlf . '<ShipTime>' . date('H:i:s', time()) . '</ShipTime>';
		$sBody .= $crlf . '<DropoffType>' . $this->FedExPickupMap[$pkg->pickup_service] . '</DropoffType>';
		//Service
		// special case if residential checked and GND service (commercial) is selected, change to GDR home delivery
		$temp = array_flip($this->FedExRateCodes);
		$ship_method = ($pkg->residential_address && ($pkg->ship_method == 'GND')) ? 'GDR' : $pkg->ship_method;
		$sBody .= $crlf . '<Service>' . $temp[$ship_method] . '</Service>';
		$sBody .= $crlf . '<Packaging>' . $this->PackageMap[$pkg->pkg_type] . '</Packaging>';
// TBD convert weight to pounds if in KGs
		$sBody .= $crlf . '<WeightUnits>' . $pkg->pkg_weight_unit . '</WeightUnits>';
// TBD total shipment weight or package weight 
		$sBody .= $crlf . '<Weight>' . number_format($pkg->package[$key]['weight'], 1) . '</Weight>';
		$sBody .= $crlf . '<CurrencyCode>' . $pkg->insurance_currency . '</CurrencyCode>';
		$sBody .= $crlf . '<ListRate>1</ListRate>';
		if ($pkg->return_service) $sBody .= $crlf . '<ReturnShipmentIndicator>PRINTRETURNLABEL</ReturnShipmentIndicator>';
		// Origin
		$sBody .= $crlf . '<Origin>';
		$sBody .= $crlf . '<Contact>';
		$sBody .= $crlf . '<CompanyName>' . COMPANY_NAME . '</CompanyName>';
		$sBody .= $crlf . '<PhoneNumber>' . strip_alphanumeric(COMPANY_TELEPHONE1) . '</PhoneNumber>';
		if (COMPANY_FAX) $sBody .= $crlf . '<FaxNumber>' . strip_alphanumeric(COMPANY_FAX) . '</FaxNumber>';
		if (COMPANY_EMAIL) $sBody .= $crlf . '<E-MailAddress>' . COMPANY_EMAIL . '</E-MailAddress>';
		$sBody .= $crlf . '</Contact>';
		$sBody .= $crlf . '<Address>';
		$sBody .= $crlf . '<Line1>' . COMPANY_ADDRESS1 . '</Line1>';
		if (COMPANY_ADDRESS2) $sBody .= $crlf . '<Line2>' . COMPANY_ADDRESS2 . '</Line2>';
		$sBody .= $crlf . '<City>' . COMPANY_CITY_TOWN . '</City>';
		$country_code = gen_get_country_iso_2_from_3(COMPANY_COUNTRY);
		if ($country_code == 'US' || $country_code == 'CA') $sBody .= $crlf . '<StateOrProvinceCode>' . COMPANY_ZONE . '</StateOrProvinceCode>';
		if ($country_code == 'US' || $country_code == 'CA' || COMPANY_POSTAL_CODE <> '') {
			$sBody .= $crlf . '<PostalCode>' . strip_alphanumeric(COMPANY_POSTAL_CODE) . '</PostalCode>';
		}
		$sBody .= $crlf . '<CountryCode>' . $country_code . '</CountryCode>';
		$sBody .= $crlf . '</Address>';
		$sBody .= $crlf . '</Origin>';
		// Destination
		$sBody .= $crlf . '<Destination>';
		$sBody .= $crlf . '<Contact>';
		if ($pkg->ship_contact) $sBody .= $crlf . '<PersonName>' . remove_special_chars($pkg->ship_contact) . '</PersonName>';
		$sBody .= $crlf . '<CompanyName>' . remove_special_chars($pkg->ship_primary_name) . '</CompanyName>';
		$sBody .= $crlf . '<PhoneNumber>' . strip_alphanumeric($pkg->ship_telephone1) . '</PhoneNumber>';
		if ($pkg->ship_email) $sBody .= $crlf . '<E-MailAddress>' . $pkg->ship_email . '</E-MailAddress>';
		$sBody .= $crlf . '</Contact>';
		$sBody .= $crlf . '<Address>';
		$sBody .= $crlf . '<Line1>' . remove_special_chars($pkg->ship_address1) . '</Line1>';
		if ($pkg->ship_address2) $sBody .= $crlf . '<Line2>' . remove_special_chars($pkg->ship_address2) . '</Line2>';

		$sBody .= $crlf . '<City>' . strtoupper($pkg->ship_city_town) . '</City>';
		if ($pkg->ship_country_code == 'US' || $pkg->ship_country_code == 'CA') $sBody .= $crlf . '<StateOrProvinceCode>' . strtoupper($pkg->ship_state_province) . '</StateOrProvinceCode>';
		if ($pkg->ship_country_code == 'US' || $pkg->ship_country_code == 'CA' || $pkg->ship_postal_code <> '') {
			$sBody .= $crlf . '<PostalCode>' . strip_alphanumeric($pkg->ship_postal_code) . '</PostalCode>';
		}
		$sBody .= $crlf . '<CountryCode>' . $pkg->ship_country_code . '</CountryCode>';
		$sBody .= $crlf . '</Address>';
		$sBody .= $crlf . '</Destination>';
		// Payment
		$sBody .= $crlf . '<Payment>';
		$sBody .= $crlf . '<PayorType>' . $this->PaymentMap[$pkg->bill_charges] . '</PayorType>';
		if ($pkg->bill_charges == '1' || $pkg->bill_charges == '2') {
			$sBody .= $crlf . '<Payor>';
			$sBody .= $crlf . '<AccountNumber>' . $pkg->bill_acct . '</AccountNumber>';
			$sBody .= $crlf . '<CountryCode>' . $pkg->ship_country_code . '</CountryCode>';
			$sBody .= $crlf . '</Payor>';
		}
		$sBody .= $crlf . '</Payment>';
		// Reference info
		$sBody .= $crlf . '<ReferenceInfo>';
//		$sBody .= $crlf . '<CustomerReference>' . $pkg->purchase_invoice_id . '</CustomerReference>';
		if ($pkg->so_po_ref_id) $sBody .= $crlf . '<PONumber>' . $pkg->so_po_ref_id . '</PONumber>';
		$sBody .= $crlf . '<InvoiceNumber>' . $pkg->purchase_invoice_id . '</InvoiceNumber>';
		$sBody .= $crlf . '</ReferenceInfo>';
		// Package
// TBD what about MPS???
		if ($pkg->pkg_type == '02') { // customer supplied packaging
			$sBody .= $crlf . '<Dimensions>';
			$sBody .= $crlf . '<Length>' . $pkg->package[$key]['length'] . '</Length>';
			$sBody .= $crlf . '<Width>' . $pkg->package[$key]['width'] . '</Width>';
			$sBody .= $crlf . '<Height>' . $pkg->package[$key]['height'] . '</Height>';
			$sBody .= $crlf . '<Units>' . $pkg->pkg_dimension_unit . '</Units>';
			$sBody .= $crlf . '</Dimensions>';
		}
		$sBody .= $crlf . '<DeclaredValue>' . number_format($pkg->package[$key]['value'], 2) . '</DeclaredValue>';
		// Special Services
		$sBody .= $crlf . '<SpecialServices>';
		if ($pkg->cod) {
			$sBody .= $crlf . '<COD>';
			$sBody .= $crlf . '<CollectionAmount>' . $pkg->total_amount . '</CollectionAmount>';
			$sBody .= $crlf . '<CollectionType>' . $this->CODMap[$pkg->cod_payment_type] . '</CollectionType>';
			$sBody .= $crlf . '</COD>';
		}
//		$sBody .= $crlf . '<HoldAtLocation>' . $pkg->hold_at_location . '</HoldAtLocation>'; // NOT USED AT THIS TIME
//		$sBody .= $crlf . '<DangerousGoods>';
//		$sBody .= $crlf . '<Accessibility>' . $pkg->accessibility . '</Accessibility>'; // NOT USED AT THIS TIME
//		$sBody .= $crlf . '</DangerousGoods>';
//		if ($pkg->dry_ice) $sBody .= $crlf . '<DryIce>1</DryIce>';
//		$sBody .= $crlf . '<ResidentialPickup>' . $pkg->res_pickup . '</ResidentialPickup>'; // NOT USED AT THIS TIME
		if ($pkg->residential_address) $sBody .= $crlf . '<ResidentialDelivery>1</ResidentialDelivery>';
//		$sBody .= $crlf . '<InsidePickup>' . $pkg->inside_pickup . '</InsidePickup>';
//		$sBody .= $crlf . '<InsideDelivery>' . $pkg->inside_delivery . '</InsideDelivery>';
//		if ($pkg->saturday_pickup) $sBody .= $crlf . '<SaturdayPickup>1</SaturdayPickup>';
		if ($pkg->saturday_delivery) $sBody .= $crlf . '<SaturdayDelivery>1</SaturdayDelivery>';
		if ($pkg->email_sndr_ship || $pkg->email_sndr_excp || $pkg->email_sndr_dlvr || $pkg->email_rcp_ship || $pkg->email_rcp_excp || $pkg->email_rcp_dlvr) {
			$sBody .= $crlf . '<EMailNotification>';
			if ($pkg->email_sndr_ship || $pkg->email_sndr_excp || $pkg->email_sndr_dlvr) {
				$sBody .= $crlf . '<Shipper>';
				if ($pkg->email_sndr_ship) $sBody .= $crlf . '<ShipAlert>' . $pkg->email_sndr_ship . '</ShipAlert>';
				if ($pkg->email_sndr_dlvr) $sBody .= $crlf . '<DeliveryNotification>' . $pkg->email_sndr_dlvr . '</DeliveryNotification>';
				if ($pkg->email_sndr_excp) $sBody .= $crlf . '<ExceptionNotification>' . $pkg->email_sndr_excp . '</ExceptionNotification>';
				$sBody .= $crlf . '<Format>TEXT</Format>';
				$sBody .= $crlf . '<LanguageCode>en</LanguageCode>';
				$sBody .= $crlf . '</Shipper>';
			}
			if ($pkg->email_rcp_ship || $pkg->email_rcp_excp || $pkg->email_rcp_dlvr) {
				$sBody .= $crlf . '<Recipient>';
				if ($pkg->email_rcp_ship) $sBody .= $crlf . '<ShipAlert>' . $pkg->email_rcp_ship . '</ShipAlert>';
				if ($pkg->email_rcp_dlvr) $sBody .= $crlf . '<DeliveryNotification>' . $pkg->email_rcp_dlvr . '</DeliveryNotification>';
				if ($pkg->email_rcp_excp) $sBody .= $crlf . '<ExceptionNotification>' . $pkg->email_rcp_excp . '</ExceptionNotification>';
				$sBody .= $crlf . '<Format>TEXT</Format>';
				$sBody .= $crlf . '<LanguageCode>en</LanguageCode>';
				$sBody .= $crlf . '</Recipient>';
			}
			$sBody .= $crlf . '</EMailNotification>';
		}
		if ($pkg->additional_handling) $sBody .= $crlf . '<NonstandardContainer>1</NonstandardContainer>';
		if ($pkg->delivery_confirmation) $sBody .= $crlf . '<SignatureOption>' . $this->SignatureMap[$pkg->delivery_confirmation_type] . '</SignatureOption>';
		$sBody .= $crlf . '</SpecialServices>';
		if (count($pkg->package) > 1) {
			$sBody .= $crlf . '<MultiPiece>';
			$sBody .= $crlf . '<PackageCount>' . count($pkg->package) . '</PackageCount>';
			$sBody .= $crlf . '<PackageSequenceNumber>' . ($key + 1) . '</PackageSequenceNumber>';
//			$sBody .= $crlf . '<ShipmentWeight>' . count($pkg->package) . '</ShipmentWeight>';
			if ($key > 0) { // link to the master package
				$sBody .= $crlf . '<MasterTrackingNumber>' . $pkg->master_tracking . '</MasterTrackingNumber>';
				if ($carrier_code == 'FDXE') $sBody .= $crlf . '<MasterFormID>' . $pkg->form_id . '</MasterFormID>';
			}
			$sBody .= $crlf . '</MultiPiece>';
		}

		$sBody .= $crlf . '<Label>';
		$sBody .= $crlf . '<Type>2DCOMMON</Type>';
		// For thermal labels
		if (MODULE_SHIPPING_FEDEX_PRINTER_TYPE == 'Thermal') { // valid values are PDF, PNG, ELTRON, ZEBRA, UNIMARK
			$sBody .= $crlf . '<ImageType>' . IMAGETYPE . '</ImageType>'; 
			$sBody .= $crlf . '<LabelStockOrientation>' . LABELSTOCKORIENTATION . '</LabelStockOrientation>'; // (LEADING, TRAILING, NONE)
			$sBody .= $crlf . '<DocTabLocation>' . DOCTABLOCATION . '</DocTabLocation>'; // only valid for thermal labels (TOP, BOTTOM)
			$sBody .= $crlf . '<DocTabContent>';
			$sBody .= $crlf . '<Type>' . DOCTABCONTENT . '</Type>'; // (STANDARD, ZONE001, BARCODED, NONE)
			if (DOCTABCONTENT == 'ZONE001') {
			  $sBody .= $crlf . '<Zone001>';
			  foreach ($ZONE001_DEFINES as $zone => $settings) {
				$sBody .= $crlf . '<HeaderValuePair>';
				$sBody .= $crlf . '<ZoneNumber>' . $zone . '</ZoneNumber>';
				$sBody .= $crlf . '<Header>' . $settings['Header'] . '</Header>';
				if (($pkg->ship_method == 'GND') || ($pkg->ship_method == 'GDR')) $settings['Value'] = str_replace('/', '', $settings['Value']);
				$sBody .= $crlf . '<Value>' . $settings['Value'] . '</Value>';
				$sBody .= $crlf . '</HeaderValuePair>';
			  }
			  $sBody .= $crlf . '</Zone001>';
			}
			$sBody .= $crlf . '</DocTabContent>';
		} else { // default to pdf for laser labels
			$sBody .= $crlf . '<ImageType>' . 'PDF' . '</ImageType>';
		}
		$sBody .= $crlf . '</Label>';

		$sBody .= $crlf . '</FDXShipRequest>';
		$sBody .= $crlf;
		return $sBody;
	}

// ***************************************************************************************************************
//								FEDEX DELETE LABEL REQUEST
// ***************************************************************************************************************
	function deleteLabel($method = 'FDXE', $shipment_id = '') {
		global $db, $messageStack;
		if (!$shipment_id) {
			$messageStack->add('Cannot delete shipment, shipment ID was not provided!','error');
			return false;
		}
		$result = array();
		$shipments = $db->Execute("select ship_date, tracking_id from " . TABLE_SHIPPING_LOG . " where shipment_id = " . $shipment_id);
		while (!$shipments->EOF) {
			$tracking_number = $shipments->fields['tracking_id'];
			$strXML = $this->FormatFedExDeleteRequest($method, $tracking_number);
			$SubmitXML = GetXMLString($strXML, $this->rate_url, "POST");
			// Check for cURL XML request errors
			if ($SubmitXML['result']=='error') {
				$messageStack->add(SHIPPING_FEDEX_CURL_ERROR . $SubmitXML['message'], 'error');
				return false;
			}
			$ResponseXML = $SubmitXML['xmlString'];
			// Check for errors returned from FedEx
			$XMLFail = GetNodeData($ResponseXML, 'Error:Code');
			if ($XMLFail) {	// fetch the error code
				$messageStack->add('FedEx Delete Label Error # ' . $XMLFail . ' - ' . GetNodeData($ResponseXML, 'Error:Message'),'error');
				return false;
			}

			// delete the label file
			$date = explode('-',$shipments->fields['ship_date']);
			$file_path = DIR_FS_MY_FILES . $_SESSION['company'] . '/shipping/labels/' . $this->code . '/' . $date[0] . '/' . $date[1] . '/' . $date[2] . '/';
			if (file_exists($file_path . $shipments->fields['tracking_id'] . '.lpt')) {
				$file_name = $shipments->fields['tracking_id'] . '.lpt';
			} elseif (file_exists($file_path . $shipments->fields['tracking_id'] . '.pdf')) {
				$file_name = $shipments->fields['tracking_id'] . '.pdf';
			} else {
				$file_name = false; // file does not exist, skip
			}
			if ($file_name) if (!unlink($file_path . $file_name)) { // only delete if it is there
				$messageStack->add_session('Trouble removing label file (' . $file_path . $file_name . ')','caution');
			}

			// if we are here the delete was successful, the lack of an error indicates success
			$messageStack->add_session('Successfully deleted the FedEx shipping label. Tracking # ' . $tracking_number,'success');
			$shipments->MoveNext();
		}
		return true;
	}

	function FormatFedExDeleteRequest($method, $tracking_number) {
		$crlf = chr(13) . chr(10);
		$sBody = '<?xml version="1.0" encoding="UTF-8" ?>';
		$sBody .= $crlf . '<FDXShipDeleteRequest xmlns:api="http://www.fedex.com/fsmapi" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="FDXShipDeleteRequest.xsd">';
		$sBody .= $crlf . '<RequestHeader>';
		$sBody .= $crlf . '<CustomerTransactionIdentifier>FedEx Ship Delete Request</CustomerTransactionIdentifier>';
		$sBody .= $crlf . '<AccountNumber>' . MODULE_SHIPPING_FEDEX_ACCOUNT_NUMBER . '</AccountNumber>';
		$sBody .= $crlf . '<MeterNumber>' . MODULE_SHIPPING_FEDEX_RATE_LICENSE . '</MeterNumber>';
		$sBody .= $crlf . '<CarrierCode>' . (($method == 'GND' || $method == 'GDR') ? 'FDXG' : 'FDXE') . '</CarrierCode>';
		$sBody .= $crlf . '</RequestHeader>';
		$sBody .= $crlf . '<TrackingNumber>' . $tracking_number . '</TrackingNumber>';
		$sBody .= $crlf . '</FDXShipDeleteRequest>';
		return $sBody;
	}

// ***************************************************************************************************************
//								FEDEX CLOSE REQUEST
// ***************************************************************************************************************
	function closeFedEx($close_date = '', $report_only = false, $report_type = 'MANIFEST') {
		global $messageStack;
		$today = date('Y-m-d');
		if (!$close_date) $close_date = $today;
		$report_only = ($close_date == $today) ? false : true;
		$date = explode('-', $close_date);
		$error = false;
		foreach(array('FDXG', 'FDXE') as $code) {
			$strXML = $this->FormatFedExCloseRequest($code, $close_date, $report_only);
//echo 'strXML = ' . htmlspecialchars($strXML) . '<br /><br />';
			$SubmitXML = GetXMLString($strXML, $this->rate_url, "POST");
			// Check for XML request errors
			if ($SubmitXML['result'] == 'error') {
				$messageStack->add(SHIPPING_FEDEX_CURL_ERROR . $SubmitXML['message'], 'error');
				$error = true;
				continue;
			}
			$ResponseXML = $SubmitXML['xmlString'];
//echo 'ResponseXML = ' . htmlspecialchars($ResponseXML) . '<br /><br />';
			// Check for errors returned from FedEx
			$XMLFail = GetNodeData($ResponseXML, 'Error:Code');
			if ($XMLFail) {	// fetch the error code
				$messageStack->add('FedEx service: ' . $code . ' Close Error # ' . $XMLFail . ' - ' . GetNodeData($ResponseXML, 'Error:Message'),'caution');
				$error = true;
				continue;
			}
			// Fetch the FedEx reports
			$file_path = DIR_FS_MY_FILES . $_SESSION['company'] . '/shipping/reports/' . $this->code . '/' . $date[0] . '/' . $date[1] . '/';
			validate_path($file_path);
//echo 'file_path = ' . ($file_path) . '<br />';
			$file_name = $date[2] . '-' . GetNodeData($ResponseXML, 'Manifest:FileName') . '.txt';
//echo 'file_name = ' . ($file_name) . '<br />';
			$mwReport = base64_decode(GetNodeData($ResponseXML, 'MultiweightReport'));
			$closeReport = base64_decode(GetNodeData($ResponseXML, 'Manifest:File'));
//echo 'close report = ' . $closeReport . '<br />';
			$codReport = base64_decode(GetNodeData($ResponseXML, 'CODReport'));
//			$hazMatReport = base64_decode(GetNodeData($ResponseXML, 'HazMatCertificate'));

			if (!$handle = fopen($file_path . $file_name, 'w')) {
				echo 'Cannot open file (' . $file_path . $file_name . ')';
				$error = true;
				continue;
			}
			if (fwrite($handle, $closeReport) === false) {
				$messageStack->add('Cannot write close report to file (' . $file_path . $file_name . ')','error');
				$error = true;
				continue;
			}
			if (fwrite($handle, $mwReport) === false) {
				$messageStack->add('Cannot write multi-weight report to file (' . $file_path . $file_name . ')','error');
				$error = true;
				continue;
			}
			if (fwrite($handle, $codReport) === false) {
				$messageStack->add('Cannot write COD report to file (' . $file_path . $file_name . ')','error');
				$error = true;
				continue;
			}
/*
			if (fwrite($handle, $hazMatReport) === false) {
				$messageStack->add('Cannot write Hazmat report to file (' . $file_path . $file_name . ')','error');
				$error = true;
				continue;
			}
*/
			fclose($handle);
		}
		if (!$error) $messageStack->add('Successfully closed the FedEx shipments for today.','success');
		return true;
	}

	function FormatFedExCloseRequest($code = 'FDXG', $date, $report_only = false, $report_type = 'MANIFEST') {
		$crlf = chr(13) . chr(10);
		$sBody = '<?xml version="1.0" encoding="UTF-8" ?>';
		$sBody .= $crlf . '<FDXCloseRequest xmlns:api="http://www.fedex.com/fsmapi" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="FDXCloseRequest.xsd">';
		$sBody .= $crlf . '<RequestHeader>';
		$sBody .= $crlf . '<CustomerTransactionIdentifier>FedEx Ship Close Request</CustomerTransactionIdentifier>';
		$sBody .= $crlf . '<AccountNumber>' . MODULE_SHIPPING_FEDEX_ACCOUNT_NUMBER . '</AccountNumber>';
		$sBody .= $crlf . '<MeterNumber>' . MODULE_SHIPPING_FEDEX_RATE_LICENSE . '</MeterNumber>';
		$sBody .= $crlf . '<CarrierCode>' . $code . '</CarrierCode>';
		$sBody .= $crlf . '</RequestHeader>';
		$sBody .= $crlf . '<Date>' . $date . '</Date>';
		$sBody .= $crlf . '<Time>' . date('H:i:s', time()) . '</Time>';
		if ($report_only) { // if reprinting reports, add these
			$sBody .= $crlf . '<ReportOnly>1</ReportOnly>';
			$sBody .= $crlf . '<ReportIndicator>' . $report_type . '</ReportIndicator>';
		}
		$sBody .= $crlf . '</FDXCloseRequest>';
		return $sBody;
	}

// ***************************************************************************************************************
//								Misc Functions
// ***************************************************************************************************************
	// converts date of the form DDmmmYY to YYYY-MM-DD (mmm is the 3 letter abreviation)
	function FedExDate($sDate) {
		if (!$sDate) return '000-00-00';
		$fedex_year = substr($sDate, 5, 2);
		$fedex_month = substr($sDate, 2, 3);
		$fedex_day = substr($sDate, 0, 2);
		$year = substr(date('Y', time()), 0, 2) . $fedex_year;
		switch ($fedex_month) {
			case 'JAN': $month = '01'; break;
			case 'FEB': $month = '02'; break;
			case 'MAR': $month = '03'; break;
			case 'APR': $month = '04'; break;
			case 'MAY': $month = '05'; break;
			case 'JUN': $month = '06'; break;
			case 'JUL': $month = '07'; break;
			case 'AUG': $month = '08'; break;
			case 'SEP': $month = '09'; break;
			case 'OCT': $month = '10'; break;
			case 'NOV': $month = '11'; break;
			case 'DEC': $month = '12'; break;
		}
		return $year . '-' . $month . '-' . $fedex_day;
	}

} // end class
?>