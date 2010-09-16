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
//  Path: /my_files/custom/extra_menus/translator.php
//

// Menu Titles
  define('MENU_HEADING_TRANSLATOR',   'Traductor de Idioma'); // New Title Menu
  define('BOX_TRANSLATOR_MODULE',     'Asistente de Traducción');
  define('BOX_TRANSLATOR_MODULE_ADM', 'Administrador de Módulo de Traducción');

// Menu Sort Positions
  define('MENU_HEADING_TRANSLATOR_ORDER',  677);
  define('BOX_TRANSLATOR_MODULE_ORDER',    670);
  define('BOX_TRANSLATOR_MODULE_ADM_ORDER',671);

// Menu Security id's
  define('SECURITY_TRANSLATOR_MGT',        680);
  define('SECURITY_TRANSLATOR_MGT_ADMIN',  681);

// Set the menus
  $menu[] = array('text'      => BOX_TRANSLATOR_MODULE,
				'heading'     => MENU_HEADING_SETUP,
				'rank'        => BOX_TRANSLATOR_MODULE_ORDER,
				'security_id' => SECURITY_TRANSLATOR_MGT,
				'link'        => html_href_link(FILENAME_DEFAULT, 'cat=translator&module=main', 'SSL'),
  );
  $menu[] = array('text'      => BOX_TRANSLATOR_MODULE_ADM,
				'heading'     => MENU_HEADING_SETUP,
				'rank'        => BOX_TRANSLATOR_MODULE_ADM_ORDER,
				'security_id' => SECURITY_TRANSLATOR_MGT_ADMIN,
				'link'        => html_href_link(FILENAME_DEFAULT, 'cat=translator&module=admin', 'SSL'),
  );

// New Database Tables
  define('TABLE_TRANSLATOR_FILES',       DB_PREFIX . 'translate_files');
  define('TABLE_TRANSLATOR_TRANSLATIONS', DB_PREFIX . 'translate_translations');
  define('TABLE_TRANSLATOR_RELEASES',    DB_PREFIX . 'translate_releases');
  define('TABLE_TRANSLATOR_MODULES',    DB_PREFIX . 'translate_modules');

// Global Defines
// This define is needed here because setup determines the tabs and will fail if this is not here.
define('TRANSLATOR_MGR_NOT_INSTALLED','El Módulo de Traducción no está instalado! Ha sido redirigido al Administrador del Módulo de Traducción para que instale el módulo.');

?>
