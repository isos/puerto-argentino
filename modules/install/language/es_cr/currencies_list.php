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
//  Path: /modules/install/language/es_cr/currencies_list.php
//

// FOR LANGUAGE TRANSLATION ONLY MODIFY THE VALUES FOR INDEXES title

/* This file holds the list of import/export configuration to insert during setup. */
$today = date('Y-m-d H:i:s', time());
$currencies_list = array();

$currencies_list[] = array(
  'title' => 'Colones ₡',
  'code' => 'CRC',
  'symbol_left' => '₡',
  'symbol_right' => '',
  'decimal_point' => '.',
  'thousands_point' => ',',
  'decimal_places' => '2',
  'decimal_precise' => '2', 
  'value' => 1.00000000,
  'last_updated' => $today);

$currencies_list[] = array(
  'title' => 'US Dolar',
  'code' => 'USD',
  'symbol_left' => '$',
  'symbol_right' => '',
  'decimal_point' => '.',
  'thousands_point' => ',',
  'decimal_places' => '2',
  'decimal_precise' => '2', 
  'value' => 0.00000000,
  'last_updated' => $today);

$currencies_list[] = array(
  'title' => 'Euro',
  'code' => 'EUR',
  'symbol_left' => '',
  'symbol_right' => 'EUR',
  'decimal_point' => '.',
  'thousands_point' => ',',
  'decimal_places' => '2',
  'decimal_precise' => '2',
  'value' => 0.00000000,
  'last_updated' => $today);


?>
