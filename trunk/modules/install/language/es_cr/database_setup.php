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
//  Path: /modules/install/language/es_cr/database_setup.php
//

  define('SAVE_DATABASE_SETTINGS', 'Salve la Configuración de la Base de Datos');//this comes before TEXT_MAIN
  define('TEXT_MAIN', "Seguidamente necesitamos información sobre su base de datos.  Digite cuidadosamente la información en la casilla correspondiente y presione <em>" . SAVE_DATABASE_SETTINGS . "</em> para continuar.");
  define('TEXT_PAGE_HEADING', 'PhreeBooks&trade; Instalación - Configuración de la Base de Datos');
  define('DATABASE_INFORMATION', 'Información de la Base de Datos');
  define('DATABASE_TYPE', 'Tipo de Base de Datos');
  define('DATABASE_TYPE_INSTRUCTION', 'Escoja el tipo de base de datos que desea usar.');
  define('DATABASE_HOST', 'Servidor de la Base de Datos');
  define('DATABASE_HOST_INSTRUCTION', '¿Cuál es el servidor de la base de datos?  El servidor de la base de datos puede digitarse de las siguientes manera: por nombre tal como  \'db1.miservidor.com\', o como una dirección IP, tal como \'192.168.0.1\'.');
  define('DATABASE_USERNAME', 'Usuario de la Base de Datos');
  define('DATABASE_USERNAME_INSTRUCTION', '¿Cual es el nombre del usuario para conectarse a la base de datos? Un ejemplo de usuario es \'root\'.');
  define('DATABASE_PASSWORD', 'Contraseña para la Base de Datos');
  define('DATABASE_PASSWORD_INSTRUCTION', '¿Cuál es la contraseña usada para conectarse a la Base de Datos?  La contraseña usada en combinación con el nombre del usuario forman la cuenta de usuario de la base de datos.');
  define('DATABASE_NAME', 'Nombre de la Base de Datos de la Compañía');
  define('DATABASE_NAME_INSTRUCTION', '¿Cuál es el nombre de la base de datos usada para almacenar los datos?  Un ejemplo de nombre de base de datos sería una forma abreviada del nombre de la tienda tal como \'mitienda\'.  NO se permite el uso de espacios ni de caracteres especiales. <!-- Si la base de datos no se encuentra, la base de datos será creada.-->');
  define('DATABASE_PREFIX', 'Prefijo para las Tablas de la Base de Datos');
  define('DATABASE_PREFIX_INSTRUCTION', '¿Qué prefijo le gustaría usar para las tablas de la base de datos?  Por ejemplo: pb_.  Deje en blanco si no necesita usar un prefijo.');
  define('DATABASE_CREATE', '¿Crear Base de Datos?');
  define('DATABASE_CREATE_INSTRUCTION', '¿Le gustaría que PhreeBooks crea la base de datos?');
  define('DATABASE_CONNECTION', 'Conexión Persistente');
  define('DATABASE_CONNECTION_INSTRUCTION', '¿Le gustaria habilitar conecciones persistentes a la base de datos?  Seleccione \'NO\' si no está seguro.');
  define('DATABASE_SESSION', 'Sesiones de la Base de Datos');
  define('DATABASE_SESSION_INSTRUCTION', '¿Quiere almacenar las sesiones en la base de datos?  Seleccione \'SÍ\' si no está seguro.');
  define('CACHE_TYPE', 'Método de Caché SQL');
  define('CACHE_TYPE_INSTRUCTION', 'Seleccione el método a usar para el caché de SQL.');
  define('SQL_CACHE', 'Directorio del Caché de Sesión/SQL');
  define('SQL_CACHE_INSTRUCTION', 'Digite el directorio a ser usado para el Caché SQL basado en archivo.');



  define('REASON_TABLE_ALREADY_EXISTS','No se puede crear tabla %s porque ya existe');
  define('REASON_TABLE_DOESNT_EXIST','No se puede usar la instrucción "drop table" %s porque la tabla no existe.');
  define('REASON_CONFIG_KEY_ALREADY_EXISTS','No se puede insertar "configuration_key" "%s" porque ya existe');
  define('REASON_COLUMN_ALREADY_EXISTS','No se puede AGREGAR columna %s porque ya existe.');
  define('REASON_COLUMN_DOESNT_EXIST_TO_DROP','No se puede ELIMINAR columna %s porque no existe.');
  define('REASON_COLUMN_DOESNT_EXIST_TO_CHANGE','No se puede MODIFICAR columna %s porque no existe.');
  define('REASON_PRODUCT_TYPE_LAYOUT_KEY_ALREADY_EXISTS','No se puede insertar "prod-type-layout configuration_key" "%s" porque ya existe');
  define('REASON_INDEX_DOESNT_EXIST_TO_DROP','No se puede "drop index" %s en table %s porque no existe.');
  define('REASON_PRIMARY_KEY_DOESNT_EXIST_TO_DROP','No se puede "drop primary key on table" %s porque no existe.');
  define('REASON_INDEX_ALREADY_EXISTS','No se puede "add index" %s a la tabla %s porque ya existe.');
  define('REASON_PRIMARY_KEY_ALREADY_EXISTS','No se puede "add primary key" a la tabla %s porque la clave del índice primario ya existe.');
  define('REASON_NO_PRIVILEGES','Usuario %s@%s no tiene %s privilegios para la base de datos.');

?>
