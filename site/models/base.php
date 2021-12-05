<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_clubdata
 *
 * @copyright   Copyright (C) 2017 vv Bruse Boys. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

require_once JPATH_ADMINISTRATOR . '/components/com_clubdata/vendor/autoload.php';
require_once JPATH_SITE . '/components/com_clubdata/sportlink.php';

jimport('joomla.application.component.helper');

use SportlinkClubData\ClubsManager;
use SportlinkClubData\Club;
use SportlinkClubData\Team;
use SportlinkClubData\ClubAddress;


/**
 * ClubData Model Base class
 *
 */
class ClubDataModelBase extends JModelLegacy
{
	
	/**
	 * @var ClubsManager clubsmanager
	 */
	protected $clubsmanager;
	
	/**
	 * @var Club
	 */
	protected $club;
	
	/**
	 * @var ClubAddress
	 */
	protected $accommodation;
	
	/**
	 * @var Team[]
	 */
	protected $teams;
	
	/**
	 * @var Team[][] teams per club
	 */
	protected $clubteams = [];
	
	/**
	 * @var array
	 */
	protected $warning=[];
	
	public function __construct($config)
	{
		parent::__construct($config);
		
		/**
		 * @var string $key  key is a (comma or whitespace) separated list with client-ids
		 */
		$key = JComponentHelper::getParams('com_clubdata')->get('clientid');

		$keys = preg_split('/[\ \n\,]+/', $key);
		$key = join(",",$keys);
		
		# $this->clubsmanager = new ClubsManager($keys);		
		$this->clubsmanager = Sportlink::getInstance($key);
	}
	
	/**
	 * Get the club
	 *
	 * @return Club  The club object
	 */
	public function getClub()
	{
		$this->club = $this->clubsmanager->getMainClub();
    	return $this->club;
	}
	
	/**
	 * Get the Accommation of the club (Visiting Address)
	 *
	 * @return ClubAddress  The visiting address (accommodation)
	 */
	
	public function getAccommodation()
	{
		$this->accommodation = $this->clubsmanager->getMainClub()->getVisitingAddress();
		return $this->accommodation;
	}
	
	/**
	 * Get the teams of all clubs in subscription
	 * @return  SportlinkClubData\Team[]  list of clubteams
	 */
	public function getTeams()
	{
		$this->teams = $this->clubsmanager->getTeams();
		return $this->teams;
	}
	
	/**
	 * Get the clubs of the subscription
	 * @return  SportlinkClubData\Club[]  list of clubs
	 */
	public function getClubs()
	{
		$this->clubs = $this->clubsmanager->getClubs();
		return $this->clubs;
	}
	
	/**
	 * Get the teams of the club
	 * @return  SportlinkClubData\Team[][]  list of teams per club
	 */
	public function getClubTeams()
	{
		foreach($this->clubsmanager->getClubManagers() as $clubmgr) {
			$this->clubteams[]=$clubmgr->getTeams();
		}
		return $this->clubteams;
	}
	
	/**
	 * Get the warning message, holding error information regarding the retrieval of data
	 *
	 * @return string
	 */
	public function getWarning()
	{
	    return empty($this->warning)?"":JText::sprintf('COM_CLUBDATA_SPORTLINK_DATA_ERROR', implode(", <br/>", $this->warning));
	}
	
	
}