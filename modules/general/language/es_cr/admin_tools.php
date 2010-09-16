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
//  Path: /modules/general/language/es_cr/admin_tools.php
//

// ************** Release 2.0 additions ****************************//
define('GEN_DEFAULT_STORE','Tienda Predeterminada');
define('GEN_DEF_CASH_ACCT','Cuenta de Efectivo Predeterminada');
define('GEN_RESTRICT_STORE','¿Restrinja registros a esta tienda?');
define('GEN_DEF_AR_ACCT','Cuenta por Cobrar Predeterminada');
define('GEN_DEF_AP_ACCT','Cuenta por Pagar Predeterminada');
define('GEN_RESTRICT_PERIOD','¿Restrinja registros al período actual?');
define('GEN_ADM_TOOLS_CLEAN_LOG','Haga respaldo y limpie el registro de auditoría');
define('GEN_ADM_TOOLS_CLEAN_LOG_DESC','Esta operación crea y baja un respaldo del archivo de registro de auditoría.  Esto sirve para controlar el tamaño del archivo de la base de datos de la compañía y reducir el tamaño del archivo de respaldo.  Se recomienda hacer el respaldo del registro de auditoría antes de limpiarlo para preservar la historia de transacciones. <br />NOTA: La limpieza del registro de auditoría deja la información del período actual y elimina todos los registros anteriores. ');
define('GEN_ADM_TOOLS_CLEAN_LOG_BACKUP','Respale el registro de auditoría');
define('GEN_ADM_TOOLS_CLEAN_LOG_CLEAN','Limpie el registro de auditoría');
define('GEN_ADM_TOOLS_BTN_CLEAN_CONFIRM','¿Está seguro que quiere borrar el registro de auditoría?');
define('GEN_ADM_TOOLS_BTN_BACKUP','¡Haga el respaldo ya!');
define('GEN_ADM_TOOLS_BTN_CLEAN','¡Borre ya!');
define('GEN_AUDIT_DB_DATA_BACKUP','Se hizo el respaldo del registro de auditoría.');
define('GEN_AUDIT_DB_DATA_CLEAN','Se limpió el registro de auditoría.');


// ************** Release 1.8 additions ****************************//
define('HEADING_TITLE_CRASH_TITLE','Información del Error SQL en PhreeBooks');
define('HEADING_TITLE_CRASH_INFORMATION','PhreeBooks encontró un error inesperado.  Presione el botón mas abajo para descargar el archivo con la información para despulgar el error que luego puede mandar al equipo de programadores de PhreeBooks y conseguir ayuda en resolver el problema.');
define('HEADING_TITLE_CRASH_BUTTON','Descargue Información para Despulgar');

// ************** Release 1.7 additions ****************************//
define('GEN_ADM_TOOLS_CUSTID','Próximo Cliente');
define('GEN_ADM_TOOLS_VENDID','Próximo Proveedor');

// Pre-release 1.6 language definitions
define('GEN_ADM_TOOLS_POST_SEQ_SUCCESS','Registrado exitósamente los cambios al número de la actual órden.');
define('GEN_ADM_TOOLS_AUDIT_LOG_SEQ','Actualizado el estatus de la órden actual');
define('GEN_ADM_TOOLS_TITLE','Utilitarios y Herramientas Administrativas');
define('GEN_ADM_TOOLS_SEQ_HEADING','Cambio de Varios Números de Secuencia');
define('GEN_ADM_TOOLS_SEQ_DESC','Los cambios en la secuencia se pueden hacer aquí.<br />Nota 1: PhreeBooks no permite secuencias duplicadas, asegúrese que el comienzo de la nueva secuencia no estará en conflicto con los valores actualmente registrados.<br />Nota 2: El número del próximo depósito es generado por el sistema y usa la fecha actual.<br />Nota 3: El próximo número de cheque puede fijarse en la pantalla de recibo de dinero antes de registrar un recibo y continuará a partir de ese valor.');
define('GEN_ADM_TOOLS_AR','Clientes/Cuentas por Cobrar');
define('GEN_ADM_TOOLS_AP','Proveedores/Cuentas por Pagar');
define('GEN_ADM_TOOLS_BNK','Banca');
define('GEN_ADM_TOOLS_OTHER','Otros');
define('GEN_ADM_TOOLS_BTN_SAVE','Salve los Cambios');

define('GEN_ADM_TOOLS_ARQ','Próximo Número de Cotización a Cliente');
define('GEN_ADM_TOOLS_APQ','Próximo Número de Solicitud de Cotización a Proveedor');
define('GEN_ADM_TOOLS_BNKD','Próximo Número de Depósito');
define('GEN_ADM_TOOLS_ARSO','Próximo Número de Órden de Venta');
define('GEN_ADM_TOOLS_APPO','Próximo Número de Órden a Compra');
define('GEN_ADM_TOOLS_BNKCK','Próximo Número de Cheque');
define('GEN_ADM_TOOLS_ARINV','Próximo Número de Factura');
define('GEN_ADM_TOOLS_ARCM','Próximo Número de Nota de Crédito a Cliente');
define('GEN_ADM_TOOLS_APCM','Próximo Número de Nota de Crédito de Proveedor');
define('GEN_ADM_TOOLS_SHIP','Próximo Número de Flete');

define('GEN_ADM_TOOLS_RE_POST_FAILED','No se seleccionaron registros para modificar.  No se tomó ninguna acción.');
define('GEN_ADM_TOOLS_RE_POST_SUCCESS','Los registros seleccionados se modificaron exitósamente.  El número de registros modificados fue: %s');
define('GEN_ADM_TOOLS_AUDIT_LOG_RE_POST','Modificar Registros: ');
define('GEN_ADM_TOOLS_REPOST_HEADING','Modificar Registros');
define('GEN_ADM_TOOLS_REPOST_DESC','<b>¡RESPALDE SUS DATOS ANTES DE MODIFICAR ALGÚN REGISTRO!</b><br />Nota: El modificar registros puede demorarse, limite los registros a modificar definiendo un rango de fechas menor o limitando el número de registros.');
define('GEN_ADM_TOOLS_REPOST_CONFIRM','¿Está seguro que quiere modificar los registros seleccionados?\n\n¡DEBE RESPALDAR EL ARCHIVO DE LA COMPAÑÍA ANTES DE HACER ESTA OPERACIÓN!');
define('GEN_ADM_TOOLS_BNK_ETC','Banca/Inventario/Otro');
define('GEN_ADM_TOOLS_DATE_RANGE','Modifique el Rango de Fechas');
define('GEN_ADM_TOOLS_START_DATE','Fecha Inicio');
define('GEN_ADM_TOOLS_END_DATE','Fecha Finalización');

define('GEN_ADM_TOOLS_BTN_REPOST','Modifique Registros');
define('GEN_ADM_TOOLS_J02','Diario General (2)');
define('GEN_ADM_TOOLS_J03','Diario Cotización a Proveedor (3)');
define('GEN_ADM_TOOLS_J04','Diario Orden de Compra (4)');
define('GEN_ADM_TOOLS_J06','Diario Compras (6)');
define('GEN_ADM_TOOLS_J07','Diario Nota de Crédito de Proveedor (7)');
define('GEN_ADM_TOOLS_J08','Diario Planilla (8)');
define('GEN_ADM_TOOLS_J09','Diario Cotización a Cliente (9)');
define('GEN_ADM_TOOLS_J10','Diario Órden de Venta (10)');
define('GEN_ADM_TOOLS_J12','Diario Factura (12)');
define('GEN_ADM_TOOLS_J13','Diario Nota de Crédito a Cliente (13)');
define('GEN_ADM_TOOLS_J14','Diario Ensamblaje de Inventario (14)');
define('GEN_ADM_TOOLS_J16','Diario Ajuste de Inventario (16)');
define('GEN_ADM_TOOLS_J18','Diario Recibo de Dinero (18)');
define('GEN_ADM_TOOLS_J19','Diario Punto de Venta (19)');
define('GEN_ADM_TOOLS_J20','Diario Salida de Efectivo (20)');
define('GEN_ADM_TOOLS_J21','Diario Punto de Compra (21)');

define('GEN_ADM_TOOLS_REPAIR_CHART_HISTORY','Revalide y Repare los Saldos de las Cuentas');
define('GEN_ADM_TOOLS_REPAIR_CHART_DESC','Esta operación revalida y repara los saldos de las cuentas del cuadro de cuentas.  Si el Balance de Prueba o el Balance General no están balanceados aquí es donde debe comenzar.  Primero revalide los saldos para ver si hay errores y repare si es necesario.');
define('GEN_ADM_TOOLS_REPAIR_TEST','Prueba de Saldos de Cuentas');
define('GEN_ADM_TOOLS_REPAIR_FIX','Corrija Errores de Saldos de Cuentas');
define('GEN_ADM_TOOLS_BTN_TEST','Prueba de Saldos de Cuentas');
define('GEN_ADM_TOOLS_BTN_REPAIR','Repare Errores de Saldos de Cuentas');
define('GEN_ADM_TOOLS_REPAIR_CONFIRM','¿Está seguro que quiere reparar saldos de cuentas?\n\n¡DEBE IMPRIMIR LOS ESTADOS FINANCIEROS Y RESPALDAR EL ARCHIVO DE COMPAÑÍA ANTES DE HACER ESTA OPERACIÓN!');
define('GEN_ADM_TOOLS_REPAIR_ERROR_MSG','Hay un error de saldo para el período %s cuenta %s Comparación de valores: %s con: %s');
define('GEN_ADM_TOOLS_REPAIR_SUCCESS','Los saldos de las cuentas están bien.');
define('GEN_ADM_TOOLS_REPAIR_ERROR','Debe reparar los saldos de las cuentas.  NOTA: RESPALDE SU COMPAÑÍA ANTES DE REPARAR LOS SALDOS DE LAS CUENTAS!');
define('GEN_ADM_TOOLS_REPAIR_COMPLETE','Los saldos de las cuentas han sido reparadas.');
define('GEN_ADM_TOOLS_REPAIR_LOG_ENTRY','Saldos Reparados');

// Encryption defines
define('GEN_ADM_TOOLS_SET_ENCRYPTION_KEY','Digite la Clave de Encripción');
define('BOX_HEADING_ENCRYPTION','Servicios de Encriptar Datos');
define('GEN_ENCRYPTION_GEN_INFO','Servicios de Encriptar dependen de la clave usada para encriptar los datos en la base de datos.  NO PIERDA LA CLAVE, sino, los datos no se pueden desencriptar');
define('GEN_ENCRYPTION_COMP_TYPE','Digite la clave de encriptar usada para almacenar de una manera segura los datos.');
define('GEN_ENCRYPTION_KEY','Clave de Encriptar ');
define('GEN_ENCRYPTION_KEY_CONFIRM','Confirme la Clave ');
define('ERROR_WRONG_ENCRYPT_KEY_MATCH','¡Las dos claves de encriptar no coinciden!');
define('ERROR_WRONG_ENCRYPT_KEY','Digitó la clave de encriptar pero no corresponde con la clave almacenada.');
define('GEN_ENCRYPTION_KEY_SET','La clave de encriptar ha sido salvada.');
define('GEN_ENCRYPTION_KEY_CHANGED','La clave de encriptar ha sido cambiada.');

define('GEN_ADM_TOOLS_SET_ENCRYPTION_PW','Crear/Modificar la Clave de Encriptar');
define('GEN_ADM_TOOLS_SET_ENCRYPTION_PW_DESC','Defina una clave de encriptar a usar si \'Habilite Encriptar\' ha sido seleccionada.  Si está definiendo por primera vez, la clave de encriptar antigüa está en blanco.');
define('GEN_ADM_TOOLS_ENCRYPT_OLD_PW','Clave de Encriptar Antigüa');
define('GEN_ADM_TOOLS_ENCRYPT_PW','Nueva Clave de Encriptar');
define('GEN_ADM_TOOLS_ENCRYPT_PW_CONFIRM','Confirme la Nueva Clave de Encriptar');
define('ERROR_OLD_ENCRYPT_NOT_CORRECT','¡La clave de encriptar actual no corresponde con la clave almacenada!');

// backup defines
define('BOX_HEADING_RESTORE','Restablezca la Compañía');
define('GEN_BACKUP_ICON_TITLE','Comience Respaldo');
define('GEN_BACKUP_GEN_INFO','Seleccione el tipo de compresión y las opciones siguientes.');
define('GEN_BACKUP_COMP_TYPE','Tipo de Compresión');
define('GEN_COMP_BZ2',' bz2 (Linux)');
define('GEN_COMP_ZIP',' Zip');
define('GEN_COMP_NONE','Ninguno (Sólo Base de Datos)');
define('GEN_BACKUP_DB_ONLY',' Sólo Base de Datos');
define('GEN_BACKUP_FULL',' Base de Datos y Archivos de la Compañía');
define('GEN_BACKUP_SAVE_LOCAL',' Salve una copia en el servidor (my_files/backups)');
define('GEN_BACKUP_WARNING','¡Advertencia!  Esta operación borrará y luego creará de nuevo la base de datos.  ¿Está seguro que quiere continuar?');
define('GEN_BACKUP_NO_ZIP_CLASS','La clase Zip no se puede encontrar.  PHP necesita que esté instalada la biblioteca zip para hacer el respaldo con compresión zip.');
define('GEN_BACKUP_FILE_ERROR','No se pudo crear el archivo zip.  Revise los permisos para el directorio: ');
define('GEN_BACKUP_MOVE_ERROR','No se puede abrir el archivo (%s) para escritura.  Revise los permisos.');

?>
