<?php echo $this->Html->css('hot.full.min'); ?>
<?php echo $this->Html->css('bootstrap-datetimepicker.min'); ?>
<?php echo $this->Html->css('bootstrap-timepicker.min'); ?>

<?php echo $this->Html->script('hot.full.min'); ?>
<?php echo $this->Html->script('moment'); ?>
<?php echo $this->Html->script('bootstrap-datetimepicker'); ?>
<?php echo $this->Html->script('bootstrap-timepicker.min'); ?>
<?php echo $this->Html->script('attendance'); ?>

<script>
	var webroot = '<?php echo $this->webroot;?>';
	var phpDate = '<?php echo date("Y-m-d");?>';
</script>

<div class="container-fluid">
	<div class="row-fluid">
		<span class='pull-right' style='text-align:center;'>
			<small>Auto Overtime</small> <br/>
			<a href="javascript:;" id='auto-overtime'><i class="fa fa-2x <?php echo $autoOvertime; ?>"></i></a>
		</span>

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
			</div>
			<div class='control-group'>
				<button id='btn-search' class='btn btn-inverse'>Search</button>
				<button id='btn-reset' class='btn'>Reset</button>
				<div id="error" class="pull-right"><?php echo $this->Session->flash();?></div>
				<span class='alert alert-success'>
					<b>Allowed format : </b> HHmm, MMDDHHmm, YYYYMMDDHHmm.. <small>ex: `201505281830`</small>
				</span>
			</div>
		</form>
		
		<input type="text" style="position:absolute; visibility:hidden" id="datepicker">
		<div id="employee-attendance"></div>
	</div>
</div>

<style>
.htCore thead tr th b{
	font-size: 10px;
	position:absolute;
	top: -3px;
}
</style>

