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
//  Path: /modules/accounts/language/es_cr/language.php
//
// *************  Release 2.0 changes  *********************
define('TEXT_NEW_CONTACT','Nuevo Contacto');
define('TEXT_COPY_ADDRESS','Transfiera Dirección');
define('TEXT_CONTACTS','Contactos');
define('TEXT_TITLE','Título');
define('TEXT_LINK_TO','Enlace A:');
define('ACT_CATEGORY_I_ADDRESS','Agregue/Edite Contacto');
define('ACT_CONTACT_HISTORY','Historia del Contacto');
define('ACT_I_SHORT_NAME','Contacto');
define('ACT_I_HEADING_TITLE','Relaciones con Clientes');
define('ACT_I_TYPE_NAME','Contactos');
define('ACT_I_PAGE_TITLE_EDIT','Edite Contacto');
define('ACT_SHORT_NAME','Contacto');
define('ACT_GL_ACCOUNT_TYPE','Categoría');
define('ACT_ACCOUNT_NUMBER','Facebook ID');
define('ACT_ID_NUMBER','Twitter ID');
define('ACT_REP_ID','Enlace a Cliente/Proveedor');
define('ACT_FIRST_DATE','Fecha Creación');
define('ACT_LAST_DATE1','Última Actualización');
define('ACT_ERROR_DUPLICATE_CONTACT','La identificación de este contacto ya existe en el sistema, digite otra identificación para el contacto nuevo.');

// *************  Release 1.9 changes  *********************
// Text specific to Projects
define('ACT_TYPE_NAME','proyectos');//had to add as ACT_J_TYPE_NAME is not being pulled
define('ACT_J_TYPE_NAME','proyectos');
define('ACT_J_HEADING_TITLE', 'Proyectos');
define('ACT_J_SHORT_NAME', 'Proyecto');
define('ACT_J_ID_NUMBER','Orden de Compra del Cliente');
define('ACT_J_REP_ID','Vendedor');
define('ACT_J_PAGE_TITLE_EDIT','Edite Proyecto');
define('ACT_J_ACCOUNT_NUMBER','Separe en Fases:');
define('ACT_ID_AUTO_FILL','(Deje en blanco si desea que el sistema genere la identificación del proyecto)');
// *********************************************************
// Targeted defines (to differentiate wording differences for different account types)
// Text specific to Vendor accounts
define('ACT_V_TYPE_NAME','Proveedores');
define('ACT_V_HEADING_TITLE', 'Proveedores');
define('ACT_V_SHORT_NAME', 'Proveedor');
define('ACT_V_GL_ACCOUNT_TYPE','Cuenta Compras');
define('ACT_V_ID_NUMBER','Cédula Jurídica');
define('ACT_V_REP_ID','Comprador');
define('ACT_V_ACCOUNT_NUMBER','Número de Cuenta');
define('ACT_V_FIRST_DATE','Proveedor Desde: ');
define('ACT_V_LAST_DATE1','Fecha Última Factura: ');
define('ACT_V_LAST_DATE2','Fecha Último Pago: ');
define('ACT_V_PAGE_TITLE_EDIT','Modificar Información del Proveedor');
 // Text specific to Employee accounts
define('ACT_E_TYPE_NAME','Empleados');
define('ACT_E_HEADING_TITLE', 'Empleados');
define('ACT_E_SHORT_NAME', 'Empleado');
define('ACT_E_GL_ACCOUNT_TYPE','Tipo de Empleado');
define('ACT_E_ID_NUMBER','Cédula de Identidad');
define('ACT_E_REP_ID','Departmento');
define('ACT_E_ACCOUNT_NUMBER','No está siendo usado');
define('ACT_E_FIRST_DATE','Fecha de Contratación: ');
define('ACT_E_LAST_DATE1','Fecha Último Aumento: ');
define('ACT_E_LAST_DATE2','Fecha de Liquidación: ');
define('ACT_E_PAGE_TITLE_EDIT','Modificar Información del Empleado');
// Text specific to branch accounts
define('ACT_B_TYPE_NAME','Tiendas');
define('ACT_B_HEADING_TITLE', 'Tiendas');
define('ACT_B_SHORT_NAME', 'Tienda');
define('ACT_B_GL_ACCOUNT_TYPE','No esta siendo usado');
define('ACT_B_ID_NUMBER','No esta siendo usado');
define('ACT_B_REP_ID','No esta siendo usado');
define('ACT_B_ACCOUNT_NUMBER','No esta siendo usado');
define('ACT_B_FIRST_DATE','Fecha de Creación: ');
define('ACT_B_LAST_DATE1','No esta siendo usado');
define('ACT_B_LAST_DATE2','No esta siendo usado');
define('ACT_B_PAGE_TITLE_EDIT','Modificar Información de la Tienda');
// Text specific to Customer accounts (default)
define('ACT_C_TYPE_NAME','Clientes');
define('ACT_C_HEADING_TITLE', 'Lista de Clientes');
define('ACT_C_SHORT_NAME', 'Cliente');
define('ACT_C_GL_ACCOUNT_TYPE','Cuenta Ingresos');
define('ACT_C_ID_NUMBER','Número Exención');
define('ACT_C_REP_ID','Vendedor');
define('ACT_C_ACCOUNT_NUMBER','Número de Cuenta');
define('ACT_C_FIRST_DATE','Cliente Desde: ');
define('ACT_C_LAST_DATE1','Fecha Última Factura: ');
define('ACT_C_LAST_DATE2','Fecha Último Pago: ');
define('ACT_C_PAGE_TITLE_EDIT','Modificar Información del Cliente');

// Category headings
define('ACT_CATEGORY_CONTACT','Información del Contacto');
define('ACT_CATEGORY_M_ADDRESS','Dirección de correo');
define('ACT_CATEGORY_S_ADDRESS','Dirección para envíos');
define('ACT_CATEGORY_B_ADDRESS','Dirección para mandar cobros');
define('ACT_CATEGORY_P_ADDRESS','Información de la Tarjeta de Crédito');
define('ACT_CATEGORY_INFORMATION','Información de la Cuenta');
define('ACT_CATEGORY_PAYMENT_TERMS','Términos de Pago');
define('TEXT_ADDRESS_BOOK','Libro de Direcciones');
define('TEXT_EMPLOYEE_ROLES','Rol del Empleado');
define('ACT_ACT_HISTORY','Historia de la Cuenta');
define('ACT_ORDER_HISTORY','Historia de Órdenes');
define('ACT_SO_HIST','Historia de Órdenes de Venta (Últimas %s)');
define('ACT_PO_HIST','Historia de Órdenes de Compra (Últimas %s)');
define('ACT_INV_HIST','Historia de Facturas (Últimas %s)');
define('ACT_SO_NUMBER','Número OV');
define('ACT_PO_NUMBER','Número OC');
define('ACT_INV_NUMBER','Número de Factura');
define('ACT_NO_RESULTS','Se no encontró');
define('ACT_PAYMENT_MESSAGE','Digite información de pago para guardar en PhreeBooks.');
define('ACT_PAYMENT_CREDIT_CARD_NUMBER','Número de Tarjeta de Crédito');
define('ACT_PAYMENT_CREDIT_CARD_EXPIRES','Fecha de Vencimiento de la Tarjeta de Crédito');
define('ACT_PAYMENT_CREDIT_CARD_CVV2','Código de Seguridad');
define('AR_CONTACT_STATUS','Estatus del Cliente');
define('AP_CONTACT_STATUS','Estatus del Proveedor');

// Account Terms (used in several modules)
define('ACT_SPECIAL_TERMS','Términos Especiales');
define('ACT_TERMS_DUE','Términos (Vence)');
define('ACT_TERMS_DEFAULT','Predeterminado: ');
define('ACT_TERMS_USE_DEFAULTS', 'Use Términos Predeterminados');
define('ACT_COD_SHORT','Contado');
define('ACT_COD_LONG','Contado');
define('ACT_PREPAID','Prepago');
define('ACT_SPECIAL_TERMS', 'Vencimiento en días');
define('ACT_END_OF_MONTH','Vence al final de mes');
define('ACT_DAY_NEXT_MONTH','Vence un día específico');
define('ACT_DUE_ON', 'Vence: ');
define('ACT_DISCOUNT', 'Descuento ');
define('ACT_EARLY_DISCOUNT', ' porcentaje. ');
define('ACT_EARLY_DISCOUNT_SHORT', '% ');
define('ACT_DUE_IN','Vence en ');
define('ACT_TERMS_EARLY_DAYS', ' día(s). ');
define('ACT_TERMS_NET','Neto ');
define('ACT_TERMS_STANDARD_DAYS', ' día(s). ');
define('ACT_TERMS_CREDIT_LIMIT', 'Límite de Crédito: ');
define('ACT_AMT_PAST_DUE','Monto Moroso: ');
define('ACT_GOOD_STANDING','Cuenta al día');
define('ACT_OVER_CREDIT_LIMIT','La cuenta está sobre el límite de crédito');
define('ACT_HAS_PAST_DUE_AMOUNT','La cuenta está morosa');

// Account table fields - common to all account types
define('ACT_POPUP_WINDOW_TITLE', 'Busque Cuenta');
define('ACT_POPUP_TERMS_WINDOW_TITLE', 'Términos de Pago');

// misc information messages
define('ACT_DISPLAY_NUMBER_OF_ACCOUNTS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> %s)');
define('ACT_WARN_DELETE_ADDRESS','¿Está seguro que quiere borrar esta dirección?');
define('ACT_WARN_DELETE_ACCOUNT', '¿Está seguro que quiere borrar esta cuenta?');
define('ACT_WARN_DELETE_PAYMENT', '¿Está seguro que quiere borrar el registro de este pago?');
define('ACT_ERROR_CANNOT_DELETE','No puede borrar esta cuenta ya que tiene transacciones ligadas');
define('ACT_ERROR_DUPLICATE_ACCOUNT','Esta cuenta ya existe en el sistema.  Digite otra cuenta.');
define('ACT_ERROR_NO_ACCOUNT_ID','Para crear un nuevo Cliente o Proveedor, hace falta definir una cuenta.  Digite la cuenta.');
define('ACT_ERROR_ACCOUNT_NOT_FOUND','¡La cuenta que busca no se encontró!');
define('ACT_BILLING_MESSAGE','No es un requisito digitar todos los campos a no ser que se vaya a agregar una dirección de cobro.');
define('ACT_SHIPPING_MESSAGE','No es un requisito digitar todos los campos a no ser que se vaya a agregar una dirección de envío.');
define('ACT_NO_ENCRYPT_KEY_ENTERED','¡PRECAUCIÓN: La clave de encripción no ha sido declarada.  La información guardada no se mostrará y los valores digitados aquí no serán salvados!');
define('ACT_PAYMENT_REF','Referencia de Pago');
define('ACT_LIST_OPEN_ORDERS','Órdenes Pendientes');
define('ACT_LIST_OPEN_INVOICES','Facturas que no han sido canceladas');
define('ACT_CARDHOLDER_NAME','Nombre en la Tarjeta');
define('ACT_CARD_HINT','Pista para la tarjeta');
define('ACT_EXP','Exp');

define('ACT_NO_KEY_EXISTS','Un pago fue especificado pero la clave de encripción no ha sido declarada.  La dirección del pago fue salvada pero no la información del pago.');

// java script errors
define('ACT_JS_SHORT_NAME', '* El \'Nombre\' no puede quedar en blanco.\n');

// Audit log messages
define('ACT_LOG_ADD_ACCOUNT','Cuenta Agregada - ');
define('ACT_LOG_UPDATE_ACCOUNT','Cuenta Actualizada - ');
define('ACT_LOG_DELETE_ACCOUNT','Cuenta Borrada - ');

//default actions
define('ACT_ACTION_OPEN',' (Acceder)');


?>
