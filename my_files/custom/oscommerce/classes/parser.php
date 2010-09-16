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
//  Path: /my_files/custom/oscommerce/classes/parser.php
//

class parser {

	// class constructor
	function parser() {
	}

	function doCURLRequest($method = 'GET', $url, $vars) {
		global $messageStack;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10); // times out after 10 seconds 
		if (strtoupper($method) == 'POST') {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
		}
		if (CURL_PROXY_REQUIRED == 'True') {
			curl_setopt ($ch, CURLOPT_HTTPPROXYTUNNEL, true);
			curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
			curl_setopt ($ch, CURLOPT_PROXY, CURL_PROXY_SERVER_DETAILS);
		}
		$data = curl_exec($ch);
		$error = curl_error($ch);
		curl_close($ch);
		if ($data != '') {
			return $data;
		} else {
			$messageStack->add('cURL error: ' . $error, 'error');
			return false; 
		}
	}

	function parse($strInputXML) {
		global $messageStack;
		$this->resParser = xml_parser_create ();
		xml_set_object($this->resParser, $this);
		xml_set_element_handler($this->resParser, "tagOpen", "tagClosed");
		xml_set_character_data_handler($this->resParser, "tagData");

		$this->strXmlData = xml_parse($this->resParser, $strInputXML);
		if(!$this->strXmlData) {
		    $strText = 'PhreeBooks osCommerce XML parse error: ' . xml_error_string(xml_get_error_code($this->resParser)) . ' at line ' . xml_get_current_line_number($this->resParser);
			$messageStack->add($strText, 'error');
//			$messageStack->add($strInputXML, 'error');
			return false;
		}
		xml_parser_free($this->resParser);
		return $this->arrOutput;
	}

	function tagOpen($parser, $name, $attrs) {
		$tag=array("name"=>$name,"attrs"=>$attrs); 
		array_push($this->arrOutput,$tag);
	}

	function tagData($parser, $tagData) {
		if (trim($tagData) <> '') {
			if (isset($this->arrOutput[count($this->arrOutput)-1]['tagData'])) {
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
		// will return false if tree path is invalid or is not found; node value (including null) if found.
		$node_data = false;
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

	function constructXMLString($xml_array) {
		$output = NULL;
		if (is_array($xml_array) && sizeof($xml_array) > 0) {
			foreach ($xml_array as $key => $value) {
				$output .= '<' . urlencode($key) . '>';
				if (is_array($value) && sizeof($value) > 0) {
					$output .= $this->constructXMLString($value);
				} else {
					$output .= urlencode($value);
				}
				$output .= '</' . urlencode($key) . '>' . chr(10);
			}
		}
		return $output;
	}

}
?>