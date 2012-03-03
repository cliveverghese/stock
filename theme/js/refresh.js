$(document).ready(function(){



		setInterval(function(){$.ajax({
			url:window.location.href,
			beforeSend:function(){
				$('#refreshing').animate({height:'24px'},100);
			},
			success:function(data){
				$('#stock').html($('#stock',data).html());
				$('#balanceUser').html($('#balanceUser',data).html());
				initilize_js();
				
				$('#refreshing').animate({height:'0px'},100);
			}
		})},10000);



		
});
