$(document).ready(function() {

	$('#birthdate').datepicker();
	$("#btn-browse-profile").click(function(){
		$("#file-profile").click();
	});
	$("#file-profile").change(function() {
		var img = URL.createObjectURL($("#file-profile")[0].files[0]);
		$("#img-profile").attr('src',img);
	});

	$("#btn-browse-signature").click(function(){
		$("#file-signature").click();
	});

	$("#file-signature").change(function() {
		var img = URL.createObjectURL($("#file-signature")[0].files[0]);
		$("#img-signature").attr('src',img);
	});
	

	$(document).click(function(e) {
		if(e.target.className === 'modal-backdrop fade in') {
			$("#modalSignature").modal('hide');
		}
	});

});