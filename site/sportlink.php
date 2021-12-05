<?php
/**
 * @package     Joomla
 * @subpackage  com_clubdata
 *
 * @copyright   Copyright (C) 2017 vv Bruse Boys. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

require_once JPATH_ADMINISTRATOR . '/components/com_clubdata/vendor/autoload.php';


use SportlinkClubData\ClubsManager;

/**
 * Sportlink class
 * 
 * Use 1 shared connection to Sportlink
 */
class Sportlink {
    
    static private $instances = array();
    
  
    public static function getInstance($key) {
        if(!array_key_exists($key, self::$instances)) {
        	$keys = preg_split('/[\ \n\,]+/', $key);
        	self::$instances[$key] = new ClubsManager($keys);
        }
        
        return self::$instances[$key];
    }
    
}