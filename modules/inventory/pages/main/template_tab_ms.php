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
//  Path: /modules/inventory/pages/main/template_tab_ms.php
//

// start the master stock tab html
?>
<div id="MSTR" class="tabset_content">
  <h2 class="tabset_label"><?php echo INV_MS_ATTRIBUTES; ?></h2>
  <table width="500" align="center" border="0" cellspacing="0" cellpadding="1">
    <tr>
	  <td class="main">
	    <table align="center" cellspacing="0" cellpadding="1">
		  <tr>
		    <th colspan="2"><?php echo INV_TEXT_ATTRIBUTE_1; ?></th>
		  </tr>
		  <tr>
		    <td class="main"><?php echo TEXT_TITLE; ?></td>
		    <td class="main"><?php echo html_input_field('attr_name_0', $cInfo->attr_name_0, 'size="11" maxlength="10" onchange="masterStockTitle(0)"'); ?></td>
		  </tr>
		  <tr>
		    <td colspan="2" class="main"><?php echo INV_MASTER_STOCK_ATTRIB_ID . ' '; ?>
				<?php echo html_input_field('attr_id_0', '', 'size="3" maxlength="2"', true); ?>
				<?php echo html_button_field('attr_add_0', TEXT_ADD, 'onclick="masterStockBuildList(\'add\', 0)"', 'SSL'); ?>
			</td>
		  </tr>
		  <tr>
		    <td class="main"><?php echo TEXT_DESCRIPTION; ?></td>
		    <td class="main"><?php echo html_input_field('attr_desc_0', '', '', true); ?></td>
		  </tr>
		  <tr>
		    <th colspan="2"><?php echo INV_TEXT_ATTRIBUTES; ?></th>
		  </tr>
		  <tr>
      		<td align="center" colspan="2" class="main">
  			  <table border="0" cellspacing="0" cellpadding="0">
			    <tr>
				  <td><?php echo html_pull_down_menu('attr_index_0', $attr_array0, '', 'size="5"'); ?></td>
				  <td valign="top"><?php echo html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="masterStockBuildList(\'delete\', 0)"') . chr(10); ?></td>
				</tr>
		      </table>
			</td>
		  </tr>
	    </table>
      </td>
	  <td>&nbsp;</td>
	  <td class="main">
	    <table align="center" cellspacing="0" cellpadding="1">
		  <tr>
		    <th colspan="2"><?php echo INV_TEXT_ATTRIBUTE_2; ?></th>
		  </tr>
		  <tr>
		    <td class="main"><?php echo TEXT_TITLE; ?></td>
		    <td class="main"><?php echo html_input_field('attr_name_1', $cInfo->attr_name_1, 'size="11" maxlength="10" onchange="masterStockTitle(1)"'); ?></td>
		  </tr>
		  <tr>
		    <td colspan="2" class="main"><?php echo INV_MASTER_STOCK_ATTRIB_ID . ' '; ?>
				<?php echo html_input_field('attr_id_1', '', 'size="3" maxlength="2"', true); ?>
				<?php echo html_button_field('attr_add_1', TEXT_ADD, 'onclick="masterStockBuildList(\'add\', 1)"', 'SSL'); ?>
			</td>
		  </tr>
		  <tr>
		    <td class="main"><?php echo TEXT_DESCRIPTION; ?></td>
		    <td class="main"><?php echo html_input_field('attr_desc_1', '', '', true); ?></td>
		  </tr>
		  <tr>
		    <th colspan="2"><?php echo INV_TEXT_ATTRIBUTES; ?></th>
		  </tr>
		  <tr>
      		<td align="center" colspan="2" class="main">
  			  <table border="0" cellspacing="0" cellpadding="0">
			    <tr>
				  <td><?php echo html_pull_down_menu('attr_index_1', $attr_array1, '', 'size="5"'); ?></td>
				  <td valign="top"><?php echo html_icon('emblems/emblem-unreadable.png', TEXT_DELETE, 'small', 'onclick="masterStockBuildList(\'delete\', 1)"') . chr(10); ?></td>
				</tr>
		      </table>
			</td>
		  </tr>
	    </table>
      </td>
    </tr>
  </table>
  <table id="sku_list" width="500" align="center" border="1" cellspacing="0" cellpadding="1">
    <tr>
	  <td colspan="3" align="center"><?php echo INV_MS_CREATED_SKUS; ?></td>
    </tr>
    <tr>
	  <th class="main"><?php echo TEXT_SKU; ?></th>
	  <th class="main"><?php echo '&nbsp;'; ?></th>
	  <th class="main"><?php echo '&nbsp;'; ?></th>
    </tr>
  </table>
</div>
