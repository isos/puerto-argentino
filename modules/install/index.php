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
//  Path: /modules/install/index.php
//

  require_once('includes/application_top.php');
  if (!isset($_GET['main_page']) || !gen_not_null($_GET['main_page'])) $_GET['main_page'] = 'index';
  $current_page = $_GET['main_page'];

  require_once('../../includes/version.php');
  require_once('../general/functions/general.php');
  require_once('../general/functions/html_functions.php');
  require_once('language/' . $language . '/language.php');
  require_once('language/' . $language . '/' . $current_page . '.php');
  require_once('pages/' . $current_page . '/header_php.php');
  
  // make sure someone is not trying to hack in
  $result = load_company_dropdown();
  $blocked_modules = array('index', 'license', 'inspect', 'system_setup');
  if (sizeof($result) > 0 && in_array($current_page, $blocked_modules)) {
    die('This installation already has been set up. Please use Company Manager.');
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<?php echo ($current_page == 'inspect') ? '<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">' : '' ; ?>
<?php echo ($current_page == 'inspect') ? '<META HTTP-EQUIV="EXPIRES" CONTENT="0">' : '' ; ?>
<?php echo ($current_page == 'inspect') ? '<META HTTP-EQUIV="Pragma" CONTENT="no-cache">' : '' ; ?>
<title><?php echo META_TAG_TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_INSTALL_CSS; ?>stylesheet.css">
<script type="text/javascript" type="text/javascript"><!--
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=280,screenX=150,screenY=150,top=150,left=150')
}
function popupWindowLrg(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=700,height=500,screenX=50,screenY=50,top=50,left=50')
}
function popupWindowChrt(url) {
  var index = document.getElementById('store_default_coa').selectedIndex;
  if (index < 0) {
    alert("<?php echo ERROR_TEXT_NO_CHART_SELECTED; ?>");
  } else {
    url = url + '&file=' + document.getElementById('store_default_coa').options[index].value;
    window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=700,height=500,screenX=50,screenY=50,top=50,left=50')
  }	
}
function langSelect() {
  var index = document.getElementById('language').selectedIndex;
  var lang  = document.getElementById('language').options[index].value;
  location.href = 'index.php?language='+lang;
}
//-->
</script>
</head>

<?php
// pull in the applicable body code
$body_code = DIR_WS_INSTALL_TEMPLATE . $current_page . '_default.php';
$body_id = str_replace('_', '', $_GET['main_page']);
?>

<body id="<?php echo $body_id; ?>" <?php echo $zc_first_field;?>>
<div id="wrap">
  <div id="headerTitle" style="float:right;"><h1><?php echo TEXT_PAGE_HEADING; ?></h1></div>
  <div id="header"><img src="<?php echo DIR_WS_INSTALL_IMAGES; ?>phreebooks_logo.png" height="80"></div>
  <div id="content">
  <?php require($body_code); ?>
  </div>
  <div id="navigation">
  <?php require(DIR_WS_INSTALL_TEMPLATE . "navigation.php"); ?>
  </div>
</div>
</body>
</html>