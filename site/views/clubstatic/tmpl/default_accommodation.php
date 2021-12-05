<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_clubdata
 *
 * @copyright   Copyright (C) 2017 Bruse Boys
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Uri\Uri;

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

?>
<h1><?php echo JText::_('COM_CLUBDATA_CLUBSTATIC_TITLE'), JText::_('COM_CLUBDATA_ENUMERATION'), $this->club->clubnaam; ?></h1>

<div class="clubdata-clubstatic"> 
	<div class="clubdata-line">
		<div class="clubdata-logo">
			<?php if (isset($this->club->kleinlogo)) { ?>
			<img class="clubdata-club-logo" src="data:image/png;base64, <?php echo $this->club->kleinlogo; ?>" alt="<?php echo $this->club->clubnaam ?>" />
			<?php } ?>
		</div>
		<div class="clubdata-desc">
			<?php echo $this->club->informatie ?>
		</div>
	</div>


	<div class="clubdata-line">
		<div class="clubdata-static-label"><?php echo JText::_('COM_CLUBDATA_CLUBSTATIC_ADDRESS'), JText::_('COM_CLUBDATA_ENUMERATION'); ?></div>
		<div class="clubdata-static-value">
			<?php echo $this->club->straatnaam, " ", $this->club->huisnummer, " ", $this->club->nummertoevoeging, "<br/>",
			" ", $this->club->postcode, " ", $this->club->plaats ?>
		</div>
	</div>
	<div class="clubdata-line">
		<div class="clubdata-static-label"><?php echo JText::_('COM_CLUBDATA_CLUBSTATIC_VISITINGADDRESS'), JText::_('COM_CLUBDATA_ENUMERATION'); ?></div>
		<div class="clubdata-static-value">
			<?php echo $this->visitingaddress->straatnaam, " ", $this->visitingaddress->huisnummer, " ", $this->visitingaddress->nummertoevoeging, "<br/>",
			" ", $this->visitingaddress->postcode, " ", $this->visitingaddress->plaats ?>
		</div>
	</div>
	<div class="clubdata-line">
		<div class="clubdata-static-label"><?php echo JText::_('COM_CLUBDATA_CLUBSTATIC_PHONE'), JText::_('COM_CLUBDATA_ENUMERATION'); ?></div>
		<div class="clubdata-static-value">
			<?php echo $this->club->telefoonnummer ?>
		</div>
	</div>
	<div class="clubdata-line">
		<div class="clubdata-static-label"><?php echo JText::_('COM_CLUBDATA_CLUBSTATIC_EMAIL'), JText::_('COM_CLUBDATA_ENUMERATION'); ?></div>
		<div class="clubdata-static-value">
			<?php echo $this->club->email ?>
		</div>
	</div>
	<div class="clubdata-line">
		<div class="clubdata-static-label"><?php echo JText::_('COM_CLUBDATA_CLUBSTATIC_WEBSITE'), JText::_('COM_CLUBDATA_ENUMERATION'); ?></div>
		<div class="clubdata-static-value">
			<?php echo $this->club->website ?>
		</div>
	</div>
	<div class="clubdata-line">
		<div class="clubdata-static-label"><?php echo JText::_('COM_CLUBDATA_CLUBSTATIC_BANK'), JText::_('COM_CLUBDATA_ENUMERATION'); ?></div>
		<div class="clubdata-static-value">
			<?php echo $this->club->banknummer, " ", $this->club->tennamevan ?>
		</div>
	</div>
	<div class="clubdata-line">
		<div class="clubdata-static-label"><?php echo JText::_('COM_CLUBDATA_CLUBSTATIC_SECRETARY'), JText::_('COM_CLUBDATA_ENUMERATION'); ?></div>
		<div class="clubdata-static-value">
			<?php echo $this->club->naamsecretaris ?>
		</div>
	</div>
	<div class="clubdata-line">
		<div class="clubdata-static-label"><?php echo JText::_('COM_CLUBDATA_CLUBSTATIC_KVK'), JText::_('COM_CLUBDATA_ENUMERATION'); ?></div>
		<div class="clubdata-static-value">
			<?php echo $this->club->kvknummer ?>
		</div>
	</div>
	<div class="clubdata-line">
		<div class="clubdata-static-label"><?php echo JText::_('COM_CLUBDATA_CLUBSTATIC_INCORPORATION_DATE'), JText::_('COM_CLUBDATA_ENUMERATION'); ?></div>
		<div class="clubdata-static-value">
			<?php echo $this->club->oprichtingsdatetime->format('d-m-Y'); ?>
		</div>
	</div>
	<div class="clubdata-line">
		<div class="clubdata-static-label"><?php echo JText::_('COM_CLUBDATA_CLUBSTATIC_OUTFIT_HOME'), JText::_('COM_CLUBDATA_ENUMERATION'); ?></div>
		<div class="clubdata-static-value">
			<?php echo JText::_('COM_CLUBDATA_CLUBSTATIC_OUTFIT_SHIRT'), JText::_('COM_CLUBDATA_ENUMERATION'), " ", $this->club->thuisshirtkleur, "<br />", 
			JText::_('COM_CLUBDATA_CLUBSTATIC_OUTFIT_SHORT'), JText::_('COM_CLUBDATA_ENUMERATION'), " ", $this->club->thuisbroekkleur, "<br />",
			JText::_('COM_CLUBDATA_CLUBSTATIC_OUTFIT_SOCKS'), JText::_('COM_CLUBDATA_ENUMERATION'), " ", $this->club->thuissokkenkleur; ?>
		</div>
	</div>
	<div class="clubdata-line">
		<div class="clubdata-static-label"><?php echo JText::_('COM_CLUBDATA_CLUBSTATIC_OUTFIT_AWAY'), JText::_('COM_CLUBDATA_ENUMERATION'); ?></div>
		<div class="clubdata-static-value">
			<?php echo JText::_('COM_CLUBDATA_CLUBSTATIC_OUTFIT_SHIRT'), JText::_('COM_CLUBDATA_ENUMERATION'), " ", $this->club->uitshirtkleur, "<br />", 
			JText::_('COM_CLUBDATA_CLUBSTATIC_OUTFIT_SHORT'), JText::_('COM_CLUBDATA_ENUMERATION'), " ", $this->club->uitbroekkleur, "<br />",
			JText::_('COM_CLUBDATA_CLUBSTATIC_OUTFIT_SOCKS'), JText::_('COM_CLUBDATA_ENUMERATION'), " ", $this->club->uitsokkenkleur; ?>
		</div>
	</div>
	
	<?php 
	$link = 'index.php?option=com_clubdata&view=clubstatic&clubindex=';
	$ndx = 0;
	foreach ($this->clubs as $aclub) {
		$uri = new Uri($link . $ndx);
		$clubOptions[] = JHTML::_('select.option', JRoute::_($uri), $aclub->clubnaam);
		$ndx += 1;
	}

	?>
	<div class="clubdata-line">
		<div>&nbsp;</div>
		<div class="clubdata-other-club">
			<form name="clubselect" id="clubselect" method="get" action="" >
				<fieldset class="btn-toolbar">
					<div class="btn-group">
						<label class="clubdata-club-search-lbl" for="clubindex"><?php echo JText::_('COM_CLUBDATA_CLUBSTATIC_OTHER_LABEL') . '&#160;'; ?></label>
						<select id="clubindex" class="inputbox" onchange="this.form.action=this.value;this.form.submit()">
			 				<option value=""><?php echo JText::_('COM_CLUBDATA_CLUBSTATIC_SELECT_DEFAULT'); ?></option>
							<?php echo JHtml::_('select.options', $clubOptions);?>
						</select>
					</div>
				</fieldset>
			</form>
		</div>
	</div>

	
</div>