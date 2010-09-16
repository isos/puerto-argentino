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
//  Path: /modules/oscommerce/language/en_us/language.php
//

// Headings 
define('MODULE_OSCOMMERCE_INSTALL_HEADING','Installation Status');
define('MODULE_OSCOMMERCE_CONFIG_HEADING','Interface Configuration');

// General Defines
define('OSCOMMERCE_CONFIRM_MESSAGE','Your order shipped %s via %s %s, tracking number: %s');
define('OSCOMMERCE_BULK_UPLOAD_SUCCESS','Successfully uploaded %s item(s) to the osCommerce e-store.');
define('OSCOMMERCE_ADMIN_URL','osCommerce path to Admin (no trailing slash)');
define('OSCOMMERCE_ADMIN_USERNAME','osCommerce admin username (can be unique to PhreeBooks Interface');
define('OSCOMMERCE_ADMIN_PASSWORD','osCommerce admin password (can be unique to PhreeBooks Interface)');
define('OSCOMMERCE_TAX_CLASS','Enter the osCommerce Tax Class Text field (Must match exactly to the entry in osCommerce if tax is charged)');
define('OSCOMMERCE_USE_PRICES','Do you want to use price sheets?');
define('OSCOMMERCE_TEXT_PRICE_SHEET','osCommerce Price Sheet to use');
define('OSCOMMERCE_TEXT_ERROR','Error # ');
define('OSCOMMERCE_SHIP_ID','osCommerce numeric status code for Shipped Orders');
define('OSCOMMERCE_PARTIAL_ID','osCommerce numeric status code for Partially Shipped Orders');
define('OSCOMMERCE_IVENTORY_UPLOAD','osCommerce Upload');
define('OSCOMMERCE_BULK_UPLOAD_TITLE','Bulk Upload');
define('OSCOMMERCE_BULK_UPLOAD_INFO','Bulk upload all products selected to be displayed in the osCommerce e-commerce site. Images are not included unless the checkbox is checked.');
define('OSCOMMERCE_BULK_UPLOAD_TEXT','Bulk upload products to e-store');
define('OSCOMMERCE_INCLUDE_IMAGES','Include Images');
define('OSCOMMERCE_BULK_UPLOAD_BTN','Bulk Upload');
define('OSCOMMERCE_PRODUCT_SYNC_TITLE','Synchronize Products');
define('OSCOMMERCE_PRODUCT_SYNC_INFO','Synchronize active products from the PhreeBooks database (set to show in the catalog and active) with current listings from osCommerce. Any SKUs that should not be listed on osCommerce are displayed. They need to be removed from osCommerce manually through the osCommerce admin interface.');
define('OSCOMMERCE_PRODUCT_SYNC_TEXT','Synchronize products with e-store');
define('OSCOMMERCE_PRODUCT_SYNC_BTN','Synchronize');
define('OSCOMMERCE_SHIP_CONFIRM_TITLE','Confirm Shipments');
define('OSCOMMERCE_SHIP_CONFIRM_INFO','Confirms all shipments on the date selected from the Shipping Manager and sets the status in osCommerce. Completed orders and partially shipped orders are updated. Email notifications to the customer are not sent.');
define('OSCOMMERCE_SHIP_CONFIRM_TEXT','Send shipment confirmations');
define('OSCOMMERCE_TEXT_CONFIRM_ON','For orders shipped on');
define('OSCOMMERCE_SHIP_CONFIRM_BTN','Confirm Shipments');

// osCommerce admin defines
define('MODULE_OSCOMMERCE_CONFIG_INFO','Please set the configuration values to your osCommerce e-store.');

// Error Messages
define('OSCOMMERCE_MOD_NOT_INSTALLED','The osCommerce Module is not set up! You have been redirected to the osCommerce Module Admin tool to set the configuration parameters.');
define('OSCOMMERCE_MOD_NOT_SETUP','The osCommerce module has not been configured!');
define('OSCOMMERCE_ERROR_NO_ITEMS','No inventory items were selected to upload to the osCommerce catalog. Looking for the checkbox field named catalog to identify items to be uploaded.');
define('OSCOMMERCE_ERROR_CONFRIM_NO_DATA','No records were found for this date to confirm with osCommerce.');
define('OSCOMMERCE_ERROR_NO_PRICE_SHEET','Couldn\'t find a default price level for price sheet: ');
define('OSCOMMERCE_CANNOT_WRITE_CONFIG','Cannot open file (%s) for writing the configuration information. Check your permissions.');
define('OSCOMMERCE_INVALID_ACTION','Invalid action requested in osCommerce interface class. Aborting!');
define('OSCOMMERCE_INVALID_SKU','Error in inventory item id, could not find the record in the database');

// Javascrpt Defines

// Audit Log Messages
define('OSCOMMERCE_UPLOAD_PRODUCT','osCommerce Product Upload');
define('OSCOMMERCE_BULK_UPLOAD','osCommerce Bulk Upload');
define('OSCOMMERCE_PRODUCT_SYNC','osCommerce Product Sync');
define('OSCOMMERCE_SHIP_CONFIRM','osCommerce Ship Confirmation');

?>