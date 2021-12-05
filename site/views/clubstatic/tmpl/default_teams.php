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
$clubindex = $input->get('clubindex',-1);

?>
<h2><?php echo JText::_('COM_CLUBDATA_CLUBSTATIC_TEAMS'); ?></h2>

<div class="clubdata-teams"> 
	<div class="clubdata-line clubdata-header">
		<div class="clubdata-team-title"><?php echo JText::_('COM_CLUBDATA_CLUBSTATIC_PHOTO'); ?></div>
		<div class="clubdata-team-title"><?php echo JText::_('COM_CLUBDATA_CLUBSTATIC_TEAM'); ?></div>
	</div>
<?php foreach ($this->teams as $team) {
	$link = 'index.php?view=team&teamcode='.$team->teamcode.'&clubindex='.$clubindex;
?>
	<div class="clubdata-line clubdata-clubteam" data-href="<?php echo JRoute::_($link) ?>">
		<div class="clubdata-static-photo">
			<?php if (isset($team->teamfoto)) { ?>
			<img class="clubdata-team-img" src="data:image/png;base64, <?php echo $team->teamfoto; ?>" alt="<?php echo $team->teamnaam_full ?>" />
			<?php } else { ?>
			<img class="clubdata-team-img" src="media/com_clubdata/images/anonymous_team.jpg" alt="<?php echo $team->teamnaam_full ?>" />
			<?php } ?>
		</div>
		<div class="clubdata-static-value">
			<?php echo $team->teamnaam_full ?>
		</div>
	</div>
<?php } ?>
</div>
<?php 
$document = JFactory::getDocument();
$document->addScriptDeclaration('
	(function($){
		$(document).ready(function() {
		    $(".clubdata-clubteam").click(function() {
		        window.document.location = $(this).data("href");
		    });
		});
	}) (jQuery);
');
?>
