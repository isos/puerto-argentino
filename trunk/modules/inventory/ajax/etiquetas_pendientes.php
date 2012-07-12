<?php
/*
 * Created on 05/07/2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
require_once(DIR_FS_MODULES."/inventory/functions/inventory.php"); 

$action =  $_REQUEST['action'];


switch ( $action ) {
	case "remove":
		$sku = $_REQUEST['sku'];
		$db->Execute("delete from `etiquetas_pendientes` where sku= '$sku'");
		echo "success";	
		break;
	case "add" :
		$sku = $_REQUEST['sku'];
		$db->Execute("insert into `etiquetas_pendientes` values('$sku')");
		$items= $db->Execute("select inv.id as id, inv.sku as sku, description_sales as descr from `inventory` inv where inv.sku = '$sku'");
		$nueva_etiqueta = array();
		while(!$items->EOF) { //deberá ser uno solo
			  $sku_id = $items->fields['id'];
			  $precio = inv_calculate_sales_price(1,$sku_id);
			  $items->MoveNext();
			  $nueva_etiqueta['sku'] = $items->fields['sku'];
			  $nueva_etiqueta['descripcion'] = $items->fields['descr'];
			  $nueva_etiqueta['precio'] = $precio;
		}	
		echo json_encode($nueva_etiqueta);	
		break;
	case "remove_all" :
		$db->Execute("delete from `etiquetas_pendientes`");
		echo "success";	
		break;	
	case "get_all":
	?>
	<style >
		@media screen,print { 
			.producto { border : 2px solid #002200; padding: 2px 5px; margin: 0px; 
						text-align:center; float: left; 
						min-width: 146px;
						min-height: 95px;
						max-width: 160px;
						font-weigth: bolder;
					  }
			.descripcion { font-size: 11pt; color: #888888; }
			.precio { font-size: 24pt; color: #000000; }
			.sku { font-size: 8pt; }
		}
		@media screen { 
			#print_bar { clear:both; width: 90%; text-align: right; font-size:9pt; padding:2px 5px 4px 0px; margin: 0 0 5px 0; background-color:#EDEDED; border: 1px solid #AAAAAA; }
		}
		@media print { 
			#print_bar { display:none; }
			div{
			/* page-break-after: always; */
        	page-break-inside: avoid;
        }
			
		}
		
	</style>
	<div id="print_bar"> <a href="#" onclick="window.print(); return false;"> Imprimir </a></div>
	<?php
		$items= $db->Execute("select inv.id as id,inv.sku as sku, description_sales as descr from `etiquetas_pendientes` ep INNER JOIN `inventory` inv on ep.sku = inv.sku");
		$etiquetas_pendientes = array();
		while(!$items->EOF) {
			  $sku_id = $items->fields['id'];
			  $precio = inv_calculate_sales_price(1,$sku_id);
			  ?>
		<div class="producto">
			<div class="descripcion"><?php echo $items->fields['descr']; ?></div>
			<div class="precio"><strong>$ <?php echo $precio; ?></strong></div>
			<div class="sku">sku: <?php echo $items->fields['sku']; ?> </div>
		</div>		  
			  
	<?php
		$items->MoveNext();
		}	
		break;	
		
	default:
		break;
}
?>
