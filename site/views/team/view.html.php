<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');



/**
 * HTML View class for the ClubData Component
 */
class ClubDataViewTeam extends JViewLegacy
{
  
	/**
	 * Overriding JView display method
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 * @return  void
	 */
	function display($tpl = null) 
	{
		// Assign data to the view
        try {
    	    $this->club = $this->get('Club');
    		$this->teams = $this->get('Teams');
    		$this->team = $this->get('Team');
    		$this->leagues = $this->get('TeamLeagues');
    		$this->leagueteams = $this->get('LeagueTeams');
    		$this->leagueranking = $this->get('LeagueRanking');
    		$this->periodsranking = $this->get('PeriodsRanking');
    		/**
    		 * @var TeamPlayer[] $players
    		 */
    		$this->players = $this->get('PlayersOnly');
    		/**
    		 * @var TeamPlayer[] $staff
    		 */
    		$this->staff = $this->get('StaffOnly');

        } catch (Exception $e) {
            $this->warning[] = $e->getMessage();
        }
        
        !empty($this->get('Warning'))?? $this->warning[] = $this->get('Warning');
        $this->warningmessage = empty($this->warning)?"":implode(", <br/>", $this->warning);
		
		// Define tabs options
		$this->tabsrankingoptions = array("active" => "tabRankingDefault");
		$this->tabsresultsoptions = array("active" => "tabResultsLatest");
		$this->tabsscheduleoptions = array("active" => "tabScheduleNext");
		
		
 		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
 
			return false;
		}

		// Display the view
		parent::display($tpl);
	}
}