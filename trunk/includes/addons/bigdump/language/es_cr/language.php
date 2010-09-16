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
//  Path: /includes/addons/bigdump/language/es_cr/language.php
//

define('TEXT_FILENAME','Archivo');
define('TEXT_MISC','Misc');
define('TEXT_QUERY','Consulta: ');
define('TEXT_MYSQL','MYSQL: ');
define('TEXT_PROCESSING_FILE','Procesando archivo: ');
define('TEXT_STARTING_LINE','Empezando desde la línea: ');
define('TEXT_TO_GO','Para terminar');
define('TEXT_DONE','Terminado');
define('TEXT_SESSION','Sesión');
define('TEXT_LINES','Líneas');
define('TEXT_QUERIES','Consultas');
define('TEXT_BYTES','Bytes');
define('TEXT_KB','KB');
define('TEXT_MB','MB');
define('TEXT_PERCENT','%');
define('TEXT_PERCENT_BAR','barra de %');
define('TEXT_STOP','ALTO');
define('TEXT_PRESS','Presione ');

define('BIGDUMP_INTRO','Este guión es una versión modificada del guión BigDump desarrollado por <a href="mailto:alexey@ozerov.de">Alexey Ozerov</a> - <a href="http://www.ozerov.de/bigdump.php" target="_blank">BigDump Home</a>');
define('BIGDUMP_FILE_EXISTS','¡El archivo %s ya existe! ¡Borre y súbalo de nuevo!');
define('BIGDUMP_UPLOAD_TYPES','Solo puede subir archivos del tipo .sql .gz o .csv.');
define('BIGDUMP_ERROR_MOVE','Hubo un error transfiriendo el archivo %s a %s');
define('BIGDUMP_ERROR_PERM','¡Revise los permisos de directorio para %s (deben ser 777)!');
define('BIGDUMP_FILE_SAVED','Archivo subido salvado como %s');
define('BIGDUMP_ERROR_UPLOAD','Error subiendo el archivo');
define('BIGDUMP_REMOVED',' fue removido exitósamente');
define('BIGDUMP_FAIL_REMOVE','No se puede remover ');
define('BIGDUMP_START_IMP','Empiece importe');
define('BIGDUMP_START_LOC',"en %s en %s");
define('BIGDUMP_DEL_FILE','Borre archivo');
define('BIGDUMP_NO_FILES','No se encontraron archivos subidos en el directorio actual');
define('BIGDUMP_ERROR_DIR','Error listando el directorio %s');
define('BIGDUMP_FROM_LOC','de %s a %s en %s');
define('BIGDUMP_UPLOAD_A','Está deshabilitado el subir formularios.  Los permisos del directorio actual <i>%s</i> <b>deben ser 777</b> para poder ');
define('BIGDUMP_UPLOAD_B',"subir archivo de aquí.  Alternativamente puede subir sus archivo via FTP al directorio: ");
define('BIGDUMP_UPLOAD_C','Puede subir su archivo de tamaño máximo de %s bytes (%s Mbytes) ');
define('BIGDUMP_UPLOAD_D',"directamente desde su navegador al servidor.  Alternativamente puede subir archivos de cualquier tamaño via FTP al directorio: ");
define('BIGDUMP_OPEN_FAIL','No se puede abrir %s para importar');
define('BIGDUMP_BAD_NAME','Verifique que el nombre del archivo contenga solo caracteres alfanuméricos, por ejemplo: %s.<br />O, especifique \%s en bigdump.php con el nombre completo del archivo. <br />O, deber subir primero el %s al servidor.');
define('BIGDUMP_NO_SEEK','No se puede buscar en %s');
define('BIGDUMP_IMPORT_MSG_1','ERROR INESPERADO: valores no-numéricos para el inicio y separación');
define('BIGDUMP_IMPORT_MSG_2','Error borrando valores de %s.');
define('BIGDUMP_IMPORT_MSG_3','ERROR INESPERADO: No se puede fijar el puntero después del final del archivo');
define('BIGDUMP_IMPORT_MSG_4','ERROR INESPERADO: No se puede fijar la separación del puntero: ');
define('BIGDUMP_IMPORT_MSG_5','Interrupción en la línea %s.');
define('BIGDUMP_IMPORT_MSG_6','En este lugar, la consulta actual es de un archivo csv, pero no fue fijado %s.');
define('BIGDUMP_IMPORT_MSG_7','Debe definir a dónde quiere enviar los datos.');
define('BIGDUMP_IMPORT_MSG_8','En este lugar, la consulta actual incluye mas de %s líneas.  Esto puede suceder si el archivo fue creado por un programa que no coloca un punto y coma seguido por un avance de línea al final de cada consulta, o si el archivo contiene inserciones extendidas. Consulte el archivo de preguntas frecuentes de BigDump para mayor información.');
define('BIGDUMP_IMPORT_MSG_9','Error en la línea %s: ');
define('BIGDUMP_IMPORT_MSG_10','ERROR INESPERADO: No se puede leer la separación del puntero para el archivo');
define('BIGDUMP_IMPORT_MSG_11','Estoy <b>esperando %s milisegundos</b> antes de empezar la siguiente sesión...');
define('BIGDUMP_IMPORT_MSG_12','Continúe de la línea %s (Habilite JavaScript para que lo haga automáticamente)');
define('BIGDUMP_IMPORT_MSG_13'," para abortar el importe<b> ¡O ESPERE!</b>");
define('BIGDUMP_IMPORT_MSG_14',' Interrupción en error');
define('BIGDUMP_IMPORT_MSG_15','Empieze al principio');
define('BIGDUMP_IMPORT_MSG_16',' (Borre (DROP) las tablas viejas antes de volver a empezar)');

define('BIGDUMP_READ_SUCCESS','Felicitaciones: Se llegó al final del archivo.  Se supone que todo está bien.');
?>
