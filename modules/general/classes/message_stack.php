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
//  Path: /modules/general/classes/message_stack.php
//

/*
  Example usage:

  $messageStack = new messageStack();
  $messageStack->add('Error: Error 1', 'error');
  $messageStack->add('Error: Error 2', 'warning');
  if ($messageStack->size > 0) echo $messageStack->output();
*/

  class messageStack extends tableBlock {
    var $size = 0;

    function messageStack() {
      $this->errors = array();
	  $this->debug_info = "Trace information for debug purposes. Release " . PROJECT_VERSION_MAJOR . '.' . PROJECT_VERSION_MINOR . ", generated " . date('Y-m-d H:i:s', time()) . ".\n\n";

      if ($_SESSION['messageQueue']) {
		$this->errors = $_SESSION['messageQueue'];
		$this->size = sizeof($_SESSION['messageQueue']);
		unset($_SESSION['messageQueue']);
      }

      if ($_SESSION['messageToStack']) {
        for ($i = 0, $n = sizeof($_SESSION['messageToStack']); $i < $n; $i++) {
          $this->add($_SESSION['messageToStack'][$i]['text'], $_SESSION['messageToStack'][$i]['type']);
        }
        unset($_SESSION['messageToStack']);
      }
    }

    function add($message, $type = 'error') {
      if ($type == 'error') {
        $this->errors[] = array('params' => 'class="messageStackError"', 'text' => html_icon('emblems/emblem-unreadable.png', TEXT_ERROR) . '&nbsp;' . $message);
      } elseif ($type == 'warning') {
        $this->errors[] = array('params' => 'class="messageStackWarning"', 'text' => html_icon('emblems/emblem-important.png', TEXT_CAUTION) . '&nbsp;' . $message);
      } elseif ($type == 'success') {
	    if (!HIDE_SUCCESS_MESSAGES) $this->errors[] = array('params' => 'class="messageStackSuccess"', 'text' => html_icon('emotes/face-smile.png', TEXT_SUCCESS) . '&nbsp;' . $message);
      } elseif ($type == 'caution') {
        $this->errors[] = array('params' => 'class="messageStackCaution"', 'text' => html_icon('emblems/emblem-important.png', TEXT_CAUTION) . '&nbsp;' . $message);
      } else {
        $this->errors[] = array('params' => 'class="messageStackError"', 'text' => $message);
      }
      $this->size++;
	  return true;
    }

    function add_session($message, $type = 'error') {
      if (!$_SESSION['messageToStack']) {
        $_SESSION['messageToStack'] = array();
      }
      $_SESSION['messageToStack'][] = array('text' => $message, 'type' => $type);
    }

	function convert_add_to_session() {
	  // write the debug data
	  
	  $_SESSION['messageQueue'] = $this->errors;
	}

    function reset() {
      $this->errors = array();
      $this->size = 0;
    }

    function output() {
      $this->table_data_parameters = 'class="messageBox"';
	  $temp = $this->errors;
	  // clear the errors, since they have been displayed.
	  unset($this->errors);
      return $this->tableBlock($temp);
    }

	function debug($txt) {
	  $this->debug_info .= $txt;
	}

	function write_debug() {
	  if (strlen($this->debug_info) < 1) return;
      $filename = DIR_FS_MY_FILES . 'trace.txt';
      if (!$handle = fopen($filename, 'w')) return $this->add("Cannot open file ($filename)", "error");
      if (fwrite($handle, $this->debug_info) === false) return $this->add("Cannot write to file ($filename)","error");
      fclose($handle);
	  $this->debug_info = NULL;
	  $this->add("Successfully created trace.txt file.","success");
	}

  }
?>
