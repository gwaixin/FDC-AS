<?php
	if ($dtrHeader) {
?>
<table id='dtrTable' class='table table-bordered' style='white-space:nowrap;'>
	<thead>
		<tr>
			<th>Employees</th>
			<?php
				foreach($dtrHeader as $key => $val) {
			?>
			<th>
				<?php 
					$day = date('d', strtotime($key));
					$dayName = date('D', strtotime($key));
					echo "$day - $dayName"; 
				?>
			</th>
			<?php
				}
			?>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach($dtrBody as $key => $val) {
		?>
		<tr>
			<td>
				<?php echo $val['profile']['first_name'] . ' '. $val['profile']['middle_name'] . ' ' . $val['profile']['last_name'];?>
			</td>
			<?php
				foreach($val['date'] as $key => $val) {
					$fTimein = empty($val['f_time_in']) ? '' : date('g:i A', strtotime($val['f_time_in']));
					$fTimeout = empty($val['f_time_out']) ? '' : date('g:i A', strtotime($val['f_time_out']));
					$overTime = empty($val['over_time']) ? '' : date('H:i', strtotime($val['over_time']));
					$track = (empty($fTimein) && empty($fTimeout) && empty($overTime)) ? '-----' : "$fTimein - $fTimeout ($overTime)";
			?>
			<td><?php echo $track;?></td>
			<?php
				}
			?>
		</tr>
		<?php
			}
		?>
	</tbody>
</table>
<div class='well'>
	<table width='100%'>
		<tr>
			<td># of Employees: <?php echo $empCount; ?></td>
			<td>Working Hrs: <?php echo $workingHrs; ?> </td>
		</tr>
		<tr>
			<td># of Absent: <?php echo $absent; ?></td>
			<td>Total of Hours: <?php echo $totalHrs; ?></td>
		</tr>
	</table>
</div>
<?php
} else {
?>
<div class='alert alert-danger'>
	<b>Ooopppsss!!</b> No data found!!
</div>
<?php
}
?>

