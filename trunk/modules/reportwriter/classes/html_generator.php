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
//  Path: /modules/reportwriter/classes/html_generator.php
//

class HTML {

  function HTML() {
	$this->output    = NULL;
	$this->FillColor = '224:235:255';
	$this->HdColor   = '#CCCCCC';
  }

  function AddHeading() {
	global $Prefs, $Heading, $Seq;
	// determine the number of columns and build heading
	foreach ($Seq as $Temp) $ColBreak[] = ($Temp['break']) ? true : false;
	$html_heading = array();
	$data = NULL;
	foreach ($Heading as $key => $value) {
	  $data .= htmlspecialchars($value);
	  if (!$ColBreak[$key]) { 
		$data .= '<br />';
		continue;
	  }
	  $html_heading[] = array('align' => $align, 'value' => $data);
	  $data = NULL;
	}
	if ($data !== NULL) { // catches not checked column break at end of row
	  $html_heading[] = array('align' => $align, 'value' => $data);
	}
	$this->numColumns = sizeof($html_heading);

	$rStyle = '';
	if ($Prefs['coynameshow']) { // Show the company name
	  $color  = $this->convert_hex($Prefs['coynamefontcolor']);
	  $dStyle = 'style="font-family:' . $Prefs['coynamefont'] . '; color:' . $color . '; font-size:' . $Prefs['coynamefontsize'] . 'pt; font-weight:bold;"';
	  $this->writeRow(array(array('align' => $Prefs['coynamealign'], 'value' => htmlspecialchars(COMPANY_NAME))), $rStyle, $dStyle, $heading = true);
	}
	if ($Prefs['title1show']) { // Set title 1 heading
	  $color  = $this->convert_hex($Prefs['title1fontcolor']);
	  $dStyle = 'style="font-family:' . $Prefs['title1font'] . '; color:' . $color . '; font-size:' . $Prefs['title1fontsize'] . 'pt;"';
	  $this->writeRow(array(array('align' => $Prefs['title1fontalign'], 'value' => htmlspecialchars(TextReplace($Prefs['title1desc'])))), $rStyle, $dStyle, $heading = true);
	}
	if ($Prefs['title2show']) { // Set Title 2 heading
	  $color  = $this->convert_hex($Prefs['title2fontcolor']);
	  $dStyle = 'style="font-family:' . $Prefs['title2font'] . '; color:' . $color . '; font-size:' . $Prefs['title2fontsize'] . 'pt;"';
	  $this->writeRow(array(array('align' => $Prefs['title2fontalign'], 'value' => htmlspecialchars(TextReplace($Prefs['title2desc'])))), $rStyle, $dStyle, $heading = true);
	}
	// Set the filter heading
	$color  = $this->convert_hex($Prefs['filterfontcolor']);
	$dStyle = 'style="font-family:' . $Prefs['filterfont'] . '; color:' . $color . '; font-size:' . $Prefs['filterfontsize'] . 'pt;"';
	$this->writeRow(array(array('align' => $Prefs['filterfontalign'], 'value' => htmlspecialchars(TextReplace($Prefs['filterdesc'])))), $rStyle, $dStyle, $heading = true);
	// Set the table header
	$color  = $this->convert_hex($Prefs['datafontcolor']);
    $rStyle = 'style="background-color:' . $this->HdColor . '"';
	$dStyle = 'style="font-family:' . $Prefs['datafont'] . '; color:' . $color . '; font-size:' . $Prefs['datafontsize'] . 'pt;"';
	$align  = $Prefs['datafontalign'];

	// Ready to draw the column titles in the header
	$this->writeRow($html_heading, $rStyle, $dStyle);
  }

  function writeRow($aData, $rStyle = '', $dStyle = '', $heading = false) {
	$output  = '  <tr';
	$output .= (!$rStyle ? '' : ' ' . $rStyle) . '>' . chr(10);
	foreach ($aData as $value) {
	  $params = NULL;
	  if ($heading) $params .= ' colspan="' . $this->numColumns . '"';
	  $output .= '    <td';
	  switch ($value['align']) {
	    case 'C': $params .= ' align="center"'; break;
	    case 'R': $params .= ' align="right"';  break;
	    default:
	    case 'L':
	      break;
	  }
	  $output .= $params . (!$dStyle ? '' : ' ' . $dStyle) . '>';
	  $output .= ($value['value'] == '') ? '&nbsp;' : $value['value'];
	  $output .= '</td>' . chr(10);
	}
	$output .= '  </tr>' . chr(10);
	$this->output .= $output;
  }

  function ReportTable($Data) {
	global $Prefs, $Seq;
	$this->output .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . chr(10);
	$this->output .= '<html xmlns="http://www.w3.org/1999/xhtml" ' . HTML_PARAMS . '>' . chr(10);
 	$this->output .= '<head>' . chr(10);
  	$this->output .= '<meta http-equiv="Content-Type" content="text/html; charset=' . CHARSET . '" />' . chr(10);
  	$this->output .= '<title>' . $this->title . '</title>' . chr(10);
  	$this->output .= '</head>' . chr(10);
  	$this->output .= '<body>' . chr(10);
  	$this->output .= '<table width="95%" align="center">' . chr(10);
	$this->AddHeading();

	$color = $this->convert_hex($this->FillColor);
	$bgStyle = 'style="background-color:' . $color . '"';

	$color  = str_replace(':', '', $Prefs['datafontcolor']);
	$dStyle = 'style="font-family:' . $Prefs['datafont'] . '; color:' . $color . '; font-size:' . $Prefs['datafontsize'] . 'pt;"';
	// Fetch the column break array and alignment array
	foreach ($Seq as $Temp) {
		$ColBreak[] = ($Temp['break']) ? true : false;
		$align[]    = $Temp['align'];
	}
	// Ready to draw the column data
	$fill           = false;
	$NeedTop        = 'No';
	foreach ($Data as $myrow) {
	  $Action = array_shift($myrow);
	  $todo = explode(':', $Action); // contains a letter of the date type and title/groupname
	  switch ($todo[0]) {
		case "h": // Heading
 		  $this->writeRow(array(array('align' => $Prefs['datafontalign'], 'value' => $todo[1])), '', $dStyle);
		  break;
		case "r": // Report Total
		case "g": // Group Total
		  $Desc  = ($todo[0] == 'g') ? RW_TEXT_GROUP_TOTAL_FOR : RW_TEXT_REPORT_TOTAL_FOR;
   		  $rStyle = 'style="background-color:' . $this->HdColor . '"';
 		  $this->writeRow(array(array('align' => $Prefs['datafontalign'], 'value' => $Desc . $todo[1])), $rStyle, $dStyle);
		  // now fall into the 'd' case to show the data
		  $fill = false;
		case "d": // data element
		default:
		  $temp = array();
		  $data = NULL;
		  foreach ($myrow as $key => $value) {
			$data .= htmlspecialchars($value);
			if (!$ColBreak[$key]) { 
			  $data .= '<br />';
			  continue;
			}
			$temp[] = array('align' => $align[$key], 'value' => $data);
			$data = NULL;
		  }
		  if ($data !== NULL) { // catches not checked column break at end of row
			$temp[] = array('align' => $align[$key], 'value' => $data);
		  }
		  $rStyle = $fill ? $bgStyle : '';
 		  $this->writeRow($temp, $rStyle, $dStyle);
		  break;
	  }
	  $fill = !$fill;
	}
	// send a blank header row
   	$rStyle = 'style="background-color:' . $this->HdColor . '"';
 	$this->writeRow(array(array('align' => '', 'value' => '&nbsp;')), $rStyle, '', $heading = true);

  	$this->output .= '</table>' . chr(10);
  	$this->output .= '</body>'  . chr(10);
  	$this->output .= '</html>'  . chr(10);
  }

  function convert_hex($value) {
    $colors = explode(':', $value);
	$output = NULL;
	foreach ($colors as $decimal) {
	  $output .= str_pad(dechex($decimal), 2, "0", STR_PAD_LEFT);
	}
	return '#' . $output;
  }
} // end class
?>