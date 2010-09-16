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
//  Path: /modules/install/language/en_us/import_export_list.php
//

// FOR LANGUAGE TRANSLATION ONLY MODIFY THE VALUES FOR INDEXES title AND description

/* This file holds the list of import/export configuration to insert during setup. */
$import_export_list = array();

$import_export_list[] = array(
  'group_id' => 'ar',
  'custom' => '0',
  'title' => 'Customer List',
  'description' => 'Customer records including shipping and billing addresses (max 5 of each)',
  'table_name' => TABLE_CONTACTS,
  'primary_key_field' => 'short_name',
  'criteria' => 'a:1:{i:0;a:5:{s:6:"cfield";s:4:"type";s:5:"ctype";s:9:"all_range";s:4:"crit";s:5:"range";s:4:"from";s:1:"c";s:2:"to";s:1:"c";}}',
  'options' => 'a:6:{s:9:"delimiter";s:5:"comma";s:9:"qualifier";s:12:"double_quote";s:16:"import_file_name";N;s:12:"imp_headings";s:1:"1";s:16:"export_file_name";s:13:"customers.txt";s:12:"exp_headings";s:1:"1";}');

$import_export_list[] = array(
  'group_id' => 'ap',
  'custom' => '0',
  'title' => 'Vendor List',
  'description' => 'Vendor records including shipping and billing addresses (max 5 of each)',
  'table_name' => TABLE_CONTACTS,
  'primary_key_field' => 'short_name',
  'criteria' => 'a:1:{i:0;a:5:{s:6:"cfield";s:4:"type";s:5:"ctype";s:9:"all_range";s:4:"crit";s:5:"range";s:4:"from";s:1:"v";s:2:"to";s:1:"v";}}',
  'options' => 'a:6:{s:9:"delimiter";s:5:"comma";s:9:"qualifier";s:12:"double_quote";s:16:"import_file_name";N;s:12:"imp_headings";s:1:"1";s:16:"export_file_name";s:11:"vendors.txt";s:12:"exp_headings";s:1:"1";}');

$import_export_list[] = array(
  'group_id' => 'hr',
  'custom' => '0',
  'title' => 'Employee List',
  'description' => 'Employee records including billing addresses',
  'table_name' => TABLE_CONTACTS,
  'primary_key_field' => 'short_name',
  'criteria' => 'a:1:{i:0;a:5:{s:6:"cfield";s:4:"type";s:5:"ctype";s:9:"all_range";s:4:"crit";s:5:"range";s:4:"from";s:1:"e";s:2:"to";s:1:"e";}}',
  'options' => 'a:6:{s:9:"delimiter";s:5:"comma";s:9:"qualifier";s:12:"double_quote";s:16:"import_file_name";N;s:12:"imp_headings";N;s:16:"export_file_name";s:0:"";s:12:"exp_headings";N;}');

$import_export_list[] = array(
  'group_id' => 'inv',
  'custom' => '0',
  'title' => 'Inventory',
  'description' => 'Inventory records including custom fields',
  'table_name' => TABLE_INVENTORY,
  'primary_key_field' => 'sku',
  'criteria' => 'a:1:{i:0;a:5:{s:6:"cfield";s:3:"sku";s:5:"ctype";s:9:"all_range";s:4:"crit";s:3:"all";s:4:"from";s:0:"";s:2:"to";s:0:"";}}',
  'options' => 'a:6:{s:9:"delimiter";s:5:"comma";s:9:"qualifier";s:12:"double_quote";s:16:"import_file_name";N;s:12:"imp_headings";N;s:16:"export_file_name";s:0:"";s:12:"exp_headings";N;}');

?>