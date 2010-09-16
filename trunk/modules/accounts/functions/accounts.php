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
//  Path: /modules/accounts/functions/accounts.php
//

// Define code used on database for identifying type of employees
$employee_types = array(
  'e' => TEXT_EMPLOYEE,
  's' => TEXT_SALES_REP,
  'b' => TEXT_BUYER,
);

$address_types = array(
  $_GET['type'] . 'm', // mailing address (1 only)
  $_GET['type'] . 's', // shipping addresses
  $_GET['type'] . 'b', // billing addresses
);
if ($_GET['type'] <> 'i') $address_types[] = 'im'; // add contacts

//
// Draw address table elements
function draw_address_fields($entries, $add_type, $reset_button = false, $delete_button = true, $short = false) {
	$field = '';
	$field_to_find = $add_type . '_address'; // test to see if there is at least one shipping or billing address
	if (sizeof($entries->$field_to_find) > 0 && substr($add_type, 1, 1) <> 'm') {
		$field .= '<tr><td class="formArea"><table id="' . $add_type . '_table" width="100%" border="0" cellspacing="0" cellpadding="0">';
		$field .= '<tr>' . chr(10);
		$field .= '  <th>' . GEN_PRIMARY_NAME .   '</th>' . chr(10);
		$field .= '  <th>' . GEN_CONTACT .        '</th>' . chr(10);
		$field .= '  <th>' . GEN_ADDRESS1 .       '</th>' . chr(10);
		$field .= '  <th>' . GEN_CITY_TOWN .      '</th>' . chr(10);
		$field .= '  <th>' . GEN_STATE_PROVINCE . '</th>' . chr(10);
		$field .= '  <th>' . GEN_POSTAL_CODE .    '</th>' . chr(10);
		$field .= '  <th>' . GEN_COUNTRY .        '</th>' . chr(10);
		// add some special fields
		if (substr($add_type, 1, 1) == 'p') $field .= '  <th>' . ACT_PAYMENT_REF . '</th>' . chr(10);
		$field .= '  <th align="center">' . TEXT_ACTION . '</th>' . chr(10);
		$field .= '</tr>' . chr(10) . chr(10);

		foreach ($entries->$field_to_find as $address) {
			$field .= '<tr id="tr_' . $address['address_id'] . '" class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">';
			$field .= '  <td class="main" onclick="editRow(\'' . $add_type . '\', ' . $address['address_id'] . ')">' . ($address['primary_name'] ? $address['primary_name'] : '&nbsp;') . '</td>' . chr(10);
			$field .= '  <td class="main" onclick="editRow(\'' . $add_type . '\', ' . $address['address_id'] . ')">' . ($address['contact'] ? $address['contact'] : '&nbsp;') . '</td>' . chr(10);
			$field .= '  <td class="main" onclick="editRow(\'' . $add_type . '\', ' . $address['address_id'] . ')">' . ($address['address1'] ? $address['address1'] : '&nbsp;') . '</td>' . chr(10);
			$field .= '  <td class="main" onclick="editRow(\'' . $add_type . '\', ' . $address['address_id'] . ')">' . ($address['city_town'] ? $address['city_town'] : '&nbsp;') . '</td>' . chr(10);
			$field .= '  <td class="main" onclick="editRow(\'' . $add_type . '\', ' . $address['address_id'] . ')">' . ($address['state_province'] ? $address['state_province'] : '&nbsp;') . '</td>' . chr(10);
			$field .= '  <td class="main" onclick="editRow(\'' . $add_type . '\', ' . $address['address_id'] . ')">' . ($address['postal_code'] ? $address['postal_code'] : '&nbsp;') . '</td>' . chr(10);
			// add special fields
			$field .= '  <td class="main" onclick="editRow(\'' . $add_type . '\', ' . $address['address_id'] . ')">' . ($address['country_code'] ? $address['country_code'] : '&nbsp;') . '</td>' . chr(10);
			if (substr($add_type, 1, 1) == 'p') $field .= '  <td class="main" onclick="editRow(\'' . $add_type . '\', ' . $address['address_id'] . ')">' . ($address['hint'] ? $address['hint'] : '&nbsp;') . '</td>' . chr(10);
			$field .= '  <td class="main" align="center">';
			$field .= html_icon('actions/edit-find-replace.png', TEXT_EDIT, 'small', 'onclick="editRow(\'' . $add_type . '\', ' . $address['address_id'] . ')"') . chr(10);
			$field .= '&nbsp;' . html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="if (confirm(\'' . ACT_WARN_DELETE_ADDRESS . '\')) removeRow(\'' . $add_type . '\', ' . $address['address_id'] . ');"') . chr(10);
			$field .= '  </td>' . chr(10);
			$field .= '</tr>' . chr(10) . chr(10);
		}
		$field .= '</table></td></tr>';
	}

	$address_id = $add_type . '_address_id';
    $field .= '<tr><td class="formArea"><table border="0" cellspacing="2" cellpadding="2">' . chr(10);

	if (!$short) {
		$field .= '<tr>';
		$field .= '  <td class="main">' . GEN_PRIMARY_NAME . '</td>' . chr(10);
		$primary_name = $add_type . '_primary_name';
		$field .= '  <td class="main">' . html_input_field($primary_name, $entries->$primary_name, 'size="49" maxlength="48"', true) . '</td>' . chr(10);
		$field .= '  <td class="main" align="right">' . GEN_TELEPHONE1 . '</td>' . chr(10);
		$telephone1 = $add_type . '_telephone1';
		$field .= '  <td class="main">' . html_input_field($telephone1, $entries->$telephone1, 'size="21" maxlength="20"', ADDRESS_BOOK_TELEPHONE1_REQUIRED) . '</td>' . chr(10);
		$field .= '</tr>';
	}

	$field .= '<tr>';
	$field .= '  <td class="main" align="right">' . GEN_CONTACT . html_hidden_field($address_id, $entries->$address_id) . '</td>' . chr(10);
	$contact = $add_type . '_contact';
	$field .= '  <td class="main">' . html_input_field($contact, $entries->$contact, 'size="33" maxlength="32"', ADDRESS_BOOK_CONTACT_REQUIRED) . '</td>' . chr(10);
	$field .= '<td class="main" align="right">' . GEN_TELEPHONE2 . '</td>' . chr(10);
	$telephone2 = $add_type . '_telephone2';
	$field .= '<td class="main">' . html_input_field($telephone2, $entries->$telephone2, 'size="21" maxlength="20"') . '</td>' . chr(10);
	$field .= '</tr>';

	$field .= '<tr>';
	$field .= '<td class="main" align="right">' . GEN_ADDRESS1 . '</td>' . chr(10);
	$address1 = $add_type . '_address1';
	$field .= '<td class="main">' . html_input_field($address1 , $entries->$address1, 'size="33" maxlength="32"', ADDRESS_BOOK_ADDRESS1_REQUIRED) . '</td>' . chr(10);
	$field .= '<td class="main" align="right">' . GEN_FAX . '</td>' . chr(10);
	$telephone3 = $add_type . '_telephone3';
	$field .= '<td class="main">' . html_input_field($telephone3, $entries->$telephone3, 'size="21" maxlength="20"') . '</td>' . chr(10);
	$field .= '</tr>';

	$field .= '<tr>';
	$field .= '<td class="main" align="right">' . GEN_ADDRESS2 . '</td>' . chr(10);
	$address2 = $add_type . '_address2';
	$field .= '<td class="main">' . html_input_field($address2, $entries->$address2, 'size="33" maxlength="32"', ADDRESS_BOOK_ADDRESS2_REQUIRED) . '</td>' . chr(10);
	$field .= '<td class="main" align="right">' . GEN_TELEPHONE4 . '</td>' . chr(10);
	$telephone4 = $add_type . '_telephone4';
	$field .= '<td class="main">' . html_input_field($telephone4, $entries->$telephone4, 'size="21" maxlength="20"') . '</td>' . chr(10);
	$field .= '</tr>';

	$field .= '<tr>';
	$field .= '<td class="main" align="right">' . GEN_CITY_TOWN . '</td>' . chr(10);
	$city_town = $add_type . '_city_town';
	$field .= '<td class="main">' . html_input_field($city_town, $entries->$city_town, 'size="25" maxlength="24"', ADDRESS_BOOK_CITY_TOWN_REQUIRED) . '</td>' . chr(10);
	$field .= '<td class="main" align="right">' . GEN_EMAIL . '</td>' . chr(10);
	$email = $add_type . '_email';
	$field .= '<td class="main">' . html_input_field($email, $entries->$email, 'size="51" maxlength="50"') . '</td>' . chr(10);
	$field .= '</tr>';

	$field .= '<tr>';
	$field .= '<td class="main" align="right">' . GEN_STATE_PROVINCE . '</td>' . chr(10);
	$state_province = $add_type . '_state_province';
	$field .= '<td class="main">' . html_input_field($state_province, $entries->$state_province, 'size="25" maxlength="24"', ADDRESS_BOOK_STATE_PROVINCE_REQUIRED) . '</td>' . chr(10);
	$field .= '<td class="main" align="right">' . GEN_WEBSITE . '</td>' . chr(10);
	$website = $add_type . '_website';
	$field .= '<td class="main">' . html_input_field($website, $entries->$website, 'size="51" maxlength="50"') . '</td>' . chr(10);
	$field .= '</tr>';

	$field .= '<tr>';
	$field .= '<td class="main" align="right">' . GEN_POSTAL_CODE . '</td>' . chr(10);
	$postal_code = $add_type . '_postal_code';
	$field .= '<td class="main">' . html_input_field($postal_code, $entries->$postal_code, 'size="11" maxlength="10"', ADDRESS_BOOK_POSTAL_CODE_REQUIRED) . '</td>' . chr(10);
	$field .= '<td class="main" align="right">' . GEN_COUNTRY . '</td>' . chr(10);
	$country_code = $add_type . '_country_code';
	$field .= '<td class="main">' . html_pull_down_menu($country_code, gen_get_countries(), ((substr($add_type, 1, 1) == 'm' && $entries->$country_code <> '') ? $entries->$country_code : COMPANY_COUNTRY)) . '</td>' . chr(10);
	$field .= '</tr>';

	if (substr($add_type, 1, 1) <> 'm' || $add_type == 'im') {
	  $field .= '<tr>' . chr(10);
	  $field .= '<td class="main" align="right">' . TEXT_NOTES . '</td>' . chr(10);
	  $notes = $add_type . '_notes';
      $field .= '<td colspan="3" class="main">' . html_textarea_field($notes, 80, 5, $entries->$notes, $parameters = '') . chr(10);
	  if ($reset_button) $field .= html_icon('actions/view-refresh.png', TEXT_RESET, 'small', 'onclick="clearForm(\'' . $add_type . '\')"') . chr(10);
	  $field .= '</td>' . chr(10);
	  $field .= '</tr>' . chr(10);
	}
	$field .= '</table></td></tr>' . chr(10) . chr(10);
	return $field;
}

function contacts_add_address_info($idx, $fields) {
	$result  = 'addBook[' . $idx . '] = new addressRecord(' . $fields['address_id'] . ', ';
	$result .= '"' . str_replace('"', '\"', $fields['primary_name']) . '", ';
	$result .= '"' . str_replace('"', '\"', $fields['contact']) . '", ';
	$result .= '"' . str_replace('"', '\"', $fields['address1']) . '", ';
	$result .= '"' . str_replace('"', '\"', $fields['address2']) . '", ';
	$result .= '"' . str_replace('"', '\"', $fields['city_town']) . '", ';
	$result .= '"' . str_replace('"', '\"', $fields['state_province']) . '", ';
	$result .= '"' . $fields['postal_code'] . '", ';
	$result .= '"' . ($fields['country_code'] ? $fields['country_code'] : COMPANY_COUNTRY) . '", ';
	$result .= '"' . $fields['telephone1'] . '", ';
	$result .= '"' . $fields['telephone2'] . '", ';
	$result .= '"' . $fields['telephone3'] . '", ';
	$result .= '"' . $fields['telephone4'] . '", ';
	$result .= '"' . $fields['email'] . '", ';
	$result .= '"' . $fields['website'] . '", ';
	$result .= '"' . gen_js_encode($fields['notes']) . '");' . chr(10);
	return $result;
}

function load_open_orders($acct_id, $journal_id, $only_open = true, $limit = 0) {	//retrieves open orders for a givin account id
	global $db;

	if (!$acct_id) return array();
	$sql  = "select id, journal_id, closed, post_date, total_amount, purchase_invoice_id, purch_order_id from " . TABLE_JOURNAL_MAIN . " where";
	$sql .= ($only_open) ? " closed = '0' and " : "";
	$sql .= " journal_id in (" . $journal_id . ") and bill_acct_id = " . $acct_id . ' order by post_date DESC';
	$sql .= ($limit) ? " limit " . $limit : "";
	$result = $db->Execute($sql);
	if ($result->RecordCount() == 0) return false;	// no open orders
	$output = array();
	$output[] = array('id' => '', 'text' => TEXT_NEW);
	while (!$result->EOF) {
	  switch ($result->fields['journal_id']) {
	    case  7: // need to negate value since it's a credit memo
		case 13:
		  $total_amount = -$result->fields['total_amount'];
		  break;
		default:
		  $total_amount = $result->fields['total_amount'];
	  }
	  $output[] = array(
		'id'                  => $result->fields['id'],
		'journal_id'          => $result->fields['journal_id'],
		'text'                => $result->fields['purchase_invoice_id'],
		'post_date'           => $result->fields['post_date'],
		'closed'              => $result->fields['closed'],
		'total_amount'        => $total_amount,
		'purchase_invoice_id' => $result->fields['purchase_invoice_id'],
		'purch_order_id'      => $result->fields['purch_order_id']);
	  $result->MoveNext();
	}
    return $output;
}

function load_crm_headings() {
  $heading_array = array(); // don't sort
  $non_sort_array = array(GEN_LAST_NAME, GEN_FIRST_NAME, TEXT_TITLE, GEN_TELEPHONE1, GEN_TELEPHONE4, GEN_EMAIL, TEXT_ACTION);
  $result = html_heading_bar($heading_array, '', $non_sort_array);
  return $result['html_code'];
}

function load_contacts($id = 0) {
  global $db;
  if (!$id) return false;
  $field_list = array('c.id', 'c.inactive', 'c.contact_first', 'c.contact_middle', 'c.contact_last', 
    'a.telephone1', 'a.telephone4', 'a.email');
  $query_raw = "select " . implode(', ', $field_list)  . " 
	from " . TABLE_CONTACTS . " c left join " . TABLE_ADDRESS_BOOK . " a on c.id = a.ref_id 
	where c.type = 'i' and c.dept_rep_id = '" . $id . "'";
  $query_result = $db->Execute($query_raw);
  return $query_result;
}

?>