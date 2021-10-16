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
	elseif ($this->schedulescope["home"])
	    echo JText::_('COM_CLUBDATA_SCHEDULE_NEXT_MATCHES_HOME_TITLE');
	else // $this->schedulescope["away"]) == true
	    echo JText::_('COM_CLUBDATA_SCHEDULE_NEXT_MATCHES_AWAY_TITLE');
	?> 
</h3>


<div class="slideshow-container">


    <?php
    $cnt=0;
    foreach ($this->clubschedule as $match) {
        switch ($match->getStatuscode()) {
    	      case 0:
    	          $statustext = JText::_("COM_CLUBDATA_MATCH_SCHEDULED"); break;
    	      case 1:
    	          $statustext = JText::_("COM_CLUBDATA_MATCH_CANCELLED"); break;
    	      default:
    	          $statustext = "";
    	}
    	$minutesToAdd = $match->getMatch()->duur +15; // add break time
    	$endMatch = (clone $match->wedstrijddatum)->modify("+{$minutesToAdd} minutes");
	?>
    <div class="clubdata-match-slides fade">

    	<div class="clubdata-match-s">
    		<div class="clubdata-match-s-hdr"><?php echo JText::_('COM_CLUBDATA_MATCH_STATE'); ?></div>
    		<div class="clubdata-match-s-state" data-matchdate="<?php echo $match->wedstrijddatum->format(DATE_RFC2822) ?>" 
    		 data-endmatchdate="<?php echo $endMatch->format(DATE_RFC2822) ?>" data-statuscode="<?php echo $match->getStatuscode() ?>">
    		 	<?php echo $statustext; ?>
    		</div>
    	</div>
    	<div class="clubdata-match-s <?php if ($match->getStatuscode() == 1) { echo 'clubdata-match-s-cancelled'; } ?>">
    		<div class="clubdata-match-s-home"><span><?php echo $match->thuisteam ?></span></div>
    		<div class="clubdata-match-s-sep"><?php echo JText::_('COM_CLUBDATA_TEAMSEPARATOR'); ?></div>
    		<div class="clubdata-match-s-away"><span><?php echo $match->uitteam ?></span></div>
    	</div>
    	<div class="clubdata-match-s">
    		<div class="clubdata-match-s-hdr"><?php echo JText::_('COM_CLUBDATA_MATCH_BEGIN'); ?></div>
    		<div class="clubdata-match-s-time"><span><?php echo $match->aanvangstijd ?></span></div>
    	</div>
    	<div class="clubdata-match-s">
    		<div class="clubdata-match-s-hdr"><?php echo JText::_('COM_CLUBDATA_MATCH_REFEREE'); ?></div>
    		<div class="clubdata-match-s-referee"><span><?php echo $match->scheidsrechter ?></span></div>
    	</div>
    	<div class="clubdata-match-s">
    		<div class="clubdata-match-s-hdr"><?php echo JText::_('COM_CLUBDATA_MATCH_FIELD'); ?></div>
    		<div class="clubdata-match-s-field"><span><?php $field=stripToFirstNumberOffset($match->veld); echo (!empty($field) ? JText::_('COM_CLUBDATA_MATCH_FIELD_ABBR') . $field : ''); ?></span></div>
    	</div>
    	<div class="clubdata-match-s">
    		<div class="clubdata-match-s-hdr"><?php echo JText::_('COM_CLUBDATA_MATCH_ROOM_HOME'); ?></div>
    		<div class="clubdata-match-s-dressroom"><span><?php $room=stripToFirstNumberOffset($match->kleedkamerthuisteam); echo (!empty($room) ? JText::_('COM_CLUBDATA_MATCH_ROOM_ABBR') . $room : ''); ?></span></div>
    	</div>
    	<div class="clubdata-match-s">
    		<div class="clubdata-match-s-hdr"><?php echo JText::_('COM_CLUBDATA_MATCH_ROOM_AWAY'); ?></div>
    		<div class="clubdata-match-s-dressroom"><span><?php $room=stripToFirstNumberOffset($match->kleedkameruitteam); echo (!empty($room) ? JText::_('COM_CLUBDATA_MATCH_ROOM_ABBR') . $room : ''); ?></span></div>
    	</div>
    	<div class="clubdata-match-s">
    		<div class="clubdata-match-s-hdr"><?php echo JText::_('COM_CLUBDATA_MATCH_ROOM_REFEREE'); ?></div>
    		<div class="clubdata-match-s-dressroom clubdata-match-s-referee"><span><?php $room=stripToFirstNumberOffset($match->kleedkamerscheidsrechter); echo (!empty($room) ? JText::_('COM_CLUBDATA_MATCH_ROOM_ABBR_REF') . $room : ''); ?></span></div>
    	</div>
 
    </div>
        
    <?php
        $cnt++;
    }
    ?>

</div>

<div style="text-align:center">
    <?php
    for ($i=0;$i<$cnt;$i++) {
    ?>
    <span class="dot"></span> 
    <?php
    }
    ?>
</div>

<script>
/*
var slideIndex = 0;
showSlides();

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("clubdata-match-slides");
  var dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
  //slides[slideIndex-1].animate({left:'0px', opacity: '0.4'}, "slow");
  setTimeout(showSlides, 4000); // Change image every 4 seconds
}
*/

$(document).ready(function(){
					slider();
				});
				
function slider() {
    $(".clubdata-match-slides #1").show("fade",500);
    $(".clubdata-match-slides #1").delay(2000).hide("slide",{direction:'left'},500);
    
    var sc=$(".clubdata-match-slides img").size();
    var count= 2;
    
    
    setInterval(function(){
    $(".clubdata-match-slides #"+count).show("slide",{direction:'right'},500);
    $(".clubdata-match-slides #"+count).delay(2000).hide("slide",{direction:'left'},500);
    
    if(count == sc)
     {count = 1;}
    else
     {
    count=count+1;
    }
    
    },3000);
}
</script>
