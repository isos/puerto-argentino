<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2010 PhreeSoft, LLC                               |
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
//  Path: /admin/soap/classes/parser.php
//


class xml2Array {
   
	function parse($strInputXML) {
		$this->resParser = xml_parser_create();
		xml_set_object($this->resParser, $this);
		xml_set_element_handler($this->resParser, "tagOpen", "tagClosed");
		xml_set_character_data_handler($this->resParser, "tagData");

		$this->strXmlData = xml_parse($this->resParser, $strInputXML);
		if(!$this->strXmlData) {
		    $strText = 'Zencart XML parse error: ' . xml_error_string(xml_get_error_code($this->resParser)) . ' at line ' . xml_get_current_line_number($this->resParser);
			return $this->responseXML('04', $strText, 'error');
		}
		xml_parser_free($this->resParser);
		return true;
	}

	function tagOpen($parser, $name, $attrs) {
		$tag=array("name"=>$name,"attrs"=>$attrs); 
		array_push($this->arrOutput,$tag);
	}

	function tagData($parser, $tagData) {
		if(trim($tagData) <> '') {
			if(isset($this->arrOutput[count($this->arrOutput)-1]['tagData'])) {
				$this->arrOutput[count($this->arrOutput)-1]['tagData'] .= $tagData;
			} else {
				$this->arrOutput[count($this->arrOutput)-1]['tagData'] = $tagData;
			}
		}
	}

	function tagClosed($parser, $name) {
		$this->arrOutput[count($this->arrOutput)-2]['children'][] = $this->arrOutput[count($this->arrOutput)-1];
		array_pop($this->arrOutput);
	}

	function getNodeData($tree, $search_array) {
		// $tree is an array path to the desired node element
		// will return false if tree path is invalid or node value is not found; node value (including null) if found.
		$path_element = array_shift($tree);
		for ($i=0; $i<count($search_array); $i++) {
			if ($search_array[$i]['name'] == $path_element) {
				if (count($tree) > 0) {
					return $this->getNodeData($tree, $search_array[$i]['children']);
				} else {
					return $search_array[$i]['tagData'];
				}
			}
		}
		return false;
	}

	function getSubArray($searchKey, $searchArray) {
		foreach ($searchArray as $value) {
			if ($value['name'] == $searchKey) {
				return $value['children'];
			}
			if (isset($value['children'])) {
				$result = $this->getSubArray($searchKey, $value['children']);
				if ($result) return $result;
			}
		}
		return false;
	}

	function validateUser() {
		global $db;
		$this->username = $this->getNodeData(array('ACCESSREQUEST','ACCESSUSERID'), $this->arrOutput);
		$this->password = $this->getNodeData(array('ACCESSREQUEST','ACCESSPASSWORD'), $this->arrOutput);
		if (!$this->username || !$this->password) {
			return $this->responseXML('10', SOAP_NO_USER_PW, 'error');
		}
// TBD - This portion is specific to the application database name, fields and password validation methods
//		if (!is_object($db)) { echo 'the database is not open ...'; return false; }
		// validate user with db (call validation function)
		$result = $db->Execute("select admin_pass from " . DB_PREFIX . "admin where admin_name = '" . $this->username . "'");
		if ($result->RecordCount() == 0) {
			return $this->responseXML('11', SOAP_USER_NOT_FOUND, 'error');
		}
		if (!zen_validate_password($this->password, $result->fields['admin_pass'])) {
			return $this->responseXML('12', SOAP_PASSWORD_NOT_FOUND, 'error');
		}
		return true; // if both the username and password are correct
	}

	function responseXML($code, $text, $level) {
		$text = preg_replace('/&nbsp;/', '', $text); // the &nbsp; messes up the response XML
		$strResponse  = '<?xml version="1.0" encoding="UTF-8" ?>' . chr(10);
		$strResponse .= '<AccessResponse>' . chr(10);
		$strResponse .= '<AccessFunction>' . 'Response' . '</AccessFunction>' . chr(10);
		$strResponse .= '<Version>1.00</Version>' . chr(10);
		$strResponse .= '<ReferenceName>' . $this->product['reference_name'] . '</ReferenceName>' . chr(10);

		switch ($level) {
			case 'error':
			case 'caution':
			case 'success':
				$strResponse .= '<Result>' . $level . '</Result>' . chr(10);
				$strResponse .= '<ResultCode>' . $code . '</ResultCode>' . chr(10);
				$strResponse .= '<ResultText>' . $text . '</ResultText>' . chr(10);
				break;
			default:
				$strResponse .= '<Result>error</Result>' . chr(10);
				$strResponse .= '<ResultCode>' . $code . '</ResultCode>' . chr(10);
				$strResponse .= '<ResultText>' . SOAP_UNEXPECTED_ERROR . '</ResultText>' . chr(10);
		}

		$strResponse .= '</AccessResponse>';
		echo $strResponse;
		return false;
	}
}
?>