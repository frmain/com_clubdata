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

use SportlinkClubData\ClubData;
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
	 * @var ClubData $sportlink
	 */
	protected $sportlink;
	
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
	 * @var array
	 */
	protected $warning=[];
	
	public function __construct($config)
	{
		parent::__construct($config);
		
		/**
		 * @var string $key
		 */
		$key = JComponentHelper::getParams('com_clubdata')->get('clientid');
        $this->sportlink = Sportlink::getInstance($key);
	}
	
	/**
	 * Get the club
	 *
	 * @return Club  The club object
	 */

	public function getClub()
	{
        $this->club = $this->sportlink->getClub();
    	return $this->club;
	}
	
	/**
	 * Get the Accommation of the club (Visiting Address)
	 *
	 * @return ClubAddress  The visiting address (accommodation)
	 */
	
	public function getAccommodation()
	{
		$this->accommodation = $this->sportlink->getClub()->getVisitingAddress();
		return $this->accommodation;
	}
	
	/**
	 * Get the teams of the club
	 * @return  SportlinkClubData\Team[]  list of clubteams
	 */
	public function getTeams()
	{
        $this->teams = $this->sportlink->getTeams();
    	return $this->teams;
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