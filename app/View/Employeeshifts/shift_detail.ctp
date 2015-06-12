<div class="modal-body">
	<table class='table'>
			<tbody>
				<tr>
					<td> Description </td>
					<td> : </td>
					<td><?php echo $shift['Employeeshift']['description'];?></td>
				</tr>
				<tr>
					<td> First Timein </td>
					<td> : </td>
					<td><?php echo date('G:i A', strtotime($shift['Employeeshift']['f_time_in']));?></td>
				</tr>
				<tr>
					<td> First Timeout </td>
					<td> : </td>
					<td><?php echo date('G:i A', strtotime($shift['Employeeshift']['f_time_out']));?></td>
				</tr>
				<tr>
					<td> Break </td>
					<td> : </td>
					<td><?php echo date('G:i A', strtotime($shift['Employeeshift']['break']));?></td>
				</tr>
					<tr><td> Overtime Start </td>
					<td> : </td>
					<td><?php echo date('G:i A', strtotime($shift['Employeeshift']['overtime_start']));?></td>
				</tr>
		</tbody>
	</table>
</div>