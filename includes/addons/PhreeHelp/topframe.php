<?php // Pre-processing
require ('config.php');
require ('language/' . DEFAULT_LANGUAGE . '/language.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Icon Frame</title>
<link rel="stylesheet" href="css/phreehelp.css">
</head>
<body>
  <div>
    <input type="image" src="css/<?php echo DEFAULT_STYLE; ?>/images/go-home.png" border="0" alt="<?php echo ICON_HOME; ?>" onclick="parent.mainFrame.location.href = '<?php echo DOC_ROOT_URL . '/' . DOC_HOME_PAGE; ?>';">
    <input type="image" src="css/<?php echo DEFAULT_STYLE; ?>/images/go-previous.png" border="0" alt="<?php echo ICON_BACK; ?>" onclick="parent.mainFrame.history.back();">
    <input type="image" src="css/<?php echo DEFAULT_STYLE; ?>/images/go-next.png" border="0" alt="<?php echo ICON_FORWARD; ?>" onclick="parent.mainFrame.history.forward();">
    <input type="image" src="css/<?php echo DEFAULT_STYLE; ?>/images/printer.png" border="0" alt="<?php echo ICON_PRINT; ?>" onclick="parent.mainFrame.focus(); parent.mainFrame.print();">
    <input type="image" src="css/<?php echo DEFAULT_STYLE; ?>/images/internet-web-browser.png" border="0" alt="<?php echo ICON_SUPPORT; ?>" onclick="parent.mainFrame.location.href = '<?php echo DOC_WWW_HELP; ?>';">
    <input type="image" src="css/<?php echo DEFAULT_STYLE; ?>/images/system-log-out.png" border="0" alt="<?php echo ICON_EXIT; ?>" onclick="parent.window.close()">
  </div>
</body>
</html>