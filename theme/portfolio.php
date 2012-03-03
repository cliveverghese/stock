<head>
<meta name="title"

content="Bulls & Bears | Powered by Geojit BNP Paribas | Conjura'12" />

<meta name="description" content="Have you ever wanted to trade on a real stock market and earn with out any real investments? Try this amazing virtual Stock exchange game and win real money with virtual cash !Conjura '12 presents Bulls and Bears" />
<?php if(!$_SESSION['mobile']) :?>
<link type = "text/css" media = "screen" rel = "stylesheet" href = "theme/css/style.css" />
<script type = "text/javascript" src = "theme/js/jquery.js"></script>
<script type = "text/javascript" src = "theme/js/function.js"></script>
<script type = "text/javascript" src = "theme/js/ticker.js"></script>
<?php else :?>
<link type = "text/css" media = "screen" rel = "stylesheet" href = "theme/css/mobile.css" />
<?php endif ;?>
<?php if($pageRefresh) :?>
<script type = "text/javascript" src = "theme/js/refresh.js"></script>
<?php endif;?>



<script type = "text/javascript" src = "theme/js/fb.js"></script>
<title>Bulls & Bears | Powered by Geojit BNP Paribas | Conjura'12</title>
</head>
<body>
	<div id = "fb-root">
	</div>
	<div id ="user">
	</div>	
	<div id = "refreshing">
	</div>
	<div id = "nav">
		<div id = "logo">
			<img src = "http://conjura.in/bullsndbears/theme/images/bullsndbears.png" height = 30>
		</div>
		<div id = "mainNav">
		<ul>
			<li><a class = "Navigation" href = "index.php">Home</a></li>
			<li><a class = "Navigation" href = "index.php?o=portfolio">Portfolio</a></li>
			<li><a class = "Navigation" href = "index.php?o=listStocks">List of Stocks</a></li>
			<li><a class = "Navigation" href = "index.php?o=pending">Pending</a></li>
			<li><a class = "Navigation" href = "index.php?o=notifications">Transactions</a></li>
			<li><a class = "Navigation" href = "index.php?o=page">Information</a></li>
			<li><a class = "Navigation" href = "index.php?o=leader">LeaderBoard</a></li>
			<li><a class = "Navigation" href = "index.php?o=winners">Winners</a></li>
			
			<li><a class = "Navigation" href = "index.php?o=feedback">Contact Us</a></li>
			<li><a class = "Navigation" href = "logout.php">Log Out</a></li>
			
			
		<div id = "balanceUser">Balance : &#8377; <?php echo $balance; ?></div>
		</ul>
		
		</div>

	</div>
	<div id = "notification">
		
	</div>
	<div id = "buyArea">
		<a class = "closeAction" href = "#">close</a>
		<div id = "buyAreaContent"></div>
	</div>
	<div id = "tickerData">
	</div>
	<div id = "content">
		<div id = "portfolio_info">	
			<div id = "portfolio_image" class = "portfolio_box">
				<?php echo $image ;?>
			</div>
			<div id = "portfolio_name" class = "portfolio_box">
				<span class = "portfolio_box_title">Name</span>
				<span class = "portfolio_box_content"><?php echo $name; ?></span>
			</div>
			<div id = "portfolio_balance" class = "portfolio_box">
				<span class = "portfolio_box_title">Balance</span>
				<span class = "portfolio_box_content"><?php echo $balance ;?></span>
				
			</div>
			<div id = "portfolio_intraday" class = "portfolio_box">
				<span class = "portfolio_box_title">Intraday</span>
				<span class = "portfolio_box_content"><?php echo $intraday_balance ;?></span>
				
			</div>
			<div id = "portfolio_profit" class = "portfolio_box">
				<span class = "portfolio_box_title">Profit</span>
				<span class = "portfolio_box_content"><?php echo $total_profit; ?></span>
				
			</div>
		</div>
		<div style = "clear:both"></div>
		<div  id = "stock" class = "stocks">
			<?php echo $content; ?>
			&nbsp;<br/>&nbsp;<br/>
		&nbsp;<br />&nbsp;<br />
		</div>
		
	</div>
	
	
	<div id = "bottombar">
		<p id = "bottombarbulls"><span class = "bottombarpoweredby"></span><img src = "http://conjura.in/bullsndbears/theme/images/conjura.png" height = 60> <a href = "http://www.geojitbnpparibas.com/socialmedia/index.html"><img src = "http://conjura.in/bullsndbears/theme/images/geojit.gif" height = 60></a>
		</p>
	</div>


	

	
</body>
