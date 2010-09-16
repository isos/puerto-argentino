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
	<tr class="dataTableHeadingRow">
		<th colspan="2"><?php echo TEXT_INSTALLABLE_RELEASES; ?></th>
	</tr>
	<?php
		foreach($files as $file)
		{
	?>
		<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
			<td class="dataTableContent" onclick="document.location.href='index.php?cat=translator&module=main&action=install_options&id=<?php echo $file; ?>'">
				<?php echo $file; ?>
			</td>
			<td class="dataTableContent" onclick="document.location.href='index.php?cat=translator&module=main&action=install_options&id=<?php echo $file; ?>'">
				 <a href="index.php?cat=translator&module=main&action=installable_delete&id=<?php echo $file; ?>"><?php echo TEXT_DELETE; ?></a> | <a href="index.php?cat=translator&module=main&action=install_options&id=<?php echo $file; ?>"><?php echo TEXT_INSTALL; ?></a>
			</td>
		</tr>
	<?php
		}
	?>
	<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
		<td  class="dataTableContent" onclick="document.location.href='index.php?cat=translator&module=main&action=install_options&id=<?php echo $file; ?>'" colspan="2">
			<a href="index.php?cat=translator&module=main&action=install_options&id=current_installation"><?php echo TEXT_LOAD_CURRENT_PHREEBOOKS_INSTALLATION_LANGUAGE_FILES; ?></a>
		</td>
	</tr>
</table>
