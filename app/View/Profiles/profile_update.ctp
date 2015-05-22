<div class="container">
 	<div class="row">
		<div class="profile-container">

		<h1>Update Profile</h1>
		<div class="img-cont">
			<div class="img-prev">
				<img src="<?php echo $data['Profile']['picture']; ?>" alt="CakePHP" id="img_preview" class="img-responsive">
			</div>
		</div>
		
<?php 
		if(!empty($errors)){
			echo '<div class="bg-padd bg-danger">';
			foreach ($errors as $row){
				echo '<p>'.$row[0].'</p>';
				 
			}
			echo '</div>';
		}
		echo $this->Form->create('Profile',array('type' => 'file', 'class' => 'form-horizontal'));
		echo $this->Form->file('picture', array('id' => 'uploadFile','required' => false,'accept' => "image/*",'style' => 'display:none;','value'=>$data['Profile']['picture']));
		echo $this->Form->button('Browse Photo', 
									array(
										'id' => 'BrowsePhoto',
										'class' => 'btn btn-success control-group'
									)
				);
		echo $this->Form->input('text',
							array('div' => array(
									'class' => 'control-group'
								),
								 'name' => 'first_name',
								 'id' => 'txtName',
								 'class' => 'input-block-level',
								 'size' => 16,
								 'label' => 'First Name',
								 'after' => '',
								 'value' => $data['Profile']['first_name'],
								 'placeholder' => ''
							)
						);
		echo $this->Form->input('text',
									array('div' => array(
											'class' => 'control-group'
									),
											'name' => 'last_name',
											'id' => 'txtLastName',
											'class' => 'input-block-level',
											'size' => 16,
											'label' => 'Last Name',
											'value' => $data['Profile']['last_name'],
											'placeholder' => ''
									)
							);
		echo $this->Form->input('text',
										array('div' => array(
												'class' => 'control-group'
										),
												'name' => 'middle_name',
												'id' => 'txtMiddleName',
												'class' => 'input-block-level',
												'size' => 16,
												'label' => 'Middle Name',
												'value' => $data['Profile']['middle_name'],
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
										'name' => 'birthdate',
										'id' => 'dp3',
										'class' => 'input-block-level',
										'size' => 16,
										'value' => date("Y-m-d", strtotime($data['Profile']['birthdate'])),
										'label' => 'Birth Date',
										'after' => ' <div class="input-group-addon"> <span class="add-on"><i class="glyphicon glyphicon-calendar"></i></span></div>',
										'placeholder' => ''
								)
						);
		echo $this->Form->input('number',
		    		array('div' => array(
		    				'class' => 'control-group'
		    		),
		    				'name' => 'contact',
		    				'id' => 'txtContact',
		    				'class' => 'input-block-level',
		    				'size' => 16,
		    				'label' => 'Contact',
		    				'value' => $data['Profile']['contact'],
		    				'placeholder' => ''
		    		)
		    );
		echo $this->Form->input('email',
		    		array('div' => array(
		    				'class' => 'control-group'
		    		),
		    				'name' => 'facebook',
		    				'id' => 'txtFacebook',
		    				'class' => 'input-block-level',
		    				'size' => 16,
		    				'label' => 'Facebook',
		    				'value' => $data['Profile']['facebook'],
		    				'placeholder' => ''
		    		)
		    );
		echo $this->Form->input('email',
		    		array('div' => array(
		    				'class' => 'control-group'
		    		),
		    				'name' => 'email',
		    				'id' => 'txtEmail',
		    				'class' => 'input-block-level',
		    				'size' => 16,
		    				'label' => 'Email',
		    				'value' => $data['Profile']['email'],
		    				'placeholder' => ''
		    		)
		    );
		echo $this->Form->input('gender',
							array(
								'div' => 'control-group',
								'type'=>'select',
								'class' => 'input-block-level',
								'label' => 'Gender',
							    'name' => 'gender',
								'options' => array(
										'M' => 'MALE',
										'F' => 'FEMALE',
								),
								'value' => $data['Profile']['gender'],
								'empty' => __('Select'),
							)
				);
	    echo $this->Form->input('Address',
		    		array('div' => array(
		    				'class' => 'control-group'
		    		),
		    				'name' => 'address',
		    				'id' => 'txtAddress',
		    				'class' => 'input-block-level',
		    				'size' => 16,
		    				'type' => 'textarea',
		    				'label' => 'Address',
		    				'value' => $data['Profile']['address'],
		    				'placeholder' => ''
		    		)
		    );
	   echo $this->Form->input('text',
		    		array('div' => array(
		    				'class' => 'control-group'
		    		),
		    				'name' => 'contact_person',
		    				'id' => 'txtContact',
		    				'class' => 'input-block-level',
		    				'size' => 16,
		    				'label' => 'Contact Person',
		    				'value' => $data['Profile']['contact_person'],
		    				'placeholder' => ''
		    		)
		    );
		echo $this->Form->input('number',
		    		array('div' => array(
		    				'class' => 'control-group'
		    		),
		    				'name' => 'contact_person_no',
		    				'id' => 'txtContactNo',
		    				'class' => 'input-block-level',
		    				'size' => 16,
		    				'label' => 'Contact Person Number',
		    				'value' => $data['Profile']['contact_person_no'],
		    				'placeholder' => ''
		    		)
		    );
	    echo $this->Form->file('signature', array('id' => 'uploadSignature','required' => false,'accept' => "image/*",'style' => 'display:none;'));
	    echo $this->Form->button('Browse Signature',
	    		array(
	    				'id' => 'BrowseSignature',
	    				'class' => 'btn btn-default'
	    		)
	    );
	    echo $this->Form->button('Submit', array('type' => 'submit','class' => 'btn btn-primary'));
	    echo $this->Form->end();
?>
		</div>
	</div>
</div>
