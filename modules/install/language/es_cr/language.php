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
//  Path: /modules/install/language/es_cr/language.php
//

  define('YES', 'SI');
  define('NO', 'NO');
  define('LANGUAGE','Español (CR)');
  define('LANGUAGE_TEXT','Idiomas Disponibles: ');

  // Global entries for the <html> tag
 define('HTML_PARAMS','lang="es-CR" xml:lang="es-CR"');

  // charset for web pages and emails
  define('CHARSET', 'UTF-8');

  // META TAG TITLE
  define('META_TAG_TITLE', 'PhreeBooks&trade; Instalación');

  // Navigation
  define('INSTALL_NAV_WELCOME','Bienvenido');
  define('INSTALL_NAV_LICENSE','Licencia');
  define('INSTALL_NAV_PREREQ','Prerequisitos');
  define('INSTALL_NAV_SYSTEM','Configuración del Sistema');
  define('INSTALL_NAV_DATABASE','Configuración Base de Datos');
  define('INSTALL_NAV_ADMIN','Configuración de Admin');
  define('INSTALL_NAV_COMPANY','Configuración de la Compañía');
  define('INSTALL_NAV_CHART','Cuadro de Cuentas');
  define('INSTALL_NAV_FY','Configuración Año Fiscal');
  define('INSTALL_NAV_DEFAULTS','Cuentas Predeterminadas');
  define('INSTALL_NAV_FINISHED','Finalizado');

  if (isset($_GET['main_page']) && ($_GET['main_page']== 'index' || $_GET['main_page']== 'licence')) {
    define('TEXT_ERROR_WARNING', 'Hola.  Solo unos puntos a considerar antes de continuar.');
  } else {
    define('TEXT_ERROR_WARNING', '<span class="errores"><strong>Advertencia: Hubo Problemas</strong></span>');
  }

  define('DB_ERROR_NOT_CONNECTED', 'Error de Instalación: No se pudo conectar a la base de datos');

  define('UPLOAD_SETTINGS','El tamaño máximo del archivo a cargar será el MENOR de los siguientes valores:.<br />
<em>upload_max_filesize</em> en php.ini %s <br />
<em>post_max_size</em> en php.ini: %s <br />' . 
//'<em>PhreeBooks</em> Upload Setting: %s <br />' .
'Pueda que encuentre alguna configuración de Apache que le impida cargar archivos o limite el tamaño máximo del archivo.  
Vea la documentación de Apache para más información.');

  define('TEXT_HELP_LINK', ' más información...');
  define('TEXT_CLOSE_WINDOW', 'Cierre Ventana');

  define('ERROR_TEXT_4_1_2', 'PHP Versión 4.1.2');
  define('ERROR_CODE_4_1_2', '1');

  define('ERROR_TEXT_STORE_CONFIGURE', 'el archivo /includes/configure.php no existe');
  define('ERROR_CODE_STORE_CONFIGURE', '3');

  define('ERROR_TEXT_PHYSICAL_PATH_ISEMPTY', 'Ruta física esta vacía');
  define('ERROR_CODE_PHYSICAL_PATH_ISEMPTY', '9');

  define('ERROR_TEXT_PHYSICAL_PATH_INCORRECT', 'Ruta física está incorrecta');
  define('ERROR_CODE_PHYSICAL_PATH_INCORRECT', '10');

  define('ERROR_TEXT_VIRTUAL_HTTP_ISEMPTY', 'HTTP virtual está en blanco');
  define('ERROR_CODE_VIRTUAL_HTTP_ISEMPTY', '11');

  define('ERROR_TEXT_VIRTUAL_HTTPS_ISEMPTY', 'HTTPS virtual está en blanco');
  define('ERROR_CODE_VIRTUAL_HTTPS_ISEMPTY', '12');

  define('ERROR_TEXT_VIRTUAL_HTTPS_SERVER_ISEMPTY', 'HTTPS servidor virtual está en blanco');
  define('ERROR_CODE_VIRTUAL_HTTPS_SERVER_ISEMPTY', '13');

  define('ERROR_TEXT_DB_USERNAME_ISEMPTY', 'El nombre del usuario de la base de datos está en blanco');
  define('ERROR_CODE_DB_USERNAME_ISEMPTY', '16'); // re-using another one, since message is essentially the same.

  define('ERROR_TEXT_DB_HOST_ISEMPTY', 'Servidor de base de datos está en blanco');
  define('ERROR_CODE_DB_HOST_ISEMPTY', '24');

  define('ERROR_TEXT_DB_NAME_ISEMPTY', 'El nombre de la base de datos está en blanco'); 
  define('ERROR_CODE_DB_NAME_ISEMPTY', '25');

  define('ERROR_TEXT_DB_SQL_NOTEXIST', 'El archivo de instalación SQL no existe');
  define('ERROR_CODE_DB_SQL_NOTEXIST', '26');

  define('ERROR_TEXT_DB_NOTSUPPORTED', 'El tipo de base de datos aún no tiene soporte');
  define('ERROR_CODE_DB_NOTSUPPORTED', '27');

  define('ERROR_TEXT_DB_CONNECTION_FAILED', 'La conexión a la base de datos falló');
  define('ERROR_CODE_DB_CONNECTION_FAILED', '28');

  define('ERROR_TEXT_DB_CREATE_FAILED', 'No se pudo crear base de datos');
  define('ERROR_CODE_DB_CREATE_FAILED', '29');

  define('ERROR_TEXT_DB_NOTEXIST', 'La base de datos no existe');
  define('ERROR_CODE_DB_NOTEXIST', '30');

  define('ERROR_TEXT_STORE_ID_ISEMPTY', 'Hace falta la identificación de la tienda');
  define('ERROR_CODE_STORE_ID_ISEMPTY', '109');

  define('ERROR_TEXT_STORE_NAME_ISEMPTY', 'Hace falta el nombre de la tienda');
  define('ERROR_CODE_STORE_NAME_ISEMPTY', '31');

  define('ERROR_TEXT_STORE_ADDRESS1_ISEMPTY', 'Hace falta la dirección de la tienda');
  define('ERROR_CODE_STORE_ADDRESS1_ISEMPTY', '32');

  define('ERROR_TEXT_STORE_OWNER_EMAIL_ISEMPTY', 'Hace falta el correo electrónico de la tienda');
  define('ERROR_CODE_STORE_OWNER_EMAIL_ISEMPTY', '33');

  define('ERROR_TEXT_STORE_OWNER_EMAIL_NOTEMAIL', 'El correo electrónico de la tienda no es válido');
  define('ERROR_CODE_STORE_OWNER_EMAIL_NOTEMAIL', '34');

  define('ERROR_TEXT_STORE_POSTAL_CODE_ISEMPTY', 'Hace falta el código postal para la tienda');
  define('ERROR_CODE_STORE_POSTAL_CODE_ISEMPTY', '35');

  define('ERROR_TEXT_DEMO_SQL_NOTEXIST', 'No existe el archivo SQL para el producto del archivo de demostración');
  define('ERROR_CODE_DEMO_SQL_NOTEXIST', '36');

  define('ERROR_TEXT_ADMIN_USERNAME_ISEMPTY', 'El nombre del usuario Admin está en blanco');
  define('ERROR_CODE_ADMIN_USERNAME_ISEMPTY', '46');

  define('ERROR_TEXT_ADMIN_EMAIL_ISEMPTY', 'El correo electrónico de Admin está en blanco');
  define('ERROR_CODE_ADMIN_EMAIL_ISEMPTY', '47');

  define('ERROR_TEXT_ADMIN_EMAIL_NOTEMAIL', 'El correo electrónico de Admin no es válido');
  define('ERROR_CODE_ADMIN_EMAIL_NOTEMAIL', '48');

  define('ERROR_TEXT_LOGIN_PASS_ISEMPTY', 'La contraseña para Admin está en blanco');
  define('ERROR_CODE_ADMIN_PASS_ISEMPTY', '49');

  define('ERROR_TEXT_LOGIN_PASS_NOTEQUAL', 'Las contraseñas no concuerdan');
  define('ERROR_CODE_ADMIN_PASS_NOTEQUAL', '50');

  define('ERROR_TEXT_PHP_VERSION', 'La versión PHP no está soportada');
  define('ERROR_CODE_PHP_VERSION', '55');

  define('ERROR_TEXT_ADMIN_CONFIGURE_WRITE', 'admin configure.php no tiene permisos de escritura');
  define('ERROR_CODE_ADMIN_CONFIGURE_WRITE', '56');

  define('ERROR_TEXT_STORE_CONFIGURE_WRITE', '/includes/configure.php no tiene permisos de escritura');
  define('ERROR_CODE_STORE_CONFIGURE_WRITE', '57');

  define('ERROR_TEXT_CACHE_DIR_ISEMPTY', 'El Directorio del Cache de la Sesión/SQL está vacío');
  define('ERROR_CODE_CACHE_DIR_ISEMPTY', '61');

  define('ERROR_TEXT_CACHE_DIR_ISDIR', 'El Directorio del Cache de la Sesión/SQL no existe');
  define('ERROR_CODE_CACHE_DIR_ISDIR', '62');

  define('ERROR_TEXT_CACHE_DIR_ISWRITEABLE', 'El Directorio del Cache de la Sesión/SQL no tiene permisos de escritura');
  define('ERROR_CODE_CACHE_DIR_ISWRITEABLE', '63');

  define('ERROR_TEXT_PHPBB_CONFIG_NOTEXIST', 'Los archivos phpBB no existen');
  define('ERROR_CODE_PHPBB_CONFIG_NOTEXIST', '68');

  define('ERROR_TEXT_REGISTER_GLOBALS_ON', 'Register Globals está ON');
  define('ERROR_CODE_REGISTER_GLOBALS_ON', '69');

  define('ERROR_TEXT_SAFE_MODE_ON', 'Safe Mode está ON');
  define('ERROR_CODE_SAFE_MODE_ON', '70');

  define('ERROR_TEXT_CACHE_CUSTOM_NEEDED','Hace falta que exista una carpeta del cache para usar esta opción');
  define('ERROR_CODE_CACHE_CUSTOM_NEEDED', '71');

  define('ERROR_TEXT_TABLE_RENAME_CONFIGUREPHP_FAILED','No se pudieron actualizar todos los archivos configure.php files con el nuevo prefijo');
  define('ERROR_CODE_TABLE_RENAME_CONFIGUREPHP_FAILED', '72');

  define('ERROR_TEXT_TABLE_RENAME_INCOMPLETE','No se pudieron renombrar todas las tablas');
  define('ERROR_CODE_TABLE_RENAME_INCOMPLETE', '73');

  define('ERROR_TEXT_SESSION_SAVE_PATH','PHP "session.save_path" no tiene permiso de escritura');
  define('ERROR_CODE_SESSION_SAVE_PATH','74');

  define('ERROR_TEXT_MAGIC_QUOTES_RUNTIME','PHP "magic_quotes_runtime" está activo');
  define('ERROR_CODE_MAGIC_QUOTES_RUNTIME','75');

  define('ERROR_TEXT_DB_VER_UNKNOWN','La información sobre la versión del motor de la base de datos no se puede determinar');
  define('ERROR_CODE_DB_VER_UNKNOWN','76');

  define('ERROR_TEXT_UPLOADS_DISABLED','Cargar archivos está desabilitado');
  define('ERROR_CODE_UPLOADS_DISABLED','77');

  define('ERROR_TEXT_ADMIN_PWD_REQUIRED','Es necesario tener una contraseña para Admin para proceder a hacer la actualización de versión');
  define('ERROR_CODE_ADMIN_PWD_REQUIRED','78');

  define('ERROR_TEXT_PHP_SESSION_SUPPORT','Es necesario tener soporte de PHP Session');
  define('ERROR_CODE_PHP_SESSION_SUPPORT','80');

  define('ERROR_TEXT_PHP_AS_CGI','No se recominenda correr PHP con cgi a no ser que sea un servidor Windows');
  define('ERROR_CODE_PHP_AS_CGI','81');

  define('ERROR_TEXT_DISABLE_FUNCTIONS','Hay funciones PHP requeridas que están desabilitadas en su servidor');
  define('ERROR_CODE_DISABLE_FUNCTIONS','82');

  define('ERROR_TEXT_OPENSSL_WARN','OpenSSL es una manera en que se puede configurar el servidor para ofrecer SSL (https://) es su sitio internet.<br /><br />Si se indica que no está disponible, posibles causas serían:<br />(a) su servicio de hospedaje no soporta SSL<br />(b) su servidor no tiene instalado OpenSSL, pero pueda ser que tenga otro servicio SSL disponible<br />(c) el servicio de hospedaje pueda que no conoce los detalles de su certificado SSL para que puedan habilitar el soporte para SSL en su dominio<br />(d) Pueda que PHP aún no esté configurado para reconocer OpenSSL.<br /><br />En todo caso, si necesita encriptar y necesita apoyo para configurar SSL en su sitio debe ponerse en contacto con la gente de su servicio de hospedaje para que lo ayuden.');
  define('ERROR_CODE_OPENSSL_WARN','79');

  define('ERROR_TEXT_DB_PREFIX_NODOTS','El prefijo para las tablas de la base de datos no puede contener ninguno de los siguientes caracteres: / o \\ o . ');
  define('ERROR_CODE_DB_PREFIX_NODOTS','83');

  define('ERROR_TEXT_PHP_SESSION_AUTOSTART','Debe desabilitar PHP Session.autostart.');
  define('ERROR_CODE_PHP_SESSION_AUTOSTART','84');
  define('ERROR_TEXT_PHP_SESSION_TRANS_SID','Debe desabilitar PHP Session.use_trans_sid.');
  define('ERROR_CODE_PHP_SESSION_TRANS_SID','86');
  define('ERROR_TEXT_DB_PRIVS','Hace falta permisos para el usuario de la base de datos');
  define('ERROR_CODE_DB_PRIVS','87');
  define('ERROR_TEXT_COULD_NOT_WRITE_CONFIGURE_FILES','Hubo un error a la hora de grabar a disco el archivo /includes/configure.php');
  define('ERROR_CODE_COULD_NOT_WRITE_CONFIGURE_FILES','88');
  define('ERROR_TEXT_DB_EXISTS','La base de datos ya existe');
  define('ERROR_CODE_DB_EXISTS','108');

  define('ERROR_TEXT_NO_CHART_SELECTED','¡Seleccione un cuadro para mostrar los detalles!');
  define('TEXT_CURRENT_SETTINGS','-- Configuración Actual de la Cuenta --');
  define('TEXT_ID','Identificación de Cuenta');
  define('TEXT_DESCRIPTION','Descripción');
  define('TEXT_ACCT_TYPE','Tipo de Cuenta');

  define('ERROR_TEXT_CHART_NAME_ISEMPTY', 'Hace falta el machote para el cuadro de cuentas.');
  define('ERROR_CODE_CHART_NAME_ISEMPTY', '94');


    define('POPUP_ERROR_1_HEADING', 'Se detectó PHP Versión 4.1.2');
    define('POPUP_ERROR_1_TEXT', 'Hay casos en que PHP Versión 4.1.2 tiene una pulga que afecta "super global arrays".  Esto puede resultar en que la sección de admin en PhreeBooks sea inaccesible.  Se le recomienda que actualice su versión de PHP a una versión mas reciente si fuera posible.');
    
 
    define('POPUP_ERROR_3_HEADING', '/includes/configure.php no existe');
    define('POPUP_ERROR_3_TEXT', 'El archivo /includes/configure.php no existe.  Este archivo se creará durante el proceso de instalación.');
    
 
    define('POPUP_ERROR_4_HEADING', 'Ruta física');
    define('POPUP_ERROR_4_TEXT', 'La ruta física el la localización del directorio donde residen sus archivos instalados de PhreeBooks.  Por ejemplo, en algunos sistemas con Linux, los archivos html están en  /var/www/html.  Si pone los archivos de PhreeBooks en un directorio llamado \'tienda\', la ruta física sería /var/www/html/tienda.  Usualmente se puede confiar en que el programa instalador acerte este directorio correctamente.');
    
 
    define('POPUP_ERROR_5_HEADING', 'Ruta Virtual HTTP');
    define('POPUP_ERROR_5_TEXT', 'Esta es la dirección que necesita poner en su navegador para ver su sitio de red donde está PhreeBooks.  Si su sitio está en la \'raíz\' de su dominio, esto sería \'http://www.midominio.com\'.  Si puso los archivos en un directorio llamado \'tienda\' entonces su ruta sería \'http://www.midominio.com/tienda\'.');
    
 
    define('POPUP_ERROR_6_HEADING', 'Servidor Virtual HTTPS');
    define('POPUP_ERROR_6_TEXT', 'Esta sería la dirección al servidor seguro/SSL.  Esta dirección varía dependiendo de cómo se implemente en su servidor el modo SSL/Secure.  Se le recomienda que lea en <a href="http://www.phreebooks.com/" target="_blank">FAQ (Preguntas Frecuentes)</a> sobre SSL para asegurarse que se configure correctamente.');
    

    define('POPUP_ERROR_7_HEADING', 'Ruta Virtual HTTPS');
    define('POPUP_ERROR_7_TEXT', 'Esta es la dirección que debe poner en su navegador de páginas internet para ver su sitio que contiene el programa PhreeBooks en modo secure/SSL. Se le recomienda que lea en <a href="http://www.phreebooks.com/" target="_blank">FAQ (Preguntas Frecuentes)</a> sobre SSL para asegurarse que se configure correctamente.');

    define('POPUP_ERROR_8_HEADING', 'Habilite SSL');
    define('POPUP_ERROR_8_TEXT', 'Esta opción determina si el modo SSL/Secure (HTTPS:) es usado en páginas vulnerables de su sitio Phreebooks.<br /><br />Cualquier página donde haga falta digitar o que contenga información personal y/o financiera e.i. login, pagos o detalles de la cuenta puede ser protegido por el modo SSL/Secure. <br /><br />Debe tener acceso a un servidor SSL (denominado por HTTPS en lugar de HTTP). <br /><br />SI NO ESTÁ SEGURO si tiene un servidor SSL entonces deje esta opción en NO por ahora, y verifique con su servicio de hospedaje.  Nota: Al igual que con todas las opciones de configuración, esto puede cambiarse mas adelante editando el archivo configure.php.');

    define('POPUP_ERROR_9_HEADING', 'La Ruta Física está vacía');
    define('POPUP_ERROR_9_TEXT', 'Dejó vacía la digitación para la ruta física.  Debe digitar un valor válido aquí.');
 
    define('POPUP_ERROR_10_HEADING', 'La Ruta Física está incorrecta');
    define('POPUP_ERROR_10_TEXT', 'La digitación para la ruta física que hizo no parece ser válida.  Corrija y pruebe de nuevo.');
 
    define('POPUP_ERROR_11_HEADING', 'La Ruta Virtual HTTP está vacía');
    define('POPUP_ERROR_11_TEXT', 'Dejó vacía la digitación para la ruta virtual HTTP.  Debe digitar un valor válido aquí.');
 
    define('POPUP_ERROR_12_HEADING', 'La Ruta Virtual HTTPS está vacía');
    define('POPUP_ERROR_12_TEXT', 'Dejó vacía la digitación para la ruta virtual HTTPS así como no habilitar el modo SSL.  Debe digitar valores válidos o desabilitar el modo SSL.');
 
    define('POPUP_ERROR_13_HEADING', 'El Servidor Virtual HTTPS está vacío');
    define('POPUP_ERROR_13_TEXT', 'Dejó vacía la digitación para el servidor virtual HTTPS así como no habilitar el modo SSL.  Debe digitar valores válidos o desabilitar el modo SSL.');

    define('POPUP_ERROR_14_HEADING', 'Tipo de Base de Datos');
    define('POPUP_ERROR_14_TEXT', 'PhreeBooks está diseñado para trabajar con múltiples tipos de base de datos.  Desafortunadamente, en este momento esa funcionalidad no está completa.  Por ahora deberá dejarlo configurado para MySQL.');

    define('POPUP_ERROR_15_HEADING', 'Servidor de la Base de Datos');
    define('POPUP_ERROR_15_TEXT', 'Este es el nombre del servidor donde está el programa de la base de datos.  En la mayoría de los casos se puede dejar como  \'localhost\'. En algunos casos excepcionales deberá pedirle a su servicio de hospedaje que le dé el nombre del servidor de la base de datos.');
 
    define('POPUP_ERROR_16_HEADING', 'Usuario de la Base de Datos');
    define('POPUP_ERROR_16_TEXT', 'Todas las bases de datos requiren un nombre de usuario y una contaseña para accesarlos.  El nombre del usuario de su base de datos puede haber sido asignado por su servicio de hospedaje y deberá obtener de ellos los detalles.');

    define('POPUP_ERROR_17_HEADING', 'Contraseña para la Base de Datos');
    define('POPUP_ERROR_17_TEXT', 'Todas las bases de datos requiren una contraseña para accesarlos.  La contraseña de su base de datos puede haber sido asignado por su servicio de hospedaje y deberá obtener de ellos los detalles.');

    define('POPUP_ERROR_18_HEADING', 'Nombre de la Base de Datos');
    define('POPUP_ERROR_18_TEXT', 'Este es el nombre de la base de datos que usará para PhreeBooks.  Si no está seguro cual debe ser, debe contactar su servicio de hospedaje para que le den mas información.');

    define('POPUP_ERROR_19_HEADING', 'Prefijo de Tablas para la Base de Datos');
    define('POPUP_ERROR_19_TEXT', 'PhreeBooks le permite agregar un prefijo a los nombres de las tablas que usa para almacenar la información.  Esto es útil especialmente si su servicio de hospedaje solo le permite una base de datos, y quiere instalar otros procedimientos en su sistema que usan la misma base de datos.  Normalmente debe dejar el valor predeterminado como está.');

    define('POPUP_ERROR_20_HEADING', 'Crear Base de Datos');
    define('POPUP_ERROR_20_TEXT', 'Esta opción determina si el instalador debe intentar crear la base de datos principal de Phreebooks. Nota \'crear\' en este contexto no tiene nada que ver con agregar las tablas que Phreebooks necesita, que se haría automáticamente de todas maneras.  Muchos servicios de hospedaje no le dan a sus usuarios permiso para  \'crear\', pero proveen otro método para crear bases de datos en blanco, e.i. cPanel o phpMyAdmin.');

    define('POPUP_ERROR_21_HEADING', 'Conexión a la base de datos');
    define('POPUP_ERROR_21_TEXT', 'Conexiones persistentes es un método para reducir la carga sobre la base de datos.  Debe consultar su servicio de hospedaje antes de seleccionar esta opción.  El habilitar "conexiones persistentes" podría causar que su servidor experimente problemas con la base de datos si no ha sido configurado para ello.<br /><br />De nuevo, asegúrese consultar con su servicio de hospedaje antes de seleccionar esta opción.');

    define('POPUP_ERROR_22_HEADING', 'Sesiones en la Base de Datos');
    define('POPUP_ERROR_22_TEXT', 'Esto determina si la información de la sesión se almacena en un archivo o en la base de datos.  A pesar de que sesiones basadas en archivos son mas rápidos, se recomiendan las sesiones almacenadas en la base de datos para todas las tiendas que usan conexiones SSL, por razones de seguridad.');

    define('POPUP_ERROR_23_HEADING', 'Habilite SSL');
    define('POPUP_ERROR_23_TEXT', '');

    define('POPUP_ERROR_24_HEADING', 'Servidor de la Base de Datos está vacío');
    define('POPUP_ERROR_24_TEXT', 'La digitación del servidor de la base de datos está vacío.  Digite un valor válido para el nombre del servidor de la base de datos. <br />Este es el nombre del servidor de páginas en el cuál corre el programa de la base de datos.  La mayoría de las veces esto se puede dejar como \'localhost\'. En algunos casos excepcionales deberá preguntarle a su servicio de hospedaje por el nombre del servidor de la base de datos.');

    define('POPUP_ERROR_25_HEADING', 'Nombre de la Base de Datos está Vacío');
    define('POPUP_ERROR_25_TEXT', 'La digitación del nombre de la base de datos está vacío.  Digite el nombre de la base de datos que desea usar para PhreeBooks.<br />Este es el nombre de la base de datos que va a usar para PhreeBooks.  Si no está seguro cuál debe ser, entonces debe consultar con su servicio de hospedaje para mayor información.');
 
    define('POPUP_ERROR_26_HEADING', 'El archivo de instalación SQL no existe');
    define('POPUP_ERROR_26_TEXT', 'El instalador no pudo encontrar el archivo de instalación SQL.  Este debe existir en el directorio \'modules/install/sql/current\' y llamarse algo como \'tables.sql\'.');

    define('POPUP_ERROR_27_HEADING', 'Base de Datos no soportada');
    define('POPUP_ERROR_27_TEXT', 'El tipo de base de datos que ha seleccionado no parece ser soportado por la versión de PHP que tiene instalado.  A lo mejor necesita consultar con su servicio de hospedaje para confirmar que el tipo de base de datos que ha seleccionado es soportado.  Si este es su propio servidor, entonces asegúrese que el soporte para este tipo de base de datos haya sido compilado en la versión de PHP, y que los archivos de extensiones/módulos/dll necesarios se están cargando (especialmente revise php.ini para extension=mysql.so, etc).');

    define('POPUP_ERROR_28_HEADING', 'Falló la Conexión a la Base de Datos');
    define('POPUP_ERROR_28_TEXT', 'No se pudo establecer una conexión a la base de datos.  Esto puede pasar por varias razones. <br /><br />
Le han dado el nombre equivocado del servidor de la base de datos, o el nombre del usuario o la <em>contraseña </em>pueda que esté incorrecta. <br /><br />
También pueda ser que le han dado el nombre de la base de datos equivocado (<strong>¿Existe?</strong> <strong>¿Fue creado?</strong> -- NOTA: PhreeBooks&trade; no crea una base de datos para usted.).<br /><br />
Revise toda la digitación y asegúrese que todas estén correctas.');

    define('POPUP_ERROR_29_HEADING', 'No se Pudo Crear la Base de Datos');
    define('POPUP_ERROR_29_TEXT', 'Parece que no tiene permiso para crear una base de datos en blanco.  Pueda que necesite contactar a su servicio de hospedaje para que ellos se lo hagan.  Alternativamente pueda que necesite usar cpanel o phpMyAdmin para crear la base de datos en blanco.  Una vez que haya creaado la base de datos manualmente, DESELECCIONE la opción \'Crear Base de Datos\' en el instalador de PhreeBooks para continuar.');

    define('POPUP_ERROR_30_HEADING', 'La Base de Datos no Existe');
    define('POPUP_ERROR_30_TEXT', 'El nombre de la base de datos que ha especificado no parece existir.<br />(<strong>¿Lo creó?</strong> -- NOTA: PhreeBooks&trade; no crea una base de datos para usted.).<br /><br />Revise los detalles de su base de datos, luego verifique esta digitación y haga las correcciones necesarias.');

    define('POPUP_ERROR_31_HEADING', 'El Nombre de la Tienda Está Vacío');
    define('POPUP_ERROR_31_TEXT', 'Especifique el nombre por el cual se va a referir a su compañía.');

    define('POPUP_ERROR_32_HEADING', 'El Dueño de la Tienda Está Vacío');
    define('POPUP_ERROR_32_TEXT', 'Digite el nombre del dueño de la compañía.  Esta información aparecerá en la página \'Contáctenos\', el mensaje de correo electrónico \'Bienvenido\', y en otros lugares a través de la compañía.');

    define('POPUP_ERROR_33_HEADING', 'El Correo Electrónico de la Tienda Está Vacío');
    define('POPUP_ERROR_33_TEXT', 'Digite el correo electrónico principal de la compañía.  Este es el correo que será usado como información de contacto en los correos electrónicos que salen de la compañía.');

    define('POPUP_ERROR_34_HEADING', 'El Correo Electrónico de la Tienda es inválido');

    define('POPUP_ERROR_35_HEADING', 'La Dirección de la Tienda Está Vacío');
    define('POPUP_ERROR_35_TEXT', 'Digite la dirección de su compañía.  Esta será usado en la página Contáctenos (esto puede ser desabilitado mas adelante si se quiere), y en las facturas y listas de empaque.  También será mostrado en la pantalla de Recibo de Dinero si el cliente elije pagar con cheque/órden de pago, a la hora de cancelar.');

    define('POPUP_ERROR_36_HEADING', 'El Archivo SQL de Demostración de Producto No Existe');
    define('POPUP_ERROR_36_TEXT', 'No se pudo localizar el archivo SQL conteniendo los productos de demostración de PhreeBooks para cargarlos en el archivo de la compañía.  Revise que exista el archivo /zc_install/demo/xxxxxxx_demo.sql. (xxxxxxx = su tipo de base de datos).');

    define('POPUP_ERROR_37_HEADING', 'Nombre de la Compañía');
    define('POPUP_ERROR_37_TEXT', 'El nombre de su compañía.  Este será usado en correos electrónicos enviados por el sistema y en algunos casos como el título del navegador.');

    define('POPUP_ERROR_38_HEADING', 'Ciudad de la Compañía');
    define('POPUP_ERROR_38_TEXT', 'La ciudad donde está ubicada la compañía será usado en los correos electrónicos enviados por el sistema.  También aparecerá en las facturas, órdenes, etc.');

    define('POPUP_ERROR_39_HEADING', 'Correo Electrónico del Dueño de la Tienda');
    define('POPUP_ERROR_39_TEXT', 'El correo electrónico principal por el cual se puede contactar su compañía. La mayoría de los correos enviados por el sistema usan este,//// así como las páginas contáctenos.');

    define('POPUP_ERROR_40_HEADING', 'País de la Compañía');
    define('POPUP_ERROR_40_TEXT', 'El país donde está basado su compañía.  Es importante que lo defina correctamente para asegurarse que las opciones de envíos e impuestos funcionen correctamente.  También aparecerá en las facturas, órdenes,etc.');

    define('POPUP_ERROR_41_HEADING', 'Provincia/Estado de la Compañía');
    define('POPUP_ERROR_41_TEXT', 'La provincia/estado donde se ubica su compañía.  Este aparecerá en las facturas, órdens, etc.');

    define('POPUP_ERROR_42_HEADING', 'Dirección de la Compañía');
    define('POPUP_ERROR_42_TEXT', 'La dirección de su compañía para ser usado en facturas y en órdenes.  Se permiten dos líneas, siendo la primera línea requerida.');

    define('POPUP_ERROR_43_HEADING', 'Almacene Idioma Predeterminado');
    define('POPUP_ERROR_43_TEXT', 'El idioma predeterminado que su compañía usa.  PhreeBooks soporta múltiples idiomas, con tal de que se carguen los archivos del idioma correspondiente.');

    define('POPUP_ERROR_44_HEADING', 'Almacene Moneda Predeterminada');
    define('POPUP_ERROR_44_TEXT', 'Seleccione la moneda predeterminada con la que su compañía va a operar.  Si la moneda que desea no está en esta lista, puede ser cambiada en el área de Admin después de que haya terminado la instalación.<br /><br />NOTA: ¡Una vez que se haya registrado la primera transacción, no se puede cambiar la moneda predeterminada!');

    define('POPUP_ERROR_45_HEADING', 'Instale Productos de Demostración');
    define('POPUP_ERROR_45_TEXT', 'Seleccione si desea instalar los productos de demostración en la base de datos para ver como funciona el programa.');

    define('POPUP_ERROR_46_HEADING', 'El Nombre del Usuario Admin Está Vacío');
    define('POPUP_ERROR_46_TEXT', 'Para hacer login en el área de Admin después de que haya terminado la instalación, necesita digitar un nombre para el usuario Admin aquí.');

    define('POPUP_ERROR_47_HEADING', 'El Correo Electrónico de Admin Está Vacío');
    define('POPUP_ERROR_47_TEXT', 'El correo electrónico para Admin se necesita para mandar la constraseña nueva en caso de que olvide la contraseña original.');

    define('POPUP_ERROR_48_HEADING', 'El Correo Electrónico de Admin es inválido');
    define('POPUP_ERROR_48_TEXT', 'Digite un correo electrónico válido.');

    define('POPUP_ERROR_49_HEADING', 'La Contraseña de Admin Está Vacío');
    define('POPUP_ERROR_49_TEXT', 'Por seguridad, el Administrador debe tener una contraseña que no sea nulo.');

    define('POPUP_ERROR_50_HEADING', 'Las Contraseñas no Concuerdan');
    define('POPUP_ERROR_50_TEXT', 'Digite de nuevo la contraseña del Administrador y la confirmación.');

    define('POPUP_ERROR_51_HEADING', 'Nombre del Usuario Admin');
    define('POPUP_ERROR_51_TEXT', 'Para hacer login al área de Admin después de que haya terminado la instalación, necesita digitar el nombre del usuario de Admin aquí.');

    define('POPUP_ERROR_52_HEADING', 'Correo Electrónico de Admin');
    define('POPUP_ERROR_52_TEXT', 'El correo electrónico para Admin se necesita para mandar la constraseña nueva en caso de que olvide la contraseña original.');

    define('POPUP_ERROR_53_HEADING', 'Contraseña de Admin');
    define('POPUP_ERROR_53_TEXT', 'La contraseña del administrador permite el acceso al área de administración.');

    define('POPUP_ERROR_54_HEADING', 'Confirmación de la Contraseña de Admin');
    define('POPUP_ERROR_54_TEXT', 'Naturalmente, necesita digitar correctamente la confirmación de la contraseña antes que pueda ser salvada para uso futuro.');

    define('POPUP_ERROR_55_HEADING', 'Versión de PHP no soportada');
    define('POPUP_ERROR_55_TEXT', 'La versión de PHP que corre en su servidor no está soportada por PhreeBooks.  Además, algunas versiones de PHP 4.1.2 tienen una pulga que afecta  "super global arrays".  Esto puede resultar en que la sección de admin de PhreeBooks no sea accesible.  Se le sugiere que actualice su versión de PHP si es posible.');
 
    define('POPUP_ERROR_57_HEADING', 'El Archivo configure.php no Tiene Permisos de Escritura');
    define('POPUP_ERROR_57_TEXT', 'El archivo includes/configure.php no tiene permisos de escritura.  Si usa Unix or Linux use el comando chmod para fijar los permisos del archivo en 777 ó 666 hasta que haya finalizado al instalación de PhreeBooks.  En un sistema Windows el archivo siempre tiene permisos de lectura/escritura.');

    define('POPUP_ERROR_58_HEADING', 'Prefijo de las Tablas de la Base de Datos');
    define('POPUP_ERROR_58_TEXT', 'PhreeBooks permite agregar un prefijo al nombre de las tablas que usa para almacenar información.  Esto es útil especialmente si su servicio de hospedaje solo permite una sola base de datos y quiere instalar otros procedimientos en sus sistema que usen esa base de datos.  Normalmente debe dejar el valor predeterminado tal como está.');
    define('POPUP_ERROR_59_HEADING', 'Directorio de Cache SQL ');
    define('POPUP_ERROR_59_TEXT', 'Una consulta SQL pueden hacerse con cache basado en base de datos en en un archivo del disco duro de su servidor, o no usarse del todo. Si escoje usar cache en las consultas SQL  a un archivo del disco duro de su servidor, entonces deberá dar el definir el directorio donde esta información será salvada. <br /><br />La instalación estandar de PhreeBooks incluye una carpeta del \'cache\'.  Necesita fijar los permisos de este subdirectorio para lectura/escritura para que su servidor (ie: apache) pueda accesarlo.<br /><br />Asegúrese que el directorio que selecciona existe y que tiene permisos de escritura pra el servidor de páginas (se recomienda chmod 777 ó al menos 666).');
    define('POPUP_ERROR_60_HEADING', 'Método de Cache SQL');
    define('POPUP_ERROR_60_TEXT', 'Algunas consultas SQL están marcadas como que puede usar un cache.  Esto quiere decir que si se usa un cache correrá mas rápido.  Puede decidir qué metodo a usar para el cache de la consulta SQL.<br /><br /><strong>Ningún</strong>. Consultas SQL sin el uso de cache. Si tiene muy pocos productos/categorías podría ser que esto le dé la mejor velocidad a su sitio.<br /><br /><strong>Base de Datos</strong>.  Consultas SQL con cache a una tabla en la base de datos.  Suena raro pero esto quizás pueda aumentar la velocidad de los sitios con un número razonable de productos/categorías.<br /><br /><strong>Archivo</strong>. Consultas SQL con cache a un archivo del disco duro del servidor.  Para que esto funcione debe asegurarse que el directorio en donde se va a manejar el cache tenga permisos de escritura por el servidor de páginas.  Este es el mejor método para sitios con un gran número de productos/categorias.');

    define('POPUP_ERROR_61_HEADING', 'El Directorio del Cache de Session/SQL Está Vacío');
    define('POPUP_ERROR_61_TEXT', 'Si desea usar cache basado en un archivo para consulta Session/SQL, debe digitar un directorio válido en su servidor y asegurarse que el servidor tiene permiso para escribir al directorio.');

    define('POPUP_ERROR_62_HEADING', 'El directorio del Cache de Session/SQL No Existe');
    define('POPUP_ERROR_62_TEXT', 'Si desea usar un archivo para del cache de la consulta Session/SQL, debe digitar un directorio válido en su servidor, y asegurarse que el servidor de páginas tiene permisos de escritura al directorio.');

    define('POPUP_ERROR_63HEADING', 'El directorio del cache de la Session/SQL no tiene permisos de escritura');
    define('POPUP_ERROR_63TEXT', 'Si desea usar cache basado en archivo para consultas de Session/SQL queries, debe proveer un directorio válido en su servidor y asegurarse que el servidor de páginas tiene permisos de escritura para el directorio.  Se recomienda chmod 666 ó 777 para Linux/Unix.  Leer/Escribir es suficiente para servidores Windows.');

    define('POPUP_ERROR_65_HEADING', 'Prefijo de Tabla phpBB de la Base de Datos');
    define('POPUP_ERROR_65_TEXT', 'Digite el prefijo para las tablas de phpBB en la base de datos donde están ubicadas.  Usualmente eso es \'phpBB_\'');

    define('POPUP_ERROR_66_HEADING', 'Nombre de la Base de Datos phpBB');
    define('POPUP_ERROR_66_TEXT', 'Digite el nombre de la base de datos donde están ubicadas las tablas de su phppBB.');
    define('POPUP_ERROR_69_HEADING', 'Register Globals');
    define('POPUP_ERROR_69_TEXT', 'PhreeBooks solo puede funcionar con la opción "Register Globals" off.');
    define('POPUP_ERROR_70_HEADING', 'Mode Seguro está On');
    define('POPUP_ERROR_70_TEXT', 'PhreeBooks no puede funcionar bien con servidores que corran en modo Safe Mode.<br /><br />Un sistema ERP requiere muchos servicios avanzados que frecuentemente están restringidos en servicios de hospedaje de bajo costo del tipo compartido.  Para que PhreeBooks corra óptimamente require un servidor que lo ponga en un espacio de red en "Safe Mode".  Necesita que su compañía de hospedaje configure el archivo php.ini con la opción "SAFE_MODE=OFF".');

    define('POPUP_ERROR_71_HEADING', 'Se requiere un directorio para cache para usar esta opción');
    define('POPUP_ERROR_71_TEXT', 'Si desea usar el sistema de consulta SQL cache basado en un archivo en Phreebooks, deberá fijar los permisos del directorior del cache en su servidor.<br /><br />Opcionalmente, puede seleccionar Cache basado en Base de Datos o No use Cache si prefiere no usar el cache basado en archivo.  En este caso, QUIZÁS necesite desabilitar también "store sessions", ya que el seguidor de sesión usa el cache de archivo también.<br /><br />Para montar adecuadamente el directorio del cache, use su porgrama de acceso FTP o el acceso a la terminal en el servidor para modificar los permisos de la carpeta y use el comando chmod 666 ó 777 para fijar los permisos a lectura/escritura.<br /><br />Específicamente el usuario de su servidor de páginas (ie: \'apache\' o \'www-user\' o quizás \'IUSR_algo\' bajo Windows) deberá tener todos los permisos de  \'lectura/escritura/borrar\' etc para el carpeta del cache.');

    define('POPUP_ERROR_72_HEADING', 'ERROR: No se pudieron actualizar todos los archivos configure.php con el nuevo prefijo');
    define('POPUP_ERROR_72_TEXT', 'Hubo un error intentando actualizar el archivo configure.php después de renombrar las tablas.  Necesitará editar manualmente su archivo /includes/configure.php files y asegurarse que la directriz "define" para "DB_PREFIX" esté fijado apropiadamente para las tablas de su base de datos de PhreeBooks.');

    define('POPUP_ERROR_73_HEADING', 'ERROR: No se pudo aplicar el nuevo prefijo de tablas a todas las tablas');
    define('POPUP_ERROR_73_TEXT', 'Hubo un error intentando renombrar las tablas de la base de datos con el nuevo prefijo de tablas.  Necesitará revisar manualmente los nombres de las tablas de su base de datos a ver si está correcto. En el peor de los casos necesitará recobrar su base de datos de su archivo de respaldo.');

    define('POPUP_ERROR_74_HEADING', 'NOTA: PHP "session.save_path" no tiene permisos de escritura');
    define('POPUP_ERROR_74_TEXT', '<strong>Esto es SOLO una nota</strong>para informarle que no tiene permisos de escritura a la ruta especificada en la opción PHP session.save_path.<br /><br />Esto quiere decir que no puede usar esta ruta para almacenamiento temporal de archivos.  En su lugar, use la "ruta de cache sugerida" mostrada debajo de ella.');

    define('POPUP_ERROR_75_HEADING', 'NOTA: PHP "magic_quotes_runtime" está activo');
    define('POPUP_ERROR_75_TEXT', 'Es mejor tener desabilitado "magic_quotes_runtime". Cuando está habilitado, puede causar errores 1064 SQL inesperados, y otros problemas de ejecución del código.<br /><br />Si no puede desabilitarlo para el servidor completo, quizás sea posible desabilitarlo vía .htaccess en su propio archivo php.ini file en su espacio privado en el servidor.  Comuníquese con el personal de su servicio de hospedaje para que lo asistan.');

    define('POPUP_ERROR_76_HEADING', 'No se pudo determinar la versión del motor de la Base de Datos');
    define('POPUP_ERROR_76_TEXT', 'No se pudo determinar el número de versión del motor de la base de datos.<br /><br />Esto NO NECESARIAMENTE es un problema serio.  
De hecho, puede ser bien común en un servidor de producción, ya que en el momento de esta inspección, puede que aún no se conozcan las credenciales de seguridad necesarios para hace login a su servidor, ya que esos se obtienen mas adelante en el proceso de instalación.<br /><br />Generalmente es seguro continuar aún si esta información se reporta como desconocida.');

    define('POPUP_ERROR_77_HEADING', 'Cargar Archivos está DESABILITADO');
    define('POPUP_ERROR_77_TEXT', 'La opción de cargar archivos esta DESABILITADA. Para habilitarla, asegúrese que <em><strong>file_uploads = on</strong></em> esté en su archivo php.ini del servidor.');

    define('POPUP_ERROR_78_HEADING', 'SE REQUIERE UN CONTRASEÑA PARA ADMIN PARA PODER ACTUALIZAR');
    define('POPUP_ERROR_78_TEXT', 'Se require un nombre de usuario y contraseña para el administrador de la compañía para poder hacer cambios a la base de datos.<br /><br />Digite un nombre de usuario y contraseña válidos para el Admini de su sitio de PhreeBooks.');

    define('POPUP_ERROR_79_TEXT','OpenSSL es "una" manera de configurar el servidor para ofrecer SSL (https://) en su sitio.<br /><br />Si aparece como No Disponible algunas posibles causas son:<br />(a) su servicio de hospedaje no soporta SSL<br />(b) su servidor no tiene instalado OpenSSL, pero QUIZÁS tenga otro servicio SSL disponible<br />(c) su servicio de hospedaje pueda que no está enterado aún de los detalles de su certificado SSL para que puedan habilitar el soporte de SSL en su dominio<br />(d) Pueda que PHP no esté configurado aún para trabajar con OpenSSL.<br /><br />En todo caso, si NO requiere encriptar sus páginas de red (SSL), debe contactar a su servicio de hospedaje para que lo ayuden.');
    define('POPUP_ERROR_79_HEADING','Información OpenSSL');

    define('POPUP_ERROR_80_HEADING', 'Se Requiere Soporte para PHP Session Support');
    define('POPUP_ERROR_80_TEXT', 'Necesita habilitar soporte de sesión PHP en su servidor.  Puede intentar instalando el módulo: php4-session ');

    define('POPUP_ERROR_81_HEADING', 'No se recominenda correr PHP con cgi a no ser que sea un servidor Windows');
    define('POPUP_ERROR_81_TEXT', 'Correr PHP como CGI puede ser problemático en algunos servidores Linux/Unix.<br /><br />Servidores Windows, sin embargo, "siempre" corren  PHP como un módulo cgi, en cuyo caso esta advertencia puede ignorarse.');
 
    define('POPUP_ERROR_82_HEADING', ERROR_TEXT_DISABLE_FUNCTIONS);
    define('POPUP_ERROR_82_TEXT', 'Su configuración PHP tiene una o mas de las siguientes funciones marcadas como "desabilitadas" en el archivo de su servidor PHP.INI :<br /><ul><li>set_time_limit</li><li>exec</li></ul>Su servidor puede sufrir una disminución en el funcionamiento debido al uso de estas medidas de seguridad que se implementan usualmente en servidores públicos de alto volumen... que usualmente no son ideales para correr sistemas de e-Commerce.<br /><br />Se recomienda que consulte con su servicio de hospedaje a ver si no tiene otro servidor donde pueda poner su sitio con estas restricciones eliminadas.');

    define('POPUP_ERROR_83_HEADING','Caracteres Invalidos en el Prefijo de Tablas de la Base de Datos');
    define('POPUP_ERROR_83_TEXT','El prefjo de las tablas de la base de datos no puede contener ninguno de los siguientes caracteres:<br />
&nbsp;&nbsp; / o \\ o . <br /><br />Seleccione un diferente prefijo.  Recomendamos algo simple como "pb_" .');

    define('POPUP_ERROR_84_HEADING','Debe desabilitarse PHP Session.autostart.');
    define('POPUP_ERROR_84_TEXT','La opción session.auto_start en el archivo PHP.INI de su servidor está como "ON". <br /><br />Potencialmente esto puede causar problemas de manejo de la sesión, ya que PhreeBooks está diseñado para empezar sesiones cuando está listo para activar opciones de una sesión.  Hacer que las sesiones comiencen automáticamente puede ser un problema en algunas configuraciones de servidor.<br /><br />Si desea desabilitarlo, podría probar poniento lo siguiente en su archivo .htaccess que está ubicado en la raiz de su compañía (el mismo directorio que index.php):<br /><br /><código>php_value session.auto_start 0</código>');

    define('POPUP_ERROR_85_HEADING','No se instalaron unas directivas SQL de actualización de la base de datos.');
    define('POPUP_ERROR_85_TEXT','Durante el proceso de acturalización de la base de datos, algunas instrucciones SQL no se pudieron ejecutar porque hubieran creado registros duplicados en la base de datos, o los prerequisitos (tales como columna deben existir para "change" o "drop") no se cumplieron.<br /><br />LA CAUSA MAS COMÚN de estas fallas es que usted ha instalado una contribución o una extra que ha alterado el núcleo de la estructura de la base de datos.  El programa de actualización está siendo amistoso para no crearle problemas. <br /><br />SU TIENDA PUEDE QUE TRABAJE BIEN sin resolver estos errores, sin embargo, recomendamos que los investigue adecuadamente. <br /><br />Si desea investigarlos, puede revisar la tabla "upgrade_exceptions" en la base de datos para detalles de cuales instrucciones no se ejecutaron y el porqué.');

    define('POPUP_ERROR_86_HEADING','Debe desabilitarse PHP Session.use_trans_sid.');
    define('POPUP_ERROR_86_TEXT','La opción de sesión .use_trans_sid en el archivo PHP.INI de su servidor esta fijado en "ON". <br /><br />Potencialmente esto puede causar problemas con el manejo de la sesión y quizás aún problemas con la seguridad.<br /><br />Puede solucionar esto mediante un parámetro en el archivo .htaccess tal como esto: <a href="http://www.olate.com/articles/252">http://www.olate.com/articles/252</a>, o puede desabilitarlo en su archivo PHP.INI si es que tiene acceso a él.<br /><br />Para mayor información sobre los riesgos de seguridad que impone, vea: <a href="http://shh.thathost.com/secadv/2003-05-11-php.txt">http://shh.thathost.com/secadv/2003-05-11-php.txt</a>.');

    define('POPUP_ERROR_87_HEADING','Hacen Falta Permisos para el Usuario de la Base de Datos');
    define('POPUP_ERROR_87_TEXT','Las operaciones en PhreeBooks requieren los siguientes privilegios a nivel de base de datos:<ul><li>ALL PRIVILEGES<br /><em>o</em></li><li>SELECT</li><li>INSERT</li><li>UPDATE</li><li>DELETE</li><li>CREATE</li><li>ALTER</li><li>INDEX</li><li>DROP</li></ul>Las actividades diarias normalmente no requieren estos privilegios, pero SI son requeridos para la instalación, actualización y actividades de SQLPatch.');

    define('POPUP_ERROR_88_HEADING','Hubo un error tratando de escribir /includes/configure.php');
    define('POPUP_ERROR_88_TEXT','El instalador no pudo verificar la escritura correcta del archivo configure.php cuando salvaba su configuración para PhreeBooks&trade;.  Revise que tenga permisos completos de escritura en su servidor el archivo configure.php localizado en:<br /><br />- /includes/configure.php<br />También deber revisar que el disco duro tenga suficiente espacio libre (o cuota de disco disponible para usted) para grabar las actualizaciones de estos archivos. <br /><br />Si los archivo tienen un tamaño de 0-bytes cuando aparece este error, entonces es muy probable que la causa sea el espacio en disco duro o espacio "disponible".<br /><br />Los permisos ideales en un sistema Unix/Linux son chmod 777 hasta que la instalación este completa.  Luego, puede fijarse de nuevo en 644 ó 444 por razones de seguridad después de que finalice la instalación.<br /><br />Si tiene un servidor Windows, quizás encuentre que sea necesario apretar el botón derecho de su ratón de PC para cada uno de estos archivos, seleccionar "Propiedades" y luego la pestaña "Seguridad".  Entonces seleccionar "Agregar" y luego "Todos" para permitirle a "Todos" permisos completos de lectura/escritura hasta que haya finalizado la instalación.  Luego modificar los permisos a solo lectura despues de la instalación.');

    define('POPUP_ERROR_89_HEADING','Permiso Para Actualizar');
    define('POPUP_ERROR_89_TEXT','Phreebooks ha detectado una instalación previa y su configuración de seguridad no le permite hacer una actualización.  Esto no es un problema en este momento a no ser que esté intentando hacer la actualización.');

    define('POPUP_ERROR_90_HEADING','Identificación de la Compañía');
    define('POPUP_ERROR_90_TEXT','La identificación de la compañía se usa en las transacciones como un identificador de los menúes plegables para ayudar a identificar la tienda que está solicitando la acción. Con la opción de multi-tienda este valor se combina con la identificación de las otras tiendas para diferenciar las transacciones.');

    define('POPUP_ERROR_91_HEADING','Código Postal de la Compañía');
    define('POPUP_ERROR_91_TEXT','El código postal es usado en facturas, órdenes, etc.  También se necesita para el módulo de envíos para calcular las tarifas de flete.');

    define('POPUP_ERROR_92_HEADING','Teléfono y Fax de la Compañía');
    define('POPUP_ERROR_92_TEXT','Se permiten dos números de teléfono y un número de fax.');

    define('POPUP_ERROR_93_HEADING','Sitio Internet de la Compañía');
    define('POPUP_ERROR_93_TEXT','Página de inicio de la compañía.  Puede ser usado para facturación, órdenes de compra, etc.');

    define('POPUP_ERROR_94_HEADING','Machote para Cuadro de Cuentas');
    define('POPUP_ERROR_94_TEXT','Se require un machote para el cuadro de cuentas.  Si ya está cargado en el sistema un cuadro de cuentas, seleccione ' . TEXT_CURRENT_SETTINGS . ' y continue o sino seleccione un machote de la lista.  Para ver el cuadro, seleccione un machote y presione \'ver detalles del cuadro\'.');

    define('POPUP_ERROR_95_HEADING','Años Fiscales/Períodos Contables');
    define('POPUP_ERROR_95_TEXT','En contabilidad se usan años fiscales y períodos contables para darle seguimiento a las finanzas de una compañía.  El año fiscal se divide en 12 períodos contables por año fiscal.  Generalmente, los períodos contables empatan con los meses calendario y los años fiscales empatan con los años calendario.  Phreebooks permite fechas de inicio no-estandares para el período fiscal y para el año fiscal para permite fechas de comienzo por ejemplo a la mitad del mes/a medio año.  Por ahora, seleccione el mes y año de inicio para fijar como su primer período contable.  PhreeBooks inicialmente fija el primer día del mes seleccionado como la fecha de inicio del período 1. <br /><br />Cuando termina la instalación, se pueden modificar las fechas de inicio de todos los períodos contables para concordar con las fechas del calendario contable de su compañía. NOTA: Este cambio deberá hacerce antes de registrar la primera transacción en Phreebooks.');

    define('POPUP_ERROR_96_HEADING','Cuenta Predeterminada Para Compra de Ítems de Inventario');
    define('POPUP_ERROR_96_TEXT','Esta es la cuenta donde se contabilizan los ítems recibidos de los proveedores.  Note que cada código tiene su propia cuenta de inventario así que esta cuenta se usa inicialmente en los formularios de órdenes para ítems que aún no tienen un código.');

    define('POPUP_ERROR_97_HEADING','Cuenta Predeterminada Para Compras');
    define('POPUP_ERROR_97_TEXT','Esta es la cuenta donde se contabilizan las compras.  La cuenta de compras predeterminada se puede modificar para una transacción en el momento de digitar la órden para mayor flexiblidad.');

    define('POPUP_ERROR_98_HEADING','Cuenta Predeterminada Para Descuentos por Compras');
    define('POPUP_ERROR_98_TEXT','Esta es la cuenta donde se contabilizan los descuentos sobre compras que dan los proveedores.  Se usa para los descuentos por prepago de compras, cupones de descuento, promociones especiales, etc.');

    define('POPUP_ERROR_99_HEADING','Cuenta Predeterminada Para Fletes de Mercadería Comprada');
    define('POPUP_ERROR_99_TEXT','Esta es la cuenta donde se contabilizan los fletes por mercadería comprada a proveedores.  Es comúm contabilizar los gastos de flete en una cuenta separada para no afectar negativamente el costo de la mercadería comprada.');

    define('POPUP_ERROR_100_HEADING','Cuenta Predeterminada Para Pagos a Proveedor');
    define('POPUP_ERROR_100_TEXT','Esta es la cuenta de donde salen los pagos que se hacen a los proveedores.  Típicamente es una cuenta de efectivo como una cuenta de banco o una cuenta de caja.');

    define('POPUP_ERROR_101_HEADING','Cuenta Predeterminada Para Ventas');
    define('POPUP_ERROR_101_TEXT','Esta es la cuenta donde se contabilizan las ventas.  La cuenta de ventas predeterminada se puede modificar para una transacción en el momento de digitar la órden para mayor flexiblidad.');

    define('POPUP_ERROR_102_HEADING','Cuenta Predeterminada Para Cuentas por Cobrar');
    define('POPUP_ERROR_102_TEXT','Esta es la cuenta donde se contabiliza lo que los clientes deben por ventas a términos, i.e. ventas cuyo pago se espera que hagan en una fecha futura.');

    define('POPUP_ERROR_103_HEADING','Cuenta Predeterminada Para Descuentos Sobre Ventas');
    define('POPUP_ERROR_103_TEXT','Esta es la cuenta donde se contabilizan los descuentos sobre ventas a los clientes.  Se usa para los descuentos por promociones, descuentos por prepago de facturas, etc.');

    define('POPUP_ERROR_104_HEADING','Cuenta Predeterminada Para Fletes de Envíos a Clientes');
    define('POPUP_ERROR_104_TEXT','Esta es la cuenta donde se contabilizan los cargos por fletes de envíos a clientes.  Es común usar cuentas separadas para los cargos por fletes y para los ingresos por ventas.');

    define('POPUP_ERROR_105_HEADING','Cuenta Predeterminada Para Recibo de Pago de Clientes');
    define('POPUP_ERROR_105_TEXT','Esta cuenta es de donde se contabilizan los recibos de dinero de los clientes.  Es típicamente una cuenta de efectivo, una cuenta de banco o una cuenta de caja.');

    define('POPUP_ERROR_106_HEADING','directorio /includes');
    define('POPUP_ERROR_106_TEXT','No tiene permiso de escritura el archivo configure.php en el directorio /includes.  Revise los permisos del directorio /includes y cambie a 777.');

    define('POPUP_ERROR_107_HEADING','directorio /my_files');
    define('POPUP_ERROR_107_TEXT','No se puede crear el directorio /my_files.  Revise los permisos del directorio y cambie a 777.');
    define('POPUP_ERROR_108_HEADING','Base de Datos Ya Existe');
    define('POPUP_ERROR_108_TEXT','¡No se pueden cargar las tablas de la base de datos pues ya existen!  PhreeBooks está tratando de hacer una instalación completa y no puede porque ha detectado una instalación previa. <br /><br />La instalación no puede continuar hasta que las tablas sean borradas.');

    define('POPUP_ERROR_109_HEADING', 'La identificación de la tienda está en blanco');
    define('POPUP_ERROR_109_TEXT', 'Especifique la identificación que se usará para identificar a su compañía. 15 caracteres o menos y sin espacios, i.e. HQ, Sucursal3, etc.');
 

?>
