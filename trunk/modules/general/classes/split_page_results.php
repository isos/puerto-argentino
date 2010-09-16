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
//  Path: /modules/general/classes/split_page_results.php
//

  class splitPageResults {

    // class constructor
    function splitPageResults(&$current_page_number, $max_rows_per_page, &$sql_query, &$query_num_rows) {
      global $db;
      $this->page_prefix = '';
	  $this->jump_page_displayed = false;

      if (empty($current_page_number)) $current_page_number = 1;

      $pos_to = strlen($sql_query);

      $pos_from = strpos($sql_query, ' from', 0);

      $pos_group_by = strpos($sql_query, 'group by', $pos_from);
      if (($pos_group_by < $pos_to) && ($pos_group_by != false)) $pos_to = $pos_group_by;

      $pos_having = strpos($sql_query, ' having', $pos_from);
      if (($pos_having < $pos_to) && ($pos_having != false)) $pos_to = $pos_having;

      $pos_order_by = strpos($sql_query, 'order by', $pos_from);
      if (($pos_order_by < $pos_to) && ($pos_order_by != false)) $pos_to = $pos_order_by;

// The original count over states the rows if a sum() is within the sql!!!
//      $count = $db->Execute("select count(*) as total " . substr($sql_query, $pos_from, ($pos_to - $pos_from)));
//      $query_num_rows = $count->fields['total'];
      $count = $db->Execute($sql_query);
      $query_num_rows = $count->RecordCount();
      $num_pages = ceil($query_num_rows / $max_rows_per_page);
      if ($current_page_number > $num_pages) {
        $current_page_number = $num_pages;
      }
      $offset = ($max_rows_per_page * ($current_page_number - 1));

// fix offset error on some versions
      if ($offset < 0) $offset = 0;

      $sql_query .= " limit " . $offset . ", " . $max_rows_per_page;
    }

    function display_links($query_numrows, $max_rows_per_page, $max_page_links, $current_page_number, $parameters = '', $page_name = 'page') {

	  // calculate number of pages needing links
      $num_pages = ceil($query_numrows / $max_rows_per_page);
	  if ($num_pages == 0) $num_pages++;
	  $this->num_pages = $num_pages; // save it for retrieval by the templates
      $pages_array = array();
      for ($i=1; $i<=$num_pages; $i++) {
        $pages_array[] = array('id' => $i, 'text' => $i);
      }

      if ($num_pages > 1) {
        $display_links = '';

        if ($current_page_number > 1) {
		  $display_links .= html_icon('actions/media-skip-backward.png', TEXT_GO_FIRST, 'small', 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=go_first', 'SSL') . '\'" style="cursor:pointer;"');
		  $display_links .= html_icon('phreebooks/media-playback-previous.png', TEXT_GO_PREVIOUS, 'small', 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=go_previous', 'SSL') . '\'" style="cursor:pointer;"');
        } else {
		  $display_links .= html_icon('actions/media-skip-backward.png', '', 'small', '');
		  $display_links .= html_icon('phreebooks/media-playback-previous.png', '', 'small', '');
        }

        if (!$this->jump_page_displayed) { // only diplay pull down once (the rest are not read by browser)
		  $display_links .= sprintf(TEXT_RESULT_PAGE, html_pull_down_menu($page_name, $pages_array, $current_page_number, 'onchange="jumpToPage(\'' . gen_get_all_get_params(array('page', 'action')) . 'action=go_page\')"'), $num_pages);
		  $this->jump_page_displayed = true;
		} else {
		  $display_links .= sprintf(TEXT_RESULT_PAGE, $current_page_number, $num_pages);
		}

        if (($current_page_number < $num_pages) && ($num_pages != 1)) {
		  $display_links .= html_icon('actions/media-playback-start.png', TEXT_GO_NEXT, 'small', 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=go_next', 'SSL') . '\'" style="cursor:pointer;"');
		  $display_links .= html_icon('actions/media-skip-forward.png', TEXT_GO_LAST, 'small', 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, gen_get_all_get_params(array('action')) . 'action=go_last', 'SSL') . '\'" style="cursor:pointer;"');
        } else {
		  $display_links .= html_icon('actions/media-playback-start.png', '', 'small', '');
		  $display_links .= html_icon('actions/media-skip-forward.png', '', 'small', '');
        }

      } else {
        $display_links = sprintf(TEXT_RESULT_PAGE, $num_pages, $num_pages);
      }

      return $display_links;
    }

    function display_count($query_numrows, $max_rows_per_page, $current_page_number, $text_output) {
      $to_num = ($max_rows_per_page * $current_page_number);
      if ($to_num > $query_numrows) $to_num = $query_numrows;
      $from_num = ($max_rows_per_page * ($current_page_number - 1));
      if ($to_num == 0) {
        $from_num = 0;
      } else {
        $from_num++;
      }

      return sprintf($text_output, $from_num, $to_num, $query_numrows);
    }
  }
?>