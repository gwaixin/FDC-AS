<div class="container">
 	<div class="row">
		<div class="contract-container">

		<h1>Contract</h1>
		
<?php 
		if(!empty($errors)){
			echo '<div class="bg-padd bg-danger">';
			foreach ($errors as $row){
				echo '<p>'.$row[0].'</p>';
				 
			}
			echo '</div>';
		}
		echo $this->Form->create('Contractlog',array('type' => 'file', 'class' => 'form-horizontal'));

	 	echo $this->Form->input('position',
						array(
							'div' => 'control-group',
							'type'=>'select',
							'class' => 'input-block-level',
							'label' => 'Employee ID',
						    'name' => 'employees_id',
							'value' => '',
							'options' => $empId,
							'empty' => __('Select'),
						)
			);
	
		echo $this->Form->input('Description',
									array('div' => array(
											'class' => 'control-group'
									),
											'name' => 'description',
											'id' => 'txtDescription',
											'type' => 'textarea',
											'class' => 'input-block-level',
											'size' => 16,
											'label' => 'Description',
											'value' => '',
											'escape' => false,
											'placeholder' => ''
									)
							);
		echo $this->Form->input('text',
					array('div' => array(
							'class' => 'control-group'
					),
							'name' => 'date_start',
							'id' => 'dpStart',
							'class' => 'input-block-level',
							'size' => 16,
							'label' => 'Date Start',
							'value' => '',
							'placeholder' => ''
					)
			);
	
		echo $this->Form->input('number',
		    		array('div' => array(
		    				'class' => 'control-group'
		    		),
		    				'name' => 'date_end',
		    				'id' => 'dpEnd',
		    				'class' => 'input-block-level',
		    				'size' => 16,
		    				'label' => 'Date End',
		    				'value' => '',
		    				'placeholder' => ''
		    		)
		    );
	    echo $this->Form->input('numeric',
		    		array('div' => array(
		    				'class' => 'control-group'
		    		),
		    				'name' => 'salary',
		    				'id' => 'txtSalary',
		    				'class' => 'input-block-level',
		    				'size' => 16,
		    				'label' => 'Salary',
		    				'value' => '',
		    				'placeholder' => ''
		    		)
		    );
	   echo $this->Form->input('text',
		    		array('div' => array(
		    				'class' => 'control-group'
		    		),
		    				'name' => 'deminise',
		    				'id' => 'txtDeminise',
		    				'class' => 'input-block-level',
		    				'size' => 16,
		    				'label' => 'Deminise',
		    				'value' => '',
		    				'placeholder' => ''
		    		)
		    );
	   
	   echo $this->Form->input('text',
	   		array('div' => array(
	   				'class' => 'control-group'
	   		),
	   				'name' => 'term',
	   				'id' => 'txtTerm',
	   				'class' => 'input-block-level',
	   				'size' => 16,
	   				'label' => 'Term',
	   				'value' => '',
	   				'placeholder' => ''
	   		)
	   );

	   	echo $this->Form->input('position',
							array(
								'div' => 'control-group',
								'type'=>'select',
								'class' => 'input-block-level',
								'label' => 'Position',
							    'name' => 'position',
								'value' => '',
								'options' => $position,
								'empty' => __('Select'),
							)
				);

	/* 	$options = array('0'=>'Active','1'=>'Inactive');
		$attributes = array(
				'div' => 'control-group list-container',
				'type' => 'radio',
				'value' => 0,
				'class' => 'list-status', 
				'options' => $options, 
				'default' => 'Y'
		);
		echo $this->Form->input('Status',$attributes); */
	    echo $this->Form->file('document', array('id' => 'uploadDocument','required' => false,'accept' => "/*",'style' => 'display:none;'));
	    echo $this->Form->button('Browse File',
	    		array(
	    				'id' => 'BrowseFile',
	    				'class' => 'btn btn-default'
	    		)
	    );
	    echo $this->Form->button('Submit', array('type' => 'submit','class' => 'btn btn-primary'));
	    echo $this->Form->end();
?>
		</div>
	</div>
</div>
