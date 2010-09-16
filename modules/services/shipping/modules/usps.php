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
//  Path: /modules/services/shipping/modules/usps.php
//

// fetch the language file, if it exists, and define service levels per FEDEX standards
include(DIR_FS_MODULES . 'services/shipping/language/' . $_SESSION['language'] . '/modules/usps.php');

// constants used in rate screen to match carrier descrptions
define('usps_1Dam',MODULE_SHIPPING_USPS_1DA);
define('usps_2Dpm',MODULE_SHIPPING_USPS_2DP);
define('usps_3Dpm',MODULE_SHIPPING_USPS_3DS);
define('usps_GND',MODULE_SHIPPING_USPS_GND);

  class usps {
	// FedEx Rate code maps
	var $USPSRateCodes = array(	
		'Express Mail' => '1Dam',
		'Priority Mail' => '3Dpm',
		'Parcel Post' => 'GND');

// class constructor
    function usps() {
      global $order, $db; //, $template;

      $this->code = 'usps';
      $this->title = MODULE_SHIPPING_USPS_TEXT_TITLE;
      $this->title_short = MODULE_SHIPPING_USPS_TITLE_SHORT;
      $this->description = MODULE_SHIPPING_USPS_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_USPS_SORT_ORDER;
      $this->enabled = ((MODULE_SHIPPING_USPS_STATUS == 'True') ? true : false);

      $this->types = array('Express' => 'Express Mail',
                           'First Class' => 'First-Class Mail',
                           'Priority' => 'Priority Mail',
                           'Parcel' => 'Parcel Post',
                           'Media' => 'Media Mail',
                           'BPM' => 'Bound Printed Material',
                           'Library' => 'Library');

      $this->intl_types = array('GXG Document' => 'Global Express Guaranteed Document Service',
                                'GXG Non-Document' => 'Global Express Guaranteed Non-Document Service',
                                'Express' => 'Global Express Mail (EMS)',
                                'Priority Lg' => 'Global Priority Mail - Flat-rate Envelope (Large)',
                                'Priority Sm' => 'Global Priority Mail - Flat-rate Envelope (Small)',
                                'Priority Var' => 'Global Priority Mail - Variable Weight (Single)',
                                'Airmail Letter' => 'Airmail Letter-post',
                                'Airmail Parcel' => 'Airmail Parcel Post',
                                'Surface Letter' => 'Economy (Surface) Letter-post',
                                'Surface Post' => 'Economy (Surface) Parcel Post');
    }

// class methods
    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_USPS_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install() {
      global $db;
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable USPS Shipping', 'MODULE_SHIPPING_USPS_STATUS', 'True', 'Do you want to offer USPS shipping?', '6', '0', 'cfg_select_option(array(\'True\', \'False\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('US Postal Service', 'MODULE_SHIPPING_USPS_TITLE', 'US Postal Service', 'Title to use for display purposes on shipping rate estimator', '6', '0', '', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Enter the USPS User ID', 'MODULE_SHIPPING_USPS_USERID', 'NONE', 'Enter the USPS USERID assigned to you.', '6', '0', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Enter the USPS Password', 'MODULE_SHIPPING_USPS_PASSWORD', 'NONE', 'See USERID, above.', '6', '0', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Which server to use', 'MODULE_SHIPPING_USPS_SERVER', 'production', 'An account at USPS is needed to use the Production server', '6', '0', 'cfg_select_option(array(\'test\', \'production\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('All Packages are Machinable', 'MODULE_SHIPPING_USPS_MACHINABLE', 'False', 'Are all products shipped machinable based on C700 Package Services 2.0 Nonmachinable PARCEL POST USPS Rules and Regulations?<br /><br /><strong>Note: Nonmachinable packages will usually result in a higher Parcel Post Rate Charge.<br /><br />Packages 35lbs or more, or less than 6 ounces (.375), will be overridden and set to False</strong>', '6', '0', 'cfg_select_option(array(\'True\', \'False\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_SHIPPING_USPS_SORT_ORDER', '0', 'Sort order of display.', '6', '0', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Domestic Shipping Methods:', 'MODULE_SHIPPING_USPS_TYPES', '1Dpm, 3Dpm, GND', 'Select the USPS domestic services to be offered by default.', '6', '14', 'cfg_select_assoc_multioption(array(\'1Dpm\'=>\'" . MODULE_SHIPPING_USPS_1DP . "\',\'3Dpm\'=>\'" . MODULE_SHIPPING_USPS_3DS . "\',\'GND\'=>\'" . MODULE_SHIPPING_USPS_GND . "\'), ', now() )");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Int\'l Shipping Methods', 'MODULE_SHIPPING_USPS_TYPES_INTL', 'GXG Document, GXG Non-Document, Express, Priority Lg, Priority Sm, Priority Var, Airmail Letter, Airmail Parcel, Surface Letter, Surface Post', 'Select the international services to be offered:', '6', '15', 'cfg_select_multioption(array(\'GXG Document\', \'GXG Non-Document\', \'Express\', \'Priority Lg\', \'Priority Sm\', \'Priority Var\', \'Airmail Letter\', \'Airmail Parcel\', \'Surface Letter\', \'Surface Post\'), ',  now())");
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array(
	  	'MODULE_SHIPPING_USPS_STATUS', 
		'MODULE_SHIPPING_USPS_TITLE', 
		'MODULE_SHIPPING_USPS_USERID', 
		'MODULE_SHIPPING_USPS_PASSWORD', 
		'MODULE_SHIPPING_USPS_SERVER', 
		'MODULE_SHIPPING_USPS_SORT_ORDER', 
		'MODULE_SHIPPING_USPS_MACHINABLE', 
		'MODULE_SHIPPING_USPS_TYPES', 
		'MODULE_SHIPPING_USPS_TYPES_INTL');
    }

// ***************************************************************************************************************
//								USPS RATE AND SERVICE REQUEST
// ***************************************************************************************************************
    function quote($pkg) {
		global $messageStack;
		if ($pkg->pkg_weight == 0) {
			$messageStack->add(SHIPPING_ERROR_WEIGHT_ZERO, 'error');
			return false;
		}
		if ($pkg->ship_to_postal_code == '') {
			$messageStack->add(SHIPPING_USPS_ERROR_POSTAL_CODE, 'error');
			return false;
		}
		$status = $this->getUSPSRates($pkg);
		if ($status['result'] == 'error') {
			$messageStack->add(SHIPPING_USPS_RATE_ERROR . $status['message'], 'error');
			return false;
		}
		return $status;
    }

	function production_FormatUSPSRateRequest($pkg, $num_packages) {
		global $debug;
// TBD this is for domestic only, international needs to be added based on country selected...
		$sBody = '<RateV2Request USERID="' . MODULE_SHIPPING_USPS_USERID . '">';
// TBD for multiple requests, loop with package number entered
		$sBody .= '<Package ID="1">';
		$sBody .= '<Service>All</Service>';
		$sBody .= '<ZipOrigination>' . $pkg->ship_postal_code . '</ZipOrigination>';
		$sBody .= '<ZipDestination>' . $pkg->ship_to_postal_code . '</ZipDestination>';
		$sBody .= '<Pounds>' . floor($pkg->pkg_weight) . '</Pounds>';
		$sBody .= '<Ounces>' . ceil(($pkg->pkg_weight % 1) * 16). '</Ounces>';
// TBD for special packages flat rate env, flat rate box, etc. (see spec)
//		$sBody .= '<Container>' . $pkg->pkg_weight . '</Container>';
// TBD use LxWxH to calculate the size parameter (Regular, Large, Oversize)
		$sBody .= '<Size>Regular</Size>';
		$sBody .= '<Machinable>True</Machinable>';
		$sBody .= '</Package>';
		$sBody .= '</RateV2Request>';
		return $sBody;
	}

	function FormatUSPSRateRequest($pkg, $num_packages) { // Example 1. To use for the test server (cannot change any values)
		global $debug;
		$sBody = '<RateV2Request USERID="' . MODULE_SHIPPING_USPS_USERID . '">';
		$sBody .= '<Package ID="0">';
		$sBody .= '<Service>PRIORITY</Service>';
		$sBody .= '<ZipOrigination>10022</ZipOrigination>';
		$sBody .= '<ZipDestination>20008</ZipDestination>';
		$sBody .= '<Pounds>10</Pounds>';
		$sBody .= '<Ounces>5</Ounces>';
		$sBody .= '<Container>Flat Rate Box</Container>';
		$sBody .= '<Size>Regular</Size>';
		$sBody .= '</Package>';
		$sBody .= '</RateV2Request>';
		return $sBody;
	}

// ***************************************************************************************************************
//								Parse function to retrieve USPS rates
// ***************************************************************************************************************
	function getUSPSRates($pkg) {
		global $messageStack, $pkg;
		$user_choices = explode(',', str_replace(' ', '', MODULE_SHIPPING_USPS_TYPES));
		$USPSQuote = array();	// Initialize the Response Array

		$this->package = $pkg->split_shipment($pkg);
		if (!$this->package) {
			$messageStack->add(SHIPPING_USPS_PACKAGE_ERROR . $pkg->pkg_weight, 'error');
			return false;
		}
// TBD convert weight to pounds if in KGs
		if ($pkg->split_large_shipments || ($pkg->num_packages == 1 && $pkg->pkg_weight <= 70)) {
			$arrRates = $this->queryUSPS($pkg, $user_choices, $pkg->num_packages);
		} else {
			$arrRates = false;
		}
		if (!$arrRates) return array();
		$USPSQuote['result'] = 'success';
		$USPSQuote['rates'] = $arrRates;
		return $USPSQuote;
	}	// End USPS Rate Function

	function queryUSPS($pkg, $user_choices, $num_packages) {		// Fetch the book rates from USPS
		global $messageStack;
		$arrRates = array();
		if (MODULE_SHIPPING_USPS_SERVER == 'production') {
			$strXML = 'API=RateV2&XML=' . $this->production_FormatUSPSRateRequest($pkg, $num_packages);
			$RateURL = 'http://Production.ShippingAPIs.com/ShippingAPI.dll';
		} else {
			$strXML = 'API=RateV2&XML=' . $this->FormatUSPSRateRequest($pkg, $num_packages);
			$RateURL = 'http://testing.shippingapis.com/ShippingAPITest.dll';
		}
		$SubmitXML = GetXMLString($strXML, $RateURL, "GET");
		// Check for XML request errors
		if ($SubmitXML['result']=='error') {
			$messageStack->add(SHIPPING_USPS_CURL_ERROR . $SubmitXML['message'], 'error');
			return false;
		}
		$ResponseXML = $SubmitXML['xmlString'];
//echo 'USPS response XML string = ' . htmlspecialchars($ResponseXML) . '<br />';
		// Check for errors
		$XMLFail = GetNodeData($ResponseXML, 'Error:Number');
		if ($XMLFail) {	// fetch the error code
			$XMLErrorDesc = GetNodeData($ResponseXML, 'Error:Description');
			$messageStack->add($this->code . ' - ' . $XMLFail . ' - ' . $XMLErrorDesc, 'error');
			return false;
		}
		// Fetch the USPS Rates
		return $this->GetUSPSRateArray($ResponseXML, $packageID = '1');
	}

	function GetUSPSRateArray($SearchXML, $packageID) {
		$arrXML = false;
		$StartTag = strpos($SearchXML, '<Package ID="' . $packageID . '">');
		$EndTag = strpos($SearchXML, '</Package>', $StartTag);
		$pkgXML = substr($SearchXML, $StartTag, $EndTag - $StartTag); // just have the package ID # return string only

		while (true) { 
			$StartTag = strpos($pkgXML, '<Postage>');
			if ($StartTag === false) break;
			$service = GetNodeData($pkgXML, 'MailService');
			$rate = GetNodeData($pkgXML, 'Rate');
			foreach ($this->USPSRateCodes as $key => $value) {
				if ($service == $key) {
					$arrXML[$this->code][$value]['book'] = $rate;
					$arrXML[$this->code][$value]['quote'] = $rate;
					$arrXML[$this->code][$value]['cost'] = $rate;
					$arrXML[$this->code][$value]['note'] = '';
				}
			}
			$EndTag = strpos($pkgXML, '</Postage>', $StartTag);
			$pkgXML = substr($pkgXML, $EndTag);
		}
		return $arrXML;
	}
  }
?>