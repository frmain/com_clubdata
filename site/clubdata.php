<?php
/**
 * @package     Joomla
 * @subpackage  com_clubdata
 *
 * @copyright   Copyright (C) 2017 vv Bruse Boys. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

//require_once JPATH_ADMINISTRATOR . '/components/com_clubdata/vendor/autoload.php';
JLoader::registerPrefix('ClubDataModel', dirname(__FILE__) . '/models');

// Get an instance of the controller prefixed by ClubData
$controller = JControllerLegacy::getInstance('ClubData');

// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();