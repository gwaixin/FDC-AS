

<table class="table table-condensed">
	<tr>
		<th> <center> Select </center> </th>
		<th> <center> Description </center> </th>
		<th> <center> First Time in </center> </th>
		<th> <center> First Time out </center> </th>
		<th> <center> Break </center> </th>
		<th> <center> Overtime start </center> </th>
	</tr>
	<?php
		foreach($lists as $list) {
			$row = $list['Employeeshift'];
			echo "<tr>
							<td><center>".
										$this->Form->button('Select',array(
																					'class' => 'btn btn-default btn-select-shift',
																					'id' => $row['id'],
																					'value' => $row['description']
																					)
																				)
							."</center></td>
							<td><center>".$row['description']."</center></td>
							<td><center>".$row['f_time_in']."</center></td>
							<td><center>".$row['f_time_out']."</center></td>
							<td><center>".$row['break']."</center></td>
							<td><center>".$row['overtime_start']."</center></td>
						</tr>";
		}
	?>
</table>