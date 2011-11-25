<?php 
// http://nseindia.com/live_market/dynaContent/live_watch/stock_watch/niftyStockWatch.json
/*{"symbol":"GAIL","open":"373.00","high":"389.95","low":"372.00","ltP":"388.80",
"ptsC":"15.90","per":"4.26","trdVol":"21.61","trdVolM":"2.16","ntP":"83.17",
"mVal":"0.83","wkhi":"537.75","wklo":"367.00","xDt":"31-DEC-2999","cAct":"-","yPC":"-20.55","mPC":"-8.67"}
*/
//symbol open high low ltP ptsC per trdVol trdVolM ntP mVal wkhi wklo xDt cAct yPC mPC 



require_once("../core/bootstrap.php");

$jsn = file_get_contents_curl("http://nseindia.com/live_market/dynaContent/live_watch/stock_watch/niftyStockWatch.json");
	$jsn_obj = json_decode($jsn);
	foreach($jsn_obj->{'data'} as $data)
	{
		$sql = "UPDATE stockval SET value = '" . $data->{'ltP'} . "', chnge = '" . $data->{'ptsC'} . "', change_perc = '" . $data->{'per'} . "', day_low = '" . $data->{'low'} . "', day_high = '" . $data->{'high'} . "', week_low = '" . $data->{'wklo'} . "', week_high = '" . $data->{'wkhi'} . "' WHERE symbol = '" . $data->{'symbol'} . "'";
		mysql_query($sql);	

		//$sql = "UPDATE stockval SET `time_stamp` = '$update_time', `value` = '".str_replace(",", "",$data->{'ltP'})."', `change` = '".str_replace(",", "",$data->{'ptsC'})."', `change_perc` = '".str_replace(",", "",$data->{'per'})."', `day_low` = '".str_replace(",", "",$data->{'low'})."', `day_high` = '".str_replace(",", "",$data->{'high'})."', `week_low` = '".str_replace(",", "",$data->{'wklo'})."', `week_high` = '".str_replace(",", "",$data->{'wkhi'})."' WHERE `symbol` = '$data->{'symbol'}';";
	}






?>
