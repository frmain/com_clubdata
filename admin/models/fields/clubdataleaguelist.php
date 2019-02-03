<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_clubdata
 *
 * @copyright   Copyright (C) 2015 vv Bruse Boys. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

require_once JPATH_ADMINISTRATOR . '/components/com_clubdata/vendor/autoload.php';

use SportlinkClubData\ClubData;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
jimport('joomla.application.component.helper');
JFormHelper::loadFieldClass('list');


/**
 * Field to load a list of available teams from ClubDataservice
 *
 */
class JFormFieldClubDataLeaguelist extends JFormFieldList
{
	/**
	 * @var string
	 */
	protected $type = 'ClubDataLeaguelist';
	
	/**
	 * @var ClubData
	 */
	protected $sportlink;
	
	/**
	 * {@inheritDoc}
	 * @see JFormFieldList::getOptions()
	 */
	protected function getOptions()
	{
		/**
		 * @todo make configurable
		 * @var string $key
		 */
		
		$key = JComponentHelper::getParams('com_clubdata')->get('clientid');

		$this->sportlink = new ClubData($key);

		// Initialize the club
		$club = $this->sportlink->getClub();

    	$options = array();

        foreach ($this->sportlink->getTeams() as $team) {
            foreach ($team->getLeagues() as $league) {
                /**
    			 * @var string $opt
    			 */
    			$opt = $league->teamnaam . " - " . $league->competitienaam;
    			
    			$options[] = JHTML::_('select.option', $league->poulecode, $opt, 'value', 'text');
            }
		}

		$options = array_merge(parent::getOptions(), $options);
    	return $options;
		
	}
}
