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
//  Path: /modules/services/pages/popup_label_viewer/template_main.php
//

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo TITLE . ' - ' . COMPANY_NAME; ?></title>
<script type="text/javascript">
<!--
window.opener.location.reload();
// -->
</script>
</head>

<?php 
echo '<frameset rows="' . $row_string . '" cols="10%,90%">';
for ($i = 0; $i < count($labels); $i++) { 
  if (is_file($file_path . $labels[$i] . '.lpt')) { // Thermal label
  	$image_src = html_href_link(FILENAME_DEFAULT, 'cat=services&amp;module=popup_label_image&amp;todo=notify&amp;date=' . $date . '&amp;carrier=' . $carrier . '&amp;label=' . $labels[$i], 'SSL');
  } elseif (is_file($file_path . $labels[$i] . '.pdf')) { // PDF format
	$image_src = $browser_path . $labels[$i] . '.pdf';
  } elseif (is_file($file_path . $labels[$i] . '.gif')) { // GIF image
	$image_src = $browser_path . $labels[$i] . '.gif';
  } else {
  	$image_src = html_href_link(FILENAME_DEFAULT, 'cat=services&amp;module=popup_label_image', 'SSL');
  }
  echo '<frame name="print_' . $i . '" src="' . html_href_link(FILENAME_DEFAULT, 'cat=services&amp;module=popup_label_button&amp;index=' . $i, 'SSL') . '" />';
  echo '<frame name="content_' . $i . '" src="' . $image_src . '" />';
}
echo '</frameset>';
echo '<noframes>';
echo '  Your browser needs to support frames for the label print function to work.';
echo '</noframes>';
?>
</html>