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
//  Path: /my_files/custom/inventory/main/extra_actions.php
//

// This file contains the extra actions added to the maintain inventory module, it is executed
// before the standard switch statement
switch ($action) {
// Begin - Upload operation added by PhreeSoft to upload products to osCommerce
  case 'osc_upload':
	$id = db_prepare_input($_POST['rowSeq']);
	require_once(DIR_FS_MY_FILES . 'custom/oscommerce/classes/parser.php');
	require_once(DIR_FS_MY_FILES . 'custom/oscommerce/classes/zencart.php');
	$upXML = new oscommerce();
	$upXML->submitXML($id, 'product_ul');
	$action = '';
	break;
// End - Upload operation added by PhreeSoft
  default:
}
?>