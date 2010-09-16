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
//  Path: /modules/setup/language/es_cr/modules/chart_of_accounts.php
//


/************* Release 2.0 additions ***********************/
define('GL_INFO_HEADING_ONLY', 'Cuenta Primaria<br />(Nota: Las cuentas primarias no pueden tener registros)');
define('GL_INFO_PRIMARY_ACCT_ID', 'Si esta es una subcuenta, seleccione la cuenta primaria:');
define('ERROR_ACCT_TYPE_REQ','¡Hace falta definir el tipo de cuenta!');
define('GL_ERROR_CANT_MAKE_HEADING','Esta cuenta tiene un saldo.  No se puede convertir a una cuenta primaria.');
/***********************************************************/


define('GL_POPUP_WINDOW_TITLE','Cuadro de Cuentas');
define('GL_HEADING_ACCOUNT_NAME', 'Cuenta #');
define('GL_HEADING_SUBACCOUNT', 'Subcuenta');
define('GL_EDIT_INTRO', 'Haga los cambios necesarios');
// define('GL_INFO_SUBACCOUNT', 'Esta es una subcuenta?');
// define('GL_INFO_PRIMARY_ACCT_ID', 'Sí. Seleccione también la cuenta principal:');
define('GL_INFO_ACCOUNT_TYPE', 'Tipo de Cuenta (Requisito)');
define('GL_INFO_ACCOUNT_INACTIVE', 'Inactiva');
define('GL_INFO_INSERT_INTRO', 'Digite la nueva cuenta con sus propiedades');
define('GL_INFO_NEW_ACCOUNT', 'Cuenta Nueva');
define('GL_INFO_EDIT_ACCOUNT', 'Edite la Cuenta');
define('GL_INFO_DELETE_ACCOUNT', 'Borre la Cuenta');
define('GL_INFO_DELETE_INTRO', '¿Está seguro que quiere borrar esta cuenta?\nLas cuentas no se pueden borrar si están ligadas a transacciones.');
define('GL_DISPLAY_NUMBER_OF_COA', TEXT_DISPLAY_NUMBER . 'cuentas');
define('GL_ERROR_CANT_DELETE','Esta cuenta no se puede borrar ya que está ligada a transacciones.');
define('GL_LOG_CHART_OF_ACCOUNTS','Cuadro de Cuentas - ');
?>
