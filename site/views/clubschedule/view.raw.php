<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Raw html View class for the ClubData Component (for calling ajax)
 * Display league results
 */
class ClubDataViewClubSchedule extends JViewLegacy
{

	/**
	 * @var SportlinkClubData\ClubAddress
	 */
	protected $accommodotion;
	
	/**
	 * @var SportlinkClubData\ClubMatch[]
	 */
	protected $clubschedule;
	
	/**
	 * @var array
	 */
	protected $schedulescope;
	
	/**
	 * @var string
	 */
	protected $warningmessage;
	
	/**
	 * Overriding JView display method
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 * @return  void
	 */
	function display($tpl = null)
	{
		try {
			$this->accommodation = $this->get('Accommodation');
			$this->clubschedule = $this->get('NextWeekSchedule');
		    $this->schedulescope = $this->get('ScheduleScope');
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
		
		$app = JFactory::getApplication();
		$app->setHeader('Access-Control-Allow-Origin', '*');
		
		parent::display($tpl);
	}
	
}
