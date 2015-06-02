
<?php
	foreach($history as $key => $val) {
		$dayCount = date('N', strtotime($val['Attendance']['date']));
		$month 	= date('M', strtotime($val['Attendance']['date']));
		$day 	= date('D', strtotime($val['Attendance']['date']));
?>
	<h5><?php echo "$month $dayCount - $day "; ?></h5>		
	<p>1st Logtime : <?php echo formatTime($val['Attendance']['f_time_in']);?> - <?php echo formatTime($val['Attendance']['f_time_out']);?></p>
	<p>2nd Logtime : <?php echo formatTime($val['Attendance']['l_time_in']);?> - <?php echo formatTime($val['Attendance']['l_time_out']);?></p>
	<p>Overtime :<?php echo $val['Attendance']['over_time'];?></p>
	<p>Rendered :<?php echo $val['Attendance']['render_time'];?></p>
	<p>Status:<?php echo $val['Attendance']['status']?></p>
		
<?php
	}

function formatTime($time) {
	return empty($time) ? '' : date('g:i A', strtotime($time));
}
?>

