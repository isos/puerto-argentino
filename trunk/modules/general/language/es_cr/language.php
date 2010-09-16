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
//  Path: /modules/general/language/es_cr/language.php
//

// NOTE: NEW RELEASE ADDITIONS/UPDATES/CHANGES ARE AT THE BOTTOM OF THIS FILE 

define('LANGUAGE','Español (CR)');

// look in your $PATH_LOCALE/locale directory for available locales.
// on RedHat6.0 I used 'en_US'
// on FreeBSD 4.0 I use 'en_US.ISO_8859-1'
// this may not work under win32 environments..
setlocale(LC_TIME, 'en_US.UTF-8');
setlocale(LC_CTYPE, 'C');

define('DATE_FORMAT', 'd/m/Y'); // this is used for date(), use only values: Y, m and d (case sensitive)
define('DATE_DELIMITER', '/'); // must match delimiter used in DATE_FORMAT
define('DATE_TIME_FORMAT', DATE_FORMAT . ' %H:%M:%S');
define('DATE_FORMAT_SPIFFYCAL', 'dd/MM/yyyy');  //Use only 'dd', 'MM' and 'yyyy' here in any order
define('MAX_NUM_PRICE_LEVELS', 5);
define('MAX_NUM_ADDRESSES', 5); // *****  For Import/Export Module, set the maximum number of addresses *****
define('MAX_INVENTORY_SKU_LENGTH', 15); // database is currently set for a maximum of 24 characters

// Global entries for the <html> tag
// define('HTML_PARAMS','dir="ltr" lang="es"');
define('HTML_PARAMS','lang="es-CR" xml:lang="es-CR"');


// charset for web pages and emails
define('CHARSET', 'UTF-8');
define("LANG_I18N","es");

// Meta-tags: page title
define('TITLE', 'PhreeBooks');

// **************  Release 2.0 changes  ********************
define('TEXT_HEADING','Título');
define('TEXT_MOVE_LEFT','Mueva Izquierda');
define('TEXT_MOVE_RIGHT','Mueva Derecha');
define('TEXT_MOVE_UP','Mueva Arriba');
define('TEXT_MOVE_DOWN','Mueva Abajo');
define('TEXT_PROFILE','Perfil');
define('TEXT_FIND','Busque ...');
define('TEXT_DETAILS','Detalles');
define('TEXT_HIDE','Oculte');
define('BOX_PHREECRM_MODULE','Relaciones con Clientes');
define('BOX_ACCOUNTS_NEW_CONTACT','Nuevo Contacto');
define('TEXT_ENCRYPTION_ENABLED','Encrypción está activado');
define('BOX_GL_BUDGET','Presupuestos');
define('TEXT_DEFAULT_PRICE_SHEET','Escala de Precios Predeterminada');
define('TEXT_PURCH_ORDER','Órdenes de Compra');
define('TEXT_PURCHASE','Compras');

// **************  Release 1.9 changes  ********************
define('TEXT_START_DATE','Fecha de Inicio');
define('TEXT_END_DATE','Fecha de Finalización');
define('TEXT_PROJECT','Proyecto');
define('DB_ERROR_NOT_CONNECTED', '¡Error de Base de Datos: ¡No se pudo conectar a la base de datos!');
define('BOX_BANKING_VENDOR_DEPOSITS', 'Depósitos de Proveedores');
define('BOX_AR_QUOTE_STATUS', 'Lista de Cotizaciones a Clientes');
define('BOX_AP_RFQ_STATUS', 'Lista de Cotizaciones de Proveedores');
define('BOX_PROJECTS_PHASES','Fases de Proyecto');
define('BOX_PROJECTS_COSTS','Costos de Proyecto');
define('BOX_ACCOUNTS_MAINTAIN_PROJECTS','Lista de Proyectos');
define('BOX_ACCOUNTS_NEW_PROJECT', 'Proyecto Nuevo');
define('TEXT_JAN', 'Ene');
define('TEXT_FEB', 'Feb');
define('TEXT_MAR', 'Mar');
define('TEXT_APR', 'Abr');
define('TEXT_MAY', 'May');
define('TEXT_JUN', 'Jun');
define('TEXT_JUL', 'Jul');
define('TEXT_AUG', 'Ago');
define('TEXT_SEP', 'Sep');
define('TEXT_OCT', 'Oct');
define('TEXT_NOV', 'Nov');
define('TEXT_DEC', 'Dic');
define('TEXT_SUN', 'D');
define('TEXT_MON', 'L');
define('TEXT_TUE', 'M');
define('TEXT_WED', 'M');
define('TEXT_THU', 'J');
define('TEXT_FRI', 'V');
define('TEXT_SAT', 'S');

// **************  Release 1.8 changes  ********************
define('BOX_BANKING_CUSTOMER_DEPOSITS', 'Depósitos De Clientes');
define('GEN_CALENDAR_FORMAT_ERROR', "¡El formato de fecha está malo, revise todas las fechas! Recibido: %s. (Formato de Fecha: " . DATE_FORMAT . ") Revise el SEPARATOR en /modules/general/language/langname/language.php que sea consistente con SpiffyCal: " . DATE_FORMAT_SPIFFYCAL);

// **************  Release 1.7 and earlier  ********************
// header text in includes/header.php
define('HEADER_TITLE_TOP', 'Inicio');
define('HEADER_TITLE_LOGOFF', 'Salir');

// Menu heading translations
define('MENU_HEADING_CUSTOMERS', 'Clientes');
define('MENU_HEADING_VENDORS', 'Proveedores');
define('MENU_HEADING_INVENTORY', 'Inventario');
define('MENU_HEADING_BANKING', 'Bancos');
define('MENU_HEADING_GL', 'Contabilidad');
define('MENU_HEADING_EMPLOYEES', 'Empleados');
define('MENU_HEADING_SETUP', 'Configuración');
define('MENU_HEADING_TOOLS', 'Herramientas');
define('MENU_HEADING_QUALITY','Control Calidad');
define('MENU_HEADING_REPORTS', 'Reportes');
define('MENU_HEADING_COMPANY', 'Compañía');

// Report Group Definitions (import/export tabs, reports/forms)
define('TEXT_RECEIVABLES','Cuentas por Cobrar');
define('TEXT_PAYABLES','Cuentas por Pagar');
define('TEXT_INVENTORY','Inventario');
define('TEXT_HR','Empleados');
define('TEXT_MANUFAC','Ensamblaje');
define('TEXT_BANKING','Bancos');
define('TEXT_GL','Contabilidad');
define('TEXT_MISC','Varios');

// General Ledger Menu Labels
define('BOX_GL_JOURNAL_ENTRY', 'Registro Contable');
define('BOX_GL_ACCOUNTS', 'Cuadro de Cuentas');
define('BOX_GL_UTILITIES', 'Utilitarios Contabilidad');

// Accounts Menu Labels
define('BOX_ACCOUNTS_NEW_CUSTOMER', 'Cliente Nuevo');
define('BOX_ACCOUNTS_MAINTAIN_CUSTOMERS', 'Lista de Clientes');
define('BOX_ACCOUNTS_NEW_EMPLOYEE', 'Empleado Nuevo');
define('BOX_ACCOUNTS_MAINTAIN_EMPLOYEES', 'Lista de Empleados');
define('BOX_ACCOUNTS_NEW_VENDOR', 'Proveedor Nuevo');
define('BOX_ACCOUNTS_MAINTAIN_VENDORS', 'Lista de Proveedores');
define('BOX_ACCOUNTS_NEW_BRANCH', 'Tienda Nueva');
define('BOX_ACCOUNTS_MAINTAIN_BRANCHES', 'Lista de Tiendas');

// Banking Menu Labels
define('BOX_BANKING_CUSTOMER_RECEIPTS', 'Recibo de Dinero de Clientes');
define('BOX_BANKING_CUSTOMER_PAYMENTS', 'Pague a Clientes');
define('BOX_BANKING_PAY_BILLS', 'Pague a Proveedores');
define('BOX_BANKING_VENDOR_RECEIPTS', 'Reembolsos de Proveedores');
define('BOX_BANKING_SELECT_FOR_PAYMENT', 'Seleccione para Pagar');
define('BOX_BANKING_BANK_ACCOUNT_REGISTER', 'Registro de Cuentas de Efectivo');
define('BOX_BANKING_ACCOUNT_RECONCILIATION', 'Reconciliación de Cuentas');
define('BOX_BANKING_VOID_CHECKS', 'Cheques Anulados');

// HR Menu Labels
define('BOX_HR_MAINTAIN_REPS','Vendedores');
define('BOX_HR_PAYROLL_ENTRY', 'Planilla');
define('BOX_HR_DEPARTMENTS', 'Departamentos');
define('BOX_HR_DEPT_TYPES', 'Tipos de Departmentos');

// Inventory Menu labels
define('BOX_INV_MAINTAIN', 'Lista de Códigos');
define('BOX_INV_PURCHASE_RECEIVE', 'Comprar/Ingresar');
define('BOX_INV_ADJUSTMENTS', 'Ajuste de Inventario');
define('BOX_INV_ASSEMBLIES', 'Ensamblajes');
define('BOX_INV_DEFAULTS', 'Inventario-Valores Pred');
define('BOX_INV_REPORTS', 'Reportes');
define('BOX_INV_TABS', 'Pestañas Inventario');
define('BOX_INV_FIELDS', 'Campos de la Base de Datos de Inventario');
define('BOX_INV_TRANSFER','Traslado de Inventario');

// Payables Menu Labels
define('BOX_AP_PURCHASE_ORDER', 'Órden De Compra Nueva');
define('BOX_AP_CREDIT_MEMO', 'Créditos De Proveedores');
define('BOX_AP_DEFAULTS', 'Proveedores-Valores Pred');
define('BOX_AP_REPORTS', 'Reportes');
define('BOX_AP_REQUEST_QUOTE', 'Solicitud de Cotización a Proveedor Nueva');
define('BOX_AP_RECEIVE_INVENTORY', 'Comprar/Ingresar');
define('BOX_AP_ORDER_STATUS', 'Lista de Órdenes de Compra');
//define('BOX_AP_WRITE_CHECK', 'Write Checks');

// Receivables Menu Labels
define('BOX_AR_SALES_ORDER', 'Órden De Venta Nueva');
define('BOX_AR_QUOTE', 'Cotización Nueva');
define('BOX_AR_INVOICE', 'Factura Nueva');
define('BOX_AR_CREDIT_MEMO', 'Nota de Crédito Nueva');
define('BOX_AR_SHIPMENTS', 'Fletes');
define('BOX_AR_ORDER_STATUS', 'Lista de Órdenes de Venta');
define('BOX_AR_DEFAULTS', 'Clientes-Valores Pred ');
//define('BOX_AR_POINT_OF_SALE','Point of Sale');
define('BOX_AR_INVOICE_MGR', 'Lista de Facturas');

// Setup/Misc Menu Labels
define('BOX_TAX_AUTH', 'Autoridad Impuesto Ventas');
define('BOX_TAX_AUTH_VEND', 'Autoridad Impuesto Compras');
define('BOX_TAX_RATES', 'Tasa Impuesto Ventas');
define('BOX_TAX_RATES_VEND', 'Tasa Impuesto Compras');
define('BOX_TAXES_COUNTRIES', 'Lista de Paises');
define('BOX_TAXES_ZONES', 'Lista de Provincias/Estados');
define('BOX_CURRENCIES', 'Lista de Monedas');
define('BOX_LANGUAGES', 'Idiomas');

// Configuration and defaults menu
define('BOX_HEADING_SEARCH','Busque Transacciones');
define('BOX_HEADING_USERS','Lista de Usuarios');
define('BOX_HEADING_BACKUP','Respaldo de Archivo de Compañía');
define('BOX_COMPANY_CONFIG','Valores De Configuración');

// Tools Menu Labels
define('BOX_HEADING_ENCRYPTION', 'Encriptado de Datos');
define('BOX_IMPORT_EXPORT', 'Importar/Exportar');
define('BOX_SHIPPING_MANAGER', 'Admin Fletes');
define('BOX_COMPANY_MANAGER', 'Administración de Compañías');
define('BOX_HEADING_ADMIN_TOOLS', 'Herramientas Administrativas');

// Services Menu Labels
define('BOX_SHIPPING', 'Preferencias Fletes');
define('BOX_PAYMENTS', 'Preferencias Forma Pago');
define('BOX_PRICE_SHEETS', 'Configuración Escala de Precios');
define('BOX_PRICE_SHEET_MANAGER', 'Lista de Escalas de Precios');

// Quality Menu Labels
define('BOX_QUALITY_HOME','Inicio Control Calidad');

// General Headings
define('GEN_HEADING_PLEASE_SELECT','Seleccione...');

// User Manager
define('HEADING_TITLE_USERS','Usuarios');
define('HEADING_TITLE_USER_INFORMATION','Usuarios');
define('HEADING_TITLE_SEARCH_INFORMATION','Busque Transacciones');

// Address/contact identifiers
define('GEN_PRIMARY_NAME', 'Nombre/Compañía');
define('GEN_EMPLOYEE_NAME', 'Empleado');
define('GEN_CONTACT', 'Atención');
define('GEN_ADDRESS1', 'Dirección');
define('GEN_ADDRESS2', 'Dirección Línea 2');
define('GEN_CITY_TOWN', 'Ciudad');
define('GEN_STATE_PROVINCE', 'Provincia/Estado');
define('GEN_POSTAL_CODE', 'Código Postal');
define('GEN_COUNTRY', 'País');
define('GEN_COUNTRY_CODE', 'Código ISO País');
define('GEN_FIRST_NAME','Primer Nombre');
define('GEN_MIDDLE_NAME','Segundo Nombre');
define('GEN_LAST_NAME','Apellidos');
define('GEN_TELEPHONE1', 'Teléfono 1');
define('GEN_TELEPHONE2', 'Teléfono 2');
define('GEN_FAX','Fax');
define('GEN_TELEPHONE4', 'Celular');
define('GEN_USERNAME','Usuario');
define('GEN_DISPLAY_NAME','Nombre A Mostrar');
define('GEN_ACCOUNT_ID', 'Cuenta');
define('GEN_CUSTOMER_ID', 'Cliente :');
define('GEN_STORE_ID', 'Tienda');
define('GEN_VENDOR_ID', 'Proveedor:');
define('GEN_EMAIL','Correo Electrónico');
define('GEN_WEBSITE','Sitio Internet');
define('GEN_ACCOUNT_LINK','Enlace A Cuenta de Empleado');

// General definitions
define('TEXT_ABSCISSA','Abscissa (X)');
define('TEXT_ACCOUNT_TYPE','Tipo De Cuenta');
define('TEXT_ACCOUNTING_PERIOD','Período Contable');
define('TEXT_ACCOUNTS','Cuentas');
define('TEXT_ACCT_DESCRIPTION','Descripción De la Cuenta');
define('TEXT_ACTIVE','En Uso');
define('TEXT_ACTION','Acción');
define('TEXT_ADD','Agregue');
define('TEXT_ADJUSTMENT','Ajuste');
define('TEXT_ALL','Todos');
define('TEXT_ALIGN','Alineamiento');
define('TEXT_AMOUNT','Monto');
define('TEXT_AND','y');
define('TEXT_BACK','Regrese');
define('TEXT_BALANCE','Saldo');
define('TEXT_BOTTOM','Inferior');
define('TEXT_BREAK','Brinque');
define('TEXT_CANCEL','Cierre');
define('TEXT_CARRIER','Transportista');
define('TEXT_CATEGORY_NAME', 'Categoría');
define('TEXT_CAUTION','Advertencia');
define('TEXT_CENTER','Centro');
define('TEXT_CHANGE','Cambie');
define('TEXT_CLEAR','Cobrado');
define('TEXT_CLOSE','Cierre');
define('TEXT_COLLAPSE','Cierre');
define('TEXT_COLLAPSE_ALL','Cierre Todos');
define('TEXT_COLOR','Color');
define('TEXT_COLUMN','Columna');
define('TEXT_CONTAINS','Contiene');
define('TEXT_COPY','Copie');
define('TEXT_COPY_TO','Copie A');
define('TEXT_CONFIRM_PASSWORD','Confirme Contraseña');
define('TEXT_CONTINUE','Continue');
define('TEXT_CREDIT_AMOUNT','Débito');
define('TEXT_CRITERIA','Criterio');
define('TEXT_CUSTCOLOR','Color (Rango 0-255)');
define('TEXT_CURRENCY','Moneda');
define('TEXT_CURRENT','Actual');
define('TEXT_CUSTOM','Especial');
define('TEXT_DATE','Fecha');
define('TEXT_DEBIT_AMOUNT','Crédito');
define('TEXT_DELETE','Borre');
define('TEXT_DEFAULT','Predeterminado');
define('TEXT_DEPARTMENT','Departamento');
define('TEXT_DESCRIPTION','Descripción');
define('TEXT_DISCOUNT','Descuento');
define('TEXT_DOWN','Baje');
define('TEXT_EDIT','Edite');
define('TEXT_ENTER_NEW','Digite Nuevo...');
define('TEXT_ERROR','Error');
define('TEXT_EQUAL','Igual A');
define('TEXT_ESTIMATE','Cotización');
define('TEXT_EXPAND','Expanda');
define('TEXT_EXPAND_ALL','Expanda Todo');
define('TEXT_EXPORT','Exporte');
define('TEXT_EXPORT_CSV','Exporte Formato CSV');
define('TEXT_EXPORT_PDF','Exporte Formato PDF');
define('TEXT_FALSE','Falso');
define('TEXT_FIELD','Campo');
define('TEXT_FIELDS','Campos');
define('TEXT_FILE_UPLOAD','Cargar Archivo');
define('TEXT_FILL','Llene');
define('TEXT_FILTER','Filtro');
define('TEXT_FINISH','Termine');
define('TEXT_FORM','Formulario');
define('TEXT_FORMS','Formularios');
define('TEXT_FLDNAME','Nombre de Campo');
define('TEXT_FONT','Fuente');
define('TEXT_FROM','De');
define('TEXT_FULL','Completo');
define('TEXT_GENERAL','General'); // typical, standard
define('TEXT_GET_RATES','Consiga Tasa');
define('TEXT_GL_ACCOUNT','Cuenta');
define('TEXT_GREATER_THAN','Mayor Que');
define('TEXT_GROUP','Grupo');
define('TEXT_HEIGHT','Altura');
define('TEXT_HELP', 'Ayuda');
define('TEXT_HISTORY','Historia');
define('TEXT_HORIZONTAL','Horizontal');
define('TEXT_IMPORT','Importe');
define('TEXT_INACTIVE','Inactive');
define('TEXT_INFO','Información'); // Information
define('TEXT_INSERT','Inserte');
define('TEXT_INSTALL','Instale');
define('TEXT_INVOICE','Factura');
define('TEXT_INVOICES','Facturas');
define('TEXT_IN_LIST','En Lista (csv)');
define('TEXT_ITEMS','Códigos');
define('TEXT_JOURNAL_TYPE','Tipo de Diario');
define('TEXT_LEFT','Izquierdo');
define('TEXT_LENGTH','Longitud');
define('TEXT_LESS_THAN','Menor Que');
define('TEXT_LEVEL','Nivel');
define('TEXT_MOVE','Traslade');
define('TEXT_NA','N/A'); // not applicable
define('TEXT_NO','No.');
define('TEXT_NONE','-Ninguno-');
define('TEXT_NOTE', 'Nota:');
define('TEXT_NOTES','Notas');
define('TEXT_NEW','Nuevo');
define('TEXT_NOT_EQUAL','Diferente De');
define('TEXT_NUM_AVAILABLE','# Disponible');
define('TEXT_NUM_REQUIRED','# Requerido');
define('TEXT_OF','de');
define('TEXT_OPEN','Abra');
define('TEXT_OPTIONS','Opciones');
define('TEXT_ORDER','Órden');
define('TEXT_ORDINATE','Ordenada(Y)');
define('TEXT_PAGE','Página');
define('TEXT_PAID','Cancelado');
define('TEXT_PASSWORD','Contraseña');
define('TEXT_PAY','Pague');
define('TEXT_PAYMENT','Pago');
define('TEXT_PAYMENT_METHOD','Forma De Pago');
define('TEXT_PAYMENTS','Pagos');
define('TEXT_PERIOD','Período');
define('TEXT_PGCOYNM','Nombre De La Compañía');
define('TEXT_POST_DATE', 'Fecha de la Transacción');
define('TEXT_PRICE', 'Precio');
define('TEXT_PRICE_MANAGER', 'Escala de Precios');
define('TEXT_PRINT','Imprima');
define('TEXT_PRINTED','Impreso');
define('TEXT_PROCESSING','Procesando');
define('TEXT_PROPERTIES','Propiedades');
define('TEXT_PO_NUMBER','OC No.');
define('TEXT_QUANTITY','Cantidad');
define('TEXT_RANGE','Rango');
define('TEXT_READ_ONLY','Solo Lectura');
define('TEXT_RECEIVE','Ingrese');
define('TEXT_RECEIVE_ALL','Ingrese OC');
define('TEXT_RECEIPTS','Recibos');
define('TEXT_RECUR','Memorice');
define('TEXT_REFERENCE','Referencia');
define('TEXT_REMOVE','Borre');
define('TEXT_RENAME','Cambie el Nombre');
define('TEXT_REPLACE','Reemplace');
define('TEXT_REPORT','Reporte');
define('TEXT_REPORTS','Reportes');
define('TEXT_RESET','Reinicie');
define('TEXT_RESULTS','Resultados');
define('TEXT_REVISE','Revice');
define('TEXT_RIGHT','Derecho');
define('TEXT_SAVE','Salve');
define('TEXT_SAVE_AS','Salve Como');
define('TEXT_SEARCH','Busque');
define('TEXT_SECURITY','Seguridad');
define('TEXT_SECURITY_SETTINGS','Parámetros De Seguridad');
define('TEXT_SELECT','Seleccione');
define('TEXT_SEND','Envie');
define('TEXT_SEPARATOR','Separador');
define('TEXT_SERIAL_NUMBER','Número De Serie');
define('TEXT_SERVICE_NAME','Servicio');
define('TEXT_SEQUENCE','Secuencia');
define('TEXT_SHIP','Envíe');
define('TEXT_SHIP_ALL','Entregue OV');
define('TEXT_SHOW','Muestre');
define('TEXT_SLCTFIELD','Seleccione un campo...');
define('TEXT_SEQ','Secuencia');
define('TEXT_SIZE','Tamaño');
define('TEXT_SKU','Código');
define('TEXT_SORT','Ordene');
define('TEXT_SORT_ORDER','Ordenamiento');
define('TEXT_SOURCE', 'Fuente');
define('TEXT_STATUS','Estatus');
define('TEXT_STATISTICS','Estadísticas');
define('TEXT_STDCOLOR','Color Estandar');
define('TEXT_SUCCESS','Éxito');
define('TEXT_SYSTEM','Sistema');
define('TEXT_TIME','Hora');
define('TEXT_TITLE','Título');
define('TEXT_TO','A');
define('TEXT_TOP','Superior');
define('TEXT_TOTAL','Total');
define('TEXT_TRANSACTION_DATE','Fecha de Transacción');
define('TEXT_TRANSACTION_TYPE','Tipo de Transacción');
define('TEXT_TRIM','Recorte');
define('TEXT_TRUE','Verdadero');
define('TEXT_TRUNCATE','Recorte');
define('TEXT_TRUNC','Recorte Descripciones Largas');
define('TEXT_TYPE','Tipo');
define('TEXT_UNIT_PRICE','Precio');
define('TEXT_UNPRINTED','Sin Imprimir');
define('TEXT_UP','Suba');
define('TEXT_UPDATE','Actualice');
define('TEXT_URL','URL');
define('TEXT_USERS','Usuario');
define('TEXT_UTILITIES','Utilitarios');
define('TEXT_VALUE','Valor');
define('TEXT_VERTICAL','Vertical');
define('TEXT_VIEW','Vista');
define('TEXT_VIEW_SHIP_LOG','Bitácora de Envíos');
define('TEXT_WEIGHT','Peso');
define('TEXT_WIDTH','Ancho');
define('TEXT_YES','Sí');

// javascript messages
define('JS_ERROR','Ocurrieron errores procesando su formulario!\nHaga las siguientes correcciones:\n\n');
define('JS_CTL_PANEL_DELETE_BOX','¿Realmente quiere borrar este cuadro?');
define('JS_CTL_PANEL_DELETE_IDX','¿Realmente quiere borrar este índice?');

// Audit log messages
define('GEN_LOG_LOGIN','Usuario-> ');
define('GEN_LOG_LOGIN_FAILED','Falló Login - id -> ');
define('GEN_LOG_LOGOFF','Salir -> ');
define('GEN_LOG_RESEND_PW','Renviar contraseña a correo -> ');
define('GEN_LOG_USER_ADD','Mantenimiento de Usuarios - Usuario Agregado -> ');
define('GEN_LOG_USER_COPY','Mantenimiento de Usuarios - Duplique');
define('GEN_MSG_COPY_INTRO','Digite su nuevo nombre de usuario.');
define('GEN_ERROR_DUPLICATE_ID','El usuario ya existe. Seleccione otro usuario.');
define('GEN_MSG_COPY_SUCCESS','El usuario fue duplicado.  Digite la contraseña y el resto de datos de este usuario nuevo.');
define('GEN_LOG_USER_UPDATE','Mantenimiento de Usuario - Actualizar Usuario -> ');
define('GEN_LOG_USER_DELETE','Mantenimiento de Usuario - Borrar Usuario -> ');
define('GEN_DB_DATA_BACKUP','Respaldo de Base Datos de la Compañía');
define('GEN_LOG_PERIOD_CHANGE','Período Contable - Cambio');

// constants for use in prev_next_display function
define('TEXT_SHOW_NO_LIMIT', ' (0 para ilimitado) ');
define('TEXT_RESULT_PAGE', 'Página %s de %d');
define('TEXT_GO_FIRST','Brinque a la primera página');
define('TEXT_GO_PREVIOUS','Página anterior');
define('TEXT_GO_NEXT','Página siguiente');
define('TEXT_GO_LAST','Brinque a la última página');
define('TEXT_DISPLAY_NUMBER', 'Mostrando <b>%d</b> a <b>%d</b> (de <b>%d</b>) ');
define('PREVNEXT_BUTTON_PREV', '&lt;&lt;');
define('PREVNEXT_BUTTON_NEXT', '&gt;&gt;');
define('TEXT_FIELD_REQUIRED', '&nbsp;<span class="fieldRequired">*</span>');

// misc error messages
define('GEN_ERRMSG_NO_DATA','Un campo requerido está en blanco.  Campo: ');
define('ERROR_MSG_ACCT_PERIOD_CHANGE','El período contable ha sido automáticamente cambiado a: %s');
define('ERROR_MSG_BAD_POST_DATE','¡Advertencia! La fecha del registro cae fuera del actual período contable!');
define('ERROR_MSG_POST_DATE_NOT_IN_FISCAL_YEAR','la fecha del registro especificado no está dentro de los períodos fiscales actualmente definidos.  Cambie la fecha del registro o agregue el período fiscal necesario.');
define('ERROR_NO_PERMISSION','Usted no tiene permiso para hacer la operación solicitada.  Contacte el administrador para solicitar el permiso requerido.');
define('ERROR_NO_SEARCH_PERMISSION','Usted no tiene permiso para ver el resultado de esta búsqueda.');
define('ERROR_NO_DEFAULT_CURRENCY_DEFINED', 'Error: No hay una moneda definida como predeterminada.  Defina una en:  Configuración->Lista de Monedas');
define('ERROR_CANNOT_CREATE_DIR','La carpeta para respaldo no se pudo crear en /my_files.  Revise los permisos.');
define('ERROR_COMPRESSION_FAILED','El respaldo comprimido falló: ');
define('TEXT_EMAIL','Correo: ');
define('TEXT_SENDER_NAME','Envía: ');
define('TEXT_RECEPIENT_NAME','Para: ');
define('TEXT_MESSAGE_SUBJECT','Asunto: ');
define('TEXT_MESSAGE_BODY','Contenido: ');
define('EMAIL_SEND_FAILED','El correo no se pudo enviar.');
define('EMAIL_SEND_SUCCESS','El correo se fue exitósamente.');
define('GEN_PRICE_SHEET_CURRENCY_NOTE','NOTA: Todos los montos están en: %s');
define('DEBUG_TRACE_MISSING','No se encontró el archivo de comandos ejecutados.  Asegúrese que capture los comandos ejecutados antes de intentar descargar el archivo!');

// search filters
define('TEXT_ASC','Asc');
define('TEXT_DESC','Desc');
define('TEXT_INFO_SEARCH_DETAIL_FILTER','Filtro de Búsqueda: ');
define('TEXT_INFO_SEARCH_PERIOD_FILTER','Período Contable: ');
define('HEADING_TITLE_SEARCH_DETAIL','Búsqueda: ');
define('TEXT_TRANSACTION_AMOUNT','Monto de la Transacción');
define('TEXT_REFERENCE_NUMBER','Número de Factura/Orden');
define('TEXT_CUST_VEND_ACCT','Cuenta de Cliente/Proveedor');
define('TEXT_INVENTORY_ITEM','Código de Inventario');
define('TEXT_GENERAL_LEDGER_ACCOUNT','Cuenta');
define('TEXT_JOURNAL_RECORD_ID','Registro No.');

// Version Check notices
define('TEXT_VERSION_CHECK_NEW_VER','Una nueva versión de PhreeBooks está disponible.  Su versión instalada es: <b>%s</b> La versión disponible es = <b>%s</b>');

// control panel defines
define('CP_ADD_REMOVE_BOXES','Muestre/Oculte Vistas del Perfil');
define('CP_CHANGE_PROFILE','Cambio de Perfil...');

// Defines for login screen
define('HEADING_TITLE', 'Identificación');
define('TEXT_LOGIN_NAME', 'Usuario: ');
define('TEXT_LOGIN_PASS', 'Contraseña: ');
define('TEXT_LOGIN_ENCRYPT', 'Clave (Deje en blanco si no usa): ');
define('TEXT_LOGIN_COMPANY','Empresa: ');
define('TEXT_LOGIN_LANGUAGE','Seleccione Idioma: ');
define('TEXT_LOGIN_THEME','Seleccione Tema: ');
define('TEXT_LOGIN_BUTTON','Acceder');
define('ERROR_WRONG_LOGIN', 'Usuario o contraseña incorrecto');
define('TEXT_PASSWORD_FORGOTTEN', 'Recuperar contraseña ');

// Defines for users.php
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'La confirmación de la contraseña debe corresponder con la contraseña nueva .');
define('ENTRY_PASSWORD_NEW_ERROR', 'Su contraseña debe tener un mínimo de ' . ENTRY_PASSWORD_MIN_LENGTH . ' caracteres.');
define('TEXT_DELETE_INTRO_USERS', '¿Está seguro que quiere borrar la cuenta de este usuario?');
define('TEXT_DELETE_ENTRY', '¿Está seguro que quiere borrar esta cuenta?');
define('TEXT_FILL_ALL_LEVELS','Marque todos');

// defines for password forgotten
define('LOST_HEADING_TITLE', 'Solicite Contraseña Nueva');
define('TEXT_ADMIN_EMAIL', 'Dirección de correo electrónico: ');
define('ERROR_WRONG_EMAIL', '<p>Digitó el correo electrónico equivocado.</p>');
define('ERROR_WRONG_EMAIL_NULL', '<p>Adiós:-P</p>');
define('SUCCESS_PASSWORD_SENT', '<p>Una contraseña nueva le será enviada a su correo electrónico.</p>');
define('TEXT_EMAIL_SUBJECT', 'Usted solicitó una contraseña nueva');
define('TEXT_EMAIL_FROM', EMAIL_FROM);
define('TEXT_EMAIL_MESSAGE', 'Una contraseña nueva fue enviada a su correo electrónico.' . "\n\n" . 'Su contraseña nueva para la compañía \'' . COMPANY_NAME . '\' es:' . "\n\n" . '   %s' . "\n\n");

// Error messages for importing reports, forms and import/export functions
define('TEXT_IMP_ERMSG1','El tamaño del archivo excede el tamaño de la directiva upload_max_filesize en la configuración de php.ini.');
define('TEXT_IMP_ERMSG2','El tamaño del archivo excede la directiva MAX_FILE_SIZE en el formulario de PhreeBooks.');
define('TEXT_IMP_ERMSG3','El archivo no se importó completamente.  Vuelva a intentar.');
define('TEXT_IMP_ERMSG4','No seleccionó ningún archivo para importar.');
define('TEXT_IMP_ERMSG5','Error de importación php desconocido, php dió error número: ');
define('TEXT_IMP_ERMSG6','El servidor reporta que el archivo no es de texto.');
define('TEXT_IMP_ERMSG7','¡El archivo a importar no contiene datos!');
define('TEXT_IMP_ERMSG8','¡PhreeBooks no pudo encontrar un reporte válido para importar en el archivo!');
define('TEXT_IMP_ERMSG9',' fue exitósamente importado!');
define('TEXT_IMP_ERMSG10','¡Hubo un error inesperado importando el archivo!');
define('TEXT_IMP_ERMSG11','¡El archivo se importó exitósamente!');
define('TEXT_IMP_ERMSG12','¡El archivo de exportación no contiene datos!');
define('TEXT_IMP_ERMSG13','¡Hubo un error inesperado importando el archivo!  No se importó el archivo.');
define('TEXT_IMP_ERMSG14','Error en el archivo de entrada. ¡Se encontraron mas de 2 calificadores de texto!  El texto con problemas es: ');
define('TEXT_IMP_ERMSG15','¡El archivo de importación debe tener un índice de referencia para procesarlo!  Incluya datos y revise que la casilla \'Muestre\' para ese campo esté marcado: ');

/********************* Release R1.7 additions *************************/
define('BOX_INV_TOOLS','Herramientas de Inventario');

/********************* Release R1.8 additions *************************/
// Configuration Groups - Moved menu from DB to here since it's loaded every time, allows translation
// code CD_xx_TITLE : CG - config group, xx - index, must match with menu_navigation.php
define('CG_01_TITLE','Mi Compañía');
define('CG_01_DESC', 'Informacion general sobre mi compañía');
define('CG_02_TITLE','Clientes Nuevos');
define('CG_02_DESC', 'Preferencias para Clientes Nuevos');
define('CG_03_TITLE','Proveedores Nuevos');
define('CG_03_DESC', 'Preferencias para Proveedores Nuevos');
define('CG_04_TITLE','Empleados Nuevos');
define('CG_04_DESC', 'Preferencias para Empleados Nuevos');
define('CG_05_TITLE','Códigos de Inventario Nuevos');
define('CG_05_DESC', 'Preferencias para Códigos de Inventario Nuevos');
define('CG_07_TITLE','Usuarios Nuevos');
define('CG_07_DESC', 'Preferencias para Usuarios Nuevos');
define('CG_08_TITLE','Generales');
define('CG_08_DESC', 'Preferencias Generales');
define('CG_09_TITLE','Importar/Exportar');
define('CG_09_DESC', 'Preferencias para Importar/Exportar información');
define('CG_10_TITLE','Envíos');
define('CG_10_DESC', 'Preferencias para Envíos/Fletes');
define('CG_11_TITLE','Libro de Direcciones');
define('CG_11_DESC', 'Preferencias para el Libro de Direcciones');
define('CG_12_TITLE','Correo Electrónico');
define('CG_12_DESC', 'Preferencias para correo electrónico con HTML');
define('CG_13_TITLE','Cuentas');
define('CG_13_DESC', 'Preferencias para las cuentas');
define('CG_15_TITLE','Sesiones');
define('CG_15_DESC', 'Opciones para las sesiones');
define('CG_17_TITLE','Tarjetas de Crédito');
define('CG_17_DESC', 'Tarjetas de Crédito aceptadas');
define('CG_19_TITLE','Parámetros de Diseño');
define('CG_19_DESC', 'Parámetros de Diseño');
define('CG_20_TITLE','Manteniemiento del Servidor');
define('CG_20_DESC', 'Preferencias para Manteniemiento del Servidor');

/********************* Release R1.9 additions *************************/
define('TEXT_EMPLOYEE','Empleado');
define('TEXT_SALES_REP','Vendedor');
define('TEXT_BUYER','Comprador');




?>
