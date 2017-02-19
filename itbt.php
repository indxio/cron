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
$itbtPairs = array('btc_usd' => 'XBTUSD', 'btc_eur' => 'XBTEUR');
$url = 'https://api.itbit.com/v1/markets/';$urlEnd = '/ticker';
foreach ($itbtPairs as $pair =>$iPair){
	$tmp = getData($url.$iPair.$urlEnd);
	$q = 'INSERT IGNORE INTO `itbt` VALUES("","'.$pair.'","'.$tmp['high24h'].'","'.$tmp['low24h'].'","'.$tmp['volume24h'].'","'.$tmp['lastPrice'].'","'.$tmp['bid'].'","'.$tmp['ask'].'","'.$timeStamp.'");';
	$con->query($q);
}

$con->close();
?>
