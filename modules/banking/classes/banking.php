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
//  Path: /modules/banking/classes/banking.php
//

require_once(DIR_FS_MODULES . 'gen_ledger/classes/gen_ledger.php');

class banking extends journal {
	
// class constructor
	function banking() {
		global $db;
		$this->journal_id          = JOURNAL_ID;
		$this->save_payment        = false;
		$this->search              = TEXT_SEARCH;
		$this->bill_primary_name   = GEN_PRIMARY_NAME;
		$this->bill_contact        = GEN_CONTACT;
		$this->bill_address1       = GEN_ADDRESS1;
		$this->bill_address2       = GEN_ADDRESS2;
		$this->bill_city_town      = GEN_CITY_TOWN;
		$this->bill_state_province = GEN_STATE_PROVINCE;
		$this->bill_postal_code    = GEN_POSTAL_CODE;
		$this->bill_country_code   = COMPANY_COUNTRY;
		switch ($this->journal_id) {
			case 18:
				$this->gl_acct_id          = $_SESSION['admin_prefs']['def_cash_acct'] ? $_SESSION['admin_prefs']['def_cash_acct'] : AR_SALES_RECEIPTS_ACCOUNT;
				$this->gl_disc_acct_id     = AR_DISCOUNT_SALES_ACCOUNT;
				$this->purchase_invoice_id = 'DP' . date('Ymd', time());
				break;
			case 20:
				$this->gl_acct_id          = $_SESSION['admin_prefs']['def_cash_acct'] ? $_SESSION['admin_prefs']['def_cash_acct'] : AP_PURCHASE_INVOICE_ACCOUNT;
				$this->gl_disc_acct_id     = AP_DISCOUNT_PURCHASE_ACCOUNT;
				$result = $db->Execute("select next_check_num from " . TABLE_CURRENT_STATUS);
				$this->purchase_invoice_id = $result->fields['next_check_num'];
				break;
			default: die ('bad journal ID in banking/classes/banking.php!');
		}
	}

	function post_ordr($action) {
		global $db, $currencies, $messageStack, $processor;
		$this->journal_main_array = $this->build_journal_main_array();	// build ledger main record
		$this->journal_rows = array();	// initialize ledger row(s) array

		switch ($this->journal_id) {
			case 18: // Cash Receipts Journal
				$module = (isset($this->shipper_code)) ? $this->shipper_code : 'freecharger'; 
				$module = load_service_module('payment', $module);
				if (class_exists($module)) {
					$processor = new $module;
					if (!$processor->check()) return false;
				}
				$result        = $this->add_item_journal_rows('credit');	// read in line items and add to journal row array
				$credit_total  = $result['total'];
				$debit_total   = $this->add_discount_journal_row('debit');
				$debit_total  += $this->add_total_journal_row('debit', $result['total'] - $result['discount']);
				break;
			case 20: // Cash Disbursements Journal
				$result        = $this->add_item_journal_rows('debit');	// read in line items and add to journal row array
				$debit_total   = $result['total'];
				$credit_total  = $this->add_discount_journal_row('credit');
				$credit_total += $this->add_total_journal_row('credit', $result['total'] - $result['discount']);
				break;
			default: return $this->fail_message('bad journal_id in banking pre-POST processing'); 	// this should never happen, JOURNAL_ID is tested at script entry!
		}

		// ***************************** START TRANSACTION *******************************
		$db->transStart();
		// *************  Pre-POST processing *************
		if (!$this->validate_purchase_invoice_id()) return false;

		// ************* POST journal entry *************
		if ($this->id) {	// it's an edit, first unPost record, then rewrite
			if (!$this->Post($new_post = 'edit')) return false;
		    $messageStack->add(BNK_REPOST_PAYMENT,'caution');
		} else {
			if (!$this->Post($new_post = 'insert')) return false;
		}

		// ************* post-POST processing *************
		switch ($this->journal_id) {
			case 18:
//			case 19:
				if ($this->purchase_invoice_id == '') {	// it's a new record, increment the po/so/inv to next number
					if (!$this->increment_purchase_invoice_id()) return false;
				}
				// Lastly, we process the payment (for receipts). NEEDS TO BE AT THE END BEFORE THE COMMIT!!!
				// Because, if an error here we need to back out the entire post (which we can), but if 
				// the credit card has been processed and the post fails, there is no way to back out the credit card charge.
				if ($processor->pre_confirmation_check()) return false;
				// Update the save payment/encryption data if requested
				if (ENABLE_ENCRYPTION && $this->save_payment && $processor->enable_encryption !== false) {
					if (!$this->encrypt_payment($module, $processor->enable_encryption)) return false;
				}
				if ($processor->before_process()) return false;
				if ($processor->after_process())  return false;
				break;
			case 20:
//			case 21:
				if ($new_post == 'insert') { // only increment if posting a new payment
					if (!$this->increment_purchase_invoice_id($force = true)) return false;
				}
				break;
			default:
		}

		$db->transCommit();	// finished successfully
		// ***************************** END TRANSACTION *******************************
		$this->session_message(constant('BNK_' . $this->journal_id . '_POST_SUCCESSFUL') . $this->purchase_invoice_id, 'success');
		return true;
	}

	function bulk_pay() {
		global $db, $currencies, $messageStack;
		$this->journal_main_array = $this->build_journal_main_array();	// build ledger main record
		$this->journal_rows       = array();	// initialize ledger row(s) array

		$result        = $this->add_item_journal_rows('debit');	// read in line items and add to journal row array
		$debit_total   = $result['total'];
		$credit_total  = $this->add_discount_journal_row('credit');
		$credit_total += $this->add_total_journal_row('credit', $result['total'] - $result['discount']);

		// *************  Pre-POST processing *************
		if (!$this->validate_purchase_invoice_id()) return false;
		// ************* POST journal entry *************
		if (!$this->Post('insert')) return false; // all bulk pay are new posts, cannot edit
		// ************* post-POST processing *************
		for ($i = 0; $i < count($this->item_rows); $i++) {
			$total_paid = $this->item_rows[$i]['total'] + $this->item_rows[$i]['dscnt'];
			if ($total_paid == $this->item_rows[$i]['amt']) {
				 $this->close_so_po($this->item_rows[$i]['id'], true);
			}
		}
		$force = ($this->journal_id == 18) ? false : true; // don't force increment if it's a bulk receipt
		if (!$this->increment_purchase_invoice_id($force)) return false;
		return true;
	}

	function delete_payment() {
		global $db;
		// verify no item rows have been acted upon (accounts reconciliation)
		$result = $db->Execute("select closed from " . TABLE_JOURNAL_MAIN . " where id = " . $this->id);
		if ($result->fields['closed'] == '1') return $this->fail_message(constant('GENERAL_JOURNAL_' . $this->journal_id . '_ERROR_6'));
		// *************** START TRANSACTION *************************
		$db->transStart();
		if (!$this->unPost('delete')) return false;
		$db->transCommit();
		// *************** END TRANSACTION *************************
		$this->session_message(constant('BNK_' . $this->journal_id . '_POST_DELETED') . $this->purchase_invoice_id, 'success');
		return true;
	}

	function add_total_journal_row($debit_credit, $amount) {	// put total value into ledger row array
		global $processor;
		if ($debit_credit == 'debit' || $debit_credit == 'credit') {
			switch ($this->journal_id) {
				case '18':
					$desc = GENERAL_JOURNAL_18_LEDGER_HEADING . ':' . $processor->payment_fields;
					break;
				case '20':
				default:
					$desc = GENERAL_JOURNAL_20_LEDGER_HEADING;
			}
			$this->journal_rows[] = array( // record for accounts receivable
				'gl_type'                 => 'ttl',
				$debit_credit . '_amount' => $amount,
				'description'             => $desc,
				'gl_account'              => $this->gl_acct_id,
			);
			return $amount;
		} else {
			die('bad parameter passed to add_total_journal_row in class orders');
		}
	}

	function add_discount_journal_row($debit_credit) {	// put total value into ledger row array
		if ($debit_credit == 'debit' || $debit_credit == 'credit') {
			$discount = 0;
			for ($i=0; $i<count($this->item_rows); $i++) {
				if ($this->item_rows[$i]['dscnt'] <> 0) {
					$this->journal_rows[] = array(
						'so_po_item_ref_id'       => $this->item_rows[$i]['id'],
						'gl_type'                 => 'dsc',
						'description'             => constant('GENERAL_JOURNAL_' . $this->journal_id . '_DISCOUNT_HEADING'),
						'gl_account'              => $this->gl_disc_acct_id,
						'serialize_number'        => $this->item_rows[$i]['inv'],
						$debit_credit . '_amount' => $this->item_rows[$i]['dscnt']);
					$discount += $this->item_rows[$i]['dscnt'];
				}
			}
			return $discount;
		} else {
			die('bad parameter passed to add_discount_journal_row in class banking');
		}
	}

	function add_item_journal_rows($debit_credit) {	// read in line items and add to journal row array
		if ($debit_credit == 'debit' || $debit_credit == 'credit') {
			$result = array('discount' => 0, 'total' => 0);
			for ($i=0; $i<count($this->item_rows); $i++) {	
				$total_paid = $this->item_rows[$i]['dscnt'] + $this->item_rows[$i]['total'];
				$this->journal_rows[] = array(
					'so_po_item_ref_id'       => $this->item_rows[$i]['id'], // link purch/rec id here for multi-id payments
					'gl_type'                 => $this->item_rows[$i]['gl_type'],
					'description'             => $this->item_rows[$i]['desc'],
					$debit_credit . '_amount' => $total_paid,
					'gl_account'              => $this->item_rows[$i]['acct'],
					'serialize_number'        => $this->item_rows[$i]['inv'],
					'post_date'               => $this->post_date,
				);
				$result['total'] += $total_paid;
				$result['discount'] += $this->item_rows[$i]['dscnt'];
			}
			return $result;
		} else {
			die('bad parameter passed to add_item_journal_rows in class banking');
		}
	}

	function encrypt_payment($module, $card_key_pos = false) {
	  global $db, $messageStack;
	  if (strlen($_SESSION['admin_encrypt']) > 1) {
		$tmp = array();
		$cnt = 0;
		$hint_val = false;
		while (true) {
			if (!isset($_POST[$module . '_field_' . $cnt])) break;
			$tmp[] = db_prepare_input($_POST[$module . '_field_' . $cnt]);
			if ($cnt === $card_key_pos) $hint_val = trim(db_prepare_input($_POST[$module . '_field_' . $cnt]));
			$cnt++;
		}

		if (sizeof($tmp) > 0) {
			require_once(DIR_FS_MODULES . 'general/classes/encryption.php');
			$hint = '';
			if ($hint_val) {
			  $hint = substr($hint_val, 0, 1);
			  for ($a = 0; $a < (strlen($hint_val) - 5); $a++) $hint .= '*'; 
			  $hint .= substr($hint_val, -4);
			}
			$encrypt = new encryption();
			if (!$enc_value = $encrypt->encrypt($_SESSION['admin_encrypt'], implode(':', $tmp), 128)) {
				$messageStack->add('Encryption error - ' . implode('. ',$encrypt->errors), 'error');
				return false;
			}
			$encryption_array = array(
				'hint'      => $hint,
				'module'    => 'contacts',
				'enc_value' => $enc_value,
				'ref_1'     => $this->bill_acct_id,
				'ref_2'     => $this->bill_address_id,
			);
			if ($this->payment_id) {
			  db_perform(TABLE_DATA_SECURITY, $encryption_array, 'update', 'id = ' . $this->payment_id);
			} else {
			  db_perform(TABLE_DATA_SECURITY, $encryption_array, 'insert');
			}
		}
	  } else {
	    $messageStack->add(BNK_PAYMENT_NOT_SAVED,'error');
		return false;
	  }
	  return true;
	}

} // end class banking
?>