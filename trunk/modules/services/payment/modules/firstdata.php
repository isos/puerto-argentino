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
//  Path: /modules/services/payment/modules/firstdata.php
//

/*
 * FirstData Global Gateway Module
 * You must have SSL active on your server to be compliant with merchant TOS
 */

include_once (DIR_FS_MODULES . 'general/classes/cc_validation.php');

class firstdata {
  var $code, $title, $description, $enabled;

  function firstdata() {
    global $order;
    $this->code        = 'firstdata';
    $this->title       = MODULE_PAYMENT_FIRSTDATA_TEXT_TITLE; // Payment module title in Catalog
    $this->description = MODULE_PAYMENT_FIRSTDATA_TEXT_DESCRIPTION; // Descriptive Info about module in Admin
    $this->enabled     = ((MODULE_PAYMENT_FIRSTDATA_STATUS == 'True') ? true : false); // Whether the module is installed or not
    $this->sort_order  = MODULE_PAYMENT_FIRSTDATA_SORT_ORDER; // Sort Order of this payment option on the customer payment page
	$this->enable_encryption = 1; // set to field position of credit card to create hint, false to turn off encryption

    if ((int)MODULE_PAYMENT_FIRSTDATA_ORDER_STATUS_ID > 0) $this->order_status = MODULE_PAYMENT_FIRSTDATA_ORDER_STATUS_ID;

	// save the information
	// Card numbers are not saved, instead keep the first and last four digits and fill middle with *'s
	$card_number = trim($_POST['firstdata_field_1']);
	$card_number = substr($card_number, 0, 4) . '********' . substr($card_number, -4);
	$this->payment_fields = implode(':', array($_POST['firstdata_field_0'], $card_number, $_POST['firstdata_field_2'], $_POST['firstdata_field_3'], $_POST['firstdata_field_4']));

	$this->avs_codes = array(
		'A' => 'Address matches - Postal Code does not match.',
		'B' => 'Street address match, Postal code in wrong format. (International issuer)',
		'C' => 'Street address and postal code in wrong formats.',
		'D' => 'Street address and postal code match. (international issuer)',
		'E' => 'AVS Error.',
		'G' => 'Service not supported by non-US issuer.',
		'I' => 'Address information not verified by international issuer.',
		'M' => 'Street address and Postal code match. (international issuer)',
		'N' => 'No match on address (street) or postal code.',
		'O' => 'No response sent.',
		'P' => 'Postal code matches, street address not verified due to incompatible formats.',
		'R' => 'Retry, system unavailable or timed out.',
		'S' => 'Service not supported by issuer.',
		'U' => 'Address information is unavailable.',
		'W' => '9 digit postal code matches, address (street) does not match.',
		'X' => 'Exact AVS match.',
		'Y' => 'Address (street) and 5 digit postal code match.',
		'Z' => '5 digit postal code matches, address (street) does not match.',
	);

	$this->cvv_codes = array(
		'M' => 'CVV2 match',
		'N' => 'CVV2 No match',
		'P' => 'Not Processed',
		'S' => 'Issuer indicates that CVV2 data should be present on the card, but the merchant has indicated that the CVV2 data is not present on the card.',
		'U' => 'Issuer has not certified for CVV2 or issuer has not provided Visa with the CVV2 encryption keys.',
		'X' => 'No response from the credit card association was reeived.',
	);
  }

  function javascript_validation() {
    $js = '  if (payment_method == "' . $this->code . '") {' . "\n" .
    '    var cc_owner = document.getElementById("firstdata_field_0").value;' . "\n" .
    '    var cc_number = document.getElementById("firstdata_field_1").value;' . "\n";
    if (MODULE_PAYMENT_FIRSTDATA_USE_CVV == 'True')  {
      $js .= '    var cc_cvv = document.getElementById("firstdata_field_4").value;' . "\n";
    }
    $js .= '    if (cc_owner == "" || cc_owner.length < ' . CC_OWNER_MIN_LENGTH . ') {' . "\n" .
    '      error_message = error_message + "' . MODULE_PAYMENT_FIRSTDATA_TEXT_JS_CC_OWNER . '";' . "\n" .
    '      error = 1;' . "\n" .
    '    }' . "\n" .
    '    if (cc_number == "" || cc_number.length < ' . CC_NUMBER_MIN_LENGTH . ') {' . "\n" .
    '      error_message = error_message + "' . MODULE_PAYMENT_FIRSTDATA_TEXT_JS_CC_NUMBER . '";' . "\n" .
    '      error = 1;' . "\n" .
    '    }' . "\n";
    if (MODULE_PAYMENT_FIRSTDATA_USE_CVV == 'True')  {
      $js .= '    if (cc_cvv == "" || cc_cvv.length < "3" || cc_cvv.length > "4") {' . "\n".
      '      error_message = error_message + "' . MODULE_PAYMENT_FIRSTDATA_TEXT_JS_CC_CVV . '";' . "\n" .
      '      error = 1;' . "\n" .
      '    }' . "\n" ;
    }
    $js .= '  }' . "\n";

    return $js;
  }

  function selection() {
    global $order;

    for ($i=1; $i<13; $i++) {
      $expires_month[] = array('id' => sprintf('%02d', $i), 'text' => strftime('%B',mktime(0,0,0,$i,1,2000)));
    }

    $today = getdate();
    for ($i = $today['year']; $i < $today['year'] + 10; $i++) {
      $expires_year[] = array('id' => strftime('%y',mktime(0,0,0,1,1,$i)), 'text' => strftime('%Y',mktime(0,0,0,1,1,$i)));
    }
	$selection = array(
	   'id' => $this->code,
	   'module' => MODULE_PAYMENT_FIRSTDATA_TEXT_CATALOG_TITLE,
	   'fields' => array(
	               array('title' => MODULE_PAYMENT_FIRSTDATA_TEXT_CREDIT_CARD_OWNER,
					   'field'   => html_input_field('firstdata_field_0', $order->firstdata_field_0)),
				   array('title' => MODULE_PAYMENT_FIRSTDATA_TEXT_CREDIT_CARD_NUMBER,
					   'field'   => html_input_field('firstdata_field_1', $order->firstdata_field_1)),
				   array('title' => MODULE_PAYMENT_FIRSTDATA_TEXT_CREDIT_CARD_EXPIRES,
					   'field'   => html_pull_down_menu('firstdata_field_2', $expires_month, $order->firstdata_field_2) . '&nbsp;' . html_pull_down_menu('firstdata_field_3', $expires_year, $order->firstdata_field_3)),
				   array('title' => MODULE_PAYMENT_FIRSTDATA_TEXT_CVV,
					   'field'   => html_input_field('firstdata_field_4', $order->firstdata_field_4, 'size="4" maxlength="4"'))
		 ));
    return $selection;
  }

  function pre_confirmation_check() {
    global $_POST, $messageStack;

	// if the card number has the blanked out middle number fields, it has been processed, show message that 
	// the charges were not processed through the merchant gateway and continue posting payment.
	if (strpos($_POST['firstdata_field_1'],'*') !== false) {
    	$messageStack->add(MODULE_PAYMENT_FIRSTDATA_NO_DUPS, 'caution');
		return false;
	}
    $cc_validation = new cc_validation();
    $result = $cc_validation->validate($_POST['firstdata_field_1'], $_POST['firstdata_field_2'], $_POST['firstdata_field_3'], $_POST['firstdata_field_4']);
    $error  = '';
    switch ($result) {
      case -1:
      $error = sprintf(TEXT_CCVAL_ERROR_UNKNOWN_CARD, substr($cc_validation->cc_number, 0, 4));
      break;
      case -2:
      case -3:
      case -4:
      $error = TEXT_CCVAL_ERROR_INVALID_DATE;
      break;
      case false:
      $error = TEXT_CCVAL_ERROR_INVALID_NUMBER;
      break;
    }

    if ( ($result == false) || ($result < 1) ) {
      $messageStack->add($error . '<!-- ['.$this->code.'] -->', 'error');
      return true;
    }

    $this->cc_card_type    = $cc_validation->cc_type;
    $this->cc_card_number  = $cc_validation->cc_number;
    $this->cc_cvv2         = $_POST['firstdata_field_4'];
    $this->cc_expiry_month = $cc_validation->cc_expiry_month;
    $this->cc_expiry_year  = $cc_validation->cc_expiry_year;
	return false;
  }

  function before_process() {
    global $order, $db, $messageStack;

	// if the card number has the blanked out middle number fields, it has been processed, the message that 
	// the charges were not processed were set in pre_confirmation_check, just return to continue without processing.
	if (strpos($_POST['firstdata_field_1'], '*') !== false) {
		return false;
	}

    $order->info['cc_expires'] = $_POST['firstdata_field_2'] . $_POST['firstdata_field_3'];
    $order->info['cc_owner']   = $_POST['firstdata_field_0'];
	$this->cc_card_owner       = $_POST['firstdata_field_0'];
    $order->info['cc_cvv']     = $_POST['firstdata_field_4'];

    // Create a string that contains a listing of products ordered for the description field
    $description = $order->description;

    // Populate an array that contains all of the data to be sent to processor (their xml string is one level)
	$str  = NULL;
	$str .= '<merchantinfo>';
	$str .= '  <configfile>' . MODULE_PAYMENT_FIRSTDATA_CONFIG_FILE . '</configfile>';
	$str .= '  <keyfile>'    . MODULE_PAYMENT_FIRSTDATA_KEY_FILE    . '</keyfile>';
	$str .= '  <host>'       . MODULE_PAYMENT_FIRSTDATA_HOST        . '</host>';
	$str .= '  <port>'       . MODULE_PAYMENT_FIRSTDATA_PORT        . '</port>';
	$str .= '</merchantinfo>';
	$str .= '<orderoptions>';
	$str .= '  <ordertype>' . ((MODULE_PAYMENT_FIRSTDATA_AUTHORIZATION_TYPE == 'Authorize') ? 'Preauth' : 'Sale') . '</ordertype>';
    if (MODULE_PAYMENT_FIRSTDATA_TESTMODE == 'Test') $str .= '  <result>' . 'Good' . '</result>'; // Live (default), Good, Decline, Duplicate
	$str .= '</orderoptions>';
	$str .= '<transactiondetails>';
	$str .= '  <transactionorigin>Eci</transactionorigin>';
	$str .= '  <oid>'          . ($order->purch_order_id ? $order->purch_order_id : microtime()) . '</oid>';
	$str .= '</transactiondetails>';
//	'ssl_salestax' => ($order->sales_tax) ? $order->sales_tax : 0,
	$str .= '<payment>';
	$str .= '  <chargetotal>'  . $order->total_amount . '</chargetotal>';
	$str .= '</payment>';
	$str .= '<creditcard>';
	$str .= '  <cardnumber>'   . preg_replace('/ /', '', $_POST['firstdata_field_1']) . '</cardnumber>';
	$str .= '  <cardexpmonth>' . $this->cc_expiry_month . '</cardexpmonth>';
	$str .= '  <cardexpyear>'  . substr($this->cc_expiry_year, -2) . '</cardexpyear>';
	if ($this->cc_cvv2) $str .= '  <cvmvalue>' . $this->cc_cvv2 . '</cvmvalue>';
	$str .= '  <cvmindicator>' . (($this->cc_cvv2) ? 'provided' : 'not_provided') . '</cvmindicator>';
	$str .= '</creditcard>';
/*
	$str .= '<shipping>';
	$str .= '  <sname>'     . str_replace('&', '-', $order->ship_primary_name) . '</sname>';
//	$str .= '  <scompany>'  . str_replace('&', '-', $order->ship_primary_name) . '</scompany>';
	$str .= '  <saddress1>' . str_replace('&', '-', substr($order->ship_address1, 0, 20)) . '</saddress1>';
//	$str .= '  <saddress2>' . str_replace('&', '-', $order->ship_address2) . '</saddress2>';
	$str .= '  <scity>'     . $order->ship_city_town . '</scity>';
	$str .= '  <sstate>'    . $order->ship_state_province . '</sstate>';
	$str .= '  <szip>'      . preg_replace("/[^A-Za-z0-9]/", "", $order->ship_postal_code) . '</szip>';
	$str .= '  <scountry>'  . $order->ship_country_code . '</scountry>';
	$str .= '  <sphone>'    . $order->ship_telephone . '</sphone>';
	$str .= '  <semail>'    . $order->bill_email . '</semail>';
	$str .= '</shipping>';
*/
	$str .= '<billing>';
	$str .= '  <name>'     . str_replace('&', '-', $order->bill_primary_name) . '</name>';
//	$str .= '  <company>'  . str_replace('&', '-', $order->bill_primary_name) . '</company>';
	$str .= '  <address1>' . str_replace('&', '-', substr($order->bill_address1, 0, 20)) . '</address1>';
	$str .= '  <addrnum>'  . substr($order->bill_address1, 0, strpos($order->bill_address1, ' ')) . '</addrnum>';
//	$str .= '  <address2>' . str_replace('&', '-', $order->bill_address2);
	$str .= '  <city>' . $order->bill_city_town . '</city>';
	$str .= '  <state>' . $order->bill_state_province . '</state>';
	$str .= '  <zip>' . preg_replace("/[^A-Za-z0-9]/", "", $order->bill_postal_code) . '</zip>';
	$str .= '  <country>' . $order->bill_country_code . '</country>';
	if ($order->bill_telephone)  $str .= '  <phone>' . $order->bill_telephone   . '</phone>';
//	$str .= '  <fax>' . $order->bill_fax . '</fax>';
	if ($order->bill_email)      $str .= '  <email>'  . $order->bill_email      . '</email>';
	if ($order->bill_short_name) $str .= '  <userid>' . $order->bill_short_name . '</userid>';
	$str .= '</billing>';
/*
	$str .= '<items>';
	$str .= '  <item>';
	$str .= '    <description>' . $description . '</description>';
	$str .= '    <id>' . '123456' . '</id>';
	$str .= '    <price>' . '12.00' . '</price>';
	$str .= '    <quantity>' . '1' . '</quantity>';
	$str .= '    <serial>' . '0987654322' . '</serial>';
	$str .= '    <options>';
	$str .= '      <option>';
	$str .= '        <name>' . 'Color' . '</name>';
	$str .= '        <value>' . 'Red' . '</value>';
	$str .= '      </option>';
	$str .= '      <option>';
	$str .= '        <name>' . 'Size' . '</name>';
	$str .= '        <value>' . 'XL' . '</value>';
	$str .= '      </option>';
	$str .= '    </options>';
	$str .= '  </item>';
	$str .= '</items>';
	$str .= '<notes>';
	$str .= '  <comments>' . 'Comment Here' . '</comments>';
	$str .= '  <referred>' . 'Reference Here' . '</referred>';
	$str .= '</notes>';
*/
    // concatenate the submission data and put into $data variable
	$data = '<order>' . $str . '</order>'; // terminate XML string

    // SEND DATA BY CURL SECTION
    // Post order info data to FirstDate, make sure you have cURL support installed
//	$url = str_replace('.com/', '.com:' . MODULE_PAYMENT_FIRSTDATA_PORT . '/', MODULE_PAYMENT_FIRSTDATA_HOST);
	$url = MODULE_PAYMENT_FIRSTDATA_HOST . ':' . MODULE_PAYMENT_FIRSTDATA_PORT . '/'; // . 'LSGSXML';
	$cert = DIR_FS_MY_FILES . 'firstdata/' . MODULE_PAYMENT_FIRSTDATA_KEY_FILE;
	$GetPost = 'POST';	
//echo 'transmit url  = '; echo htmlspecialchars($url); echo '<br />';
//echo 'transmit cert = '; echo htmlspecialchars($cert); echo '<br />';
//echo 'transmit data = '; echo htmlspecialchars($data); echo '<br /><br />';

    $ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	// uncomment the next line if you get curl error 60: error setting certificate verify locations
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	// uncommenting the next line is most likely not necessary in case of error 60
//	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSLCERT, DIR_FS_MY_FILES . 'firstdata/' . MODULE_PAYMENT_FIRSTDATA_KEY_FILE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10); // times out after 10 seconds 
//	curl_setopt($ch, CURLOPT_HEADER, 0);
//	curl_setopt($ch, CURLOPT_VERBOSE, 0);
	if ($GetPost == 'POST') {
	  curl_setopt($ch, CURLOPT_POST, 1);
	  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    if (CURL_PROXY_REQUIRED == 'True') {
      curl_setopt ($ch, CURLOPT_HTTPPROXYTUNNEL, true);
      curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
      curl_setopt ($ch, CURLOPT_PROXY, CURL_PROXY_SERVER_DETAILS);
    }
	$authorize    = curl_exec($ch); 
	// Check for curl errors
	$curlerrornum = curl_errno($ch);
	$curlerror    = curl_error($ch);
	curl_close ($ch);
	if ($curlerrornum) { 
		$messageStack->add('XML Read Error (cURL) #' . $curlerrornum . '. Description = ' . $curlerror,'error');
		return true;
	}
//$messageStack->add('response xml = ' . htmlspecialchars($authorize),'caution');

	// since the response is only one level deep, we can do a simple parse
	$authorize = trim($authorize);
//	$authorize = substr($authorize, strpos($authorize, '<txn>') + 5); // remove up to and including the container tag
//	$authorize = substr($authorize, 0, strpos($authorize, '</txn>')); // remove from end container tag on
	$results = array();
	$runaway_loop_counter = 0;
	while ($authorize) {
		$key           = substr($authorize, strpos($authorize, '<') + 1, strpos($authorize, '>') - 1);
		$authorize     = substr($authorize, strpos($authorize, '>') + 1); // remove start tag
		$value         = substr($authorize, 0, strpos($authorize, '<')); // until start of end tag
		$authorize     = substr($authorize, strpos($authorize, '>') + 1); // remove end tag
		$results[$key] = $value;
		if ($runaway_loop_counter++ > 1000) break;
	}

    $this->transaction_id = $results['r_ref'];
    $this->auth_code      = $results['r_code'];

    // If the response code is not 0 (approved) then redirect back to the payment page with the appropriate error message
    if ($results['r_error']) {
      $messageStack->add('Decline Code #' . $results['r_error'] . ': ' . $results['r_message'] . ' - ' . MODULE_PAYMENT_FIRSTDATA_TEXT_DECLINED_MESSAGE, 'error');
	  return true;
    } else {
		$messageStack->add($results['r_message'] . ' - Approval code: ' . $this->auth_code . ' --> CVV2 results: ' . $this->cvv_codes[$results['r_authresponse']], 'success');
		$messageStack->add('Address verification results: ' . $this->avs_codes[$results['r_avs']], 'success');
		return false;
	}
	$messageStack->add($results['r_message'] . ' - ' . MODULE_PAYMENT_FIRSTDATA_TEXT_DECLINED_MESSAGE, 'error');
	return true;
  }

  function after_process() {
    return false;
  }

  function check() {
    global $db;
    if (!isset($this->_check)) {
      $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_FIRSTDATA_STATUS'");
      $this->_check = $check_query->RecordCount();
    }
    return $this->_check;
  }

  function install() {
    global $db;
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable FirstData Network Module', 'MODULE_PAYMENT_FIRSTDATA_STATUS', 'True', 'Do you want to accept FirstData payments?', '6', '0', 'cfg_select_option(array(\'True\', \'False\'), ', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Merchant ID', 'MODULE_PAYMENT_FIRSTDATA_CONFIG_FILE', '', 'The Store ID used for the FirstData Network service.', '6', '0', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Key File Name', 'MODULE_PAYMENT_FIRSTDATA_KEY_FILE', '', 'The PEM key file with path used for the FirstData Network service. File must be placed in the directory my_files/firstdata. Typipcally the store ID with the .pem extension.', '6', '0', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Host', 'MODULE_PAYMENT_FIRSTDATA_HOST', '', 'The host used for the FirstData Network service. Provided in welcome packet. Should be something like: https://secure.linkpt.net', '6', '0', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Port', 'MODULE_PAYMENT_FIRSTDATA_PORT', '', 'The port used for the FirstData Network service. Provided in welcome packet.', '6', '0', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Transaction Mode', 'MODULE_PAYMENT_FIRSTDATA_TESTMODE', 'Test', 'Transaction mode used for processing orders', '6', '0', 'cfg_select_option(array(\'Test\', \'Production\'), ', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Authorization Type', 'MODULE_PAYMENT_FIRSTDATA_AUTHORIZATION_TYPE', 'Authorize', 'Do you want submitted credit card transactions to be authorized only, or authorized and captured?', '6', '0', 'cfg_select_option(array(\'Authorize\', \'Authorize/Capture\'), ', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort order of display.', 'MODULE_PAYMENT_FIRSTDATA_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
  }

  function remove() {
    global $db;
    $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
  }

  function keys() {
    return array(
	  'MODULE_PAYMENT_FIRSTDATA_STATUS', 
	  'MODULE_PAYMENT_FIRSTDATA_CONFIG_FILE', 
	  'MODULE_PAYMENT_FIRSTDATA_KEY_FILE', 
	  'MODULE_PAYMENT_FIRSTDATA_HOST', 
	  'MODULE_PAYMENT_FIRSTDATA_PORT', 
	  'MODULE_PAYMENT_FIRSTDATA_TESTMODE', 
	  'MODULE_PAYMENT_FIRSTDATA_AUTHORIZATION_TYPE', 
	  'MODULE_PAYMENT_FIRSTDATA_SORT_ORDER',
	);
  }
}

?>