<?php
use Joomla\CMS\Uri\Uri;

/**
 * @package     Joomla.Site
 * @subpackage  com_clubdata
 *
 * @copyright   Copyright (C) 2017 Bruse Boys
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$input = JFactory::getApplication()->input;
$currleague = $input->get('league');

?>
<h2><?php echo JText::_('COM_CLUBDATA_LEAGUES_TITLE'); ?></h2>

<div class="clubdata-leagues"> 
	<div class="clubdata-header">
		<div class="clubdata-league-title"><?php echo JText::_('COM_CLUBDATA_LEAGUE_SELECT'); ?></div>
		<div class="clubdata-league-title"><?php echo JText::_('COM_CLUBDATA_LEAGUE_TITLE'); ?></div>
		<div class="clubdata-league-title"><?php echo JText::_('COM_CLUBDATA_LEAGUE_CLASS'); ?></div>
	</div>
<?php foreach ($this->leagues as $league) { 
	$link = new Uri('index.php?option=com_clubdata&view=team&teamcode='.$league->teamcode);
	$link->setVar('clubindex', $league->clubindex);
	$link->setVar('league', $league->poulecode);
	$link = JRoute::_($link);
?>
 
	<div class="clubdata-league <?php if ($currleague == $league->poulecode) echo "clubdata-league-selected"; ?>" data-href="<?php echo $link ?>">
		<div class="clubdata-league-select">
		<?php 
		if ($currleague == $league->poulecode) { ?>
			<span class="glyphicon glyphicon-hand-right"></span><span><?php echo JText::_('COM_CLUBDATA_SELECTED'); ?>&nbsp;</span>
		<?php 
		} else {
			if (isset($league->poulecode)) { 
		?>
			<a href="<?php echo $link ?>" class="btn btn-default btn-info"><?php echo JText::_('COM_CLUBDATA_SELECT'); ?></a>
		<?php 
			}
		} ?>
		</div>
		<div class="clubdata-league-title"><?php echo $league->competitienaam ?></div>
		<div class="clubdata-league-class"><?php echo $league->klasse ?></div>
		
	</div>
<?php } ?>
</div>
<?php 
$document = JFactory::getDocument();
$document->addScriptDeclaration('
	(function($){
		$(document).ready(function() {
		    $(".clubdata-league").click(function() {
		        window.document.location = $(this).data("href");
		    });
		});
	}) (jQuery);
');

?>