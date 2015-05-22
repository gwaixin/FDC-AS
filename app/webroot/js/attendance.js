var selected_row = null;
var list = [];
var hot;
var focusElem;
var rowIndex;
var colClass;
var statusArr;

$(document).ready(function () {
	$('#time-in').timepicker({defaultTime : false});
	var currentDate = isDateTime($('#date').val()) ? $('#date').val() : phpDate; 
	
	
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
	
	$(document).on('click', '.otime', function() {
		rowIndex = $(this).closest('tr').index();
		if (list[rowIndex]['estatus'] == 1) {
			return;
		}
		focusElem = $(this);
		if (confirm("Update overtime? click cancel to reset overtime")) {
			checkOvertime(true);
		} else {
			checkOvertime(false);
		}
	});

	

	//HANDSON TABLE INTIATION AND FUNCTIONS
	function checkOvertime(set) {
		if (set) {
  			$.post(webroot+'Attendances/getOverTime', {id:list[rowIndex]['id']}, function(data) {
  				focusElem.html(data);
  			});
  		} else {
  			$.post(webroot+'Attendances/resetOvertime', {id:list[rowIndex]['id']}, function(data) {
  				focusElem.html('00:00:00');
  				console.log('reset ot: ' + data);
  			});
  		}
	}
	
	function attendanceList() {
		//$('#employee-attendance').html('');
		statusArr = ['pending', 'present', 'absent', 'late', 'undertime'];
		hot = new Handsontable($("#employee-attendance")[0], {
		    data: list,
		    height: 396,
		    colHeaders: ["ID", "NAME", "TIMEIN <b>1st</b>", "TIMEOUT <b>1st</b>", "TIMEIN <b>2nd</b>", "TIMEIN <b>2nd</b>", "RENDERED TIME", "OVERTIME", "STATUS"],
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
		      {data: 'over_time', type: 'text', className:'otime htCenter htMidlle', readOnly: true},
		      {data: 'status', type: 'dropdown', source: statusArr, className:'status htCenter htMidlle'}
		    ], afterChange: function(change, sources) {
			    if (sources === 'loadData' || change[0][2].trim() == change[0][3].trim()) {
			    	console.log(list);
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
				    	//console.log(statIndex + rowIndex);
				  		//checkOvertime();
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
			}, cells: function (row, col, prop) {
				var cellProperties = {};
				var insData = this.instance.getData()[row][col];
				if (list[row]['estatus'] == 1) {
					cellProperties.readOnly = true;
				} else {
					switch (col) {
						case 2:
							if (list[row]['ef_time_in']) {
								cellProperties.readOnly = true;
							}
							break;
						case 3: 
							if (list[row]['ef_time_out']) {
								cellProperties.readOnly = true;
							}
							break;
						case 4: 
							if (list[row]['el_time_in']) {
								cellProperties.readOnly = true;
							}
							break;
						case 5: 
							if (list[row]['el_time_out']) {
								cellProperties.readOnly = true;
							}
							break; 
							
					}
				}
				
				return cellProperties;
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
			if (list.length === 0) {
				$('#error').html('No Data found');
				$('.htCore tbody').html('');
			} 
			attendanceList();
			//}
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
		maxView: 1
	}).on('changeDate', function(ev){
    	$('#datetimepicker').blur();
    	hot.setDataAtRowProp(rowIndex, colClass, formatDate(new Date(ev.date.valueOf()), '%Y-%M-%d %H:%m:%s '));
    }).on('hide', function(ev) {
    	hot.setDataAtRowProp(rowIndex, colClass, formatDate(new Date(ev.date.valueOf()), '%Y-%M-%d %H:%m:%s '));
    });

    
	
	
});
		

function changeStat(stat) {
	hot.setDataAtRowProp(0, 'status', statusArr[stat]);
}

function getTotalTime() {
	
	var ftimein 	= list[rowIndex]['f_time_in'];
	var ftimeout 	= list[rowIndex]['f_time_out'];
	var ltimein 	= list[rowIndex]['l_time_in'];
	var ltimeout 	= list[rowIndex]['l_time_out'];
	var id 			= list[rowIndex]['id'];
	if ( 
		(isDateTime(ftimein) && isDateTime(ftimeout)) ||
		(isDateTime(ltimein) && isDateTime(ltimeout))
	) {
			
		var formData = new FormData();
		formData.append('f_time_in', ftimein);
		formData.append('f_time_out', ftimeout);
		formData.append('l_time_in', ltimein);
		formData.append('l_time_out', ltimeout);
		formData.append('id', id);
		//console.log(ftimein + ":" + ftimeout + ":" + ltimein + ":" + ltimeout);
		$.ajax({
			url			: 	webroot + 'attendances/getTotalTime',
			data		:	formData,
			processData	:	false,
			contentType	:	false,
			type		: 	'POST',
			dataType	:	'JSON',
			success		:	function(data) {
				console.log(data);
				focusElem.siblings('.status').html(statusArr[data['stat']]);
				focusElem.siblings('.total_time').html(data['total']);
				//focusElem.siblings('.otime').html(data['ot']);
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