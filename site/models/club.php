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

JLoader::register('ClubDataModelBase', __DIR__ . '/base.php');

use SportlinkClubData\ClubMatch;


/**
 * ClubData Model
 *
 */
class ClubDataModelClub extends ClubDataModelBase
{
	/**
	 * @var ClubMatch[]
	 */
	protected $nextweekschedule;
	
	/**
	 * @var array
	 */
	protected $schedulescope;
	
    /**
	 * @var ClubMatch[]
	 */
	protected $lastweekresults;
	
	/**
	 * @var ClubMatch[]
	 */
	protected $cancellations;
	
	/**
	 * Get the schedule for all teams of the club for the coming week(s)
	 *
	 * @return ClubMatch[]
	 */
	public function getNextWeekSchedule()
	{
	    $app = JFactory::getApplication();
	    $homeaway=$app->input->getvar('homeaway');
	    $home = true; $away = true;
	    if ($homeaway=="home") $away = false;
	    if ($homeaway=="away") $home = false;
	    $daysahead=$app->input->getvar('daysahead', 8);
	    return $this->getClubSchedule($daysahead, $home, $away);
	}
	
	/**
	 * Get the schedule for all teams of the club for the x days ahead (default 8 days ahead)
	 *
	 * @return ClubMatch[]
	 */
	public function getClubSchedule($daysahead=8, $home=true, $away=true)
	{
        $this->schedulescope = array("home"=>$home, "away" => $away, "daysahead" => $daysahead);
        $this->nextweekschedule = $this->clubsmanager->getSchedule($daysahead, null, null, true, "datum", null, $home, $away);
	    return $this->nextweekschedule;
	}
	
	/**
	 * Get the schedulescope 
	 *
	 * @return array
	 */
	public function getScheduleScope()
	{
	    return $this->schedulescope;
	}
	    
	/**
	 * Get the results of all teams of the club from last weeks 
	 *
	 * @return ClubMatch[]
	 */
	public function getLastWeekResults()
	{
	    $app = JFactory::getApplication();
	    $daysback=$app->input->getvar('daysback', null);
	    return $this->getClubResults($daysback);
	}
	
	/**
	 * Get the results for all teams of the club from last x days back (default 7 days back)
	 *
	 * @return ClubMatch[]
	 */
	public function getClubResults($daysback=7)
	{
   	    $this->schedulescope = array("daysback" => $daysback);
   	    $this->lastweekresults = $this->clubsmanager->getResults($daysback, floor($daysback/7)*-1, null, null, true, "datum-team-tijd-omgekeerd");
        return $this->lastweekresults;
	}
	
	/**
	 * Get the cancellations of all teams of the club for the next period (30 days ahead from now)
	 *
	 * @return ClubMatch[]
	 */
	public function getCancellations()
	{
	    if (!isset($this->cancellations))
	    {
	    	$this->cancellations = $this->clubsmanager->getCancellations();
	    }
	    return $this->cancellations;
	}
	
	
}