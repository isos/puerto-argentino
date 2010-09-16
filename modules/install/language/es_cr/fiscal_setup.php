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
//  Path: /modules/install/language/es_cr/fiscal_setup.php
//

  define('SAVE_STORE_SETTINGS', 'Salve Configuración de Año Fiscal'); //this comes before TEXT_MAIN
  define('SKIP_STORE_SETTINGS', 'Año Fiscal Ya Existe - Brincando'); //this comes before TEXT_MAIN
  define('TEXT_MAIN', "Esta sección de PhreeBooks&trade; le ayudará a definir el año fiscal de la compañía.  Luego podrá cambiar esta configuración en el menú Contabilidad.  Haga su selección y presione<em>".SAVE_STORE_SETTINGS."</em> para continuar.  Si ya existe un año fiscal en su base de datos, en su lugar aparecerá el boton <em>".SKIP_STORE_SETTINGS."</em>. Presione este botón para brincarse este paso.");
  define('TEXT_FISCAL_YEAR_EXISTS','Años fiscales del <b>%d</b> al <b>%d</b> ya están en la base de datos, presione <em>' . SKIP_STORE_SETTINGS . '</em> para continuar.');
  define('TEXT_PAGE_HEADING', 'PhreeBooks&trade; Instalación - Configuración del Año Fiscal');
  define('STORE_INFORMATION', 'Información del Año Fiscal');

  define('STORE_DEFAULT_PERIOD', 'Primer Período Contable');
  define('STORE_DEFAULT_PERIOD_INSTRUCTION', 'Seleccione el primer mes de su primer período contable.  Inicialmente, PhreeBooks fijará el primer día del mes seleccionado como período 1.');

  define('STORE_DEFAULT_FY', 'Año Fiscal');
  define('STORE_DEFAULT_FY_INSTRUCTION', 'Seleccione el año de su primer año fiscal.  El mes seleccionado anteriormente y esta selección de año será la primera fecha a partir de la cual se pueden grabar registros contables.');

  define('TEXT_JAN','Enero');
  define('TEXT_FEB','Febrero');
  define('TEXT_MAR','Marzo');
  define('TEXT_APR','Abril');
  define('TEXT_MAY','Mayo');
  define('TEXT_JUN','Junio');
  define('TEXT_JUL','Julio');
  define('TEXT_AUG','Augosto');
  define('TEXT_SEP','Septiembre');
  define('TEXT_OCT','Octubre');
  define('TEXT_NOV','Noviembre');
  define('TEXT_DEC','Diciembre');
  
  $period_values = array();
  $period_values[] = array('id' => '01', 'text' => TEXT_JAN);
  $period_values[] = array('id' => '02', 'text' => TEXT_FEB);
  $period_values[] = array('id' => '03', 'text' => TEXT_MAR);
  $period_values[] = array('id' => '04', 'text' => TEXT_APR);
  $period_values[] = array('id' => '05', 'text' => TEXT_MAY);
  $period_values[] = array('id' => '06', 'text' => TEXT_JUN);
  $period_values[] = array('id' => '07', 'text' => TEXT_JUL);
  $period_values[] = array('id' => '08', 'text' => TEXT_AUG);
  $period_values[] = array('id' => '09', 'text' => TEXT_SEP);
  $period_values[] = array('id' => '10', 'text' => TEXT_OCT);
  $period_values[] = array('id' => '11', 'text' => TEXT_NOV);
  $period_values[] = array('id' => '12', 'text' => TEXT_DEC);


  $fiscal_years = array();
  $fiscal_years[] = array('id' => '2005', 'text' => '2005');
  $fiscal_years[] = array('id' => '2006', 'text' => '2006');
  $fiscal_years[] = array('id' => '2007', 'text' => '2007');
  $fiscal_years[] = array('id' => '2008', 'text' => '2008');
  $fiscal_years[] = array('id' => '2009', 'text' => '2009');
  $fiscal_years[] = array('id' => '2010', 'text' => '2010');
  $fiscal_years[] = array('id' => '2011', 'text' => '2011');
  $fiscal_years[] = array('id' => '2012', 'text' => '2012');
  $fiscal_years[] = array('id' => '2013', 'text' => '2013');
  $fiscal_years[] = array('id' => '2014', 'text' => '2014');
  $fiscal_years[] = array('id' => '2015', 'text' => '2015');
  $fiscal_years[] = array('id' => '2016', 'text' => '2016');
  $fiscal_years[] = array('id' => '2017', 'text' => '2017');
  $fiscal_years[] = array('id' => '2018', 'text' => '2018');
?>
