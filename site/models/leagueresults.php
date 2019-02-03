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
use SportlinkClubData\LeagueMatch;
use SportlinkClubData\Exception\InvalidResponseException;

define('SEASONSTART', '01-07'); // start of season is at 1st of July

/**
 * ClubData Model
 *
 */
class ClubDataModelLeagueResults extends ClubDataModelBase
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
	 * @var Team[]
	 */
	protected $leagueteams=null;
		
	/**
	 * @var LeagueMatch[]
	 */
	protected $latestleagueresults=null;

	/**
	 * @var LeagueMatch[]
	 */
	protected $ownleagueresults=null;
	
	/**
	 * @var LeagueMatch[]
	 */
	protected $allleagueresults=null;

	/**
	 * @var LeagueMatch[][]
	 */
	protected $matchescrosstable=null;

	/**
	 * Calculate the weekoffset and daysahead for getting all matches of the whole season
	 *
	 * @param integer $weekoffset calculated weekoffset based on SEASONSTART (1-Jul), pass by reference
	 * @param integer $daysahead calculated days from weekoffset to current date, pass by reference
	 * @return void
	 */
	private function calcSeasonStart(&$weekoffset, &$daysahead)
	{
		$now = new DateTime();
		$startofseason = DateTime::createFromFormat('d-m', SEASONSTART);
		if ($startofseason > $now) {
			$startofseason = $startofseason->modify('-1 year');
		}
		$interval = $now->diff($startofseason, true);
		$weekoffset = ceil($interval->days/7)*-1;
		$daysahead = abs($weekoffset) * 7;
	}
	
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
			try {
				$this->league = new League($this->sportlink, $this->leagueid);
				//$this->league->populate();
			} catch (InvalidResponseException $e) {
				throw new Exception(JText::sprintf('COM_CLUBDATA_LEAGUE_NOTFOUND', $this->leagueid), 404);
			}
		}
		return $this->league;
	}
	
	/**
	 * Get the teams in the league
	 *
	 * @return LeaguePosition[]
	 * @throws Exception if league does not exist
	 */
	public function getLeagueTeams()
	{
		if (!isset($this->leagueteams))
		{
			$this->leagueteams = $this->getLeague()->getRanking();
			usort($this->leagueteams, function ($team1, $team2) {
				if ($team1->teamnaam == $team2->teamnaam) return 0;
				return ($team1->teamnaam < $team2->teamnaam)? -1 : 1;
			});
		}
		return $this->leagueteams;
	}
	
	
	/**
	 * Get the latest results for the league
	 *
	 * @return LeagueMatch[]
	 * @throws Exception if league does not exist
	 */
	public function getLatestLeagueResults()
	{
		if (!isset($this->latestleagueresults))
		{
			$this->latestleagueresults = $this->getLeague()->getMatchResults();
			// descending sort on match date
			usort($this->latestleagueresults, function ($match1, $match2) {
			    if ($match1->wedstrijddatum == $match2->wedstrijddatum) return 0;
			    return ($match1->wedstrijddatum > $match2->wedstrijddatum)? -1 : 1;
			});
		}
		return $this->latestleagueresults;
	}

	
	/**
	 * Get the own results for the league
	 *
	 * @return LeagueMatch[]
	 * @throws Exception if league does not exist
	 */
	public function getOwnLeagueResults()
	{
		if (!isset($this->ownleagueresults))
		{
			$onlyownteam = true;
			$this->calcSeasonStart($weekoffset, $daysahead);
			
			$this->ownleagueresults = $this->getLeague()->getMatchResults($onlyownteam, $daysahead, $weekoffset);
			// descending sort on match date
			usort($this->ownleagueresults, function ($match1, $match2) {
			    if ($match1->wedstrijddatum == $match2->wedstrijddatum) return 0;
			    return ($match1->wedstrijddatum > $match2->wedstrijddatum)? -1 : 1;
			});
		}
		return $this->ownleagueresults;
	}
	
	/**
	 * Get the all results for the league
	 *
	 * @return LeagueMatch[]
	 * @throws Exception if league does not exist
	 */
	public function getAllLeagueResults()
	{
		if (!isset($this->allleagueresults))
		{
			$onlyownteam = false;
			$this->calcSeasonStart($weekoffset, $daysahead);
			
			$this->allleagueresults = $this->getLeague()->getMatchResults($onlyownteam, $daysahead, $weekoffset);
			// descending sort on match date
			usort($this->allleagueresults, function ($match1, $match2) {
			    if ($match1->wedstrijddatum == $match2->wedstrijddatum) return 0;
			    return ($match1->wedstrijddatum > $match2->wedstrijddatum)? -1 : 1;
			});
		}
		return $this->allleagueresults;
	}
	
	/**
	 * Get the all matches for the league in a combined table with results and schedule
	 *
	 * @return LeagueMatch[][]
	 * @throws Exception if league does not exist
	 */
	public function getMatchesCrossTable()
	{
		if (!isset($this->matchescrosstable))
		{
			$results = $this->getAllLeagueResults();
			$scheduledmatches = $this->getLeague()->getMatchSchedule(false, 365);
			
			$hometeams = $this->getLeagueTeams();
			$awayteams = $this->getLeagueTeams();
			foreach ($hometeams as $hometeam) {
				foreach ($awayteams as $awayteam) {
					($hometeam == $awayteam)? $away[$awayteam->teamnaam] = '===' : $away[$awayteam->teamnaam] = '***';
				}
				$this->matchescrosstable[$hometeam->teamnaam] = $away;
			}
			
			/* overwrite with LeagueMatch object including the result when match has been played */
			foreach ($results as $match) {
				$this->matchescrosstable[$match->thuisteam][$match->uitteam]= $match;
			}
			
			/* overwrite with LeagueMatch object including the scheduled date when match has to be played */
			foreach ($scheduledmatches as $match) {
			    if (key_exists($match->thuisteam, $this->matchescrosstable) && key_exists($match->uitteam, $this->matchescrosstable[$match->thuisteam])) {
			        $this->matchescrosstable[$match->thuisteam][$match->uitteam]= $match;
			    }
			}
			
		}
		return $this->matchescrosstable;
	}
	
}