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
//  Path: /modules/reportwriter/language/es_cr/classes/entry_builder.php
//

// Release 1.8 language changes
define('TEXT_SO_POST_DATE','Fecha Órden de Venta');
define('RW_EB_PAYMENT_DETAIL','Detalle de Recibo de Dinero');

//
define('RW_EB_RECORD_ID','Identificación de Registro');
define('RW_EB_JOURNAL_ID','Identificación de Diario');
define('RW_EB_STORE_ID','Identificación de Tienda');
define('RW_EB_JOURNAL_DESC','Descripción');
define('RW_EB_CLOSED','Cerrado');
define('RW_EB_FRT_TOTAL','Monto de Flete');
define('RW_EB_FRT_CARRIER','Transportista');
define('RW_EB_FRT_SERVICE','Servicio de Flete');
define('RW_EB_TERMS','Términos');
define('RW_EB_INV_DISCOUNT','Descuento de Factura');
define('RW_EB_SALES_TAX','Impuesto de Ventas');
define('RW_EB_TAX_AUTH','Autoridad de Impuesto');
define('RW_EB_TAX_DETAILS','Detalles del Impuesto');
define('RW_EB_INV_SUBTOTAL','Subtotal de la Factura');
define('RW_EB_INV_TOTAL','Monto de la Factura');
define('RW_EB_CUR_CODE','Código de la Moneda');
define('RW_EB_CUR_EXC_RATE','Tipo de Cambio de la Moneda');
define('RW_EB_SO_NUM','Número de la Órden de Venta');
define('RW_EB_INV_NUM','Número de Factura');
define('RW_EB_PO_NUM','Número de Órden de Compra');
define('RW_EB_SALES_REP','Vendedor');
define('RW_EB_AR_ACCT','Cuenta por Cobrar');
define('RW_EB_BILL_ACCT_ID','Cobro Identificación de Cuenta');
define('RW_EB_BILL_ADD_ID','Cobro Identificación de Dirección');
define('RW_EB_BILL_PRIMARY_NAME','Cobro Nombre Principal');
define('RW_EB_BILL_CONTACT','Cobro Contacto');
define('RW_EB_BILL_ADDRESS1','Cobro Dirección Línea 1');
define('RW_EB_BILL_ADDRESS2','Cobro Dirección Línea 2');
define('RW_EB_BILL_CITY','Cobro Ciudad');
define('RW_EB_BILL_STATE','Cobro Provincia/Estado');
define('RW_EB_BILL_ZIP','Cobro Código Postal');
define('RW_EB_BILL_COUNTRY','Cobro País');
define('RW_EB_BILL_TELE1','Cobro Teléfono 1');
define('RW_EB_BILL_TELE2','Cobro Teléfono 2');
define('RW_EB_BILL_FAX','Cobro Fax');
define('RW_EB_BILL_TELE4','Cobro Celular');
define('RW_EB_BILL_EMAIL','Cobro Correo Electrónico');
define('RW_EB_BILL_WEBSITE','Cobro Sitio Internet');
define('RW_EB_SHIP_ACCT_ID','Envío Identificación de Cuenta');
define('RW_EB_SHIP_ADD_ID','Envío Identificación de Dirección');
define('RW_EB_SHIP_PRIMARY_NAME','Envío Nombre Principal');
define('RW_EB_SHIP_CONTACT','Envío Contacto');
define('RW_EB_SHIP_ADDRESS1','Envío Dirección Línea 1');
define('RW_EB_SHIP_ADDRESS2','Envío Dirección Línea 2');
define('RW_EB_SHIP_CITY','Envío Ciudad');
define('RW_EB_SHIP_STATE','Envío Provincia/Estado');
define('RW_EB_SHIP_ZIP','Envío Código Postal');
define('RW_EB_SHIP_COUNTRY','Envío País');
define('RW_EB_SHIP_TELE1','Envío Teléfono 1');
define('RW_EB_SHIP_TELE2','Envío Teléfono 2');
define('RW_EB_SHIP_FAX','Envío Fax');
define('RW_EB_SHIP_TELE4','Envío Celular');
define('RW_EB_SHIP_EMAIL','Envío Correo Electrónico');
define('RW_EB_SHIP_WEBSITE','Envío Sitio Internet');
define('RW_EB_CUSTOMER_ID','Identificación de Cliente');
define('RW_EB_ACCOUNT_NUMBER','Número de Cuenta');
define('RW_EB_GOV_ID_NUMBER','Cédula Jurídica');
define('RW_EB_SHIP_DATE','Envío Fecha');
define('RW_EB_TOTAL_PAID','Monto Pagado');
define('RW_EB_PAYMENT_DATE','Fecha');
define('RW_EB_PAYMENT_DUE_DATE','Vence');
define('RW_EB_PAYMENT_METHOD','Método de Pago');
define('RW_EB_PAYMENT_REF','Referencia de Recibo de Dinero');
define('RW_EB_PAYMENT_DEP_ID','Depósito');
define('RW_EB_BALANCE_DUE','Saldo Actual');

// Data table defines
define('RW_EB_SO_DESC','order_description');
define('RW_EB_SO_QTY','order_qty');
define('RW_EB_SO_TOTAL_PRICE','order_price');
define('RW_EB_SO_UNIT_PRICE','order_unit_price');
define('RW_EB_SO_SKU','order_sku');
define('RW_EB_SO_SERIAL_NUM','order_serial_num');
define('RW_EB_SHIPPED_PRIOR','qty_shipped_prior');
define('RW_EB_BACKORDER_QTY','qty_on_backorder');
define('RW_EB_INV_DESC','invoice_description');
define('RW_EB_INV_QTY','invoice_qty');
define('RW_EB_INV_TOTAL_PRICE','invoice_full_price');
define('RW_EB_INV_UNIT_PRICE','invoice_unit_price');
define('RW_EB_INV_DISCOUNT','invoice_discount');
define('RW_EB_INV_PRICE','invoice_price');
define('RW_EB_INV_SKU','invoice_sku');
define('RW_EB_INV_SERIAL_NUM','invoice_serial_num');

?>
