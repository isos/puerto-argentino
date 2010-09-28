<!-- 
este script busca en la BBDD todos los producos que han recibido algun ajuste manual (adj) y calcula:
la cant. comprada
la cant. vendida
la cant. ajustada
el stock actual
el stock teorico (sin el ajuste)
 -->
<style>
 a {
   font-size:8pt;
   color:green;
   margin-left: 20px;
   }
 td {
 	border-botom:1px solid;
 	text-align:center;
 	}
 .descripcion {
 	text-align:right;
 	padding-left:15px;
 } 	
 	.header {
 		border:thin solid; 
 		background:#ddeedd;
 	}
</style>
<?php

 	function exec_query($gl_type,$sku) {
 		$query = "SELECT SUM(`qty`) FROM `journal_item` where `gl_type` = '".$gl_type."' and `sku` = '".$sku."'";
		$resu= mysql_query($query);
		$cant = mysql_fetch_row($resu);
		return $cant[0];
 	}

 	function print_row($row) {
 		
 		echo $row? "<tr> <td> ".$row['sku']."</td> <td class='descripcion'> ".$row['descripcion']."</td> 
 					<td> ".$row['Compras']."</td> <td> ".$row['Ventas']."</td>  
 					<td> ".$row['Cantidad Ajustada']."</td> <td> ".$row['Stock actual']."</td> <td> ".($row['Compras'] - $row['Ventas'])."</td></tr>"
 			: 	"<table> 
 					<tr class='header'> <td> sku </td> <td> Descripcion </td> 
 					<td> Cant. Comprada </td> <td> Cant. Vendida </td> 
 					<td> Cant. Ajustada </td> <td> Stock actual </td> <td> Stock sin ajustar</td></tr>";
 			;
 	}
   $db = mysql_connect("localhost","root","root");
   mysql_select_db("phreebooks2");
   $query = 	"SELECT ji.`sku` AS  'sku',
	            i.`description_short` AS  'descripcion',
		    i.`quantity_on_hand` AS  'Stock actual',
		    SUM( ji.qty ) AS  'Cantidad Ajustada'
	      	FROM  `inventory` i INNER JOIN  `journal_item` ji 
			ON i.sku = ji.sku
		WHERE  `gl_type` =  'adj'
		GROUP BY ji.`sku` 
		ORDER BY `sku` ASC";

	$results = mysql_query($query);
	echo "<p> Cant. total de resultados: ".mysql_num_rows($results)."(<a href='#' onclick='javascript:window.location.reload();'>Volver a calcular</a>)</p>";
	print_row(false);
	while ($row = mysql_fetch_array($results)) {

		$sku = $row[0];
		  
		$row['Compras'] = exec_query('por',$sku);
		$row['Ventas'] = exec_query('sos',$sku);
	
		print_row($row);
	}

		echo "</table>";
?>
