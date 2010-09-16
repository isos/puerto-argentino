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
//  Path: /modules/general/pages/debug/pre_process.php
//

/**************   Check user security   *****************************/

/**************  include page specific files    *********************/

/**************   page specific initialization  *************************/

/***************   hook for custom actions  ***************************/

/***************   Act on the action request   *************************/
$file_name = 'trace.txt';
if (!$handle = fopen(DIR_FS_MY_FILES . $file_name, "r")) {
  $messageStack->add(DEBUG_TRACE_MISSING, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}
$contents = fread($handle, filesize(DIR_FS_MY_FILES . $file_name));
fclose($handle);

$file_size = strlen($contents);
header('Content-type: text/html; charset=utf-8');
header("Content-disposition: attachment; filename=" . $file_name . "; size=" . $file_size);
header('Pragma: cache');
header('Cache-Control: public, must-revalidate, max-age=0');
header('Connection: close');
header('Expires: ' . date('r', time() + 60 * 60));
header('Last-Modified: ' . date('r', time()));
print $contents;
exit();  

/*****************   prepare to display templates  *************************/
?>