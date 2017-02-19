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
$btfxPairs = array('ltc_btc'=>'LTCBTC','btc_usd'=>'BTCUSD','ltc_usd'=>'LTCUSD');
$url = 'https://api.bitfinex.com/v1/pubticker/';
foreach ($btfxPairs as $pair=>$bPair){$temp = getData($url.$bPair);
	if(isset($query)){
	$query .= 'INSERT IGNORE INTO `btfx` VALUES("","'.$pair.'","'.$temp['high'].'","'.$temp['low'].'","'.$temp['volume'].'","'.$temp['last_price'].'","'.$temp['bid'].'","'.$temp['ask'].'","'.$timeStamp.'");';
	}else{
	$query = 'INSERT IGNORE INTO `btfx` VALUES("","'.$pair.'","'.$temp['high'].'","'.$temp['low'].'","'.$temp['volume'].'","'.$temp['last_price'].'","'.$temp['bid'].'","'.$temp['ask'].'","'.$timeStamp.'");';
	}
}
$con->multi_query($query);
$con->close();
?>
