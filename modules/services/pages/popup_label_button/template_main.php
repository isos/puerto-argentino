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
//  Path: /modules/services/pages/popup_label_button/template_main.php
//

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo TITLE . ' - ' . COMPANY_NAME; ?></title>
</head>

<body>
  <form>
    <p><input type="button" name="<?php echo 'close_' . $index; ?>" value="<?php echo TEXT_CLOSE; ?>" onclick="<?php echo 'parent.opener.location.reload(); parent.close()'; ?>" /></p>
<!--    <p><input type="button" name="<?php echo 'prn_' . $index; ?>" value="<?php echo TEXT_PRINT; ?>" onclick="<?php echo 'parent.content_' . $index . '.focus(); parent.content_' . $index . '.print()'; ?>" /></p> -->
  </form>
</body>
</html>