<?
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
//  Path: /admin/soap/products.php
//

// The following line is specific to the application. Pull in startup script to initialize db, classes, etc.
require ('application_top.php');
require ('classes/products.php'); // soap required classes
$rawpost = urldecode(file_get_contents("php://input")); // retrieve the XML raw string
// Start processing the received string
$products_upload = new xml_products();
$products_upload->processXML($rawpost);
// The following line is specific to the application. Pull in finalize script to close db, classes, etc.
require ('application_bottom.php');

?>