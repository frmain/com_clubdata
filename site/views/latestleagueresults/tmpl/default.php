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
elseif (empty($this->latestleagueresults)) 
{ ?>
<div class="clubdata-nomatches alert alert-info">
	<?php echo JText::_('COM_CLUBDATA_RESULTS_LATEST_NO_MATCHES'); ?>
</div>
<?php 
} 
else 
{ ?>

<div class="clubdata-results"> 
	<div class="clubdata-match clubdata-header">
		<div class="clubdata-match-date"><?php echo JText::_('COM_CLUBDATA_MATCH_DATE'); ?></div>
		<div class="clubdata-match-title"><?php echo JText::_('COM_CLUBDATA_MATCH'); ?></div>
		<div class="clubdata-match-result"><?php echo JText::_('COM_CLUBDATA_MATCH_RESULT'); ?></div>
	</div>
	<?php foreach ($this->latestleagueresults as $match) { ?>
	<div class="clubdata-match <?php if ($match->eigenteam) {echo 'clubdata-favourite';} ?>">
		<div class="clubdata-match-date"><?php echo $match->datumopgemaakt ?></div>
		<div class="clubdata-match-title">
			<span class="clubdata-match-home"><?php echo $match->thuisteam ?></span>
			<span><?php echo JText::_('COM_CLUBDATA_TEAMSEPARATOR') ?></span>
			<span class="clubdata-match-away"><?php echo $match->uitteam ?></span>			
		</div>
		<?php if (!empty($match->uitslag)) {?>
		<div class="clubdata-match-result"><?php echo $match->uitslag ?></div>
		<?php } else {?>
		<div class="clubdata-match-state"><?php echo $match->status ?></div>
		<?php } ?>
	</div>
	<?php } ?>
</div>
<?php } ?>
