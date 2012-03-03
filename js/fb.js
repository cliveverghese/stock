window.fbAsyncInit = function() {
        FB.init({
          appId      : '153170114784919',
          status     : true, 
          cookie     : true,
          xfbml      : true
        });

        FB.Event.subscribe('auth.login', function(response) {
		window.location.reload();
 		
        });
	FB.Event.subscribe('auth.logout',function(response) {
		$.ajax("http://conjura.in/bullsndbears/logout.php");
	});
	
	FB.getLoginStatus(function(response){
		if(response.status == "connected"){
			FB.api('/me',function(response){
				$("#user").html('<img height = "25px" src = "http://graph.facebook.com/' + response.id + '/picture" />' + response.name );
			});
		}else{
			$("#user").html('<a href = "https://www.facebook.com/dialog/oauth?client_id=153724004694703&redirect_uri=http://conjura.in/bullsndbears/&scope=email">Login</a>');
		}
});


      };
	

      (function(d){
         var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all.js";
         d.getElementsByTagName('head')[0].appendChild(js);
       }(document));
