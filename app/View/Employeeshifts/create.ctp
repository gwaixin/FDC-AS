<?php echo $this->Form->create('Employee_shift', array('class' => 'form-horizontal', 'action' => '/create')); ?>
	<fieldset>
		<legend>Create Employee's Shifts</legend>
		<div class="bg-padd bg-danger notice" style='display:none;'><?php echo $this->Session->flash();?></div>
		<div class='control-group'>
			<?php echo $this->Form->input('description', 
						array(
							'id'			=> 	'description',
							'type' 			=> 	'text', 
							'placeholder' 	=> 	'Description', 
							'label' 		=> 	'Shift description'
						) 
					);
			?>
			<?php echo $this->Form->input('ftime_in', 
						array(
							'id'			=> 	'ftime_in',
							'type' 			=> 	'time', 
							'placeholder' 	=> 	'TIME', 
							'label' 		=> 	'First Time-In'
						) 
					);
			?>
			<?php echo $this->Form->input('ftime_out', 
						array(
							'id'			=> 	'ftime_out',
							'type' 			=> 	'time', 
							'placeholder' 	=> 	'TIME', 
							'label' 		=> 	'First Time-Out'
						) 
					);
			?>
			<?php echo $this->Form->input('ltime_in', 
						array(
							'id'			=> 	'ltime_in',
							'type' 			=> 	'time', 
							'placeholder' 	=> 	'TIME', 
							'label' 		=> 	'Last Time-In'
						) 
					);
			?>
			<?php echo $this->Form->input('ltime_out', 
						array(
							'id'			=> 	'ltime_out',
							'type' 			=> 	'time', 
							'placeholder' 	=> 	'TIME', 
							'label' 		=> 	'Last Time-Out'
						) 
					);
			?>
		</div>
		<div class='control-group'>
			<input type='submit' name='shift' class='btn btn-primary submits' id='btn-shifts-submit' value='Create'/>
			<input type='reset' name='shift' class='btn reset' id='btn-position-reset'/>	
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
	
	
	/*$('.submits').click(function(e) {
		e.preventDefault();
		var url = $(this).parents('form').attr('action');
		alert(url);
	});*/
});
</script>