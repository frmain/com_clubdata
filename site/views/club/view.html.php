<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');



/**
 * HTML View class for the ClubData Component
 */
class ClubDataViewClub extends JViewLegacy
{

	/**
	 * Overriding JView display method
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 * @return  void
	 */
	function display($tpl = null) 
	{
		// get last tab from session
		$sess = JFactory::getSession();
		$activetab=$sess->get('clubviewactivetab', 'tabClubScheduleHome', 'com_clubdata');
		
		// Define tabs options
		$this->tabscluboptions = array("active" => $activetab);
		
		
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