
<table class="table">
	<thead>
		<tr>
			<td>Date</td>
			<td>Logtime</td>
			<td>Break</td>
			<td>Overtime</td>
			<td>Rendered</td>
			<td>Status</td>
		</tr>
	</thead>
	<tbody>
<?php
	foreach($history as $key => $val) {
		$dayCount = date('d', strtotime($val['Attendance']['date']));
		$month 	= date('M', strtotime($val['Attendance']['date']));
		$day 	= date('D', strtotime($val['Attendance']['date']));
?>
	<tr>
		<td><?php echo "$month $dayCount - $day "; ?></td>
		<td><?php echo formatTime($val['Attendance']['f_time_in']);?> - <?php echo formatTime($val['Attendance']['f_time_out']);?></td>
		<td><?php echo formatTime($val['Attendance']['break']); ?></td>
		<td><?php echo $val['Attendance']['over_time'];?></td>
		<td><?php echo $val['Attendance']['render_time'];?></td>
		<td><?php echo $val['Attendance']['status']?></td>
	</tr>
<?php
	}
?>
	</tbody>
</table>
<?php
function formatTime($time) {
	return empty($time) ? '' : date('g:i A', strtotime($time));
}
?>

