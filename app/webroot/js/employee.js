var selected_row = null;
var selected_cell = null;
var dropdownIndex = 0;
var advancedData = [];
var validatedCells = [];

$(document).ready(function () {

	var searchValue = "";
	var names = [];
	var positions = [];
	var positionLevels = [];
	fillDropDown();

	var fields = {'name':1,'employee_id':2,'tin':3,'salary':4,'drug_test':5,'pagibig':6,'philhealth':7,
				  'medical':8,'sss':9,'insurance_id':10,'f_time_in':14,'f_time_out':15,'l_time_in':16,
				  'l_time_out':17
				 };

	$(document).click(function(e) {
		
		if(e.toElement.className.match("time")) {
			// $("#table-employees textarea").attr('id','time');
			// $("#time").timepicker();
		} else {		
			$("#time").unbind();
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

	function  fillDropDown() {

		$.post(baseUrl + 'employees/getDropdownValues',function(data) {

			names = data.names;
			positions = data.positions;
			positionLevels = data.positionLevels;
			getEmployees();
			getPositions();
			getPositionLevels();

		},'JSON');

	}

	function getPositions() {

		$("#cbo-position").append("<option value='' disabled> Position </option>");
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

		if(e.keyCode === 13) {
			searchValue = $(this).val();
			getEmployees();
		}

	});

	function getNames() {

		$.post(baseUrl + 'employees/getNames',function(data) {

			names = data;
			displayEmployees();

		},'JSON')

	}

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

				if(data.success) {
					advancedData[index].id = data.id;
				}

			},'JSON');

	}

	function updateAll(data) {

		var data_arr = [];
		for(var x in data) {
			var index = data[x][0];
			if(advancedData[index].id !== null || advancedData[index].id) {
				if(data[x][1] !== 'name' && data[x][1] !== 'contract') {
					removeError({'index':index,'field':data[x][1]});
					if(data[x][3]) {
						if(data[x][2] !== data[x][3]) {
							var employee = {'index':index,id:advancedData[index].id,'field':data[x][1],'value':data[x][3]};
							data_arr.push(employee);
						}
					} else {
						$("#table-employees tr")[index+1].childNodes[fields[data[x][1]]].style.background = "#FF3333";
						validatedCells.push({'index':index,'field':data[x][1]});
					}
				}
			} else {
				if(advancedData[index].name !== null && advancedData[index].employee_id !== null) {
					if(advancedData[index].name && advancedData[index].employee_id) {
						addEmployee(advancedData[index],index);
					}
				}
			}
		}
		if(data_arr.length) {
			$.post(baseUrl + 'employees/saveAll',{employees:data_arr},
				function(data) {

					for(var x in data) {
						var index = data[x].index
						var field = data[x].field;
						validatedCells.push({'index':index,'field':data[x].field});
						$("#table-employees tr")[parseInt(index)+1].childNodes[fields[field]].style.background = "#FF3333";
					}

				},'JSON');
		}
		showInvalidFields();

	}


	function showInvalidFields() {

		for(var x in validatedCells) {
			if(validatedCells[x] !== null) {
				var index = validatedCells[x].index;
				var field = validatedCells[x].field;
				$("#table-employees tr")[parseInt(index)+1].childNodes[fields[field]].style.background = "#FF3333";
			}
		}
		
	}

	function removeError(error) {

		for(var x in validatedCells) {
			if(validatedCells[x] !== null) {
				if(parseInt(validatedCells[x].index) === parseInt(error.index) && validatedCells[x].field === error.field) {
					var index = parseInt(error.index);
					var field = error.field;
					$("#table-employees tr")[index+1].childNodes[fields[field]].removeAttribute('style');
					validatedCells[x] = null;
				}
			}
		}

	}

	function displayEmployees() {

		$("#table-employees").html("");
	  	var hot = new Handsontable($("#table-employees")[0], {
	    data: advancedData,
	    height: 396,
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
		    {data: 'employee_id', type: 'text'},
	      {data: 'tin', type: 'numeric'},
	      {data: 'salary', type: 'text'},
	      {data: 'drug_test', type: 'text'},
	      {data: 'pagibig', type: 'text'},
	      {data: 'philhealth', type: 'text'},
	      {data: 'medical', type: 'text'},
	      {data: 'sss', type: 'text'},
	      {data: 'insurance_id', type: 'text'},
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
	      {data: 'f_time_in', type: 'text', className: 'time htCenter'},
	      {data: 'f_time_out', type: 'text', className: 'time htCenter'},
	      {data: 'l_time_in', type: 'text', className: 'time htCenter'},
	      {data: 'l_time_out', type: 'text', className: 'time htCenter'},
	      {data: 'role', type: 'text'},
	      {data: 'status', type: 'dropdown', source: ['Active', 'Inactive']}
	    ]
	  });

		hot.addHook('afterChange',function(data) {

			updateAll(data);

		});

		hot.addHook('beforeRemoveRow',function(e) {

			if(advancedData[e].id !== null || advancedData[e].id) {
				if(advancedData[e].status !== "Trash") {
					var c = confirm('Are you sure you want to remove this employee?');
					if(c === true) {
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