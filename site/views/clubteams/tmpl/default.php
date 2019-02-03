<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<h1>Clubteams</h1>
<?php 
foreach ($this->teams as $league) {
?>
	<div>
		League: <?php echo $league->teamcode ?> - <?php echo $league->teamnaam ?> - <?php echo $league->competitienaam ?> ;
	</div>
<?php 
} 
?>
