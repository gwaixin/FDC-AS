

<link href="<?php echo $this->webroot;?>css/hot.full.min.css" rel="stylesheet">
<link href="<?php echo $this->webroot;?>css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
<link href="<?php echo $this->webroot;?>css/bootstrap-timepicker.min.css" rel="stylesheet"/>
<!-- <link href="<?php echo $this->webroot;?>css/twitter-bootstrap.min.css" rel="stylesheet"/>  -->
<script src="<?php echo $this->webroot;?>js/hot.full.min.js"></script>
<script src="<?php echo $this->webroot;?>js/moment.js"></script>
<script src="<?php echo $this->webroot;?>js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo $this->webroot;?>js/bootstrap-timepicker.min.js"></script>
<script>
var webroot = '<?php echo $this->webroot;?>';
var selected_row = null;
var list = [];
var hot;
var focusElem;
var rowIndex;
var colClass;
$(document).ready(function () {
	$('#time-in').timepicker({defaultTime : false});
	var currentDate = isDateTime($('#date').val()) ? $('#date').val() : "<?php echo date('Y-m-d H:i:s');?>"; 
	
	
	var htTextarea;
	
	
	var currentTime;
	$(document).on('click', '#employee-attendance td.time', function(e) {
		colClass = $(this).attr('class').split(' ')[0];
		htTextarea = $("#employee-attendance textarea");
		rowIndex = $(this).closest('tr').index();
		
		var hotInputHolder = htTextarea.parent();
		if ($(this).hasClass('time') && hotInputHolder.is(':visible')) {
			focusElem = $(this);
			
			var offset = htTextarea.offset();
			$('#datetimepicker').css('left', (offset.left) +'px');
			$('#datetimepicker').css('top', (offset.top+ 40) +'px');
			/*hotInputHolder.find("input").remove();
			hotInputHolder.prepend("<input type='text' style='position: absolute; visibility:hidden;' value='"+list[rowIndex][colClass]+"'>");
			hotInputHolder.find("input").datetimepicker('show');*/
			//htTextarea.datetimepicker().click();
			//htTextarea.click();
			
			var vDateTime = isDateTime(htTextarea.val()) ? htTextarea.val() : currentDate; 
			
			$('#datetimepicker').val(vDateTime);
			$('#datetimepicker').datetimepicker('show');
			
			
			
		} else {
			//if (htTextarea.hasClass('ui-timepicker-input')) {
				//htTextarea.timepicker().remove();
			//}
		}
		
		
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
		      {data: 'f_time_in', type: 'text', className:'f_time_in time htCenter htMiddle'},
		      {data: 'f_time_out', type: 'text', className:'f_time_out time htCenter htMiddle'},
		      {data: 'l_time_in', type: 'text', className:'l_time_in time htCenter htMiddle'},
		      {data: 'l_time_out', type: 'text', className:'l_time_out time htCenter htMidlle'},
		      {data: 'total_time', type: 'text', className:'htCenter time htMidlle total_time', readOnly: true},
		      {data: 'status', type: 'dropdown', source: statusArr, className:'status htCenter htMidlle'}
		    ], afterChange: function(change, sources) {
			    if (sources === 'loadData' || change[0][2].trim() == change[0][3].trim()) {
		            return; //don't do anything as this is called when table is loaded
		        }
		        
		    	setTimeout(function() {
				    console.log(change);
			    	rowIndex = isSorted(hot) ? hot.sortIndex[change[0][0]][0] : change[0][0];
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
						if (!validateDate(colClass)) {
							focusElem.addClass('htInvalid');
							return;
						}
						
						updateValue = list[rowIndex][colClass];
						getTotalTime();
					}
					
					updateEmployeeData();
		    	 }, 300);
			}
	  	});
	}
	

	function validateDate(dateClass) {
		var ok = false;
		var err;
		switch (dateClass) {
			case 'f_time_in' : 
				if (!isDateTime(list[rowIndex]['f_time_out']) || 
					Date.parse(list[rowIndex][dateClass]) < Date.parse(list[rowIndex]['f_time_out'])
				) {
					ok = true;
				}
				break;
			case 'l_time_in' :
				if (!isDateTime(list[rowIndex]['l_time_out']) ||
					(Date.parse(list[rowIndex][dateClass]) < Date.parse(list[rowIndex]['l_time_out']))
				) {
					ok = true;
				} 
				break;
			case 'f_time_out' :
				if (Date.parse(list[rowIndex][dateClass]) > Date.parse(list[rowIndex]['f_time_in'])
				) {
					ok = true;
				}
				break;
			case 'l_time_out' :
				if (!isDateTime(list[rowIndex]['l_time_in']) ||
					Date.parse(list[rowIndex][dateClass]) > Date.parse(list[rowIndex]['l_time_in'])
				) {
					ok = true; 
				}
				break; 
		}
		return ok;
	}
	
	function getEmployeeData() {
		$.post(webroot+'attendances/getEmployee', {}, function(data) {
			$('#error').html(data);
		});
	}

	var updateAjax;
	var updateValue;
	function updateEmployeeData() {
		var formData = new FormData();
		//var physicalIndex = isSorted(hot) ? hot.sortIndex[rowIndex][0] : rowIndex;
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

	function isSorted(hotInstance) {
	  return hotInstance.sortingEnabled && typeof hotInstance.sortColumn !== 'undefined';
	}
	
	
	//getEmployeeData();
	//getAttendanceList('2015-05-15');
	getAttendanceList(formAttendance);
	function getAttendanceList(formAttendance) {
		$.post(webroot + 'attendances/attendanceList', formAttendance, function(data) {
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

	$('#btn-reset').click(function(e) {
		e.preventDefault();
		if(confirm('Are you sure to reset all the time in and out??')) {
			resetAttendance($('#attendance-form').serialize());
		}
	});

	$('#datetimepicker').datetimepicker({
		weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
	}).on('changeDate', function(ev){
    	$('#datetimepicker').blur();
    	hot.setDataAtRowProp(rowIndex, colClass, formatDate(new Date(ev.date.valueOf()), '%Y-%M-%d %H:%m:%s '));
    }).on('hide', function(ev) {
    	hot.setDataAtRowProp(rowIndex, colClass, formatDate(new Date(ev.date.valueOf()), '%Y-%M-%d %H:%m:%s '));
    });

    
	
});
		
function getTotalTime() {
	
	var ftimein 	= list[rowIndex]['f_time_in'];
	var ftimeout 	= list[rowIndex]['f_time_out'];
	var ltimein 	= list[rowIndex]['l_time_in'];
	var ltimeout 	= list[rowIndex]['l_time_out'];
	
	if ( 
		(isDateTime(ftimein) && isDateTime(ftimeout)) ||
		(isDateTime(ltimein) && isDateTime(ltimeout))
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
				console.log(data);
				focusElem.siblings('.total_time').html(data);
			}
		});
	} else {
		if (!isDateTime(list[rowIndex][colClass])) {
			focusElem.addClass('htInvalid');
		}
	}
}

function isDateTime(date) {
	var isValid = !!new Date(date).getTime();
	return isValid;
}

function formatDate(date, fmt) {
    function pad(value) {
        return (value.toString().length < 2) ? '0' + value : value;
    }
    return fmt.replace(/%([a-zA-Z])/g, function (_, fmtCode) {
        switch (fmtCode) {
        case 'Y':
            return date.getUTCFullYear();
        case 'M':
            return pad(date.getUTCMonth() + 1);
        case 'd':
            return pad(date.getUTCDate());
        case 'H':
            return pad(date.getUTCHours());
        case 'm':
            return pad(date.getUTCMinutes());
        case 's':
            return pad(date.getUTCSeconds());
        default:
            throw new Error('Unsupported format code: ' + fmtCode);
        }
    });
}
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


