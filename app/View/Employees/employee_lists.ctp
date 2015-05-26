
<?php 

	echo $this->Html->css('main');
	echo $this->Html->css('employee');
	echo $this->Html->css('hot.full.min');
	echo $this->Html->css('bootstrap-timepicker.min');
	echo $this->Html->script('hot.full.min');
	echo $this->Html->script('employee');
	echo $this->Html->script('bootstrap-timepicker');
	echo $this->Html->script('bootstrap-timepicker.min');
	echo $this->Html->script('bootbox');
?>


<style>
body {
	height: 9999px;
}
#additional-info-container {
	margin: 10px 10px;
}
#additional-info-container input {
	width: 400px;
	height: 30px;
}
#loading-BG {
	display: none;
	left: 0;
	top: 0;
	position: fixed;
	z-index: 9999;
	width: 100%;
	height: 100%;
	background: RGBA(0,0,0,0.5);
}
#loading-BG div {
	margin: 5% auto;
	width: 250px;
	background: #fff;
	border-radius: 10px;
}
div > .rowHeader:hover {
	cursor: pointer;
}
.contract:hover {
	cursor: pointer;
}
#contract-selections ul {
	list-style-type: none;
	margin: 0;
	padding: 0;
	display: inline-block;
}
#contract-selections li {
	padding: 2px 5px;
}
#contract-selections li button {
	margin: 0px auto;
	font: 10px "Trebuchet MS",sans-serif;
}
#contract-selections {
	position: fixed;
	z-index: 99;
	top: 0;
	left: 0;
	height: 80px;
	background: #f9f9f9;
	border-radius: 2px;
	display: none;
}
</style>

<script>
var baseUrl = "<?php echo $this->webroot; ?>";
</script>

<div id="loading-BG">
	<div>
	<center>
		<?php 
			echo $this->Html->image('icon-loading.gif');
		?>
	</div>
	</center>
</div>
<div id="contract-selections">
	<ul>
	<?php 
		echo "<li>";
		echo $this->Form->button('Add Contract',array(
																			'class' => 'btn btn-primary',
																			'data-toggle' => 'modal',
																			'data-target' => '#modalContract',
																			'onclick' => 'SelectContract(\'url\')'
																		)
																	);
		echo "</li>";
		echo "<li>";
		echo $this->Form->button('View Contract',array(
																			'class' => 'btn btn-primary',
																			'data-toggle' => 'modal',
																			'data-target' => '#modalContract',
																			'onclick' => 'SelectContract(\'url\')'
																		)
																	);
		echo "</li>";
		echo "<li>";
		echo $this->Form->button('View History',array(
																			'class' => 'btn btn-primary',
																			'data-toggle' => 'modal',
																			'data-target' => '#modalContract',
																			'onclick' => 'SelectContract(\'url\')'
																		)
																	);
		echo "</li>";
	?>
	</ul>
</div>



<div class="modal fade" id="modalContract" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true" style="display:none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       </div>
      <div class="modal-body" id="contract-container">
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true" style="display:none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="modal-title" id="myModalLabel"> More Information </h2>
       	<big style="color:red;" id="txt-errors"></big>
		    </div>
      <div class="modal-body">
      	<form>
			    <div class="form-group" id="additional-info-container">
						<h4 id="lbl-employee"> </h4>
				    <?php
		        		echo $this->Form->Select('Drug Test',array(
		        																	'Passed' => 'Passed',
		        																	'Failed' => 'Failed'
		        																),array(
		        																'empty' => 'Drug Test',
	        																	'name' => 'drug_test',
	        																	'id' => 'drug_test',
	        																	'disabled' => 'disabled',
	        																	'div' => false
	        																	)
	        																);
		        		echo $this->Form->input('Tin No',array(
	        																	'name' => 'tin',
	        																	'id' => 'tin',
	        																	'disabled' => 'disabled',
	        																	'placeholder' => 'Enter Tin No',
	        																	'div' => false
	        																	)
	        																);
		        		echo $this->Form->input('Salary',array(
	        																	'name' => 'salary',
	        																	'id' => 'salary',
	        																	'disabled' => 'disabled',
	        																	'placeholder' => 'Enter Salary',
	        																	'div' => false
	        																	)
	        																);
		        		echo $this->Form->input('Medical No',array(
	        																	'name' => 'medical',
	        																	'id' => 'medical',
	        																	'disabled' => 'disabled',
	        																	'placeholder' => 'Enter Medical',
	        																	'div' => false
	        																	)
	        																);
		        		echo $this->Form->input('Pagibig No',array(
	        																	'name' => 'pagibig',
	        																	'id' => 'pagibig',
	        																	'disabled' => 'disabled',
	        																	'placeholder' => 'Enter Philhealth #',
	        																	'div' => false
	        																	)
	        																);
		        		echo $this->Form->input('Philhealth No',array(
	        																	'name' => 'philhealth',
	        																	'id' => 'philhealth',
	        																	'disabled' => 'disabled',
	        																	'placeholder' => 'Enter Philhealth #',
	        																	'div' => false
	        																	)
	        																);
		        		echo $this->Form->input('Sss No',array(
	        																	'name' => 'sss',
	        																	'id' => 'sss',
	        																	'disabled' => 'disabled',
	        																	'placeholder' => 'Enter SSS #',
	        																	'div' => false
	        																	)
	        																);
		        		echo $this->Form->input('Insurance id',array(
	        																	'name' => 'insurance_id',
	        																	'id' => 'insurance_id',
	        																	'disabled' => 'disabled',
	        																	'placeholder' => 'Enter Insurance ID',
	        																	'div' => false
	        																	)
	        																);
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
		        <span class="add-on"><i class="glyphicon glyphicon-calendar"></i></span>
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
																    	'position' => 'Position',
																    	'status' => 'Status'
																    ),
																    array(
																    	'empty' => 'Search By',
																    	'id' => 'cbo-category',
																    	'class' => 'form-control'
																    	)
																    );
		echo " ";
		echo $this->Form->select('field',
																    array(
																    		1 => 'Inactive',
																    		2 => 'Active'
																    ),
																    array(
																    	'empty' => 'Status',
																    	'id' => 'cbo-status',
																    	'class' => 'form-control'
																    	)
																    );
		echo " ";
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
		echo " ";
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

	<div class="input-group-addon"> 
	<span class="add-on"><i class="glyphicon glyphicon-calendar"></i></span>
	</div>