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
			foreach($shifts as $key => $val) {
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
<script>
	$(document).ready(function() {
		var row;
		var sid;
		$('.shift-btn-delete').click(function() {
			if (confirm("Are you sure you want to Delete this shift???")) {
				row = $(this).parent().parent();
				sid = row.attr('sid');
				$.post(webroot+'Employeeshifts/delete', {id:sid}, function(data) {
					if (data == 'success') {
						row.fadeOut(300);
					}
				});
			} 
		});

		$('.shift-btn-edit').click(function() {
			row = $(this).parent().parent();
			sid = row.attr('sid');
			$.post(webroot+'Employeeshifts/edit', {id:sid}, function(data) {
				$('#employee-shift-modal .modal-body').html(data);
				$('#employee-shift-modal').modal('show');
			});
		});

		$('.shift-btn-update').click(function() {
			$.post(webroot+'Employeeshifts/update/'+sid, $('#eshift-form-update').serialize(), function(data) {
				if(data['result'] == 'success') {
					$('#employee-shift-modal').modal('hide');
					console.log(data);
					//data['changes'].forEach(updatingList);
					for(var item in data['changes']) {
						row.find('.' + item).html(data['changes'][item]);
						console.log(data['changes'][item]);
					}
					/*row.find('.shift-id').html();
					row.find('.shift-desc').html();
					row.find('.shift-ftimein').html();
					row.find('.shift-ftimeout').html();
					row.find('.shift-ltimein').html();
					row.find('.shift-ltimeout').html();
					row.find('.shift-overtime').html();
					row.find('.shift-status').html();*/
				} else if (data['result'] == 'fail') {
					$('#modal-error p').html(data['error']);
					$('#modal-error').fadeIn(300, function() {
						setTimeout(function() {
							$('#modal-error').fadeOut(300);
						}, 1000);
					});
				}
			}, 'JSON');
		});

		function updatingList(element, index, array) {
			//console.log('a[' + index + '] = ' + element);
			row.find('.' + index).html(element);
		}
	});
</script>

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

