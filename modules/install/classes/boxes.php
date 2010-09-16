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
//  Path: /modules/install/classes/boxes.php
//

  class tableBox {
    var $table_border = '0';
    var $table_width = '100%';
    var $table_cellspacing = '0';
    var $table_cellpadding = '2';
    var $table_parameters = '';
    var $table_row_parameters = '';
    var $table_data_parameters = '';

// class constructor
    function tableBox($contents, $direct_output = false) {
      $tableBox_string = '<table border="' . gen_output_string($this->table_border) . '" width="' . gen_output_string($this->table_width) . '" cellspacing="' . gen_output_string($this->table_cellspacing) . '" cellpadding="' . gen_output_string($this->table_cellpadding) . '"';
      if (gen_not_null($this->table_parameters)) $tableBox_string .= ' ' . $this->table_parameters;
      $tableBox_string .= '>' . "\n";

      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        if (isset($contents[$i]['form']) && gen_not_null($contents[$i]['form'])) $tableBox_string .= $contents[$i]['form'] . "\n";
        $tableBox_string .= '  <tr';
        if (gen_not_null($this->table_row_parameters)) $tableBox_string .= ' ' . $this->table_row_parameters;
        if (isset($contents[$i]['params']) && gen_not_null($contents[$i]['params'])) $tableBox_string .= ' ' . $contents[$i]['params'];
        $tableBox_string .= '>' . "\n";

        if (isset($contents[$i][0]) && is_array($contents[$i][0])) {
          for ($x=0, $n2=sizeof($contents[$i]); $x<$n2; $x++) {
            if (isset($contents[$i][$x]['text']) && gen_not_null($contents[$i][$x]['text'])) {
              $tableBox_string .= '    <td';
              if (isset($contents[$i][$x]['align']) && gen_not_null($contents[$i][$x]['align'])) $tableBox_string .= ' align="' . gen_output_string($contents[$i][$x]['align']) . '"';
              if (isset($contents[$i][$x]['params']) && gen_not_null($contents[$i][$x]['params'])) {
                $tableBox_string .= ' ' . $contents[$i][$x]['params'];
              } elseif (gen_not_null($this->table_data_parameters)) {
                $tableBox_string .= ' ' . $this->table_data_parameters;
              }
              $tableBox_string .= '>';
              if (isset($contents[$i][$x]['form']) && gen_not_null($contents[$i][$x]['form'])) $tableBox_string .= $contents[$i][$x]['form'];
              $tableBox_string .= $contents[$i][$x]['text'];
              if (isset($contents[$i][$x]['form']) && gen_not_null($contents[$i][$x]['form'])) $tableBox_string .= '</form>';
              $tableBox_string .= '</td>' . "\n";
            }
          }
        } else {
          $tableBox_string .= '    <td';
          if (isset($contents[$i]['align']) && gen_not_null($contents[$i]['align'])) $tableBox_string .= ' align="' . gen_output_string($contents[$i]['align']) . '"';
          if (isset($contents[$i]['params']) && gen_not_null($contents[$i]['params'])) {
            $tableBox_string .= ' ' . $contents[$i]['params'];
          } elseif (gen_not_null($this->table_data_parameters)) {
            $tableBox_string .= ' ' . $this->table_data_parameters;
          }
          $tableBox_string .= '>' . $contents[$i]['text'] . '</td>' . "\n";
        }

        $tableBox_string .= '  </tr>' . "\n";
        if (isset($contents[$i]['form']) && gen_not_null($contents[$i]['form'])) $tableBox_string .= '</form>' . "\n";
      }

      $tableBox_string .= '</table>' . "\n";

      if ($direct_output == true) echo $tableBox_string;

      return $tableBox_string;
    }
  }

  class infoBox extends tableBox {
    function infoBox($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->infoBoxContents($contents));
      $this->table_cellpadding = '1';
      $this->table_parameters = 'class="sideBox"';
      $this->tableBox($info_box_contents, true);
    }

    function infoBoxContents($contents) {
      $this->table_cellpadding = '3';
      $this->table_parameters = 'class="sideBoxContent"';
      $info_box_contents = array();
      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        $info_box_contents[] = array(array('align' => (isset($contents[$i]['align']) ? $contents[$i]['align'] : ''),
                                           'form' => (isset($contents[$i]['form']) ? $contents[$i]['form'] : ''),
                                           'params' => 'class="boxText"',
                                           'text' => (isset($contents[$i]['text']) ? $contents[$i]['text'] : '')));
      }
      return $this->tableBox($info_box_contents);
    }
  }

// $no_corners = true eliminates all images from the header completely.
  class infoBoxHeading extends tableBox {
    function infoBoxHeading($contents, $left_corner = true, $right_corner = true, $right_arrow = false, $no_corners = false) {
      $this->table_cellpadding = '0';

      if ($left_corner == true) {
        $left_corner = html_image(DIR_WS_TEMPLATE_IMAGES . 'infobox/corner_left.gif');
      } else {
        if ($no_corners == true) {
          $left_corner = '';
        } else {
          $left_corner = html_image(DIR_WS_TEMPLATE_IMAGES . 'infobox/corner_right_left.gif');
        }
      }
      if ($right_arrow == true) {
        $right_arrow = '<a href="' . $right_arrow . '">' . html_image(DIR_WS_TEMPLATE_IMAGES . 'infobox/arrow_right.gif', ICON_ARROW_RIGHT) . '</a>';
      } else {
        $right_arrow = '';
      }
      if ($right_corner == true) {
        $right_corner = $right_arrow . html_image(DIR_WS_TEMPLATE_IMAGES . 'infobox/corner_right.gif');
      } else {
        if ($no_corners == true) {
          $right_corner = '';
        } else {
          $right_corner = $right_arrow;
        }
      }

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => 'height="14" class="sideBoxHeading"',
                                         'text' => $left_corner),
                                   array('params' => 'width="100%" height="14" class="sideBoxHeading"',
                                         'text' => $contents[0]['text']),
                                   array('params' => 'height="14" class="sideBoxHeading" ',
                                         'text' => $right_corner));

      $this->tableBox($info_box_contents, true);
    }
  }

  class contentBox extends tableBox {
    function contentBox($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->contentBoxContents($contents));
      $this->table_cellpadding = '1';
      $this->table_parameters = 'class="sideBox"';
      $this->tableBox($info_box_contents, true);
    }

    function contentBoxContents($contents) {
      $this->table_cellpadding = '4';
      $this->table_parameters = 'class="sideBoxContents"';
      return $this->tableBox($contents);
    }
  }

  class contentBoxHeading extends tableBox {
    function contentBoxHeading($contents) {
      $this->table_width = '100%';
      $this->table_cellpadding = '0';

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => 'height="14" class="sideBoxHeading"',
                                         'text' => html_image(DIR_WS_TEMPLATE_IMAGES . 'infobox/corner_left.gif')),
                                   array('params' => 'height="14" class="sideBoxHeading" width="100%"',
                                         'text' => $contents[0]['text']),
                                   array('params' => 'height="14" class="sideBoxHeading"',
                                         'text' => html_image(DIR_WS_TEMPLATE_IMAGES . 'infobox/corner_right_left.gif')));

      $this->tableBox($info_box_contents, true);
    }
  }

  class errorBox extends tableBox {
    function errorBox($contents) {
      $this->table_data_parameters = 'class="errorBox"';
      $this->tableBox($contents, true);
    }
  }

  class productListingBox extends tableBox {
    function productListingBox($contents) {
      $this->table_parameters = 'class="productListing"';
      $this->tableBox($contents, true);
    }
  }
?>