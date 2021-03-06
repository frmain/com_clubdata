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


use SportlinkClubData\ClubData;

/**
 * Sportlink class
 * 
 * Use 1 shared connection to Sportlink
 */
class Sportlink {
    
    static private $instances = array();
    
    private function __construct($key) {

        parent::__construct();
    }
    
    
    public static function getInstance($key) {
        if(!array_key_exists($key, self::$instances)) {
            self::$instances[$key] = new ClubData($key);
        }
        
        return self::$instances[$key];
    }
    
}