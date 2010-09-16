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
//  Path: /modules/inventory/language/es_cr/language.php
//

/********************* Release R2.0 additions *************************/
define('INV_TYPES_SA','Ensamblaje con Control de Número de Serie');

/********************* Release R1.9 additions *************************/
define('INV_TYPES_SI','Artículo de Inventario');
define('INV_TYPES_SR','Artículo con Control de Número de Serie');
define('INV_TYPES_MS','Artículo de Inventario Master');
define('INV_TYPES_AS','Artículo de Ensamblaje');
define('INV_TYPES_NS','Artículo Sin Control de Inventario');
define('INV_TYPES_LB','Mano de Obra');
define('INV_TYPES_SV','Servicio por Unidad');
define('INV_TYPES_SF','Servicio Tarifa Fija');
define('INV_TYPES_CI','Cargo');
define('INV_TYPES_AI','Actividad');
define('INV_TYPES_DS','Descripción');
define('INV_TYPES_IA','Componente de Artículo de Ensamblaje');
define('INV_TYPES_MI','SubItem de Artículo de Inventario Master');
// repeated: INV_TYPES_SI 
//$inventory_types_plus['ai'] = 'Parte de un Ensamblaje';
//$inventory_types_plus['mi'] = 'Subítem de un Código Master';

define('INV_TEXT_FIFO','FIFO');
define('INV_TEXT_LIFO','LIFO');
define('INV_TEXT_AVERAGE','Promedio');
define('INV_TEXT_GREATER_THAN','Mayor que');
define('TEXT_CHECKED','Marcado');
define('TEXT_UNCHECKED','Sin Marcar');
define('TEXT_SGL_PREC','Precisión Sencilla');
define('TEXT_DBL_PREC','Doble Precisión');
define('TEXT_NOT_USED','Sin Usar');
define('TEXT_DIR_ENTRY','Digitación Directa');
define('TEXT_ITEM_COST','Costo del Artículo');
define('TEXT_RETAIL_PRICE','Precio de Venta');
define('TEXT_PRICE_LVL_1','1er Nivel de Precios');	
define('TEXT_DEC_AMT','Reducción por Monto');
define('TEXT_DEC_PCNT','Reducción Porcentaje');
define('TEXT_INC_AMT','Aumento por Monto');
define('TEXT_INC_PCNT','Aumento Porcentual');
define('TEXT_NEXT_WHOLE','Próxima Unidad');
define('TEXT_NEXT_FRACTION','Próxima Fracción');
define('TEXT_NEXT_INCREMENT','Próximo Incremento');
define('INV_XFER_SUCCESS','Se trasfirieron exitósamente %s piezas del código %s');
define('TEXT_INV_MANAGED','Inventario Controlado');
define('TEXT_FILTERS','Filtros:');
define('TEXT_SHOW_INACTIVE','Muestre Inactivo');
define('TEXT_APPLY','Aplique');
define('AJAX_INV_NO_INFO','No hay suficiente información para obtener detalles del artículo');


/********************* Release R1.8 additions *************************/
define('INV_TOOLS_VALIDATE_SO_PO','Validar Cantidades en Inventario basado en Valores de las Órdenes');
define('INV_TOOLS_VALIDATE_SO_PO_DESC','Esta operación verifica que las cantidades de inventario en Órdenes de Compra y en Órdenes de Venta concuerdan con los registros contables.  Tienen precedencia los valores calculados de los registros contables sobre los valores de la tabla de inventarios.');
define('INV_TOOLS_REPAIR_SO_PO','Pruebe y Repare Cantidades en Inventario Basado en Valores de las Órdenes');
define('INV_TOOLS_BTN_SO_PO_FIX','Inicie Prueba y Reparación');
define('INV_TOOLS_PO_ERROR','Código: %s tenía una cantidad en Órden de Compra de %s y debería ser %s.  Se ajustó el saldo de la tabla de inventario.');
define('INV_TOOLS_SO_ERROR','Código: %s tenía una cantidad en Órden de Venta de %s y debería ser %s.  Se ajustó el saldo de la tabla de inventario.');

define('INV_TOOLS_SO_PO_RESULT','Se terminó de procesar la cantidades de inventario en las órdenes.  El número total de items procesados fue %s.  El número de registros con errores fue %s.');
define('INV_TOOLS_AUTDIT_LOG_SO_PO','Herramientas de Inventario - Repare Cantidades de OV/OC (%s)');
define('INV_ENTRY_PURCH_TAX','Impuesto de Compras Predeterminado');
define('INV_ENTRY_ITEM_TAXABLE', 'Impuesto de Ventas Predeterminado');
define('TEXT_LAST_MONTH','Mes Anterior');
define('TEXT_LAST_3_MONTH','3 Meses');
define('TEXT_LAST_6_MONTH','6 Meses');
define('TEXT_LAST_12_MONTH','12 Meses');

/********************* Release R1.7 additions *************************/
define('TEXT_WHERE_USED','Usados En');
define('TEXT_CURRENT_COST','Costo Actual del Ensamblaje');
define('JS_INV_TEXT_ASSY_COST','El costo actual para ensamblar este código es: ');
define('JS_INV_TEXT_USAGE','Este código está usado en los siguientes ensamblajes: ');
define('JS_INV_TEXT_USAGE_NONE','Este código no está siendo usado en ningún ensamblaje.');
define('INV_HEADING_UPC_CODE','Código UPC');
define('INV_SKU_ACTIVITY','Movimientos del Código ');
define('INV_ENTRY_INVENTORY_DESC_SALES','Descripción para Ventas');
define('INV_ERROR_DELETE_HISTORY_EXISTS','No se puede borrar este ítem de inventario ya que tiene registros ligados.');
define('INV_ERROR_DELETE_ASSEMBLY_PART','No se puede borrar este ítem de inventario ya que es parte de un ensamblaje.');

define('INV_TOOLS_VALIDATE_INVENTORY','Verifique el Inventario Mostrado');
define('INV_TOOLS_VALIDATE_INV_DESC','Esta operación hace pruebas para asegurarse que las cantidades de inventario que se encuentran en la base de datos de inventario y que se muestran en las pantallas son las mismas que aparecen en la base de datos de la historia de inventario tal como las calcula Phreebooks cuando ocurre un movimiento de inventario.  Los únicos ítmes que se verifican son aquellos que se calculan en el costo de bienes vendidos.  La reparación de los saldos corrige el inventario sin afectar la historia de inventario. ');
define('INV_TOOLS_REPAIR_TEST','Verifique Saldos de Inventario con la historia de costo de bienes vendidos');
define('INV_TOOLS_REPAIR_FIX','Repare los saldos de Inventario con la historia de costo de bienes vendidos');
define('INV_TOOLS_REPAIR_CONFIRM','¿Está seguro que quiere reparar los valores de inventario para que concuerden con los valores calculados de costo de bienes vendidos?');
define('INV_TOOLS_BTN_TEST','Verifique Saldos de Inventario');
define('INV_TOOLS_BTN_REPAIR','Sincronice Cantidades en Inventario');
define('INV_TOOLS_OUT_OF_BALANCE','Código: %s -> el inventario muestra %s pero la historia de costo de bienes vendidos tiene %s como disponibles');
define('INV_TOOLS_IN_BALANCE','Los saldos de inventario concuerdan.');

/********************* Release R1.6 and earlier additions *************************/
define('INV_ASSY_HEADING_TITLE', 'Ensamblaje/Desensamblaje de Inventario');
define('TEXT_INVENTORY_REVALUATION', 'Revalorización del Inventario');
define('INV_FIELD_HEADING_TITLE', 'Administrador de Base de Datos de Inventario');
define('INV_POPUP_WINDOW_TITLE', 'Ítems de Inventario');
define('INV_POPUP_PRICE_MGR_WINDOW_TITLE','Administración de Lista de Precios');
define('INV_POPUP_ADJ_WINDOW_TITLE','Ajustes de Inventario');
define('INV_ADJUSTMENT_ACCOUNT','Cuenta para el Ajuste');
define('INV_POPUP_PRICES_WINDOW_TITLE','Lista de Precios');
define('INV_BULK_SKU_ENTRY_TITLE','Ajuste General de Precios');
define('INV_POPUP_XFER_WINDOW_TITLE','Tienda a Tienda');

define('INV_HEADING_QTY_ON_HAND', 'En Inventario');
define('INV_QTY_ON_HAND', 'En Inventario');
define('INV_HEADING_SERIAL_NUMBER', 'Número de Serie');
define('INV_HEADING_QTY_TO_ASSY', 'Cantidad a Ensamblar');
define('INV_HEADING_QTY_ON_ORDER', 'Pedidos');
define('INV_HEADING_QTY_IN_STOCK', 'En Inventario');
define('TEXT_QTY_THIS_STORE','En Tienda');
define('INV_HEADING_QTY_ON_SO', 'Comprometidos');
define('INV_QTY_ON_SALES_ORDER', 'Comprometidos');
define('INV_HEADING_PREFERRED_VENDOR', 'Proveedor Preferido');
define('INV_HEADING_LEAD_TIME', 'Días en Llegar');
define('INV_QTY_ON_ORDER', 'Pedidos');
define('INV_ASSY_PARTS_REQUIRED','Componentes requeridos para este ensamblaje');
define('INV_TEXT_REMAINING','Quedan');
define('INV_TEXT_UNIT_COST','Costo Unitario');
define('INV_TEXT_CURRENT_VALUE','Valor Actual');
define('INV_TEXT_NEW_VALUE','Valor Nuevo');

define('INV_ADJ_QUANTITY','Cantidad Ajustada');
define('INV_REASON_FOR_ADJUSTMENT','Motivo del Ajuste');
define('INV_ADJ_VALUE', 'Valor del Ajuste');
define('INV_ROUNDING', 'Redondeo');
define('INV_RND_VALUE', 'Valor Redondeado');
define('INV_BOM','Lista de Materiales');
define('INV_ADJ_DELETE_ALERT', '¿Está seguro que quiere borrar este ajuste de inventario?');
define('INV_MSG_DELETE_INV_ITEM', '¿Está seguro que quiere borrar este código de inventario?');

define('INV_XFER_FROM_STORE','Traslado de Tienda');
define('INV_XFER_TO_STORE','A Tienda');
define('INV_XFER_QTY','Cantidad Transferida');
define('INV_XFER_ERROR_NO_COGS_REQD','Este traslado de inventario no afecta la cuenta de costo de bienes vendidos.  ¡Por tanto no require un registro contable!');
define('INV_XFER_ERROR_QTY_ZERO','¡La cantidad de este ítem no puede ser menor que cero!  Digite de nuevo el traslado en la dirección contraria con una cantidad positiva.');
define('INV_XFER_ERROR_SAME_STORE_ID','La tienda fuente y destino son idénticos. ¡No se realizó el traslado!');
define('INV_XFER_ERROR_NOT_ENOUGH_SKU','No se puede realizar el traslado.  ¡No hay inventario suficiente para hacer este traslado!');

define('INV_HEADING_NEW_ITEM', 'Nuevo Código de Inventario'); 
define('INV_HEADING_FIELD_INFO', 'Información de base de datos de Inventario');
define('INV_HEADING_FIELD_PROPERTIES', 'Tipo de campo y propiedades (Seleccione Uno)');
define('INV_ENTER_SKU','Digite el código, tipo de ítem y método de costos, luego presione el botón Continúe<br />Máxima longitud del Código es ' . MAX_INVENTORY_SKU_LENGTH . ' caracteres (' . (MAX_INVENTORY_SKU_LENGTH - 5) . ' para un ítem Master)');
define('INV_MS_ATTRIBUTES','Atributos para un ítem Master');
define('INV_TEXT_ATTRIBUTE_1','Atributo 1');
define('INV_TEXT_ATTRIBUTE_2','Atributo 2');
define('INV_TEXT_ATTRIBUTES','Atributos');
define('INV_MS_CREATED_SKUS','Los siguientes códigos serán creados');

define('INV_ENTRY_INVENTORY_TYPE', 'Tipo de Inventario');
define('INV_ENTRY_INVENTORY_DESC_SHORT', 'Descripción Corta');
define('INV_ENTRY_INVENTORY_DESC_PURCHASE', 'Descripción Para Compras');
define('INV_ENTRY_IMAGE_PATH','Ubicación de Imágenes');
define('INV_ENTRY_SELECT_IMAGE','Seleccione una Imagen');
define('INV_ENTRY_ACCT_SALES', 'Cuenta Ventas/Ingreso');
define('INV_ENTRY_ACCT_INV', 'Cuenta Valor de Inventario');
define('INV_ENTRY_ACCT_COS', 'Cuenta Costo de Inventario Vendido');
define('INV_ENTRY_INV_ITEM_COST','Precio de Costo');
define('INV_ENTRY_FULL_PRICE', 'Precio de Venta');
define('INV_ENTRY_ITEM_WEIGHT', 'Peso');
define('INV_ENTRY_ITEM_MINIMUM_STOCK', 'Inventario Mínimo');
define('INV_ENTRY_ITEM_REORDER_QUANTITY', 'Cantidad a Pedir');
define('INV_ENTRY_INVENTORY_COST_METHOD', 'Método de Costos');
define('INV_ENTRY_INVENTORY_SERIALIZE', 'Control de Número de Serie');
define('INV_MASTER_STOCK_ATTRIB_ID','ID (Máx 2 Caract.)');

define('INV_DATE_ACCOUNT_CREATION', 'Fecha de Creación');
define('INV_DATE_LAST_UPDATE', 'Última Actualización');
define('INV_DATE_LAST_JOURNAL_DATE', 'Fecha de Última Entrada');

// Inventory History
define('INV_SKU_HISTORY','Historia del Código');
define('INV_OPEN_PO','Órdenes de Compra Pendientes');
define('INV_OPEN_SO','Órdenes de Venta Pendientes');
define('INV_PURCH_BY_MONTH','Compras Mensuales');
define('INV_SALES_BY_MONTH','Ventas Mensuales');

define('INV_NO_RESULTS','No se encontró');
define('INV_PO_NUMBER','No. de OC');
define('INV_SO_NUMBER','No. de OV');
define('INV_PO_DATE','Fecha OC');
define('INV_SO_DATE','Fecha OV');
define('INV_PO_RCV_DATE','Fecha de Entrada');
define('INV_SO_SHIP_DATE','Fecha a Entregar');
define('INV_PURCH_COST','Costo de la Compra');
define('INV_SALES_INCOME','Monto de Ventas');
define('TEXT_MONTH','Este Mes');

define('INV_MSG_COPY_INTRO', 'Digite el nuevo código al que quiere copiar este:');
define('INV_MSG_RENAME_INTRO', 'Digite el nuevo código al que quiere nombrar este:');
define('INV_ERROR_DUPLICATE_SKU','El código ya existe.');
define('INV_ERROR_CANNOT_DELETE','El código no se puede eliminar porque tiene transacciones ligadas.');
define('INV_ERROR_BAD_SKU','Hubo un error con la lista de ensamblaje.  Verifique los códigos y las cantidades.  El código con problemas es: ');
define('INV_ERROR_SKU_INVALID','Código inválido.  Verifique el código y el número de la cuenta de inventario.');
define('INV_ERROR_SKU_BLANK','El valor para el código está en blanco.  Digite un código y vuelva a intentar.');
define('INV_ERROR_FIELD_BLANK','El nombre del campo está en blanco.  Digite un nombre para el campo y vuelva a intentar.');
define('INV_ERROR_FIELD_DUPLICATE','El campo que digitó esta duplicado, cambie el nombre del campo y vuelva a intentar.');
define('INV_ERROR_NEGATIVE_BALANCE','Error desensamblando el código, no hay suficiente cantidad de inventario para desensamblar las cantidad solicitada!');
define('TEXT_DISPLAY_NUMBER_OF_ITEMS', 'Mostrando <b>%d</b> a <b>%d</b> (de <b>%d</b> ítems)');
define('TEXT_DISPLAY_NUMBER_OF_FIELDS', 'Mostrando <b>%d</b> a <b>%d</b> (de <b>%d</b> campos)');
define('INV_CATEGORY_MEMBER', 'Miembro de Categoría:');
define('INV_FIELD_NAME', 'Campo: ');
define('INV_DESCRIPTION', 'Descripción: ');
define('TEXT_USE_DEFAULT_PRICE_SHEET','Use la Escala de Precios predeterminada');
define('INV_ERROR_ASSY_CANNOT_DELETE','No se puede borrar el ensamblaje.  ¡Ya fue usado en una transacción!');
define('INV_POST_SUCCESS','Registrado exitósamente el Ajuste de Inventario Ref no. ');
define('INV_POST_ASSEMBLY_SUCCESS','Código de ensamblaje definido exitósamente: ');
define('INV_NO_PRICE_SHEETS','¡No se han definido Escalas de Precios!');
define('INV_DEFINED_PRICES','Escalas de Precios para este Código: ');

define('INV_LABEL_DEFAULT_TEXT_VALUE', 'Valor Predeterminado: ');
define('INV_LABEL_MAX_NUM_CHARS', 'Máximo Número de Caracteres (Longitud)');
define('INV_LABEL_FIXED_255_CHARS', 'Fijo de 255 Caracteres Máximo');
define('INV_LABEL_MAX_255', '(para longitudes de menos de 256 Caracteres )');
define('INV_LABEL_CHOICES', 'Digite Selección');
define('INV_LABEL_TEXT_FIELD', 'Campo de Texto');
define('INV_LABEL_HTML_TEXT_FIELD', 'Código HTML' );
define('INV_LABEL_HYPERLINK', 'Enlace');
define('INV_LABEL_IMAGE_LINK', 'Nombre de Archivo de Imagen');
define('INV_LABEL_INVENTORY_LINK', 'Enlace de Ítem de Inventario (Enlace apuntando a otro ítem de inventario (URL))');
define('INV_LABEL_INTEGER_FIELD', 'Número Entero');
define('INV_LABEL_INTEGER_RANGE', 'Rango de Números Enteros');
define('INV_LABEL_DECIMAL_FIELD', 'Número Decimal');
define('INV_LABEL_DECIMAL_RANGE', 'Rango Decimal');
define('INV_LABEL_DEFAULT_DISPLAY_VALUE', 'Formato a Mostrar (Máx, Decimales)');
define('INV_LABEL_DROP_DOWN_FIELD', 'Lista Plegable');
define('INV_LABEL_RADIO_FIELD', 'Selección Mediante Botón de Radio<br />Digite las opciones, separadas por comas así:<br />valor1:desc1:def1,valor2:desc2:def2<br /><u>Clave:</u><br />valor = El valor para poner en la base de datos<br />desc = Descripción de la opción<br />def = Valor Predeterminado 0 ó 1, siendo 1 el valor predeterminado<br />Nota: Solo se perminte un valor predeterminado de 1 por lista');
define('INV_LABEL_DATE_TIME_FIELD', 'Fecha y Hora');
define('INV_LABEL_CHECK_BOX_FIELD', 'Casilla Para Marcar (Opciones: Sí o No)');
define('INV_LABEL_TIME_STAMP_FIELD', 'Sello con la Hora');
define('INV_LABEL_TIME_STAMP_VALUE', 'Campo del sistema para control de la última fecha y hora que se hizo un cambio a un código de inventario en particular.');

define('INV_FIELD_NAME_RULES','Los nombres de campo no pueden contener espacios o caracteres<br />especiales y deben tener 64 o menos caracteres');
define('INV_DELETE_INTRO_INV_FIELDS', '¿Está seguro que quiere borrar este campo de inventario?\n¡TODA LA INFORMACION SE PERDERÁ!');
define('INV_INFO_HEADING_DELETE_INVENTORY', 'Borre Campo de Inventario');
define('INV_CATEGORY_CANNOT_DELETE','No se puede borrar categoría.  Está siendo usado por el campo: ');
define('INV_CANNOT_DELETE_SYSTEM','¡Los campos de la categoría Sistema no se pueden borrar!');
define('INV_IMAGE_PATH_ERROR','¡Error en la ubicación para subir la imagen!');
define('INV_IMAGE_FILE_TYPE_ERROR','Error en archivo de la imagen a cargar.  No es un formato de archivo aceptable.');
define('INV_IMAGE_FILE_WRITE_ERROR','Hubo un problema salvando el archivo de la imagen al directorio especificado.');
define('INV_FIELD_RESERVED_WORD','Ese nombre del campo es una palabra reservada.  Escoja otro nombre para el campo.');

// java script errors and messages
define('JS_SKU_BLANK', '* El ítem necesita un código o UPC\n');
define('JS_COGS_AUTO_CALC','El precio unitario será calculado por el sistema.');
define('JS_NO_SKU_ENTERED','Necesita definir el código.\n');
define('JS_ADJ_VALUE_ZERO','La cantidad del ajuste no puede ser cero.\n');
define('JS_XFER_VALUE_ZERO','La cantidad a transferir debe ser mayor que cero.\n');
define('JS_ASSY_VALUE_ZERO','La cantidad del ensamblaje debe ser diferente de cero.\n');
define('JS_NOT_ENOUGH_PARTS','No hay suficente inventario para ensamblar las cantidades deseadas');
define('JS_MS_INVALID_ENTRY','Ambos la identificación y la descripción son campos requeridos.  Digite ambos valores y presione OK.');
define('JS_INV_TEXT_ASSY_COST','El valor actual del ensamblaje para este código es: ');
define('JS_INV_TEXT_USAGE','Este código está usado en los siguientes ensamblajes: ');
define('JS_INV_TEXT_USAGE_NONE','Este código no está siendo usando en ningún ensamblaje.');

// audit log messages
define('INV_LOG_ADJ','Ajuste de Inventario - ');
define('INV_LOG_ASSY','Ensamblaje - ');
define('INV_LOG_FIELDS','Campos de Inventario - ');
define('INV_LOG_INVENTORY','Código de Inventario - ');
define('INV_LOG_PRICE_MGR','Administrador de Precios - ');
define('INV_LOG_TRANSFER','Tienda a Tienda de %s a %s');



// the inventory type indexes should not be changed or the inventory module won't work.
// system generated types (not to be displayed are: ai - assembly item, mi - master stock with attributes)
$inventory_types = array(
	'si' => INV_TYPES_SI,
	'sr' => INV_TYPES_SR,
	'ms' => INV_TYPES_MS,
	'as' => INV_TYPES_AS,
        'sa' => INV_TYPES_SA,
	'ns' => INV_TYPES_NS,
	'lb' => INV_TYPES_LB,
	'sv' => INV_TYPES_SV,
	'sf' => INV_TYPES_SF,
	'ci' => INV_TYPES_CI,
	'ai' => INV_TYPES_AI,
	'ds' => INV_TYPES_DS);

// used for identifying inventory types in reports and forms that are not selectable by the user
$inventory_types_plus = $inventory_types;
$inventory_types_plus['ia'] = INV_TYPES_IA;//changed from ai by rl 20100117
$inventory_types_plus['mi'] = INV_TYPES_MI;

$cost_methods = array(
	'f' => INV_TEXT_FIFO,		// First-in, First-out
	'l' => INV_TEXT_LIFO,		// Last-in, First-out
	'a' => INV_TEXT_AVERAGE);	// Average Costing

$integer_lengths = array(
	'0' => '-127 ' . TEXT_TO . ' 127',
	'1' => '-32,768 ' . TEXT_TO . ' 32,768',
	'2' => '-8,388,608 ' . TEXT_TO . ' 8,388,607',
	'3' => '-2,147,483,648 ' . TEXT_TO . ' 2,147,483,647',
	'4' => INV_TEXT_GREATER_THAN . ' 2,147,483,648');

$decimal_lengths = array(
	'0' => TEXT_SGL_PREC,
	'1' => TEXT_DBL_PREC);

$check_box_choices = array(
	'0' => TEXT_UNCHECKED, 
	'1' => TEXT_CHECKED);

$price_mgr_sources = array(
	'0' => TEXT_NOT_USED,	// Do not remove this selection, leave as first entry
	'1' => TEXT_DIR_ENTRY,
	'2' => TEXT_ITEM_COST,
	'3' => TEXT_RETAIL_PRICE,
// Price Level 1 needs to always be at the end (it is pulled from the first row to avoid a circular reference)
// The index can change but must be matched with the javascript to update the price source values.
	'4' => TEXT_PRICE_LVL_1);	

$price_mgr_adjustments = array(
	'0' => TEXT_NONE,
	'1' => TEXT_DEC_AMT,
	'2' => TEXT_DEC_PCNT,
	'3' => TEXT_INC_AMT,
	'4' => TEXT_INC_PCNT);

$price_mgr_rounding = array(
	'0' => TEXT_NONE,
	'1' => TEXT_NEXT_WHOLE,
	'2' => TEXT_NEXT_FRACTION,
	'3' => TEXT_NEXT_INCREMENT);

?>
