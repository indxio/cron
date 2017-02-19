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
$btrxPairs = array('blk_btc'=>'btc-blk','cann_btc'=>'btc-cann','ccn_btc'=>'btc-ccn','doge_btc'=>'btc-doge','drk_btc'=>'btc-dash','ltc_btc'=>'btc-ltc','myr_btc'=>'btc-myr','nxt_btc'=>'btc-nxt','pot_btc'=>'btc-pot','utc_btc'=>'btc-utc','via_btc'=>'btc-via');
$url = 'https://bittrex.com/api/v1.1/public/getmarketsummary?market=';
foreach ($btrxPairs as $pair=>$bPair){$temp = getData($url.$bPair);
if(isset($query)){
	$query .= 'INSERT IGNORE INTO `btrx` VALUES("","'.$pair.'","'.$temp['result'][0]['High'].'","'.$temp['result'][0]['Low'].'","'.$temp['result'][0]['BaseVolume'].'","'.$temp['result'][0]['Last'].'","'.$temp['result'][0]['Bid'].'","'.$temp['result'][0]['Ask'].'","'.$timeStamp.'");';
}else{
	$query = 'INSERT IGNORE INTO `btrx` VALUES("","'.$pair.'","'.$temp['result'][0]['High'].'","'.$temp['result'][0]['Low'].'","'.$temp['result'][0]['BaseVolume'].'","'.$temp['result'][0]['Last'].'","'.$temp['result'][0]['Bid'].'","'.$temp['result'][0]['Ask'].'","'.$timeStamp.'");';
}
}
$con->multi_query($query);
$con->close();
?>
