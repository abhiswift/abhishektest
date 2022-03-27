$(document).ready(function(e){
	{
		$('.switchcheck').click(function(){
		    let checkedstat=$(this).is(':checked');
		    let id=$(this).data("id");
		    let name=$(this).data("name");
		    let urlhit=$(this).data("url");
	        let stat1=1;
	        let stat2=2;
	        if(checkedstat==true)
	        {
	          changebuttonstatus(name, id, urlhit, stat2);
	        }
	        else if(checkedstat==false)
	        {
	          changebuttonstatus(name, id, urlhit, stat1);
	        }
	  	});
	}
	{
		function changebuttonstatus(cat, id, urlhit, stat){
		    $.ajax({
		      type: 'POST',
		      url:  urlhit,
		      data: {
		        cat: cat,
		        id: id,
		        stat: stat
		      },
		      dataType:'json',
		      success: function(response){
		      	if(response.status==1){
		      		swal("Oops!!!", response.msg, "error");
		      	}else{
		      		swal("Success!!!", response.msg, "success");
		      	}
		      }, error: function(jqXHR){
		      }
		    })
  		}
	}
});