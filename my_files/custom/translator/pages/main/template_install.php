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

echo $toolbar->build_toolbar();
?>
<input type="hidden" name="action" value="p_install" />
<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
<table align="center" id="container" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<th colspan="2">
			<?php echo TEXT_RELEASE_INFO; ?>
		</th>
	</tr>
	<tr>
		<td>
			<?php echo TEXT_FILENAME; ?>
		</td>
		<td>
			<?php echo $_GET['id']; ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo TEXT_RELEASE_NAME; ?>
		</td>
		<td>
			<input type="text" name="title" />
		</td>
	</tr>
	<tr>
		<td>
			<?php echo TEXT_LANGUAGE_TO_LOAD; ?>
		</td>
		<td>
			<input type="text" name="source_lang" value="<?php echo DEFAULT_LANGUAGE; ?>"/>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo TEXT_DESTINATION_LANGUAGE; ?>
		</td>
		<td>
			<input type="text" name="destination_lang" value="<?php echo DEFAULT_LANGUAGE; ?>"/>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo TEXT_EXPORT_TRANSLATED_ONLY; ?>
		</td>
		<td>
			<input type="checkbox" value="1" name="translated_only" />
		</td>
	</tr>
	<tr>
		<td>
			<?php echo TEXT_DESCRIPTION; ?>
		</td>
		<td>
			<input type="text" name="description" />
		</td>
	</tr>
	<tr>
		<th colspan="2"><?php echo TEXT_MODULES; ?></th>
	</tr>
	<tr>
		<td colspan="2">
			<table align="center" width="100%">
			<?php
			//foreach modules
			foreach($_SESSION['translation_modules'] as $key => $value)
			{
				?>
				<tr>
					<th>
						<div style="float:left"><?php echo $key; ?></div><div style="float:right"><input type="checkbox" name="<?php echo $key; ?>" value="1" checked="checked" onclick="checkAll(document.getElementById(\'translator\'), '<?php echo $key; ?>', this.checked);" /></div>
					</th>
				</tr>
				<?php
				foreach($value['files'] as $k => $file)
				{
					?> <tr>
							<td>
								<div style="float:left"><?php echo $file['file_name']; ?></div><div style="float:right"><input type="checkbox" class="<?php echo $key; ?>" name="<?php echo $key.'_'.$file['file_name']; ?>" value="1" checked="checked" /></div>
							</td>
						</tr>
				<?php
				}
			}
			?>
			</table>
		</td>
	</tr>
</table>
