$(document).ready(function(){
	$.ajax({
		url:"http://localhost/bulls/index.php?o=portfolio",
		success: function(data){
						
			$("div.portfolio").html($('div.portfolio',data).html());
					
		}
	});
});
		
