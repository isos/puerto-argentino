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
//  Path: /includes/footer.php
//

// Hook for custom logo
if (defined('FOOTER_LOGO')) {
	$image_path = FOOTER_LOGO;
} else {
	$image_path = DIR_WS_IMAGES . 'phreebooks_logo.png';
}
?>
<div id="footertable">
<br /><br /><br />
<hr />

<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" class="smallText" >
	<p>ERP/Accounting Engine Release <?php echo PROJECT_VERSION_MAJOR . '.' . PROJECT_VERSION_MINOR; ?> Copyright &copy; <?php echo date('Y',time()); ?> <a href="http://www.PhreeSoft.com" target="_blank">PhreeSoft, LLC&trade;</a>
	<?php echo '(' . (int)(1000* (microtime(true) - PAGE_EXECUTION_START_TIME)) . ' ms) ' . $db->count_queries . ' SQLs (' . (int)($db->total_query_time * 1000).' ms)'; ?></p></td>
  </tr>
<?php // session variables
//	echo '<tr><td class="smallText">Session Variables=<br />'; print_r($_SESSION); echo '</td></tr>';
?>
</table>
</div>
<?php if ($include_header) { ?>
</div></div><!-- close trans div -->
<?php } ?>
