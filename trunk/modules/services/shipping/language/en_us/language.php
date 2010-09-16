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
//  Path: /modules/services/shipping/language/en_us/language.php
//

// shipping
define('HEADING_TITLE_MODULES_SHIPPING','Shipping Services');
define('SHIPPING_HEADING_SHIP_MGR','Shipping Module Manager');
define('SHIPPING_BUTTON_CREATE_LOG_ENTRY','Create a Shipment Entry');
define('SHIPPING_SET_BY_SYSTEM',' (Set by the system)');

define('SHIPPING_POPUP_WINDOW_TITLE','Shipping Rate Estimator');
define('SHIPPING_POPUP_WINDOW_RATE_TITLE','Shipping Estimator - Rates');
define('SHIPPING_ESTIMATOR_OPTIONS','Shipping Estimator - Shipment Options');
define('SHIPPING_TEXT_SHIPPER','Shipper:');
define('SHIPPING_TEXT_SHIPMENT_DATE','Shipment Date');
define('SHIPPING_TEXT_SHIP_FROM_CITY','Ship From City: ');
define('SHIPPING_TEXT_SHIP_TO_CITY','Ship To City: ');
define('SHIPPING_RESIDENTIAL_ADDRESS','Residential Address');
define('SHIPPING_TEXT_SHIP_FROM_STATE','Ship From State: ');
define('SHIPPING_TEXT_SHIP_TO_STATE','Ship To State: ');
define('SHIPPING_TEXT_SHIP_FROM_ZIP','Ship From Postal Code: ');
define('SHIPPING_TEXT_SHIP_TO_ZIP','Ship To Postal Code: ');
define('SHIPPING_TEXT_SHIP_FROM_COUNTRY','Ship From Country: ');
define('SHIPPING_TEXT_SHIP_TO_COUNTRY','Ship To Country: ');
define('SHIPPING_TEXT_PACKAGE_INFORMATION','Package Information');
define('SHIPPING_TEXT_PACKAGE_TYPE','Type of Packaging ');
define('SHIPPING_TEXT_PICKUP_SERVICE','Pickup Service ');
define('SHIPPING_TEXT_DIMENSIONS','Dimensions: ');
define('SHIPPING_ADDITIONAL_HANDLING','Additional Handling Applies (Oversize)');
define('SHIPPING_INSURANCE_AMOUNT','Insurance: Amount ');
define('SHIPPING_SPLIT_LARGE_SHIPMENTS','Split large shipments for small pkg carrier ');
define('SHIPPING_TEXT_PER_BOX',' per box');
define('SHIPPING_TEXT_DELIVERY_CONFIRM','Delivery Confirmation ');
define('SHIPPING_SPECIAL_OPTIONS','Special Options');
define('SHIPPING_SERVICE_TYPE','Service Type');
define('SHIPPING_HANDLING_CHARGE','Handling Charge: Amount ');
define('SHIPPING_COD_AMOUNT','COD: Collect ');
define('SHIPPING_SATURDAY_PICKUP','Saturday Pickup');
define('SHIPPING_SATURDAY_DELIVERY','Saturday Delivery');
define('SHIPPING_HAZARDOUS_MATERIALS','Hazardous Material');
define('SHIPPING_TEXT_DRY_ICE','Dry Ice');
define('SHIPPING_TEXT_RETURN_SERVICES','Return Services ');
define('SHIPPING_TEXT_METHODS','Shipping Methods');
define('SHIPPING_TOTAL_WEIGHT','Total Shipment Weight');
define('SHIPPING_TOTAL_VALUE','Total Shipment Value');
define('SHIPPING_EMAIL_SENDER','E-mail Sender');
define('SHIPPING_EMAIL_RECIPIENT','E-mail Recipient');
define('SHIPPING_EMAIL_SENDER_ADD','Sender E-mail Address');
define('SHIPPING_EMAIL_RECIPIENT_ADD','Recipient E-mail Address');
define('SHIPPING_TEXT_EXCEPTION','Exception');
define('SHIPPING_TEXT_DELIVER','Deliver');
define('SHIPPING_PRINT_LABEL','Print Label');
define('SHIPPING_BILL_CHARGES_TO','Bill charges to');
define('SHIPPING_THIRD_PARTY','Recpt/Third Party Acct #');
define('SHIPPING_THIRD_PARTY_ZIP','Third Party Postal Code');
define('SHIPPING_LTL_FREIGHT_CLASS','LTL Freight Class');
define('SHIPPING_DEFAULT_LTL_CLASS','125');
define('SHIPPNIG_SUMMARY','Shipment Summary');
define('SHIPPING_SHIPMENT_DETAILS','Shipment Details');
define('SHIPPING_PACKAGE_DETAILS','Package Details');
define('SHIPPING_VOID_SHIPMENT','Void Shipment');

define('SHIPPING_TEXT_CARRIER','Carrier');
define('SHIPPING_TEXT_SERVICE','Service');
define('SHIPPING_TEXT_FREIGHT_QUOTE','Freight Quote');
define('SHIPPING_TEXT_BOOK_PRICE','Book Price');
define('SHIPPING_TEXT_COST','Cost');
define('SHIPPING_TEXT_NOTES','Notes');
define('SHIPPING_TEXT_PRINT_LABEL','Print Label');
define('SHIPPING_TEXT_CLOSE_DAY','Daily Close');
define('SHIPPING_TEXT_DELETE_LABEL','Delete Shipment');
define('SHIPPING_TEXT_SHIPMENT_ID','Shipment ID');
define('SHIPPING_TEXT_REFERENCE_ID','Reference ID');
define('SHIPPING_TEXT_TRACKING_NUM','Tracking Number');
define('SHIPPING_TEXT_EXPECTED_DATE','Expected Delivery Date');
define('SHIPPING_TEXT_ACTUAL_DATE','Actual Delivery Date');
define('SHIPPING_TEXT_DOWNLOAD','Download Thermal Label');
define('SHIPPING_THERMAL_INST','<br />The file is pre-formatted for thermal label printers. To print the label:<br /><br />
		1. Click the Download button to start the download.<br />
		2. Click on \'Save\' on the confirmation popup to save the file to you local machine.<br />
		3. Copy the file directly to the printer port. (the file must be copied in raw format)');
define('SHIPPING_TEXT_NO_LABEL','No Label Found!');

define('SHIPPING_ERROR_WEIGHT_ZERO','Shipment weight cannot be zero.');
define('SHIPPING_DELETE_CONFIRM', 'Are you sure you want to delete this package?');
define('SHIPPING_NO_SHIPMENTS', 'There are no shipments from this carrier today!');
define('SHIPPING_ERROR_CONFIGURATION', '<strong>Shipping Configuration errors!</strong>');
define('SHIPPING_UPS_CURL_ERROR','cURL Error: ');
define('SHIPPING_UPS_PACKAGE_ERROR','Died having trouble splitting the shipment into pieces. The shipment weight was: ');
define('SHIPPING_UPS_ERROR_WEIGHT_150','Single shipment weight cannot be greater than 150 lbs to use the UPS module.');
define('SHIPPING_UPS_ERROR_POSTAL_CODE','Postal Code is required to use the UPS module');
define('SHIPPING_FEDEX_ERROR_POSTAL_CODE','Postal Code is required to use the FedEx module');
define('SHIPPING_FEDEX_NO_PACKAGES','There were no packages to ship, either the total quantity or weight was zero.');
define('SHIPPING_FEDEX_DELETE_ERROR','Error - Cannot delete the shipment, not enough information provided.');
define('SHIPPING_FEDEX_CANNOT_DELETE','Error - Cannot delete a shipment whose label was generated prior to today.');
define('SHIPPING_FEDEX_LABEL_DELETED','FedEx Label - Deleted');
define('SHIPPING_FEDEX_END_OF_DAY','FedEx - End of Day Close');
define('SHIPPING_USPS_ERROR_STATUS', '<strong>Warning:</strong> USPS shipping module is either missing the username, or it is set to TEST rather than PRODUCTION and will not work.<br />If you cannot retrieve USPS Shipping Quotes, contact USPS to activate your Web Tools account on their production server. 1-800-344-7779 or icustomercare@usps.com');

// Audit log messages
define('SHIPPING_LOG_FEDEX_LABEL_PRINTED','Label Generated');

// shipping options
define('SHIPPING_1DEAM','1 Day Early a.m.');
define('SHIPPING_1DAM','1 Day a.m.');
define('SHIPPING_1DPM','1 Day p.m.');
define('SHIPPING_1DFRT','1 Day Freight');
define('SHIPPING_2DAM','2 Day a.m.');
define('SHIPPING_2DPM','2 Day p.m.');
define('SHIPPING_2DFRT','2 Day Freight');
define('SHIPPING_3DPM','3 Day');
define('SHIPPING_3DFRT','3 Day Freight');
define('SHIPPING_GND','Ground');
define('SHIPPING_GDR','Ground Residential');
define('SHIPPING_GNDFRT','Ground LTL Freight');
define('SHIPPING_I2DEAM','Worldwide Early Express');
define('SHIPPING_I2DAM','Worldwide Express');
define('SHIPPING_I3D','Worldwide Expedited');
define('SHIPPING_IGND','Ground (Canada)');

define('SHIPPING_DAILY','Daily Pickup');
define('SHIPPING_CARRIER','Carrier Customer Counter');
define('SHIPPING_ONE_TIME','Request/One Time Pickup');
define('SHIPPING_ON_CALL','On Call Air');
define('SHIPPING_RETAIL','Suggested Retail Rates');
define('SHIPPING_DROP_BOX','Drop Box/Center');
define('SHIPPING_AIR_SRV','Air Service Center');

define('SHIPPING_TEXT_LBS','lbs');
define('SHIPPING_TEXT_KGS','kgs');

define('SHIPPING_TEXT_IN','in');
define('SHIPPING_TEXT_CM','cm');

define('SHIPPING_ENVENLOPE','Envelope/Letter');
define('SHIPPING_CUST_SUPP','Customer Supplied');
define('SHIPPING_TUBE','Carrier Tube');
define('SHIPPING_PAK','Carrier Pak');
define('SHIPPING_BOX','Carrier  Box');
define('SHIPPING_25KG','25kg Box');
define('SHIPPING_10KG','10kg Box');

define('SHIPPING_CASH','Cash');
define('SHIPPING_CHECK','Check');
define('SHIPPING_CASHIERS','Cashier\'s Check');
define('SHIPPING_MO','Money Order');
define('SHIPPING_ANY','Any');

define('SHIPPING_NO_CONF','No delivery confirmation');
define('SHIPPING_NO_SIG_RQD','No Signature Required');
define('SHIPPING_SIG_REQ','Signature Required');
define('SHIPPING_ADULT_SIG','Adult Signature Required');

define('SHIPPING_RET_CARRIER','Carrier Return Label');
define('SHIPPING_RET_LOCAL','Print Local Return Label');
define('SHIPPING_RET_MAILS','Carrier Prints and Mails Return Label');

define('SHIPPING_SENDER','Sender');
define('SHIPPING_RECEIPIENT','Receipient');
define('SHIPPING_THIRD_PARTY','Third Party');
define('SHIPPING_COLLECT','Collect');

// Set up choices for dropdown menus for general shipping methods, not all are used for each method
$shipping_defaults = array();
// enable or disable Time in Travel information/address verification, if false postal code will be used
$shipping_defaults['TnTEnable'] = true;

$shipping_defaults['service_levels'] = array(
	'1DEam'  => SHIPPING_1DEAM,
	'1Dam'   => SHIPPING_1DAM,
	'1Dpm'   => SHIPPING_1DPM,
	'1DFrt'  => SHIPPING_1DFRT,
	'2Dam'   => SHIPPING_2DAM,
	'2Dpm'   => SHIPPING_2DPM,
	'2DFrt'  => SHIPPING_2DFRT,
	'3Dpm'   => SHIPPING_3DPM,
	'3DFrt'  => SHIPPING_3DFRT,
	'GND'    => SHIPPING_GND,
	'GDR'    => SHIPPING_GDR,
	'GndFrt' => SHIPPING_GNDFRT,
	'I2DEam' => SHIPPING_I2DEAM,
	'I2Dam'  => SHIPPING_I2DAM,
	'I3D'    => SHIPPING_I3D,
	'IGND'   => SHIPPING_IGND,
);

// Pickup Type Code - conforms to UPS standards per the XML specification
$shipping_defaults['pickup_service'] = array(
	'01' => SHIPPING_DAILY,
	'03' => SHIPPING_CARRIER,
	'06' => SHIPPING_ONE_TIME,
	'07' => SHIPPING_ON_CALL,
	'11' => SHIPPING_RETAIL,
	'19' => SHIPPING_DROP_BOX,
	'20' => SHIPPING_AIR_SRV,
);

// Weight Unit of Measure
// Value: char(3), Values "LBS" or "KGS"
$shipping_defaults['weight_unit'] = array(
	'LBS' => SHIPPING_TEXT_LBS,
	'KGS' => SHIPPING_TEXT_KGS,
);

// Package Dimensions Unit of Measure
$shipping_defaults['dimension_unit'] = array(
	'IN' => SHIPPING_TEXT_IN,
	'CM' => SHIPPING_TEXT_CM,
);
	
// Package Type
$shipping_defaults['package_type'] = array(
	'01' => SHIPPING_ENVENLOPE,
	'02' => SHIPPING_CUST_SUPP,
	'03' => SHIPPING_TUBE,
	'04' => SHIPPING_PAK,
	'21' => SHIPPING_BOX,
	'24' => SHIPPING_25KG,
	'25' => SHIPPING_10KG,
);

// COD Funds Code
$shipping_defaults['cod_funds_code'] = array(
	'0' => SHIPPING_CASH,
	'1' => SHIPPING_CHECK,
	'2' => SHIPPING_CASHIERS,
	'3' => SHIPPING_MO,
	'4' => SHIPPING_ANY,
);

// Delivery Confirmation
// Package delivery confirmation only allowed for shipments with US origin/destination combination.
$shipping_defaults['delivery_confirmation'] = array(
//	'0' => SHIPPING_NO_CONF,
	'1' => SHIPPING_NO_SIG_RQD,
	'2' => SHIPPING_SIG_REQ,
	'3' => SHIPPING_ADULT_SIG,
);

// Return label services
$shipping_defaults['return_label'] = array(
	'0' => SHIPPING_RET_CARRIER,
	'1' => SHIPPING_RET_LOCAL,
	'2' => SHIPPING_RET_MAILS,
);

// Billing options
$shipping_defaults['bill_options'] = array(
	'0' => SHIPPING_SENDER,
	'1' => SHIPPING_RECEIPIENT,
	'2' => SHIPPING_THIRD_PARTY,
	'3' => SHIPPING_COLLECT,
);

$ltl_classes = array('0' => TEXT_SELECT, '050' => '50', '055' => '55', '060' => '60', '065' => '65', '070' => '70', 
	'077' => '77.5', '085' => '85', '092' => '92.5', '100' => '100', '110' => '110', '125' => '125',
	'150' => '150', '175' => '175', '200' => '200', '250' => '250', '300' => '300');

?>