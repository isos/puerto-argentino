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
//  Path: /modules/inventory/functions/inventory.php
//

define('DEFAULT_TEXT_LENGTH','32');
define('DEFAULT_REAL_DISPLAY_FORMAT','10,2');
define('DEFAULT_INPUT_FIELD_LENGTH',120);
////
// Get list of chart of accounts
  function inv_get_field_categories($db_table = TABLE_INVENTORY_CATEGORIES) {
    global $db;
    $category_values = $db->Execute("select category_id, category_name
        from " . $db_table . " order by category_name");
    $category_array = array();
    $category_array[0] = TEXT_SYSTEM;
    while (!$category_values->EOF) {
      $category_array[$category_values->fields['category_id']] = $category_values->fields['category_name'];
      $category_values->MoveNext();
    }
    return $category_array;
  }

////
//
  function inv_prep_field_form($form_array) {
	// set the default values
	$form_array['text_length']     = DEFAULT_TEXT_LENGTH;
	$form_array['text_default']    = '';
	$form_array['link_default']    = '';
	$form_array['integer_range']   = '0';
	$form_array['integer_default'] = '0';
	$form_array['decimal_range']   = '0';
	$form_array['decimal_display'] = DEFAULT_REAL_DISPLAY_FORMAT;
	$form_array['decimal_default'] = '';
	$form_array['radio_default']   = '';
	$form_array['date_range']      = '0';
	$form_array['time_range']      = '0';
	$form_array['date_time_range'] = '0';
	$form_array['check_box_range'] = '0';

	switch ($form_array['entry_type']) {
		case 'text':
		case 'html':
			$form_array['text_length']  = $form_array['length'];
			$form_array['text_default'] = $form_array['default'];
			break;
		case 'hyperlink':
		case 'image_link':
		case 'inventory_link':
			$form_array['link_default'] = $form_array['default'];
			break;
		case 'integer':
			$form_array['integer_range']   = $form_array['select'];
			$form_array['integer_default'] = $form_array['default'];
			break;
		case 'decimal':
			$form_array['decimal_range']   = $form_array['select'];
			$form_array['decimal_display'] = $form_array['display'];
			$form_array['decimal_default'] = $form_array['default'];
			break;
		case 'drop_down':
		case 'radio':
		case 'enum':
			$form_array['radio_default'] = $form_array['default'];
			break;
		case 'date':
			$form_array['date_range'] = $form_array['select'];
			break;
		case 'time':
			$form_array['time_range'] = $form_array['select'];
			break;
		case 'date_time':
			$form_array['date_time_range'] = $form_array['select'];
			break;
		case 'check_box':
			$form_array['check_box_range'] = $form_array['select'];
			break;
		case 'time_stamp':
			break;
		default:
	}
	return $form_array;
  }

////
// Syncronizes the fields in the inventory db with the field parameters 
// (usually only needed for first entry to inventory field builder)
  function inv_sync_inv_field_list($db_table = TABLE_INVENTORY, $field_table = TABLE_INVENTORY_FIELDS) {
	global $db;
	// First check to see if inventory field table is synced with actual inventory table
	$temp = $db->Execute("describe " . $db_table);
	while (!$temp->EOF) {
		$table_fields[]=$temp->fields['Field'];
		$temp->MoveNext();
	}
	sort($table_fields);
	$temp = $db->Execute("select field_name from " . $field_table . " order by field_name");
	while (!$temp->EOF) {
		$field_list[]=$temp->fields['field_name'];
		$temp->MoveNext();
	}
	$needs_sync = false;
	foreach ($table_fields as $key=>$value) {
		if ($value<>$field_list[$key]) {
			$needs_sync = true;
			break;
		}
	}
	if ($needs_sync) {
		if (is_array($field_list)) {
			$add_list = array_diff($table_fields, $field_list);
		} else {
			$add_list = $table_fields;
		}
			$delete_list = '';
		if (is_array($field_list)) $delete_list = array_diff($field_list, $table_fields);
		if (isset($add_list)) {
			foreach ($add_list as $value) { // find the field attributes and copy to field list table
				$myrow = $db->Execute("show fields from " . $db_table . " like '" . $value . "'");
				$Params = array('default' => $myrow->fields['Default']);
				$type = $myrow->fields['Type'];
				if (strpos($type,'(') === false) {
					$data_type = strtolower($type);
				} else {
					$data_type = strtolower(substr($type,0,strpos($type,'(')));
				}
				switch ($data_type) {
					case 'date':      $Params['type'] = 'date'; break;
					case 'time':      $Params['type'] = 'time'; break;
					case 'datetime':  $Params['type'] = 'date_time'; break;
					case 'timestamp': $Params['type'] = 'time_stamp'; break;
					case 'year':      $Params['type'] = 'date'; break;
	
					case 'bigint':
					case 'int':
					case 'mediumint':
					case 'smallint':
					case 'tinyint':
						$Params['type'] = 'integer';
						if ($data_type=='tinyint')   $Params['default'] = '0';
						if ($data_type=='smallint')  $Params['default'] = '1';
						if ($data_type=='mediumint') $Params['default'] = '2';
						if ($data_type=='int')       $Params['default'] = '3';
						if ($data_type=='bigint')    $Params['default'] = '4';
						break;
					case 'decimal':
					case 'double':
					case 'float':
						$Params['type'] = 'decimal';
						if ($data_type=='float')  $Params['default'] = '0';
						if ($data_type=='double') $Params['default'] = '1';
						break;
					case 'tinyblob':
					case 'tinytext':
					case 'char':
					case 'varchar':
					case 'longblob':
					case 'longtext':
					case 'mediumblob':
					case 'mediumtext':
					case 'blob':
					case 'text':
						$Params['type'] = 'text';
						if ($data_type=='varchar' OR $data_type=='char') { // find the actual db length
							$Length = trim(substr($type, strpos($type,'(')+1, strpos($type,')')-strpos($type,'(')-1));
							$Params['length'] = $Length;
						}
						if ($data_type=='tinytext'   OR $data_type=='tinyblob')   $Params['length'] = '255';
						if ($data_type=='text'       OR $data_type=='blob')       $Params['length'] = '65,535';
						if ($data_type=='mediumtext' OR $data_type=='mediumblob') $Params['length'] = '16,777,215';
						if ($data_type=='longtext'   OR $data_type=='longblob')   $Params['length'] = '4,294,967,295';
						break;
					case 'enum':
					case 'set':
						$Params['type'] = 'drop_down';
						$temp = trim(substr($type, strpos($type,'(')+1, strpos($type,')')-strpos($type,'(')-1));
						$selections = explode(',', $temp);
						$defaults = '';
						foreach($selections as $selection) {
							$selection = preg_replace("/'/", '', $selection);
							if ($myrow->fields['Default'] == $selection) $set = 1; else $set = 0;
							$defaults .= $selection . ':' . $selection .':' . $set . ',';
						}
						$defaults = substr($defaults, 0, -1);
						$Params['default'] = $defaults;
						break;
					default:
				}
				$temp = $db->Execute("insert into " . $field_table . " set 
					entry_type = '" . $Params['type'] . "', 
					field_name = '" . $value . "', 
					description = '" . $value . "', 
					category_id = 0, 
					params = '" . serialize($Params) . "'");  // catgory_id = 0 for System category
			}
		}
		if ($delete_list) {
			foreach ($delete_list as $value) {
				$temp = $db->Execute("delete from " . $field_table . " where field_name='" . $value . "'");
			}
		}
	}
	return;
  }

  function build_bom_list($id, $error = false) {
	global $db;
	$bom_list = array();
	if ($error) { // re-generate the erroneous information
		$x = 1;
		while (isset($_POST['sku_' . $x])) { // while there are item rows to read in
			$bom_list[] = array(
				'id'          => db_prepare_input($_POST['id_' . $x]),
				'sku'         => db_prepare_input($_POST['sku_' . $x]),
				'description' => db_prepare_input($_POST['desc_' . $x]),
				'qty'         => db_prepare_input($_POST['qty_' . $x]));
			$x++;
		}
	} else { // pull the information from the database
		$result = $db->Execute("select id, sku, description, qty 
			from " . TABLE_INVENTORY_ASSY_LIST . " where ref_id = " . $id . " order by id");
		while (!$result->EOF) {
			$bom_list[] = $result->fields;
			$result->MoveNext();
		}
	}
	return $bom_list;
  }

  function load_store_stock($sku, $store_id) {
	global $db;
	$sql = "select sum(remaining) as remaining from " . TABLE_INVENTORY_HISTORY . " 
		where store_id = '" . $store_id . "' and sku = '" . $sku . "'";
	$result = $db->Execute($sql);
	$store_bal = $result->fields['remaining'];
	$sql = "select sum(qty) as qty from " . TABLE_INVENTORY_COGS_OWED . " 
		where store_id = '" . $store_id . "' and sku = '" . $sku . "'";
	$result = $db->Execute($sql);
	$qty_owed = $result->fields['qty'];
	return ($store_bal - $qty_owed);
  }

  function build_field_entry($param_array, $cInfo) {
	$output = '<tr><td class="main">' . $param_array['description'] . '</td>';
	$params = unserialize($param_array['params']);
	switch ($params['type']) {
		case 'text':
		case 'html':
			if ($params['length'] < 256) {
				$length = ($params['length'] > 120) ? 'size="120"' : ('size="' . $params['length'] . '"');
				$output .= '<td class="main">' . html_input_field($param_array['field_name'], $cInfo->$param_array['field_name'], $length) . '</td></tr>';
			} else {
				$output .= '<td class="main">' . html_textarea_field($param_array['field_name'], DEFAULT_INPUT_FIELD_LENGTH, 4, $cInfo->$param_array['field_name']) . '</td></tr>';
			}
			break;
		case 'hyperlink':
		case 'image_link':
		case 'inventory_link':
			$output .= '<td class="main">' . html_input_field($param_array['field_name'], $cInfo->$param_array['field_name'], 'size="' . DEFAULT_INPUT_FIELD_LENGTH . '"') . '</td></tr>';
			break;
		case 'integer':
		case 'decimal':
			$output .= '<td class="main">' . html_input_field($param_array['field_name'], $cInfo->$param_array['field_name'], 'size="13" maxlength="12" style="text-align:right"') . '</td></tr>';
			break;
		case 'date':
		case 'time':
		case 'date_time':
			$output .= '<td class="main">' . html_input_field($param_array['field_name'], $cInfo->$param_array['field_name'], 'size="21" maxlength="20"') . '</td></tr>';
			break;
		case 'drop_down':
		case 'enum':
			$choices = explode(',',$params['default']);
			$pull_down_selection = array();
			$default_selection = '';
			while ($choice = array_shift($choices)) {
				$values = explode(':',$choice);
				$pull_down_selection[] = array('id' => $values[0], 'text' => $values[1]);
				if ($cInfo->$param_array['field_name'] == $values[0]) $default_selection = $values[0];
			}
			$output .= '<td class="main">' . html_pull_down_menu($param_array['field_name'], $pull_down_selection, $default_selection) . '</td></tr>';
			break;
		case 'radio':
			$output .= '<td class="main">';
			$choices = explode(',',$params['default']);
			while ($choice = array_shift($choices)) {
				$values = explode(':',$choice);
				$output .= html_radio_field($param_array['field_name'], $values[0], ($cInfo->$param_array['field_name']==$values[0]) ? true : false);
				$output .= '&nbsp;' . $values[1] . '&nbsp;';
			}
			$output .= '</td></tr>';
			break;
		case 'check_box':
			$output .= '<td class="main">' . html_checkbox_field($param_array['field_name'], '1', ($cInfo->$param_array['field_name']==1) ? true : false) . '</td></tr>';
			break;
		case 'time_stamp':
		default:
			$output = '';
	}
	return $output;
  }

  function inv_sku_inv_accounts($sku) {
  	global $db;
	$result = $db->Execute("select account_sales_income, account_inventory_wage, account_cost_of_sales 
		from " . TABLE_INVENTORY . " where sku = '" . $sku . "'");
	if ($result->RecordCount()) {
		$gl_accts = array(
			'sales_income'   => $result->fields['account_sales_income'],
			'inventory_wage' => $result->fields['account_inventory_wage'],
			'cost_of_sales'  => $result->fields['account_cost_of_sales']);
		return $gl_accts;
	} else {
		return false;
	}
  }

  function inv_calculate_prices($item_cost, $full_price, $encoded_price_levels) {
    global $currencies;
	$price_levels = explode(';', $encoded_price_levels);
	$prices = array();
	for ($i=0, $j=1; $i < MAX_NUM_PRICE_LEVELS; $i++, $j++) {
		$level_info = explode(':', $price_levels[$i]);
		$price      = $currencies->clean_value($level_info[0] ? $level_info[0] : (($i == 0) ? $full_price : 0));
		$qty        = $level_info[1] ? $level_info[1] : $j;
		$src        = $level_info[2] ? $level_info[2] : 0;
		$adj        = $level_info[3] ? $level_info[3] : 0;
		$adj_val    = $level_info[4] ? $level_info[4] : 0;
		$rnd        = $level_info[5] ? $level_info[5] : 0;
		$rnd_val    = $level_info[6] ? $level_info[6] : 0;
		if ($j == 1) $src++; // for the first element, the Not Used selection is missing

		switch ($src) {
			case 0: $price = 0;                  break; // Not Used
			case 1: 			                 break; // Direct Entry
			case 2: $price = $item_cost;         break; // Last Cost
			case 3: $price = $full_price;        break; // Retail Price
			case 4: $price = $first_level_price; break; // Price Level 1
		}

		switch ($adj) {
			case 0:                                      break; // None
			case 1: $price -= $adj_val;                  break; // Decrease by Amount
			case 2: $price -= $price * ($adj_val / 100); break; // Decrease by Percent
			case 3: $price += $adj_val;                  break; // Increase by Amount
			case 4: $price += $price * ($adj_val / 100); break; // Increase by Percent
		}

		switch ($rnd) {
			case 0: // None
				break;
			case 1: // Next Integer (whole dollar)
				$price = ceil($price);
				break;
			case 2: // Constant remainder (cents)
				$remainder = $rnd_val;
				if ($remainder < 0) $remainder = 0; // don't allow less than zero adjustments
				// conver to fraction if greater than 1 (user left out decimal point)
				if ($remainder >= 1) $remainder = '.' . $rnd_val;
				$price = floor($price) + $remainder;
				break;
			case 3: // Next Increment (round to next value)
				$remainder = $rnd_val;
				if ($remainder <= 0) { // don't allow less than zero adjustments, assume zero
				  $price = ceil($price);
				} else {
				  $price = ceil($price / $remainder) * $remainder;
				}
		}

		if ($j == 1) $first_level_price = $price; // save level 1 pricing
		$price = $currencies->precise($price);
		if ($src) $prices[$i] = array('qty' => $qty, 'price' =>$price);
	}
	return $prices;
  }

  function save_ms_items($sql_data_array, $attributes) {
  	global $db;
	$base_sku = $sql_data_array['sku'];
	// split attributes
	$attr0 = explode(',', $attributes['ms_attr_0']);
	$attr1 = explode(',', $attributes['ms_attr_1']);
	if (!count($attr0)) return true; // no attributes, nothing to do
	// build skus
	$sku_list = array();
	for ($i = 0; $i < count($attr0); $i++) {
		$temp = explode(':', $attr0[$i]);
		$idx0 = $temp[0];
		if (count($attr1)) {
			for ($j = 0; $j < count($attr1); $j++) {
				$temp = explode(':', $attr1[$j]);
				$idx1 = $temp[0];
				$sku_list[] = $sql_data_array['sku'] . '-' . $idx0 . $idx1;
			}
		} else {
			$sku_list[] = $sql_data_array['sku'] . '-' . $idx0;
		}
	}
	// either update, delete or insert sub skus depending on sku list
	$result = $db->Execute("select sku from " . TABLE_INVENTORY . " 
		where inventory_type = 'mi' and sku like '" . $sql_data_array['sku'] . "-%'");
	$existing_sku_list = array();
	while (!$result->EOF) {
		$existing_sku_list[] = $result->fields['sku'];
		$result->MoveNext();
	}
	$delete_list = array_diff($existing_sku_list, $sku_list);
	$update_list = array_intersect($existing_sku_list, $sku_list);
	$insert_list = array_diff($sku_list, $update_list);
	$sql_data_array['inventory_type'] = 'mi';
	foreach($delete_list as $sku) {
		$result = $db->Execute("delete from " . TABLE_INVENTORY . " where sku = '" . $sku . "'");
	}
	foreach($update_list as $sku) {
		$sql_data_array['sku'] = $sku;
		db_perform(TABLE_INVENTORY, $sql_data_array, 'update', "sku = '" . $sku . "'");
	}
	foreach($insert_list as $sku) {
		$sql_data_array['sku'] = $sku;
		db_perform(TABLE_INVENTORY, $sql_data_array, 'insert');
	}
	// update/insert into inventory_ms_list table
	$result = $db->Execute("select id from " . TABLE_INVENTORY_MS_LIST . " where sku = '" . $base_sku . "'");
	$exists = $result->RecordCount();
	$data_array = array(
		'sku'         => $base_sku,
		'attr_0'      => $attributes['ms_attr_0'],
		'attr_name_0' => $attributes['attr_name_0'],
		'attr_1'      => $attributes['ms_attr_1'],
		'attr_name_1' => $attributes['attr_name_1']);
	if ($exists) {
		db_perform(TABLE_INVENTORY_MS_LIST, $data_array, 'update', "id = " . $result->fields['id']);
	} else {
		db_perform(TABLE_INVENTORY_MS_LIST, $data_array, 'insert');
	}
  }

  function gather_history($sku) {
    global $db;
	$inv_history = array();
	$dates = gen_get_dates();
	$cur_month = $dates['ThisYear'] . '-' . substr('0' . $dates['ThisMonth'], -2) . '-01';
	for($i = 0; $i < 13; $i++) {
	  $index = substr($cur_month, 0, 7);
	  $history['purchases'][$index] = array(
	  	'post_date'    => $cur_month,
	  	'qty'          => 0,
	  	'total_amount' => 0,
	  );
	  $history['sales'][$index] = array(
	  	'post_date'    => $cur_month,
	  	'qty'          => 0,
	  	'usage'        => 0,
	  	'total_amount' => 0,
	  );
	  $history['adjustments'][$index] = array(
	  	'post_date'    => $cur_month,
	  	'qty'          => 0,
	  	'total_amount' => 0,
	  );
	  
	  $cur_month = gen_specific_date($cur_month, 0, -1, 0);
	}
	$last_year = ($dates['ThisYear'] - 1) . '-' . substr('0' . $dates['ThisMonth'], -2) . '-01';

	// load the SO's and PO's and get order, expected del date
	$sql = "select m.id, m.journal_id, m.store_id, m.purchase_invoice_id, i.qty, i.post_date, i.date_1, 
	i.id as item_id 
	  from " . TABLE_JOURNAL_MAIN . " m inner join " . TABLE_JOURNAL_ITEM . " i on m.id = i.ref_id 
	  where m.journal_id in (4, 10, 16) and i.sku = '" . $sku ."' and m.closed = '0' 
	  order by i.date_1";
	$result = $db->Execute($sql);
	while(!$result->EOF) {
	  switch ($result->fields['journal_id']) {
	    case  4:
		  $gl_type   = 'por';
		  $hist_type = 'open_po';
		  break;
	    case 10:
		  $gl_type   = 'sos';
		  $hist_type = 'open_so';
		  break;
	    case 16: //agrego para recuperar tambien los ajustes de inventario
	      $gl_type = 'adj';
	      $hist_type = 'open_ad';
	      break;  
	  }
	  $sql = "select sum(qty) as qty from " . TABLE_JOURNAL_ITEM . " 
		where gl_type = '" . $gl_type . "' and so_po_item_ref_id = " . $result->fields['item_id'];
	  $adj = $db->Execute($sql); // this looks for partial received to make sure this item is still on order
	  if ($result->fields['qty'] > $adj->fields['qty']) {
		$history[$hist_type][] = array(
		  'id'                  => $result->fields['id'],
		  'store_id'            => $result->fields['store_id'],
		  'purchase_invoice_id' => $result->fields['purchase_invoice_id'],
		  'post_date'           => $result->fields['post_date'],
		  'qty'                 => $result->fields['qty'],
		  'date_1'              => $result->fields['date_1'],
		);
	  }
	  $result->MoveNext();
	}

	// load the units received and sold, assembled and adjusted
	$sql = "select m.journal_id, m.post_date, i.qty, i.gl_type, i.credit_amount, i.debit_amount 
	  from " . TABLE_JOURNAL_MAIN . " m inner join " . TABLE_JOURNAL_ITEM . " i on m.id = i.ref_id 
	  where m.journal_id in (6, 12, 14, 16) and i.sku = '" . $sku ."' and m.post_date >= '" . $last_year . "' 
	  order by m.post_date DESC";
	$result = $db->Execute($sql);
	while(!$result->EOF) {
	  $month = substr($result->fields['post_date'], 0, 7);
	  switch ($result->fields['journal_id']) {
	    case  6:
	      $history['purchases'][$month]['qty']          += $result->fields['qty'];
	      $history['purchases'][$month]['total_amount'] += $result->fields['debit_amount'];
		  break;
	    case 12:
	      $history['sales'][$month]['qty']              += $result->fields['qty'];
	      $history['sales'][$month]['usage']            += $result->fields['qty'];
	      $history['sales'][$month]['total_amount']     += $result->fields['credit_amount'];
		  break;
	    case 14:
		  if ($result->fields['gl_type'] == 'asi') { // only if part of an assembly
	        $history['sales'][$month]['usage'] -= $result->fields['qty']; // need to negate quantity since assy.
		  }
		  break;
	    case 16:
	      $history['adjustments'][$month]['qty'] += $result->fields['qty']; //agrego para recuperar los ajustes
	      $history['sales'][$month]['usage'] += $result->fields['qty'];
		  break;
	  }
	  $result->MoveNext();
	}

	// calculate average usage
	$cnt = 0;
	$history['averages'] = array();
	foreach ($history['sales'] as $key => $value) {
	  if ($cnt == 0) { 
	    $cnt++;
		continue; // skip current month since we probably don't have the full months worth
	  }
	  $history['averages']['12month'] += $history['sales'][$key]['usage'];
	  if ($cnt < 7) $history['averages']['6month'] += $history['sales'][$key]['usage'];
	  if ($cnt < 4) $history['averages']['3month'] += $history['sales'][$key]['usage'];
	  if ($cnt < 2) $history['averages']['1month'] += $history['sales'][$key]['usage'];
	  $cnt++;
	}
	$history['averages']['12month'] = round($history['averages']['12month'] / 12, 2);
	$history['averages']['6month']  = round($history['averages']['6month']  /  6, 2);
	$history['averages']['3month']  = round($history['averages']['3month']  /  3, 2);
	return $history;
  }

////
// caculate the total tax rate for a given tax code 
// the value of each element is the id's of the tax authorities imploded(-) with the tax rate
  function inv_calculate_tax_drop_down($type = 'c') {
    global $db;
    $tax_rates = $db->Execute("select tax_rate_id, description_short 
		from " . TABLE_TAX_RATES . " where type = '" . $type . "'");
    $tax_rate_drop_down = array();
    $tax_rate_drop_down[] = array('id' => '0', 'text' => TEXT_NONE);
	while (!$tax_rates->EOF) {
	  $tax_rate_drop_down[] = array('id' => $tax_rates->fields['tax_rate_id'],
							'text' => $tax_rates->fields['description_short']);
	  $tax_rates->MoveNext();
	}
	return $tax_rate_drop_down;
  }

  function inv_calculate_sales_price($qty, $sku_id, $contact_id = '') {
    global $db, $currencies;
	// get the inventory prices
	$inventory = $db->Execute("select item_cost, full_price, price_sheet from " . TABLE_INVENTORY . " where id = '" . $sku_id . "'");
	// determine what price to charge based on customer and sku information
	if ($inventory->fields['price_sheet'] <> '') { // if inventory price sheet is defined, it has priority
	  $sheet_name = $inventory->fields['price_sheet'];
	} else {
	  $customer = $db->Execute("select price_sheet from " . TABLE_CONTACTS . " where id = '" . $contact_id . "'");
	  if ($customer->fields['price_sheet'] <> '') { // no price sheet used for this customer, check for default
	    $sheet_name = $customer->fields['price_sheet'];
	  } else {
	    $customer = $db->Execute("select sheet_name from " . TABLE_PRICE_SHEETS . " where default_sheet = '1'");
	    $sheet_name = ($customer->RecordCount() == 0) ? '' : $customer->fields['sheet_name'];
	  }
	}

	// determine the sku price ranges from the price sheet in effect
	$sql = "select id, default_levels from " . TABLE_PRICE_SHEETS . " 
		where inactive = '0' and 
		(expiration_date is null or expiration_date = '0000-00-00' or expiration_date >= '" . date('Y-m-d', time()) . "') 
		and sheet_name = '" . $sheet_name . "'";
	$price_sheets = $db->Execute($sql);
	
	// retrieve special pricing for this inventory item
	$sql = "select price_sheet_id, price_levels from " . TABLE_INVENTORY_SPECIAL_PRICES . " 
		where price_sheet_id = '" . $price_sheets->fields['id'] . "' and inventory_id = " . $sku_id;
	$result = $db->Execute($sql);
	$special_prices = array();
	while (!$result->EOF) {
		$special_prices[$result->fields['price_sheet_id']] = $result->fields['price_levels'];
		$result->MoveNext();
	}
	
	$levels = isset($special_prices[$price_sheets->fields['id']]) ? $special_prices[$price_sheets->fields['id']] : $price_sheets->fields['default_levels'];
	$prices = inv_calculate_prices($inventory->fields['item_cost'], $inventory->fields['full_price'], $levels);
	$price = '0.0';
	foreach ($prices as $value) if ($qty >= $value['qty']) $price = $currencies->clean_value($value['price']);
	return $price;
  }

?>