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

$link = new JUri(JRoute::_(JUri::base().'index.php?option=com_clubdata&task=display&format=raw', false));
$badgetext = JText::_('COM_CLUBDATA_SCOPE_WEEKS_JS');
?>

<div class="clubdataclub">
	<div class="col-md-12">
        <p class="clubdata-infotext"><?php echo JText::_('COM_CLUBDATA_CLUB_DESCRIPTION'); ?></p>
        <?php 
        	echo JHtml::_('bootstrap.startTabSet', 'tabsClub', $this->tabscluboptions);
        	echo JHtml::_('bootstrap.addTab', 'tabsClub', 'tabClubScheduleHome', '<span class="glyphicon glyphicon-flag"></span>&nbsp;' . JText::_('COM_CLUBDATA_CLUB_TAB_SCHEDULE_HOME') . ' <span id="_weeksahead_home" class="clubdata-scope-weeks badge"></span>');
        ?>
        	
        <?php 
        	echo JHtml::_('bootstrap.endTab');
        	echo JHtml::_('bootstrap.addTab', 'tabsClub', 'tabClubScheduleAway', '<span class="glyphicon glyphicon-road"></span>&nbsp;' . JText::_('COM_CLUBDATA_CLUB_TAB_SCHEDULE_AWAY') . ' <span id="_weeksahead_away" class="clubdata-scope-weeks badge"></span>');
        ?>
        
        <?php 
        	echo JHtml::_('bootstrap.endTab');
        	echo JHtml::_('bootstrap.addTab', 'tabsClub', 'tabClubCancellations', '<span class="glyphicon glyphicon-warning-sign"></span>&nbsp;' . JText::_('COM_CLUBDATA_CLUB_TAB_CANCELLATIONS'));
        ?>
        
        <?php 
        	echo JHtml::_('bootstrap.endTab');
        	echo JHtml::_('bootstrap.addTab', 'tabsClub', 'tabClubResults', '<span class="glyphicon glyphicon-check"></span>&nbsp;' . JText::_('COM_CLUBDATA_CLUB_TAB_RESULTS') . ' <span id="_weeksback" class="clubdata-scope-weeks badge"></span>');
        	?>
        
        <?php 
        	echo JHtml::_('bootstrap.endTab');
        	echo JHtml::_('bootstrap.endTabSet');
        ?>
        <div id="clubloader" class="clubdata-loader-wrapper">
        	<div class="clubdata-loader"></div>
        </div>
        <form>
	        <input type="hidden" id="daysahead_home" name="daysahead_home" value="8" />
    	    <input type="hidden" id="daysahead_away" name="daysahead_away" value="8" />
    	    <input type="hidden" id="daysback" name="daysback" value="7" />
    	</form>
	</div>
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
                    var changed = false;
					switch(target) {
						case "#tabClubScheduleHome": 
                            tmp = "&view=clubschedule&homeaway=home";
                            var daysahead = $("#daysahead_home").val();
                            if (daysahead != null) {
                                if (daysahead.substr(0,1)=="*") { changed = true; daysahead = daysahead.substr(1); $("#daysahead_home").val(daysahead);} 
                                tmp = tmp + "&daysahead=" + daysahead;
                            }
                            break;
						case "#tabClubScheduleAway": 
                            tmp = "&view=clubschedule&homeaway=away";
                            var daysahead = $("#daysahead_away").val();
                            if (daysahead != null) {
                                if (daysahead.substr(0,1)=="*") { changed = true; daysahead = daysahead.substr(1); $("#daysahead_away").val(daysahead);} 
                                tmp = tmp + "&daysahead=" + daysahead;
                            }
                            break;
						case "#tabClubResults": 
                            tmp = "&view=clubresults";
                            var daysback = $("#daysback").val();
                            if (daysback != null) {
                                if (daysback.substr(0,1)=="*") { changed = true; daysback = daysback.substr(1); $("#daysback").val(daysback);} 
                                tmp = tmp + "&daysback=" + daysback;
                            }
                            break;
						case "#tabClubCancellations": 
                            tmp = "&view=clubcancellations";
                            break;
					}					
					if (!$.trim( $(target).html() ).length || changed) {  // check if element is empty
				        $.ajax(
							{url: "'. $link->toString() .'".concat(tmp), 
							type: "post",
							dataType: "html",
							async: true,
						    beforeSend: function(){
						        	$("#clubloader").show();
							    },
						    complete: function(){
						        	$("#clubloader").hide();
						    	},
							error: function (xhr, ajaxOptions, thrownError) {
						        	$(target).html("Error: " + xhr.status + ", " + thrownError);
						    	},
							success: function(result){
            						$(target).html(result);
                                    $("#daysahead_home").trigger("change");
                                    $("#daysahead_away").trigger("change");
                                    $("#daysback").trigger("change");
    								$("[data-toggle=\'popover\']").popover();
								}
							});
					}
	    	}
	    	$("#tabsClubTabs > li > a").on("shown.bs.tab", func);

            var hash = window.location.hash;
            if (hash) {
                $("#tabsClubTabs a[href=\"" + hash + "\"]").tab("show");
            }
            $("#tabsClubTabs > li.active > a").trigger("shown.bs.tab");

            $("#tabsClubTabs > li > a").click( function(e) {
                e.preventDefault();
            } );

            $("#daysahead_home").on("change", function() {
                $("#tabsClubTabs > li.active > a").trigger("shown.bs.tab");
                var days=$("#daysahead_home").val();
                days=parseInt(days.replace("*", ""));
                $("[id^=weeksahead]").text("+"+ Math.floor(days/7) + "' . $badgetext .'");
            } );

            $("#daysahead_away").on("change", function() {
                $("#tabsClubTabs > li.active > a").trigger("shown.bs.tab");
                var days=$("#daysahead_away").val();
                days=parseInt(days.replace("*", ""));
                $("[id^=weeksahead]").text("+"+ Math.floor(days/7) + "' . $badgetext .'");
            } );

            $("#daysback").on("change", function() {
                $("#tabsClubTabs > li.active > a").trigger("shown.bs.tab");
                var days=$("#daysback").val();
                days=parseInt(days.replace("*", ""));
                $("[id^=weeksback]").text("-"+ Math.floor(days/7) + "' . $badgetext .'");
            } );

            $("#daysahead_home").trigger("change");
            $("#daysahead_away").trigger("change");
            $("#daysback").trigger("change");
		});


	}) (jQuery);
');

?>
