<?php // Pre-processing
require('config.php');
include('language/' . DEFAULT_LANGUAGE . '/language.php');
require('includes/functions.php');

// Load db class
require('includes/db/' . DB_TYPE . '/query_factory.php');
$db = new queryFactory();
if (!$db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE)) {
	echo $db->show_error() . '<br />';
	die (NO_CONNECT_DB);
}
// $current = check_version();  // make sure db is current with latest information files - MOVED TO index.php
// check to see if script re-entered from search
$search_field = $_POST['search_field'];

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Left Frame</title>
<link rel="stylesheet" href="css/phreehelp.css">
<script type="text/javascript" src="modules/tabtastic/addclasskillclass.js"></script>
<script type="text/javascript" src="modules/tabtastic/attachevent.js"></script>
<script type="text/javascript" src="modules/tabtastic/addcss.js"></script>
<script type="text/javascript" src="modules/tabtastic/tabtastic.js"></script>
<script type="text/javascript">
function Toggle(item) {
   obj=document.getElementById(item);
   visible=(obj.style.display!="none")
   key=document.getElementById("zh_" + item);
   if (visible) {
     obj.style.display="none";
     key.innerHTML="<img src='css/<?php echo DEFAULT_STYLE; ?>/images/folder.gif' width='16' height='16' hspace='0' vspace='0' border='0'>";
   } else {
      obj.style.display="block";
      key.innerHTML="<img src='css/<?php echo DEFAULT_STYLE; ?>/images/textfolder.gif' width='16' height='16' hspace='0' vspace='0' border='0'>";
   }
}

function Expand(tab_type) {
	divs=document.getElementsByTagName("DIV");
	for (i=0;i<divs.length;i++) {
		div_id = divs[i].id;
		if (div_id.substr(0,3) == tab_type) {
			divs[i].style.display="block";
			key=document.getElementById("zh_" + div_id);
			key.innerHTML="<img src='css/<?php echo DEFAULT_STYLE; ?>/images/textfolder.gif' width='16' height='16' hspace='0' vspace='0' border='0'>";
		}
	}
}

function Collapse(tab_type) {
	divs=document.getElementsByTagName("DIV");
	for (i=0;i<divs.length;i++) {
		div_id = divs[i].id;
		if (div_id.substr(0,3) == tab_type) {
			divs[i].style.display="none";
			key=document.getElementById("zh_" + div_id);
			key.innerHTML="<img src='css/<?php echo DEFAULT_STYLE; ?>/images/folder.gif' width='16' height='16' hspace='0' vspace='0' border='0'>";
		}
	}
}
</script>
</head>

<body>

<ul class="tabset_tabs">
   <li><a href="#contents"<?php echo ($search_field=='') ? ' class="active"' : ''; ?>><?php echo HEADING_CONTENTS; ?></a></li>
   <li><a href="#index"><?php echo HEADING_INDEX; ?></a></li>
   <li><a href="#search"<?php echo ($search_field<>'') ? ' class="active"' : ''; ?>><?php echo HEADING_SEARCH; ?></a></li>
</ul>

<div id="contents" class="tabset_content">
	<h2 class="tabset_label"><?php echo HEADING_CONTENTS; ?></h2>
	<a href="javascript:Expand('doc');"><?php echo TEXT_EXPAND; ?></a> - <a href="javascript:Collapse('doc');"><?php echo TEXT_COLLAPSE; ?></a><br />
	<fieldset>
		<?php echo retrieve_toc(); ?>
	</fieldset>
</div>

<div id="index" class="tabset_content">
	<h2 class="tabset_label"><?php echo HEADING_INDEX; ?></h2>
	<a href="javascript:Expand('idx');"><?php echo TEXT_EXPAND; ?></a> - <a href="javascript:Collapse('idx');"><?php echo TEXT_COLLAPSE; ?></a><br />
	<fieldset><?php echo retrieve_index(); ?></fieldset>
</div>

<div id="search" class="tabset_content">
	<h2 class="tabset_label"><?php echo HEADING_SEARCH; ?></h2>
	<?php echo TEXT_KEYWORD; ?><br />
	<form name="search_form" method="post" action="leftframe.php">
		<input type="text" name="search_field" value="<?php echo $search_field; ?>">
        <input type="image" src="css/<?php echo DEFAULT_STYLE; ?>/images/system-search.png" border="0" alt="Search">
    </form>
	<?php echo TEXT_SEARCH_RESULTS; ?><br />
	<fieldset>
		<?php echo search_results($search_field); ?>
	</fieldset>
</div>

<?php // Post-processing ?>

</body>
</html>
