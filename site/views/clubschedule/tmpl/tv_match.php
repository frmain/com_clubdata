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

// @todo: in params

function getFirstNumberOffset($string){
	preg_match('/^\D*(?=\d*)/', $string, $m);
	return isset($m[0]) ? strlen($m[0]) : FALSE;
}

function stripToFirstNumberOffset($string){
	$strip_acc_layout_item = true;
	if ($strip_acc_layout_item)
		return substr($string, (int)getFirstNumberOffset($string));
	else
		return $string;
}

?>
<h3 id="clubdata-title">
	<?php 
	if ($this->schedulescope["home"] == $this->schedulescope["away"])
		echo JText::_('COM_CLUBDATA_SCHEDULE_NEXT_MATCHES_TITLE');
	elseif ($this->schedulescope["home"]) {
		if (!empty($this->clubschedule)) {
			reset($this->clubschedule); 
			$matchid=key($this->clubschedule);
			echo JText::sprintf('COM_CLUBDATA_SCHEDULE_NEXT_MATCHES_HOME_ACC_TITLE', $this->clubschedule[$matchid]->accommodatie);
		}
		else 
			echo JText::sprintf('COM_CLUBDATA_SCHEDULE_NEXT_MATCHES_HOME_TITLE');
	}
	else // $this->schedulescope["away"]) == true
		echo JText::_('COM_CLUBDATA_SCHEDULE_NEXT_MATCHES_AWAY_TITLE');
	?>
</h3>


<div id="slides" class="clubdata-slideshow">

	<?php
	foreach ($this->clubschedule as $match) {
		switch ($match->getStatuscode()) {
			case 0:
				$statustext = JText::_("COM_CLUBDATA_MATCH_SCHEDULED"); break;
			case 1:
				$statustext = JText::_("COM_CLUBDATA_MATCH_CANCELLED"); break;
			default:
				$statustext = "";
		}
		$matchdetail=$match->getMatchDetail();
		$minutesToAdd = $matchdetail->duur +15; // add break time
		$endMatch = (clone $match->wedstrijddatum)->modify("+{$minutesToAdd} minutes");
		?>
	<div class="clubdata-match-slide fade">
		<div class="clubdata-match-s <?php if ($match->getStatuscode() == 1) { echo 'clubdata-match-s-cancelled'; } ?>">
			<div class="clubdata-match-s-homeaway">
				<h3 class="clubdata-match-s-home"><img class="clubdata-clublogo" src="https://logoapi.voetbal.nl/logo.php?clubcode=<?php echo $match->thuisteamclubrelatiecode?>" /><?php echo $match->thuisteam ?></h3>
				<h3><?php echo JText::_('COM_CLUBDATA_TEAMSEPARATOR'); ?></h3>
				<h3 class="clubdata-match-s-away"><?php echo $match->uitteam ?><img class="clubdata-clublogo" src="https://logoapi.voetbal.nl/logo.php?clubcode=<?php echo $match->uitteamclubrelatiecode?>" /></h3>
			</div>
		</div>
		<div class="clubdata-match-s">
			<div class="clubdata-match-s-hdr"><?php echo JText::_('COM_CLUBDATA_MATCH_DATE'); ?></div>
			<div class="clubdata-match-s-value clubdata-match-s-date <?php if ($match->getStatuscode() == 1) { echo 'clubdata-match-s-cancelled'; } ?>"><?php $matchdate=new JDate($match->wedstrijddatum->format('Y-m-d')); echo $matchdate->format('D j M'); ?></div>
		</div>
		<div class="clubdata-match-s">
			<div class="clubdata-match-s-hdr"><?php echo JText::_('COM_CLUBDATA_MATCH_BEGIN'); ?></div>
			<div class="clubdata-match-s-value clubdata-match-s-time <?php if ($match->getStatuscode() == 1) { echo 'clubdata-match-s-cancelled'; } ?>"><?php if (! empty($match->aanvangstijd)) { ?><img class="clubdata-icon-s" src="<?php echo Juri::root() . 'media/com_clubdata/images/clock-icon.png'?>" alt="" /><?php }; ?><span><?php echo $match->aanvangstijd ?></span></div>
		</div>
		<div class="clubdata-match-s">
			<div class="clubdata-match-s-hdr"><?php echo JText::_('COM_CLUBDATA_MATCH_REFEREE'); ?></div>
			<div class="clubdata-match-s-value clubdata-match-s-referee <?php if ($match->getStatuscode() == 1) { echo 'clubdata-match-s-cancelled'; } ?>"><?php if (! empty($match->getReferee())) { ?><img class="clubdata-icon-s" src="<?php echo Juri::root() . 'media/com_clubdata/images/referee-icon.png'?>" alt="" /><?php }; ?><span><?php echo ($match->getRefereePrivate()? JText::_('COM_CLUBDATA_PRIVATE'): $match->getReferee()) ?></span></div>
		</div>
		<div class="clubdata-match-s">
			<div class="clubdata-match-s-hdr"><?php echo JText::_('COM_CLUBDATA_MATCH_FIELD'); ?></div>
			<div class="clubdata-match-s-value clubdata-match-s-field <?php if ($match->getStatuscode() == 1) { echo 'clubdata-match-s-cancelled'; } ?>"><?php if (! empty($match->veld)) { ?><img class="clubdata-icon-s" src="<?php echo Juri::root() . 'media/com_clubdata/images/field-icon.png'?>" alt="" /><?php }; ?><span><?php $field=stripToFirstNumberOffset($match->veld); echo (!empty($field) ? JText::_('COM_CLUBDATA_MATCH_FIELD_ABBR') . $field : ''); ?></span></div>
		</div>
		<div class="clubdata-match-s">
			<div class="clubdata-match-s-hdr"><?php echo JText::_('COM_CLUBDATA_MATCH_ROOM_HOME'); ?></div>
			<div class="clubdata-match-s-value clubdata-match-s-dressroom <?php if ($match->getStatuscode() == 1) { echo 'clubdata-match-s-cancelled'; } ?>"><?php $room=stripToFirstNumberOffset($match->kleedkamerthuisteam); if (! empty($room)) { ?><img class="clubdata-icon-s" src="<?php echo Juri::root() . 'media/com_clubdata/images/changingrooms-home-icon.png'?>" alt="" /><?php }; ?><span><?php echo (!empty($room) ? JText::_('COM_CLUBDATA_MATCH_ROOM_ABBR') . $room : ''); ?></span></div>
		</div>
		<div class="clubdata-match-s">
			<div class="clubdata-match-s-hdr"><?php echo JText::_('COM_CLUBDATA_MATCH_ROOM_AWAY'); ?></div>
			<div class="clubdata-match-s-value clubdata-match-s-dressroom <?php if ($match->getStatuscode() == 1) { echo 'clubdata-match-s-cancelled'; } ?>"><?php $room=stripToFirstNumberOffset($match->kleedkameruitteam); if (! empty($room)) { ?><img class="clubdata-icon-s" src="<?php echo Juri::root() . 'media/com_clubdata/images/changingrooms-away-icon.png'?>" alt="" /><?php }; ?><span><?php echo (!empty($room) ? JText::_('COM_CLUBDATA_MATCH_ROOM_ABBR') . $room : ''); ?></span></div>
		</div>
		<div class="clubdata-match-s">
			<div class="clubdata-match-s-hdr"><?php echo JText::_('COM_CLUBDATA_MATCH_ROOM_REFEREE'); ?></div>
			<div class="clubdata-match-s-value clubdata-match-s-dressroom clubdata-match-s-referee <?php if ($match->getStatuscode() == 1) { echo 'clubdata-match-s-cancelled'; } ?>"><?php $room=stripToFirstNumberOffset($match->kleedkamerscheidsrechter); if (! empty($room)) { ?><img class="clubdata-icon-s" src="<?php echo Juri::root() . 'media/com_clubdata/images/changingrooms-referee-icon.png'?>" alt="" /><?php }; ?><span><?php echo (!empty($room) ? JText::_('COM_CLUBDATA_MATCH_ROOM_ABBR_REF') . $room : ''); ?></span></div>
		</div>
		<div class="clubdata-match-s">
			<div class="clubdata-match-s-hdr"><?php echo JText::_('COM_CLUBDATA_MATCH_STATE'); ?></div>
			<div class="clubdata-match-s-value clubdata-match-s-state" data-matchdate="<?php echo $match->wedstrijddatum->format(DATE_RFC2822) ?>" 
			 data-endmatchdate="<?php echo $endMatch->format(DATE_RFC2822) ?>" data-statuscode="<?php echo $match->getStatuscode() ?>"  data-statustext-timer="<?php echo JText::_('COM_CLUBDATA_SCHEDULE_JS_STATUS_START_TIMER') ?>" data-statustext-playing="<?php echo JText::_('COM_CLUBDATA_SCHEDULE_JS_STATUS_MATCH_PLAYING') ?>" data-statustext-end="<?php echo JText::_('COM_CLUBDATA_SCHEDULE_JS_STATUS_MATCH_END') ?>" >
			 	<?php echo $statustext; ?>
			</div>
		</div>
	</div>
		
	<?php
	}
	?>

</div>

<div id="dots" class="dots" style="text-align:center">
	<?php
	for ($i=0;$i<count($this->clubschedule);$i++) {
	?>
	<span class="dot"></span> 
	<?php
	}
	?>
</div>

<script type="text/javascript">

var slideshow = $("#slides .clubdata-match-slide");
var dots = $("#dots .dot");
var hometeam = $(".clubdata-match-s-home");
var awayteam = $(".clubdata-match-s-away");

var slideIndex = 0;
var timerID;
var slidetime=4000; // default 4 seconds

function showMatchSlides() {
	var i
	if (slideshow.length > 0) {
		for (i = 0; i < slideshow.length; i++) {
			slideshow[i].style.display = "none";	
		}
		slideIndex++;
		if (slideIndex > slideshow.length) {slideIndex = 1}
		for (i = 0; i < dots.length; i++) {
			dots[i].className = dots[i].className.replace(" active", "");
		}
		slideshow[slideIndex-1].style.display = "block";
		dots[slideIndex-1].className += " active";
	
	    hometeam.addClass('slide-fromleft');
	    awayteam.addClass('slide-fromright');
		
		var slide=slideshow[slideIndex-1];
	
		timerID=setTimeout(showMatchSlides, slidetime); 
	}
}

function setMatchSlideTime(milliseconds) {
	slidetime=milliseconds;
}

function resetMatchSlides() {
	clearTimeout(timerID);
	slideIndex = 0;
	showMatchSlides();
}

function stopMatchSlides() {
	clearTimeout(timerID);
	slideIndex = 0;
}

function getMatchSlideCount() {
	return slideshow.length;
}
</script>

