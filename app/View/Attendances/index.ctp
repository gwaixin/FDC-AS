

<link href="<?php echo $this->webroot;?>css/hotMain.css" rel="stylesheet">
<link href="<?php echo $this->webroot;?>css/hot.full.min.css" rel="stylesheet">
<link href="<?php echo $this->webroot;?>css/jquery.timepicker.css" rel="stylesheet"/>

<script src="<?php echo $this->webroot;?>js/hot.full.min.js"></script>
<script src="<?php echo $this->webroot;?>js/jquery.timepicker.min.js"></script>
<script>
var selected_row = null;
var list = [];
var hot;
var focusElem;
var rowIndex;
$(document).ready(function () {

	var htTextarea;
	
	var colClass;

	
	
	$(document).on('click', '#employee-attendance td', function(e) {
		colClass = $(this).attr('class').split(' ')[0];
		htTextarea = $("#employee-attendance textarea");
		rowIndex = $(this).closest('tr').index();
		if (
			colClass == 'f_time_in' 	|| 
			colClass == 'f_time_out' 	||
			colClass == 'l_time_in'	||
			colClass == 'l_time_out'
		) {
			focusElem = $(this);
<<<<<<< HEAD
			htTextarea.select();
			htTextarea.timepicker({ 'timeFormat': 'H:i:s' });
			htTextarea.on('changeTime', function() {
			    $('#onselectTarget').text($(this).val());
=======
			console.log(htTextarea.val());
			htTextarea.timepicker({
                minuteStep: 1,
                disableFocus: true
			});
			
			htTextarea.timepicker().on('changeTime.timepicker', function(e) {
				currentTime = e.time.value;
			});
			htTextarea.timepicker().on('hide.timepicker', function(e) {
				hot.setDataAtRowProp(rowIndex, colClass, e.time.value);
>>>>>>> 050ff347c7aee211ef4c1520b03f11934875a191
			});
			
		} else {
			//if (htTextarea.hasClass('ui-timepicker-input')) {
				htTextarea.timepicker().remove();
			//}
		}
		
		
	});
	
	$(document).on('click', '.ui-timepicker-list li', function() {
		var time = $(this).html();
		list[rowIndex][colClass] = time;
		hot.render();
		console.log(colClass + ":" + list[rowIndex][colClass]);
	});


	//HANDSON TABLE INTIATION AND FUNCTIONS
	
	
	function attendanceList() {
		$('#employee-attendance').html('');
		var statusArr = ['pending', 'present', 'absent', 'late', 'undertime'];
		hot = new Handsontable($("#employee-attendance")[0], {
		    data: list,
		    height: 396,
		    colHeaders: ["ID", "NAME", "First Timein", "First Timeout", "Last Timein", "Last timeout", "TOTAL TIME", "STATUS"],
		    rowHeaders: true,
		    stretchH: 'all',
		    columnSorting: true,
		    contextMenu: true,
		    className: "htCenter htMiddle normal-col",
		    columns: [
		      {data: 'employee_id', type: 'text', className:'txt-name', readOnly: true},
			  {data: 'name', type: 'text', readOnly: true},
		      {data: 'f_time_in', type: 'text', className:'f_time_in hrCenter htMiddle'},
		      {data: 'f_time_out', type: 'text', className:'f_time_out hrCenter htMiddle'},
		      {data: 'l_time_in', type: 'text', className:'l_time_in hrCenter htMiddle'},
		      {data: 'l_time_out', type: 'text', className:'l_time_out hrCenter htMidlle'},
		      {data: 'total_time', type: 'text', className:'hrCenter htMidlle total_time', readOnly: true},
		      {data: 'status', type: 'dropdown', source: statusArr, className:'status hrCenter htMidlle'}
		    ], afterChange: function(change, sources) {
		    	if (sources === 'loadData') {
		            return; //don't do anything as this is called when table is loaded
		        }
		    	setTimeout(function() {
				   
			    	rowIndex = change[0][0];
			    	colClass = change[0][1];
			    	
				  	if (colClass == 'status') {
				  		var statIndex = statusArr.indexOf(change[0][3]);
				  		if (statIndex < 0) {
					  		$('#error').html('DELE PWEDE!! status na ing.ana');
					  		return;
					  	}
				    	console.log(statIndex + rowIndex);
				    	updateValue = statIndex;
					} else {
						updateValue = list[rowIndex][colClass];
						getTotalTime();
					}
					
					updateEmployeeData();
		    	 }, 300);
			}
	  	});
	}
	
	
	function getEmployeeData() {
		$.post('getEmployee', {}, function(data) {
			$('#error').html(data);
		});
	}

	var updateAjax;
	var updateValue;
	function updateEmployeeData() {
		var formData = new FormData();
		formData.append('id', list[rowIndex]['id']);
		formData.append('value', updateValue);
		formData.append('field', colClass);
		updateAjax = $.ajax({
			url: 'updateAttendance',
			data: formData,
			processData: false,
			contentType: false,
			type: 'POST',
			success: function(data) {
				console.log(data);
				updateAjax = null;
			}
		});
		
		//$.post('updateAttendance'
	}
	
	//getEmployeeData();
	//getAttendanceList('2015-05-15');
	getAttendanceList(formAttendance);
	function getAttendanceList(formAttendance) {
		$.post('attendanceList', formAttendance, function(data) {
			list = data;
			attendanceList();
			if (list.length === 0) {
				$('#error').html('No Data found');
			}
			console.log(list);
		}, 'JSON');
	}

	function resetAttendance(formAttendance) {
		$.post(webroot + 'attendances/resetAttendance', formAttendance, function(data) {
			//console.log(data);
			//$('#error').html(data);
			getAttendanceList(formAttendance);
		});
	}
	
	var formAttendance = new FormData();


	$('#btn-search').click(function(e) {
		e.preventDefault();
		getAttendanceList($('#attendance-form').serialize());
		
	});
	
	$('#date').datepicker();
<<<<<<< HEAD
=======
	$('#time-in').timepicker({
		defaultTime: false
	});

	$('#btn-reset').click(function(e) {
		e.preventDefault();
		if(confirm('Are you sure to reset all the time in and out??')) {
			resetAttendance($('#attendance-form').serialize());
		}
	});
	
>>>>>>> 050ff347c7aee211ef4c1520b03f11934875a191
});
function getTotalTime() {
	var ftimein 	= list[rowIndex]['f_time_in'];
	var ftimeout 	= list[rowIndex]['f_time_out'];
	var ltimein 	= list[rowIndex]['l_time_in'];
	var ltimeout 	= list[rowIndex]['l_time_out'];
	
	if ( 
		(ftimein != '--------' && ftimeout != '--------') ||
		(ltimein != '--------' && ltimeout != '--------') 
	) {
			
		var formData = new FormData();
		formData.append('ftimein', ftimein);
		formData.append('ftimeout', ftimeout);
		formData.append('ltimein', ltimein);
		formData.append('ltimeout', ltimeout);
		//console.log(ftimein + ":" + ftimeout + ":" + ltimein + ":" + ltimeout);
		$.ajax({
			url			: 	webroot + 'attendances/getTotalTime',
			data		:	formData,
			processData	:	false,
			contentType	:	false,
			type		: 	'POST',
			success		:	function(data) {
				focusElem.siblings('.total_time').html(data);
			}
		});
	}
}
</script>
<style>
.htHidden {
	display: none;
}

.htCore thead tr th:nth-child(10) {
	display: none;
}
</style>

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
<<<<<<< HEAD
			<div class='form-group'>
				<div class='col-lg-6'>
					<input type='text' id='date' placeholder='Choose Date' name='date' />
				</div>
				<div class='col-lg-6'>
						<input type='text' placeholder='Start of Time in' />
				</div>
=======
			<div class='control-group'>
				<input type='text' id='date' placeholder='Choose Date' name='date' />
				<input type='text' placeholder='Start of Time in' id='time-in' name='time-in'/>
>>>>>>> 050ff347c7aee211ef4c1520b03f11934875a191
			</div>
			<div class='control-group'>
				<button id='btn-search' class='btn btn-inverse'>Search</button>
				<button id='btn-reset' class='btn'>Reset</button>
				<div id="error" class="pull-right"></div>
			</div>
		</form>
		<div id="employee-attendance"></div>
	</div>
</div>

