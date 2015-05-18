<div class="container-fluid">
<h1>Admin side</h1>
	<div class="row-fluid">
		<div class='span3'>
			<?php echo $this->Form->create('Positions', array('class' => 'form-horizontal')); ?>
				<fieldset>
					<legend>Create Position</legend>
					<div class='control-group'>
						<?php echo $this->Form->input('pDescription', 
									array(
										'type' 			=> 	'text', 
										'placeholder' 	=> 	'Description', 
										'label' 		=> 	'Position description'
									) 
								)
						?>	
					</div>
					<div class='control-group'>
						<?php echo $this->Form->input('Create', array('label' => '', 'type'	=> 'submit', 'class' => 'btn btn-primary'))?>
					</div>
				</fieldset>
			<?php echo $this->Form->end();?>
			
		</div>
		<div class='span6'>
			<?php pr($positions); ?>
			<?php echo $this->Form->create('Position Level', array('class' => 'form-horizontal')); ?>
				<fieldset>
					<legend>Create Position Level </legend>
					<div class='control-group'>
						<?php echo $this->Form->input('position', array(
										'label' 	=> 'Choose a Position',
										'options'	=> $positions[0]
									)
								)
						?>
					</div>
					<div class='control-group'>
						<?php echo $this->Form->input('pLvlDescription', 
									array(
										'type' 			=> 'text', 
										'placeholder' 	=> 'Description', 
										'label' 		=> 'Position level description'
									) 
								)
						?>	
					</div>
					<div class='control-group'>
						<?php echo $this->Form->input('Create', array('label' => '', 'type'	=> 'submit', 'class' => 'btn btn-primary'))?>
					</div>
				</fieldset>
			<?php echo $this->Form->end();?>
			
		</div>
	</div>
</div>