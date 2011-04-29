<?php
/**
 * Este modulo arma la orden de compra de manera automatica, buscando los productos que estab bajos en stock
 */

if ((JOURNAL_ID == 4 ) && (!isset($_GET['vendor'])) ) {
		
	require(DIR_FS_MODULES . 'orders/language/low_stock/' . $_SESSION['language'] . '/language.php');
	$toolbar->add_icon('import', 'onclick=ProcessLowStock()');
	$toolbar->icon_list['import']['text'] = LOW_STOCK_BUTTON; 
	 
?>	
<script type="text/javascript">
<?php //echo $FirstValue;?>

function ProcessLowStock(){	
	var vID = document.getElementById('search').value;
	if (vID != ''){
		url = '?cat=orders&module=ajax&op=low_stock&vendor='+vID;
		$.ajax({ url: url, dataType : 'json',
			success : function(json) {
										var i=1;
										$.each(json,function(id,qty) {
											addInvRow();	
											var rowCnt = i++;
											document.getElementById('qty_'+rowCnt).value = qty;
											document.getElementById('sku_'+rowCnt).value = id;
											setField('sku_' + rowCnt , id );
											loadSkuDetails(id, rowCnt);
											
										});
		 							}
			 });
		 
			
						
	}else{
		alert('<?php echo LOW_STOCK_NO_VENDOR?>');
	}
	
}
</script>
<?php } ?>	