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
//  Path: /modules/orders/pages/popup_bar_code/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = (int)$_SESSION['admin_id']; // for popups, just make sure they are logged in
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files    *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');

/**************   page specific initialization  *************************/
$jID = isset($_GET['jID']) ? $_GET['jID'] : '12'; // set default to Sales Journal

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/orders/popup_bar_code/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  default:
}

/*****************   prepare to display templates  *************************/

$include_header   = false;
$include_footer   = false;
$include_tabs     = false;
$include_calendar = true;
$include_template = 'template_main.php';
define('PAGE_TITLE', POPUP_BAR_CODE_TITLE);

?>