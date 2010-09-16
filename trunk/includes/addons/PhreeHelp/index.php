<?php 
require('config.php');
require('language/' . DEFAULT_LANGUAGE . '/language.php');
require('includes/functions.php');
require('includes/db/' . DB_TYPE . '/query_factory.php');
$context_ref = isset($_GET['idx']) ? $_GET['idx'] : '';

// Load db class
$db = new queryFactory();
if (!$db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE)) {
	echo $db->show_error() . '<br />';
	die (NO_CONNECT_DB);
}
$current = check_version();  // make sure db is current with latest information files
$result = false;
if ($context_ref) {
  $result = $db->Execute("select doc_url from " . DB_PREFIX . "zh_search where doc_pos = '" . $context_ref . "'");
}
$start_page = (!$result) ? (DOC_ROOT_URL . '/' . DOC_HOME_PAGE) : $result->fields['doc_url'];

//$start_page = DOC_ROOT_URL . '/' . DOC_HOME_PAGE;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo HEADING_TITLE; ?></title>
<link rel="stylesheet" href="css/phreehelp.css">
</head>

<frameset rows="*" cols="300,*" frameborder="YES" border="2" framespacing="0">
  <frameset rows="60,*" cols="*" frameborder="YES" border="2" framespacing="0">
    <frame name="topFrame" src="topframe.php" scrolling="NO">
    <frame name="leftFrame" src="leftframe.php">
  </frameset>
  <frame name="mainFrame" src="<?php echo $start_page; ?>">
</frameset>
<noframes>
<body> 
</body>
</noframes>
</html>