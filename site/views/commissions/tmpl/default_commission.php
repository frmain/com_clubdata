<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_clubdata
 *
 * @copyright   Copyright (C) 2018 Bruse Boys
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

?>

	<h2><?php echo /* JText::_('COM_CLUBDATA_COMMISSION_TITLE'), JText::_('COM_CLUBDATA_ENUMERATION'), */ $this->commission->commissienaam; ?></h2>
	<div class="clubdata-description">
		<span><?php echo JText::_('COM_CLUBDATA_COMMISSION_DESCRIPTION'), JText::_('COM_CLUBDATA_ENUMERATION'); ?></span>
		<span><?php echo $this->commission->omschrijving ?></span>
	</div>
	<?php if (isset($this->commission->foto)) { ?>
	<div class="clubdata-commission-photo">
		<img class="clubdata-commission-img" src="data:image/png;base64, <?php echo $this->commission->foto; ?>" alt="<?php echo $this->commission->commissienaam ?>" />
	</div>
	<?php } ?>

	<?php if (isset($this->commission->opmerkingen)) { ?>
	<div class="clubdata-comment">
		<span><?php echo JText::_('COM_CLUBDATA_COMMISSION_REMARKS'), JText::_('COM_CLUBDATA_ENUMERATION'); ?></span>
		<span><?php echo $this->commission->opmerkingen ?></span>
	</div>
	<?php } ?>
	<?php if (isset($this->commission->email)) { ?>
	<div class="clubdata-email">
		<span><?php echo JText::_('COM_CLUBDATA_COMMISSION_EMAIL'), JText::_('COM_CLUBDATA_ENUMERATION'); ?></span>
		<span><a href="mailto:<?php echo $this->commission->email ?>?subject=<?php echo JText::sprintf('COM_CLUBDATA_COMMISSION_SUBJECT', $this->commission->commissienaam); ?>">
		<?php echo $this->commission->email ?></a></span>
	</div>
	<?php } ?>
	
	<div class="clubdata-commission-members">

		<?php if (count($this->members[$this->commission->commissiecode]) != 0) { ?>
		<h3 class="clubdata-commission-members"><?php echo JText::_('COM_CLUBDATA_COMMISSION_MEMBERS_TITLE'); ?></h3>
 		<?php } ?>
 		<!-- NO HEADER 
    	<div class="clubdata-member clubdata-header">
    		<div class="clubdata-member-photo"><?php echo JText::_('COM_CLUBDATA_MEMBERS_PHOTO'); ?></div>
    		<div class="clubdata-member-name"><?php echo JText::_('COM_CLUBDATA_MEMBERS_NAME'); ?></div>
    		<div class="clubdata-member-role"><?php echo JText::_('COM_CLUBDATA_MEMBERS_ROLE'); ?></div>
    	</div>
    	 -->
    	<?php 
    	$count_private = 0;
    	foreach ($this->members[$this->commission->commissiecode] as $member) { 
    	    if ($member->private)
    	        $count_private++;
    	    else {
    	?>
    
    	<div class="clubdata-member">
    		<div class="clubdata-member-cola">
        		<div class="clubdata-member-photo">
        		<?php if(!empty($member->foto)) {?>
        			<img class="clubdata-member-img hasPopover" src="data:image/png;base64,<?php echo $member->foto ?>" alt="<?php echo JText::_('COM_CLUBDATA_MEMBERS_PHOTO');?>" 
        				data-toggle="popover"
        				data-trigger="hover"
        				data-html="true"
        				data-placement="top" 
        				title="<?php echo $member->lid; ?>" 
        				data-content="<img class='clubdata-member-img-popover' src='data:image/png;base64,<?php echo $member->foto; ?>' />"
        			/>
        		<?php } else {?>
        			<img class="clubdata-member-img hasPopover" src="<?php echo Juri::root() . 'media/com_clubdata/images/anonymous.jpg'?>" alt="<?php echo JText::_('COM_CLUBDATA_MEMBERS_PHOTO_UNKNOWN');?>"
        				data-toggle="popover"
        				data-trigger="hover"
        				data-html="true"
        				data-placement="top" 
        				title="<?php echo JText::_('COM_CLUBDATA_MEMBERS_PHOTO_UNKNOWN'); ?>" 
        			 />
        		<?php } ?>
				</div>
    		</div>
    		<div class="clubdata-member-colb">
        		<div class="clubdata-member-name"><?php echo $member->lid ?></div>
        		<div class="clubdata-member-role"><?php echo $member->rol ?></div>
        		<div class="clubdata-member-description"><?php echo $member->informatie ?></div>
        		<div class="clubdata-member-since"><?php echo JText::_('COM_CLUBDATA_MEMBERS_SINCE'), $member->startdatum ?></div>
        	</div>
    	</div>
			<?php } ?>
		<?php } ?>
	</div>
    <?php if ($count_private) {?>
    <div class="clubdata-footer">
    	<div class="clubdata-member-name"><?php echo JText::plural('COM_CLUBDATA_MEMBERS_PRIVATE', $count_private); ?></div>
    </div>
    <?php }?>		

