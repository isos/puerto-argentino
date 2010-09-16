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
//  Path: /modules/services/pages/popup_label_image/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = (int)$_SESSION['admin_id']; // for popups, just make sure they are logged in
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************   page specific initialization  *************************/
require_once(DIR_FS_WORKING . 'shipping/language/' . $_SESSION['language'] . '/language.php');

$todo = $_GET['todo'];
$carrier = $_GET['carrier'];
$date = explode('-',$_GET['date']);
$label = $_GET['label'];

switch ($todo) {
  case 'notify':
  default:
	$image = (!$label) ? SHIPPING_TEXT_NO_LABEL : '';
	// show the form with a button to download
	break;
  case 'download':
	$file_path = DIR_FS_MY_FILES . $_SESSION['company'] . '/shipping/labels/' . $carrier . '/' . $date[0] . '/' . $date[1] . '/' . $date[2] . '/';
	$file_name = $label . '.lpt';
	if (file_exists($file_path . $file_name)) {
		$file_size = filesize($file_path . $file_name);
		$handle = fopen($file_path . $file_name, "r");
		$image = fread($handle, $file_size);
		fclose($handle);
		header('Content-type: application/octet-stream');
		header('Content-Length: ' . $file_size);
		header('Content-Disposition: attachment; filename=' . $file_name);
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		echo $image;
		exit();
	} else {
		$image = SHIPPING_TEXT_NO_LABEL;
	}
	break;
}

$custom_html = true; // need custome header to support frames
$include_header = false; // include header flag
$include_footer = false; // include footer flag
$include_tabs = false;
$include_calendar = false;

$include_template = 'template_main.php'; // include display template (required)
?>