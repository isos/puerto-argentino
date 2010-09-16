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
//  Path: /modules/install/charts/CR_Corp_General.php
//

// Cuadro de Cuentas para Costa Rica Sociedad Anónima Simple
$chart_description = "CR - Negocio en General - Cuadro de Cuentas (Sociedad Anónima y Corporaciones)";
$chart_array = array();

$chart_array[] = array('1060','Cuenta de Banco','0');
$chart_array[] = array('1065','Caja Chica','0');
$chart_array[] = array('1200','Cuentas por Cobrar','2');
$chart_array[] = array('1205','Provisión Incobrables','2');
$chart_array[] = array('1500','Inventario','4');
$chart_array[] = array('1800','Capital Social','8');
$chart_array[] = array('1820','Mobiliario y Equipo','8');
$chart_array[] = array('1825','Depr. Acum. Mob. y Equip.','8');
$chart_array[] = array('1840','Vehículos','8');
$chart_array[] = array('1845','Depr. Acum. Vehículos','8');
$chart_array[] = array('2100','Cuentas por Pagar','20');
$chart_array[] = array('2110','Imp. Renta por pagar','22');
$chart_array[] = array('2120','Imp. Municipal por pagar','22');
$chart_array[] = array('2130','Imp. Franquicia por Pagar','22');
$chart_array[] = array('2140','Imp. Sobre Activos por Pagar','22');
$chart_array[] = array('2150','Imp. Ventas por Pagar','22');
$chart_array[] = array('2210','Planillas por Pagar','22');
$chart_array[] = array('2220','Cargas Sociales','22');
$chart_array[] = array('2230','Feriados por Pagar','22');
$chart_array[] = array('2240','Vacaciones por Pagar','22');
$chart_array[] = array('2310','Prestaciones por Pagar','22');
$chart_array[] = array('2320','Riesgos Profesionales por Pagar','22');
$chart_array[] = array('2330','CCSS por Pagar','22');
$chart_array[] = array('2340','Aguinaldos por Pagar','22');
$chart_array[] = array('2370','Embargos por Pagar','22');
$chart_array[] = array('2380','Contribuciones por Pagar','22');
$chart_array[] = array('2620','Préstamos Bancarios','24');
$chart_array[] = array('2680','Préstamos de Accionistas','24');
$chart_array[] = array('3300','Capital Social','24');
$chart_array[] = array("3400","Acciones Comunes","40");
$chart_array[] = array("3500","Aporte de Accionistas","40");
$chart_array[] = array("3600","Dividendos Pagados","42");
$chart_array[] = array("3800","Ganancias Retenidas","44");
$chart_array[] = array('4010','Ventas','30');
$chart_array[] = array('4400','Otros Ingresos','30');
$chart_array[] = array('4430','Ingresos por Fletes y Manejo','30');
$chart_array[] = array('4440','Intereses','30');
$chart_array[] = array('4450','Ganancia Cambiaria','30');
$chart_array[] = array('5010','Costo de Bienes Vendidos','32');
$chart_array[] = array('5100','Flete','32');
$chart_array[] = array('5400','Planillas - Salarios','34');
$chart_array[] = array('5410','Planillas - Cargas Sociales','34');
$chart_array[] = array('5420','Planillas - Horas Extra','34');
$chart_array[] = array('5430','Planillas - Feriados','34');
$chart_array[] = array('5440','Planillas - Vacaciones','34');
$chart_array[] = array('5450','Planillas - Prestaciones','34');
$chart_array[] = array('5460','Planillas - CCSS','34');
$chart_array[] = array('5470','Planillas - Aguinaldos','34');
$chart_array[] = array('5480','Planillas - Riesgos Profesionales','34');
$chart_array[] = array('5510','Impuesto - Sobre la Renta','34');
$chart_array[] = array('5520','Impuesto - Municipal','34');
$chart_array[] = array('5530','Impuesto - Territorial','34');
$chart_array[] = array('5540','Impuesto - Sobre Activos','34');
$chart_array[] = array('5550','Impuesto - Franquicia','34');
$chart_array[] = array('5600','Gastos Generales y Admin','34');
$chart_array[] = array('5610','Contadores y Abogados','34');
$chart_array[] = array('5615','Publicidad y Promociones','34');
$chart_array[] = array('5620','Incobrables','34');
$chart_array[] = array('5660','Gasto de Amortización','34');
$chart_array[] = array('5685','Seguros','34');
$chart_array[] = array('5690','Intereses y Gastos Bancarios','34');
$chart_array[] = array('5700','Gastos de Oficina','34');
$chart_array[] = array('5760','Alquileres','34');
$chart_array[] = array('5765','Reparación y Mantenimiento','34');
$chart_array[] = array('5780','Teléfono','34');
$chart_array[] = array('5785','Viajes y Entretenimiento','34');
$chart_array[] = array('5790','Gastos Servicios Públicos','34');
$chart_array[] = array('5795','Permisos','34');
$chart_array[] = array('5800','Licencias','34');
$chart_array[] = array('5810','Pérdida Cambiaria','34');

?>
