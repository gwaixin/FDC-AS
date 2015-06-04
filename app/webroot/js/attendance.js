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
var isMonthly = false;
var rowArr = [];
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
		changeDate();
		currentRequest = {keyword:keyword, monthly:currentDate};
		isMonthly = true;
		getAttendanceList(currentRequest);
		
	});
	
	$('#date').datepicker({
		autoclose: true,
		viewMode: "months",
		minViewMode: "months",
		format: "yyyy-mm"
	});

	$('#btn-reset').click(function(e) {
		e.preventDefault();
		/*if(currentRequest != "" && confirm('Are you sure to reset all the time in and out??')) {
			var id = [];
			var l;
			for (l in list) {
			  
			  id[l] = list[l]['id'];
			}
			if (id != null) {
				console.log(id);
				resetAttendance(id);
			}
		}*/
		$('#attendance-form')[0].reset();
		currentRequest = $('#attendance-form').serialize();
		getAttendanceList(currentRequest);
		changeDate();
		console.log('testing');
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

    //Tooltips
    $('.calendar-nav').tooltip({placement: 'bottom'});
	$('#btn-search-monthly').tooltip({placement: 'right'});

	
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

function convertToTime(val) {
	var time = 0;
	switch (val.length) {
		case 4: 
			time = pad(toTime(val));
			
			break;
		case 5:
		case 8:
			time = val;
			break;
		default: alert('Available format for break HH:mm, HHmm');
	}
	if (time != 0 && !isDateTime('2015-11-24 ' + time)) {
		time = 0;
		alert('Invalid time format');
	}
	return time;
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

function isEmptyRow(instance, row) {
	var rowData = instance.getData()[row];
	if (!instance.isEmptyRow(row)) {
		return false;
	}

	return true;
}

function defaultValueRenderer(instance, td, row, col, prop, value, cellProperties) {
	var args = arguments;

	if (args[5] === null && instance.isEmptyRow(row)) {
		var val = tplTotal[col];
		switch (col) {
			case 4: 
			case 5: 
			case 6: 
				val = calculateTotalTime(instance, row, col); 
				break;
		}
		args[5] = val;
		cellProperties.readOnly = true;
		td.style.color = '#000';
		td.style.background = '#EEE';
	}
	Handsontable.renderers.TextRenderer.apply(this, args);
}

function calculateTotalTime(instance, row, col) {
	var total = 0;
	var seconds = 0;
	for (var i = row-1; i >= 0; --i) {
		var time = instance.getDataAtCell(i, col);
		if (time != null && time != '' && typeof time != 'undefined') {
			var splitTime = time.split(':');
			seconds += (parseFloat(splitTime[0])*3600);
			seconds += (parseFloat(splitTime[1])*60);
			seconds += parseFloat(splitTime[2]);//splitTime[2];
		}
	}
	var hours = Math.floor(seconds/3600);
	seconds -= hours*3600;
	var minutes  = Math.floor(seconds/60);
	seconds -= minutes*60;
	
	hours = (hours <= 0 ) ? '' : hours + ' hr ';
	minutes = (minutes <= 0) ? '' : minutes + ' min ';
	seconds = (seconds <= 0) ? '' : seconds +' sec ';

	total = hours + minutes + seconds;
	return total;
}

var tplTotal = ["TOTAL", "", "", "", "BREAK", "RENDERTIME", "OVERTIME"];
function attendanceList() {
	//$('#employee-attendance').html('');
	statusArr = ['pending', 'present', 'absent', 'late', 'undertime'];
	hot = new Handsontable($("#employee-attendance")[0], {
	    data: list,
	    height: 396,
	    colHeaders: ["ID", "NAME", "TIMEIN", "TIMEOUT", "BREAK", "RENDERED TIME", "OVERTIME", "STATUS", "DAY"],
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
	      {data: 'break', type:'text', className:'break time htCenter htMiddle'},
	     // {data: 'l_time_in', type: 'text', className:'l_time_in time htCenter htMiddle'},
	     // {data: 'l_time_out', type: 'text', className:'l_time_out time htCenter htMidlle'},
	      {data: 'total_time', type: 'text', className:'htCenter time htMidlle total_time', readOnly: true},
	      {data: 'over_time', type: 'text', className:'otime htCenter htMidlle', readOnly: true},
	      {data: 'status', type: 'dropdown', source: statusArr, className:'status htCenter htMidlle'},
	      {data: 'day', type: 'text', className:'htCenter htMiddle', readOnly: true}
	    ], beforeChange: function(change, sources) {

	    	var instance = hot,
        	ilen = change.length,
        	clen = instance.colCount,
	        rowColumnSeen = {},
	        rowsToFill = {},
	        i,
	        c;

			for (i = 0; i < ilen; i++) {
			// if oldVal is empty
				if (change[i][2] === null && change[i][3] !== null) {
				  if (!instance.isEmptyRow(change[i][0])) {
				    // add this row/col combination to cache so it will not be overwritten by template
				    rowColumnSeen[change[i][0] + '/' + change[i][1]] = true;
				    rowsToFill[change[i][0]] = true;
				  }
				}
			}
			for (var r in rowsToFill) {
				if (rowsToFill.hasOwnProperty(r)) {
				  for (c = 0; c < clen; c++) {
				    // if it is not provided by user in this change set, take value from template
				    if (!rowColumnSeen[r + '/' + c]) {
				      change.push([r, c, null, tplTotal[c]]);
				    }
				  }
				}
			}
 
	    	rowIndex = isSorted(hot) ? hot.sortIndex[change[0][0]][0] : change[0][0];
	    	colClass = change[0][1];


	    	if (
	    		colClass != 'status' && 
	    		colClass != 'total_time' &&
	    		colClass != 'otime' &&
	    		change[0][2] != change[0][3] &&
	    		change[0][3] != ''
	    	) {

	    		var time = colClass == 'break' ? convertToTime(change[0][3]) : convertToDatetime(change[0][3]);
	    		if (time === 0) {
	    			console.log(change[0]);
	    			change[0][3] = change[0][2];
	    			return;
	    		} else {
	    			time = ((colClass == 'break' && time.length == 8) || (time.length == 19)) ? time : time+':00';
	    			list[rowIndex][colClass] = time;
	    			change[0][3] = time;
	    		}
	    	}
	    }, afterChange: function(change, sources) {

	    	if (sources == 'loadData') {
	    		return;
	    	}
	    	rowArr = []; //empty row
	    	var data;//id value field
	    	var ctr = 0;
	    	var idArr = [];
	        var fieldArr = [];
	        var value;
	    	for (var r in change) {
			    if (
			    	sources === 'loadData' || 
			    	change[r][2] == change[r][3]
			    ) {
			    	//console.log(list);
		            return; //don't do anything as this is called when table is loaded
		        }
		       
		        
		    	//setTimeout(function() {
			    rowIndex = change[r][0];
			    colClass = change[r][1];
				if (colClass == 'status') {
			  		var statIndex = statusArr.indexOf(change[r][3]);
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
				value = updateValue;
				if (idArr.indexOf(list[rowIndex]['id']) < 0) {
					idArr.push(list[rowIndex]['id']);
				}
				if (fieldArr.indexOf(colClass) < 0) {
					fieldArr.push(colClass);
				}
				rowArr.push(rowIndex);
				
			}

			data = {id: JSON.stringify(idArr), field: JSON.stringify(fieldArr), value:value};
			//console.log(JSON.stringify(data));

			updateEmployeeData(data);
				

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
					/*case 4: 
						if (list[row]['el_time_in']) {
							cellProperties.readOnly = true;
						}
						break;
					case 5: 
						if (list[row]['el_time_out']) {
							cellProperties.readOnly = true;
						}
						break; */
						
				}
			}
			cellProperties.renderer = defaultValueRenderer;
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
			if (isMonthly) {
				hot.alter('insert_row');
				isMonthly = false;
			}	
		}
		//}
	}, 'JSON');
}

var updateAjax;
var updateValue;
function updateEmployeeData(formData) {
	/*var formData = new FormData();
	//var physicalIndex = isSorted(hot) ? hot.sortIndex[rowIndex][0] : rowIndex;
	formData.append('id', list[rowIndex]['id']);
	formData.append('value', updateValue);
	formData.append('field', colClass);*/
	updateAjax = $.ajax({
		url: webroot+'attendances/updateAttendance',
		data: formData,
		type: 'POST',
		success: function(data) {
			console.log(data);
			updateAjax = null;
			if (colClass != 'status') {
				for(var i=0; i< rowArr.length; i++) {
					getTotalTime(rowArr[i]);
					//console.log(rowArr[i]);
				}
			}
		}
	});
	
	//$.post('updateAttendance'
}

function changeStat(stat) {
	hot.setDataAtRowProp(0, 'status', statusArr[stat]);
}

function getTotalTime(row) {
	
	var ftimein 	= list[row]['f_time_in'] ? list[row]['f_time_in'] : '';
	var ftimeout 	= list[row]['f_time_out'] ? list[row]['f_time_out'] : '';
	//var ltimein 	= list[row]['l_time_in'];
	//var ltimeout 	= list[row]['l_time_out'];
	var id 			= list[row]['id'];
	if (colClass != 'status') {
			
		var formData = new FormData();
		formData.append('f_time_in', ftimein);
		formData.append('f_time_out', ftimeout);
		//formData.append('l_time_in', ltimein);
		//formData.append('l_time_out', ltimeout);
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
				
				list[row]['total_time'] = data['render_time'];
				if (list[row]['status'] != statusArr[data['status']]) {
					list[row]['status'] = statusArr[data['status']];
				}
				if (typeof data['over_time'] !== 'undefined') {
					list[row]['over_time'] = data['over_time'];
				}

				hot.render();
			}
		});
	} else {
		if (!isDateTime(list[row][colClass])) {
			//focusElem.addClass('htInvalid');
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
