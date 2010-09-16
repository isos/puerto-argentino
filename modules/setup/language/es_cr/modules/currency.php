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
//  Path: /modules/setup/language/es_cr/modules/currency.php
//

define('SETUP_TITLE_CURRENCIES', 'Monedas');
define('SETUP_CURRENCY_NAME', 'Moneda');
define('SETUP_CURRENCY_CODES', 'Código');
define('SETUP_UPDATE_EXC_RATE','Actualize el tipo de cambio');

define('SETUP_CURR_EDIT_INTRO', 'Haga los cambios necesarios');
define('SETUP_INFO_CURRENCY_TITLE', 'Título:');
define('SETUP_INFO_CURRENCY_CODE', 'Código:');
define('SETUP_INFO_CURRENCY_SYMBOL_LEFT', 'Símbolo Izquierda:');
define('SETUP_INFO_CURRENCY_SYMBOL_RIGHT', 'Símbolo Derecha:');
define('SETUP_INFO_CURRENCY_DECIMAL_POINT', 'Punto Decimal:');
define('SETUP_INFO_CURRENCY_THOUSANDS_POINT', 'Separador de Miles:');
define('SETUP_INFO_CURRENCY_DECIMAL_PLACES', 'Número de Decimales:');
define('SETUP_INFO_CURRENCY_DECIMAL_PRECISE', 'Precisión Decimal: Para cuando se necesita una mayor precisión en los valores de moneda usados en precios unitarios y cantidades.  Este valor típicamente fija el número de decimales deseado:');
define('SETUP_INFO_CURRENCY_VALUE', 'Valor');
define('SETUP_INFO_CURRENCY_EXAMPLE', 'Ejemplo de Salida:');
define('SETUP_CURR_INSERT_INTRO', 'Digite la nueva moneda y la información correspondiente');
define('SETUP_CURR_DELETE_INTRO', 'Está seguro que quiere borrar esta moneda?');
define('SETUP_INFO_HEADING_NEW_CURRENCY', 'Nueva Moneda');
define('SETUP_INFO_HEADING_EDIT_CURRENCY', 'Edite Moneda');
define('SETUP_INFO_HEADING_DELETE_CURRENCY', 'Borre Moneda');
define('SETUP_SET_DEFAULT', 'Fije como predeterminado');
define('SETUP_INFO_SET_AS_DEFAULT', SETUP_SET_DEFAULT . ' (requiere actualización manual del tipo de cambio)');
define('SETUP_INFO_CURRENCY_UPDATED', 'El tipo de cambio para %s (%s) se actualizó exitosamente vía %s.');

define('SETUP_ERROR_CANNOT_CHANGE_DEFAULT', 'La moneda predeterminada no se puede cambiar una vez que hayan transacciones en el sistema!');
define('SETUP_ERROR_REMOVE_DEFAULT_CURRENCY', 'Error: La moneda predeterminada no se puede borrar. Cambie de moneda predeterminada y vuelva a intentarlo.');
define('SETUP_ERROR_CURRENCY_INVALID', 'Error: El tipo de cambio para %s (%s) no se puedo actualizar vía %s. Es válido el código para la moneda?');
define('SETUP_WARN_PRIMARY_SERVER_FAILED', 'Advertencia: El servidor de tipo de cambio primario (%s) falló para %s (%s).  Intentando actualizar con el servidor de tipo de cambio secundario.');
define('TEXT_DISPLAY_NUMBER_OF_CURRENCIES', TEXT_DISPLAY_NUMBER . 'monedas');
define('SETUP_LOG_CURRENCY','Monedas - ');

?>
