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
//  Path: /modules/inventory/pages/tools/template_main.php
//

// start the form
echo html_form('tools', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['print']['show']    = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
  foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('01');
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo BOX_INV_TOOLS; ?></div>
<fieldset>
<legend><?php echo INV_TOOLS_VALIDATE_INVENTORY; ?></legend>
<p><?php echo INV_TOOLS_VALIDATE_INV_DESC; ?></p>
  <table align="center" border="0" cellspacing="2" cellpadding="1">
    <tr>
	  <th><?php echo INV_TOOLS_REPAIR_TEST; ?></th>
	  <th><?php echo INV_TOOLS_REPAIR_FIX; ?></th>
	</tr>
	<tr>
	  <td align="center"><?php echo html_button_field('inv_hist_test', INV_TOOLS_BTN_TEST, 'onclick="submitToDo(\'inv_hist_test\')"'); ?></td>
	  <td align="center"><?php echo html_button_field('inv_hist_fix', INV_TOOLS_BTN_REPAIR, 'onclick="if (confirm(\'' . INV_TOOLS_REPAIR_CONFIRM . '\')) submitToDo(\'inv_hist_fix\')"'); ?></td>
	</tr>
  </table>
</fieldset>
<fieldset>
<legend><?php echo INV_TOOLS_VALIDATE_SO_PO; ?></legend>
<p><?php echo INV_TOOLS_VALIDATE_SO_PO_DESC; ?></p>
  <table align="center" border="0" cellspacing="2" cellpadding="1">
    <tr>
	  <th><?php echo INV_TOOLS_REPAIR_SO_PO; ?></th>
	</tr>
	<tr>
	  <td align="center"><?php echo html_button_field('inv_on_order_fix', INV_TOOLS_BTN_SO_PO_FIX, 'onclick="submitToDo(\'inv_on_order_fix\')"'); ?></td>
	</tr>
  </table>
</fieldset>
</form>

<hr/>
<h3> Etiquetas para imprimir </h3>
<div>
	<label for="nueva_etiqueta">Agregar</label><input type="text" name="nueva_etiqueta" id="nueva_etiqueta" onkeypress> <br/>
	<a href="#" onclick="imprimir_listado(); return false;"> Imprimir listado </a>
</div>
<br/>
<table id="etiquetas_pendientes">
<?php
foreach ( $etiquetas_pendientes as $sku_id => $item) { ?>
       <tr id="<?php echo $item['sku']; ?>"> 
       		<td> <?php echo $item['sku']; ?> </td>
       		<td> <?php echo $item['precio']; ?> </td>
       		<td> <?php echo $item['descripcion']; ?> </td>
       		<td> <a href="#" onclick="eliminar_pendiente('<?php echo $item['sku']; ?>'); return false;"> Eliminar </td>
       	</tr>	
<?php } ?>
</table>
<div>
	<a href="#" onclick="vaciar_listado(); return false;">Vaciar listado</a> 
</div>

<script>
	function eliminar_pendiente(sku) { 
		url = "index.php?cat=inventory&module=ajax&op=etiquetas_pendientes&action=remove&sku=" +sku;
		$.post(url, function(data){ $("#"+sku).fadeOut().remove(); });
	}
	
	function agregar_pendiente(sku) {
		url = "index.php?cat=inventory&module=ajax&op=etiquetas_pendientes&action=add&sku=" +sku;
		$.getJSON(url,
			  function(json){
			  	$("#etiquetas_pendientes").append("<tr id='"+json['sku']+"'> <td>"+json['sku']+"</td><td>"+json.precio+"</td><td>"+json.descripcion+"</td><td> <a href='#' onclick='eliminar_pendiente(\""+json.sku+"\"); return false;\'> Eliminar </td></tr>"); 
  		});
		
	}
	
	function vaciar_listado(){ 
		url = "index.php?cat=inventory&module=ajax&op=etiquetas_pendientes&action=remove_all";
		if (confirm("¿Esta seguro que desea eliminar todas las etiquetas pendientes?")) {
				$.post(url, function(msg){ if (msg == "success") $("#etiquetas_pendientes tr").remove(); });
		}
		
	}
	
	function imprimir_listado() { 
		url = "index.php?cat=inventory&module=ajax&op=etiquetas_pendientes&action=get_all";
		window.open(url, "_BLANK",'width=595,height=892,menubar=no,resizable=yes,scrollbars=yes,directories=no');

	}
	$(document).ready(function(){
		
		$("#nueva_etiqueta").keypress(function(event) {
			  if ( event.which == 13 ) {
			     event.preventDefault();
			     $input = $(event.target);
			     agregar_pendiente($input.val());
			     $input.val("");
			   }
			});
	 })
</script>