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
//  Path: /modules/setup/language/es_cr/language.php
//

// configuration
define('SETUP_CONFIG_EDIT_INTRO', 'Haga los cambios que sean necesarios');
define('SETUP_INFO_DATE_ADDED', 'Fecha Agregado:');
define('SETUP_INFO_LAST_MODIFIED', 'Última Modificación:');
define('SETUP_NO_MODULE_NAME','¡El programa de configuración requiere un nombre de módulo!');

// company manager
define('SETUP_CO_MGR_COPY_CO','Copie la Compañía');
define('SETUP_CO_MGR_COPY_HDR','Digite la base de datos para la compañía nueva. (Debe ajustarse a Mysql y su propia convención de nombramiento de archivos, típicamente de 8 a 12 caracteres alfanuméricos).  Este nombre es usado como el nombre de la base de datos y será agregado al directorio my_files donde se mantienen los datos específicos de la compañía.  Si sus privilegios no le permiten crear la base de datos pídale al administrados del sistema que crea la base de datos antes de crear la compañía nueva.');
define('SETUP_CO_MGR_SRVR_NAME','Servidor de la Base de Datos ');
define('SETUP_CO_MGR_DB_NAME','Nombre de la Base de Datos ');
define('SETUP_CO_MGR_DB_USER','Usuario de la Base de Datos ');
define('SETUP_CO_MGR_DB_PW','Contraseña para la Base de Datos ');
define('SETUP_CO_MGR_CO_NAME','Nombre Completo de la Compañía ');
define('SETUP_CO_MGR_SELECT_OPTIONS','Seleccione los registros de la base de datos que quiere copiar a la nueva compañía.');
define('SETUP_CO_MGR_OPTION_1','Copie todo el contenido de la base de datos a la nueva compañía.');
define('SETUP_CO_MGR_OPTION_2','Copie el cuadro de cuentas a la nueva compañía.');
define('SETUP_CO_MGR_OPTION_3','Copie los reportes/formularios a la nueva compañía.');
define('SETUP_CO_MGR_OPTION_4','Copie el inventario a la nueva compañía.');
define('SETUP_CO_MGR_OPTION_5','Copie los clientes a la nueva compañía.');
define('SETUP_CO_MGR_OPTION_6','Copie los proveedores a la nueva compañía.');
define('SETUP_CO_MGR_OPTION_7','Copie los empleados a la nueva compañía.');
define('SETUP_CO_MGR_OPTION_8','Copie los usuarios a la nueva compañía.');
define('SETUP_CO_MGR_ERROR_EMPTY_FIELD','¡El nombre de la base de datos y la compañía no pueden dejarse en blanco!');
define('SETUP_CO_MGR_NO_DB','Error creando la base de datos, revise los privilegios y el nombre de la base de datos.  El administrador del sistema quizás sea quien deba crear la base de datos antes de que Ud. pueda crear la compañía.');
define('SETUP_CO_MGR_DUP_DB_NAME','Error - ¡La base de datos no puede tener el mismo nombre que la actual base de datos!');
define('SETUP_CO_MGR_CANNOT_CONNECT','Error conectando a la nueva base de datos.  Revise el nombre del usuario y la contraseña.');
define('SETUP_CO_MGR_ERROR_1','Error creando las tablas de la base de datos.');
define('SETUP_CO_MGR_ERROR_2','Error cargando los datos a las tablas de la base de datos.');
define('SETUP_CO_MGR_ERROR_3','Error creando los directorios de la compañía.');
define('SETUP_CO_MGR_ERROR_4','Error creando el archivo de configuración de la compañía.');
define('SETUP_CO_MGR_ERROR_5A','Error eliminando la tabla ');
define('SETUP_CO_MGR_ERROR_5B','. Base de datos Error no. ');
define('SETUP_CO_MGR_ERROR_6','Error copiando la tabla ');
define('SETUP_CO_MGR_ERROR_7','Error cargando los datos de demostración.');
define('SETUP_CO_MGR_CREATE_SUCCESS','La compañía se creó exitósamente.');
define('SETUP_CO_MGR_DELETE_SUCCESS','¡La compañía ha sido borrada exitósamente!');
define('SETUP_CO_MGR_LOG','Administrador de Compañías - ');

define('SETUP_CO_MGR_ADD_NEW_CO','Crear una Compañía Nueva');
define('SETUP_CO_MGR_ADD_NEW_DEMO','Agregue datos de demostración a las tablas de la base de datos.');

define('SETUP_CO_MGR_DEL_CO','Borre la compañía');
define('SETUP_CO_MGR_SELECT_DELETE','Seleccione la compañía a borrar.');
define('SETUP_CO_MGR_DELETE_CONFIRM','¡ADVERTENCIA: ESTO BORRARÁ LA BASE DE DATOS Y TODOS LOS ARCHIVOS CON INFORMACIÓN DE LA COMPAÑÍA!  ¡TODA LA INFORMACION SE PERDERÁ!');
define('SETUP_CO_MGR_JS_DELETE_CONFIRM','¿Está seguro que quiere borrar esta compañía?');

?>
