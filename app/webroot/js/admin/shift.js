$(document).ready(function() {
	var row;
	var sid;
	$('.shift-btn-delete').click(function() {
		if (confirm("Are you sure you want to Delete this shift???")) {
			row = $(this).parent().parent();
			sid = row.attr('sid');
			$.post(webroot+'Employeeshifts/delete', {id:sid}, function(data) {
				if (data == 'success') {
					row.fadeOut(300);
				}
			});
		} 
	});

	$('.shift-btn-edit').click(function() {
		row = $(this).parent().parent();
		sid = row.attr('sid');
		$.post(webroot+'Employeeshifts/edit', {id:sid}, function(data) {
			$('#employee-shift-modal .modal-body').html(data);
			$('#employee-shift-modal').modal('show');
		});
	});

	$('.shift-btn-update').click(function() {
		$.post(webroot+'Employeeshifts/update/'+sid, $('#eshift-form-update').serialize(), function(data) {
			if(data['result'] == 'success') {
				$('#employee-shift-modal').modal('hide');
				console.log(data);
				//data['changes'].forEach(updatingList);
				for(var item in data['changes']) {
					row.find('.' + item).html(data['changes'][item]);
					console.log(data['changes'][item]);
				}
			} else if (data['result'] == 'fail') {
				$('#modal-error p').html(data['error']);
				$('#modal-error').fadeIn(300, function() {
					setTimeout(function() {
						$('#modal-error').fadeOut(300);
					}, 1000);
				});
			}
		}, 'JSON');
	});
	
	checkNotice();

	function checkNotice() {
		if (typeof $('.notice').html() != 'undefined' && $('.notice').html().length > 0) {
			$('.notice').fadeIn(1000);
		}
	}
});

$(document).on('click', '.settime', function() {
	var type = $(this).attr('timeType');
	var setting = $(this).attr('timeSet');
	if (setting === 'deactivated') {
		$(this).parent('span').siblings('select').removeAttr('disabled');
		$(this).attr('timeSet', 'activated');
	} else {
		$(this).parent('span').siblings('select').attr('disabled', 'true');
		$(this).attr('timeSet', 'deactivated');
	} 
});