<?php
// +--------------------------------------------------------+
// |               PhreeBooks Open Source ERP               |
// +--------------------------------------------------------+
// | Copyright (c) 2009 PhreeSoft, LLC                      |
// | http://www.phreesoft.com                               |
// | Portions Copyright (c) 2003 osCommerce, 2005 ZenCart   |
// +--------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL  |
// | license that is bundled with this package in the file: |
// | /doc/manual/ch01-Introduction/license.html             |
// +--------------------------------------------------------+
//  Path: /my_files/custom/extra_menus/rma.php
//

// Menu Titles
  define('MENU_HEADING_RMA',   'RMA - Control de Garantías de Clientes'); // New Title Menu
  define('BOX_RMA_MODULE',     'RMA - Garantías');
  define('BOX_RMA_MODULE_ADM', 'Administrador de Módulo RMA');

// Menu Sort Positions
  define('MENU_HEADING_RMA_ORDER',  77);
  define('BOX_RMA_MODULE_ORDER',    70);
  define('BOX_RMA_MODULE_ADM_ORDER',71);

// Menu Security id's
  define('SECURITY_RMA_MGT',        180);
  define('SECURITY_RMA_MGT_ADMIN',  181);

// Set the title menu
//  $pb_headings[MENU_HEADING_RMA_ORDER] = array(
//		'text' => MENU_HEADING_RMA, 
//		'link' => html_href_link(FILENAME_DEFAULT, 'cat=rma&module=cat_rma', 'SSL'),
//  );
// Set the menus
  $menu[] = array('text'      => BOX_RMA_MODULE, 
				'heading'     => MENU_HEADING_CUSTOMERS, 
				'rank'        => BOX_RMA_MODULE_ORDER, 
				'security_id' => SECURITY_RMA_MGT, 
				'link'        => html_href_link(FILENAME_DEFAULT, 'cat=rma&module=main', 'SSL'),
  );
  $menu[] = array('text'      => BOX_RMA_MODULE_ADM, 
				'heading'     => MENU_HEADING_CUSTOMERS, 
				'rank'        => BOX_RMA_MODULE_ADM_ORDER, 
				'security_id' => SECURITY_RMA_MGT_ADMIN, 
				'link'        => html_href_link(FILENAME_DEFAULT, 'cat=rma&module=admin', 'SSL'),
  );

// New Database Tables
  define('TABLE_RMA',      DB_PREFIX . 'rma_module');
  define('TABLE_RMA_ITEM', DB_PREFIX . 'rma_module_item');

// Global Defines
// This define is needed here because setup determines the tabs and will fail if this is not here.
define('RMA_MGR_NOT_INSTALLED','El módulo RMA no está instalado! Ha sido redirigido al Administrador del Módulo RMA para que instale el módulo.');

?>
