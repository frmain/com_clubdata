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
<h3>
	<?php 
	if ($this->schedulescope["home"] == $this->schedulescope["away"])
	    echo JText::_('COM_CLUBDATA_SCHEDULE_TITLE');
	elseif ($this->schedulescope["home"])
	    echo JText::_('COM_CLUBDATA_SCHEDULE_HOME_TITLE');
	else // $this->schedulescope["away"]) == true
	    echo JText::_('COM_CLUBDATA_SCHEDULE_AWAY_TITLE');
	?> 
	<span id="weeksahead_schedule" class="clubdata-scope-weeks badge"></span>
</h3>

<?php 
if (!empty($this->warningmessage)) { ?>
<div class="clubdata-message alert alert-warning">
	<?php echo $this->warningmessage; ?>
</div>
<?php 
} elseif (empty($this->clubschedule)) { ?>
<div class="clubdata-nomatches alert alert-info">
	<?php echo JText::_('COM_CLUBDATA_CLUB_SCHEDULE_NO_MATCHES'); ?>
</div>
<?php 
} 
else 
{ ?>

<div id="clubdata-clubschedule" class="clubdata-clubschedule"> 
	<div class="clubdata-match clubdata-header">
		<div class="clubdata-match-date"><?php echo JText::_('COM_CLUBDATA_MATCH_DATE'); ?></div>
		<div class="clubdata-match-time"><?php echo JText::_('COM_CLUBDATA_MATCH_TIME'); ?></div>
		<div class="clubdata-match-home"><?php echo JText::_('COM_CLUBDATA_MATCH_HOMETEAM'); ?></div>
		<div class="clubdata-match-away"><?php echo JText::_('COM_CLUBDATA_MATCH_AWAYTEAM'); ?></div>
		<div class="clubdata-match-referee"><?php echo JText::_('COM_CLUBDATA_MATCH_REFEREE'); ?></div>
		<div class="clubdata-match-field"><?php echo JText::_('COM_CLUBDATA_MATCH_FIELD'); ?></div>
		<div class="clubdata-match-state"><?php echo JText::_('COM_CLUBDATA_MATCH_STATE'); ?></div>
	</div>
	<?php foreach ($this->clubschedule as $match) { ?>
	<div class="clubdata-match <?php if ($match->getStatuscode() == 1) { echo 'clubdata-match-cancelled'; } ?>">
		<div class="clubdata-match-date"><?php echo (new JDate($match->wedstrijddatum->format('Y-m-d')))->format('D j M'); ?></div>
		<div class="clubdata-match-time"><?php echo $match->aanvangstijd ?></div>
		<div class="clubdata-match-home"><?php echo $match->thuisteam ?></div>
		<div class="clubdata-match-away"><?php echo $match->uitteam ?></div>
		<div class="clubdata-match-referee"><?php echo $match->scheidsrechter ?></div>
		<div class="clubdata-match-field"><?php echo $match->veld ?></div>
		<div class="clubdata-match-state"><?php echo $match->status ?></div>
	</div>
	<?php } ?>

</div>
<?php 
} 
?>

<div class="clubdata-changescope">
	<button id="moredaysahead" type="button" class="btn btn-info" onclick="
		  (function($){
			    val=$('[id^=daysahead_]').val().replace('*', ''); // strip changed operator '*' 
			    $('[id^=daysahead_]').val('*' + Math.min(parseInt(val) + 7), 365);  // max 365 days ahead
			    $('[id^=daysahead_]').trigger('change');
		  }) (jQuery);">
		<span class="glyphicon glyphicon-plus"></span><?php echo JText::_('COM_CLUBDATA_SCOPE_MORE'); ?>
	</button>
	<button id="lessdaysahead" type="button" class="btn btn-info" onclick="
		  (function($){
			    val=$('[id^=daysahead_]').val().replace('*', ''); // strip changed operator '*' 
			    $('[id^=daysahead_]').val('*' + Math.max(parseInt(val) - 7, 7)); // minimum 7 days ahead
			    $('[id^=daysahead_]').trigger('change');
		  }) (jQuery);">
		<span class="glyphicon glyphicon-minus"></span><?php echo JText::_('COM_CLUBDATA_SCOPE_LESS'); ?>
	</button>
</div>	
