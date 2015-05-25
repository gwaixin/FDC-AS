$(document).ready(function() {
	var name = '';
	
	$('.submits').click(function(e) {
		e.preventDefault();
		
		var event = $(this).val();
		var url = $(this).parents('form').attr('action') + '/' + event;
		name = $(this).attr('name');
		
		if (event != 'Delete' || confirm('Are you really really sure?')) {
			$.post(url, $(this).parents('form').serialize(), function(data) {
				
				if(data['result'] == 'fail') {
					$('.'+ name +'-errors').html(data['message']);
					$('.'+ name +'-errors').fadeIn(500);
				} else if(data['result'] == 'success') {
					$('.'+ name +'-notice').html(data['message']);
					$('.'+ name +'-notice').fadeIn(500);
					if (name == 'position') {
						$.post(webroot+'Positions/viewPositionList', {}, function(data) {
							if (data[0] == 'success') {
								$('#PositionlevelPositionsId').html(data[1]);
							}
						}, 'JSON');
						reset();
					} else {
						resetPLevel();
					}
					getAllPositionLevel();
					getAllPosition();
				}
				setTimeout(function() {
					$('.'+ name + '-errors').fadeOut(100);
					$('.'+ name + '-notice').fadeOut(100);
				}, 3000);
				
			}, 'JSON');
		}
	});

	//Position JS
	var currPos; //Current position
	$('#btn-search-position').click(function() {
		var position = $('#seach-position').val();
		$.post(webroot+'Positions/searchPosition', {position: position}, function(data) {
			if (data[0] == 'success') {
				$('#searched-position').html(data[1]);
				if (data[2] == 1) {
					$('#seach-position').val($('#searched-position option:selected').text());
				} else {
					$('#searched-position').slideToggle();
					$('#seach-position').val($('#searched-position option:selected').text());
				}
				$('#btn-position-submit').val('Update');
				$('#btn-position-remove').fadeIn(500);
			} else {
				alert(data[1]);
			}
		}, 'JSON');
	});

	$('#searched-position').change(function() {
		$('#seach-position').val($('#searched-position option:selected').text());
		
	});

	$('#btn-position-reset').click(function() {
		reset();
	});

	function reset() {
		$('#seach-position').val('');
		$('#btn-position-submit').val('Create');
		$('#btn-position-remove').hide();
		$('#searched-position').fadeOut(100);
		$('#searched-position').html();
	}
	
	//Position Level JS
	var posLevelList = [];
	$('#btn-search-position-level').click(function() {
		var form = $(this).parents('form');
		var url = form.attr('action') + '/search';
		$.post(url, form.serialize(), function(data) {
			if (data[0] == 'success') {
				$('#searched-position-level').html(data[1]);
				console.log(data);
				posLevelList = data[3];
				var sPosLevel = $('#searched-position-level option:selected').val();
				if (data[2] == 1) {
					$('#seach-position-level').val(posLevelList[sPosLevel][0]);
				} else {
					$('#searched-position-level').slideToggle();
					$('#seach-position-level').val(posLevelList[sPosLevel][0]);
				}
				$('#btn-position-level-submit').val('Update');
				$('#btn-position-level-remove').fadeIn(500);
				$('#PositionlevelPositionsId').prop( "disabled", true );
			} else {
				alert(data[1]);
			}
		}, 'JSON');
	});

	$('#searched-position-level').change(function() {
		var sPosLevel = $('#searched-position-level option:selected').val();
		$('#seach-position-level').val(posLevelList[sPosLevel][0]);
		$('#PositionlevelPositionsId').val(posLevelList[sPosLevel][1]);
	});

	$('#btn-position-level-reset').click(function() {
		resetPLevel();
	});

	$('#PositionlevelPositionsId').change(function() {
		getAllPositionLevel();
	});
	function resetPLevel() {
		$('#PositionlevelPositionsId').prop('disabled', false );
		$('#searched-position-level').html('');
		$('#searched-position-level').fadeOut(100);
		$('#btn-position-level-submit').val('Create');
		$('#seach-position-level').val('');
		$('#btn-position-level-remove').hide();
	}
	getAllPosition();
	getAllPositionLevel();
	function getAllPosition() {
		$.post(webroot+'admin/getAllPosition', {}, function(data) {
			$('.list-of-positions').html(data);
		});
	}

	function getAllPositionLevel() {
		var id = $('#PositionlevelPositionsId').val();
		$.post(webroot+'Positionlevels/getPositionLevel/', {id: id}, function(data) {
			$('.list-of-positions-level').html(data);
		});
	}
});

