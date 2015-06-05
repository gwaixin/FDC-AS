<div class="container-fluid">
	<div class="row-fluid">
		<div class="sm-container main-content box-center">
	         <h3 class="modal-title" id="myModalLabel">ADD COMPANY</h3>
	     	 <div class="company-content-form">
	     	 
	     	 		<?php 

	     	 		if(!empty($errors)){
	     	 			echo '<div class="bg-padd bg-danger">';
	     	 			foreach ($errors as $row){
	     	 				echo '<p class="alert alert-error">'.$row[0].'</p>';
	     	 					
	     	 			}
	     	 			echo '</div>';
	     	 		}
	     	 		
	     	 		echo $this->Form->create('Companysystem', array('class' => 'form-horizontal'));

	     	 		?>

	     	 		<div class="path-container">
	     	 			<div class="input-group-data">
	     	 			<?php  			
	     	 			echo $this->Form->input('text',
	     	 					array('div' => array(
	     	 							'class' => 'control-group'
	     	 					),
	     	 							'name' => 'name',
	     	 							'id' => 'txtName',
	     	 							'class' => 'input-block-level',
	     	 							'label' => 'Name:',
	     	 							'required' => true,
	     	 							'value' => $data['name'],
	     	 							'placeholder' => ''
	     	 					)
	     	 			);
	     	 			
						echo $this->Form->input('text',
											array('div' => array(
													'class' => 'control-group'
											),
													'name' => 'address',
													'type' => 'textarea',
													'id' => 'txtAddress',
													'class' => 'input-block-level',
													'label' => 'Address:',
													'required' => true,
													'value' => $data['address'],
													'placeholder' => ''
											)
									);
						
	     	 			?>
	     	 			</div>
	     	 		</div>
	     	 		<?php 
	     	 		
					echo $this->Form->input('text',
									array('div' => array(
											'class' => 'control-group'
									),
											'name' => 'description',
											'id' => 'txtDescription',
											'class' => 'input-block-level',
											'label' => 'Description:',
											'required' => true,
											'value' => $data['description'],
											'placeholder' => ''
									)
							);
					
					echo $this->Form->input('date',
							array('div' => array(
									'class' => 'control-group input-group date',
									'id' => '',
									'data-date' =>'12-02-2012',
									'data-date-format'=>'yyyy-mm-dd',
							),
									'name' => 'date_start',
									'id' => 'dp3',
									'class' => 'input-block-level ',
									'size' => 16,
									'label' => 'Date Start:',
									'required' => true,
									'value' => $data['date_start'],
									'after' => ' <div class="input-group-addon"> <span class="add-on"><i class="glyphicon glyphicon-calendar"></i></span></div>',
									'placeholder' => ''
							)
					);

					echo $this->Form->input('text',
							array('div' => array(
									'class' => 'control-group'
							),
									'name' => 'owner',
									'id' => 'txtOwner',
									'class' => 'input-block-level',
									'label' => 'Owner:',
									'required' => true,
									'value' => $data['owner'],
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