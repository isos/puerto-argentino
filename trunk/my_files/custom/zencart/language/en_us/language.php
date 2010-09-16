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
//  Path: /modules/zencart/language/en_us/language.php
//

// Headings 
define('MODULE_ZENCART_INSTALL_HEADING','Installation Status');
define('MODULE_ZENCART_CONFIG_HEADING','Interface Configuration');

// General Defines
define('ZENCART_CONFIRM_MESSAGE','Your order shipped %s via %s %s, tracking number: %s');
define('ZENCART_BULK_UPLOAD_SUCCESS','Successfully uploaded %s item(s) to the ZenCart e-store.');
define('ZENCART_ADMIN_URL','ZenCart path to Admin (no trailing slash)');
define('ZENCART_ADMIN_USERNAME','ZenCart admin username (can be unique to PhreeBooks Interface');
define('ZENCART_ADMIN_PASSWORD','ZenCart admin password (can be unique to PhreeBooks Interface)');
define('ZENCART_TAX_CLASS','Enter the ZenCart Tax Class Text field (Must match exactly to the entry in ZenCart if tax is charged)');
define('ZENCART_USE_PRICES','Do you want to use price sheets?');
define('ZENCART_TEXT_PRICE_SHEET','ZenCart Price Sheet to use');
define('ZENCART_TEXT_ERROR','Error # ');
define('ZENCART_SHIP_ID','ZenCart numeric status code for Shipped Orders');
define('ZENCART_PARTIAL_ID','ZenCart numeric status code for Partially Shipped Orders');
define('ZENCART_IVENTORY_UPLOAD','ZenCart Upload');
define('ZENCART_BULK_UPLOAD_TITLE','Bulk Upload');
define('ZENCART_BULK_UPLOAD_INFO','Bulk upload all products selected to be displayed in the ZenCart e-commerce site. Images are not included unless the checkbox is checked.');
define('ZENCART_BULK_UPLOAD_TEXT','Bulk upload products to e-store');
define('ZENCART_INCLUDE_IMAGES','Include Images');
define('ZENCART_BULK_UPLOAD_BTN','Bulk Upload');
define('ZENCART_PRODUCT_SYNC_TITLE','Synchronize Products');
define('ZENCART_PRODUCT_SYNC_INFO','Synchronize active products from the PhreeBooks database (set to show in the catalog and active) with current listings from ZenCart. Any SKUs that should not be listed on Zencart are displayed. They need to be removed from ZenCart manually through the ZenCart admin interface.');
define('ZENCART_PRODUCT_SYNC_TEXT','Synchronize products with e-store');
define('ZENCART_PRODUCT_SYNC_BTN','Synchronize');
define('ZENCART_SHIP_CONFIRM_TITLE','Confirm Shipments');
define('ZENCART_SHIP_CONFIRM_INFO','Confirms all shipments on the date selected from the Shipping Manager and sets the status in ZenCart. Completed orders and partially shipped orders are updated. Email notifications to the customer are not sent.');
define('ZENCART_SHIP_CONFIRM_TEXT','Send shipment confirmations');
define('ZENCART_TEXT_CONFIRM_ON','For orders shipped on');
define('ZENCART_SHIP_CONFIRM_BTN','Confirm Shipments');

// ZenCart admin defines
define('MODULE_ZENCART_CONFIG_INFO','Please set the configuration values to your ZenCart e-store.');

// Error Messages
define('ZENCART_MOD_NOT_INSTALLED','The ZenCart Module is not set up! You have been redirected to the ZenCart Module Admin tool to set the configuration parameters.');
define('ZENCART_MOD_NOT_SETUP','The Zencart module has not been configured!');
define('ZENCART_ERROR_NO_ITEMS','No inventory items were selected to upload to the ZenCart catalog. Looking for the checkbox field named catalog to identify items to be uploaded.');
define('ZENCART_ERROR_CONFRIM_NO_DATA','No records were found for this date to confirm with ZenCart.');
define('ZENCART_ERROR_NO_PRICE_SHEET','Couldn\'t find a default price level for price sheet: ');
define('ZENCART_CANNOT_WRITE_CONFIG','Cannot open file (%s) for writing the configuration information. Check your permissions.');
define('ZENCART_INVALID_ACTION','Invalid action requested in ZenCart interface class. Aborting!');
define('ZENCART_INVALID_SKU','Error in inventory item id, could not find the record in the database');

// Javascrpt Defines

// Audit Log Messages
define('ZENCART_UPLOAD_PRODUCT','ZenCart Product Upload');
define('ZENCART_BULK_UPLOAD','ZenCart Bulk Upload');
define('ZENCART_PRODUCT_SYNC','ZenCart Product Sync');
define('ZENCART_SHIP_CONFIRM','ZenCart Ship Confirmation');

?>