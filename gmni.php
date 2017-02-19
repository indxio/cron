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
$data = getData('https://api.gemini.com/v1/pubticker/btcusd');
$query = 'INSERT IGNORE INTO `gmni` VALUES("","btc_usd","'.$data['bid'].'","'.$data['ask'].'","'.$data['volume']['USD'].'","'.$data['last'].'","'.$timeStamp.'");';
$con->multi_query($query);
$con->close();
?>
