<div class="container">
 	<div class="row">
		<div class="profile-container">

		<h3>Profile</h3>
		<div class="img-cont">
			<div class="img-prev">
				<?php echo $this->Html->image('emptyprofile.jpg', array('alt' => 'CakePHP', 'id' => 'img_preview', 'class' => 'img-responsive')); ?>
			</div>
		</div>
		
<?php 
		if(!empty($errors)){
			echo '<div class="bg-padd bg-danger">';
			foreach ($errors as $row){
				echo '<p class="alert alert-error">'.$row[0].'</p>';
				 
			}
			echo '</div>';
		}
		echo $this->Form->create('Profile',array('type' => 'file', 'class' => 'form-horizontal'));
		echo $this->Form->file('picture', array('id' => 'uploadFile','required' => false,'accept' => "image/*",'style' => 'display:none;'));
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
								 'label' => 'First name',
								 'after' => '',
								 'required' => true,
								 'value' => $data['first_name'],
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
											'required' => true,
											'value' => $data['last_name'],
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
												'label' => 'Middel Name',
												'required' => true,
												'value' => $data['middle_name'],
												'placeholder' => ''
										)
								);
		echo $this->Form->input('text',
				array('div' => array(
						'class' => 'control-group'
				),
						'name' => 'nick_name',
						'id' => 'txtnick_name',
						'class' => 'input-block-level',
						'size' => 16,
						'label' => 'Nickname',
						'required' => true,
						'value' => $data['nick_name'],
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
										'required' => true,
										'class' => 'input-block-level ',
										'size' => 16,
										'label' => 'Birth date',
										'value' => $data['birthdate'],
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
		    				'required' => true,
		    				'value' => $data['contact'],
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
		    				'required' => true,
		    				'value' => $data['facebook'],
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
		    				'required' => true,
		    				'value' => $data['email'],
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
								'required' => true,
								'value' => $data['gender'],
								'options' => array(
										'M' => 'MALE',
										'F' => 'FEMALE',
								),
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
		    				'required' => true,
		    				'value' => $data['address'],
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
		    				'required' => true,
		    				'label' => 'Contact Person',
		    				'value' => $data['contact_person'],
		    				'placeholder' => ''
		    		)
		    );
		echo $this->Form->input('number',
		    		array('div' => array(
		    				'class' => 'control-group list-container'
		    		),
		    				'name' => 'contact_person_no',
		    				'id' => 'txtContactNo',
		    				'class' => 'input-block-level',
		    				'size' => 16,
		    				'required' => true,
		    				'label' => 'Contact Person Number',
		    				'value' => $data['contact_person_no'],
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
