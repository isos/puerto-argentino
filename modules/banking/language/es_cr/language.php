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
//  Path: /modules/banking/language/es_cr/language.php
//

// **************  Release 2.0 changes  ********************
define('BNK_ERROR_NO_ENCRYPT_KEY', '¡Está almacenada la información de pago pero la llave de encripción no se ha declarado!');

// **************  Release 1.9 changes  ********************
define('BNK_DEP_20_V_WINDOW_TITLE', 'Depósitos de Proveedores');
define('BNK_20_ENTER_DEPOSIT','Digite un Depósito de Proveedor');

// **************  Release 1.8 changes  ********************
define('BNK_DEP_18_C_WINDOW_TITLE', 'Depósitos de Clientes');
define('BNK_DEP_18__WINDOW_TITLE', 'Depósitos de Clientes');  //REMOVE WHEN CODE IS FIXED template_main.php
define('BNK_18_ENTER_DEPOSIT','Digite un Depósito de Cliente');

// **************  Release 1.7 and earlier  ********************
// general
define('BNK_CASH_ACCOUNT','Cuenta de Efectivo');
define('BNK_DISCOUNT_ACCOUNT','Cuenta de Descuentos por Prepago');
define('BNK_AMOUNT_DUE','Monto a Pagar');
define('BNK_DUE_DATE','Vence');
define('BNK_INVOICE_NUM','Factura #');
define('BNK_TEXT_CHECK_ALL','Marque Todos');
define('BNK_TEXT_DEPOSIT_ID','Número de Depósito');
define('BNK_TEXT_PAYMENT_ID','Referencia de Pago');
define('BNK_TEXT_WITHDRAWAL','Retiro');
define('BNK_TEXT_SAVE_PAYMENT_INFO','Salve Información de Pago ');

define('BNK_REPOST_PAYMENT','¡El pago se registró de nuevo, esto puede haber duplicado un pago previo!');
define('TEXT_CCVAL_ERROR_INVALID_DATE', 'La fecha de vencimiento de la tarjeta de crédito es inválida.  Revise la fecha e intente de nuevo.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'El número de la tarjeta de crédito es inválida.  Revise el número e intente de nuevo.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'El número de la tarjeta de crédito empezando con %s no fue digitado correctamente, o no aceptamos ese tipo de tarjeta. Pruebe de nuevo o use otra tarjeta de crédito.');
define('BNK_BULK_PAY_NOT_POSITIVE','¡El pago al proveedor: %s no se hizo ya que el monto de pago total es menor o igual a cero!');
define('BNK_PAYMENT_NOT_SAVED','La casilla de Salve Información de Pago estaba marcada pero la clave de encripción no está presente.  ¡El recibo fue procesado pero la información de pago no fue salvada!');

// Audit Log Messages
define('BNK_LOG_ACCT_RECON','Reconciliación de Cuenta, período: ');

// Cash receipts specific definitions
define('BNK_18_ERROR_NO_VENDOR','¡No seleccionó un Cliente!');
define('BNK_18_ENTER_BILLS','Digite Recibo de Efectivo');
define('BNK_18_DELETE_BILLS','Elimine Recibo de Efectivo');
define('BNK_18_C_WINDOW_TITLE','Recibo de Dinero de Clientes');
define('BNK_18_V_WINDOW_TITLE','Reembolsos de Proveedores');
define('BNK_18_BILL_TO','Recibido De:');
define('BNK_18_POST_SUCCESSFUL','Se registró exitósamente el recibo no. ');
define('BNK_18_POST_DELETED','Se borró exitósamente el recibo no. ');
define('BNK_18_AMOUNT_PAID','Monto Recibido');
define('BNK_18_DELETE_ALERT','¿Está seguro que quiere borrar este recibo?');
define('BNK_18_NEGATIVE_TOTAL','¡El monto del recibo no puede ser menor que cero!');

/*
// Point of Sale specific definitions
define('BNK_19_ERROR_NO_VENDOR','No Customer was selected!');
define('BNK_19_ENTER_BILLS','Enter Point of Sale Payments');
define('BNK_19_DELETE_BILLS','Delete Point of Sale Receipts');
define('BNK_19_WINDOW_TITLE','Receipts');
define('BNK_19_BILL_TO','Receive From:');
define('BNK_19_POST_SUCCESSFUL','Successfully posted receipt # ');
define('BNK_19_POST_DELETED','Successfully deleted receipt # ');
define('BNK_19_AMOUNT_PAID','Amt Rcvd');
define('BNK_19_DELETE_ALERT','Are you sure you want to delete this receipt?');
*/
// Cash Distribution specific definitions
define('BNK_20_ERROR_NO_VENDOR','¡No seleccionó ningún proveedor!');
define('BNK_20_ENTER_BILLS','Digite Salidas de Efectivo');
define('BNK_20_DELETE_BILLS','Borre Salidas de Efectivo');
define('BNK_20_V_WINDOW_TITLE','Pague a Proveedores');
define('BNK_20_C_WINDOW_TITLE','Pague a Clientes');
define('BNK_20_BILL_TO','Pagadero A:');
define('BNK_20_POST_SUCCESSFUL','Se registró exitósamente el pago no. ');
define('BNK_20_POST_DELETED','Se borró exitósamente el pago no. ');
define('BNK_20_AMOUNT_PAID','Monto Pagado');
define('BNK_20_DELETE_ALERT','¿Está seguro que quiere borrar este pago?');
define('BNK_20_NEGATIVE_TOTAL','¡El monto del pago no puede ser menor que cero!');
/*
// Point of Purchase (Write Checks) specific definitions
define('BNK_21_ERROR_NO_VENDOR','No vendor was selected!');
define('BNK_21_ENTER_BILLS','Enter Point of Purchase Payment');
define('BNK_21_DELETE_BILLS','Delete Point of Purchase Payment');
define('BNK_21_WINDOW_TITLE','Payments');
define('BNK_21_BILL_TO','Pay To:');
define('BNK_21_POST_SUCCESSFUL','Successfully posted payment # ');
define('BNK_21_POST_DELETED','Successfully deleted payment # ');
define('BNK_21_AMOUNT_PAID','Amt Paid');
define('BNK_21_DELETE_ALERT','Are you sure you want to delete this payment?');
*/

// bulk pay bills
define('BNK_CHECK_DATE','Fecha del Cheque');
define('BNK_TEXT_FIRST_CHECK_NUM','Número del Primer Cheque');
define('BNK_TOTAL_TO_BE_PAID','Total de Todos los Pagos');
define('BNK_INVOICES_DUE_BY','Facturas que Vencen el');
define('BNK_DISCOUNT_LOST_BY','Descuentos Vencidos al');
define('BNK_INVOICE_DATE','Fecha Factura');
define('BNK_VENDOR_NAME','Proveedor');
define('BNK_ACCOUNT_BALANCE','Saldo Antes de Pagos');
define('BNK_BALANCE_AFTER_CHECKS','Saldo Después de Pagos');

// account reconciliation
define('BANKING_HEADING_RECONCILIATION','Reconciliación de Cuentas');
define('BNK_START_BALANCE','Saldo Final en el Estado de Cuenta');
define('BNK_OPEN_CHECKS','- Cheques No Cobrados');
define('BNK_OPEN_DEPOSITS','+ Depósito en Tránsito');
define('BNK_GL_BALANCE','- Saldo de Cuenta en Libros');
define('BNK_END_BALANCE','Diferencia Sin Reconciliar');
define('BNK_DEPOSIT_CREDIT','Depósitos/Créditos');
define('BNK_CHECK_PAYMENT','Cheques/Retiros');
define('TEXT_MULTIPLE_DEPOSITS','Depósitos de Clientes');
define('TEXT_MULTIPLE_PAYMENTS','Pagar Cuentas');
define('TEXT_CASH_ACCOUNT','Cuentas de Efectivo');
define('BNK_ERROR_PERIOD_NOT_ALL','El período contable no puede ser \'Todos\' para esta operación de reconciliación.');
define('BNK_RECON_POST_SUCCESS','Los cambios se hicieron exitósamente.');

// Bank account register
define('BANKING_HEADING_REGISTER','Registro de Cuentas de Efectivo');
define('TEXT_BEGINNING_BALANCE','Saldo Inicial');
define('TEXT_ENDING_BALANCE','Saldo Final');
define('TEXT_DEPOSIT','Depósito');

// Cvv stuff for credit cards
define('HEADING_CVV', 'Qué es CVV?');
define('TEXT_CVV_HELP1', 'Visa, Mastercard, Discover. Verificación de código de 3 dígitos<br /><br />
                    Para su seguridad, requerimos que digite el número de verificación que aparece en su tarjeta.<br /><br />
                    El número de verificación es un número de 3 dígitos impreso en la parte de atrás de la tarjeta.
                    Aparece después y a la derecha del número de su tarjeta.<br />' .
                    html_image(DIR_WS_IMAGES . 'cvv2visa.gif'));

define('TEXT_CVV_HELP2', 'American Express. Verificación de código de 4 dígitos<br /><br />
                    Para su seguridad, requerimos que digite el número de verificación que aparece en su tarjeta.<br /><br />
                    El número de verificación es un número de 4 dígitos impreso en la parte de atrás de la tarjeta.
                    Aparece después y a la derecha del número de su tarjeta.<br />' .
                    html_image(DIR_WS_IMAGES . 'cvv2amex.gif'));
?>
