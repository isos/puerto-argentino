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
// Path: /index.php
//

// Set the level of error reporting
error_reporting(E_ALL & ~E_NOTICE);

//get the category and module information for our file includes
if ($_POST["cat"])       $cat = $_POST["cat"];
elseif ($_GET["cat"])    $cat = $_GET["cat"];
else                     $cat = 'general';

if ($_POST["module"])    $module = $_POST["module"];
elseif ($_GET["module"]) $module = $_GET["module"];
else                     $module = 'index';

//initialize our variables, set module to login if not logged in
require('includes/application_top.php');

// test for user logged in and show login page if not
if (!$user_validated && $module != 'pw_lost') {
  if ($module <> 'login' && $module <> 'pw_lost') { // save the page requested to reload when logging back in
    $_SESSION['pb_cat']    = $_GET['cat'];
    $_SESSION['pb_module'] = $_GET['module'];
    $_SESSION['pb_jID']    = $_GET['jID'];
    $_SESSION['pb_type']   = $_GET['type'];
  } 
  $cat    = 'general';
  $module = 'login';
} else {
  unset($_SESSION['pb_cat']);
  unset($_SESSION['pb_module']);
  unset($_SESSION['pb_jID']);
  unset($_SESSION['pb_type']);
}

// check to see if it is an ajax request
if ($module == 'ajax') {
  $pre_process_path = DIR_FS_MY_FILES . 'custom/' . $cat . '/ajax/' . $_REQUEST["op"] . '.php';
  if (file_exists($pre_process_path)) { require($pre_process_path); die; }
  $pre_process_path = DIR_FS_MODULES . $cat . '/ajax/' . $_REQUEST["op"] . '.php';
  if (file_exists($pre_process_path)) { require($pre_process_path); die; }
  die; // go no further
}

//include the custom modfications for this module
$custom_html      = false;
$include_header   = false;
$include_footer   = false;
$include_template = 'template_main.php'; // default template to use, can be over-ridden by pre_process

//start processing the module, required, pull in custom modules if requested
$pre_process_path = DIR_FS_MY_FILES . 'custom/' . $cat . '/pages/' . $module . '/pre_process.php';
if (file_exists($pre_process_path)) {
  define('DIR_FS_WORKING', DIR_FS_MY_FILES . 'custom/' . $cat . '/');
  define('DIR_WS_WORKING', DIR_WS_FULL_PATH . 'my_files/custom/' . $cat . '/');
} else {
  $pre_process_path = DIR_FS_MODULES . $cat . '/pages/' . $module . '/pre_process.php';
  if (file_exists($pre_process_path)) {
    define('DIR_FS_WORKING', DIR_FS_MODULES . $cat . '/');
	define('DIR_WS_WORKING', DIR_WS_FULL_PATH . 'modules/' . $cat . '/');
  } else die('No pre_process file, looking for the file: ' . $pre_process_path);
}

// load the pre_process file
require($pre_process_path); 

// set the template path as defined from the pre-process script, include custom if exists
if (file_exists(DIR_FS_MY_FILES . 'custom/' . $cat . '/pages/' . $module . '/' . $include_template)) {
  $template_path = DIR_FS_MY_FILES . 'custom/' . $cat . '/pages/' . $module . '/' . $include_template;
} else {
  $template_path = DIR_FS_WORKING . 'pages/' . $module . '/' . $include_template;
}

if (!$custom_html) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo HTML_PARAMS; ?>>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
  <title><?php echo PAGE_TITLE; ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_THEMES . 'css/stylesheet.css'; ?>" />
  <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
  <!-- cat = <?php echo $cat; ?> - module = <?php echo $module; ?> -->

  <?php if ($include_header) { ?>
  <script type="text/javascript" src="includes/javascript/menu.js"></script>
  <?php } ?>

  <script type="text/javascript">
  var pbBrowser = (document.all) ? 'IE' : 'FF';
  var sessionAutoRefresh  = <?php echo defined('SESSION_AUTO_REFRESH') ? SESSION_AUTO_REFRESH : 0; ?>;
  var text_search         = '<?php echo TEXT_SEARCH; ?>';
  var date_format         = '<?php echo DATE_FORMAT; ?>';
  var date_delimiter      = '<?php echo DATE_DELIMITER; ?>';
  var inactive_bg_color   = '#cccccc';
  var inactive_text_color = '#cccccc';
  // Variables for script generated combo boxes
  var icon_path           = '<?php echo DIR_WS_ICONS; ?>';
  var combo_image_on      = '<?php echo DIR_WS_ICONS . '16x16/phreebooks/pull_down_active.gif'; ?>';
  var combo_image_off     = '<?php echo DIR_WS_ICONS . '16x16/phreebooks/pull_down_inactive.gif'; ?>';
  // Calendar translations
  var month_short_01      = '<?php echo TEXT_JAN; ?>';
  var month_short_02      = '<?php echo TEXT_FEB; ?>';
  var month_short_03      = '<?php echo TEXT_MAR; ?>';
  var month_short_04      = '<?php echo TEXT_APR; ?>';
  var month_short_05      = '<?php echo TEXT_MAY; ?>';
  var month_short_06      = '<?php echo TEXT_JUN; ?>';
  var month_short_07      = '<?php echo TEXT_JUL; ?>';
  var month_short_08      = '<?php echo TEXT_AUG; ?>';
  var month_short_09      = '<?php echo TEXT_SEP; ?>';
  var month_short_10      = '<?php echo TEXT_OCT; ?>';
  var month_short_11      = '<?php echo TEXT_NOV; ?>';
  var month_short_12      = '<?php echo TEXT_DEC; ?>';
  var day_short_1         = '<?php echo TEXT_SUN; ?>';
  var day_short_2         = '<?php echo TEXT_MON; ?>';
  var day_short_3         = '<?php echo TEXT_TUE; ?>';
  var day_short_4         = '<?php echo TEXT_WED; ?>';
  var day_short_5         = '<?php echo TEXT_THU; ?>';
  var day_short_6         = '<?php echo TEXT_FRI; ?>';
  var day_short_7         = '<?php echo TEXT_SAT; ?>';
  </script>

  <?php if (class_exists('currencies')) { // will not be defined unless logged in and db defined ?>
  <script type="text/javascript">
  var decimal_places  = "<?php echo $currencies->currencies[DEFAULT_CURRENCY]['decimal_places']; ?>";
  var decimal_precise = "<?php echo $currencies->currencies[DEFAULT_CURRENCY]['decimal_precise']; ?>";
  var decimal_point   = "<?php echo $currencies->currencies[DEFAULT_CURRENCY]['decimal_point']; ?>";
  var thousands_point = "<?php echo $currencies->currencies[DEFAULT_CURRENCY]['thousands_point']; ?>";
  var formatted_zero  = "<?php echo $currencies->format(0); ?>";
  </script>
  <?php } ?>

  <script type="text/javascript" src="includes/javascript/ajax.js"></script>
  <script type="text/javascript" src="includes/javascript/general.js"></script>
  <script type="text/javascript" src="includes/javascript/jquery.js"></script>
  <script type="text/javascript" src="includes/javascript/jquery.hotkeys.js"></script>

  <?php if ($include_tabs) { ?>
  <script type="text/javascript" src="includes/addons/tabtastic/tabs.js"></script>
  <?php } ?>

  <?php if ($include_calendar) { ?>
  <link rel="stylesheet" type="text/css" href="includes/addons/spiffyCal/spiffyCal.css" />
  <script type="text/javascript" src="includes/addons/spiffyCal/spiffyCal.js"></script>
  <?php } ?>

  <?php
  // load the javascript specific, required
  $js_include_path = DIR_FS_WORKING . 'pages/' . $module . '/js_include.php';
  if (file_exists($js_include_path)) { require($js_include_path); } 
    else die('No js_include file, looking for the file: ' . $js_include_path);

  // load the custom javascript if present
  $js_include_path = DIR_FS_MY_FILES . 'custom/' . $cat . '/' . $module . '/extra_js.php';
  if (file_exists($js_include_path)) { require($js_include_path); }

  $html_body_params = ($include_header) ? ' onload="init(); startClock();" onunload="endClock();"' : ' onload="init();"';
  ?>

  </head>
  <body<?php echo $html_body_params; ?>>
  <script type="text/javascript" src="includes/addons/wz_tooltip/wz_tooltip.js"></script>
  <script type="text/javascript" src="includes/addons/wz_tooltip/tip_balloon.js"></script>  

  <?php
  if ($include_calendar) echo '<div id="spiffycalendar" class="text"></div>';

  // show the menu
  if ($include_header) { require(DIR_FS_INCLUDES . 'header.php'); }

} // end if (!$custom_html) 

// load the template, required
if (is_file($template_path)) {
	require($template_path);
} else die('No template file. Looking for: ' . $template_path);

if (!$custom_html) {
  if ($include_footer) { require(DIR_FS_INCLUDES . 'footer.php'); }
?>
</body>
</html>
<?php } // end if (!custom_html)

require('includes/application_bottom.php');
?>
