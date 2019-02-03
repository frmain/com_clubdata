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

JHtml::stylesheet('com_clubdata/clubdata.css', array(), true);

JHtml::_('bootstrap.framework');
JHtml::_('bootstrap.popover');

JHtml::script(Juri::base() . 'media/com_clubdata/js/ajax.js');

?>

<?php 
if (!empty($this->warningmessage)) { ?>
<div class="clubdata-message alert alert-warning">
	<?php echo $this->warningmessage; ?>
</div>
<?php 
} else {?>
<div class="clubdatateam">
	<div class="col-md-6">
		<div class="clubdatateamdata">
			<?php echo $this->loadTemplate('team');?>
		</div>
		<div class="clubdataranking">
			<?php echo $this->loadTemplate('ranking');?>
		</div>
		<div class="clubdataschedule">
			<?php echo $this->loadTemplate('schedule');?>
		</div>	
		<div class="clubdataresults">
			<?php echo $this->loadTemplate('results');?>
		</div>	
	</div>
	<div class="col-md-6">
		<div class="clubdataleagues">
			<?php echo $this->loadTemplate('leagues');?>
		</div>
		<div class="clubdataplayers">
			<?php echo $this->loadTemplate('players');?>
		</div>
		<div class="clubdatastaff">
			<?php echo $this->loadTemplate('staff');?>
		</div>
	</div>
</div>
<?php } ?>