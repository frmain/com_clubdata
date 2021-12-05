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

JLoader::register('ClubDataModelBase', __DIR__ . '/base.php');

use SportlinkClubData\League;
use SportlinkClubData\LeagueMatch;

/**
 * ClubData Model
 *
 */
class ClubDataModelLeagueSchedule extends ClubDataModelBase
{
	
	/**
	 * @var string
	 */
	private $leagueid = null;
	
	/**
	 * @var League
	 */
	protected $league=null;
	
	/**
	 * @var LeagueMatch[]
	 */
	protected $leagueschedule=null;
	
	/**
	 * @var LeagueMatch[]
	 */
	protected $ownleagueschedule=null;
	
	/**
	 * @var LeagueMatch[]
	 */
	protected $nextweekleagueschedule=null;
	
	/**
	 * Get the league
	 *
	 * @return League  The league object
	 * @throws Exception if league does not exist
	 */
	public function getLeague()
	{
		if (!isset($this->league))
		{
			$app = JFactory::getApplication();
			$this->leagueid = $app->input->get('league',null);
			$this->clubindex = $app->input->get('clubindex',-1);
			if (! $this->clubsmanager->getClubManager($this->clubindex)) {
				throw new Exception(JText::sprintf('COM_CLUBDATA_CLUB_NOTFOUND', $this->clubindex), 404);
			}
			try {
				$this->league = new League($this->clubsmanager->getClubManager($this->clubindex)->getDataManager(), $this->leagueid);
				//$this->league->populate();
			} catch (Exception $e) {
				throw new Exception(JText::sprintf('COM_CLUBDATA_LEAGUE_NOTFOUND', $this->leagueid), 404);
			}
		}
		return $this->league;
	}
	
	/**
	 * Get the league schedule for max 365 days ahead
	 *
	 * @return LeagueMatch[]
	 * @throws Exception if league does not exist
	 */
	public function getLeagueSchedule()
	{
		if (!isset($this->leagueschedule))
		{
			$this->leagueschedule = $this->getLeague()->getMatchSchedule(false, 365);
		}
		return $this->leagueschedule;
	}

	/**
	 * Get the leagueschedule for the coming weeks (14 days ahead) 
	 *
	 * @return LeagueMatch[]
	 * @throws Exception if league does not exist
	 */
	public function getNextWeekLeagueSchedule()
	{
		if (!isset($this->nextweekleagueschedule))
		{
			$this->nextweekleagueschedule = $this->getLeague()->getMatchSchedule(false, 14);
		}
		return $this->nextweekleagueschedule;
	}
	
	/**
	 * Get the own leagueschedule for max 365 days ahead 
	 *
	 * @return LeagueMatch[]
	 * @throws Exception if league does not exist
	 */
	public function getOwnLeagueSchedule()
	{
		if (!isset($this->ownleagueschedule))
		{
			$this->ownleagueschedule = $this->getLeague()->getMatchSchedule(true, 365);
		}
		return $this->ownleagueschedule;
	}
	
}