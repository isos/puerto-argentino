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
//  Path: /modules/install/language/en_us/database_setup.php
//

  define('SAVE_DATABASE_SETTINGS', 'Save Database Settings');//this comes before TEXT_MAIN
  define('TEXT_MAIN', "Next we need to know some information on your database settings.  Please carefully enter each setting in the appropriate box and press <em>" . SAVE_DATABASE_SETTINGS . "</em> to continue.'");
  define('TEXT_PAGE_HEADING', 'PhreeBooks&trade; Setup - Database Setup');
  define('DATABASE_INFORMATION', 'Database Information');
  define('DATABASE_TYPE', 'Database Type');
  define('DATABASE_TYPE_INSTRUCTION', 'Choose the database type to be used.');
  define('DATABASE_HOST', 'Database Host');
  define('DATABASE_HOST_INSTRUCTION', 'What is the database host?  The database host can be in the form of a host name, such as \'db1.myserver.com\', or as an IP-address, such as \'192.168.0.1\'.');
  define('DATABASE_USERNAME', 'Database Username');
  define('DATABASE_USERNAME_INSTRUCTION', 'What is the username used to connect to the database? An example username is \'root\'.');
  define('DATABASE_PASSWORD', 'Database Password');
  define('DATABASE_PASSWORD_INSTRUCTION', 'What is the password used to connect to the database?  The password is used together with the username, which forms your database user account.');
  define('DATABASE_NAME', 'Company Database Name');
  define('DATABASE_NAME_INSTRUCTION', 'What is the name of the database used to hold the data? An example database name would be an abbreviated company name such as \'mycompany\'. Spaces or special characters are NOT allowed. <!-- If the database is not found the database will be created.-->');
  define('DATABASE_PREFIX', 'Database Table-Prefix');
  define('DATABASE_PREFIX_INSTRUCTION', 'What is the prefix you would like used for database tables?  Example: pb_ Leave empty if no prefix is needed.');
  define('DATABASE_CREATE', 'Create Database?');
  define('DATABASE_CREATE_INSTRUCTION', 'Would you like PhreeBooks to create the database?');
  define('DATABASE_CONNECTION', 'Persistent Connection');
  define('DATABASE_CONNECTION_INSTRUCTION', 'Would you like to enable persistent database connections?  Click \'no\' if you are unsure.');
  define('DATABASE_SESSION', 'Database Sessions');
  define('DATABASE_SESSION_INSTRUCTION', 'Do you want store your sessions in your database?  Click \'yes\' if you are unsure.');
  define('CACHE_TYPE', 'SQL Cache Method');
  define('CACHE_TYPE_INSTRUCTION', 'Select the method to use for SQL caching.');
  define('SQL_CACHE', 'Session/SQL Cache Directory');
  define('SQL_CACHE_INSTRUCTION', 'Enter the directory to used for File-based SQL Caching.');



  define('REASON_TABLE_ALREADY_EXISTS','Cannot create table %s because it already exists');
  define('REASON_TABLE_DOESNT_EXIST','Cannot drop table %s because it does not exist.');
  define('REASON_CONFIG_KEY_ALREADY_EXISTS','Cannot insert configuration_key "%s" because it already exists');
  define('REASON_COLUMN_ALREADY_EXISTS','Cannot ADD column %s because it already exists.');
  define('REASON_COLUMN_DOESNT_EXIST_TO_DROP','Cannot DROP column %s because it does not exist.');
  define('REASON_COLUMN_DOESNT_EXIST_TO_CHANGE','Cannot CHANGE column %s because it does not exist.');
  define('REASON_PRODUCT_TYPE_LAYOUT_KEY_ALREADY_EXISTS','Cannot insert prod-type-layout configuration_key "%s" because it already exists');
  define('REASON_INDEX_DOESNT_EXIST_TO_DROP','Cannot drop index %s on table %s because it does not exist.');
  define('REASON_PRIMARY_KEY_DOESNT_EXIST_TO_DROP','Cannot drop primary key on table %s because it does not exist.');
  define('REASON_INDEX_ALREADY_EXISTS','Cannot add index %s to table %s because it already exists.');
  define('REASON_PRIMARY_KEY_ALREADY_EXISTS','Cannot add primary key to table %s because a primary key already exists.');
  define('REASON_NO_PRIVILEGES','User %s@%s does not have %s privileges to database.');

?>