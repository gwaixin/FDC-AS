
<?php 

	echo $this->Html->css('main');
	echo $this->Html->css('employee');
	echo $this->Html->css('hot.full.min');
	echo $this->Html->css('bootstrap-timepicker.min');
	echo $this->Html->script('hot.full.min');
	echo $this->Html->script('employee');
	echo $this->Html->script('bootstrap-timepicker');
	echo $this->Html->script('bootstrap-timepicker.min');

?>

<script>
var baseUrl = "<?php echo $this->webroot; ?>";
</script>

<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="modal-title" id="myModalLabel"> More Information </h2>
       </div>
      <div class="modal-body">
      	<form>
			    <div class="form-group">
						<h4 id="lbl-employee"> </h4>
		        <?php 
		        		echo $this->Form->input('Username',array(
	        																	'name' => 'username',
	        																	'id' => 'username',
	        																	'disabled' => 'disabled',
	        																	'placeholder' => 'Enter Username',
	        																	'div' => false
	        																	)
	        																);
		        		echo $this->Form->input('Password',array(
		        																'type' => 'password',
	        																	'name' => 'password',
	        																	'id' => 'password',
	        																	'disabled' => 'disabled',
	        																	'placeholder' => 'Enter Password',
	        																	'div' => false
	        																	)
	        																);
		        ?>
				  </div>
      </div>
      <div class="modal-footer">
			  <input type="button" value="Edit" class="btn btn-primary" id="btn-submit">
      </div>
    </div>
  </div>
</div>

<div id="employee-container">
	<div id="search-container" class="form-control">
	<h3> Employees </h3>
		<?php 
		echo $this->Form->select('field',
																    array(
																    	'employee_id' => 'Employee ID',
																    	'name' => 'Name',
																    	'position' => 'Position',
																    	'status' => 'Status'
																    ),
																    array(
																    	'empty' => 'Search By',
																    	'id' => 'cbo-category',
																    	'class' => 'form-control'
																    	)
																    );
		echo $this->Form->select('field',
																    array(
																    		2 => 'Inactive',
																    		1 => 'Active'
																    ),
																    array(
																    	'empty' => 'Status',
																    	'id' => 'cbo-status',
																    	'class' => 'form-control'
																    	)
																    );
		echo $this->Form->select('',null,array(
																	'empty' => 'Position',
																	'id' => 'cbo-position',
																  'class' => 'cbo-position'
																)
															);
		echo " ";
		echo $this->Form->select('',null,array(
																	'id' => 'cbo-position-level',
																  'class' => 'cbo-position'
																)
															);
		echo $this->Form->input('',array(
																	'id' => "txt-search",
																	'class' => 'txt-search',
																	'placeholder' => 'Search',
																	'class' => 'form-control',
																	'div' => false,
																	'label' => false
																)
															);
		?>		
	</div>
	<div id="table-employees"></div>
</div>


  <div class="row text-center" style="display:none;">
    <a href="#" class="btn btn-lg btn-primary" id="btn-select" data-toggle="modal" data-target="#largeModal">Click to open Modal</a>
	</div>