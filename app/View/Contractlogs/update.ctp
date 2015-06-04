<div class="container-fluid">
 	<div class="row-fluid">
		<div class="main-content">
		<input type="hidden" id="url" value="<?php echo $this->webroot;?>">
		<h3>Update Contract</h3>
		
<?php 
		if(!empty($errors)){
			echo '<div class="bg-padd bg-danger">';
			foreach ($errors as $row){
				echo '<p class="alert alert-error">'.$row[0].'</p>';
				 
			}
			echo '</div>';
		}

		echo $this->Form->create('Contractlog',array('type' => 'file', 'class' => 'form-horizontal'));

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
											'value' => $data['description'],
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
							'value' => date('Y-m-d',strtotime($data['date_start'])),
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
		    				'value' => date('Y-m-d',strtotime($data['date_end'])),
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
		    				'value' => $data['salary'],
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
		    				'value' => $data['deminise'],
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
	   				'value' => $data['term'],
	   				'placeholder' => ''
	   		)
	   );

	   echo $this->Form->input('positions_id',
						array(
							'div' => 'control-group',
							'type'=>'select',
							'class' => 'input-block-level',
							'label' => 'Position',
						    'name' => 'positions_id',
							'id' => 'contract-position',
							'value' => $data['positions_id'],
							'options' => $position,
							'empty' => __('Select'),
						)
			);
	   
	   
	   echo $this->Form->input('position_levels_id',
	   		array(
	   				'div' => 'control-group',
	   				'type'=>'select',
	   				'class' => 'input-block-level',
	   				'label' => 'Position level',
	   				'name' => 'position_levels_id',
	   				'id' => 'contract-position-level',
	   				'value' => $data['position_levels_id'],
	   				'options' => $positionlevel,
	   				'empty' => __('Select'),
	   		)
	   );

	    echo $this->Form->file('document', array('id' => 'uploadDocument','required' => false,'accept' => "application/pdf",'style' => 'display:none;'));
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
