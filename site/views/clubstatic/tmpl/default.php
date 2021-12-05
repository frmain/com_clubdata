<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::stylesheet('com_clubdata/clubdata.css', array(), true);

JHtml::_('bootstrap.framework');
JHtml::_('bootstrap.popover');

?>

<?php 
if (!empty($this->warningmessage)) { ?>
<div class="clubdata-message alert alert-warning">
	<?php echo $this->warningmessage; ?>
</div>
<?php 
} else {?>
<div class="clubdataclub">
	<div class="col-md-6">
		<div class="clubdataclubstatic">
			<?php echo $this->loadTemplate('club');?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="clubdataclubteams">
			<?php echo $this->loadTemplate('teams');?>
		</div>
	</div>
</div>
<?php } ?>


