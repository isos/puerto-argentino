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
//  Path: /modules/gen_ledger/language/es_cr/language.php
//

// ******************* Release 2.0 Additions ******************/
define('GENERAL_JOURNAL_18_C_DESC','Recibo de Dinero de Cliente');
define('GENERAL_JOURNAL_18_V_DESC','Recibo de Dinero de Proveedor');
define('GENERAL_JOURNAL_20_V_DESC','Pago a Proveedor');
define('GENERAL_JOURNAL_20_C_DESC','Pago a Cliente');
define('GL_BUDGET_HEADING_TITLE','Administrador de Presupuestos');
define('GL_BUDGET_INTRO_TEXT','Esta herramienta establece presupuestos para cuentas.<br />NOTA: ¡El icono salve debe presionarse después de la digitación y antes de cambiar la cuenta o el período fiscal!');
define('GL_COPY_ACTUAL_CONFIRM','¿Está seguro que quiere reemplazar los montos presupuestados para todas las cuentas para el año fiscal con los montos reales del año fiscal anterior?  ¡Esta operación no puede revertirse!');
define('GL_BUDGET_COPY_HINT','Copie montos reales del año fiscal anterior');
define('GL_CLEAR_ACTUAL_CONFIRM','¿Está seguro que quiere borrar los montos presupuestados en todas las cuentas del año fiscal seleccionado? ¡Esta operación no puede revertirse!');
define('TEXT_BUDGET_CLEAR_HINT','Borre todos los montos presupuestados para este año fiscal');
define('TEXT_LOAD_ACCT_PRIOR','Cargue lo montos actuales del año fiscal anterior');
define('ERROR_NO_GL_ACCT_INFO','¡No hay datos para el año fiscal anterior escogido!');
define('TEXT_PERIOD_DATES','Período / Fechas');
define('TEXT_PRIOR_FY','Año Fiscal Anterior');
define('TEXT_BUDGET','Presupuesto');
define('TEXT_NEXT_FY','Próximo Año Fiscal');
define('GL_TEXT_COPY_PRIOR','Copie el presupuesto anterior a presupuesto actual');
define('GL_TEXT_ALLOCATE','Distribuya el total en todo el año fiscal');
define('GL_TEXT_COPY_NEXT','Copie el presupuesto siguiente al presupuesto actual');
define('GL_JS_CANNOT_COPY','¡Este registro no se puede copiar ya que aún no ha sido salvado!');
define('GL_JS_COPY_CONFIRM','Ha elegido copiar este registro.  Esto creará una copia del registro actual con los campos modificados. NOTA: La referencia debe ser diferente o esta operación no se podrá registrar.  Presione OK para continuar o Cancele para regresar al formulario.');

// General
define('TEXT_SELECT_FILE','Archivo a Importar: ');

// Titles and headings
define('GL_ENTRY_TITLE','Registro Contable');
define('GL_HEADING_BEGINNING_BALANCES','Cuadro de Cuentas - Saldos Iniciales');
define('GL_HEADING_IMPORT_BEG_BALANCES','Importe Saldos Iniciales');

// Audit Log Messages
define('GL_LOG_ADD_JOURNAL','Agrege Registros - ');
define('GL_LOG_FY_UPDATE','Año Fiscal - ');
define('GL_LOG_PURGE_DB','Purgue Base de Datos');

// Special buttons
define('GL_BTN_PURGE_DB','Purgue Registros Contables');
define('GL_BTN_BEG_BAL','Digite Saldos Iniciales');
define('GL_BTN_IMP_BEG_BALANCES','Importe Inventario y Saldos Iniciales de Cuentas por Pagar y Cuentas por Cobrar');
define('GL_BTN_CHG_ACCT_PERIOD', 'Cambie el Período Contable Actual');
define('GL_BTN_NEW_FY', 'Genere el Siguiente Año Fiscal');
define('GL_BTN_UPDATE_FY', 'Actualice Cambios Al Año Fiscal');
define('GL_BB_IMPORT_INVENTORY','Importe Inventario');
define('GL_BB_IMPORT_PAYABLES','Importe Cuentas por Pagar');
define('GL_BB_IMPORT_RECEIVABLES','Importe Cuentas por Cobrar');
define('GL_BB_IMPORT_SALES_ORDERS','Importe Órdenes de Venta');
define('GL_BB_IMPORT_PURCH_ORDERS','Importe Órdenes de Compra');
define('GL_BB_IMPORT_HELP_MSG','Refiérase a Ayuda para los requisitos de formato del archivo.');

// GL Utilities
define('GL_UTIL_HEADING_TITLE', 'Mantenimiento de Cuentas, Configuración y Utilitarios');
define('GL_UTIL_PERIOD_LEGEND','Períodos Contables y Años Fiscales');
define('GL_UTIL_BEG_BAL_LEGEND','Saldos Contables Iniciales');
define('GL_UTIL_PURGE_ALL','Purgue Todas las Transacciones (reinicialización)');
define('GL_FISCAL_YEAR','Año Fiscal');
define('GL_UTIL_FISCAL_YEAR_TEXT','Las fechas calendario del período fiscal se pueden modificar aquí.  Note que fechas para un año fiscal no se pueden modificar para el período del último registro y ningún período anterior.');
define('GL_UTIL_BEG_BAL_TEXT','Para la configuración inicial y migraciones de otros sistemas contables.');
define('GL_UTIL_PURGE_DB','Borre todos los registros contables (escriba \'purge\' en la casilla de texto y oprima el botón Purgue Registros Contables)<br />');
define('GL_UTIL_PURGE_DB_CONFIRM','¿Está seguro que quiere borrar todo los registros contables?');
define('GL_UTIL_PURGE_CONFIRM','Borrados todos los registros contables y limpiadas las bases de datos.');
define('GL_UTIL_PURGE_FAIL','¡No se afectó ningún registro!');
define('GL_CURRENT_PERIOD','Período Contable Actual: ');
define('GL_WARN_ADD_FISCAL_YEAR','¿Está seguro que quiere agregar el período fiscal: ');
define('GL_ERROR_FISCAL_YEAR_SEQ','El último período del año fiscal modificado no empata con la fecha de inicio del siguiente período fiscal.  La fecha de comienzo del período fiscal siguiente ha sido modificado y debe ser revisado.');
define('GL_WARN_CHANGE_ACCT_PERIOD','Digite el período contable que quiere hacer el actual:');
define('GL_ERROR_BAD_ACCT_PERIOD','El período fiscal seleccionado no ha sido definido.  Vuelva a escojer el período o agrege un nuevo año fiscal para continuar.');
define('GL_ERROR_NO_BALANCE','¡No se pueden actualizar los saldos iniciales ya que los débitos y créditos no calzan!');
define('GL_ERROR_UPDATE_COA_HISTORY','Error producido actualizando la historia del cuadro de cuentas después de fijar los saldos iniciales!');
define('GL_BEG_BAL_ERROR_0',' encontrado en línea ');
define('GL_BEG_BAL_ERROR_1','Número de cuenta inválido en línea ');
define('GL_BEG_BAL_ERROR_2A','No se encontró número de factura en línea ');
define('GL_BEG_BAL_ERROR_2B','. Marcado como esperando cancelación!');
define('GL_BEG_BAL_ERROR_3','Saliéndose de importar.  No se encontró número de factura en línea ');
define('GL_BEG_BAL_ERROR_4A','Saliéndose del procediminto.  Mal formato de fecha encontrado en línea ');
define('GL_BEG_BAL_ERROR_4B','. Esperando formato ');
define('GL_BEG_BAL_ERROR_5','Salteándose línea.  Cero como monto total se encontró en línea ');
define('GL_BEG_BAL_ERROR_6','Número de cuenta inválido en línea ');
define('GL_BEG_BAL_ERROR_7','Salteándose item inventario.  Cantidad cero encontrado en línea ');
define('GL_BEG_BAL_ERROR_8A','No se pudo actualizar código # ');
define('GL_BEG_BAL_ERROR_8B',', el procedimiento ha sido finalizado.');
define('GL_BEG_BAL_ERROR_9A','No se pudo actualizar la cuenta ');

// GL popup
define('TEXT_DISPLAY_NUMBER_OF_ACCTS', 'Mostrando <b>%d</b> a <b>%d</b> (de <b>%d</b> Cuentas)');

// General Ledger Translations
define('GL_ERROR_JOURNAL_BAD_ACCT','No se encontró la cuenta!');
define('GL_ERROR_OUT_OF_BALANCE','Esta transacción no se puede registrar porque los débitos y créditos no coinciden!');
define('GL_ERROR_BAD_ACCOUNT','Una o mas cuentas son inválidas.  Corrija y vuelva a intentar.');
define('GL_ERROR_NO_REFERENCE','Para transacciones memorizadas, el número de referencia inicial debe ser definido.  PhreeBooks incrementará el número para cada transacción memorizada.');
define('GL_ERROR_RECUR_ROLL_REQD','Esta es una transacción memorizada.  Quiere actualizar también las transaccines futuras? (Presione Cancele para actualizar solamente esta transacción)');
define('GL_ERROR_RECUR_DEL_ROLL_REQD','Esta es una transacción memorizada.  Quiere borrar también las transaccines futuras? (Presione Cancele para borrar solamente esta transacción)');
define('GL_ERROR_NO_ITEMS','No se registraron transacciones.  Para registrar una transacción, la cantidad no puede estar en blanco.');
define('GL_ERROR_NO_POST','Hubo errores en este procedimiento.  No se registró ninguna transacción.');
define('GL_ERROR_NO_DELETE','Hubo errores en este procedimiento.  No se borró ninguna transacción.');
define('GL_ERROR_CANNOT_FIND_NEXT_ID','No se pudo leer el siguiente número de órden/factura de la tabla: ' . TABLE_CURRENT_STATUS);
define('GL_ERROR_CANNOT_DELETE_MAIN','No se pudo borrar el registro no. ');
define('GL_ERROR_CANNOT_DELETE_ITEM','No se pudo borrar el registro no. %d.  ¡No se encontró ningún renglon!');
define('GL_ERROR_NEVER_POSTED','No se puede borrar esta transacción porque nunca fue registrada.');
define('GL_DELETE_GL_ROW','¿Está seguro que quiere borrar el registro perteneciente a este renglón?');
define('GL_DELETE_ALERT','¿Está seguro que quiere borrar este registro?');
define('GL_ERROR_DIED_CREATING_RECORD','Se paralizó tratando de registrar la transaccion # = ');
define('GL_ERROR_POSTING_CHART_BALANCES','Error registrando saldos de la cuenta: ');
define('GL_ERROR_OUT_OF_BALANCE_A','El balance de prueba no está balanceado. Débitos: ');
define('GL_ERROR_OUT_OF_BALANCE_B',' y créditos: ');
define('GL_ERROR_OUT_OF_BALANCE_C',' en el período ');
define('GL_ERROR_NO_GL_ACCT_NUMBER','La función no pasó ningún número de cuenta /gen_ledger.php: ');
define('GL_ERROR_UPDATING_ACCOUNT_HISTORY','Error actualizando la historia de cliente/proveedor.');
define('GL_ERROR_DELETING_ACCOUNT_HISTORY','Error borrando el registro de cliente/proveedor');
define('GL_ERROR_UPDATING_INVENTORY_STATUS','La actualización del estatus de inventario requiere que el código exista.  El código que no existe es: ');
define('GL_ERROR_CALCULATING_COGS','El cálculo del costo de bienes vendidos require que el código esté definido, la operación falló.');
define('GL_ERROR_POSTING_INV_HISTORY','Error registrando la historia de inventario.');
define('GL_ERROR_UNPOSTING_COGS','Error volviendo a costo de bienes vendidos anterior a esta transacción, código: ');
define('GL_ERROR_BAD_SKU_ENTERED','El código digitado no se pudo encontrar.  No se tomó ninguna acción.');
define('GL_ERROR_SKU_NOT_ASSY','No se puede ensamblar un código que no tiene componentes, código: ');
define('GL_ERROR_NOT_ENOUGH_PARTS','No hay suficientes partes para construir el número solicitado de ensamblajes, código: ');
define('GL_ERROR_POSTING_NEG_INVENTORY','Error registrando el costo de bienes vendidos para una Nota de Credito de Proveedor.  El inventario sería negativo y el costo de bienes vendidos no se podría calcular.  Código afectado: ');
define('GL_ERROR_SERIALIZE_QUANTITY','Error calculando el costo de bienes vendidos para un código con control de número de serie.  La cantidad no es igual a 1 por línea declarada.');
define('GL_ERROR_SERIALIZE_EMPTY','Error calculando el costo de bienes vendidos para un código con control de número de serie.  El número de serie está en blanco.');
define('GL_ERROR_SERIALIZE_COGS','Error de costo de bienes vendidos.  No se encontró el número de serie o mas de un código posee el mismo número de serie.');
define('GL_ERROR_NO_RETAINED_EARNINGS_ACCOUNT','No se encontró o se encontraron varias cuentas de ganancia retenida.  ¡Solo puede existir una cuenta de ganancia retenida en PhreeBooks para operar correctamente!');

define('GL_DISPLAY_NUMBER_OF_ENTRIES', TEXT_DISPLAY_NUMBER . 'Registros contables');
define('GL_TOTALS','Totales:');
define('GL_OUT_OF_BALANCE','Diferencia sin balancear');
define('GL_ACCOUNT_INCREASED','La cuenta será incrementada');
define('GL_ACCOUNT_DECREASED','La cuenta será reducida');

define('GL_JOURNAL_ENTRY_COGS','Costo de Bienes Vendidos');

// Journal Entries
define('GENERAL_JOURNAL_0_DESC','Importe de Registros de Saldos Iniciales de Inventario');
define('GL_MSG_IMPORT_0_SUCCESS','Los saldos iniciales del inventario se importaron exitosamente.  El número de registros importados fue: ');
define('GL_MSG_IMPORT_0','Saldos Iniciales de Inventario Importados');

define('GENERAL_JOURNAL_2_DESC','Registro Contable');
define('GENERAL_JOURNAL_2_ERROR_2','El número de registro digitado está duplicado.  ¡Digite un nuevo número de registro!');

define('GENERAL_JOURNAL_3_DESC','Solicitud de Cotización a Proveedor');
define('GENERAL_JOURNAL_3_ERROR_2','SCP - El número de Solicitud de Cotización a Proveedor está duplicado.  Digite un nuevo número de Solicitud de Cotización a Proveedor!');
define('GENERAL_JOURNAL_3_ERROR_5','¡SCP - No se pudo incrementar el número de solicitud de cotización a proveedor!');
define('GENERAL_JOURNAL_3_LEDGER_DISCOUNT','Monto de Descuento de Cotización a Proveedor');
define('GENERAL_JOURNAL_3_LEDGER_FREIGHT','Monto de Flete de Cotización a Proveedor');
define('GENERAL_JOURNAL_3_LEDGER_HEADING','Monto Total de Cotización a Proveedor');

define('GENERAL_JOURNAL_4_DESC','Órden de Compra');
define('GENERAL_JOURNAL_4_ERROR_2','OC - El número de la Órden de Compra está duplicado.  ¡Digite un nuevo número de Órden de Compra!');
define('GENERAL_JOURNAL_4_ERROR_5','¡OC - No se pudo incrementar el número de Órden de Compra!');
define('GENERAL_JOURNAL_4_ERROR_6','¡OC - No se puede borrar una Órden de Compra si tiene mercadería que ya ha sido recibida!');
define('GENERAL_JOURNAL_4_LEDGER_DISCOUNT','Monto de Descuento en Orden de Compra');
define('GENERAL_JOURNAL_4_LEDGER_FREIGHT','Monto de Flete en Órden de Compra');
define('GENERAL_JOURNAL_4_LEDGER_HEADING','Monto Total de Órden de Compra');
define('GL_MSG_IMPORT_4_SUCCESS','Órdenes de Compra importados exitósamente.  El número de registros importados es: ');
define('GL_MSG_IMPORT_4','Órdenes de Compra Importados');

define('GENERAL_JOURNAL_6_DESC','Compra a Proveedor');
define('GENERAL_JOURNAL_6_ERROR_2','C/P - El número de la Compra a Proveedor está duplicado.  ¡Digite un nuevo número de Compra a Proveedor!');
define('GENERAL_JOURNAL_6_ERROR_6','¡C/P - Una compra no se puede borrar si tiene ligado una Nota de Crédito o un Pago!');
define('GENERAL_JOURNAL_6_LEDGER_DISCOUNT','Monto de Descuento de Compra/Recibo de Mercadería');
define('GENERAL_JOURNAL_6_LEDGER_FREIGHT','Monto de Flete de Compra/Recibo de Mercadería');
define('GENERAL_JOURNAL_6_LEDGER_HEADING','Monto Total de Compra/Recibo de Mercadería');
define('GL_MSG_IMPORT_6_SUCCESS','Cuentas por Pagar importadas exitósamente.  El número de registros importados es: ');
define('GL_MSG_IMPORT_6','Cuentas por Pagar Importadas');

define('GENERAL_JOURNAL_7_DESC','Nota de Crédito de Proveedor');
define('GENERAL_JOURNAL_7_ERROR_2','NCP - El número de la Nota de Crédito está duplicado.  ¡Digite un nuevo número de Nota de Crédito!');
define('GENERAL_JOURNAL_7_ERROR_5','¡NCP - No se pudo incrementar el número de Nota de Crédito!');
define('GENERAL_JOURNAL_7_ERROR_6','¡NCP - Una Nota de Crédito no se puede borrar si ya tienen un pago aplicado!');
define('GENERAL_JOURNAL_7_LEDGER_DISCOUNT','Monto de Descuento por Nota de Crédito de Proveedor');
define('GENERAL_JOURNAL_7_LEDGER_FREIGHT','Monto de Flete por Nota de Crédito de Proveedor');
define('GENERAL_JOURNAL_7_LEDGER_HEADING','Monto Total de Nota de Crédito de Proveedor');

define('GENERAL_JOURNAL_9_DESC','Cotización a Cliente');
define('GENERAL_JOURNAL_9_ERROR_2','COT - El número de la Cotización a Cliente está duplicado.  ¡Digite un nuevo número de Cotización a Cliente!');
define('GENERAL_JOURNAL_9_ERROR_5','¡COT - No se pudo incrementar el número de Cotización a Cliente!');
define('GENERAL_JOURNAL_9_LEDGER_DISCOUNT','Monto de Descuento de Cotización a Cliente');
define('GENERAL_JOURNAL_9_LEDGER_FREIGHT','Monto de Flete de Cotización');
define('GENERAL_JOURNAL_9_LEDGER_HEADING','Monto Total de Cotización');

define('GENERAL_JOURNAL_10_DESC','Órden de Venta');
define('GENERAL_JOURNAL_10_ERROR_2','OV - El número de la Órden de Venta está duplicado.  Digite un nuevo número de Órden de Venta!');
define('GENERAL_JOURNAL_10_ERROR_5','¡OV - No se pudo incrementar el número de Órden de Venta!');
define('GENERAL_JOURNAL_10_ERROR_6','¡OV - Una Órden de Venta no se puede borrar si tiene ítems que ya han sido facturados!');
define('GENERAL_JOURNAL_10_LEDGER_DISCOUNT','Monto de Descuento de Órden de Venta');
define('GENERAL_JOURNAL_10_LEDGER_FREIGHT','Monto de Flete de Órden de Venta');
define('GENERAL_JOURNAL_10_LEDGER_HEADING','Total de la Órden de Venta');
define('GL_MSG_IMPORT_10_SUCCESS','Las Órdenes de Venta se importaron exitósamente.  El número de registros importados fue : ');
define('GL_MSG_IMPORT_10','Órdenes de Venta Importadas');

define('GENERAL_JOURNAL_12_DESC','Factura');
define('GENERAL_JOURNAL_12_ERROR_2','Fact - El número de la Nota de Crédito está duplicado.  ¡Digite un nuevo número de Nota de Crédito!');
define('GENERAL_JOURNAL_12_ERROR_5','¡Fact - No se pudo incrementar el número de factura!');
define('GENERAL_JOURNAL_12_ERROR_6','¡Fact - Una factura no se puede borrar si tiene aplicado una Nota de Crédito o un Recibo de Dinero!');
define('GENERAL_JOURNAL_12_LEDGER_DISCOUNT','Monto de Descuento sobre la Factura');
define('GENERAL_JOURNAL_12_LEDGER_FREIGHT','Monto de Flete sobre la Factura');
define('GENERAL_JOURNAL_12_LEDGER_HEADING','Monto Total de Factura');
define('GL_MSG_IMPORT_12','Importe de Cuentas por Cobrar');
define('GL_MSG_IMPORT_12_SUCCESS','Cuentas por Cobrar importadas exitósamene.  El número de registros importados fue: ');
define('GL_MSG_IMPORT_12','Facturas Importadas');

define('GENERAL_JOURNAL_13_DESC','Nota de Credito a Cliente');
define('GENERAL_JOURNAL_13_ERROR_2','NCC - El número de la Nota de Crédito está duplicado.  ¡Digite un nuevo número de Nota de Crédito!');
define('GENERAL_JOURNAL_13_ERROR_5','¡NCC - No se pudo incrementar el número de Nota de Crédito!');
define('GENERAL_JOURNAL_13_ERROR_6','¡NCC - Una Nota de Crédito no se puede borrar si ya tiene un pago aplicado!');
define('GENERAL_JOURNAL_13_LEDGER_DISCOUNT','Monto de descuento por Nota de Crédito');
define('GENERAL_JOURNAL_13_LEDGER_FREIGHT','Monto de Flete correspondiente a Nota de Crédito');
define('GENERAL_JOURNAL_13_LEDGER_HEADING','Monto Total Nota de Crédito');

define('GENERAL_JOURNAL_14_DESC','Ensamblaje');

define('GENERAL_JOURNAL_16_DESC','Ajuste de Inventario');

define('GENERAL_JOURNAL_18_DESC','Recibo de Dinero de Clientes');
define('GENERAL_JOURNAL_18_ERROR_2','RD - El número de recibo que digitó está duplicado.  ¡Digite un nuevo número de recibo!');
define('GENERAL_JOURNAL_18_ERROR_5','¡RD - No se pudo incrementar el número de recibo!');
define('GENERAL_JOURNAL_18_ERROR_6','¡RD - Un recibo no se puede borrar si ya fue reconciliado con el banco!');
define('GENERAL_JOURNAL_18_DISCOUNT_HEADING','Descuentos a Cliente por Prepago');
define('GENERAL_JOURNAL_18_LEDGER_HEADING','Monto Total de Recibo de Dinero de Cliente');

/*
define('GENERAL_JOURNAL_19_DESC','Point of Sale Entry');
define('GENERAL_JOURNAL_19_ERROR_2','S/I - The receipt number you entered is a duplicate, please enter a new receipt number!');
define('GENERAL_JOURNAL_19_ERROR_5','S/I - Failed incrementing the receipt number!');
define('GENERAL_JOURNAL_19_ERROR_6','S/I - An receipt cannot be deleted if there has been a payment applied!');
define('GENERAL_JOURNAL_19_LEDGER_DISCOUNT','Point of Sale Discount Amount');
define('GENERAL_JOURNAL_19_LEDGER_FREIGHT','Point of Sale Freight Amount');
define('GENERAL_JOURNAL_19_DISCOUNT_HEADING','Customer Receipt Discount');
define('GENERAL_JOURNAL_19_LEDGER_HEADING','Point of Sale Total');
*/

define('GENERAL_JOURNAL_20_DESC','Pago a Proveedor');
define('GENERAL_JOURNAL_20_ERROR_2','P/P - El número de cheque que digitó está duplicado.  ¡Digite un nuevo número de cheque!');
define('GENERAL_JOURNAL_20_ERROR_5','¡P/P - No se pudo incrementar el número de pago!');
define('GENERAL_JOURNAL_20_ERROR_6','¡P/P - Un pago no se puede borrar si ya fue reconciliado con el banco!');
define('GENERAL_JOURNAL_20_DISCOUNT_HEADING','Descuento del Proveedor');
define('GENERAL_JOURNAL_20_LEDGER_HEADING','Total del Pago a Proveedor');

/*
define('GENERAL_JOURNAL_21_DESC','Purchase Entry');
define('GENERAL_JOURNAL_21_ERROR_2','P/R - The check number you entered is a duplicate, please enter a new check number!');
define('GENERAL_JOURNAL_21_ERROR_6','P/R - A purchase cannot be deleted if there has been a payment applied!');
define('GENERAL_JOURNAL_21_LEDGER_DISCOUNT','Purchase Discount Amount');
define('GENERAL_JOURNAL_21_LEDGER_FREIGHT','Purchase Freight Amount');
define('GENERAL_JOURNAL_21_DISCOUNT_HEADING','Purchase Discount');
define('GENERAL_JOURNAL_21_LEDGER_HEADING','Purchase Total');
*/
?>
