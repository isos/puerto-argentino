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
//  Path: /modules/setup/language/en_us/language.php
//

// configuration
define('SETUP_CONFIG_EDIT_INTRO', 'Please make any necessary changes');
define('SETUP_INFO_DATE_ADDED', 'Date Added:');
define('SETUP_INFO_LAST_MODIFIED', 'Last Modified:');
define('SETUP_NO_MODULE_NAME','The setup script require a module name!');

// company manager
define('SETUP_CO_MGR_COPY_CO','Copy Company');
define('SETUP_CO_MGR_COPY_HDR','Enter the database name for the new company. (Must conform to mysql and your file system naming conventions, typically 8-12 alphanumeric characters) This name is used as the database name and will be added to the my_files directory to hold company specific data. If your privileges donnot allow the creation of the database, have your administrator create the database prior to creating the company.');
define('SETUP_CO_MGR_SRVR_NAME','Database Server ');
define('SETUP_CO_MGR_DB_NAME','Database Name ');
define('SETUP_CO_MGR_DB_USER','Database User Name ');
define('SETUP_CO_MGR_DB_PW','Database Password ');
define('SETUP_CO_MGR_CO_NAME','Company Full Name ');
define('SETUP_CO_MGR_SELECT_OPTIONS','Select the database records to copy to the new company.');
define('SETUP_CO_MGR_OPTION_1','Copy all database contents to new company.');
define('SETUP_CO_MGR_OPTION_2','Copy chart of accounts to new company.');
define('SETUP_CO_MGR_OPTION_3','Copy reports/forms to new company.');
define('SETUP_CO_MGR_OPTION_4','Copy inventory to new company.');
define('SETUP_CO_MGR_OPTION_5','Copy customers to new company.');
define('SETUP_CO_MGR_OPTION_6','Copy vendors to new company.');
define('SETUP_CO_MGR_OPTION_7','Copy employees to new company.');
define('SETUP_CO_MGR_OPTION_8','Copy users to new company.');
define('SETUP_CO_MGR_ERROR_EMPTY_FIELD','Database name and company name cannot be blank!');
define('SETUP_CO_MGR_NO_DB','Error creating database, check privileges and database name. Your administrator may have to create the database table before you create the company.');
define('SETUP_CO_MGR_DUP_DB_NAME','Error - The database name cannot be the same as the current database name!');
define('SETUP_CO_MGR_CANNOT_CONNECT','Error connecting to the new database. Check the username and password.');
define('SETUP_CO_MGR_ERROR_1','Error creating database tables.');
define('SETUP_CO_MGR_ERROR_2','Error loading data into database tables.');
define('SETUP_CO_MGR_ERROR_3','Error creating the company directories.');
define('SETUP_CO_MGR_ERROR_4','Error creating the company configuration file.');
define('SETUP_CO_MGR_ERROR_5A','Error dropping table ');
define('SETUP_CO_MGR_ERROR_5B','. DB Error # ');
define('SETUP_CO_MGR_ERROR_6','Error copying table ');
define('SETUP_CO_MGR_ERROR_7','Error loading demo data.');
define('SETUP_CO_MGR_CREATE_SUCCESS','Successfuly created new company');
define('SETUP_CO_MGR_DELETE_SUCCESS','The company was successfully deleted!');
define('SETUP_CO_MGR_LOG','Company Manager - ');

define('SETUP_CO_MGR_ADD_NEW_CO','Create New Company');
define('SETUP_CO_MGR_ADD_NEW_DEMO','Add demo data to the database tables.');

define('SETUP_CO_MGR_DEL_CO','Delete Company');
define('SETUP_CO_MGR_SELECT_DELETE','Select the company to delete.');
define('SETUP_CO_MGR_DELETE_CONFIRM','WARNING: THIS WILL DELETE THE DATABASE AND ALL COMPANY SPECIFIC FILES! ALL DATA WILL BE LOST!');
define('SETUP_CO_MGR_JS_DELETE_CONFIRM','Are you sure you want to delete this company?');

?>