<?php
require 'creds.php';
$con = new mysqli($host,$user,$pass,$db);
date_default_timezone_set("UTC");
$timeStamp = date('Y-m-d H:i:s');
$url = "https://poloniex.com/public?command=returnTicker";
$pairs = array(
	'eth_btc'=>'BTC_ETH',
	'ltc_btc'=>'BTC_LTC',
	'eth_usd'=>'USDT_ETH',
	'ltc_usd'=>'USDT_LTC',
	'btc_usd'=>'USDT_BTC',
	'dash_usd'=>'USDT_DASH'
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
	foreach($data as $kPair=>$kData){
		if(in_array($kPair,$pairs)){
			echo $kPair.'<br />';
			echo array_search($kPair,$pairs).'<br />';
			var_dump($kData);
			echo '<hr />';
			$ipair = array_search($kPair,$pairs);
			$query = 'INSERT IGNORE INTO `polx` VALUES("","'.$ipair.'","'.$kData['high24hr'].'","'.$kData['low24hr'].'","'.$kData['quoteVolume'].'","'.$kData['last'].'","'.$kData['highestBid'].'","'.$kData['lowestAsk'].'","'.$timeStamp.'")';
			echo $query.'<hr />';
			$con->query($query);

		}
	}
$con->close();
?>
