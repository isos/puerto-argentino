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
//  Path: /includes/javascript/general.js
//

// BOS - set up ajax session refresh timer to stay logged in if the browser is active
var sessionClockID = 0; // start a session clock to stay logged in
ajaxRH["sessionTimeout"] = "processSessionTimeout";

function refreshSessionClock() {
  if (sessionClockID) {
    window.clearTimeout(sessionClockID);
    loadXMLReq('index.php?cat=general&module=ajax&op=refresh_session');
  }
  sessionClockID = window.setTimeout("refreshSessionClock()", 300000); // set to 5 minutes
}

function processSessionTimeout() {
  return;
}

function clearSessionClock() {
  if (sessionClockID) {
    window.clearTimeout(sessionClockID);
    sessionClockID = 0;
  }
}
// EOS - set up ajax session refresh timer to stay logged in if the browser is active

function clearField(field_name, text_value) {
  if (document.getElementById(field_name).value == text_value) {
	document.getElementById(field_name).style.color = '';
	document.getElementById(field_name).value       = '';
  }
}

function setField(field_name, text_value) {
  if (document.getElementById(field_name).value == '' || document.getElementById(field_name).value == text_value) {
	document.getElementById(field_name).style.color = inactive_text_color;
	document.getElementById(field_name).value       = text_value;
  } else {
	document.getElementById(field_name).style.color = '';
  }
}

function removeElement(parentDiv, childDiv) {
  if (childDiv == parentDiv) {
    return false;
  } else if (document.getElementById(childDiv)) {     
    var child  = document.getElementById(childDiv);
    var parent = document.getElementById(parentDiv);
    parent.removeChild(child);
  } else {
    return false;
  }
}

function insertValue(dVal, value) {
  if (!document.getElementById(dVal)) return;
  if (document.getElementById(dVal) && value) {
	document.getElementById(dVal).value = value;
	document.getElementById(dVal).style.color = '';
  } else {
	document.getElementById(dVal).value = '';
  }
}

function rowOverEffect(object) {
  if (object.className == 'dataTableRow') object.className = 'dataTableRowOver';
}

function rowOutEffect(object) {
  if (object.className == 'dataTableRowOver') object.className = 'dataTableRow';
}

var clockID = 0;
function refreshClock() {
  if (clockID) {
    clearTimeout(clockID);
    clockID = 0;
  }
  var currentDate = new Date();
  var currentHours = new String(currentDate.getHours());
  if (currentHours.length < 2) currentHours = '0' + currentHours;
  var currentMinutes = new String(currentDate.getMinutes());
  if (currentMinutes.length < 2) currentMinutes = '0' + currentMinutes;
  var currentSeconds = new String(currentDate.getSeconds());
  if (currentSeconds.length < 2) currentSeconds = '0' + currentSeconds;
  var currentMonth = new String(currentDate.getMonth()+1);
  if (currentMonth.length < 2) currentMonth = '0' + currentMonth;
  var currentDay = new String(currentDate.getDate());
  if (currentDay.length < 2) currentDay = '0' + currentDay;
  var currentYear = new String(currentDate.getFullYear());
  // display via date format
  var df = date_format; // load the PHP date format string per locale
  df = df.replace("Y", currentYear);
  df = df.replace("m", currentMonth);
  df = df.replace("d", currentDay);
  if(document.all) { // IE browsers
    document.getElementById('rtClock').innerText = ' '+df+' '+currentHours+':'+currentMinutes+':'+currentSeconds;
  } else { //firefox
    document.getElementById('rtClock').textContent = ' '+df+' '+currentHours+':'+currentMinutes+':'+currentSeconds;
  }
  clockID = setTimeout("refreshClock()", 1000);
}

function startClock() {
  clockID = setTimeout("refreshClock()", 500);
  if (sessionAutoRefresh) refreshSessionClock();
}

function endClock() {
  if (clockID) {
    clearTimeout(clockID);
    clockID = 0;
  }
  clearSessionClock();
}

// Numeric functions
function d2h(d, padding) {
	if (isNaN(d)) d = parseInt(d);
    var hex = Number(d).toString(16);
    padding = typeof (padding) === "undefined" || padding === null ? padding = 2 : padding;
    while (hex.length < padding) hex = "0" + hex;
    return hex;
}

function h2d(h) {
  return parseInt(h, 16);
}

// date functions
function cleanDate(sDate) { // converts date from locale to mysql friendly yyyy-mm-dd
  var tmpArray = new Array();
  var keys  = date_format.split(date_delimiter);
  var parts = sDate.split(date_delimiter);
  for (var i=0; i<keys.length; i++) {
	switch (keys[i]) {
	  case 'Y': tmpArray[0] = parts[i]; break;
	  case 'm': tmpArray[1] = parts[i]; break;
	  case 'd': tmpArray[2] = parts[i]; break;
	}
  }
  return tmpArray.join('-');
}

function formatDate(sDate) { // converts date from mysql friendly yyyy-mm-dd to locale specific
  var tmpArray = new Array();
  var keys  = date_format.split(date_delimiter);
  var parts = sDate.split('-');
  for (var i=0; i<keys.length; i++) {
	switch (keys[i]) {
	  case 'Y': tmpArray[i] = parts[0]; break;
	  case 'm': tmpArray[i] = parts[1]; break;
	  case 'd': tmpArray[i] = parts[2]; break;
	}
  }
  return tmpArray.join(date_delimiter);
}

// Currency translation functions
function cleanCurrency(amount) {
  amount = amount.replace(new RegExp("["+thousands_point+"]", "g"), '');
  amount = amount.replace(new RegExp("["+decimal_point+"]", "g"), '.');
  return amount;
}

function formatCurrency(amount) { // convert to expected currency format
  // amount needs to be a string type with thousands separator ',' and decimal point dot '.' 
  var factor = Math.pow(10, decimal_places);
  var numExpr = parseFloat(amount);
  if (isNaN(numExpr)) return amount;
  numExpr = Math.round(numExpr * factor);
  var minus = (numExpr < 0) ? '-' : ''; 
  numExpr = Math.abs(numExpr);
  var decimal = (numExpr % factor).toString();
  while (decimal.length < decimal_places) decimal = '0' + decimal;
  var whole = Math.floor(numExpr / factor).toString();
  for (var i = 0; i < Math.floor((whole.length-(1+i))/3); i++)
    whole = whole.substring(0,whole.length-(4*i+3)) + thousands_point + whole.substring(whole.length-(4*i+3));
  if (decimal_places > 0) {
    return minus + whole + decimal_point + decimal;
  } else {
	return minus + whole;
  }
}

function formatPrecise(amount) { // convert to expected currency format with the additional precision
  // amount needs to be a string type with thousands separator ',' and decimal point dot '.' 
  var factor = Math.pow(10, decimal_precise);
  var numExpr = parseFloat(amount);
  if (isNaN(numExpr)) return amount;
  numExpr = Math.round(numExpr * factor);
  var minus = (numExpr < 0) ? '-' : ''; 
  numExpr = Math.abs(numExpr);
  var decimal = (numExpr % factor).toString();
  while (decimal.length < decimal_precise) decimal = '0' + decimal;
  var whole = Math.floor(numExpr / factor).toString();
  for (var i = 0; i < Math.floor((whole.length-(1+i))/3); i++)
    whole = whole.substring(0,whole.length-(4*i+3)) + thousands_point + whole.substring(whole.length-(4*i+3));
  if (decimal_precise > 0) {
    return minus + whole + decimal_point + decimal;
  } else {
	return minus + whole;
  }
}
// End currency translation functions

//
 function AlertError(MethodName,e)  {
	if (e.description == null) { alert(MethodName + " Exception: " + e.message); }
	else {  alert(MethodName + " Exception: " + e.description); }
 }

// ******************** functions used for combo box scripting ***********************************

var fActiveMenu = false;
var oOverMenu   = false;

if (document.images) { //pre-load images
 img_on      = new Image();
 img_on.src  = combo_image_on; 
 img_off     = new Image();
 img_off.src = combo_image_off; 
}

if (pbBrowser != 'IE') document.onmouseup = mouseSelect(0); // turns off the combo box in not hovering over

function mouseSelect(e) {
	if (fActiveMenu) {
		if (oOverMenu == false) {
			oOverMenu = false;
			document.getElementById(fActiveMenu).style.display = "none";
			fActiveMenu = false;
			return false;
		}
		return false;
	}
	return true;
}

function dropDownData(id, text) {
  this.id   = id;
  this.text = text;
}

function buildDropDown(selElement, data, defValue) {
  // build the dropdown
  for (i=0; i<data.length; i++) {
	newOpt = document.createElement("option");
	newOpt.text = data[i].text;
	document.getElementById(selElement).options.add(newOpt);
	document.getElementById(selElement).options[i].value = data[i].id;
  }
  if (defValue != false) document.getElementById(selElement).value = defValue;
}

function htmlComboBox(name, values, defaultVal, parameters, width, onChange) {
  var field;
  field = '<input type="text" name="' + name + '" id="' + name + '" value="' + defaultVal + '" ' + parameters + '>';
  field += '<image name="imgName' + name + '" id="imgName' + name + '" src="' + icon_path + '16x16/phreebooks/pull_down_inactive.gif" height="16" width="16" align="absmiddle" style="border:none;" onMouseOver="handleOver(\'imgName' + name + '\'); return true;" onMouseOut="handleOut(\'imgName' + name + '\'); return true;" onclick="JavaScript:menuActivate(\'' + name + '\', \'combodiv' + name + '\', \'combosel' + name + '\', \'imgName' + name + '\')">';
  field += '<div id="combodiv' + name + '" style="position:absolute; display:none; top:0px; left:0px; z-index:10000" onmouseover="javascript:oOverMenu=\'combodiv' + name + '\';" onmouseout="javascript:oOverMenu=false;">';
  field += '<select size="10" id="combosel' + name + '" style="width:' + width + '; border-style:none" onclick="JavaScript:textSet(\'' + name + '\', this.value); ' + onChange + ';" onkeypress="JavaScript:comboKey(\'' + name + '\', this, event);">';
  field += '</select></div>';
  return field;
}

function menuActivate(idEdit, idMenu, idSel, idImg) {
  if (fActiveMenu) return mouseSelect(0);
  oEdit = document.getElementById(idEdit);
  oMenu = document.getElementById(idMenu);
  oSel  = document.getElementById(idSel);
  oImg  = document.getElementById(idImg);
  nTop  = oEdit.offsetTop + oEdit.offsetHeight;
  nLeft = oEdit.offsetLeft;
  while (oEdit.offsetParent != document.body) {
	oEdit  = oEdit.offsetParent;
	nTop  += oEdit.offsetTop;
	nLeft += oEdit.offsetLeft;
  }
  oMenu.style.display = "";
  oMenu.style.top     = nTop + 'px';
  oMenu.style.left    = (nLeft - oSel.offsetWidth + oImg.offsetLeft + oImg.offsetWidth) + 'px';
  fActiveMenu = idMenu;
  document.getElementById(idSel).value = document.getElementById(idEdit).value;
  document.getElementById(idSel).focus();
  return false;
}

function textSet(idEdit, text) {
  document.getElementById(idEdit).value = text;
  oOverMenu = false;
  mouseSelect(0);
  document.getElementById(idEdit).focus();
}

function comboKey(idEdit, idSel, e) {
  var keyPressed;
  if(window.event) {
	keyPressed = window.event.keyCode; // IE hack
  } else {
	keyPressed = e.which; // standard method
  }
  if (keyPressed == 13 || keyPressed == 32) {
	textSet(idEdit,idSel.value);
  } else if (keyPressed == 27) {
	mouseSelect(0);
	document.getElementById(idEdit).focus();
  }
}

function handleOver(idImg) { 
 if (document.images) document.getElementById(idImg).src=img_on.src;
}

function handleOut(idImg) {
 if (document.images) document.getElementById(idImg).src=img_off.src;
}

// *****************  END functions used for combo box scripting ***********************************
// ***************** START function to build html strings ******************************************
function buildIcon(imagePath, alt, params) {
    var image_html = '<img src="' + imagePath + '" border="0" alt="' + alt + '" title="' + alt + '" ' + params + ' />';
    return image_html;
}

// ***************** START function to set button pressed ******************************************
function submitToDo(todo) {
	document.getElementById('todo').value = todo;
	if (check_form()) document.getElementById('todo').form.submit();
}

function submitSeq(rowSeq, todo) {
	document.getElementById('rowSeq').value = rowSeq;
	document.getElementById('todo').value = todo;
	if (check_form()) document.getElementById('todo').form.submit();
	return true;
}

function jumpToPage(get_params) {
  var index = document.getElementById('page').selectedIndex;
  var pageNum = document.getElementById('page').options[index].value;
  location.href = 'index.php?'+get_params+'&page='+pageNum;
}

function searchPage(get_params) {
  var searchText = document.getElementById('search_text').value;
  location.href = 'index.php?'+get_params+'search_text='+searchText;
}

function periodPage(get_params) {
  var searchPeriod = document.getElementById('search_period').value;
  location.href = 'index.php?'+get_params+'search_period='+searchPeriod;
}
