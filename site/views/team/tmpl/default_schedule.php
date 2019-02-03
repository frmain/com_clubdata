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

$app = JFactory::getApplication();
$teamcode=$app->input->getVar('teamcode');
$league=$app->input->getvar('league');

$link = new JUri(JRoute::_(JUri::base().'index.php?option=com_clubdata&task=display&format=raw', false));
$link->setVar('teamcode', $teamcode);
$link->setVar('league', $league);

?>
<h2><?php echo JText::_('COM_CLUBDATA_SCHEDULE_TITLE'); ?></h2>
<p class="clubdata-infotext"><?php echo JText::_('COM_CLUBDATA_SCHEDULE_DESCRIPTION'); ?></p>
<?php 
	echo JHtml::_('bootstrap.startTabSet', 'tabsSchedule', $this->tabsscheduleoptions);
	echo JHtml::_('bootstrap.addTab', 'tabsSchedule', 'tabScheduleNext', JText::_('COM_CLUBDATA_SCHEDULE_TAB_NEXT'));
?>
	
<?php 
	echo JHtml::_('bootstrap.endTab');
	echo JHtml::_('bootstrap.addTab', 'tabsSchedule', 'tabScheduleOwn', JText::_('COM_CLUBDATA_SCHEDULE_TAB_OWN'));
?>

<?php 
	echo JHtml::_('bootstrap.endTab');
	echo JHtml::_('bootstrap.addTab', 'tabsSchedule', 'tabScheduleAll', JText::_('COM_CLUBDATA_SCHEDULE_TAB_ALL'));
?>

<?php 
	echo JHtml::_('bootstrap.endTab');
	echo JHtml::_('bootstrap.endTabSet');
?>
<div id="scheduleloader" class="clubdata-loader-wrapper">
	<div class="clubdata-loader"></div>
</div>
<?php 
$document = JFactory::getDocument();
$document->addScriptDeclaration('
	(function($){
		$(document).ready(function() {
		    $(document).ajaxStart(function(){
		    });
		    $(document).ajaxComplete(function(){
		    });
			var func = 	function(e){
	        		var target = $(e.target).attr("href"); // activated tab
					if (!target) return false;
					var tmp = "";
					switch(target) {
						case "#tabScheduleNext": tmp = "&view=nextleagueschedule";break;
						case "#tabScheduleOwn": tmp = "&view=ownleagueschedule";break;
						case "#tabScheduleAll": tmp = "&view=leagueschedule";break;
					}					
					if (!$.trim( $(target).html() ).length) {  // check if element is empty
				        $.ajax(
							{url: "'. $link->toString() .'".concat(tmp), 
							type: "post",
							dataType: "html",
							async: true,
						    beforeSend: function(){
						        	$("#scheduleloader").show();
							    },
						    complete: function(){
						        	$("#scheduleloader").hide();
						    	},
							error: function (xhr, ajaxOptions, thrownError) {
						        	$(target).html("Error: " + xhr.status + ", " + thrownError);
						    	},
							success: function(result){
            						$(target).html(result);
    								$("[data-toggle=\'popover\']").popover();
								}
							});
					}
	    	}

	    	$("#tabsScheduleTabs > li > a").on("shown.bs.tab", func);
			$("#tabsScheduleTabs > li.active > a").trigger("shown.bs.tab");
		});
	}) (jQuery);
');
?>
