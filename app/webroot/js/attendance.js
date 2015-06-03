var selected_row = null;
var list = [];
var hot;
var focusElem;
var rowIndex;
var colClass;
var statusArr;
var dateObj;
var cMonthDay;
var cYear;
var currentDate;
var currentRequest = "";
$(document).ready(function () {
	//$('#time-in').timepicker({defaultTime : false});
	//For dates
	//console.log($('#date').val());
	changeDate();
	
	var currentTime;

	function changeDate() {
		currentDate = isDateTime($('#date').val()) ? $('#date').val() : phpDate; 
		dateObj 	= new Date(currentDate);
		cMonthDay 	= pad((dateObj.getUTCMonth()+1)) + '-' +pad(dateObj.getDate());
		cYear 		= dateObj.getUTCFullYear();
	}
	//hot table textarea popup
	var htTextarea;
	
	//checker if time has been converted
	var hasConvert;
	
	$(document).on('click', '#employee-attendance td.time', function(e) {
		colClass = $(this).attr('class').split(' ')[0];
		htTextarea = $("#employee-attendance textarea");
		rowIndex = $(this).closest('tr').index();
		
		var hotInputHolder = htTextarea.parent();
		if ($(this).hasClass('time') && hotInputHolder.is(':visible')) {
			focusElem = $(this);
			htTextarea.select();
		} 
	});
	
	$(document).on('click', '.otime', function() {
		rowIndex = $(this).closest('tr').index();
		if (
			list[rowIndex]['estatus'] == 1 ||
			isDateTime(list[rowIndex]['ef_time_out'])
		) {
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
  				//focusElem.html(data);
  				list[rowIndex]['over_time'] = data;
  				hot.render();
  			});
  		} else {
  			$.post(webroot+'Attendances/resetOvertime', {id:list[rowIndex]['id']}, function(data) {
  				focusElem.html('00:00:00');
  				console.log('reset ot: ' + data);
  			});
  		}
	}
	
	


	function validateDate(dateClass) {
		/*var ok = false;
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
		}*/
		return true;
	}
	
	function getEmployeeData() {
		$.post(webroot+'attendances/getEmployee', {}, function(data) {
			$('#error').html(data);
		});
	}
	
	
	//getEmployeeData();
	//getAttendanceList('2015-05-15');
	getAttendanceList(formAttendance);

	function resetAttendance(formAttendance) {
		$.ajax({
		    type: 'POST',
		    url: webroot + 'attendances/resetAttendance',
		    data: {ids: JSON.stringify(formAttendance)},
		    success: function(data) {
		    	getAttendanceList(currentRequest);
		    }
		});
	}
	
	var formAttendance = new FormData();
	

	$('#btn-search').click(function(e) {
		e.preventDefault();
		currentRequest = $('#attendance-form').serialize();
		getAttendanceList(currentRequest);
		changeDate();
	});

	$('#btn-search-monthly').click(function(e) {
		e.preventDefault();
		var keyword = $('#keyword').val();
		currentRequest = {keyword:keyword, monthly:currentDate};
		getAttendanceList(currentRequest);
		changeDate();
	});
	
	$('#date').datepicker();

	$('#btn-reset').click(function(e) {
		e.preventDefault();
		if(currentRequest != "" && confirm('Are you sure to reset all the time in and out??')) {
			var id = [];
			var l;
			for (l in list) {
			  
			  id[l] = list[l]['id'];
			}
			if (id != null) {
				console.log(id);
				resetAttendance(id);
			}
		}
	});
  
    $('#auto-overtime').click(function() {
    	var elem = $(this).find('i.fa');
    	var setting = elem.hasClass('fa-toggle-off') ? 1 : 0;
    	elem.removeClass('fa-toggle-on');
    	elem.removeClass('fa-toggle-off');
    	$.post(webroot+'Attendances/setAutoOvertime', {auto:setting}, function(data) {
    		elem.addClass(data);
    	});
    	
    });
	
	
});

function convertToDatetime(val) {
	var fDate = 0;
	switch (val.length) {
		case 4: 
			var time = pad(toTime(val));
			fDate = cYear+'-'+cMonthDay+' '+time;
			break;
		case 8:
			var month = pad(toMonth(val.substr(0, 4)));
			var time = pad(toTime(val.substr(4, 8)));
			fDate = cYear+'-'+month+' '+time;
			break;
		case 12: 
			var year = pad(toYear(val.substr(0, 4)));
			var month = pad(toMonth(val.substr(4, 8)));
			var time = pad(toTime(val.substr(8, 12)));
			fDate = year+'-'+month+' '+time;
			break;
		case 19:
			fDate = val;
			break;
		default: alert('Did not follow the allowed format'); 
	}
	if (fDate != 0 && !isDateTime(fDate)) {
		fDate = 0;
		alert('Invalid time format'); 
	}
	return fDate;
}

function toTime(val) {
	var time = val.split('');
	return time[0] + time[1] +':'+ time[2] + time[3];
}

function toMonth(val) {
	var date = val.split('');
	return date[0] + date[1] +'-'+ date[2] + date[3];
}

function toYear(val) {
	var year = val.split('');
	return year[0] + year[1] + year[2] + year[3];
}
function isSorted(hotInstance) {
  return hotInstance.sortingEnabled && typeof hotInstance.sortColumn !== 'undefined';
}

function attendanceList() {
	//$('#employee-attendance').html('');
	statusArr = ['pending', 'present', 'absent', 'late', 'undertime'];
	hot = new Handsontable($("#employee-attendance")[0], {
	    data: list,
	    height: 396,
	    colHeaders: ["ID", "NAME", "TIMEIN <b>1st</b>", "TIMEOUT <b>1st</b>", "TIMEIN <b>2nd</b>", "TIMEOUT <b>2nd</b>", "RENDERED TIME", "OVERTIME", "STATUS", "DAY"],
	    rowHeaders: false,
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
	      {data: 'status', type: 'dropdown', source: statusArr, className:'status htCenter htMidlle'},
	      {data: 'day', type: 'text', className:'htCenter htMiddle', readOnly: true}
	    ], beforeChange: function(change, sources) {
	    	rowIndex = isSorted(hot) ? hot.sortIndex[change[0][0]][0] : change[0][0];
	    	colClass = change[0][1];
	    	if (
	    		colClass != 'status' && 
	    		colClass != 'total_time' &&
	    		colClass != 'otime' &&
	    		change[0][2] != change[0][3]
	    	) {
	    		var time = convertToDatetime(change[0][3]);
	    		if (time === 0) {
	    			console.log(change[0]);
	    			change[0][3] = change[0][2];
	    			return;
	    		} else {
	    			time = time.length == 19 ? time : time+':00';
	    			list[rowIndex][colClass] = time;
	    			change[0][3] = time;
	    		}
	    	}
	    }, afterChange: function(change, sources) {
		    if (
		    	sources === 'loadData' || 
		    	change[0][3] == '' ||
		    	change[0][2] == change[0][3]
		    	
		    ) {
		    	//console.log(list);
	            return; //don't do anything as this is called when table is loaded
	        }
	        
	    	//setTimeout(function() {
		    	
			if (colClass == 'status') {
		  		var statIndex = statusArr.indexOf(change[0][3]);
		  		if (statIndex < 0) {
			  		$('#error').html('Invalid status');
			  		$('#error').fadeIn(200);
			  		return;
			  	}
		    	//console.log(statIndex + rowIndex);
		  		//checkOvertime();
		    	updateValue = statIndex;
		    	
			} else {
				/*if (!validateDate(colClass)) {
					focusElem.addClass('htInvalid');
					return;
				}
				*/
				
				updateValue = list[rowIndex][colClass];
				//updateEmployeeData();
				
			}
			updateEmployeeData();
				

	    	 //}, 300);
		}, cells: function (row, col, prop) {
			var tmpData = this.instance.getData();
			
			if (list.length <= 0) {
				return;
			}
			var cellProperties = {};
			var insData = tmpData[row][col];
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

function getAttendanceList(formAttendance) {
	$.post(webroot + 'attendances/attendanceList', formAttendance, function(data) {
		$("#employee-attendance").html('');
		if (data == '') {
			$('#error').html("No data found");
			$('#error').fadeIn(200);
			currentRequest = "";
		} else if (typeof data['error'] !== 'undefined') {
			$('#error').html(data['error']);
			$('#error').fadeIn(200);
			currentRequest = "";
		} else {
			console.log(data);
			$('#error').html('');
			$('#error').hide();
			list = data;
			attendanceList();
		}
		//}
	}, 'JSON');
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
			if (colClass != 'status') {
				getTotalTime();
			}
		}
	});
	
	//$.post('updateAttendance'
}

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
				/* Reference */
				//focusElem.siblings('.total_time').html(data['total']);
				//focusElem.siblings('.otime').html(data['overtime']);
				//focusElem.siblings('.status').html(statusArr[data['stat']]);
				
				list[rowIndex]['total_time'] = data['render_time'];
				if (list[rowIndex]['status'] != statusArr[data['status']]) {
					list[rowIndex]['status'] = statusArr[data['status']];
				}
				if (typeof data['over_time'] !== 'undefined') {
					list[rowIndex]['over_time'] = data['over_time'];
				}

				hot.render();
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

function pad(value) {
    return (value.toString().length < 2) ? '0' + value : value;
}
function formatDate(date, fmt) {
    
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

//For calendar Events
$(document).on('click', '.days', function() {
   $('#focus-day').removeAttr('id');
   $(this).attr('id', 'focus-day');
   var day = pad($(this).html());
   //alert(yearMonth+day);
   var yearMonth = $('#yearmonth').val();
   currentRequest = {date:(yearMonth+day)};
   getAttendanceList(currentRequest);
});

$(document).on('click', '.calendar-nav', function() {
	var date = $(this).attr('date');
    $.post(webroot+'attendances/getCalendar', {date: date}, function(data) {
        $("#calendar").html(data);
    });
});
