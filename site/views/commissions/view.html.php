<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');



/**
 * HTML View class for the ClubData Component
 */
class ClubDataViewCommissions extends JViewLegacy
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
			$this->commissions = $this->get('Commissions');
			$this->members = $this->get('CommissionMembers');
		} catch (Exception $e) {
			JLog::add($e->getMessage(), JLog::ERROR, 'com_clubdata');
			if ($e->getCode() == 0) {
				$this->warning[] = JText::sprintf("COM_CLUBDATA_SPORTLINK_DATA_ERROR",$e->getMessage());
			} else {
				// reraise and show error page
				throw new Exception(JText::_("COM_CLUBDATA_SPORTLINK_NOT_FOUND"), 404);
			}
		}

		!empty($this->get('Warning'))?? $this->warning[] = $this->get('Warning');
		$this->warningmessage = empty($this->warning)?"":implode(", <br/>", $this->warning);

		// Display the view
		parent::display($tpl);
	}
}