<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2010 PhreeSoft, LLC                               |
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
//  Path: /my_files/custom/extra_menus/oscommerce.php
//

// REMEMBER TO CHECK PERMISSIONS AFTER ADDING A NEW MENU ITEM. THEY DEFAULT TO NO ACCESS AND 
// DO NOT SHOW UP ON THE MENU UNITL PERMISSION HAS BEEN GRANTED AND THE USER HAS RE-LOGGED IN

// include the language definition for the menu items
if (file_exists(DIR_FS_MY_FILES . 'custom/oscommerce/language/' . $_SESSION['language'] . '/menu.php')) {
  include_once(DIR_FS_MY_FILES  . 'custom/oscommerce/language/' . $_SESSION['language'] . '/menu.php');
} else {
  include_once(DIR_FS_MY_FILES  . 'custom/oscommerce/language/en_us/menu.php');
}

// Set the menu order, if using osCommerce title menu option (after Customers and before Vendors)
define('MENU_HEADING_OSCOMMERCE_ORDER',    16);

// Security id's
define('SECURITY_ID_OSCOMMERCE_ADMIN',     208);
define('SECURITY_ID_OSCOMMERCE_INTERFACE', 209);

// Uncomment below to set the title menu for the osCommerce interface, otherwsie it will be parts of the Tools mennu
/*
$pb_headings[MENU_HEADING_OSCOMMERCE_ORDER] = array(
  'text' => MENU_HEADING_OSCOMMERCE, 
  'link' => html_href_link(FILENAME_DEFAULT, 'cat=general&module=index&tpl=cat_osc', 'SSL'),
);
*/
// Menu Locations
$menu[] = array(
  'text'        => BOX_OSCOMMERCE_ADMIN, 
  'heading'     => MENU_HEADING_TOOLS, // MENU_HEADING_OSCOMMERCE // Change if creating own title menu item
  'rank'        => 40, 
  'security_id' => SECURITY_ID_OSCOMMERCE_ADMIN, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=oscommerce&module=admin', 'SSL'),
);

$menu[] = array(
  'text'        => BOX_OSCOMMERCE_MODULE, 
  'heading'     => MENU_HEADING_TOOLS, // MENU_HEADING_OSCOMMERCE // Change if creating own title menu item
  'rank'        => 41, 
  'security_id' => SECURITY_ID_OSCOMMERCE_INTERFACE, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=oscommerce&module=main', 'SSL'),
);

// New Database Tables
// None

?>