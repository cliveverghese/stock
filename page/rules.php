<?php
	$content .= '<ul id = "page"><li><a href = "index.php?o=page&p=market">General Information</a></li><li><a href = "index.php?o=page&p=how">How To Play</a></li><li><a href = "index.php?o=page&p=event">Event Structure</a></li><li><a href = "index.php?o=page&p=rules">Rules & Regulations</a></li></ul><div style = "clear:both"></div><br /><br />';
	if(!isset($_GET['p']))
	{
		$_GET['p'] = 'market';
	}
	if($_GET['p'] == 'rules')
	{
		$content .= "<h2>RULES & GUIDELINES</h2>
<ol>
<li>BULLS & BEARS is a Real time Stock Market Event. </li>
<li>BULLS & BEARS is not responsible for any Connection Errors/ Internet Issues</li>
<li>BULLS&BEARS is not responsible for any delays caused by participant. </li>
<li>BULLS&BEARS  reserves the right to eliminate the participants in case of any misconduct.</li>
<li>BULLS & BEARS will have the right to terminate an account If any sort of Hacking/Script injection techniques are detected. </li>
<li>A Valid College Identity Card is compulsory to claim the prize money. </li>
<li>The Decision of the Co-ordinators shall be final and binding to all.  
Any disputes related to BULLS & BEARS has to be settled with the Co-ordinators.</li> ";
	}
	else if($_GET['p'] == 'how')
	{
		$content .= "<h2>How to Play</h2>
<ol>
<li>Select the Stocks from 'List of Stocks' and add them to watch list. </li>
<li>Stocks in the Watch list will be shown on the Home screen. </li>
<li>Click on 'BUY' to buy a particular stock.</li>
<li>SYMBOL: Shows the Symbol or SCRIP name of a particular stock</li>
<li>QUANTITY: No of Stocks </li>

<li>Trade Type: Whether Intraday or Delivery ( Read General Information )</li>
<li>Select the Pricing: Whether Current Price or Limit Price ( Read General Information for More details )</li>
<li>Click Submit to Confirm. </li>
<li>All Transactions will be recorded and notifications will be available in the 'Notifications' tab. </li>
<li>After Market Orders or AMO can be used in case the Market is closed. The order will be executed on the next trading day.  All such orders will be recorded and shown in the 'Pending' tab</li>
<li>Portfolio will record all your transactions and balance amount. </li>
</ol>
";
	}
	else if($_GET['p'] == 'event')
	{
		$content .= "<h2>Event details</h2>

<ol>
<li>Weekly online event (Monday to Friday) for 4 consecutive weeks starting from Monday 30th Jan and ending on 24th Feb, 2012</li>
<li>BULLS & BEARS is a real time stock market platform linked to the National Stock Exchange (NSE) </li>
<li> Virtual money of Rs 1,00,000 will be credited to your portfolio and Net profit will be calculated every Friday to decide the weekly winner </li>
<li>Total Portfolio Value = ( Total Value of all Stocks in Portfolio + Balance amount in Portfolio) </li>
<li>The Total Portfolio Value on Friday will be the ONLY factor which will decide the Weekly winner. So maximize your profits. </li>
<li>Weekly Winners will be announced every Friday ( after 4 PM )</li>
<li>Overall winner will be announced on Feb 24th. </li>
<li>Total Portfolio Value after 4 Weeks of Trading will be the ONLY factor which will decide the Overall winner.</li>

</ol><br /><br />";
	}
	else if($_GET['p'] == 'market')
	{
		
		$content .= "<h2><strong>Market Timings</strong></h2>
Trading on the BULLS & BEARS Platform takes place on all days of the week. ( Mon-Fri )<br />
On Sundays and OFF Market hours please make use of the AMO Option ( Advanced Market Order)<br />
AMO records your trading and activates them upon the opening of Market. 
The market timings of BULLS & BEARS are in sync with NSE:<br /><br />

<strong>Normal Market Open : 09:10 hours<br />
Normal Market Close : 15:30 hours</strong><br />
<h2>Type of Trading</h2>
<strong>INTRADAY</strong> - Intraday Trading, also known as Day Trading, is the system where you BUY stocks and SELL them  before the end of that day's trading session ( Before 4PM). Thereby making a profit for yourself in that buy-sell or sell-buy exercise. All in one day. All you need to predict is whether a particular stock will rise or fall very sharply in the course of the day. 5 Times exposure in Portfolio Value for Intraday Trading. (Ex If your portfolio value is Rs 20,000 you can trade for Rs 1,00,000 ) 0.3% Brokerage will be deducted per transaction.<br />
<strong>DELIVERY</strong> : Buy the stocks and sell them as per the decision of the user. The Stocks which you have traded in delivery type will be credited to your portfolio.  All trading except INTRADAY are treated as DELIVERY type in 'BULLS & BEARS'. 0.8% Brokerage will be deducted per transaction. <br />

<h2>Types of Orders</h2>
<strong>Limit Price/Order</strong> :   An order that allows the price to be specified while entering the order into the system. The order will stay unexecuted till it reaches the Limit Price ( which the user has given )<br />

<strong>Current Price/Order</strong> : An order to buy or sell securities at the best price obtainable at the time of entering the order. Or the stock will be bought at the Current Market Price. <br />
<strong>AMO</strong> : After Market Order <br />
Checking this button while placing your order will result in an After Market Order. AMO can be placed only after market hours (i.e. when the markets are closed). When you place an AMO, the order is added to 'Pending' orders and sent to the stock exchange as soon as the markets open on the next working day.<br /><br /><br />"; 
	}

