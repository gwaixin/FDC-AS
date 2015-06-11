$(document).ready(function() {
	changeList();
	function changeList() {
		var year = $('#year').val();
		var month = $('#month').val();
		//var date = year + '-' + month + '-01';
		var shift = $('#shift').val();

		$.post(webroot+'Dtr/listDTR', {month:month, year:year, shift:shift}, function(data) {
			$('#dtr').html(data);
		});
	}

	$('#year, #shift, #month').change(function() {
		changeList();
	});
	
});