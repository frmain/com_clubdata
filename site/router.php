<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_clubdata
 */

defined('_JEXEC') or die;

use Joomla\CMS\Component\Router\RouterView;
use Joomla\CMS\Component\Router\RouterInterface;
use Joomla\CMS\Component\Router\RouterViewConfiguration;
use Joomla\CMS\Component\Router\Rules\MenuRules;
use Joomla\CMS\Component\Router\Rules\StandardRules;
use Joomla\CMS\Component\Router\Rules\NomenuRules;

JLoader::registerPrefix('ClubData', JPATH_SITE . '/components/com_clubdata');
JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_clubdata/models', 'ClubDataModel');

/**
 * Routing class from com_clubdata
 *
 * @since  3.3
 */
class ClubDataRouter extends RouterView
{
	protected $noIDs = false;
	
	protected $clubs = array();
	protected $teams = array();
	
	/**
	 * ClubData Component router constructor
	 *
	 * @param   JApplicationCms  $app   The application object
	 * @param   JMenu            $menu  The menu object to work with
	 */
	public function __construct($app = null, $menu = null)
	{
		$params = JComponentHelper::getParams('com_clubdata');
		$this->noIDs = (bool) $params->get('sef_ids');
		
		$club = new RouterViewconfiguration('club');
		$this->registerView($club);
		
		$clubstatic = new RouterViewconfiguration('clubstatic');
		$clubstatic->setKey('clubindex');
		$this->registerView($clubstatic);
		
		$team = new RouterViewconfiguration('team');
		$team->setKey('teamcode')->setParent($clubstatic, 'clubindex');
		$this->registerView($team);

		parent::__construct($app, $menu);
		
		$this->attachRule(new MenuRules($this));
		
		/* @todo  implement/test sef_advanced*/
		if ($params->get('sef_advanced', 0))
		{
			$this->attachRule(new StandardRules($this));
			$this->attachRule(new NomenuRules($this));
		}
		
		$basemodel = JModelLegacy::getInstance('Base', 'ClubDataModel');
		if ($basemodel) { 
			$this->clubs = $basemodel->getClubs();
			$this->teams = $basemodel->getClubTeams();
		}
		
	}
	

	/**
	 * try to find a clubindex for a team in teams array
	 * @return integer   index of the club within the list of clubmanagers
	 */
	public function findClubindex($teamcode)
	{
		foreach($this->teams as $clubindex=>$teams) {
			if (key_exists($teamcode, $teams))
				return $clubindex;
		}
		# when not found
		return -1;
	}

	/**
	 * Method to get the segment(s) for a team
	 *
	 * @param   string  $id     teamcode of the team to retrieve the segments for
	 * @param   array   $query  The request that is built right now
	 *
	 * @return  array|string  The segments of this item
	 */
	public function getTeamSegment($id, $query)
	{

		if (!strpos($id, ':'))
		{
			# try to find a clubindex when not provided
			if (empty($query["clubindex"])) {
				$clubindex = $this->findClubindex($id);
			} else {
				$clubindex = $query["clubindex"];
			}
			if (!empty($this->teams[$clubindex]) && key_exists($id, $this->teams[$clubindex]))
				$id .= ':' . $this->teams[$clubindex][$id]->teamnaam_full;
		}
		
		if ($this->noIDs)
		{
			list($void, $segment) = array_pad(explode(':', $id, 2), 2, null);
			
			return array($void => $segment);
		}

		return array((int) $id => $id);
	}

	/**
	 * Method to get the id for a team
	 *
	 * @param   string  $segment  Segment of the contact to retrieve the Teamcode for
	 * @param   array   $query    The request that is parsed right now
	 *
	 * @return  mixed   The id of this item or false
	 */
	public function getTeamId($segment, $query)
	{
		if ($this->noIDs)
		{
			return (int) array_search($segment, $this->teams);
		}

		return (int) $segment;
	}

	/**
	 * Method to get the segment(s) for a club
	 *
	 * Clubstatic is the view where we do this for.
	 * 
	 * @param   string  $id     clubmanagerindex of the club to retrieve the segments for
	 * @param   array   $query  The request that is built right now
	 *
	 * @return  array|string  The segments of this item
	 */
	public function getClubstaticSegment($index, $query)
	{
		
		if (!strpos($index, ':'))
		{
			if (!empty($this->clubs) && key_exists($index, $this->clubs))
				$index .= ':' . $this->clubs[$index]->clubnaam;
		}
		
		if ($this->noIDs)
		{
			list($void, $segment) = array_pad(explode(':', $index, 2), 2, null);
			
			return array($void => $segment);
		}
		
		return array((int) $index => $index);
	}
	
	/**
	 * Method to get the index for a club
	 *
	 * @param   string  $segment  Segment of the contact to retrieve the Teamcode for
	 * @param   array   $query    The request that is parsed right now
	 *
	 * @return  mixed   The indexnr of this item or false
	 */
	public function getClubstaticId($segment, $query)
	{
		if ($this->noIDs)
		{
			return (int) array_search($segment, $this->clubs);
		}
		
		return (int) $segment;
	}
	

/* These function build en parse can be overridden

	public function build(&$query)
	{
	}

	public function parse(&$segments)
	{
	}
*/
	
}



/* THESE FUNCTIONS ARE FOR OLD JOOMLA VERSIONS, MIGHT BE DELETED IN FUTURE */

/**
 * ClubData router functions
 *
 * These functions are proxys for the new router interface
 * for old SEF extensions.
 *
 * @param   array  &$query  An array of URL arguments
 *
 * @return  array  The URL arguments to use to assemble the subsequent URL.
 *
 * @deprecated  4.0  Use Class based routers instead
 */
function ClubDataBuildRoute(&$query)
{
	$app = JFactory::getApplication();
	$router = new ClubDataRouter($app, $app->getMenu());

	return $router->build($query);
}

/**
 * ClubData router functions
 *
 * These functions are proxys for the new router interface
 * for old SEF extensions.
 *
 * @param   array  $segments  The segments of the URL to parse.
 *
 * @return  array  The URL attributes to be used by the application.
 *
 * @deprecated  4.0  Use Class based routers instead
 */
function ClubDataParseRoute($segments)
{
	$app = JFactory::getApplication();
	$router = new ClubDataRouter($app, $app->getMenu());

	return $router->parse($segments);
}
