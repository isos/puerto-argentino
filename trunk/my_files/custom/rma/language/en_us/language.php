<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2009 PhreeSoft, LLC                               |
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
//  Path: /modules/rma/language/en_us/language.php
//

// Headings 
define('BOX_RMA_MAINTAIN','Return Material Authorizations');
define('MENU_HEADING_RMA','RMA Details');
define('MENU_HEADING_NEW_RMA','Create New RMA');

// General Defines
define('TEXT_RMAS','RMAs');
define('TEXT_RMA_ID','RMA Num');
define('TEXT_ASSIGNED_BY_SYSTEM',' (Assigned by System)');
define('TEXT_CREATION_DATE','Created');
define('TEXT_CLOSED_DATE','Closed');
define('TEXT_PURCHASE_INVOICE_ID','Sales/Invoice #');
define('TEXT_CREATION_DATE','Creation Date');
define('TEXT_CLOSED_DATE','Closed Date');
define('TEXT_CALLER_NAME','Caller Name');
define('TEXT_CALLER_TELEPHONE1','Telephone');
define('TEXT_CALLER_EMAIL','Email');
define('TEXT_CALLER_NOTES','Caller Notes');
define('TEXT_DETAILS','Details');
define('TEXT_REASON_FOR_RETURN','Reason for Return');
define('TEXT_ENTERED_BY','Entered By');
define('TEXT_RECEIVE_DATE','Date Received');
define('TEXT_RECEIVED_BY','Received By');
define('TEXT_RECEIVE_CARRIER','Shipment Carrier');
define('TEXT_RECEIVE_TRACKING_NUM','Shipment Tracking #');
define('TEXT_RECEIVE_NOTES','Receiving Notes');

//************ RMA admin defines *************/
define('MODULE_RMA_GEN_INFO','RMA Module Administration tools. Please select an action below.');
define('MODULE_RMA_INSTALL_INFO','Install Return Material Authorization Module');
define('MODULE_RMA_REMOVE_INFO','Remove Return Material Authorization Module');
define('MODULE_RMA_REMOVE_CONFIRM','Are you sure you want to remove the RMA Module?');
define('MODULE_RMA_SAVE_FILES','Also remove files from my_files directory');
define('RMAS_ERROR_DELETE_MSG','The database files have been deleted. To completely remove the module, remove all files in the directory /my_files/custom/rma and the configuration file /my_files/custom/extra_menus/rma.php');

// Error Messages
define('RMA_ERROR_INSTALL_MSG','There was an error during installation!');

// Javascrpt defines
define('RMA_MSG_DELETE_RMA','Are you sure you want to delete this RMA?');
define('RMA_ROW_DELETE_ALERT','Are you sure you want to delete this item row?');

// audit log messages
define('RMA_LOG_USER_ADD','RMA Created - RMA # ');
define('RMA_LOG_USER_UPDATE','RMA Updated - RMA # ');
define('RMA_MESSAGE_SUCCESS_ADD','Successfully created RMA # ');
define('RMA_MESSAGE_SUCCESS_UPDATE','Successfully updated RMA # ');
define('RMA_MESSAGE_ERROR','There was an error creating/updating the RMA.');
define('RMA_MESSAGE_DELETE','The RMA was successfully deleted.');
define('RMA_ERROR_CANNOT_DELETE','There was an error deleting the RMA.');

//  codes for status and RMA reason
$status_codes = array(
  '0'  => 'Select Status ...', // do not remove from top position
  '1'  => 'RMA Created/Waiting for Parts',
  '2'  => 'Parts Received',
  '3'  => 'In Inspecion',
  '4'  => 'In Disposition',
  '5'  => 'In Test',
  '6'  => 'Waiting for Credit',
  '7'  => 'Closed - Replaced',
//'8'  => 'Code Available',
  '90' => 'Closed - Not Received',
  '99' => 'Closed',
);

$reason_codes = array(
  '0'  => 'Select Reason for RMA ...', // do not remove from top position
  '1'  => 'Did Not Need',
  '2'  => 'Ordered Wrong Part',
  '3'  => 'Did Not fit',
  '4'  => 'Defective/Swap out',
  '5'  => 'Damaged in Shipping',
//'6'  => 'Code Available',
//'7'  => 'Code Available',
  '80' => 'Wrong Connector',
  '99' => 'Other (Specify in Notes)',
);

$action_codes = array(
  '0'  => 'Select Action ...', // do not remove from top position
  '1'  => 'Return to Stock',
  '2'  => 'Return to Customer',
  '3'  => 'Test & Replace',
  '4'  => 'Warranty Replace',
  '5'  => 'Scrap',
//'6'  => 'Code Available',
//'7'  => 'Code Available',
  '99' => 'Other (Specify in Notes)',
);

?>