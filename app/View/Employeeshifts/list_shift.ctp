<h4>List of Shifts</h4>
<table class="table">
	<thead>
		<tr>
			<th>id</th>
			<th>description</th>
			<th>ftime_in</th>
			<th>ftime_out</th>
			<th>ltime_in</th>
			<th>ltime_out</th>
			<th>overtime_start</th>
			<th>status</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach($data as $key => $val) {
			$ftimeIn  = empty($val['Employeeshift']['ftime_in']) ? '' 	: date('g:i A', strtotime($val['Employeeshift']['ftime_in']));
			$ftimeOut = empty($val['Employeeshift']['ftime_out']) ? '' 	: date('g:i A', strtotime($val['Employeeshift']['ftime_out']));
			$ltimeIn  =	empty($val['Employeeshift']['ltime_in']) ? '' 	: date('g:i A', strtotime($val['Employeeshift']['ltime_in']));
			$ltimeOut =	empty($val['Employeeshift']['ltime_out']) ? '' 	: date('g:i A', strtotime($val['Employeeshift']['ltime_out']));
			$overtime =	empty($val['Employeeshift']['overtime_start']) ? '' : date('g:i A', strtotime($val['Employeeshift']['overtime_start']));
		?>
		<tr class="shift-row" sid="<?php echo $val['Employeeshift']['id']; ?>">
			<td class="shift-id"><?php echo $val['Employeeshift']['id'];?></td>
			<td class="description"><?php echo $val['Employeeshift']['description'];?></td>
			<td class="ftime_in"><?php echo $ftimeIn;?></td>
			<td class="ftime_out"><?php echo $ftimeOut;?></td>
			<td class="ltime_in"><?php echo $ltimeIn;?></td>
			<td class="ltime_out"><?php echo $ltimeOut;?></td>
			<td class="overtime"><?php echo $overtime;?></td>
			<td class="status"><?php echo $val['Employeeshift']['status'];?></td>
			<td>
				<button class="btn btn-danger shift-btn-delete">Delete</button>
				<button class="btn btn-success shift-btn-edit">Edit</button>
			</td>
		</tr>
		<?php
			}
		?>
	</tbody>
</table>
<div class='row'>
<?php
	echo $this->Paginator->numbers(array(
		'modulus' 	=> 2,   /* Controls the number of page links to display */
		'first' 	=> '<<',
		'separator' => '',
		'last' 		=> '>>',
		'tag'		=> 'li',
		'currentClass' 	=> 'active',
		'currentTag' 	=> 'span',
		'before' 		=> "<div class='pagination'><ul>", 'after' => '</ul></div>')
	);
?>
</div>

<div id="employee-shift-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
  	<div class='alert alert-danger' id='modal-error' style='display:none;'>
    	<h4 class='alert-heading'>Ooopsss</h4>
    	<p></p>
    </div>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Edit Shift Schedule</h3>
  </div>
  <div class="modal-body">
    <p>One fine body…</p>
  </div>
  <div class="modal-footer">
    <a href="javascript:;" data-dismiss="modal" aria-hidden="true" class="btn">Close</a>
    <a href="javascript:;" class="btn btn-primary shift-btn-update">Save changes</a>
  </div>
</div>

<?php echo $this->Html->script('admin/shift'); ?>
