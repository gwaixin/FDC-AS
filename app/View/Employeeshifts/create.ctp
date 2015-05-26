<?php echo $this->Form->create('Employee_shift', array('class' => 'form-horizontal', 'action' => '/create')); ?>
	<fieldset>
		<legend>Create Employee's Shifts</legend>
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
						'after'			=>	'</div>'
					) 
				);
				echo $this->Form->input('ftime_in', 
					array(
						'id'			=> 	'ftime_in',
						'type' 			=> 	'time', 
						'placeholder' 	=> 	'TIME', 
						'label' 		=> 	'First Time-In',
						'between' 		=> 	'<div class="control-group">',
						'after'			=>	'</div>',
						'required'		=> true
					) 
				);
				echo $this->Form->input('ftime_out', 
					array(
						'id'			=> 	'ftime_out',
						'type' 			=> 	'time', 
						'placeholder' 	=> 	'TIME', 
						'label' 		=> 	'First Time-Out',
						'between' 		=> 	'<div class="control-group">',
						'after'			=>	'</div>'
					) 
				);
				$ltimeInSetting = '<span> <a href="javascript:;" class="settime" timeType="ltime_in" timeSet="deactivated"><i class="icon-edit"></i></span></a>';
				echo $this->Form->input('ltime_in', 
					array(
						'id'			=> 	'ltime_in',
						'type' 			=> 	'time', 
						'placeholder' 	=> 	'TIME', 
						'label' 		=> 	'Last Time-In',
						'between' 		=> 	'<div class="control-group">',
						'disabled'		=> 	true,
						'after'			=>	" $ltimeInSetting </div>",
						'value'			=>	''
					) 
				);
				$ltimeOutSetting = '<span> <a href="javascript:;" class="settime" timeType="ltime_out" timeSet="deactivated"><i class="icon-edit"></i></span></a>';
				echo $this->Form->input('ltime_out', 
					array(
						'id'			=> 	'ltime_out',
						'type' 			=> 	'time', 
						'placeholder' 	=> 	'TIME', 
						'label' 		=> 	'Last Time-Out',
						'between' 		=> 	'<div class="control-group">',
						'disabled'		=> 	true,
						'after'			=>	" $ltimeOutSetting </div>"
					) 
				);
				
				echo $this->Form->input('overtime_start', 
					array(
						'id'			=> 	'ltime_out',
						'type' 			=> 	'text', 
						'placeholder' 	=> 	'OVERTIME', 
						'label' 		=> 	'OVERTIME STARTS',
						'between' 		=> 	'<div class="control-group">',
						'after'			=>	'</div>'
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

	$('.settime').click(function() {
		var type = $(this).attr('timeType');
		var setting = $(this).attr('timeSet');
		setting = setting === 'deactivated' ? 'activate' : 'deactivated';
	});
	
	/*$('.submits').click(function(e) {
		e.preventDefault();
		var url = $(this).parents('form').attr('action');
		alert(url);
	});*/
});
</script>