<?php
echo html_form('translator', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);
echo $toolbar->build_toolbar();
?>
<div class="pageHeading"><?php echo BOX_TRANSLATOR_MAINTAIN; ?></div>
<table align="center" id="container" border="0" cellpadding="0" cellspacing="0">

<input type="hidden" name="action" value="p_export" />
<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
<table align="center">
	<tr>
		<th colspan="2">
			<?php echo TEXT_EXPORT_OPTIONS; ?>
		</th>
	</tr>
	<tr>
		<td>
			<?php echo TEXT_EXPORT_TO; ?>
		</td>
		<td>
			<select name="export_to">
				<option value="current_installation"><?php echo TEXT_CURRENT_INSTALLATION; ?></option>
				<option value="zip"><?php echo TEXT_ZIP; ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td><?php echo TEXT_EXPORT_AS_LANGUAGE; ?></td>
		<td><input type="text" size="5" name="language" value="<?php echo $release['destination_lang']; ?>" /></td>
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
				<div style="float:right"><input type="checkbox" name="module_<?php echo $modules->fields['module_id']; ?>" value="1" checked="checked" onclick="checkAll(document.getElementById('translator'), '<?php echo $modules->fields['title']; ?>', this.checked);" /></div>
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
				<td align="right" class="dataTableContent" onclick="">
					<input type="checkbox" class="<?php echo $modules->fields['title']; ?>" name="files[]" value="<?php echo $files->fields['file_id'];?>" checked="checked" />
				</td>
			</tr>
			<?php
			$files->MoveNext();
		}
		$modules->MoveNext();
	}
	?>
</table>
