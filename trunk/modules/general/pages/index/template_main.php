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
//  Path: /modules/general/pages/index/template_main.php
//

// display alerts/error messages, if any since the toolbar is not shown
if ($messageStack->size > 0) echo $messageStack->output();
?>
<div class="shortcuts"> 
 <a title="Nueva venta" href="index.php?cat=orders&module=orders&jID=12&page=1" id="VentaShortcut">
  <div id="shortcut_icon">
    <img src="includes/shortcuts/cart.gif" border="0"/><p>Nueva <u>v</u>enta</p>
   </div> </a>
  <a title="Inventario" href="index.php?cat=inventory&module=main&page=1" id="InventarioShortcut">
  <div id="shortcut_icon">
    <img src="includes/shortcuts/barcode.jpg" border="0"/><p>Inventar<u>i</u>o</p>
  </div></a>
  <a title="Ingresar compra" href="index.php?cat=orders&module=orders&jID=6&page=1" id="CompraShortcut">
  <div id="shortcut_icon">
    <img src="includes/shortcuts/purchase.jpg" border="0"/><p>Ingresar <u>c</u>ompra</p>
  </div></a>
</div>
<script>

	var keys_ids = new Array();
	keys_ids["118"] = "#VentaShortcut"; //letra v corta
	keys_ids["105"] = "#InventarioShortcut";
	keys_ids["99"] = "#CompraShortcut";	
	function shortcut(key) {
		if (keys_ids[key])
			window.location = $(keys_ids[key]).attr("href");

	}
	
	$(document).bind('keydown', 'Ctrl+c', function() { shortcut(99);}); //nueva compra
	$(document).bind('keydown', 'Ctrl+v', function() { shortcut(118);}); //nueva venta
	$(document).bind('keydown', 'Ctrl+i', function() { shortcut(105);}); //ir a inventario

/* NO LO HAGO MAS ASI, USO EL PLUGIN DE HOTKEYS
	$(document).keypress(function(event) { 
					shortcut(event.charCode); 
				}
			 ); 
*/
</script>
<?php
echo html_control_panel($page_id, $cp_boxes);

?>
