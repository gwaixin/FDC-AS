var weburl = $('#url').val(); //base url
var positionmode = 0; //position select box
		
$(function(){
	
	$('#dp3').datepicker({
		 format: 'yyyy-mm-dd',
	});
	
	$('#dpStart').datepicker({
		 format: 'yyyy-mm-dd',
	});
	$('#dpEnd').datepicker({
		 format: 'yyyy-mm-dd',
	});

	/*
	 * upload file
	 */
	$("#uploadFile").on("change", function(){
        var files = !!this.files ? this.files : [];
		
        if (!files.length || !window.FileReader) return;
		
		
        if (/^image/.test( files[0].type)){ 
            var reader = new FileReader();
            reader.readAsDataURL(files[0]);
			imageName = files[0].name;
            reader.onloadend = function(){ 
                $("#img_preview").attr("src", this.result);
            }
        }
    });
	
	/*
	 * trigger browse photo
	 */
	$('#BrowsePhoto').on('click',function(e){
		e.preventDefault();
		$("#uploadFile").click();
	});
	
	/*
	 * trigger browse photo
	 */
	$('#BrowseSignature').on('click',function(e){
		e.preventDefault();
		$("#uploadSignature").click();
	});
	
	/*
	 * delete profile
	 */
	$('.delete-list').on('click',function(e){
		var dataID = $(this).data('profid');
		var posturl = weburl+'profiles/delete';
		if(confirm('Are you sure you want to delete this profile?')){
		
			$.post(posturl,{dataID:dataID},function(data){
				if(data == 1){
					$('.pro-id-'+dataID).remove();
				}
			});
			
		}
		
	});
	
	/*
	 * view detail profile
	 */
	$('.view-detail').on('click', function(e){
		e.preventDefault();
		var posturl = weburl+'profiles/view';
		var dataID = $(this).data('view-id');
		$.post(posturl,{dataId:dataID},function(data){
			var result = JSON.parse(data);
			var birthDate = new Date(result.Profile.birthdate);
			$('#img_preview').attr('src',weburl+'upload/'+result.Profile.picture);
			$('#f_name').html(result.Profile.last_name+', '+result.Profile.first_name+' '+result.Profile.middle_name);
			$('#birth').html(birthDate.getFullYear() + "-" + (birthDate.getMonth() + 1) + "-" + birthDate.getDate());
			$('#c_no').html(result.Profile.contact);
			$('#fb').html(result.Profile.facebook);
			$('#email').html(result.Profile.email);
			$('#gender').html(result.Profile.gender);
			$('#address').html(result.Profile.address);
			$('#c_p').html(result.Profile.contact_person);
			$('#c_p_no').html(result.Profile.contact_person_no);
			$('#sig .sig-prev').attr('src',weburl+'upload/'+result.Profile.signature);
		});
		
	});
	
	/*
	 * Browse file such as PDF , Docu and etc
	 */
	$('#BrowseFile').on('click',function(e){
		e.preventDefault();
		$("#uploadDocument").click();
	});
	
	/*
	 * trigger contract position
	 * call funtion GetPostion
	 */
	$('#contract-position').change(function(){
		positionmode = 0;
		GetPostion($(this).val(),$('#contract-position-level'));
	});
	/*
	 * trigger contract position level
	 * call funtion GetPostion
	 */
	$('#contract-position-level').change(function(){
		positionmode = 1;
		GetPostion($(this).val(),$('#contract-position'));
	});
	
	/*
	 * View Contract Profile
	 */
	$('.View-Contract').on('click', function(e){
		
		var url = weburl+'contractlogs/view';
		var dataid = $(this).data('id-contract');
		$.post(url,{dataid:dataid},function(data){
			var res = JSON.parse(data);
			if(res !== 0){
				for(var row in res){
					console.log(res);
					var dateStart = new Date(res[row].Contractlog.date_start);
					var dateEnd = new Date(res[row].Contractlog.date_end);
					$('#employee-id').html(res[row].emp.employee_id);
					$('#description').html(res[row].Contractlog.description);
					$('#date-start').html(dateStart.getFullYear() + "-" + (dateStart.getMonth() + 1) + "-" + dateStart.getDate());
					$('#date-end').html(dateEnd.getFullYear() + "-" + (dateEnd.getMonth() + 1) + "-" + dateEnd.getDate());
					$('#document').html(res[row].Contractlog.document);
					$('#salary').html(res[row].Contractlog.salary);
					$('#deminise').html(res[row].Contractlog.deminise);
					$('#term').html(res[row].Contractlog.term);
					$('#position').html(res[row].post.description);
					$('#position-level').html(res[row].postlevel.description);
				}
			}
		});
		
	});
	
	
});

/**
 * Get Position / Position level value of select box
 * @param id = id description of current select position
 * @param elem = parent element id of html
 */
function GetPostion(id,elem){

	var url = weburl+'contractlogs/GetPosition';
	var len = 0;
	$.post(url,{mode:positionmode,id:id},function(data){
		var res = JSON.parse(data);

		if(res !== 0){
			len = Object.keys(res).length;
			if (len  > 1){
				for(var row in res){
					elem.empty();
					elem.prepend("<option value=''>Select</option>").val('');
					$.each(res, function(value,key) {
						elem.append($("<option></option>")
					     .attr("value", value).text(key));
					});
				}	
			}else{
				for(var row in res){
					elem.val(row);
				}
			}

		}else{
			elem.val('');
		}
		
	});
	
}
