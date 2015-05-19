<div class="container-fluid">
<h1>Admin side</h1>
	<div class="row-fluid">
		<div class='span3'>
			<?php echo $this->Form->create('Position', array('class' => 'form-horizontal', 'action' => '/')); ?>
				<fieldset>
					<legend>Position Management</legend>
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
			
		</div>
		<div class='span6'>
			<?php echo $this->Form->create('Positionlevel', array('class' => 'form-horizontal', 'action' => '/')); ?>
				<fieldset>
					<legend>Create Position Level </legend>
					<div class="bg-padd bg-danger position-level-errors" style="display:none;"></div>
					<div class="bg-padd bg-danger position-level-notice" style="display:none;"></div>
					<div class='control-group'>
						<?php echo $this->Form->input('positions_id', array(
										'label' 	=> 'Choose a Position'
									)
								);
						?>
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
	</div>
</div>
<script>var webroot = '<?php echo $this->webroot;?>';</script>
<script>
	$(document).ready(function() {
		var name = '';
		
		$('.submits').click(function(e) {
			e.preventDefault();
			
			var event = $(this).val();
			var url = $(this).parents('form').attr('action') + '/' + event;
			name = $(this).attr('name');
			
			if (event != 'Delete' || confirm('Are you really really sure?')) {
				$.post(url, $(this).parents('form').serialize(), function(data) {
					
					if(data['result'] == 'fail') {
						$('.'+ name +'-errors').html(data['message']);
						$('.'+ name +'-errors').fadeIn(500);
					} else if(data['result'] == 'success') {
						$('.'+ name +'-notice').html(data['message']);
						$('.'+ name +'-notice').fadeIn(500);
						if (name == 'position') {
							reset();
						} else {
							resetPLevel();
						}
					}
					setTimeout(function() {
						$('.'+ name + '-errors').fadeOut(100);
						$('.'+ name + '-notice').fadeOut(100);
					}, 3000);
					
				}, 'JSON');
			}
		});

		//Position JS
		var currPos; //Current position
		$('#btn-search-position').click(function() {
			var position = $('#seach-position').val();
			$.post(webroot+'Positions/searchPosition', {position: position}, function(data) {
				if (data[0] == 'success') {
					$('#searched-position').html(data[1]);
					if (data[2] == 1) {
						$('#seach-position').val($('#searched-position option:selected').text());
					} else {
						$('#searched-position').slideToggle();
						$('#seach-position').val($('#searched-position option:selected').text());
					}
					$('#btn-position-submit').val('Update');
					$('#btn-position-remove').fadeIn(500);
				} else {
					alert(data[1]);
				}
			}, 'JSON');
		});

		$('#searched-position').change(function() {
			$('#seach-position').val($('#searched-position option:selected').text());
			
		});

		$('#btn-position-reset').click(function() {
			reset();
		});

		function reset() {
			$('#seach-position').val('');
			$('#btn-position-submit').val('Create');
			$('#btn-position-remove').hide();
			$('#searched-position').fadeOut(100);
			$('#searched-position').html();
		}
		
		//Position Level JS
		var posLevelList = [];
		$('#btn-search-position-level').click(function() {
			var form = $(this).parents('form');
			var url = form.attr('action') + '/search';
			$.post(url, form.serialize(), function(data) {
				if (data[0] == 'success') {
					$('#searched-position-level').html(data[1]);
					console.log(data);
					posLevelList = data[3];
					var sPosLevel = $('#searched-position-level option:selected').val();
					if (data[2] == 1) {
						$('#seach-position-level').val(posLevelList[sPosLevel][0]);
					} else {
						$('#searched-position-level').slideToggle();
						$('#seach-position-level').val(posLevelList[sPosLevel][0]);
					}
					$('#btn-position-level-submit').val('Update');
					$('#btn-position-level-remove').fadeIn(500);
					$('#PositionlevelPositionsId').prop( "disabled", true );
				} else {
					alert(data[1]);
				}
			}, 'JSON');
		});

		$('#searched-position-level').change(function() {
			var sPosLevel = $('#searched-position-level option:selected').val();
			$('#seach-position-level').val(posLevelList[sPosLevel][0]);
			$('#PositionlevelPositionsId').val(posLevelList[sPosLevel][1]);
		});

		$('#btn-position-level-reset').click(function() {
			resetPLevel();
		});

		function resetPLevel() {
			$('#PositionlevelPositionsId').prop('disabled', false );
			$('#searched-position-level').html('');
			$('#searched-position-level').fadeOut(100);
			$('#btn-position-level-submit').val('Create');
			$('#seach-position-level').val('');
			$('#btn-position-level-remove').hide();
		}

		
	});

	
</script>