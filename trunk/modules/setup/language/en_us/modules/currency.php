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
//  Path: /modules/setup/language/en_us/modules/currency.php
//

define('SETUP_TITLE_CURRENCIES', 'Currencies');
define('SETUP_CURRENCY_NAME', 'Currency');
define('SETUP_CURRENCY_CODES', 'Code');
define('SETUP_UPDATE_EXC_RATE','Update Exchange Rate');

define('SETUP_CURR_EDIT_INTRO', 'Please make any necessary changes');
define('SETUP_INFO_CURRENCY_TITLE', 'Title:');
define('SETUP_INFO_CURRENCY_CODE', 'Code:');
define('SETUP_INFO_CURRENCY_SYMBOL_LEFT', 'Symbol Left:');
define('SETUP_INFO_CURRENCY_SYMBOL_RIGHT', 'Symbol Right:');
define('SETUP_INFO_CURRENCY_DECIMAL_POINT', 'Decimal Point:');
define('SETUP_INFO_CURRENCY_THOUSANDS_POINT', 'Thousands Point:');
define('SETUP_INFO_CURRENCY_DECIMAL_PLACES', 'Decimal Places:');
define('SETUP_INFO_CURRENCY_DECIMAL_PRECISE', 'Decimal Precision: For use with unit prices and quantities at a higher precision than currency values. This value is typically set to the number of decimal palces:');
define('SETUP_INFO_CURRENCY_VALUE', 'Value:');
define('SETUP_INFO_CURRENCY_EXAMPLE', 'Example Output:');
define('SETUP_CURR_INSERT_INTRO', 'Please enter the new currency with its related data');
define('SETUP_CURR_DELETE_INTRO', 'Are you sure you want to delete this currency?');
define('SETUP_INFO_HEADING_NEW_CURRENCY', 'New Currency');
define('SETUP_INFO_HEADING_EDIT_CURRENCY', 'Edit Currency');
define('SETUP_INFO_HEADING_DELETE_CURRENCY', 'Delete Currency');
define('SETUP_SET_DEFAULT', 'Set as default');
define('SETUP_INFO_SET_AS_DEFAULT', SETUP_SET_DEFAULT . ' (requires a manual update of currency values)');
define('SETUP_INFO_CURRENCY_UPDATED', 'The exchange rate for %s (%s) was updated successfully via %s.');

define('SETUP_ERROR_CANNOT_CHANGE_DEFAULT', 'The default currency cannot be changed once entries have been entered in the system!');
define('SETUP_ERROR_REMOVE_DEFAULT_CURRENCY', 'Error: The default currency can not be removed. Please set another currency as default, and try again.');
define('SETUP_ERROR_CURRENCY_INVALID', 'Error: The exchange rate for %s (%s) was not updated via %s. Is it a valid currency code?');
define('SETUP_WARN_PRIMARY_SERVER_FAILED', 'Warning: The primary exchange rate server (%s) failed for %s (%s) - trying the secondary exchange rate server.');
define('TEXT_DISPLAY_NUMBER_OF_CURRENCIES', TEXT_DISPLAY_NUMBER . 'currencies');
define('SETUP_LOG_CURRENCY','Currencies - ');

?>