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
//  Path: /modules/inventory/language/en_us/language.php
//

/********************* Release R2.0 additions *************************/
define('INV_TOOLS_STOCK_ROUNDING_ERROR','SKU: %s -> Stock indicates %s on hand but is less than your precision. Please repair your inventory balances, the stock on hand will be rounded to %s.');
define('INV_TOOLS_BALANCE_CORRECTED','SKU: %s -> The inventory stock on hand has been changed to %s.');

/********************* Release R2.0 additions *************************/
define('INV_TYPES_SA','Serialized Assembly');

/********************* Release R1.9 additions *************************/
define('INV_TYPES_SI','Stock Item');
define('INV_TYPES_SR','Serialized Item');
define('INV_TYPES_MS','Master Stock Item');
define('INV_TYPES_AS','Item Assembly');
define('INV_TYPES_NS','Non-stock Item');
define('INV_TYPES_LB','Labor');
define('INV_TYPES_SV','Service');
define('INV_TYPES_SF','Flat Rate - Service');
define('INV_TYPES_CI','Charge Item');
define('INV_TYPES_AI','Activity Item');
define('INV_TYPES_DS','Description');
define('INV_TYPES_IA','Item Assembly Part');
define('INV_TYPES_MI','Master Stock Sub Item');
define('INV_TEXT_FIFO','FIFO');
define('INV_TEXT_LIFO','LIFO');
define('INV_TEXT_AVERAGE','Average');
define('INV_TEXT_GREATER_THAN','Larger than');
define('TEXT_CHECKED','Checked');
define('TEXT_UNCHECKED','Unchecked');
define('TEXT_SGL_PREC','Single Precision');
define('TEXT_DBL_PREC','Double Precision');
define('TEXT_NOT_USED','Not Used');
define('TEXT_DIR_ENTRY','Direct Entry');
define('TEXT_ITEM_COST','Item Cost');
define('TEXT_RETAIL_PRICE','Retail Price');
define('TEXT_PRICE_LVL_1','Price Level 1');	
define('TEXT_DEC_AMT','Decrease by Amount');
define('TEXT_DEC_PCNT','Decrease by Percent');
define('TEXT_INC_AMT','Increase by Amount');
define('TEXT_INC_PCNT','Increase by Percent');
define('TEXT_NEXT_WHOLE','Next Dollar');
define('TEXT_NEXT_FRACTION','Constant Cents');
define('TEXT_NEXT_INCREMENT','Next Increment');
define('INV_XFER_SUCCESS','Successfully transfered %s pieces of sku %s');
define('TEXT_INV_MANAGED','Controlled Stock');
define('TEXT_FILTERS','Filters:');
define('TEXT_SHOW_INACTIVE','Show Inactive');
define('TEXT_APPLY','Apply');
define('AJAX_INV_NO_INFO','Not enough information was passed to retrieve the item details');

/********************* Release R1.8 additions *************************/
define('INV_TOOLS_VALIDATE_SO_PO','Validate Inventory Quantity on Order Values');
define('INV_TOOLS_VALIDATE_SO_PO_DESC','This operation tests to make sure your inventory quantity on Purchase Order and quantity of Sales Order match with the journal entries. The calculated values from the journal entries override the value in the inventory table.');
define('INV_TOOLS_REPAIR_SO_PO','Test and Repair Inventory Quantity on Order Values');
define('INV_TOOLS_BTN_SO_PO_FIX','Begin Test and Repair');
define('INV_TOOLS_PO_ERROR','SKU: %s had a quantity on Purchase Order of %s and should be %s. The inventory table balance was fixed.');
define('INV_TOOLS_SO_ERROR','SKU: %s had a quantity on Sales Order of %s and should be %s. The inventory table balance was fixed.');
define('INV_TOOLS_SO_PO_RESULT','Finished processing Inventory order quantities. The total number of items processed was %s. The number of records with errors was %s.');
define('INV_TOOLS_AUTDIT_LOG_SO_PO','Inv Tools - Repair SO/PO Qty (%s)');
define('INV_ENTRY_PURCH_TAX','Default Purchase Tax');
define('INV_ENTRY_ITEM_TAXABLE', 'Default Sales Tax');
define('TEXT_LAST_MONTH','Last Month');
define('TEXT_LAST_3_MONTH','3 Months');
define('TEXT_LAST_6_MONTH','6 Months');
define('TEXT_LAST_12_MONTH','12 Months');

/********************* Release R1.7 additions *************************/
define('TEXT_WHERE_USED','Where Used');
define('TEXT_CURRENT_COST','Current Assembly Cost');
define('JS_INV_TEXT_ASSY_COST','The current price to assemble this SKU is: ');
define('JS_INV_TEXT_USAGE','This SKU is used in the following assemblies: ');
define('JS_INV_TEXT_USAGE_NONE','This SKU is not used in any assemblies.');
define('INV_HEADING_UPC_CODE','UPC Code');
define('INV_SKU_ACTIVITY','SKU Activity');
define('INV_ENTRY_INVENTORY_DESC_SALES','Sales Description');
define('INV_ERROR_DELETE_HISTORY_EXISTS','Cannot delete this inventory item since there is a record in the inventory_history table.');
define('INV_ERROR_DELETE_ASSEMBLY_PART','Cannot delete this inventory item since it is part of an assembly.');

define('INV_TOOLS_VALIDATE_INVENTORY','Validate Inventory Displayed Stock');
define('INV_TOOLS_VALIDATE_INV_DESC','This operation tests to make sure your inventory quantities listed in the inventory database and displayed in the inventory screens are the same as the quantities in the inventory history database as calculated by PhreeBooks when inventory movements occur. The only items tested are the ones that are tracked in the cost of goods sold calculation. Repairing inventory balances will correct the quantity in stock and leave the inventory history data alone. ');
define('INV_TOOLS_REPAIR_TEST','Test Inventory Balances with COGS History');
define('INV_TOOLS_REPAIR_FIX','Repair Inventory Balances with COGS History');
define('INV_TOOLS_REPAIR_CONFIRM','Are you sure you want to repair the inventory stock on hand to match the PhreeBooks COGS history calculated values?');
define('INV_TOOLS_BTN_TEST','Verify Stock Balances');
define('INV_TOOLS_BTN_REPAIR','Sync Qty in Stock');
define('INV_TOOLS_OUT_OF_BALANCE','SKU: %s -> stock indicates %s on hand but COGS history list %s available');
define('INV_TOOLS_IN_BALANCE','Your inventory balances are OK.');

/********************* Release R1.6 and earlier additions *************************/
define('INV_ASSY_HEADING_TITLE', 'Assemble/Disassemble Inventory');
define('TEXT_INVENTORY_REVALUATION', 'Inventory Re-valuation');
define('INV_FIELD_HEADING_TITLE', 'Inventory Fields Manager');
define('INV_POPUP_WINDOW_TITLE', 'Inventory Items');
define('INV_POPUP_PRICE_MGR_WINDOW_TITLE','Inventory Price Manager');
define('INV_POPUP_ADJ_WINDOW_TITLE','Inventory Adjustments');
define('INV_ADJUSTMENT_ACCOUNT','Adjustment Account');
define('INV_POPUP_PRICES_WINDOW_TITLE','SKU Price List');
define('INV_BULK_SKU_ENTRY_TITLE','Bulk SKU Pricing Entry');
define('INV_POPUP_XFER_WINDOW_TITLE','Transfer Inventory Between Stores');

define('INV_HEADING_QTY_ON_HAND', 'Qty on Hand');
define('INV_QTY_ON_HAND', 'Quantity on Hand');
define('INV_HEADING_SERIAL_NUMBER', 'Serial Number');
define('INV_HEADING_QTY_TO_ASSY', 'Qty to Assemble');
define('INV_HEADING_QTY_ON_ORDER', 'Qty on Order');
define('INV_HEADING_QTY_IN_STOCK', 'Qty in Stock');
define('TEXT_QTY_THIS_STORE','Qty this Branch');
define('INV_HEADING_QTY_ON_SO', 'Qty on Sales Order');
define('INV_QTY_ON_SALES_ORDER', 'Quantity on Sales Order');
define('INV_HEADING_PREFERRED_VENDOR', 'Preferred Vendor');
define('INV_HEADING_LEAD_TIME', 'Lead Time (days)');
define('INV_QTY_ON_ORDER', 'Quantity on Purchase Order');
define('INV_ASSY_PARTS_REQUIRED','Components required for this assembly');
define('INV_TEXT_REMAINING','Qty Remaining');
define('INV_TEXT_UNIT_COST','Unit Cost');
define('INV_TEXT_CURRENT_VALUE','Current Value');
define('INV_TEXT_NEW_VALUE','New Value');

define('INV_ADJ_QUANTITY','Adjustment Quantity');
define('INV_REASON_FOR_ADJUSTMENT','Reason for Adjustment');
define('INV_ADJ_VALUE', 'Adj. Value');
define('INV_ROUNDING', 'Rounding');
define('INV_RND_VALUE', 'Rnd. Value');
define('INV_BOM','Bill of Materials');
define('INV_ADJ_DELETE_ALERT', 'Are you sure you want to delete this Inventory Adjustment?');
define('INV_MSG_DELETE_INV_ITEM', 'Are you sure you want to delete this inventory item?');

define('INV_XFER_FROM_STORE','Transfer From Store ID');
define('INV_XFER_TO_STORE','To Store ID');
define('INV_XFER_QTY','Transfer Quantity');
define('INV_XFER_ERROR_NO_COGS_REQD','This inventory item is not tracked in the cost of goods sold. Therefore, the transfer of this item between stores does not require it to be posted!');
define('INV_XFER_ERROR_QTY_ZERO','This inventory item quantity cannot be less than zero! Re-enter the transfer the other direction with a positive quantity.');
define('INV_XFER_ERROR_SAME_STORE_ID','The source and destination store ID\'s are the same, the transfer was not performed!');
define('INV_XFER_ERROR_NOT_ENOUGH_SKU','Cannot transfer inventory, not enough available in stock to transfer!');

define('INV_HEADING_NEW_ITEM', 'New Inventory Item'); 
define('INV_HEADING_FIELD_INFO', 'Inventory Field Information');
define('INV_HEADING_FIELD_PROPERTIES', 'Field Type and Properties (Select One)');
define('INV_ENTER_SKU','Enter the SKU, item type and cost method then press Continue<br />Maximum SKU length is ' . MAX_INVENTORY_SKU_LENGTH . ' characters (' . (MAX_INVENTORY_SKU_LENGTH - 5) . ' for Master Stock)');
define('INV_MS_ATTRIBUTES','Master Stock Attributes');
define('INV_TEXT_ATTRIBUTE_1','Attribute 1');
define('INV_TEXT_ATTRIBUTE_2','Attribute 2');
define('INV_TEXT_ATTRIBUTES','Attributes');
define('INV_MS_CREATED_SKUS','The followng SKUs will be created');

define('INV_ENTRY_INVENTORY_TYPE', 'Inventory Type');
define('INV_ENTRY_INVENTORY_DESC_SHORT', 'Short Description');
define('INV_ENTRY_INVENTORY_DESC_PURCHASE', 'Purchase Description');
define('INV_ENTRY_IMAGE_PATH','Relative Image Path');
define('INV_ENTRY_SELECT_IMAGE','Select Image');
define('INV_ENTRY_ACCT_SALES', 'Sales/Income Account');
define('INV_ENTRY_ACCT_INV', 'Inventory/Wage Account');
define('INV_ENTRY_ACCT_COS', 'Cost of Sales Account');
define('INV_ENTRY_INV_ITEM_COST','Item Cost');
define('INV_ENTRY_FULL_PRICE', 'Full Price');
define('INV_ENTRY_ITEM_WEIGHT', 'Item Weight');
define('INV_ENTRY_ITEM_MINIMUM_STOCK', 'Minimum Stock Level');
define('INV_ENTRY_ITEM_REORDER_QUANTITY', 'Reorder Quantity');
define('INV_ENTRY_INVENTORY_COST_METHOD', 'Cost Method');
define('INV_ENTRY_INVENTORY_SERIALIZE', 'Serialize Item');
define('INV_MASTER_STOCK_ATTRIB_ID','ID (Max 2 Chars)');

define('INV_DATE_ACCOUNT_CREATION', 'Creation date');
define('INV_DATE_LAST_UPDATE', 'Last Update');
define('INV_DATE_LAST_JOURNAL_DATE', 'Last Entry Date');

// Inventory History
define('INV_SKU_HISTORY','SKU History');
define('INV_OPEN_PO','Open Purchase Orders');
define('INV_OPEN_SO','Open Sales Orders');
define('INV_PURCH_BY_MONTH','Purchases By Month');
define('INV_SALES_BY_MONTH','Sales By Month');
define('INV_AVG_USAGE','Average Usage (not including this month)');

define('INV_NO_RESULTS','No Results Found');
define('INV_PO_NUMBER','PO Number');
define('INV_SO_NUMBER','SO Number');
define('INV_PO_DATE','PO Date');
define('INV_SO_DATE','SO Date');
define('INV_PO_RCV_DATE','Receive Date');
define('INV_SO_SHIP_DATE','Ship Date');
define('INV_PURCH_COST','Purchase Cost');
define('INV_SALES_INCOME','Sales Income');
define('TEXT_MONTH','This Month');

define('INV_MSG_COPY_INTRO', 'Please enter a new SKU ID to copy to:');
define('INV_MSG_RENAME_INTRO', 'Please enter a new SKU ID to rename this SKU to:');
define('INV_ERROR_DUPLICATE_SKU','The new inventory item cannot be created because the sku is already in use.');
define('INV_ERROR_CANNOT_DELETE','The inventory item cannot be deleted because there are journal entries in the system matching the sku');
define('INV_ERROR_BAD_SKU','There was an error with the item assembly list, please validate sku values and check quantities. Failing sku was: ');
define('INV_ERROR_SKU_INVALID','SKU is invalid. Please check the sku value and inventory account for errors.');
define('INV_ERROR_SKU_BLANK','The SKU field was left blank. Please enter a sku value and retry.');
define('INV_ERROR_FIELD_BLANK','The field name was left blank. Please enter a field name and retry.');
define('INV_ERROR_FIELD_DUPLICATE','The field you entered is a duplicate, please change the field name and re-submit.');
define('INV_ERROR_NEGATIVE_BALANCE','Error unbuilding inventory, not enough stock on hand to unbuild the requested quantity!');
define('TEXT_DISPLAY_NUMBER_OF_ITEMS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> items)');
define('TEXT_DISPLAY_NUMBER_OF_FIELDS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> fields)');
define('INV_CATEGORY_MEMBER', 'Category Member:');
define('INV_FIELD_NAME', 'Field Name: ');
define('INV_DESCRIPTION', 'Description: ');
define('TEXT_USE_DEFAULT_PRICE_SHEET','Use Default Price Sheet Settings');
define('INV_ERROR_ASSY_CANNOT_DELETE','Cannot delete assembly. It has been used by another journal entry!');
define('INV_POST_SUCCESS','Succesfully Posted Inventory Adjustment Ref # ');
define('INV_POST_ASSEMBLY_SUCCESS','Successfully assembled SKU: ');
define('INV_NO_PRICE_SHEETS','No price sheets have been defined!');
define('INV_DEFINED_PRICES','Defined Prices for SKU: ');

define('INV_LABEL_DEFAULT_TEXT_VALUE', 'Default Value: ');
define('INV_LABEL_MAX_NUM_CHARS', 'Maximum Number of Characters (Length)');
define('INV_LABEL_FIXED_255_CHARS', 'Fixed at 255 Characters Maximum');
define('INV_LABEL_MAX_255', '(for lengths less than 256 Characters)');
define('INV_LABEL_CHOICES', 'Enter Selection String');
define('INV_LABEL_TEXT_FIELD', 'Text Field');
define('INV_LABEL_HTML_TEXT_FIELD', 'HTML Code');
define('INV_LABEL_HYPERLINK', 'Hyper-Link');
define('INV_LABEL_IMAGE_LINK', 'Image File Name');
define('INV_LABEL_INVENTORY_LINK', 'Inventory Link (Link pointing to another inventory item (URL))');
define('INV_LABEL_INTEGER_FIELD', 'Integer Number');
define('INV_LABEL_INTEGER_RANGE', 'Integer Range');
define('INV_LABEL_DECIMAL_FIELD', 'Decimal Number');
define('INV_LABEL_DECIMAL_RANGE', 'Decimal Range');
define('INV_LABEL_DEFAULT_DISPLAY_VALUE', 'Display Format (Max,Decimal)');
define('INV_LABEL_DROP_DOWN_FIELD', 'Dropdown List');
define('INV_LABEL_RADIO_FIELD', 'Radio Button Selection<br />Enter choices, separated by commas as:<br />value1:desc1:def1,value2:desc2:def2<br /><u>Key:</u><br />value = The value to place into the database<br />desc = Textual description of the choice<br />def = Default 0 or 1, 1 being the default choice<br />Note: Only 1 default is allowed per list');
define('INV_LABEL_DATE_TIME_FIELD', 'Date and Time');
define('INV_LABEL_CHECK_BOX_FIELD', 'Check Box (Yes or No Choice)');
define('INV_LABEL_TIME_STAMP_FIELD', 'Time Stamp');
define('INV_LABEL_TIME_STAMP_VALUE', 'System field to track the last date and time a change to a particular inventory item was made.');

define('INV_FIELD_NAME_RULES','Fieldnames cannot contain spaces or special<br />characters and must be 64 characters or less');
define('INV_DELETE_INTRO_INV_FIELDS', 'Are you sure you want to delete this inventory field?\nALL DATA WILL BE LOST!');
define('INV_INFO_HEADING_DELETE_INVENTORY', 'Delete Inventory Field');
define('INV_CATEGORY_CANNOT_DELETE','Cannot delete category. It is being used by field: ');
define('INV_CANNOT_DELETE_SYSTEM','Fields in the System category cannot be deleted!');
define('INV_IMAGE_PATH_ERROR','Error in the path specified for the upload image!');
define('INV_IMAGE_FILE_TYPE_ERROR','Error in the uploaded image file. Not an acceptable file type.');
define('INV_IMAGE_FILE_WRITE_ERROR','There was a problem writing the image file to the specified directory.');
define('INV_FIELD_RESERVED_WORD','The field name entered is a reserved word. Please choose a new field name.');

// java script errors and messages
define('JS_SKU_BLANK', '* The new item needs a SKU or UPC Code\n');
define('JS_COGS_AUTO_CALC','Unit price will be calculated by the system.');
define('JS_NO_SKU_ENTERED','A SKU value is required.\n');
define('JS_ADJ_VALUE_ZERO','A non-zero adjustment quantity is required.\n');
define('JS_XFER_VALUE_ZERO','A positive transfer quantity is required.\n');
define('JS_ASSY_VALUE_ZERO','A non-zero assembly quantity is required.\n');
define('JS_NOT_ENOUGH_PARTS','Not enough inventory to assemble the desired quantities');
define('JS_MS_INVALID_ENTRY','Both ID and Description are required fields. Please enter both values and press OK.');
define('JS_INV_TEXT_ASSY_COST','The current price to assemble this SKU is: ');
define('JS_INV_TEXT_USAGE','This SKU is used in the following assemblies: ');
define('JS_INV_TEXT_USAGE_NONE','This SKU is not used in any assemblies.');

// audit log messages
define('INV_LOG_ADJ','Inventory Adjustment - ');
define('INV_LOG_ASSY','Inventory Assembly - ');
define('INV_LOG_FIELDS','Inventory Fields - ');
define('INV_LOG_INVENTORY','Inventory Item - ');
define('INV_LOG_PRICE_MGR','Inventory Price Manager - ');
define('INV_LOG_TRANSFER','Inv Transfer from %s to %s');

// the inventory type indexes should not be changed or the inventory module won't work.
// system generated types (not to be displayed are: ai - assembly item, mi - master stock with attributes)
$inventory_types = array(
  'si' => INV_TYPES_SI,
  'sr' => INV_TYPES_SR,
  'ms' => INV_TYPES_MS,
  'as' => INV_TYPES_AS,
  'sa' => INV_TYPES_SA,
  'ns' => INV_TYPES_NS,
  'lb' => INV_TYPES_LB,
  'sv' => INV_TYPES_SV,
  'sf' => INV_TYPES_SF,
  'ci' => INV_TYPES_CI,
  'ai' => INV_TYPES_AI,
  'ds' => INV_TYPES_DS,
);

// used for identifying inventory types in reports and forms that are not selectable by the user
$inventory_types_plus       = $inventory_types;
$inventory_types_plus['ia'] = INV_TYPES_IA;
$inventory_types_plus['mi'] = INV_TYPES_MI;

$cost_methods = array(
  'f' => INV_TEXT_FIFO,	   // First-in, First-out
  'l' => INV_TEXT_LIFO,	   // Last-in, First-out
  'a' => INV_TEXT_AVERAGE, // Average Costing
); 

$integer_lengths = array(
  '0' => '-127 ' . TEXT_TO . ' 127',
  '1' => '-32,768 ' . TEXT_TO . ' 32,768',
  '2' => '-8,388,608 ' . TEXT_TO . ' 8,388,607',
  '3' => '-2,147,483,648 ' . TEXT_TO . ' 2,147,483,647',
  '4' => INV_TEXT_GREATER_THAN . ' 2,147,483,648',
);

$decimal_lengths = array(
  '0' => TEXT_SGL_PREC,
  '1' => TEXT_DBL_PREC,
);

$check_box_choices = array(
  '0' => TEXT_UNCHECKED, 
  '1' => TEXT_CHECKED,
);

$price_mgr_sources = array(
  '0' => TEXT_NOT_USED,	// Do not remove this selection, leave as first entry
  '1' => TEXT_DIR_ENTRY,
  '2' => TEXT_ITEM_COST,
  '3' => TEXT_RETAIL_PRICE,
// Price Level 1 needs to always be at the end (it is pulled from the first row to avoid a circular reference)
// The index can change but must be matched with the javascript to update the price source values.
  '4' => TEXT_PRICE_LVL_1,
);	

$price_mgr_adjustments = array(
  '0' => TEXT_NONE,
  '1' => TEXT_DEC_AMT,
  '2' => TEXT_DEC_PCNT,
  '3' => TEXT_INC_AMT,
  '4' => TEXT_INC_PCNT,
);

$price_mgr_rounding = array(
  '0' => TEXT_NONE,
  '1' => TEXT_NEXT_WHOLE,
  '2' => TEXT_NEXT_FRACTION,
  '3' => TEXT_NEXT_INCREMENT,
);

define('INV_ACTION_OPEN',' (Acceder)');
?>