
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

<link href="http://handsontable.com//styles/main.css" rel="stylesheet">
<link href="http://handsontable.com//bower_components/handsontable/dist/handsontable.full.min.css" rel="stylesheet">
<script src="http://handsontable.com//bower_components/handsontable/dist/handsontable.full.min.js"></script>

<script>
$(document).ready(function () {

	var advancedData = [];
	function get_employees() {

		$.post('employees/get_employees',function(data) {

			advancedData = data;
			display_employees();

		},'JSON')

	}

	get_employees();

	function display_employees() {

	  var hot = new Handsontable($("#adv_example")[0], {
	    data: advancedData,
	    height: 396,
	    colHeaders: ["Employee ID","Name", "Tin", "Salary", "Drug Test", "Pagibig", "Philhealth", "SSS", "Insurance ID","Position","Position Level","Contract"],
	    rowHeaders: true,
	    stretchH: 'all',
	    columnSorting: true,
	    contextMenu: true,
	    className: "htCenter htMiddle",
	    columns: [
		    {data: 'id', type: 'text'},
	      {data: 'name', type: 'text'},
	      {data: 'tin', type: 'text'},
	      {data: 'salary', type: 'text'},
	      {data: 'drug_test', type: 'text'},
	      {data: 'pagibig', type: 'text'},
	      {data: 'philhealth', type: 'text'},
	      {data: 'sss', type: 'text'},
	      {data: 'insurance_id', type: 'text'},
	      {data: 'position', type: 'text'},
	      {data: 'position_level', type: 'text'},
	      {data: 'contract', type: 'text'}
	    ]
	  });
	}
  
});

function add_employee() {
	var data = {tin:'',salary:'',profile_id:1,drug_test:'',philhealth:'',
							sss:'',insurance_id:'',role:1,position_id:1,position_level:1,
							current_contract:1};
	$.post('employees/add_employee',data,
		function(data) {

		});
}

</script>

<div id="adv_example"></div>