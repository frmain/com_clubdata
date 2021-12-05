<?php
/**
 * @package     Joomla
 * @subpackage  com_clubdata
 *
 * @copyright   Copyright (C) 2017 vv Bruse Boys. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use SportlinkClubData\Club;
use SportlinkClubData\Team;
use SportlinkClubData\Exception\InvalidResponseException;
use SportlinkClubData\ClubManager;
use SportlinkClubData\ClubAddress;

JLoader::register('ClubDataModelBase', __DIR__ . '/base.php');

/**
 * ClubData Model for Club related items
 *
 */
class ClubDataModelClubStatic extends ClubDataModelBase
{
	/**
	 * @var ClubManager
	 */
	protected $clubmanager;
	
	/**
	 * @var ClubAddress
	 */
	protected $clubvisitingaddress;
	
	/**
	 * @var Club[]
	 */
	protected $clubs;
	
	/**
	 * @var Team[] 
	 */
	protected $teams;
 

	/**
	 * Get the clubs
	 * @return  SportlinkClubData\Club[]  List of clubs
	 */
	public function getClubs()
	{
		if (!isset($this->clubs))
		{
			$this->clubs = $this->clubsmanager->getClubs();
		}
		return $this->clubs;
	}
	
	/**
	 * get the ClubManager, managing the club static data
	 *
	 * @return ClubManager
	 * @throws Exception if team does not exist
	 */
	public function getClubManager()
	{
		if (!isset($this->clubmanager))
		{
			$app = JFactory::getApplication();
			$this->clubindex = $app->input->get('clubindex',-1);
			if (! $this->clubsmanager->getClubManager($this->clubindex)) {
				throw new Exception(JText::sprintf('COM_CLUBDATA_CLUB_NOTFOUND', $this->clubindex), 404);
			}
			try {
				$this->clubmanager = $this->clubsmanager->getClubManager($this->clubindex);
			} catch (InvalidResponseException $e) {
				throw new Exception(JText::sprintf('COM_CLUBDATA_CLUB_NOTFOUND', $this->clubindex), 404);
			}
		}
		return $this->clubmanager;
	}
	
	/**
	 * Overriding the getClub function for retrieving the club
	 *
	 * @return Club  The club object
	 */
	public function getClub()
	{
		if (!isset($this->club))
		{
			$this->club = $this->getClubManager()->getClub();
		}
		return $this->club;
	}
	
	/**
	 * Get the club's visiting address
	 *
	 * @return ClubAddress  The clubaddress object
	 */
	public function getClubVisitingAddress()
	{
		if (!isset($this->clubvisitingaddress))
		{
			$this->clubvisitingaddress = $this->getClubManager()->getClub()->getVisitingAddress();
		}
		return $this->clubvisitingaddress;
	}
	
	/**
	 * Get the teams of the club
	 * @return  SportlinkClubData\Team[]  List of teams
	 */
	public function getTeams()
	{
		if (!isset($this->teams))
		{
			$this->teams = $this->getClubManager()->getTeams(true);
		}
		return $this->teams;
	}
	
	
}