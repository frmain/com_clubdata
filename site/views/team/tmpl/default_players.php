<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_clubdata
 *
 * @copyright   Copyright (C) 2017 Bruse Boys
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

?>
<h2><?php echo JText::_('COM_CLUBDATA_PLAYERS_TITLE'); ?></h2>

<div class="clubdata-players"> 
	<div class="clubdata-player clubdata-header">
		<div class="clubdata-player-photo"><?php echo JText::_('COM_CLUBDATA_PLAYERS_PHOTO'); ?></div>
		<div class="clubdata-player-name"><?php echo JText::_('COM_CLUBDATA_PLAYERS_NAME'); ?></div>
		<div class="clubdata-player-function"><?php echo JText::_('COM_CLUBDATA_PLAYERS_FUNCTION'); ?></div>
		<div class="clubdata-player-role"><?php echo JText::_('COM_CLUBDATA_PLAYERS_ROLE'); ?></div>
	</div>
<?php $count_private = 0;
	foreach ($this->players as $player) { 
		if ($player->private) 
			$count_private++; 
		else { 
	?>

	<div class="clubdata-player">
		<div class="clubdata-player-photo">
		<?php if(!empty($player->foto)) {?>
			<img class="clubdata-player-img hasPopover" src="data:image/png;base64,<?php echo $player->foto ?>" alt="<?php echo JText::_('COM_CLUBDATA_PLAYERS_PHOTO');?>" 
				data-toggle="popover"
				data-trigger="hover"
				data-html="true"
				data-placement="top" 
				title="<?php echo $player->naam; ?>" 
				data-content="<img class='clubdata-player-img-popover' src='data:image/png;base64,<?php echo $player->foto; ?>' />"
			/>
		<?php } else {?>
			<img class="clubdata-player-img hasPopover" src="<?php echo Juri::root() . 'media/com_clubdata/images/anonymous.jpg'?>" alt="<?php echo JText::_('COM_CLUBDATA_PLAYERS_PHOTO_UNKNOWN');?>"
				data-toggle="popover"
				data-trigger="hover"
				data-html="true"
				data-placement="top" 
				title="<?php echo JText::_('COM_CLUBDATA_PLAYERS_PHOTO_UNKNOWN'); ?>" 
			 />
		<?php } ?>
		</div>
		<div class="clubdata-player-name"><?php echo $player->naam ?></div>
		<div class="clubdata-player-function"><?php echo $player->functie ?></div>
		<div class="clubdata-player-role"><?php echo $player->rol ?></div>
	</div>
	<?php } ?>
<?php } ?>
</div>
<?php if ($count_private) {?>
<div class="clubdata-footer">
	<div class="clubdata-player-name"><?php echo JText::plural('COM_CLUBDATA_PLAYERS_PRIVATE', $count_private); ?></div>
</div>
<?php }?>	