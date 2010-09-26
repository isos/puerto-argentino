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
//  Path: /includes/configure.php
//

// Define the webserver and path parameters
// Main webserver: eg, http://localhost - should not be empty for productive servers
 define('HTTP_SERVER', 'http://'.$_SERVER["HTTP_HOST"]);
// Secure webserver: eg, https://localhost - should not be empty for productive servers
 define('HTTPS_SERVER', 'https://'.$_SERVER["HTTP_HOST"]); // eg, https://localhost 
// secure webserver for admin areas?
 define('ENABLE_SSL_ADMIN', 'false')

// NOTE: be sure to leave the trailing '/' at the end of these lines if you make changes!
// * DIR_WS_* = Webserver directories (virtual/URL)
// these paths are relative to top of your webspace ... (ie: under the public_html or httpdocs folder)
  define('DIR_WS_ADMIN', '/phreebooks2/');

// * DIR_FS_* = Filesystem directories (local/physical)
//the following path is a COMPLETE path to your PhreeBooks files. eg: /var/www/vhost/accountname/public_html/app_dir/
  define('DIR_FS_ADMIN', '/datos/workspaces/phpworkspace/KioscoHugo/');

// define the default language
  define('DEFAULT_LANGUAGE','es_cr');

// define our database connection
  define('DB_TYPE', 'mysql');
  define('DB_PREFIX', '');
  
  /***
   * INICIO ZONA DE CONFIGURACION ESPECIFICA PARA PUERTO-ARGENTINO 
   */
  
// definiciones especificas para el Kiosco de Hugo

  define('DEFAULT_FINAL_CONSUMER_ID',2);
  define('DEFAULT_JOURNAL_ID',18);
  define('DEFAULT_THEME','cheetah');
  
//longitud minima de un sku para que sea considerado como valido
  define('MIN_SKU_LENGTH',11);
  
  define('COMPANY_NAME','phreebooks2');

  //COMBINACIONES DE TECLAS 
  
  //Ir al index del usuario
  define('GO_HOME_SHORTCUT','Alt+q');
  
  //Pagina Inicial: Crear compra
  define('NEW_PURCHASE_SHORTCUT','Alt+c');

  //Pagina Inicial: Nueva venta
  define('NEW_SELL_SHORTCUT','Alt+v');
  
  //Pagina Inicial: Ir al inventario
  define('GOTO_INVENTORY_SHORTCUT','Alt+i');

  //Formulario de ordenes: guardar orden
  define('SAVE_ORDER_SHORTCUT','Alt+G'); 
  
   //Formulario de ordenes: abrir la ventana de busqueda
  define('SEARCH_ITEM_SHORTCUT','Alt+B');
   
?>
