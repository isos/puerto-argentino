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
//  Path: /modules/services/classes/class.base.php
//

/**
 * abstract class base
 *
 * any class that wants to notify or listen for events must extend this base class
 *
 * @package classes
 */
class base {
  /**
   * array to hold the list of observer classes
   * @var array
   */
  var $observers = array();
  /**
   * method used to an attach an observer to the notifier object
   * 
   * NB. We have to get a little sneaky here to stop session based classes adding events ad infinitum
   * To do this we first concatenate the class name with the event id, as a class is only ever going to attach to an
   * event id once, this provides a unigue key. To ensure there are no naming problems with the array key, we md5 the unique
   * name to provide a unique hashed key. 
   * 
   * @param object Reference to the observer class
   * @param array An array of eventId's to observe
   */
  function attach(&$observer, $eventIDArray) {
    foreach($eventIDArray as $eventID) {
      $nameHash = md5(get_class($observer).$eventID);
      $this->observers[$nameHash] = array('obs'=>&$observer, 'eventID'=>$eventID);
    }
  }
  /**
   * method used to detach an observer from the notifier object
   * @param object
   * @param array
   */
  function detach($observer, $eventIDArray) {
    foreach($eventIDArray as $eventID) {    
      $nameHash = md5(get_class($observer).$eventID);
      unset($this->observers[$nameHash]);
    }
  }
  /**
   * method to notify observers that an event as occurred in the notifier object
   * 
   * @param string The event ID to notify for
   * @param array paramters to pass to the observer, useful for passing stuff which is outside of the 'scope' of the observed class.
   */
  function notify($eventID, $paramArray = array()) {
    foreach($this->observers as $key=>$obs) {
      if ($obs['eventID'] == $eventID) {
        $obs['obs']->update($this, $eventID, $paramArray);
      }
    }
  }
}
?>