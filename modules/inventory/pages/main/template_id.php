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
//  Path: /modules/inventory/pages/cat_inv/template_id.php
//

echo html_form('inventory', FILENAME_DEFAULT, gen_get_all_get_params(array('action')));
echo html_hidden_field('todo', '') . chr(10);
// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action','module')) . '&amp;module=main', 'SSL') . '\'"';
$toolbar->icon_list['open']['show'] = false;
$toolbar->icon_list['delete']['show'] = false;
$toolbar->icon_list['save']['show'] = false;
$toolbar->icon_list['print']['show'] = false;
$toolbar->add_icon('continue', 'onclick="submitToDo(\'create\')"', $order = 10);
$toolbar->add_help('07.04.01.01');
echo $toolbar->build_toolbar(); 
?>
  <div class="pageHeading"><?php echo INV_HEADING_NEW_ITEM; ?></div>
  <table width="500" align="center" cellspacing="0" cellpadding="1">
    <tr>
	  <th nowrap="nowrap" colspan="2"><?php echo INV_ENTER_SKU; ?></th>
    </tr>
    <tr>
	  <td class="main" align="right"><?php echo TEXT_SKU; ?></td>
	  <td class="main"><?php echo html_input_field('sku', $sku, 'size="' . (MAX_INVENTORY_SKU_LENGTH + 2) . '" maxlength="' . MAX_INVENTORY_SKU_LENGTH . '"'); ?></td>
    </tr>
    <tr>
	  <td class="main" align="right"><?php echo INV_ENTRY_INVENTORY_TYPE; ?></td>
	  <td class="main"><?php echo html_pull_down_menu('inventory_type', gen_build_pull_down($inventory_types), isset($inventory_type) ? $inventory_type : 'si', 'onchange="setSkuLength()"'); ?></td>
    </tr>
    <tr>
	  <td class="main" align="right"><?php echo INV_ENTRY_INVENTORY_COST_METHOD; ?></td>
	  <td class="main"><?php echo html_pull_down_menu('cost_method', gen_build_pull_down($cost_methods), isset($cost_method) ? $cost_method : 'f'); ?></td>
	  <script> 
	/* por default, marco la opcion LIFO*/
		$("#cost_method option[value='l']").attr('selected', 'selected');

	/* si al ingresar el sku/codigo de barras, ingresan un enter (a mano o lo hace el lector), 	se ejecutará un submit del formulario para que vaya al siguiente*/
		$("#sku").keydown(function(event) {
			if (event.keyCode == '13') {
			     event.preventDefault();
			     submitToDo('create')
			   }
		});
	  </script>
    </tr>
    <tr>
	  <td nowrap="nowrap" colspan="2"><?php echo '&nbsp;'; ?></td>
    </tr>
  </table>
</form>
