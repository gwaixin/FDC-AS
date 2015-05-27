

var timePicker;
var selectedIndex = 0;
var rightClicked = false;
var timer = null;
var hot = null;
var advancedData = [];
var currentSelectedRow  = -1;
$(document).ready(function () {

	var selected_row = null;
	var selected_cell = null;
	var dropdownIndex = 0;
	var selectedTimeCell;
	var names = [];
	var positionLevelDropdown = null;

	var lastSelectedIndex = -1;

	var searchValue = "";
	var companies = [];
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
			$("#txt-errors").html("");
			$("#edit-last-timein").html('Edit');
			$("#edit-last-timeout").html('Edit');
			$("#btn-submit").val('Edit');
			$("#additional-info-container #txt-errors").html("");
			$("#lbl-employee").html('Name : '+advancedData[selectedIndex].name);
			$("#additional-info-container input:not(#salary):not(#l_time_in):not(#l_time_out)").attr('disabled','disabled');
			$("#additional-info-container select").attr('disabled','disabled');
			$("#edit-last-timein").attr('disabled','disabled');
			$("#edit-last-timeout").attr('disabled','disabled');
			for(var x in $("#additional-info-container input")) {
				if(!isNaN(parseFloat(x)) && isFinite(x)) {
					var input = $("#additional-info-container input")[x];
					input.value = advancedData[selectedIndex][input.name];
				}
			}
			$("#password").val("company_default_password");
			$("#drug_test").val(advancedData[selectedIndex].drug_test);
		}
	});

	$("#btn-submit").click(function() {
		if($("#btn-submit").val() === 'Edit') {
			$("#additional-info-container input:not(#salary):not(#l_time_in):not(#l_time_out)").removeAttr('disabled');
			$("#additional-info-container select").removeAttr('disabled');
			$("#edit-last-timein").removeAttr('disabled');
				$("#edit-last-timeout").removeAttr('disabled');
			$("#btn-submit").val('Save');
		} else {
			var default_password = "company_default_password";
			var records = [];
			updateAdditionalInfo(selectedIndex);
		}
	});


	$("#edit-last-timein").click(function(){
		if($("#btn-submit").val() === 'Save') {
			if($("#edit-last-timein").html().trim() === 'Edit') {
				$("#l_time_in").removeAttr('disabled');
				$("#edit-last-timein").html('Cancel');
			} else {
				$("#l_time_in").val("");
				$("#l_time_in").attr('disabled','disabled');
				$("#edit-last-timein").html('Edit');
			}
		}
	});

	$("#edit-last-timeout").click(function(){
		if($("#btn-submit").val() === 'Save') {
			if($("#edit-last-timeout").html().trim() === 'Edit') {
				$("#l_time_out").removeAttr('disabled');
				$("#edit-last-timeout").html('Cancel');
			} else {
				$("#l_time_out").val("");
				$("#l_time_out").attr('disabled','disabled');
				$("#edit-last-timeout").html('Edit');
			}
		}
	});

	$(document).scroll(showContractButtons);

	$(window).resize(showContractButtons);

	function showContractButtons() {
		if($("#contract-selections").css('display') === 'block' && lastSelectedIndex >= 0) {
			var row = hot.getSelectedRange().to.row;
			var col = hot.getSelectedRange().to.col;
			var elem = hot.getCell(row,col);
			var top = ($("#table-employees").offset().top + elem.offsetTop) - $('body').scrollTop();
			var left = (($("#table-employees").offset().left + elem.offsetLeft) + $(".contract").width() -$("#contract-selections").width()) - $('#table-employees').scrollLeft();
			$("#contract-selections").css({'top':top,'left':left,'display':'block'});
		}
	}

	$(document).dblclick(function(e) {
		if(e.target.className === 'rowHeader' || e.target.className === 'relative') {
			$("#btn-select").click();
		}
		if(typeof hot.getSelectedRange() !== 'undefined') {
			if(hot.getSelectedRange().to.col === 6) {
				var top = $("#table-employees").offset().top + e.target.offsetTop;
				var left = ($("#table-employees").offset().left + e.target.offsetLeft) + $(".contract").width() -$("#contract-selections").width();
				var row = hot.getSelectedRange().to.row;
				$('#empID').val(advancedData[row].id);
				$('.empID').val(advancedData[row].id);
				$('.View-Contract').attr('data-id-contract',advancedData[row].id+':'+advancedData[row].contract_id);
				$("#contract-selections").css({'top':top,'left':left,'display':'block'});
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
			companies = data.companies;
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
		for(var x in positionLevels) {
			if($("#cbo-position").val() === positionLevels[x].position) {
				$("#cbo-position-level").append("<option value='" + positionLevels[x].positionLevel + "'> " + positionLevels[x].positionLevel + " </option>");			
			}
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

	$(document).click(function(e) {
		var target = e.target;
		var textareaExists = false;
		if(typeof hot.getSelectedRange() !== 'undefined' && positionLevelDropdown === null) {
			var col = hot.getSelectedRange().to.col;
			if(col === 4 && $("#table-employees textarea").length > 0) {
				textareaExists = true;
			}
		}
		if(positionLevelDropdown === null && target.className.match('current') && textareaExists) {
			appendPositionLevelDropdown();
		}
		if(positionLevelDropdown !== null && target.className.match('current')) {
			if(e.target.className.match('position-level')) {
				$("#table-employees textarea").css('display','none');
				$("#table-employees select").css({'width':$("#table-employees .position-level").width()+10
																					});
				$(".position-level-dropdown").css('display','block');
				$("#table-employees textarea").blur();
			} else {
				$("#table-employees textarea").css('display','block');
				$(".position-level-dropdown").css('display','none');
			}
			if(hot.getSelectedRange().to.col === 4) {
				refreshPositionLevel(advancedData[hot.getSelectedRange().to.row].position);
			}
		}
		if(!target.className.match('contract')) {
			$("#contract-selections").css({'display':'none'});
		}
		if(target.className.match('current') && typeof hot.getSelectedRange() !== 'undefined') {
			lastSelectedIndex = hot.getSelectedRange().to.row;
		} else {
			lastSelectedIndex = -1;
		}

		if(target.className.match('position-level-dropdown')) {
			positionLevelDropdown = e.target;
		}
		if(target.className.match('modal-backdrop fade in')) {
			$(".close").click();
		}

		if(e.target.className.match('txt-time')) {
			for(var x = 0 ; x < $(".bootstrap-timepicker-widget").length ; x++) {
				$(".bootstrap-timepicker-widget")[0].style.zIndex = '99999';
				if(x > 0) {
					document.body.removeChild($(".bootstrap-timepicker-widget")[0]);
				}
			}
		}

		if(typeof hot.getSelectedRange() !== 'undefined') {
			currentSelectedRow = hot.getSelectedRange().to.row;
		}

	});

	function appendPositionLevelDropdown() {
		var options = '<option value="">Positon Level</option>';
			$("#table-employees textarea").after("<select class='position-level-dropdown'>"+options+"</select>");
			$("#table-employees select").css('display','none');
			positionLevelDropdown = "";
			$("#table-employees select").change(function(){
				var value = $(".position-level-dropdown")[$(".position-level-dropdown").length-1].value;
				advancedData[hot.getSelectedRange().to.row].position_level = value;
				$("#table-employees textarea").val(value);
				var index = hot.getSelectedRange().to.row;
				hot.getCell(index,5).innerHTML = value;
				hot.selectCell(index,4);
				var data = [];
				data[0] = {'id':advancedData[index],'field':'position_level','position':advancedData[index],'value':value};
				$.post(baseUrl+"employees/saveAll",{'employees':data});
			});
	}

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

		},'JSON');
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
								if(data[x][1] === 'position_level') {
									employee['position'] = advancedData[index].position;
								}
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

	function updateAdditionalInfo(index) {
		$("#loading-BG").css('display','block');
		var data = {};
		var inputs = $("#additional-info-container input:not(#salary)");
		for(var x = 0 ; x < inputs.length ; x++) {
			data[inputs[x].name] = inputs[x].value;
		}
		data['id'] = advancedData[index].id;
		data['drug_test'] = $("#drug_test").val();
		$.post(baseUrl+'employees/updateAdditionInfo',{employee:data},
			function(errors) {
				$("#loading-BG").css('display','none');
				if(errors) {
					$("#txt-errors").html("<p>"+errors+"</p>");
				} else {
					$(".close").click();
					for(var x = 0 ; x < inputs.length ; x++) {
						advancedData[selectedIndex][inputs[x].name] = inputs[x].value;
					}
					advancedData[selectedIndex]['drug_test'] = $("#drug_test").val();
					$("#drug_test").val("company_default_password");
					bootbox.alert("Successfully updated employee info");
				}
			},'JSON');
	}

	function refreshPositionLevel(position) {
		var options = "<option value=''> Position Level </option>";
		for(var x in positionLevels) {
			if(position === positionLevels[x].position) {
				options += "<option value='"+positionLevels[x].positionLevel+"'>"+positionLevels[x].positionLevel+"</option>";
			}
		}
		$(".position-level-dropdown")[$(".position-level-dropdown").length-1].innerHTML = options;
		$(".position-level-dropdown")[$(".position-level-dropdown").length-1].value = advancedData[hot.getSelectedRange().to.row].position_level;
	}


	function validEmployeeID(value, callback) {
		setTimeout(function() {
			if(value === null) {
				callback(true);
			} else if (value.length === 0) {
				callback(true);
			} else if (value.match(/[0-9a-zA-Z-]{5,}/)) {
		        callback(true);
		    } else {
		    	callback(false);
		    }
	    }, 1);
	    return false;		
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
			} else if (value.match(/[0-9]{6,}/)) {
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
    colHeaders: ["Name","Employee ID", "Company","Position","Position Level", "Shift","Contract", "Role", "Status"],
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
		  	{data: 'employee_id',validator: validEmployeeID, type: 'text'},
		  	{
	      	data: 'company_systems', 
	      	type: 'dropdown',
	      	source: companies
	      },
	      {
	      	data: 'position', 
	      	type: 'text',
	      	readOnly: true
	      },
	      {
	      	data: 'position_level', 
	      	type: 'text',
	      	className: 'position-level current htCenter htMiddle',
	      	readOnly: true
	      },
	      {
	      	data: 'shift', 
	      	type: 'text',
	      	readOnly: true,
	      	className: 'shift current htCenter htMiddle'
	      },
	      {
	      	data: 'contract', 
	      	type: 'text', 
	      	readOnly: true,
	      	className: 'contract current htCenter htMiddle'
	      },
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
			if(data[0][1] === 'position' && data[0][2] !== data[0][3]) {
				var index = data[0][0];
				if($(".position-level-dropdown").length > 0) {
					refreshPositionLevel(advancedData[index].position);
				}
				advancedData[index].position_level = "";
				hot.getCell(index,4).innerHTML = "";
				data[0] = {'id':advancedData[index].id,'field':'position_level','position':advancedData[index].position,'value':''};
				$.post(baseUrl+"employees/saveAll",{'employees':data});
			}
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