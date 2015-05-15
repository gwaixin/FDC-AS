
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

<div id="employee-container">
	<div id="search-container" class="form-control">
		<label for="txt-search"></label>
		<select id="cbo-category" class="form-control">
			<option value="" disabled> Search By </option>
			<option value="employee_id"> Employee ID </option>
			<option value="name"> Name </option>
			<option value="position"> Position </option>
			<option value="status"> Status </option>
		</select>
		<select id="cbo-status" class="form-control">
			<option value="" disabled> Status </option>
			<option value="2"> Active </option>
			<option value="1"> Inactive </option>
		</select>
		<select id="cbo-position" class="cbo-position"></select>
		<select id="cbo-position-level"  class="cbo-position"></select>
		
		<input type="text" id="txt-search" placeholder="Search" class="form-control">
	</div>
	<div id="table-employees"></div>
</div>