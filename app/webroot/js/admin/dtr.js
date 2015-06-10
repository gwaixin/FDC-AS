$(document).ready(function() {
	changeList();
	function changeList() {
		var year = $('#year').val();
		var month = $('#month').val();
		var date = year + '-' + month + '-01';
		var shift = $('#shift').val();

		$.post(webroot+'DTR/listDTR', {date: date, shift:shift}, function(data) {
			$('#dtr').html(data);
		});
	}

	$('#year, #shift, #month').change(function() {
		changeList();
	});
	
});