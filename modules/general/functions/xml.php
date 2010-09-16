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
//  Path: /modules/general/functions/xml.php
//

//this function creates an xml header with typeid so we can process and associate
//the proper response handler with the returned data
function createXmlHeader($type) {
	header("Content-Type: text/xml");
	//use a default dbencoding
	if (!defined("CHARSET")) define("CHARSET", "UTF-8");
	$str = "<?xml version=\"1.0\" encoding=\"" . CHARSET . "\" standalone=\"yes\"?>\n";
	$str .= "<data>\n";
	$str .= "\t<typeid>" . $type . "</typeid>\n";
	return $str;
}

//puts a footer on the end of our xml data
function createXmlFooter() {
	return "</data>\n";
}

//encases the data in its xml tags and CDATA declaration
function xmlEntry($key, $data, $ignore = NULL) {
	$str = "\t<" . $key . ">";
	if ($data!=NULL) {
		//convert our db data to the proper encoding if able
		if (defined("DB_CHARSET") && defined("CHARSET")) $data = charConv($data, DB_CHARSET, CHARSET);
		if ($ignore) $str .= $data;
		else $str .= "<![CDATA[" . $data . "]]>";
	}
	$str .= "</" . $key . ">\n";
	return $str;
}

?>