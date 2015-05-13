
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

<link href="http://handsontable.com//styles/main.css" rel="stylesheet">
<link href="http://handsontable.com//bower_components/handsontable/dist/handsontable.full.min.css" rel="stylesheet">
<link href="<?php echo $this->webroot;?>css/jquery.timepicker.css" rel="stylesheet"/>

<script src="http://handsontable.com//bower_components/handsontable/dist/handsontable.full.min.js"></script>
<script src="<?php echo $this->webroot;?>js/jquery.timepicker.min.js"></script>
<script>
var selected_row = null;

$(document).ready(function () {

	var htTextarea;
	var focusElem;
	var rowIndex;
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
			htTextarea.select();
			htTextarea.timepicker({ 'timeFormat': 'H:i:s' });
			htTextarea.on('changeTime', function() {
			    $('#onselectTarget').text($(this).val());
			});
			
		} else {
			if (htTextarea.hasClass('ui-timepicker-input')) {
				htTextarea.timepicker('remove');
			}
		}
		
		
	});
	
	$(document).on('click', '.ui-timepicker-list li', function() {
		var time = $(this).html();
		list[rowIndex][colClass] = time;
		hot.render();
		console.log(colClass + ":" + list[rowIndex][colClass]);
	});


	//HANDSON TABLE INTIATION AND FUNCTIONS
	
	var hot;
	function attendanceList() {

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
		    	if (sources === 'loadData') {
		            return; //don't do anything as this is called when table is loaded
		        }
		    	
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
				
			}
	  	});
	}
	
	var list = [];
	function getEmployeeData() {
		$.post('getEmployee', {}, function(data) {
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
	getAttendanceList(0);
	function getAttendanceList(currentDate) {
		$.post('attendanceList', {date:currentDate}, function(data) {
			list = data;
			attendanceList();
		}, 'JSON');
	}

	var currentDate = $('#current-date').val();

	$('.f-timein').click(function() {
		alert('testing');
	});
});
</script>
<style>
.htHidden {
	display: none;
}

.htCore thead tr th:nth-child(10) {
	display: none;
}
</style>
<input type='text' placeholder='Search' />
<input type='text' placeholder='Choose Date' />
<select>
	<option selected='selected'>Status</option>
	<?php foreach($attendanceStat as $as) { ?>
	<option><?php echo $as; ?></option>
	<?php }?>
</select>

<button>Search</button>
<br/>
<div id="employee-attendance"></div>
<div id="error"></div>
