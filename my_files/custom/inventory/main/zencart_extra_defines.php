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
//  Path: /my_files/custom/inventory/main/zencart_extra_defines.php
//

// This file contains the extra defines that can be used for customizing you output and 
// adding functionality to PhreeBooks. It needs to be renamed to extra_defines.php if that 
// file does not exist. If extra_defines.php does exist, the contents of this file ned to be 
// merged with the existing file.

// Additional Action bar buttons (DYNAMIC AS IT IS SET BASED ON EVERY LINE!!!)
@include_once(DIR_FS_MY_FILES . 'custom/zencart/config.php'); // pull the current zencart config info, if it is there
@include_once(DIR_FS_MY_FILES . 'custom/zencart/language/' . $_SESSION['language'] . '/language.php');
function add_extra_action_bar_buttons($query_fields) {
  $output = '';
  if (defined('ZENCART_URL') && $_SESSION['admin_security'][SECURITY_ID_MAINTAIN_INVENTORY] > 1 && $query_fields['catalog'] == '1') {
    $output .= html_icon('../../../../my_files/custom/zencart/images/zencart.gif', ZENCART_IVENTORY_UPLOAD, 'small', 'onclick="submitSeq(' . $query_fields['id'] . ', \'upload\')"', '16', '16') . chr(10);
  }
  return $output;
}

// Defines used to increase search scope (additional fields) within a module, the constant 
// cannot change and the format should be as follows: 
//$extra_search_fields = array('field_1', 'field_2');

// defines to use to retrieve more fields from sql for custom processing in list generation operations
$extra_fields = array();
// for the ZenCart upload mod, the catalog field should be in the table
if (defined('ZENCART_URL')) $extra_fields[] = 'catalog';

if (count($extra_fields) > 0) $extra_query_list_fields = $extra_fields;

?>