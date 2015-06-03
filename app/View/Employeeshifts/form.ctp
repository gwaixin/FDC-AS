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
						'value'			=>  $shift['Employeeshift']['description'],
						'class'			=> 	'span11'
					) 
				);
				echo $this->Form->input('f_time_in', 
					array(
						'id'			=> 	'f_time_in',
						'type' 			=> 	'time',
						'selected' 		=> 	$shift['Employeeshift']['f_time_in'],
						'placeholder' 	=> 	'TIME', 
						'label' 		=> 	'First Time-In',
						'class'			=>	'span3',
						'between' 		=> 	'',
						'after'			=>	'',
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
						'class'			=>	'span3'
					) 
				);
				
				
				//$ltiDisable = empty($shift['Employeeshift']['l_time_in']);
				//$ltoDisable = empty($shift['Employeeshift']['l_time_out']);
				
				/*echo $this->Form->input('l_time_in', 
					array(
						'id'			=> 	'l_time_in',
						'type' 			=> 	'time', 
						'selected' 		=> 	$shift['Employeeshift']['l_time_in'],
						'placeholder' 	=> 	'TIME', 
						'label' 		=> 	'Last Time-In',
						'between' 		=> 	'<div class="control-group">',
						'disabled'		=> 	$ltiDisable,
						'after'			=>	" $timeOptional </div>",
						//'value'			=>	'',
						'class'			=>	'span3'
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
						'disabled'		=> 	$ltoDisable,
						'after'			=>	" $timeOptional </div>",
						'class'			=>	'span3'
					) 
				);*/

				$otDisable = empty($shift['Employeeshift']['overtime_start']);
				$breakDisable = empty($shift['Employeeshift']['break']);
				$editOption = '<br/><span> <a href="javascript:;" class="settime"><i class="fa fa-edit"></i></a> edit</span> &nbsp;&nbsp;';
				$resetOption = '<span> <a href="javascript:;" class="resetTime"><i class="fa fa-refresh"></i></a> reset</span>';

				echo $this->Form->input('break', 
					array(
						'id'			=> 	'break',
						'type' 			=> 	'text', 
						'placeholder' 	=> 	'00:00:00', 
						'label' 		=> 	'Break',
						'between' 		=> 	'<div class="control-group" elem="input">',
						'disabled'		=> 	$breakDisable,
						'after'			=>	" <span class='alert alert-info'><i class='icon-exclamation-sign'></i> Format should be '00:00:00'</span> $editOption</div>",
						'value'			=>	$shift['Employeeshift']['break']
					) 
				);
				echo $this->Form->input('overtime_start', 
					array(
						'id'			=> 	'overtime_start',
						'type' 			=> 	'time', 
						'selected' 		=> 	$shift['Employeeshift']['overtime_start'],
						'placeholder' 	=> 	'OVERTIME', 
						'label' 		=> 	'OVERTIME STARTS',
						'between' 		=> 	'<div class="control-group" elem="select">',
						'disabled'		=> 	$otDisable,
						'after'			=>	" $editOption $resetOption</div>",
						'class'			=>	'span3',
						'value'			=> $shift['Employeeshift']['overtime_start']

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
<style>
	.time {
		float:left;
		width:50%;
	}
	.centertext {
		margin-top: 8px;
		text-align: center;
	}
</style>