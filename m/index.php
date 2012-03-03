<?php
session_start();
$_SESSION['mobile'] = true;
setcookie("mobile","1",time()+60*60*24*30,"/bullsndbears/");
	Header("Location: http://conjura.in/bullsndbears/");
