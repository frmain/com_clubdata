<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_clubdata
 *
 * @copyright   Copyright (C) 2017-20 Bruse Boys
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

?>
<h3 id="clubdata-title"><?php echo JText::_('COM_CLUBDATA_RESULTS_TITLE'); ?></h3>

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
else {
	?>
	<div id="clubdata-data" class="clubdata-data">
		<div class="clubdata-clubresults"> 
			<div class="clubdata-match clubdata-header-imgrow">
				<div class="clubdata-match-home"><img class="clubdata-icon" src="<?php echo Juri::root() . 'media/com_clubdata/images/home2-icon.png'?>" alt="" /></div>
				<div class="clubdata-match-away"><img class="clubdata-icon" src="<?php echo Juri::root() . 'media/com_clubdata/images/away-icon.png'?>" alt="" /></div>
				<div class="clubdata-match-result"><img class="clubdata-icon" src="<?php echo Juri::root() . 'media/com_clubdata/images/score-icon.png'?>" alt="" /></div>
			</div>
			<div class="clubdata-match clubdata-header">
				<div class="clubdata-match-home"><?php echo JText::_('COM_CLUBDATA_MATCH_HOMETEAM'); ?></div>
				<div class="clubdata-match-away"><?php echo JText::_('COM_CLUBDATA_MATCH_AWAYTEAM'); ?></div>
				<div class="clubdata-match-result"><?php echo JText::_('COM_CLUBDATA_MATCH_RESULT'); ?></div>
 			</div>
			<?php 
			$lastdate = null;
			foreach ($this->clubresults as $match) {
				// make a header per date; list need to be sorted by date
				if ($match->datum != $lastdate) { ?>
					<div class="clubdata-match">
						<h4 class="clubdata-match-date colspan"><?php $matchdate=new JDate($match->wedstrijddatum->format('Y-m-d')); echo $matchdate->format('D j M'); ?></h4>
					</div>
				<?php 
						$lastdate = $match->datum;
				}
				?>
				<div class="clubdata-match">
					<div class="clubdata-match-home"><span><?php echo $match->thuisteam ?></span></div>
					<div class="clubdata-match-away"><span><?php echo $match->uitteam ?></span></div>
					<div class="clubdata-match-result">
					<?php if (!empty($match->uitslag)) {?>
						<span><?php echo $match->uitslag ?></span>
					<?php } else { ?>
						<span class="clubdata-match-state"><?php echo $match->status ?></span>
					<?php } ?>
					</div>
 				</div>
			<?php 
			} ?>
		</div>
	</div> 
<?php
} ?>
