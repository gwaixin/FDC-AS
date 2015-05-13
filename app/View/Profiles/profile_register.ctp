<div class="container">
 	<div class="row">
		<div class="profile-container">

		<h1>Profile</h1>
		<div class="img-cont">
			<div class="img-prev">
				<?php echo $this->Html->image('emptyprofile.jpg', array('alt' => 'CakePHP', 'id' => 'img_preview', 'class' => 'img-responsive')); ?>
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
		echo $this->Form->create('Profile',array('type' => 'file'));
		echo $this->Form->file('picture', array('id' => 'uploadFile','accept' => "image/*",'style' => 'display:none;'));
		echo $this->Form->button('Browse Photo', 
									array(
										'id' => 'BrowsePhoto',
										'class' => 'btn btn-success'
									)
				);
		echo $this->Form->input('text',
							array('div' => array(
									'class' => 'form-group'
								),
								 'name' => 'first_name',
								 'id' => 'txtName',
								 'class' => 'form-control',
								 'size' => 16,
								 'label' => false,
								 'after' => '',
								 'value' => $data['Profile']['first_name'],
								 'placeholder' => 'First Name'
							)
						);
		echo $this->Form->input('text',
									array('div' => array(
											'class' => 'form-group'
									),
											'name' => 'last_name',
											'id' => 'txtLastName',
											'class' => 'form-control',
											'size' => 16,
											'label' => false,
											'value' => $data['Profile']['last_name'],
											'placeholder' => 'Last Name'
									)
							);
		echo $this->Form->input('text',
										array('div' => array(
												'class' => 'form-group'
										),
												'name' => 'middle_name',
												'id' => 'txtMiddleName',
												'class' => 'form-control',
												'size' => 16,
												'label' => false,
												'value' => $data['Profile']['middle_name'],
												'placeholder' => 'Middle Name'
										)
								);
		echo $this->Form->input('date',
								array('div' => array(
										'class' => 'form-group input-group date',
										'id' => 'dp3',
										'data-date' =>'12-02-2012',
										'data-date-format'=>'yyyy-mm-dd',
									),
										'name' => 'birthdate',
										'id' => 'txtBirth',
										'class' => 'form-control',
										'size' => 16,
										'label' => false,
										'value' => $data['Profile']['birthdate'],
										'after' => ' <div class="input-group-addon"> <span class="add-on"><i class="glyphicon glyphicon-calendar"></i></span></div>',
										'placeholder' => 'Birth Date'
								)
						);
		echo $this->Form->input('number',
		    		array('div' => array(
		    				'class' => 'form-group'
		    		),
		    				'name' => 'contact',
		    				'id' => 'txtContact',
		    				'class' => 'form-control',
		    				'size' => 16,
		    				'label' => false,
		    				'value' => $data['Profile']['contact'],
		    				'placeholder' => 'Contact'
		    		)
		    );
		echo $this->Form->input('email',
		    		array('div' => array(
		    				'class' => 'form-group'
		    		),
		    				'name' => 'facebook',
		    				'id' => 'txtFacebook',
		    				'class' => 'form-control',
		    				'size' => 16,
		    				'label' => false,
		    				'value' => $data['Profile']['facebook'],
		    				'placeholder' => 'Facebook'
		    		)
		    );
		echo $this->Form->input('email',
		    		array('div' => array(
		    				'class' => 'form-group'
		    		),
		    				'name' => 'email',
		    				'id' => 'txtEmail',
		    				'class' => 'form-control',
		    				'size' => 16,
		    				'label' => false,
		    				'value' => $data['Profile']['email'],
		    				'placeholder' => 'Email'
		    		)
		    );
		echo $this->Form->input('gender',
							array(
								'div' => 'form-group',
								'type'=>'select',
								'class' => 'form-control',
								'label' => false,
							    'name' => 'gender',
								'value' => $data['Profile']['gender'],
								'options' => array(
										'M' => 'MALE',
										'F' => 'FEMALE',
								),
								'empty' => __('Gender'),
							)
				);
	    echo $this->Form->input('text',
		    		array('div' => array(
		    				'class' => 'form-group'
		    		),
		    				'name' => 'address',
		    				'id' => 'txtAddress',
		    				'class' => 'form-control',
		    				'size' => 16,
		    				'label' => false,
		    				'value' => $data['Profile']['address'],
		    				'placeholder' => 'Address'
		    		)
		    );
	   echo $this->Form->input('text',
		    		array('div' => array(
		    				'class' => 'form-group'
		    		),
		    				'name' => 'contact_person',
		    				'id' => 'txtContact',
		    				'class' => 'form-control',
		    				'size' => 16,
		    				'label' => false,
		    				'value' => $data['Profile']['contact_person'],
		    				'placeholder' => 'Contact Person'
		    		)
		    );
		echo $this->Form->input('number',
		    		array('div' => array(
		    				'class' => 'form-group'
		    		),
		    				'name' => 'contact_person_no',
		    				'id' => 'txtContactNo',
		    				'class' => 'form-control',
		    				'size' => 16,
		    				'label' => false,
		    				'value' => $data['Profile']['contact_person_no'],
		    				'placeholder' => 'Contact Person Number'
		    		)
		    );
	    echo $this->Form->input('text',
	    		array('div' => array(
	    				'class' => 'form-group'
	    		),
	    				'name' => 'signature',
	    				'id' => 'txtSignature',
	    				'class' => 'form-control',
	    				'size' => 16,
	    				'label' => false,
	    				'value' => $data['Profile']['signature'],
	    				'placeholder' => 'Signature'
	    		)
	    );
	    echo $this->Form->button('Submit', array('type' => 'submit','class' => 'btn btn-primary'));
	    echo $this->Form->end();
?>
		</div>
	</div>
</div>
