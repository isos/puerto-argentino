<?php
	if (isset($_GET['vendor'])) {
		
		$result = $db->Execute("select id, short_name from " . TABLE_CONTACTS . " where type = 'v' and short_name = '".$_GET['vendor']."' " );
		
		$json = array();
		
		if (!$result->EOF){
			
			$vendor_id = $result->fields['id'];
			/**
			 * Esta era la version original, ahora la cambio para usar lo mismo que le propusimos a Cesar
			 * $result_second = $db->Execute("SELECT id FROM ".TABLE_INVENTORY. " WHERE quantity_on_hand < (minimum_stock_level + quantity_on_sales_order - quantity_on_order) and inactive = '0'and vendor_id = '".."'");
			 */
			
			$result_second = $db->Execute("SELECT id, reorder_quantity as qty FROM ".TABLE_INVENTORY. " 
										   WHERE quantity_on_hand < minimum_stock_level and inactive = '0'and vendor_id = $vendor_id and reorder_quantity > 0");
			$i = 0;
			while (!$result_second->EOF){
				$json [$result_second->fields['id'] ]= $result_second->fields['qty'] ;
				$result_second->MoveNext();	
			}
		}
		
		
		echo json_encode($json); 
}
?>