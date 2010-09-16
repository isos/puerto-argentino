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
//  Path: /modules/setup/language/en_us/modules/tax_auths_vend.php
//

define('SETUP_TITLE_TAX_AUTHS_VEND', 'Purchase Tax Authorities');

define('SETUP_TAX_DESC_SHORT', 'Short Name');
define('SETUP_TAX_GL_ACCT', 'GL Account ID');
define('SETUP_TAX_RATE', 'Tax Rate (percent)');

define('SETUP_TAX_AUTH_EDIT_INTRO', 'Please make any necessary changes');
define('SETUP_INFO_DESC_SHORT', 'Short Name (15 chars max)');
define('SETUP_INFO_DESC_LONG', 'Long Description (64 chars max)');
define('SETUP_INFO_GL_ACCOUNT', 'GL Account to record tax:');
define('SETUP_INFO_VENDOR_ID', 'Vendor to submit funds to:');
define('SETUP_INFO_TAX_RATE', 'Tax rate (in percent)');
define('SETUP_TAX_AUTH_INSERT_INTRO', 'Please enter the new tax authority with its properties');
define('SETUP_TAX_AUTH_DELETE_INTRO', 'Are you sure you want to delete this tax authority?');
define('SETUP_TAX_AUTHS_DELETE_ERROR','Cannot delete this tax authority, it is being use in a journal entry.');
define('SETUP_INFO_HEADING_NEW_TAX_AUTH', 'New Tax Authority');
define('SETUP_INFO_HEADING_EDIT_TAX_AUTH', 'Edit Tax Authority');
define('SETUP_INFO_HEADING_DELETE_TAX_AUTH', 'Delete Tax Authority');
define('SETUP_TAX_AUTHS_LOG','Tax Authorities - ');

define('SETUP_DISPLAY_NUMBER_OF_TAX_AUTH', TEXT_DISPLAY_NUMBER . 'tax authorities');

?>