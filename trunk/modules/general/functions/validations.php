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
//  Path: /modules/general/functions/validations.php
//

// For earlier version of php (pre-5.3) on Windows platforms where function checkdnsrr does not exist
  if (!function_exists('checkdnsrr')) {
    function checkdnsrr($dummy1, $dummy2) { } // do nothing
  }

  function validate_email($email) {
    $isValid = true;
    $atIndex = strrpos($email, "@");
    if (is_bool($atIndex) && !$atIndex) {
      $isValid = false;
    } else {
      $domain    = substr($email, $atIndex+1);
      $local     = substr($email, 0, $atIndex);
      $localLen  = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64) { // local part length exceeded
         $isValid = false;
      } else if ($domainLen < 1 || $domainLen > 255) { // domain part length exceeded
         $isValid = false;
      } else if ($local[0] == '.' || $local[$localLen-1] == '.') { // local part starts or ends with '.'
         $isValid = false;
      } else if (preg_match('/\\.\\./', $local)) { // local part has two consecutive dots
         $isValid = false;
      } else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) { // character not valid in domain part
         $isValid = false;
      } else if (preg_match('/\\.\\./', $domain)) { // domain part has two consecutive dots
         $isValid = false;
      } else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))) {
         // character not valid in local part unless local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))) $isValid = false;
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))) $isValid = false;
    }
    return $isValid;
  }

  function validate_upload($filename, $file_type = 'text', $extension = 'txt') {
  	global $messageStack;
	if ($_FILES[$filename]['error']) { // php error uploading file
		switch ($_FILES[$filename]['error']) {
			case '1': $messageStack->add(TEXT_IMP_ERMSG1, 'error'); break;
			case '2': $messageStack->add(TEXT_IMP_ERMSG2, 'error'); break;
			case '3': $messageStack->add(TEXT_IMP_ERMSG3, 'error'); break;
			case '4': $messageStack->add(TEXT_IMP_ERMSG4, 'error'); break;
			default:  $messageStack->add(TEXT_IMP_ERMSG5 . $_FILES[$filename]['error'] . '.', 'error');
		}
		return false;
	} elseif (!is_uploaded_file($_FILES[$filename]['tmp_name'])) { // file uploaded
		$messageStack->add(TEXT_IMP_ERMSG13, 'error');
		return false;
	} elseif ($_FILES[$filename]['size'] == 0) { // report contains no data, error
		$messageStack->add(TEXT_IMP_ERMSG7, 'error');
		return false;
	}
	$ext = strtolower(substr($_FILES[$filename]['name'], -3, 3));
	$textfile = (strpos($_FILES[$filename]['type'], $file_type) === false) ? false : true;
	if (!is_array($extension)) $extension = array($extension);
	if ((!$textfile && in_array($ext, $extension)) || $textfile) { // allow file_type and extensions
		return true;
	}
	$messageStack->add(TEXT_IMP_ERMSG6, 'error');
	return false;
  }

  function validate_path($file_path) {
	if (!is_dir($file_path)) mkdir($file_path, 0777, true); // works for PHP5, for PHP4 and lower (needs recursive re-write)
	return true;
  }

  function validate_db_date($date) {
    $y = (int)substr($date,0,4); 
	if ($y < 1900 || $y > 2099) return false;
    $m = (int)substr($date,5,2); 
	if ($m < 1 || $m > 12) return false;
    $d = (int)substr($date,8,2); 
	if ($d < 1 || $d > 31) return false;
	return true;
  }

  function validate_send_mail($to_name, $to_address, $email_subject, $email_text, $from_email_name, $from_email_address, $block = array(), $attachments_list = '' ) {
    global $messageStack;
    if (SEND_EMAILS != 'true') return false;  // if sending email is disabled in Admin, just exit

    // check for injection attempts. If new-line characters found in header fields, simply fail to send the message
    foreach(array($from_email_address, $to_address, $from_email_name, $to_name, $email_subject) as $key => $value) {
      if (!$value) continue;
	  if (strpos("\r", $value) !== false || strpos("\n", $value) !== false) return false;
    }
    // if no text or html-msg supplied, exit
    if (!gen_not_null($email_text) && !gen_not_null($block['EMAIL_MESSAGE_HTML'])) return false;
    // if email name is same as email address, use the Store Name as the senders 'Name'
    if ($from_email_name == $from_email_address) $from_email_name = COMPANY_NAME;
    // loop thru multiple email recipients if more than one listed  --- (esp for the admin's "Extra" emails)...
    foreach(explode(',', $to_address) as $key => $to_email_address) {
      //define some additional html message blocks available to templates, then build the html portion.
      if ($block['EMAIL_TO_NAME'] == '')      $block['EMAIL_TO_NAME']      = $to_name;
      if ($block['EMAIL_TO_ADDRESS'] == '')   $block['EMAIL_TO_ADDRESS']   = $to_email_address;
      if ($block['EMAIL_SUBJECT'] == '')      $block['EMAIL_SUBJECT']      = $email_subject;
      if ($block['EMAIL_FROM_NAME'] == '')    $block['EMAIL_FROM_NAME']    = $from_email_name;
      if ($block['EMAIL_FROM_ADDRESS'] == '') $block['EMAIL_FROM_ADDRESS'] = $from_email_address;
      $email_html = $email_text;

      //  if ($attachments_list == '') $attachments_list= array();

      // clean up &amp; and && from email text
      while (strstr($email_text, '&amp;&amp;')) $email_text = str_replace('&amp;&amp;', '&amp;', $email_text);
      while (strstr($email_text, '&amp;'))      $email_text = str_replace('&amp;', '&', $email_text);
      while (strstr($email_text, '&&'))         $email_text = str_replace('&&', '&', $email_text);

      // clean up currencies for text emails
      $fix_currencies = split("[:,]" , CURRENCIES_TRANSLATIONS);
      $size = sizeof($fix_currencies);
      for ($i=0, $n=$size; $i<$n; $i+=2) {
        $fix_current = $fix_currencies[$i];
        $fix_replace = $fix_currencies[$i+1];
        if (strlen($fix_current)>0) {
          while (strpos($email_text, $fix_current)) $email_text = str_replace($fix_current, $fix_replace, $email_text);
        }
      }
      // fix double quotes
      while (strstr($email_text, '&quot;')) $email_text = str_replace('&quot;', '"', $email_text);
      // fix slashes
      $email_text = stripslashes($email_text);
      $email_html = stripslashes($email_html);

      // Build the email based on whether customer has selected HTML or TEXT, and whether we have supplied HTML or TEXT-only components
      if (!gen_not_null($email_text)) {
        $text = str_replace('<br[[:space:]]*/?[[:space:]]*>', "\n", $block['EMAIL_MESSAGE_HTML']);
        $text = str_replace('</p>', "</p>\n", $text);
        $text = htmlspecialchars(stripslashes(strip_tags($text)));
      } else {
        $text = strip_tags($email_text);
      }
      // now lets build the mail object with the phpmailer class
	  require_once(DIR_FS_ADDONS . 'PHPMailer/class.phpmailer.php');
      $mail = new PHPMailer();

      $lang_code = ($_SESSION['languages_code'] == '' ? 'en' : $_SESSION['languages_code'] );
      $mail->SetLanguage($lang_code, DIR_FS_CLASSES . 'support/');
      $mail->CharSet =  (defined('CHARSET')) ? CHARSET : "iso-8859-1";
      if ($debug_mode=='on') $mail->SMTPDebug = true;
      if (EMAIL_TRANSPORT=='smtp' || EMAIL_TRANSPORT=='smtpauth') {
        $mail->IsSMTP();                           // set mailer to use SMTP
        $mail->Host = EMAIL_SMTPAUTH_MAIL_SERVER;
        if (EMAIL_SMTPAUTH_MAIL_SERVER_PORT != '25' && EMAIL_SMTPAUTH_MAIL_SERVER_PORT != '') $mail->Port = EMAIL_SMTPAUTH_MAIL_SERVER_PORT;
        if (EMAIL_TRANSPORT=='smtpauth') {
          $mail->SMTPAuth = true;     // turn on SMTP authentication
          $mail->Username = (gen_not_null(EMAIL_SMTPAUTH_MAILBOX)) ? EMAIL_SMTPAUTH_MAILBOX : EMAIL_FROM;  // SMTP username
          $mail->Password = EMAIL_SMTPAUTH_PASSWORD; // SMTP password
        }
      }
      $mail->Subject  = $email_subject;
      $mail->From     = $from_email_address;
      $mail->FromName = $from_email_name;
      $mail->AddAddress($to_email_address, $to_name);
      $mail->AddReplyTo($from_email_address, $from_email_name);
	  if (isset($block['EMAIL_CC_ADDRESS'])) $mail->AddCC($block['EMAIL_CC_ADDRESS'], $block['EMAIL_CC_NAME']);
      // set proper line-endings based on switch ... important for windows vs linux hosts:
      $mail->LE = (EMAIL_LINEFEED == 'CRLF') ? "\r\n" : "\n";
      $mail->WordWrap = 76;    // set word wrap to 76 characters
      // if mailserver requires that all outgoing mail must go "from" an email address matching domain on server, set it to store address
      if (EMAIL_SEND_MUST_BE_STORE=='Yes') $mail->From = EMAIL_FROM;
      if (EMAIL_TRANSPORT=='sendmail-f' || EMAIL_TRANSPORT=='sendmail') {
	    $mail->Mailer = 'sendmail';
        $mail->Sender = $mail->From;
      }
      // process attachments
      // Note: $attachments_list array requires that the 'file' portion contains the full path to the file to be attached
      if (EMAIL_ATTACHMENTS_ENABLED && gen_not_null($attachments_list) ) {
        $mail->AddAttachment($attachments_list['file']);          // add attachments
      } //endif attachments
      if (EMAIL_USE_HTML == 'true' && trim($email_html) != '' && ADMIN_EXTRA_EMAIL_FORMAT == 'HTML') {
        $mail->IsHTML(true);           // set email format to HTML
        $mail->Body    = $email_html;  // HTML-content of message
        $mail->AltBody = $text;        // text-only content of message
      }  else {                        // use only text portion if not HTML-formatted
        $mail->Body    = $text;        // text-only content of message
      }
      // EMAIL_FRIENDLY_ERRORS ... debating whether to reinstate it to suppress the messageStack in this case too, or not. 
      if (!$mail->Send()) {
        $messageStack->add(sprintf(EMAIL_SEND_FAILED . '&nbsp;'. $mail->ErrorInfo, $to_name, $to_email_address, $email_subject),'error');
        return false;
	  }
    } // end foreach loop thru possible multiple email addresses
    return true;
  }  // end function

  function web_connected($silent = true) { 
    global $messageStack;
    $web_enabled = false; 
    $connected = @fsockopen('www.phreebooks.com', 80, $errno, $errstr, 20);
    if ($connected) { 
      $web_enabled = true; 
      fclose($connected); 
    } else {
	  if (!$silent) $messageStack->add('You are not connected to the internet. Error:' . $errno . ' - ' . $errstr, 'error');
	}
    return $web_enabled;   
  }
?>