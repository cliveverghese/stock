$(document).ready(function(){
	$('#user').html("Checking Authentication...<br /><img src = \"http://conjura.in/bullsndbears/theme/images/loading.gif\">");
});

window.fbAsyncInit = function() {
        FB.init({
          appId      : '153170114784919',
          status     : true, 
          cookie     : true,
          xfbml      : true
        });

        FB.Event.subscribe('auth.login', function(response) {
		window.location.reload(true);
		 		
        });
	FB.Event.subscribe('auth.logout',function(response) {
		$.ajax("http://conjura.in/bullsndbears/logout.php");
	});
	
	FB.getLoginStatus(function(response){
		if(response.status == "connected"){
			FB.api('/me',function(response){
				$("#user").html('<img height = "25px" src = "http://graph.facebook.com/' + response.id + '/picture" />' + response.name + '<br /><a href = "index.php">Proceed to home Page</a>');	
				$('#slow').animate({opacity:"0"});
			});
		}else{
			$("#user").html('<a id = "fb-login" href = "http://www.facebook.com/dialog/oauth?client_id=153170114784919&redirect_uri=http://conjura.in/bullsndbears/&scope=email+ ,publish_stream"><img src = "http://conjura.in/bullsndbears/theme/images/fb.png"></a>');
			$('#slow').animate({opacity:"0"});
		}
});


      };
	

  (function(d){
         var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "https://connect.facebook.net/en_US/all.js";
         d.getElementsByTagName('head')[0].appendChild(js);
       }(document));

