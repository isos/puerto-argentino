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
//  Path: /modules/services/shipping/functions/shipping.php
//

function load_shipping_module_list() {
  $directory_array = array();
  if ($dir = @dir(DEFAULT_MOD_DIR)) {
    while ($file = $dir->read()) {
      if (!is_dir(DEFAULT_MOD_DIR . $file)) {
        if (substr($file, strrpos($file, '.')) == '.php') {
		  $module_name = strtoupper(substr($file, 0, strrpos($file, '.')));
		  if (defined('MODULE_SHIPPING_' . $module_name . '_STATUS')) { // see if module installed
		  	if (constant('MODULE_SHIPPING_' . $module_name . '_STATUS') == 'True') { // see if enabled
				$check_box = true;
			} else {
				$check_box = false;
			}
            $directory_array[] = array('id' => strtolower($module_name), 'text' => constant('MODULE_SHIPPING_' . $module_name . '_TITLE'), 'checked' => $check_box);
		  }
        }
      }
    }
    $dir->close();
  }
  if ($dir = @dir(CUSTOM_MOD_DIR)) {
    while ($file = $dir->read()) {
      if (!is_dir(CUSTOM_MOD_DIR . $file)) {
        if (substr($file, strrpos($file, '.')) == '.php') {
		  $module_name = strtoupper(substr($file, 0, strrpos($file, '.')));
		  if (defined('MODULE_SHIPPING_' . $module_name . '_STATUS')) { // see if module installed
		  	if (constant('MODULE_SHIPPING_' . $module_name . '_STATUS') == 'True') { // see if enabled
				$check_box = true;
			} else {
				$check_box = false;
			}
            $directory_array[] = array('id' => strtolower($module_name), 'text' => constant('MODULE_SHIPPING_' . $module_name . '_TITLE'), 'checked' => $check_box);
		  }
        }
      }
    }
    $dir->close();
  }
  sort($directory_array);
  return $directory_array;
}

function strip_alphanumeric($value) {
  return preg_replace("/[^a-zA-Z0-9\s]/", "", $value);
}

function remove_special_chars($value) {
  $value = str_replace('&', '-', $value);
  return $value;
}

// ******************************************************************************************************************
//								XML REQUEST/GENERIC PARSER FUNCTIONS
// ******************************************************************************************************************
function GetXMLString($y, $SubmitURL, $GetPost) {
	global $cURLpath;
	$ch = curl_init(); /// initialize a cURL session 
	curl_setopt($ch, CURLOPT_URL,$SubmitURL); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10); // times out after 10 seconds 
	curl_setopt($ch, CURLOPT_HEADER, 0); 
	if ($GetPost=="POST") { curl_setopt($ch, CURLOPT_POST, 1); }	
	curl_setopt($ch, CURLOPT_POSTFIELDS, "$y"); 
	$xyz = curl_exec($ch); 
	// Check for errors
	$curlerrornum = curl_errno($ch);
	$curlerror = curl_error($ch);
	if ($curlerrornum) { 
		$UPSQuote['result'] = 'error';
		$UPSQuote['message'] = 'XML Read Error (cURL) #'.$curlerrornum.'. Description='.$curlerror.'.<br />';
	} else {
		$UPSQuote['result'] = 'success';
		$UPSQuote['xmlString'] = $xyz;
	}
	curl_close ($ch);
	return $UPSQuote;
}

function GetNodeData($SearchXML, $XMLPath) {
	$ParseTree = explode(":",$XMLPath);

	for ($i=0; $i<count($ParseTree); $i++) {
		$TagFound = strpos(strtolower($SearchXML),'<'.strtolower($ParseTree[$i]).'>');
		if ($TagFound) { $SearchXML = substr($SearchXML, $TagFound);
		} else {
			return false;	// branch not found
		}
	}
	$SearchXML = substr($SearchXML, strpos($SearchXML,">"));		// locate the end of the last tag
	$SearchXML = substr($SearchXML, 1, strpos($SearchXML,"<")-1);	// locate the end of the value we seek
	return $SearchXML;
}

function GetNodeArray($SearchXML, $XMLStart, $XMLIndexName, $TagsToFind) {
	$ParseTree = explode(":", $XMLStart);
	$arrXML = false;
	$StartTag = strpos(strtolower($SearchXML), '<' . strtolower($ParseTree[count($ParseTree)-1]) . '>');
	while ($StartTag) { 
		$EndTag = strpos(strtolower($SearchXML), '</' . strtolower($ParseTree[count($ParseTree)-1]) . '>');
		$tempXML = substr($SearchXML, $StartTag, $EndTag - $StartTag);	// Work with just the beginning instance
		if ($XMLIndexName == "") {	// Its a single dimension array
			if ($TagsToFind == "") {	// Look no further, just get the tag data
				$arrXML[] = $tempXML;
			} else {
				foreach ($TagsToFind as $key => $value)  {
					if ($key == 'index') { $arrXML[] = GetNodeData($tempXML, $value); }
					else { $arrXML[$key] = GetNodeData($tempXML, $value); }
				}
			}
		} else {	// its two dimensional
			$Index = GetNodeData($tempXML, $XMLIndexName);
			foreach ($TagsToFind as $key => $value) $arrXML[$Index][$key] = GetNodeData($tempXML, $value);
		}
		$SearchXML = substr($SearchXML, $EndTag + strlen('</' . strtolower($ParseTree[count($ParseTree)-1]) . '>') - 1);	// Trim the first instance to see if there are more
		$StartTag = strpos(strtolower($SearchXML), '<' . strtolower($ParseTree[count($ParseTree)-1]) . '>');
	}
	return $arrXML;
}

function GetPackageArray($SearchXML, $Container, $TagsToFind) {
	$arrXML = false;
	$Container = strtolower($Container);
	$StartTag = strpos(strtolower($SearchXML), '<' . $Container . '>');
	while ($StartTag) { 
		$EndTag = strpos(strtolower($SearchXML), '</' . $Container . '>');
		$tempXML = substr($SearchXML, $StartTag, $EndTag - $StartTag);	// Work with just the beginning instance
		$tagArray = array();
		foreach ($TagsToFind as $key => $value) {
			$tagArray[$key] = GetNodeData($tempXML, $value);
		}
		$arrXML[] = $tagArray;
		$SearchXML = substr($SearchXML, $EndTag + strlen('</' . $Container . '>') - 1);	// Trim the first instance to see if there are more
		$StartTag = strpos(strtolower($SearchXML), '<' . $Container . '>');
	}
	return $arrXML;
}

?>