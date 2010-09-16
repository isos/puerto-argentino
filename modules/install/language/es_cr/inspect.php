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
//  Path: /modules/install/language/es_cr/inspect.php
//

  define('TEXT_PAGE_HEADING', 'PhreeBooks&trade; Instalación - Inspección del Servidor');
  define('INSTALL_BUTTON', 'Instale '); // this comes before TEXT_MAIN
  define('UPGRADE_BUTTON', 'Actualice'); // this comes before TEXT_MAIN
  define('DB_UPGRADE_BUTTON', 'Actualice Base de Datos'); // this comes before TEXT_MAIN
  define('REFRESH_BUTTON', 'Vuelva a Revisar');
//Button meanings: (to be made into help-text for future version):
// "Install" = make new configure.php files, regardless of existing contents.  Load new database by dropping old tables.
// "Upgrade" = read old configure.php files, and write new ones using new structure. Upgrade database, instead of wiping and new install
// "Database Upgrade" = don't write the configure.php files -- simply jump to the database-upgrade page. Only displayed if detected database version is new enough to not require configure.php file updates.

  define('TEXT_MAIN', 'Revise que su servidor cumple con los requisitos para que PhreeBooks&trade; funcione. &nbsp;Resuelva cualquier error y advertencia antes de continuar. &nbsp;Luego presione <em>'.INSTALL_BUTTON.'&nbsp;</em>para continuar.');
  define('SYSTEM_INSPECTION_RESULTS', 'Resultados de la Inspección del Sistema');
  define('OTHER_INFORMATION', 'Otra Información del Sistema (Solo de referencia)');
  define('OTHER_INFORMATION_DESCRIPTION', 'La información que sigue no necesariamente indica un problema.  Sencillamente se muestra para tener toda la información reunida en un solo lugar.');

  define('NOT_EXIST','NO SE ENCONTRÓ');
  define('WRITABLE','Permite Escritura');
  define('UNWRITABLE',"<span class='errores'>No se puede salvar</span>");
  define('UNKNOWN','Desconocido');

  define('UPGRADE_DETECTION','Actualización está disponible');
  define('LABEL_PREVIOUS_INSTALL_FOUND','Se encontró una instalación previa de PhreeBooks');
  define('LABEL_PREVIOUS_VERSION_NUMBER','La base de datos parece ser de PhreeBooks v%s');
  define('LABEL_PREVIOUS_VERSION_NUMBER_UNKNOWN','<em>Sin embargo, la versión de su base de datos no se puede determinar, resultado usual de tener una tabla con prefijos equivocados u otro problema con la base de datos. <br /><br />ADVERTENCIA: Use solo la opción de actualización si está seguro que la configuración de su archivo configure.php está correcta.</em>');

  define('DISPLAY_PHP_INFO','Enlace a PHP Info: ');
  define('VIEW_PHP_INFO_LINK_TEXT','Vea PHP INFO en su servidor');
  define('LABEL_WEBSERVER','Servidor');
  define('LABEL_MYSQL_AVAILABLE','Soporta MySQL');
  define('LABEL_MYSQL_VER','Versión MySQL');
  define('LABEL_DB_PRIVS','Privilegios de Base de Datos');
  define('LABEL_POSTGRES_AVAILABLE','Soporte para PostgreSQL');
  define('LABEL_PHP_VER','Versión PHP');
  define('LABEL_REGISTER_GLOBALS','Register Globals');
  define('LABEL_SET_TIME_LIMIT','PHP Tiempo Máximo de Ejecución por página');
  define('LABEL_DISABLED_FUNCTIONS','Disabilite funciones PHP');
  define('LABEL_SAFE_MODE','PHP Modo Seguro');
  define('LABEL_CURRENT_CACHE_PATH','Directorio Actual de Cache SQL');
  define('LABEL_SUGGESTED_CACHE_PATH','Directorio Sugerido para Cache SQL Cache');
  define('LABEL_HTTP_HOST','Servidor HTTP');
  define('LABEL_PATH_TRANLSATED','Path_Translated');
  define('LABEL_PHP_API_MODE','Modo PHP API');
  define('LABEL_PHP_MODULES','Módulos PHP Activos');
  define('LABEL_PHP_EXT_SESSIONS','Soporte para sesiones PHP');
  define('LABEL_PHP_SESSION_AUTOSTART','PHP Session.AutoStart');
  define('LABEL_PHP_EXT_SAVE_PATH','PHP Session.Save_Path');
  define('LABEL_PHP_EXT_FTP','Soporte para PHP FTP');
  define('LABEL_PHP_EXT_CURL','Soporte para PHP cURL');
  define('LABEL_PHP_MAG_QT_RUN','Configuración para PHP magic_quotes_runtime ');
  define('LABEL_PHP_EXT_GD','Soporte para PHP GD');
  define('LABEL_PHP_EXT_OPENSSL','Soporte para PHP OpenSSL');
  define('LABEL_PHP_UPLOAD_STATUS','Soporte para PHP Cargar');
  define('LABEL_PHP_EXT_PFPRO','Soporte para PHP Payflow Pro');
  define('LABEL_PHP_EXT_ZLIB','Soporte para PHP Compresión ZLIB');
  define('LABEL_PHP_SESSION_TRANS_SID','PHP session.use_trans_sid');
  define('LABEL_DISK_FREE_SPACE','Espacio Libre en Disco Duro del Servidor');
  define('LABEL_XML_SUPPORT','Soporte para PHP XML');
  define('LABEL_OPEN_BASEDIR','Restricciones PHP open_basedir');
  define('LABEL_UPLOAD_TMP_DIR','Directorio TMP para PHP cargar archivos');
  define('LABEL_SENDMAIL_FROM','PHP sendmail \'De\'');
  define('LABEL_SENDMAIL_PATH','Ruta de PHP sendmail');
  define('LABEL_SMTP_MAIL','Destino de PHP SMTP');
  define('LABEL_CONFIG_WRITEABLE','/includes directorrio con permisos de escritura');
  define('LABEL_MY_FILES_CREATE','/my_files directorio con permisos de escritura');
  define('LABEL_CRITICAL','Ítems Críticos');
  define('LABEL_RECOMMENDED','Items Recomendados');
  define('LABEL_OPTIONAL','Items Opcionales');
  define('LABEL_UPGRADE_PERMISSION','Permiso para Actualización');

  define('LABEL_EXPLAIN','&nbsp;Presione aquí para mas información');
  define('LABEL_FOLDER_PERMISSIONS','Permisos de Archivo y Directorio');
  define('LABEL_WRITABLE_FOLDER_INFO','Para que muchas funciones administrativas de uso día a día funcionen en PhreeBooks&trade;,
varios archivos y directorios deben tener permisos de escritura.  Seguidamente está la lista de directorios que necesitan tener permisos de lectura y escritura, y la configuración recomendada de CHMOD.  Corrija esta configuración antes de continuar con la instalación. 
Refresque esta página en su navegador para volver a revisar la configuración.<br /><br >Algunos servidores no le permiten fijar el CHMOD a 777, sino solo a 666.  Pruebe primero con 777 y si necesita entonces use 666.');


?>
