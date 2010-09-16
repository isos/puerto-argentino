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
//  Path: /modules/install/language/es_cr/admin_setup.php
//

  define('TEXT_PAGE_HEADING', 'PhreeBooks&trade; Instalación - Configuración de la Cuenta de Administrador');
  define('SAVE_ADMIN_SETTINGS', 'Salve Configuración de Admin');//this comes before TEXT_MAIN
  define('TEXT_MAIN', "Para configurar el programa PhreeBooks&trade;, necesita una cuenta administrativa.  Seleccione un nombre y una contraseña para el administrador, y digite una dirección de correo electrónico para enviar la contraseña cuando solicita resetearla.  Digite y revise cuidadosamene la información y presione <em>".SAVE_ADMIN_SETTINGS.'</em> cuando haya terminado.');
  define('ADMIN_INFORMATION', 'Información sobre el Administrador');
  define('ADMIN_USERNAME', 'Nombre de Usuario del Administrador');
  define('ADMIN_USERNAME_INSTRUCTION', 'Digite el nombre del usuario de la cuenta del administrador de PhreeBooks.');
  define('ADMIN_PASS', 'Contraseña para el Administrador');
  define('ADMIN_PASS_INSTRUCTION', 'Digite la contraseña del usuario de la cuenta del administrador de PhreeBooks.');
  define('ADMIN_PASS_CONFIRM', 'Confirme la contraseña del administrador');
  define('ADMIN_PASS_CONFIRM_INSTRUCTION', 'Confirme la contraseña del usuario de la cuenta del administrador de PhreeBooks.');
  define('ADMIN_EMAIL', 'Correo Electrónico del Administrador');
  define('ADMIN_EMAIL_INSTRUCTION', 'Digite el correo electrónico usado por el administrador de PhreeBooks.');
  define('UPGRADE_DETECTION','Se detectó una actualización');
  define('UPGRADE_INSTRUCTION_TITLE','Revise a ver si hay actualizaciones de PhreeBooks&trade; cuando hace login como Administrador');
  define('UPGRADE_INSTRUCTION_TEXT','Esto intentará comunicarse con el servidor en línea a ver si hay una actualización de Phreebooks disponible o no.  Si una actualización está disponible aparecerá un mensaje en admin.  NO se instalará automáticamente ninguna actualización.<br />Esto lo puede cambiar mas adelante en Admin-> Config-> Mi Tienda-> Revise si está disponible una actualización.');

?>
