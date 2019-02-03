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

<div class="clubdata-results">
	<div class="clubdata-crosstable clubdata-header">
		<div class="clubdata-crosstable-title">
			<span class="clubdata-crosstable-away-header"><?php echo JText::_('COM_CLUBDATA_RESULTS_AWAY')?></span>
			<span class="clubdata-crosstable-home-header"><?php echo JText::_('COM_CLUBDATA_RESULTS_HOME')?></span>
		</div>
		<?php foreach ($this->leagueteams as $team) { ?>
		<div class="clubdata-crosstable-awayteam">
			<span class="vertical"><?php echo $team->teamnaam ?></span>
		</div>
		<?php } ?>
	</div>
	<?php foreach ($this->matchescrosstable as $hometeam=>$away) {?>
	<div class="clubdata-crosstable">
		<div class="clubdata-crosstable-hometeam"><?php echo $hometeam ?></div>
		<?php foreach ($away as $awayteam=>$match) {
			if($match instanceof SportlinkClubData\LeagueMatch) {
				$displaytext = empty($match->uitslag)? $match->datumopgemaakt : $match->uitslag;
				$displaytexttype = empty($match->uitslag)? 'schedule' : 'result';
			} else {
				$displaytext = $match; // $match is just a string
				$displaytexttype = 'text';
			}?>
		<div class="clubdata-crosstable-<?php echo $displaytexttype ?>"><?php echo $displaytext ?></div>
		<?php } ?>
	</div>
	<?php } ?>
</div>
