<?php
// +--------------------------------------------------------+
// |               PhreeBooks Open Source ERP               |
// +--------------------------------------------------------+
// | Copyright (c) 2008 PhreeSoft, LLC                      |
// | http://www.phreesoft.com                               |
// | Portions Copyright (c) 2003 osCommerce, 2005 ZenCart   |
// +--------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL  |
// | license that is bundled with this package in the file: |
// | /doc/manual/ch01-Introduction/license.html             |
// +--------------------------------------------------------+
//  Path: /my_files/custom/extra_menus/assets.php
//

// Menu Titles
  define('MENU_HEADING_ASSETS','Activos'); // New Title Menu
  define('BOX_ASSET_MODULE', 'Administración de Activos');
  define('BOX_ASSET_MODULE_ADM', 'Administrador del Módulo Administración de Activos');
  define('BOX_ASSET_MODULE_TABS', 'Pestañas Administración de Activos');
  define('BOX_ASSET_MODULE_FIELDS', 'Campos de la Base de Datos de Administración de Activos');

// Menu Sort Positions
  define('MENU_HEADING_ASSETS_ORDER',77);
  define('BOX_ASSET_MODULE_ORDER',90);
  define('BOX_ASSET_MODULE_ADM_ORDER',91);
  define('BOX_ASSET_MODULE_TABS_ORDER',92);
  define('BOX_ASSET_MODULE_FIELDS_ORDER',93);

// Menu Security id's
  define('SECURITY_ASSET_MGT',170);
  define('SECURITY_ASSET_MGT_ADMIN',171);
  define('SECURITY_ASSET_MGT_TABS',172);
  define('SECURITY_ASSET_MGT_FIELDS',173);

// Set the title menu
  $pb_headings[MENU_HEADING_ASSETS_ORDER] = array('text' => MENU_HEADING_ASSETS, 
				'link' => html_href_link(FILENAME_DEFAULT, 'cat=assets&module=cat_assets', 'SSL'));

// Set the menus
  $menu[] = array('text' => BOX_ASSET_MODULE, 
				'heading' => MENU_HEADING_ASSETS, 
				'rank' => BOX_ASSET_MODULE_ORDER, 
				'security_id' => SECURITY_ASSET_MGT, 
				'link' => html_href_link(FILENAME_DEFAULT, 'cat=assets&module=main', 'SSL'));

  $menu[] = array('text' => BOX_ASSET_MODULE_ADM, 
				'heading' => MENU_HEADING_ASSETS, 
				'rank' => BOX_ASSET_MODULE_ADM_ORDER, 
				'security_id' => SECURITY_ASSET_MGT_ADMIN, 
				'link' => html_href_link(FILENAME_DEFAULT, 'cat=assets&module=admin', 'SSL'));

  $menu[] = array('text' => BOX_ASSET_MODULE_TABS, 
				'heading' => MENU_HEADING_ASSETS, 
				'rank' => BOX_ASSET_MODULE_TABS_ORDER, 
				'security_id' => SECURITY_ASSET_MGT_TABS, 
				'link' => html_href_link(FILENAME_DEFAULT, 'cat=setup&module=main&subject=assets_tabs&page=1', 'SSL'));

  $menu[] = array('text' => BOX_ASSET_MODULE_FIELDS, 
				'heading' => MENU_HEADING_ASSETS, 
				'rank' => BOX_ASSET_MODULE_FIELDS_ORDER, 
				'security_id' => SECURITY_ASSET_MGT_FIELDS, 
				'link' => html_href_link(FILENAME_DEFAULT, 'cat=assets&module=assets_fields', 'SSL'));

// New Database Tables
define('TABLE_ASSETS',         DB_PREFIX . 'assets');
define('TABLE_ASSETS_FIELDS',  DB_PREFIX . 'assets_fields');
define('TABLE_ASSETS_HISTORY', DB_PREFIX . 'assets_history');
define('TABLE_ASSETS_TABS',    DB_PREFIX . 'assets_tabs');

// Global Defines
// This define is needed here because setup determines the tabs and will fail if this isnot here.
define('ASSET_MGR_NOT_INSTALLED','El módulo Administración de Activos no está instalado!  Ha sido redirigido al Administrador del Módulo de Administración de Activos para que instale el módulo.');

?>
