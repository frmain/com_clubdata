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

$menu = JFactory::getApplication()->getMenu();
$active = $menu->getActive();
$itemid = $active->id;

$app = JFactory::getApplication();
$teamcode=$app->input->getVar('teamcode');
$league=$app->input->getvar('league');

$link = new JUri(JRoute::_(JUri::base().'index.php?option=com_clubdata&task=leagueresults&format=raw', false));
$link = new JUri(JRoute::_(JUri::base().'index.php?option=com_clubdata&task=display&format=raw', false));
$link->setVar('teamcode', $teamcode);
$link->setVar('league', $league);
//$link->setVar('Itemid', $itemid);

?>
<h2><?php echo JText::_('COM_CLUBDATA_RESULTS_TITLE'); ?></h2>
<p class="clubdata-infotext"><?php echo JText::_('COM_CLUBDATA_RESULTS_DESCRIPTION'); ?></p>
<?php 
	echo JHtml::_('bootstrap.startTabSet', 'tabsResults', $this->tabsresultsoptions);
	echo JHtml::_('bootstrap.addTab', 'tabsResults', 'tabResultsLatest', JText::_('COM_CLUBDATA_RESULTS_TAB_LATEST'));
?>

<?php 
	echo JHtml::_('bootstrap.endTab');
	echo JHtml::_('bootstrap.addTab', 'tabsResults', 'tabResultsOwn', JText::_('COM_CLUBDATA_RESULTS_TAB_OWN'));
?>

<?php 
	echo JHtml::_('bootstrap.endTab');
	echo JHtml::_('bootstrap.addTab', 'tabsResults', 'tabResultsAll', JText::_('COM_CLUBDATA_RESULTS_TAB_ALL'));
?>

<?php 
	echo JHtml::_('bootstrap.endTab');
	echo JHtml::_('bootstrap.addTab', 'tabsResults', 'tabResultsCrosstable', JText::_('COM_CLUBDATA_RESULTS_TAB_CROSSTABLE'));
?>

<?php 
	echo JHtml::_('bootstrap.endTab');
	echo JHtml::_('bootstrap.endTabSet');
?>
<div id="resultsloader" class="clubdata-loader-wrapper">
	<div class="clubdata-loader"></div>
</div>
<?php 
$document = JFactory::getDocument();
$document->addScriptDeclaration('
	(function($){
		$(document).ready(function() {
			var func = 	function(e){
	        		var target = $(e.target).attr("href"); // activated tab
					if (!target) return false;
					var tmp = "";
					switch(target) {
						case "#tabResultsLatest": tmp = "&view=latestleagueresults";break;
						case "#tabResultsCrosstable": tmp = "&view=matchescrosstable";break;
						case "#tabResultsOwn": tmp = "&view=ownleagueresults";break;
						case "#tabResultsAll": tmp = "&view=leagueresults";break;
					}					
					if (!$.trim( $(target).html() ).length) {  // check if element is empty
				        $.ajax(
							{url: "'. $link->toString() .'".concat(tmp), 
							type: "post",
							dataType: "html",
							async: true,
						    beforeSend: function(){
						        	$("#resultsloader").show();
							    },
						    complete: function(){
						        	$("#resultsloader").hide();
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

	    	$("#tabsResultsTabs > li > a").on("shown.bs.tab", func);
			$("#tabsResultsTabs > li.active > a").trigger("shown.bs.tab");
		});
	}) (jQuery);
');

?>