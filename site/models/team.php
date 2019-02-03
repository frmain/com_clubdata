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


use SportlinkClubData\Team;
use SportlinkClubData\League;
use SportlinkClubData\LeaguePosition;
use SportlinkClubData\LeaguePeriod;
use SportlinkClubData\TeamPlayer;
use SportlinkClubData\Exception\InvalidResponseException;

define('SEASONSTART', '01-07'); // start of season is at 1st of July

/**
 * ClubData Model Team
 *
 */
class ClubDataModelTeam extends ClubDataModelBase
{
	
	/**
	 * @var string
	 */
	private $teamcode = null;
	
	/**
	 * @var Team 
	 */
	protected $team;
	
	/**
	 * @var League[]
	 */
	protected $leagues;
	
	/**
	 * @var League[]
	 */
	protected $currentleagues;
	
	/**
	 * @var Team[]
	 */
	protected $leagueteams=null;
	
	/**
	 * @var LeaguePosition[]
	 */
	protected $leagueranking=null;
	
	/**
	 * @var LeaguePeriod[]
	 */
	protected $leagueperiods=null;
	
	/**
	 * @var LeaguePeriod[LeaguePosition[]]
	 */
	protected $periodsranking=null;
	
	/**
	 * @var TeamPlayer[]
	 */
	protected $players=null;
	
	
	/**
	 * Get the team
	 * 
	 * @return Team  The team object
	 * @throws Exception if team does not exist
	 */
	public function getTeam()
	{
		if (!isset($this->team))
		{
			$app = JFactory::getApplication();
			$this->teamcode = $app->input->get('teamcode',null);
			try {
				$this->team = new Team($this->sportlink, $this->teamcode,-1, array(), true);
			} catch (InvalidResponseException $e) {
				throw new Exception(JText::sprintf('COM_CLUBDATA_TEAM_NOTFOUND', $this->teamcode), 404);
			}
		}
		return $this->team;
	}
	
	/**
	 * Get all leagues where team participates in
	 *
	 * @return League[] 
	 */
	public function getTeamLeagues()
	{
		if (!isset($this->leagues))
		{	
			$this->leagues = $this->getTeam()->getLeagues();
			$app = JFactory::getApplication();
			$this->setCurrentLeagueID($app->input->getvar('league'));
		}
		return $this->leagues;
	}

	/**
	 * Get only the regular and current leagues where team participates in 
	 *
	 * Normally this results only in 1 league
	 *
	 * @return League[]
	 */
	public function getCurrentTeamLeagues()
	{
		if (!isset($this->currentleagues))
		{
			$this->currentleagues = $this->getTeam()->getLeagues(true, false);
		}
		return $this->currentleagues;
	}
	
	
	/**
	 * Set the current leagueID (poulecode)
	 *
	 * @param integer|null $leagueid If leagueID is not specified or does not exist, this function tries to find a valid one
	 * @return string $leagueid
	 */
	private function setCurrentLeagueID($leagueid=null)
	{
		$app = JFactory::getApplication();
		if (!isset($leagueid)) {
			$this->getCurrentTeamLeagues();
			$league = reset($this->currentleagues);
			$leagueid = $league->poulecode;
		} else {
			if (!array_key_exists($leagueid, $this->getTeamLeagues())) {
				$league = reset($this->leagues);
				$leagueid = $league->poulecode;
			}
		}
		$app->input->set('league', $leagueid);
		$app->getSession()->set('league', $leagueid);
		return $leagueid;
	}

	/**
	 * Get the current leagueID (poulecode)
	 *
	 * @return integer
	 */
	public function getCurrentLeagueID()
	{
		$app = JFactory::getApplication();
		$league=$app->input->getvar('league');
		if (isset($league))
			return $league;
		$league=$app->getSession()->get('league');
		return $league;
	}
	
	/**
	 * Get the ranking of the league
	 *
	 * @return LeaguePosition[]
	 * @throws Exception if league does not exist
	 */
	public function getLeagueRanking()
	{
		if (!isset($this->leagueranking))
		{
			$currentleagueid = $this->getCurrentLeagueID();
			$leagues = $this->getTeamLeagues();
			if (array_key_exists($currentleagueid, $leagues))
				$league = $leagues[$currentleagueid];
			else {
				//league does not exist, try to set another one
				$currentleagueid = $this->setCurrentLeagueID();
				if (array_key_exists($currentleagueid, $leagues))
					$league = $leagues[$currentleagueid];
				else
					throw new Exception(JText::sprintf('COM_CLUBDATA_LEAGUE_NOTFOUND', $currentleagueid), 404);
			}
			if (isset($league)) {
				$this->leagueranking = $league->getRanking();
			}
		}
		return $this->leagueranking;
	}
	
	/**
	 * Get the teams in the league
	 *
	 * @return LeaguePosition[]
	 */
	public function getLeagueTeams()
	{
		if (!isset($this->leagueteams))
		{
			$this->leagueteams = $this->getLeagueRanking();
			usort($this->leagueteams, function ($team1, $team2) {
				if ($team1->teamnaam == $team2->teamnaam) return 0;
				return ($team1->teamnaam < $team2->teamnaam)? -1 : 1;
			});
		}
		return $this->leagueteams;
	}
	
	/**
	 * Get the periods in the league
	 *
	 * @return LeaguePeriod[]
	 */
	public function getLeaguePeriods()
	{
		if (!isset($this->leagueperiods))
		{
			$currentleagueid = $this->getCurrentLeagueID();
			$league = $this->getTeamLeagues()[$currentleagueid];
			if (isset($league)) {
				$this->leagueperiods = $league->getPeriods();
			}
		}
		return $this->leagueperiods;
	}
	
	/**
	 * Get the periods in the league
	 *
	 * @return LeaguePeriod[][]
	 */
	public function getPeriodsRanking()
	{
		if (!isset($this->periodsranking))
		{
			$this->periodsranking = array();
			foreach ($this->getLeaguePeriods() as $period) {
				$this->periodsranking[$period->waarde] = $period->getRanking();
			}
		}
		return $this->periodsranking;
	}
	

	/**
	 * Get the teamplayers, including staff
	 *
	 * @return TeamPlayer[]
	 */
	public function getTeamPlayers()
	{
		if (!isset($this->players))
		{
			$this->players = $this->getTeam()->getPlayers(true);
		}
		return $this->players;
	}
	
	/**
	 * Get the teamplayers only
	 *
	 * @return TeamPlayer[]
	 */
	public function getPlayersOnly()
	{
		return $this->getTeam()->getPlayers(true,1);
	}
	
	/**
	 * Get the staff only
	 *
	 * @return TeamPlayer[]
	 */
	public function getStaffOnly()
	{
		return $this->getTeam()->getPlayers(true,2);
	}
	
}