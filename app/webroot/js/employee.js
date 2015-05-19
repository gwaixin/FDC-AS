

var timePicker;
var selectedIndex = 0;
var rightClicked = false;
var timer = null;
var hot = null;
$(document).ready(function () {

	var selected_row = null;
	var selected_cell = null;
	var dropdownIndex = 0;
	var advancedData = [];
	var selectedTimeCell;
	var names = [];

	var searchValue = "";
	var positions = [];
	var positionLevels = [];
	fillDropDown();
	var timePicker = null;
	var selectedTime = "";

	var clicked = false;

	var fields = {'name':1,'employee_id':2,'tin':3,'salary':4,'drug_test':5,'pagibig':6,'philhealth':7,
				  'medical':8,'sss':9,'insurance_id':10,'f_time_in':14,'f_time_out':15,'l_time_in':16,
				  'l_time_out':17
				 };
	$("#btn-select").click(function() {
			selectedIndex = hot.getSelectedRange().to.row;
			if(advancedData[selectedIndex].id !== null) {
				$("#lbl-employee").html('Name : '+advancedData[selectedIndex].name);
				$("#username").attr('disabled','disabled');
				$("#username").val(advancedData[selectedIndex].username);
				$("#password").val("********");
				$("#btn-submit").val('Edit');
			}
	});

	$("#btn-submit").click(function() {
		if($("#btn-submit").val() === 'Edit') {
			$("#username").removeAttr('disabled');
			$("#btn-submit").val('Save');
		} else {
			var records = [{'id':advancedData[selectedIndex].id,'field':'username','value':$("#username").val()}];
			$.post(baseUrl+'employees/saveAll',{employees:records},
				function(data) {
					if(data.errors.length === 0) {
						alert('Successully save!');
						$("#btn-submit").val('Edit');
						advancedData[selectedIndex].username = $("#username").val();
					}
				},'JSON');
		}
	});

	$(document).dblclick(function(e) {
		if(e.target.className === 'rowHeader' || e.target.className === 'relative') {
			$("#btn-select").click();
		}
	});

	$(document).click(function(e) {
		if (e.target.className.match("time") && timePicker === null) {
			$("#table-employees textarea").after("<input type='text' id='time' readonly>");
			timePicker = $("#time");
			$("#table-employees input").timepicker();
			$("#table-employees textarea").css('display','none');
			$("#time").change(function() {
				if ($("#time").val().length > 0) {
					var index = selectedTimeCell.to.row;
					var time = $("#time").val();
					$("#table-employees textarea").focus();
					// $("#table-employees tr:nth-child("+(parseInt(index)+1)+") .f_time_in").html(time);
					var data = [[index,selectedTime,time,time]];
					if(hot.sortIndex.length > 0) {
						advancedData[hot.sortIndex[index][0]][selectedTime] = time;
						data = [[hot.sortIndex[index][0],selectedTime,time,time]];
					} else {
						advancedData[index][selectedTime] = time;
					}
					$("#table-employees textarea").val(time);
					updateAll(data);
				}
			});
		}
		if (e.target.className.match('current') && timePicker !== null ) {
			if (e.target.className.match('time')) {
				var className = e.target.className;
				$("#table-employees textarea").css('display','none');
				$("#time").css('display','inline-block');
				selectedTime = className.split(' ')[1];
				selectedTimeCell = hot.getSelectedRange();
				var index = selectedTimeCell.to.row;
				var time = advancedData[index][selectedTime];
				if(hot.sortIndex.length > 0) {
					time = advancedData[hot.sortIndex[index][0]][selectedTime];
				}
				$("#time").focus();
				$("#time").val(time);
				$("#table-employees textarea").val(time);
				$("#time").blur();
				$("#time").css({'height':$("."+selectedTime).height()-10,'width':$("."+selectedTime).width()-5});
			} else {
				$("#table-employees textarea").css('display','inline-block');
				$("#time").css('display','none');
			}
		}

	});

	$("#cbo-position").change(function() {
		$("#cbo-position-level").val("");
		getPositionLevels();
		searchValue = $(this).val();
		getEmployees();
	});

	$("#cbo-position-level").change(function() {
		getEmployees();
	});

	$("#cbo-status").val("");
	$("#cbo-status").change(function() {
		searchValue = $("#cbo-status").val();
		getEmployees();
	});

	function fillDropDown() {
		$.post(baseUrl + 'employees/getDropdownValues',function(data) {
			names = data.names;
			positions = data.positions;
			positionLevels = data.positionLevels;
			getEmployees();
			getPositions();
			getPositionLevels();

		},'JSON');
	}

	function getNames() {
		$.post(baseUrl + 'employees/getDropdownValues',function(data) {
			names = data.names;
		},'JSON');
	}

	function getPositions() {
		$("#cbo-position option:first-child").attr('disabled','disabled');
		for(var x in positions) {
			$("#cbo-position").append("<option value='" + positions[x] + "'> " + positions[x] + " </option>");
		}
	}

	function getPositionLevels() {
		$("#cbo-position-level").html("");
		$("#cbo-position-level").append( "<option value='' disabled> Level </option>");
		for(var x in positions) { 
			$("#cbo-position-level").append("<option value='" + positionLevels[x] + "'> " + positionLevels[x] + " </option>");
		}
		$("#cbo-position-level").val("");
	}


	$("#cbo-category").change(function() {
		switch($("#cbo-category").val()) {
			case "name" :
				$(".cbo-position").css('display','none');
				$("#txt-search").css('display','');
				$("#cbo-status").css('display','none');
			break;
			case "employee_id" :
				$(".cbo-position").css('display','none');
				$("#txt-search").css('display','');
				$("#cbo-status").css('display','none');
			break;
			case "position" :
				$("#cbo-position").val("");
				$("#cbo-position-level").val("");
				$(".cbo-position").css('display','inline-block');
				$("#txt-search").css('display','none');
				$("#cbo-position-level").html("");
				$("#cbo-status").css('display','none');
			break;
			case "status":
				$("#cbo-status").val("");
				$(".cbo-position").css('display','none');
				$("#txt-search").css('display','none');
				$("#cbo-status").css('display','inline-block');
			break;
		}
	});

	$("#txt-search").keypress(function(e) {
		if (e.keyCode === 13) {
			searchValue = $(this).val();
			getEmployees();
		}
	});


	function getEmployees() {
		$.post(baseUrl + 'employees/getEmployees',{field:$("#cbo-category").val(),value:searchValue,
																		position_level:$("#cbo-position-level").val()},
			function(data) {

				advancedData = data;
				displayEmployees();

		},'JSON')
	}


	function addEmployee(employee,index) {
		$.post(baseUrl + 'employees/addEmployee',{employee:employee},
			function(data) {
				if (data.success) {
					advancedData[index].id = data.id;
					refresh();
				}
			},'JSON');
	}

	function updateAll(data) {
		var data_arr = [];
		for(var x in data) {
			if (typeof(data[x]) === 'object' && data[x] !== null) {
				var index = data[x][0];
				if (hot.sortIndex.length > 0) {
					index = hot.sortIndex[data[x][0]][0];
				}
				if (advancedData[index].id !== null || advancedData[index].id) {
					if (data[x][1] !== 'name' && data[x][1] !== 'contract') {
						if (data[x][3]) {
							if ((data[x][2] !== data[x][3]) || data[x][1].match('time')) {
								var employee = {'index':index,id:advancedData[index].id,'field':data[x][1],'value':data[x][3]};
								data_arr.push(employee);
							}
						}
					}
				} else {
					if (advancedData[index].name !== null && advancedData[index].employee_id !== null) {
						if (advancedData[index].name && advancedData[index].employee_id) {
							addEmployee(advancedData[index],index);
						}
					}
				}
			}
		}
		if (data_arr.length) {
			$.post(baseUrl + 'employees/saveAll',{employees:data_arr});
		}
	}


	
	function validTin(value, callback) {
		setTimeout(function() {
			if(value === null) {
				callback(true);
			} else if (value.length === 0) {
				callback(true);
			} else if (value.match(/[0-9]{4,}/)) {
		        callback(true);
		    } else {
		    	callback(false);
		    }
	    }, 1);
	    return false;		
	}

	function validCode(value, callback) {
		setTimeout(function() {
			if(value === null) {
				callback(true);
			} else if (value.length === 0) {
				callback(true);
			} else if (value.match(/([0-9]{2,})-([0-9]{2,})/)) {
		        callback(true);
		    } else {
		    	callback(false);
		    }
	    }, 1);
	    return false;
	}

	function validDrugTest(value, callback) {
		setTimeout(function() {
			if(value === null) {
				callback(true);
			} else if (value.length === 0) {
				callback(true);
			} else if (value.toLowerCase().match(/passed|failed/)) {
		        callback(true);
		    } else {
		    	callback(false);
		    }
	    }, 1);
	    return false;
	}

	function validTime(value, callback) {
		setTimeout(function(){
			if(value === null) {
				callback(true);
			} else if (value.length === 0) {
				callback(true);
			} else if (value.match(/([0-9]{1}):([0-9]{2}) AM|PM/)) {
		        callback(true);
		    } else {
		        callback(false);
	      	}
	    }, 1);
	    return false;
	}


	function sortData() {
		if (hot.sortIndex.length > 0) {
			var data = [];
			for(var x = 0 ; x < hot.sortIndex.length ; x++) {
				data[x] = advancedData[hot.sortIndex[x][0]];
			}
			advancedData = data;
		}
	}

	function refresh() {
		$.post(baseUrl + 'employees/getDropdownValues',function(data) {

			names = data.names;
			refreshTable();
			sortData();

		},'JSON')
	}

	function refreshTable() {
		timePicker = null;
		displayEmployees();
	}



	function displayEmployees() {
		if (hot !== null) {
			hot.destroy();
		}
  	hot = new Handsontable($("#table-employees")[0], {
    data: advancedData,
    height: 396,
    manualColumnResize: true,
    manualRowResize: true,
    colHeaders: ["Name","Employee ID", "Tin", "Salary", "Drug Test", "Pagibig", "Philhealth", "Medical", "SSS", "Insurance ID","Position","Position Level","Contract","First Time in","First Time out","Last Time in","Last Time out", "Role", "Status"],
    rowHeaders: true,
    stretchH: 'all',
    columnSorting: true,
    contextMenu: true,
    className: "htCenter htMiddle",
    columns: [
	   		{
	   			data: 'name', 
	   			type: 'autocomplete',
	   			source: names,
	   			strict: false,
	   			className : 'htLeft'
	   		},
		  {data: 'employee_id',validator: validCode, type: 'text'},
	      {data: 'tin', type: 'text', validator: validTin},
	      {data: 'salary', type: 'text'},
	      {data: 'drug_test', validator: validDrugTest, type: 'text'},
	      {data: 'pagibig', validator: validCode, type: 'text'},
	      {data: 'philhealth', validator: validCode, type: 'text'},
	      {data: 'medical', type: 'text'},
	      {data: 'sss', validator: validCode, type: 'text'},
	      {data: 'insurance_id', validator: validCode, type: 'text'},
	      {
	      	data: 'position', 
	      	type: 'dropdown',
	      	source: positions
	      },
	      {
	      	data: 'position_level', 
	      	type: 'dropdown',
	      	source: positionLevels
	      },
	      {data: 'contract', type: 'text'},
	      {data: 'f_time_in', type: 'text', validator: validTime, className: 'time f_time_in htCenter'},
	      {data: 'f_time_out', type: 'text', validator: validTime, className: 'time f_time_out htCenter'},
	      {data: 'l_time_in', type: 'text', validator: validTime, className: 'time l_time_in htCenter'},
	      {data: 'l_time_out', type: 'text', validator: validTime, className: 'time l_time_out htCenter'},
	      {data: 'role', type: 'text'},
	      {data: 'status', type: 'dropdown', source: ['Active', 'Inactive']}
	  	  ]
 	 });
		hot.addHook('afterRender',function() {
			if (advancedData[0].id !== null) {
				hot.validateCells(finished);
			}
		})
		hot.addHook('afterChange',function(data) {

			updateAll(data);

		});
		hot.addHook('beforeRemoveRow',function(e) {
			if (advancedData[e].id !== null || advancedData[e].id) {
				if (advancedData[e].status !== "Trash") {
					var c = confirm('Are you sure you want to remove this employee?');
					if (c === true) {
						$.post(baseUrl + 'employees/deleteEmployee',{id:advancedData[e].id});
						advancedData[e].status = "Trash";
					} else {
						hot.undo();
					}
				} else {
					hot.undo();
					alert("Employee is already trash");
				}
			}
		});
	}
});

var finished = function() {
	// console.log('Finished!');
}
function SelectEmployee() {
	$("#btn-select").click();
}
var appendViewEmployeeButton = function() {
	timer = setTimeout('appendViewEmployeeButton()',100);
	if(rightClicked) {
	// 	try {
	// 		$(".htContextMenu .ht_master table tbody tr:last-child").before("<tr id='tr-view-employee-info'><td><div onclick='SelectEmployee()'>View Employee</div></td></tr>");
	// 	} catch(error) {
	// 		console.log(error);
	// 	}
	// 	rightClicked = false;
	// 	clearTimeout(timer);
	// } else {
	// 	rightClicked = true;
	}
}