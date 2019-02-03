<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_clubdata
 */

defined('_JEXEC') or die;

use Joomla\CMS\Component\Router\RouterView;
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
        
        $team = new RouterViewconfiguration('team');
        $team->setKey('teamcode');
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
        if ($basemodel) $this->teams = $basemodel->getTeams();
        
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
            if (key_exists($id, $this->teams))
                $id .= ':' . $this->teams[$id]->teamnaam;
        }
        
        if ($this->noIDs)
        {
            list($void, $segment) = array_pad(explode(':', $id, 2), 2, null);
            
            return array($void => $segment);
        }

        return array((int) $id => $id);
    }

    /**
     * Method to get the segment(s) for a team
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
    
    
}

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
