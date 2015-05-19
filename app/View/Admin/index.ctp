<div class="container-fluid">
<h1>Admin side</h1>
	<div class="bg-padd bg-danger errors" style="display:none;">
	
	</div>
	<div class="row-fluid">
		<div class='span3'>
			<?php echo $this->Form->create('Position', array('class' => 'form-horizontal', 'action' => 'create')); ?>
				<fieldset>
					<legend>Create Position</legend>
					<div class='control-group'>
						<?php echo $this->Form->input('description', 
									array(
										'type' 			=> 	'text', 
										'placeholder' 	=> 	'Description', 
										'label' 		=> 	'Position description'
									) 
								)
						?>	
					</div>
					<div class='control-group'>
						<?php echo $this->Form->input('Create', array('label' => '', 'type'	=> 'submit', 'class' => 'btn btn-primary submits'))?>
					</div>
				</fieldset>
			<?php echo $this->Form->end();?>
			
		</div>
		<div class='span6'>
			<?php echo $this->Form->create('Positionlevel', array('class' => 'form-horizontal', 'action' => 'create')); ?>
				<fieldset>
					<legend>Create Position Level </legend>
					<div class='control-group'>
						<?php echo $this->Form->input('positions_id', array(
										'label' 	=> 'Choose a Position'
									)
								)
						?>
					</div>
					<div class='control-group'>
						<?php echo $this->Form->input('description', 
									array(
										'type' 			=> 'text', 
										'placeholder' 	=> 'Description', 
										'label' 		=> 'Position level description'
									) 
								)
						?>	
					</div>
					<div class='control-group'>
						<?php echo $this->Form->input('Create', 
								array(
									'label' => '',
									'type'	=> 'submit', 
									'class' => 'btn btn-primary submits',
									'id'	=> 'btn-create-posLevel'
								)
							)
						?>
					</div>
				</fieldset>
			<?php echo $this->Form->end();?>
			
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('.submits').click(function(e) {
			e.preventDefault();
			var url = $(this).parents('form').attr('action');
			$.post(url, $(this).parents('form').serialize(), function(data) {
				console.log(data);
			});
		});
	});
</script>