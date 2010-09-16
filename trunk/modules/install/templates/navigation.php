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
//  Path: /modules/install/templates/navigation.php
//

?>
<ul>
  <li<?php echo ($body_id == 'index') ? ' id="step"' : ''; ?>><?php echo INSTALL_NAV_WELCOME; ?></li>
  <li<?php echo ($body_id == 'license') ? ' id="step"' : ''; ?>><?php echo INSTALL_NAV_LICENSE; ?></li>
  <li<?php echo ($body_id == 'inspect') ? ' id="step"' : ''; ?>><?php echo INSTALL_NAV_PREREQ; ?></li>
  <li<?php echo ($body_id == 'systemsetup') ? ' id="step"' : ''; ?>><?php echo INSTALL_NAV_SYSTEM; ?></li>
  <li<?php echo ($body_id == 'databasesetup') ? ' id="step"' : ''; ?>><?php echo INSTALL_NAV_DATABASE; ?></li>
  <li<?php echo ($body_id == 'adminsetup') ? ' id="step"' : ''; ?>><?php echo INSTALL_NAV_ADMIN; ?></li>
  <li<?php echo ($body_id == 'storesetup') ? ' id="step"' : ''; ?>><?php echo INSTALL_NAV_COMPANY; ?></li>
  <li<?php echo ($body_id == 'chartsetup') ? ' id="step"' : ''; ?>><?php echo INSTALL_NAV_CHART; ?></li>
  <li<?php echo ($body_id == 'fiscalsetup') ? ' id="step"' : ''; ?>><?php echo INSTALL_NAV_FY; ?></li>
  <li<?php echo ($body_id == 'coadefaults') ? ' id="step"' : ''; ?>><?php echo INSTALL_NAV_DEFAULTS; ?></li>
  <li<?php echo ($body_id == 'finished') ? ' id="step"' : ''; ?>><?php echo INSTALL_NAV_FINISHED; ?></li>
</ul>
