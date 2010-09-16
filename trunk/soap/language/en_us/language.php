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
//  Path: /soap/language/en_us/language.php
//

define('SOAP_NO_USER_PW','The username and password submitted cannot be found in the XML string.');
define('SOAP_USER_NOT_FOUND','The username submitted is not valid.');
define('SOAP_PASSWORD_NOT_FOUND','The password submitted is not valid.');
define('SOAP_UNEXPECTED_ERROR','An unexpected error code was returned by the processing server.');
define('SOAP_XML_SUBMITTED_SO','XML submitted Sales Order');
define('SOAP_NO_CUSTOMER_ID','The customer ID is missing or is invalid.');
define('SOAP_NO_POST_DATE','The post date is missing or is invalid.');
define('SOAP_BAD_POST_DATE','The post date falls outside the current available fiscal years defined in PhreeBooks.');

define('SOAP_NO_BILLING_PRIMARY_NAME','The customer billing primary name is required.');
define('SOAP_NO_BILLING_CONTACT','The customer billing contact is required.');
define('SOAP_NO_BILLING_ADDRESS1','The customer billing address line 1 is required.');
define('SOAP_NO_BILLING_ADDRESS2','The customer billing address line 2 is required.');
define('SOAP_NO_BILLING_CITY_TOWN','The customer billing city/town is required.');
define('SOAP_NO_BILLING_STATE_PROVINCE','The customer billing state/province is required.');
define('SOAP_NO_BILLING_POSTAL_CODE','The customer billing postal code is required.');
define('SOAP_NO_BILLING_COUNTRY_CODE','The customer billing ISO 2 character country code is required.');
define('SOAP_NO_SHIPPING_PRIMARY_NAME','The customer shipping primary name is required.');
define('SOAP_NO_SHIPPING_CONTACT','The customer shipping contact is required.');
define('SOAP_NO_SHIPPING_ADDRESS1','The customer shipping address line 1 is required.');
define('SOAP_NO_SHIPPING_ADDRESS2','The customer shipping address line 2 is required.');
define('SOAP_NO_SHIPPING_CITY_TOWN','The customer shipping city/town is required.');
define('SOAP_NO_SHIPPING_STATE_PROVINCE','The customer shipping state/province is required.');
define('SOAP_NO_SHIPPING_POSTAL_CODE','The customer shipping postal code is required.');
define('SOAP_NO_SHIPPING_COUNTRY_CODE','The customer shipping ISO 2 character country code is required.');

define('SOAP_SO_POST_ERROR','There was an error posting the sales order. Description - ');
define('SOAP_ACCOUNT_PROBLEM','Could not find main address for an existing customer. Major problem with the PhreeBooks address database.');

// particular to order type
define('AUDIT_LOG_SOAP_10_ADDED','SOAP Sales Orders - Add');
define('AUDIT_LOG_SOAP_12_ADDED','SOAP Sales/Invoice - Add');
define('SOAP_10_SUCCESS','Sales order %s was downloaded successfully.');
define('SOAP_12_SUCCESS','Sales invoice %s was downloaded successfully.');

?>