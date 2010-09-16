<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2007-2008 PhreeSoft, LLC                          |
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
//  Path: /modules/translator/scripts/install_sql.php
//

$tables[TABLE_TRANSLATOR_FILES] = "
	CREATE TABLE " . TABLE_TRANSLATOR_FILES  . " (
	  `id` smallint(5) unsigned NOT NULL auto_increment,
	  `release_id` smallint(5) unsigned NOT NULL,
	  `module` smallint(5) unsigned NOT NULL,
	  `file` varchar(255) collate utf8_unicode_ci NOT NULL,
	  `path` varchar(255) collate utf8_unicode_ci NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

$tables[TABLE_TRANSLATOR_TRANSLATIONS] = "
	CREATE TABLE " . TABLE_TRANSLATOR_TRANSLATIONS  . " (
	  `id` int(10) unsigned NOT NULL auto_increment,
	  `file` smallint(5) unsigned NOT NULL,
	  `defined_key` varchar(255) collate utf8_unicode_ci NOT NULL,
	  `original` text collate utf8_unicode_ci NOT NULL,
	  `translation` text collate utf8_unicode_ci NOT NULL,
	  `translated` tinyint(3) unsigned NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

$tables[TABLE_TRANSLATOR_RELEASES] = "
	CREATE TABLE " . TABLE_TRANSLATOR_RELEASES  . " (
	  `id` smallint(5) unsigned NOT NULL auto_increment,
	  `title` varchar(100) collate utf8_unicode_ci NOT NULL,
	  `source_lang` varchar(10) collate utf8_unicode_ci NOT NULL,
	  `destination_lang` varchar(10) collate utf8_unicode_ci NOT NULL,
	  `description` varchar(255) collate utf8_unicode_ci NOT NULL,
	  `translated_only` tinyint(1) unsigned NOT NULL,
	  `added` datetime NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

$tables[TABLE_TRANSLATOR_MODULES] = "
	CREATE TABLE " . TABLE_TRANSLATOR_MODULES  . " (
	  `id` smallint(5) unsigned NOT NULL auto_increment,
	  `release_id` smallint(5) unsigned NOT NULL,
	  `title` varchar(100) collate utf8_unicode_ci NOT NULL,
	  `path` varchar(255) collate utf8_unicode_ci NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
?>
