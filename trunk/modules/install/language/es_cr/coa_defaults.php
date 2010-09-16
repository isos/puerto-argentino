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
//  Path: /modules/install/language/es_cr/coa_defaults.php
//

  define('SAVE_STORE_SETTINGS', 'Salve Configuración Predeterminada'); //this comes before TEXT_MAIN
  define('TEXT_MAIN', "Esta sección del instalador de  PhreeBooks&trade; le ayudará a configurar las cuentas predeterminadas de la compañía. Más adelante podrá cambiar esta configuración a través del menú Compañía.  Haga su selección y presione <em>".SAVE_STORE_SETTINGS."</em> para continuar. <br /><br />NOTA: PhreeBooks Intentará acertar las cuentas predeterminadas de inventario en este paso.  Se recomienda que verifique esta configuración a través del menú <em>Compañía</em> antes de crear códigos de inventario.");
  define('TEXT_PAGE_HEADING', 'PhreeBooks&trade; Instalación - Cuentas Predeterminadas');
  define('STORE_INFORMATION', 'Información de Cuentas Predeterminadas');
  define('COA_REFERENCE','Referencia de Cuadro de Cuentas:');

// for best guess of accounts to pre-set the account pull downs
  define('TEXT_INVENTORY','inventario');
  define('TEXT_PAYABLE','por pagar');
  define('TEXT_PURCHASE_DISCOUNT','descuento por compras');
  define('ORD_FREIGHT','flete');
  define('TEXT_CHECKING','efectivo');
  define('TEXT_SALES','ventas');
  define('TEXT_RECEIVABLES','por cobrar');
  define('TEXT_SALES_DISCOUNT','descuento de ventas');
  define('TEXT_COGS','costo de ventas');

  define('STORE_DEFAULT_INV_ACCT','Cuenta Predeterminada de Compra de Inventario');
  define('STORE_DEFAULT_INV_ACT_INSTRUCTION','Seleccione una cuenta para ser usada para el inventario de códigos comprado a proveedores.  Esta cuenta debe ser del tipo \'Inventario\'.');
  define('STORE_DEFAULT_AP_PURCH','Cuenta Predeterminada de Compras');
  define('STORE_DEFAULT_AP_PURCH_INSTRUCTION','Seleccione una cuenta para ser usada para el inventario de códigos comprado a proveedores.  Esta cuenta debe ser una cuenta del tipo \'Cuentas por Pagar\'.');
  define('STORE_DEFAULT_AP_DISC','Cuenta Predeterminada Descuento sobre Compras');
  define('STORE_DEFAULT_AP_DISC_INSTRUCTION','Seleccione una cuenta para ser usada para los descuentos recibidos por pagos hechos a los proveedores.  Esta cuenta debe ser una cuenta del tipo \'Ingreso\'.');
  define('STORE_DEFAULT_AP_FRT','Cuenta Predeterminada Flete sobre Compras ');
  define('STORE_DEFAULT_AP_FRT_INSTRUCTION','Seleccione una cuenta para ser usada para los pagos de fletes sobre compras de inventario.  Esta cuenta debe ser una cuenta del tipo \'Gastos\'.');
  define('STORE_DEFAULT_AP_PMT','Cuenta Predeterminada Pagos a Proveedor');
  define('STORE_DEFAULT_AP_PMT_INSTRUCTION','Seleccione una cuenta para ser usada para los pagos a proveedores por facturas de inventario.  Esta cuenta debe ser una cuenta del tipo \'Efectivo\'.');
  define('STORE_DEFAULT_AR_SALES','Cuenta Predeterminada Ventas a Clientes');
  define('STORE_DEFAULT_AR_SALES_INSTRUCTION','Seleccione una cuenta para ser usada para el ingreso de las ventas de contado a clientes.  Esta cuenta debe ser una cuenta del tipo \'Ingresos\'.');
  define('STORE_DEFAULT_AR_RCV','Cuenta Predeterminada Cuentas por Cobrar');
  define('STORE_DEFAULT_AR_RCV_INSTRUCTION','Seleccione una cuenta para ser usada para el ingreso de las facturas de ventas a crédito a los clientes.  Esta cuenta debe ser una cuenta del tipo \'Cuentas por Cobrar\'.');
  define('STORE_DEFAULT_AR_DISC','Cuenta Predeterminada Descuentos a Clientes');
  define('STORE_DEFAULT_AR_DISC_INSTRUCTION','Seleccione una cuenta para ser usada para los descuentos a clientes por promociones, pago adelantado, etc. Esta cuenta debe ser una cuenta del tipo \'Ingresos\'.');
  define('STORE_DEFAULT_AR_FRT','Cuenta Predeterminada Fletes sobre Ventas a Clientes');
  define('STORE_DEFAULT_AR_FRT_INSTRUCTION','Seleccione una cuenta para ser usada para los fletes asociados con envíos de mercadería a los clientes.  Esta cuenta debe ser una cuenta del tipo \'Ingresos\'.');
  define('STORE_DEFAULT_AR_RCPT','Cuenta Predeterminada Recibo de Dinero por Ventas a Clientes');
  define('STORE_DEFAULT_AR_RCPT_INSTRUCTION','Seleccione una cuenta para ser usada para los recibos de dinero de los clientes.  Esta cuenta debe ser una cuenta del tipo \'Efectivo\'.');

?>
