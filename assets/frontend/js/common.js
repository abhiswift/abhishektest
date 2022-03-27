$(document).ready(function(e){

	{
		$('#contact-form-btn').on('click', function(){
			$(this).prop('disabled', true);
			let formdata =$('#contact-form').serialize();
			let linkurl=$(this).data("link");
			$.ajax({
				type: "POST",
				url: linkurl,
				data: formdata,
				dataType: 'json',
				success: function(res){
					$('#contact-form-btn').prop('disabled', false);
					if(res.status==1){
                        swal("Oops!", res.msg, "error");
                        $('input[name=csrf_test_name]').val(res.csrfhash);
                    }else{
                    	swal("Success", res.msg, "success");
                    	$('#contact-form').trigger("reset");
                    	$('input[name=csrf_test_name]').val(res.csrfhash);
                    }
				}, error: function (jqXHR){
				}
			})
		})
	}
	
})