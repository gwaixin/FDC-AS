<table class="table table-striped">
	<thead>
		<tr>
			<th>Date</th>
			<th>Logtime</th>
			<th>Break</th>
			<th>Overtime</th>
			<th>Rendered</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
<?php
	foreach($history as $key => $val) {
		$dayCount = date('d', strtotime($val['Attendance']['date']));
		$month 	= date('M', strtotime($val['Attendance']['date']));
		$day 	= date('D', strtotime($val['Attendance']['date']));
		$stat 	= empty($val['Attendance']['status']) ? '' : $status["{$val['Attendance']['status']}"];
?>
	<tr>
		<td><?php echo "$month $dayCount - $day "; ?></td>
		<td><?php echo formatTime($val['Attendance']['f_time_in']);?> - <?php echo formatTime($val['Attendance']['f_time_out']);?></td>
		<td><?php echo formatTime($val['Attendance']['break']); ?></td>
		<td><?php echo $val['Attendance']['over_time'];?></td>
		<td><?php echo $val['Attendance']['render_time'];?></td>
		<td><?php echo ucfirst($stat); ?></td>
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

