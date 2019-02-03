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
<h3><?php echo JText::_('COM_CLUBDATA_CLUB_TAB_CANCELLATIONS'); ?></h3>

<?php 
if (!empty($this->warningmessage)) { ?>
<div class="clubdata-message alert alert-warning">
	<?php echo $this->warningmessage; ?>
</div>
<?php 
} elseif (empty($this->clubcancellations)) { ?>
<div class="clubdata-nomatches alert alert-info">
	<?php echo JText::_('COM_CLUBDATA_CLUB_CANCELLATIONS_NO_MATCHES'); ?>
</div>
<?php 
} 
else 
{ ?>

<div id="clubdata-clubcancellations" class="clubdata-clubcancellations"> 
	<div class="clubdata-match clubdata-header">
		<div class="clubdata-match-date"><?php echo JText::_('COM_CLUBDATA_MATCH_DATE'); ?></div>
		<div class="clubdata-match-time"><?php echo JText::_('COM_CLUBDATA_MATCH_TIME'); ?></div>
		<div class="clubdata-match-home"><?php echo JText::_('COM_CLUBDATA_MATCH_HOMETEAM'); ?></div>
		<div class="clubdata-match-away"><?php echo JText::_('COM_CLUBDATA_MATCH_AWAYTEAM'); ?></div>
		<div class="clubdata-match-facilities"><?php echo JText::_('COM_CLUBDATA_MATCH_FACILITIES'); ?></div>
		<div class="clubdata-match-place"><?php echo JText::_('COM_CLUBDATA_MATCH_PLACE'); ?></div>
		<div class="clubdata-match-state"><?php echo JText::_('COM_CLUBDATA_MATCH_STATE'); ?></div>
	</div>
	<?php foreach ($this->clubcancellations as $match) { ?>
	<div class="clubdata-match clubdata-match-cancelled">
		<div class="clubdata-match-date"><?php echo $match->datum ?></div>
		<div class="clubdata-match-time"><?php echo $match->aanvangstijd ?></div>
		<div class="clubdata-match-home"><?php echo $match->thuisteam ?></div>
		<div class="clubdata-match-away"><?php echo $match->uitteam ?></div>
		<div class="clubdata-match-facilities"><?php echo $match->accommodatie ?></div>
		<div class="clubdata-match-place"><?php echo $match->plaats ?></div>
		<div class="clubdata-match-state"><?php echo $match->status ?></div>
	</div>
	<?php } ?>
</div>
<?php } ?>
