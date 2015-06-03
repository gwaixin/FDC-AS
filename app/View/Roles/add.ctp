<div class="container-fluid">
	<div class="row-fluid">
		<div class="sm-container main-content box-center">
	         <h3 class="modal-title" id="myModalLabel">Roles</h3>
	         <input type="hidden" id="url" value="/">
	     	 <div class="roles-content-form">
	     	 
	     	 		<?php 

	     	 		if (!empty($errors)) {
	     	 			echo '<div class="bg-padd bg-danger">';
	     	 			foreach ($errors as $row){
	     	 				echo '<p class="alert alert-error">'.$row[0].'</p>';
	     	 					
	     	 			}
	     	 			echo '</div>';
	     	 		}
	     	 		
	     	 		echo $this->Form->create('roles',array('class' => 'form-horizontal'));
	     	 		
					echo $this->Form->input('text',
									array('div' => array(
											'class' => 'control-group'
									),
											'name' => 'description',
											'id' => 'txtDescription',
											'class' => 'input-block-level',
											'label' => false,
											'value' => '',
											'placeholder' => ''
									)
							);
						     	 		
					echo $this->Form->button('Submit', array('type' => 'submit','class' => 'btn btn-primary'));
	     	 		echo $this->Form->end();
	     	 		?>
	     	 </div>
		</div>
	</div>
</div>