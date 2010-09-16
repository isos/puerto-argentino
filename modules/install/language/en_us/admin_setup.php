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
//  Path: /modules/install/language/en_us/admin_setup.php
//

  define('TEXT_PAGE_HEADING', 'PhreeBooks&trade; Setup - Administrator Account Setup');
  define('SAVE_ADMIN_SETTINGS', 'Save Admin Settings');//this comes before TEXT_MAIN
  define('TEXT_MAIN', "To administer settings in your PhreeBooks&trade; shop, you need an Administrative account.  Please select an administrator's name, and password, and enter an email address for reset passwords to be sent to.  Enter and check the information carefully and press <em>".SAVE_ADMIN_SETTINGS.'</em> when you are done.');
  define('ADMIN_INFORMATION', 'Administrator Information');
  define('ADMIN_USERNAME', 'Administrator\'s Username');
  define('ADMIN_USERNAME_INSTRUCTION', 'Enter the username to be used for your PhreeBooks administrator account.');
  define('ADMIN_PASS', 'Administrator\'s Password');
  define('ADMIN_PASS_INSTRUCTION', 'Enter the password to be used for your PhreeBooks administrator account.');
  define('ADMIN_PASS_CONFIRM', 'Confirm Administrator\'s Password');
  define('ADMIN_PASS_CONFIRM_INSTRUCTION', 'Confirm the password to be used for your PhreeBooks administrator account.');
  define('ADMIN_EMAIL', 'Administrator\'s Email');
  define('ADMIN_EMAIL_INSTRUCTION', 'Enter the email address to be used for your PhreeBooks administrator account.');
  define('UPGRADE_DETECTION','Upgrade Detection');
  define('UPGRADE_INSTRUCTION_TITLE','Check for PhreeBooks&trade; updates when logging into Admin');
  define('UPGRADE_INSTRUCTION_TEXT','This will attempt to talk to the live PhreeBooks&trade; versioning server to determine if an upgrade is available or not. If an update is available, a message will appear in admin.  It will NOT automatically APPLY any upgrades.<br />You can override this later in Admin->Config->My Store->Check if version update is available.');

?>