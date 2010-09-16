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
//  Path: /modules/install/language/en_us/language.php
//

  define('YES', 'YES');
  define('NO', 'NO');
  define('LANGUAGE','English (US)');
  define('LANGUAGE_TEXT','Available Languages: ');

  // Global entries for the <html> tag
  define('HTML_PARAMS','lang="en-US" xml:lang="en-US"');

  // charset for web pages and emails
  define('CHARSET', 'UTF-8');

  // META TAG TITLE
  define('META_TAG_TITLE', 'PhreeBooks&trade; Installer');

  // Navigation
  define('INSTALL_NAV_WELCOME','Welcome');
  define('INSTALL_NAV_LICENSE','License');
  define('INSTALL_NAV_PREREQ','Prerequisites');
  define('INSTALL_NAV_SYSTEM','System Setup');
  define('INSTALL_NAV_DATABASE','Database Setup');
  define('INSTALL_NAV_ADMIN','Admin Setup');
  define('INSTALL_NAV_COMPANY','Company Setup');
  define('INSTALL_NAV_CHART','Chart of Accounts');
  define('INSTALL_NAV_FY','Fiscal Year Setup');
  define('INSTALL_NAV_DEFAULTS','Account Defaults');
  define('INSTALL_NAV_FINISHED','Finished');

  if (isset($_GET['main_page']) && ($_GET['main_page']== 'index' || $_GET['main_page']== 'license')) {
    define('TEXT_ERROR_WARNING', 'Hi: Just a few issues that need addressing before we continue.');
  } else {
    define('TEXT_ERROR_WARNING', '<span class="errors"><strong>Warning: Problems Found</strong></span>');
  }

  define('DB_ERROR_NOT_CONNECTED', 'Install Error: Could not connect to the Database');

  define('UPLOAD_SETTINGS','The Maximum upload size supported will be whichever the LOWER of these values:.<br />
<em>upload_max_filesize</em> in php.ini %s <br />
<em>post_max_size</em> in php.ini: %s <br />' . 
//'<em>PhreeBooks</em> Upload Setting: %s <br />' .
'You may find some Apache settings that prevent you from uploading files or limit your maximum file size.  
See the Apache documentation for more information.');

  define('TEXT_HELP_LINK', ' more info...');
  define('TEXT_CLOSE_WINDOW', 'Close Window');

  define('ERROR_TEXT_4_1_2', 'PHP Version is 4.1.2');
  define('ERROR_CODE_4_1_2', '1');

  define('ERROR_TEXT_STORE_CONFIGURE', '/includes/configure.php file does not exist');
  define('ERROR_CODE_STORE_CONFIGURE', '3');

  define('ERROR_TEXT_PHYSICAL_PATH_ISEMPTY', 'Physical path is empty');
  define('ERROR_CODE_PHYSICAL_PATH_ISEMPTY', '9');

  define('ERROR_TEXT_PHYSICAL_PATH_INCORRECT', 'Physical path is incorrect');
  define('ERROR_CODE_PHYSICAL_PATH_INCORRECT', '10');

  define('ERROR_TEXT_VIRTUAL_HTTP_ISEMPTY', 'Virtual HTTP is empty');
  define('ERROR_CODE_VIRTUAL_HTTP_ISEMPTY', '11');

  define('ERROR_TEXT_VIRTUAL_HTTPS_ISEMPTY', 'Virtual HTTPS is empty');
  define('ERROR_CODE_VIRTUAL_HTTPS_ISEMPTY', '12');

  define('ERROR_TEXT_VIRTUAL_HTTPS_SERVER_ISEMPTY', 'Virtual HTTPS server is empty');
  define('ERROR_CODE_VIRTUAL_HTTPS_SERVER_ISEMPTY', '13');

  define('ERROR_TEXT_DB_USERNAME_ISEMPTY', 'DB UserName is empty');
  define('ERROR_CODE_DB_USERNAME_ISEMPTY', '16'); // re-using another one, since message is essentially the same.

  define('ERROR_TEXT_DB_HOST_ISEMPTY', 'DB Host is empty');
  define('ERROR_CODE_DB_HOST_ISEMPTY', '24');

  define('ERROR_TEXT_DB_NAME_ISEMPTY', 'DB name is empty'); 
  define('ERROR_CODE_DB_NAME_ISEMPTY', '25');

  define('ERROR_TEXT_DB_SQL_NOTEXIST', 'SQL Install file does not exist');
  define('ERROR_CODE_DB_SQL_NOTEXIST', '26');

  define('ERROR_TEXT_DB_NOTSUPPORTED', 'Database not supported');
  define('ERROR_CODE_DB_NOTSUPPORTED', '27');

  define('ERROR_TEXT_DB_CONNECTION_FAILED', 'Connection to Database failed');
  define('ERROR_CODE_DB_CONNECTION_FAILED', '28');

  define('ERROR_TEXT_DB_CREATE_FAILED', 'Could not create database');
  define('ERROR_CODE_DB_CREATE_FAILED', '29');

  define('ERROR_TEXT_DB_NOTEXIST', 'Database does not exist');
  define('ERROR_CODE_DB_NOTEXIST', '30');

  define('ERROR_TEXT_STORE_ID_ISEMPTY', 'Store ID is required');
  define('ERROR_CODE_STORE_ID_ISEMPTY', '109');

  define('ERROR_TEXT_STORE_NAME_ISEMPTY', 'Store name is required');
  define('ERROR_CODE_STORE_NAME_ISEMPTY', '31');

  define('ERROR_TEXT_STORE_ADDRESS1_ISEMPTY', 'Store address1 is required');
  define('ERROR_CODE_STORE_ADDRESS1_ISEMPTY', '32');

  define('ERROR_TEXT_STORE_OWNER_EMAIL_ISEMPTY', 'Store email address is required');
  define('ERROR_CODE_STORE_OWNER_EMAIL_ISEMPTY', '33');

  define('ERROR_TEXT_STORE_OWNER_EMAIL_NOTEMAIL', 'Store email address is not valid');
  define('ERROR_CODE_STORE_OWNER_EMAIL_NOTEMAIL', '34');

  define('ERROR_TEXT_STORE_POSTAL_CODE_ISEMPTY', 'Store postal code is required');
  define('ERROR_CODE_STORE_POSTAL_CODE_ISEMPTY', '35');

  define('ERROR_TEXT_DEMO_SQL_NOTEXIST', 'Demo product SQL file does not exist');
  define('ERROR_CODE_DEMO_SQL_NOTEXIST', '36');

  define('ERROR_TEXT_ADMIN_USERNAME_ISEMPTY', 'Admin user name is empty');
  define('ERROR_CODE_ADMIN_USERNAME_ISEMPTY', '46');

  define('ERROR_TEXT_ADMIN_EMAIL_ISEMPTY', 'Admin email empty');
  define('ERROR_CODE_ADMIN_EMAIL_ISEMPTY', '47');

  define('ERROR_TEXT_ADMIN_EMAIL_NOTEMAIL', 'Admin email is not valid');
  define('ERROR_CODE_ADMIN_EMAIL_NOTEMAIL', '48');

  define('ERROR_TEXT_LOGIN_PASS_ISEMPTY', 'Admin password is empty');
  define('ERROR_CODE_ADMIN_PASS_ISEMPTY', '49');

  define('ERROR_TEXT_LOGIN_PASS_NOTEQUAL', 'Passwords do not match');
  define('ERROR_CODE_ADMIN_PASS_NOTEQUAL', '50');

  define('ERROR_TEXT_PHP_VERSION', 'PHP Version not supported');
  define('ERROR_CODE_PHP_VERSION', '55');

  define('ERROR_TEXT_ADMIN_CONFIGURE_WRITE', 'admin configure.php is not writeable');
  define('ERROR_CODE_ADMIN_CONFIGURE_WRITE', '56');

  define('ERROR_TEXT_STORE_CONFIGURE_WRITE', '/includes/configure.php is not writeable');
  define('ERROR_CODE_STORE_CONFIGURE_WRITE', '57');

  define('ERROR_TEXT_CACHE_DIR_ISEMPTY', 'The Session/SQL Cache Directory entry is empty');
  define('ERROR_CODE_CACHE_DIR_ISEMPTY', '61');

  define('ERROR_TEXT_CACHE_DIR_ISDIR', 'The Session/SQL Cache Directory entry does not exist');
  define('ERROR_CODE_CACHE_DIR_ISDIR', '62');

  define('ERROR_TEXT_CACHE_DIR_ISWRITEABLE', 'The Session/SQL Cache Directory entry is not writeable');
  define('ERROR_CODE_CACHE_DIR_ISWRITEABLE', '63');

  define('ERROR_TEXT_PHPBB_CONFIG_NOTEXIST', 'phpBB config files do not exist');
  define('ERROR_CODE_PHPBB_CONFIG_NOTEXIST', '68');

  define('ERROR_TEXT_REGISTER_GLOBALS_ON', 'Register Globals is ON');
  define('ERROR_CODE_REGISTER_GLOBALS_ON', '69');

  define('ERROR_TEXT_SAFE_MODE_ON', 'Safe Mode is ON');
  define('ERROR_CODE_SAFE_MODE_ON', '70');

  define('ERROR_TEXT_CACHE_CUSTOM_NEEDED','Cache folder required to use file caching support');
  define('ERROR_CODE_CACHE_CUSTOM_NEEDED', '71');

  define('ERROR_TEXT_TABLE_RENAME_CONFIGUREPHP_FAILED','Could not update all your configure.php files with new prefix');
  define('ERROR_CODE_TABLE_RENAME_CONFIGUREPHP_FAILED', '72');

  define('ERROR_TEXT_TABLE_RENAME_INCOMPLETE','Could not rename all tables');
  define('ERROR_CODE_TABLE_RENAME_INCOMPLETE', '73');

  define('ERROR_TEXT_SESSION_SAVE_PATH','PHP "session.save_path" is not writable');
  define('ERROR_CODE_SESSION_SAVE_PATH','74');

  define('ERROR_TEXT_MAGIC_QUOTES_RUNTIME','PHP "magic_quotes_runtime" is active');
  define('ERROR_CODE_MAGIC_QUOTES_RUNTIME','75');

  define('ERROR_TEXT_DB_VER_UNKNOWN','Database Engine version information unknown');
  define('ERROR_CODE_DB_VER_UNKNOWN','76');

  define('ERROR_TEXT_UPLOADS_DISABLED','File Uploads are disabled');
  define('ERROR_CODE_UPLOADS_DISABLED','77');

  define('ERROR_TEXT_ADMIN_PWD_REQUIRED','Admin Password required to proceed with upgrade');
  define('ERROR_CODE_ADMIN_PWD_REQUIRED','78');

  define('ERROR_TEXT_PHP_SESSION_SUPPORT','PHP Session Support is required');
  define('ERROR_CODE_PHP_SESSION_SUPPORT','80');

  define('ERROR_TEXT_PHP_AS_CGI','PHP running as cgi not recommended unless server is Windows');
  define('ERROR_CODE_PHP_AS_CGI','81');

  define('ERROR_TEXT_DISABLE_FUNCTIONS','Required PHP functions are disabled on your server');
  define('ERROR_CODE_DISABLE_FUNCTIONS','82');

  define('ERROR_TEXT_OPENSSL_WARN','OpenSSL is "one" way in which a server can be configured to offer SSL (https://) support for your site.<br /><br />If this is showing as unavailable, possible causes could be:<br />(a) your webhost doesn\'t support SSL<br />(b) your webserver doesn\'t have OpenSSL installed, but MIGHT have another form of SSL services available<br />(c) your web host may not yet be aware of your SSL certificate details so that they can enable SSL support for your domain<br />(d) PHP may not be configured to know about OpenSSL yet.<br /><br />In any case, if you DO require encryption support on your web pages (SSL), you should be contacting your web hosting provider for assistance.');
  define('ERROR_CODE_OPENSSL_WARN','79');

  define('ERROR_TEXT_DB_PREFIX_NODOTS','Database Table-Prefix may not contain any of these characters: / or \\ or . ');
  define('ERROR_CODE_DB_PREFIX_NODOTS','83');

  define('ERROR_TEXT_PHP_SESSION_AUTOSTART','PHP Session.autostart should be disabled.');
  define('ERROR_CODE_PHP_SESSION_AUTOSTART','84');
  define('ERROR_TEXT_PHP_SESSION_TRANS_SID','PHP Session.use_trans_sid should be disabled.');
  define('ERROR_CODE_PHP_SESSION_TRANS_SID','86');
  define('ERROR_TEXT_DB_PRIVS','Permissions Required for Database User');
  define('ERROR_CODE_DB_PRIVS','87');
  define('ERROR_TEXT_COULD_NOT_WRITE_CONFIGURE_FILES','Error encountered while writing /includes/configure.php');
  define('ERROR_CODE_COULD_NOT_WRITE_CONFIGURE_FILES','88');
  define('ERROR_TEXT_DB_EXISTS','Database already exists');
  define('ERROR_CODE_DB_EXISTS','108');

  define('ERROR_TEXT_NO_CHART_SELECTED','Please select a chart to display the details!');
  define('TEXT_CURRENT_SETTINGS','-- Current Account Settings --');
  define('TEXT_ID','Account ID');
  define('TEXT_DESCRIPTION','Description');
  define('TEXT_ACCT_TYPE','Account Type');

  define('ERROR_TEXT_CHART_NAME_ISEMPTY', 'A chart of accounts template is required.');
  define('ERROR_CODE_CHART_NAME_ISEMPTY', '94');

define('POPUP_ERROR_1_HEADING', 'PHP Version 4.1.2 Detected');
define('POPUP_ERROR_1_TEXT', 'Some releases of PHP Version 4.1.2 have a bug which affects super global arrays. This may result in the admin section of PhreeBooks not being accessible. You are advised to upgrade your PHP version if possible.');
define('POPUP_ERROR_3_HEADING', '/includes/configure.php does not exist');
define('POPUP_ERROR_3_TEXT', 'The file /includes/configure.php does not exist. This file will be created during the installation process.');
define('POPUP_ERROR_4_HEADING', 'Physical Path');
define('POPUP_ERROR_4_TEXT', 'The physiscal path is the path to the directory where your PhreeBooks files are installed. For example on some linux systems the html files are stored in /var/www/html. If you then put your PhreeBooks files in a directory called \'store\', the physical path would be /var/www/html/store. The installer usually can be trusted to guess this directory correctly.');
define('POPUP_ERROR_5_HEADING', 'Virtual HTTP Path');
define('POPUP_ERROR_5_TEXT', 'This is the address you would need to put into a web browser to view your PhreeBooks website. If the site is in the \'root\' of your domain, this would be \'http://www.yourdomain.com\'. If you had put the files under a directory called \'store\' then the path would be \'http://www.yourdomain.com/store\'.');
define('POPUP_ERROR_6_HEADING', 'Virtual HTTPS Server');
define('POPUP_ERROR_6_TEXT', 'This is the web server address for your secure/SSL server. This address varies depending on how SSL/Secure mode is implemented on your server. You are advised to read the <a href="http://www.phreebooks.com/" target="_blank">FAQ Entry</a> on SSL to ensure this is set correctly.');
define('POPUP_ERROR_7_HEADING', 'Virtual HTTPS Path');
define('POPUP_ERROR_7_TEXT', 'This is the address you would need to put into a web browser to view your PhreeBooks website in secure/SSL mode. You are advised to read the <a href="http://www.phreebooks.com/" target="_blank">FAQ Entry</a> on SSL to ensure this is set correctly.');
define('POPUP_ERROR_8_HEADING', 'Enable SSL');
define('POPUP_ERROR_8_TEXT', 'This setting determines whether SSL/Secure (HTTPS:) mode is used on security-vulnerable pages of your PhreeBooks website.<br /><br />Any page where personal or financial information is entered e.g. login, payments, account details can be protected by SSL/Secure mode. <br /><br />You must have access to an SSL server (denoted by using HTTPS instead of HTTP). <br /><br />IF YOU ARE NOT SURE if you have an SSL server then please leave this setting set to NO for now, and check with your hosting provider. Note: As with all settings, this can be changed later by editing the configure.php file.');
define('POPUP_ERROR_9_HEADING', 'Physical Path is empty');
define('POPUP_ERROR_9_TEXT', 'You have left the entry for the Physical path empty. You must make a valid entry here.');
define('POPUP_ERROR_10_HEADING', 'Physical Path is incorrect');
define('POPUP_ERROR_10_TEXT', 'The entry you have made for the Physical Path does not appear to be valid. Please correct and try again.');
define('POPUP_ERROR_11_HEADING', 'Virtual HTTP is empty');
define('POPUP_ERROR_11_TEXT', 'You have left the entry for the Virtual HTTP path empty. You must make a valid entry here.');
define('POPUP_ERROR_12_HEADING', 'Virtual HTTPS is empty');
define('POPUP_ERROR_12_TEXT', 'You have left the entry for the Virtual HTTPS path empty as well as enabling SSL mode. You must make a valid entry here or disable SSL mode.');
define('POPUP_ERROR_13_HEADING', 'Virtual HTTPS server is empty');
define('POPUP_ERROR_13_TEXT', 'You have left the entry for the Virtual HTTPS server empty as well as enabling SSL mode. You must make a valid entry here or disable SSL mode');
define('POPUP_ERROR_14_HEADING', 'Database Type');
define('POPUP_ERROR_14_TEXT', 'PhreeBooks is designed to support multiple database types. Unfortunately at the moment that support is not complete. For now you should always leave this set to MySQL.');
define('POPUP_ERROR_15_HEADING', 'Database Host');
define('POPUP_ERROR_15_TEXT', 'This is the name of the webserver on which your host runs their database program. In most cases this can always be left set to \'localhost\'. In some exceptional cases you will need to ask your hosting provider for the server name of their database server.');
define('POPUP_ERROR_16_HEADING', 'Database User Name');
define('POPUP_ERROR_16_TEXT', 'All databases require a username and password to access them. The username for your database may well have been assigned by your hosting provider and you should contact them for details.');
define('POPUP_ERROR_17_HEADING', 'Database Password');
define('POPUP_ERROR_17_TEXT', 'All databases require a username and password to access them. The password for your database may well have been assigned by your hosting provider and you should contact them for details.');
define('POPUP_ERROR_18_HEADING', 'Database Name');
define('POPUP_ERROR_18_TEXT', 'This is the name of the database that will be used for PhreeBooks. If you are unsure as to what this should be, then you should contact your hosting provider for more information.');
define('POPUP_ERROR_19_HEADING', 'Database Table-Prefix');
define('POPUP_ERROR_19_TEXT', 'PhreeBooks allows you to add a prefix to the table names it uses to store its information. This is especially useful if your host only allows you one database, and you want to install other scripts on your system that use that database. Normally you should just leave the default setting as it is.');
define('POPUP_ERROR_20_HEADING', 'Database Create');
define('POPUP_ERROR_20_TEXT', 'This setting determines whether the installer should attempt to create the main database for PhreeBooks. Note \'create\' in this context has nothing to do with adding the tables that PhreeBooks needs, which will be done automatically anyway. Many hosts will not give their users \'create\' permissions, but provide another method for creating blank databases, e.g. cPanel or phpMyAdmin.');
define('POPUP_ERROR_21_HEADING', 'Database Connection');
define('POPUP_ERROR_21_TEXT', 'Persistent connections are a method of reducing the load on the database. You should consult your server host before setting this option.  Enabling "persistent connections" could cause your host to experience database problems if they haven\'t configured to handle it.<br /><br />Again, be sure to talk to your host before considering use of this option.');
define('POPUP_ERROR_22_HEADING', 'Database Sessions');
define('POPUP_ERROR_22_TEXT', 'This detemines whether session information is stored in a file or in the database. While file-based sessions are faster, database sessions are recommended for all online stores using SSL connections, for the sake of security.');
define('POPUP_ERROR_23_HEADING', 'Enable SSL');
define('POPUP_ERROR_23_TEXT', '');
define('POPUP_ERROR_24_HEADING', 'DB Host is empty');
define('POPUP_ERROR_24_TEXT', 'The entry for DB Host is empty. Please enter a valid Database Server Hostname. <br />This is the name of the webserver on which your host runs their database program. In most cases this can always be left set to \'localhost\'. In some exceptional cases you will need to ask your hosting provider for the server name of their database server.');
define('POPUP_ERROR_25_HEADING', 'DB name is empty');
define('POPUP_ERROR_25_TEXT', 'The entry for DB name is empty. Please enter the name of the database you wish to use for PhreeBooks.<br />This is the name of the database that will be used for PhreeBooks. If you are unsure as to what this should be, then you should contact your hosting provider for more information.');
define('POPUP_ERROR_26_HEADING', 'SQL Install file does not exist');
define('POPUP_ERROR_26_TEXT', 'The installer could not find the sql install file. This should exist within the \'modules/install/sql/current\' directory and be called something like \'tables.sql\'.');
define('POPUP_ERROR_27_HEADING', 'Database not supported');
define('POPUP_ERROR_27_TEXT', 'The database type you have selected does not appear to be supported by the PHP version you have installed. You may need to check with your hosting provider to check that the database type you have selected is supported. If this is your own server, then please ensure that support for the database type has been compiled into PHP, and that the necessary extensions/modules/dll files are being loaded (esp check php.ini for extension=mysql.so, etc).');
define('POPUP_ERROR_28_HEADING', 'Connection to Database failed');
define('POPUP_ERROR_28_TEXT', 'A connection to the database could not be made. This can happen for a number of reasons. <br /><br />
You may have given the wrong DB host name, or the user name or <em>password </em>may be incorrect. <br /><br />
You may also have given the wrong database name (<strong>Does it exist?</strong> <strong>Did you create it?</strong> -- NOTE: PhreeBooks&trade; does not create a database for you.).<br /><br />
Please review all of the entries and ensure that they are correct.');
define('POPUP_ERROR_29_HEADING', 'Could not create database');
define('POPUP_ERROR_29_TEXT', 'You do not appear to have permission to create a blank database. You may need to contact your host to do this for you. Alternatavely you may need to use cpanel or phpMyAdmin to create a blank database. Once you create the database manually, DESELECT the \'Create Database\' option in the PhreeBooks Installer in order to proceed.');
define('POPUP_ERROR_30_HEADING', 'Database does not exist');
define('POPUP_ERROR_30_TEXT', 'The database name you have specified does not appear to exist.<br />(<strong>Did you create it?</strong> -- NOTE: PhreeBooks&trade; does not create a database for you.).<br /><br />Please check your database details, then verify this entry and make corrections where necessary.');
define('POPUP_ERROR_31_HEADING', 'Store name is empty');
define('POPUP_ERROR_31_TEXT', 'Please specify the name by which you will refer to your company.');
define('POPUP_ERROR_32_HEADING', 'Store owner is empty');
define('POPUP_ERROR_32_TEXT', 'Please supply the name of the company owner.  This information will appear in the \'Contact Us\' page, the \'Welcome\' email messages, and other places throughout the company.');
define('POPUP_ERROR_33_HEADING', 'Store email address is empty');
define('POPUP_ERROR_33_TEXT', 'Please supply the companies primary email address. This is the address which will be supplied for contact information in emails that are sent out from the company.');
define('POPUP_ERROR_34_HEADING', 'Store email address is not valid');
define('POPUP_ERROR_34_TEXT', 'You must supply a valid email address.');
define('POPUP_ERROR_35_HEADING', 'Store address is empty');
define('POPUP_ERROR_35_TEXT', 'Please supply the street address of your company.  This will be displayed on the Contact-Us page (this can be disabled if required), and on invoice/packing-slip materials. It will also be displayed if a customer elects to purchase by check/money-order, upon checkout.');
define('POPUP_ERROR_36_HEADING', 'Demo product SQL file does not exist');
define('POPUP_ERROR_36_TEXT', 'We were unable to locate the SQL file containing the PhreeBooks demo products to load them into your company.  Please check that the /zc_install/demo/xxxxxxx_demo.sql file exists. (xxxxxxx = your database-type).');
define('POPUP_ERROR_37_HEADING', 'Company Name');
define('POPUP_ERROR_37_TEXT', 'The name of your company. This will be used in emails sent by the system and in some cases, the browser title.');
define('POPUP_ERROR_38_HEADING', 'Company City/Town');
define('POPUP_ERROR_38_TEXT', 'The company city or town details may be used in emails sent by the system. It also appears on the address-label layout on invoicing, etc.');
define('POPUP_ERROR_39_HEADING', 'Store Owner Email');
define('POPUP_ERROR_39_TEXT', 'The main email address by which your company can be contacted. Most emails sent by the system will use this, as well as contact us pages.');
define('POPUP_ERROR_40_HEADING', 'Company Country');
define('POPUP_ERROR_40_TEXT', 'The country your company is based in. It is important that you set this correctly to ensure that Tax and shipping options work correctly.  It also determines the address-label layout on invoicing, etc.');
define('POPUP_ERROR_41_HEADING', 'Company State/Province');
define('POPUP_ERROR_41_TEXT', 'This represents a geographical sub-division of the country your company is based in. eg. A state in the U.S.A.');
define('POPUP_ERROR_42_HEADING', 'Store Address');
define('POPUP_ERROR_42_TEXT', 'Your Company Address, used on invoices and order confirmations. Two lines are allowed, the first line is required.');
define('POPUP_ERROR_43_HEADING', 'Store Default Language');
define('POPUP_ERROR_43_TEXT', 'The default language your company will use. PhreeBooks is inherently multi-language, provided the correct language pack is loaded. Unfortunately at the moment PhreeBooks only comes with an English Language Pack as default.');
define('POPUP_ERROR_44_HEADING', 'Store Default Currency');
define('POPUP_ERROR_44_TEXT', 'Select a default currency which your company will operate on.  If your desired currency is not listed here, it can be changed in the Admin area after installation is complete.<br /><br />NOTE: Once a journal entry has been made, the default currency cannot be changed!');
define('POPUP_ERROR_45_HEADING', 'Install Demo Products');
define('POPUP_ERROR_45_TEXT', 'Please select whether you wish to install the demo products into the database in order to preview the methods by which various features of PhreeBooks operate.');
define('POPUP_ERROR_46_HEADING', 'Admin user name is empty');
define('POPUP_ERROR_46_TEXT', 'To log into the Admin area after install is complete, you need to supply an Admin username here.');
define('POPUP_ERROR_47_HEADING', 'Admin email empty');
define('POPUP_ERROR_47_TEXT', 'The Admin email address is required in order to send password-resets in case you forget the password.');
define('POPUP_ERROR_48_HEADING', 'Admin email is not valid');
define('POPUP_ERROR_48_TEXT', 'Please supply a valid email address.');
define('POPUP_ERROR_49_HEADING', 'Admin password is empty');
define('POPUP_ERROR_49_TEXT', 'For security, the Administrator\'s password cannot be blank.');
define('POPUP_ERROR_50_HEADING', 'Passwords do not match');
define('POPUP_ERROR_50_TEXT', 'Please re-enter the administrator password and confirmation password.');
define('POPUP_ERROR_51_HEADING', 'Admin User Name');
define('POPUP_ERROR_51_TEXT', 'To log into the Admin area after install is complete, you need to supply an Admin username here.');
define('POPUP_ERROR_52_HEADING', 'Admin Email Address');
define('POPUP_ERROR_52_TEXT', 'The Admin email address is required in order to send password-resets in case you forget the password.');
define('POPUP_ERROR_53_HEADING', 'Admin Password');
define('POPUP_ERROR_53_TEXT', 'The administrator password is your secure password to allow you access to the administration area.');
define('POPUP_ERROR_54_HEADING', 'Admin Password Confirmation');
define('POPUP_ERROR_54_TEXT', 'Naturally, you need to supply matching passwords before the password can be saved for future use.');
define('POPUP_ERROR_55_HEADING', 'PHP Version not supported');
define('POPUP_ERROR_55_TEXT', 'The PHP Version running on your webserver is not supported by PhreeBooks.  Additionally, some releases of PHP Version 4.1.2 have a bug which affects super global arrays. This may result in the admin section of PhreeBooks not being accessible. You are advised to upgrade your PHP version if possible.');
define('POPUP_ERROR_57_HEADING', 'PhreeBooks configure.php is not writeable');
define('POPUP_ERROR_57_TEXT', 'The file includes/configure.php is not writeable. If you are using a Unix or Linux system then please CHMOD the file to 777 or 666 until the PhreeBooks install is completed. On a Windows system it is simply enough that the file is set to read/write.');
define('POPUP_ERROR_58_HEADING', 'DB Table Prefix');
define('POPUP_ERROR_58_TEXT', 'PhreeBooks allows you to add a prefix to the table names it uses to store its information. This is especially useful if your host only allows you one database, and you want to install other scripts on your system that use that database. Normally you should just leave the default setting as it is.');
define('POPUP_ERROR_59_HEADING', 'SQL Cache Directory');
define('POPUP_ERROR_59_TEXT', 'SQL queries can be cached either in the database, in a file on your server\'s hard disk, or not at all. If you choose to cache SQL queries to a file on your server\'s hard disk, then you must provide the directory where this information can be saved. <br /><br />The standard PhreeBooks installation includes a \'cache\' folder.  You need to mark this folder read-write for your webserver (ie: apache) to access it.<br /><br />Please ensure that the directory you select exists and is writeable by the web server (CHMOD 777 or at least 666 recommended).');
define('POPUP_ERROR_60_HEADING', 'SQL Cache Method');
define('POPUP_ERROR_60_TEXT', 'Some SQL queries are marked as being cacheable. This means that if they are cached they will run much more quickly. You can decide which method is used to cache the SQL Query.<br /><br /><strong>None</strong>. SQL queries are not cached at all. If you have very few products/categories you might actually find this gives the best speed for your site.<br /><br /><strong>Database</strong>. SQL queries are cached to a database table. Sounds strange but this might provide a speed increase for sites with medium numbers of products/categories.<br /><br /><strong>File</strong>. SQL Queries are cached to your server\'s hard disk. For this to work you must ensure that the directory where queries are cached to is writeable by the web server. This method is probably most suitable for sites with a large number of products/categories.');
define('POPUP_ERROR_61_HEADING', 'The Session/SQL Cache Directory entry is empty');
define('POPUP_ERROR_61_TEXT', 'If you wish to use file caching for Session/SQL queries, you must supply a valid directory on your webserver, and ensure that the webserver has rights to write into that folder/directory.');
define('POPUP_ERROR_62_HEADING', 'The Session/SQL Cache Directory entry does not exist');
define('POPUP_ERROR_62_TEXT', 'If you wish to use file caching for Session/SQL queries, you must supply a valid directory on your webserver, and ensure that the webserver has rights to write into that folder/directory.');
define('POPUP_ERROR_63_HEADING', 'The Session/SQL Cache Directory entry is not writeable');
define('POPUP_ERROR_63_TEXT', 'If you wish to use file caching for Session/SQL queries, you must supply a valid directory on your webserver, and ensure that the webserver has rights to write into that folder/directory.  CHMOD 666 or 777 is advisable under Linux/Unix.  Read/Write is suitable under Windows servers.');
define('POPUP_ERROR_65_HEADING', 'phpBB Database Table-Prefix');
define('POPUP_ERROR_65_TEXT', 'Please supply the table-prefix for your phpBB tables in the database where they are located. This is usually \'phpBB_\'');
define('POPUP_ERROR_66_HEADING', 'phpBB Database Name');
define('POPUP_ERROR_66_TEXT', 'Please supply the database name where your phpBB tables are located.');
define('POPUP_ERROR_69_HEADING', 'Register Globals');
define('POPUP_ERROR_69_TEXT', 'PhreeBooks can only work with the "Register Globals" setting off.');
define('POPUP_ERROR_70_HEADING', 'Safe Mode is On');
define('POPUP_ERROR_70_TEXT', 'PhreeBooks does not work well on servers running in Safe Mode.<br /><br />To run an ERP system requires many advanced services often restricted on lower-cost "shared" hosting services. To run PhreeBooks in optimum fashion will require setting up a webhosting service that does not place you or your webspace in "Safe Mode".  You need your hosting company to set "SAFE_MODE=OFF" in your php.ini file.');
define('POPUP_ERROR_71_HEADING', 'Cache folder required to use file-based caching support');
define('POPUP_ERROR_71_TEXT', 'If you wish to use the "file-based SQL cache support" in PhreeBooks, you\'ll need to set the proper permissions on the cache folder in your webspace.<br /><br />Optionally, you can choose "Database Caching" or "No Caching" if you prefer not to use the cache folder. In this case, you MAY need to disable "store sessions" as well, as the session tracker uses the file cache as well.<br /><br />To set up the cache folder properly, use your FTP program or shell access to your server to CHMOD the folder to 666 or 777 read-write permissions level.<br /><br />Most specifically, the userID of your webserver (ie: \'apache\' or \'www-user\' or maybe \'IUSR_something\' under Windows) must have all \'read-write-delete\' etc privileges to the cache folder.');
define('POPUP_ERROR_72_HEADING', 'ERROR: Could not update all your configure.php files with new prefix');
define('POPUP_ERROR_72_TEXT', 'While attempting to update your configure.php files after renaming tables, we encountered an error.  You will need to manually edit your /includes/configure.php files and ensure that the "define" for "DB_PREFIX" is set properly for your PhreeBooks tables in your database.');
define('POPUP_ERROR_73_HEADING', 'ERROR: Could not apply new table-prefix to all tables');
define('POPUP_ERROR_73_TEXT', 'While attempting to rename your database tables with the new table prefix, we encountered an error.  You will need to manually review your database tablenames for accuracy. Worst-case, you may need to recover from your backup.');
define('POPUP_ERROR_74_HEADING', 'NOTE: PHP "session.save_path" is not writable');
define('POPUP_ERROR_74_TEXT', '<strong>This is JUST a note </strong>to inform you that you do not have permission to write to the path specified in the PHP session.save_path setting.<br /><br />This simply means that you cannot use this path setting for temporary file storage.  Instead, use the "suggested cache path" shown below it.');
define('POPUP_ERROR_75_HEADING', 'NOTE: PHP "magic_quotes_runtime" is active');
define('POPUP_ERROR_75_TEXT', 'It is best to have "magic_quotes_runtime" disabled. When enabled, it can cause unexpected 1064 SQL errors, and other code-execution problems.<br /><br />If you cannot disable it for the whole server, it may be possible to disable via .htaccess or your own php.ini file in your private webspace.  Talk to your hosting company for assistance.');
define('POPUP_ERROR_76_HEADING', 'Database Engine version information unknown');
define('POPUP_ERROR_76_TEXT', 'The version number of your database engine could not be obtained.<br /><br />This is NOT NECESSARILY a serious issue. In fact, it can be quite common on a production server, as at the stage of this inspection, we may not yet know the required security credentials in order to log in to your server, since those are obtained later in the installation process.<br /><br />It is generally safe to proceed even if this information is listed as Unknown.');
define('POPUP_ERROR_77_HEADING', 'File Uploads are DISABLED');
define('POPUP_ERROR_77_TEXT', 'File uploads are DISABLED. To enable them, make sure <em><strong>file_uploads = on</strong></em> is in your server\'s php.ini file.');
define('POPUP_ERROR_78_HEADING', 'ADMIN PASSWORD REQUIRED TO UPGRADE');
define('POPUP_ERROR_78_TEXT', 'The Store Administrator username and password are required in order to make changes to the database.<br /><br />Please enter a valid admin user ID and password for your PhreeBooks site.');
define('POPUP_ERROR_79_TEXT','OpenSSL is "one" way in which a server can be configured to offer SSL (https://) support for your site.<br /><br />If this is showing as unavailable, possible causes could be:<br />(a) your webhost doesn\'t support SSL<br />(b) your webserver doesn\'t have OpenSSL installed, but MIGHT have another form of SSL services available<br />(c) your web host may not yet be aware of your SSL certificate details so that they can enable SSL support for your domain<br />(d) PHP may not be configured to know about OpenSSL yet.<br /><br />In any case, if you DO require encryption support on your web pages (SSL), you should be contacting your web hosting provider for assistance.');
define('POPUP_ERROR_79_HEADING','OpenSSL Information');
define('POPUP_ERROR_80_HEADING', 'PHP Session Support is Required');
define('POPUP_ERROR_80_TEXT', 'You need to enable PHP Session support on your webserver.  You might try installing this module: php4-session ');
define('POPUP_ERROR_81_HEADING', 'PHP running as cgi not recommended unless server is Windows');
define('POPUP_ERROR_81_TEXT', 'Running PHP as CGI can be problematic on some Linux/Unix servers.<br /><br />Windows servers, however, "always" run PHP as a cgi module, in which case this warning can be ignored.');
define('POPUP_ERROR_82_HEADING', ERROR_TEXT_DISABLE_FUNCTIONS);
define('POPUP_ERROR_82_TEXT', 'Your PHP configuration has one or more of the following functions marked as "disabled" in your server\'s PHP.INI file:<br /><ul><li>set_time_limit</li><li>exec</li></ul>Your server may suffer from decreased performance due to the use of these security measures which are usually implemented on highly-used public servers... which are not always ideal for running an e-Commerce system.<br /><br />It is recommended that you speak with your hosting provider to determine whether they have another server where you may run your site with these restrictions removed.');
define('POPUP_ERROR_83_HEADING','Invalid characters in database table-prefix');
define('POPUP_ERROR_83_TEXT','Database Table-Prefix may not contain any of these characters:<br />
&nbsp;&nbsp; / or \\ or . <br /><br />Please select a different prefix. We recommend something simple like "pb_" .');
define('POPUP_ERROR_84_HEADING','PHP Session.autostart should be disabled.');
define('POPUP_ERROR_84_TEXT','The session.auto_start setting in your server\'s PHP.INI file is set to ON. <br /><br />This could potentially cause you some problems with session handling, as PhreeBooks is designed to start sessions when it\'s ready to activate session features. Having sessions start automatically can be a problem in some server configurations.<br /><br />If you wish to tackly disabling this yourself, you could try putting the following into a .htaccess file located in the root of your shop (same folder as index.php):<br /><br /><code>php_value session.auto_start 0</code>');
define('POPUP_ERROR_85_HEADING','Some database-upgrade SQL statements not installed.');
define('POPUP_ERROR_85_TEXT','During the database-upgrade process, some SQL statements could not be executed because they would have created duplicate entries in the database, or the prerequisites (such as column must exist to change or drop) were not met.<br /><br />THE MOST COMMON CAUSE of these failures/exceptions is that you have installed a contribution/add-on that has made alterations to the core database structure. The upgrader is trying to be friendly and not create a problem for you. <br /><br />YOUR STORE MAY WORK JUST FINE without investigating these errors, however, we recommend that you check them out to be sure. <br /><br />If you wish to investigate, you may look at your "upgrade_exceptions" table in the database for details on which statements failed to execute and why.');
define('POPUP_ERROR_86_HEADING','PHP Session.use_trans_sid should be disabled.');
define('POPUP_ERROR_86_TEXT','The session.use_trans_sid setting in your server\'s PHP.INI file is set to ON. <br /><br />This could potentially cause you some problems with session handling and possibly even security concerns.<br /><br />You can work around this by setting an .htaccess parameter such as this: <a href="http://www.olate.com/articles/252">http://www.olate.com/articles/252</a>, or you could disable it in your PHP.INI if you have access to it.<br /><br />For more information on the security risks it imposes, see: <a href="http://shh.thathost.com/secadv/2003-05-11-php.txt">http://shh.thathost.com/secadv/2003-05-11-php.txt</a>.');
define('POPUP_ERROR_87_HEADING','Permissions Required for Database User');
define('POPUP_ERROR_87_TEXT','PhreeBooks operations require the following database-level privileges:<ul><li>ALL PRIVILEGES<br /><em>or</em></li><li>SELECT</li><li>INSERT</li><li>UPDATE</li><li>DELETE</li><li>CREATE</li><li>ALTER</li><li>INDEX</li><li>DROP</li></ul>Day-to-day activities do not normally require the "CREATE" and "DROP" privileges, but these ARE required for Installation, Upgrade, and SQLPatch activities.');
define('POPUP_ERROR_88_HEADING','Error encountered while writing /includes/configure.php');
define('POPUP_ERROR_88_TEXT','While attempting to save your settings, PhreeBooks&trade; Installer was unable to verify successful writing of your configure.php file settings. Please check to be sure that your webserver has full write permissions to the configure.php file shown below.<br /><br />- /includes/configure.php<br />You may want to also check that there is sufficient disk space (or disk quota available to you) in order to write updates to these files. <br /><br />If the files are 0-bytes in size when you encounter this error, then disk space or "available" disk space is likely the cause.<br /><br />Ideal permissions in Unix/Linux hosting is CHMOD 777 until installation is complete. Then they can be set back to 644 or 444 for security after installation is done.<br /><br />If you are running on a Windows host, you may also find it necessary to right-click on each of these files, choose "Properties", then the "Security" tab. Then click on "Add" and select "Everyone", and grant "Everyone" full read/write access until installation is complete. Then reset to read-only after installation.');
define('POPUP_ERROR_89_HEADING','Permission To Upgrade');
define('POPUP_ERROR_89_TEXT','Phreebooks has detected a previous installation and your security settings do not allow you to upgrade. This is not a problem at this time unless an upgrade is being performed.');
define('POPUP_ERROR_90_HEADING','Company ID');
define('POPUP_ERROR_90_TEXT','The CompanyID is used for journal entries and as an identifier for pull-down menus to help identify the branch requesting the action. For multi-branch operation, this value will be combined with the ID\'s from other branches to separate entries.');
define('POPUP_ERROR_91_HEADING','Company Postal Code');
define('POPUP_ERROR_91_TEXT','The Postal Code/Zip Code is used for invoices, etc. It is also used for the shipping module to calculate freight rates.');
define('POPUP_ERROR_92_HEADING','Company Telephone/Fax Numbers');
define('POPUP_ERROR_92_TEXT','Two telephone numbers and one fax number are permitted.');
define('POPUP_ERROR_93_HEADING','Company Website');
define('POPUP_ERROR_93_TEXT','Company main URL to homepage. Can be used for invoices, purchase orders, etc.');
define('POPUP_ERROR_94_HEADING','Chart of Accounts Template');
define('POPUP_ERROR_94_TEXT','A Chart of accounts template is required. If a chart is already loaded in the system, select ' . TEXT_CURRENT_SETTINGS . ' and continue or else select a template from the list. To preview a chart, select a template and press \'view chart details\'.');
define('POPUP_ERROR_95_HEADING','Fiscal Years/Accounting Periods');
define('POPUP_ERROR_95_TEXT','Accounting principles use fiscal years and accounting periods to track financial performance. The fiscal year is broken into 12 accounting periods per fiscal year. Generally, accounting periods align with calendar months and fiscal years align with calendar years. Phreebooks will also allow non-standard start dates to a period and the fiscal year to allow mid-month/mid-year start dates. For now, select a starting month and year to set as your first accounting period. PhreeBooks will initially set the start at the first day of the selected month as period 1. <br /><br />After setup is complete, the actual days of each accounting period can be modified to match the accounting calendar of your company. NOTE: This change needs to be completed before the first journal entry.');
define('POPUP_ERROR_96_HEADING','Default Inventory Item Purchase Account');
define('POPUP_ERROR_96_TEXT','This account represents the account to use for items received from vendors. Note that each SKU has it\'s own inventory account but this is used for initial loading of the order forms for items not set up in the database with a SKU.');
define('POPUP_ERROR_97_HEADING','Default Purchase Account');
define('POPUP_ERROR_97_TEXT','This account represents the ledger account to accumulate your purchases. The default purchase account can be overridden on an order by order level for more granularity of your companies purchase data.');
define('POPUP_ERROR_98_HEADING','Default Purchase Discount Account');
define('POPUP_ERROR_98_TEXT','This account represents the ledger account to accumulate discounts on purchases from vendors. It may hold coupons/discounts unafilliated with your inventory items, pre-payment discounts on purchases, etc.');
define('POPUP_ERROR_99_HEADING','Default Purchase Freight In Account');
define('POPUP_ERROR_99_TEXT','This account represents the ledger account where freight-in charges are placed. It is common to break out freight-in charges into a separate account to not adversly affect the cost of received inventory.');
define('POPUP_ERROR_100_HEADING','Default Vendor Payment Account');
define('POPUP_ERROR_100_TEXT','This account represents the ledger account where payments to vendors are pulled from. It is typiclly a cash account usually a checking account or cash drawer.');
define('POPUP_ERROR_101_HEADING','Default Sales Account');
define('POPUP_ERROR_101_TEXT','This account represents the ledger account to accumulate your sales. The default sales account can be overridden on an order by order level for more granularity of your companies sales data.');
define('POPUP_ERROR_102_HEADING','Default Accounts Receivable Account');
define('POPUP_ERROR_102_TEXT','This account represents the ledger account to accumulate cash owed due to sales with payment terms, i.e. sales where payment is expected at a later date.');
define('POPUP_ERROR_103_HEADING','Default Sales Discount Account');
define('POPUP_ERROR_103_TEXT','This account represents the ledger account to accumulate discounts on sales to customers. It may hold coupons unafilliated with your inventory items, pre-payment discounts on sales, etc.');
define('POPUP_ERROR_104_HEADING','Default Sales Freight Out Account');
define('POPUP_ERROR_104_TEXT','This account represents the ledger account where shipping freight charges are placed. It is common to break out freight charges into a separate account to discern between product sales and freight sales.');
define('POPUP_ERROR_105_HEADING','Default Customer Payment Account');
define('POPUP_ERROR_105_TEXT','This account represents the ledger account where cash is pulled for payments received from your customers. It is typiclly a cash account usually a checking account or cash drawer.');
define('POPUP_ERROR_106_HEADING','directory /includes');
define('POPUP_ERROR_106_TEXT','Cannot write the configure.php file to the directory /includes. Check /includes directory permissions and change to 777.');
define('POPUP_ERROR_107_HEADING','directory /my_files');
define('POPUP_ERROR_107_TEXT','Cannot create the directory /my_files. Check permissions on the root directory and change to 777.');
define('POPUP_ERROR_108_HEADING','Database Exists');
define('POPUP_ERROR_108_TEXT','Cannot load the database tables, they already exist! PhreeBooks is trying to perform a clean install and cannot because it has detected a prior installation. <br /><br />The installation cannot continue until the database tables are removed.');
define('POPUP_ERROR_109_HEADING', 'Store ID is empty');
define('POPUP_ERROR_109_TEXT', 'Please specify the ID by which you will refer to your company. 15 characters or less and no spaces, i.e. HQ, SWBranch, etc.');

?>