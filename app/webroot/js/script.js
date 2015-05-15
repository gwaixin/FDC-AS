$(function(){
	
	var weburl = $('#url').val();
	
	$('#dp3').datepicker();

	
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
	
	$('#BrowsePhoto').on('click',function(e){
		e.preventDefault();
		$("#uploadFile").click();
	});
	
	$('#BrowseSignature').on('click',function(e){
		e.preventDefault();
		$("#uploadSignature").click();
	});
	
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
	
	$('.view-detail').on('click', function(e){
		e.preventDefault();
		var posturl = weburl+'profiles/view';
		var dataID = $(this).data('view-id');
		$.post(posturl,{dataId:dataID},function(data){
			var result = JSON.parse(data);
			console.log(result);
			$('#img_preview').attr('src','upload/'+result.Profile.picture);
			$('#f_name').html(result.Profile.last_name+', '+result.Profile.first_name+' '+result.Profile.middle_name);
			$('#birth').html(result.Profile.birthdate);
			$('#c_no').html(result.Profile.contact);
			$('#fb').html(result.Profile.facebook);
			$('#email').html(result.Profile.email);
			$('#gender').html(result.Profile.gender);
			$('#address').html(result.Profile.address);
			$('#c_p').html(result.Profile.contact_person);
			$('#c_p_no').html(result.Profile.contact_person_no);
			$('#sig .sig-prev').attr('src','upload/'+result.Profile.signature);
		});
		
	});
	
});