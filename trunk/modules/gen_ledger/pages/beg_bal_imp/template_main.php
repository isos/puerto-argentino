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
//  Path: /modules/gen_ledger/pages/beg_bal_imp/template_main.php
//

// start the form
echo html_form('beg_bal_imp', FILENAME_DEFAULT, gen_get_all_get_params(array('action')), 'post', 'enctype="multipart/form-data"') . chr(10);

// include hidden fields
echo html_hidden_field('todo', '') . chr(10);

// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, 'cat=gen_ledger&amp;module=beg_bal', 'SSL') . '\'"';
$toolbar->icon_list['open']['show'] = false;
$toolbar->icon_list['save']['show'] = false;
$toolbar->icon_list['delete']['show'] = false;
$toolbar->icon_list['print']['show'] = false;

// pull in extra toolbar overrides and additions
if (count($extra_toolbar_buttons) > 0) {
	foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
}

// add the help file index and build the toolbar
$toolbar->add_help('03.04.02');
echo $toolbar->build_toolbar();

// Build the page
?>
<div class="pageHeading"><?php echo GL_HEADING_IMPORT_BEG_BALANCES; ?></div>
<table align="center" border="1" cellspacing="0" cellpadding="1">
  <tr>
	<td align="center"><?php echo '<h3>' . GL_BB_IMPORT_INVENTORY . '</h3>' . GL_BB_IMPORT_HELP_MSG; ?></td>
	<td align="center">
		<?php echo html_file_field('file_name_inv') . '<br /><br />'; ?>
		<?php echo html_submit_field('import_inv', GL_BB_IMPORT_INVENTORY); ?>
	</td>
  </tr>
  <tr>
	<td align="center"><?php echo '<h3>' . GL_BB_IMPORT_PURCH_ORDERS . '</h3>' . GL_BB_IMPORT_HELP_MSG; ?></td>
	<td align="center">
		<?php echo html_file_field('file_name_po') . '<br /><br />'; ?>
		<?php echo html_submit_field('import_po', GL_BB_IMPORT_PURCH_ORDERS); ?>
	</td>
  </tr>
  <tr>
	<td align="center"><?php echo '<h3>' . GL_BB_IMPORT_PAYABLES . '</h3>' . GL_BB_IMPORT_HELP_MSG; ?></td>
	<td align="center">
		<?php echo html_file_field('file_name_ap') . '<br /><br />'; ?>
		<?php echo html_submit_field('import_ap', GL_BB_IMPORT_PAYABLES); ?>
	</td>
  </tr>
  <tr>
	<td align="center"><?php echo '<h3>' . GL_BB_IMPORT_SALES_ORDERS . '</h3>' . GL_BB_IMPORT_HELP_MSG; ?></td>
	<td align="center">
		<?php echo html_file_field('file_name_so') . '<br /><br />'; ?>
		<?php echo html_submit_field('import_so', GL_BB_IMPORT_SALES_ORDERS); ?>
	</td>
  </tr>
  <tr>
	<td align="center"><?php echo '<h3>' . GL_BB_IMPORT_RECEIVABLES . '</h3>' . GL_BB_IMPORT_HELP_MSG; ?></td>
	<td align="center">
		<?php echo html_file_field('file_name_ar') . '<br /><br />'; ?>
		<?php echo html_submit_field('import_ar', GL_BB_IMPORT_RECEIVABLES); ?>
	</td>
  </tr>
</table>
</form>