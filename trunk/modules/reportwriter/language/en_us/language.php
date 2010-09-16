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
//  Path: /modules/reportwriter/language/en_us/language.php
// 

define('RW_FONT_HELVETICA','helvetica');
define('RW_FONT_COURIER','Courier');
define('RW_FONT_TIMES','Times Roman');
define('RW_FONT_SERIF','Serif');

if (!defined('PDF_APP')) define('PDF_APP','TCPDF'); // possible choices are FPDF and TCPDF 
$Fonts = array (
  'helvetica' => RW_FONT_HELVETICA,
  'courier'   => RW_FONT_COURIER,
  'times'     => RW_FONT_TIMES,
);
if (PDF_APP == 'TCPDF') {
  $Fonts['freeserif'] = RW_FONT_SERIF;
  define('PDF_DEFAULT_FONT','freeserif');
} else {
  define('PDF_DEFAULT_FONT','helvetica');
}

// Reportwriter Defaults
define('RW_DEFAULT_COLUMN_WIDTH','25'); // in millimeters
define('RW_DEFAULT_MARGIN','8'); // in millimeters
define('RW_DEFAULT_TITLE1', '%reportname%');
define('RW_DEFAULT_TITLE2', 'Report Generated %date%');
define('RW_DEFAULT_PAPERSIZE', 'Letter:216:282'); // must match id from array $PaperSizes defined below
define('RW_DEFAULT_ORIENTATION', 'P');

// **************  Release 2.0 changes  ********************
define('RW_FRM_RNDDECIMAL','Round Decimal Places');
define('RW_FRM_RNDPRECISE','Round Precision');
define('RW_SERIAL_FORM','Make this a sequential form (primarily used for receipt printers and line printers). Page properties will be limited as output is based on the sequence of the field list. If unsure, leave this box unchecked.');

// **************  Release 1.9 changes  ********************
define('RW_FRM_SET_PRINTED','Set Printed Flag');
define('RW_FRM_SET_PRINTED_NOTE','Sets the field selected to 1 after each form has been generated. The field must be in the same table as the form page break field.');
define('TEXT_CC_NAME','CC:');
define('RW_TEXT_DISPLAY_ON','Display On:');
define('RW_TEXT_ALL_PAGES','All Pages');
define('RW_TEXT_FIRST_PAGE','First Page');
define('RW_TEXT_LAST_PAGE','Last Page');
define('RW_TEXT_TOTAL_ONLY','Show Totals Only');
define('TEXT_DUPLICATE','Duplicate');
define('RW_FRM_PRINTED','Printed Indicator');

// **************  Release 1.8 changes  ********************
define('RW_FRM_PAGE_BREAK','Form Page Break Field (table.fieldname)');
define('RW_RPT_PAGE_BREAK','Group Page Break');
define('RW_NULL_PCUR','Null 0 - Posted Currency');
define('RW_DEF_CUR','Default Currency');
define('RW_NULL_DCUR','Null 0 - Default Currency');
define('RW_EMAIL_MSG_DETAIL','E-mail Message Body Text');

// **************  Release 1.7 changes  ********************
define('RW_BAR_CODE','Bar Code Image');
define('RW_TEXT_GROUP_TOTAL_FOR','Group Total For: ');
define('RW_TEXT_REPORT_TOTAL_FOR','Report Total For: ');
define('RW_FRM_YES_SKIP_NO','Yes, blank No');
define('RW_TEXT_PURCHASES','Purchases');

// Headings
define('RW_HEADING_TITLE','Reports and Forms');

// Report and Form page title definitions
define('RW_TITLE_RPTFRM','Report/Form: ');
define('RW_TITLE_RPRBLDR','Report and Form Builder - ');
define('RW_TITLE_REPORT_GEN','Report Generator');
define('RW_TITLE_STEP1','Menu');
define('RW_TITLE_STEP2','Step 2');
define('RW_TITLE_STEP3','Step 3');
define('RW_TITLE_STEP4','Step 4');
define('RW_TITLE_STEP5','Step 5');
define('RW_TITLE_STEP6','Step 6');
define('RW_TITLE_MENU','Reports Menu');
define('RW_TITLE_CRITERIA','Criteria Setup');
define('RW_TITLE_PAGESAVE','Save Report');
define('RW_TITLE_PAGESETUP','Report Page Setup');
define('RW_TITLE_SECURITY','Security Settings');

// Javascript messages
define('RW_JS_SELECT_REPORT','Please select a report or form!');
define('RW_JS_ENTER_EXPORT_NAME','Enter a name for this definition');
define('RW_JS_ENTER_DESCRIPTION','Enter a description for this definition');

// General 
define('TEXT_AUTO_ALIGN','Auto Align');
define('TEXT_CONTINUED','Continued');
define('TEXT_PAGE_SETUP','Page Setup');
define('TEXT_DB_LINKS','Database Relationships');
define('TEXT_FIELD_SETUP','Field Setup');
define('TEXT_CRITERIA','Filter Criteria');
define('GL_CURRENT_PERIOD','Current Period');
define('TEXT_USE_ACCOUNTING_PERIODS','Use Accounting Periods (field: period)');
define('TEXT_ALL_USERS','Allow All Users');
define('TEXT_ALL_EMPLOYEES','Allow All Employees');
define('TEXT_ALL_DEPTS','Allow All Departments');
define('TEXT_FORM_FIELD','Form Field: ');
define('RW_NARRATIVE_DETAIL','Detailed Description (255 characters maximum)');
define('RW_FORM_DELIVERY_METHOD','Form Delivery Method');
define('RW_RPT_DELIVERY_METHOD','Report Delivery Method');
define('RW_BROWSER','Browser: ');
define('RW_DOWNLOAD','Download: ');
define('RW_DL_FILENAME_SOURCE','Filename Source');
define('RW_TEXT_PREFIX','Prefix: ');
define('RW_TEXT_SOURCE_FIELD',' Source Field: ');
define('RW_TEXT_MIN_VALUE','Min Value');
define('RW_TEXT_MAX_VALUE','Max Value');
define('RW_JOURNAL_DESCRIPTION','Journal Description');

// Paper Size Definitions
define('TEXT_PAPER','Paper Size');
define('TEXT_PAPER_WIDTH','Paper Width');
define('TEXT_ORIEN','Orientation');
define('TEXT_MM','mm');
define('TEXT_PORTRAIT','Portrait');
define('TEXT_LANDSCAPE','Landscape');
define('TEXT_USEFUL_INFO','Useful Information');
define('TEXT_LEGAL','Legal');
define('TEXT_LETTER','Letter');

// Definitions for date selection dropdown list
define('TEXT_TODAY','Today');
define('TEXT_WEEK','This Week');
define('TEXT_WTD','Week To Date');
define('TEXT_MONTH','This Month');
define('TEXT_MTD','Month To Date');
define('TEXT_QUARTER','This Quarter');
define('TEXT_QTD','Quarter To Date');
define('TEXT_YEAR','This Year');
define('TEXT_YTD','Year To Date');

// definitions for db tables
define('TEXT_TABLE1','Table 1');
define('TEXT_TABLE2','Table 2');
define('TEXT_TABLE3','Table 3');
define('TEXT_TABLE4','Table 4');
define('TEXT_TABLE5','Table 5');
define('TEXT_TABLE6','Table 6');

// Message definitions
define('RW_RPT_SAVEDEF','The name you entered is a default report. Please enter a new My Report name.');
define('RW_RPT_SAVEDUP','This report name already exists! Press Replace to overwrite or enter a new name and press continue.');
define('RW_RPT_DUPDB','There is an error in your database selection. Check your database names and link equations.');
define('RW_RPT_BADFLD','There is an error in your database field or description. Pleae check and try again.');
define('RW_RPT_BADDATA','There is an error in one of your data fields. Pleae check and try again.');
define('RW_RPT_FUNC_NOT_FOUND','A special function was requested but could not be found. The special function requested was: ');
define('RW_RPT_EMPTYFIELD','A data field has been left empty located at sequence number: ');
define('RW_RPT_EMPTYTABLE','An original data table entry was not found to create a duplicate of in sequence number: ');
define('RW_RPT_NO_SPECIAL_REPORT','No special report function name was entered. Either uncheck the check box or enter a function name!');
define('RW_RPT_NO_TABLE_DATA','Your table statements did not return any rows. Either the tables are empty or there is an error in the link statements!');
define('RW_RPT_DEFDEL','If you replace this report/form, the original report/form will be deleted!');
define('RW_RPT_NODATA','There was not any data in this report based on the criteria provided!');
define('RW_RPT_NOROWS','This report/form with the filter criteria selected does not contain any data!');
define('RW_RPT_WASSAVED',' was saved and copied to report: ');
define('RW_RPT_UPDATED','The report name has been updated!');
define('RW_FRM_NORPT','No form name was selected to perform this operation.');
define('RW_RPT_NORPT','No report or form was selected to perform this operation.');
define('RW_RPT_NORPTTYPE','Either Report or Form type needs to be selected!');
define('RW_RPT_REPDUP','The name you entered is already in use. Please enter a new report name!');
define('RW_RPT_REPDEL','Press OK to delete this report.');
define('RW_RPT_REPOVER','Press OK to overwrite this report.');
define('RW_RPT_NOSHOW','There are no reports to show!');
define('RW_RPT_NOFIELD','There are no fields to show!');
define('RW_FRM_RPTENTER','Enter a name for this form.');
define('RW_RPT_RPTENTER','Enter a name for this report.');
define('RW_RPT_RPTNOENTER','(Leave blank to use default report name from import file)');
define('RW_RPT_MAX30','(maximum 30 characters)');
define('RW_FRM_RPTGRP','Enter the group this form is a part of:');
define('RW_RPT_RPTGRP','Enter the group this report is a part of:');
define('RW_RPT_DEFIMP','Select a default report to import.');
define('RW_RPT_RPTBROWSE','Or browse for a report to upload.');
define('RW_RPT_SPECIAL_REPORT','Special Report (Programmers Only)');
define('RW_RPT_CANNOT_EDIT','This is a standard report, changes cannot be saved in the report viewer! The report must first be copied to a My Report before changes can be saved or may be permanently edited in Report Builder.');
define('RW_FRM_NO_SELECTION','Please select a report or form!');
define('RW_RPT_EXPORT_SUCCESS','The report/form was exported successfully.');
define('RW_RPT_EXPORT_FAILED','The report/form was not exported!');
define('RW_EMAIL_BODY',"Attached is your %s from %s \n\nTo view the attachment, you must have pdf reader software installed on your computer.");

// Report  Specific
define('RW_RPT_RPTFILTER','Report Filters: ');
define('RW_RPT_GROUPBY','Grouped by:');
define('RW_RPT_SORTBY','Sorted by:');
define('RW_RPT_DATERANGE','Date Range:');
define('RW_RPT_CRITBY','Filters:');
define('RW_RPT_ADMIN','Administrator Page');
define('RW_RPT_BRDRLINE','Border Line');
define('RW_RPT_BOXDIM','Single Line Outline Dimensions (mm)');
define('RW_RPT_CRITTYPE','Type of Criteria');
define('RW_RPT_TYPECREATE','Select report or form type to create:');
define('RW_RPT_CUSTRPT','Custom Reports');
define('RW_RPT_DATEDEF','Default Date Selected');
define('RW_RPT_DATEFNAME','Date Fieldname (table.fieldname)');
define('RW_RPT_DATEINFO','Report Date Information');
define('RW_RPT_DATEINST','Uncheck all boxes for date independent reports; leave Date Fieldname empty');
define('RW_RPT_DATELIST','Date Field List<br />(check all that apply)');
define('RW_RPT_DEFRPT','Standard Reports');
define('RW_RPT_ENDPOS','End Position (mm)');
define('RW_RPT_ENTRFLD','Enter a New Field');
define('RW_RPT_FLDLIST','Field List');
define('RW_RPT_FORMOUTPUT','Select a Form to Output');
define('RW_RPT_FORMSELECT','Form Selection');
define('RW_RPT_GRPLIST','Grouping List');
define('RW_RPT_IMAGECUR','Current Image');
define('RW_RPT_IMAGEUPLOAD','Upload new Image');
define('RW_RPT_IMAGESEL','Image Selection');
define('RW_RPT_IMAGESTORED','Select Stored Image');
define('RW_RPT_IMAGEDIM','Image Dimensions (mm)');
define('RW_RPT_LINEATTRIB','Line Attributes');
define('RW_RPT_LINEWIDTH','Line Width (pts) ');
define('RW_RPT_LINKEQ','Link Equation (See Note Below)');
define('RW_RPT_DB_LINK_HELP','The link equations must be in SQL snytax. Tables may be identified either by the table name from the db (as they appear in the drop-down menu), or better, by an alias [tablex] (x = 1 through 6) enclosed in brackets []. tablex is a reference to the table selected in the Table Name list dropdown. For example, [table1].id = [table2].ref_id would link the id field of the table selected in pull down Table 1 to the ref_id field from the table selected in the pull down Table 2. Using the alias will allow portability of the reports/forms to support database table prefixes, if used. After entering each line, reportwriter will verify the equation will make a valid SQL statement.');
define('RW_RPT_FIELD_HELP','Notes: The If multiple fields are displayed in the same column, the field with the largest column width will determine the width of column.');
define('RW_RPT_MYRPT','My Reports');
define('RW_RPT_NOBRDR','No Border');
define('RW_RPT_NOFILL','No Fill');
define('RW_RPT_DISPNAME','Name to Display');
define('RW_RPT_PGFILDESC','Report Filter Description');
define('RW_RPT_PGHEADER','Header Information / Formatting');
define('RW_RPT_PGLAYOUT','Page Layout');
define('RW_RPT_PGMARGIN_L','Left Margin');
define('RW_RPT_PGMARGIN_R','Right Margin');
define('RW_RPT_PGMARGIN','Page Margins');
define('RW_RPT_RNRPT','Rename Report');
define('RW_RPT_PGTITL1','Report Title 1');
define('RW_RPT_PGTITL2','Report Title 2');
define('RW_RPT_RPTDATA','Report Data Heading');
define('RW_RPT_RPTID','Report/Form Identification');
define('RW_RPT_RPTIMPORT','Report Import');
define('RW_RPT_SORTLIST','Sorting Information');
define('RW_RPT_STARTPOS','Start Position (Upper Left Corner in mm)');
define('RW_RPT_TBLNAME','Table Name');
define('RW_RPT_TEXTATTRIB','Text Attributes');
define('RW_RPT_TEXTDISP','Text to Display');
define('RW_RPT_TEXTPROC','Text Processing');
define('RW_RPT_TBLFNAME','Fieldname');
define('RW_RPT_TOTALS','Report Totals');
define('RW_RPT_FLDTOTAL','Enter fields to total (Table.Fieldname)');
define('RW_RPT_TABLE_HEADING_PROP','Table Heading Properties');
define('RW_RPT_TABLE_BODY_PROP','Table Body Properties');

// Form Group Definitions
define('RW_FRM_BANKCHK','Bank Checks');
define('RW_FRM_BANKDEPSLIP','Bank Deposit Slips');
define('RW_FRM_COLLECTLTR','Collection Letters');
define('RW_FRM_CUSTLBL','Labels - Customer');
define('RW_FRM_CUSTQUOTE','Customer Quotes');
define('RW_FRM_VENDQUOTE','Vendor Quotes');
define('RW_FRM_CUSTSTATE','Customer Statements');
define('RW_FRM_INVPKGSLIP','Invoices and Packing Slips');
define('RW_FRM_CRDMEMO','Credit Memos - Customer');
define('RW_FRM_PURCHORD','Purchase Orders');
define('RW_FRM_SALESORD','Sales Orders');
define('RW_FRM_SALESREC','Sales Receipts');
define('RW_FRM_VENDLBL','Labels - Vendor');
define('RW_FRM_VENDOR_CRDMEMO','Credit Memos - Vendor');

// Form Processing Definitions
define('RW_FRM_CNVTDLR','Convert Dollars');
define('RW_FRM_CNVTEURO','Convert Euros');
define('RW_FRM_COMMA','Comma - ,');
define('RW_FRM_COMMASP','Comma-Space');
define('RW_FRM_COYBLOCK','Company Data Block');
define('RW_FRM_COYDATA','Company Data Line');
define('RW_FRM_DATABLOCK','Data Block');
define('RW_FRM_DATALINE','Data Line');
define('RW_FRM_DATATABLE','Data Table');
define('RW_FRM_DATATABLEDUP','Copy of Data Table');
define('RW_FRM_DATATOTAL','Data Total');
define('RW_FRM_DATE','Formatted Date');
define('RW_FRM_DATE_TIME', 'Date/Time');
define('RW_FRM_FIXEDTXT','Fixed Text Field');
define('RW_FRM_IMAGE','Image - JPG or PNG');
define('RW_FRM_LINE','Line');
define('RW_FRM_LOWERCASE','Lowercase');
define('RW_FRM_NEGATE','Negate');
define('RW_FRM_NEWLINE','Line Break');
define('RW_FRM_NOIMAGE','No Image');
define('RW_FRM_NULLDLR','Null if 0 - Dollars');
define('RW_FRM_NUM_2_WORDS','Number to Words');
define('RW_FRM_PAGENUM','Page Number');
define('RW_POSTED_CURR','Posted Currency');
define('RW_FRM_QUOTE_SINGLE', 'Single Quote - \'');
define('RW_FRM_QUOTE_DOUBLE', 'Double Quote - "');
define('RW_FRM_RECTANGLE','Rectangle');
define('RW_FRM_RNDR2','Round (2 decimal)');
define('RW_FRM_SEMISP','Semicolon-space');
define('RW_FRM_DELNL','Skip Blank-Line Break');
define('RW_FRM_SHIP_METHOD','Ship Method');
define('RW_FRM_SPACE1','Single Space');
define('RW_FRM_SPACE2','Double Space');
define('RW_FRM_TAB', 'Tab - \t');
define('RW_FRM_TERMS_TO_LANG','Terms to Language');
define('RW_FRM_UPPERCASE','Uppercase');
define('RW_FRM_ORDR_QTY','Quantity Ordered');
define('RW_BRANCH_ID','Contact ID');
define('RW_REP_ID','User Name');

// Color definitions
define('TEXT_RED','Red');
define('TEXT_GREEN','Green');
define('TEXT_BLUE','Blue');
define('TEXT_BLACK','Black');
define('TEXT_ORANGE','Orange');
define('TEXT_YELLOW','Yellow');
define('TEXT_WHITE','White');

// numbers
define('TEXT_ZERO','zero');
define('TEXT_ONE','one');
define('TEXT_TWO','two');
define('TEXT_THREE','three');
define('TEXT_FOUR','four');
define('TEXT_FIVE','five');
define('TEXT_SIX','six');
define('TEXT_SEVEN','seven');
define('TEXT_EIGHT','eight');
define('TEXT_NINE','nine');
define('TEXT_TEN','ten');
define('TEXT_ELEVEN','eleven');
define('TEXT_TWELVE','twelve');
define('TEXT_THIRTEEN','thirteen');
define('TEXT_FOURTEEN','fourteen');
define('TEXT_FIFTEEN','fifteen');
define('TEXT_SIXTEEN','sixteen');
define('TEXT_SEVENTEEN','seventeen');
define('TEXT_EIGHTEEN','eighteen');
define('TEXT_NINETEEN','nineteen');
define('TEXT_TWENTY','twenty');
define('TEXT_THIRTY','thirty');
define('TEXT_FORTY','forty');
define('TEXT_FIFTY','fifty');
define('TEXT_SIXTY','sixty');
define('TEXT_SEVENTY','seventy');
define('TEXT_EIGHTY','eighty');
define('TEXT_NINETY','ninety');
define('TEXT_HUNDERD','hundred');
define('TEXT_THOUSAND','thousand');
define('TEXT_MILLION','million');
define('TEXT_BILLION','billion');
define('TEXT_TRILLION','trillion');
define('TEXT_DOLLARS','Dollars');

// journal names
define('TEXT_JOURNAL_ID_02','General Journal');
define('TEXT_JOURNAL_ID_03','Purchase Quote');
define('TEXT_JOURNAL_ID_04','Purchase Order');
define('TEXT_JOURNAL_ID_06','Puchases');
define('TEXT_JOURNAL_ID_07','Vendor CM');
define('TEXT_JOURNAL_ID_08','Payroll');
define('TEXT_JOURNAL_ID_09','Sales Quote');
define('TEXT_JOURNAL_ID_10','Sales Order');
define('TEXT_JOURNAL_ID_12','Sales/Invoice');
define('TEXT_JOURNAL_ID_13','Customer CM');
define('TEXT_JOURNAL_ID_14','Inv Assembly');
define('TEXT_JOURNAL_ID_16','Inv Adjustment');
define('TEXT_JOURNAL_ID_18','Cash Receipts');
define('TEXT_JOURNAL_ID_19','POS Journal');
define('TEXT_JOURNAL_ID_20','Cash Distribution');
define('TEXT_JOURNAL_ID_21','POP Journal');

// Paper sizes supported in fpdf class, includes dimensions width, length in mm for page setup
$PaperSizes = array (
	'A3:297:420'     => 'A3',
	'A4:210:297'     => 'A4',
	'A5:148:210'     => 'A5',
	'Legal:216:357'  => TEXT_LEGAL,
	'Letter:216:282' => TEXT_LETTER,
);

// Available font sizes in units: points
$FontSizes = array (
	'8'  => '8', 
	'9'  => '9', 
	'10' => '10', 
	'11' => '11', 
	'12' => '12', 
	'14' => '14', 
	'16' => '16', 
	'18' => '18', 
	'20' => '20', 
	'24' => '24', 
	'28' => '28', 
	'32' => '32', 
	'36' => '36', 
	'40' => '40', 
	'50' => '50',
);

// Available font sizes in units: points
$LineSizes = array (
	'1' => '1', 
	'2' => '2', 
	'3' => '3', 
	'4' => '4', 
	'5' => '5', 
	'6' => '6', 
	'7' => '7', 
	'8' => '8', 
	'9' => '9', 
	'10'=>'10',
);

// Font colors keyed by color Red:Green:Blue
$FontColors = array (
	'0:0:0'       => TEXT_BLACK, // Leave black first as it is typically the default value
	'255:0:0'     => TEXT_RED,
	'255:128:0'   => TEXT_ORANGE,
	'255:255:0'   => TEXT_YELLOW,
	'0:255:0'     => TEXT_GREEN,
	'0:0:255'     => TEXT_BLUE,
	'255:255:255' => TEXT_WHITE,
);

// journal definitions
$rw_xtra_jrnl_defs = array(
  '2'  => TEXT_JOURNAL_ID_02,
  '3'  => TEXT_JOURNAL_ID_03,
  '4'  => TEXT_JOURNAL_ID_04,
  '6'  => TEXT_JOURNAL_ID_06,
  '7'  => TEXT_JOURNAL_ID_07,
  '8'  => TEXT_JOURNAL_ID_08,
  '9'  => TEXT_JOURNAL_ID_09,
  '10' => TEXT_JOURNAL_ID_10,
  '12' => TEXT_JOURNAL_ID_12,
  '13' => TEXT_JOURNAL_ID_13,
  '14' => TEXT_JOURNAL_ID_14,
  '16' => TEXT_JOURNAL_ID_16,
  '18' => TEXT_JOURNAL_ID_18,
  '19' => TEXT_JOURNAL_ID_19,
  '20' => TEXT_JOURNAL_ID_20,
  '21' => TEXT_JOURNAL_ID_21,
);

// The below functions are used to convert a number to language for USD (primarily for checks)
function value_to_words_en_us($number) {
	$number   = round($number, 2);
	$position = array('', ' '.TEXT_THOUSAND, ' '.TEXT_MILLION, ' '.TEXT_BILLION, ' '.TEXT_TRILLION);
	$dollars  = intval($number);
	$cents    = round(($number - $dollars) * 100);
	if (strlen($cents) == 1) $cents = '0' . $cents;
	if ($dollars < 1) {
		$output = TEXT_ZERO;
	} else {
		$output = build_1000_words($dollars, $position);
	}
	return strtoupper($output . ' ' . TEXT_DOLLARS . ' ' . TEXT_AND . ' ' . $cents . '/100');
}

function build_1000_words($number, $position) {
	$output = '';
	$suffix = array_shift($position);
	$tens = $number % 100;
	$number = intval($number / 100);
	$hundreds = $number % 10;
	$number = intval($number / 10);
	if ($number >= 1) $output = build_1000_words($number, $position);
	switch ($hundreds) {
		case 1: $output .= ' ' . TEXT_ONE   . ' ' . TEXT_HUNDERD; break;
		case 2: $output .= ' ' . TEXT_TWO   . ' ' . TEXT_HUNDERD; break;
		case 3: $output .= ' ' . TEXT_THREE . ' ' . TEXT_HUNDERD; break;
		case 4: $output .= ' ' . TEXT_FOUR  . ' ' . TEXT_HUNDERD; break;
		case 5: $output .= ' ' . TEXT_FIVE  . ' ' . TEXT_HUNDERD; break;
		case 6: $output .= ' ' . TEXT_SIX   . ' ' . TEXT_HUNDERD; break;
		case 7: $output .= ' ' . TEXT_SEVEN . ' ' . TEXT_HUNDERD; break;
		case 8: $output .= ' ' . TEXT_EIGHT . ' ' . TEXT_HUNDERD; break;
		case 9: $output .= ' ' . TEXT_NINE  . ' ' . TEXT_HUNDERD; break;
	}
	$output .= build_100_words($tens);
	return $output . $suffix;
}

function build_100_words($number) {
	if ($number > 9 && $number < 20) {
		switch ($number) {
			case 10: return ' ' . TEXT_TEN;
			case 11: return ' ' . TEXT_ELEVEN;
			case 12: return ' ' . TEXT_TWELVE;
			case 13: return ' ' . TEXT_THIRTEEN;
			case 14: return ' ' . TEXT_FOURTEEN;
			case 15: return ' ' . TEXT_FIFTEEN;
			case 16: return ' ' . TEXT_SIXTEEN;
			case 17: return ' ' . TEXT_SEVENTEEN;
			case 18: return ' ' . TEXT_EIGHTEEN;
			case 19: return ' ' . TEXT_NINETEEN;
		}
	}
	$output = '';
	$tens = intval($number / 10);
	switch ($tens) {
		case 2: $output .= ' ' . TEXT_TWENTY;  break;
		case 3: $output .= ' ' . TEXT_THIRTY;  break;
		case 4: $output .= ' ' . TEXT_FORTY;   break;
		case 5: $output .= ' ' . TEXT_FIFTY;   break;
		case 6: $output .= ' ' . TEXT_SIXTY;   break;
		case 7: $output .= ' ' . TEXT_SEVENTY; break;
		case 8: $output .= ' ' . TEXT_EIGHTY;  break;
		case 9: $output .= ' ' . TEXT_NINETY;  break;
	}
	$ones = $number % 10;
	switch ($ones) {
		case 1: $output .= (($output) ? '-' : ' ') . TEXT_ONE;   break;
		case 2: $output .= (($output) ? '-' : ' ') . TEXT_TWO;   break;
		case 3: $output .= (($output) ? '-' : ' ') . TEXT_THREE; break;
		case 4: $output .= (($output) ? '-' : ' ') . TEXT_FOUR;  break;
		case 5: $output .= (($output) ? '-' : ' ') . TEXT_FIVE;  break;
		case 6: $output .= (($output) ? '-' : ' ') . TEXT_SIX;   break;
		case 7: $output .= (($output) ? '-' : ' ') . TEXT_SEVEN; break;
		case 8: $output .= (($output) ? '-' : ' ') . TEXT_EIGHT; break;
		case 9: $output .= (($output) ? '-' : ' ') . TEXT_NINE;  break;
	}
	return $output;
}

/********************** DO NOT EDIT BELOW THIS LINE **********************************/

// Sets the default groups for forms, index max 4 chars
$ReportGroups = array (
	'ar'   => TEXT_RECEIVABLES,
	'ap'   => TEXT_PAYABLES,
	'inv'  => TEXT_INVENTORY,
	'hr'   => TEXT_HR,
	'man'  => TEXT_MANUFAC,
	'bnk'  => TEXT_BANKING,
	'gl'   => TEXT_GL,
	'misc' => TEXT_MISC);  // do not delete misc category

// This array is imploded with the first entry = number of text boxes to build (0, 1 or 2), 
// the remaining is the dropdown menu listings
$CritChoices = array(
	 0 => '2:ALL:RANGE:EQUAL',
	 1 => '0:YES:NO',
	 2 => '0:ALL:YES:NO',
	 3 => '0:ALL:ACTIVE:INACTIVE',
	 4 => '0:ALL:PRINTED:UNPRINTED',
//	 5 => NOT_USED_AVAILABLE,
	 6 => '1:EQUAL',
	 7 => '2:RANGE',
	 8 => '1:NOT_EQUAL',
	 9 => '1:IN_LIST',
	10 => '1:LESS_THAN',
	11 => '1:GREATER_THAN',
);

// Paper orientation
$PaperOrientation = array (
	'P' => TEXT_PORTRAIT,
	'L' => TEXT_LANDSCAPE,
);
	
$FontAlign = array (
	'L' => TEXT_LEFT,
	'R' => TEXT_RIGHT,
	'C' => TEXT_CENTER,
);

$TotalLevels = array(
	'0' => TEXT_NO,
	'1' => TEXT_YES,
);

$DateChoices = array(
	'a' => TEXT_ALL,
	'b' => TEXT_RANGE,
	'c' => TEXT_TODAY,
	'd' => TEXT_WEEK,
	'e' => TEXT_WTD,
	'l' => GL_CURRENT_PERIOD,
	'f' => TEXT_MONTH,
	'g' => TEXT_MTD,
	'h' => TEXT_QUARTER,
	'i' => TEXT_QTD,
	'j' => TEXT_YEAR,
	'k' => TEXT_YTD,
);

/*********************************************************************************************
Form unique defaults
**********************************************************************************************/ 
// Sets the groupings for forms indexed to a specific report (top level) grouping, 
// index is of the form ReportGroup[index]:FormGroup[index], each have a max of 4 chars
// This array is linked to the ReportGroups array by using the index values of ReportGroup
// the first value must match an index value of ReportGroup.
$FormGroups = array (
	'bnk:deps'  => RW_FRM_BANKDEPSLIP,
	'ap:quot'   => RW_FRM_VENDQUOTE,
	'ap:po'     => RW_FRM_PURCHORD,
	'ap:chk'    => RW_FRM_BANKCHK,	// Bank checks grouped with the ap (accounts payable report group
	'ap:cm'     => RW_FRM_VENDOR_CRDMEMO,
	'ap:lblv'   => RW_FRM_VENDLBL,
	'ap:pur'    => RW_TEXT_PURCHASES,
	'ar:quot'   => RW_FRM_CUSTQUOTE,
	'ar:so'     => RW_FRM_SALESORD,
	'ar:inv'    => RW_FRM_INVPKGSLIP,
	'ar:cm'     => RW_FRM_CRDMEMO,
	'ar:lblc'   => RW_FRM_CUSTLBL,
	'ar:rcpt'   => RW_FRM_SALESREC,
	'ar:cust'   => RW_FRM_CUSTSTATE,
	'ar:col'    => RW_FRM_COLLECTLTR,
	'misc:misc' => TEXT_MISC);  // do not delete misc category

// DataTypes
// A corresponding class function needs to be generated for each new function added.
// The index code is also used to identify the form to include to set the properties.
$FormEntries = array(
	'Data'    => RW_FRM_DATALINE,
	'TBlk'    => RW_FRM_DATABLOCK,
	'Tbl'     => RW_FRM_DATATABLE,
	'TDup'    => RW_FRM_DATATABLEDUP,
	'Ttl'     => RW_FRM_DATATOTAL,
	'Text'    => RW_FRM_FIXEDTXT,
	'Img'     => RW_FRM_IMAGE,
	'Rect'    => RW_FRM_RECTANGLE,
	'Line'    => RW_FRM_LINE,
	'CDta'    => RW_FRM_COYDATA,
	'CBlk'    => RW_FRM_COYBLOCK,
	'PgNum'   => RW_FRM_PAGENUM,
);
if (PDF_APP == 'TCPDF') $FormEntries['BarCode'] = RW_BAR_CODE;

// The function to process these values is: ProcessData
// A case statement needs to be generated to process each new value
$FormProcessing = array(
	''           => TEXT_NONE,
	'uc'         => RW_FRM_UPPERCASE,
	'lc'         => RW_FRM_LOWERCASE,
	'neg'        => RW_FRM_NEGATE,
	'rnd2d'      => RW_FRM_RNDR2,
	'rnd_dec'    => RW_FRM_RNDDECIMAL,
	'rnd_pre'    => RW_FRM_RNDPRECISE,
	'def_cur'    => RW_DEF_CUR,
	'null_dcur'  => RW_NULL_DCUR,
	'posted_cur' => RW_POSTED_CURR,
	'null_pcur'  => RW_NULL_PCUR,
	'dlr'        => RW_FRM_CNVTDLR,
	'null-dlr'   => RW_FRM_NULLDLR,
	'euro'       => RW_FRM_CNVTEURO,
	'date'       => RW_FRM_DATE,
	'n2wrd'      => RW_FRM_NUM_2_WORDS,
	'terms'      => RW_FRM_TERMS_TO_LANG,
	'ordr_qty'   => RW_FRM_ORDR_QTY,
	'branch'     => RW_BRANCH_ID,
	'rep_id'     => RW_REP_ID,
	'ship_name'  => RW_FRM_SHIP_METHOD,
	'j_desc'     => RW_JOURNAL_DESCRIPTION,
	'yesBno'     => RW_FRM_YES_SKIP_NO,
	'printed'    => RW_FRM_PRINTED,
);

// The function to process these values is: AddSep
// A case statement needs to be generated to process each new value
$TextProcessing = array(
	''        => TEXT_NONE,
	'sp'      => RW_FRM_SPACE1,
	'2sp'     => RW_FRM_SPACE2,
	'comma'   => RW_FRM_COMMA,
	'com-sp'  => RW_FRM_COMMASP,
	'nl'      => RW_FRM_NEWLINE,
	'semi-sp' => RW_FRM_SEMISP,
	'del-nl'  => RW_FRM_DELNL,
);

// Bar code Types (for use with TCPDF)
$BarCodeTypes = array(
	'C39'     => 'CODE 39',
	'C39+'    => 'CODE 39 w/checksum',
	'C39E'    => 'CODE 39 EXTENDED',
	'C39E+'   => 'CODE 39 EXT w/checksum',
	'I25'     => 'Interleaved 2 of 5',
	'C128A'   => 'CODE 128 A',
	'C128B'   => 'CODE 128 B',
	'C128C'   => 'CODE 128 C',
	'EAN13'   => 'EAN 13',
	'UPCA'    => 'UPC-A',
	'POSTNET' => 'POSTNET',
	'CODABAR' => 'CODABAR',
);

?>