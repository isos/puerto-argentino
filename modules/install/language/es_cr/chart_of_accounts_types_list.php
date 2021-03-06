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
//  Path: /modules/install/language/es_cr/chart_of_accounts_types_list.php
//


// FOR LANGUAGE TRANSLATION ONLY MODIFY THE VALUES FOR INDEXES description

/* This file holds the list of import/export configuration to insert during setup. */
define('COA_00_DESC','Efectivo');
define('COA_02_DESC','Cuentas por Cobrar');
define('COA_04_DESC','Inventario');
define('COA_06_DESC','Otros Activo Circulante');
define('COA_08_DESC','Activo Fijo');
define('COA_10_DESC','Depreciación Acumulada');
define('COA_12_DESC','Otros Activos');
define('COA_20_DESC','Cuentas por Pagar');
define('COA_22_DESC','Otros Pasivos a Corto Plazo');
define('COA_24_DESC','Pasivo a Largo Plazo');
define('COA_30_DESC','Ingresos');
define('COA_32_DESC','Costo de Ventas');
define('COA_34_DESC','Gastos');
define('COA_40_DESC','Patrimonio - No Cierra');
define('COA_42_DESC','Patrimonio - Cierra');
define('COA_44_DESC','Patrimonio - Utilidades No Distribuidas');

$chart_of_accounts_types_list = array();

$chart_of_accounts_types_list[] = array(
  'id' => 0,
  'description' => COA_00_DESC,
  'asset' => '1');
$chart_of_accounts_types_list[] = array(
  'id' => 2,
  'description' => COA_02_DESC,
  'asset' => '1');
$chart_of_accounts_types_list[] = array(
  'id' => 4,
  'description' => COA_04_DESC,
  'asset' => '1');
$chart_of_accounts_types_list[] = array(
  'id' => 6,
  'description' => COA_06_DESC,
  'asset' => '1');
$chart_of_accounts_types_list[] = array(
  'id' => 8,
  'description' => COA_08_DESC,
  'asset' => '1');
$chart_of_accounts_types_list[] = array(
  'id' => 10,
  'description' => COA_10_DESC,
  'asset' => '0');
$chart_of_accounts_types_list[] = array(
  'id' => 12,
  'description' => COA_12_DESC,
  'asset' => '1');
$chart_of_accounts_types_list[] = array(
  'id' => 20,
  'description' => COA_20_DESC,
  'asset' => '0');
$chart_of_accounts_types_list[] = array(
  'id' => 22,
  'description' => COA_22_DESC,
  'asset' => '0');
$chart_of_accounts_types_list[] = array(
  'id' => 24,
  'description' => COA_24_DESC,
  'asset' => '0');
$chart_of_accounts_types_list[] = array(
  'id' => 30,
  'description' => COA_30_DESC,
  'asset' => '0');
$chart_of_accounts_types_list[] = array(
  'id' => 32,
  'description' => COA_32_DESC,
  'asset' => '1');
$chart_of_accounts_types_list[] = array(
  'id' => 34,
  'description' => COA_34_DESC,
  'asset' => '1');
$chart_of_accounts_types_list[] = array(
  'id' => 40,
  'description' => COA_40_DESC,
  'asset' => '0');
$chart_of_accounts_types_list[] = array(
  'id' => 42,
  'description' => COA_42_DESC,
  'asset' => '0');
$chart_of_accounts_types_list[] = array(
  'id' => 44,
  'description' => COA_44_DESC,
  'asset' => '0');

?>
