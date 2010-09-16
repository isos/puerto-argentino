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
//  Path: /modules/install/templates/display_errors.php
//

?><fieldset>
<legend><?php echo TEXT_ERROR_WARNING; ?></legend>
  <div id="error">
<ul>
<?php
  foreach ($zc_install->error_array as $za_errors ) {
    echo '<li class="FAIL">' . $za_errors['text'] . '<a href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=' . $za_errors['code'] . '\')"> ' . TEXT_HELP_LINK . '</a></li>';
  }
?>
</ul>
  </div>
</fieldset>
  
<br /><br />