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
<input type="hidden" name="action" value="p_mod" />
<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
<table align="center" id="container" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<th colspan="2">
			<?php echo TEXT_EDIT_RELEASE; ?>
		</th>
	</tr>
	<tr>
		<td>
			<?php echo TEXT_RELEASE; ?>
		</td>
		<td>
			<input type="text" name="title" value="<?php echo $release['title']; ?>" />
		</td>
	</tr>
	<tr>
		<td>
			<?php echo TEXT_DESCRIPTION; ?>
		</td>
		<td>
			<input type="text" name="description" value="<?php echo $release['description']; ?>" />
		</td>
	</tr>
	<tr>
		<td>
			<?php echo TEXT_DESTINATION_LANGUAGE; ?>
		</td>
		<td>
			<input type="text" name="destination_lang" value="<?php echo $release['destination_lang']; ?>" />
		</td>
	</tr>
	<tr>
		<td>
			<?php echo TEXT_EXPORT_TRANSLATED_ONLY; ?>
		</td>
		<td>
			<input type="checkbox" value="1" <?php echo ($release['translated_only'])?'checked="checked"':''; ?>/>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo TEXT_UPDATE_FROM_ALREADY_TRANSLATED; ?>
		</td>
		<td>
			<select name="update_from">
				<option value="0"><?php echo TEXT_CHOOSE; ?></option>
				<?php
				$sql = "SELECT * FROM " . TABLE_TRANSLATOR_RELEASES . "
						WHERE id != '".db_prepare_input($_GET['id'])."'
						ORDER BY title DESC";
				$result = $db->Execute($sql);
				while(!$result->EOF)
				{
					echo '<option value="'.$result->fields['id'].'">'.$result->fields['title'].'</option>';
					$result->MoveNext();
				}
				?>
			</select>
		</td>
	</tr>
	<?php
	$sql = "SELECT title,id AS module_id FROM ".TABLE_TRANSLATOR_MODULES." WHERE release_id = '".$db->prepare_input($_GET['id'])."'";
	$modules = $db->Execute($sql);
	while(!$modules->EOF)
	{
		?><tr class="dataTableHeadingRow">
			<th>
				<div style="float:left"><?php echo $modules->fields['title']; ?></div>
			</th>
			<th>
				<div style="float:right"><input type="radio" name="remove" value="m_<?php echo $modules->fields['module_id']; ?>" /></div>
			</th>
		</tr>
		<?php
		$sql = "SELECT file,id AS file_id FROM ".TABLE_TRANSLATOR_FILES." WHERE module = '".$modules->fields['module_id']."'";
		$files = $db->Execute($sql);
		while(!$files->EOF)
		{
			?><tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
				<td align="left" class="dataTableContent" onclick="">
					<?php echo $files->fields['file']; ?>
				</td>
				<td align="right" class="dataTableContent">
					<input type="radio" name="remove" value="f_<?php echo $files->fields['file_id']; ?>" />
				</td>
			</tr>
			<?php
			$files->MoveNext();
		}
		$modules->MoveNext();
	}
	?>
</table>
