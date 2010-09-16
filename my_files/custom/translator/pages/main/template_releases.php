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
<table align="center" id="container" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<th colspan="3"><?php echo TEXT_INSTALLED_RELEASES; ?></th>
	</tr>
  <tr class="dataTableHeadingRow">
	<th width="20%"><?php echo TEXT_RELEASES; ?></th>
	<th width="20%"><?php echo TEXT_CONVERSION_STATISTICS; ?></th>
	<th width="20%"><?php echo TEXT_ACTION; ?></th>
  </tr>
  <?php
	$sql = "SELECT * FROM " . TABLE_TRANSLATOR_RELEASES . " ORDER BY title ASC";
	$result = $db->Execute($sql);
	while(!$result->EOF)
	{
		$sql = "SELECT COUNT(t.id) AS all_string FROM " . TABLE_TRANSLATOR_TRANSLATIONS . " t
				JOIN " . TABLE_TRANSLATOR_FILES . " f ON f.id = t.file AND f.release_id = '".$result->fields['id']."'
				";
		$all = $db->Execute($sql);

		$sql = "SELECT COUNT(t.id) AS translated FROM " . TABLE_TRANSLATOR_TRANSLATIONS . " t
				JOIN " . TABLE_TRANSLATOR_FILES . " f ON f.id = t.file AND f.release_id = '".$result->fields['id']."' AND translated = '1'
				";
		$translated = $db->Execute($sql);

		if($all->fields['all_string'])
			$status = ($translated->fields['translated']/$all->fields['all_string']) * 100;
		else
			$status = 0;
		?><tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
						<td class="dataTableContent" onclick="document.location.href='index.php?cat=translator&module=files&action=files&id=<?php echo $result->fields['id']; ?>'">
							<?php echo $result->fields['title']; ?>
						</td>
						<td class="dataTableContent" onclick="document.location.href='index.php?cat=translator&module=files&action=files&id=<?php echo $result->fields['id']; ?>'">
							<?php echo $all->fields['all_string'].'/'.$translated->fields['translated'].' ('.number_format($status,2).'%'; ?>)
						</td>
						<td class="dataTableContent" onclick="document.location.href='index.php?cat=translator&module=files&action=files&id=<?php echo $result->fields['id']; ?>'">
							<a href="index.php?cat=translator&module=main&action=mod&id=<?php echo $result->fields['id']; ?>"><?php echo TEXT_EDIT; ?></a> | <a href="index.php?cat=translator&module=export&action=options&id=<?php echo $result->fields['id']; ?>"><?php echo TEXT_EXPORT; ?></a> | <a href="index.php?cat=translator&module=files&action=files&id=<?php echo $result->fields['id']; ?>"><?php echo TEXT_TRANSLATE; ?></a>
						</td>
					</tr><?php
	$result->MoveNext();
	} ?>
</table>
