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
//  Path: /modules/accounts/pages/main/js_include.php
//

?>
<script type="text/javascript">
<!--
// pass any php variables generated during pre-process that are used in the javascript functions.
// Include translations here as well.
ajaxRH["contactList"] = "fillContacts";
ajaxRH["fillContact"] = "fillContactFields";

// Insert javscript file references here.
<?php echo $contact_js; ?>
<?php echo $js_pmt_array; ?>

function init() {
  cssjsmenu('navbar');
  SetDisabled();

<?php if ($include_template == 'template_main.php') {
 	echo '  document.getElementById("search_text").focus();'  . chr(10); 
  	echo '  document.getElementById("search_text").select();' . chr(10); 
  }
?>
  if (window.extra_init) { extra_init() } // hook for additional initializations
}

function check_form() {
  var error = 0;
  var error_message = "<?php echo JS_ERROR; ?>";

  <?php if (!$auto_type && ($action == 'edit' || $action == 'update' || $action == 'new')) { ?> // if showing the edit/update detail form
  var acctId = document.getElementById('short_name').value;
    if (acctId == '') {
      error_message += "<?php echo ACT_JS_SHORT_NAME; ?>";
	  error = 1;
    }
  <?php } ?>

  if (error == 1) {
    alert(error_message);
    return false;
  } else {
    return true;
  }
}

// Insert other page specific functions here.
function changeOptions() {
	LoadDefaults();
	SetDisabled();
}

function LoadDefaults() {
  if (document.accounts.special_terms[0].checked) {
	document.getElementById('early_percent').value = '<?php echo constant($terms_type . "_PREPAYMENT_DISCOUNT_PERCENT"); ?>';
	document.getElementById('early_days').value = '<?php echo constant($terms_type . "_PREPAYMENT_DISCOUNT_DAYS"); ?>';
	document.getElementById('standard_days').value = '<?php echo constant($terms_type . "_NUM_DAYS_DUE"); ?>';
  } else if (document.accounts.special_terms[1].checked) {
	document.getElementById('early_percent').value = '';
	document.getElementById('early_days').value = '';
	document.getElementById('standard_days').value = '';
  } else if (document.accounts.special_terms[2].checked) {
	document.getElementById('early_percent').value = '';
	document.getElementById('early_days').value = '';
	document.getElementById('standard_days').value = '';
  } else if (document.accounts.special_terms[3].checked) {
	document.getElementById('early_percent').value = '<?php echo constant($terms_type . "_PREPAYMENT_DISCOUNT_PERCENT"); ?>';
	document.getElementById('early_days').value = '<?php echo constant($terms_type . "_PREPAYMENT_DISCOUNT_DAYS"); ?>';
	document.getElementById('standard_days').value = '<?php echo constant($terms_type . "_NUM_DAYS_DUE"); ?>';
  } else if (document.accounts.special_terms[4].checked) {
	document.getElementById('early_percent').value = '<?php echo constant($terms_type . "_PREPAYMENT_DISCOUNT_PERCENT"); ?>';
	document.getElementById('early_days').value = '<?php echo constant($terms_type . "_PREPAYMENT_DISCOUNT_DAYS"); ?>';
	document.getElementById('standard_days').value = '';
  } else if (document.accounts.special_terms[5].checked) {
	document.getElementById('early_percent').value = '<?php echo constant($terms_type . "_PREPAYMENT_DISCOUNT_PERCENT"); ?>';
	document.getElementById('early_days').value = '<?php echo constant($terms_type . "_PREPAYMENT_DISCOUNT_DAYS"); ?>';
	document.getElementById('standard_days').value = '';
  }
  document.accounts.elements['due_date'].value = '';
}

function SetDisabled() {
  if (!document.accounts.special_terms) return;
  if (document.accounts.special_terms[1].checked) {
	document.getElementById('early_percent').disabled = true;
	document.getElementById('early_days').disabled    = true;
	document.getElementById('standard_days').disabled = true;
	document.accounts.elements['due_date'].disabled   = true;
  } else if (document.accounts.special_terms[2].checked) {
	document.getElementById('early_percent').disabled = true;
	document.getElementById('early_days').disabled    = true;
	document.getElementById('standard_days').disabled = true;
	document.accounts.elements['due_date'].disabled   = true;
  } else if (document.accounts.special_terms[3].checked) {
	document.getElementById('early_percent').disabled = false;
	document.getElementById('early_days').disabled    = false;
	document.getElementById('standard_days').disabled = false;
	document.accounts.elements['due_date'].disabled   = true;
  } else if (document.accounts.special_terms[4].checked) {
	document.getElementById('early_percent').disabled = false;
	document.getElementById('early_days').disabled    = false;
	document.getElementById('standard_days').disabled = true;
	document.accounts.elements['due_date'].disabled   = false;
  } else if (document.accounts.special_terms[5].checked) {
	document.getElementById('early_percent').disabled = false;
	document.getElementById('early_days').disabled    = false;
	document.getElementById('standard_days').disabled = true;
	document.accounts.elements['due_date'].disabled   = true;
  } else {
	document.getElementById('early_percent').disabled = true;
	document.getElementById('early_days').disabled    = true;
	document.getElementById('standard_days').disabled = true;
	document.accounts.elements['due_date'].disabled   = true;
  }
}

function addressRecord(address_id, primary_name, contact, address1, address2, city_town, state_province, postal_code, country_code, telephone1, telephone2, telephone3, telephone4, email, website, notes) {
	this.address_id     = address_id;
	this.primary_name   = primary_name;
	this.contact        = contact;
	this.address1       = address1;
	this.address2       = address2;
	this.city_town      = city_town;
	this.state_province = state_province;
	this.postal_code    = postal_code;
	this.country_code   = country_code;
	this.telephone1     = telephone1;
	this.telephone2     = telephone2;
	this.telephone3     = telephone3;
	this.telephone4     = telephone4;
	this.email          = email;
	this.website        = website;
	this.notes          = notes;
}

function pmtRecord(id, hint, name, card_num, exp_month, exp_year, cvv2) {
	this.id        = id;
	this.hint      = hint;
	this.name      = name;
	this.card_num  = card_num;
	this.exp_month = exp_month;
	this.exp_year  = exp_year;
	this.cvv2      = cvv2;
}

function editRow(type, id) {
  // replace form fields with field data
  document.getElementById(type+'_address_id').value     = id;
  document.getElementById(type+'_primary_name').value   = addBook[id].primary_name;
  document.getElementById(type+'_contact').value        = addBook[id].contact;
  document.getElementById(type+'_address1').value       = addBook[id].address1;
  document.getElementById(type+'_address2').value       = addBook[id].address2;
  document.getElementById(type+'_city_town').value      = addBook[id].city_town;
  document.getElementById(type+'_state_province').value = addBook[id].state_province;
  document.getElementById(type+'_postal_code').value    = addBook[id].postal_code;
  document.getElementById(type+'_country_code').value   = addBook[id].country_code;
  document.getElementById(type+'_telephone1').value     = addBook[id].telephone1;
  document.getElementById(type+'_telephone2').value     = addBook[id].telephone2;
  document.getElementById(type+'_telephone3').value     = addBook[id].telephone3;
  document.getElementById(type+'_telephone4').value     = addBook[id].telephone4;
  document.getElementById(type+'_email').value          = addBook[id].email;
  document.getElementById(type+'_website').value        = addBook[id].website;
  document.getElementById(type+'_notes').value          = addBook[id].notes;
} 

function editPmtRow(index) {
  document.getElementById('payment_id').value        = js_pmt_array[index].id;
  document.getElementById('payment_cc_name').value   = js_pmt_array[index].name;
  document.getElementById('payment_cc_number').value = js_pmt_array[index].card_num;
  document.getElementById('payment_exp_month').value = js_pmt_array[index].exp_month;
  document.getElementById('payment_exp_year').value  = js_pmt_array[index].exp_year;
  document.getElementById('payment_cc_cvv2').value   = js_pmt_array[index].cvv2;
} 

function clearForm(type) {
  document.getElementById(type+'_address_id').value     = 0;
  document.getElementById(type+'_primary_name').value   = '';
  document.getElementById(type+'_contact').value        = '';
  document.getElementById(type+'_address1').value       = '';
  document.getElementById(type+'_address2').value       = '';
  document.getElementById(type+'_city_town').value      = '';
  document.getElementById(type+'_state_province').value = '';
  document.getElementById(type+'_postal_code').value    = '';
  document.getElementById(type+'_country_code').value   = '<?php echo COMPANY_COUNTRY; ?>';
  document.getElementById(type+'_telephone1').value     = '';
  document.getElementById(type+'_telephone2').value     = '';
  document.getElementById(type+'_telephone3').value     = '';
  document.getElementById(type+'_telephone4').value     = '';
  document.getElementById(type+'_email').value          = '';
  document.getElementById(type+'_website').value        = '';
  document.getElementById(type+'_notes').value          = '';
}

function clearPmtForm() {
  document.getElementById('payment_id').value                = 0;
  document.getElementById('payment_cc_name').value           = '';
  document.getElementById('payment_cc_number').value         = '';
  document.getElementById('payment_exp_month').selectedIndex = 0;
  document.getElementById('payment_exp_year').selectedIndex  = 0;
  document.getElementById('payment_cc_cvv2').value           = '';
}

function removeRow(type, id) {
  document.getElementById('del_add_id').value += ',' + id; // add to the list to delete
  document.getElementById(type + '_table').deleteRow(document.getElementById('tr_'+id).rowIndex);
}

function removePmtRow(id) {
  document.getElementById('del_pmt_id').value += ',' + id; // add to the list to delete
  document.getElementById('pmt_table').deleteRow(document.getElementById('trp_'+id).rowIndex);
}

function loadContacts() {
//  var guess = document.getElementById('dept_rep_id').value;
  var guess = document.getElementById('dept_rep_id').value;
//  document.getElementById('dept_rep_id').options[0].text = guess;
  if (guess.length < 3) return;
  loadXMLReq('index.php?cat=accounts&module=ajax&op=load_contact_info&guess='+guess);
}

// ajax response handler call back function
function fillContacts(resp) {
  data = parseXML(resp);
  // clear the dropdown
  while (document.getElementById('comboseldept_rep_id').options.length) {
	document.getElementById('comboseldept_rep_id').remove(0);
  }
  if (data.guesses) buildContactDropDown(data.guesses);
}

function buildContactDropDown(data) {
  for (i=0; i<data.length; i++) {
	newOpt = document.createElement("option");
	newOpt.text = data[i].guess ? data[i].guess : '<?php echo TEXT_FIND; ?>';
	document.getElementById('comboseldept_rep_id').options.add(newOpt);
	document.getElementById('comboseldept_rep_id').options[i].value = data[i].id;
  }
  if (!fActiveMenu) menuActivate('dept_rep_id', 'combodivdept_rep_id', 'comboseldept_rep_id', 'imgNamedept_rep_id');
  document.getElementById('dept_rep_id').focus();
}

function editContact(id) {
  loadXMLReq('index.php?cat=accounts&module=ajax&op=load_contact&fID=fillContact&cID='+id);
}

function fillContactFields(resp) {
  data = parseXML(resp);
  var contact = data.contact[0];
  var address = data.billaddress[0];
  insertValue('i_id',              contact.id);
  insertValue('i_short_name',      contact.short_name);
  insertValue('i_contact_middle',  contact.contact_middle);
  insertValue('i_contact_first',   contact.contact_first);
  insertValue('i_contact_last',    contact.contact_last);
  insertValue('i_account_number',  contact.account_number);
  insertValue('i_gov_id_number',   contact.gov_id_number);
  insertValue('im_address_id',     address.address_id);
  insertValue('im_primary_name',   address.primary_name);
  insertValue('im_contact',        address.contact);
  insertValue('im_telephone1',     address.telephone1);
  insertValue('im_telephone2',     address.telephone2);
  insertValue('im_telephone3',     address.telephone3);
  insertValue('im_telephone4',     address.telephone4);
  insertValue('im_email',          address.email);
  insertValue('im_website',        address.website);
  insertValue('im_address1',       address.address1);
  insertValue('im_address2',       address.address2);
  insertValue('im_city_town',      address.city_town);
  insertValue('im_state_province', address.state_province);
  insertValue('im_postal_code',    address.postal_code);
  insertValue('im_country_code',   address.country_code);
  insertValue('im_notes',          address.notes);
}

function clearContactForm() {
  insertValue('i_id',              '');
  insertValue('i_short_name',      '');
  insertValue('i_contact_middle',  '');
  insertValue('i_contact_first',   '');
  insertValue('i_contact_last',    '');
  insertValue('i_account_number',  '');
  insertValue('i_gov_id_number',   '');
  insertValue('im_address_id',     '');
  insertValue('im_primary_name',   '');
  insertValue('im_contact',        '');
  insertValue('im_telephone1',     '');
  insertValue('im_telephone2',     '');
  insertValue('im_telephone3',     '');
  insertValue('im_telephone4',     '');
  insertValue('im_email',          '');
  insertValue('im_website',        '');
  insertValue('im_address1',       '');
  insertValue('im_address2',       '');
  insertValue('im_city_town',      '');
  insertValue('im_state_province', '');
  insertValue('im_postal_code',    '');
  insertValue('im_country_code',   '');
  insertValue('im_notes',          '');
}

function copyContactAddress(type) {
  insertValue('im_primary_name',   document.getElementById(type+'m_primary_name').value);
  insertValue('im_contact',        document.getElementById(type+'m_contact').value);
  insertValue('im_telephone1',     document.getElementById(type+'m_telephone1').value);
  insertValue('im_telephone2',     document.getElementById(type+'m_telephone2').value);
  insertValue('im_telephone3',     document.getElementById(type+'m_telephone3').value);
  insertValue('im_telephone4',     document.getElementById(type+'m_telephone4').value);
  insertValue('im_email',          document.getElementById(type+'m_email').value);
  insertValue('im_website',        document.getElementById(type+'m_website').value);
  insertValue('im_address1',       document.getElementById(type+'m_address1').value);
  insertValue('im_address2',       document.getElementById(type+'m_address2').value);
  insertValue('im_city_town',      document.getElementById(type+'m_city_town').value);
  insertValue('im_state_province', document.getElementById(type+'m_state_province').value);
  insertValue('im_postal_code',    document.getElementById(type+'m_postal_code').value);
  insertValue('im_country_code',   document.getElementById(type+'m_country_code').value);
}

// -->
</script>