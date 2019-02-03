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
<h2><?php echo JText::_('COM_CLUBDATA_RANKING_TITLE'); ?></h2>

<?php 
	$showtabs = count($this->periodsranking);
	if ($showtabs) { 
		echo JHtml::_('bootstrap.startTabSet', 'tabsRanking', $this->tabsrankingoptions);
		echo JHtml::_('bootstrap.addTab', 'tabsRanking', 'tabRankingDefault', JText::_('COM_CLUBDATA_RANKING_TAB_MAIN'));
	}
?>
    	
<div class="clubdata-ranking"> 
	<div class="clubdata-rank clubdata-header">
		<div class="clubdata-ranking-position"><?php echo JText::_('COM_CLUBDATA_RANKING_POSITION'); ?></div>
		<div class="clubdata-ranking-team"><?php echo JText::_('COM_CLUBDATA_RANKING_TEAM'); ?></div>
		<div class="clubdata-ranking-total"><?php echo JText::_('COM_CLUBDATA_RANKING_MATCHES_TOTAL'); ?></div>
		<div class="clubdata-ranking-won"><?php echo JText::_('COM_CLUBDATA_RANKING_MATCHES_WON'); ?></div>
		<div class="clubdata-ranking-drawn"><?php echo JText::_('COM_CLUBDATA_RANKING_MATCHES_DRAWN'); ?></div>
		<div class="clubdata-ranking-lost"><?php echo JText::_('COM_CLUBDATA_RANKING_MATCHES_LOST'); ?></div>
		<div class="clubdata-ranking-points"><?php echo JText::_('COM_CLUBDATA_RANKING_MATCHES_POINTS'); ?></div>
		<div class="clubdata-ranking-score"><?php echo JText::_('COM_CLUBDATA_RANKING_MATCHES_SCORE'); ?></div>
		<div class="clubdata-ranking-goalsdiff"><?php echo JText::_('COM_CLUBDATA_RANKING_MATCHES_GOALSDIFF'); ?></div>
	</div>
<?php foreach ($this->leagueranking as $position) { ?>
	<div class="clubdata-rank <?php if ($position->eigenteam) {echo ' clubdata-favourite';}?>">
		<div class="clubdata-ranking-position"><?php echo $position->positie ?></div>
		<div class="clubdata-ranking-team"><?php echo $position->teamnaam ?></div>
		<div class="clubdata-ranking-total"><?php echo $position->gespeeldewedstrijden ?></div>
		<div class="clubdata-ranking-won"><?php echo $position->gewonnen ?></div>
		<div class="clubdata-ranking-drawn"><?php echo $position->gelijk ?></div>
		<div class="clubdata-ranking-lost"><?php echo $position->verloren ?></div>
		<div class="clubdata-ranking-points"><?php echo $position->punten ?></div>
		<div class="clubdata-ranking-score"><?php echo $position->doelpuntenvoor, JText::_('COM_CLUBDATA_SCORESEPARATOR'), $position->doelpuntentegen ?></div>
		<div class="clubdata-ranking-goalsdiff"><?php echo $position->doelsaldo ?></div>
		<?php if ($position->verliespunten != 0) { ?>
		<div class="clubdata-ranking-points-deducted"><?php echo $position->verliespunten ?></div>
		<?php } ?>
	</div>
<?php } ?>
</div>
<?php 
	if ($showtabs) { 
		echo JHtml::_('bootstrap.endTab');
	}
?>
    	
<?php foreach ($this->periodsranking as $period=>$ranking) {
	echo JHtml::_('bootstrap.addTab', 'tabsRanking', 'tabRanking'.trim($period), JText::sprintf('COM_CLUBDATA_RANKING_TAB_PERIOD', $period));
?>
<div class="clubdata-ranking"> 
	<div class="clubdata-rank clubdata-header">
		<div class="clubdata-ranking-position"><?php echo JText::_('COM_CLUBDATA_RANKING_POSITION'); ?></div>
		<div class="clubdata-ranking-team"><?php echo JText::_('COM_CLUBDATA_RANKING_TEAM'); ?></div>
		<div class="clubdata-ranking-total"><?php echo JText::_('COM_CLUBDATA_RANKING_MATCHES_TOTAL'); ?></div>
		<div class="clubdata-ranking-won"><?php echo JText::_('COM_CLUBDATA_RANKING_MATCHES_WON'); ?></div>
		<div class="clubdata-ranking-drawn"><?php echo JText::_('COM_CLUBDATA_RANKING_MATCHES_DRAWN'); ?></div>
		<div class="clubdata-ranking-lost"><?php echo JText::_('COM_CLUBDATA_RANKING_MATCHES_LOST'); ?></div>
		<div class="clubdata-ranking-points"><?php echo JText::_('COM_CLUBDATA_RANKING_MATCHES_POINTS'); ?></div>
		<div class="clubdata-ranking-score"><?php echo JText::_('COM_CLUBDATA_RANKING_MATCHES_SCORE'); ?></div>
		<div class="clubdata-ranking-goalsdiff"><?php echo JText::_('COM_CLUBDATA_RANKING_MATCHES_GOALSDIFF'); ?></div>
	</div>
	<?php foreach ($ranking as $position) {	?>
	<div class="clubdata-rank <?php if ($position->eigenteam) {echo ' clubdata-favourite';}?>">
		<div class="clubdata-ranking-position"><?php echo $position->positie ?></div>
		<div class="clubdata-ranking-team"><?php echo $position->teamnaam ?></div>
		<div class="clubdata-ranking-total"><?php echo $position->aantalwedstrijden ?></div>
		<div class="clubdata-ranking-won"><?php echo $position->gewonnen ?></div>
		<div class="clubdata-ranking-drawn"><?php echo $position->gelijkspel ?></div>
		<div class="clubdata-ranking-lost"><?php echo $position->verloren ?></div>
		<div class="clubdata-ranking-points"><?php echo $position->totaalpunten ?></div>
		<div class="clubdata-ranking-score"><?php echo $position->doelpuntenvoor, JText::_('COM_CLUBDATA_SCORESEPARATOR'), $position->tegendoelpunten ?></div>
		<div class="clubdata-ranking-goalsdiff"><?php echo $position->doelsaldo ?></div>
		<?php if ($position->verliespunten != 0) { ?>
		<div class="clubdata-ranking-points-deducted"><?php echo $position->verliespunten ?></div>
		<?php } ?>
	</div>
	<?php } ?>
</div>
	<?php echo JHtml::_('bootstrap.endTab');?>
<?php } ?>

<?php 
	if ($showtabs) { 
		echo JHtml::_('bootstrap.endTabSet');
	}
?>