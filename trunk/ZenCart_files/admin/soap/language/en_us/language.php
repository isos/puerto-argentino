<?php
//
// * @copyright Copyright 2010 PhreeSoft LLC
//  $Id: /admin/soap/language/en_us/language.php $
//
// Set some defines to use based on zencart install
define('ZENCART_PRODUCT_TAX_CLASS_ID',2); // sets the record id for the default sales tax to use

// General defines for SOAP interface
define('SOAP_NO_USER_PW','The username and password submitted cannot be found in the XML string.');
define('SOAP_USER_NOT_FOUND','The username submitted is not valid.');
define('SOAP_PASSWORD_NOT_FOUND','The password submitted is not valid.');
define('SOAP_UNEXPECTED_ERROR','An unexpected error code was returned by the processing server.');
define('SOAP_XML_SUBMITTED_SO','XML submitted Sales Order');
define('SOAP_NO_CUSTOMER_ID','The customer ID is missing or is invalid.');
define('SOAP_NO_POST_DATE','The post date is missing or is invalid.');
define('SOAP_BAD_POST_DATE','The post date falls outside the current available fiscal years defined in PhreeBooks.');

define('SOAP_BAD_LANGUAGE_CODE','The language ISO code submitted could not be found in the Zencart languages table. Expecting to find code = ');
define('SOAP_BAD_PRODUCT_TYPE','The product type name could not be found in the Zencart product_types table. Expecting to find type_name %s for sku %s.');
define('SOAP_BAD_MANUFACTURER','The manufacturers name could not be found in the Zencart manufacturers table. Expecting to find manufacturer name %s for sku %s.');
define('SOAP_BAD_CATEGORY','The category name could not be found or is not unique in the Zencart categories_description table. Expecting to find category name %s for sku %s.');
define('SOAP_BAD_CATEGORY_A','The category name submitted is not at the lowest level in the category tree. This is a Zencart requirement!');
define('SOAP_NO_SKU','No SKU was found. A SKU must be present in the submitted XML string!');
define('SOAP_BAD_ACTION','A bad action was submitted.');
define('SOAP_OPEN_FAILED','Error opening the image file to write. Trying to write to: ');
define('SOAP_ERROR_WRITING_IMAGE','Error writing the image file to the Zencart image directory.');

define('SOAP_PU_POST_ERROR','There was an error updating the product in Zencart. Description - ');
define('SOAP_PRODUCT_UPLOAD_SUCCESS_A','Product SKU ');
define('SOAP_PRODUCT_UPLOAD_SUCCESS_B',' was uploaded successfully.');

define('SOAP_NO_ORDERS_TO_CONFIRM', 'No orders were uploaded to confirm.');
define('SOAP_CONFIRM_SUCCESS','Order Confirmation was completed successfully. The number of orders updated was: %s');

define('SOAP_NO_SKUS_UPLOADED','No skus were uploaded to syncronize.');
define('SOAP_SKUS_MISSING','The following skus are in Zencart but not flagged to be there by PhreeBooks: ');
define('SOAP_PRODUCTS_IN_SYNC','The product listings between PhreeBooks and ZenCart are in sync.');

?>