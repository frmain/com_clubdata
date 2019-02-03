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

JHtml::stylesheet('com_clubdata/clubdata.css', array(), true);

$document = JFactory::getDocument();
$document->addScriptDeclaration('
    jQuery(function($){ $(document).ready(
        function() {
            var colors = ["#c0dbe2", "#ccb9da", "#cdf1c3", "#fdfd96", "#5d9b9b", "#ff6961", "#77dd77", "#aec6cf", "#d3d3d3", "#dea5a4", "#ffb6c1", "#ff7514"];
            $(".clubdata-commission").each(
              function() {
                $(this).css("background-color", colors[Math.floor(Math.random() * colors.length)]);
              }
            );
        }
    )});
');


?>

<div class="clubdatacommissions">
	<div class="col-md-12">
		<h1><?php echo JText::_('COM_CLUBDATA_COMMISSIONS_TITLE'); ?></h1>
        <?php 
        if (!empty($this->warningmessage)) { ?>
        <div class="clubdata-message alert alert-warning">
        	<?php echo $this->warningmessage; ?>
        </div>
        <?php 
        } else {
        ?>
		<p class="clubdata-infotext"><?php echo JText::_('COM_CLUBDATA_COMMISSIONS_DESCRIPTION'); ?></p>
    	<?php 
    	// 2-column-layout
    	$cols=2;
    	$cnt = 0;
    	foreach ($this->commissions as $commission) { 
    	    $cnt++;
    	    if ($cnt % $cols == 1) { echo '<div class="clubdata-commission-row">'; }	?>
            		<div class="clubdata-commission">
            			<?php 
            			 $this->commission = &$commission;
            			 echo $this->loadTemplate('commission');
            			?>
            		</div>
			<?php
			if ($cnt % $cols == 0) { echo "</div>"; }	
    	} 
		if ($cnt % $cols == 1) { echo "</div>"; }
    	}?>
	</div>
</div>
