<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2010 PhreeSoft, LLC                          |
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
//  Path: /modules/zencart/pages/admin/template_main.php
//

// start the form
echo html_form('zencart_admin', FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'post', '', true) . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['params']   = 'onclick="submitToDo(\'save\')"';
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['print']['show']    = false;
echo $toolbar->build_toolbar();

// Build the page
?>
<div class="pageHeading"><?php echo PAGE_TITLE; ?></div>
<fieldset>
<legend><?php echo MODULE_ZENCART_CONFIG_HEADING; ?></legend>
<table width="600" align="center" border="1" cellspacing="1" cellpadding="1">
  <tr><th colspan="2"><?php echo MODULE_ZENCART_CONFIG_INFO; ?></th></tr> 
  <tr>
    <td><?php echo ZENCART_ADMIN_URL; ?></td>
    <td><?php echo html_input_field('zencart_url', $url ? $url : 'http://', 'size="64"'); ?></td>
  </tr>
  <tr>
    <td><?php echo ZENCART_ADMIN_USERNAME; ?></td>
    <td><?php echo html_input_field('zencart_username', $username ? $username : '', ''); ?></td>
  </tr>
  <tr>
    <td><?php echo ZENCART_ADMIN_PASSWORD; ?></td>
    <td><?php echo html_password_field('zencart_password', $password ? $password : '', ''); ?></td>
  </tr>
  <tr>
    <td><?php echo ZENCART_TAX_CLASS; ?></td>
    <td><?php echo html_input_field('zencart_tax_class', $tax_class ? $tax_class : '', 'size="40"'); ?></td>
  </tr>
  <tr>
    <td><?php echo ZENCART_USE_PRICES; ?></td>
    <td><?php echo html_checkbox_field('zencart_use_prices', '1', $use_prices ? true : false, '', 'onclick="togglePriceSheets()"'); ?></td>
  </tr>
  <tr id="price_sheet_row">
    <td><?php echo ZENCART_TEXT_PRICE_SHEET; ?></td>
    <td><?php echo html_pull_down_menu('zencart_price_sheet', pull_down_price_sheet_list(), $price_sheet ? $price_sheet : '', ''); ?></td>
  </tr>
  <tr>
    <td><?php echo ZENCART_SHIP_ID; ?></td>
    <td><?php echo html_input_field('zencart_shipped_id', $shipped_id ? $shipped_id : '', 'size="3"'); ?></td>
  </tr>
  <tr>
    <td><?php echo ZENCART_PARTIAL_ID; ?></td>
    <td><?php echo html_input_field('zencart_partial_id', $partial_id ? $partial_id : '', 'size="3"'); ?></td>
  </tr>
</table>
</fieldset>
</form>