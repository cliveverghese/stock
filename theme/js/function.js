function initilize_js(){
	
	$('.watchAction').submit(function(e){
		e.preventDefault();
		$.ajax({
		type: 'POST',		
		url:"index.php",
		data: $(this).serialize(),
		beforeSend: function(data){
			$('#notification').html("Processing Request...");
			$('#notification').stop().animate({height:'20px'},100);
			},
		success: function(data){
			$('#notification').html($('#stock',data).html());
			$('#notification').stop().delay(5000).animate({height:'0px'},100);
			}
			});
	});
	$('.watchActionRemove').submit(function(e){
		e.preventDefault();
		var symbol = this.elements["symbol"].value;
		$.ajax({
		type: 'POST',		
		url:"index.php",
		data: $(this).serialize(),
		beforeSend: function(data){
			$('#notification').html("Processing Request...");
			$('#notification').stop().animate({height:'20px'},100);
			},
		success:function(data){
			$('#notification').html($('#stock',data).html());
			$('#notification').delay(5000).stop().animate({height:'0px'},100);
			$('#' + symbol).fadeOut();
			}});
	});


	

	$('.buyAction').click(function(e){
		e.preventDefault();
		$('#buyArea').stop().animate({height:'170px'},200);

		var page = $(this).attr("href");
		$.ajax({
			url:page,
			beforeSend:function(){
				$('#buyAreaContent').html("Loading...");
			},
			success:function(data){
				$('#buyAreaContent').html($('#stock',data).html());
				$('.buySellType').change(function(){
					if($(this).val()=="limit")
					{
						
						$('.limitBuy').val("").removeAttr("disabled");
						$('.stoploss').val("").removeAttr("disabled");
						
						$('input.limitBuy').focus();
					}
					else
					{
						$('.limitBuy').val("Current Price").attr("disabled","disabled");
						$('.stoploss').val("Stop Loss").attr("disabled","disabled");
					}
				});
				$('.buySellAction').submit(function(e){
					e.preventDefault();
							$.ajax({
							type: 'POST',		
							url:"index.php",
							data: $(this).serialize(),
							beforeSend:function(){
								$('#buyAreaContent').html("Processing Request....");
							},	
							success:function(data){
						$('#buyAreaContent').html($('#stock',data).html());
							}});
					});
			}
			});
			
		});
	$('.closeAction').click(function(e){
		e.preventDefault();
		$('#buyArea').stop().animate({height:'0px'},200);

		});
	
		
}
		
$(document).ready(function(){
			initilize_js();
			

});


