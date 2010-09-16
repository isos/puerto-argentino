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
//  Path: /my_files/custom/extra_menus/zencart.php
//

// REMEMBER TO CHECK PERMISSIONS AFTER ADDING A NEW MENU ITEM. THEY DEFAULT TO NO ACCESS AND 
// DO NOT SHOW UP ON THE MENU UNITL PERMISSION HAS BEEN GRANTED AND THE USER HAS RE-LOGGED IN

// include the language definition for the menu items
if (file_exists(DIR_FS_MY_FILES . 'custom/zencart/language/' . $_SESSION['language'] . '/menu.php')) {
  include_once(DIR_FS_MY_FILES  . 'custom/zencart/language/' . $_SESSION['language'] . '/menu.php');
} else {
  include_once(DIR_FS_MY_FILES  . 'custom/zencart/language/en_us/menu.php');
}

// Set the menu order, if using ZenCart title menu option (after Customers and before Vendors)
define('MENU_HEADING_ZENCART_ORDER',    15);

// Security id's
define('SECURITY_ID_ZENCART_ADMIN',     201);
define('SECURITY_ID_ZENCART_INTERFACE', 200);

// Uncomment below to set the title menu for the ZenCart interface, otherwsie it will be parts of the Tools mennu
/*
$pb_headings[MENU_HEADING_ZENCART_ORDER] = array(
  'text' => MENU_HEADING_ZENCART, 
  'link' => html_href_link(FILENAME_DEFAULT, 'cat=general&module=index&tpl=cat_zencart', 'SSL'),
);
*/
// Menu Locations
$menu[] = array(
  'text'        => BOX_ZENCART_ADMIN, 
  'heading'     => MENU_HEADING_TOOLS, // MENU_HEADING_ZENCART // Change if creating own title menu item
  'rank'        => 30, 
  'security_id' => SECURITY_ID_ZENCART_ADMIN, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=zencart&module=admin', 'SSL'),
);

$menu[] = array(
  'text'        => BOX_ZENCART_MODULE, 
  'heading'     => MENU_HEADING_TOOLS, // MENU_HEADING_ZENCART // Change if creating own title menu item
  'rank'        => 31, 
  'security_id' => SECURITY_ID_ZENCART_INTERFACE, 
  'link'        => html_href_link(FILENAME_DEFAULT, 'cat=zencart&module=main', 'SSL'),
);

// New Database Tables
// None

?>