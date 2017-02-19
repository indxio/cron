<?php
date_default_timezone_set("UTC");
$timeStamp = date('Y-m-d H:i:s');
require 'creds.php';
$con = new mysqli($host,$user,$pass,$db);
function getData($url){
	$ch = curl_init();
	$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$url);
	$response=curl_exec($ch);
	curl_close($ch);
	return json_decode($response,true);
}
$url = 'https://www.okcoin.com/api/ticker.do?ok=1';$temp = getData($url);
$query = 'INSERT IGNORE INTO `okcn` VALUES("","btc_usd","'.$temp['ticker']['high'].'","'.$temp['ticker']['low'].'","'.$temp['ticker']['vol'].'","'.$temp['ticker']['last'].'","'.$temp['ticker']['buy'].'","'.$temp['ticker']['sell'].'","'.$timeStamp.'");';
$con->multi_query($query);
$con->close();
?>
