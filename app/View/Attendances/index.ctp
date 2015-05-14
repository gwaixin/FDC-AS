

<link href="<?php echo $this->webroot;?>css/hot.full.min.css" rel="stylesheet">
<link href="<?php echo $this->webroot;?>css/bootstrap-timepicker.min.css" rel="stylesheet"/>
<!-- <link href="<?php echo $this->webroot;?>css/twitter-bootstrap.min.css" rel="stylesheet"/>  -->
<script src="<?php echo $this->webroot;?>js/hot.full.min.js"></script>
<script src="<?php echo $this->webroot;?>js/bootstrap-timepicker.js"></script>
<script>
var webroot = '<?php echo $this->webroot;?>';
var selected_row = null;

$(document).ready(function () {

	var htTextarea;
	var focusElem;
	var rowIndex;
	var colClass;

	var currentTime;
	
	$(document).on('click', '#employee-attendance td', function(e) {
		colClass = $(this).attr('class').split(' ')[0];
		htTextarea = $("#employee-attendance textarea");
		rowIndex = $(this).closest('tr').index();
		if (
			colClass == 'f_time_in' 	|| 
			colClass == 'f_time_out' 	||
			colClass == 'l_time_in'		||
			colClass == 'l_time_out'
		) {
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
			});
			
		} else {
			if (htTextarea.hasClass('ui-timepicker-input')) {
				htTextarea.timepicker('remove');
			}
		}
		
		
	});


	//HANDSON TABLE INTIATION AND FUNCTIONS
	
	var hot;
	function attendanceList() {
		$('#employee-attendance').html('');
		var statusArr = ['pending', 'present', 'absent', 'late', 'undertime'];
		hot = new Handsontable($("#employee-attendance")[0], {
		    data: list,
		    height: 396,
		    colHeaders: ["ID", "NAME", "First Timein", "First Timeout", "Last Timein", "Last timeout", "TOTAL TIME", "STATUS", "hiddenID"],
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
		      {data: 'total_time', type: 'text', readOnly: true},
		      {data: 'status', type: 'dropdown', source: statusArr, className:'status hrCenter htMidlle'},
		      {data: 'id', type: 'numeric', className:'htHidden', readOnly: true}
		    ], afterChange: function(change, sources) {
			    if (sources === 'loadData' || change[0][2] == change[0][3]) {
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
					}
					
					updateEmployeeData();
		    	 }, 300);
			}
	  	});
	}
	
	var list = [];
	function getEmployeeData() {
		$.post(webroot+'attendances/getEmployee', {}, function(data) {
			$('#error').html(data);
		});
	}

	var updateAjax;
	var updateValue;
	function updateEmployeeData() {
		/*if (updateAjax && updateAjax.readystate != 4) {
			return;
		}*/
		var formData = new FormData();
		formData.append('id', list[rowIndex]['id']);
		formData.append('value', updateValue);
		formData.append('field', colClass);
		updateAjax = $.ajax({
			url: webroot+'attendances/updateAttendance',
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
		$.post(webroot + 'attendances/attendanceList', formAttendance, function(data) {
			list = data;
			attendanceList();
		}, 'JSON');
	}

	var formAttendance = new FormData();


	$('#btn-search').click(function(e) {
		e.preventDefault();
		getAttendanceList($('#attendance-form').serialize());
		
	});
	
	$('#date').datepicker();
	$('#time-in').timepicker({
		defaultTime: false
	});

	function validateTime(time) {
		return time.match(/^(0?[1-9]|1[012])(:[0-5]\d) [APap][mM]$/) ? true: false;
		
	}
});
</script>
<style>
.htHidden {
	display: none;
}

.htCore thead tr th:nth-child(10) {
	display: none;
}

.bootstrap-timepicker-widget table td input {
	width: 55px;
}
</style>
<div class='col-lg-12'>
	<h3> Attendance</h3>
	<div class='col-lg-8'>
		<form class='form-horizontal' id='attendance-form'>
			<div class='form-group'>
				<div class='col-lg-6'>
					<input type='text' placeholder='Search Employee ID or Name' name='keyword'/>
				</div>
				<div class='col-lg-6'>
					<select name='status'>
						<option selected='selected' disabled>Choose Status</option>
						<?php foreach($attendanceStat as $key => $as) { ?>
						<option value='<?php echo $key;?>'><?php echo $as; ?></option>
						<?php }?>
					</select>
				</div>
			</div>
			<div class='form-group'>
				<div class='col-lg-6'>
					<input type='text' id='date' placeholder='Choose Date' name='date' />
				</div>
				<div class='col-lg-6'>
						<input type='text' placeholder='Start of Time in' id='time-in' name='time-in'/>
				</div>
			</div>
			<div class='form-group'>
				<button id='btn-search'>Search</button>
			</div>
		</form>
	</div>
</div>
<div class='col-lg-12'>
	<div id="employee-attendance"></div>
	<div id="error"></div>
</div>

