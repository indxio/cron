<?php
require 'creds.php';
$con = new mysqli($host,$user,$pass,$db);
date_default_timezone_set("UTC");
$timeStamp = date('Y-m-d H:i:s');
$url = "https://cex.io/api/tickers/USD/EUR/BTC";
$ch = curl_init();
$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
$response=curl_exec($ch);
curl_close($ch);
$data = json_decode($response,true);
$pairs = array(
	'btc_eur'=>'BTC:EUR',
	'ltc_btc'=>'LTC:BTC',
	'ltc_usd'=>'LTC:EUR',
	'ltc_usd'=>'LTC:USD',
	'btc_usd'=>'BTC:USD'
);
foreach($data['data'] as $id=>$info){
	//echo $info['pair'].'<br/>';
	if(in_array($info['pair'],$pairs)){
		$ipair = array_search($info['pair'],$pairs);
		$query = 'INSERT IGNORE INTO `cexo` VALUES("","'.$ipair.'","'.$info['high'].'","'.$info['low'].'","'.$info['volume'].'","'.$info['last'].'","'.$info['bid'].'","'.$info['ask'].'","'.$timeStamp.'")';
		//echo $query.'<hr />';
		$con->query($query);
	}
}


$con->close();
?>
