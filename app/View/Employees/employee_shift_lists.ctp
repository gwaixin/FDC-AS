

<table class="table table-condensed">
	<tr>
		<th> Select </th>
		<th> Description </th>
		<th> First Time in </th>
		<th> First Time out </th>
		<th> Last Time in </th>
		<th> Last Time out </th>
		<th> Overtime start </th>
	</tr>
	<?php
		foreach($lists as $list) {
			$row = $list['Employeeshift'];
			echo "<tr>
							<td>".
										$this->Form->button('Select <i class="icon-hand-up"></i>',array(
																					'class' => 'btn btn-default btn-select-shift',
																					'id' => $row['id'],
																					'value' => $row['description']
																					)
																				)
							."</td>
							<td>".$row['description']."</td>
							<td>".$row['f_time_in']."</td>
							<td>".$row['f_time_out']."</td>
							<td>".$row['l_time_in']."</td>
							<td>".$row['l_time_out']."</td>
							<td>".$row['overtime_start']."</td>
						</tr>";
		}
	?>
</table>