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
//  Path: /modules/install/language/es_cr/system_setup.php
//

  define('SAVE_SYSTEM_SETTINGS', 'Salve la Configuración del Sistema'); //this comes before TEXT_MAIN
  define('TEXT_MAIN', "Necesitamos configurar el ambiente del sistema de PhreeBooks&trade;.  Revise cuidadosamente cada configuración y cambie si es necesario para ajustarse a su estructura de directorios. Entonces presione <em>".SAVE_SYSTEM_SETTINGS.'</em> para continuar.');
  define('TEXT_PAGE_HEADING', 'PhreeBooks&trade; Instalación - Configuración del Sistema');
  define('SERVER_SETTINGS', 'Configuración del Servidor');
  define('PHYSICAL_PATH', 'Ruta física');
  define('PHYSICAL_PATH_INSTRUCTION', 'La ruta física al directorio de<br />PhreeBooks.<br />No ponga barra diagonal ("slash") al final.');
  define('VIRTUAL_HTTP_PATH', 'Ruta HTTP Virtual');
  define('VIRTUAL_HTTP_PATH_INSTRUCTION', 'Ruta Virtual a su directorio de<br />PhreeBooks.<br />No ponga barra diagonal ("slash") al final.');
  define('VIRTUAL_HTTPS_PATH', 'Ruta HTTPS Virtual');
  define('VIRTUAL_HTTPS_PATH_INSTRUCTION', 'Ruta Virtual a su directorio <br />SSL PhreeBooks.<br />No ponga barra diagonal ("slash") al final.');
  define('VIRTUAL_HTTPS_SERVER', 'Servidor HTTPS Virtual');
  define('VIRTUAL_HTTPS_SERVER_INSTRUCTION', 'Ruta Virtual a su directorio<br />SSL PhreeBooks.<br />No ponga barra diagonal ("slash") al final.');
  define('ENABLE_SSL', 'Habilitar SSL');
  define('ENABLE_SSL_INSTRUCTION', 'Le gustaría habilitar SSL (Secure Sockets Layer)?<br />Deje esto configurado en NO a no ser que esté SEGURO que tiene SSL funcionando.');
?>
