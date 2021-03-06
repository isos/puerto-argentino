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
//  Path: /modules/install/pages/license/header_php.php
//

  $zc_install->error = false;
  $zc_install->fatal_error = false;
  $zc_install->error_list = array();
  
  if (isset($_POST['submit'])) {
    if (isset($_POST['license_consent']) && $_POST['license_consent'] == 'agree') {
      header('location: index.php?main_page=inspect&language=' . $language);
      exit;
    }
    if (isset($_POST['license_consent']) && $_POST['license_consent'] == 'disagree') {
      header('location: index.php');
      exit;
    }
  }
?>