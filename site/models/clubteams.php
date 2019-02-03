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

use SportlinkClubData\Team;
use SportlinkClubData;

/**
 * ClubData Model for Club related items
 *
 */
class ClubDataModelClubteams extends ClubDataModelBase
{
	/**
	 * @var Team[] 
	 */
	protected $teams;
 
	/**
	 * Get the teams of the club
	 * @return  SportlinkClubData\Team[]  List of teams
	 */
	public function getTeams()
	{
		if (!isset($this->teams))
		{
			$this->teams = $sportlink->getTeams();
		}
		return $this->teams;
	}
	
	
}