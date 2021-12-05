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
<h1><?php echo JText::_('COM_CLUBDATA_TEAM_TITLE'), JText::_('COM_CLUBDATA_ENUMERATION'), $this->team->teamnaam; ?></h1>

<div class="clubdata-teamdata"> 
	<?php if (isset($this->team->teamfoto)) { ?>
	<div class="clubdata-team-photo">
		<img class="clubdata-team-img" src="data:image/png;base64, <?php echo $this->team->teamfoto; ?>" alt="<?php echo $this->club->clubnaam, ' ', $this->team->teamnaam ?>" />
	</div>
	<?php } ?>


	<div class="clubdata-category">
		<span><?php echo JText::_('COM_CLUBDATA_TEAM_CATEGORY'), JText::_('COM_CLUBDATA_ENUMERATION'); ?></span>
		<span><?php echo $this->team->geslacht, ', ', $this->team->categorie ?></span>
	</div>
	<?php if (isset($this->team->omschrijving)) { ?>
	<div class="clubdata-description">
		<span><?php echo JText::_('COM_CLUBDATA_TEAM_DESCRIPTION'), JText::_('COM_CLUBDATA_ENUMERATION'); ?></span>
		<span><?php echo $this->team->omschrijving ?></span>
	</div>
	<?php } ?>
	
	<?php 
	$teamoptions = array();
	$teamoptions[] = JHTML::_('select.option', '', JText::_('COM_CLUBDATA_TEAM_SELECT_DEFAULT'));
	foreach ($this->teams as $team) {
		$option = JHTML::_('select.option', $team->teamcode, $team->teamnaam_full, array('option.attr' => 'optionattr'));
		$option->optionattr = array(
			'data-clubindex' => $team->clubindex
		);
		$teamoptions[] = $option;
	}

	?>
	<div class="clubdata-other-team">
		<form name="teamselect" id="teamselect" method="get" action="<?php echo JRoute::_("index.php?view=team"); ?>" >
			<fieldset class="btn-toolbar">
				<div class="btn-group">
					<input type="hidden" name="clubindex" value="">
					<label class="clubdata-team-search-lbl" for="team"><?php echo JText::_('COM_CLUBDATA_TEAM_OTHER_LABEL') . '&#160;'; ?></label>
					<select id="team" name="teamcode" class="inputbox" onchange="this.form.clubindex.value=this.options[this.selectedIndex].getAttribute('data-clubindex');this.form.submit()">
						<?php echo JHtml::_('select.options', $teamoptions, array('option.attr' => 'optionattr'));?>
					</select>
				</div>
			</fieldset>
		</form>
	</div>

	
</div>