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
//  Path: /modules/orders/language/es_cr/language.php
//

/********************* Release R2.0 additions ***********************/
//define('ORD_ENABLE_LINE_ITEM_BAR_CODE',0); // 0 - turned off; 1 - turned on
//define('ORD_BAR_CODE_LENGTH',12);
define('ORD_ERROR_NOT_CUR_PERIOD','¡Sus permisos no le permiten hacer registros a otro período que no sea el actual!');
define('ORD_ERROR_DEL_NOT_CUR_PERIOD','¡Sus permisos no le permiten borrar un registro de otro período que no sea el período actual!');

/********************* Release R1.9 additions ***********************/
define('ORD_DISCOUNT_GL_ACCT','Cuenta De Descuento');
define('ORD_FREIGHT_GL_ACCT','Cuenta De Flete');
define('ORD_INV_STOCK_LOW','No hay suficiente inventario para este código.');
define('ORD_INV_STOCK_BAL','El número de unidades en inventario es: ');
define('ORD_INV_OPEN_POS','Las siguientes Ordenes de Compra están pendientes:');
define('ORD_INV_STOCK_STATUS','OC: %s Cant: %s Vence: %s');
define('ORD_JS_SKU_NOT_UNIQUE','No se puede cargar ese código.  La búsqueda no dió como resultado un código único o se encontraron múltiples artículos conteniendo el código.');
define('ORD_JS_NO_CID','La información del Contacto debe cargarse en este formulario antes de que se puedan cargar las propiedades.');

/********************* Release R1.7 additions *************************/
define('POPUP_BAR_CODE_TITLE','Escane Código');
define('ORD_BAR_CODE_INTRO','Digite cantidad y escane el código.');
define('TEXT_UPC_CODE','Escane Código');

/********************************************************************/

// General
define('ORD_ADD_UPDATE', 'Nuevo/Actualice');
define('ORD_AP_ACCOUNT', 'Cuenta por Pagar');
define('ORD_AR_ACCOUNT', 'Cuenta por Cobrar');
define('ORD_CASH_ACCOUNT', 'Cuenta Efectivo');
define('ORD_CLOSED','¿Vencido?');
define('ORD_COPY_BILL','Copie-->');
define('ORD_CUSTOMER_NAME','Cliente');
define('ORD_DELETE_ALERT','¿Está seguro que quiere borrar esta órden?');
define('ORD_DELIVERY_DATES', 'Fecha Entrega');
define('ORD_DISCOUNT_PERCENT','Descuento (%)');
define('ORD_DROP_SHIP', 'Envío a Terceros');
define('ORD_EXPECTED_DATES','Fecha Esperada de Ingreso - ');
define('ORD_FREIGHT', 'Flete');
define('ORD_FREIGHT_ESTIMATE', 'Flete Estimado');
define('ORD_FREIGHT_SERVICE', 'Servicio');
define('ORD_INVOICE_TOTAL', 'Total Factura');
define('ORD_MANUAL_ENTRY', 'Digitado Manual');
define('ORD_NA','N/A');
define('ORD_NEW_DELIVERY_DATES', 'Nueva Fecha de Ingreso');
define('ORD_PAID', '¿Cancelado?');
define('ORD_PURCHASE_TAX', 'Impuesto de Compra');
define('ORD_ROW_DELETE_ALERT','¿Está seguro que quiere borrar este renglón?');
define('ORD_SALES_TAX', 'Impuesto de Ventas');
define('ORD_SHIP_CARRIER', 'Transportista');
define('ORD_SHIP_TO', 'Envíe A:');
define('ORD_SHIPPED', 'Enviado');
define('ORD_SUBTOTAL', 'Subtotal');
define('ORD_TAX_RATE', 'IV');
define('ORD_TAXABLE', 'Gravable');
define('ORD_VENDOR_NAME','Proveedor');
define('ORD_VOID_SHIP','Anule Envío');
define('ORD_WAITING_FOR_INVOICE','Esperando Factura');
define('ORD_WAITING','¿Esperando?');
define('ORD_SO_INV_MESSAGE','Deje en blanco y el sistema le asignará el número.');
define('ORD_CONVERT_TO_SO_INV','Convierta a OV/Factura');
define('ORD_CONVERT_TO_SO','Convierta a OV ');
define('ORD_CONVERT_TO_INV','Convierta a Factura ');
define('ORD_PO_MESSAGE','Deje en blanco y el sistema le asignará el número.');
define('ORD_CONVERT_TO_SO_INV','Convierta a OV/Factura');
define('ORD_CONVERT_TO_PO','Genere Automáticamente Órden de Compra ');

// Javascript Messages
define('ORD_JS_RECUR_NO_INVOICE','Para una transacción memorizada, es necesario definir un número de factura inicial.  PhreeBooks incrementará el número con cada nueva transacción.');
define('ORD_JS_RECUR_ROLL_REQD','Esta es una transacción memorizada. ¿Quiere actualizar transacciones futuras también? (Presione Cancele para actualizar solo esta transacción)');
define('ORD_JS_RECUR_DEL_ROLL_REQD','Esta es una transacción memorizada. ¿Quiere borrar las transacciones futuras también? (Presione Cancele para borrar solamente esta transacción)');
define('ORD_JS_WAITING_FOR_PAYMENT','Debe marcar Esperando Factura o digitar un número de factura.');
define('ORD_JS_SERIAL_NUM_PROMPT','Digite el número de serie para este item.  NOTA: La cantidad debe ser 1 para códigos con número de serie.');
define('ORD_JS_NO_STOCK_A','¡Advertencia! No hay suficiente inventario de este código ');
define('ORD_JS_NO_STOCK_B',' en inventario para satisfacer esta órden.\nEl número de artículos en inventario es: ');
define('ORD_JS_NO_STOCK_C','\n\nPresione OK para continuar o Cancele para regresar al formulario de órden.');
define('ORD_JS_INACTIVE_A','¡Advertencia! Código: ');
define('ORD_JS_INACTIVE_B',' está inactivo.\n\nPresione OK para continuar o Cancele para regresar al formulario de órdenes');
define('ORD_JS_CANNOT_CONVERT_QUOTE','¡Una cotización sin registrar no se puede convertir a una Órden de Venta o Factura!');
define('ORD_JS_CANNOT_CONVERT_SO','¡Una Órden de Venta sin registrar no se puede convertir a una Órden de Compra!');

// Audit log messages
define('ORD_DELIVERY_DATES','OC/OV Fechas de Entrega - ');

// Recur Transactions
define('ORD_RECUR_INTRO','Esta transacción se puede duplicar en el futuro seleccionando el número de veces y la frecuencia con que desee que ocurra.  La presente transacción se considera la primer ocurrencia.');
define('ORD_RECUR_ENTRIES','Digite el número de transacciones a crear');
define('ORD_RECUR_FREQUENCY','¿Con qué frecuencia desea que ocurra la transacción?');
define('ORD_TEXT_WEEKLY','Semanalmente');
define('ORD_TEXT_BIWEEKLY','Bi-semanalmente');
define('ORD_TEXT_MONTHLY','Mensualmente');
define('ORD_TEXT_QUARTERLY','Trimestralmente');
define('ORD_TEXT_YEARLY','Anualmente');
define('ORD_PAST_LAST_PERIOD','¡La transacción registrada no puede ocurrir después del último período en el sistema!');

// Tooltips
define('ORD_TT_PURCH_INV_NUM','Si deja el campo en blanco, Phreebooks automáticamente le asignará un número.');

// Purchase Quote Specific
define('ORD_TEXT_3_BILL_TO', 'Remita a:');
define('ORD_TEXT_3_REF_NUM', 'Referencia #');
define('ORD_TEXT_3_WINDOW_TITLE','Solicitud de Cotización a Proveedor');
define('ORD_TEXT_3_EXPIRES', 'Vigencia');
define('ORD_TEXT_3_NUMBER', 'Número');
define('ORD_TEXT_3_TEXT_REP', 'Comprador');
define('ORD_TEXT_3_ITEM_COLUMN_1','Cant');
define('ORD_TEXT_3_ITEM_COLUMN_2','Recib');
define('ORD_TEXT_3_ERROR_NO_VENDOR','¡No seleccionó ningún proveedor! Seleccione un proveedor de la lista o digite la información y seleccione: ' . ORD_ADD_UPDATE);
define('ORD_TEXT_3_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'cotizaciones');
define('ORD_TEXT_3_CLOSED_TEXT',TEXT_CLOSE);

// Purchase Order Specific
define('ORD_TEXT_4_BILL_TO', 'Remita a:');
define('ORD_TEXT_4_REF_NUM', 'Referencia No.');
define('ORD_TEXT_4_WINDOW_TITLE','Órden de Compra');
define('ORD_TEXT_4_EXPIRES', 'Vigencia');
define('ORD_TEXT_4_NUMBER', 'Número');
define('ORD_TEXT_4_TEXT_REP', 'Comprador');
define('ORD_TEXT_4_ITEM_COLUMN_1','Cant');
define('ORD_TEXT_4_ITEM_COLUMN_2','Recib');
define('ORD_TEXT_4_ERROR_NO_VENDOR','¡No seleccionó ningún proveedor!  Seleccione un proveedor de la lista o digite la información y seleccione: ' . ORD_ADD_UPDATE);
define('ORD_TEXT_4_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'órdenes de compra');
define('ORD_TEXT_4_CLOSED_TEXT',TEXT_CLOSE);

// Purchase/Receive Specific
define('ORD_TEXT_6_BILL_TO', 'Remita a:');
define('ORD_TEXT_6_REF_NUM', 'Referencia');
define('ORD_TEXT_6_WINDOW_TITLE','Comprar/Ingresar');
define('ORD_TEXT_6_ERROR_NO_VENDOR','¡No seleccionó ningún proveedor! Seleccione un proveedor de la lista o digite la información y seleccione: ' . ORD_ADD_UPDATE);
define('ORD_TEXT_6_NUMBER', 'Factura No.');
define('ORD_TEXT_6_TEXT_REP', 'Comprador');
define('ORD_TEXT_6_ITEM_COLUMN_1','Saldo OC');
define('ORD_TEXT_6_ITEM_COLUMN_2','Recib');
define('ORD_TEXT_6_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'códigos recibidos');
define('ORD_TEXT_6_CLOSED_TEXT','Factura Cancelada');

// Vendor Credit Memo Specific
define('ORD_TEXT_7_BILL_TO', 'Remita a:');
define('ORD_TEXT_7_REF_NUM', 'Referencia');
define('ORD_TEXT_7_WINDOW_TITLE','Nota de Crédito de Proveedor');
define('ORD_TEXT_7_ERROR_NO_VENDOR','¡No seleccionó ningún proveedor! Seleccione un proveedor de la lista o digite la información y seleccione: ' . ORD_ADD_UPDATE);
define('ORD_TEXT_7_NUMBER', 'Número');
define('ORD_TEXT_7_TEXT_REP', 'Comprador');
define('ORD_TEXT_7_ITEM_COLUMN_1','Recibido');
define('ORD_TEXT_7_ITEM_COLUMN_2','Devueltos');
define('ORD_TEXT_7_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'facturas proveedor');
define('ORD_TEXT_7_CLOSED_TEXT','Crédito Otorgado');

// Customer Quote Specific
define('ORD_TEXT_9_BILL_TO', 'Facturado A:');
define('ORD_TEXT_9_REF_NUM', 'No. OC');
define('ORD_TEXT_9_WINDOW_TITLE','Cotización a Cliente');
define('ORD_TEXT_9_EXPIRES', 'Vence');
define('ORD_TEXT_9_NUMBER', 'Número');
define('ORD_TEXT_9_TEXT_REP', 'Vend');
define('ORD_TEXT_9_ITEM_COLUMN_1','Cant');
define('ORD_TEXT_9_ITEM_COLUMN_2','Facturado');
define('ORD_TEXT_9_ERROR_NO_VENDOR','¡No seleccionó ningún cliente! Seleccione un cliente o digite la información y seleccione: ' . ORD_ADD_UPDATE);
define('ORD_TEXT_9_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'cotización a cliente');
define('ORD_TEXT_9_CLOSED_TEXT',TEXT_CLOSE);

// Sales Order Specific
define('ORD_TEXT_10_BILL_TO', 'Facturado A:');
define('ORD_TEXT_10_REF_NUM', 'No. OC');
define('ORD_TEXT_10_WINDOW_TITLE','Órden de Venta');
define('ORD_TEXT_10_EXPIRES', 'Envie');
define('ORD_TEXT_10_NUMBER', 'Número');
define('ORD_TEXT_10_TEXT_REP', 'Vend');
define('ORD_TEXT_10_ITEM_COLUMN_1','Cant');
define('ORD_TEXT_10_ITEM_COLUMN_2','Facturado');
define('ORD_TEXT_10_ERROR_NO_VENDOR','¡No seleccionó ningún cliente! Seleccione un cliente de la lista o digite la información y seleccione: ' . ORD_ADD_UPDATE);
define('ORD_TEXT_10_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'órdenes de venta');
define('ORD_TEXT_10_CLOSED_TEXT',TEXT_CLOSE);

// Sales/Invoice Specific
define('ORD_TEXT_12_BILL_TO', 'Facturado A:');
define('ORD_TEXT_12_REF_NUM', 'No. OC');
define('ORD_TEXT_12_WINDOW_TITLE','Factura');
define('ORD_TEXT_12_EXPIRES', 'Envie');
define('ORD_TEXT_12_ERROR_NO_VENDOR','¡No seleccionó el cliente!');
define('ORD_TEXT_12_NUMBER', 'Número');
define('ORD_TEXT_12_TEXT_REP', 'Vend');
define('ORD_TEXT_12_ITEM_COLUMN_1','En OV');
define('ORD_TEXT_12_ITEM_COLUMN_2','Cant');
define('ORD_TEXT_12_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'facturas');
define('ORD_TEXT_12_CLOSED_TEXT','Cancelado');

// Customer Credit Memo Specific
define('ORD_TEXT_13_BILL_TO', 'Facturado A:');
define('ORD_TEXT_13_REF_NUM', 'Referencia');
define('ORD_TEXT_13_WINDOW_TITLE','Nota de Crédito a Cliente');
define('ORD_TEXT_13_EXPIRES', 'Envíe');
define('ORD_TEXT_13_ERROR_NO_VENDOR','¡No seleccionó el cliente!');
define('ORD_TEXT_13_NUMBER', 'Número');
define('ORD_TEXT_13_TEXT_REP', 'Vend');
define('ORD_TEXT_13_ITEM_COLUMN_1','Enviado');
define('ORD_TEXT_13_ITEM_COLUMN_2','Devueltos');
define('ORD_TEXT_13_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'facturas');
define('ORD_TEXT_13_CLOSED_TEXT','Crédito Cancelado');

/*
// Cash Receipts Specific
define('ORD_TEXT_18_BILL_TO', 'Vendido A:');
define('ORD_TEXT_18_REF_NUM', 'Orden de Compra #');
define('ORD_TEXT_18_WINDOW_TITLE','Recibos de Dinero');
define('ORD_TEXT_18_EXPIRES', 'Envíe antes de');
define('ORD_TEXT_18_ERROR_NO_VENDOR','No seleccionó ningun cliente!');
define('ORD_TEXT_18_NUMBER', 'Recibo Numero');
define('ORD_TEXT_18_TEXT_REP', 'Vendedor');
define('ORD_TEXT_18_ITEM_COLUMN_1','Saldo OV');
define('ORD_TEXT_18_ITEM_COLUMN_2','Cant');
define('ORD_TEXT_18_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'recibos');

// Point of Sale Specific
define('ORD_TEXT_19_BILL_TO', 'Sale to:');
define('ORD_TEXT_19_REF_NUM', 'Purchase Order #');
define('ORD_TEXT_19_WINDOW_TITLE','Point of Sale');
define('ORD_TEXT_19_EXPIRES', 'Ship By Date');
define('ORD_TEXT_19_ERROR_NO_VENDOR','No customer was selected!');
define('ORD_TEXT_19_NUMBER', 'Receipt Number');
define('ORD_TEXT_19_TEXT_REP', 'Sales Rep');
define('ORD_TEXT_19_ITEM_COLUMN_1','SO Bal');
define('ORD_TEXT_19_ITEM_COLUMN_2','Qty');
define('ORD_TEXT_19_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'sales');

// Cash Distribution Journal
define('ORD_TEXT_20_BILL_TO', 'Remit to:');
define('ORD_TEXT_20_REF_NUM', 'Reference #');
define('ORD_TEXT_20_WINDOW_TITLE','Cash Distribution');
define('ORD_TEXT_20_ERROR_NO_VENDOR','No vendor was selected! Either select a vendor from the popup menu or enter the information and select: ' . ORD_ADD_UPDATE);
define('ORD_TEXT_20_NUMBER', 'Payment Number');
define('ORD_TEXT_20_TEXT_REP', 'Buyer');
define('ORD_TEXT_20_ITEM_COLUMN_1','PO Bal');
define('ORD_TEXT_20_ITEM_COLUMN_2','Rcvd');
define('ORD_TEXT_20_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'payments');

// Direct Inventory Purchase/Receive (Checks)
define('ORD_TEXT_21_BILL_TO', 'Remit to:');
define('ORD_TEXT_21_REF_NUM', 'Reference #');
define('ORD_TEXT_21_WINDOW_TITLE','Direct Purchase');
define('ORD_TEXT_21_ERROR_NO_VENDOR','No vendor was selected! Either select a vendor from the popup menu or enter the information and select: ' . ORD_ADD_UPDATE);
define('ORD_TEXT_21_NUMBER', 'Payment Number');
define('ORD_TEXT_21_TEXT_REP', 'Buyer');
define('ORD_TEXT_21_ITEM_COLUMN_1','PO Bal');
define('ORD_TEXT_21_ITEM_COLUMN_2','Rcvd');
define('ORD_TEXT_21_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER . 'payments');
*/

// popup specific
define('ORD_POPUP_WINDOW_TITLE_3', 'Lista de Solicitudes de Cotización a Proveedor');
define('ORD_POPUP_WINDOW_TITLE_4', 'Lista de Órdenes de Compra');
define('ORD_POPUP_WINDOW_TITLE_6', 'Comprar/Ingresar');
define('ORD_POPUP_WINDOW_TITLE_7', 'Nota de Crédito de Proveedor');
define('ORD_POPUP_WINDOW_TITLE_9', 'Lista de Cotizaciones a Clientes');
define('ORD_POPUP_WINDOW_TITLE_10', 'Lista de Órdenes de Venta');
define('ORD_POPUP_WINDOW_TITLE_12', 'Lista de Facturas');
define('ORD_POPUP_WINDOW_TITLE_13', 'Lista de Notas de Crédito');
//define('ORD_POPUP_WINDOW_TITLE_19', 'Point of Sale');
//define('ORD_POPUP_WINDOW_TITLE_21', 'Inventory Direct Purchase');

// recur specific
define('ORD_RECUR_WINDOW_TITLE_2', 'Memorice Registro Contable');
define('ORD_RECUR_WINDOW_TITLE_3', 'Memorice Cotización a Cliente');
define('ORD_RECUR_WINDOW_TITLE_4', 'Memorice Órden de Compra');
define('ORD_RECUR_WINDOW_TITLE_6', 'Memorice Comprar/Ingresar');
define('ORD_RECUR_WINDOW_TITLE_7', 'Memorice Nota de Crédito de Proveedor');
define('ORD_RECUR_WINDOW_TITLE_9', 'Memorice Solicitud de Cotización a Proveedor');
define('ORD_RECUR_WINDOW_TITLE_10', 'Memorice Orden de Venta');
define('ORD_RECUR_WINDOW_TITLE_12', 'Memorice Factura');
define('ORD_RECUR_WINDOW_TITLE_13', 'Memorice Nota de Crédito');
//define('ORD_RECUR_WINDOW_TITLE_19', 'Recur Point of Sale');
//define('ORD_RECUR_WINDOW_TITLE_21', 'Recur Inventory Direct Purchase');

define('ORD_HEADING_NUMBER_3', 'Solicitud de Cotización a Proveedor');
define('ORD_HEADING_NUMBER_4', 'Orden de Compra');
define('ORD_HEADING_NUMBER_6', 'Factura');
define('ORD_HEADING_NUMBER_7', 'Nota de Crédito a Cliente');
define('ORD_HEADING_NUMBER_9', 'Cotización a Cliente ');
define('ORD_HEADING_NUMBER_10', 'Orden de Venta');
define('ORD_HEADING_NUMBER_12', 'Factura');
define('ORD_HEADING_NUMBER_13', 'Nota de Crédito de Proveedor');
//define('ORD_HEADING_NUMBER_19', 'Receipt Number');
//define('ORD_HEADING_NUMBER_21', 'Payment Number');

define('ORD_HEADING_STATUS_3', ORD_CLOSED);
define('ORD_HEADING_STATUS_4', ORD_CLOSED);
define('ORD_HEADING_STATUS_6', ORD_WAITING);
define('ORD_HEADING_STATUS_7', ORD_WAITING);
define('ORD_HEADING_STATUS_9', ORD_CLOSED);
define('ORD_HEADING_STATUS_10', ORD_CLOSED);
define('ORD_HEADING_STATUS_12', TEXT_PAID);
define('ORD_HEADING_STATUS_13', TEXT_PAID);
//define('ORD_HEADING_STATUS_19', ORD_CLOSED);
//define('ORD_HEADING_STATUS_21', ORD_CLOSED);

define('ORD_HEADING_NAME_3',ORD_VENDOR_NAME);
define('ORD_HEADING_NAME_4',ORD_VENDOR_NAME);
define('ORD_HEADING_NAME_6',ORD_VENDOR_NAME);
define('ORD_HEADING_NAME_7',ORD_VENDOR_NAME);
define('ORD_HEADING_NAME_9',ORD_CUSTOMER_NAME);
define('ORD_HEADING_NAME_10',ORD_CUSTOMER_NAME);
define('ORD_HEADING_NAME_12',ORD_CUSTOMER_NAME);
define('ORD_HEADING_NAME_13',ORD_CUSTOMER_NAME);
//define('ORD_HEADING_NAME_19',ORD_CUSTOMER_NAME);
//define('ORD_HEADING_NAME_21',ORD_VENDOR_NAME);


?>
