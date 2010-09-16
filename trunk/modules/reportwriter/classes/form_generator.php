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
//  Path: /modules/reportwriter/classes/form_generator.php
//

if (PDF_APP == 'FPDF') { 
  require_once (DIR_FS_ADDONS . 'fpdf/fpdf.php'); // FPDF class to generate reports
} else {
  define ("K_PATH_MAIN", DIR_FS_ADDONS . "tcpdf/");
  define ("K_PATH_URL",  DIR_WS_FULL_PATH . "includes/addons/tcpdf/");
  require_once (DIR_FS_ADDONS . 'tcpdf/tcpdf.php'); // TCPDF class to generate reports, default
}

class PDF extends TCPDF {

	var $y0;             // current y position
	var $x0;             // current x position
	var $pageY;          // y value of bottom of page less bottom margin
	var $PageCnt;        // tracks the page count for correct page numbering for multipage and multiform printouts
    var $NewPageGroup;   // variable indicating whether a new group was requested
    var $PageGroups;     // variable containing the number of pages of the groups
    var $CurrPageGroup;  // variable containing the alias of the current page group

	function PDF() {
		global $Prefs;
		define('RowSpace', 2); // define separation between the heading rows
		$PaperSize = explode(':', $Prefs['papersize']);
		if (PDF_APP == 'FPDF') {
			$this->FPDF($Prefs['paperorientation'], 'mm', $PaperSize[0]);
		} else {
			parent::__construct($Prefs['paperorientation'], 'mm', $PaperSize[0], true, 'UTF-8', false); 
			$this->SetCellPadding(0);
		}
		if ($Prefs['paperorientation'] == 'P') { // Portrait - calculate max page height
			$this->pageY = $PaperSize[2] - $Prefs['marginbottom'];
		} else { // Landscape
			$this->pageY = $PaperSize[1] - $Prefs['marginbottom'];
		}
		$this->SetMargins($Prefs['marginleft'], $Prefs['margintop'], $Prefs['marginright']);
		$this->SetAutoPageBreak(0, $Prefs['marginbottom']);
		$this->SetFont(PDF_DEFAULT_FONT);
		$this->SetDrawColor(128, 0, 0);
		$this->SetLineWidth(0.35); // 1 point
		$this->AliasNbPages();
	}
	
	function Header() { // prints all static information on the page
		global $FieldListings, $FieldValues;
		$tempValues = $FieldValues;
		foreach ($FieldListings as $key => $SingleObject) {
			switch ($SingleObject['params']['index']) {
				case "Data": 
					$SingleObject['params']['TextField'] = array_shift($tempValues); // fill the data to display
					// some special processing if display on first or last page only
					$FieldListings[$key]['params']['TextTemp']  = $SingleObject['params']['TextField'];
					if (($this->PageNo() <> 1 && $SingleObject['params']['LastOnly'] == 1) || $SingleObject['params']['LastOnly'] == 2) {
						$SingleObject['params']['TextField'] = '';
					}
				case "TBlk": // same operation as page number 
				case "Text": 
				case "CDta": 
				case "CBlk": 
				case "PgNum": 
					$this->FormText($SingleObject['params']); 
					break;
				case "Img": 
					$this->FormImage($SingleObject['params']); 
					break;
				case "Line": 
					$this->FormLine($SingleObject['params']); 
					break;
				case "Rect": 
					$this->FormRect($SingleObject['params']); 
					break;
				case "BarCode": 
					$SingleObject['params']['TextField'] = array_shift($tempValues); // fill the data to display
					$this->FormBarCode($SingleObject['params']); 
					break;
				default: // do nothing
			}
		}
	}

	function Footer() { // Prints totals at end of last page
		global $FieldListings;
		foreach ($FieldListings as $SingleObject) {
			if ($SingleObject['params']['index'] == 'Ttl') $this->FormText($SingleObject['params']);
			if ($SingleObject['params']['index'] == 'Data' && $SingleObject['params']['LastOnly'] == '2') {
				$this->FormText($SingleObject['params']);
			}
		}
	}

    function StartPageGroup() { // create a new page group; call this before calling AddPage()
        $this->NewPageGroup = true;
    }

    function GroupPageNo() { // current page in the group
        return $this->PageGroups[$this->CurrPageGroup];
    }

    function PageGroupAlias() { // alias of the current page group -- will be replaced by the total number of pages in this group
        return $this->CurrPageGroup;
    }

    function _beginpage($orientation, $format) {
        parent::_beginpage($orientation, $format);
        if ($this->NewPageGroup) {
            // start a new group
            $n = sizeof($this->PageGroups)+1;
            $alias = "{nb$n}";
            $this->PageGroups[$alias] = 1;
            $this->CurrPageGroup = $alias;
            $this->NewPageGroup = false;
        }
        elseif ($this->CurrPageGroup) {
            $this->PageGroups[$this->CurrPageGroup]++;
		}
    }

    function _putpages() {
		$nb = $this->page;
		if (!empty($this->PageGroups)) { // do page number replacement
			foreach ($this->PageGroups as $k => $v) {
				for ($n = 1; $n <= $nb; $n++) $this->pages[$n] = str_replace($k, $v, $this->pages[$n]);
			}
		}
		parent::_putpages();
	}

	function FormImage($Params) {
		if (is_file(DIR_FS_MY_FILES . $_SESSION['company'] . '/images/' . $Params['filename'])) {
			$this->Image(DIR_FS_MY_FILES . $_SESSION['company'] . '/images/' . $Params['filename'], $Params['LineXStrt'], $Params['LineYStrt'], $Params['BoxWidth'], $Params['BoxHeight']);
		} else { // no image was found at the specified path, draw a box
			// check for any data entered
			if (!isset($Params['LineXStrt'])) { // then no information was entered for this entry, set some defaults
				$Params['LineXStrt'] = '10';
				$Params['LineYStrt'] = '10';
				$Params['BoxWidth']  = '50';
				$Params['BoxHeight'] = '20';
			}
			$this->SetXY($Params['LineXStrt'], $Params['LineYStrt']);
			$this->SetFont(PDF_DEFAULT_FONT, '', '10');
			$this->SetTextColor(255, 0, 0);
			$this->SetDrawColor(255, 0, 0);
			$this->SetLineWidth(0.35);
			$this->SetFillColor(255);
			$this->Cell($Params['BoxWidth'], $Params['BoxHeight'], RW_FRM_NOIMAGE, 1, 0, 'C');
		}
	}

	function FormLine($Params) {
		if (!isset($Params['LineXStrt'])) return;	// don't do anything if data array has not been set
		if ($Params['Line'] == '2') $RGB = $Params['BrdrRed'] . ':' . $Params['BrdrGreen'] . ':' . $Params['BrdrBlue'];
			else $RGB = $Params['BrdrColor'];
		$FC = explode(':', $RGB);
		$this->SetDrawColor($FC[0], $FC[1], $FC[2]);
		$this->SetLineWidth($Params['LineSize'] * 0.35);
		if ($Params['LineType'] == '1') { // Horizontal
			$XEnd = $Params['LineXStrt'] + $Params['HLength'];
			$YEnd = $Params['LineYStrt'];
		} elseif ($Params['LineType'] == '2') { // Vertical
			$XEnd = $Params['LineXStrt'];
			$YEnd = $Params['LineYStrt'] + $Params['VLength'];
		}  elseif ($Params['LineType'] == '3') { // Custom
			$XEnd = $Params['LineXEnd'];
			$YEnd = $Params['LineYEnd'];
		} 
		$this->Line($Params['LineXStrt'], $Params['LineYStrt'], $XEnd, $YEnd);
	}

	function FormRect($Params) {
		if (!isset($Params['LineXStrt'])) return;	// don't do anything if data array has not been set
		$DrawFill = '';
		if ($Params['Line'] == '0') {  // No Border
			$this->SetDrawColor(255);
			$this->SetLineWidth(0);
		} else { 
			$DrawFill = 'D';
			if ($Params['Line'] == '2') $RGB = $Params['BrdrRed'] . ':' . $Params['BrdrGreen'] . ':' . $Params['BrdrBlue'];
				else $RGB = $Params['BrdrColor'];
			$FC = explode(':', $RGB);
			$this->SetDrawColor($FC[0], $FC[1], $FC[2]);
			$this->SetLineWidth($Params['LineSize'] * 0.35);
		}
		if ($Params['Fill'] == '0') {  // Set Fill Color
			$this->SetFillColor(255);
		} else {
			$DrawFill .= 'F';
			if ($Params['Fill'] == '2') $RGB = $Params['FillRed'] . ':' . $Params['FillGreen'] . ':' . $Params['FillBlue'];
				else $RGB = $Params['FillColor'];
			$FC = explode(':', $RGB);
			$this->SetFillColor($FC[0], $FC[1], $FC[2]);
		}
		$this->Rect($Params['LineXStrt'], $Params['LineYStrt'], $Params['BoxWidth'], $Params['BoxHeight'], $DrawFill);
	}

	function FormBarCode($Params) {
		if (!isset($Params['LineXStrt'])) return;	// don't do anything if data array has not been set
		if (PDF_APP  <> 'TCPDF') {  // need to use TCPDF to generate bar codes.
			$Params['TextField'] = 'Barcodes Require TCPDF';
			$this->FormText($Params);
			return;
		}
		$style = array();
		$style['position']    = 'L'; // center image in box area
		$style['border']      = $Params['Line'] ? true : false; // border around image
		$style['padding']     = 4; // in user units
		$style['text']        = true; // print text below barcode
		$style['font']        = $Params['Font'];
		$style['fontsize']    = $Params['FontSize'];
		$style['stretchtext'] = 1; // 0 = disabled; 1 = horizontal scaling only if necessary; 2 = forced horizontal scaling; 3 = character spacing only if necessary; 4 = forced character spacing

		switch ($Params['Color']) {
			default:
			case '0': $style['fgcolor'] = array(0, 0, 0); break;
			case '1': $style['fgcolor'] = explode(':', $Params['FontColor']); break;
			case '2': $style['fgcolor'] = array($Params['FontRed'], $Params['FontGreen'], $Params['FontBlue']); break;
		}
		switch ($Params['Fill']) {
			default:
			case '0': $style['bgcolor'] = false; break;
			case '1': $style['bgcolor'] = explode(':', $Params['FillColor']); break;
			case '2': $style['bgcolor'] = array($Params['FillRed'], $Params['FillGreen'], $Params['FillBlue']); break;
		}
		$this->write1DBarcode($Params['TextField'], $Params['BarCodeType'], $Params['LineXStrt'], $Params['LineYStrt'], $Params['BoxWidth'], $Params['BoxHeight'], 0.4, $style, 'N');
	}

	function FormText($Params) {
		if (!isset($Params['LineXStrt'])) return;	// don't do anything if data array has not been set
		$this->SetXY($Params['LineXStrt'], $Params['LineYStrt']);
		$this->SetFont($Params['Font'], '', $Params['FontSize']);
		if ($Params['Color'] == '2') $RGB = $Params['FontRed'] . ':' . $Params['FontGreen'] . ':' . $Params['FontBlue'];
			else $RGB = $Params['FontColor'];
		$FC = explode(':', $RGB);
		$this->SetTextColor($FC[0], $FC[1], $FC[2]);
		if ($Params['Line'] == '0') {  // No Border
			$Border = '0';
		} else { 
			$Border = '1';
			if ($Params['Line'] == '2') $RGB = $Params['BrdrRed'] . ':' . $Params['BrdrGreen'] . ':' . $Params['BrdrBlue'];
				else $RGB = $Params['BrdrColor'];
			$FC = explode(':', $RGB);
			$this->SetDrawColor($FC[0], $FC[1], $FC[2]);
			$this->SetLineWidth($Params['LineSize'] * 0.35);
		}
		if ($Params['Fill'] == '0') {  // No Fill
			$Fill = '0';
		} else { 
			$Fill = '1';
			if ($Params['Fill'] == '2') $RGB = $Params['FillRed'] . ':' . $Params['FillGreen'] . ':' . $Params['FillBlue'];
				else $RGB = $Params['FillColor'];
			$FC = explode(':', $RGB);
			$this->SetFillColor($FC[0], $FC[1], $FC[2]);
		}
		if ($Params['index'] <> 'PgNum') $TextField = $Params['TextField'];
//			else $TextField = ($this->PageNo() - $this->PageCnt) . ' ' . TEXT_OF . ' {nb}';
			else $TextField = $this->GroupPageNo() . ' ' . TEXT_OF . ' ' . $this->PageGroupAlias(); // fix for multi-page multi-group forms
		if (isset($Params['Processing'])) $TextField = ProcessData($TextField, $Params['Processing']);
		$this->MultiCell($Params['BoxWidth'], $Params['BoxHeight'], $TextField, $Border, $Params['FontAlign'], $Fill);
	}

	function FormTable($Params) {
		// set up some variables
		if ($Params['hFill'] == '2') $hRGB = $Params['hFillRed'] . ':' . $Params['hFillGreen'] . ':' . $Params['hFillBlue'];
			else $hRGB = $Params['hFillColor'];
		if ($Params['Fill'] == '2') $RGB = $Params['FillRed'] . ':' . $Params['FillGreen'] . ':' . $Params['FillBlue'];
			else $RGB = $Params['FillColor'];
		$FC  = explode(':', $RGB);
		$hFC = (!$hRGB) ? $FC : explode(':', $hRGB);
		$MaxBoxY = $Params['LineYStrt'] + $Params['BoxHeight']; // figure the max y position on page

		$FillThisRow = false;
		$MaxRowHt = 0; //track the tallest row to estimate page breaks
		$this->y0 = $Params['LineYStrt'];
		foreach ($Params['Data'] as $index => $myrow) {
			// See if we are at or near the end of the table box size
			if (($this->y0 + $MaxRowHt) > $MaxBoxY) { // need a new page
				$this->DrawTableLines($Params, $HeadingHt); // draw the box and lines around the table
				$this->AddPage();
				$this->y0 = $Params['LineYStrt'];
				$this->SetLeftMargin($Params['LineXStrt']);
				$this->SetXY($Params['LineXStrt'], $Params['LineYStrt']);
				$MaxRowHt  = $this->ShowTableRow($Params, $Params['Data'][0], true, $hFC, true); // new page heading
				$HeadingHt = $MaxRowHt;
			}
			$this->SetLeftMargin($Params['LineXStrt']);
			$this->SetXY($Params['LineXStrt'], $this->y0);
			// fill in the data
			if ($index == 0) { // its a heading line
				$MaxRowHt  = $this->ShowTableRow($Params, $myrow, true, $hFC, true);
				$HeadingHt = $MaxRowHt;
			} else {
				$MaxRowHt = $this->ShowTableRow($Params, $myrow, $FillThisRow, $FC, false);
			}
			$FillThisRow = !$FillThisRow;
		}
		$this->DrawTableLines($Params, $HeadingHt); // draw the box and lines around the table
	}

	function ShowTableRow($Params, $myrow, $FillThisRow, $FC, $Heading) {
		$MaxBoxY = $Params['LineYStrt'] + $Params['BoxHeight']; // figure the max y position on page
		$fillReq = $Heading ? $Params['hFill'] : $Params['Fill'];
		if ($FillThisRow && $fillReq) $this->SetFillColor($FC[0], $FC[1], $FC[2]); 
			else $this->SetFillColor(255);
		$this->Cell($Params['BoxWidth'], $MaxBoxY - $this->y0, '', 0, 0, 'L', 1);
		$maxY = $this->y0; // set to current top of row
		$Col = 0;
		$NextXPos = $Params['LineXStrt'];
		foreach ($myrow as $key => $value) {
			if ($Params['Seq'][$Col]['TblShow']) {
				$font  = ($Heading && $Params['hFont']      <> '') ? $Params['hFont']      : $Params['Seq'][$Col]['Font'];
				$size  = ($Heading && $Params['hFontSize']  <> '') ? $Params['hFontSize']  : $Params['Seq'][$Col]['FontSize'];
				$color = ($Heading && $Params['hFontColor'] <> '') ? $Params['hFontColor'] : $Params['Seq'][$Col]['FontColor'];
				$align = ($Heading && $Params['hFontAlign'] <> '') ? $Params['hFontAlign'] : $Params['Seq'][$Col]['FontAlign'];
				$this->SetLeftMargin($NextXPos);
				$this->SetXY($NextXPos, $this->y0);
				$this->SetFont($font, '', $size);
				$TC = explode(':', $color);
				$this->SetTextColor($TC[0], $TC[1], $TC[2]);
				$CellHeight = ($size + RowSpace) * 0.35;
//				if ($trunc) $value=$this->TruncData($value, $Params['Seq'][$Col]['TblColWidth']);
				// special code for heading and data
				if ($Heading) {
					if (!$Params['hFontAlign']) $align = 'C'; // for legacy Pre R1.6 center headings
					if ($align == 'A') $align = $Params['Seq'][$Col]['FontAlign']; // auto align
				} else {
					if (isset($Params['Seq'][$Col]['Processing'])) $value = ProcessData($value, $Params['Seq'][$Col]['Processing']);
				}
				$this->MultiCell($Params['Seq'][$Col]['TblColWidth'], $CellHeight, $value, 0, $align);
				if ($this->GetY() > $maxY) $maxY = $this->GetY();
				$NextXPos += $Params['Seq'][$Col]['TblColWidth'];
			}
			$Col++;
		}
		$ThisRowHt = $maxY - $this->y0; // seee how tall this row was
		if ($ThisRowHt > $MaxRowHt) $MaxRowHt = $ThisRowHt; // keep that largest row so far to track pagination
		$this->y0 = $maxY; // set y position to largest value for next row
		if ($Heading && $Params['hLine']) { // then it's the heading draw a line after if fill is set
			$this->Line($Params['LineXStrt'], $maxY, $Params['LineXStrt'] + $Params['BoxWidth'], $maxY);
			$this->y0 = $this->y0 + ($Params['hLineSize'] * 0.35);
		}
		return $MaxRowHt;
	}

	function DrawTableLines($Params, $HeadingHt) {
		if ($Params['hLine'] == '')     $Params['hLine']     = $Params['Line'];
		if ($Params['hLineSize'] == '') $Params['hLineSize'] = $Params['LineSize'];
		if ($Params['hLine'] == '2')    $hRGB = $Params['hBrdrRed'] . ':' . $Params['hBrdrGreen'] . ':' . $Params['hBrdrBlue'];
			else $hRGB = $Params['hBrdrColor'];
		if ($Params['Line'] == '2') $RGB = $Params['BrdrRed'] . ':' . $Params['BrdrGreen'] . ':' . $Params['BrdrBlue'];
			else $RGB = $Params['BrdrColor'];
		$DC  = explode(':', $RGB);
		$hDC = (!$hRGB) ? $DC : explode(':', $hRGB);
		$MaxBoxY = $Params['LineYStrt'] + $Params['BoxHeight']; // figure the max y position on page

		// draw the heading 
		$this->SetDrawColor($hDC[0], $hDC[1], $hDC[2]);
		$this->SetLineWidth($Params['hLineSize'] * 0.35);
		if ($Params['hLine'] <> '0') {
		  $this->Rect($Params['LineXStrt'], $Params['LineYStrt'], $Params['BoxWidth'], $HeadingHt);
			$NextXPos = $Params['LineXStrt'];
			foreach ($Params['Seq'] as $index => $value) { // Draw the vertical lines
				$this->Line($NextXPos, $Params['LineYStrt'], $NextXPos, $Params['LineYStrt'] + $HeadingHt);
				$NextXPos += $value['TblColWidth'];
			}
		}

		// draw the table lines
		$this->SetDrawColor($DC[0], $DC[1], $DC[2]);
		$this->SetLineWidth($Params['LineSize'] * 0.35);
		// Fill the remaining part of the table with white
		if ($this->y0 < $MaxBoxY) {
			$this->SetLeftMargin($Params['LineXStrt']);
			$this->SetXY($Params['LineXStrt'], $this->y0);
			$this->SetFillColor(255);
			$this->Cell($Params['BoxWidth'], $MaxBoxY - $this->y0, '', 0, 0, 'L', 1);
		}
		if ($Params['Line'] <> '0') {
			$this->Rect($Params['LineXStrt'], $Params['LineYStrt'] + $HeadingHt, $Params['BoxWidth'], $Params['BoxHeight'] - $HeadingHt);
			$NextXPos = $Params['LineXStrt'];
			foreach ($Params['Seq'] as $index => $value) { // Draw the vertical lines
				$this->Line($NextXPos, $Params['LineYStrt'] + $HeadingHt, $NextXPos, $Params['LineYStrt'] + $Params['BoxHeight']);
				$NextXPos += $value['TblColWidth'];
			}
		}
		return;
	}

	function TruncData($strData, $ColWidth) {
		$percent = 0.90; //percent to truncate from max to account for proportional spacing
		$CurWidth = $this->GetStringWidth($strData);
		if ($CurWidth > ($ColWidth * $percent)) { // then it needs to be truncated
			// for now we'll do an approximation based on averages and scale to 90% of the width to allow for variance
			// A better aproach would be an recursive call to this function until the string just fits.
			$NumChars = strlen($strData);
			// Reduce the string by 1-$percent and retest
			$strData = $this->TruncData(substr($strData, 0, ($ColWidth / $CurWidth) * $NumChars * $percent), $ColWidth);
		}
		return $strData;
	}

} // end class
?>