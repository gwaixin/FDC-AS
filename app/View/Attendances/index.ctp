<?php echo $this->Html->css('hot.full.min'); ?>
<?php echo $this->Html->css('bootstrap-datetimepicker.min'); ?>
<?php echo $this->Html->css('bootstrap-timepicker.min'); ?>

<?php echo $this->Html->script('hot.full.min'); ?>
<?php echo $this->Html->script('moment'); ?>
<?php echo $this->Html->script('bootstrap-datetimepicker'); ?>
<?php echo $this->Html->script('bootstrap-timepicker.min'); ?>
<?php echo $this->Html->script('attendance'); ?>

<script>var webroot = '<?php echo $this->webroot;?>';</script>

<div class="container-fluid">
	<div class="row-fluid">
		<form class='form-horizontal' id='attendance-form'>
			<h3> Attendance</h3>
			<div class='control-group'>
				<input type='text' placeholder='Search Employee ID or Name' name='keyword'/>
				<select name='status'>
					<option selected='selected' disabled>Choose Status</option>
					<?php foreach($attendanceStat as $key => $as) { ?>
					<option value='<?php echo $key;?>'><?php echo $as; ?></option>
					<?php }?>
				</select>
			</div>
			<div class='control-group'>
				<input type='text' id='date' placeholder='Choose Date' name='date' />
				<input type='text' placeholder='Start of Time in' id='time-in' name='time-in'/>
			</div>
			<div class='control-group'>
				<button id='btn-search' class='btn btn-inverse'>Search</button>
				<button id='btn-reset' class='btn'>Reset</button>
				<div id="error" class="pull-right"></div>
			</div>
		</form>
		
		<input type="text" style="visibility:hidden; position:absolute;" value="" id="datetimepicker">
		<div id="employee-attendance"></div>
	</div>
</div>


