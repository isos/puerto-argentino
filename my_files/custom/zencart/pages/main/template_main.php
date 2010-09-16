<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2010 PhreeSoft, LLC                               |
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
//  Path: /modules/zencart/pages/main/template_main.php
//

echo html_form('zencart', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);
echo html_hidden_field('todo', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['save']['show']     = false;
$toolbar->icon_list['print']['show']    = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;

//$toolbar->add_help('');
echo $toolbar->build_toolbar(); 
?>
<div class="pageHeading"><?php echo BOX_ZENCART_MODULE; ?></div>
  <table align="center" width="600" border="0" cellspacing="0" cellpadding="1">
	<tr><td colspan="2" align="right"><img src="<?php echo DIR_WS_ADMIN . 'my_files/custom/zencart/images/zen-cart-logo.png'; ?>"></td></tr>
    <tr><th colspan="2"><?php echo ZENCART_BULK_UPLOAD_TITLE; ?></th></tr>
    <tr><td colspan="2"><?php echo ZENCART_BULK_UPLOAD_INFO; ?></td></tr>
    <tr>
      <td align="right"><?php echo ZENCART_INCLUDE_IMAGES; ?></td>
      <td><?php echo html_checkbox_field('include_images', '1', false); ?></td>
    </tr>
    <tr>
      <td align="right"><?php echo ZENCART_BULK_UPLOAD_TEXT; ?></td>
      <td><?php echo html_button_field('bulkupload', ZENCART_BULK_UPLOAD_BTN, 'onclick="submitToDo(\'bulkupload\')"'); ?></td>
	</tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><th colspan="2"><?php echo ZENCART_PRODUCT_SYNC_TITLE; ?></th></tr>
    <tr><td colspan="2"><?php echo ZENCART_PRODUCT_SYNC_INFO; ?></td></tr>
    <tr>
      <td align="right"><?php echo ZENCART_PRODUCT_SYNC_TEXT; ?></td>
      <td><?php echo html_button_field('sync', ZENCART_PRODUCT_SYNC_BTN, 'onclick="submitToDo(\'sync\')"'); ?></td>
	</tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><th colspan="2"><?php echo ZENCART_SHIP_CONFIRM_TITLE; ?></th></tr>
    <tr><td colspan="2"><?php echo ZENCART_SHIP_CONFIRM_INFO; ?></td></tr>
    <tr>
      <td align="right"><?php echo ZENCART_TEXT_CONFIRM_ON; ?></td>
      <td><script language="javascript">shipDate.writeControl(); shipDate.displayLeft=true; shipDate.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script></td>
	</tr>
    <tr>
      <td align="right"><?php echo ZENCART_SHIP_CONFIRM_TEXT; ?></td>
      <td><?php echo html_button_field('confirm', ZENCART_SHIP_CONFIRM_BTN, 'onclick="submitToDo(\'confirm\')"'); ?></td>
	</tr>
  </table>
</form>
