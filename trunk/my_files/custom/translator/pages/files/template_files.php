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
<input type="hidden" name="action" value="p_files" />
<table width="90%" align="center" id="container" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<th colspan="4">
			 <?php echo $release['title'].' '.TEXT_RELEASE_FILES; ?>
		</th>
	</tr>
	<tr>
		<td colspan="2">
			<?php echo TEXT_SELECT_MODULE; ?> <select name="modules" onchange="this.form.submit()">
				<option value="0"><?php echo TEXT_ALL; ?></option>
				<?php
				$sql = "SELECT * FROM ".TABLE_TRANSLATOR_MODULES." WHERE release_id = '".db_prepare_input($_REQUEST['id'])."'";
				$modules = $db->Execute($sql);
				while(!$modules->EOF)
				{
					$selected = ($_REQUEST['modules'] == $modules->fields['id'])?' selected="selected"':'';
					?>
					<option<?php echo $selected; ?> value="<?php echo $modules->fields['id']; ?>"><?php echo $modules->fields['title']; ?></option>
					<?php
					$modules->MoveNext();
				}
				?>
			</select>
		</td>
	</tr>
	<tr class="dataTableHeadingRow">
		<th width="20%">
			<?php echo TEXT_MODULE_NAME; ?>
		</th>
		<th width="40%" align="center">
			<?php echo TEXT_FILENAME; ?>
		</th>
		<th width="20%" nowrap>
			<?php echo TEXT_LINES_PER_TRANSLATED; ?>
		</th>
		<th align="center">
			<?php echo TEXT_ACTION; ?>
		</th>
	</tr>
	<?php
	$osszesen = 0;
	$keszen = 0;
	foreach($files as $value)
	{
		$sql = "SELECT COUNT(id) AS all_string FROM " . TABLE_TRANSLATOR_TRANSLATIONS . " WHERE file = '".$value['id']."'";
		$all = $db->Execute($sql);
		$sql = "SELECT COUNT(id) AS translated FROM " . TABLE_TRANSLATOR_TRANSLATIONS . " WHERE file = '".$value['id']."' AND translated = '1'";
		$translated = $db->Execute($sql);
		if($all->fields['all_string'])
			$status = ($translated->fields['translated']/$all->fields['all_string']) * 100;
		else
			$status = 0;
		$osszesen += $all->fields['all_string'];
		$keszen += $translated->fields['translated'];
		?>
		<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
						<td class="dataTableContent" onclick="document.location.href='index.php?cat=translator&module=files&action=translate&id=<?php echo $value['id']; ?>&release=<?php echo $_REQUEST['id']; ?>'">
							<?php echo $value['title']; ?>
						</td>
						<td class="dataTableContent" onclick="document.location.href='index.php?cat=translator&module=files&action=translate&id=<?php echo $value['id']; ?>&release=<?php echo $_REQUEST['id']; ?>'">
							<?php echo $value['file']; ?>
						</td>
						<td class="dataTableContent" onclick="document.location.href='index.php?cat=translator&module=files&action=translate&id=<?php echo $value['id']; ?>&release=<?php echo $_REQUEST['id']; ?>'">
							<?php echo $all->fields['all_string'].'/'.$translated->fields['translated'].' ('.number_format($status,2); ?>)%
						</td>
						<td class="dataTableContent" onclick="document.location.href='index.php?cat=translator&module=files&action=translate&id=<?php echo $value['id']; ?>&release=<?php echo $_REQUEST['id']; ?>'">
							<a href="index.php?cat=translator&module=files&action=translate&id=<?php echo $value['id']; ?>&release=<?php echo $_REQUEST['id']; ?>"><?php echo TEXT_TRANSLATE; ?></a>
						</td>
					</tr>
		<?php
	}
	if($osszesen != 0)
		$teljes_keszultseg = ($keszen / $osszesen ) * 100;
		?>
		<tr>
					<td>
						<?php echo TEXT_ALL; ?>:
					</td>
					<td>&nbsp;</td>
					<td>
						<?php echo $osszesen .'/'.$keszen.' ('.number_format($teljes_keszultseg,2); ?>%)
					</td>
				</tr>
</table>
