<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_clubdata
 *
 * @copyright   Copyright (C) 2018 vv Bruse Boys. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JLoader::register('ClubDataModelBase', __DIR__ . '/base.php');


use SportlinkClubData\Commission;
use SportlinkClubData\CommissionMember;

/**
 * ClubData Model Commissions
 *
 */
class ClubDataModelCommissions extends ClubDataModelBase
{
	
	/**
	 * @var Commission[] 
	 */
	protected $commissions=null;
	
	/**
	 * @var CommissionMember[][]
	 */
	protected $members=null;
	
	/**
	 * Get the club commissions
	 *
	 * @return Commission[]
	 */
	public function getCommissions()
	{
	    if (!isset($this->commissions))
	    {
            $this->commissions = $this->sportlink->getCommissions();
            // shuffle($this->commissions);
	    }
	    return $this->commissions;
	}
	
	/**
	 * Get the members
	 *
	 * @return CommissionMember[]
	 */
	public function getCommissionMembers()
	{
	    if (!isset($this->members))
	    {
	        foreach ($this->commissions as $commission) {
                $this->members[$commission->commissiecode] =  $commission->getMembers(true);
	        }
        }
	    return $this->members;
	}
		
}