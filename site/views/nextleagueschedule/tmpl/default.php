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

if (!empty($this->warningmessage)) { ?>
<div class="clubdata-message alert alert-warning">
	<?php echo $this->warningmessage; ?>
</div>
<?php 
} 
elseif (empty($this->leagueschedule)) { ?>
<div class="clubdata-nomatches  alert alert-info">
	<?php echo JText::_('COM_CLUBDATA_SCHEDULE_NEXT_NO_MATCHES'); ?>
</div>
<?php 
} 
else 
{ ?>

<div id="clubdata-schedule-next" class="clubdata-schedule"> 
	<div class="clubdata-match clubdata-header">
		<div class="clubdata-match-date"><?php echo JText::_('COM_CLUBDATA_MATCH_DATE'); ?></div>
		<div class="clubdata-match-time"><?php echo JText::_('COM_CLUBDATA_MATCH_TIME'); ?></div>
		<div class="clubdata-match-title"><?php echo JText::_('COM_CLUBDATA_MATCH'); ?></div>
	</div>
	<?php foreach ($this->leagueschedule as $match) { ?>
	<div class="clubdata-match hasPopover<?php if ($match->eigenteam) {echo ' clubdata-favourite';} ?><?php if ($match->getStatuscode() == 1) { echo ' clubdata-match-cancelled'; } ?>"
			data-toggle="popover"
			data-trigger="hover"
			data-html="true"
			data-container="#clubdata-schedule-next"
			data-placement="auto top" 
			title="<?php echo JText::_('COM_CLUBDATA_MATCH_DETAILS'); ?>" 
			data-content="<?php echo JText::_('COM_CLUBDATA_MATCH'), JText::_('COM_CLUBDATA_ENUMERATION'), "<strong>", $match->wedstrijd, "</strong><br/>",
			JText::_('COM_CLUBDATA_MATCH_FACILITIES'), JText::_('COM_CLUBDATA_ENUMERATION'), htmlspecialchars($match->accommodatie), "<br/>",
			JText::_('COM_CLUBDATA_MATCH_PLACE'), JText::_('COM_CLUBDATA_ENUMERATION'), htmlspecialchars($match->plaats), "<br/>",
			JText::_('COM_CLUBDATA_MATCH_CODE'), JText::_('COM_CLUBDATA_ENUMERATION'), $match->wedstrijdcode, "<br/>", 
			JText::_('COM_CLUBDATA_MATCH_NR'), JText::_('COM_CLUBDATA_ENUMERATION'), $match->wedstrijdnummer; ?>"
	>
		<div class="clubdata-match-date"><?php echo $match->datumopgemaakt ?></div>
		<div class="clubdata-match-time"><?php echo $match->aanvangstijd ?></div>
		<div class="clubdata-match-title"> 
			<span class="clubdata-match-home"><?php echo $match->thuisteam ?></span>
			<span><?php echo JText::_('COM_CLUBDATA_TEAMSEPARATOR') ?></span>
			<span class="clubdata-match-away"><?php echo $match->uitteam ?></span>			
   			<?php if ($match->getStatuscode() == 1) { ?>
    			<span class="clubdata-match-cancellation">
    				<?php echo JText::_('COM_CLUBDATA_MATCH_CANCELLED'); ?>
    			</span>
    		<?php }?>
		</div>
	</div>
	<?php } ?>
</div>
<?php } ?>
