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
				echo $this->Form->input('ftime_in', 
					array(
						'id'			=> 	'ftime_in',
						'type' 			=> 	'time',
						'selected' 		=> 	$shift['Employeeshift']['ftime_in'],
						'placeholder' 	=> 	'TIME', 
						'label' 		=> 	'First Time-In',
						'class'			=>	'span2',
						'between' 		=> 	'<div class="control-group">',
						'after'			=>	'</div>',
						'required'		=> true
					) 
				);
				echo $this->Form->input('ftime_out', 
					array(
						'id'			=> 	'ftime_out',
						'type' 			=> 	'time',
						'selected' 		=> 	$shift['Employeeshift']['ftime_out'],
						'placeholder' 	=> 	'TIME', 
						'label' 		=> 	'First Time-Out',
						'between' 		=> 	'<div class="control-group">',
						'after'			=>	'</div>',
						'class'			=>	'span2'
					) 
				);
				
				$timeOptional = '<span> <a href="javascript:;" class="settime" timeSet="deactivated"><i class="icon-edit"></i></span></a>';
				echo $this->Form->input('ltime_in', 
					array(
						'id'			=> 	'ltime_in',
						'type' 			=> 	'time', 
						'selected' 		=> 	$shift['Employeeshift']['ltime_in'],
						'placeholder' 	=> 	'TIME', 
						'label' 		=> 	'Last Time-In',
						'between' 		=> 	'<div class="control-group">',
						'disabled'		=> 	true,
						'after'			=>	" $timeOptional </div>",
						'value'			=>	'',
						'class'			=>	'span2'
					) 
				);
				echo $this->Form->input('ltime_out', 
					array(
						'id'			=> 	'ltime_out',
						'type' 			=> 	'time',
						'selected' 		=> 	$shift['Employeeshift']['ltime_out'],
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
						'id'			=> 	'ltime_out',
						'type' 			=> 	'time', 
						'selected' 		=> 	$shift['Employeeshift']['ltime_in'],
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
$(document).ready(function(){
	function checkNotice() {
		if ($('.notice').html().length > 0) {
			$('.notice').fadeIn(1000);
		}
	}
	
	checkNotice();

	$('.settime').click(function() {
		var type = $(this).attr('timeType');
		var setting = $(this).attr('timeSet');
		if (setting === 'deactivated') {
			$(this).parent('span').siblings('select').removeAttr('disabled');
			$(this).attr('timeSet', 'activated');
		} else {
			$(this).parent('span').siblings('select').attr('disabled', 'true');
			$(this).attr('timeSet', 'deactivated');
		} 
	});

	$('#eshift-form-update').on('submit', function(e) {
		e.preventDefault();
	});
});
</script>