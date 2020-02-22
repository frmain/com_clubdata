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
		echo JText::_('COM_CLUBDATA_SCHEDULE_TITLE');
	elseif ($this->schedulescope["home"])
		echo JText::_('COM_CLUBDATA_SCHEDULE_HOME_TITLE');
	else // $this->schedulescope["away"]) == true
		echo JText::_('COM_CLUBDATA_SCHEDULE_AWAY_TITLE');
	?> 
</h3>

<?php 
if (!empty($this->warningmessage)) { ?>
<div class="clubdata-message alert alert-warning">
	<?php echo $this->warningmessage; ?>
</div>
<?php 
} elseif (empty($this->clubschedule)) { ?>
<div class="clubdata-nomatches alert alert-info">
	<?php echo JText::_('COM_CLUBDATA_CLUB_SCHEDULE_NO_MATCHES'); ?>
</div>
<?php 
} 
else {
	?>
	<div id="clubdata-data" class="clubdata-data">
		<div class="clubdata-clubschedule"> 
			<div class="clubdata-match clubdata-header-imgrow">
				<div class="clubdata-match-time"><img class="clubdata-icon" src="<?php echo Juri::root() . 'media/com_clubdata/images/clock-icon.png'?>" alt="" /></div>
				<div class="clubdata-match-home"><img class="clubdata-icon" src="<?php echo Juri::root() . 'media/com_clubdata/images/home2-icon.png'?>" alt="" /></div>
				<div class="clubdata-match-dressroom clubdata-match-home"><img class="clubdata-icon" src="<?php echo Juri::root() . 'media/com_clubdata/images/changingrooms-home-icon.png'?>" alt="" /></div>
				<div class="clubdata-match-away"><img class="clubdata-icon" src="<?php echo Juri::root() . 'media/com_clubdata/images/away-icon.png'?>" alt="" /></div>
				<div class="clubdata-match-dressroom clubdata-match-away"><img class="clubdata-icon" src="<?php echo Juri::root() . 'media/com_clubdata/images/changingrooms-away-icon.png'?>" alt="" /></div>
				<div class="clubdata-match-field"><img class="clubdata-icon" src="<?php echo Juri::root() . 'media/com_clubdata/images/field-icon.png'?>" alt="" /></div>
				<div class="clubdata-match-referee"><img class="clubdata-icon" src="<?php echo Juri::root() . 'media/com_clubdata/images/referee-icon.png'?>" alt="" /></div>
				<div class="clubdata-match-dressroom clubdata-match-referee"><img class="clubdata-icon" src="<?php echo Juri::root() . 'media/com_clubdata/images/changingrooms-referee-icon.png'?>" alt="" /></div>
<!--
				<div class="clubdata-match-state"><img class="clubdata-icon" src="<?php echo Juri::root() . 'media/com_clubdata/images/state-icon.png'?>" alt="" /></div>
 -->
			</div>
			<div class="clubdata-match clubdata-header">
				<div class="clubdata-match-time"><?php echo JText::_('COM_CLUBDATA_MATCH_TIME'); ?></div>
				<div class="clubdata-match-home"><?php echo JText::_('COM_CLUBDATA_MATCH_HOMETEAM'); ?></div>
				<div class="clubdata-match-dressroom clubdata-match-home"><?php echo JText::_('COM_CLUBDATA_MATCH_ROOM_HOME_ABBR'); ?></div>
				<div class="clubdata-match-away"><?php echo JText::_('COM_CLUBDATA_MATCH_AWAYTEAM'); ?></div>
				<div class="clubdata-match-dressroom clubdata-match-away"><?php echo JText::_('COM_CLUBDATA_MATCH_ROOM_AWAY_ABBR'); ?></div>
				<div class="clubdata-match-field"><?php echo JText::_('COM_CLUBDATA_MATCH_FIELD'); ?></div>
				<div class="clubdata-match-referee"><?php echo JText::_('COM_CLUBDATA_MATCH_REFEREE'); ?></div>
				<div class="clubdata-match-dressroom clubdata-match-referee"><?php echo JText::_('COM_CLUBDATA_MATCH_ROOM_REF_ABBR'); ?></div>
<!--
				<div class="clubdata-match-state"><?php echo JText::_('COM_CLUBDATA_MATCH_START'); ?></div>
 -->
 			</div>
			<?php 
			$lastdate = null;
			foreach ($this->clubschedule as $match) {
				// make a header per date; list need to be sorted by date
				if ($match->datum != $lastdate) { ?>
					<div class="clubdata-match">
						<h4 class="clubdata-match-date colspan"><?php $matchdate=new JDate($match->wedstrijddatum->format('Y-m-d')); echo $matchdate->format('D j M'); ?></h4>
					</div>
				<?php 
						$lastdate = $match->datum;
				}
/*				$interval = $match->wedstrijddatum->diff(new DateTime());
				if ($interval->d < 1) 
					// $statustext =  $interval->format(JText::_("COM_CLUBDATA_MATCH_START_IN"));
				else {
*/
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
				<div class="clubdata-match <?php if ($match->getStatuscode() == 1) { echo 'clubdata-match-cancelled'; } ?>">
					<div class="clubdata-match-time"><span><?php echo $match->aanvangstijd ?></span></div>
					<div class="clubdata-match-home"><span><?php echo $match->thuisteam ?></span></div>
					<div class="clubdata-match-dressroom"><span><?php $room=stripToFirstNumberOffset($match->kleedkamerthuisteam); echo (!empty($room) ? JText::_('COM_CLUBDATA_MATCH_ROOM_ABBR') . $room : ''); ?></span></div>
					<div class="clubdata-match-away"><span><?php echo $match->uitteam ?></span></div>
					<div class="clubdata-match-dressroom"><span><?php $room=stripToFirstNumberOffset($match->kleedkameruitteam); echo (!empty($room) ? JText::_('COM_CLUBDATA_MATCH_ROOM_ABBR') . $room : ''); ?></span></div>
					<div class="clubdata-match-field"><span><?php $field=stripToFirstNumberOffset($match->veld); echo (!empty($field) ? JText::_('COM_CLUBDATA_MATCH_FIELD_ABBR') . $field : ''); ?></span></div>
					<div class="clubdata-match-referee"><span <?php if ($match->getRefereePrivate()) echo "class=clubdata-private" ?>><?php echo ($match->getRefereePrivate()? JText::_('COM_CLUBDATA_PRIVATE'): $match->getReferee()) ?></span></div>
					<div class="clubdata-match-dressroom clubdata-match-dressroom-referee"><span><?php $room=stripToFirstNumberOffset($match->kleedkamerscheidsrechter); echo (!empty($room) ? JText::_('COM_CLUBDATA_MATCH_ROOM_ABBR_REF') . $room : ''); ?></span></div>
<!-- 
					<div class="clubdata-match-state" data-matchdate="<?php echo $match->wedstrijddatum->format(DATE_RFC2822) ?>" 
						data-endmatchdate="<?php echo $endMatch->format(DATE_RFC2822) ?>" data-statuscode="<?php echo $match->getStatuscode() ?>">
						<?php echo $statustext; ?>
					</div>
 -->
 				</div>
				<?php 
				} ?>
			</div>
		</div> 
		<?php
} ?>
