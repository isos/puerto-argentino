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
//  Path: /modules/setup/language/en_us/modules/chart_of_accounts.php
//

/************* Release 2.0 additions ***********************/
define('GL_INFO_HEADING_ONLY', 'This account is a heading and cannot accept posted values?');
define('GL_INFO_PRIMARY_ACCT_ID', 'If this account is a sub-account, select primary account:');
define('ERROR_ACCT_TYPE_REQ','The GL Account Type is required!');
define('GL_ERROR_CANT_MAKE_HEADING','This account has a balance. It cannot be converted to a header account.');
/***********************************************************/

define('GL_POPUP_WINDOW_TITLE','Chart of Accounts');
define('GL_HEADING_ACCOUNT_NAME', 'Account ID');
define('GL_HEADING_SUBACCOUNT', 'Subaccount');
define('GL_EDIT_INTRO', 'Please make any necessary changes');
define('GL_INFO_ACCOUNT_TYPE', 'Account type (Required)');
define('GL_INFO_ACCOUNT_INACTIVE', 'Account inactive');
define('GL_INFO_INSERT_INTRO', 'Please enter the new GL account with its properties');
define('GL_INFO_NEW_ACCOUNT', 'New Account');
define('GL_INFO_EDIT_ACCOUNT', 'Edit Account');
define('GL_INFO_DELETE_ACCOUNT', 'Delete Account');
define('GL_INFO_DELETE_INTRO', 'Are you sure you want to delete this account?\nAccounts cannot be deleted if there is a journal entry against the account.');
define('GL_DISPLAY_NUMBER_OF_COA', TEXT_DISPLAY_NUMBER . 'accounts');
define('GL_ERROR_CANT_DELETE','This account cannot be deleted because there are journal entries against it.');
define('GL_LOG_CHART_OF_ACCOUNTS','Chart of Accounts - ');
?>