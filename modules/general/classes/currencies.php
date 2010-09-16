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
//  Path: /modules/general/classes/currencies.php
//

class currencies {
    var $currencies;

    function currencies() {
      global $db, $messageStack;
      $this->currencies = array();
      $currencies = $db->Execute("select * from " . TABLE_CURRENCIES);
      while (!$currencies->EOF) {
		$this->currencies[$currencies->fields['code']] = array(
		   'title'           => $currencies->fields['title'],
		   'symbol_left'     => $currencies->fields['symbol_left'],
		   'symbol_right'    => $currencies->fields['symbol_right'],
		   'decimal_point'   => $currencies->fields['decimal_point'],
		   'thousands_point' => $currencies->fields['thousands_point'],
		   'decimal_places'  => $currencies->fields['decimal_places'],
		   'decimal_precise' => $currencies->fields['decimal_precise'],
		   'value'           => $currencies->fields['value'],
		);
        $currencies->MoveNext();
      }
	  if (DEFAULT_CURRENCY == '') { // do not put this in the translation file, it is loaded before the language file is loaded.
	    $messageStack->add('You do not have a default currency set, PhreeBooks requires a default currency to operate properly! Please set the default currency in Setup -> Currencies.', 'error');
	  }
    }

// class methods
	// omits the symbol_left and symbol_right (just the formattted number))
    function format($number, $calculate_currency_value = true, $currency_type = DEFAULT_CURRENCY, $currency_value = '') {
      if ($calculate_currency_value) {
        $rate = ($currency_value) ? $currency_value : $this->currencies[$currency_type]['value'];
        $format_string = number_format($number * $rate, $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']);
      } else {
        $format_string = number_format($number, $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']);
      }
      return $format_string;
    }

	// omits the symbol_left and symbol_right (just the formattted number to the precision number of decimals))
    function precise($number, $calculate_currency_value = true, $currency_type = DEFAULT_CURRENCY, $currency_value = '') {
      if ($calculate_currency_value) {
        $rate = ($currency_value) ? $currency_value : $this->currencies[$currency_type]['value'];
        $format_string = number_format($number * $rate, $this->currencies[$currency_type]['decimal_precise'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']);
      } else {
        $format_string = number_format($number, $this->currencies[$currency_type]['decimal_precise'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']);
      }
      return $format_string;
    }

    function format_full($number, $calculate_currency_value = true, $currency_type = DEFAULT_CURRENCY, $currency_value = '', $output_format = '') {
      if ($calculate_currency_value) {
        $rate = ($currency_value) ? $currency_value : $this->currencies[$currency_type]['value'];
        $format_string = $this->currencies[$currency_type]['symbol_left'] . ' ' . number_format($number * $rate, $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . ' ' . $this->currencies[$currency_type]['symbol_right'];
      } else {
        $format_string = $this->currencies[$currency_type]['symbol_left'] . ' ' . number_format($number, $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . ' ' . $this->currencies[$currency_type]['symbol_right'];
      }
	  switch ($output_format) {
	  	case 'fpdf': // assumes default character set
		  $format_string = str_replace('&euro;', chr(128),  $format_string); // Euro
		  break;
		default:
	  }
      return $format_string;
    }

    function get_value($code) {
      return $this->currencies[$code]['value'];
    }

	function clean_value($number, $currency_type = DEFAULT_CURRENCY) {
	  // converts the number to standard float format (period as decimal, no thousands separator)
	  $temp  = str_replace($this->currencies[$currency_type]['thousands_point'], '', trim($number));
	  $value = str_replace($this->currencies[$currency_type]['decimal_point'], '.', $temp);
	  $value = preg_replace("/[^-0-9.]+/","",$value);
	  return $value;
	}

	function build_js_currency_arrays() {
		$js_codes  = 'var js_currency_codes = new Array(';
		$js_values = 'var js_currency_values = new Array(';
		foreach ($this->currencies as $code => $values) {
			$js_codes  .= "'" . $code . "',";
			$js_values .= $this->currencies[$code]['value'] . ",";
		}
		$js_codes  = substr($js_codes, 0, -1) . ");";
		$js_values = substr($js_values, 0, -1) . ");";
		return $js_codes . chr(10) . $js_values . chr(10);
	}

}
?>