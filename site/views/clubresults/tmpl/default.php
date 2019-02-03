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
<h3><?php echo JText::_('COM_CLUBDATA_CLUB_TAB_RESULTS'); ?> <span id="weeksback_results" class="clubdata-scope-weeks badge"></span></h3>

<?php 
if (!empty($this->warningmessage)) { ?>
<div class="clubdata-message alert alert-warning">
	<?php echo $this->warningmessage; ?>
</div>
<?php 
} elseif (empty($this->clubresults)) { ?>
<div class="clubdata-nomatches alert alert-info">
	<?php echo JText::_('COM_CLUBDATA_CLUB_RESULTS_NO_MATCHES'); ?>
</div>
<?php 
} 
else 
{ ?>

<div id="clubdata-clubresults" class="clubdata-clubresults"> 
	<div class="clubdata-match clubdata-header">
		<div class="clubdata-match-date"><?php echo JText::_('COM_CLUBDATA_MATCH_DATE'); ?></div>
		<div class="clubdata-match-home"><?php echo JText::_('COM_CLUBDATA_MATCH_HOMETEAM'); ?></div>
		<div class="clubdata-match-away"><?php echo JText::_('COM_CLUBDATA_MATCH_AWAYTEAM'); ?></div>
		<div class="clubdata-match-result"><?php echo JText::_('COM_CLUBDATA_MATCH_RESULT'); ?></div>
	</div>
	<?php foreach ($this->clubresults as $match) { ?>
	<div class="clubdata-match">
		<div class="clubdata-match-date"><?php echo (new JDate($match->wedstrijddatum->format('Y-m-d')))->format('j M'); ?></div>
		<div class="clubdata-match-home"><?php echo $match->thuisteam ?></div>
		<div class="clubdata-match-away"><?php echo $match->uitteam ?></div>
		<?php if (!empty($match->uitslag)) {?>
		<div class="clubdata-match-result"><?php echo $match->uitslag ?></div>
		<?php } else {?>
		<div class="clubdata-match-state"><?php echo $match->status ?></div>
		<?php } ?>
	</div>
	<?php } ?>
</div>
<?php } ?>

<div class="clubdata-changescope">
	<button id="moredaysback" type="button" class="btn btn-info" onclick="
		  (function($){
			    val=$('#daysback').val().replace('*', ''); // strip changed operator '*' 
			    $('#daysback').val('*' + Math.min(parseInt(val) + 7), 365);  // max 365 days ahead
			    $('#daysback').trigger('change');
		  }) (jQuery);">
		<span class="glyphicon glyphicon-minus"></span><?php echo JText::_('COM_CLUBDATA_SCOPE_MORE'); ?>
	</button>
	<button id="lessdaysback" type="button" class="btn btn-info" onclick="
		  (function($){
			    val=$('#daysback').val().replace('*', ''); // strip changed operator '*' 
			    $('#daysback').val('*' + Math.max(parseInt(val) - 7, 7)); // minimum 7 days ahead
			    $('#daysback').trigger('change');
		  }) (jQuery);">
		<span class="glyphicon glyphicon-plus"></span><?php echo JText::_('COM_CLUBDATA_SCOPE_LESS'); ?>
	</button>
</div>	
