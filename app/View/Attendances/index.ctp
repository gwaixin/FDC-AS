<?php 
	echo $this->Html->css('hot.full.min'); 
	echo $this->Html->css('bootstrap-datetimepicker.min');
	echo $this->Html->css('bootstrap-timepicker.min');
	echo $this->Html->script('hot.full.min');
	echo $this->Html->script('moment');
	echo $this->Html->script('bootstrap-datetimepicker');
	echo $this->Html->script('bootstrap-timepicker.min');
	echo $this->Html->script('attendance');
?>

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
						<input type='hidden' name='date' id='form-date' value=''/>
						
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
				<div class="control-group">
					<form id="form-attendance" method="post" action="/admin/attendances/downloadAttendance">
						<input type="text" name="attendance"  id="attendance-data" value="" style="display:none;" />
						<button class="btn" type="submit" id="btn-dl-attendance">Download Attendance CSV</button>
					</form>
							
				</div>
				<div class="control-group">

					<?php
						if(isset($errors)) {
							echo '<div class="alert alert-danger">';
								foreach($errors as $err) {
									echo $err .'<br/>';
								}
							echo '</div> ';
						}
						
					?>
					<?php
						echo $this->Form->create('Attendances', array('type' => 'file'));
						echo $this->Form->input('file',array( 'type' => 'file','id'=>'uploadCsv'));
						echo $this->Form->input('Upload CSV',array('type'=>'submit','class'=>'btn btn-success'));
						echo $this->Form->end();
					?>
							
				</div>
				
				
				<input type='hidden' id='calendar-day' value='<?php echo date("d", strtotime($currentDate)); ?>'/>
				<input type='hidden' id='calendar-yearmonth' value='<?php echo date("Y-m", strtotime($focus)); ?>'/>
			</div>
			<div  class="span3">
				<input type='text' id='date' value='' style='visibility:hidden; position:absolute;' value="<?php echo date('Y-m-d', strtotime($currentDate));?>"/>
				<div id="calendar">
				<?php
					echo $this->element('calendar');
				?>
				</div>
			</div>
			<div id='current-date'>
				<h4></h4>
			</div>
			<div class="clearfix"></div>
		</div>

		<div id="employee-attendance"></div>
		
	</div>
</div>


<!-- Modal -->
<div class="modal hide fade" id="modalShift" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
	    <div class="modal-content">
		    <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h1>Employee Shift Master</h1>
	       	</div>
		</div>
		<div class="modal-body"></div>
		<div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
    </div>
</div>

<style>
.htCore thead tr th b{
	font-size: 10px;
	position:absolute;
	top: -3px;
}
.days, .calendar-nav, .shift{
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
