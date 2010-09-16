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
//  Path: /modules/install/templates/license_default.php
//

?>
<p><?php echo TEXT_MAIN; ?></p>
<?php
  if ($zc_install->error) { require(DIR_WS_INSTALL_TEMPLATE . 'display_errors.php'); }
?>
<iframe src="../../doc/manual/ch01-Introduction/license.html"></iframe>
<form method="post" action="index.php?main_page=license<?php if (isset($_GET['language'])) { echo '&language=' . $_GET['language']; } ?>">
  <input type="radio" name="license_consent" id="agree" value="agree" />
  <label for="agree"><?php echo AGREE; ?></label><br />
  <input type="radio" name="license_consent" id="disagree" checked="checked" value="disagree" />
  <label for="disagree"><?php echo DISAGREE; ?></label><br />
  <input type="submit" name="submit" class="button" value="<?php echo INSTALL; ?>" />
</form>