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
//  Path: /modules/install/templates/inspect_default.php
//

?>
<p><?php echo TEXT_MAIN; ?></p>
<?php
  if ($zc_install->error) { require(DIR_WS_INSTALL_TEMPLATE . 'display_errors.php'); }
?>
<form method="post" action="index.php?main_page=inspect<?php if (isset($_GET['language'])) { echo '&language=' . $_GET['language']; } ?>">

<?php if ($phreebooks_allow_database_upgrade == true) { ?>
<fieldset>
<legend><strong><?php echo UPGRADE_DETECTION; ?></strong></legend>
<div class="section"><br />
 <strong><?php echo LABEL_PREVIOUS_INSTALL_FOUND; ?></strong><br />
 <?php echo $zdb_version_message; ?>
 </div></fieldset>
 <br />
<?php } ?>
<fieldset>
<legend><strong><?php echo SYSTEM_INSPECTION_RESULTS; ?></strong></legend>
<div class="section"><ul class="inspect-list">
<?php foreach ($status_check as $val) { ?>
   <li class='<?php echo $val['Class']; ?>'><strong><?php echo $val['Title']; ?></strong> = <?php echo $val['Status']; ?>
<?php if ($val['HelpURL']!='' && ($val['Class'] == 'FAIL' || $val['Class'] == 'WARN') ) {
    echo '&nbsp; ' . '<a class="nowrap" href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=' . $val['HelpURL'] . '\')"> ';
//    echo (gen_not_null($val['HelpLabel'])) ? $val['HelpLabel'] : LABEL_EXPLAIN ;
    echo LABEL_EXPLAIN ;
    echo '</a>';
    } ?>
</li><br />
<?php } //end foreach?>

<!--
<br />
 <li><strong><?php //echo LABEL_PHP_MODULES; ?></strong><br/>
   <ul>
   <?php //foreach($php_extensions as $module) { echo '<li>' . $module .'</li><br />'; } ?>
   </ul></li>
-->
</ul>
<br /><a class="button" href="javascript:popupWindowLrg('includes/phpinfo.php')"><?php echo VIEW_PHP_INFO_LINK_TEXT; ?></a>
</div>
</fieldset>

<fieldset>
<legend><strong><?php echo OTHER_INFORMATION; ?></strong></legend>
<div class="section"><?php echo OTHER_INFORMATION_DESCRIPTION; ?><ul class="inspect-list">
<?php foreach ($status_check2 as $val) { ?>
   <li class='<?php echo $val['Class']; ?>'><strong><?php echo $val['Title']; ?></strong> = <?php echo $val['Status']; ?>
<?php if ($val['HelpURL']!='' && ($val['Class'] == 'FAIL' || $val['Class'] == 'WARN') ) {
    echo '&nbsp; ' . '<a class="nowrap" href="javascript:popupWindow(\'popup_help_screen.php?language=' . $language . '&error_code=' . $val['HelpURL'] . '\')"> ';
//    echo (gen_not_null($val['HelpLabel'])) ? $val['HelpLabel'] : LABEL_EXPLAIN ;
    echo LABEL_EXPLAIN ;
    echo '</a>';
    } ?>
</li><br />
<?php } //end foreach?>
</ul>
</div>
</fieldset>

<fieldset>
<legend><strong><?php echo LABEL_FOLDER_PERMISSIONS; ?></strong></legend>
<div class='section'>
<?php echo LABEL_WRITABLE_FOLDER_INFO; ?>
<ul class="inspect-list">
<?php foreach ($file_status as $val) { ?>
   <li class='<?php echo $val['class']; ?>'><strong><?php echo $val['file']; ?></strong> = 
   <?php echo $val['exists'] . $val['writable']; ?>
   </li><br />
<?php } //end foreach?>
<br />
<?php foreach ($folder_status as $val) { ?>
   <li class='<?php echo $val['class']; ?>'><strong><?php echo $val['folder']; ?></strong> = 
   <?php echo $val['writable']; ?>
   <?php echo ($val['writable']==UNWRITABLE)?'&nbsp;&nbsp;(chmod '.$val['chmod'] . ')' : ''; ?>
   </li><br />
<?php } //end foreach?>
</ul>
</div>
</fieldset>

<input type="submit" name="submit" class="button" tabindex = "8" value="<?php echo INSTALL_BUTTON; ?>" />
<?php if ($phreebooks_previous_version_installed == true) { ?>
<input type="submit" name="upgrade" class="button" tabindex = "9" value="<?php echo UPGRADE_BUTTON; ?>" />
<?php } ?>
<?php if ($phreebooks_allow_database_upgrade == true) { ?>
<input type="submit" name="db_upgrade" class="button" tabindex = "10" value="<?php echo DB_UPGRADE_BUTTON; ?>" />
<?php } ?>
<input type="submit" name="refresh" class="button" tabindex = "11" value="<?php echo REFRESH_BUTTON; ?>" />
</form>
