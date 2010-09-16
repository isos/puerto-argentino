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
//  Path: /modules/install/popup_help_screen.php
//

  require('includes/application_top.php');
  require('language/' . $language . '/language.php');
  session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" /> 
<title><?php echo META_TAG_TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_INSTALL_CSS; ?>stylesheet.css">
</head>
<body id="popup"></body>
<div id="header">
<h1>
<?php
$error_code = (isset($_GET['error_code'])) ?  $_GET['error_code'] : '';
switch ($error_code) {
  case 'coa':
	require('../../includes/configure.php');
	if (!defined('DB_TYPE') || DB_TYPE=='') {
	  echo('Database Type Invalid. Did your configure.php file get written correctly?');
	  $zc_install->error = true;
	}
	define('DB_DATABASE',$_SESSION['company']);
	define('DB_SERVER',$_SESSION['db_server']);
	define('DB_SERVER_USERNAME',$_SESSION['db_user']);
	define('DB_SERVER_PASSWORD',$_SESSION['db_pw']);
	$db->Connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE) or die("Unable to connect to database");

	$filename = $_GET['file'];
	if ($filename == 'default') {
	  $chart_array = array();
	  $sql = "select id, description, account_type from " . DB_PREFIX . "chart_of_accounts";
	  $result = $db->Execute($sql);
	  while (!$result->EOF) {
		$chart_array[] = array($result->fields['id'], $result->fields['description'], $result->fields['account_type']);
		$result->MoveNext();
	  }
	  $chart_description = TEXT_CURRENT_SETTINGS;
	} else {
	  require('charts/' . $filename);
	}
	define('POPUP_ERROR_HEADING', $chart_description);
	$text_string = '<table width="100%">';
	$text_string .= '<tr><td width="20%" align="center">' . TEXT_ID . '</td><td width="50%" align="center">' . TEXT_DESCRIPTION . '</td><td width="30%" align="center">' . TEXT_ACCT_TYPE . '</td></tr>' . chr(10);
	foreach ($chart_array as $value) {
	  $text_string .= '<tr><td>' . $value[0] . '</td><td>' . $value[1] . '</td><td>' . load_acct_type_desc($value[2]) . '</td></tr>' . chr(10);
	}
	$text_string .= '</table>' . chr(10);
	break;
  default: // all other errors with a number assigned
	define('POPUP_ERROR_HEADING', constant('POPUP_ERROR_' . $error_code . '_HEADING'));
}  
  echo POPUP_ERROR_HEADING;
  echo '    <br /><br />';
?>
  </h1>
</div>
<div id="popup_content">
<?php
  if (defined('POPUP_ERROR_' . $error_code . '_TEXT')) {
    echo constant('POPUP_ERROR_' . $error_code . '_TEXT');
  } else {
    echo $text_string;
  }
  echo '<br /><br />';
?>
</div>
<?php
  echo '<center>' . '<a href="javascript:window.close()">' . TEXT_CLOSE_WINDOW . '</a></center>';
?>
</body>
</html>