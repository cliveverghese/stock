function stopTickerData(){
	document.getElementById("tickerMarquee").stop();
}
function loadTickerData(){
	var val = $("#tickerSel").val();
	tickerData(val);	
}
function tickerData(val){		
	
	$.get('http://conjura.in/bullsndbears/TickerFeed.php',
		function(html){
		
							
			
			var out='&nbsp;&nbsp;';
			var timestamp;
			var spl = html.split("|");
			if(spl.length == 0)
				return;
			timestamp=$.trim(spl[1]);
			var lt = timestamp;
			try{lt=timestamp.substring(3,6)+' '+timestamp.substring(0,2)+', '+ timestamp.substring(6);}catch(e){}
			var size=parseInt(spl[2]);
			
			if(val=='CM')
			{		
				for(var i=3;i<size;i++)
				{
					var data = spl[i].split(",");
					var css="";
					var img="";
					var name= data[0]+'&nbsp;&nbsp;';
					var ltp=data[1];
					var chng=data[2];
					if(chng>0){
						css="class=\"green\"";
						img="<img src=\"http://conjura.in/bullsndbears/theme/images/uparrow.gif\" alt=\"\" />";
					}
					else if(chng<0){
						css="class=\"red\"";
						img="<img src=\"http://conjura.in/bullsndbears/theme/images/downarrow.gif\" alt=\"\" />";
					}
					out+=name+'<span '+css+'>'+ltp+' ('+chng+'%) '+img+'</span>&nbsp;&nbsp;&nbsp;';						
				}
			}
			
			
			//$("#tickerData").html("<marquee id='tickerMarquee' onmouseover='this.stop();' onmouseout='this.start();'><nobr>"+out+"</nobr></marquee>");
			$("#tickerData").html('<marquee id="tickerMarquee" onmouseover="this.stop();" onmouseout="this.start();" truespeed="" scrollamount="2" scrolldelay="2" direction="left" loop="repeat"><nobr>Mobile Site available at conjura.in/bullsndbears/m/'+out+'</nobr></marquee>');

		}
	);
}

$(document).ready(function(){
	tickerData('CM');
});
