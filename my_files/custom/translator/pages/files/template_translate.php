<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright (c) 2009 PhreeSoft, LLC                               |
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
//  Path: /modules/translator/pages/main/template_main.php
//

echo html_form('translator', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);

$toolbar->add_icon('search','onclick="document.translator.action.value=\'p_search\'; document.translator.submit();"');
echo $toolbar->build_toolbar();
?>
<input type="hidden" name="action" value="p_translate" />
<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
<input type="hidden" name="from" value="<?php echo $_REQUEST['from']; ?>" />
<input type="hidden" name="release" value="<?php echo $_REQUEST['release']; ?>" />
<table align="center" id="container" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<th colspan="6"><?php echo TEXT_TRANSLATABLE_STRINGS; ?> (<?php echo TEXT_MODULE_NAME.': '.$translator->getModuleNameForFile($_REQUEST['id']).'; '; echo TEXT_FILENAME.': '.$translator->getFilenameFromID($_REQUEST['id']); ?>)</th>
	</tr>
	<tr>
		<th width="2%">#</th>
		<th width="12%"><?php echo TEXT_KEY; ?></th>
		<th width="40%"><?php echo TEXT_ORIGINAL; ?></th>
		<th width="40%"><?php echo TEXT_VALUE; ?></th>
		<th width="3%"><?php echo TEXT_TRANSLATED; ?></th>
	</tr>
	<tr>
		<td></td>
		<td>
			<input type="text" name="defined_key" value="<?php echo $_REQUEST['defined_key']; ?>" />
		</td>
		<td><input type="text" name="original" value="<?php echo $_REQUEST['original']; ?>" /></td>
		<td><input type="text" name="translation" value="<?php echo $_REQUEST['translation']; ?>" /></td>
		<td>
			<select name="translated" onchange="this.form.submit()">
				<option value="2"><?php echo TEXT_ALL ?></option>
				<option value="1" <?php echo ($_REQUEST['translated'] == 1)?' selected="selected" ':''; ?>><?php echo TEXT_YES; ?></option>
				<option value="0" <?php echo ($_REQUEST['translated'] == 0 && $_REQUEST['translated'] != '')?' selected="selected" ':''; ?>><?php echo TEXT_NO; ?></option>
			</select>
		</td>
	</tr>
	<?php
		$i = 1;
		foreach($translations as $value)
		{
			$translated = ($value['translated'])?' checked="checked"':'';
			?>
			<tr class="<?php echo $translator->zebra(); ?>" >
							<td style="border-bottom:1px solid black">
								<?php echo $i; ?>.
							</td>
							<td style="border-bottom:1px solid black">
								<?php echo $value['defined_key']; ?>
							</td>
							<td style="border-bottom:1px solid black">
								<?php echo $value['original']; ?>
							</td>
							<td style="border-bottom:1px solid black">
								<textarea rows="2" cols="60" name="translation_<?php echo $value['id']; ?>"><?php echo $value['translation']; ?></textarea>
							</td>
							<td style="border-bottom:1px solid black">
								<input type="checkbox" value="1" name="translated_<?php echo $value['id']; ?>"<?php echo $translated; ?>>
							</td>
						</tr>
		<?php
			$i++;
		}
		?>
</table>
