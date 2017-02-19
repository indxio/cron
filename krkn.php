<?php
date_default_timezone_set("UTC");
$timeStamp = date('Y-m-d H:i:s');
require 'creds.php';
$con = new mysqli($host,$user,$pass,$db);
$url = "https://api.kraken.com/0/public/Ticker?pair=xbtusd,xbteur,ltcusd,ltceur,ethxbt,etheur,ethusd";
$pairs = array(
	'XETHXXBT'=>'eth_btc',
	'XETHZEUR'=>'eth_eur',
	'XETHZUSD'=>'eth_usd',
	'XLTCZEUR'=>'ltc_eur',
	'XXBTXLTC'=>'btc_ltc',
	'XXBTXNMC'=>'btc_nmc',
	'XXBTZEUR'=>'btc_eur',
	'XXBTZUSD'=>'btc_usd',
	'XLTCZUSD'=>'ltc_usd'
);
$ch = curl_init();
$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
$response=curl_exec($ch);
curl_close($ch);
$data = json_decode($response,true);
if($data['error'] == null){
	foreach($data['result'] as $kPair=>$kData){
		$query = 'INSERT IGNORE INTO `krkn` VALUES("","'.$pairs[$kPair].'","'.$kData['h'][1].'","'.$kData['l'][1].'","'.$kData['v'][1].'","'.$kData['c'][0].'","'.$kData['b'][0].'","'.$kData['a'][0].'","'.$timeStamp.'")';
		$con->query($query);
		echo 'INSERT SUCCESS';
	}
}else{
	echo 'ERROR: '.$data['error'];
}
$con->close();
?>
