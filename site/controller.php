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
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * ClubData Component Controller
 */
class ClubDataController extends JControllerLegacy
{
	
	/**
	 * Get the leagueresults for viewing 
	 * 
	 * reacts to call: index.php?option=com_clubdata&task=leagueresults
	 * alternative display function

	 */
	public function leagueResults() {
		//set view
		$this->input->set('view', 'leagueresults');
		
		// bind the 'team' model to the view as the default model
		$view = $this->getView('leagueresults', 'raw');
		$view->setModel($this->getModel('team'), true);

		// set the layout of the view
		$layout = $this->input->get('layout');
		$view->setLayout($layout);
		
		$view->display();
	}
	
	
	/**
	 * Method to display a view; override.
	 *
	 * @see JControllerLegacy 
	 */
	public function display($cachable = false, $urlparams = false)
	{
		
		$viewname = $this->input->get('view');
		$layout = $this->input->get('layout');
		
		// bind the 'leagueschedule' model to the view as the default model
		if (in_array($viewname, ['ownleagueschedule', 'nextleagueschedule'])) {
			$view = $this->getView($viewname, 'raw');
			$view->setModel($this->getModel('leagueschedule'), true);
			// set the layout of the view
			$view->setLayout($layout);
		}

		// bind the 'leagueresults' model to the view as the default model
		if (in_array($viewname, ['latestleagueresults', 'ownleagueresults', 'matchescrosstable'])) {
				$view = $this->getView($viewname, 'raw');
				$view->setModel($this->getModel('leagueresults'), true);
				// set the layout of the view
				$view->setLayout($layout);
		}
		
		// bind the 'club' model to the view as the default model
		if (in_array($viewname, ['clubschedule', 'clubschedulehome', 'clubscheduleaway', 'clubresults', 'clubcancellations'])) {
		    $view = $this->getView($viewname, 'raw');
		    $view->setModel($this->getModel('club'), true);
		    // set the layout of the view
		    $view->setLayout($layout);
		}
		
		
		return parent::display();
	}
	
	
}