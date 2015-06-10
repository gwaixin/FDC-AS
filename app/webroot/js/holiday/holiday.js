$(function(){
	$('#holiday-date').datepicker({
		autoclose: true,
		viewMode: "months",
		//minViewMode: "months",
		format: "yyyy-mm-dd"
	});
});

function formatRate() {
    var inputElement = $('.rate').val();
    inputElement=inputElement.replace(/\D/g, '');
    var inputValue = inputElement.replace('.', '').split("").join(""); // reverse
    var newValue = '';
    for (var i = 0; i < inputValue.length; i++) {
        if (i == 1) {
            newValue += '.';
		}
        newValue += inputValue[i];
        
    }
    $('.rate').val(newValue);
}