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
//  Path: /soap/classes/parser.php
//

class xml2Array {
   
	function parse($strInputXML) {
		// some clean-up for the parser
		$strInputXML = str_replace('&', '&amp;', $strInputXML);

		$this->resParser = xml_parser_create( "UTF-8" );
		xml_set_object($this->resParser, $this);
		xml_set_element_handler($this->resParser, "tagOpen", "tagClosed");
		xml_set_character_data_handler($this->resParser, "tagData");

		$this->strXmlData = xml_parse($this->resParser, $strInputXML);
		if(!$this->strXmlData) {
		    $strText = 'PhreeBooks XML parse error: ' . xml_error_string(xml_get_error_code($this->resParser)) . ' at line ' . xml_get_current_line_number($this->resParser);
			return $this->responseXML('04', $strText, 'error');
		}
		xml_parser_free($this->resParser);
		return true;
	}

	function tagOpen($parser, $name, $attrs) {
		$tag = array("name" => $name,"attrs" => $attrs); 
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

	function validateUser($username = '', $password = '') {
		global $db;

		if (!$username || !$password) {
			return $this->responseXML('10', SOAP_NO_USER_PW, 'error');
		}
		// This portion is specific to the application database name, fields and password validation methods
		// validate user with db (call validation function)
		$result = $db->Execute("select admin_pass from " . TABLE_USERS . " where admin_name = '" . $username . "'");
		if ($result->RecordCount() == 0) {
			return $this->responseXML('11', SOAP_USER_NOT_FOUND, 'error');
		}
		if (!pw_validate_password($password, $result->fields['admin_pass'])) {
			return $this->responseXML('12', SOAP_PASSWORD_NOT_FOUND, 'error');
		}
		return true; // if both the username and password are correct
	}

	function responseXML($code, $text, $level) {
		$strResponse = '';
		$strResponse .= '<?xml version="1.0" encoding="UTF-8" ?>' . chr(10);
		$strResponse .= '<AccessResponse>' . chr(10);
		$strResponse .= '<AccessFunction>SalesOrderEntry</AccessFunction>' . chr(10);
		$strResponse .= '<Version>1.00</Version>' . chr(10);
		$strResponse .= '<ReferenceName>' . $this->product['reference_name'] . '</ReferenceName>' . chr(10);

		switch ($level) {
			case 'error':
				$strResponse .= '<Result>error</Result>' . chr(10);
				$strResponse .= '<ResultCode>' . $code . '</ResultCode>' . chr(10);
				$strResponse .= '<ResultText>' . $text . '</ResultText>' . chr(10);
				break;
			case 'success':
				$strResponse .= '<Result>success</Result>' . chr(10);
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

	function get_account_id($short_name, $type = '') {
		global $db;
		$result = $db->Execute("select id from " . TABLE_CONTACTS . " 
			where short_name = '" . $short_name . "' and type = '" . $type . "'");
		return ($result->RecordCount() == 0) ? 0 : $result->fields['id'];
	}

	function get_user_id($admin_name) {
		global $db;
		$result = $db->Execute("select admin_id from " . TABLE_USERS . " where admin_name = '" . $admin_name . "'");
		return ($result->RecordCount() == 0) ? false : $result->fields['admin_id'];
	}

	function float($str) {
		if(strstr($str, ",")) {
			$str = str_replace(".", "", $str); // replace dots (thousand seps) with blancs
			$str = str_replace(",", ".", $str); // replace ',' with '.'
		}
		if (preg_match("#([0-9\.]+)#", $str, $match)) { // search for number that may contain '.'
			return floatval($match[0]);
		} else {
			return floatval($str); // take some last chances with floatval
		}
	}

	function best_guess_country($country) { // defaults to COMPANY_COUNTRY if blank or not found
		global $db;
		$country = trim($country);
		if (strlen($country) == 0) return COMPANY_COUNTRY;  
		$result = $db->Execute("select countries_name, countries_iso_code_3 from " . TABLE_COUNTRIES . " where countries_name like '%" . $country . "%'");
		if (!$result->RecordCount()) return COMPANY_COUNTRY;
		while (!$result->EOF) {
			if ($result->fields['countries_name'] == $country) return $result->fields['countries_iso_code_3'];
			$result->MoveNext();
		}
		return COMPANY_COUNTRY;
	}

	function best_guess_zone($zone, $country = COMPANY_COUNTRY) { // Country needs to be ISO3
		global $db;
		$zone = trim($zone);
		$result = $db->Execute("select zone_code, zone_name from " . TABLE_ZONES . " 
			where countries_iso_code_3 = '" . $country . "' and (zone_name like '%" . $zone . "%' or zone_code = '" . $zone . "')");
		if ($result->RecordCount() == 0) return $zone;
		if ($result->RecordCount() == 1) return $result->fields['zone_code'];
		while (!$result->EOF) {
			if ($result->fields['zone_code'] == $zone) return $result->fields['zone_code'];
			if ($result->fields['zone_name'] == $zone) return $result->fields['zone_code'];
			$result->MoveNext();
		}
		return $zone;
	}

}
?>