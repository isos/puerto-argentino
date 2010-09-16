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
//  Path: /modules/orders/pages/popup_delivery/pre_process.php
//

/**************   Check user security   *****************************/
$security_level = (int)$_SESSION['admin_id']; // for popups, just make sure they are logged in
if ($security_level == 0) { // no permission to enter page, error and redirect to home page
  $messageStack->add_session(ERROR_NO_PERMISSION, 'error');
  gen_redirect(html_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

/**************  include page specific files  *********************/
require(DIR_FS_WORKING . 'language/' . $_SESSION['language'] . '/language.php');

/**************   page specific initialization  *************************/
$oID = (int)$_GET['oID'];
define('JOURNAL_ID',(int)$_GET['jID']);

$action = (isset($_GET['action']) ? $_GET['action'] : $_POST['todo']);

/***************   hook for custom actions  ***************************/
$custom_path = DIR_FS_MY_FILES . 'custom/accounts/popup_accts/extra_actions.php';
if (file_exists($custom_path)) { include($custom_path); }

/***************   Act on the action request   *************************/
switch ($action) {
  case 'save':
	$i = 1;
	while(true) {
		if (!isset($_POST['eta_date_' . $i])) break;
		if ($_POST['eta_date_' . $i] <> '') {
			$new_date = gen_db_date_short($_POST['eta_date_' . $i]);
			$rID = $_POST['id_' . $i];
			$db->Execute("update " . TABLE_JOURNAL_ITEM . " set date_1 = '" . $new_date . "' where id = " . $rID);
		}
		$i++;
	}
	gen_add_audit_log(ORD_DELIVERY_DATES . TEXT_EDIT, $result->fields['purchase_invoice_id']);
	break;
default:
}

/*****************   prepare to display templates  *************************/
$gl_type = (JOURNAL_ID == 4 || JOURNAL_ID == 6) ? 'poo' : 'soo';
$sql = " select m.purchase_invoice_id, i.id, i.sku, i.qty, i.description, i.date_1 
	from " . TABLE_JOURNAL_MAIN . " m inner join " . TABLE_JOURNAL_ITEM . " i on m.id = i.ref_id 
	where i.ref_id = " . $oID . " and i.gl_type = '" . $gl_type . "'";
$ordr_items = $db->Execute($sql);
$num_items = $ordr_items->RecordCount();

$include_header = false; // include header flag
$include_footer = true; // include footer flag
$include_tabs = false;
$include_calendar = true;

$include_template = 'template_main.php'; // include display template (required)
define('PAGE_TITLE', ORD_EXPECTED_DATES);

?>