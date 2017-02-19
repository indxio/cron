<?php
$loadT = microtime(true);
date_default_timezone_set("UTC");
$timeStamp = date('Y-m-d H:i:s');
require 'creds.php';
$con = new mysqli($host,$user,$pass,$db);
$url = 'https://www.bitstamp.net/api/ticker/';
$ch = curl_init();
$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
$response=curl_exec($ch);
curl_close($ch);
$temp = json_decode($response,true);
$query = 'INSERT IGNORE INTO `btsp` VALUES("","btc_usd","'.$temp['high'].'","'.$temp['low'].'","'.$temp['volume'].'","'.$temp['last'].'","'.$temp['bid'].'","'.$temp['ask'].'","'.$timeStamp.'");';
$con->query($query);
$con->close();
?>
