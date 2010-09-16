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
//  Path: /modules/services/pages/popup_label_viewer/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = (int)$_SESSION['admin_id']; // for popups, just make sure they are logged in
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************   page specific initialization  *************************/
require_once(DIR_FS_WORKING . 'shipping/language/' . $_SESSION['language'] . '/language.php');

$carrier    = $_GET['carrier'];
$date       = $_GET['date'];
$date_array = explode('-',$date);
$labels     = $_GET['labels'];
$labels     = explode(':',$labels);
if (count($labels) == 0) die('No labels were passed to label_viewer.php!');
$row_size   = intval(100 / count($labels));
$row_string = '';
for ($i = 0; $i < count($labels); $i++) $row_string .= $row_size . '%,';
$row_string = substr($row_string, 0, -1);

$file_path = DIR_FS_MY_FILES . $_SESSION['company'] . '/shipping/labels/' . $carrier . '/' . $date_array[0] . '/' . $date_array[1] . '/' . $date_array[2] . '/';
$browser_path = DIR_WS_ADMIN . 'my_files/' . $_SESSION['company'] . '/shipping/labels/' . $carrier . '/' . $date_array[0] . '/' . $date_array[1] . '/' . $date_array[2] . '/';

$custom_html      = true; // need custome header to support frames
$include_header   = false;
$include_footer   = false;
$include_tabs     = false;
$include_calendar = false;
$include_template = 'template_main.php';

?>