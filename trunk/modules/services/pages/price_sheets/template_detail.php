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
//  Path: /modules/services/pages/price_sheets/template_detail.php
//

// start the form
echo html_form('pricesheet', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);
$hidden_fields = NULL;

// include hidden fields
echo html_hidden_field('id', $id);
echo html_hidden_field('todo', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'SSL') . '\'"';
$toolbar->icon_list['open']['show']     = false;
if ($security_level > 1) {
  $toolbar->icon_list['save']['params'] = 'onclick="submitToDo(\'' . (($action == 'new') ? 'save' : 'update') . '\')"';
} else {
  $toolbar->icon_list['save']['show']   = false;
}
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['print']['show']    = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('07.04.06');
echo $toolbar->build_toolbar(); 

// Build the page
?>
<div class="pageHeading"><?php echo ($action == 'new') ? PRICE_SHEET_NEW_TITLE : PRICE_SHEET_EDIT_TITLE . $sheet_name . ' (' . TEXT_REVISION . ' ' . $revision . ')'; ?></div>
<table align="center" width="400" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="main"><?php echo PRICE_SHEET_NAME; ?></td>
    <td class="main"><?php echo html_input_field('sheet_name', $sheet_name, '', false); ?></td>
    <td class="main" align="right"><?php echo TEXT_REVISION; ?></td>
    <td class="main"><?php echo html_input_field('revision', $revision, 'readonly="readonly" size="5"', false); ?></td>
  </tr>
  <tr>
    <td class="main"><?php echo TEXT_EFFECTIVE_DATE; ?></td>
    <td class="main">
<script type="text/javascript">datePost.writeControl(); datePost.dateFormat="<?php echo DATE_FORMAT_SPIFFYCAL; ?>";</script>
	</td>
    <td class="main" align="right"><?php echo TEXT_USE_AS_DEFAULT; ?></td>
    <td class="main"><?php echo html_checkbox_field('default_sheet', '1', ($default_sheet) ? ' checked' : ''); ?></td>
  </tr>
<?php if (ENABLE_MULTI_CURRENCY) echo '<tr><td colspan="4" class="fieldRequired" align="center"> ' . sprintf(GEN_PRICE_SHEET_CURRENCY_NOTE, $currencies->currencies[DEFAULT_CURRENCY]['title']) . '</td></tr>'; ?>
  <tr>
    <td colspan="4"><table width="100%" border="1" cellspacing="1" cellpadding="1">
      <tr class="dataTableHeadingRow">
        <td align="center"><?php echo TEXT_LEVEL;      ?></td>
        <td align="center"><?php echo TEXT_QUANTITY;   ?></td>
        <td align="center"><?php echo TEXT_SOURCE;     ?></td>
        <td align="center"><?php echo TEXT_ADJUSTMENT; ?></td>
        <td align="center"><?php echo INV_ADJ_VALUE;   ?></td>
        <td align="center"><?php echo INV_ROUNDING;    ?></td>
        <td align="center"><?php echo INV_RND_VALUE;   ?></td>
        <td align="center"><?php echo TEXT_PRICE;      ?></td>
      </tr>
<?php
	$price_levels = explode(';', $default_levels);
	// remove the last element from the price level source array (Level 1 price source)
	$first_source_list = $price_mgr_sources;
	array_shift($first_source_list);
	array_pop($first_source_list);
	for ($i = 0, $j = 1; $i < MAX_NUM_PRICE_LEVELS; $i++, $j++) {
		$level_info = explode(':', $price_levels[$i]);
		$price = $currencies->precise($level_info[0] ? $level_info[0] : (($i == 0) ? $full_price : 0));
		$qty     = $level_info[1] ? $level_info[1] : $j;
		$src     = $level_info[2] ? $level_info[2] : 0;
		$adj     = $level_info[3] ? $level_info[3] : 0;
		$adj_val = $level_info[4] ? $level_info[4] :'0';
		$rnd     = $level_info[5] ? $level_info[5] : 0;
		$rnd_val = $level_info[6] ? $level_info[6] :'0';
		echo '<tr>' . chr(10);
		echo '<td align="center">' . $j . '</td>' . chr(10);
		echo '<td>' . html_input_field('qty_' .     $j, $qty, 'size="10" onchange="updatePrice()" style="text-align:right"') . '</td>' . chr(10);
		echo '<td>' . html_pull_down_menu('src_' .  $j, gen_build_pull_down(($i==0) ? $first_source_list : $price_mgr_sources), $src, 'onchange="updatePrice()"') . '</td>' . chr(10);
		echo '<td>' . html_pull_down_menu('adj_' .  $j, gen_build_pull_down($price_mgr_adjustments), $adj, 'disabled="disabled" onchange="updatePrice()"') . '</td>' . chr(10);
		echo '<td>' . html_input_field('adj_val_' . $j, $currencies->format($adj_val), 'disabled="disabled" size="10" onchange="updatePrice()" style="text-align:right"') . '</td>' . chr(10);
		echo '<td>' . html_pull_down_menu('rnd_' .  $j, gen_build_pull_down($price_mgr_rounding), $rnd, 'disabled="disabled" onchange="updatePrice()"') . '</td>' . chr(10);
		echo '<td>' . html_input_field('rnd_val_' . $j, $currencies->precise($rnd_val), 'disabled="disabled" size="10" onchange="updatePrice()" style="text-align:right"') . '</td>' . chr(10);
		echo '<td>' . html_input_field('price_' .   $j, $currencies->format($price), 'onchange="updatePrice()" style="text-align:right"') . '</td>' . chr(10);
		echo '</tr>' . chr(10);
	}
	$hidden_fields = '<script type="text/javascript">initEditForm()</script>' . chr(10);
?>
    </table></td>
  </tr>
</table>
<?php // display the hidden fields that are not used in this rendition of the form
echo $hidden_fields;
?>
</form>