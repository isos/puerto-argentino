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
//  Path: /modules/reportwriter/language/es_cr/language.php
// 


define('RW_FONT_HELVETICA','helvetica');
define('RW_FONT_COURIER','Courier');
define('RW_FONT_TIMES','Times Roman');
define('RW_FONT_SERIF','Serif');
define('RW_FONT_SANS','Sans'); //ADDED RL20100117

if (!defined('PDF_APP')) define('PDF_APP','TCPDF'); // possible choices are FPDF and TCPDF 
$Fonts = array (
  'helvetica' => RW_FONT_HELVETICA,
  'courier'   => RW_FONT_COURIER,
  'times'     => RW_FONT_TIMES,
);
if (PDF_APP == 'TCPDF') {
  $Fonts['freeserif'] = RW_FONT_SERIF;
  $Fonts['freesans'] = RW_FONT_SANS;  //ADDED RL20100117
  define('PDF_DEFAULT_FONT','freeserif');
 
} else {
  define('PDF_DEFAULT_FONT','helvetica');
}

// Reportwriter Defaults
define('RW_DEFAULT_COLUMN_WIDTH','25'); // in millimeters
define('RW_DEFAULT_MARGIN','8'); // in millimeters
define('RW_DEFAULT_TITLE1', '%reportname%');
define('RW_DEFAULT_TITLE2', 'Reporte Generado %date%');
define('RW_DEFAULT_PAPERSIZE', 'Carta:216:282'); // must match id from array $PaperSizes defined below
define('RW_DEFAULT_ORIENTATION', 'V');

// **************  Release 2.0 changes  ********************
define('RW_FRM_RNDDECIMAL','Número de decimales para redondeo');
define('RW_FRM_RNDPRECISE','Precisión de Roundeo ');
define('RW_SERIAL_FORM','Crea un formulario secuencial (para uso principalmente con impresoras de matriz de puntos y termales).  Las propiedades de la página serán limitadas ya que la información está basada en la secuencia de la lista de campos.  Si no está seguro, deje la casilla sin marcar.');

// **************  Release 1.9 changes  ********************
define('RW_FRM_SET_PRINTED','Fije Indicador de Impresión');
define('RW_FRM_SET_PRINTED_NOTE','Dé un valor de 1 al campo seleccionado después de que cada formulario se genera.  El campo debe estar en la misma tabla que el campo de cambio de página.');
define('TEXT_CC_NAME','CC:');
define('RW_TEXT_DISPLAY_ON','Muestre:');
define('RW_TEXT_ALL_PAGES','Todas las Páginas');
define('RW_TEXT_FIRST_PAGE','Primera Página');
define('RW_TEXT_LAST_PAGE','Última Página');
define('RW_TEXT_TOTAL_ONLY','Muestre Solamente Totales');
define('TEXT_DUPLICATE','Duplicado');
define('RW_FRM_PRINTED','Indicador de Impresión');



// **************  Release 1.8 changes  ********************
define('RW_FRM_PAGE_BREAK','Campo para Cambio de Página del Formulario (table.fieldname)');
define('RW_RPT_PAGE_BREAK','Agrupación Cambio de Página');
define('RW_NULL_PCUR','Nulo 0 - Moneda Seleccionada');
define('RW_DEF_CUR','Moneda Predeterminada');
define('RW_NULL_DCUR','Nulo 0 - Moneda Predeterminada');
define('RW_EMAIL_MSG_DETAIL','Cuerpo del mensaje de correo electrónico');

// **************  Release 1.7 changes  ********************
define('RW_BAR_CODE','Imagen Código de Barras');
define('RW_TEXT_GROUP_TOTAL_FOR','Total del Grupo: ');
define('RW_TEXT_REPORT_TOTAL_FOR','Total del Reporte: ');
define('RW_FRM_YES_SKIP_NO','Sí, En Blanco No');
define('RW_TEXT_PURCHASES','Compras');

// Headings
define('RW_HEADING_TITLE','Reportes y Formularios');

// Report and Form page title definitions
define('RW_TITLE_RPTFRM','Reporte/Formulario: ');
define('RW_TITLE_RPRBLDR','Constructor de Reportes y Formularios - ');
define('RW_TITLE_REPORT_GEN','Generador de Reporte ');
define('RW_TITLE_STEP1','Menú');
define('RW_TITLE_STEP2','Paso 2');
define('RW_TITLE_STEP3','Paso 3');
define('RW_TITLE_STEP4','Paso 4');
define('RW_TITLE_STEP5','Paso 5');
define('RW_TITLE_STEP6','Paso 6');
define('RW_TITLE_MENU','Menú de Reportes');
define('RW_TITLE_CRITERIA','Configuración de Criterios');
define('RW_TITLE_PAGESAVE','Salve Reporte');
define('RW_TITLE_PAGESETUP','Configuración de Página del Reporte');
define('RW_TITLE_SECURITY','Configuración de Permisos');

// Javascript messages
define('RW_JS_SELECT_REPORT','¡Seleccione un reporte o formulario!');
define('RW_JS_ENTER_EXPORT_NAME','Digite el nombre para esta definición');
define('RW_JS_ENTER_DESCRIPTION','Digite una descripción para esta definición');

// General 
define('TEXT_AUTO_ALIGN','Alinie Automáticamene');
define('TEXT_CONTINUED','Continúa');
define('TEXT_PAGE_SETUP','Configuración de Página');
define('TEXT_DB_LINKS','Relaciones de la base de datos');
define('TEXT_FIELD_SETUP','Configuración de Campo');
define('TEXT_CRITERIA','Criterios para Filtro');
define('GL_CURRENT_PERIOD','Período Actual');
define('TEXT_USE_ACCOUNTING_PERIODS','Use Períodos Contables (campo: período)');
define('TEXT_ALL_USERS','Permita a todos los usuarios');
define('TEXT_ALL_EMPLOYEES','Permita a todos los empleados');
define('TEXT_ALL_DEPTS','Permita a todos los departamentos');
define('TEXT_FORM_FIELD','Campo de Formulario: ');
define('RW_NARRATIVE_DETAIL','Descripción Detallada (255 caracteres máximo)');
define('RW_FORM_DELIVERY_METHOD','Método de Entrega para el Formulario');
define('RW_RPT_DELIVERY_METHOD','Método de Entrega para el Reporte');
define('RW_BROWSER','Navegador: ');
define('RW_DOWNLOAD','Descargar: ');
define('RW_DL_FILENAME_SOURCE','Archivo Fuente');
define('RW_TEXT_PREFIX','Prefijo: ');
define('RW_TEXT_SOURCE_FIELD',' Campo Fuente: ');
define('RW_TEXT_MIN_VALUE','Valor Mínimo');
define('RW_TEXT_MAX_VALUE','Valor Máximo');
define('RW_JOURNAL_DESCRIPTION','Descripción');

// Paper Size Definitions
define('TEXT_PAPER','Tamaño de Papel');
define('TEXT_PAPER_WIDTH','Ancho de Papel');
define('TEXT_ORIEN','Orientación');
define('TEXT_MM','mm');
define('TEXT_PORTRAIT','Vertical');
define('TEXT_LANDSCAPE','Horizontal');
define('TEXT_USEFUL_INFO','Información Útil');
define('TEXT_LEGAL','Legal');
define('TEXT_LETTER','Carta');


// Definitions for date selection dropdown list
define('TEXT_TODAY','Hoy');
define('TEXT_WEEK','Esta Semana');
define('TEXT_WTD','Semana a Hoy');
define('TEXT_MONTH','Este Mes');
define('TEXT_MTD','Mes a Hoy');
define('TEXT_QUARTER','Este Trimestre');
define('TEXT_QTD','Trimestre a Hoy');
define('TEXT_YEAR','Este Año');
define('TEXT_YTD','Año a Hoy');

// definitions for db tables
define('TEXT_TABLE1','Tabla 1');
define('TEXT_TABLE2','Tabla 2');
define('TEXT_TABLE3','Tabla 3');
define('TEXT_TABLE4','Tabla 4');
define('TEXT_TABLE5','Tabla 5');
define('TEXT_TABLE6','Tabla 6');

// Message definitions
define('RW_RPT_SAVEDEF','El nombre que digitó es el nombre de un reporte predeterminado.  Digite otro nombre para el reporte nuevo.');
define('RW_RPT_SAVEDUP','¡Ese nombre ya existe! Aprete remplazar para sobrescribir o digite un nuevo nombre y aprete continúe.');
define('RW_RPT_DUPDB','Hay un error en su seleccion de base de datos.  Revise los nombres de su base de datos y los enlaces.');
define('RW_RPT_BADFLD','Hay un error en su campo de base de datos en la descripción.  Revise y pruebe de nuevo.');
define('RW_RPT_BADDATA','Hay un error en uno de los campos de la base de datos.  Revise y pruebe de nuevo.');
define('RW_RPT_FUNC_NOT_FOUND','La función especial solicitada no se pudo encontrar.  La función especial solicitada es: ');
define('RW_RPT_EMPTYFIELD','Un campo de datos está en blanco y está localizado en secuencia número: ');
define('RW_RPT_EMPTYTABLE','No se encontró una tabla de datos original para crear un duplicado en los números de secuencia: ');
define('RW_RPT_NO_SPECIAL_REPORT','No se definió una función especial en el repore.  ¡Quítele la marca a la casilla o digite el nombre de una función!');
define('RW_RPT_NO_TABLE_DATA','Su declaración de tabla no devolvió ningún renglón de datos.  ¡Las tablas están vacías o hay un error en los enlaces de las declaraciones!');
define('RW_RPT_DEFDEL','¡Si reemplaza este reporte/formulario, el reporte/formulario original se borrará!');
define('RW_RPT_NODATA','¡No hay datos en este reporte basado en los criterios seleccionados!');
define('RW_RPT_NOROWS','¡Este reporte/formulario con los criterios de filtro seleccionados no contiene datos!');
define('RW_RPT_WASSAVED',' fue salvado y copiado al reporte: ');
define('RW_RPT_UPDATED','¡El nombre de este reporte ha sido actualizado!');
define('RW_FRM_NORPT','No seleccionó ningún formulario para esta operación.');
define('RW_RPT_NORPT','No seleccionó ningún reporte o formulario para esta operación.');
define('RW_RPT_NORPTTYPE','¡Debe seleccionar un tipo de Reporte o Formulario!');
define('RW_RPT_REPDUP','El nombre seleccionado ya está en uso.  ¡Seleccione un nuevo nombre para el reporte!');
define('RW_RPT_REPDEL','Aprete OK para borrar este reporte.');
define('RW_RPT_REPOVER','Aprete OK para sobrescribir este reporte.');
define('RW_RPT_NOSHOW','¡No hay reportes para mostrar!');
define('RW_RPT_NOFIELD','¡No hay campos de datos para mostrar!');
define('RW_FRM_RPTENTER','Digite un nombre para este formulario.');
define('RW_RPT_RPTENTER','Digite un nombre para este reporte.');
define('RW_RPT_RPTNOENTER','(Deje en blanco para usar el nombre del reporte predeterminado en el archivo de importe)');
define('RW_RPT_MAX30','(máximo 30 caracteres)');
define('RW_FRM_RPTGRP','Digite el grupo a que pertenece este formulario:');
define('RW_RPT_RPTGRP','Digite el grupo a que pertenece este reporte:');
define('RW_RPT_DEFIMP','Seleccione un reporte predeterminado a importar.');
define('RW_RPT_RPTBROWSE','o seleccione un reporte para cargar.');
define('RW_RPT_SPECIAL_REPORT','Reporte Especial (Solo Para Programadores)');
define('RW_RPT_CANNOT_EDIT','¡Este es un reporte modelo, los cambios no serán salvados! Debe hacer una copia del reporte, modificarlo y luego salvar los cambios.');
define('RW_FRM_NO_SELECTION','¡Seleccione un reporte o formulario!');
define('RW_RPT_EXPORT_SUCCESS','Exportó el reporte/formulario exitósamente.');
define('RW_RPT_EXPORT_FAILED','¡El reporte/formulario no se pudo exportar!');
define('RW_EMAIL_BODY',"Adjunto está su %s de %s \n\nPara ver el adjunto, debe tener software para leer un pdf instalado en su sistema.");

// Report  Specific
define('RW_RPT_RPTFILTER','Filtros del Reporte: ');
define('RW_RPT_GROUPBY','Agrupados por:');
define('RW_RPT_SORTBY','Ordenados por:');
define('RW_RPT_DATERANGE','Rango de Fechas:');
define('RW_RPT_CRITBY','Filtros:');
define('RW_RPT_ADMIN','Administrador de Página');
define('RW_RPT_BRDRLINE','Línea de Borde');
define('RW_RPT_BOXDIM','Dimensiones de la línea de borde sencilla (mm)');
define('RW_RPT_CRITTYPE','Tipo de Criterios');
define('RW_RPT_TYPECREATE','Seleccione el tipo de reporte o formulario a crear:');
define('RW_RPT_CUSTRPT','Reportes Personalizados');
define('RW_RPT_DATEDEF','Selección de Fecha Predeterminada');
define('RW_RPT_DATEFNAME','Nombre de campo de fecha (table.fieldname)');
define('RW_RPT_DATEINFO','Información de Fecha de Reporte');
define('RW_RPT_DATEINST','Quítele la marca a todas las casillas para reportes independientes de la fecha.  Deje el campo de Fecha en blanco');
define('RW_RPT_DATELIST','Lista de Campos de Fecha<br />(marque todos los que aplican)');
define('RW_RPT_DEFRPT','Reportes Modelo');
define('RW_RPT_ENDPOS','Posición Final (mm)');
define('RW_RPT_ENTRFLD','Digite un Nuevo Campo');
define('RW_RPT_FLDLIST','Lista de Campos');
define('RW_RPT_FORMOUTPUT','Seleccione un Formulario para la Salida');
define('RW_RPT_FORMSELECT','Selección de Formulario');
define('RW_RPT_GRPLIST','Lista de Agrupamiento');
define('RW_RPT_IMAGECUR','Imagen Actual');
define('RW_RPT_IMAGEUPLOAD','Cargar Archivo de Nueva Imagen');
define('RW_RPT_IMAGESEL','Selección de Imagen');
define('RW_RPT_IMAGESTORED','Seleccione Imagen Existente');
define('RW_RPT_IMAGEDIM','Dimensiones de la Imagen (mm)');
define('RW_RPT_LINEATTRIB','Atributos de Línea');
define('RW_RPT_LINEWIDTH','Ancho de Línea (pts) ');
define('RW_RPT_LINKEQ','Ecuación de Enlace (Vea Nota Abajo)');
define('RW_RPT_DB_LINK_HELP','Las ecuaciones de enlace deben estar escritas con sintaxis SQL.  Las tablas se pueden identificar por su nombre de la base de datos (como aparecen en el menú plegable), o mejor aún, por un seudónimo [tablex] (x = 1 a 6) encerrado en paréntesis cuadrados []. tablex es una referencia a la tabla seleccionada en el menú plegable de Nombres de Tablas.  Por ejemplo, [table1].id = [table2].ref_id enlazaría el campo id de la tabla seleccionada del menú Tabla 1 al campo ref_id de la tabla seleccionada del menú Tabla 2.  El uso de sinónomos permite la portabilidad de los reportes/formularios para permitir sufijos en los nombres de las tablas de la base de datos, en caso de usarse.  Después de digitar cada línea, el constructor de reportes verificará que la ecuación PUEDE definir una declaración válida en SQL.');
define('RW_RPT_FIELD_HELP','Nota: Si se muestran campos múltiples en una misma columna, el campo con el ancho de columna mayor determinará el ancho de la columna.');
define('RW_RPT_MYRPT','Mis Reportes');
define('RW_RPT_NOBRDR','Sin Borde');
define('RW_RPT_NOFILL','Sin Relleno');
define('RW_RPT_DISPNAME','Nombre a Mostrar');
define('RW_RPT_PGFILDESC','Descripción de Filtro para el Reporte');
define('RW_RPT_PGHEADER','Información del Encabezado/Formato');
define('RW_RPT_PGLAYOUT','Diseño de Página');
define('RW_RPT_PGMARGIN_L','Margen Izquierdo');
define('RW_RPT_PGMARGIN_R','Margen Derecho');
define('RW_RPT_PGMARGIN','Márgenes de Página');
define('RW_RPT_RNRPT','Nombre del Reporte');
define('RW_RPT_PGTITL1','Título del Reporte 1');
define('RW_RPT_PGTITL2','Título del Reporte 2');
define('RW_RPT_RPTDATA','Encabezado de los Datos');
define('RW_RPT_RPTID','Identificación del Reporte/Formulario');
define('RW_RPT_RPTIMPORT','Importar Reporte');
define('RW_RPT_SORTLIST','Información de Ordenamiento');
define('RW_RPT_STARTPOS','Posición de Inicio (Esquina Superior Izquierda en mm)');
define('RW_RPT_TBLNAME','Nombre de la Tabla');
define('RW_RPT_TEXTATTRIB','Atributos para el Texto');
define('RW_RPT_TEXTDISP','Texto a Mostrar');
define('RW_RPT_TEXTPROC','Procesamiento de Texto');
define('RW_RPT_TBLFNAME','Nombre de Campo');
define('RW_RPT_TOTALS','Totales para el Reporte');
define('RW_RPT_FLDTOTAL','Digite los campos a totalizar (Tabla.NombreDeCampo)');
define('RW_RPT_TABLE_HEADING_PROP','Propiedades del Encabezado de la Tabla');
define('RW_RPT_TABLE_BODY_PROP','Propiedades del Cuerpo de la Tabla');

// Form Group Definitions
define('RW_FRM_BANKCHK','Banco - Cheques');
define('RW_FRM_BANKDEPSLIP','Banco - Recibos de Depósito');
define('RW_FRM_COLLECTLTR','Colección de Cartas');
define('RW_FRM_CUSTLBL','Etiquetas - Cliente');
define('RW_FRM_CUSTQUOTE','Cotizaciones a Cliente');
define('RW_FRM_VENDQUOTE','Solicitudes de Cotizaciones a Proveedores');
define('RW_FRM_CUSTSTATE','Estados de Cuenta de Clientes');
define('RW_FRM_INVPKGSLIP','Facturas y Listas de Empaque');
define('RW_FRM_CRDMEMO','Notas de Crédito - Clientes');
define('RW_FRM_PURCHORD','Órdenes de Compra');
define('RW_FRM_SALESORD','Órdenes de Venta');
define('RW_FRM_SALESREC','Recibos de Compras');
define('RW_FRM_VENDLBL','Etiquetas - Proveedor');
define('RW_FRM_VENDOR_CRDMEMO','Notas de Crédito - Proveedores');

// Form Processing Definitions
define('RW_FRM_CNVTDLR','Convierta a Dólares');
define('RW_FRM_CNVTEURO','Convierta a Euros');
define('RW_FRM_COMMA','Coma - ,');
define('RW_FRM_COMMASP','Coma-Espacio');
define('RW_FRM_COYBLOCK','Bloque Datos de Compañía');
define('RW_FRM_COYDATA','Línea de Datos de Compañía');
define('RW_FRM_DATABLOCK','Bloque de Datos');
define('RW_FRM_DATALINE','Línea de Datos');
define('RW_FRM_DATATABLE','Tabla de Datos');
define('RW_FRM_DATATABLEDUP','Copia de Tabla de Datos');
define('RW_FRM_DATATOTAL','Total Datos');
define('RW_FRM_DATE','Fecha con Formato');
define('RW_FRM_DATE_TIME', 'Fecha/Hora');
define('RW_FRM_FIXEDTXT','Campo Fijo de Texto');
define('RW_FRM_IMAGE','Imagen - JPG o PNG');
define('RW_FRM_LINE','Línea');
define('RW_FRM_LOWERCASE','Minúsculas');
define('RW_FRM_NEGATE','Negar');
define('RW_FRM_NEWLINE','Nueva Línea');
define('RW_FRM_NOIMAGE','Sin Imagen');
define('RW_FRM_NULLDLR','Nulo si 0 - Dólares');
define('RW_FRM_NUM_2_WORDS','Número a Palabras');
define('RW_FRM_PAGENUM','Número de Página');
define('RW_POSTED_CURR','Moneda Seleccionada');
define('RW_FRM_QUOTE_SINGLE', 'Comilla Sencilla - \'');
define('RW_FRM_QUOTE_DOUBLE', 'Comillas - "');
define('RW_FRM_RECTANGLE','Rectángulo');
define('RW_FRM_RNDR2','Redondear (2 decimales)');
define('RW_FRM_SEMISP','Punto y coma-espacio');
define('RW_FRM_DELNL','Brínquese línea en blanco');
define('RW_FRM_SHIP_METHOD','Método de Envío');
define('RW_FRM_SPACE1','Espaciado Sencillo');
define('RW_FRM_SPACE2','Doble Espacio');
define('RW_FRM_TAB', 'Tabulador - \t');
define('RW_FRM_TERMS_TO_LANG','Dígitos a Palabras');
define('RW_FRM_UPPERCASE','Mayúsculas');
define('RW_FRM_ORDR_QTY','Cantidad Pedida');
define('RW_BRANCH_ID','Contacto');
define('RW_REP_ID','Usuario');


// Color definitions
define('TEXT_RED','Rojo');
define('TEXT_GREEN','Verde');
define('TEXT_BLUE','Azul');
define('TEXT_BLACK','Negro');
define('TEXT_ORANGE','Anaranjado');
define('TEXT_YELLOW','Amarillo');
define('TEXT_WHITE','Blanco');

// numbers
define('TEXT_ZERO','cero');
define('TEXT_ONE','uno');
define('TEXT_TWO','dos');
define('TEXT_THREE','tres');
define('TEXT_FOUR','cuatro');
define('TEXT_FIVE','cinco');
define('TEXT_SIX','seis');
define('TEXT_SEVEN','siete');
define('TEXT_EIGHT','ocho');
define('TEXT_NINE','nueve');
define('TEXT_TEN','diez');
define('TEXT_ELEVEN','once');
define('TEXT_TWELVE','doce');
define('TEXT_THIRTEEN','trece');
define('TEXT_FOURTEEN','catorce');
define('TEXT_FIFTEEN','quince');
define('TEXT_SIXTEEN','dieciseis');
define('TEXT_SEVENTEEN','diecisiete');
define('TEXT_EIGHTEEN','dieciocho');
define('TEXT_NINETEEN','diecinueve');
define('TEXT_TWENTY','veinte');
define('TEXT_THIRTY','treinta');
define('TEXT_FORTY','cuarenta');
define('TEXT_FIFTY','cincuenta');
define('TEXT_SIXTY','sesenta');
define('TEXT_SEVENTY','setenta');
define('TEXT_EIGHTY','ochenta');
define('TEXT_NINETY','noventa');
define('TEXT_HUNDERD','ciento');
define('TEXT_THOUSAND','mil');
define('TEXT_MILLION','millón');
define('TEXT_BILLION','billón');
define('TEXT_TRILLION','trillón');
define('TEXT_DOLLARS','Dólares');

// journal names
define('TEXT_JOURNAL_ID_02','Diario General');
define('TEXT_JOURNAL_ID_03','Solicitud de Cotización a Proveedor');
define('TEXT_JOURNAL_ID_04','Órden de Compra');
define('TEXT_JOURNAL_ID_06','Compras');
define('TEXT_JOURNAL_ID_07','Nota de Crédito a Proveedor');
define('TEXT_JOURNAL_ID_08','Planilla');
define('TEXT_JOURNAL_ID_09','Cotización a Cliente');
define('TEXT_JOURNAL_ID_10','Órden de Venta');
define('TEXT_JOURNAL_ID_12','Factura');
define('TEXT_JOURNAL_ID_13','Nota de Crédito a Cliente');
define('TEXT_JOURNAL_ID_14','Ensamblaje de Inventario');
define('TEXT_JOURNAL_ID_16','Ajuste de Inventario');
define('TEXT_JOURNAL_ID_18','Recibo de Dinero');
define('TEXT_JOURNAL_ID_19','Diario Punto de Venta');
define('TEXT_JOURNAL_ID_20','Pago con Efectivo');
define('TEXT_JOURNAL_ID_21','Diario Punto de Compra');

// Paper sizes supported in fpdf class, includes dimensions width, length in mm for page setup
$PaperSizes = array (
	'A3:297:420'     => 'A3',
	'A4:210:297'     => 'A4',
	'A5:148:210'     => 'A5',
	'Legal:216:357'  => TEXT_LEGAL,
	'Letter:216:282' => TEXT_LETTER,
);

// Available font sizes in units: points
$FontSizes = array (
	'8'  => '8', 
	'9'  => '9', 
	'10' => '10', 
	'11' => '11', 
	'12' => '12', 
	'14' => '14', 
	'16' => '16', 
	'18' => '18', 
	'20' => '20', 
	'24' => '24', 
	'28' => '28', 
	'32' => '32', 
	'36' => '36', 
	'40' => '40', 
	'50' => '50',
);

// Available font sizes in units: points
$LineSizes = array (
	'1' => '1', 
	'2' => '2', 
	'3' => '3', 
	'4' => '4', 
	'5' => '5', 
	'6' => '6', 
	'7' => '7', 
	'8' => '8', 
	'9' => '9', 
	'10'=>'10',
);

// Font colors keyed by color Red:Green:Blue
$FontColors = array (
	'0:0:0'       => TEXT_BLACK, // Leave black first as it is typically the default value
	'255:0:0'     => TEXT_RED,
	'255:128:0'   => TEXT_ORANGE,
	'255:255:0'   => TEXT_YELLOW,
	'0:255:0'     => TEXT_GREEN,
	'0:0:255'     => TEXT_BLUE,
	'255:255:255' => TEXT_WHITE,
);

// journal definitions
$rw_xtra_jrnl_defs = array(
  '2'  => TEXT_JOURNAL_ID_02,
  '3'  => TEXT_JOURNAL_ID_03,
  '4'  => TEXT_JOURNAL_ID_04,
  '6'  => TEXT_JOURNAL_ID_06,
  '7'  => TEXT_JOURNAL_ID_07,
  '8'  => TEXT_JOURNAL_ID_08,
  '9'  => TEXT_JOURNAL_ID_09,
  '10' => TEXT_JOURNAL_ID_10,
  '12' => TEXT_JOURNAL_ID_12,
  '13' => TEXT_JOURNAL_ID_13,
  '14' => TEXT_JOURNAL_ID_14,
  '16' => TEXT_JOURNAL_ID_16,
  '18' => TEXT_JOURNAL_ID_18,
  '19' => TEXT_JOURNAL_ID_19,
  '20' => TEXT_JOURNAL_ID_20,
  '21' => TEXT_JOURNAL_ID_21,
);

// The below functions are used to convert a number to language for USD (primarily for checks)
function value_to_words_en_us($number) {
	$number   = round($number, 2);
	$position = array('', ' '.TEXT_THOUSAND, ' '.TEXT_MILLION, ' '.TEXT_BILLION, ' '.TEXT_TRILLION);
	$dollars  = intval($number);
	$cents    = round(($number - $dollars) * 100);
	if (strlen($cents) == 1) $cents = '0' . $cents;
	if ($dollars < 1) {
		$output = TEXT_ZERO;
	} else {
		$output = build_1000_words($dollars, $position);
	}
	return strtoupper($output . ' ' . TEXT_DOLLARS . ' ' . TEXT_AND . ' ' . $cents . '/100');
}

function build_1000_words($number, $position) {
	$output = '';
	$suffix = array_shift($position);
	$tens = $number % 100;
	$number = intval($number / 100);
	$hundreds = $number % 10;
	$number = intval($number / 10);
	if ($number >= 1) $output = build_1000_words($number, $position);
	switch ($hundreds) {
		case 1: $output .= ' ' . TEXT_ONE   . ' ' . TEXT_HUNDERD; break;
		case 2: $output .= ' ' . TEXT_TWO   . ' ' . TEXT_HUNDERD; break;
		case 3: $output .= ' ' . TEXT_THREE . ' ' . TEXT_HUNDERD; break;
		case 4: $output .= ' ' . TEXT_FOUR  . ' ' . TEXT_HUNDERD; break;
		case 5: $output .= ' ' . TEXT_FIVE  . ' ' . TEXT_HUNDERD; break;
		case 6: $output .= ' ' . TEXT_SIX   . ' ' . TEXT_HUNDERD; break;
		case 7: $output .= ' ' . TEXT_SEVEN . ' ' . TEXT_HUNDERD; break;
		case 8: $output .= ' ' . TEXT_EIGHT . ' ' . TEXT_HUNDERD; break;
		case 9: $output .= ' ' . TEXT_NINE  . ' ' . TEXT_HUNDERD; break;
	}
	$output .= build_100_words($tens);
	return $output . $suffix;
}

function build_100_words($number) {
	if ($number > 9 && $number < 20) {
		switch ($number) {
			case 10: return ' ' . TEXT_TEN;
			case 11: return ' ' . TEXT_ELEVEN;
			case 12: return ' ' . TEXT_TWELVE;
			case 13: return ' ' . TEXT_THIRTEEN;
			case 14: return ' ' . TEXT_FOURTEEN;
			case 15: return ' ' . TEXT_FIFTEEN;
			case 16: return ' ' . TEXT_SIXTEEN;
			case 17: return ' ' . TEXT_SEVENTEEN;
			case 18: return ' ' . TEXT_EIGHTEEN;
			case 19: return ' ' . TEXT_NINETEEN;
		}
	}
	$output = '';
	$tens = intval($number / 10);
	switch ($tens) {
		case 2: $output .= ' ' . TEXT_TWENTY;  break;
		case 3: $output .= ' ' . TEXT_THIRTY;  break;
		case 4: $output .= ' ' . TEXT_FORTY;   break;
		case 5: $output .= ' ' . TEXT_FIFTY;   break;
		case 6: $output .= ' ' . TEXT_SIXTY;   break;
		case 7: $output .= ' ' . TEXT_SEVENTY; break;
		case 8: $output .= ' ' . TEXT_EIGHTY;  break;
		case 9: $output .= ' ' . TEXT_NINETY;  break;
	}
	$ones = $number % 10;
	switch ($ones) {
		case 1: $output .= (($output) ? '-' : ' ') . TEXT_ONE;   break;
		case 2: $output .= (($output) ? '-' : ' ') . TEXT_TWO;   break;
		case 3: $output .= (($output) ? '-' : ' ') . TEXT_THREE; break;
		case 4: $output .= (($output) ? '-' : ' ') . TEXT_FOUR;  break;
		case 5: $output .= (($output) ? '-' : ' ') . TEXT_FIVE;  break;
		case 6: $output .= (($output) ? '-' : ' ') . TEXT_SIX;   break;
		case 7: $output .= (($output) ? '-' : ' ') . TEXT_SEVEN; break;
		case 8: $output .= (($output) ? '-' : ' ') . TEXT_EIGHT; break;
		case 9: $output .= (($output) ? '-' : ' ') . TEXT_NINE;  break;
	}
	return $output;
}

/********************** DO NOT EDIT BELOW THIS LINE **********************************/

// Sets the default groups for forms, index max 4 chars
$ReportGroups = array (
	'ar'   => TEXT_RECEIVABLES,
	'ap'   => TEXT_PAYABLES,
	'inv'  => TEXT_INVENTORY,
	'hr'   => TEXT_HR,
	'man'  => TEXT_MANUFAC,
	'bnk'  => TEXT_BANKING,
	'gl'   => TEXT_GL,
	'misc' => TEXT_MISC);  // do not delete misc category

// Translation does not load! Keep english.
// This array is imploded with the first entry = number of text boxes to build (0, 1 or 2), 
// the remaining is the dropdown menu listings
//$CritChoices = array(
//	 0 => '2:TODOS:RANGO:IGUAL',
//	 1 => '0:SI:NO',
//	 2 => '0:TODOS:SI:NO',
//	 3 => '0:TODOS:ACTIVO:INACTIVO',
//	 4 => '0:TODOS:IMPRESO:NO IMPRESO',
//	 5 => NOT_USED_AVAILABLE,
//	 6 => '1:IGUAL',
//	 7 => '2:RANGO',
//	 8 => '1:NO_IGUAL',
//	 9 => '1:EN_LISTA',
//	10 => '1:MENOR_QUE',
//	11 => '1:MAYOR_QUE',


// This array is imploded with the first entry = number of text boxes to build (0, 1 or 2), 
// the remaining is the dropdown menu listings
$CritChoices = array(
	 0 => '2:ALL:RANGE:EQUAL',
	 1 => '0:YES:NO',
	 2 => '0:ALL:YES:NO',
	 3 => '0:ALL:ACTIVE:INACTIVE',
	 4 => '0:ALL:PRINTED:UNPRINTED',
//	 5 => NOT_USED_AVAILABLE,
	 6 => '1:EQUAL',
	 7 => '2:RANGE',
	 8 => '1:NOT_EQUAL',
	 9 => '1:IN_LIST',
	10 => '1:LESS_THAN',
	11 => '1:GREATER_THAN',



);

// Paper orientation
$PaperOrientation = array (
	'P' => TEXT_PORTRAIT,
	'L' => TEXT_LANDSCAPE,
);
	
$FontAlign = array (
	'L' => TEXT_LEFT,
	'R' => TEXT_RIGHT,
	'C' => TEXT_CENTER,
);

$TotalLevels = array(
	'0' => TEXT_NO,
	'1' => TEXT_YES,
);

$DateChoices = array(
	'a' => TEXT_ALL,
	'b' => TEXT_RANGE,
	'c' => TEXT_TODAY,
	'd' => TEXT_WEEK,
	'e' => TEXT_WTD,
	'l' => GL_CURRENT_PERIOD,
	'f' => TEXT_MONTH,
	'g' => TEXT_MTD,
	'h' => TEXT_QUARTER,
	'i' => TEXT_QTD,
	'j' => TEXT_YEAR,
	'k' => TEXT_YTD,
);

/*********************************************************************************************
Form unique defaults
**********************************************************************************************/ 
// Sets the groupings for forms indexed to a specific report (top level) grouping, 
// index is of the form ReportGroup[index]:FormGroup[index], each have a max of 4 chars
// This array is linked to the ReportGroups array by using the index values of ReportGroup
// the first value must match an index value of ReportGroup.
$FormGroups = array (
	'bnk:deps'  => RW_FRM_BANKDEPSLIP,
	'ap:quot'   => RW_FRM_VENDQUOTE,
	'ap:po'     => RW_FRM_PURCHORD,
	'ap:chk'    => RW_FRM_BANKCHK,	// Bank checks grouped with the ap (accounts payable report group
	'ap:cm'     => RW_FRM_VENDOR_CRDMEMO,
	'ap:lblv'   => RW_FRM_VENDLBL,
	'ap:pur'    => RW_TEXT_PURCHASES,
	'ar:quot'   => RW_FRM_CUSTQUOTE,
	'ar:so'     => RW_FRM_SALESORD,
	'ar:inv'    => RW_FRM_INVPKGSLIP,
	'ar:cm'     => RW_FRM_CRDMEMO,
	'ar:lblc'   => RW_FRM_CUSTLBL,
	'ar:rcpt'   => RW_FRM_SALESREC,
	'ar:cust'   => RW_FRM_CUSTSTATE,
	'ar:col'    => RW_FRM_COLLECTLTR,
	'misc:misc' => TEXT_MISC);  // do not delete misc category

// DataTypes
// A corresponding class function needs to be generated for each new function added.
// The index code is also used to identify the form to include to set the properties.
$FormEntries = array(
	'Data'    => RW_FRM_DATALINE,
	'TBlk'    => RW_FRM_DATABLOCK,
	'Tbl'     => RW_FRM_DATATABLE,
	'TDup'    => RW_FRM_DATATABLEDUP,
	'Ttl'     => RW_FRM_DATATOTAL,
	'Text'    => RW_FRM_FIXEDTXT,
	'Img'     => RW_FRM_IMAGE,
	'Rect'    => RW_FRM_RECTANGLE,
	'Line'    => RW_FRM_LINE,
	'CDta'    => RW_FRM_COYDATA,
	'CBlk'    => RW_FRM_COYBLOCK,
	'PgNum'   => RW_FRM_PAGENUM,
);
if (PDF_APP == 'TCPDF') $FormEntries['BarCode'] = RW_BAR_CODE;

// The function to process these values is: ProcessData
// A case statement needs to be generated to process each new value
$FormProcessing = array(
	''           => TEXT_NONE,
	'uc'         => RW_FRM_UPPERCASE,
	'lc'         => RW_FRM_LOWERCASE,
	'neg'        => RW_FRM_NEGATE,
	'rnd2d'      => RW_FRM_RNDR2,
        'rnd_dec'    => RW_FRM_RNDDECIMAL,
	'rnd_pre'    => RW_FRM_RNDPRECISE,
	'def_cur'    => RW_DEF_CUR,
	'null_dcur'  => RW_NULL_DCUR,
	'posted_cur' => RW_POSTED_CURR,
	'null_pcur'  => RW_NULL_PCUR,
	'dlr'        => RW_FRM_CNVTDLR,
	'null-dlr'   => RW_FRM_NULLDLR,
	'euro'       => RW_FRM_CNVTEURO,
	'date'       => RW_FRM_DATE,
	'n2wrd'      => RW_FRM_NUM_2_WORDS,
	'terms'      => RW_FRM_TERMS_TO_LANG,
	'ordr_qty'   => RW_FRM_ORDR_QTY,
	'branch'     => RW_BRANCH_ID,
	'rep_id'     => RW_REP_ID,
	'ship_name'  => RW_FRM_SHIP_METHOD,
	'j_desc'     => RW_JOURNAL_DESCRIPTION,
	'yesBno'     => RW_FRM_YES_SKIP_NO,
        'printed'    => RW_FRM_PRINTED,
);

// The function to process these values is: AddSep
// A case statement needs to be generated to process each new value
$TextProcessing = array(
	''        => TEXT_NONE,
	'sp'      => RW_FRM_SPACE1,
	'2sp'     => RW_FRM_SPACE2,
	'comma'   => RW_FRM_COMMA,
	'com-sp'  => RW_FRM_COMMASP,
	'nl'      => RW_FRM_NEWLINE,
	'semi-sp' => RW_FRM_SEMISP,
	'del-nl'  => RW_FRM_DELNL,
);

// Bar code Types (for use with TCPDF)
$BarCodeTypes = array(
	'C39'     => 'CODE 39',
	'C39+'    => 'CODE 39 w/checksum',
	'C39E'    => 'CODE 39 EXTENDED',
	'C39E+'   => 'CODE 39 EXT w/checksum',
	'I25'     => 'Interleaved 2 of 5',
	'C128A'   => 'CODE 128 A',
	'C128B'   => 'CODE 128 B',
	'C128C'   => 'CODE 128 C',
	'EAN13'   => 'EAN 13',
	'UPCA'    => 'UPC-A',
	'POSTNET' => 'POSTNET',
	'CODABAR' => 'CODABAR',
);

?>
