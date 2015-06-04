<?php echo $this->Html->css('hot.full.min'); ?>
<?php echo $this->Html->css('bootstrap-datetimepicker.min'); ?>
<?php echo $this->Html->css('bootstrap-timepicker.min'); ?>

<?php echo $this->Html->script('hot.full.min'); ?>
<?php echo $this->Html->script('moment'); ?>
<?php echo $this->Html->script('bootstrap-datetimepicker'); ?>
<?php echo $this->Html->script('bootstrap-timepicker.min'); ?>
<?php echo $this->Html->script('attendance'); ?>

<script>
	var phpDate = '<?php echo date("Y-m-d");?>';
</script>

<div class="container-fluid">
	<div class="row-fluid">
		<div class="main-content">
			<div class="span9">
				<form class='form-horizontal' id='attendance-form'>
					<h3> 
						Attendance 
						<a href="javascript:;" id='auto-overtime' style='margin-left: 5px;' title='Auto Overtime calculation'>
							<i class="fa fa-1x <?php echo $autoOvertime; ?>"></i> 
						</a>
					</h3>
					<div class='control-group'>
						<div class='span3'>
							<input type='text' placeholder='Search Employee ID or Name' name='keyword' id='keyword'/>
						</div>
						<div class='span5'>
							<div class="input-append">
								<input type='text' placeholder='Date' name='date' id='date' class='span10'/>
								<button id='btn-search-monthly' class='btn btn-inverse' data-toggle="tooltip" title='Monthly search'><i class="fa fa-search"></i></button>
							</div>
						</div>
						
					</div>
					<div class='control-group'>
						<!--<input type='text' id='date' placeholder='Choose Date' name='date' />-->
						<div class='span3'>
							<select name='status'>
								<option selected='selected' disabled>Choose Status</option>
								<?php foreach($attendanceStat as $key => $as) { ?>
								<option value='<?php echo $key;?>'><?php echo $as; ?></option>
								<?php }?>
							</select>
						</div>
						<div class='span5'>
							<select name='shifts'>
								<option selected='selected' disabled>Choose Shifts</option>
								<?php foreach($shifts as $key => $s) { ?>
								<option value="<?php echo $s['Employeeshift']['id'];?>"><?php echo $s['Employeeshift']['description']; ?></option>
								<?php }?>
								<option value='0'>All</option>
							</select>
						</div>
					</div>
					<div class='control-group'>
						<button id='btn-search' class='btn btn-inverse'>Filter Search</button>
						<input type='reset' class='btn' id='btn-reset' value='Reset'/>
						<span class='alert alert-success'>
							<b>Allowed format : </b> HHmm, MMDDHHmm, YYYYMMDDHHmm.. <small>ex: `201505281830`</small>
						</span>
					</div>
					<div class='control-group'>
						<div id="error" class="alert alert-danger" style="display:none;"><?php echo $this->Session->flash();?></div>
					</div>
				</form>
			</div>
			<div id="calendar" class="span3">
				<?php
					echo $this->element('calendar');
				?>
			</div>
			<div class="clearfix"></div>
		</div>

		<div id="employee-attendance"></div>
	</div>
</div>
<style>
.htCore thead tr th b{
	font-size: 10px;
	position:absolute;
	top: -3px;
}
.days, .calendar-nav{
	cursor: pointer;
	transition: color .25s ease-in-out;
}
.calendar-nav:hover {
	color:#0088cc;
}

#calendar {
	table-layout: fixed;
}

#focus-day {
	border: 1px solid #0088cc!important;
}

.day-head {
	background: #222;
	color: #eee;
}
#calendar {
	font-size: 0.8rem;
}
#calendar .table {
	margin-bottom: 5px;
}
</style>

