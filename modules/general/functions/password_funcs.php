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
//  Path: /modules/general/functions/password_funcs.php
//

function pw_validate_password($plain, $encrypted) {
  if (gen_not_null($plain) && gen_not_null($encrypted)) {
// split apart the hash / salt
    $stack = explode(':', $encrypted);
    if (sizeof($stack) != 2) return false;
    if (md5($stack[1] . $plain) == $stack[0]) {
      return true;
    }
  }
  return false;
}

function pw_validate_encrypt($plain) {
  global $db;
  if (gen_not_null($plain)) {
    $sql = "select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'ENCRYPTION_VALUE'";
    $result = $db->Execute($sql);
    $encrypted = $result->fields['configuration_value'];
    $stack = explode(':', $encrypted);
    if (sizeof($stack) != 2) return false;
    if (md5($stack[1] . $plain) == $stack[0]) return true;
  }
  return false;
}

function pw_encrypt_password($plain) {
  $password = '';
  for ($i=0; $i<10; $i++) {
    $password .= general_rand();
  }
  $salt = substr(md5($password), 0, 2);
  $password = md5($salt . $plain) . ':' . $salt;
  return $password;
}

function pw_create_random_value($length = 12) {
  $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
  $chars_length = (strlen($chars) - 1);
  $string = $chars{rand(0, $chars_length)};
  for ($i = 1; $i < $length; $i = strlen($string)) {
	$r = $chars{rand(0, $chars_length)};
	if ($r != $string{$i - 1}) $string .=  $r;
  }
  return $string;
}

?>