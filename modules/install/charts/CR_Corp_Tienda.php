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
//  Path: /modules/install/charts/CR_Corp_Tienda.php
//

// Cuadro de cuentas Costa Rica tienda simple Sociedad Anónima
$chart_description = "CR - Tienda Simple - Cuadro de Cuentas (Sociedades Anónimas y Corporaciones)";
$chart_array = array();

$chart_array[] = array("1000","Efectivo","0");
$chart_array[] = array("1020","Cuenta de Banco","0");
$chart_array[] = array("1100","Cuentas por Cobrar","2");
$chart_array[] = array("1150","Provisión Incobrables","2");
$chart_array[] = array("1200","Inventario","4");
$chart_array[] = array("1400","Gastos Prepagados","6");
$chart_array[] = array("1500","Mobiliario y Equipo","8");
$chart_array[] = array("1900","Depr. Acum Prop y Equipo","10");
$chart_array[] = array("2000","Cuentas por Pagar","20");
$chart_array[] = array("2310","Impuesto de Ventas por Pagar","22");
$chart_array[] = array("2312","Impuesto de Ventas por Pagar","22");
$chart_array[] = array("2320","Deducciones por Pagar","22");
$chart_array[] = array("2330","Planillas por Pagar","22");
$chart_array[] = array("2340","Cargas Sociales por Pagar","22");
$chart_array[] = array("2350","Aguinaldos por Pagar","22");
$chart_array[] = array("2360","Prestaciones por Pagar","22");
$chart_array[] = array("2370","CCSS por Pagar","22");
$chart_array[] = array("2380","Impuesto de la Renta por Pagar","22");
$chart_array[] = array("2400","Depósitos de Clientes","22");
$chart_array[] = array("2500","Porc. Corr. Deuda LP","22");
$chart_array[] = array("2700","Pasivo LP No Corr.","22");
$chart_array[] = array("3100","Acciones Comunes","40");
$chart_array[] = array("3200","Aporte de Accionistas","40");
$chart_array[] = array("3500","Dividendos Pagados","42");
$chart_array[] = array("3800","Ganancia Retenida","44");
$chart_array[] = array("4000","Ingreso por Ventas","30");
$chart_array[] = array("4100","Intereses de Inversiones","30");
$chart_array[] = array("4200","Intereses Cobrados Clientes","30");
$chart_array[] = array("4300","Otro Ingresos","30");
$chart_array[] = array("4900","Descuentos por Ventas","30");
$chart_array[] = array("5000","Costo de Venas","32");
$chart_array[] = array("5100","Costo de Ventas Fletes","32");
$chart_array[] = array("5400","Costo de ventas Planillas","32");
$chart_array[] = array("5900","Ajustes de Inventario","32");
$chart_array[] = array("6000","Planillas","34");
$chart_array[] = array("6050","Gasto CCSS","34");
$chart_array[] = array("6100","Gasto Cargas Sociales","34");
$chart_array[] = array("6150","Gasto Incobrables","34");
$chart_array[] = array("6200","Impuesto de Renta","34");
$chart_array[] = array("6250","Otros Impuestos","34");
$chart_array[] = array("6300","Alquileres","34");
$chart_array[] = array("6350","Mantenimiento y Reparación","34");
$chart_array[] = array("6400","Servicios Publicos","34");
$chart_array[] = array("6450","Suministros de Oficina","34");
$chart_array[] = array("6500","Teléfono","34");
$chart_array[] = array("6550","Otros Gastos Oficina","34");
$chart_array[] = array("6600","Publicidad","34");
$chart_array[] = array("6650","Comisiones","34");
$chart_array[] = array("6700","Gasto Franquicia","34");
$chart_array[] = array("6750","Alquiler de Equipo","34");
$chart_array[] = array("6800","Flete","34");
$chart_array[] = array("6850","Service Charge Expense","34");
$chart_array[] = array("6900","Gasto Descuento por Compras","34");
$chart_array[] = array("6950","Seguros","34");
$chart_array[] = array("7000","Faltante/Sobrante Caja","34");
$chart_array[] = array("7050","Gasto Depreciación","34");
$chart_array[] = array("7100","Gan/Pér Venta de Activos","34");

?>
