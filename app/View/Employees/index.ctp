
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

<link href="http://handsontable.com//styles/main.css" rel="stylesheet">
<link href="http://handsontable.com//bower_components/handsontable/dist/handsontable.full.min.css" rel="stylesheet">
<script src="http://handsontable.com//bower_components/handsontable/dist/handsontable.full.min.js"></script>

<script>
var selected_row = null;

$(document).ready(function () {

	$(document).click(function(e) {

		if(selected_row === null) {
			$("#adv-example textarea").keyup(function() {
				if(e.toElement.className === "txt-name current") {
					$("#suggested-names").css({'display':'block',
						'margin-top':selected_row.offsetTop+$("#suggested-names").height() + 65 + 'px',
					  'margin-left':e.toElement.offsetLeft + 20 + 'px',});
					$.post("employees/suggestNames",{name:$("#adv-example textarea").val()},
						function(data) {

							$("#suggested-names").html(data);
							$("#suggested-names").val("");

						});
				}

			});
		}
		var className = e.toElement.className.split(' ')[e.toElement.className.split(' ').length-1];
		if(className === "current") {
			selected_row = e.toElement.parentNode;
			saveChanges();
		}

	});


	$("#suggested-names").change(function() {

		if($("#suggested-names").val().length > 0) {
			$("#adv-example textarea").val($("#suggested-names").val());
			$("#suggested-names").css('display','none');
			var index = $("tbody").children().index(selected_row);
			selected_row.childNodes[1].innerHTML = $("#adv-example textarea").val();
			advancedData[index]['name'] = $("#adv-example textarea").val();
		}

	});
	

	function get_employees() {

		$.post('employees/getEmployees',function(data) {

			advancedData = data;
			display_employees();

		},'JSON')

	}

	get_employees();

	function display_employees() {

	  var hot = new Handsontable($("#adv-example")[0], {
	    data: advancedData,
	    height: 396,
	    colHeaders: ["Name","Employee ID", "Tin", "Salary", "Drug Test", "Pagibig", "Philhealth", "SSS", "Insurance ID","Position","Position Level","Contract"],
	    rowHeaders: true,
	    stretchH: 'all',
	    columnSorting: true,
	    contextMenu: true,
	    className: "htCenter htMiddle",
	    columns: [
	      {data: 'name', type: 'text', className:'txt-name'},
		    {data: 'employee_id', type: 'text'},
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

var advancedData = [];
function saveChanges() {

	var index = $("tbody").children().index(selected_row);
	if(advancedData[index].name !== null) {
		$.post('employees/saveChanges',{employee:advancedData[index]},function(data) {


			
		});
	}

};

</script>
<style>
#suggested-names {
	display: none;
	position: fixed;
	z-index: 999;
	width: 300px;
	left: 0;
	top: 0;
}
</style>
<div id="adv-example"></div>
<select id="suggested-names"></select>