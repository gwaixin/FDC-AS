<?php 
	echo $this->Form->create('Employee_shift', array(
			'class' 	=> 'form-horizontal',
			'action' 	=> '/create',
			'id'		=>	'eshift-form-update'
		)
	);
?>
	<fieldset>
		<div class="bg-padd bg-danger notice" style='display:none;'><?php echo $this->Session->flash();?></div>
		<div class='control-group'>
			<?php 
				echo $this->Form->input('description', 
					array(
						'id'			=> 	'description',
						'type' 			=> 	'text',
						'placeholder' 	=> 	'Description', 
						'label' 		=> 	'Shift description',
						'between' 		=> 	'<div class="control-group">',
						'after'			=>	'</div>',
						'value'			=>  $shift['Employeeshift']['description']
					) 
				);
				echo $this->Form->input('f_time_in', 
					array(
						'id'			=> 	'f_time_in',
						'type' 			=> 	'time',
						'selected' 		=> 	$shift['Employeeshift']['f_time_in'],
						'placeholder' 	=> 	'TIME', 
						'label' 		=> 	'First Time-In',
						'class'			=>	'span2',
						'between' 		=> 	'<div class="control-group">',
						'after'			=>	'</div>',
						'required'		=> true
					) 
				);
				echo $this->Form->input('f_time_out', 
					array(
						'id'			=> 	'f_time_out',
						'type' 			=> 	'time',
						'selected' 		=> 	$shift['Employeeshift']['f_time_out'],
						'placeholder' 	=> 	'TIME', 
						'label' 		=> 	'First Time-Out',
						'between' 		=> 	'<div class="control-group">',
						'after'			=>	'</div>',
						'class'			=>	'span2'
					) 
				);
				
				$timeOptional = '<span> <a href="javascript:;" class="settime" timeSet="deactivated"><i class="icon-edit"></i></span></a>';
				echo $this->Form->input('l_time_in', 
					array(
						'id'			=> 	'l_time_in',
						'type' 			=> 	'time', 
						'selected' 		=> 	$shift['Employeeshift']['l_time_in'],
						'placeholder' 	=> 	'TIME', 
						'label' 		=> 	'Last Time-In',
						'between' 		=> 	'<div class="control-group">',
						'disabled'		=> 	true,
						'after'			=>	" $timeOptional </div>",
						'value'			=>	'',
						'class'			=>	'span2'
					) 
				);
				echo $this->Form->input('l_time_out', 
					array(
						'id'			=> 	'l_time_out',
						'type' 			=> 	'time',
						'selected' 		=> 	$shift['Employeeshift']['l_time_out'],
						'placeholder' 	=> 	'TIME', 
						'label' 		=> 	'Last Time-Out',
						'between' 		=> 	'<div class="control-group">',
						'disabled'		=> 	true,
						'after'			=>	" $timeOptional </div>",
						'class'			=>	'span2'
					) 
				);
				echo $this->Form->input('overtime_start', 
					array(
						'id'			=> 	'overtime_start',
						'type' 			=> 	'time', 
						'selected' 		=> 	$shift['Employeeshift']['overtime_start'],
						'placeholder' 	=> 	'OVERTIME', 
						'label' 		=> 	'OVERTIME STARTS',
						'between' 		=> 	'<div class="control-group">',
						'disabled'		=> 	true,
						'after'			=>	" $timeOptional </div>",
						'class'			=>	'span2'
					) 
			);
			?>
		</div>
	</fieldset>
<?php echo $this->Form->end();?>
<script>
$(document).on('submit', '#eshift-form-update', function(e) {
	e.preventDefault();
});
</script>