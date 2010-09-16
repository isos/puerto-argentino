<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2008 PhreeSoft, LLC                               |
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
//  Path: /modules/assets/language/en_us/language.php
//

// Headings 
define('BOX_ASSETS_MAINTAIN','Maintain Assets');
define('MENU_HEADING_ASSETS','Asset Details');

// General Defines
define('TEXT_ASSETS','assets');
define('TEXT_VEHICLE','Vehicle');
define('TEXT_BUILDING','Building');
define('TEXT_FURNITURE','Furniture');
define('TEXT_COMPUTER','Computer');
define('TEXT_LAND','Land');
define('TEXT_SOFTWARE','Software');
define('TEXT_ASSET_ID','Asset ID');
//define('','');

//************ Assets defines *********************/
define('ASSETS_HEADING_NEW_ITEM','New Asset');
define('ASSETS_ENTER_ASSET_ID','Create a New Asset');
define('ASSETS_ENTRY_ASSET_TYPE','Enter the Asset Type');
define('ASSETS_ENTRY_ASSETS_DESC_SHORT','Description Short');
define('ASSETS_ENTRY_ASSETS_TYPE','Asset Type');
define('ASSETS_ENTRY_FULL_PRICE','Original Cost');
define('ASSETS_ENTRY_ASSETS_DESC_PURCHASE','Detailed Description');
define('ASSETS_ENTRY_ACCT_SALES','GL Asset Account');
define('ASSETS_ENTRY_ACCT_INV','GL Depreciation Account');
define('ASSETS_ENTRY_ACCT_COS','GL Maintenance Account');
define('ASSETS_ENTRY_ASSETS_SERIALIZE','Serial (VIN) Number');
define('ASSETS_DATE_ACCOUNT_CREATION','Asset Purchase Date');
define('ASSETS_DATE_LAST_UPDATE','Last Mantainence Date');
define('ASSETS_DATE_LAST_JOURNAL_DATE','Asset Retire Date');
define('ASSETS_ENTRY_SELECT_IMAGE','Image');
define('ASSETS_ENTRY_IMAGE_PATH','Image Relative Path');
define('ASSETS_MSG_COPY_INTRO','Enter the asset ID for the new asset.');
define('ASSETS_MSG_RENAME_INTRO','Enter the new asset ID to rename this asset.');

//************ admin defines *************/
define('MODULE_ASSET_GEN_INFO','Asset Manager Administration tools. Please select an action below.');
define('MODULE_ASSET_INSTALL_INFO','Install Asset Management Module');
define('MODULE_ASSET_REMOVE_INFO','Remove Asset Management Module');
define('MODULE_ASSET_REMOVE_CONFIRM','Are you sure you want to remove the Asset Managment Module?');
define('MODULE_ASSET_SAVE_FILES','Also remove files from my_files directory');

//************ Asset Field manager *********/
define('ASSETS_FIELD_HEADING_TITLE','Asset Field Manager');
define('ASSETS_DELETE_INTRO_FIELDS','Are you sure you want to delete this asset field?');

// Error Messages
define('ASSETS_ERROR_INSTALL_MSG','There was an error during installation!');

// Javascrpt defines
define('ASSETS_MSG_DELETE_ASSET','Are you sure you want to delete this asset?');

// Asset Selection defines
// the asset type indexes should not be changed or the asset module won't work.
$assets_types = array(
	'vh' => TEXT_VEHICLE,
	'bd' => TEXT_BUILDING,
	'fn' => TEXT_FURNITURE,
	'pc' => TEXT_COMPUTER,
	'ld' => TEXT_LAND,
	'sw' => TEXT_SOFTWARE,
);


?>