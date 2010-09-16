<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2008, 2009, 2010 PhreeSoft, LLC                   |
// | http://www.PhreeSoft.com                                        |
// +-----------------------------------------------------------------+
// | Thes program es free software: you can redistribute it and/or   |
// | modify it under el  terms de el  GNU General Public License as  |
// | published by el  Free Software Foundation, eielr version 3 de  |
// | el  License, or any later version.                              |
// |                                                                 |
// | Thes program es distributed in el  hope that it will be usarful, |
// | but WITHOUT ANY WARRANTY; without even el  implied warranty de  |
// | MERCHANTABILITY or FITNESS para A PARTICULAR PURPOSE.  See el    |
// | GNU General Public License para more details.                    |
// |                                                                 |
// | el  license that es bundled with this paquete es located in el  |
// | file: /doc/manual/ch01-Introduction/license.html.               |
// | If not, see http://www.gnu.org/licenses/                        |
// +-----------------------------------------------------------------+
//  Path: /modules/install/language/es_cr/config_data.php
//

// Set some general translations (may be set in general/language already
define('TEXT_YES','Si');
define('TEXT_NO','No');
define('TEXT_SINGLE_MODE','Modo Una Línea');
define('TEXT_DOUBLE_MODE','Modo Doble Línea');
define('TEXT_AFTER_DISCOUNT','Después del Descuento');
define('TEXT_BEFORE_DISCOUNT','Antes del Descuento');
define('TEXT_LOCAL','Local');
define('TEXT_DOWNLOAD','Descargue');
define('TEXT_CHECKED','Marcado');
define('TEXT_UNCHECKED','Sin Marcar');
define('TEXT_HIDE','Esconda');
define('TEXT_SHOW','Muestre');
define('TEXT_NUMBER','Número');
define('TEXT_DESCRIPTION','Descripción');
define('TEXT_BOTH','Ambos');
define('TEXT_PURCH_ORDER','Órdenes de Compra');
define('TEXT_PURCHASE','Compras');



/*********************************************************************************************************
									Configuration Data
/*********************************************************************************************************/
/************************** Group ID 0 (System set constants) ***********************************************/
// code CD_xx_yy_TITLE : CD - config data, xx - group ID, yy - sort order
define('CD_00_01_TITLE','Período Contable Actual');
define('CD_00_01_DESC', 'Este valor define el período contable actual. ES FIJADO POR EL SISTEMA.');
define('CD_00_02_TITLE','Período Contable Actual - Fecha de Comienzo');
define('CD_00_02_DESC', 'Este valor define la fecha de comienzo del período contable actual. ES FIJADO POR EL SISTEMA.');
define('CD_00_03_TITLE','Período Contable Actual - Fecha Final');
define('CD_00_03_DESC', 'Este valor define la fecha final del período contable actual. ES FIJADO POR EL SISTEMA.');
define('CD_00_04_TITLE','Módulos Instalados');
define('CD_00_04_DESC','Lista de nombres de archivos del módulo de envíos separado por punto y coma. Esto se actualiza automáticamente. No hace falta editar. (Ejemplo: ups.php;flat.php;item.php)');
/************************** Group ID 1 (My Company) ***********************************************/
define('CD_01_01_TITLE','Compañía');
define('CD_01_01_DESC', 'El Nombre de mi compañía ');
define('CD_01_02_TITLE','Encargado de Cuentas por Cobrar');
define('CD_01_02_DESC', 'El nombre o identificador predeterminado usado para todas las operaciones de cuentas por cobrar.');
define('CD_01_03_TITLE','Encargado de Cuentas por Pagar');
define('CD_01_03_DESC', 'El nombre o identificador predeterminado usado para todas las operaciones de cuentas por pagar.');
define('CD_01_04_TITLE','Dirección');
define('CD_01_04_DESC', 'Primera línea de la dirección');
define('CD_01_05_TITLE','Dirección Línea 2');
define('CD_01_05_DESC', 'Segunda línea de la dirección');
define('CD_01_06_TITLE','Ciudad');
define('CD_01_06_DESC', 'La ciudad donde se ubica esta compañía ');
define('CD_01_07_TITLE','Provincia o Estado');
define('CD_01_07_DESC', 'La provincia/estado donde se ubica esta compañía ');
define('CD_01_08_TITLE','Código Postal');
define('CD_01_08_DESC', 'El código postal donde se ubica esta compañía ');
define('CD_01_09_TITLE','País');
define('CD_01_09_DESC', 'El país donde la compañía está ubicada<br /><br /><strong>Nota: Recuerde actualizar la provincia/estado de la compañía.</strong>');
define('CD_01_10_TITLE','Número de Teléfono Primario');
define('CD_01_10_DESC', 'Digite el número de teléfono primario de la compañía');
define('CD_01_11_TITLE','Número de Teléfono Secundario');
define('CD_01_11_DESC', 'Número de teléfono secundario');
define('CD_01_12_TITLE','Número de Fax');
define('CD_01_12_DESC', 'Digite el número fax de la compañía');
define('CD_01_13_TITLE','Correo Electrónico de la Compañía');
define('CD_01_13_DESC', 'Digite la dirección de correo electrónico de la compañía ');
define('CD_01_14_TITLE','Dirección Sitio Internet de la Compañía');
define('CD_01_14_DESC', 'Digite la dirección del sitio de internet de la compañía (sin el http://)');
define('CD_01_15_TITLE','Cédula Jurídica de la Compañía');
define('CD_01_15_DESC', 'Digite la cédula jurídica de la compañía');
define('CD_01_16_TITLE','Identificación de Compañía');
define('CD_01_16_DESC', 'Digite una identificación para la compañía. Esta identificación es para ser usada para diferenciar las transacciones generadas localmente de las que son registradas vía importar/exportar.');
define('CD_01_18_TITLE','Habilite Multi-Tienda');
define('CD_01_18_DESC', 'Habilite la funcionalidad multi-tienda.<br />Si selecciona NO, se supondrá solamente una ubicación para la compañía .');
define('CD_01_19_TITLE','Habilite Mostrar Multi-Monedas');
define('CD_01_19_DESC', 'Habilite mostrar opción de moneda en las pantallas de digitación de datos.<br />Si selecciona NO, se usará solamente la moneda predeterminada.');
define('CD_01_20_TITLE','Cambie a la Moneda del Idioma Predeterminado');
define('CD_01_20_DESC', 'Cambie automáticamente a la moneda del idioma predeterminado cuando ésta se modifica');
define('CD_01_25_TITLE','Habilite Función de Envíos');
define('CD_01_25_DESC', 'Habilite la función de envíos y los campos de envío.');
define('CD_01_30_TITLE','Habilite Encripción');
define('CD_01_30_DESC', 'Habilite el almacenamiento encriptado de los datos y los campos encriptados.');
define('CD_01_50_TITLE','Habilite Descuentos de Porcentaje/Monto Fijo Sobre el Total de la Órden');
define('CD_01_50_DESC', 'Esta función agrega dos campos adicionales para el nivel de descuento como valor o como porcentaje a las pantallas para digitar órdenes.  Si no se habilita, los campos no se mostrarán en las pantallas de digitación de órdenes.');
define('CD_01_52_TITLE','Redondeo de Impuestos por Autoridad');
define('CD_01_52_DESC', 'Habilite a PhreeBooks para redondear por autoridad, los impuestos calculados antes de sumar todos los impuestos. Para casos de una sola autoridad de impuestos, esto evitará que errores de precisión matemática se introduzcan al registro.  Para casos de varias autoridades de impuesto, esto podría llevar a que se calcule mas o menos del impuesto de corresponde. Si no esta seguro, déjelo en No.');
define('CD_01_55_TITLE','Habilite el Lector de Código de Barras');
define('CD_01_55_DESC','Si se habilita, permitirá la entrada de datos a las pantallas de órdenes por medio de escaneadores de códigos de barras USB y otros.');
define('CD_01_75_TITLE','Use Modo Una Línea en la Pantalla de Digitación de Órdenes');
define('CD_01_75_DESC', 'Habilita la opción del modo una línea en las pantallas de digitación de órdenes sin mostrar los campos para el precio total y con descuento de volunen.  La pantalla en modo una línea muestra solo números de cuenta y no la descripción como sucede en el modo de doble línea.');
/************************** Group ID 2 (cliente Defaults) ***********************************************/
define('CD_02_01_TITLE','Cuenta Predeterminada - Cuentas por Cobrar');
define('CD_02_01_DESC', 'Cuenta predeterminada de cuentas por cobrar');
define('CD_02_02_TITLE','Cuenta Predeterminada de Ventas ');
define('CD_02_02_DESC', 'Cuenta predeterminada para transacciones de ventas ');
define('CD_02_03_TITLE','Cuenta Predeterminada para Recibos de Dinero');
define('CD_02_03_DESC', 'Cuenta para aplicar recibos de dinero cuando los clientes pagan las facturas.');
define('CD_02_04_TITLE','Cuenta Predeterminada Para Descuentos Clientes de Crédito');
define('CD_02_04_DESC', 'Cuenta para aplicar descuentos a clientes de crédito cuando pagan antes del vencimiento de la factura.');
define('CD_02_05_TITLE','Cuenta Predeterminada Para Fletes');
define('CD_02_05_DESC', 'Cuenta Predeterminada para cargos de fletes');
define('CD_02_06_TITLE','Cuenta Predeterminada para Depósito de Cliente');
define('CD_02_06_DESC', 'Cuenta predeterminada de efectivo para depósitos de clientes.');
define('CD_02_10_TITLE','Términos de pago');
define('CD_02_10_DESC', 'Selección de Términos de pago');
define('CD_02_11_TITLE','Use Límite de Crédito');
define('CD_02_11_DESC', 'Use límite de crédito para el cliente cuando se está procesando órdenes');
define('CD_02_12_TITLE','Monto del Límite de Crédito');
define('CD_02_12_DESC', 'Monto del límite de crédito predeterminado a usar para clientes.');
define('CD_02_13_TITLE','Número de Días en que Vence la Factura');
define('CD_02_13_DESC', 'El número de días en que el pago se vence para usar en ventas de términos (vence en # de días, vence el día)');
define('CD_02_14_TITLE','Número de Días para que Venza el Descuento por Prepago');
define('CD_02_14_DESC', 'Número de días a usar para descuento por prepago.  Use junto con el descuento por prepago que se detalla a mas adelante.  Digite 0 para ningún descuento por prepago.');
define('CD_02_15_TITLE','Descuento por Prepago en Porcentaje');
define('CD_02_15_DESC', 'Descuento por prepago en porcentaje.  No use a no ser que el número de días para el descuento por prepago sea igual a cero.');
define('CD_02_16_TITLE','Antigüedad de la Cuenta - Fecha de Comienzo de Cálculo');
define('CD_02_16_DESC', 'Fija la fecha de comienzo para calcular la antigüedad de la cuenta.  Las opciones son:<br />0 - Fecha de la Factura ó 1 - Fecha de Vencimiento');
define('CD_02_17_TITLE','Antigüedad de la Cuenta - Período 1');
define('CD_02_17_DESC', 'Determina el número de días para la primera advertencia de vencimiento de las facturas.  El período comienza en la fecha del comienzo de la Antigüedad.');
define('CD_02_18_TITLE','Antigüedad de la Cuenta - Período 2');
define('CD_02_18_DESC', 'Determina el número de días para la segunda advertencia de vencimiento de las facturas.  El período comienza en la fecha del comienzo de la Antigüedad.');
define('CD_02_19_TITLE','Antigüedad de la Cuenta - Período 3');
define('CD_02_19_DESC', 'Determina el número de días para la tercera advertencia de vencimiento de las facturas.  El período comienza en la fecha del comienzo de la Antigüedad.');
define('CD_02_20_TITLE','Antigüedad de la Cuenta - Encabezado 1');
define('CD_02_20_DESC', 'Este es el encabezado a usar en reportes que muestran la antigüedad de la cuenta que vence en fecha 1.');
define('CD_02_21_TITLE','Antigüedad de la Cuenta - Encabezado 2');
define('CD_02_21_DESC', 'Este es el encabezado a usar en reportes que muestran la antigüedad de la cuenta que vence en fecha 2.');
define('CD_02_22_TITLE','Antigüedad de la Cuenta - Encabezado 3');
define('CD_02_22_DESC', 'Este es el encabezado a usar en reportes que muestran la antigüedad de la cuenta que vence en fecha 3.');
define('CD_02_23_TITLE','Antigüedad de la Cuenta - Encabezado 4');
define('CD_02_23_DESC', 'Este es el encabezado a usar en reportes que muestran la antigüedad de la cuenta que vence en fecha 4.');
define('CD_02_24_TITLE','Calcule Cargo por Intereses');
define('CD_02_24_DESC', 'Define si se calcula o no los intereses sobre facturas vencidas.');
define('CD_02_30_TITLE','Agregue Impuesto de Ventas a los Cargos por Envíos');
define('CD_02_30_DESC', 'Si se habilita, los cargos por envíos se le sumarán al cálculo del Impuesto de Ventas.  Si no se habilita, al cliente no se le cobrará impuesto de ventas sobre los cargos de envíos.');
define('CD_02_35_TITLE','Incremente Automáticamene el Número de Identificación de Cliente');
define('CD_02_35_DESC', 'Si se fija en verdadero, esta opción automáticamente le asignará un número de identificación al cliente/proveedor nuevo en el momento de su creación.');
define('CD_02_40_TITLE','Muestre la ventana de estatus de la cuenta en las pantallas de órdenes');
define('CD_02_40_DESC', 'Esta opción muestra la ventana de estatus de la cuenta en las pantallas de órdenes cuando el cliente se selecciona de la ventanilla de búsqueda.  Muestra los saldos, antigüedad de la cuenta así como el estatus activo o inactivo de la cuenta.');
define('CD_02_50_TITLE','Calcule Impuesto de Ventas Antes de Aplicar el Descuento');
define('CD_02_50_DESC', 'Si se habilitan descuentos por volumen de la órden, esta opción determina si el impuesto de ventas se calcula antes o después de que se le aplica el descuento a la orden de venta, factura o cotización a cliente.');
/************************** Group ID 3 (Vendor Defaults) ***********************************************/
define('CD_03_01_TITLE','Cuenta Predeterminada de Código de Compras');
define('CD_03_01_DESC', 'Cuenta predeterminada para todos los códigos a no ser que se especifique otra cuenta en la pantalla del código.');
define('CD_03_02_TITLE','Cuenta Predeterminada de Compras');
define('CD_03_02_DESC', 'Cuenta Predeterminada para todas las compras a no ser que se especifique otra cuenta en la pantalla del proveedor.');
define('CD_03_03_TITLE','Cuenta Predeterminada para Pagos');
define('CD_03_03_DESC', 'Cuenta para aplicar los pagos cuando se pagan las facturas al proveedor.');
define('CD_03_04_TITLE','Cuenta Predeterminada de Fletes sobre Compras');
define('CD_03_04_DESC', 'Cuenta predeterminada para los fletes sobre la mercadería comprada a los proveedores');
define('CD_03_05_TITLE','Cuenta Descuento por Compras');
define('CD_03_05_DESC', 'Cuenta de descuento por compras canceladas con derecho a descuento según los términos de pago');
define('CD_03_06_TITLE','Cuenta Predeterminada para Depósitos de Proveedor');
define('CD_03_06_DESC', 'Cuenta predeterminada de efectivo para depósitos de proveedor.');
define('CD_03_10_TITLE','Límite de Crédito Predeterminado que Otorga el Proveedor');
define('CD_03_10_DESC', 'Límite de Crédito predeterminado que otroga el proveedor a no ser que indique otro monto en la pantalla del Proveedor');
define('CD_03_11_TITLE','Términos del Proveedor');
define('CD_03_11_DESC', 'Términos de pago predeterminado');
define('CD_03_12_TITLE','Términos de Pago - Número de Días');
define('CD_03_12_DESC', 'El número de días en que vence el pago (solo use con la opción de fecha de vencimiento y factura vence en # de días)');
define('CD_03_13_TITLE','Porcentaje de Descuento por Pago Temprano');
define('CD_03_13_DESC', 'Porcenaje de descuento por pago temprano.  Use con pago temprano, número de días');
define('CD_03_14_TITLE','Descuento Pago Temprano - Número de Días');
define('CD_03_14_DESC', 'Número de días en que aplica el descuento por pago temprano');
define('CD_03_15_TITLE','Fecha Comienzo Antigüedad - Cuentas por Pagar');
define('CD_03_15_DESC', 'Fecha de comienzo del control de la antigüedad para usar en cuentas por pagar<br />0= Fecha Factura 1= Fecha Vencimiento');
define('CD_03_16_TITLE','Antigüedad de la Cuenta - Contador Días 1');
define('CD_03_16_DESC', 'Número de días desde la fecha de comienzo de la antigüedad para la advertencia número 1');
define('CD_03_17_TITLE','Antigüedad de la Cuenta - Contador Días 2');
define('CD_03_17_DESC', 'Número de días desde la fecha de comienzo de la antigüedad para la advertencia número 2');
define('CD_03_18_TITLE','Antigüedad de la Cuenta - Contador Días 3');
define('CD_03_18_DESC', 'Número de días desde la fecha de comienzo de la antigüedad para la advertencia número 3');
define('CD_03_19_TITLE','Antigüedad de la Cuenta - Encabezado 1');
define('CD_03_19_DESC', 'Encabezado a usar en los reportes de antigüedad de la cuenta fecha 1');
define('CD_03_20_TITLE','Antigüedad de la Cuenta - Encabezado 2');
define('CD_03_20_DESC', 'Encabezado a usar en los reportes de antigüedad de la cuenta fecha 2');
define('CD_03_21_TITLE','Antigüedad de la Cuenta - Encabezado 3');
define('CD_03_21_DESC', 'Encabezado a usar en los reportes de antigüedad de la cuenta fecha 3');
define('CD_03_22_TITLE','Antigüedad de la Cuenta - Encabezado 4');
define('CD_03_22_DESC', 'Encabezado a usar en los reportes de antigüedad de la cuenta fecha 4');
define('CD_03_30_TITLE','Agregue Impuesto a Proveedor por Cargos de Fletes');
define('CD_03_30_DESC', 'Si se habilita, los cargos por fletes serán agregados al cálculo del impuesto de ventas.  Si no se habilita, no se calcularán los impuestos sobre los fletes.');
define('CD_03_35_TITLE','Incremente Automáticamente el Número de Identificación del Proveedor');
define('CD_03_35_DESC', 'Si se fija como Verdadero, esta opción automáticamente le asignará un número de identificación a un nuevo proveedor en el momento de su creación.');
define('CD_03_40_TITLE','Muestre Ventana Estatus del Proveedor en Pantala de Órdenes');
define('CD_03_40_DESC', 'Esta opción muesta la ventana del estatus del proveedor en las pantallas de órdenes cuando el proveedor se selecciona de la búsqueda de proveedor.  Muestra saldos, antigüedad de la Cuenta así como el estatus de activo o inactivo de la cuenta.');
define('CD_03_50_TITLE','Calcule Impuesto de Ventas Antes Del Descuento');
define('CD_03_50_DESC', 'Si se habilitan los descuentos por volumen, esta opción determina si el Impuesto de Ventas se calcula antes o después de que se aplica el descuento en las órdenes de compra, compras y solicitud de cotizaciones al proveedor.');
/************************** Group ID 4 (Employee Defaults) ***********************************************/

/************************** Group ID 5 (Inventario Defaults) ***********************************************/
define('CD_05_01_TITLE','Cuenta Predeterminada - Ventas/Ingreso para Códigos de Inventario');
define('CD_05_01_DESC', 'Cuenta predeterminada de ventas/ingreso para códigos de tipo inventario');
define('CD_05_02_TITLE','Cuenta Predeterminada - Inventario para Códigos de Inventario');
define('CD_05_02_DESC', 'Cuenta predeterminada de Inventario para códigos de tipo inventario');
define('CD_05_03_TITLE','Cuenta Predeterminada - Costo de Ventas para Códigos de Inventario');
define('CD_05_03_DESC', 'Cuenta predeterminada de Costo de Ventas para códigos de tipo inventario');
define('CD_05_04_TITLE','Método de Costos de Inventario Predeterminado para Códigos de Inventario');
define('CD_05_04_DESC', 'Método predeterminado para calcular los costos de inventario para códigos del tipo inventario<br />f - FIFO, l - LIFO, a - Promedio');
define('CD_05_05_TITLE','Cuenta Predeterminada - Ventas/Ingreso para Códigos Master');
define('CD_05_05_DESC', 'Cuenta predeterminada de ventas/ingreso para códigos master');
define('CD_05_06_TITLE','Cuenta Predeterminada - Inventario para Códigos Master');
define('CD_05_06_DESC', 'Cuenta predeterminada de inventario para códigos master');
define('CD_05_07_TITLE','Cuenta Predeterminada - Costo de Ventas Códigos Master');
define('CD_05_07_DESC', 'Cuenta predeterminada de costo de ventas códigos master');
define('CD_05_08_TITLE','Método de Costos de Inventario Predeterminado para Códigos Master');
define('CD_05_08_DESC', 'Método predeterminado para calcular los costos de inventario para códigso del tipo Master<br />f - FIFO, l - LIFO, a - Promedio');
define('CD_05_11_TITLE','Cuenta Predeterminada - Ventas/Ingreso para Códigos de Ensamblaje');
define('CD_05_11_DESC', 'Cuenta predeterminada de ventas/ingreso para códigos de tipo ensamblaje');
define('CD_05_12_TITLE','Cuenta Predeterminada - Inventario para Códigos Ensamblaje');
define('CD_05_12_DESC', 'Cuenta predeterminada de inventario para códigos de tipo ensamblaje');
define('CD_05_13_TITLE','Cuenta Predeterminada - Costo de Ventas Códigos de Ensamblaje');
define('CD_05_13_DESC', 'Cuenta predeterminada de costo de ventas para códigos de tipo ensamblaje');
define('CD_05_14_TITLE','Método de Costos de Inventario Predeterminado para Códigos Ensamblaje');
define('CD_05_14_DESC', 'Método predeterminado para calcular los costos de inventario para códigos del tipo ensamblaje<br />f - FIFO, l - LIFO, a - Promedio');
define('CD_05_16_TITLE','Cuenta Predeterminada - Ventas/Ingreso Códigos con Control de Número de Serie');
define('CD_05_16_DESC', 'Cuenta predeterminada de ventas/ingreso para códigos con control de número de serie');
define('CD_05_17_TITLE','Cuenta Predeterminada - Inventario Códigos con Control de Número de Serie');
define('CD_05_17_DESC', 'Cuenta predeterminada de inventario para códigos con control de número de serie');
define('CD_05_18_TITLE','Cuenta Predeterminada - Costos de Ventas Códigos con Control de Número de Serie');
define('CD_05_18_DESC', 'Cuenta predeterminada de costos de ventas para códigos con control de número de serie');
define('CD_05_19_TITLE','Método de Costos de Inventario Predeterminado para Código Con Control de Número de Serie');
define('CD_05_19_DESC', 'Método predeterminado para calcular los costos de inventario para códigos con control de número de serie<br />f - FIFO, l - LIFO, a - Promedio');
define('CD_05_21_TITLE','Cuenta Predeterminada - Ventas/Ingreso Códigos No Inventariados');
define('CD_05_21_DESC', 'Cuenta predeterminada de ventas/ingreso para códigos no inventariados');
define('CD_05_22_TITLE','Cuenta Predeterminada - Inventario Códigos No Inventariados');
define('CD_05_22_DESC', 'Cuenta predeterminada de inventario para códigos no inventariados');
define('CD_05_23_TITLE','Cuenta Predeterminada - Costo de Ventas Códigos No Inventariados');
define('CD_05_23_DESC', 'Cuenta predeterminada de costo de ventas para códigos no intentariados');
define('CD_05_31_TITLE','Cuenta Predeterminada - Ventas/Ingreso Códigos de Servicio');
define('CD_05_31_DESC', 'Cuenta predeterminada de ventas/ingreso para códigos de servicio');
define('CD_05_32_TITLE','Cuenta Predeterminada - Inventario Códigos de Servicio');
define('CD_05_32_DESC', 'Cuenta predeterminada de inventario para códigos de servicio');
define('CD_05_33_TITLE','Cuenta Predeterminada - Costo de Ventas Códigos de Servicio');
define('CD_05_33_DESC', 'Cuenta predeterminada de costo de ventas para códigos de servicio');
define('CD_05_36_TITLE','Cuenta Predeterminada - Ventas/Ingreso Códigos de Mano de Obra');
define('CD_05_36_DESC', 'Cuenta predeterminada de ventas/ingreso para códigos de Mano de Obra');
define('CD_05_37_TITLE','Cuenta Predeterminada - Inventario Códigos de Mano de Obra');
define('CD_05_37_DESC', 'Cuenta predeterminada de inventario para códigos de mano de obra');
define('CD_05_38_TITLE','Cuenta Predeterminada - Costo de Ventas Códigos de Mano de Obra');
define('CD_05_38_DESC', 'Cuenta predeterminada de costo de ventas para códigos de mano de obra');
define('CD_05_41_TITLE','Cuenta Predeterminada - Ventas/Ingreso Códigos de Actividad');
define('CD_05_41_DESC', 'Cuenta predeterminada de ventas/ingreso para códigos de actividad');
define('CD_05_42_TITLE','Cuenta Predeterminada - Ventas/Ingreso Códigos tipo Cargo');
define('CD_05_42_DESC', 'Cuenta predeterminada de ventas/ingreso para códigos tipo cargo');
define('CD_05_50_TITLE','Tasa de Impuesto de Ventas Predeterminado para Nuevos Códigos de Inventario');
define('CD_05_50_DESC', 'Tasa de impuesto de ventas predeterminado a usar en la creación de códigos de inventario.<br /><br />NOTA: Este valor se aplica en la creación automática de códigos y puede ser cambiada en Inventario => Lista de Códigos.  La tasa de impuestos se selecciona de una tabla de la base de datos y se debe fijar durante la instalación o cambiarlo en Configuración => Tasa Impuesto de Ventas.');
define('CD_05_52_TITLE','Tasa de Impuesto de Compras para Nuevos Códigos de Inventario');
define('CD_05_52_DESC', 'Tasa de impuesto de compras predeterminada a usar en la creación de códigos de inventario.<br /><br />NOTA: Este valor se aplica en la creación automática de códigos y puede ser cambiada en Inventario => Lista de Códigos.  La tasa de impuestos se selecciona de una tabla de la base de datos y se debe fijar durante la instalación o cambiarlo en Configuración => Tasa Impuesto Compras.');
define('CD_05_55_TITLE','Habilite la Creación Automática de Códigos de Inventario');
define('CD_05_55_DESC', 'Permite la creación automática de códigos de inventario en las pantallas de órdenes.<br /><br />En Phreebooks, no se necesitan códigos para tipos de inventario para los cuales no se les va a llevar el control.  Esta opción permite la creación automática de códigos de inventario.  El tipo de inventario a usar será inventario.  Las cuentas a usar serían las cuentas predeterminadas y el método de costos predeterminado para códigos de inventario.');
define('CD_05_60_TITLE','Llene Automáticamente Lista Plegable de Inventario Cuando Digita Códigos en Órdenes');
define('CD_05_60_DESC', 'Llena la lista con las opciones en el momento en que se está digitando el campo del código.  Esta función es útil cuando se conoce el código ya que acelera el llenado del formulario de órdenes.  Sin embargo, podría demorar la digitación de códigos cuando se usa el lector de código de barras.');
define('CD_05_65_TITLE','Habilite búsqueda automática de códigos existentes en el formulario de órdenes');
define('CD_05_65_DESC', 'Cuando está habilitado, PhreeBooks busca una longitud del código en el formulario de órdenes igual al la longitud del código de barras y cuando alcanza esa longitud, intenta encontrar un código de inventario existente.  Esto permite una digitación rápida de códigos cuando se está usando lectores de barras.');
define('CD_05_70_TITLE','Longitud del código para lectores de barras en el formulario de órdenes');
define('CD_05_70_DESC', 'Fija el número de caracteres esperado cuando se está leyendo códigos de barras.  PhreeBooks empieza la búsqueda solo después de que se alcanza el número de caracteres. Valores típicos son de 12 ó 13 caracteres.');
define('CD_05_75_TITLE','Habilite la actualización automática del costo del código para compras con Órden de Compra');
define('CD_05_75_DESC', 'Cuando está habilitado, PhreeBooks actualizará el costo del código en la tabla de inventario con el precio de la Órden de Compra o el de Comprar/Ingresar.  Usado para agilizar la actualización de costos sin tener que actualizar primero las tablas de inventario.');
/************************** Group ID 6 (Special Cases (Payment, Shippping, Price Sheets) **************/
// 
// The group is from add-on modules which will not have a language translation here.
// They should be included with the module.
// 
/************************** Group ID 7 (Use Account Defaults) ***********************************************/
define('CD_07_17_TITLE','Lontitud de Contraseña');
define('CD_07_17_DESC', 'Longitud mínima de la contraseña');
/************************** Group ID 8 (General Settings) ***********************************************/
define('CD_08_01_TITLE','Número Máximo de Resultados de la Búsqueda por Página');
define('CD_08_01_DESC', 'Número máximo de resultados devueltos por la búsqueda por página');
define('CD_08_03_TITLE','Revise Automáticamene Si Hay Actualizaciones del Programa');
define('CD_08_03_DESC', 'Automáticamene revisa a ver si hay actualizaciones del programa cuando hace el login a PhreeBooks.');
define('CD_08_05_TITLE','Esconda Mensajes de Éxito');
define('CD_08_05_DESC', 'Esconda mensajes de notificación de operaciones ralizadas exitosamente.<br />Solo muestre mensajes de precaución y error.');
define('CD_08_07_TITLE','Actualice Automáticamene los Tipos de Cambio de Moneda');
define('CD_08_07_DESC', 'Actualiza automáticamente el tipo de cambio de todas las monedas definidas con cada login.<br />Si se desabilita, los tipos de cambio se pueden actualizar manualmente vía el menú Configuración => Lista de Monedas.');
define('CD_08_10_TITLE','Límite de Resultados para Historia de Cliente/Proveedor');
define('CD_08_10_DESC', 'Limita la cantidad de Ventas/Compras históricas que se muestran para cuentas de clientes/proveedores.');
define('CD_08_15_TITLE','Aplicación Predeterminada a Usar para Generar Reportes y Formularios PDF');
define('CD_08_15_DESC', 'Fija la aplicación a usar para generar los reportes y formularios en formato PDF.  FPDF es mas estable y produce resultados mas confiables pero no maneja codificación en fuentes UTF-8 o código de barras.  TCPDF es mas robusto pero aún está en desarrollo y puede que requiera actualizaciones adicionales para tener la versión mas reciente.');
/************************** Group ID 9 (Import/Export Settings) ***********************************************/
define('CD_09_01_TITLE','Preferencias Exportación de Reporte/Formulario');
define('CD_09_01_DESC', 'Especifica las preferencias de exportación cuando se exportan reportes y formularios.  La opción local salvará el archivo del reporte en el directorio /my_files/reports del servidor para poder ser usado por todas las compañías.  Descargar bajará el archivo a su navegador de donde podrá salvar/imprimir el reporte desde su computador.');
/************************** Group ID 10 (Shipping Defaults) ***********************************************/
define('CD_10_01_TITLE','Unidad de Medida de Peso Predeterminada');
define('CD_10_01_DESC', 'Fija la unidad de medida de peso predeterminada para los pesos de todos los paquetes.  Valores válidos son:<br />LBS - Libra<br />KGS - Kilogramos');
define('CD_10_02_TITLE','Moneda Predeterminada para Usar en Envíos');
define('CD_10_02_DESC', 'Valores válidos son<br />CR - Colón<br />USD - US Dólares<br />EUR - Euros');
define('CD_10_03_TITLE','Unidad de Medida Predeterminada para las Dimensiones del Paquete');
define('CD_10_03_DESC', 'Unidades de medida del paquete. Valores válidos son:<br />PULG -Pulgadas<br />CM - Centímetros');
define('CD_10_04_TITLE','Preselección de Casilla Residencial');
define('CD_10_04_DESC', '0 - Fija como predeterminado la casilla de Envíe a Dirección Residencial y marcado (dirección comercial)<br />1 - Fija como predeterminados la casilla de Envíe a Dirección Residencial y marcado (dirección residencial)');
define('CD_10_05_TITLE','Tipo de Paquete Predeterminado');
define('CD_10_05_DESC', 'Especifica el tipo de paquete predeterminado a usar en envíos.');
define('CD_10_06_TITLE','Servicio Predeterminado para Recoger el Paquete');
define('CD_10_06_DESC', 'Especifique el tipo de servicio predeterminado para recojer el paquete.');
define('CD_10_07_TITLE','Longitud Predeterminada del Paquete');
define('CD_10_07_DESC', 'Defina la longitud predeterminada del paquete a usar para un envío estandar.');
define('CD_10_08_TITLE','Ancho Predeterminado del Paquete');
define('CD_10_08_DESC', 'Defina un ancho predeterminado del paquete a usar para un envío estandar.');
define('CD_10_09_TITLE','Altura Predeterminada del Paquete');
define('CD_10_09_DESC', 'Defina la altura predeterminada del paquete a usar para un envío estandar.');
define('CD_10_10_TITLE','Casilla Cargo por Manejo Especial');
define('CD_10_10_DESC', 'Muestre la casilla de Cargo por Manejo Especial');
define('CD_10_12_TITLE','Casilla Manejo Adicional');
define('CD_10_12_DESC', 'Preseleccione la casilla de manejo adicional');
define('CD_10_14_TITLE','Seleccione Muestre Opción de Seguros');
define('CD_10_14_DESC', 'Muestre la opción de seguros.');
define('CD_10_16_TITLE','Preseleccione Opción de Seguros');
define('CD_10_16_DESC', 'Preseleccione la casilla con la opción de seguros como predeterminado.');
define('CD_10_18_TITLE','Valor del Paquete Predeterminado Para Efectos de Seguros');
define('CD_10_18_DESC', 'Especifique el valor monetario predeterminado, basado en la moneda usada para calcular el seguro.  Este valor típicamente será sobreseído por el valor dado por el programa de envíos con el valor de compra/venta del estimador de envíos.');
define('CD_10_20_TITLE','Muestre Casilla para Dividir Envíos Grandes');
define('CD_10_20_DESC', 'Muestre la casilla para permitir que envíos pesados sean divididos en paquetes pequeños.');
define('CD_10_22_TITLE','Preselección de Casilla Divida Envío');
define('CD_10_22_DESC', 'Preseleccione la casilla para dividir el envío.  Esta opción es para dividir el envío en partes mas pequeñas (de peso seleccionable por el usuario) para enviar por un servicio de envío de paquetes pequeños, i.e. UPS, FedEx, DHL, etc.');
define('CD_10_24_TITLE','Divida Envío Grande por Peso');
define('CD_10_24_DESC', 'Peso Predeterminado a usar para dividir los envíos grandes para servicio de envío de paquetes péqueños.');
define('CD_10_26_TITLE','Muestre Casilla de Confirme Recibido');
define('CD_10_26_DESC', 'Muestre la casilla de confirme recibido');
define('CD_10_28_TITLE','Preseleccione la Casilla de Confirme Recibido.');
define('CD_10_28_DESC', 'Preseleccione la casilla de confirme recibido.  Valores Válidos son:<br />0 - Sin marcar<br />1 - Marcado');
define('CD_10_30_TITLE','Tipo de Confirme Recibido Solicitado.');
define('CD_10_30_DESC', 'Especifica valor predeterminado para el tipo de confirme recibido requerido');
define('CD_10_32_TITLE','Muestre Casilla Cargos por Manejo');
define('CD_10_32_DESC', 'Muestre la casilla de cargos por manejo.');
define('CD_10_34_TITLE','Preseleccione Casilla para Cargos por Manejo del Envío');
define('CD_10_34_DESC', 'Preseleccione la opción de cargospor manejo del envío.');
define('CD_10_36_TITLE','Valor Predeterminado de Cargo por Manejo de Envío');
define('CD_10_36_DESC', 'Establece el valor predeterminado por manejo del envío basado en la unidad de medida ');
define('CD_10_38_TITLE','Muestre Opciones de Pago Contra Entrega para Envíos');
define('CD_10_38_DESC', 'Habilite la casilla de opciones de pago contra entrega');
define('CD_10_40_TITLE','Preseleccione Casilla de Pago Contra Entrega');
define('CD_10_40_DESC', 'Preseleccione la casilla de pago contra entrega');
define('CD_10_42_TITLE','Predeterminado Forma de Pago');
define('CD_10_42_DESC', 'Seleccione la forma de pago predeterminada a aceptar');
define('CD_10_44_TITLE','Muestre Casilla Recoger Sábado');
define('CD_10_44_DESC', 'Muestre la casilla para recoger el día sábado');
define('CD_10_46_TITLE','Preseleccione Casilla para Recoger Sábado');
define('CD_10_46_DESC', 'Preseleccione la casilla para recoger el día sábado');
define('CD_10_48_TITLE','Muestre Casilla Entregue Sábado');
define('CD_10_48_DESC', 'Muestre casilla entregue día sábado');
define('CD_10_50_TITLE','Preseleccione Casilla Entregue Sábado');
define('CD_10_50_DESC', 'Preseleccione la casilla de entregue día sábado');
define('CD_10_52_TITLE','Muestre Casilla Material Peligroso');
define('CD_10_52_DESC', 'Muestre casilla de material peligraso');
define('CD_10_54_TITLE','Preseleccione Casilla de Material Peligroso');
define('CD_10_54_DESC', 'Preseleccione la casilla de material peligroso');
define('CD_10_56_TITLE','Muestre Casilla Hielo Seco');
define('CD_10_56_DESC', 'Muestre casilla Hielo Seco');
define('CD_10_58_TITLE','Preseleccione Casilla Hielo Seco');
define('CD_10_58_DESC', 'Preseleccione la casilla de hielo seco');
define('CD_10_60_TITLE','Muestre Casilla Servicio de Devolución');
define('CD_10_60_DESC', 'Muestre casilla de servicio de devolución');
define('CD_10_62_TITLE','Preseleccione Casilla Servicio de Devolución ');
define('CD_10_62_DESC', 'Preseleccione la casilla de servicio de devolución');
define('CD_10_64_TITLE','Selección Predeterminada de Servicio de Devolución (Etiquetas de Devolución)');
define('CD_10_64_DESC', 'Seleccione como predeterminado la selección de la casilla de servicio de devolución.');
/************************** Group ID 11 (Address Book Defaults) ***********************************************/
define('CD_11_02_TITLE','Cuenta Contacto Campo Requerido ');
define('CD_11_02_DESC', 'Requiere o no que el campo Contacto sea digitado en la configuración de cuentas (proveedores, clientes y empleados)');
define('CD_11_03_TITLE','Cuenta Dirección Campo Requerido');
define('CD_11_03_DESC', 'Requiere o no que el campo Dirección sea digitado en la configuración de cuentas (proveedores, clientes y empleados)');
define('CD_11_04_TITLE','Cuenta Dirección Línea 2 Campo Requerido');
define('CD_11_04_DESC', 'Requiere o no que el campo Dirección Linea 2 sea digitado en la configuración de cuentas (proveedores, clientes y empleados)');
define('CD_11_05_TITLE','Cuenta Ciudad Campo Requerido');
define('CD_11_05_DESC', 'Requiere o no que el campo Ciudad sea digitado en la configuración de cuentas (proveedores, clientes y empleados)');
define('CD_11_06_TITLE','Cuenta Provincia/Estado Campo Requerido');
define('CD_11_06_DESC', 'Requiere o no que el campo Provincia/Estado (proveedores, clientes y empleados)');
define('CD_11_07_TITLE','Cuenta Código Postal Campo Requerido');
define('CD_11_07_DESC', 'Requiere o no que el campo Código Postal sea digitado en la configuración de cuentas (proveedores, clientes y empleados)');
define('CD_11_08_TITLE','Cuenta Teléfono 1 Campo Requerido');
define('CD_11_08_DESC', 'Requiere o no que el campo Teléfono 1 sea digitado en la configuración de cuentas (proveedores, clientes y empleados)');
define('CD_11_09_TITLE','Cuenta Dirección de Correo Electrónico Campo Requerido');
define('CD_11_09_DESC', 'Requiere o no que el campo Correo sea digitado en la configuración de cuentas (proveedores, clientes y empleados)');
define('CD_11_10_TITLE','Envíos Dirección Campo Requerido');
define('CD_11_10_DESC', 'Requiere o no que el campo Dirección sea digitado para envíos.');
define('CD_11_11_TITLE','Envíos Dirección Línea 2 Campo Requerido');
define('CD_11_11_DESC', 'Requiere o no que el campo Dirección Línea 2 sea digitado para envíos.');
define('CD_11_12_TITLE','Envíos Contacto Campo Requerido');
define('CD_11_12_DESC', 'Requiere o no que el campo Contacto sea digitado para envíos.');
define('CD_11_13_TITLE','Envíos Ciudad Campo Requerido');
define('CD_11_13_DESC', 'Requiere o no que el campo Ciudad sea digitado para envíos.');
define('CD_11_14_TITLE','Envíos Provincia/Estado Campo Requerido');
define('CD_11_14_DESC', 'Requiere o no que el campo Provincia/Estado sea digitado para envíos.');
define('CD_11_15_TITLE','Envíos Código Postal Campo Requerido');
define('CD_11_15_DESC', 'Requiere o no que el campo Código Postal sea digitado para envíos.');
/************************** Group ID 12 (E-mail Settings) ***********************************************/
define('CD_12_01_TITLE',' Método de Transporte de Correo ');
define('CD_12_01_DESC', 'Define el método para enviar correo.<br /><strong>PHP</strong> es el predeterminado, y usa encapsuladores propios de PHP para procesarlos.<br />Los servidores que usan Windows y SO Mac debieran cambiar esta configuración a <strong>SMTP</strong>.<br /><br /><strong>SMTPAUTH</strong> debería usarse solo si su servidor requiere autenticación SMTP para enviar mensajes.  Debe configurar su SMTPAUTH en los campos apropiados en la sección de Admin.<br /><br /><strong>sendmail</strong> es para servidores Linux/Unix que usan el programa sendmail<br /><strong>"sendmail-f"</strong> es solo para servidores que requieren usar el parámetro -f para enviar correo.  Esta es una configuración de seguridad usada para prevenir la falsificación. Provocará errores si el servidor de correos no está configurado para usarlo.<br /><br /><strong>Qmail</strong> es para servidores Linux/Unix que corren Qmail como encapsulador en /var/qmail/bin/sendmail.');
define('CD_12_02_TITLE','Nueva línea en los correos');
define('CD_12_02_DESC', 'Defina la secuencia de caracteres a usar para separar los encabezados de correo.');
define('CD_12_03_TITLE','Envíe Correos');
define('CD_12_03_DESC', 'Envíe correos');
define('CD_12_04_TITLE','Use MIME HTML cuando envía correos');
define('CD_12_04_DESC', 'Envíe correo en formato HTML');
define('CD_12_05_TITLE','Verifique Dirección de Correo por DNS');
define('CD_12_05_DESC', 'Verifique la dirección de correo a través del servidor DNS');
define('CD_12_06_TITLE','¿Archive Correo?');
define('CD_12_06_DESC', 'Si desea que el mensaje enviado se almacene después de enviar, seleccione Si.');
define('CD_12_07_TITLE','Errores de E-Mail');
define('CD_12_07_DESC', '¿Quiere mostrar errores si falla el envío del correo?  Fijar esto a No causará que PHP muestre los errores y posiblemente falle el procedimiento.  Solo defina cono No para resolver problemas y Si para producción.');
define('CD_12_10_TITLE','Dirección de Correo Electrónico (Mostrado para Contactarlo a Usted)');
define('CD_12_10_DESC', 'Dirección de Correo Electrónico de la Compañía.  Use "Solo Muestre" para informarle a los clientes como contactarlo a Usted.');
define('CD_12_11_TITLE','Dirección de Correo Electrónico  (Enviado De)');
define('CD_12_11_DESC', 'Dirección predeterminada de dónde los mensajes serán "enviados".  Puede ser cambiado a la hora de componer el correo en los módulos admin.');
define('CD_12_12_TITLE','¡Los correos deben ser enviados desde un dominio conocido!');
define('CD_12_12_DESC', '¿Su servidor de correo requiere que todo correo saliente tenga una dirección "De" que concuerde con un dominio conocido y que exista en su servidor de páginas?<br /><br />Esto generalmente se exije para prevenir falsificaciones y transmisiones masivas de spam.  Si se fija en SI, esto hará que la dirección de correo electrónico  (enviado De) sea usado como la dirección De en todo correo saliente.');
define('CD_12_15_TITLE','¿Formato para Correo a Admin?');
define('CD_12_15_DESC', 'Seleccione el formato para el correo a Admin');
define('CD_12_40_TITLE','Fije Lista Plegable para Direcciones de "Contáctenos"');
define('CD_12_40_DESC', 'En la página "Contáctenos", fije la lista de direcciones de correo electrónico, en este formato: Nombre 1 &lt;email@Dirección L1&gt;, Nombre 2 &lt;email@Dirección L2&gt;');
define('CD_12_50_TITLE','Contáctenos - Muestre el Nombre de la Tienda y la Dirección');
define('CD_12_50_DESC', 'Incluya el Nombre de la Tienda y la Dirección<br />0= No 1= Si');
define('CD_12_70_TITLE','Cuenta de correos SMTP');
define('CD_12_70_DESC', 'Digite el nombre de la cuenta de correo (yo@midominio.com) que le dió su administrador del servidor.  Este es el nombre de la cuenta que su servidor requiere para autentificación SMTP.<br />Solo se necesita si el servidor está usando autentificación SMTP.');
define('CD_12_71_TITLE','Contraseña para la cuenta de correo SMTP');
define('CD_12_71_DESC', 'Digite la Contraseña SMTP de su correo. <br />Solo se necesita si el servidor está usando autentificación SMTP.');
define('CD_12_72_TITLE','Servidor de Correo SMTP');
define('CD_12_72_DESC', 'Digite el nombre del servidor DNS de su servidor SMTP de correos.<br />ie: correo.midominio.com<br />ó 55.66.77.88<br />Solo se necesita si el servidor esta usando autentificación SMTP.');
define('CD_12_73_TITLE','IP del Servidor SMTP de Correo Electrónico');
define('CD_12_73_DESC', 'Digite el número IP en que su servidor de correos SMTP opera.<br />Solo se requiere si está usando autentificación SMTP para correo electrónico.');
define('CD_12_74_TITLE','Convierta Moneda para Correo Electrónico de Texto');
define('CD_12_74_DESC', '¿Qué conversión de moneda necesita para enviar correo electrónico de texto?<br />Predeterminado = &amp;colón;,£:&amp;euro;,');
/************************** Group ID 13 (Settings) ***********************************************/
define('CD_13_01_TITLE','Adelante Automáticamente el Período Contable');
define('CD_13_01_DESC', 'Automáticamente cambia el período contable actual basado en la fecha del servidor y el calendario fiscal actual.  Si no se habilita, el período contable actual deberá ser cambiado manualmente en el menú  Contabilidad => Utilitarios Contabilidad.');
define('CD_13_05_TITLE','Muestre Nombres Completos de la Cuentas');
define('CD_13_05_DESC', 'Determina como mostrar las cuentas en las listas plegables.<br />  Número - solo el número de cuenta.<br />Descripción - Solo la descripción de cuenta.<br />Ambos - Muestre ambos, el número y el nombre de la cuenta.');
/************************** Group ID 15 (Sessions Settings) ***********************************************/
define('CD_15_01_TITLE','Duración de la Sesión en Segundos');
define('CD_15_01_DESC', 'Digite el tiempo predeterminado en segundos<br />Ejemplo: 3600= 1 hora<br /><br />Nota: Muy poco tiempo puede resultar en que le dé problemas de desconección cuando agrega o edita códigos de inventario.');
define('CD_15_05_TITLE','Auto-renueva la sesión para evitar desconecciones entre refrezcamientos de pantalla');
define('CD_15_05_DESC', 'Cuando está habilitado, esta opción reafirma con el servidor la sesión cada 5 minutos evitando que expire la sesión y que el usuario tenga que re-identificarse.  Esta opción previene la pérdida de la digitación del registro cuando PhreeBooks ha estado inactivo y la acción de continuar produce la pantalla de identificación.');
/************************** Group ID 17 (Credit Card Settings) ***********************************************/
define('CD_17_01_TITLE','Longitud Mínima del Nombre del Dueño de la Tarjeta de Crédito');
define('CD_17_01_DESC', 'Digite la longitud mínima del nombre del dueño de la tarjeta de crédito.');
define('CD_17_02_TITLE','Longitud Mínima del Número de la Tarjeta de Crédito');
define('CD_17_02_DESC', 'Digite la longitud mínima del número de la tarjeta de crédito.');
define('CD_17_03_TITLE','Habilite Tarjeta de Crédito Visa');
define('CD_17_03_DESC', 'Habilite tarjeta de crédito Visa.');
define('CD_17_04_TITLE','Habilite Tarjeta de Crédito Master Card');
define('CD_17_04_DESC', 'Habilite tarjeta de crédito Master Card.');
define('CD_17_05_TITLE','Habilite Tarjeta de Crédito American Express');
define('CD_17_05_DESC', 'Habilite tarjeta de crédito American Express.');
define('CD_17_06_TITLE','Habilite Tarjeta de Crédito Discover');
define('CD_17_06_DESC', 'Habilite tarjeta de crédito Discover.');
define('CD_17_07_TITLE','Habilite Tarjeta de Crédito Diners Club');
define('CD_17_07_DESC', 'Habilite tarjeta de crédito Diners Club.');
define('CD_17_08_TITLE','Habilite Tarjeta de Crédito JCB');
define('CD_17_08_DESC', 'Habilite tarjeta de crédito JCB.');
define('CD_17_09_TITLE','Habilite Australian Bankcard');
define('CD_17_09_DESC', 'Habilite Australian Bankcard.');
/************************** Group ID 19 (Layout Settings) ***********************************************/

/************************** Group ID 20 (Website Maintenence) ***********************************************/
define('CD_20_99_TITLE','Habilite Generación de Archivo para Despulgar');
define('CD_20_99_DESC', 'Habilite generación de archivo con el propósito de despulgar el programa.<br />Si selecciona SI, un menú adicional aparecerá en el menú de herramientas para descargar el archivo que va a ayudar a determinar problemas con el programa.');
/************************** Group ID 99 (Alternate (non-displayed Settings) *********************************/
// 
// This group is from add-on modules which will not have a language translation here.
// They should be included with the module.
// 

?>
