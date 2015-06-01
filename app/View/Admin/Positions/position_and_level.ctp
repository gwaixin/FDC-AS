<div class="container-fluid">
	<div class="row-fluid">
		<div class='main-content'>
			<h3>Position Management</h3>
			<div class='span3'>
				<?php echo $this->Form->create('Position', array('class' => 'form-horizontal', 'action' => '/')); ?>
					<fieldset>
						<legend>Creating position</legend>
						<div class="bg-padd bg-danger position-errors" style="display:none;"></div>
						<div class="bg-padd bg-danger position-notice" style="display:none;"></div>
						<div class='control-group'>
							<?php echo $this->Form->input('description', 
										array(
											'id'			=> 	'seach-position',
											'type' 			=> 	'text', 
											'placeholder' 	=> 	'Description', 
											'label' 		=> 	'Position description',
											'between'		=>	'<div class="input-append">',
											'after'			=> 	'<button class="btn" id="btn-search-position" type="button"><i class="icon-search"></i></button></div>'
										) 
									);
							?>
							<?php 
								echo $this->Form->select('id', '', array(
									'style'	=> 'display:none;',
									'id'	=> 'searched-position'	
								));
							?>
						</div>
						<div class='control-group'>
							<input type='submit' name='position' class='btn btn-primary submits' id='btn-position-submit' value='Create'/>
							<input type='submit' name='position' class='btn btn-danger submits' id='btn-position-remove' value='Delete' style='display:none;'/>
							<input type='reset' name='position' class='btn reset' id='btn-position-reset'/>	
						</div>
					</fieldset>
				<?php echo $this->Form->end();?>
				<div>
					<h4>List of position</h4>
					<div class='list-of-positions'>
					
					</div>
					<?php 
						//foreach($positions as $key => $val) {
						//	echo "<li>" . $val . "</li>"; 
						//}
					?>
				</div>
				
			</div>
			<div class='span6'>
				<?php echo $this->Form->create('Positionlevel', array('class' => 'form-horizontal', 'action' => '/')); ?>
					<fieldset>
						<legend>Creating Position Level </legend>
						<div class="bg-padd bg-danger position-level-errors" style="display:none;"></div>
						<div class="bg-padd bg-danger position-level-notice" style="display:none;"></div>
						<div class='control-group'>
							<div class='span6'>
								<?php echo $this->Form->input('positions_id', array(
												'label' 	=> 'Choose a Position'
											)
										);
								?>
							</div>
							<div class='span6'>
								<h4>Position level list</h4>
								<div class='list-of-positions-level'></div>
							</div>
						</div>
						<div class='control-group'>
							<?php 
								$after = '<button class="btn" id="btn-search-position-level" type="button"><i class="icon-search"></i></button></div>';
								echo $this->Form->input('description', 
										array(
											'id'			=> 'seach-position-level',
											'type' 			=> 'text', 
											'placeholder' 	=> 'Description', 
											'label' 		=> 'Position level description', 
											'between'		=> '<div class="input-append">',
											'after'			=> $after
										) 
									);
							?>
							<?php 
								echo $this->Form->select('id', '', array(
									'style'	=> 'display:none;',
									'id'	=> 'searched-position-level'	
								));
							?>	
						</div>
						<div class='control-group'>
							<input type='submit' name='position-level' class='btn btn-primary submits' id='btn-position-level-submit' value='Create'/>
							<input type='submit' name='position-level' class='btn btn-danger submits' id='btn-position-level-remove' value='Delete' style='display:none;'/>
							<input type='reset' name='position-level' class='btn reset' id='btn-position-level-reset'/>
						</div>
					</fieldset>
				<?php echo $this->Form->end();?>
				
			</div>
			<div class='clearfix'></div>
		</div>
	</div>
</div>
<script>var webroot = '<?php echo $this->webroot;?>';</script>
<?php echo $this->Html->script('admin'); ?>
<style>
.list-of-positions-level {
	position:absolute;
	margin-top: -5px;
}
</style>