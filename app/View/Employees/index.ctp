
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<link href="http://handsontable.com//styles/main.css" rel="stylesheet">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<link href="http://handsontable.com//bower_components/handsontable/dist/handsontable.full.min.css" rel="stylesheet">
<script src="http://handsontable.com//bower_components/handsontable/dist/handsontable.full.min.js"></script>

<script>
var selected_row = null;
var selected_cell = null;
var dropdownIndex = 0;
$(document).ready(function () {


	var advancedData = [];

	var searchValue = "";
	var names = [];
	var positions = [];
	var positionLevels = [];
	fillDropDown();
	
	$(document).click(function() {

		if(selected_row = null) {
			$("#table-employees texarea").blur(saveChanges);
			$("#table-employees texarea").change(saveChanges);
		}

	});

	$("#cbo-position").change(function() {

		getPositionLevels();
		searchValue = $(this).val();
		getEmployees();

	});

	$("#cbo-position-level").change(function() {

		getEmployees();

	});

	$("#cbo-status").change(function() {

		searchValue = $("#cbo-status").val();
		getEmployees();

	});

	function  fillDropDown() {

		$.post('employees/getDropdownValues',function(data) {

			names = data.names;
			positions = data.positions;
			positionLevels = data.positionLevels;

		},'JSON');

	}
	
	function getPositions() {

		$.post("employees/getPositions",{value:""},function(data) {

			$("#cbo-position").append("<option value=''> Position </option>");
			for(var x in data) {
				$("#cbo-position").append("<option value='" + data[x] + "'>" + data[x] + "</option>");
			}
			getEmployees();

		});

	}

	function getPositionLevels() {

		$.post("employees/getPositionLevels",{value:"",position:$(".cbo-position").val()},
			function(data) {

				$("#cbo-position-level").html("");
				$("#cbo-position-level").append("<option value=''> Position Level </option>");
				for(var x in data) {
					$("#cbo-position-level").append("<option value='" + data[x] + "'>" + data[x] + "</option>");
				}

		},'JSON');

	}
	
	getPositions();

	$("#cbo-category").change(function() {

		switch($("#cbo-category").val()) {
			case "name" :
				$(".cbo-position").css('display','none');
				$("#txt-search").css('display','block');
				$("#cbo-status").css('display','none');
			break;
			case "employee_id" :
				$(".cbo-position").css('display','none');
				$("#txt-search").css('display','block');
				$("#cbo-status").css('display','none');
			break;
			case "position" :
				$(".cbo-position").css('display','block');
				$("#txt-search").css('display','none');
				$("#cbo-position-level").html("");
				$("#cbo-status").css('display','none');
			break;
			case "status":
				$(".cbo-position").css('display','none');
				$("#txt-search").css('display','none');
				$("#cbo-status").css('display','block');
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

		$.post('employees/getNames',
			function(data) {

				names = data;
				displayEmployees();

		},'JSON')

	}

	function getEmployees() {

		$.post('employees/getEmployees',{field:$("#cbo-category").val(),value:searchValue,
																		position_level:$("#cbo-position-level").val()},
			function(data) {

				advancedData = data;
				displayEmployees();

		},'JSON')

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
	   			strict: false
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
	      {data: 'first_time_in', type: 'text'},
	      {data: 'first_time_out', type: 'text'},
	      {data: 'last_time_in', type: 'text'},
	      {data: 'last_time_out', type: 'text'},
	      {data: 'role', type: 'text'},
	      {
	      	data: 'status', 
	      	type: 'dropdown',
	      	source: ['Active', 'Inactive']
	      }
	    ]
	  });

		hot.addHook('afterChange',function(e) {

			var index = e[0][0];
			if(advancedData[index].name !== null) {
				$.post('employees/saveChanges',{employee:advancedData[index]},function(data) {
					
					if(data.errors) {
						//selected_cell.style.background = "rgb(208,0,0)";
					} else {

					}

				},'JSON');
			}

		});

	}
  
});

</script>
<style>
#table-employees {
	z-index: 0;
}
#autocomplete{
	display: none;
	position: fixed;
	font: 14px "Trebuchet MS",sans-serif;
	z-index: 9999;
	width: 300px;
	left: 0;
	top: 0;
}
#autocomplete input{
	opacity: 0;
	z-index: -111;
}
.id-number {
	display: none;
}
.cbo-position {
	display: none;
}
#cbo-status {
	display: none;
}
.invalid {
	background: red;
}
</style>

<div id="autocomplete">
  <input>
</div>
<div id="search-container">
	<label for="txt-search"></label>
	<select id="cbo-category">
		<option value=""> Search By </option>
		<option value="employee_id"> Employee ID </option>
		<option value="name"> Name </option>
		<option value="position"> Position </option>
		<option value="status"> Status </option>
	</select>
	<input type="text" id="txt-search" placeholder="Search">
	<select id="cbo-position" class="cbo-position"></select>
	<select id="cbo-position-level"  class="cbo-position"></select>
	<select id="cbo-status">
		<option value=""> Status </option>
		<option value="1"> Active </option>
		<option value="0"> Inactive </option>
	</select>
</div>
<div id="table-employees"></div>
