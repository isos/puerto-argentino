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
//  Path: /includes/header.php
//

?>
<div class="headerBar">
  <div class="headerBarContent" style="float:right;"><a href="<?php echo html_href_link(FILENAME_DEFAULT, 'cat=general&amp;module=logoff', 'SSL'); ?>" class="headerLink"><?php echo HEADER_TITLE_LOGOFF; ?></a>&nbsp;</div>
  <div class="headerBarContent" style="float:right;"><a href="#" class="headerLink" onclick='window.open("<?php echo html_href_link('includes/addons/PhreeHelp/index', '', 'NONSSL'); ?>","help","width=800,height=550,resizable=1,scrollbars=1,top=150,left=200");'><?php echo TEXT_HELP; ?></a>&nbsp;|&nbsp;</div>
  <div class="headerBarContent" style="float:right;"><a href="<?php echo html_href_link(FILENAME_DEFAULT, '', 'SSL'); ?>" class="headerLink"><?php echo HEADER_TITLE_TOP; ?></a>&nbsp;|&nbsp;</div>
  <?php // start the left heading fields ?>
  <?php if (ENABLE_ENCRYPTION && strlen($_SESSION['admin_encrypt']) > 0) {
  	echo '<div class="headerBarContent" style="float:left;">' . html_icon('emblems/emblem-readonly.png', TEXT_ENCRYPTION_ENABLED, 'small') . '</div>';
  } ?>
  <div class="headerBarContent" style="float:left;"><?php echo COMPANY_NAME; ?></div>
  <div class="headerBarContent" style="float:left;"><?php echo ' | '; ?></div>
  <div class="headerBarContent" style="float:left;"><?php echo TEXT_ACCOUNTING_PERIOD . ': ' . CURRENT_ACCOUNTING_PERIOD; ?></div>
  <div class="headerBarContent" style="float:left;"><?php echo ' | ' . get_ip_address() . '&nbsp;'; ?></div>
  <div class="headerBarContent" style="float:left;"><?php echo ' | '; ?></div>
  <div id="rtClock" class="headerBarContent"><?php echo '&nbsp;' . date(DATE_FORMAT, time()); ?></div>
</div>
<?php require(DIR_FS_INCLUDES . 'header_navigation.php'); ?>